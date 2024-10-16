@php
    use Illuminate\Support\Number;
    $record = $getRecord();
@endphp

<div class="text-sm" style="color:{{ $getPerformanceColor() }}">
    <div class="flex items-center">
        @if ($getProfitBool())
            <x-heroicon-o-arrow-small-up class="w-3 h-3" />
        @else
            <x-heroicon-o-arrow-small-down class="w-3 h-3" />
        @endif
        {{ Number::percentage($getPercentage(), 2) }}
    </div>
    <div>{{ Number::currency($getDifference() / 100, $record->market_locale->value) }}</div>
</div>
