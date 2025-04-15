<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TagResource\Pages;
use App\Models\Tag;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TagResource extends Resource
{
    protected static ?string $model = Tag::class;

    protected static ?string $navigationLabel = 'Tags';
    protected static ?string $navigationIcon = 'heroicon-o-tag';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Tag Details')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->unique(Tag::class, 'name', ignoreRecord: true)
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (callable $set, $state) {
                                $set('slug', Tag::createArabicSlug($state));
                            }),
                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->unique(Tag::class, 'slug', ignoreRecord: true)
                            ->maxLength(255)
                            ->disabled()
                            ->dehydrated(true),
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
                Tables\Columns\TextColumn::make('slug')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label('View')
                    ->modalHeading('Tag Details')
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
                        Forms\Components\TextInput::make('created_at')
                            ->label('Created At')
                            ->disabled()
                            ->default(fn($record) => $record->created_at),
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
            'index' => Pages\ListTags::route('/'),
            'create' => Pages\CreateTag::route('/create'),
            'edit' => Pages\EditTag::route('/{record}/edit'),
        ];
    }
}
