<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\QuestionClosedQuestionRelationManagerResource\RelationManagers\AnswerRelationManager;
use App\Filament\Admin\Resources\QuestionClosedQuestionRelationManagerResource\RelationManagers\AnswersRelationManager;
use App\Filament\Admin\Resources\QuestionOptionsRelationManagerResource\RelationManagers\QuestionOptionsRelationManager;
use App\Filament\Admin\Resources\QuestionResource\Pages;
use App\Filament\Admin\Resources\QuestionResource\RelationManagers;

use App\Models\Question;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\Str;
use Filament\Forms\Components\FileUpload;

use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Carbon\Carbon;
use Filament\Actions\Action;

use Illuminate\Database\Eloquent\SoftDeletingScope;

class QuestionResource extends Resource
{
    public static ?string $label = 'Savollar';
    protected static ?string $model = Question::class;

    protected static ?string $navigationIcon = 'heroicon-o-question-mark-circle';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Main Content')->schema(
                    [
                        RichEditor::make('body')->required()->columnSpanFull()->minLength(1)->disableToolbarButtons(['attachFiles'])->maxLength(150),
                Select::make('question_type')
    ->options([
        'multiple_choice' => 'Multiple Choice',
        'singular_choice' => 'Singular Choice',
       'closed_question' => 'Closed Question',
    ])->required(),
                TextInput::make('slug')->required()->minLength(1)->unique()->maxLength(150),

                    ]
    ),
    Section::make('Additional Content')->schema(
        [

            DateTimePicker::make('created_date')->default(Carbon::now()),
            //Checkbox::make('featured'),
            Select::make('quiz_id')->relationship('quiz', 'slug')
            ->searchable()
            ->required(),
            TextInput::make('answer')->minLength(1)->maxLength(100),
        ]
        ),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable()->searchable(),
                TextColumn::make('body')->sortable()->searchable()->html(),
                TextColumn::make('created_at')->sortable()->searchable(),
                TextColumn::make('quiz_id')->sortable()->searchable(),
                TextColumn::make('question_type')->sortable()->searchable(),
                TextColumn::make('slug')->sortable()->searchable(),
                TextColumn::make('answer')->sortable()->searchable()
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        //if (question_type === 'multiple_choice' || $rec->question_type === 'singular_choice') {
       //     return [
      //          QuestionOptionsRelationManager::class
          //  ];
       // }
        return [
            QuestionOptionsRelationManager::class,
         //   AnswersRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListQuestions::route('/'),
            'create' => Pages\CreateQuestion::route('/create'),
            'edit' => Pages\EditQuestion::route('/{record}/edit'),
        ];
    }
}
