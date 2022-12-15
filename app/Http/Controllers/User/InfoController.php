<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\TestHistory;
use App\Models\TrainingPlan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\User\UserChangePasswordRequest;
use App\Http\Requests\User\InfoUpdateRequest;

class InfoController extends Controller
{
    public function info($id)
    {
        if (Auth::user()->id != $id) {
            return redirect()->back();
        }
        $data["user"] = User::find($id);
        return view('user.info.info')->with('data', $data);
    }

    public function update(InfoUpdateRequest $request,$id)
    {
        if (Auth::user()->id != $id) {
            return redirect()->back();
        }
        $data["user"] = User::find($id);
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
        return redirect()->route('user.info.info',$id)->with('data',$data)->with('success', 'Cập nhật thông tin thành công');
    }

    public function password($id)
    {
        if (Auth::user()->id != $id) {
            return redirect()->back();
        }
        $data["user"] = User::find($id);
        return view("user.info.password")->with("id", $id)->with("data",$data);
    }

    public function changePassword(UserChangePasswordRequest $request,$id)
    {
        if (Auth::user()->id != $id) {
            return redirect()->back();
        }
        $data["user"] = User::find($id);
        // $old_pasword = Hash::make($request->pastpass);
        if(Hash::check($request->pastpass,$data["user"]->password)) {
            $data["user"]->password = Hash::make($request->password);
            $check = $data["user"]->save();
        }
        else {
            return redirect()->back()->with("fail", "Mật khẩu cũ không đúng.");
        }
        
        if ($check) {
            return redirect()->back()->with('id', $id)->with("success", "Bạn đã thay đổi mật khẩu thành công");
        }
        return redirect()->back()->with('id', $id)->with("fail", "Đã có sự cố xảy ra.");
    }

    public function history($id)
    {
        if (Auth::user()->id != $id) {
            return redirect()->back();
        }
        $data["user"] = User::find($id);
        $hquery = TestHistory::where('user_id', '=', $id)
            ->orderBy('created_at', 'desc');
        $data["histories_count"] = $hquery->count();
        $data["histories"] = $hquery->paginate(4);
        return view('user.info.history')->with('data',$data);
    }

    public function plan($id) {
        if (Auth::user()->id != $id) {
            return redirect()->back();
        }
        $data["user"] = User::find($id);
        $data["plan"] = TrainingPlan::where("user_id" ,'=',$id)->first();
        $data["fulltest"] = TestHistory::where("score","!=",null)->orderBy("created_at","desc")->first();
        return view('user.info.plan')->with('data',$data);
    }

    public function createPlan(Request $request,$id) {
        if (Auth::user()->id != $id) {
            return redirect()->back();
        }
        $data["plan"] = new TrainingPlan();
        $data["plan"]->user_id = $id;
        $data["plan"]->current_score = $request->current_score;
        $data["plan"]->goal_score = $request->goal_score;
        $data["plan"]->date_end = $request->date_end;
        $data["plan"]->part_suggestion = $request->part_suggestion;
        $data["plan"]->status = "ongoing";
        $data["plan"]->save();
        return redirect()->back()->with('data',$data)->with('success',"Bạn đã tạo kế hoạch thành công");
    }

    public function updatePlan(Request $request,$id,$pid) {
        if (Auth::user()->id != $id) {
            return redirect()->back();
        }
        $data["plan"] = TrainingPlan::find($pid);
        $data["plan"]->current_score = $request->current_score;
        $data["plan"]->goal_score = $request->goal_score;
        $data["plan"]->date_end = $request->date_end;
        $data["plan"]->part_suggestion = $request->part_suggestion;
        $data["plan"]->status = "ongoing";
        $data["plan"]->save();
        return redirect()->back()->with('data',$data)->with('success',"Bạn đã cập nhật kế hoạch thành công");
    }

    public function deletePlan($id,$pid) {
        if (Auth::user()->id != $id) {
            return redirect()->back();
        }
        $plan = TrainingPlan::find($pid);
        $plan->delete();
        return redirect()->route('user.info.plan',$id);
    }
}
