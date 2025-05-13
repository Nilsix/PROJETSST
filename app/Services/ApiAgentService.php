<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ApiAgentService
{
    private string $token = 'E3rsyX3gtpOb0EiUW5NuYSu55dAxDs8N';

    public function getAllSites(): array
    {
        $sites = [];
        $alreadyProcessed = [];

        for ($i = 10000000; $i <= 10000100; $i++) { // <-- Limite pour tester !
            $numAgent = 'UR' . str_pad($i, 8, '0', STR_PAD_LEFT);

            $response = Http::withOptions(['verify' => false])->get('https://solo.urssaf.recouv/orchestra/api/', [
                'token' => $this->token,
                'type' => 'ldap',
                'agent' => $numAgent
            ]);

            $data = $response->json();

            if (!empty($data) && isset($data[0]['sitename'])) {
                $siteName = $data[0]['sitename'];

                if (!in_array($siteName, $alreadyProcessed)) {
                    $alreadyProcessed[] = $siteName;
                    $sites[] = [
                        'code' => $data[0]['sitecode'],
                        'name' => $siteName
                    ];
                }
            }
        }

        return $sites;
    }
}
