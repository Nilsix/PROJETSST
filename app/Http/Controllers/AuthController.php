<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Hash;
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
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $email = $request->input('email');

        // Vérifier si l'utilisateur existe déjà
        $user = User::where('email', $email)->first();

        if (!$user) {
            return back()->withErrors([
                'email' => 'Cet email n\'est pas enregistré.',
            ])->onlyInput('email');
        }

        // Vérifier le mot de passe
        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'email' => 'Le mot de passe est incorrect.',
            ])->onlyInput('email');
        }

                if (Auth::attempt(['email' => $email, 'password' => $request->password])) {
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
