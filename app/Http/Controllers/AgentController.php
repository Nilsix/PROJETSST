<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Http;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;


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
        $userNum = auth()->user()->numAgent;    
        // Récupération des informations pour chaque agent
        foreach ($agents as $agent) { 
            $agentsList[] = $this->callAgentApi($agent->id,$agent->numAgent);
        }

        $userSite = $this->returnUserSite();
        // Debug: Vérifier la structure des données
        uasort($agentsList, function($a, $b){
            return $a['sitename'] <=> $b['sitename'];
        });
        return view('agent.index', compact('agentsList','userSite'));
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
        try{
        $data = $request->validate([
            "numAgent" => "required|unique:agents,numAgent|size:10",
        ], [
            "numAgent.required" => "Le numéro de l'agent est requis",
            "numAgent.size" => "Le numéro de l'agent doit contenir exactement 10 caractères"
        ]);
        $numAgent = $data["numAgent"];
            // Vérifier si l'agent existe déjà dans la base de données
            $existingAgent = Agent::where('numAgent', $numAgent)->first();
            if ($existingAgent) {
                throw new \Exception('Cet agent existe déjà dans la base de données');
            }
            $agent = $this->callAgentApi(0,$numAgent);
            $userSite = $this->returnUserSite();
            if(Gate::denies('see-agent', [$agent["sitename"],$userSite])){
                return redirect()->route('agent.index')->with('error', 'Vous n\'avez pas l\'autorisation d\'ajouter un agent de ce site');
            }
            Agent::create([
                "numAgent" => $numAgent,
            ]);
            return redirect()->route('agent.index')->with('success', 'Agent ajouté avec succès');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function edit($id)
    {
        $agent = Agent::findOrFail($id);
        $agentAPI = $this->callAgentApi($id,$agent->numAgent);
        $userSite = $this->returnUserSite();
        if (Gate::denies('see-agent', [$agentAPI["sitename"],$userSite])) {
            return redirect()->route('agent.index')->with('error', 'Tu n\'as pas l\'autorisation d\'accéder sur cette page');
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
        $agentAPI = $this->callAgentApi($id,$agent->numAgent);
        $userSite = $this->returnUserSite();
        if (Gate::denies('see-agent',[$agentAPI["sitename"],$userSite])) {
            return redirect()->route('agent.index')->with('error', 'Tu n\'as pas l\'autorisation d\'accéder sur cette page');
        }
        $agent->delete();
        return redirect()->route('agent.index')->with('success', 'Agent supprimé avec succès');
    }

    public function show($id)
    {
        $userSite = $this->returnUserSite();
        $agent = Agent::findOrFail($id);
        $agentAPI = $this->callAgentApi($id,$agent->numAgent);
        if (Gate::denies('see-agent',[$agentAPI["sitename"],$userSite])) {
            abort(403, "Tu n'as pas l'autorisation d'accéder sur cette page");
        }
        $agentData = $this->callAgentApi($id,$agent->numAgent);
        return view('agent.show', ["agent" => $agentData]);
    }

    

public static function callAgentApi($id, $numAgent)
{
    return Cache::remember("agent_api_{$numAgent}", 300, function () use ($id, $numAgent) {
        try {
            $response = Http::withOptions([
                'verify' => false
            ])->get('https://solo.urssaf.recouv/orchestra/api/', [
                'token' => "E3rsyX3gtpOb0EiUW5NuYSu55dAxDs8N",
                'type' => 'ldap',
                'agent' => $numAgent
            ]);
            if ($response->successful() && !empty($response->json())) {
                $data = $response->json()[0];
                $data['id'] = $id;
                return $data;
            }
        } catch (Exception $e) {
            Log::error("Erreur appel API pour agent $numAgent : ".$e->getMessage());
        }
        return null;
    });
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
