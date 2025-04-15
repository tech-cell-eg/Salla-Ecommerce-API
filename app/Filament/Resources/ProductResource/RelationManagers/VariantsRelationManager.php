<?php

namespace App\Filament\Resources\ProductResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class VariantsRelationManager extends RelationManager
{
    protected static string $relationship = 'variants';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('price')
                    ->numeric()
                    ->prefix('$')
                    ->required(),
                
                Forms\Components\TextInput::make('stock')
                    ->numeric()
                    ->minValue(0)
                    ->required(),
                
                Forms\Components\Select::make('attributeValues')
                    ->relationship('attributeValues', 'value')
                    ->multiple()
                    ->preload()
                    ->required()
                    ->createOptionForm([
                        Forms\Components\Select::make('attribute_id')
                            ->relationship('attribute', 'name')
                            ->required(),
                        Forms\Components\TextInput::make('value')
                            ->required(),
                    ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('price')
                    ->money('usd')
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('stock')
                    ->numeric()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('attributeValues.value')
                    ->badge()
                    ->listWithLineBreaks(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}