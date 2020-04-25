<?php

namespace App\Http\Controllers;

use App\Login;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class LoginController extends Controller
{

    public function __construct()
    {
        
    }

    public function index()
    {
        $id = Auth::id();
        if(!empty($id))
        {
            return redirect()->route('route.dashboard');
        }
        else {
            return view('login.index');
        }
    }
    

    public function authenticate(Request $request)
    {

        $request->validate([
            'email' => ['required','email:rfc,dns'],
            'password' => ['required','min:8'], 
        ]);

        
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            //return view('dashboard.index');
            return redirect()->route('route.dashboard');
        }
        else {
            return view('login.index')->with('error','Please enter valid credentials');
        }
    }


    public function resetPassword(){
        return view('login.reset');
    }


    public function changePassword(Request $request){
        $request->validate([
            'email' => ['required','email:rfc,dns'],
            'password' => ['required','min:8'], 
            'password_confirmation' => ['required','min:8'], 
        ]);
        if($request->password != $request->password_confirmation)
        {
            return view('login.reset')->with('error','Password and Confirm Password does not match');
        }
        $email = $request->email;
        $password = Hash::make($request->password);
        $update = [
            'email'=>$email,
            'password'=>$password,
        ];
        $update = \DB::table('users')->where('email',$email)->update($update); 
        if($update)
        {
            return view('login.index');
        }
        else {
            return view('login.reset')->with('error','Email Address does not exist');
        }
    }

}