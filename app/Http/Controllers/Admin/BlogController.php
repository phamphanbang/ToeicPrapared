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
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\Eloquent\Builder;

class BlogController extends Controller
{
    public function index(){
        $data["blogs"] = Blog::getAllBlogs();
        Session::put('task_url',request()->fullUrl());
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
        if(session('task_url')){
            return redirect(session('task_url'))->with('blogCreateSuccess','Blog created successfully');
        }
        return redirect()->route('admin.blog.index')->with('blogCreateSuccess','Blog created successfully');
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

    public function destroy($id){
        $blog = Blog::find($id);
        $comment_set_id = $blog->commentSet->id;
        $blog->delete();
        $comment_set = CommentSet::find($comment_set_id);
        $comment_set->delete();
        if(session('task_url')){
            return redirect(session('task_url'))->with('deleteBlogSuccessfully','Blog deleted successfully');
        }
        return redirect()->route('admin.blog.index')->with('deleteBlogSuccessfully','Blog deleted successfully');
    }

    public function search(Request $request) {
        if($request->by == "author") {
            $data["blogs"] = Blog::whereHas('user', function (Builder $query ) use($request) {
                $query->where('name', 'like', $request->search);
            })->paginate(5);
        }
        else {
            $data["blogs"] = Blog::where($request->by,'like','%'.$request->search.'%')->paginate(5);
        }
        return view('admin.blog.list')->with('data',$data);
    }
}
