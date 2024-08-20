<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Annee;

class AnneeController extends Controller
{
    public function setActive(Request $request){
               \DB::table('annees')->update(['is_active'=>false]);
       \DB::table('annees')->where('id', $request->input('annee'))->update(['is_active'=>true]);
       return redirect()->back();
    //    return redirect()->route('students');

        die;
    }
}
