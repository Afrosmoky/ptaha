<?php

namespace App\Filament\Resources\Pages\RelationManagers;

use App\Filament\Resources\Pages\PageResource;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Group;
use Filament\Tables\Table;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns;
use Filament\Schemas\Schema;
use Filament\Actions;
use Illuminate\Support\Facades\Storage;


class PageSectionsRelationManager extends RelationManager
{
    protected static string $relationship = 'sections';

    protected static ?string $relatedResource = PageResource::class;

    protected static ?string $title = 'Sekcje strony';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Select::make('type')
                    ->label('Typ sekcji')
                    ->options([
                        'text' => 'Tekst',
                        'cta' => 'CTA',
                        'split' => 'Tekst + Galeria',
                        'text_image' => 'Tekst + Zdjęcie',
                    ])
                    ->required()
                    ->reactive(),

                Group::make()
                    ->live()
                    ->schema(fn ($get) => match ($get('type')) {
                        'text' => [
                            RichEditor::make('data.content')
                                ->label('Treść')
                                ->required()
                                ->dehydrated(),
                        ],

                        'cta' => [
                            TextInput::make('data.headline')
                                ->label('Nagłówek')
                                ->required(),

                            Textarea::make('data.text')
                                ->label('Opis'),

                            TextInput::make('data.button_text')
                                ->label('Tekst przycisku')
                                ->required(),

                            TextInput::make('data.button_url')
                                ->label('Link przycisku')
                                ->required(),
                        ],

                        'split' => [
                            RichEditor::make('data.text')
                                ->label('Treść')
                                ->required(),

                            Select::make('data.layout')
                                ->label('Układ')
                                ->options([
                                    'text_left' => 'Tekst po lewej',
                                    'text_right' => 'Tekst po prawej',
                                ])
                                ->required(),
                        ],
                        'text_image' => [
                            RichEditor::make('data.content')
                                ->label('Treść')
                                ->required(),

                            FileUpload::make('image_upload')
                                ->label('Zdjęcie')
                                ->image()
                                ->disk('public')
                                ->directory('tmp/sections/image')
                                ->required(),

                            Textarea::make('data.caption')
                                ->label('Podpis pod zdjęciem')
                                ->rows(2),

                            Select::make('data.image_position')
                                ->label('Pozycja zdjęcia')
                                ->options([
                                    'left' => 'Po lewej',
                                    'right' => 'Po prawej',
                                ])
                                ->default('right')
                                ->required(),
                        ],
                        default => [],
                    }),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->reorderable('sort_order')
            ->columns([
                Columns\TextColumn::make('type')
                    ->label('Typ'),

                Columns\TextColumn::make('created_at')
                    ->label('Dodano')
                    ->dateTime(),
            ])

            ->headerActions([
                Actions\CreateAction::make()
                    ->label('Dodaj sekcję')
                    ->after(function ($record, array $data) {
                        // ⬇️ ZAPIS ZDJĘCIA PO CREATE
                        if (
                            ($data['type'] ?? null) === 'text_image'
                            && !empty($data['image_upload'])
                        ) {
                            foreach ((array) $data['image_upload'] as $path) {
                                $record
                                    ->addMedia(Storage::disk('public')->path($path))
                                    ->toMediaCollection('image');

                                Storage::disk('public')->delete($path);
                            }
                        }
                    }),
            ])

            ->recordActions([
                Actions\EditAction::make()
                    ->mutateDataUsing(function (array $data, $record) {
                        // ⬇️ ZAPIS ZDJĘCIA PRZY EDYCJI
                        if (
                            ($data['type'] ?? null) === 'text_image'
                            && !empty($data['image_upload'])
                        ) {
                            foreach ((array) $data['image_upload'] as $path) {
                                $record
                                    ->clearMediaCollection('image')
                                    ->addMedia(Storage::disk('public')->path($path))
                                    ->toMediaCollection('image');

                                Storage::disk('public')->delete($path);
                            }

                            // ⚠️ NIE zapisujemy image_upload do bazy
                            unset($data['image_upload']);
                        }

                        return $data;
                    }),


                Actions\DeleteAction::make(),
            ])

            ->defaultSort('sort_order');
    }
}
