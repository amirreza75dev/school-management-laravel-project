<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function formValidation(Request $request){
        $validatedData = $request->validate([
            'name' => ['string', 'min:6', 'required'],
            'email' => ['email','string','required'],
            'rule' => ['required'],
            'password' => ['string', 'min:8', 'required'],
            'password-confirmation' => ['string', 'min:8', 'required','same:password'],
            'terms' => ['required']
        ]);
        $hashedPassword = Hash::make($validatedData['password']);
        $userModel = new User([
            'name' => $validatedData['name'],
            'email'=> $validatedData['email'],
            'rule'=> $validatedData['rule'],
            'password'=> $hashedPassword
        ]);
        $userModel->save();
        return redirect()->route('login');
    }
    public function showLoginView(){
        return view('admin.admin-login');
    }
    public function userLogin(Request $request){
        $validatedData = $request->validate([
            'email' => ['email', 'required'],
            'rule' => ['required'],
            'password' => ['required']
        ]);
        $remember = $request->has('remember');
        if(Auth::attempt(['email' => $validatedData['email'], 'password' => $validatedData['password']],$remember)){
            $user = Auth::user();
            $userRule = $user->rule;
            switch($userRule){
                case 'admin':
                    return redirect()->route('admin-dashboard');
                    break;
                case 'teacher':
                    return redirect()->route('teacher-dashboard');
                    break;
                case 'student':
                    return redirect()->route('student-dashboard');
                    break;
                case 'parent':
                    return redirect()->route('parent-dashboard');
                    break;
            }
        }else{
            return redirect()->route('login')->withInput()->withErrors(['loginError'=>'invalid login credentials']);
        }
    }
    public function userLogout(){
        Auth::logout();
        return redirect()->route('login');
    }
}
