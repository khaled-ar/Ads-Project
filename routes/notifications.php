<?php

use App\Http\Controllers\NotificationsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
|
| Here is where you can register auth routes.
|
*/

Route::prefix('notifications')->controller(NotificationsController::class)
    ->group(function() {
        Route::get('', 'index');
        Route::get('un-readed', 'unreaded');
        Route::get('readed', 'readed');
        Route::get('{notification}', 'show');
        Route::delete('{notification}', 'delete');
        Route::delete('destroy/{notification}', 'destroy');
        Route::patch('mark-as-readed/{notification}', 'mark_as_readed');
        Route::patch('mark-as-unreaded/{notification}', 'mark_as_unreaded');
    });
