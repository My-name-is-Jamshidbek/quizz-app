<?php

namespace App\Filament\Admin\Resources\QuizResource\Pages;

use App\Filament\Admin\Resources\QuizResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Admin\Resources\QuizResource\Widgets\QuizChart;
use Filament\Pages\Concerns\ExposesTableToWidgets;

class ListQuizzes extends ListRecords
{
    use ExposesTableToWidgets;
    protected static string $resource = QuizResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
    protected function getFooterWidgets(): array {
        return [
            QuizChart::class,
        ];
    }
}
