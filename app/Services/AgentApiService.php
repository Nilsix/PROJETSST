<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Exception;

class AgentApiService
{
    private const API_URL = 'https://solo.urssaf.recouv/orchestra/api/';
    private const TOKEN = 'E3rsyX3gtpOb0EiUW5NuYSu55dAxDs8N';

    public function getAgent(string $numAgent)
    {
        try {
            $response = Http::withOptions([
                'verify' => false
            ])->get(self::API_URL, [
                'token' => self::TOKEN,
                'type' => 'ldap',
                'agent' => $numAgent
            ]);

            if ($response->successful() && !empty($response->json())) {
                return $response->json()[0];
            }
            
            return null;
        } catch (Exception $e) {
            return null;
        }
    }

    public function getValidAgents(int $count = 10)
    {
        $validAgents = [];
        $attempts = 0;
        
        while (count($validAgents) < $count && $attempts < 100) {
            // Générer un numéro d'agent aléatoire (format URXXXXXXX)
            $numAgent = 'UR' . str_pad(rand(1000000, 9999999), 7, '0', STR_PAD_LEFT);
            
            $agent = $this->getAgent($numAgent);
            
            if ($agent !== null) {
                $validAgents[] = [
                    'numAgent' => $numAgent,
                    'data' => $agent
                ];
            }
            
            $attempts++;
        }
        
        return $validAgents;
    }
}
