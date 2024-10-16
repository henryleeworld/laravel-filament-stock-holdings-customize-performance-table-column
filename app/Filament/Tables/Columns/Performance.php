<?php

namespace App\Filament\Tables\Columns;

use Filament\Tables\Columns\Column;

class Performance extends Column
{
    protected string $view = 'filament.tables.columns.performance';

    public function getDifference(): int
    {
        $record = $this->getRecord();
        return abs($record->market_price_current_month - $record->market_price_last_month);
    }

    public function getPercentage(): int
    {
        $record = $this->getRecord();
        return (($record->market_price_current_month - $record->market_price_last_month) / $record->market_price_current_month) * 100;
    }

    public function getProfitBool(): bool
    {
        $record = $this->getRecord();
        return $record->market_price_current_month > $record->market_price_last_month;
    }

    public function getPerformanceColor(): string
    {
        return match($this->getProfitBool()) {
            true => '#16a34a',
            false => '#dc2626',
            default => '#4b5563',
        };
    }
}
