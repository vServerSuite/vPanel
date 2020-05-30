<?php

namespace App\Http\Controllers;

use Auth;

use Illuminate\Http\Request;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Exceptions\PermissionDoesNotExist;

use Illuminate\Support\Facades\Http;

use App\User;

class ProfileController extends Controller
{
    public function details($userId)
    {
        $requestor = Auth::User();

        if ($requestor !== null) {
            $user = User::find($userId);
            if ($user !== null) {
                if (($user->id === $requestor->id) or $requestor->can('View All Profiles')) {
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
                } else {
                    return response()->json(['error' => 'Insufficient permissions']);
                }
            } else {
                return response()->json(['error' => 'User not found']);
            }
        } else {
            return response()->json(['error' => 'Requestor is not authenticated']);
        }
    }

    public function permissions($userId)
    {
        $requestor = Auth::User();

        if ($requestor !== null) {
            if ($requestor->can('View Permissions')) {
                $user = User::find($userId);

                if ($user !== null) {

                    $permissions = Permission::getPermissions(['guard_name' => 'web']);
                    $permissionObject = [];

                    foreach ($permissions as $permission) {
                        array_push($permissionObject, [
                            'permission_name' => $permission->name,
                            'permission_value' => $user->can($permission->name)
                        ]);
                    }
                    return response()->json($permissionObject);
                } else {
                    return response()->json(['error' => 'User not found']);
                }
            } else {
                return response()->json(['error' => 'Insufficient Permissions']);
            }
        } else {
            return response()->json(['error' => 'Requestor is not authenticated']);
        }
    }

    public function updatePermission($userId, Request $request)
    {
        $error = null;

        $requestor = Auth::User();

        if ($requestor !== null) {
            if ($requestor->can('Edit Permissions')) {
                $user = User::find($userId);
                if ($user !== null) {
                    $permissionName = $request->input('permission_name');
                    if ($permissionName !== null) {
                        $permissionValue = $request->input('permission_value');
                        if ($permissionValue !== null) {
                            try {
                                $webPermission = Permission::findByName($permissionName, 'web');
                                $apiPermission = Permission::findByName($permissionName, 'api');

                                if ($permissionValue) {
                                    $user->givePermissionTo($webPermission, $apiPermission);
                                } else {
                                    $user->revokePermissionTo($webPermission, $apiPermission);
                                }
                            } catch (PermissionDoesNotExist $ex) {
                                $error = $ex;
                            }
                        } else {
                            $error = "Permission value was not set when sending the request";
                        }
                    } else {
                        $error = "Permission key was not set when sending the request";
                    }
                } else {
                    $error = "User was not found";
                }
            } else {
                $error = "Insufficient Permissions";
            }
        } else {
            $error = "Requestor Id was null";
        }
        return response()->json([
            'success' => $error == null,
            'error' => $error
        ]);
    }
}
