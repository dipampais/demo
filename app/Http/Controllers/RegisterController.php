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


        $emailExists = \DB::table('users')->select('email')->where('email',$request->email)->count();

       if($emailExists>1)
        {
            return view('register.index')->with('error','Email already exists, please register with new email');
        }
        else 
        {
            $image = $request->file('profilePhoto');
            $input['imagename'] = time().'.'.$image->getClientOriginalExtension();
            if (!file_exists(public_path('/thumbnail'))) {
                mkdir (public_path('/thumbnail'), 0755);
            }
            $destinationPath = public_path('/thumbnail');
            $img = Image::make($image->getRealPath());

            
            $destinationPath = public_path('/images');
            $image->move($destinationPath, $input['imagename']);
            

            $img = imagecreatefromjpeg($destinationPath.'/'.$input['imagename']);   // load the image-to-be-saved

           
            imagejpeg($img, $destinationPath.'/'.$input['imagename'],50);

           
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

    public function compressImage($source, $destination, $quality) { 
        // Get image info 
        
        $imgInfo = getimagesize($source); 
        
        $mime = $imgInfo['mime']; 
        
        // Create a new image from file 
        switch($mime){ 
            case 'image/jpeg': 
                $image = imagecreatefromjpeg($source); 
                break; 
            case 'image/jpg': 
                $image = imagecreatefromjpeg($source); 
                break;     
            case 'image/png': 
                $image = imagecreatefrompng($source); 
                break; 
            case 'image/gif': 
                $image = imagecreatefromgif($source); 
                break; 
            default: 
                $image = imagecreatefromjpeg($source); 
        } 
         
        // Save image 


        imagejpeg($image, $destination, $quality); 
         
        // Return compressed image 
        return $destination; 
    } 

}