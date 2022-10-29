<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\LoginRequest;

class LoginController extends Controller
{
    public function index()
    {
        if(Auth::check()){
            return redirect()->route('admin.user.index');
        }
        return view('admin.auth.login');
    }

    public function postLogin(LoginRequest $request){
        $login = $request->only(['email','password']);
        //$login['role'] = 'admin';
        if(Auth::attempt($login)){
            return redirect()->route('admin.user.index');
        }
        return redirect()->route('admin.index')->withInput()->with('loginFail','Wrong password or this account not approved yet');
    }

    public function logout(){
        Auth::logout();
        return redirect()->route('admin.index');
    }
}
