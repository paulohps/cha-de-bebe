<?php

namespace App\Filament\Resources\NumberResource\Pages;

use App\Models\Number;
use Filament\Pages\Actions;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\NumberResource;

class ListNumbers extends ListRecords
{
    protected static string $resource = NumberResource::class;

    protected function getActions(): array
    {
        return [
            Actions\Action::make('multiple-create')
                ->label('Criar vários números')
                ->action(fn(array $data) => collect(array_fill(Number::max('value') + 1, $data['amount'], null))
                    ->map(static fn($value, $key) => Number::query()->create(['value' => $key]))
                )->form([
                    TextInput::make('amount')
                        ->integer()
                        ->minValue(1)
                        ->maxValue(100)
                        ->required()
                        ->label('Quantidade')
                ])->modalButton('Criar'),
            Actions\CreateAction::make()
        ];
    }
}
