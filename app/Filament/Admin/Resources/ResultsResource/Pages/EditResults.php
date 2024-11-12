<?php

namespace App\Filament\Admin\Resources\ResultsResource\Pages;

use App\Filament\Admin\Resources\ResultsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditResults extends EditRecord
{
    protected static string $resource = ResultsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
