@extends('layouts.master')


@section('title')
انشاء فرع جديد
@endsection
@section('content')
    @component('common-components.breadcrumb')
        @slot('title') الفروع @endslot
        @slot('li1') لوحة التحكم @endslot
        @slot('li2') الفروع @endslot
        @slot('route1') {{ route('dashboard') }} @endslot
        @slot('route2') {{ route('branches.index') }} @endslot
        @slot('li3') انشاء فرع جديد @endslot
    @endcomponent
    <div class="create">
        <div class="container">
            <div class="card">
                <div class="card-header">
                    انشاء فرع جديد
                </div>
                <div class="card-body">
                    <form action="{{ route('branches.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="name">أسم الفرع</label>
                                    <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                                    @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="name">رقم الفرع</label>
                                    <input type="number" class="form-control" name="phone" value="{{ old('phone') }}">
                                    @error('phone')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="name">عنوان الفرع</label>
                                    <input type="text" class="form-control" name="address" value="{{ old('address') }}">
                                    @error('address')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for=""></label>
                                    <input type="submit" value="أنشاء" class="btn btn-success">
                                    <a href="{{ route('branches.index') }}" class="btn btn-info">رجوع الى الفروع</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
