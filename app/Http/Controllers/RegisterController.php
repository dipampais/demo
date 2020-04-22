<?php

namespace App\Http\Controllers;

use App\Register;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class RegisterController extends Controller
{

    public function __construct()
    {
        
    }

    public function index()
    {
        return view('register.index');
    }
    

    public function registerUser(Request $request){
        $request->validate([
            'name' => ['required','min:3'],
            'email' => ['required','email:rfc,dns'],
            'password' => ['required','min:8'], 
            'password_confirmation' => ['required','min:8'], 
        ]);

        if($request->password != $request->password_confirmation)
        {
            return view('register.index')->with('error','Password and Confirm Password does not match');
        }

        $insert = \DB::table('users')->insert(
            [
                'name' => $request->name, 
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'created_at' => \DB::raw('now()')
            ]
        );
        return view('login.index')->with('success','User Account Created Successfully');
    }

}