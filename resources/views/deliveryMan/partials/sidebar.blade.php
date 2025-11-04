<aside class="app-sidebar active">
    <div class="app-sidebar__logo">
        <a class="header-brand" href="index.html">
            <img src="{{ asset('mcare/images/mcare-logo.png') }}" class="header-brand-img desktop-lgo"
                alt="Admitro logo" />
            <img src="{{ asset('coverpage/assets/images/brand/logo1.png') }}" class="header-brand-img dark-logo"
                alt="Admitro logo" />
            <img src="{{ asset('coverpage/assets/images/brand/favicon.png') }}" class="header-brand-img mobile-logo"
                alt="Admitro logo" />
            <img src="{{ asset('coverpage/assets/images/brand/favicon1.png') }}" class="header-brand-img darkmobile-logo"
                alt="Admitro logo" />
        </a>
    </div>

    <div class="app-sidebar__user">
        <div class="dropdown user-pro-body text-center">
            <div class="user-pic">
                <img src="{{ asset('images/boy.jpg') }}" alt="user-img" class="avatar-xl rounded-circle mb-1" />
            </div>
            <div class="user-info">
                <h5 class="mb-1">{{ ucfirst(strtolower(Auth::user()->user_fullname)) }} <i
                        class="ion-checkmark-circled text-success fs-12"></i></h5>
            </div>
        </div>
    </div>
    <ul class="side-menu app-sidebar3">
        <li class="side-item side-item-category mt-4">Main</li>

        <li class="slide">
            <a class="side-menu__item" href="{{ route('delivery-man.dashboard') }}">
                <svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24"
                    width="24">
                    <path d="M0 0h24v24H0V0z" fill="none" />
                    <path
                        d="M19 5v2h-4V5h4M9 5v6H5V5h4m10 8v6h-4v-6h4M9 17v2H5v-2h4M21 3h-8v6h8V3zM11 3H3v10h8V3zm10 8h-8v10h8V11zm-10 4H3v6h8v-6z" />
                </svg>
                <span class="side-menu__label">Dashboard</span>

            </a>
        </li>

        <li class="slide">
            <a class="side-menu__item" href="{{ route('delivery-man.order-list') }}">
                {{-- <i class="side-menu__icon ti-notepad" ></i> --}}
                <i class="side-menu__icon fas fa-clipboard-list"
                    style="font-size: 17px!important; line-height: 21px!important;"></i>
                <span class="side-menu__label">Assigned Order list</span>{{--<span class="angle fa fa-angle-right"></span>--}}
            </a>
        </li>
        <li class="slide">
            <a class="side-menu__item" href="{{ route('delivery-man.picked-order-list') }}">
                {{-- <i class="side-menu__icon ti-notepad" ></i> --}}
                <i class="side-menu__icon fas fa-people-carry"
                    style="font-size: 17px!important; line-height: 21px!important;"></i>
                <span class="side-menu__label">Picked Order list</span>{{--<span class="angle fa fa-angle-right"></span>--}}
            </a>
        </li>
        <li class="slide">
            <a class="side-menu__item" href="{{ route('delivery-man.delivered-order-list') }}">
                {{-- <i class="side-menu__icon ti-notepad" ></i> --}}
                <i class="side-menu__icon fas fa-shipping-fast"
                    style="font-size: 17px!important; line-height: 21px!important;"></i>
                <span class="side-menu__label">Delivered Order list</span>{{--<span class="angle fa fa-angle-right"></span>--}}
            </a>
        </li>
        <li class="slide">
            <a class="side-menu__item" href="{{ route('delivery-man.cancelled-order-list') }}">
                {{-- <i class="side-menu__icon ti-notepad" ></i> --}}
                <i class="side-menu__icon fas fa-ban"
                    style="font-size: 17px!important; line-height: 21px!important;"></i>
                <span class="side-menu__label">Cancelled Order list</span>{{--<span class="angle fa fa-angle-right"></span>--}}
            </a>
        </li>
        <li class="slide">
            <a class="side-menu__item" href="{{ route('delivery-man.reset-password') }}">
                <i class="side-menu__icon fas fa-key"
                    style="font-size: 17px!important; line-height: 21px!important;"></i>
                <span class="side-menu__label">Reset Password</span>
            </a>
        </li>
        <li class="slide">
            <a class="side-menu__item" href="{{ route('delivery-logout') }}">
                <i class="side-menu__icon fa fa-sign-out"
                    style="font-size: 17px!important; line-height: 21px!important;"></i>
                <span class="side-menu__label">Sign Out</span>
            </a>
        </li>
        {{-- <li class="slide">
                    <a class="side-menu__item" href="#">
                        <i class="side-menu__icon ion-calendar"></i>
                        <span class="side-menu__label">Schedule Time</span>

                    </a>
                </li>

                <li class="slide">
                    <a class="side-menu__item" href="#">
                        <i class="side-menu__icon zmdi zmdi-money"></i>
                        <span class="side-menu__label">Payment History</span>

                    </a>
                </li>

                <li class="slide">
                    <a class="side-menu__item" href="#">
                        <svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24">
                            <path d="M0 0h24v24H0V0z" fill="none"></path>
                            <path d="M17.73 12.02l3.98-3.98c.39-.39.39-1.02 0-1.41l-4.34-4.34c-.39-.39-1.02-.39-1.41 0l-3.98 3.98L8 2.29C7.8 2.1 7.55 2 7.29 2c-.25 0-.51.1-.7.29L2.25 6.63c-.39.39-.39 1.02 0 1.41l3.98 3.98L2.25 16c-.39.39-.39 1.02 0 1.41l4.34 4.34c.39.39 1.02.39 1.41 0l3.98-3.98 3.98 3.98c.2.2.45.29.71.29.26 0 .51-.1.71-.29l4.34-4.34c.39-.39.39-1.02 0-1.41l-3.99-3.98zM12 9c.55 0 1 .45 1 1s-.45 1-1 1-1-.45-1-1 .45-1 1-1zm-4.71 1.96L3.66 7.34l3.63-3.63 3.62 3.62-3.62 3.63zM10 13c-.55 0-1-.45-1-1s.45-1 1-1 1 .45 1 1-.45 1-1 1zm2 2c-.55 0-1-.45-1-1s.45-1 1-1 1 .45 1 1-.45 1-1 1zm2-4c.55 0 1 .45 1 1s-.45 1-1 1-1-.45-1-1 .45-1 1-1zm2.66 9.34l-3.63-3.62 3.63-3.63 3.62 3.62-3.62 3.63z"></path>
                        </svg>
                        <span class="side-menu__label">Patients</span>

                    </a>
                </li>

                <li class="slide">
                    <a class="side-menu__item" href="#">
                        <i class="side-menu__icon ion-chatbubbles" ></i>
                        <span class="side-menu__label">Chats</span>

                    </a>
                </li> --}}
    </ul>
</aside>
