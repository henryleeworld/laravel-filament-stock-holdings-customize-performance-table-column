<?php

namespace App\Models;

use App\Enums\MarketLocale;
use App\Enums\Type;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Holding extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'symbol',
        'name',
        'quantity',
        'market_price_current_month',
        'market_price_last_month',
        'market_locale',
        'type',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'market_locale' => MarketLocale::class,
            'type' => Type::class,
        ];
    }

    protected function marketPriceCurrentMonth(): Attribute
    {
        return Attribute::make(
            get: static fn($value) => $value / 100,
            set: static fn($value) => $value * 100,
        );
    }

    protected function marketPriceLastMonth(): Attribute
    {
        return Attribute::make(
            get: static fn($value) => $value / 100,
            set: static fn($value) => $value * 100,
        );
    }

    protected function marketValue(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->market_price_current_month * $this->quantity,
        );
	}
}
