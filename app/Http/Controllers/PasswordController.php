<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PasswordController extends Controller
{
    
public function editPassword(Request $request)
{
    return view('passwordEdit');
}
public function updatePassword(Request $request)
{
    $request->validate([
        'current_password' => 'required',
        'new_password' => 'required|confirmed|min:8',
    ]);
// die;
    // Vérifie quel guard est utilisé et récupère l'utilisateur connecté
    if (auth('admin')->check()) {
        $user = auth('admin')->user();
    } elseif (auth('enseignant')->check()) {
        $user = auth('enseignant')->user();
    } else {
        $user = auth('etudiant')->user();
    }

    // Vérifie que le mot de passe actuel correspond
    if (!\Hash::check($request->current_password, $user->password)) {
        return back()->withErrors(['current_password' => 'Le mot de passe actuel est incorrect.']);
    }

    // Modifie le mot de passe
    $user->update([
        'password' => \Hash::make(trim($request->new_password)),

    ]);

    return back()->with('success', 'Mot de passe mis à jour avec succès !');
}

}
