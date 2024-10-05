<?php

namespace App\Http\Controllers;

use App\Models\Admin;
// use App\Models\Etudiant;
use Illuminate\Http\Request;

class AdminController extends Controller
{
public function show(Admin $admin)
{
    $admin = \Auth::guard('admin')->user();// Récupérer l'utilisateur admin connecté
    return view('admin.show', compact('admin')); 
}


}
