<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Agent;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AgentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer 10 agents valides depuis l'API
        $factory = new \Database\Factories\AgentFactory();
        $agents = $factory->createValidAgents(10);
    }
}
