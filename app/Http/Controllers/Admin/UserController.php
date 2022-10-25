<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Http\Requests\RegistrationRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function index() {
        $data["users"] = User::getAllUsers();
        Session::put('task_url',request()->fullUrl());
        return view('admin.user.list')->with('data',$data);
    }

    public function create() {
        return view('admin.user.create');
    }

    public function store(RegistrationRequest $request) {
        $data["user"] = new User;
        $data["user"]->name = $request->name;
        $data["user"]->email = $request->email;
        $data["user"]->password = Hash::make($request->password);
        $data["user"]->save();
        if(session('task_url')){
            return redirect(session('task_url'))->with('registerSuccess','User created successfully');
        }
        return redirect()->route('admin.user.index')->with('registerSuccess','User created successfully');
    }

    public function edit($id) {
        $data["user"] = User::find($id);
        return view('admin.user.edit')->with('data',$data);
    }

    public function update(UpdateUserRequest $request, $id) {
        $data["user"] = User::find($id);
        if($request->password){
            $data["user"]->password = Hash::make($request->password); 
        }
        $data["user"]->name = $request->name;
        $data["user"]->email = $request->email;
        $data["user"]->save();
        if(session('task_url')){
            return redirect(session('task_url'))->with('profileChangeSuccess','Profile changed successfully');
        }
        return redirect()->route('admin.user.index')->with('profileChangeSuccess','Profile changed successfully');
    }

    public function destroy($id) {
        $user = User::find($id);
        $user->delete();
        if(session('task_url')){
            return redirect(session('task_url'))->with('deleteUserSuccessfully','User deleted successfully');
        }
        return redirect()->route('admin.user.index')->with('deleteUserSuccessfully','User deleted successfully');
    }

    public function search(Request $request) {
        $data["users"] = User::where($request->by,'like','%'.$request->search.'%')->paginate(5);
        return view('admin.user.list')->with('data',$data);
    }
}
