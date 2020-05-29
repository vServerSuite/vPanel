<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Http;

use App\User;

class ProfileController extends Controller
{
    public function details($userId)
    {
        $user = User::find($userId);

        $discordUser = Http::withHeaders(['Authorization' => 'Bot ' . env('DISCORD_BOT_TOKEN')])
            ->get('https://discord.com/api/v6/users/' . $user->discord_id)->json();

        return response()->json([
            'discord' => [
                'id' => $discordUser['id'],
                'username' => $discordUser['username'] . '#' . $discordUser['discriminator'],
                'avatar' => 'https://cdn.discordapp.com/avatars/' . $discordUser['id'] . '/' . $discordUser['avatar'] . '.' . (strpos($discordUser['avatar'], '_', 1) ? "gif" : "png") . '?size=128'
            ],
            'username' => $user->name,
            'avatar' => 'https://crafatar.com/avatars/' . $user->mc_uuid . '?size=100'
        ]);
    }

    public function permissions($userId)
    {
        $user = User::find($userId);

        $permissions = Permission::getPermissions(['guard_name' => 'web']);
        $permissionObject = [];

        foreach ($permissions as $permission) {
            array_push($permissionObject, [
                'perm_name' => $permission->name,
                'perm_value' => $user->can($permission->name)
            ]);
        }
        return response()->json($permissionObject);
    }
}
