<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Test;
use App\Models\TestHistory;
use App\Models\TrainingPlan;
use Illuminate\Support\Facades\Auth;

class HomePageController extends Controller
{
    public function index() {
        if (Auth::check()) {
            $hquery = TestHistory::where('user_id','=',Auth::user()->id)
            ->orderBy('created_at','desc');
            $data["histories_count"] = $hquery->count();
            $data["histories"] = $hquery->limit(4)->get();
            // if ($data["histories_count"] > 0) {
            //     foreach($histories as $index => $history) {
            //         $data["histories"][$index]["name"] = $history->name;
                    
            //     }
            // } 
            $data["plan"] = TrainingPlan::where("user_id" , "=" , Auth::user()->id)->first();
        }
        $data["tests"] = Test::where('type', '=' , 'fulltest')
        ->orderBy('created_at','desc')
        ->limit(8)
        ->get();
        $data["blogs"] = Blog::orderBy('created_at','desc')
        ->limit(3)
        ->get();
        return view('user.home')->with('data',$data);
    }
}
