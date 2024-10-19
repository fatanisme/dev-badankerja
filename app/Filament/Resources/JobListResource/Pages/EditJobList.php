<?php

namespace App\Filament\Resources\JobListResource\Pages;

use App\Filament\Resources\JobListResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditJobList extends EditRecord
{
    protected static string $resource = JobListResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
