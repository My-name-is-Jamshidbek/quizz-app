<?php

namespace App\Filament\Admin\Resources\UserResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use App\Models\User;
use App\Models\Quiz;
use App\Models\Question;
use Filament\Widgets\StatsOverviewWidget\Stat;

class UserStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Users', User::count()),
            Stat::make('Total Admins', User::where('Role', 'ADMIN')->count()),

            Stat::make('Total Quizzes', Quiz::count())
        ];
    }
}
