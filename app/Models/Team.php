<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $fillable = ['team_name','code','country_code'];

    public function specs()
    {
        return $this->hasOne(TeamSpec::class,'team_id','id');
    }
}
