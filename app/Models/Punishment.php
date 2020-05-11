<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Punishment extends Model
{
    protected $connection = 'bungee';

    protected $table = 'Punishments';

    protected $primaryKey = 'punishment_id';

    protected $keyType = 'string';
}
