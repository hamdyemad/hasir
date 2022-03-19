<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\Project;
use App\Models\Status;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MessagesController extends Controller
{
    public function index(Request $request) {
        Carbon::setLocale('ar');
        $projects = Project::all();
        if($request->type == 'مستثمر') {
            $messages = Message::where('project_id', '!=', null)->latest();
        } else {
            $messages = Message::where('project_id', null)->latest();
        }
        $statuses = Status::orderBy('default_val', 'DESC')->get();

        if($request->status_id) {
            $messages = $messages->where('status_id', 'like', '%' . $request->status_id . '%');
        }
        if($request->project_id) {
            $messages = $messages->where('project_id', $request->project_id);
        }
        if($request->type) {
            $messages = $messages->where('type', 'like', '%' . $request->type . '%');
        }
        if($request->name) {
            $messages = $messages->where('name', 'like', '%' . $request->name . '%');
        }
        if($request->email) {
            $messages = $messages->where('email', 'like', '%' . $request->email . '%');
        }
        if($request->phone) {
            $messages = $messages->where('phone', 'like', '%' . $request->phone . '%');
        }
        $messages = $messages->paginate(10);
        if($messages->count() > 0) {
            foreach ($messages as $message) {
                if($message->viewed == 0) {
                    $message->update([
                        'viewed' => 1
                    ]);
                }
            }
        }
        return view('messages.index', compact('messages', 'statuses', 'projects'));
    }

    public function updateStatus(Request $request) {
        $message = Message::find($request->message_id);
        if($message) {
            $message->update([
                'status_id' => $request->status_id
            ]);
            return response()->json(['msg' => 'تم تعديل الحالة بنجاح', 'status' => true]);
        }
    }

    public function destroy(Message $message)
    {
        Message::destroy($message->id);
        return redirect()->back()->with('success', 'تم ازالة الرسالة بنجاح');
    }
}
