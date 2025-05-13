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

    public function __construct(...$args)
    {
        parent::__construct(...$args); // Ne JAMAIS oublier ça en factory custom
        $this->agentApiService = new AgentApiService();
    }

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'numAgent' => $this->faker->unique()->regexify('UR[0-9]{8}')
        ];
    }

    public function state($state)
    {
        return parent::state($state);
    }
}
