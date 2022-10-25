<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\TestTemplate;

class TestTemplateController extends Controller
{
    public function index() {
        $data["templates"] = TestTemplate::getAllTemplates();
        return view('admin.template.list')->with('data',$data);
    }

    public function show() {
        
    }

    public function store() {
        
    }

    public function edit() {
        
    }

    public function update() {
        
    }

    public function destroy() {
        
    }
}
