<?php


namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Comment;

class BlogController extends Controller
{
    public function index() {
        $data["blogs"] = Blog::orderBy("created_at","desc")->paginate(6);
        return view('user.blog.list')->with('data',$data);
    }

    public function show($id) {
        $data["blog"] = Blog::find($id);
        $comment_set_id = $data["blog"]->comment_set_id;
        $data["comments"] = Comment::getAllComments($comment_set_id);
        $data["num_of_comments"] = $data["comments"]->count();
        return view('user.blog.show')->with('data',$data);
    }

    public function search(Request $request) {
        $data["blogs"] = Blog::where('name','like','%'.$request->search.'%')->paginate(6);
        return view('user.blog.list')->with('data',$data);
    }

    public function comment(Request $request)
    {
        $comment = new Comment();
        $comment->user_id = $request->user_id;
        $comment->comment_set_id = $request->comment_set_id;
        $comment->comment = $request->comment;
        $comment->save();
        return redirect()->back();
    }
}
