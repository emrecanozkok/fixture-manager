<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fixture extends Model
{
    use HasFactory;

    public function homeTeam()
    {
        return $this->hasOne(Team::class,'id','home_team_id');
    }

    public function awayTeam()
    {
        return $this->hasOne(Team::class,'id','away_team_id');
    }
}
