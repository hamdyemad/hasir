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
                </div>
                <form action="{{ route('orders.index') }}" method="GET">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="project_id">المشروع</label>
                                <select name="project_id" class="form-control select2">
                                    <option value="">أختر المشروع</option>
                                    @foreach ($projects as $project)
                                        <option @if($project->id == request('project_id')) selected @endif value="{{ $project->id }}">{{ $project->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="status_id">حالة الطلب</label>
                                <select name="status_id" class="form-control select2">
                                    <option value="">أختر حالة الطلب</option>
                                    @foreach ($statuses as $status)
                                        <option @if($status->id == request('status_id')) selected @endif value="{{ $status->id }}">{{ $status->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="client_name">أسم العميل</label>
                                <input class="form-control" name="client_name" type="text" value="{{ request('client_name') }}">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="client_phone">الجوال</label>
                                <input class="form-control" name="client_phone" type="text" value="{{ request('client_phone') }}">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="client_email">البريد الالكترونى</label>
                                <input class="form-control" name="client_email" type="text" value="{{ request('client_email') }}">
                            </div>
                        </div>
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
                                <th>#</th>
                                <th><span>المشروع</span></th>
                                <th><span>الدور</span></th>
                                <th><span>حالة الدور</span></th>
                                <th><span>أسم العميل</span></th>
                                <th><span>الجوال</span></th>
                                <th><span>البريد الألكترونى</span></th>
                                <th><span>حالة الطلب</span></th>
                                <th><span>وقت الأنشاء</span></th>
                                <th><span>وقت أخر تعديل</span></th>
                                <th>الأعدادات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr id="{{ $order->id }}">
                                    <th scope="row">{{ $order->id }}</th>
                                    <td><span>{{ $order->project->name }}</span></td>
                                    <td><span>{{ $order->info->round }}</span></td>
                                    <td><span>{{ $order->info_status }}</span></td>
                                    <td><span>{{ $order->client_name }}</span></td>
                                    <td><span>{{ $order->client_phone }}</span></td>
                                    <td><span>{{ $order->client_email }}</span></td>
                                    <td>
                                        <select name="status_id" class="form-control select2 status">
                                            <option value="">أختر حالة الطلب</option>
                                            @foreach ($statuses as $status)
                                                <option @if($status->id == $order->status_id) selected @endif value="{{ $status->id }}">{{ $status->name }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <span>{{ $order->created_at->diffForHumans() }}</span>
                                    </td>
                                    <td>
                                        <span>{{ $order->updated_at->diffForHumans() }}</span>
                                    </td>
                                    <td>
                                        <div class="options d-flex">
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
        $(".status").on('change', function () {
            $("#preloader_all").removeClass('d-none');
            let token = $("meta[name=_token]").attr('content'),
            order_id = $(this).parent().parent().attr('id'),
            user_id = "{{ Auth::id() }}",
            status_id = $(this).val();
            console.log(token, order_id, user_id, status_id);
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
                    console.log(data);
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
