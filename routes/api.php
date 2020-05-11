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

$v1Prefix = "/v1/";

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get($v1Prefix . 'players/{player?}', function($player = null) {
    return $player == null ? App\Models\Player::all() : App\Models\Player::find($player);
});

Route::get($v1Prefix . 'punishments/{player?}', function($player = null) {
    return $player == null ? App\Models\Punishment::all() : App\Models\Punishment::where('punishment_uuid', $player)->get();
});
Route::get($v1Prefix . 'logs/{player?}', function($player = null) {
    return $player == null ? App\Models\Log::all() : App\Models\Log::where('log_player', $player)->get();
});
