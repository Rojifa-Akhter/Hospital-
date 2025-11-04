@extends("mCare.layouts.master")
@push('mcare_customcss')
    {{-- <link rel="shortcut icon" href="{{ asset('coverpage/img/favicon.ico') }}" type="image/x-icon" />
    <link rel="icon" href="{{ asset('coverpage/favicon.ico') }}" type="image/x-icon" /> --}}
    <!-- Google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&family=Poppins:wght@300;400;500;700&family=Roboto:wght@300;400;500;700;900&display=swap"
        rel="stylesheet">
    <!-- icofont -->
    <link rel="stylesheet" href="{{ asset('coverpage/css/icofont.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('coverpage/css/all.min.css') }}" />
    <!-- Slick slider -->
    <link rel="stylesheet" href="{{ asset('coverpage/css/slick.css') }}" />
    <link rel="stylesheet" href="{{ asset('coverpage/css/slick-theme.css') }}" />
    <!-- bootstrap -->
    <link rel="stylesheet" href="{{ asset('coverpage/css/bootstrap.min.css') }}" />
    <!-- Style css-->


    <link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('asset/timepicker/css/timepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
    {{-- @include("mCare.layouts.css") --}}

    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.min.css'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <style>
        .hero_section {
            padding: 100px 0;
            background: url(coverpage/img/about_us.png) center center no-repeat;
            background-size: cover;
            position: relative;
            z-index: 1;
        }

        .small_section_title {
            font-size: 14px;
            padding: 9px 20px;
            background-color: #e0fff0;
            display: inline-block;
            border-radius: 30px;
        }

        .section_title {
            font-size: 45px;
            font-weight: 600;
            position: relative;
            margin-top: 5px;
            margin-bottom: 15px;
        }

        h3 {
            font-size: 28px;
            font-family: "Roboto", sans-serif;
            color: #025730;
        }

        .about_us {
            padding: 100px 0px;
        }

        .mission_goals {
            padding: 0px 0px 75px 0px;
        }

    </style>

@endpush
@section('content')
    <!-- Slider Start -->
    <div class="about_hero_section">
        <div class="hero_section">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="hero_text">
                            <h1>About Us</h1>
                            <b>Home <i class="fas fa-angle-double-right"> </i> <span>About Us</span> </b>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Slider end -->

    <!-- About us start -->
    <div class="about_us" style="background-color: #fff;">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="aboutus_video">
                        <img src="{{ asset('coverpage/img/mission.jpg') }}" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="about_us_section">
                        {{-- <h5 class="small_section_title">About us</h5> --}}
                        <h3 class="section_title">Who We Are</h3>
                        <p class="mt-3"></p>

                        <ul class=" mt-3">
                            <li>MCARE is an online healthcare platform, established by professionals with over 10 years
                                experience in the field of education, training, IT business with local & global companies,
                                providing an affordable, hassle-free experience for all your health needs.

                            </li>

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- About us end -->
    <div class="mission_goals">
        <div class="container">
            <div class="row align-items-center">


                <div class="col-md-6">
                    <div class="mission_section">
                        <h3 class="section_title">What We Do</h3>
                        <p class="mt-3"></p>

                        <ul class=" mt-3">
                            <li>MCARE offers a variety of medicines, healthcare products, online doctor consultations &
                                overseas treatment.
                            </li>
                            <li>All the items available on MCARE are directly collected from verified, licensed
                                manufacturers to maintain 100% efficacy.

                            </li>
                            <li>MCARE has numerous qualified local & forgain healthcare professionals who are always ready
                                to provide telemedicine service.
                            </li>
                            <li>We have collaborated with some of the top hospitals in India, enabling the people of
                                Bangladesh to get world-class treatment facilities overseas, without having concerns about
                                paperwork or permission.
                            </li>
                        </ul>

                        {{-- <button class="btn btn-theme mt-3">
                            Contact us
                        </button> --}}
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mission_img">
                        <img src="{{ asset('coverpage/img/mission.jpg') }}" />
                    </div>

                </div>

            </div>
        </div>
    </div>
    <!-- Mission & Goals   start -->
    <div class="mission_goals">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="mission_img">
                        <img src="{{ asset('coverpage/img/mission.jpg') }}" />
                    </div>

                </div>
                <div class="col-md-6">
                    <div class="mission_section">
                        <h3 class="section_title">Why We Are Here</h3>
                        <p class="mt-3"></p>

                        <ul class=" mt-3">
                            <li>Whether you seek doctor consultation or better treatment abroad, our ultimate goal is to
                                provide you with the quality healthcare service you deserve, while keeping costs reasonable.
                                We are devoted to empowering our users, allowing them to make better healthcare decisions
                                with our advanced technology & expert professionals.

                            </li>
                        </ul>

                        {{-- <button class="btn btn-theme mt-3">
                            Contact us
                        </button> --}}
                    </div>
                </div>

            </div>
        </div>
    </div>


    <!--Mission & Goals end -->


@endsection




{{-- Custom Js --}}

@push('mcare_customjs')
    <script src="{{ asset('coverpage/js/jquery-3.2.1.min.js') }}"></script>
    <!-- Bootstrap JS -->
    <!-- scripts -->
    <script src="{{ asset('coverpage/js/scripts.js') }}"></script>
    <script src="{{ asset('coverpage/js/bootstrap.min.js') }}"></script>
    <script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}">
    </script>
    <script type="application/javascript" src="{{ asset('js/jquery.blockUI.js') }}"></script>
    <script type="application/javascript" src="{{ asset('asset/timepicker/js/timepicker.js') }}"></script>
    <script type="application/javascript"
        src="{{ asset('node_modules/jquery-validation/dist/jquery.validate.min.js') }}"></script>

    <script src="{{ asset('js/typeahead.bundle.js') }}"></script>
    <script>
        $(document).on("click", ".image_show", function() {
            $('.img_class').addClass('d-none');
            $('.image_show').removeClass(' shadow-none bg-light rounded');
            var id = $(this).attr("id")
            $('#' + id).addClass(' shadow-none bg-light rounded');
            $('#img_' + id).removeClass('d-none');
        });
    </script>
@endpush
