<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Api\V1\BooksController;
use App\Http\Controllers\Api\V1\RolesController;
use App\Http\Controllers\Api\V1\BookLoanController;
use App\Http\Controllers\Api\V1\CategoryController;
use App\Http\Controllers\Api\V1\PermissionsController;
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
        Route::post('/users/register', [UserController::class, 'registerUnAuthenticatedUser']);

        Route::group(['middleware' => ['auth:sanctum','ensure.json.header']], function () {
            Route::post('/logout', [AuthenticationController::class, 'logout']);

            Route::apiResource('/users', UserController::class);
            Route::apiResource('/categories', CategoryController::class);
            Route::apiResource('/subcategories', SubCategoryController::class);
            Route::apiResource('/books', BooksController::class);
            Route::apiResource('/roles', RolesController::class);
            Route::apiResource('/bookloans', BookLoanController::class);
            Route::apiResource('/permissions', PermissionsController::class);

            Route::get('/books/search/{title} ', [BooksController::class, 'search']);
            Route::post('/bookloans/return/{id}', [BookLoanController::class, 'returnBook']);
            Route::post('/bookloans/approve/{id}', [BookLoanController::class, 'approveBookLoan']);
            Route::post('/bookloans/reject/{id}', [BookLoanController::class, 'rejectBookLoan']);
            Route::post('/bookloans/extend/{id}', [BookLoanController::class, 'extendBookLoan']);
            Route::get('/bookloans/approved/loans', [BookLoanController::class, 'getApprovedBookLoans']);
            Route::get('/bookloans/pending/loans', [BookLoanController::class, 'getPendingBookLoans']);
            Route::get('/bookloans/rejected/loans', [BookLoanController::class, 'getRejectedBookLoans']);
            Route::get('/bookloans/extended/loans', [BookLoanController::class, 'getExtendedBookLoans']);
            Route::get('/bookloans/returned/loans', [BookLoanController::class, 'getReturnedBookLoans']);
            Route::get('/bookloans/user/loans/{id}', [BookLoanController::class, 'getUserBookLoans']);
            Route::get('/bookloans/overdue/loans', [BookLoanController::class, 'getOverdueBookLoans']);

        });
    }
);
