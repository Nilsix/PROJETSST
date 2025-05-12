<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $request->validate([
            'numAgent' => 'required',
            'password' => 'required',
        ]);

        $token = 'E3rsyX3gtpOb0EiUW5NuYSu55dAxDs8N';
        $numAgent = $request->input('numAgent');

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

                // Vérifier si l'utilisateur existe déjà
                $user = User::where('numAgent', $numAgent)->first();

                if (!$user) {
                    // Créer un nouvel utilisateur
                    $user = User::create([
                        'numAgent' => $numAgent,
                        'password' => bcrypt($request->password),
                        'nomSite' => $agentData['sitename'] ?? null
                    ]);
                }

                if (Auth::attempt(['numAgent' => $numAgent, 'password' => $request->password])) {
                    $request->session()->regenerate();
                    return redirect()->intended('dashboard');
                }
            }

            return back()->withErrors([
                'numAgent' => 'Le numéro d\'agent ou le mot de passe est incorrect.',
            ])->onlyInput('numAgent');
        } catch (Exception $e) {
            Log::error('Erreur lors de l\'authentification:', ['error' => $e->getMessage()]);
            return back()->withErrors([
                'numAgent' => 'Une erreur est survenue lors de l\'authentification.',
            ])->onlyInput('numAgent');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
