<?php

namespace App\Filament\Resources\JobListResource\Pages;

use App\Filament\Resources\JobListResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListJobLists extends ListRecords
{
    protected static string $resource = JobListResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
