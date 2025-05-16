<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Http;
use Exception;
use Illuminate\Support\Facades\Log;

class AgentController extends Controller
{
    public function index()
    {
        $agents = Agent::all();
        $agentsList = [];
        $user = auth()->user();
        $token = 'E3rsyX3gtpOb0EiUW5NuYSu55dAxDs8N';

        /*try{
            $response = Http::withOptions([
                'verify' => false ])->get('https://solo/urssaf/orchestra/api/', [
                    'token' => $token,
                    'type' => 'ldap',
                    'agent' => $user->numAgent
                ]);
            
        }catch(Exception $e){
            
        }*/
        foreach ($agents as $agent) {
            $numAgent = $agent->numAgent;
           
            try {
                $response = Http::withOptions([
                    'verify' => false
                ])->get('https://solo.urssaf.recouv/orchestra/api/', [
                    'token' => $token,
                    'type' => 'ldap',
                    'agent' => $numAgent
                ]);

                if ($response->successful() && !empty($response->json())) {
                    $agentData = $response->json()[0];
                    \Log::info('Agent data from API:', ['data' => $agentData]);
                    $agentsList[] = [
                        'numAgent' => $numAgent,
                        'sitename' => $agentData["sitename"] ?? null,
                        'nom' => $agentData['nom'] ?? null,
                        'prenom' => $agentData['prenom'] ?? null,
                        'email' => $agentData['email'] ?? null,
                        'fonction' => $agentData['fonction'] ?? null,
                        'certification' => $agent->certification,
                        'id' => $agent->id
                    ];
                } else {
                    $agentsList[] = [
                        'numAgent' => $numAgent,
                        'sitename' => $agent->sitename,
                        'nom' => null,
                        'prenom' => null,
                        'email' => null,
                        'fonction' => null,
                        'certification' => $agent->certification,
                        'id' => $agent->id
                    ];
                }
            } catch (Exception $e) {
                // En cas d'erreur, on conserve les données de base
                $agentsList[] = [
                    'numAgent' => $numAgent,
                    'sitename' => $agent->sitename,
                    'nom' => null,
                    'prenom' => null,
                    'email' => null,
                    'fonction' => null,
                    'certification' => $agent->certification,
                    'id' => $agent->id
                ];
            }
        }

        // Debug: Vérifier la structure des données
        \Log::info('Agents list:', ['agents' => $agentsList]);

        $user = auth()->user();
        return view('agent.index', compact('agentsList', 'user'));
    }

    public function create()
    {
        $user = auth()->user();
        return view('agent.create', ["user" => $user]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            "numAgent" => "required|unique:agents,numAgent|size:10",
            "certification" => "integer",
        ], [
            "numAgent.required" => "Le numéro de l'agent est requis",
            "numAgent.size" => "Le numéro de l'agent doit contenir exactement 10 caractères"
        ]);

        $numAgent = $request->input('numAgent');
        $token = 'E3rsyX3gtpOb0EiUW5NuYSu55dAxDs8N';

        try {
            $response = Http::withOptions([
                'verify' => false
            ])->get('https://solo.urssaf.recouv/orchestra/api/', [
                'token' => $token,
                'type' => 'ldap',
                'agent' => $numAgent
            ]);

            if (!$response->successful()) {
                throw new \Exception('Erreur lors de la communication avec l\'API: ' . $response->status());
            }

            $agentData = $response->json();
            if (empty($agentData)) {
                throw new \Exception('Agent non trouvé dans l\'API');
            }

            // Vérifier si l'agent existe déjà dans la base de données
            $existingAgent = Agent::where('numAgent', $numAgent)->first();
            if ($existingAgent) {
                throw new \Exception('Cet agent existe déjà dans la base de données');
            }

            $agent = $response->json()[0];
            Agent::create([
                "numAgent" => $numAgent,
                "certification" => $data["certification"]
            ]);
            return redirect()->route('agent.index')->with('success', 'Agent ajouté avec succès');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function edit($id)
    {
        $agent = Agent::findOrFail($id);
        if (Gate::denies('see-agent', $agent)) {
            abort(403, "Tu n'as pas l'autorisation d'accéder sur cette page");
        }
        return view('agent.edit', ["agent" => $agent]);
    }

    public function update($id, Request $request)
    {
        $agent = Agent::findOrFail($id);
        if (Gate::denies('see-agent', $agent)) {
            abort(403, "Tu n'as pas l'autorisation d'accéder sur cette page");
        }
        $data = $request->validate([
            "certification" => "required",
        ]);

        $agent->update($data);
        return redirect()->route('agent.index')->with('success', 'Agent mis à jour avec succès');
    }

    public function destroy(Agent $agent)
    {
        if (Gate::denies('see-agent', $agent)) {
            abort(403, "Tu n'as pas l'autorisation d'accéder sur cette page");
        }
        $agent->delete();
        return redirect()->route('agent.index')->with('success', 'Agent supprimé avec succès');
    }
}
