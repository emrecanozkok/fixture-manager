<?php

namespace App\Services;

use App\Models\Fixture;
use App\Models\Tournament;
use Illuminate\Database\Eloquent\Collection;

class FixtureService
{
    /**
     * @param Collection $teams
     * @return array
     */
    public function generateFixture(Collection $teams) : array
    {
        $teamCount = $teams->count();
        $tempFixture = collect();
        foreach ($teams as $teamFirst) {
            foreach ($teams as $teamSecond) {
                if ($teamFirst->id != $teamSecond->id) {
                    $tempFixture->add(collect([
                        'home_team_id' => $teamFirst->id,
                        'away_team_id' => $teamSecond->id
                    ]));
                }
            }
        }
        $tempFixture=$tempFixture->shuffle();
        $fixture = array();
        for ($i = 1; $i <= ($teamCount * ($teamCount - 1) / config('constants.match_per_week')); $i++) {
            foreach ($tempFixture as $fixtureKey => $fixtureMatch) {
                $week = sprintf('week_%d', $i);
                $fixtureMatch['week'] = $i;
                if (!isset($fixture[$week])) {
                    $fixture[$week] = [];
                    $fixture[$week]['games'][] = $fixtureMatch;
                    $fixture[$week]['gamer_teams'][] = $fixtureMatch['home_team_id'];
                    $fixture[$week]['gamer_teams'][] = $fixtureMatch['away_team_id'];
                    $tempFixture->forget($fixtureKey);
                } else {
                    if (!count(
                        array_intersect(
                            array_values($fixture[$week]['gamer_teams']),
                            array_values([$fixtureMatch['home_team_id'], $fixtureMatch['away_team_id']])
                        )
                        ) > 0) {
                        $fixture[$week]['games'][] = $fixtureMatch;
                        $fixture[$week]['gamer_teams'][] = $fixtureMatch['home_team_id'];
                        $fixture[$week]['gamer_teams'][] = $fixtureMatch['away_team_id'];
                        $tempFixture->forget($fixtureKey);
                    }
                }

                if (count($fixture[$week]['games']) == config('constants.match_per_week')) {
                    break;
                }
            }
        }

        return $fixture;
    }

    /**
     * @return boolean
     */
    public function checkFixtureHasGenerated(): bool
    {
        return Fixture::exists();
    }
}
