@extends('layouts.master')

@section('title')
المستثمرين
@endsection

@section('content')
    @component('common-components.breadcrumb')
        @slot('title') المستثمرين @endslot
        @slot('li1') لوحة التحكم @endslot
        @slot('route1') {{ route('dashboard') }} @endslot
        @slot('li3') المستثمرين @endslot
    @endcomponent
    <div class="all_messages">
        <div class="card">
            <div class="card-header">
                <div class="d-flex flex-column flex-md-row text-center text-md-right justify-content-between">
                    <h2>المستثمرين</h2>
                </div>
                <form action="{{ route('messages.index') }}" method="GET">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="project_id">أسم المشروع</label>
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
                                <label for="status_id">الحالة</label>
                                <select name="status_id" class="form-control select2">
                                    <option value="">أختر حالة</option>
                                    @foreach ($statuses as $status)
                                        <option @if($status->id == request('status_id')) selected @endif value="{{ $status->id }}">{{ $status->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="type">نوع الطلب</label>
                                <select name="type" class="form-control select2">
                                    <option value="">أختر نوع الطلب</option>
                                    <option @if('مستثمر' == request('type')) selected @endif value="مستثمر">مستثمر</option>
                                    <option @if('طالب عقار' == request('type')) selected @endif value="طالب عقار">طالب عقار</option>
                                    <option @if('أخرى' == request('type')) selected @endif value="أخرى">أخرى</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="name">الأسم</label>
                                <input class="form-control" name="name" type="text" value="{{ request('name') }}">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="email">البريد الألكترونى</label>
                                <input class="form-control" name="email" type="email" value="{{ request('email') }}">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="phone">الجوال</label>
                                <input class="form-control" name="phone" type="text" value="{{ request('phone') }}">
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
                                <th><span>أسم المشروع</span></th>
                                <th><span>الأسم</span></th>
                                <th><span>نوع الطلب</span></th>
                                <th><span>البريد الألكترونى</span></th>
                                <th><span>الجوال</span></th>
                                <th><span>حالة الطلب</span></th>
                                <th><span>الملاحظات</span></th>
                                <th><span>وقت الأنشاء</span></th>
                                <th><span>وقت أخر تعديل</span></th>
                                <th>الأعدادات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($messages as $message)
                                <tr id="{{ $message->id }}">
                                    <th scope="row">{{ $message->id }}</th>
                                    <td>
                                        @if($message->project)
                                            <span>{{ $message->project->name }}</span>
                                        @else
                                        --
                                        @endif
                                    </td>
                                    <td><span>{{ $message->name }}</span></td>
                                    <td><span>{{ $message->type }}</span></td>
                                    <td><span>{{ $message->email }}</span></td>
                                    <td><span>{{ $message->phone }}</span></td>
                                    <td>
                                        <select name="status_id" class="form-control select2 status">
                                            <option value="">أختر حالة الطلب</option>
                                            @foreach ($statuses as $status)
                                                <option @if($status->id == $message->status_id) selected @endif value="{{ $status->id }}">{{ $status->name }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td><span>
                                        {{ $message->notes }}
                                    </span></td>
                                    <td>
                                        <span>{{ $message->created_at->diffForHumans() }}</span>
                                    </td>
                                    <td>
                                        <span>{{ $message->updated_at->diffForHumans() }}</span>
                                    </td>
                                    <td>
                                        <div class="options d-flex">
                                            @can('messages.destroy')
                                                <button class="btn btn-danger" data-toggle="modal"
                                                    data-target="#modal_{{ $message->id }}">
                                                    <span>ازالة</span>
                                                    <span class="mdi mdi-delete-outline"></span>
                                                </button>
                                                <!-- Modal -->
                                                @include('layouts.partials.modal', [
                                                'id' => $message->id,
                                                'route' => route('messages.destroy', $message->id)
                                                ])
                                            @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $messages->links() }}
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
            message_id = $(this).parent().parent().attr('id'),
            user_id = "{{ Auth::id() }}",
            status_id = $(this).val();
            console.log(token, message_id, user_id, status_id);
            $.ajax({
                "method": "POST",
                "data": {
                    "_token": token,
                    "message_id" : message_id,
                    "user_id" : user_id,
                    "status_id": status_id
                },
                "url": "{{ route('messages.status_update') }}",
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
