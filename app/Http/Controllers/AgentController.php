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
    /**
     * Affiche la liste des agents
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $agents = Agent::all();
        $agentsList = [];
        $user = auth()->user(); 
        $userNum = $user->numAgent;
        
        \Log::info('num user var : '.$userNum);
        
        $token = 'E3rsyX3gtpOb0EiUW5NuYSu55dAxDs8N';
        $apiSite = "site random";

        try {
            // Récupération des informations de l'utilisateur connecté
            $response = Http::withOptions([
                'verify' => false
            ])->get('https://solo.urssaf.recouv/orchestra/api/', [
                'token' => $token,
                'type' => 'ldap',
                'agent' => $userNum
            ]);

            if ($response->successful() && !empty($response->json())) {
                \Log::info('API request successful', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                    'json' => $response->json()
                ]);
                
                $data = $response->json()[0];
                $apiSite = $data['sitename'];
            } else {
                \Log::error('API request failed', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
            }
        } catch (\Exception $e) {
            \Log::error('API request exception:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }

        // Récupération des informations pour chaque agent
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
                    //\Log::info('Agent data from API:', ['data' => $agentData]);
                    
                    $agentsList[] = [
                        'numAgent' => $agentData['numagent'],
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

        \Log::info('num user : '.$user->numAgent);
        $userSite = $apiSite;
        
        // Debug: Vérifier la structure des données
        uasort($agentsList, function($a, $b){
            return $a['sitename'] <=> $b['sitename'];
        });
        
        return view('agent.index', compact('agentsList', 'user', 'userSite'));
    }

    /**
     * Affiche le formulaire de création d'un nouvel agent
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $user = auth()->user();
        return view('agent.create', ["user" => $user]);
    }

    /**
     * Enregistre un nouvel agent
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
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
        $userSite = $this->returnUserSite();
        if (Gate::denies('see-agent', [$agent,$userSite])) {
            abort(403, "Tu n'as pas l'autorisation d'accéder sur cette page");
        }
        return view('agent.edit', ["agent" => $agent]);
    }

  

    public function update($id, Request $request)
    {
        $agent = Agent::findOrFail($id);
        $data = $request->validate([
            "certification" => "required",
        ]);
        $agent->update($data);
        return redirect()->route('agent.index')->with('success', 'Agent mis à jour avec succès');
    }

    public function destroy($id)
    {
        $agent = Agent::findOrFail($id);
        $userSite = $this->returnUserSite();
        if (Gate::denies('see-agent',[$agent,$userSite])) {
            abort(403, "Tu n'as pas l'autorisation d'accéder sur cette page");
        }
        $agent->delete();
        return redirect()->route('agent.index')->with('success', 'Agent supprimé avec succès');
    }

    public function show($id)
    {
        $agent = Agent::findOrFail($id);
        $agentData;
        $userSite = $this->returnUserSite();
        if(Gate::denies('see-agent', [$agent,$userSite])){
            abort(403, "Tu n'as pas l'autorisation d'accéder sur cette page");
        }
        try{
            $response = Http::withOptions([
                'verify' => false
            ])->get('https://solo.urssaf.recouv/orchestra/api/', [
                'token' => "E3rsyX3gtpOb0EiUW5NuYSu55dAxDs8N",
                'type' => 'ldap',
                'agent' => $agent->numAgent
            ]);
            if ($response->successful() && !empty($response->json())) {
                $data = $response->json()[0];
                $agentData = [
                    'numAgent' => $data['numagent'],
                    'sitename' => $data["sitename"] ?? null,
                    'nom' => $data['nom'] ?? null,
                    'prenom' => $data['prenom'] ?? null,
                    'email' => $data['email'] ?? null,
                    'jobname' => $data['jobname'] ?? null,
                    'servicename' => $data['servicename'] ?? null,
                    'certification' => $agent->certification,
                    'id' => $agent->id
                ];
                
            }
        }catch(Exception $e){
            
        }
        return view('agent.show', ["agent" => $agentData]);
    }

    //Retourne le site de l'utilisateur
    public function returnUserSite(){
        $user = auth()->user();
        $userSite;
        try {
            $response = Http::withOptions([
                'verify' => false
            ])->get('https://solo.urssaf.recouv/orchestra/api/', [
                'token' => "E3rsyX3gtpOb0EiUW5NuYSu55dAxDs8N",
                'type' => 'ldap',
                'agent' => $user->numAgent
            ]);

            if ($response->successful() && !empty($response->json())) {
                $data = $response->json()[0];
                $userSite = $data['sitename'];
            } else {
                $userSite = null;
            }
        } catch (Exception $e) {
            $userSite = null;
        }
        return $userSite;
    }
}
