<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Role;
use App\Models\UserInfo;
use App\Traits\File;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    use File;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('users.index');
        Carbon::setLocale('ar');
        $users = User::where('type', '!=', 'admin')->where('id', '!=', Auth::id());
        $roles = Role::latest()->get();
        if($request->name) {
            $users->where('name', 'like', '%' . $request->name . '%');
        }
        if($request->branch_id) {
            $users->where('branch_id', 'like', '%' . $request->branch_id . '%');
        }
        if($request->email) {
            $users->where('email', 'like', '%' . $request->email . '%');
        }
        if($request->phone) {
            $users->where('phone', 'like', '%' . $request->phone . '%');
        }
        if($request->banned) {
            $users->where('banned', 'like', '%' . $request->banned . '%');
        }
        $users = $users->latest()->paginate(10);
        return view('users.employee_index', compact('users', 'roles'));

    }

    public function profile(User $user) {
        return view('users.profile', compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('users.create');
        $roles = Role::latest()->get();
        if($roles->count() > 0) {
            return view('users.create', compact('roles'));
        } else {
            return redirect()->back()->with('error', 'يجب عليك انشاء صلاحيات أولا');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('users.create');
        $creation = [
            'name' => $request->name,
            'email' => $request->email,
            'type' => 'sub-admin',
            'address' => $request->address,
            'phone' => $request->phone,
            'password' => Hash::make($request->password)
        ];
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];
        $messages = [
            'name.required' => 'الأسم مطلوب',
            'name.string' => 'الأسم يجب أن يكون حروفا',
            'name.max' => 'يجب ادخال حروف اقل من 255',
            'email.required' => 'البريد الألكترونى مطلوب',
            'email.string' => 'البريد الألكترونى يجب أن يكون حروفا',
            'email.max' => 'يجب ادخال حروف اقل من 255',
            'email.unique' => 'البريد الألكترونى هذا موجود بالفعل',
            'password.required' =>'الرقم السرى مطلوب',
            'password.string' =>'الرقم السرى يجب أن يكون حروفا',
            'password.min' =>'ادخل حروف اكثر من 8',
            'password.confirmed' => 'يجب على الرقم السرى أن يكون مطابق',
        ];

        if($request->type == 'sub-admin') {
            $rules['roles'] = 'required|exists:roles,id';
            $messages['roles.required'] = 'الصلاحيات مطلوبة';
            $messages['roles.exists'] = 'الصلاحية غير موجودة بالبيانات';
        }
        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->with('error', 'يوجد مشكلة ما فى التسجيل')->withInput($request->all());
        }
        if($request->has('avatar')) {
            $creation['avatar'] = $this->uploadFile($request, $this->usersPath, 'avatar');
        }
        $user = User::create($creation);
        if($request->has('roles')) {
            foreach ($request->roles as $role) {
                $user->roles()->attach($role);
            }
        }
        return redirect()->back()->with('success', 'تم انشاء الحساب بنجاح');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,User $user)
    {
        $this->authorize('users.edit');
        $roles = Role::latest()->get();
        if($roles->count() > 0) {
            return view('users.edit', compact('user', 'roles'));
        } else {
            return redirect()->back()->with('error', 'يجب عليك انشاء صلاحيات أولا');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $this->authorize('users.edit');
        $updateArray = [
            'name' => $request->name,
            'email' => $request->email,
            'address' => $request->address,
            'phone' => $request->phone,
        ];
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255',Rule::unique('users', 'email')->ignore($user->id)],
            'roles' => 'required|exists:roles,id',
        ];
        $messages = [
            'name.required' => 'الأسم مطلوب',
            'name.string' => 'الأسم يجب أن يكون حروفا',
            'name.max' => 'يجب ادخال حروف اقل من 255',
            'email.required' => 'البريد الألكترونى مطلوب',
            'email.string' => 'البريد الألكترونى يجب أن يكون حروفا',
            'email.max' => 'يجب ادخال حروف اقل من 255',
            'email.unique' => 'البريد الألكترونى هذا موجود بالفعل',
            'roles.required' => 'الصلاحيات مطلوبة',
            'roles.exists' => 'الصلاحية غير موجودة بالبيانات'
        ];
        if($request->profile) {
            unset($rules['roles']);
            unset($messages['roles.required']);
            unset($messages['roles.exists']);
        }

        if($request->password !== null) {
            $updateArray['password'] = Hash::make($request->password);
        }
        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->with('error', 'يوجد مشكلة ما فى التسجيل')->withInput($request->all());
        }
        if($request->has('avatar')) {
            $updateArray['avatar'] = $this->uploadFile($request, $this->usersPath, 'avatar');
            if(file_exists($user->avatar)) {
                $img = last(explode('/', $user->avatar));
                if(in_array($img, scandir(dirname($user->avatar)))) {
                    unlink($user->avatar);
                }
            }
        }
        $user->update($updateArray);
        if($request->has('roles')) {
            // Remove All Roles
            foreach ($user->roles as $role) {
                $user->roles()->detach($role);
            }
            // Add New Roles
            foreach ($request->roles as $role) {
                $user->roles()->attach($role);
            }
        }
        return redirect()->back()->with('info', 'تم تعديل الحساب بنجاح');
    }

    public function banned(Request $request, User $user) {
        if($request->active == 'on') {
            $user->update(['banned' => 1]);
            return redirect()->back()->with('success', 'تم حظر ' . $user->name . ' بنجاح');
        } else {
            $user->update(['banned' => 0]);
            return redirect()->back()->with('success', 'تم فك حظر ' . $user->name . ' بنجاح');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $this->authorize('users.destroy');
        if(file_exists($user->avatar)) {
            $img = last(explode('/', $user->avatar));
            if(in_array($img, scandir(dirname($user->avatar)))) {
                unlink($user->avatar);
            }
        }
        User::destroy($user->id);
        return redirect()->back()->with('success', 'تمت ازالة ' . $user->name . ' بنجاح');

    }
}
