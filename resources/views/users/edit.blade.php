@extends('layouts.master')

@section('title')
تعديل الموظف
@endsection

@section('content')
    @component('common-components.breadcrumb')
        @slot('title') {{ $user->name }} @endslot
        @slot('li1') لوحة التحكم @endslot
        @slot('route1') {{ route('dashboard') }} @endslot
        @slot('li2') كل الموظفين @endslot
        @slot('route2') {{ route('users.index') }} @endslot
        @slot('li3') {{ $user->name }} @endslot
    @endcomponent
    <div class="create_user">
        <div class="container">
            <div class="card">
                <div class="card-header">
                    تعديل الموظف
                </div>
                <div class="card-body">
                    <form class="form-horizontal mt-4" method="POST" action="{{ route('users.update', $user) }}"
                        enctype="multipart/form-data">
                        @method("PATCH")
                        @csrf
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="name">الأسم</label>
                                    <input type="text" name="name" value="{{ $user->name }}"
                                        class="form-control" placeholder="ادخل الأسم">
                                    @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="category">الصلاحيات</label>
                                    <select class="form-control select2 select2-multiple" name="roles[]"
                                        data-placeholder="أختر الصلاحيات" multiple>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}" @if ($user->roles->contains($role->id)) selected @endif>
                                                {{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('roles')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="useremail">البريد الألكترونى</label>
                                    <input type="email" name="email" class="form-control" name="email"
                                        value="{{ $user->email }}" id="useremail" placeholder="أدخل البريد الألكترونى"
                                        autocomplete="email">
                                    @error('email')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="name">الصورة الشخصية</label>
                                    <input type="file" class="form-control input_files" accept="image/*" hidden
                                        name="avatar" value="{{ old('avatar') }}">
                                    <button type="button" class="btn btn-primary form-control files">
                                        <span class="mdi mdi-plus btn-lg"></span>
                                    </button>
                                    <div class="imgs mt-2 d-flex">
                                        @if ($user->avatar)
                                            <img class="rounded" src="{{ asset($user->avatar) }}" alt="">
                                        @else
                                            <img class="rounded" src="{{ asset('images/avatar.jpg') }}" alt="">
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="username">الهاتف</label>
                                    <input type="text" name="phone" value="{{ $user->phone }}" autocomplete="phone"
                                        class="form-control" autofocus id="name" placeholder="أدخل الهاتف">
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="username">العنوان</label>
                                    <input type="text" name="address" value="{{ $user->address }}" autocomplete="address"
                                        class="form-control" autofocus id="name" placeholder="أدخل العنوان">
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="userpassword">الرقم السرى</label>
                                    <input type="password" class="form-control" name="password"
                                        autocomplete="new-password" id="userpassword" placeholder="ادخل الرقم السرى">
                                    @error('password')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <button class="btn btn-primary w-md waves-effect waves-light" type="submit">تعديل
                                        الحساب</button>
                                    <a href="{{ route('users.index') }}" class="btn btn-info">الرجوع الى
                                        المستخدمين</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footerScript')
@endsection
