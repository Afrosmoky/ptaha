<?php

namespace App\Filament\Resources\Projects\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Components\View;

class ProjectForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // ===== DANE PROJEKTU =====
                TextInput::make('title')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn ($state, $set) =>
                    $set('slug', str($state)->slug())
                    ),

                TextInput::make('slug')
                    ->required()
                    ->disabled()
                    ->dehydrated(fn () => true)
                    ->unique(ignoreRecord: true),

                Select::make('type')
                    ->options([
                        'building' => 'Budynki',
                        'interior' => 'Wnętrza',
                    ])
                    ->required(),

                Textarea::make('description')
                    ->columnSpanFull(),

                Toggle::make('is_published')
                    ->label('Opublikowany')
                    ->required(),

                // ===== MEDIA =====
                Section::make('Media')
                    ->schema([
                        // ===== HERO PREVIEW =====
                        View::make('filament.forms.components.hero-preview')
                            ->visible(fn ($record) => $record?->hasMedia('hero'))
                            ->viewData([
                                'record' => fn ($record) => $record,
                            ]),

                        // ===== HERO UPLOAD =====
                        FileUpload::make('hero_upload')
                            ->label('Zdjęcie główne')
                            ->image()
                            ->disk('public')
                            ->directory('tmp/hero')
                            ->preserveFilenames()
                            ->maxFiles(1),

                        // ===== GALERIA PREVIEW =====
                        View::make('filament.forms.components.gallery-preview')
                            ->visible(fn ($record) => $record?->hasMedia('gallery'))
                            ->viewData([
                                'record' => fn ($record) => $record,
                            ]),

                        // ===== GALERIA UPLOAD =====
                        FileUpload::make('gallery_upload')
                            ->label('Galeria projektu')
                            ->image()
                            ->multiple()
                            ->disk('public')
                            ->directory('tmp/gallery')
                            ->preserveFilenames(),
                    ])
                    ->collapsed(), // opcjonalnie – ładny UX
            ]);
    }
}
