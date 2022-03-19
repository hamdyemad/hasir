<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect" id="vertical-menu-btn">
                <i class="mdi mdi-menu"></i>
            </button>
        </div>

        <div class="d-flex">
            <div class="dropdown d-none d-lg-inline-block">
                <button type="button" class="btn header-item noti-icon waves-effect" data-toggle="fullscreen">
                    <i class="mdi mdi-fullscreen font-size-24"></i>
                </button>
            </div>

            {{-- Start Noteifications --}}
            @php
                $orders = App\Models\Order::where('viewed', 0)->latest()->get();
                $messages = App\Models\Message::where('viewed', 0)->where('project_id', null)->latest()->get();
                $investors = App\Models\Message::where('viewed', 0)->where('project_id', '!=',null)->latest()->get();
            @endphp
            <div class="dropdown d-inline-block ml-1">
                <button type="button" class="btn header-item noti-icon waves-effect"
                    id="page-header-notifications-dropdown" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                    <i class="ti-bell"></i>
                    <span class="badge badge-danger badge-pill">{{ count($orders) + count($messages) + count($investors) }}</span>
                </button>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right p-0"
                    aria-labelledby="page-header-notifications-dropdown">
                    @if(count($orders) > 0)
                        <div class="p-3">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h5 class="m-0"> الطلبات ({{ count($orders) }}) </h5>
                                </div>
                            </div>
                        </div>
                        <div data-simplebar style="max-height: 230px;">
                            @foreach ($orders as $order)
                                <a href="{{ route('orders.index') . '?status_id=' . $order->status_id }}" class="text-reset notification-item">
                                    <div class="media">
                                        <div class="avatar-xs mr-3">
                                            <span class="avatar-title border-primary rounded-circle ">
                                                <i class="mdi mdi-cart-outline"></i>
                                            </span>
                                        </div>
                                        <div class="media-body">
                                            <h6 class="mt-0 mb-1">رقم الطلب : ({{ $order->id }})</h6>
                                            <h6 class="mt-0 mb-1">أسم العميل : ({{ $order->client_name }})</h6>
                                            <h6 class="mt-0 mb-1">رقم العميل : ({{ $order->client_phone }})</h6>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                        <div class="p-2 border-top">
                            <a class="btn btn-sm btn-link font-size-14 btn-block text-center" href="{{ route('orders.index') }}">
                                عرض الطلبات
                            </a>
                        </div>
                    @endif
                    @if(count($messages) > 0)
                        <div class="p-3">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h5 class="m-0"> الرسائل ({{ count($messages) }}) </h5>
                                </div>
                            </div>
                        </div>
                        <div data-simplebar style="max-height: 230px;">
                            @foreach ($messages as $message)
                                <a href="{{ route('messages.index') . '?status_id=' . $message->status_id }}" class="text-reset notification-item">
                                    <div class="media">
                                        <div class="avatar-xs mr-3">
                                            <span class="avatar-title border-primary rounded-circle ">
                                                <i class="mdi mdi-cart-outline"></i>
                                            </span>
                                        </div>
                                        <div class="media-body">
                                            <h6 class="mt-0 mb-1">رقم الطلب : ({{ $message->id }})</h6>
                                            <h6 class="mt-0 mb-1">أسم العميل : ({{ $message->name }})</h6>
                                            <h6 class="mt-0 mb-1">رقم العميل : ({{ $message->phone }})</h6>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                        <div class="p-2 border-top">
                            <a class="btn btn-sm btn-link font-size-14 btn-block text-center" href="{{ route('messages.index') }}">
                                عرض الرسائل
                            </a>
                        </div>
                    @endif
                    @if(count($investors) > 0)
                        <div class="p-3">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h5 class="m-0"> المستثمرين ({{ count($investors) }}) </h5>
                                </div>
                            </div>
                        </div>
                        <div data-simplebar style="max-height: 230px;">
                            @foreach ($investors as $investor)
                                <a href="{{ route('investors.index') . '?status_id=' . $investor->status_id . '&project_id' . $investor->project_id }}" class="text-reset notification-item">
                                    <div class="media">
                                        <div class="avatar-xs mr-3">
                                            <span class="avatar-title border-primary rounded-circle ">
                                                <i class="mdi mdi-cart-outline"></i>
                                            </span>
                                        </div>
                                        <div class="media-body">

                                            <h6 class="mt-0 mb-1">أسم المشروع : (
                                                @if($investor->project)
                                                    <span>{{ $investor->project->name }}</span>
                                                @else
                                                --
                                                @endif
                                                )</h6>
                                            <h6 class="mt-0 mb-1">أسم المستثمر : ({{ $investor->name }})</h6>
                                            <h6 class="mt-0 mb-1">رقم المستثمر : ({{ $investor->phone }})</h6>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                        <div class="p-2 border-top">
                            <a class="btn btn-sm btn-link font-size-14 btn-block text-center" href="{{ route('investors.index') . '?type=مستثمر' }}">
                                عرض المستثمرين
                            </a>
                        </div>
                    @endif
                </div>
            </div>
            {{-- End Noteifications



            {{-- Profile --}}
            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    @if (Auth::check())
                        @if (Auth::user()->avatar)
                            <img class="rounded-circle header-profile-user" src="{{ asset(Auth::user()->avatar) }}">
                        @else
                            <img class="rounded-circle header-profile-user" src="{{ asset('images/avatar.jpg') }}">
                        @endif
                    @endif
                </button>
                <div class="dropdown-menu dropdown-menu-right">
                    <!-- item-->
                    <a class="dropdown-item" href="{{ route('users.profile',  Auth::user()) }}"><i
                            class="mdi mdi-account-circle font-size-17 text-muted align-middle mr-1"></i> Profile</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item text-danger" href="javascript:void();"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
                            class="mdi mdi-power font-size-17 text-muted align-middle mr-1 text-danger"></i>
                        {{ __('Logout') }}</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>

            {{-- <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item noti-icon right-bar-toggle waves-effect">
                    <i class="mdi mdi-spin mdi-settings"></i>
                </button>
            </div> --}}

        </div>
    </div>
</header>
