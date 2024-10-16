<?php

namespace App\Filament\Resources;

use App\Enums\MarketLocale;
use App\Enums\Type;
use App\Filament\Resources\HoldingResource\Pages;
use App\Filament\Tables\Columns\Performance;
use App\Models\Holding;
use Awcodes\FilamentBadgeableColumn\Components\Badge;
use Awcodes\FilamentBadgeableColumn\Components\BadgeableColumn;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Table;

class HoldingResource extends Resource
{
    protected static ?string $model = Holding::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label(__('Name'))
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('symbol')
                    ->label(__('Symbol'))
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('quantity')
                    ->label(__('Quantity'))
                    ->required()
                    ->numeric()
                    ->rules(['integer', 'min:0']),
                Forms\Components\TextInput::make('market_price_current_month')
                    ->label(__('Market price current month'))
                    ->required()
                    ->numeric()
                    ->rules(['regex:/^\d*\.?\d{0,2}$/']),
                Forms\Components\TextInput::make('market_price_last_month')
                    ->label(__('Market price last month'))
                    ->required()
                    ->numeric()
                    ->rules(['regex:/^\d*\.?\d{0,2}$/']),
                Forms\Components\Select::make('market_locale')
                    ->label(__('Market locale'))
                    ->placeholder(__('Market locale'))
                    ->options(MarketLocale::class)
                    ->required()
                    ->native(false),
                Forms\Components\Select::make('type')
                    ->label(__('Type'))
                    ->placeholder(__('Type'))
                    ->options(Type::class)
                    ->required()
                    ->native(false),
            ]);
    }

    public static function getModelLabel(): string
    {
        return __('holding');
    }

    public static function getNavigationLabel(): string
    {
        return __('Holdings');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListHoldings::route('/'),
            'create' => Pages\CreateHolding::route('/create'),
            'edit' => Pages\EditHolding::route('/{record}/edit'),
        ];
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                BadgeableColumn::make('name')
                    ->label(__('Name'))
                    ->separator('')
                    ->prefixBadges([
                        Badge::make('symbol')
                            ->color('black')
                            ->label(fn(Holding $record) => $record->symbol),
                    ])
                    ->sortable(),
                Tables\Columns\TextColumn::make('quantity')
                    ->label(__('Quantity'))
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('market_value')
                    ->label(__('Market value'))
                    ->weight(FontWeight::SemiBold)
                    ->money(fn(Holding $record) => $record->market_locale->value, 100),
                Tables\Columns\TextColumn::make('market_price_current_month')
                    ->label(__('Market price'))
                    ->money(fn(Holding $record) => $record->market_locale->value, 100),
                Performance::make('performance')
                    ->label(__('Performance')),
                Tables\Columns\TextColumn::make('type')
                    ->label(__('Type'))
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->link()
                    ->hiddenLabel()
                    ->icon('heroicon-o-chevron-right'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
