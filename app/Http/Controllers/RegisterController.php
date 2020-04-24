<?php

namespace App\Http\Controllers;

use App\Register;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Validator;
//use Illuminate\Intervention\Image\Image;

// use App\Http\Requests;
use Image;
//use Intervention\Image\Facades\Image;

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
        
        //dd($request->gender);
        $request->validate([
            'name' => ['required','min:3'],
            'email' => ['required','email:rfc,dns'],
            'password' => ['required','min:8'], 
            'password_confirmation' => ['required','min:8'], 
            'gender'       => 'required|in:0,1',
            'profilePhoto' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:3072',
        ]);
        
        


        if($request->password != $request->password_confirmation)
        {
            return view('register.index')->with('error','Password and Confirm Password does not match');
        }

        
        $image = $request->file('profilePhoto');
        $input['imagename'] = time().'.'.$image->getClientOriginalExtension();
        //dd(public_path('/thumbnail'));
        if (!file_exists(public_path('/thumbnail'))) {
            mkdir (public_path('/thumbnail'), 0755);
        }
        $destinationPath = public_path('/thumbnail');
        $img = Image::make($image->getRealPath());
        $img->resize(100, 100, function ($constraint) {
            $constraint->aspectRatio();
        })->save($destinationPath.'/'.$input['imagename']);
   
        $destinationPath = public_path('/images');
        $image->move($destinationPath, $input['imagename']);
   
        //$this->postImage->add($input);

        $insert = \DB::table('users')->insert(
            [
                'name' => $request->name, 
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'created_at' => \DB::raw('now()'),
                'gender'   => $request->gender, 
                'profilePhoto'   => $input['imagename'],
            ]
        );
        return view('login.index')->with('success','User Account Created Successfully');
    }

}