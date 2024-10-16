<?php

namespace App\Filament\Resources\HoldingResource\Pages;

use App\Filament\Resources\HoldingResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditHolding extends EditRecord
{
    protected static string $resource = HoldingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
