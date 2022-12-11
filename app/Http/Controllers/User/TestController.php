<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Test;
use App\Models\TestHistory;
use App\Models\TestHistoryAnswer;
use App\Models\TestQuestion;
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
        $data["tests"] = Test::find($id);
        return view('user.test.start')->with('data',$data);
    }

    public function submit(Request $request) {
        $rq = 0;
        $wq = 0;
        $eq = 0;
        $history = new TestHistory();
        $history->test_id = $request->test_id;
        $history->user_id = $request->user_id;
        $history->duration = $request->duration;
        $history->total_question = $request->total_question;
        $history->right_question = $rq;
        $history->wrong_question = $wq;
        $history->empty_question = $eq;
        $history->save();
        foreach($request["questions"] as $question) {
            $q = new TestHistoryAnswer();
            $q->history_id = $history->id;
            $q->question_id = $question["id"];
            $q->answer = $question["select"];
            $q->save(); 
            if ($question["select"] == "none" ) {
                $eq += 1;
            } 
            elseif ($question["select"] == $question["answer"]) {
                $rq += 1;
            }
            else {
                $wq += 1;
            }
        }
        $history->right_question = $rq;
        $history->wrong_question = $wq;
        $history->empty_question = $eq;
        $history->update();
        return redirect()->route('user.test.result', [$request->test_id,$history->id]);
    }

    public function result($id,$result_id) {
        $data["tests"] = Test::find($id);
        $data["result"] = TestHistory::find($result_id);
        foreach( $data["tests"]->testParts as $index => $part) {
            $data["parts"][$index]["name"] = $part->name;
            foreach($part->testQuestions as $qindex => $question) {
                $answer = TestHistoryAnswer::where('history_id' , '=' , $result_id)->where('question_id' , '=' , $question->id)->first();
                $data["parts"][$index]["questions"][$qindex]["order_in_test"] = $question->order_in_test;
                $data["parts"][$index]["questions"][$qindex]["select"] = $answer->answer;
                $data["parts"][$index]["questions"][$qindex]["answer"] = $question->answer;
                if ($answer->answer == "none") {
                    $data["parts"][$index]["questions"][$qindex]["status"] = "none";
                }
                else {
                    $data["parts"][$index]["questions"][$qindex]["status"] = $question->answer == $answer->answer ? "right" : "wrong";
                }
            }
        }
        return view('user.test.result')->with('data',$data);
    }

    public function details($id,$result_id) {
        return view('user.test.detail');
    }
}
