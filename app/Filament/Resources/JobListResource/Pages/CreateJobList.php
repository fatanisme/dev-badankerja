<?php

namespace App\Filament\Resources\JobListResource\Pages;

use App\Filament\Resources\JobListResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateJobList extends CreateRecord
{
    protected static string $resource = JobListResource::class;
}
