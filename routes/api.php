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
use App\Http\Controllers\Admin\PermissionsController;
use App\Http\Controllers\ProfileController;

use Illuminate\Support\Facades\Http;

use Spatie\Permission\Models\Permission;
use App\User;

$v1Prefix = "/v1/";

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:api')->group(function () use ($v1Prefix) {
    Route::get($v1Prefix . 'players/{player?}', function ($player = null) {
        return $player == null ? App\Models\Player::all() : App\Models\Player::find($player);
    });
    Route::get($v1Prefix . 'punishments/{player?}', function ($player = null) {
        return $player == null ? App\Models\Punishment::all() : App\Models\Punishment::where('punishment_uuid', $player)->get();
    });
    Route::get($v1Prefix . 'logs/{player?}', function ($player = null) {
        return $player == null ? App\Models\Log::all() : App\Models\Log::where('log_player', $player)->get();
    });
    Route::get($v1Prefix . 'onlineplayers', function () {
        return Http::withHeaders(['Authorization' => 'Basic ' . env('MINECRAFT_API_KEY')])
            ->get(env('MINECRAFT_API_URL') . '/players');
    });
    Route::get($v1Prefix . 'donations/{limit?}', function ($limit = 5) {
        $donations = Http::withHeaders(['X-Tebex-Secret' => env('TEBEX_SECRET_KEY')])
            ->get('https://plugin.tebex.io/payments/?limit=' . $limit)->json();

        $donationsDto = [];

        foreach ($donations as $donation) {
            array_push($donationsDto, [
                'id' => $donation['id'],
                'amount' => $donation['amount'],
                'currency' => [
                    'symbol' => $donation['currency']['symbol']
                ],
                'player' => [
                    'name' => $donation['player']['name'],
                    'uuid' => preg_replace("/(\w{8})(\w{4})(\w{4})(\w{4})(\w{12})/i", "$1-$2-$3-$4-$5", $donation['player']['uuid'])
                ]
            ]);
        }

        return response()->json([
            'items' => $donationsDto
        ]);
    });

    // Route::get($v1Prefix . 'permissions/table/headers', 'Admin\PermissionsController@headers');
    Route::get($v1Prefix . 'user/details/{userId}', 'ProfileController@user');
});

Route::get($v1Prefix . 'auth/discord', 'DiscordController@generateAuthUrl');
Route::get($v1Prefix . 'auth/discord/callback', 'DiscordController@callback');
Route::post($v1Prefix . 'auth/discord/flow', 'DiscordController@code_exchange');

Route::post($v1Prefix . 'onboarding/generate', 'OnboardingController@generate');
Route::post($v1Prefix . 'onboarding/save/mc', 'OnboardingController@save_mc');
Route::post($v1Prefix . 'onboarding/save/discord', 'OnboardingController@save_discord');
Route::post($v1Prefix . 'onboarding/register', 'OnboardingController@register');

Route::post($v1Prefix . 'auth/minecraft', function (Request $request) {
    $token = App\Models\PanelVerificationToken::where('token', $request->input('code'))->first();

    $valid = false;
    $uuid = null;
    $username = null;
    $error = null;

    if ($token != null) {
        if ($token->token_used == '0') {
            $uuid = $token->token_uuid;
            $player = App\Models\Player::find($uuid);
            if ($player != null) {
                $username = $player->player_username;
                $valid = true;
            } else {
                $error = "Player could not be found in the database. Please report this error to your Systems Administrator";
            }
        } else {
            $error = "Token has already been used";
        }
    } else {
        $error = "Token could not be found";
    }

    if ($valid) {
        $token->token_used = '1';
        $token->save();
    }

    return response()->json([
        'isValid' => $valid,
        'uuid' => $uuid,
        'username' => $username,
        'error' => $error
    ]);
});
