<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Project;
use App\Models\Status;
use App\Models\StatusHistory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        Carbon::setLocale('ar');
        $projects = Project::orderBy('name')->get();
        $statuses = Status::orderBy('default_val', 'DESC')->get();
        $orders = Order::latest();
        if($request->project_id) {
            $orders = $orders->where('project_id', 'like', '%' . $request->project_id . '%');
        }
        if($request->client_name) {
            $orders = $orders->where('client_name', 'like', '%' . $request->client_name . '%');
        }
        if($request->client_phone) {
            $orders = $orders->where('client_phone', 'like', '%' . $request->client_phone . '%');
        }
        if($request->client_email) {
            $orders = $orders->where('client_email', 'like', '%' . $request->client_email . '%');
        }
        $orders = $orders->paginate(10);
        if($orders->count() > 0) {
            foreach ($orders as $order) {
                if($order->viewed == 0) {
                    $order->update([
                        'viewed' => 1
                    ]);
                }
            }
        }
        return view('orders.index', compact('orders', 'projects', 'statuses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }
    public function updateStatus(Request $request) {
        $order = Order::find($request->order_id);
        if($order) {
            $order->update([
                'status_id' => $request->status_id
            ]);
            StatusHistory::create([
                'user_id' => $request->user_id,
                'order_id' => $order->id,
                'status_id' => $request->status_id
            ]);
            return response()->json(['msg' => 'تم تعديل الحالة بنجاح', 'status' => true]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        Order::destroy($order->id);
        return redirect()->back()->with('success', 'تم ازالة الطلب بنجاح');
    }
}
