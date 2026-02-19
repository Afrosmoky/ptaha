<?php

namespace App\Filament\Resources\MenuItems\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class MenuItemForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('page_id')
                    ->label('Strona')
                    ->relationship('page', 'title')
                    ->nullable()
                    ->reactive(),

                Select::make('parent_id')
                    ->label('Element nadrzędny')
                    ->relationship('parent', 'label')
                    ->searchable()
                    ->nullable(),

                TextInput::make('url')
                    ->label('Link zewnętrzny')
                    ->visible(fn ($get) => empty($get('page_id'))),

                TextInput::make('label')
                    ->label('Tekst')
                    ->required(),

                Toggle::make('is_active')
                    ->label('Aktywny'),
            ]);
    }
}
