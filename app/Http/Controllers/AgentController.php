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

        foreach ($agents as $agent) {
            $numAgent = $agent->numAgent;
            $token = 'E3rsyX3gtpOb0EiUW5NuYSu55dAxDs8N';

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
                        'nomSite' => $agentData["sitename"] ?? null,
                        'nom' => $agentData['nom'] ?? null,
                        'prenom' => $agentData['prenom'] ?? null,
                        'email' => $agentData['email'] ?? null,
                        'fonction' => $agentData['fonction'] ?? null
                    ];
                } else {
                    $agentsList[] = [
                        'numAgent' => $numAgent,
                        'nomSite' => $agent->nomSite,
                        'nom' => null,
                        'prenom' => null,
                        'email' => null,
                        'fonction' => null
                    ];
                }
            } catch (Exception $e) {
                // En cas d'erreur, on conserve les données de base
                $agentsList[] = [
                    'numAgent' => $numAgent,
                    'nomSite' => $agent->nomSite,
                    'nom' => null,
                    'prenom' => null,
                    'email' => null,
                    'fonction' => null
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

            if ($response->successful() && !empty($response->json())) {
                $agent = $response->json()[0];
                Agent::create([
                    "numAgent" => $numAgent
                ]);
                return redirect()->route('agent.index')->with('success', 'Agent ajouté avec succès');
            }

            return back()->with('error', 'Le numéro d\'agent n\'est pas valide ou ne correspond à aucun agent existant');
        } catch (Exception $e) {
            return back()->with('error', 'Erreur lors de la récupération des données de l\'agent');
        }
    }

    public function edit(Agent $agent)
    {
        if (Gate::denies('see-agent', $agent)) {
            abort(403, "Tu n'as pas l'autorisation d'accéder sur cette page");
        }
        return view('agent.edit', ["agent" => $agent]);
    }

    public function update(Agent $agent, Request $request)
    {
        if (Gate::denies('see-agent', $agent)) {
            abort(403, "Tu n'as pas l'autorisation d'accéder sur cette page");
        }
        $data = $request->validate([
            "numAgent" => ["required", Rule::unique('agents', 'numAgent')->ignore($agent->id), "size:10"],
            "nomAgent" => "required",
            "prenomAgent" => "required",
            "site_id" => "required"
        ], [
            "numAgent.required" => "Le numéro de l'agent est requis",
            "numAgent.unique" => "Le numéro de l'agent doit être unique",
            "numAgent.size" => "Le numéro de l'agent doit contenir exactement 10 caractères",
            "nomAgent.required" => "Le nom de l'agent est requis",
            "prenomAgent.required" => "Le prénom de l'agent est requis",
            "site_id.required" => "Le site de l'agent est requis"
        ]);
        $agent->update($data);
        return redirect()->route('agent.index')->with('success', 'Agent modifié avec succès');
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
