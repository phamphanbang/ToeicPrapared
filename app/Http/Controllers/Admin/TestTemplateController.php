<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\TestTemplate;
use App\Http\Requests\CreateTemplateRequest;
use App\Models\ClusterTemplate;
use App\Models\PartTemplate;
use App\Http\Requests\UpdateTemplateRequest;
use Illuminate\Support\Facades\Session;

class TestTemplateController extends Controller
{
    public function index()
    {
        $data["templates"] = TestTemplate::getAllTemplates();
        Session::put('task_url', request()->fullUrl());
        return view('admin.template.list')->with('data', $data);
    }

    public function show($id)
    {
        $data["template"] = TestTemplate::find($id);
        return view('admin.template.show')->with('data', $data);
    }

    public function create()
    {
        return view('admin.template.create');
    }

    public function store(CreateTemplateRequest $request)
    {
        $template = new TestTemplate;
        $template->name = $request->name;
        $template->description = $request->description;
        $template->num_of_part = $request->num_of_part;
        $template->num_of_question = $request->num_of_question;
        $template->status = $request->status;
        $template->type = $request->type;
        $template->duration = $request->duration;
        $template->have_score_range = $request->have_score_range == "yes" ? true : false;
        $template->have_audio_file = $request->have_audio_file == "yes" ? true : false;
        $template->save();
        foreach ($request["parts"] as $data) {
            $part = new PartTemplate;
            $part->name = $data["name"];
            $part->type = $data["type"];
            $part->order_in_test = $data["order_in_test"];
            $part->description = $data["description"];
            $part->num_of_question = $data["num_of_question"];
            $part->num_of_answer = $data["num_of_answer"];
            $part->have_attachment = $data["have_attachment"] == "yes" ? true : false;
            $part->have_question = $data["have_question"] == "yes" ? true : false;
            $part->test_id = $template->id;
            if (array_key_exists("cluster", $data)) {
                $part->have_cluster = true;
                $part->save();
                foreach ($data["cluster"] as $clusterData) {
                    $cluster = new ClusterTemplate;
                    $cluster->num_in_part = $clusterData["num_in_part"];
                    $cluster->num_of_question = $clusterData["num_of_question"];
                    $cluster->have_question = $data["have_question"] == "yes" ? true : false;
                    $cluster->part_id = $part->id;
                    $cluster->save();
                };
            } else {
                $part->have_cluster = false;
                $part->save();
            }
        }
        if (session('task_url')) {
            return redirect(session('task_url'))->with('templateCreateSuccess', 'Template created successfully');
        }
        return redirect()->route('admin.template.index')->with('templateCreateSuccess', 'Template created successfully');
    }

    public function edit($id)
    {
        $data["template"] = TestTemplate::find($id);
        return view('admin.template.edit')->with('data', $data);
    }

    public function update(UpdateTemplateRequest $request, $id)
    {
        $template = TestTemplate::find($id);
        $template->name = $request->name;
        $template->description = $request->description;
        $template->num_of_part = $request->num_of_part;
        $template->num_of_question = $request->num_of_question;
        $template->duration = $request->duration;
        $template->status = $request->status;
        $template->type = $request->type;
        $template->have_score_range = $request->have_score_range == "yes" ? true : false;
        $template->have_audio_file = $request->have_audio_file == "yes" ? true : false;
        $template->save();
        $template->partTemplates()->delete();
        if ($request->has('parts')) {
            foreach ($request["parts"] as $data) {
                $part = new PartTemplate;
                $part->name = $data["name"];
                $part->type = $data["type"];
                $part->order_in_test = $data["order_in_test"];
                $part->description = $data["description"];
                $part->num_of_question = $data["num_of_question"];
                $part->num_of_answer = $data["num_of_answer"];
                $part->have_attachment = $data["have_attachment"] == "yes" ? true : false;
                $part->have_question = $data["have_question"] == "yes" ? true : false;
                $part->test_id = $template->id;
                if (array_key_exists("cluster", $data)) {
                    $part->have_cluster = true;
                    $part->save();
                    foreach ($data["cluster"] as $clusterData) {
                        $cluster = new ClusterTemplate;
                        $cluster->num_in_part = $clusterData["num_in_part"];
                        $cluster->num_of_question = $clusterData["num_of_question"];
                        $cluster->have_question = $data["have_question"] == "yes" ? true : false;
                        $cluster->part_id = $part->id;
                        $cluster->save();
                    };
                } else {
                    $part->have_cluster = false;
                    $part->save();
                }
            }
        }
        if (session('task_url')) {
            return redirect(session('task_url'))->with('templateUpdateSuccess', 'Template updated successfully');
        }
        return redirect()->route('admin.template.index')->with('templateUpdateSuccess', 'Template updated successfully');
    }

    public function destroy($id)
    {
        $template = TestTemplate::find($id);
        $template->delete();
        if (session('task_url')) {
            return redirect(session('task_url'))->with('deleteTemplateSuccessfully', 'Template deleted successfully');
        }
        return redirect()->route('admin.blog.index')->with('deleteTemplateSuccessfully', 'Template deleted successfully');
    }

    public function search(Request $request)
    {
        $data["templates"] = TestTemplate::where('name', 'like', '%' . $request->search . '%')->paginate(5);
        return view('admin.template.list')->with('data', $data);
    }
}
