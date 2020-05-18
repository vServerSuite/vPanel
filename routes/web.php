<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/onboarding/{onboarding_id}', function ($onboardingid) {
    $onboarding = App\Models\Onboarding::find($onboardingid);
    if ($onboarding != null) {
        return view('auth/onboarding', [
            'error' => null,
            'id' => $onboardingid,
            'mc_uuid' => $onboarding->mc_uuid_actual,
            'discord_id' => $onboarding->discord_id
        ]);
    } else {
        return view('auth/onboarding', [
            'error' => "Onboarding Id not found - Please generate an id via running /panel verify in-game",
            'id' => $onboardingid,
            'mc_uuid' => "null",
            'discord_id' => "null"
        ]);
    }
});

Route::get('/discord/callback', function () {
    return view('auth/discord_callback');
});
