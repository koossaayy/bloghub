<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('profile.edit', ['user' => auth()->user()]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'name'   => 'required|max:255',
            'email'  => 'required|email|unique:users,email,' . auth()->id(),
            'bio'    => 'nullable|max:500',
            'avatar' => 'nullable|image|max:2048',
        ]);

        $data = [
            'name'  => $request->name,
            'email' => $request->email,
            'bio'   => $request->bio,
        ];

        if ($request->file('avatar')) {
            $data['avatar'] = $request->file('avatar')
                ->store('avatars', 'public');
        }

        auth()->user()->update($data);

        return back()->with('success', 'Profil mis à jour !');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password'         => 'required|min:8|confirmed',
        ]);

        if (!Hash::check($request->current_password, auth()->user()->password)) {
            return back()->withErrors(['current_password' => 'Mot de passe incorrect']);
        }

        auth()->user()->update([
            'password' => Hash::make($request->password)
        ]);

        return back()->with('success', 'Mot de passe mis à jour !');
    }

    public function destroy(Request $request)
    {
        $user = auth()->user();
        auth()->logout();
        $user->delete();

        return redirect('/')->with('success', 'Compte supprimé !');
    }
}