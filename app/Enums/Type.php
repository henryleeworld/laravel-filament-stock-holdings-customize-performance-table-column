<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum Type: string implements HasLabel
{
    case EQUITY  = 'Equity';
    case INDEX   = 'Index';
    case ODDLOT  = 'Odd-lot';
    case WARRANT = 'Warrant';

    public function getLabel(): string
    {
        return match ($this) {
            self::EQUITY => __('Equity'),
            self::INDEX => __('Index'),
            self::ODDLOT => __('Odd-lot'),
            self::WARRANT => __('Warrant'),
        };
    }
}
