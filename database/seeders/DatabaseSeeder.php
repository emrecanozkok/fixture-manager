<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Here we are creating a collection of 1 Team models
        $teams = \App\Models\Team::factory()->count(4)->create();


        $teams->each(function($team) {
            $teamSpec = \App\Models\TeamSpec::factory()->count(1)->make();
            $team->specs()->create($teamSpec->first()->toArray());
        });
    }
}
