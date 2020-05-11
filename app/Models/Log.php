<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $connection = 'bungee';

    protected $table = 'Logs';

    protected $primaryKey = 'log_id';

    protected $keyType = 'int';
}
