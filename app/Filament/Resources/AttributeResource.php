<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AttributeResource\Pages;
use App\Models\Attribute;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AttributeResource extends Resource
{
    protected static ?string $model = Attribute::class;

    protected static ?string $navigationLabel = 'Attributes';
    protected static ?string $navigationIcon = 'heroicon-o-adjustments-horizontal';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->unique(Attribute::class, 'name', ignoreRecord: true)
                    ->maxLength(255),
                
                Forms\Components\Section::make('Attribute Values')
                    ->schema([
                        Forms\Components\Repeater::make('attributeValues')
                            ->relationship()
                            ->schema([
                                Forms\Components\TextInput::make('value')
                                    ->required()
                                    ->maxLength(255),
                            ])
                            ->columns(1)
                            ->itemLabel(fn (array $state): ?string => $state['value'] ?? null)
                            ->collapsible()
                            ->defaultItems(0)
                            ->addActionLabel('Add Value')
                            ->deleteAction(
                                fn (Forms\Components\Actions\Action $action) => $action->requiresConfirmation(),
                            ),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('attributeValues.value')
                    ->badge()
                    ->label('Values')
                    ->listWithLineBreaks()
                    ->limitList(3)
                    ->expandableLimitedList(),
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
                    ->modalHeading('Attribute Details')
                    ->modalButton('Close')
                    ->modalWidth('lg')
                    ->recordTitle(fn($record) => $record->name)
                    ->form([
                        Forms\Components\TextInput::make('name')
                            ->disabled()
                            ->default(fn($record) => $record->name),
                        
                        Forms\Components\Placeholder::make('values_list')
                            ->label('Values')
                            ->content(function ($record) {
                                $values = $record->attributeValues()->pluck('value')->toArray();
                                return empty($values) 
                                    ? 'No values defined' 
                                    : implode(', ', $values);
                            }),
                            
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
            'index' => Pages\ListAttributes::route('/'),
            'create' => Pages\CreateAttribute::route('/create'),
            'edit' => Pages\EditAttribute::route('/{record}/edit'),
        ];
    }
}
