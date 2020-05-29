<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Permission;

use App\User;

class ProfileController extends Controller
{
    public function user($user)
    {
        $headers = [[
            'text' => 'Username',
            'value' => 'username'
        ]];
        foreach (Permission::getPermissions(['guard_name' => 'web']) as $permission) {
            array_push($headers, [
                'text' => $permission->name,
                'value' => strtolower(str_replace(' ', '_', $permission->name))
            ]);
        };
        return response()->json([
            'headers' => $headers
        ]);
    }
}
