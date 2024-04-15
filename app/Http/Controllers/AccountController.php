<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Validator as ValidationValidator;

class AccountController extends Controller
{
    public function registration(){
        return view('frontend.account.registration');
    }
    public function processregister(Request $request){
        $validator=Validator::make($request->all(),[
            'name'=> 'required',
            'email'=>'required|email|unique:users,email',
            'password'=> 'required|min:5|same:confirmPassword',
            'confirmPassword'=>'required'
        ]);

        if($validator->passes()){
            $user=new User();
            $user->name=$request->name;
            $user->email=$request->email;
            $user->password=Hash::make($request->password);
            $user->save();
            session()->flash('success','You have registered successfully');
            return response()->json([
                'status'=>true,
                'errors'=> $validator->errors()
            ]);
        }
        else{
            
            return response()->json([
                'status'=>false,
                'errors'=> $validator->errors()
            ]);
        }
    }
    public function login(){
        return view('frontend.account.login');
    }
    public function authenticate(Request $request){
        $validator=Validator::make($request->all(),[
            'email'=>'required|email',
            'password'=>'required'
        ]);
        if($validator->passes()){
            if(Auth::attempt(['email'=>$request->email, 'password'=> $request->password])){
                return redirect()->route('profile');
            }
            else{
                return redirect()->route('login')->with('error','Either Email/password is incorrect');
            }
        }
        else{
            return redirect()->route('login')->withErrors($validator)->withInput($request->only('email'));
        }
    }
    public function profile(){
        return view('frontend.account.profile');
    }

    public function logout(){
        Auth::logout();
        return redirect()->route('home');
    }
        
}
