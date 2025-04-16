<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Product;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers\TagsRelationManager;
use App\Filament\Resources\ProductResource\RelationManagers\ImagesRelationManager;
use App\Filament\Resources\ProductResource\RelationManagers\DetailsRelationManager;
use App\Filament\Resources\ProductResource\RelationManagers\VariantsRelationManager;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationLabel = 'Products';
    protected static ?string $navigationIcon = 'heroicon-o-cube';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Basic Information')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('small_desc')
                            ->label('Short Description')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\RichEditor::make('description')
                            ->label('Description')
                            ->required()
                            ->columnSpanFull(),
                        Forms\Components\Toggle::make('status')
                            ->label('Active')
                            ->default(true),
                        Forms\Components\TextInput::make('sku')
                            ->label('SKU')
                            ->required()
                            ->unique(Product::class, 'sku', ignoreRecord: true)
                            ->maxLength(255),
                        Forms\Components\Select::make('category_id')
                            ->relationship('category', 'name')
                            ->required()
                            ->searchable(),
                        Forms\Components\Select::make('brand_id')
                            ->relationship('brand', 'name')
                            ->required()
                            ->searchable(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Variants')
                    ->schema([
                        Forms\Components\Toggle::make('has_variants')
                            ->label('Has Variants')
                            ->default(false)
                            ->live()
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('price')
                            ->numeric()
                            ->prefix('$')
                            ->rules(['nullable', 'decimal:0,3'])
                            ->hidden(fn($get) => $get('has_variants'))
                            ->dehydrated(fn($get) => !$get('has_variants')),
                    ]),

                Forms\Components\Section::make('Discount')
                    ->schema([
                        Forms\Components\Toggle::make('has_discount')
                            ->label('Has Discount')
                            ->default(false)
                            ->live(),
                        Forms\Components\TextInput::make('discount')
                            ->numeric()
                            ->prefix('$')
                            ->rules(['nullable', 'decimal:0,3'])
                            ->visible(fn($get) => $get('has_discount')),
                        Forms\Components\DatePicker::make('start_discount')
                            ->label('Start Discount')
                            ->nullable()
                            ->visible(fn($get) => $get('has_discount')),
                        Forms\Components\DatePicker::make('end_discount')
                            ->label('End Discount')
                            ->nullable()
                            ->visible(fn($get) => $get('has_discount')),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Stock Management')
                    ->schema([
                        Forms\Components\Toggle::make('manage_stock')
                            ->label('Manage Stock')
                            ->default(false)
                            ->live(),
                        Forms\Components\TextInput::make('quantity')
                            ->numeric()
                            ->rules(['nullable', 'integer'])
                            ->visible(fn($get) => $get('manage_stock')),
                        Forms\Components\Toggle::make('available_in_stock')
                            ->label('Available in Stock')
                            ->default(true)
                            ->visible(fn($get) => $get('manage_stock')),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('category.name')
                    ->label('Category')
                    ->sortable(),
                Tables\Columns\TextColumn::make('brand.name')
                    ->label('Brand')
                    ->sortable(),
                Tables\Columns\TextColumn::make('price')
                    ->label('Price')
                    ->formatStateUsing(fn($state, $record) => $record->has_variants ? 'Has variants' : \Number::currency($state, 'USD'))
                    ->sortable()
                    ->description(fn($record) => $record->has_variants ? '(multiple variants)' : ''),
                Tables\Columns\IconColumn::make('status')
                    ->boolean()
                    ->label('Active'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            ImagesRelationManager::class,
            DetailsRelationManager::class,
            VariantsRelationManager::class,
            TagsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}