<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Gate;
use App\Models\Site;

class AgentController extends Controller
{
    public function index(){
        $agents = Agent::all();
        return view('agent.index', ["agents" => $agents]);
    }
    public function create(){
        $sites = Site::all();
        return view('agent.create', ["sites" => $sites] );
    }
    public function store(Request $request){
        $data = $request->validate([
            "numAgent" => "required|unique:agents,numAgent",
            "nomAgent" => "required",
            "prenomAgent" => "required",
            "site_id" => "required"
        ], [
            "numAgent.required" => "Le numéro de l'agent est requis",
            "numAgent.unique" => "Le numéro de l'agent doit être unique",
            "nomAgent.required" => "Le nom de l'agent est requis",
            "prenomAgent.required" => "Le prénom de l'agent est requis",
            "site_id.required" => "Le site de l'agent est requis"
        ]);
        Agent::create($data);
        return redirect()->route('agent.index')->with("success","Agent crée avec succès");
     }
    public function edit(Agent $agent){
        if(Gate::denies('see-agent',$agent)){
            abort(403,"Tu n'as pas l'autorisation d'accéder sur cette page");
        }
        return view('agent.edit', ["agent" => $agent]);
    }

    public function update(Agent $agent,Request $request){
        if(Gate::denies('see-agent',$agent)){
            abort(403,"Tu n'as pas l'autorisation d'accéder sur cette page");
        }
        $data = $request->validate([
            "numAgent" => ["required",Rule::unique('agents','numAgent')->ignore($agent->id)],
            "nomAgent" => "required",
            "prenomAgent" => "required",
            "site_id" => "required"
        ], [
            "numAgent.required" => "Le numéro de l'agent est requis",
            "numAgent.unique" => "Le numéro de l'agent doit être unique",
            "nomAgent.required" => "Le nom de l'agent est requis",
            "prenomAgent.required" => "Le prénom de l'agent est requis",
            "site_id.required" => "Le site de l'agent est requis"
        ]);
        $agent->update($data);
        return redirect()->route('agent.index')->with('success','Agent modifié avec succès');
    }
    public function destroy(Agent $agent){
        if(Gate::denies('see-agent',$agent)){
            abort(403,"Tu n'as pas l'autorisation d'accéder sur cette page");
        }
        $agent->delete();
        return redirect()->route('agent.index')->with('success','Agent supprimé avec succès');
    }
}
