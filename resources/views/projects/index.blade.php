@extends('layouts.master')


@section('title')
المشاريع
@endsection

@section('content')
    @component('common-components.breadcrumb')
        @slot('title') المشاريع @endslot
        @slot('li1') لوحة التحكم @endslot
        @slot('route1') {{ route('dashboard') }} @endslot
        @slot('li3') كل المشاريع @endslot
    @endcomponent
    <div class="all_projects">
        <div class="card">
            <div class="card-header">
                <div class="d-flex flex-column flex-md-row text-center text-md-right justify-content-between">
                    <h2>المشاريع</h2>
                    @can('projects.create')
                        <div>
                            <a href="{{ route('projects.create') }}" class="btn btn-primary mb-2">أنشاء مشروع جديد</a>
                        </div>
                    @endcan
                </div>
                <form action="{{ route('projects.index') }}" method="GET">
                    <div class="row">
                        <div class="col-6 col-md-4 col-lg-3">
                            <div class="form-group">
                                <label for="name">أسم المشروع</label>
                                <input class="form-control" name="name" type="text" value="{{ request('name') }}">
                            </div>
                        </div>
                        <div class="col-6 col-md-4 col-lg-3">
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
                                <th><span>عدد الوحدات</span></th>
                                <th><span>الوحدات المتاحة</span></th>
                                <th><span>عدد المبانى</span></th>
                                <th><span>وصف المشروع</span></th>
                                <th><span>مميزات الموقع</span></th>
                                <th>مرئى</th>
                                <th><span>رقم الظهور</span></th>
                                <th><span>وقت الأنشاء</span></th>
                                <th><span>وقت أخر تعديل</span></th>
                                <th>الأعدادات</th>
                            </tr>
                        </thead>
                        @foreach ($projects as $project)
                            <tbody>
                                <tr>
                                    <th scope="row">{{ $project->id }}</th>
                                    <td>
                                        <div>
                                            <span class="d-block">{{ $project->name }}</span>
                                            @if ($project->photos !== null)
                                                <img class="mt-2" src="{{ asset(json_decode($project->photos)[0]) }}" alt="">
                                            @else
                                                <img class="mt-2" src="{{ asset('/images/product_avatar.png') }}"
                                                    alt="">
                                            @endif
                                        </div>
                                    </td>
                                    <td>{{ $project->units }}</td>
                                    <td>{{ $project->available_units }}</td>
                                    <td>{{ $project->buildings }}</td>
                                    <td><p>
                                        @if(strlen($project->description) > 30)
                                            {{ mb_substr($project->description, 0, 30) . '...' }}
                                        @else
                                            {{ $project->description }}
                                        @endif
                                    </p></td>
                                    <td><p>
                                        @if(strlen($project->location_features) > 30)
                                            {{ mb_substr($project->location_features, 0, 30) . '...' }}
                                        @else
                                            {{ $project->location_features }}
                                        @endif
                                    </p></td>
                                    <td>
                                        @if($project->active)
                                            <div class="badge badge-success font-size-14 p-2">مرئى</div>
                                        @else
                                        <div class="badge badge-danger">غير مرئى</div>
                                        @endif
                                    </td>
                                    <td>{{ $project->viewed_number }}</td>
                                    <td>{{ $project->created_at->diffForHumans() }}</td>
                                    <td>{{ $project->updated_at->diffForHumans() }}</td>
                                    <td>
                                        <div class="options d-flex">
                                            @can('projects.edit')
                                                <a class="btn btn-info mr-1"
                                                    href="{{ route('projects.edit', $project) }}">
                                                    <span>تعديل</span>
                                                    <span class="mdi mdi-circle-edit-outline"></span>
                                                </a>
                                            @endcan
                                            @can('projects.destroy')
                                                <button class="btn btn-danger" data-toggle="modal"
                                                    data-target="#modal_{{ $project->id }}">
                                                    <span>ازالة</span>
                                                    <span class="mdi mdi-delete-outline"></span>
                                                </button>
                                                <!-- Modal -->
                                                @include('layouts.partials.modal', [
                                                'id' => $project->id,
                                                'route' => route('projects.destroy', $project->id)
                                                ])
                                            @endcan
                                    </td>
                                </tr>
                                @if($project->infos->count() > 0)
                                    <tr>
                                        <th>الدور</th>
                                        <th>رقم الشقة</th>
                                        <th><span>مواصفات الشقة</span></th>
                                        <th>المساحة</th>
                                        <th><span>مميزات الشقة</span></th>
                                        <th>السعر</th>
                                        <th>الحالة</th>
                                    </tr>
                                    @foreach ($project->infos as $info)
                                        <tr>
                                            <td><span>{{ $info->round }}</span></td>
                                            <td><span>{{ $info->rooms }}</span></td>
                                            <td><p>
                                                @if(strlen($info->description) > 30)
                                                    {{ mb_substr($info->description, 0, 30) . '...' }}
                                                @else
                                                    {{ $info->description }}
                                                @endif
                                            </p></td>
                                            <td><p>
                                                @if(strlen($info->space) > 30)
                                                    {{ mb_substr($info->space, 0, 30) . '...' }}
                                                @else
                                                    {{ $info->space }}
                                                @endif
                                            </p></td>
                                            <td><p>
                                                @if(strlen($info->features) > 30)
                                                    {{ mb_substr($info->features, 0, 30) . '...' }}
                                                @else
                                                    {{ $info->features }}
                                                @endif
                                            </p></td>
                                            <td><span>{{ $info->price }}</span></td>
                                            <td>
                                                <div class="badge badge-info">{{ $info->status }}</div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        @endforeach
                    </table>
                    {{ $projects->links() }}
                </div>
            </div>
        </div>
    </div>

@endsection
