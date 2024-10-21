<?php
namespace App\Filament\Resources\JobTypeResource\Api;

use Rupadana\ApiService\ApiService;
use App\Filament\Resources\JobTypeResource;
use Illuminate\Routing\Router;


class JobTypeApiService extends ApiService
{
    protected static string | null $resource = JobTypeResource::class;

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
