<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Test;
use App\Models\TestTemplate;

class TestController extends Controller
{
    public function index() {
        $data["tests"] = Test::getAllTests();
        $data["templates"] = TestTemplate::all();
        return view('user.test.list')->with('data',$data);
    }

    public function show($id) {
        $data["tests"] = Test::find($id);
        return view('user.test.show')->with('data',$data);
    }

    public function start($id) {
        return view('user.test.test');
    }

    public function result($id) {
        return view('user.test.result');
    }

    public function details($id,$result_id) {
        return view('user.test.detail');
    }
}
