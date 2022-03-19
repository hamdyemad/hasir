<section class="contact-us pt-5 pb-5 card">
    <img class="bg wow fadeIn" data-wow-offset="200" src="{{ asset('/images/gradient-white-monochrome-background_23-2149020688.webp') }}" alt="">
    <div class="container">
        <div class="wow jello">
            @include('frontend.inc.heading', ['heading' => 'تواصل معنا'])
        </div>
        <div class="row">
            <div class="col-12 col-lg-6 wow fadeInRight">
                <h2 class="text-center text-lg-left">مسؤوليتنا تكمن في جعل مسكنك متكامل من جميع النواحي بدايةً من البنية التحتية إلى أدق التفاصيل لبناء منشاة متميزة تفوق التوقعات وتليق بعملاء حصير.</h2>
            </div>
            <div class="col-12 col-lg-6">
                <h2 class="text-center text-lg-left wow fadeInLeft">يسعدنا استقبال أسئلتكم واستفساراتكم من خلال:</h2>
                @if(get_setting('email'))
                    <div class="contact wow fadeInLeft" data-wow-delay="0.1s">
                        <div class="card-header">
                            <div class="head d-flex align-items-center">
                                <span class="mdi mdi-email-outline"></span>
                                <h3>البريد الإلكتروني</h3>
                            </div>
                            <span>{{ get_setting('email') }}</span>
                        </div>
                    </div>
                @endif
                @if(get_setting('phone'))
                    <div class="contact wow fadeInLeft" data-wow-delay="0.2s">
                        <div class="card-header">
                            <div class="head d-flex align-items-center">
                                <span class="mdi mdi-phone-in-talk-outline"></span>
                                <h3>الهاتف</h3>
                            </div>
                            <span>{{ get_setting('phone') }}</span>
                        </div>
                    </div>
                @endif
                @if(get_setting('address'))
                    <div class="contact wow fadeInLeft" data-wow-delay="0.3s">
                        <div class="card-header">
                            <div class="head d-flex align-items-center">
                                <span class="mdi mdi-map-marker-outline"></span>
                                <h3>العنوان</h3>
                            </div>
                        <span>{{ get_setting('address') }}</span>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
