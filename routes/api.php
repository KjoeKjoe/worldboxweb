<?php

use Illuminate\Http\Request;
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

Route::middleware([\App\Http\Middleware\WorldboxModMiddleware::class])->group(function () {
    Route::post('twitch/add/slave', [\App\Http\Controllers\TwitchSlaveController::class, 'store']);
});

Route::middleware([\App\Http\Middleware\WorldboxModMiddleware::class])->group(function () {
    Route::prefix('slaves')->group(function () {
        //UnityEndpoints
        Route::get('all', [\App\Http\Controllers\SlaveController::class, 'all']);
        Route::get('get', [\App\Http\Controllers\SlaveController::class, 'get']);
        Route::post('store', [\App\Http\Controllers\SlaveController::class, 'store']);
        Route::post('died', [\App\Http\Controllers\SlaveController::class, 'died']);
        Route::post('stats/update', [\App\Http\Controllers\SlaveController::class, 'updateStats']);

        //Discord command url's
        Route::post('set/race', [\App\Http\Controllers\SlaveController::class, 'setRace']);
        Route::post('set/nickname', [\App\Http\Controllers\SlaveController::class, 'setNickname']);
        Route::post('add/level', [\App\Http\Controllers\SlaveController::class, 'addLevel']);
        Route::post('add/trait', [\App\Http\Controllers\SlaveController::class, 'addTrait']);
        Route::post('add/equipment', [\App\Http\Controllers\SlaveController::class, 'buyEquipment']);
        Route::get('currency/get', [\App\Http\Controllers\SlaveController::class, 'getCurrency']);
        Route::get('shop/get', [\App\Http\Controllers\SlaveController::class, 'getShop']);
        Route::post('respawn', [\App\Http\Controllers\SlaveController::class, 'respawn']);
        Route::post('enable/follow', [\App\Http\Controllers\SlaveController::class, 'follow']);

        //kingdom cmd's
        Route::post('kingdom/war', [\App\Http\Controllers\WarController::class, 'war']);
        Route::post('kingdom/peace', [\App\Http\Controllers\WarController::class, 'peace']);

        Route::post('revolt/store', [\App\Http\Controllers\RevoltController::class, 'store']);
        Route::get('revolt', [\App\Http\Controllers\RevoltController::class, 'get']);
        //not in discord
        Route::get('kingdom/war/cmd', [\App\Http\Controllers\WarController::class, 'getCmd']);

        //get event
        Route::get('event/cmd', [\App\Http\Controllers\EventController::class, 'get']);
        Route::post('event/cmd/store', [\App\Http\Controllers\EventController::class, 'store']);
    });
    //minimap render
    Route::post('map/render', [\App\Http\Controllers\DashboardController::class, 'renderMap']);

});
