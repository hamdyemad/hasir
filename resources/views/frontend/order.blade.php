@extends('frontend.layout')

@section('content')
    <div class="create_order pt-3 project">
        <div class="container">
            <div class="card">
                <div class="card-header text-center animated fadeInDown">
                    <h1>معلومات الطلب</h1>
                </div>
                <div class="card-body animated fadeInUp">
                    <form action="{{ route('frontend.order.store', $info) }}" method="POST">
                        <input type="hidden" name="project_id" value="{{ $project->id }}">
                        <input type="hidden" name="info_id" value="{{ $info->id }}">
                        @csrf
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <input type="text" name="client_name" placeholder="الأسم" class="form-control">
                                    @error('client_name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <input type="text" name="client_phone" placeholder="الجوال" class="form-control">
                                    @error('client_phone')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <input type="email" name="client_email" placeholder="البريد الألكترونى" class="form-control">
                                    @error('client_email')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <input type="submit" class="btn btn-primary btn-block" value="أرسل" class="form-control">
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="about">
                        @include('frontend.inc.heading', [
                            'heading' => 'معلومات الدور'
                        ])
                        <div class="card mt-3 wow fadeInUp" data-wow-offset="100">
                            <div class="card-header d-flex align-items-center justify-content-between">
                                <h2 class="round text-center text-md-left">الدور ({{ $info->round }})</h2>
                                <h2 class="d-none d-md-block badge badge-secondary">رقم الشقة: ({{ $info->rooms }})</h2>
                                <h2 class="d-none d-md-block badge badge-secondary">{{ $info->status }}</h2>
                            </div>
                            <div class="card-body">
                                <div class="info_images mb-3 wow fadeInUp" data-wow-offset="100">
                                    @if($info->photos !== null)
                                        <div class="row">
                                            @foreach (json_decode($info->photos) as $photo)
                                                <div class="col">
                                                    <img src="{{ asset($photo) }}">
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <img class="default" src="{{ asset('/images/product_avatar.png') }}"alt="">
                                    @endif
                                </div>
                                <ul>
                                    <li class="d-md-none">
                                        <h3>رقم الشقة:</h3>
                                        <h5>{{ $info->rooms }}</h5>
                                    </li>
                                    <li class="d-md-none">
                                        <h3>الحالة:</h3>
                                        <h5>{{ $info->status }}</h5>
                                    </li>
                                    <li>
                                        <h3>السعر:</h3>
                                        <h5>{{ $info->price }}</h5>
                                    </li>
                                </ul>
                                @if($info->space)
                                    <div class="card">
                                        <div class="card-header">
                                            <h3>المساحة:</h3>
                                        </div>
                                        <div class="card-body">
                                            <p>{{ $info->space }}</p>
                                        </div>
                                    </div>
                                @endif
                                @if($info->description)
                                    <div class="card">
                                        <div class="card-header">
                                            <h3>المواصفات:</h3>
                                        </div>
                                        <div class="card-body">
                                            <p>{{ $info->description }}</p>
                                        </div>
                                    </div>
                                @endif
                                @if($info->features)
                                    <div class="card">
                                        <div class="card-header">
                                            <h3>المميزات:</h3>
                                        </div>
                                        <div class="card-body">
                                            <p>{{ $info->features }}</p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
