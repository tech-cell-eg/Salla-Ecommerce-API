<?php

namespace App\Filament\Resources\OrderResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class OrderItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'items';

    // No form needed since create/edit is not required
    public function form(Form $form): Form
    {
        return $form->schema([]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('product_name')
            ->columns([
                Tables\Columns\TextColumn::make('product_name')
                    ->label('Product Name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('product.price')
                    ->label('Product')
                    ->default('N/A')
                    ->sortable(),
                Tables\Columns\TextColumn::make('product_quantity')
                    ->label('Quantity')
                    ->sortable(),
                Tables\Columns\TextColumn::make('product_price')
                    ->label('Price')
                    ->money('usd')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([]) // No create action
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label('View')
                    ->modalHeading('Order Item Details')
                    ->modalButton('Close')
                    ->modalWidth('lg')
                    ->form([
                        Forms\Components\TextInput::make('product_name')
                            ->label('Product Name')
                            ->disabled()
                            ->default(fn($record) => $record->product_name),
                        Forms\Components\TextInput::make('product_id')
                            ->label('Product')
                            ->disabled()
                            ->default(fn($record) => $record->product ? $record->product->name : 'N/A'),
                        Forms\Components\Textarea::make('product_desc')
                            ->label('Description')
                            ->disabled()
                            ->default(fn($record) => $record->product_desc),
                        Forms\Components\TextInput::make('product_quantity')
                            ->label('Quantity')
                            ->disabled()
                            ->default(fn($record) => $record->product_quantity),
                        Forms\Components\TextInput::make('product_price')
                            ->label('Price')
                            ->prefix('$')
                            ->disabled()
                            ->default(fn($record) => $record->product_price),
                        Forms\Components\KeyValue::make('data')
                            ->label('Additional Data')
                            ->disabled()
                            ->default(fn($record) => $record->data),
                    ]),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}