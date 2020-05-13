<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PanelVerificationToken extends Model
{
    protected $connection = 'bungee';

    protected $table = 'PanelVerificationTokens';

    protected $primaryKey = 'token_id';

    protected $keyType = 'int';

    public $timestamps = false;
}
