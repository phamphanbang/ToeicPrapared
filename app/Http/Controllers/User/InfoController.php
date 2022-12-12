<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\TestHistory;
use App\Models\TrainingPlan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class InfoController extends Controller
{
    public function info($id)
    {
        $data["user"] = User::find($id);
        return view('user.info.info')->with('data', $data);
    }

    public function update(Request $request)
    {
        $data["user"] = User::find($request->id);
        $data["user"]->name = $request->name;
        $data["user"]->email = $request->email;
        $data["user"]->save();
        if ($request->hasFile('avatar')) {
            $file = $request->file("avatar");
            $extension = $file->extension();
            $file->storeAs('public/images/avatar/', $data["user"]->id . '.' . $extension);
            $data["user"]->avatar = 'images/avatar/' . $data["user"]->id . '.' . $extension;
            $data["user"]->update();
        }
        return redirect()->route('user.info.info')->with('data',$data)->with('profileChangeSuccess', 'Profile changed successfully');
    }

    public function password($id)
    {
        return view("user.info.password")->with("id", $id);
    }

    public function changePassword(Request $request)
    {
        $data["user"] = User::find($request->id);
        $data["user"]->password = Hash::make($request->password);
        $check = $data["user"]->save();
        if ($check) {
            return redirect()->back()->with('id', $request->id)->with("success", "Bạn đã thay đổi mật khẩu thành công");
        }
        return redirect()->back()->with('id', $request->id)->with("fail", "Đã có sự cố xảy ra.");
    }

    public function history($id)
    {
        $hquery = TestHistory::where('user_id', '=', $id)
            ->orderBy('created_at', 'desc');
        $data["histories_count"] = $hquery->count();
        $data["histories"] = $hquery->paginate(6);
        return view('user.info.history')->with('data',$data);
    }

    public function plan($id) {
        $data["plan"] = TrainingPlan::where("user_id" ,'=',$id)->first();
        return view('user.info.plan')->with('data',$data);
    }

    public function createPlan(Request $request) {
        $data["plan"] = new TrainingPlan();
        $data["plan"]->current_score = $request->current_score;
        $data["plan"]->goal_score = $request->goal_score;
        $data["plan"]->date_end = $request->date_end;
        $data["plan"]->part_suggestion = $request->part_suggestion;
        $data["plan"]->status = "ongoing";
        $data["plan"]->save();
        return redirect()->back()->with('data',$data)->with('success',"Bạn đã tạo kế hoạch thành công");
    }

    public function deletePlan($id) {
        $plan = TrainingPlan::find($id);
        $plan->delete();
        $id = Auth::user()->id;
        return redirect()->route('user.info.plan',$id);
    }
}
