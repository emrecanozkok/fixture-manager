<?php

namespace App\Services;

use App\Enum\SimulationEnum;
use App\Models\Fixture;
use App\Models\Team;
use Illuminate\Database\Eloquent\Collection;

class SimulationService
{

    /**
     * @param SimulationEnum $type
     * @return bool
     */
    public function playWeek(SimulationEnum $type): bool
    {
        $isPlayed = ['is_played', '=', false];
        $nextWeekQuery = [];

        if($type == SimulationEnum::NEXTWEEK){
            $nextWeek = $this->findNextWeek();
            $mainQuery[] = ['week', '=', $nextWeek];
        }

        $mainQuery[] = $isPlayed;

        $weekMatches = Fixture::where($mainQuery)->with(['homeTeam.specs', 'awayTeam.specs'])->get();
        if($weekMatches){
            foreach ($weekMatches as $match) {
                [$homeScore, $awayScore] = $this->simulateMatch($match['homeTeam'], $match['awayTeam']);

                $match->home_score = $homeScore;
                $match->away_score = $awayScore;
                $match->is_played = true;
                $match->save();
            }
            return true;
        }else{
            return false;
        }
    }

    /**
     * @return Collection
     */
    public function nextWeekFixture(): Collection
    {
        $nextWeek = $this->findNextWeek();
        return Fixture::where([
            ['is_played', '=', false],
            ['week', '=', $nextWeek]
        ])->with(['homeTeam.specs', 'awayTeam.specs'])->get();
    }

    /**
     * @return bool|int
     */
    public function findNextWeek(): bool|int
    {
        $nextWeek = Fixture::where('is_played', false)->orderBy('week')->limit(1)->get()->first();
        return $nextWeek ? $nextWeek->week : false;
    }

    /**
     * @param Team $homeTeam
     * @param Team $awayTeam
     * @return int[]
     */
    public function simulateMatch(Team $homeTeam, Team $awayTeam): array
    {
        $homeTeamPower = $homeTeam['specs']->home_power +
            $homeTeam['specs']->goalkeeper_power +
            $homeTeam['specs']->supporter_power;

        $awayTeamPower = $awayTeam['specs']->away_power +
            $awayTeam['specs']->goalkeeper_power +
            $awayTeam['specs']->supporter_power;

        $powerDiff = abs($homeTeamPower - $awayTeamPower);

        $homeScore = 0;
        $awayScore = 0;
        for ($i = 1; $i <= rand(1, 10); $i++) {
            //Ev atak yapıyor.
            if (rand(0, $homeTeamPower) > rand(0, $awayTeamPower)) {
                $homeScore++;
            }

            //Rakip atak yapıyor.
            if (rand(0, $awayTeamPower) > rand(0, $homeTeamPower)) {
                $awayScore++;
            }

        }

        return [$homeScore, $awayScore];
    }

