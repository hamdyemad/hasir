@extends('layouts.master')

@section('title')
انشاء عميل جديد
@endsection
@section('content')
    @component('common-components.breadcrumb')
        @slot('title') شركاء النجاح @endslot
        @slot('li1') لوحة التحكم @endslot
        @slot('li2') شركاء النجاح @endslot
        @slot('route1') {{ route('dashboard') }} @endslot
        @slot('route2') {{ route('clients.index') }} @endslot
        @slot('li3') انشاء عميل جديد @endslot
    @endcomponent
    <div class="create_project">
        <div class="container">
            <div class="card">
                <div class="card-header">
                    انشاء عميل جديد
                </div>
                <div class="card-body">
                    <form action="{{ route('clients.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="name">صورة العميل</label>
                                    <input type="file" class="form-control input_files" accept="image/*" hidden name="photo"
                                        value="{{ old('photo') }}">
                                    <button type="button" class="btn btn-primary form-control files">
                                        <span class="mdi mdi-plus btn-lg"></span>
                                    </button>
                                    <div class="imgs mt-2 d-flex"></div>
                                    @error('photo')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for=""></label>
                                    <input type="submit" value="أنشاء" class="btn btn-success">
                                    <a href="{{ route('clients.index') }}" class="btn btn-info">رجوع الى شركاء النجاح</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
