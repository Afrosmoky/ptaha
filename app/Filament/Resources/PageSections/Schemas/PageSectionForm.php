<?php

namespace App\Filament\Resources\PageSections\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class PageSectionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('page_id')
                    ->required()
                    ->numeric(),
                TextInput::make('type')
                    ->required(),
                Textarea::make('data')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('sort_order')
                    ->required()
                    ->numeric()
                    ->default(0),
            ]);
    }
}
