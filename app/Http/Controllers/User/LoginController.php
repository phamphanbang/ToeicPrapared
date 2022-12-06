<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserLoginRequest;
use App\Http\Requests\User\UserRegistrationRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function index() {
        return view('user.auth.login');
    }

    public function registration() {
        return view('user.auth.register');
    }

    public function login(UserLoginRequest $request) {
        $credential = $request->only("email","password");

        if(Auth::attempt($credential)){
            return redirect()->route('home');
        }

        return redirect()->route('user.login')->withInput()->with('LoginFail','Mật khẩu không chính xác.');
    }

    public function register(UserRegistrationRequest $request) {
        // $user = User::created([
        //     "name" => $request->name,
        //     "password" => Hash::make($request->password),
        //     "email" => $request->email
        // ]);
        $user = new User;
        $user->name = $request->name;
        $user->password = Hash::make($request->password);
        $user->email = $request->email;
        $user->save();
        Auth::loginUsingId($user->id);
        return redirect()->route('home');
    }

    public function logout(){
        Auth::logout();
        return redirect()->route('home');
    }
}
