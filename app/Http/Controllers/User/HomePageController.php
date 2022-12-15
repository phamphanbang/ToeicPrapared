<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Test;
use App\Models\TestHistory;
use App\Models\TestTemplate;
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
            $data["plan"] = TrainingPlan::where("user_id" , "=" , Auth::user()->id)->first();
            $data["check"] = true;
            if($data["plan"]) {
                $test_type = TestTemplate::where("name" , "=" , "Part ".$data["plan"]->part_suggestion)->first();
                if ($test_type) {
                    $data["recomend"] = Test::where("type" , "=" , "parttest")
                    ->where("test_type_id","=",$test_type->id)
                    ->where("score_range", ">=" , $data["plan"]->current_score)
                    ->orderBy("score_range","asc")
                    ->limit(4)
                    ->get();
                    $data["check"] = false;
                }
            }
            
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

    public function contact() {
        return view('user.footer.contact');
    }

    public function security() {
        return view('user.footer.security');
    }

    public function usage() {
        return view('user.footer.usage');
    }
}
