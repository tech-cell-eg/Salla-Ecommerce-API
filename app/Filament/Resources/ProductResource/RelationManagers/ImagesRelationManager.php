<?php

namespace App\Filament\Resources\ProductResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ImagesRelationManager extends RelationManager
{
    protected static string $relationship = 'images';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\FileUpload::make('image') // Fixed field name
                    ->required()
                    ->image()
                    ->directory('tours')
                    ->preserveFilenames()
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/gif']),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('image')
            ->columns([
                Tables\Columns\ImageColumn::make('image'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                $this->bulkUploadAction(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    protected function bulkUploadAction(): Tables\Actions\Action
    {
        return Tables\Actions\Action::make('bulkUpload')
            ->label('Upload Multiple Images')
            ->icon('heroicon-m-photo')
            ->form([
                Forms\Components\FileUpload::make('image') // Fixed field name
                    ->label('Select Images')
                    ->multiple()
                    ->required()
                    ->image()
                    ->directory('tours')
                    ->preserveFilenames()
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/gif']),
            ])
            ->action(function (array $data): void {
                foreach ($data['image'] as $imagePath) { // Fixed array key
                    $this->ownerRecord->images()->create([
                        'image' => $imagePath,
                    ]);
                }
            })
            ->modalHeading('Bulk Upload Images')
            ->modalSubmitActionLabel('Upload')
            ->successNotificationTitle('Images uploaded successfully');
    }
}