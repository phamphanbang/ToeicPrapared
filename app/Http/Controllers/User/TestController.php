<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Test;
use App\Models\TestHistory;
use App\Models\TestHistoryAnswer;
use App\Models\TestQuestion;
use App\Models\TestTemplate;
use App\Models\TrainingPlan;
use Illuminate\Support\Facades\Auth;

class TestController extends Controller
{
    public function index()
    {
        $data["tests"] = Test::getAllTests();
        $data["templates"] = TestTemplate::all();
        return view('user.test.list')->with('data', $data);
    }

    public function show($id)
    {
        $data["tests"] = Test::find($id);
        $comment_set_id = $data["tests"]->comment_set_id;
        $data["comments"] = Comment::getAllComments($comment_set_id);
        $data["num_of_comments"] = $data["comments"]->count();
        if (Auth::check()) {
            $hquery = TestHistory::where('test_id', '=', $id)
                ->where('user_id', '=', Auth::user()->id)
                ->orderBy('created_at', 'desc');
            $data["histories_count"] = $hquery->count();
            $data["histories"] = $hquery->limit(3)->get();
        }

        return view('user.test.show')->with('data', $data);
    }

    public function start($id)
    {
        $data["tests"] = Test::find($id);
        return view('user.test.start')->with('data', $data);
    }

    public function submit(Request $request)
    {
        $rq = 0;
        $wq = 0;
        $eq = 0;
        $listening = 0;
        $reading = 0;
        $history = new TestHistory();
        $history->test_id = $request->test_id;
        $history->user_id = $request->user_id;
        $history->duration = $request->duration;
        $history->total_question = $request->total_question;
        $history->right_question = $rq;
        $history->wrong_question = $wq;
        $history->empty_question = $eq;
        $history->save();
        foreach ($request["parts"] as $part) {
            foreach ($part["questions"] as $question) {
                $q = new TestHistoryAnswer();
                $q->history_id = $history->id;
                $q->question_id = $question["id"];
                $q->answer = $question["select"];
                $q->save();
                $check = $question["select"] == $question["answer"];
                if ($question["select"] == "none") {
                    $eq += 1;
                } elseif ($check) {
                    $rq += 1;
                } else {
                    $wq += 1;
                }
                if ($request->type == "fulltest" && $check) {
                    if ($question["type"] == "reading") {
                        $reading += 1;
                    } else {
                        $listening += 1;
                    }
                }
            }
        }

        $history->right_question = $rq;
        $history->wrong_question = $wq;
        $history->empty_question = $eq;

        if ($request->type == "fulltest") {
            $score = $this->score($listening, $reading);
            $history->score = $score;
            $plan = TrainingPlan::where("user_id", "=", $request->user_id)->first();
            if ($plan) {
                $plan->current_score = $score;
                $plan->update();
            }
        }
        $history->update();
        return redirect()->route('user.test.result', [$request->test_id, $history->id]);
    }

    public function score($listening, $reading)
    {
        $lc = 0;
        $rc = 0;
        if ($listening <= 2) {
            $lc = 5;
        } else {
            $lc = ($listening * 5) - 5;
        }
        if ($reading == 0) {
            $rc = 5;
        } else {
            $rc = ($reading * 5) + 10;
        }
        return $lc + $rc;
    }

