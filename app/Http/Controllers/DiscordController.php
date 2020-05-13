<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Http;

class DiscordController extends Controller
{

    private $scopes = 'email identify guilds';
    private $authUrl = 'https://discordapp.com/api/oauth2/authorize';
    private $baseUrl = 'https://discordapp.com/api/v6/';

    public function generateState()
    {
        session_start();
        $session = session_id();
        return sha1($session . env('APP_KEY'));
    }

    public function generateAuthUrl()
    {
        return redirect($this->authUrl . '?response_type=code&client_id=' . env('DISCORD_ID') . '&scope=' . urlencode($this->scopes) . '&state=' . $this->generateState() . '&redirect_uri=' . urlencode(env('APP_URL') . env('DISCORD_CALLBACK')) . '&prompt=consent');
    }

    public function callback(Request $request)
    {
        $state = $request::query('state');
        $sessionState = $this->generateState();

        if ($sessionState != $state) {
            return "Unauthorized";
        }

        return redirect('/discord/callback?code=' . $request::query('code'));
    }

    public function code_exchange(Request $request)
    {
        $code = $request::input('code');
        $res = Http::asForm()->post($this->baseUrl . 'oauth2/token', [
            'client_id' => env('DISCORD_ID'),
            'client_secret' => env('DISCORD_SECRET'),
            'grant_type' => 'authorization_code',
            'code' => $code,
            'redirect_uri' => env('APP_URL') . env('DISCORD_CALLBACK'),
            'scope' => $this->scopes
        ]);
        return $this->get_user($res->json()["access_token"]);
    }

    public function get_user($token)
    {
        $res = Http::withToken($token)->get($this->baseUrl . 'users/@me');
        $data = $res->json();
        $user = array(
            'username' => $data['username'] . '#' . $data['discriminator'],
            'email' => $data['email'],
            'id' => $data['id'],
            'avatar' => 'https://cdn.discordapp.com/avatars/' . $data['id'] . '/' . $data['avatar'] . '.' . (strpos($data['avatar'], '_', 1) ? "gif" : "png") . '?size=128'
        );
        return json_encode($user);
    }
}
