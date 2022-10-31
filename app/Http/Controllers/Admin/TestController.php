<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CommentSet;
use App\Models\Test;
use App\Models\TestCluster;
use App\Models\TestPart;
use App\Models\TestQuestion;
use App\Models\TestTemplate;
use Illuminate\Support\Facades\Session;
use SebastianBergmann\Template\Template;

class TestController extends Controller
{
    public function index()
    {
        $data["tests"] = Test::getAllTests();
        Session::put('task_url', request()->fullUrl());
        return view('admin.test.list')->with('data', $data);
    }

    public function show()
    {
    }

    public function create()
    {
        $data["templates"] = TestTemplate::where('status', '=', 'public')->get();
        return view('admin.test.create')->with('data', $data);
    }

    public function generate(Request $request)
    {
        $data["templates"] = TestTemplate::where('status', '=', 'public')->get();
        $data["template"] = TestTemplate::find($request->template);
        return view('admin.test.create')->with('data', $data);
    }

    public function store(Request $request)
    {
        $comment_set = new CommentSet;
        $comment_set->type = "test";
        $comment_set->save();
        $test = $this->saveTest($request, $comment_set->id);
        foreach ($request["part"] as $data) {
            $part = $this->savePart($data, $test->id);
            if ($part->have_cluster == "true") {
                foreach ($data["cluster"] as $cluster_data) {
                    $cluster = $this->saveCluster($cluster_data, $part->id);
                    foreach ($cluster_data["question"] as $data_question) {
                        $question = $this->saveQuestion($data_question,$part,$cluster);
                    }
                }
            }
            else {
                foreach ($data["question"] as $data_question){
                    $question = $this->saveQuestion($data_question,$part);
                }
            }
        }
        if (session('task_url')) {
            return redirect(session('task_url'))->with('testCreateSuccess', 'Test created successfully');
        }
        return redirect()->route('admin.test.index')->with('testCreateSuccess', 'Test created successfully');
    }

    public function edit()
    {
    }

    public function update()
    {
    }

    public function destroy()
    {
    }

    public function search()
    {
    }

    // Custom Function

    public function saveTest($data, $comment_set_id)
    {
        $test = new Test;
        $test->name = $data->name;
        $test->duration = $data->duration;
        $test->status = $data->status;
        $test->num_of_question = $data->num_of_question;
        if ($data->has("score_range")) {
            $test->num_of_question = $data->num_of_question;
        }
        $test->test_type_id = $data->test_type_id;
        $test->comment_set_id = $comment_set_id;
        $test->save();
        if ($data->has("audio_file")) {
            $file = $data->file("audio_file");
            $extension = $file->extension();
            $file->move(public_path('tests/audio/'), $test->id .'.'. $extension);
            $test->audio_file = 'pulic/tests/audio/' . $test->id.'.' . $extension;
        }
        $test->update();
        return $test;
    }

    public function savePart($data, $test_id)
    {
        $part = new TestPart;
        $part->order_in_test = $data["order_in_test"];
        $part->name = $data["name"];
        $part->num_of_question = $data["num_of_question"];
        $part->description = $data["description"];
        $part->have_cluster = $data["have_cluster"]  == "yes" ? true : false;
        $part->have_attachment = $data["have_attachment"]  == "yes" ? true : false;
        $part->have_question = $data["have_question"]  == "yes" ? true : false;
        $part->test_id = $test_id;
        $part->save();
        return $part;
    }

    public function saveCluster($data, $part_id)
    {
        $cluster = new TestCluster;
        
        $cluster->order_in_part = $data["order_in_part"];
        $cluster->question_begin = $data["question_begin"];
        $cluster->question_end = $data["question_end"];
        $cluster->part_id = $part_id;
        if (array_key_exists("question_content", $data)) {
            $cluster->question = $data["question_content"];
        }
        $cluster->save();
        if (array_key_exists("attachment", $data)) {
            $file = $data["attachment"]->file("attachment");
            
            $extension = $file->extension();
            $file->move(public_path('images/cluster/'), $cluster->id .'.'. $extension);
            $cluster->attachment = 'pulic/images/cluster/' . $cluster->id .'.'. $extension;
        }
        $cluster->update();
        return $cluster;
    }

    public function saveQuestion($data, $part, $cluster = null)
    {
        $question = new TestQuestion;
        $question->order_in_test = $data["order_in_test"];
        $question->option_1 = $data["option_1"];
        $question->option_2 = $data["option_2"];
        $question->option_3 = $data["option_3"];
        $question->answer = $data["answer"];
        $question->explanation = $data["option_3"];
        $question->part_id = $part->id;
        if ($part->have_question) {
            $question->question = $data["question"];
        }
        if ($part->num_of_answer == 4) {
            $question->option_4 = $data["option_4"];
        }
        if ($cluster != null) {
            $question->cluster_id = $cluster->id;
        }
        $question->save();
        if ($part->have_attachment) {
            $extension = $data["attachment"]->extension();
            $data["attachment"]->move(public_path('images/question/'), $question->id .'.'. $extension);
            $question->attachment = 'pulic/images/question/' . $question->id .'.'. $extension;
        }
        $question->update();
        return $question;
    }
}
