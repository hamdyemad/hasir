<nav class="navbar navbar-expand-lg p-0 fixed-top">
    <div class="container">
        <a class="navbar-brand animated fadeInRight" href="{{ route('frontend.home') }}">
            @if (get_setting('logo'))
                <img src="{{ asset(get_setting('logo')) }}">
            @else
                <img src="{{ URL::asset('/images/default.png') }}">
            @endif
        </a>
        <div class="navbar-toggler animated fadeInLeft" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span></span>
            <span></span>
            <span></span>
        </div>

        <div class="collapse navbar-collapse animated fadeInLeft" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item" data-nav=".header">
                    <a class="nav-link @if(activeRoute('frontend.home')) active_link @endif"@if(activeRoute('frontend.home')) @else  href="{{ route('frontend.home') }}" @endif>
                    الرئيسية
                    <img src="{{ asset('/images/icons/building.png') }}" alt="">
                    </a>
                </li>
                <li class="nav-item" data-nav=".services">
                    <a class="nav-link @if(activeRoute('frontend.services')) active_link @endif "@if(activeRoute('frontend.home')) @else  href="{{ route('frontend.services') }}" @endif>
                        خدماتنا
                        <img src="{{ asset('/images/icons/building.png') }}" alt="">
                    </a>
                </li>
                <li class="nav-item" data-nav=".projects">
                    <a class="nav-link @if(activeRoute('frontend.projects')) active_link @endif "@if(activeRoute('frontend.home')) @else  href="{{ route('frontend.projects') }}" @endif>
                        مشاريعنا
                        <img src="{{ asset('/images/icons/building.png') }}" alt="">
                    </a>
                </li>
                <li class="nav-item" data-nav=".testimonials">
                    <a  class="nav-link @if(activeRoute('frontend.clients')) active_link @endif "@if(activeRoute('frontend.home')) @else  href="{{ route('frontend.clients') }}" @endif>
                        عملائنا
                        <img src="{{ asset('/images/icons/building.png') }}" alt="">
                    </a>
                </li>
                <li class="nav-item" data-nav=".contact-us">
                    <a  class="nav-link @if(activeRoute('frontend.contact_us')) active_link @endif "@if(activeRoute('frontend.home')) @else  href="{{ route('frontend.contact_us') }}" @endif>
                        تواصل معنا
                        <img src="{{ asset('/images/icons/building.png') }}" alt="">
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if(activeRoute('frontend.send_message_page')) active_link @endif "@if(activeRoute('frontend.send_message_page')) @else  href="{{ route('frontend.send_message_page') . '?type=مستثمر' }}" @endif>
                        أستثمر معنا
                        <img src="{{ asset('/images/icons/building.png') }}" alt="">
                    </a>
                </li>
            </ul>
        </div>
    </div>
  </nav>

