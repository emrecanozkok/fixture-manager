<?php

namespace App\Http\Controllers;

use App\Enum\SimulationEnum;
use App\Models\Fixture;
use App\Services\FixtureService;
use App\Services\SimulationService;

class SimulationController extends Controller
{
    public SimulationService $simulationService;
    public FixtureService $fixtureService;

    public function __construct(SimulationService $simulationService,FixtureService $fixtureService)
    {
        $this->simulationService = $simulationService;
        $this->fixtureService = $fixtureService;
    }

    public function index()
    {
        if($this->fixtureService->checkFixtureHasGenerated()) {
            $scoreBoardData = $this->simulationService->calculateScoreBoard();
            $nextWeek = $this->simulationService->findNextWeek();
            $nextWeekData = $this->simulationService->nextWeekFixture();
            $prediction = $this->simulationService->calculateChampPercentage();
            return view('simulation', [
                'scoreBoard' => $scoreBoardData,
                'nextWeek' => $nextWeek,
                'nextWeekData' => $nextWeekData,
                'prediction' => $prediction
            ]);
        }else{
            return redirect()->route('tournament.index');
        }
    }

    public function playNextWeek()
    {
        $this->simulationService->playWeek(SimulationEnum::NEXTWEEK);
        return redirect()->route('simulation.index');

    }
    public function playAllWeeks()
    {
        $this->simulationService->playWeek(SimulationEnum::ALL);
        return redirect()->route('simulation.result');

    }
    public function result(){
        if($this->fixtureService->checkFixtureHasGenerated()) {
            $dbFixture = Fixture::orderBy('id', 'ASC')->with(['homeTeam', 'awayTeam'])->get()->groupBy(['week']);
            return view('result', ['fixture' => $dbFixture]);
        }
    }
    public function resetData()
    {
        $this->simulationService->resetData();
        return redirect()->route('tournament.index');

    }
}
