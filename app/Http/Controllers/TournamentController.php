<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;

class TournamentController extends Controller
{
    public function index(){
        return view('tournamentTeams',['teams'=>Team::all()]);
    }
}
