<?php

use App\Http\Controllers\DOSpacesController;
use App\Http\Controllers\LoginUser\LoginUserController;
use App\Http\Controllers\LogoutUser\LogoutUserController;
use App\Http\Controllers\RegisterUser\RegisterUserController;
use App\Http\Controllers\Submissions\AssignSubmissionController;
use App\Http\Controllers\Submissions\CreateSubmissionController;
use App\Http\Controllers\Submissions\GetSubmissionsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
*/

Route::post('/register', RegisterUserController::class);

Route::post('/login', LoginUserController::class)->middleware(['guest']);

Route::post('/logout', LogoutUserController::class)->middleware(['auth:sanctum']);

Route::post('/submissions', CreateSubmissionController::class)->middleware(['auth:sanctum', 'role:Patient']);

Route::get('/submissions', GetSubmissionsController::class)->middleware(['auth:sanctum']);

Route::put('/submissions/{submission}', AssignSubmissionController::class)->middleware(['auth:sanctum', 'role:Doctor']);

Route::post('/prescription', [DOSpacesController::class, 'store']);//->middleware(['auth:sanctum', 'role:Doctor']);

Route::delete('/prescription', [DOSpacesController::class, 'delete']);

Route::put('/prescription', [DOSpacesController::class, 'update']);
