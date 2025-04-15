<?php

namespace App\Filament\Resources\ProductResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class ImagesRelationManager extends RelationManager
{
    protected static string $relationship = 'images';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\FileUpload::make('images')
                    ->required()
                    ->image()
                    ->directory('tours')
                    ->preserveFilenames(),
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
                // Tables\Actions\CreateAction::make(), // Default single upload
                $this->bulkUploadAction(),           // Custom multi upload
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
                Forms\Components\FileUpload::make('images')
                    ->label('Select Images')
                    ->multiple()
                    ->required()
                    ->image()
                    ->directory('tours')
                    ->preserveFilenames(),
            ])
            ->action(function (array $data): void {
                foreach ($data['images'] as $imagePath) {
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
