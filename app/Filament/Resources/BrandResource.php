<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BrandResource\Pages;
use App\Models\Brand;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class BrandResource extends Resource
{
    protected static ?string $model = Brand::class;

    protected static ?string $navigationLabel = 'Brands';
    protected static ?string $navigationIcon = 'heroicon-o-star';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->unique(Brand::class, 'name')
                    ->maxLength(255),
                Forms\Components\FileUpload::make('logo')
                    ->image()
                    ->directory('logos')
                    ->required(),
                Forms\Components\Toggle::make('status')
                    ->label('Active')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->sortable()->searchable(),
                Tables\Columns\ImageColumn::make('logo'),
                Tables\Columns\IconColumn::make('status')
                    ->boolean()
                    ->label('Active'),
                Tables\Columns\TextColumn::make('created_at')->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label('View')
                    ->modalHeading('Brand Details')
                    ->modalButton('Close')
                    ->modalWidth('lg')
                    ->recordTitle(fn($record) => $record->name)
                    ->form([
                        Forms\Components\TextInput::make('name')
                            ->disabled()
                            ->default(fn($record) => $record->name),

                        Forms\Components\FileUpload::make('logo')
                            ->image()
                            ->disabled()
                            ->default(fn($record) => $record->logo),

                        Forms\Components\Toggle::make('status')
                            ->label('Active')
                            ->disabled()
                            ->default(fn($record) => $record->status),
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
            'index' => Pages\ListBrands::route('/'),
            'create' => Pages\CreateBrand::route('/create'),
            'edit' => Pages\EditBrand::route('/{record}/edit'),
        ];
    }
}
