<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Agent;
use App\Models\Site;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Agent>
 */
class AgentFactory extends Factory
{
    protected $model = Agent::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'numAgent' => $this->faker->unique()->bothify('??-??-??'),
            'nomAgent' => $this->faker->name(),
            'prenomAgent' => $this->faker->name(),
            'site_id' => $this->faker->randomElement(Site::all()->pluck('id')),
        ];
    }
}
