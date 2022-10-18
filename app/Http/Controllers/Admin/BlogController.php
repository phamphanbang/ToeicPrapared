<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Blog;

class BlogController extends Controller
{
    public function index(){
        $data["blogs"] = Blog::getAllBlogs();
        return view('admin.blog.list')->with('data',$data);
    }

    public function create(){
        return view('admin.blog.create');
    }

    public function store(){
        
    }

    public function edit(){
        
    }

    public function update(){
        
    }

    public function delete(){
        
    }
}
