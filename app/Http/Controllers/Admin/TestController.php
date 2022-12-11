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
use App\Http\Requests\CreateTestRequest;
use Illuminate\Support\Facades\Storage;

class TestController extends Controller
{
    public function index()
    {
        $data["tests"] = Test::getAllTests();
        Session::put('task_url', request()->fullUrl());
        return view('admin.test.list')->with('data', $data);
    }

    public function show($id)
    {
        $data["test"] = Test::find($id);
        return view('admin.test.show')->with('data', $data);
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
        // return redirect()->route('admin.test.create')->with('data', $data);
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
                    $cluster = $this->saveCluster($cluster_data, $part->id, $test->id);
                    foreach ($cluster_data["question"] as $data_question) {
                        $question = $this->saveQuestion($data_question, $part, $cluster, $test->id);
                    }
                }
            } else {
                foreach ($data["question"] as $data_question) {
                    $question = $this->saveQuestion($data_question, $part, null, $test->id);
                }
            }
        }
        if (session('task_url')) {
            return redirect(session('task_url'))->with('testCreateSuccess', 'Test created successfully');
        }
        return redirect()->route('admin.test.index')->with('testCreateSuccess', 'Test created successfully');
    }

    public function edit($id)
    {
        $data["test"] = Test::find($id);
        $data["test_template"] = $data["test"]->testTemplate;
        return view('admin.test.edit')->with('data', $data);
    }

    public function update(Request $request, $id)
    {
        $test = Test::find($id);
        $test->status = $request->status;
        if ($request->has('score_range')) {
            $test->score_range = $request->score_range;
        }
        if ($request->hasFile('audio_file')) {
            $file = $request->file("audio_file");
            $extension = $file->extension();
            $file->storeAs('public/tests/' . $test->id . '/audio/', $test->id . '.' . $extension);
            $test->audio_file = 'tests/' . $test->id . '/audio/' . $test->id . '.' . $extension;
        }
        $test->update();
        foreach ($request->cluster as $data) {
            $cluster = TestCluster::find($data["id"]);
            if (array_key_exists("question", $data)) {
                $cluster->question = $data["question"];
            }
            if (array_key_exists("attachment", $data) && $data["attachment"] != null) {
                $file = $data["attachment"]->file("attachment");
                $extension = $file->extension();
                $file->storeAs('public/tests/' . $test->id . '/clusters/', $cluster->id . '.' . $extension);
                $cluster->attachment = 'tests/' . $test->id . '/clusters/' . $cluster->id . '.' . $extension;
            }
            $cluster->update();
        }
        foreach ($request->question as $data) {
            $question = TestQuestion::find($data["id"]);
            if (array_key_exists("question", $data)) {
                $question->question = $data["question"];
            }
            if (array_key_exists("attachment", $data) && $data["attachment"] != null) {
                $extension = $data["attachment"]->extension();
                $data["attachment"]->storeAs('public/tests/' . $test->id . '/questions/', $question->id . '.' . $extension);
                $question->attachment = 'tests/' . $test->id . '/questions/' . $question->id . '.' . $extension;
            }
            $question->option_1 = $data["option_1"];
            $question->option_2 = $data["option_2"];
            $question->option_3 = $data["option_3"];
            if (array_key_exists("option_4", $data)) {
                $question->option_4 = $data["option_4"];
            }
            $question->explanation = $data["explanation"];
            $question->update();
        }
        if (session('task_url')) {
            return redirect(session('task_url'))->with('testUpdateSuccess', 'Test updated successfully');
        }
        return redirect()->route('admin.test.index')->with('testUpdateSuccess', 'Test updated successfully');
    }

    public function destroy($id)
    {
        $test = Test::find($id);
        $comment_set_id = $test->commentSet->id;
        Storage::deleteDirectory('public/tests/'.$test->id);
        $test->delete();
        $comment_set = CommentSet::find($comment_set_id);
        $comment_set->delete();
        if (session('task_url')) {
            return redirect(session('task_url'))->with('deleteTestSuccessfully', 'Test deleted successfully');
        }
        return redirect()->route('admin.test.index')->with('deleteTestSuccessfully', 'Test deleted successfully');
    }

    public function search(Request $request)
    {
        $data["tests"] = Test::where('name','like','%'.$request->search.'%')->paginate(5);
        return view('admin.test.list')->with('data', $data);
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
            $file->storeAs('public/tests/' . $test->id . '/audio/', $test->id . '.' . $extension);
            $test->audio_file = 'tests/' . $test->id . '/audio/' . $test->id . '.' . $extension;
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
        $part->num_of_answer = $data["num_of_answer"];
        $part->description = $data["description"];
        $part->have_cluster = $data["have_cluster"]  == "yes" ? true : false;
        $part->have_attachment = $data["have_attachment"]  == "yes" ? true : false;
        $part->have_question = $data["have_question"]  == "yes" ? true : false;
        $part->test_id = $test_id;
        $part->save();
        return $part;
    }

    public function saveCluster($data, $part_id, $testId)
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
            $file->storeAs('public/tests/' . $testId . '/clusters/', $cluster->id . '.' . $extension);
            $cluster->attachment = 'tests/' . $testId . '/clusters/' . $cluster->id . '.' . $extension;
        }
        $cluster->update();
        return $cluster;
    }

    public function saveQuestion($data, $part, $cluster = null, $testId)
    {
        $question = new TestQuestion;
        $question->order_in_test = $data["order_in_test"];
        $question->option_1 = $data["option_1"];
        $question->option_2 = $data["option_2"];
        $question->option_3 = $data["option_3"];
        $question->answer = $data["answer"];
        $question->explanation = $data["explanation"];
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
            $data["attachment"]->storeAs('public/tests/' . $testId . '/questions/', $question->id . '.' . $extension);
            $question->attachment = 'tests/' . $testId . '/questions/' . $question->id . '.' . $extension;
        }
        $question->update();
        return $question;
    }
}
