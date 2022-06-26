<section class="services pb-5 pt-5">
    <div class="container">
        <div class="wow jello"  data-wow-offset="100">
            @include('frontend.inc.heading', ['heading' => 'خدماتنا'])
        </div>
        <div>
            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="wow fadeInRight" data-wow-offset="50" data-wow-delay="0.1s">
                        <div class="card">
                            الفلل السكنية.
                        </div>
                    </div>
                    <div class="wow fadeInRight" data-wow-offset="50" data-wow-delay="0.2s">
                        <div class="card">
                            الشقق الفارهة.
                        </div>
                    </div>
                    <div class="wow fadeInRight" data-wow-offset="50" data-wow-delay="0.1s">
                        <div class="card">
                            المراكز التجارية.
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <img class="bg wow fadeInLeft"  data-wow-offset="200" src="{{ asset('/images/icons/2.png') }}" alt="">
                </div>
            </div>
            <div class="down-service wow fadeInUp" data-wow-offset="200">
                <h3>
                    فريق حصير يعملون على قدمٍ وساق لإنجاز متطلباتك وتحقيق احلامك على الوجه الأمثل.
                </h3>
                <a class="btn btn-primary rounded" href="{{ route('frontend.send_message_page') . '?type=تعاون تجارى' }}">
                    <span class="h5">تعاون تجارى</span>
                </a>
            </div>
        </div>
    </div>
</section>
