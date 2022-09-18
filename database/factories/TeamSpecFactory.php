<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TeamSpec>
 */
class TeamSpecFactory extends Factory
{

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Models\TeamSpec::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'away_power' => rand(0,255),
            'goolkeeper_power' => rand(0,255),
            'supporter_power' => rand(0,255),
            'home_power' => rand(0,255),
        ];
    }
}