    public function result($id, $result_id)
    {
        $data["tests"] = Test::find($id);
        $data["result"] = TestHistory::find($result_id);
        $comment_set_id = $data["tests"]->comment_set_id;
        $data["comments"] = Comment::getAllComments($comment_set_id);
        $data["num_of_comments"] = $data["comments"]->count();
        foreach ($data["tests"]->testParts as $index => $part) {
            $data["parts"][$index]["name"] = $part->name;
            foreach ($part->testQuestions as $qindex => $question) {
                $answer = TestHistoryAnswer::where('history_id', '=', $result_id)->where('question_id', '=', $question->id)->first();
                $data["parts"][$index]["questions"][$qindex]["order_in_test"] = $question->order_in_test;
                $data["parts"][$index]["questions"][$qindex]["select"] = $answer->answer;
                $data["parts"][$index]["questions"][$qindex]["answer"] = $question->answer;
                if ($answer->answer == "none") {
                    $data["parts"][$index]["questions"][$qindex]["status"] = "none";
                } else {
                    $data["parts"][$index]["questions"][$qindex]["status"] = $question->answer == $answer->answer ? "right" : "wrong";
                }
            }
        }
        return view('user.test.result')->with('data', $data);
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

    public function details($id, $result_id)
    {
        $data["tests"] = Test::find($id);
        $data["result"] = TestHistory::find($result_id);
        foreach ($data["tests"]->testParts as $index => $part) {
            $data["parts"][$index]["name"] = $part->name;
            $data["parts"][$index]["have_cluster"] = $part->have_cluster;
            $data["parts"][$index]["have_attachment"] = $part->have_attachment;
            $data["parts"][$index]["have_question"] = $part->have_question;
            $data["parts"][$index]["order_in_test"] = $part->order_in_test;
            $data["parts"][$index]["num_of_answer"] = $part->num_of_answer;
            if ($part->have_cluster) {
                foreach ($part->testCluster as $cindex => $cluster) {
                    $data["parts"][$index]["clusters"][$cindex]["question"] = $cluster->question;
                    $data["parts"][$index]["clusters"][$cindex]["attachment"] = $cluster->attachment;
                    foreach ($cluster->testQuestion as $qindex => $question) {
                        $answer = TestHistoryAnswer::where('history_id', '=', $result_id)->where('question_id', '=', $question->id)->first();
                        $data["parts"][$index]["clusters"][$cindex]["questions"][$qindex]["order_in_test"] = $question->order_in_test;
                        $data["parts"][$index]["clusters"][$cindex]["questions"][$qindex]["select"] = $answer->answer;
                        $data["parts"][$index]["clusters"][$cindex]["questions"][$qindex]["answer"] = $question->answer;
                        $data["parts"][$index]["clusters"][$cindex]["questions"][$qindex]["question"] = $question->question;
                        $data["parts"][$index]["clusters"][$cindex]["questions"][$qindex]["attachment"] = $question->attachment;
                        $data["parts"][$index]["clusters"][$cindex]["questions"][$qindex]["id"] = $question->id;
                        $data["parts"][$index]["clusters"][$cindex]["questions"][$qindex]["option_1"] = $question->option_1;
                        $data["parts"][$index]["clusters"][$cindex]["questions"][$qindex]["option_2"] = $question->option_2;
                        $data["parts"][$index]["clusters"][$cindex]["questions"][$qindex]["option_3"] = $question->option_3;
                        $data["parts"][$index]["clusters"][$cindex]["questions"][$qindex]["option_4"] = $question->option_4;
                        if ($answer->answer == "none") {
                            $data["parts"][$index]["clusters"][$cindex]["questions"][$qindex]["status"] = "none";
                        } else {
                            $data["parts"][$index]["clusters"][$cindex]["questions"][$qindex]["status"] = $question->answer == $answer->answer ? "right" : "wrong";
                        }
                    }
                }
            } else {
                foreach ($part->testQuestions as $qindex => $question) {
                    $answer = TestHistoryAnswer::where('history_id', '=', $result_id)->where('question_id', '=', $question->id)->first();
                    $data["parts"][$index]["questions"][$qindex]["order_in_test"] = $question->order_in_test;
                    $data["parts"][$index]["questions"][$qindex]["select"] = $answer->answer;
                    $data["parts"][$index]["questions"][$qindex]["answer"] = $question->answer;
                    $data["parts"][$index]["questions"][$qindex]["question"] = $question->question;
                    $data["parts"][$index]["questions"][$qindex]["attachment"] = $question->attachment;
                    $data["parts"][$index]["questions"][$qindex]["id"] = $question->id;
                    $data["parts"][$index]["questions"][$qindex]["option_1"] = $question->option_1;
                    $data["parts"][$index]["questions"][$qindex]["option_2"] = $question->option_2;
                    $data["parts"][$index]["questions"][$qindex]["option_3"] = $question->option_3;
                    $data["parts"][$index]["questions"][$qindex]["option_4"] = $question->option_4;
                    $data["parts"][$index]["questions"][$qindex]["explanation"] = $question->explanation;
                    if ($answer->answer == "none") {
                        $data["parts"][$index]["questions"][$qindex]["status"] = "none";
                    } else {
                        $data["parts"][$index]["questions"][$qindex]["status"] = $question->answer == $answer->answer ? "right" : "wrong";
                    }
                }
            }
        }
        return view('user.test.detail')->with('data', $data);
    }

    public function type($type)
    {
        $data["tests"] = Test::getByType($type);
        $data["templates"] = TestTemplate::all();
        return view('user.test.list')->with('data', $data);
    }

    public function search(Request $request)
    {
        if ($request->by == "none") {
            $data["tests"] = Test::where('name', 'like', '%' . $request->search . '%')->paginate(12);
        } else {
            $data["tests"] = Test::where('name', 'like', '%' . $request->search . '%')->where('test_type_id', '=', $request->by)->paginate(12);
        }
        $data["templates"] = TestTemplate::all();
        return view('user.test.list')->with('data', $data);
    }
}
