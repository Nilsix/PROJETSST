<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Agent;
use App\Services\AgentApiService;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Agent>
 */
class AgentFactory extends Factory
{
    protected $model = Agent::class;
    
    private AgentApiService $agentApiService;

    public function __construct()
    {
        $this->agentApiService = new AgentApiService();
    }

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'numAgent' => $this->faker->unique()->bothify('UR???????'),
        ];
    }

    /**
     * Crée un nombre spécifié d'agents valides depuis l'API
     *
     * @param int $count Nombre d'agents à créer
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function createValidAgents(int $count = 10)
    {
        $validAgents = $this->agentApiService->getValidAgents($count);
        
        return collect($validAgents)->map(function ($agent) {
            return Agent::create([
                'numAgent' => $agent['numAgent']
            ]);
        });
    }
}
