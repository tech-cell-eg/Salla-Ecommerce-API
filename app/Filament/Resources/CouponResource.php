<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CouponResource\Pages;
use App\Models\Coupon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CouponResource extends Resource
{
    protected static ?string $model = Coupon::class;

    protected static ?string $navigationLabel = 'Coupons';
    protected static ?string $navigationIcon = 'heroicon-o-ticket';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Coupon Details')
                    ->schema([
                        Forms\Components\TextInput::make('code')
                            ->required()
                            ->unique(Coupon::class, 'code', ignoreRecord: true)
                            ->maxLength(255),
                        Forms\Components\Select::make('type')
                            ->label('Type')
                            ->options([
                                'product' => 'Product',
                                'category' => 'Category',
                                'all' => 'All',
                            ])
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set) {
                                $set('product_id', null);
                                $set('category_id', null);
                            }),
                        Forms\Components\Select::make('product_id')
                            ->label('Product')
                            ->relationship('product', 'name')
                            ->searchable()
                            ->visible(fn($get) => $get('type') === 'product')
                            ->required(fn($get) => $get('type') === 'product'),
                        Forms\Components\Select::make('category_id')
                            ->label('Category')
                            ->relationship('category', 'name')
                            ->searchable()
                            ->visible(fn($get) => $get('type') === 'category')
                            ->required(fn($get) => $get('type') === 'category'),
                        Forms\Components\TextInput::make('discount_precentage')
                            ->label('Discount Percentage')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(100)
                            ->suffix('%')
                            ->nullable(),
                        Forms\Components\DatePicker::make('start_date')
                            ->required()
                            ->minDate(now()->startOfDay()) // Prevent dates before today
                            ->reactive(),
                        Forms\Components\DatePicker::make('end_date')
                            ->required()
                            ->minDate(fn($get) => $get('start_date') ?? now()->startOfDay()) // Must be equal to or after start_date
                            ->afterOrEqual('start_date'),
                        Forms\Components\TextInput::make('limit_number')
                            ->label('Limit Number')
                            ->numeric()
                            ->minValue(0)
                            ->nullable(),
                        Forms\Components\TextInput::make('time_used')
                            ->label('Times Used')
                            ->numeric()
                            ->minValue(0)
                            ->default(0)
                            ->disabled(),
                        Forms\Components\Toggle::make('is_active')
                            ->label('Active')
                            ->default(true),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('type')
                    ->formatStateUsing(fn($state) => ucfirst($state))
                    ->sortable(),
                Tables\Columns\TextColumn::make('product.name')
                    ->label('Product')
                    ->default('N/A')
                    ->sortable(),
                Tables\Columns\TextColumn::make('category.name')
                    ->label('Category')
                    ->default('N/A')
                    ->sortable(),
                Tables\Columns\TextColumn::make('discount_precentage')
                    ->label('Discount %')
                    ->suffix('%')
                    ->sortable(),
                Tables\Columns\TextColumn::make('start_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('end_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('limit_number')
                    ->label('Limit')
                    ->default('Unlimited')
                    ->sortable(),
                Tables\Columns\TextColumn::make('time_used')
                    ->label('Times Used')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label('View')
                    ->modalHeading('Coupon Details')
                    ->modalButton('Close')
                    ->modalWidth('lg')
                    ->recordTitle(fn($record) => $record->code)
                    ->form([
                        Forms\Components\TextInput::make('code')
                            ->disabled()
                            ->default(fn($record) => $record->code),
                        Forms\Components\TextInput::make('type')
                            ->disabled()
                            ->default(fn($record) => ucfirst($record->type)),
                        Forms\Components\TextInput::make('product_id')
                            ->label('Product')
                            ->disabled()
                            ->default(fn($record) => $record->product ? $record->product->name : 'N/A'),
                        Forms\Components\TextInput::make('category_id')
                            ->label('Category')
                            ->disabled()
                            ->default(fn($record) => $record->category ? $record->category->name : 'N/A'),
                        Forms\Components\TextInput::make('discount_precentage')
                            ->label('Discount Percentage')
                            ->suffix('%')
                            ->disabled()
                            ->default(fn($record) => $record->discount_precentage),
                        Forms\Components\DatePicker::make('start_date')
                            ->disabled()
                            ->default(fn($record) => $record->start_date),
                        Forms\Components\DatePicker::make('end_date')
                            ->disabled()
                            ->default(fn($record) => $record->end_date),
                        Forms\Components\TextInput::make('limit_number')
                            ->label('Limit Number')
                            ->disabled()
                            ->default(fn($record) => $record->limit_number ?? 'Unlimited'),
                        Forms\Components\TextInput::make('time_used')
                            ->label('Times Used')
                            ->disabled()
                            ->default(fn($record) => $record->time_used),
                        Forms\Components\Toggle::make('is_active')
                            ->label('Active')
                            ->disabled()
                            ->default(fn($record) => $record->is_active),
                    ]),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCoupons::route('/'),
            'create' => Pages\CreateCoupon::route('/create'),
            'edit' => Pages\EditCoupon::route('/{record}/edit'),
        ];
    }
}
