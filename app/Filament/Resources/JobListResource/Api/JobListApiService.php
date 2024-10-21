<?php
namespace App\Filament\Resources\JobListResource\Api;

use Rupadana\ApiService\ApiService;
use App\Filament\Resources\JobListResource;
use Illuminate\Routing\Router;


class JobListApiService extends ApiService
{
    protected static string | null $resource = JobListResource::class;

    public static function handlers() : array
    {
        return [
            Handlers\CreateHandler::class,
            Handlers\UpdateHandler::class,
            Handlers\DeleteHandler::class,
            Handlers\PaginationHandler::class,
            Handlers\DetailHandler::class
        ];

    }
}
