<?php

namespace App\Http\Controllers\Auth\Admin;


use Illuminate\Http\Request;
use App\Services\DataService;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    protected $dataService;

    public function __construct(DataService $dataService)
    {
        $this->dataService = $dataService;
    }

    public function home()
    {
        $data = $this->dataService->getAllData();
dd($data);
        return view('admin/home',compact('data'));
     }
}
