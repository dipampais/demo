<?php

namespace App\Http\Controllers;

use App\Register;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
//use Illuminate\Validation\Validator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\URL;
use Image;

class ProfileController extends Controller
{

    public function __construct()
    {
    }

    public function index()
    {
    }

    public function editProfile(){
        $user = Auth::user();
        $userData['data'] = \DB::table('users')->where('id',$user->id)->first();
      
        $userData['profileImageFullPath'] = public_path('/images').'/'.$userData['data']->profilePhoto;
        return view('profile.edit',$userData);
    }


    public function updateProfile(Request $request){


        $request->validate([
            'name'  => ['required','min:3'],
            'email' => ['required','email:rfc,dns'],
            'gender'=> 'required|in:0,1',
            'passoword' => 'min:8',
        ]);


        
        
        
        $userData['data'] = \DB::table('users')->where('id',$request->userId)->first();
      
        $userData['profileImageFullPath'] = public_path('/images').'/'.$userData['data']->profilePhoto;
       
       
        if($request->password != $request->password_confirmation)
        {
            return view('profile.edit',$userData)->with('error','Password and Confirm Password does not match');
        }
        
        
        $checkEmail = \DB::select("select * from users where email like '".$request->email."' and id not in(".$request->userId.")");
        if(!empty($checkEmail))
        {
            return view('profile.edit',$userData)->with('error',''.$request->email.' - Email is already registered by another user, please try with new email'); 
        }
        else if(!empty($request->password) ){
            $validator = Validator::make($request->all(), [
                'password' => 'min:8',
            ])->validate();
        }
        else 
        {
            $imageName = $userData['data']->profilePhoto;
            if($request->file('profilePhoto')!=null)
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

            
                $success = imagejpeg($img, $destinationPath.'/'.$input['imagename'],50);
                if($success)
                {
                    $imageName = $input['imagename'];
                    unlink($userData['profileImageFullPath']);
                }
            }
            $update = [
                'name' => $request->name, 
                'email' => $request->email,
                'updated_at' => \DB::raw('now()'),
                'gender'   => $request->gender, 
                'profilePhoto'   => $imageName,
            ];

            if(!empty($request->password) ){
                $update['password'] = Hash::make($request->password);
            }
            
            \DB::table('users')->where('id',$request->userId)->update($update);
            return view('profile.edit',$userData)->with('success','Profile has been updated Successfully');
        }
        
    }
}