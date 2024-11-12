<?php

namespace App\Filament\Admin\Resources\ChoiceDatabaseResource\Pages;

use App\Filament\Admin\Resources\ChoiceDatabaseResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListChoiceDatabases extends ListRecords
{
    protected static string $resource = ChoiceDatabaseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
