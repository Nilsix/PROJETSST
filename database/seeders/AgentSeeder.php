<?php

namespace Database\Seeders;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Seeder;
use App\Models\Agent;
use Exception;
use Illuminate\Support\Facades\Http;

class AgentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer 10 agents valides
        $json = file_get_contents(public_path('protection.sst.json'));
        $agents = json_decode($json, true);
        $token = 'E3rsyX3gtpOb0EiUW5NuYSu55dAxDs8N';
        foreach ($agents as $agent) {
            try {
                $response = Http::withOptions([
                    'verify' => false
                ])->get('https://solo.urssaf.recouv/orchestra/api/', [
                    'token' => $token,
                    'type' => 'ldap',
                    'agent' => $agent['numagent']
                ]);

                if ($response->successful()) {
                    $agentData = $response->json()[0];
                    Agent::updateOrCreate([
                        'numAgent' => $agent['numagent'],
                        'certification' => 3
                    ]);
                } else {
                    // Création ou mise à jour de l'agent si la requête échoue
                    Agent::updateOrCreate([
                        'numAgent' => $agent['numagent'],
                        'certification' => 3
                    ]);
                }
            } catch (Exception $e) {
                // Gestion des exceptions
            }
        }
    }
}