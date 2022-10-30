<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Test;
use App\Models\TestTemplate;
use Illuminate\Support\Facades\Session;

class TestController extends Controller
{
    public function index() {
        $data["tests"] = Test::getAllTests();
        Session::put('task_url', request()->fullUrl());
        return view('admin.test.list')->with('data', $data);
    }

    public function show() {
        
    }

    public function create() {
        $data["templates"] = TestTemplate::where('status' , '=' , 'public')->get();
        return view('admin.test.create')->with('data',$data);
    }

    public function generate(Request $request) {

    }

    public function store() {
        
    }

    public function edit() {
        
    }

    public function update() {
        
    }

    public function destroy() {
        
    }

    public function search() {
        
    }
}
