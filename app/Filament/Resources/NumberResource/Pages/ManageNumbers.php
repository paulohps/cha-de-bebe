<?php

namespace App\Filament\Resources\NumberResource\Pages;

use App\Models\Diaper;
use App\Models\Number;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Pages\Actions;
use Filament\Forms\Components\TextInput;
use App\Filament\Resources\NumberResource;
use Filament\Resources\Pages\ManageRecords;

class ManageNumbers extends ManageRecords
{
    protected static string $resource = NumberResource::class;

    protected function getActions(): array
    {
        $diapers = Diaper::all()->pluck('name', 'id');
        $lastNumber = Number::max('value') ?? 'N/A';

        return [
            Actions\Action::make('multiple-create')
                ->label('Criar vários números')
                ->modalSubheading("Último número criado: $lastNumber")
                ->action(fn(array $data) => collect($data['numbers'])
                    ->map(static fn(array $numbers) => collect(array_fill($numbers['start'], $numbers['amount'], null))
                        ->map(static fn($value, $key) => Number::query()
                            ->create(['value' => $key, 'diaper_id' => $numbers['diaper_id']])
                        )
                    )
                )->form([
                    Repeater::make('numbers')
                        ->label('Números')
                        ->createItemButtonLabel('Adicionar números')
                        ->columns(3)
                        ->schema([
                            TextInput::make('start')
                                ->integer()
                                ->required()
                                ->label('Início'),
                            TextInput::make('amount')
                                ->integer()
                                ->required()
                                ->label('Quantidade'),
                            Select::make('diaper_id')
                                ->options($diapers)
                                ->required()
                                ->label('Fraldas')
                        ])
                ])->modalButton('Criar'),
            Actions\CreateAction::make()
        ];
    }

    public function getHeaderWidgets(): array
    {
        return [
            NumberResource\Widgets\CountersOverview::class
        ];
    }
}
