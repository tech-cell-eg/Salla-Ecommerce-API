<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationLabel = 'Categories';
    protected static ?string $navigationIcon = 'heroicon-o-folder';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->unique(Category::class, 'name', ignoreRecord: true)
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(function ($state, callable $set) {
                        $set('slug', Str::slug($state));
                    }),
                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->unique(Category::class, 'slug', ignoreRecord: true)
                    ->maxLength(255)
                    ->disabled(fn ($context) => $context === 'edit'),
                Forms\Components\Select::make('parent')
                    ->label('Parent Category')
                    ->relationship('parentCategory', 'name')
                    ->nullable()
                    ->options(
                        Category::whereNull('parent')->pluck('name', 'id')->toArray()
                    ),
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
                Tables\Columns\TextColumn::make('slug')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('parentCategory.name')
                    ->label('Parent')
                    ->default('None'),
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
                    ->modalHeading('Category Details')
                    ->modalButton('Close')
                    ->modalWidth('lg')
                    ->recordTitle(fn($record) => $record->name)
                    ->form([
                        Forms\Components\TextInput::make('name')
                            ->disabled()
                            ->default(fn($record) => $record->name),
                        Forms\Components\TextInput::make('slug')
                            ->disabled()
                            ->default(fn($record) => $record->slug),
                        Forms\Components\TextInput::make('parent')
                            ->label('Parent Category')
                            ->disabled()
                            ->default(fn($record) => $record->parentCategory?->name ?? 'None'),
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
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}