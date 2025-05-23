<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Agent;
use Illuminate\Support\Facades\Http;
use App\Models\User;

class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = \App\Models\User::all();
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
        $user = \App\Models\User::findOrFail($id);
        return view('user.edit', compact('user'));
    }
    public function update(Request $request, $id)
    {
        $user = \App\Models\User::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6',
            'vision' => 'required|integer|min:1|max:3',
            'nomSite' => 'nullable|string|max:255',
        ]);
        
        // Seulement si un nouveau mot de passe est fourni
        if ($request->filled('password')) {
            $validated['password'] = bcrypt($validated['password']);
        } else {
            unset($validated['password']);
        }
        
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
