<?php

namespace App\Filament\Resources;

use App\Models\Diaper;
use Filament\{Forms, Tables};
use Filament\Resources\{Form, Table, Resource};
use App\Filament\Resources\DiaperResource\Pages;

class DiaperResource extends Resource
{
    protected static ?string $model = Diaper::class;

    protected static ?string $navigationIcon = 'heroicon-o-gift';

    protected static ?string $modelLabel = 'Fralda';
    protected static ?string $pluralModelLabel = 'Fraldas';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageDiapers::route('/'),
        ];
    }
}
