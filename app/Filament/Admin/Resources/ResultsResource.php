<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\ResultsResource\Pages;
use App\Filament\Admin\Resources\ResultsResource\RelationManagers;
use App\Models\Result;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Support\Facades\FilamentAsset;
use Filament\Support\Assets\Css;



class ResultsResource extends Resource
{
    protected static ?string $model = Result::class;
    public static ?string $label = 'Natijalar';

    protected static ?string $navigationIcon = 'heroicon-o-arrow-trending-up';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

            ]);
    }

    public static function canCreate(): bool
    {
       return false;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('owner.name')
                    ->searchable(),
                    Tables\Columns\TextColumn::make('quiz.category')
                    ->searchable(),
                    Tables\Columns\TextColumn::make('created_at')
                    ->searchable(),
                    Tables\Columns\TextColumn::make('updated_at')
                    ->searchable(),
                    Tables\Columns\TextColumn::make('result')
                    ->searchable()
            ])
            ->filters([
                //
            ])
            ->actions([
                //Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListResults::route('/'),
   //         'create' => Pages\CreateResults::route('/create'),
         //   'edit' => Pages\EditResults::route('/{record}/edit'),
        ];
    }
}
