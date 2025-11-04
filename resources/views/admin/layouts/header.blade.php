{{-- <nav class="navbar navbar-expand-md sticky-top navbar-dark bg-navy shadow-sm"> --}}
@php
    if (!Auth::check()) {
        Auth::logout();
        return redirect('/login');
    }
    
    $company_details = $lead_unit = \App\Models\Company::where('status', 1)
        ->where('hospital_no_pk', Session::get('user.ses_hospital_no_pk'))
        ->first();
    $imageURL = isset($company_details->logo) ? '/images/uploads/hospital_images/' . $company_details->logo : 'images/login_page_logo.png';
    $backgroundColor = isset($company_details->logo_background_color) ? $company_details->logo_background_color : 'white';
    $hospitalCode = isset($company_details->hospital_code) ? $company_details->hospital_code : 'H360';
    $hospitalName = isset($company_details->hospital_name) ? $company_details->hospital_name : '';
    $class_name = '';
    if ($hospitalCode == 'UNICO') {
        $class_name = 'uhl-top-bar-bg';
    }

@endphp

<div class="row">
    <div class="col-md-12">
        <nav class="navbar custom-navbar navbar-expand-lg navbar-light bg-success {{ $class_name }} ">
            <div class="" style="margin-left: 24px;">
                <a href="#" class="sidebar-toggle text-white" data-toggle="push-menu" role="button">
                    <span class="indicator glyphicon-chevron-left oi oi-menu"></span>
                </a>
            </div>
            <div class="brand logo-width" style="text-align: center">
                <a class="navbar-brand" href="{{ route('home') }}" style="">
                    {{--					<img class="w-100" src="{{ asset($imageURL) }}"> --}}
                    <h4 class="mb-0 text-white" style="font-weight: bold">
                        @if ($hospitalCode == 'EWMCH' && $hospitalName == 'DIVINE MERCY HOSPITAL LIMITED')
                            {{ 'DMGH' }}
                        @else
                            {{ $hospitalCode }}

                            @if(isset($company_details->hospital_code))
                                @if ($company_details->hospital_code == 'GMC')
                                    H
                                @endif
                            @endif

                        @endif

                    </h4>
                </a>
            </div>

            <!-- Responsive User Menu -->
            <div class="user user-menu responsive_user_menu">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img src="{{ asset('images/test.png') }}" class="user-image" alt="User Image"
                        style="width:30px;" />
                    <span class="hidden-xs text-white">{{ ucwords(Auth::user()->user_name) }}</span>
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown"
                    style="width: 325px !important;">
                    <ol>
                        <li class="text-center py-2" style="background-color: #00a65a;color:rgba(255,255,255,0.8)">
                            <img src="{{ asset('images/test.png') }}" class="img-circle"
                                alt="User Image" style="width: 90px;" />

                            <p>
                                {{ ucwords(Auth::user()->user_name) }} <br>
                                <small>Member since 
                                <strong>{{ !empty(Auth::user()->au_entry_at) ? date('d M Y', strtotime(Auth::user()->au_entry_at)) : '' }}</strong></small>
                            </p>
                        </li>

                        <li class="row mt-2">
                            <div class="col-6 text-center">
                                <a class="btn btn-md btn-info" rel="tab"
                                    href="<?php echo e(url('profile/manage/' . Auth::user()->user_no_pk)); ?>">Manage Profile</a>
                            </div>
                            <div class="col-6 text-center">
                                <a href="{{ route('logout') }}" class="btn btn-md btn-danger">Sign
                                    out</a>
                            </div>
                        </li>
                    </ol>
                </div>
            </div>
            <!-- Close Responsive User Menu -->


            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">

                    <li class="nav-item dropdown  @if (Session::get('user.ses_hospital_code') != 'IMPALA') d-none @endif">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="far fa-bell" style="font-size: 20px; margin-top: 6px;"></i>
                            <span class="label label-success"
                                style="position: relative; top: -13px; left: -7px; padding: 0px 3px;  border-radius: 50%; background: red; color:#ffffff; font-size: 11px;">{{ isset($external_refferal_performance_count) ? $external_refferal_performance_count : 0 }}</span>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown" style="width:340px;">
                            <div class="messages-notify">
                                <div class="header" style="font-weight: 600; color: #1d68a7; font-size:17px;">You have
                                    {{ isset($external_refferal_performance_count) ? $external_refferal_performance_count : 0 }}
                                    notifications</div>
                                <div class="items">
                                    <ol class="menu">
                                        @if (!empty($external_refferal_performance_info))
                                            @foreach ($external_refferal_performance_info as $data)
                                                <li>
                                                    <div class=" d-flex align-items-center">
                                                        <!-- start float -->
                                                        <div class=""
                                                            style="width: 20px; margin-right:5px; overflow:hidden;">
                                                            {{-- <i class="far fa-envelope" style="color: #000"></i> --}}
                                                            <i class="fa fa-bullhorn" style="color: #000"></i>
                                                        </div>
                                                        <div class="w-100">
                                                            <h4 style="font-size: 14px;">
                                                                {{ $data->agent_name }} referred to Rakib Hasan
                                                            </h4>
                                                        </div>
                                                    </div>
                                                </li>
                                            @endforeach
                                        @endif
                                        <li class="nav-item dropdown d-none">
                                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown"
                                                role="button" data-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                                                <i class="far fa-bell"></i>
                                                <span class="label label-success">4</span>
                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                                <div class="messages-notify">
                                                    <div class="header">You have 4 messages</div>
                                                    <div class="items">
                                                        <ol class="menu">
                                                            <li>
                                                                <div class=" d-flex align-items-center">
                                                                    <!-- start float -->
                                                                    <div class=""
                                                                        style="width: 50px; border-radius:50%; margin-right:5px; overflow:hidden;">
                                                                        <img src="{{ asset('images/girl.jpg') }}"
                                                                            class="img-circle" alt="User Image"
                                                                            style="width: 100%;" />
                                                                    </div>
                                                                    <div class="w-100">
                                                                        <h4>
                                                                            Support Team
                                                                            <small class="float-right"><i
                                                                                    class="far fa-clock"></i> 5
                                                                                mins</small>
                                                                        </h4>
                                                                        <p>Why not buy a new awesome theme?</p>
                                                                    </div>
                                                                </div>
                                                            </li>

                                                            <li>
                                                                <div class=" d-flex align-items-center">
                                                                    <div class=""
                                                                        style="width: 50px; border-radius:50%; margin-right:5px; overflow:hidden;">
                                                                        <img src="{{ asset('images/girl.jpg') }}"
                                                                            class="img-circle" alt="User Image"
                                                                            style="width: 100%;" />
                                                                    </div>
                                                                    <div class="w-100">
                                                                        <h4>
                                                                            AdminLTE Design Team
                                                                            <small class="float-right"><i
                                                                                    class="far fa-clock"></i> 2
                                                                                hours</small>
                                                                        </h4>
                                                                        <p>Why not buy a new awesome theme?</p>
                                                                    </div>
                                                                </div>
                                                            </li>

                                                            <li>
                                                                <div class=" d-flex align-items-center">
                                                                    <div class=""
                                                                        style="width: 50px; border-radius:50%; margin-right:5px; overflow:hidden;">
                                                                        <img src="{{ asset('images/girl.jpg') }}"
                                                                            class="img-circle" alt="User Image"
                                                                            style="width: 100%;" />
                                                                    </div>
                                                                    <div class="w-100">
                                                                        <h4>
                                                                            Developers
                                                                            <small class="float-right"><i
                                                                                    clrass="faa-clock-o"></i>
                                                                                Today</small>
                                                                        </h4>
                                                                        <p>Why not buy a new awesome theme?</p>
                                                                    </div>
                                                                </div>
                                                            </li>

                                                            <li>
                                                                <div class=" d-flex align-items-center">
                                                                    <div class=""
                                                                        style="width: 50px; border-radius:50%; margin-right:5px; overflow:hidden;">
                                                                        <img src="{{ asset('images/girl.jpg') }}"
                                                                            class="img-circle" alt="User Image"
                                                                            style="width: 100%;" />
                                                                    </div>
                                                                    <div class="w-100">
                                                                        <h4>
                                                                            Sales Department
                                                                            <small class="float-right"><i
                                                                                    clrass="faa-clock-o"></i>
                                                                                Yesterday</small>
                                                                        </h4>
                                                                        <p>Why not buy a new awesome theme?</p>
                                                                    </div>
                                                                </div>
                                                            </li>

                                                            <li>
                                                                <div class=" d-flex align-items-center">
                                                                    <div class=""
                                                                        style="width: 50px; border-radius:50%; margin-right:5px; overflow:hidden;">
                                                                        <img src="{{ asset('images/girl.jpg') }}"
                                                                            class="img-circle" alt="User Image"
                                                                            style="width: 100%;" />
                                                                    </div>
                                                                    <div class="w-100">
                                                                        <h4>
                                                                            Reviewers
                                                                            <small class="float-right"><i
                                                                                    class="far fa-clock"></i> 2
                                                                                days</small>
                                                                        </h4>
                                                                        <p>Why not buy a new awesome theme?</p>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        </ol>
                                                    </div>
                                                    <div class="footer"><a href="#">See All Messages</a></div>
                                                </div>
                                            </div>
                                        </li>
                                    </ol>
                                </div>
                                <div class="footer"><a href="{{ route('v1.external-referral-performance-report') }}"
                                        target="_blank">See All Notifications</a></div>
                            </div>
                        </div>
                    </li>

                    <li class="nav-item dropdown">
                        <div class="user user-menu">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img src="{{ asset('images/test.png') }}" class="user-image" alt="User Image"
                                    style="width:30px;" />
                                <span class="hidden-xs text-white">{{ ucwords(Auth::user()->user_name) }}</span>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown"
                                style="width: 325px !important;">
                                <ol>
                                    <li class="user-header">
                                        <img src="{{ asset('images/test.png') }}" class="img-circle"
                                            alt="User Image" style="width: 90px;" />

                                        <p>
                                            {{ ucwords(Auth::user()->user_name) }}
                                            <small>Member since
                                                <strong>{{ !empty(Auth::user()->au_entry_at) ? date('d M Y', strtotime(Auth::user()->au_entry_at)) : '' }}</strong></small>
                                        </p>
                                    </li>

                                    <li class="user-footer form-row">
                                        <div class="col-md-6 text-left">
                                            <a class="btn btn-md btn-info" rel="tab"
                                                href="<?php echo e(url('profile/manage/' . Auth::user()->user_no_pk)); ?>">Manage Profile</a>
                                        </div>
                                        <div class="col-md-6 text-right">
                                            <a href="{{ route('logout') }}" class="btn btn-md btn-danger">Sign
                                                out</a>
                                        </div>
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</div>
