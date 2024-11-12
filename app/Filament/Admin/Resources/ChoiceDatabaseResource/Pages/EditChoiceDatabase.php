<?php

namespace App\Filament\Admin\Resources\ChoiceDatabaseResource\Pages;

use App\Filament\Admin\Resources\ChoiceDatabaseResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditChoiceDatabase extends EditRecord
{
    protected static string $resource = ChoiceDatabaseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
