<?php

namespace App\Http\Controllers;

use App\Register;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class DashboardController extends Controller
{
    public function __construct()
    {
        
    }

    public function index()
    {
         $user = \Auth::user();
         if($user)
         {
            return view('dashboard.index');
         }
         else {
            return redirect('/');
         }
    }
}