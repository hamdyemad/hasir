<div class="contact_from_form">
    <a href="{{ route('frontend.send_message_page') }}">
        <span class="mdi mdi-email-outline"></span>
    </a>
    <span class="popup">تواصل معنا</span>
</div>
<footer>
    <div class="container">
        <div class="row align-items-center">
            <div class="col-12 col-md-6">
                <div class="logo wow fadeInDown">
                    @if (get_setting('logo'))
                        <img src="{{ asset(get_setting('logo')) }}">
                    @else
                        <img src="{{ URL::asset('/images/default.png') }}">
                    @endif
                </div>
                @if(get_setting('description'))
                <p class="mt-2 wow fadeInUp">{{ get_setting('description') }}</p>
                @endif
                <ul class="social-links d-flex align-items-center wow fadeInUp">
                    @if(get_setting('facebook'))
                        <li class="facebook"><a href="{{ get_setting('facebook') }}"><span class="mdi mdi-facebook"></span></a></li>
                    @endif
                    @if(get_setting('twitter'))
                    <li class="twitter"><a href="{{ get_setting('twitter') }}"><span class="mdi mdi-twitter"></span></a></li>
                    @endif
                    @if(get_setting('instagram'))
                    <li class="instagram"><a href="{{ get_setting('instagram') }}"><span class="mdi mdi-instagram"></span></a></li>
                    @endif
                    @if(get_setting('youtube'))
                    <li class="youtube"><a href="{{ get_setting('youtube') }}"><span class="mdi mdi-youtube"></span></a></li>
                    @endif
                </ul>
            </div>
            <div class="col-12 col-md-6">
                <ul class="links wow fadeInUp">
                    @if(get_setting('email'))
                        <li>
                            <a href="mailto:{{ get_setting('email') }}">
                                <span class="mdi mdi-email-outline"></span>
                                <span>{{ get_setting('email') }}</span>
                            </a>
                        </li>
                    @endif
                    @if(get_setting('phone'))
                        <li>
                            <a href="tel:{{ get_setting('phone') }}">
                                <span class="mdi mdi-phone-in-talk-outline"></span>
                                <span>{{ get_setting('phone') }}</span>
                            </a>
                        </li>
                    @endif
                    @if(get_setting('address'))
                        <li>
                            <a href="#">
                                <span class="mdi mdi-map-marker-outline"></span>
                                <span>{{ get_setting('address') }}</span>
                            </a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</footer>
