@php
$patient_id = !empty(Auth::user()->patient_no_fk) ? Auth::user()->patient_no_fk : '';
$pat_details = \Illuminate\Support\Facades\DB::table('patient_info_vw')
    ->where('patient_no_pk', $patient_id)
    ->first();
$imageURL_patient = isset($pat_details->patient_photo) ? '/images/uploads/patient_images/' . $pat_details->patient_photo : 'images/login_patient_logo.png';
$full_name = isset($pat_details->patient_name) ? $pat_details->patient_name : 'N/A';
$su_name = isset($pat_details->su_name) ? $pat_details->su_name : 'N/A';

$company_details = $lead_unit = \App\Models\Company::where('status', 1)->first();
$imageURL = isset($company_details->logo) ? '/images/uploads/hospital_images/' . $company_details->logo : 'coverpage/img/mcare_logo.png';
$backgroundColor = isset($company_details->logo_background_color) ? $company_details->logo_background_color : 'white';
$hospitalCode = isset($company_details->hospital_code) ? $company_details->hospital_code : 'Mcare';

$auth_id = \Illuminate\Support\Facades\Auth::user()->user_no_pk;
$hospital_code = strtoupper(Session::get('user.ses_hospital_code'));

@endphp
<aside class="app-sidebar active">
    @if ($hospital_code != 'CHPC')
        <div class="app-sidebar__logo">
            @if ($patient_id != '')
                <a class="header-brand" href="#">
                @else
                    <a class="header-brand" href="{{ route('cover-page-v2') }}">
            @endif
            <img src="{{ asset('coverpage/img/mcare_logo.png') }}" class="header-brand-img desktop-lgo"
                alt="Admitro logo" />
            <img src="{{ asset('coverpage/assets/images/brand/logo1.png') }}" class="header-brand-img dark-logo"
                alt="Admitro logo" />
            <img src="{{ asset('coverpage/assets/images/brand/favicon.png') }}" class="header-brand-img mobile-logo"
                alt="Admitro logo" />
            <img src="{{ asset('coverpage/assets/images/brand/favicon1.png') }}"
                class="header-brand-img darkmobile-logo" alt="Admitro logo" />
            </a>
        </div>
    @endif
    <div class="app-sidebar__user">
        <div class="dropdown user-pro-body text-center">
            <div class="user-pic">
                @if ($imageURL_patient != '')
                    <img src="{{ asset($imageURL_patient) }}" alt="img" class="avatar avatar-md brround" />
                @else
                    <img src="{{ asset('images/boy.jpg') }}" alt="img" class="avatar avatar-md brround" />
                @endif

            </div>
            <div class="user-info">
                <a href="#" data-toggle="modal" data-target="#available_hours">
                    <h5 class="mb-1">
                        {{ !empty(Auth::user()->user_name) ? ucfirst(Auth::user()->user_name) : '' }} <i
                            class="ion-checkmark-circled text-success fs-12"></i></h5>
                </a>
                @if ($hospital_code == 'CHPC')

                    <span class="text-muted app-sidebar__user-name text-sm">Patient</span>
                @else
                    <span class="text-muted app-sidebar__user-name text-sm">Customer</span>
                @endif

            </div>
        </div>
        <div class="sidebar-navs">
            <ul class="nav nav-pills-circle">
                <li class="nav-item" data-placement="top" data-toggle="tooltip" title="Support">
                    <a class="icon" href="#">
                        <i class="las la-life-ring header-icons"></i>
                    </a>
                </li>
                <li class="nav-item" data-placement="top" data-toggle="tooltip" title="Documentation">
                    <a class="icon" href="#">
                        <i class="las la-file-alt header-icons"></i>
                    </a>
                </li>
                <li class="nav-item" data-placement="top" data-toggle="tooltip" title="Projects">
                    <a href="#" class="icon">
                        <i class="las la-project-diagram header-icons"></i>
                    </a>
                </li>
                <li class="nav-item" data-placement="top" data-toggle="tooltip" title="Settings">
                    <a class="icon" href="#">
                        <i class="las la-cog header-icons"></i>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <ul class="side-menu app-sidebar3">
        <li class="slide">
            <a class="side-menu__item" href="{{ route('cover.patient-admin-panel') }}">
                <svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24"
                    width="24">
                    <path d="M0 0h24v24H0V0z" fill="none" />
                    <path
                        d="M19 5v2h-4V5h4M9 5v6H5V5h4m10 8v6h-4v-6h4M9 17v2H5v-2h4M21 3h-8v6h8V3zM11 3H3v10h8V3zm10 8h-8v10h8V11zm-10 4H3v6h8v-6z" />
                </svg>
                <span class="side-menu__label">Dashboard</span></span>
            </a>
        </li>
        @if ($hospital_code != 'CHPC')
            <li class="slide">
                <a class="side-menu__item" href="{{ route('patient.e-commerce-orders', $auth_id) }}">
                    <i class="side-menu__icon zmdi zmdi-money"></i>
                    <span class="side-menu__label">Ecommerce Orders</span></span>
                </a>
            </li>
        @endif


        <li class="slide">
            <a class="side-menu__item" href="{{ route('patient.appointment-book', $patient_id) }}">
                <i class="side-menu__icon ti-notepad"></i>
                <span class="side-menu__label">Appointments</span></span>
            </a>
        </li>
        @if ($hospital_code != 'CHPC')

            <li class="slide">
                <a class="side-menu__item" href="{{ route('video-call') }}">
                    <i class="side-menu__icon ti-notepad"></i>
                    <span class="side-menu__label">Video Call</span></span>
                </a>
            </li>
            <li class="slide">
                @php
                    $patient_id = !empty(Auth::user()->patient_no_fk) ? Auth::user()->patient_no_fk : '';

                @endphp
                <a class="side-menu__item" href="{{ route('emr.patient-emr-data', $patient_id) }}">
                    <i class="side-menu__icon ion-calendar"></i>
                    <span class="side-menu__label">EMR</span></span>
                </a>
            </li>

            <li class="slide">
                <a class="side-menu__item" href="#">
                    <i class="side-menu__icon zmdi zmdi-money"></i>
                    <span class="side-menu__label">Payment History</span></span>
                </a>
            </li>
        @endif

        <li class="slide">
            <a class="side-menu__item" href="{{ route('patient.details', $patient_id) }}">
                {{-- <a class="side-menu__item" href="{{route('patient.register-profile',$patient_id)}}"> --}}
                <svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24"
                    width="24">
                    <path d="M0 0h24v24H0V0z" fill="none"></path>
                    <path
                        d="M17.73 12.02l3.98-3.98c.39-.39.39-1.02 0-1.41l-4.34-4.34c-.39-.39-1.02-.39-1.41 0l-3.98 3.98L8 2.29C7.8 2.1 7.55 2 7.29 2c-.25 0-.51.1-.7.29L2.25 6.63c-.39.39-.39 1.02 0 1.41l3.98 3.98L2.25 16c-.39.39-.39 1.02 0 1.41l4.34 4.34c.39.39 1.02.39 1.41 0l3.98-3.98 3.98 3.98c.2.2.45.29.71.29.26 0 .51-.1.71-.29l4.34-4.34c.39-.39.39-1.02 0-1.41l-3.99-3.98zM12 9c.55 0 1 .45 1 1s-.45 1-1 1-1-.45-1-1 .45-1 1-1zm-4.71 1.96L3.66 7.34l3.63-3.63 3.62 3.62-3.62 3.63zM10 13c-.55 0-1-.45-1-1s.45-1 1-1 1 .45 1 1-.45 1-1 1zm2 2c-.55 0-1-.45-1-1s.45-1 1-1 1 .45 1 1-.45 1-1 1zm2-4c.55 0 1 .45 1 1s-.45 1-1 1-1-.45-1-1 .45-1 1-1zm2.66 9.34l-3.63-3.62 3.63-3.63 3.62 3.62-3.62 3.63z">
                    </path>
                </svg>
                <span class="side-menu__label">Profile</span></span>
            </a>
        </li>
        @if ($hospital_code != 'CHPC')


            <li class="slide">
                <a class="side-menu__item" href="{{ route('cover-page-v2') }}">
                    <svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24"
                        width="24">
                        <path d="M0 0h24v24H0V0z" fill="none" />
                        <path
                            d="M19 5v2h-4V5h4M9 5v6H5V5h4m10 8v6h-4v-6h4M9 17v2H5v-2h4M21 3h-8v6h8V3zM11 3H3v10h8V3zm10 8h-8v10h8V11zm-10 4H3v6h8v-6z" />
                    </svg>
                    <span class="side-menu__label">Homepage</span></span>
                </a>
            </li>
        @endif
        <li class="slide">
            <a class="side-menu__item" href="{{ route('cover.logout') }}">
                <i class="side-menu__icon ion-chatbubbles"></i>
                <span class="side-menu__label">Sign Out</span></span>
            </a>
        </li>
    </ul>
</aside>
