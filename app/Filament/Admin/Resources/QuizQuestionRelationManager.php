<?php

namespace App\Filament\Resources\QuestionRelationManagerResource\RelationManagers;

use App\Filament\Admin\Resources\QuestionOptionResource\RelationManagers\OptionsRelationManager;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Section;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\Select;
use Symfony\Component\Console\Question\ChoiceQuestion;

class QuizQuestionRelationManager extends RelationManager
{
    protected static string $relationship = 'questions';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Main Content')->schema([
                Forms\Components\TextInput::make('body')
                    ->required()
                    ->maxLength(255),

                //    Forms\Components\Select::make('question_type')
                 //   ->required()
                 //   ->maxLength(255)
                 Select::make('question_type')
    ->options([
        'multiple_choice' => 'Multiple Choice',
        'singular_choice' => 'Singular Choice',
       'closed_question' => 'Closed Question',
    ])->required(),
    Forms\Components\TextInput::make('slug')
    ->required()
    ->maxLength(255),
    ]),
    ]);

    }



    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('question')
            ->columns([
                Tables\Columns\TextColumn::make('body')->html(),
                TextColumn::make('slug')
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
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
