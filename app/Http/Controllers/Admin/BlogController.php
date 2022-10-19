<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\CommentSet;
use App\Models\User;
use App\Http\Requests\CreateBlogRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UpdateBlogRequest;

class BlogController extends Controller
{
    public function index(){
        $data["blogs"] = Blog::getAllBlogs();
        return view('admin.blog.list')->with('data',$data);
    }

    public function create(){
        return view('admin.blog.create');
    }

    public function store(CreateBlogRequest $request){
        $comment_set = new CommentSet;
        $comment_set->type = "blog";
        $comment_set->save();
        $data["blog"] = new Blog;
        $data["blog"]->name = $request->name;
        $data["blog"]->blog = $request->blog;
        $data["blog"]->comment_set_id = $comment_set->id;
        $data["blog"]->user_id = $request->user()->id;
        $data["blog"]->save();
        return redirect('admin/blog/'.$data["blog"]->id.'/edit')->with('data',$data)->with('blogCreateSuccess','Blog created successfully');
    }

    public function show($id){
        $data["blog"] = Blog::find($id);
        return view('admin.blog.show')->with('data',$data);
    }

    public function edit($id){
        $data["blog"] = Blog::find($id);
        return view('admin.blog.edit')->with('data',$data);
    }

    public function update(UpdateBlogRequest $request, $id){
        $data["blog"] = Blog::find($id);
        $data["blog"]->name = $request->name;
        $data["blog"]->blog = $request->blog;
        $data["blog"]->save();
        return redirect(route('admin.blog.edit',$data["blog"]->id))->with('data',$data)->with('blogChangeSuccess','Blog changed successfully');
    }

    public function delete(){
        
    }
}
