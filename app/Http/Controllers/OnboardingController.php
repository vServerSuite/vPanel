<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Request;
use App\Models\Onboarding;

use App\Models;

class OnboardingController extends Controller
{
    public function generate(Request $request)
    {
        $code = $request::input('mc_uuid');

        $onboardingResult = Onboarding::create([
            'mc_uuid_expected' => $code
        ]);

        return response()->json([
            'success' => $onboardingResult != null,
            'id' => $onboardingResult->key,
            'onboardingUrl' => env('APP_URL') . '/onboarding/' . $onboardingResult->key
        ]);
    }

    public function save_mc(Request $request)
    {
        $key = $request::input('key');
        $uuid = $request::input('mc_uuid');

        $onboardingRequest = Onboarding::find($key);

        $error = null;

        if ($onboardingRequest != null) {
            if ($onboardingRequest->mc_uuid_expected == $uuid) {
                $onboardingRequest->mc_uuid_actual = $uuid;
                $onboardingRequest->save();
            } else {
                $error = "This minecraft UUID is not linked to the onboarding Id. Please re-generate an onboarding link in-game";
            }
        } else {
            $error = "Onboarding Id not found";
        }

        return response()->json([
            'success' => $error == null,
            'error' => $error
        ]);
    }

    public function save_discord(Request $request)
    {
        $key = $request::input('key');
        $discordId = $request::input('discord_id');

        $onboardingRequest = Onboarding::find($key);

        $error = null;

        if ($onboardingRequest != null) {
            $onboardingRequest->discord_id = $discordId;
            $onboardingRequest->save();
        } else {
            $error = "Onboarding Id not found";
        }

        return response()->json([
            'success' => $error == null,
            'error' => $error
        ]);
    }
}
