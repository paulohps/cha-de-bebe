<?php

namespace App\Filament\Resources\NumberResource\Widgets;

use App\Models\Number;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class CountersOverview extends BaseWidget
{
    protected function getCards(): array
    {
        return [
            Card::make('Total', Number::count()),
            Card::make('Vendidos', Number::whereNotNull('name')->count()),
            Card::make('Não vendidos', Number::whereNull('name')->count()),
            Card::make('Aprovados', Number::whereNotNull('approved_at')->count()),
            Card::make('Vendidos não aprovados', Number::whereNotNull('name')->whereNull('approved_at')->count()),
            Card::make('Não aprovados', Number::whereNull('approved_at')->count())
        ];
    }
}
