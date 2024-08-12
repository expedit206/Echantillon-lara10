<?php

namespace App\Http\Controllers;

use App\Models\Etudiant;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function allStudents()
    {

        $students = Etudiant::latest()->paginate(10);
        $total = $students->count();

        return view('admin.students', compact('students'));
     }
}
