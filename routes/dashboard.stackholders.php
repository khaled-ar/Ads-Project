<?php

use App\Http\Controllers\Dashboard\StackholdersController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
|
| Here is where you can register auth routes.
|
*/

Route::apiResource('stackholders', StackholdersController::class);
Route::get('get-all/stackholders', [StackholdersController::class, 'get_all'])->name('dash.stackholders.get_all');
