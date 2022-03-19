@extends('frontend.layout')

@section('content')
    <div class="projects_page">
        @include('frontend.inc.projects')
    </div>
@endsection
@section('footerScript')
    <script>
        $('.projects_carousel').owlCarousel({
            margin:10,
            loop: true,
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