    /**
     * @return array
     */
    public function calculateScoreBoard(): array
    {
        //here we go again
        $scoreTempRow = [
            'team_name' => null,
            'p' => 0,
            'w' => 0,
            'd' => 0,
            'l' => 0,
            'gd' => 0,
            'gf' => 0,
            'ga' => 0
        ];
        $scoreData = [];

        $playedMatches = Fixture::where([
            ['is_played', '=', true]
        ])->with(['homeTeam', 'awayTeam'])->get();

        foreach ($playedMatches as $match) {
            $temp = $scoreTempRow;

            $addPoint = 0;

            if (!isset($scoreData[$match->home_team_id])) {
                $temp['team_name'] = $match['homeTeam']->team_name;
                $scoreData[$match->home_team_id] = $temp;
            }
            if (!isset($scoreData[$match->away_team_id])) {
                $temp['team_name'] = $match['homeTeam']->team_name;
                $scoreData[$match->away_team_id] = $temp;
            }

            $scoreData[$match->home_team_id]['team_name'] = $match['homeTeam']->team_name;
            $scoreData[$match->away_team_id]['team_name'] = $match['awayTeam']->team_name;

            if ($match->home_score > $match->away_score) {
                $scoreData[$match->home_team_id]['p'] = $scoreData[$match->home_team_id]['p'] + 3;
                $scoreData[$match->home_team_id]['w'] = $scoreData[$match->home_team_id]['w'] + 1;
                $scoreData[$match->home_team_id]['gf'] = $scoreData[$match->home_team_id]['gf'] + $match->home_score;

                $scoreData[$match->away_team_id]['l'] = $scoreData[$match->away_team_id]['l'] + 1;
                $scoreData[$match->home_team_id]['ga'] = $scoreData[$match->home_team_id]['ga'] + $match->away_score;
            }
            if ($match->home_score < $match->away_score) {
                $scoreData[$match->away_team_id]['p'] = $scoreData[$match->away_team_id]['p'] + 3;
                $scoreData[$match->away_team_id]['w'] = $scoreData[$match->away_team_id]['w'] + 1;
                $scoreData[$match->away_team_id]['gf'] = $scoreData[$match->away_team_id]['gf'] + $match->away_score;


                $scoreData[$match->home_team_id]['l'] = $scoreData[$match->home_team_id]['l'] + 1;
                $scoreData[$match->away_team_id]['ga'] = $scoreData[$match->away_team_id]['ga'] + $match->home_score;
            }
            if ($match->home_score == $match->away_score) {
                $scoreData[$match->home_team_id]['p'] = $scoreData[$match->home_team_id]['p'] + 1;
                $scoreData[$match->away_team_id]['p'] = $scoreData[$match->away_team_id]['p'] + 1;

                $scoreData[$match->home_team_id]['d'] = $scoreData[$match->home_team_id]['d'] + 1;
                $scoreData[$match->away_team_id]['d'] = $scoreData[$match->away_team_id]['d'] + 1;
            }
        }

        //sory by points
        usort($scoreData, function ($a, $b) {
            return $a['p'] < $b['p'];
        });
        return $scoreData;
    }

    /**
     * @return void
     */
    public function resetData()
    {
        Fixture::query()->delete();
    }

    /**
     * @return array
     */
    public function calculateChampPercentage(): array
    {
        $lastPlayedMatch= Fixture::where('is_played',true)->orderBy('week','DESC')->get()->first();
        $unPlayedLastMatch = Fixture::where('is_played',false)->orderBy('week','DESC')->get()->first();
        $scoreBoardData = $this->calculateScoreBoard();
        $prediction = [];
        $checkedPointTable = [];

        //if league is continue
        if($lastPlayedMatch && $unPlayedLastMatch) {
            $weekDiff = $unPlayedLastMatch->week - $lastPlayedMatch->week;
            if($weekDiff > 3){
                return [];
            }

            $maxPoint = $scoreBoardData[0]['p'];
            foreach ($scoreBoardData as $team){
                $temp = $team;
                $temp['p'] = $temp['p'] + 1;
                if($team['p'] + (3*$weekDiff) < $maxPoint) {
                    $temp['p'] = 0;
                }
                $checkedPointTable[] = $temp;
            }
            $totalPoint = array_sum(array_column($checkedPointTable,'p'));
            foreach ($checkedPointTable as $team){
                $temp = [
                    'team_name' => $team['team_name'],
                    'percent' => ($team['p'] / $totalPoint) * 100
                ];
                $prediction[] = $temp;
            }


        }else{
            foreach ($scoreBoardData as $key => $team){

                if($key == 0){
                    $temp = [
                        'team_name' => $team['team_name'],
                        'percent' => 100
                    ];
                }else{
                    $temp = [
                        'team_name' => $team['team_name'],
                        'percent' => 0
                    ];
                }
                $prediction[] = $temp;
            }
        }

        return $prediction;
    }
}
