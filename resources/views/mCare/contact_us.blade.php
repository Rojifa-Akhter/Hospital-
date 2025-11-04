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



        /*======================================================*/
        /* contact page start*/
        /*======================================================*/


        /*======================================================*/
        /*Download app css start*/
        /*======================================================*/
        .download_app {
            background-color: #0793a6;
            padding: 100px 0px;
        }

        .download_app .device_text h3 {
            color: #fff;
            font-size: 35px;
            margin-bottom: 30px;
        }

        .download_app .device_text p {
            color: #fff;
            font-size: 20px;
            margin-bottom: 30px;
        }

        .download_app .device_image {
            width: 400px;
        }


        /*======================================================*/
        /*Download app css end*/
        /*======================================================*/


        .contact_us {
            padding: 15px 0px;
        }

        .contact_slider {
            background: url((coverpage/img/contact_theme.png) center center no-repeat;
            background-size: cover;
            min-height: 70vh;
            padding: 100px 0px;
            position: relative;
        }

        .contactSlider-text h1 {
            font-size: 50px;
            font-weight: 700;

            font-family: Roboto;
        }

        .contactSlider-text h4 {
            font-size: 20px;
            margin-top: 10px;

        }

        .contactSlider-text span {
            color: #6AAF08;
        }

        .fa-angle-double-right {
            color: #6AAF08;

        }

        .contact_card {
            background-color: #EDFFF6;
            padding: 20px;
        }

        .icon i {
            font-size: 35px;
            padding: 10px;
            color: #025730;
        }

        .content span {
            font-size: 24px;
            font-weight: 600;
            color: #025730;

        }

        .content p {
            color: #025730;
        }

        /*======================================================*/
        /* contact page end*/
        /*======================================================*/

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
                            <h1>Contact Us</h1>
                            <b>Home <i class="fas fa-angle-double-right"> </i> <span>Contact US</span> </b>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Slider end -->




    <!-- contact us start -->
    <div class="contact_us">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 ">
                    <div class="card contact_card d-flex flex-row justify-content-center">
                        <div class="icon">

                            <i class="fas fa-phone-alt"></i>
                        </div>

                        <div class="content">
                            <span>Contact Number</span>
                            <p>{{ isset($po_hospital_details->telephone1) ? $po_hospital_details->telephone1 : '' }}</p>
                        </div>
                    </div>

                </div>

                <div class="col-md-6 ">
                    <div class="card contact_card d-flex flex-row justify-content-center">
                        <div class="icon">

                            <i class="fas fa-envelope"></i>
                        </div>

                        <div class="content">
                            <span>Email Address</span>
                            <p>{{ isset($po_hospital_details->email) ? $po_hospital_details->email : '' }}</p>
                        </div>
                    </div>

                </div>

                <div class="col-md-12 mt-3">
                    <div class="card contact_card d-flex flex-row justify-content-center">
                        <div class="icon">

                            <i class="fas fa-map-marker-alt"></i>
                        </div>

                        <div class="content">
                            <span>Location</span>
                            <p>Wasi Tower, 572/K (13th Floor), ECB Chattar, Matikata, Dhaka Cantonment, Dhaka-1206,
                                Bangladesh .</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- contact us end -->






    <!-- Download app start -->
    <div class="download_app">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="device_image">
                        <img class="w-100" src="{{ asset('coverpage/img/mobile_device.png') }}" alt="">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="device_text">
                        <h3>Download MCARE mobile app</h3>
                        <p>MCARE exists to provide a better customer experience. We are a one-stop-shop for your healthcare
                            products, medicine, offering caring doctors and much more.</p>
                    </div>

                    <div class="store_logo">
                        <img src="{{ asset('coverpage/img/app_store.png') }}" alt="">
                        <img src="{{ asset('coverpage/img/play_store.png') }}" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Download app end -->




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
