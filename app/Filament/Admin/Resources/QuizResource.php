<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\QuizResource\Pages;
use App\Filament\Resources\QuestionRelationManagerResource\RelationManagers\QuizQuestionRelationManager;
use App\Models\Quiz;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Admin\Resources\QuizResource\Widgets\QuizChart;




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
use Filament\Facades\Filament;

class QuizResource extends Resource
{
    public static ?string $label = 'Quizlar';
    protected static ?string $model = Quiz::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Main Content')->schema(
                    [
                        TextInput::make('category')->
                required()->minLength(1)->maxLength(150)
                ->afterStateUpdated(function(string $operation, $state, Forms\Set $set) {
                    if($operation === 'edit') {
                        return;
                    }
                   $set('slug', Str::slug($state));
                }),
                TextInput::make('slug')->required()->minLength(1)->unique()->maxLength(150),

                Section::make('Meta')->schema(
                    [

                        DateTimePicker::make('created_date')->default(Carbon::now()),
                        Checkbox::make('featured'),
                        Select::make('user_id')->relationship('author', 'name')
                        ->searchable()
                        ->required(),
                    ]
                    ),
                    ]
                )]
            );

    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('category')->sortable()->searchable(),
                TextColumn::make('slug')->sortable()->searchable(),
                TextColumn::make('author.name')->sortable()->searchable(),
                TextColumn::make('id')->sortable()->searchable(),
                TextColumn::make('created_date')->date('Y-m-d')->sortable()->searchable(),
                CheckboxColumn::make('featured')
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                //Tables\Actions\CreateAction::make()
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
            QuizQuestionRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListQuizzes::route('/'),
            'create' => Pages\CreateQuiz::route('/create'),
            'edit' => Pages\EditQuiz::route('/{record}/edit'),
        ];
    }

    public static function getWidgets(): array {
        return[
          QuizChart::class
        ];
    }


}
