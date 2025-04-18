<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AgentController extends Controller
{
    public function index(){
        $agents = Agent::all();
        return view('agent.index', ["agents" => $agents]);
    }
    public function create(){
        return view('agent.create');
    }
    public function store(Request $request){
        $data = $request->validate([
            "numAgent" => "required|unique:agents,numAgent",
            "nomAgent" => "required",
            "prenomAgent" => "required",
            "site" => "required"
        ], [
            "numAgent.required" => "Le numéro de l'agent est requis",
            "numAgent.unique" => "Le numéro de l'agent doit être unique",
            "nomAgent.required" => "Le nom de l'agent est requis",
            "prenomAgent.required" => "Le prénom de l'agent est requis",
            "site.required" => "Le site de l'agent est requis"
        ]);
        Agent::create($data);
        return redirect()->route('agent.index');
     }
    public function edit(Agent $agent){
        return view('agent.edit', ["agent" => $agent]);
    }

    public function update(Agent $agent,Request $request){
        $data = $request->validate([
            "numAgent" => ["required",Rule::unique('agents','numAgent')->ignore($agent->id)],
            "nomAgent" => "required",
            "prenomAgent" => "required",
            "site" => "required"
        ], [
            "numAgent.required" => "Le numéro de l'agent est requis",
            "numAgent.unique" => "Le numéro de l'agent doit être unique",
            "nomAgent.required" => "Le nom de l'agent est requis",
            "prenomAgent.required" => "Le prénom de l'agent est requis",
            "site.required" => "Le site de l'agent est requis"
        ]);
        $agent->update($data);
        return redirect()->route('agent.index')->with('success','Agent modifié avec succès');
    }
    public function destroy(Agent $agent){
        $agent->delete();
        return redirect()->route('agent.index')->with('success','Agent supprimé avec succès');
    }
}
