<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationLabel = 'Orders';
    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Order Details')
                    ->schema([
                        Forms\Components\TextInput::make('user_name')
                            ->label('Customer Name')
                            ->disabled(),
                        Forms\Components\TextInput::make('user_email')
                            ->label('Email')
                            ->disabled(),
                        Forms\Components\TextInput::make('user_phone')
                            ->label('Phone')
                            ->disabled(),
                        Forms\Components\TextInput::make('total_price')
                            ->label('Total Price')
                            ->prefix('$')
                            ->disabled(),
                        Forms\Components\Textarea::make('note')
                            ->label('Note')
                            ->disabled(),
                        Forms\Components\TextInput::make('status')
                            ->label('Status')
                            ->disabled()
                            ->formatStateUsing(fn($state) => ucfirst($state)),
                        Forms\Components\TextInput::make('country')
                            ->label('Country')
                            ->disabled(),
                        Forms\Components\TextInput::make('governorate')
                            ->label('Governorate')
                            ->disabled(),
                        Forms\Components\TextInput::make('city')
                            ->label('City')
                            ->disabled(),
                        Forms\Components\TextInput::make('street')
                            ->label('Street')
                            ->disabled(),
                        Forms\Components\TextInput::make('created_at')
                            ->label('Created At')
                            ->disabled(),
                    ])
                    ->columns(2),
                Forms\Components\Section::make('Order Items')
                    ->schema([
                        Forms\Components\Repeater::make('items')
                            ->relationship('items')
                            ->schema([
                                Forms\Components\TextInput::make('product_name')
                                    ->label('Product Name')
                                    ->disabled(),
                                Forms\Components\Textarea::make('product_desc')
                                    ->label('Description')
                                    ->disabled(),
                                Forms\Components\TextInput::make('product_quantity')
                                    ->label('Quantity')
                                    ->disabled(),
                                Forms\Components\TextInput::make('product_price')
                                    ->label('Price')
                                    ->prefix('$')
                                    ->disabled(),
                                Forms\Components\KeyValue::make('data')
                                    ->label('Additional Data')
                                    ->disabled(),
                            ])
                            ->addable(false)
                            ->deletable(false)
                            ->reorderable(false)
                            ->label('Order Items'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('Order ID')
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('User')
                    ->default('N/A')
                    ->sortable(),
                Tables\Columns\TextColumn::make('user_name')
                    ->label('Customer Name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('user_email')
                    ->label('Email')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('user_phone')
                    ->label('Phone')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('total_price')
                    ->money('usd')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->formatStateUsing(fn($state) => ucfirst($state))
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                        'delivered' => 'Delivered',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('View Details'), // Renamed to indicate it's for viewing
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ])
            ->defaultSort('created_at', 'desc')
            ->headerActions([])
            ->checkIfRecordIsSelectableUsing(fn() => false);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'edit' => Pages\EditOrder::route('/{record}/edit'), // Add edit route
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }

    // Prevent actual editing by overriding the update method
    public function update(array $data, $record): bool
    {
        return false; // Disables saving changes
    }
}
