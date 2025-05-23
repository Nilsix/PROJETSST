<?php

namespace Database\Seeders;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Http;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $token = "E3rsyX3gtpOb0EiUW5NuYSu55dAxDs8N";
        $numAgent = "UR11701281";
        
        try {
            $response = Http::withOptions([
                'verify' => false
            ])->get('https://solo.urssaf.recouv/orchestra/api/', [
                'token' => $token,
                'type' => 'ldap',
                'agent' => $numAgent
            ]);

            if ($response->successful() && !empty($response->json())) {
                $data = $response->json()[0];
                
                // Vérifier si l'utilisateur existe déjà
                $user = User::where('email', $data['email'])->first();
                
                if (!$user) {
                    // Créer l'utilisateur seulement s'il n'existe pas
                    User::create([
                        "name" => $data['nom'] . " " . $data['prenom'],
                        "email" => $data['email'],
                        "password" => bcrypt("testtest"),
                        "vision" => 3,
                        "numAgent" => $data['numagent']
                    ]);
                    $this->command->info('Utilisateur créé avec succès.');
                } else {
                    $this->command->info('Un utilisateur avec cet email existe déjà.');
                }
            }
        } catch (\Exception $e) {
            $this->command->error('Erreur lors de la création de l\'utilisateur: ' . $e->getMessage());
        }
    }
}
