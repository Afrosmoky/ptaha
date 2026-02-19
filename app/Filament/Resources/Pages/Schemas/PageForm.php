<?php

namespace App\Filament\Resources\Pages\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\View;

class PageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('title')
                ->required()
                ->maxLength(255)
                ->live(onBlur: true)
                ->afterStateUpdated(fn ($state, callable $set) =>
                $set('slug', str($state)->slug())
                ),

            TextInput::make('slug')
                ->required()
                ->maxLength(255)
                ->unique(ignoreRecord: true),

            RichEditor::make('content')
                ->columnSpanFull(),

            TextInput::make('seo_title')
                ->maxLength(255),

            TextInput::make('seo_description')
                ->maxLength(255),

            DateTimePicker::make('published_at')->default(now()),
            View::make('filament.forms.components.page-gallery-preview')
                ->visible(fn ($record) => $record?->hasMedia('gallery')),
            Section::make('Galeria strony')
                ->description('Zdjęcia używane w sekcjach typu split')
                ->schema([
                    FileUpload::make('gallery_upload')
                        ->label('Zdjęcia galerii')
                        ->image()
                        ->multiple()
                        ->disk('public')
                        ->directory('tmp/page-gallery')
                        ->preserveFilenames(),
                ])
                ->collapsed(),
        ]);
    }
}
