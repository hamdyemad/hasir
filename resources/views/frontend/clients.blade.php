@extends('frontend.layout')

@section('content')
    <div class="clients_page">
        @include('frontend.inc.testimonials')
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
    </script>
@endsection
