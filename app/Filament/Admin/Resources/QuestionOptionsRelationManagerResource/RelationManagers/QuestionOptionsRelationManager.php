<?php

namespace App\Filament\Admin\Resources\QuestionOptionsRelationManagerResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\CheckboxColumn;
use Illuminate\Container\Attributes\Tag;

class QuestionOptionsRelationManager extends RelationManager
{
    protected static string $relationship = 'options';

    public function form(Form $form): Form
    {
        return $form->schema([
            Section::make('Option Content')->schema([
                ///Forms\Components\TextInput::make('body')
                //   ->required()
                //  ->maxLength(255),

                RichEditor::make('body')
                    ->required()
                    ->columnSpanFull()
                    ->minLength(1)
                    ->disableToolbarButtons(['attachFiles'])
                    ->maxLength(150),
                Checkbox::make('right_option'),
           //     Select::make('question_type')
              //      ->options([
               //         'multiple_choice' => 'Multiple Choice',
               //         'singular_choice' => 'Singular Choice',
              //          'closed_question' => 'Closed Question',
              //      ])
              //      ->required(),
            ]),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('body')
            ->columns([Tables\Columns\TextColumn::make('body')->html(), TextColumn::make('question_id')->sortable()->searchable(), CheckboxColumn::make('right_option')])
            ->filters([
                //
            ])
            ->headerActions([Tables\Actions\CreateAction::make()])
            ->actions([Tables\Actions\EditAction::make(), Tables\Actions\DeleteAction::make()])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }
}
