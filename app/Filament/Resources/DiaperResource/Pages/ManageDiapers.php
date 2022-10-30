<?php

namespace App\Filament\Resources\DiaperResource\Pages;

use Filament\Pages\Actions;
use App\Filament\Resources\DiaperResource;
use Filament\Resources\Pages\ManageRecords;

class ManageDiapers extends ManageRecords
{
    protected static string $resource = DiaperResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
