<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Api\V1\BooksController;
use App\Http\Controllers\Api\V1\CategoryController;
use App\Http\Controllers\Api\V1\SubCategoryController;
use App\Http\Controllers\Api\V1\AuthenticationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/



Route::prefix('/v1')->group(
    function () {
        Route::post('/login', [AuthenticationController::class, 'login']);
        Route::group(['middleware' => ['auth:sanctum','ensure.json.header']], function () {
            Route::post('/logout', [AuthenticationController::class, 'logout']);

            Route::apiResource('/users', UserController::class);
            Route::apiResource('/categories', CategoryController::class);
            Route::apiResource('/subcategories', SubCategoryController::class);

            Route::apiResource('/books', BooksController::class);

            Route::get('/books/search/{title} ', [BooksController::class, 'search']);

        });
    }
);
