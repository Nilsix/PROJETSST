<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Agent;
use Illuminate\Support\Facades\Http;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    
    public function index()
    {
        if(Gate::denies('manage-users')){
            return redirect()->route('agent.index')->with('error', 'Tu n\'as pas l\'autorisation d\'accéder sur cette page');
        }
        $users = User::all();
        return view('user.index', compact('users'));
    }

    public function create()
    {
        $agents = Agent::all();
        $agentsList = [];
        foreach ($agents as $agent) {
            $agentsList[] = AgentController::callAgentApi($agent->id,$agent->numAgent);
        }

        return view('user.create', compact('agentsList'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'numAgent' => 'required',
            'password' => 'required|string|min:8',
            'vision' => 'required|integer|min:1|max:3',
        ]);
       
        $token = 'E3rsyX3gtpOb0EiUW5NuYSu55dAxDs8N';
        $response = Http::withOptions([
            'verify' => false
        ])->get('https://solo.urssaf.recouv/orchestra/api/', [
            'token' => $token,
            'type' => 'ldap',
            'agent' => $validated['numAgent']
        ]);
        if ($response->successful() && !empty($response->json())) {
            $agentData = $response->json()[0];
            $validated['password'] = bcrypt($validated['password']);
            $validated['name'] = $agentData['nom'].' '.$agentData['prenom'];
            $validated['email'] = $agentData['email'];
            User::create($validated);
        } else {
            return redirect()->back()->with('error', 'Agent non trouvé');
        }
        
        return redirect()->route('user.index')->with('success', 'Utilisateur créé avec succès');
     }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('user.edit', compact('user'));
    }
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $validated = $request->validate([
            'vision' => 'required|integer|min:1|max:3',
        ]); 
        $user->update($validated);
        return redirect()->route('user.index')->with('success', 'Utilisateur mis à jour avec succès');
    }

    public function destroy($id)
    {
        $user = \App\Models\User::findOrFail($id);
        $user->delete();
        return redirect()->route('user.index')->with('success', 'Utilisateur supprimé avec succès');
    }
    
}
