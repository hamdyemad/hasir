@php
    $testimonials = \App\Models\Client::latest()->get();
@endphp
<section class="testimonials pb-5">
    <div class="container">
        <div class="wow jello" data-wow-offset="200">
            @include('frontend.inc.heading', ['heading' => 'شركاء النجاح'])
        </div>
        <div class="owl-carousel owl-theme testimonials_carousel wow fadeInUp" data-wow-offset="300">
            @foreach ($testimonials as $key => $testimonial)
                <div class="item">
                    <img src="{{ asset($testimonial->photo) }}" alt="">
                </div>
            @endforeach
        </div>
    </div>
</section>
