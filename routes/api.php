<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

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

use App\Http\Controllers\DiscordController;
use App\Http\Controllers\OnboardingController;

$v1Prefix = "/v1/";

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get($v1Prefix . 'players/{player?}', function ($player = null) {
    return $player == null ? App\Models\Player::all() : App\Models\Player::find($player);
});

Route::get($v1Prefix . 'punishments/{player?}', function ($player = null) {
    return $player == null ? App\Models\Punishment::all() : App\Models\Punishment::where('punishment_uuid', $player)->get();
});
Route::get($v1Prefix . 'logs/{player?}', function ($player = null) {
    return $player == null ? App\Models\Log::all() : App\Models\Log::where('log_player', $player)->get();
});

Route::get($v1Prefix . 'auth/discord', 'DiscordController@generateAuthUrl');
Route::get($v1Prefix . 'auth/discord/callback', 'DiscordController@callback');
Route::post($v1Prefix . 'auth/discord/flow', 'DiscordController@code_exchange');

Route::post($v1Prefix . 'onboarding/generate', 'OnboardingController@generate');
Route::post($v1Prefix . 'onboarding/save/mc', 'OnboardingController@save_mc');
Route::post($v1Prefix . 'onboarding/save/discord', 'OnboardingController@save_discord');

Route::post($v1Prefix . 'auth/minecraft', function (Request $request) {
    $token = App\Models\PanelVerificationToken::where('token', $request->input('code'))->first();

    $valid = $token != null and $token->used == '0';

    if ($valid) {
        $uuid = $token->token_uuid;
        $player = App\Models\Player::find($uuid);
        $username = $player->player_username;

        $token->token_used = '1';
        $token->save();

        return '{"isValid": "true", "uuid": "' . $uuid . '", "username": "' . $username . '"}';
    } else {
        return '{"isValid": "false", "error": "Incorrect Authentication Pin"}';
    }
});