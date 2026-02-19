<?php

namespace App\Filament\Resources\ExternalLinks\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

class ExternalLinkForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Grid::make(2)->schema([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),

                TextInput::make('url')
                    ->required()
                    ->url()
                    ->maxLength(255),
            ]),

            Textarea::make('description')
                ->columnSpanFull(),

            Grid::make(3)->schema([
                TextInput::make('cta')
                    ->label('CTA text'),

                TextInput::make('sort_order')
                    ->numeric()
                    ->default(0),

                Toggle::make('is_active')
                    ->label('Aktywny')
                    ->default(true),
            ]),
        ]);
    }
}
