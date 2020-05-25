<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Request;
use App\Models\Onboarding;

use App\Models;
use App\User;

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

        if ($key != null) {
            $uuid = $request::input('mc_uuid');

            if ($uuid != null) {
                $username = $request::input('mc_username');

                if ($username != null) {
                    $onboardingRequest = Onboarding::find($key);

                    $error = null;

                    if ($onboardingRequest != null) {
                        if ($onboardingRequest->mc_uuid_expected == $uuid) {
                            $onboardingRequest->mc_uuid_actual = $uuid;
                            $onboardingRequest->username = $username;
                            $onboardingRequest->save();
                        } else {
                            $error = "This minecraft UUID is not linked to the onboarding Id. Please re-generate an onboarding link in-game";
                        }
                    } else {
                        $error = "Onboarding Id not found";
                    }
                } else {
                    $error = "Username is required to update MC record";
                }
            } else {
                $error = "UUID is required to update MC record";
            }
        } else {
            $error = "Onboarding Id is required to update MC record";
        }

        return response()->json([
            'success' => $error == null,
            'error' => $error
        ]);
    }

    public function save_discord(Request $request)
    {
        $key = $request::input('key');

        if ($key != null) {
            $discordId = $request::input('discord_id');

            if ($discordId != null) {
                $discordEmail = $request::input('discord_email');

                if ($discordEmail != null) {
                    $onboardingRequest = Onboarding::find($key);

                    $error = null;

                    if ($onboardingRequest != null) {
                        $onboardingRequest->discord_id = $discordId;
                        $onboardingRequest->email = $discordEmail;
                        $onboardingRequest->save();
                    } else {
                        $error = "Onboarding Id not found";
                    }
                } else {
                    $error = "Discord email is required to update Discord record";
                }
            } else {
                $error = "Discord Id is required to update Discord record";
            }
        } else {
            $error = "Onboarding Id is required to update Discord record";
        }

        return response()->json([
            'success' => $error == null,
            'error' => $error
        ]);
    }

    public function register(Request $request)
    {
        $onboardingId = $request::input('onboarding_id');
        $email = $request::input('email');
        $password = $request::input('password');
        $passwordConfirm = $request::input('password_confirm');
        $error = null;

        if ($onboardingId != null) {
            $onboardingRequest = Onboarding::find($onboardingId);
            if ($onboardingRequest != null) {
                if ($email != null) {
                    if ($password != null) {
                        if ($passwordConfirm != null) {
                            if ($password == $passwordConfirm) {
                                if (User::where('email', $email)->exists() == false) {
                                } else {
                                    $error = "Email is already registered";
                                }
                            } else {
                                $error = "Passwords do not match";
                            }
                        } else {
                            $error = "Confirmation Password is required";
                        }
                    } else {
                        $error = "Password is required";
                    }
                } else {
                    $error = "Email is required";
                }
            } else {
                $error = "Onboarding Id was not found";
            }
        } else {
            $error = "Onboarding Id is required";
        }


        return response()->json([
            'success' => $error == null,
            'error' => $error
        ]);
    }
}
