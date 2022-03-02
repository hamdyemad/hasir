@extends('layouts.master')

@section('title')
انشاء صنف جديد
@endsection
@section('content')
    @component('common-components.breadcrumb')
        @slot('title') الأصناف @endslot
        @slot('li1') لوحة التحكم @endslot
        @slot('li2') الأصناف @endslot
        @slot('route1') {{ route('dashboard') }} @endslot
        @slot('route2') {{ route('categories.index') }} @endslot
        @slot('li3') انشاء صنف جديد @endslot
    @endcomponent
    <div class="create_category">
        <div class="container">
            <div class="card">
                <div class="card-header">
                    انشاء صنف جديد
                </div>
                <div class="card-body">
                    <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="name">أسم الصنف</label>
                                    <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                                    @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="name">صورة الصنف</label>
                                    <input type="file" class="form-control input_files" accept="image/*" hidden name="photo"
                                        value="{{ old('photo') }}">
                                    <button type="button" class="btn btn-primary form-control files">
                                        <span class="mdi mdi-plus btn-lg"></span>
                                    </button>
                                    <div class="imgs mt-2 d-flex"></div>
                                </div>
                            </div>
                            @if(Auth::user()->type == 'admin')
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label for="category">الفرع</label>
                                        <select class="form-control select2" name="branch_id">
                                            <option value="">أختر الفرع</option>
                                            @foreach ($branches as $branch)
                                                <option value="{{ $branch->id }}" @if (old('branch_id') == $branch->id) selected @endif>{{ $branch->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('branch_id')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            @else
                            <input type="hidden" name="branch_id" value="{{ Auth::user()->branch_id }}">
                            @endif
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="name">رقم الظهور</label>
                                    <input type="integer" class="form-control" name="viewed_number" value="{{ old('viewed_number') }}">
                                    @error('viewed_number')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="مرئى">مرئى</label>
                                <div class="form-group">
                                    <input type="checkbox" name="active" id="switch4" switch="bool" checked />
                                    <label for="switch4" data-on-label="Yes" data-off-label="No"></label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for=""></label>
                                    <input type="submit" value="أنشاء" class="btn btn-success">
                                    <a href="{{ route('categories.index') }}" class="btn btn-info">رجوع الى الأصناف</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection