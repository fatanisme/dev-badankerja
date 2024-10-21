<?php
namespace App\Filament\Resources\JobCategoryResource\Api;

use Rupadana\ApiService\ApiService;
use App\Filament\Resources\JobCategoryResource;
use Illuminate\Routing\Router;


class JobCategoryApiService extends ApiService
{
    protected static string | null $resource = JobCategoryResource::class;

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
