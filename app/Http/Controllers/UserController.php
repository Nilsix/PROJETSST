<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = \App\Models\User::with('site')->get();
        return view('user.index', compact('users'));
    }

    public function create()
    {
        $sites = \App\Models\Site::all();
        return view('user.create', compact('sites'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'vision' => 'required|integer|min:1|max:3',
            'site_id' => 'nullable|exists:sites,id',
        ]);
        $validated['password'] = bcrypt($validated['password']);
        \App\Models\User::create($validated);
        return redirect()->route('user.index')->with('success', 'Utilisateur créé avec succès');
    }

    public function edit($id)
    {
        $user = \App\Models\User::findOrFail($id);
        $sites = \App\Models\Site::all();
        return view('user.edit', compact('user', 'sites'));
    }

    public function update(Request $request, $id)
    {
        $user = \App\Models\User::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6',
            'vision' => 'required|integer|min:1|max:3',
            'site_id' => 'nullable|exists:sites,id',
        ]);
        if (!empty($validated['password'])) {
            $validated['password'] = bcrypt($validated['password']);
        } else {
            unset($validated['password']);
        }
        $user->update($validated);
        return redirect()->route('user.index')->with('success', 'Utilisateur modifié avec succès');
    }

    public function destroy($id)
    {
        $user = \App\Models\User::findOrFail($id);
        $user->delete();
        return redirect()->route('user.index')->with('success', 'Utilisateur supprimé avec succès');
    }
}
