@extends('layouts.master')

@section('title')
الطلبات
@endsection

@section('content')
    @component('common-components.breadcrumb')
        @slot('title') الطلبات @endslot
        @slot('li1') لوحة التحكم @endslot
        @slot('route1') {{ route('dashboard') }} @endslot
        @slot('li3') الطلبات @endslot
    @endcomponent
    <div class="all_orders">
        <div class="card">
            <div class="card-header">
                <div class="d-flex flex-column flex-md-row text-center text-md-right justify-content-between">
                    <h2>الطلبات</h2>
                    @can('orders.create')
                        <div>
                            <a href="{{ route('orders.create') }}" class="btn btn-primary mb-2">أنشاء طلب جديد</a>
                        </div>
                    @endcan
                </div>
                <form action="{{ route('orders.index') }}" method="GET">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="customer_name">أسم العميل</label>
                                <input class="form-control" name="customer_name" type="text" value="{{ request('customer_name') }}">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="customer_phone">رقم العميل</label>
                                <input class="form-control" name="customer_phone" type="text" value="{{ request('customer_phone') }}">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="customer_address">عنوان العميل</label>
                                <input class="form-control" name="customer_address" type="text" value="{{ request('customer_address') }}">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="name">حالة الطلب</label>
                                <select class="form-control select2" name="status_id">
                                    <option value="">أختر الحالة</option>
                                    @foreach ($statuses as $status)
                                        <option value="{{ $status->id }}" @if ($status->id == request('status_id')) selected @endif>
                                            {{ $status->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        @if(Auth::user()->type == 'admin')
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="name">نوع الطلب</label>
                                    <select class="form-control select2" name="type">
                                        <option value="">أختر النوع</option>
                                        <option value="inhouse" @if ('inhouse' == request('type')) selected @endif>طلب أستلام من الفرع</option>
                                        <option value="online" @if ('online' == request('type')) selected @endif>طلب أونلاين</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="name">الفرع</label>
                                    <select class="form-control select2" name="branch_id">
                                        <option value="">أختر الفرع</option>
                                        @foreach ($branches as $branch)
                                            <option value="{{ $branch->id }}" @if ($branch->id == request('branch_id')) selected @endif>
                                                {{ $branch->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @endif
                        <div class="col-6">
                            <div class="form-group">
                                <label for="name"></label>
                                <input type="submit" value="بحث" class="form-control btn btn-primary mt-1">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table mb-0">

                        <thead>
                            <tr>
                                <th><span>رقم الطلب</span></th>
                                <th>أسم العميل</th>
                                <th>عنوان العميل</th>
                                <th>المدينة</th>
                                <th>رقم العميل</th>
                                <th><span>حالة الطلب</span></th>
                                <th><span>فرع الطلب</span></th>
                                <th><span>وقت الأنشاء</span></th>
                                <th><span>وقت أخر تعديل</span></th>
                                <th>الأعدادات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr id="{{ $order->id }}" data-value="{{ $order }}">
                                    <th scope="row">{{ $order->id }}</th>
                                    @if($order->customer_name)
                                        <td>{{ $order->customer_name }}</td>
                                    @else
                                        <td><div class="badge badge-secondary">لا يوجد أسم</div></td>
                                    @endif
                                    @if($order->customer_address)
                                        <td>{{ $order->customer_address }}</td>
                                    @else
                                        <td><div class="badge badge-secondary">لا يوجد عنوان</div></td>
                                    @endif
                                    @if($order->city)
                                        <td>
                                            {{ $order->city->name }}
                                        </td>
                                    @else
                                    <td><div class="badge badge-secondary">لا يوجد مدينة</div></td>
                                    @endif
                                    @if($order->customer_phone)
                                        <td>{{ $order->customer_phone }}</td>
                                    @else
                                        <td><div class="badge badge-secondary">لا يوجد هاتف</div></td>
                                    @endif
                                    <td>
                                        <select class="form-control status select2" name="" id="">
                                            @foreach ($statuses as $status)
                                                <option value="{{ $status->id }}" @if($order->status_id == $status->id) selected @endif>{{ $status->name }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <div class="badge badge-primary p-2">({{ $order->branch->name }})</div>
                                        @if($order->type == 'online')
                                            <div class="badge badge-primary mt-2">طلب أونلاين</div>
                                        @endif
                                    </td>
                                    <td>
                                        <span>{{ $order->created_at->diffForHumans() }}</span>
                                    </td>
                                    <td>
                                        <span>{{ $order->updated_at->diffForHumans() }}</span>
                                    </td>
                                    <td>
                                        <div class="options d-flex">
                                            @can('orders.show')
                                                <a class="btn btn-success mr-1" href="{{ route('orders.show', $order) }}">
                                                    <span>اظهار</span>
                                                    <span class="mdi mdi-eye"></span>
                                                </a>
                                            @endcan
                                            @can('orders.edit')
                                                <a class="btn btn-info mr-1" href="{{ route('orders.edit', $order) }}">
                                                    <span>تعديل</span>
                                                    <span class="mdi mdi-circle-edit-outline"></span>
                                                </a>

                                            @endcan
                                            @can('orders.destroy')
                                                <button class="btn btn-danger" data-toggle="modal"
                                                    data-target="#modal_{{ $order->id }}">
                                                    <span>ازالة</span>
                                                    <span class="mdi mdi-delete-outline"></span>
                                                </button>
                                                <!-- Modal -->
                                                @include('layouts.partials.modal', [
                                                'id' => $order->id,
                                                'route' => route('orders.destroy', $order->id)
                                                ])
                                            @endcan
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="8">
                                        <div class="products d-flex">
                                            <div class="product-variants d-flex">
                                                @foreach ($order->order_details->groupBy('product_id') as $key => $orderProduct)
                                                    @if(isset($orderProduct->groupBy('variant_type')['']))
                                                        @foreach ($orderProduct->groupBy('variant_type')[''] as $variant)
                                                            <ul class="variants">
                                                                <li><h6>الأسم : </h6><div class="badge badge-info rounded">{{ $variant->product->name }}</div></li>
                                                                <li><h6>السعر :</h6> <div class="badge badge-info rounded">{{ $variant->price }}</div></li>
                                                                <li><h6>الكمية : </h6><div class="badge badge-info rounded">{{ $variant->qty }}</div></li>
                                                                <li><h6>السعر الكلى : </h6><div class="badge badge-info rounded">{{ $variant->total_price }}</div></li>
                                                            </ul>
                                                        @endforeach
                                                    @else
                                                        <ul class="variants">
                                                            <li><h6>الأسم : </h6><div class="badge badge-info rounded">{{ \App\Models\Product::find($key)->name }}</div></li>
                                                        </ul>
                                                    @endif
                                                    @if(isset($orderProduct->groupBy('variant_type')['size']))
                                                        @foreach ($orderProduct->groupBy('variant_type')['size'] as $variant)
                                                            <ul class="variants">
                                                                <li><h6>الحجم : </h6><div class="badge badge-info rounded">{{ $variant->variant }}</div></li>
                                                                <li><h6>السعر :</h6> <div class="badge badge-info rounded">{{ $variant->price }}</div></li>
                                                                <li><h6>الكمية : </h6><div class="badge badge-info rounded">{{ $variant->qty }}</div></li>
                                                                <li><h6>السعر الكلى : </h6><div class="badge badge-info rounded">{{ $variant->total_price }}</div></li>
                                                            </ul>
                                                        @endforeach
                                                    @endif
                                                    @if(isset($orderProduct->groupBy('variant_type')['extra']))
                                                        @foreach ($orderProduct->groupBy('variant_type')['extra'] as $variant)
                                                            <ul class="variants">
                                                                <li><h6>الأضافة : </h6><div class="badge badge-info rounded">{{ $variant->variant }}</div></li>
                                                                <li><h6>السعر :</h6> <div class="badge badge-info rounded">{{ $variant->price }}</div></li>
                                                                <li><h6>الكمية : </h6><div class="badge badge-info rounded">{{ $variant->qty }}</div></li>
                                                                <li><h6>السعر الكلى : </h6><div class="badge badge-info rounded">{{ $variant->total_price }}</div></li>
                                                            </ul>
                                                        @endforeach
                                                    @endif
                                                @endforeach
                                            </div>
                                            <div class="product-variants d-flex">
                                                <ul class="variants">
                                                        <li><h6>السعر الكلى : </h6><div class="badge badge-info rounded">{{ ($order->grand_total - $order->shipping )+ $order->total_discount }}</div></li>
                                                        @if($order->shipping)
                                                            <li><h6>الشحن: </h6><div class="badge badge-info rounded">{{ $order->shipping }}</div></li>
                                                        @endif
                                                        @if($order->total_discount)
                                                            <li><h6>الخصم: </h6><div class="badge badge-info rounded">{{ $order->total_discount }}</div></li>
                                                        @endif
                                                        <li><h6>السعر النهائى : </h6><div class="badge badge-info rounded">{{ $order->grand_total }}</div></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $orders->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection


@section('footerScript')
    <script>
        orderChannel.bind('App\\Events\\newOrder', function(data) {
            if(data) {
                if(data.order.branch_id == "{{ Auth::user()->branch_id }}" || "{{Auth::user()->type}}" == 'admin') {
                    window.location.reload();
                }
            }
        });

        let statusChannel = pusher.subscribe('changeOrderStatus');
        statusChannel.bind('App\\Events\\changeOrderStatus', function(data) {
            if(data) {
                if(data.order.branch_id == "{{ Auth::user()->branch_id }}") {
                    window.location.reload();
                }
                // $(`#${data.order.id} .status`).select2("val", data.status_id);
            }
        });

        $(".status").on('change', function () {
            $("#preloader_all").removeClass('d-none');
            let token = $("meta[name=_token]").attr('content'),
            order_id = $(this).parent().parent().attr('id'),
            user_id = "{{ Auth::id() }}",
            status_id = $(this).val();
            $.ajax({
                "method": "POST",
                "data": {
                    "_token": token,
                    "order_id" : order_id,
                    "user_id" : user_id,
                    "status_id": status_id
                },
                "url": "{{ route('orders.status_update') }}",
                "success": function(data) {
                    if(data.status) {
                        toastr.success(data.msg);
                    }
                    $("#preloader_all").addClass('d-none');
                },
                "error": function(err) {
                    console.log(err);
                }
            })
        })
    </script>
@endsection
