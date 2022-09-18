<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamSpec extends Model
{
    protected $fillable = ['team_id','away_power','goolkeeper_power','supporter_power','home_power'];

    use HasFactory;
}
