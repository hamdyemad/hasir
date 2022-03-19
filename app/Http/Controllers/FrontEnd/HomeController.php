<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Mail\SendMail;
use App\Models\Message;
use App\Models\Order;
use App\Models\Project;
use App\Models\ProjectInfos;
use App\Models\Status;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function home_page()
    {
        return view('frontend.home');
    }

    public function services_page() {
        return view('frontend.services');
    }

    public function projects_page() {
        return view('frontend.projects');
    }

    public function clients_page() {
        return view('frontend.clients');
    }

    public function contact_us_page() {
        return view('frontend.contact_us');
    }

    public function order_page(Project $project, ProjectInfos $info) {
        return view('frontend.order', compact('project', 'info'));
    }


    public function order_store(Request $request, ProjectInfos $info) {
        $status = Status::where('default_val' ,1)->first();
        if($status) {
            $validator_array = [
                'project_id' => 'required|exists:projects,id',
                'info_id' => 'required|exists:project_infos,id',
                'client_name' => 'required',
                'client_phone' => 'required',
                'client_email' => 'required|email',
            ];
            $validator_array_msgs = [
                'client_name.required' => 'الأسم مطلوب',
                'client_phone.required' => 'الهاتف مطلوب',
                'client_email.required' => 'البريد الألكترونى مطلوب',
                'client_email.email' => 'يجب كتابة بريد الكترونى',
            ];
            $validator = Validator::make($request->all(), $validator_array, $validator_array_msgs);
            if($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput($request->all())->with('error', 'يوجد خطأ ما');
            }

            Order::create([
                'project_id' => $request->project_id,
                'info_id' => $info->id,
                'info_status' => $info->status,
                'status_id' => $status->id,
                'client_name' => $request->client_name,
                'client_phone' => $request->client_phone,
                'client_email' => $request->client_email,
            ]);
            return redirect(route('frontend.home'))->with('success', 'تم ارسال طلبك بنجاح');
        } else {
            return redirect(route('frontend.home'))->with('error', 'يجب أن يتم انشاء حالات للطلب أولا');
        }
    }

    public function project_page(Project $project) {
        return view('frontend.project', compact('project'));
    }

    public function send_message_page() {
        return view('frontend.send_message');
    }

    public function send_message(Request $request) {
        $status = Status::where('default_val', 1)->first();
        if($status) {
            $rules = [
                'name' => 'required',
                'type' => 'required',
                'email' => 'required|email',
                'phone' => 'required'
            ];
            $messages = [
                'name.required' => 'الأسم مطلوب',
                'type.required' => 'نوع الطلب مطلوب',
                'email.required' => 'البريد الألكترونى مطلوب',
                'email.email' => 'البريد الألكترونى يجب أن يكون بريد',
                'phone.required' => 'الجوال مطلوب',
            ];
            $creation = [
                'status_id' => $status->id,
                'name' => $request->name,
                'type' => $request->type,
                'email' => $request->email,
                'phone' => $request->phone,
                'notes' => $request->notes,
            ];
            if($request->has('project_id')) {
                unset($rules['type']);
                $creation['project_id'] = $request->project_id;
                $request['type'] = 'مستثمر';
                $creation['type'] = 'مستثمر';
                $request['notes'] = '';
            }
            $validator = Validator::make($request->all(),$rules,$messages);
            if($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInputs($request->all());
            }
            try {
                Mail::to(get_setting('email'))->send(new SendMail($request->all()));
            } catch (\Throwable $th) {
                // return redirect()->back()->with('error', 'قد يكون الميل الخاص بحصير تحت الصيانة');
            }
            Message::create($creation);
            return redirect()->back()->with('success', 'تم الأرسال بنجاح');
        } else {
            return redirect()->back()->with('error', 'يجب انشاء حالات أولا');
        }
    }

}
