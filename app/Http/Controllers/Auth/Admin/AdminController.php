<?php

namespace App\Http\Controllers\Auth\Admin;


use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function home()
    {
        return view('admin/home');
     }
}
