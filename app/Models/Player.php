<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    protected $connection = 'bungee';

    protected $table = 'Players';

    protected $primaryKey = 'player_uuid';

    protected $keyType = 'string';
}
