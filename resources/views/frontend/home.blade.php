@extends('frontend.layout')

@section('content')
    <div class="home">
        @include('frontend.inc.header')
        @include('frontend.inc.future_informations')
        @include('frontend.inc.services')
        @include('frontend.inc.features')
        @include('frontend.inc.projects')
        @include('frontend.inc.testimonials')
        @include('frontend.inc.contact_us')
    </div>
@endsection

@section('footerScript')
    <script>
        $('.testimonials_carousel').owlCarousel({
            margin:10,
            loop: true,
            rtl: true,
            nav:true,
            responsive:{
                0:{
                    items:2
                },
                600:{
                    items:4
                },
                1000:{
                    items:6
                }
            }
        })
        $('.projects_carousel').owlCarousel({
            margin:10,
            // loop: true,
            rtl: true,
            nav:true,
            responsive:{
                0:{
                    items:1
                },
                568: {
                    items: 2
                },
                769:{
                    items:3
                },
                1500: {
                    items: 4
                }
            }
        })
    </script>
@endsection
