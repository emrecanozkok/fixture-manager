<?php

namespace App\Http\Controllers;

use App\Models\Fixture;
use App\Models\Team;
use App\Services\FixtureService;


class FixtureController extends Controller
{
    public FixtureService $fixtureService;

    public function __construct(FixtureService $fixtureService)
    {
        $this->fixtureService = $fixtureService;
    }
    public function generate(){
        $teams = Team::all();

        if(!$this->fixtureService->checkFixtureHasGenerated()) {
            $fixture = $this->fixtureService->generateFixture($teams);
            foreach ($fixture as $week){
                foreach ($week['games'] as $match){
                    Fixture::insert($match->toArray());
                }

            }
        }

        $dbFixture = Fixture::orderBy('id','ASC')->with(['homeTeam','awayTeam'])->get()->groupBy(['week']);
        return view('fixture',['fixture' => $dbFixture]);

    }
}
