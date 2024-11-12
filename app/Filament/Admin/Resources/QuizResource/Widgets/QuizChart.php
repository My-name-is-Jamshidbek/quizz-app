<?php

namespace App\Filament\Admin\Resources\QuizResource\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Quiz;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Filament\Widgets\LineChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageTable;
use App\Filament\Admin\Resources\QuizResource\Pages\ListQuizzes;
use Filament\Widgets\Widget;

class QuizChart extends LineChartWidget
{
    protected int | string | array $columnSpan = 'full';
    use InteractsWithPageTable;

    protected function getTablePage(): string {
        return ListQuizzes::class;
    }
    protected static ?string $heading = 'Chart';

    protected function getData(): array
    {
        $data = Trend::model(Quiz::class)
        ->between(
            start: now()->startOfYear(),
            end: now()->endOfYear(),
        )
        ->perMonth()
        ->dateColumn('created_at')
        ->count();

    return [
        'datasets' => [
            [
                'label' => 'Quizzes',
                'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
            ],
        ],
        'labels' => $data->map(fn (TrendValue $value) => $value->date),
    ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
