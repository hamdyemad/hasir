@extends('frontend.layout')

@section('content')
    <div class="project pt-3 pb-3">
        <div class="container">
            <div class="card">
                <div class="row">
                    <div class="col-12 col-lg-6 images_container animated fadeInRight">
                        <div class="full_images">
                            @if($project->photos !== null)
                                <!-- Main image, on which xzoom will be applied -->
                                <img class="xzoom default" src="{{ asset(json_decode($project->photos)[0]) }}" xoriginal="{{ asset(json_decode($project->photos)[0]) }}">

                                <!-- Thumbnails -->
                                <div class="owl-carousel owl-theme project_images_carousl images">
                                    @foreach (json_decode($project->photos) as $photo)
                                        <div class="item">
                                            <a href="{{ asset($photo) }}">
                                                <img class="xzoom-gallery" width="80" src="{{ asset($photo) }}" xpreview="{{ asset($photo) }}">
                                                </a>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <img class="default" src="{{ asset('/images/product_avatar.png') }}"alt="">
                            @endif
                        </div>
                    </div>
                    <div class="col-12 col-lg-6 content_container animated fadeIn">
                        <div class="content">
                            <h1>{{ $project->name }}</h1>
                            <ul>
                                @if($project->buildings)
                                    <li>
                                        <span>عدد المبانى</span>
                                        <span>{{ $project->buildings }}</span>
                                    </li>
                                @endif
                                @if($project->units)
                                    <li>
                                        <span>عدد الوحدات</span>
                                        <span>{{ $project->units }}</span>
                                    </li>
                                @endif
                                @if($project->available_units)
                                    <li>
                                        <span>الوحدات المتاحة</span>
                                        <span>{{ $project->available_units }}</span>
                                    </li>
                                @endif
                            </ul>
                            @if($project->file)
                                <a class="btn btn-info" href="{{ asset($project->file) }}" target="_blank">تحميل ملف المشروع</a>
                            @endif
                            <div class="car">
                                <div class="card-header">
                                    <h2 class="mb-0">نبذة عن المشروع</h2>
                                </div>
                                <div class="card-body">
                                    <p class="mb-0">{{ $project->description }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="locations">
                    <div class="row">
                        @if($project->location)
                            <div class="col-12 col-lg-6 wow fadeInRight" data-wow-offset="100">
                                <iframe src="{{$project->location}}" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                            </div>
                        @endif
                        @if($project->location_features)
                            <div class="col-12 col-lg-6 wow fadeInLeft" data-wow-offset="100">
                                <div class="card">
                                    <div class="card-header">مميزات الموقع</div>
                                    <div class="card-body">
                                        {{$project->location_features}}
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                @if($project->infos->count() > 0)
                    <div class="about">
                        <div class="wow fadeInUp" data-wow-offset="100">
                            @include('frontend.inc.heading', [
                                'heading' => 'معلومات خاصة بالمشروع'
                            ])
                        </div>
                        @foreach ($project->infos as $info)
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
                                    <a href="{{ route('frontend.order', [$project->id,$info->id]) }}" class="btn btn-block btn-primary">أطلب الأن</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
                <div class="p-3 wow fadeInUp" data-wow-offset="100">
                    <form action="{{ route('frontend.send_message') }}" method="POST">
                        @csrf
                        <input type="hidden" name="project_id" value="{{ $project->id }}">
                        @include('frontend.inc.heading', [
                            'heading' => 'سجل أهتمامك للمشاريع القادمة'
                        ])
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <input class="form-control" type="text" name="name" placeholder="الأسم" value="{{ old('name') }}">
                                    @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <input class="form-control" type="text" name="phone" placeholder="الجوال" value="{{ old('phone') }}">
                                    @error('phone')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <input class="form-control" type="email" name="email" placeholder="البريد الألكترونى" value="{{ old('email') }}">
                                    @error('email')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <input class="btn btn-primary btn-block" type="submit" value="سجل">
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
    <script>
        $(".xzoom, .xzoom-gallery").xzoom({
            position:'left',
            mposition:'inside',
            fadeIn:true,
            smooth:true,
        });
        $(".info_xzoom, .info-xzoom-gallery").xzoom({
            position:'left',
            mposition:'inside',
            fadeIn:true,
            smooth:true,
        });

        $('.project_images_carousl').owlCarousel({
            margin:10,
            rtl: true,
            nav:true,
            responsive:{
                0:{
                    items:3
                },
                767: {
                    items: 4
                },
                1000:{
                    items:5
                }
            }
        })
    </script>
@endsection
