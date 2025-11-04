@extends('iCure-Home.includes.cover_master')

@push('custom_css')
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('e_commerce/images/favicon.png') }}">
    <!-- Material Design Iconic Font-V2.2.0 -->
    <link rel="stylesheet" href="{{ asset('e_commerce/css/material-design-iconic-font.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('e_commerce/css/font-awesome.min.css') }}">
    <!-- Font Awesome Stars-->
    <link rel="stylesheet" href="{{ asset('e_commerce/css/fontawesome-stars.css') }}">
    <!-- Meanmenu CSS -->
    <link rel="stylesheet" href="{{ asset('e_commerce/css/meanmenu.css') }}">
    <!-- owl carousel CSS -->
    <link rel="stylesheet" href="{{ asset('e_commerce/css/owl.carousel.min.css') }}">
    <!-- Slick Carousel CSS -->
    <link rel="stylesheet" href="{{ asset('e_commerce/css/slick.css') }}">
    <!-- Animate CSS -->
    <link rel="stylesheet" href="{{ asset('e_commerce/css/animate.css') }}">
    <!-- Jquery-ui CSS -->
    <link rel="stylesheet" href="{{ asset('e_commerce/css/jquery-ui.min.css') }}">
    <!-- Venobox CSS -->
    <link rel="stylesheet" href="{{ asset('e_commerce/css/venobox.css') }}">
    <!-- Nice Select CSS -->
    <link rel="stylesheet" href="{{ asset('e_commerce/css/nice-select.css') }}">
    <!-- Magnific Popup CSS -->
    <link rel="stylesheet" href="{{ asset('e_commerce/css/magnific-popup.css') }}">
    <!-- Bootstrap V4.1.3 Fremwork CSS -->
    <link rel="stylesheet" href="{{ asset('e_commerce/css/bootstrap.min.css') }}">
    <!-- Helper CSS -->
    <link rel="stylesheet" href="{{ asset('e_commerce/css/helper.css') }}">
    <!-- Main Style CSS -->
    <link rel="stylesheet" href="{{ asset('e_commerce/style.css') }}">
    <!-- Responsive CSS -->
    <link rel="stylesheet" href="{{ asset('e_commerce/css/responsive.css') }}">
    <!-- Modernizr js -->
    <script src="{{ asset('e_commerce/js/vendor/modernizr-2.8.3.min.js') }}"></script>
@endpush

@section('cover_content')
    <!-- preloader Start -->
    <div class="preloader-wrap">
        <div class="preloader">
            <img src="{{ asset('coverpage/img/loader.gif') }}" alt="">
        </div>
    </div>
    <!-- preloader End -->




    <div id="carousel-indicators" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#carousel-indicators" data-slide-to="0" class="active"></li>
            <li data-target="#carousel-indicators" data-slide-to="1" class=""></li>
            <li data-target="#carousel-indicators" data-slide-to="2" class=""></li>
        </ol>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="d-block w-100" alt="" src="{{ asset('coverpage/img/slider_1.png') }}"
                    data-holder-rendered="true">
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" alt="" src="{{ asset('coverpage/img/p1.png') }}" data-holder-rendered="true">
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" alt="" src="{{ asset('coverpage/img/p2.png') }}" data-holder-rendered="true">
            </div>
        </div>
    </div>




    <div class="working_area">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="section_title_area text-center mb-5">
                        <h3 class="section_title2">Our Woking area</h3>
                        <p class="sub_title"></p>
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-sm-6 col-md-6 col-lg-4">
                    <div class="card shadow-sm  my-3">
                        <div class="card_image">
                            <img class="card-img-top" src="{{ asset('coverpage/img/pharmacy.jpg') }}"
                                alt="Card image cap" />
                            <span class="dept_name">Physical & Online
                                Medicine</span>
                        </div>
                        <div class="card-body">

                            <p class="dept_details">Non-prescription Medicine</p>
                            <p class="dept_details">Prescription Medicine</p>
                            <div class="text-center pt-3">
                                <a href="#" class="btn-transparent">View Details <i class="fas fa-long-arrow-alt-right"></i>
                                </a>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-md-6 col-lg-4">
                    <div class="card shadow-sm  my-3">
                        <div class="card_image">
                            <img class="card-img-top" src="{{ asset('coverpage/img/beauty.jpg') }}"
                                alt="Card image cap" />
                            <span class="dept_name">Health & Beauty
                                Products </span>
                        </div>
                        <div class="card-body">
                            <p class="dept_details">Devices ,Kids Items , Women’s Items , Beauty Products ,Supplements</p>
                            <div class="text-center pt-3">
                                <a href="#" class="btn-transparent">View Details <i class="fas fa-long-arrow-alt-right"></i>
                                </a>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-md-6 col-lg-4">
                    <div class="card shadow-sm  my-3">
                        <div class="card_image">
                            <img class="card-img-top" src="{{ asset('coverpage/img/online_pres.jpg') }}"
                                alt="Card image cap" />
                            <span class="dept_name">Online Doctor
                                Consultation</span>
                        </div>
                        <div class="card-body">
                            <p class="dept_details">Doctors are available here</p>
                            <div class="text-center pt-3">
                                <a href="#" class="btn-transparent">View Details <i class="fas fa-long-arrow-alt-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- working area end -->

    <div class="find_doctors">
        <div class="container">
            <div class="form-row">
                <div class="col-md-12">
                    <div class="text-center mb-3">
                        <h2 class="">Prescription Medicines</h2>
                    </div>
                </div>
            </div>




            <section class="product-area li-laptop-product Special-product pt-60 pb-45">
                <div class="container">
                    @if (!empty($cate_wise_product))
                        @foreach ($cate_wise_product as $cat => $items)

                            @if (!$items->isEmpty())
                                <div class="col-lg-12">
                                    <div class="li-section-title">
                                        <h2>
                                            <span>{{ $cat }}</span>
                                        </h2>
                                    </div>
                                    <div class="row">
                                        <div class="product-active owl-carousel">
                                            @foreach ($items as $item)
                                                <div class="col-lg-12">
                                                    <!-- single-product-wrap start -->
                                                    <div class="single-product-wrap">
                                                        <div class="product-image">
                                                            <a href="single-product.html">
                                                                <img src="{{ env('IMAGE_PATH') . '/images/product/large-size/1.jpg' }}"
                                                                    alt="Product Image">
                                                            </a>
                                                            <span class="sticker">New</span>
                                                        </div>
                                                        <div class="product_desc">
                                                            <div class="product_desc_info">
                                                                <div class="product-review">
                                                                    <h5 class="manufacturer">
                                                                        <a
                                                                            href="shop-left-sidebar.html">{{ $item->cat_lookup_data_name }}</a>
                                                                    </h5>
                                                                    <div class="rating-box">
                                                                        <ul class="rating">
                                                                            <li><i class="fa fa-star-o"></i></li>
                                                                            <li><i class="fa fa-star-o"></i></li>
                                                                            <li><i class="fa fa-star-o"></i></li>
                                                                            <li class="no-star"><i
                                                                                    class="fa fa-star-o"></i>
                                                                            </li>
                                                                            <li class="no-star"><i
                                                                                    class="fa fa-star-o"></i>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                                <h4>
                                                                    <a class="product_name"
                                                                        href="{{ env('ECOMMERCE') . '/product-details/' . $item->item_no_pk . '/' . $item->item_name }}">{{ $item->item_name }}</a>
                                                                </h4>
                                                                <div class="price-box">
                                                                    <span class="new-price">BDT
                                                                        {{ $item->sales_price }}</span>
                                                                </div>
                                                            </div>
                                                            <div class="add-actions">
                                                                <form action="#" class="cart-quantity"
                                                                    id="cartForm{{ $item->item_no_pk }}" method="POST">
                                                                    @csrf
                                                                    <input type="hidden" name="item_id"
                                                                        value="{{ $item->item_no_pk }}">
                                                                    <input type="hidden" name="product_price"
                                                                        value="{{ $item->sales_price }}">
                                                                    <input type="hidden" name="product_name"
                                                                        value="{{ $item->item_name }}">
                                                                    <input class="cart-plus-minus-box" name="cart_quantity"
                                                                        value="1" type="hidden">
                                                                    <ul class="add-actions-link">
                                                                        <li class="add-cart active"><a
                                                                                href="{{ env('ECOMMERCE') . '/product-details/' . $item->item_no_pk . '/' . $item->item_name }}">Add
                                                                                to cart</a></li>
                                                                        <li><a class="links-details"
                                                                                href="wishlist.html"><i
                                                                                    class="fa fa-heart-o"></i></a></li>
                                                                        <li><a href="#" title="quick view"
                                                                                class="quick-view-btn" data-toggle="modal"
                                                                                data-target="#exampleModalCenter"><i
                                                                                    class="fa fa-eye"></i></a></li>
                                                                    </ul>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- single-product-wrap end -->
                                                </div>

                                            @endforeach

                                        </div>
                                    </div>
                                </div>
                            @endif

                        @endforeach

                    @endif
                </div>
            </section>
        </div>
    </div>


    <!-- Find doctor start -->
    <div class="find_doctors">
        <div class="container">
            <div class="form-row">
                <div class="col-md-12">
                    <div class="text-center mb-3">
                        <h2 class="">Find the best doctor</h2>
                    </div>
                </div>
            </div>

            <form action="" method="post" id="SearcForm">
                @csrf
                <div class="form-row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <select class="form-control shadow-sm " name="country">
                                <option value="">Select Country*</option>
                                @if (!empty($country_name))
                                    @foreach ($country_name as $pk => $country)
                                        <option value="{{ $pk }}">{{ $country }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <select class="form-control shadow-sm " name="specialization">
                                <option value="">Select Specialist*</option>
                                @if (!empty($docspl))
                                    @foreach ($docspl as $spe_name)
                                        <option value="{{ $spe_name->specialization_id }}">
                                            {{ $spe_name->specialization_name }}
                                            ({{ $spe_name->no_of_doctor }})
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            {{-- <select class="form-control shadow-sm " name="doctor"> --}}
                            {{-- <option value="">Select Doctor</option> --}}
                            {{-- @if (!empty($doctors)) --}}
                            {{-- @foreach ($doctors as $doc_name) --}}
                            {{-- <option value="{{ $doc_name->person_no_pk }}"> --}}
                            {{-- {{ $doc_name->full_name }} --}}
                            {{-- </option> --}}
                            {{-- @endforeach --}}
                            {{-- @endif --}}
                            {{-- </select> --}}
                            <input type="text" id="primary_doctor" name="primary_doctor" class="form-control shadow-sm "
                                placeholder="Search By Doctor Name" />
                            <input type="hidden" id="doctor_id" name="doctor_id" class="hdn_doctor_id">

                        </div>
                    </div>

                    <div class="col-md-1">
                        <button class="btn btn-theme2 btn-block" type="button" id="formSearchBtn"><i
                                class="fa fa-search"></i></button>
                    </div>
                </div>
            </form>


            <div class="doctors">
                <div class="row" id="doctors_data">
                    @include('iCure-Home.cover_doctor_list')

                </div>
            </div>
        </div>
    </div>
    <!-- Find doctor end -->

    <!-- About us start -->
    <div class="about_us">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="aboutus_video">
                        <a href="#"><i class="fas fa-play"></i></a>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="about_us_section">
                        <h5 class="small_section_title">About us</h5>
                        <h3 class="section_title">Know who we are</h3>
                        <p class="mt-3">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam placerat
                            rutrum turpis, sit amet hendrerit metus vulputate id.</p>

                        <ul class="theme_list_item mt-3">
                            <li>From emergency department care to remote patient monitoring for chronic care management and
                                access to care from specialists.</li>
                            <li> telehealth is changing the way health care is provided both expanding patient access to
                                routine and specialty care while improving patient satisfaction and outcomes.</li>
                            <li>Recent years have seen significant growth in the use of telehealth, to the point where more
                                than .</li>
                        </ul>

                        <button class="btn btn-theme mt-3">
                            Contact us
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- About us end -->




    <!-- why choose us start -->
    <div class="why_choose_us">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-12 col-lg-6">
                    <div class="choose_us_text">
                        <h2 class="section_title">Why choose us!</h2>
                        <p>From emergency department care to remote patient monitoring for chronic care management and
                            access to care from specialists, telehealth is changing the way health care is provided both
                            expanding patient access to routine and specialty care while improving patient satisfaction and
                            outcomes. Recent years have seen significant growth in the use of telehealth, to the point where
                            more than .</p>
                    </div>

                    <div class="full_counter">
                        <div class="row">
                            <div class="col-sm-6 col-md-6 col-lg-6">
                                <div class="counter">
                                    <h3>25000+</h3>
                                    <span>Happy Patients</span>
                                </div>
                            </div>

                            <div class="col-sm-6 col-md-6 col-lg-6">
                                <div class="counter">
                                    <h3>25000+</h3>
                                    <span>Happy Patients</span>
                                </div>
                            </div>

                            <div class="col-sm-6 col-md-6 col-lg-6">
                                <div class="counter">
                                    <h3>25000+</h3>
                                    <span>Happy Patients</span>
                                </div>
                            </div>

                            <div class="col-sm-6 col-md-6 col-lg-6">
                                <div class="counter">
                                    <h3>25000+</h3>
                                    <span>Happy Patients</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 col-lg-6">
                    <div class="choose_us_blocks">
                        <div class="row">
                            <div class="col-sm-6 col-md-6 col-lg-6">
                                <div class="block">
                                    <i class="fas fa-briefcase-medical"></i>
                                    <h4>Qualified Doctors</h4>
                                    <p> Recent years have seen significant growth in the use of telehealth, to the point
                                        where more than . </p>
                                </div>
                            </div>

                            <div class="col-sm-6 col-md-6 col-lg-6">
                                <div class="block">
                                    <i class="fas fa-briefcase-medical"></i>
                                    <h4>Qualified Doctors</h4>
                                    <p> Recent years have seen significant growth in the use of telehealth, to the point
                                        where more than . </p>
                                </div>
                            </div>

                            <div class="col-sm-6 col-md-6 col-lg-6">
                                <div class="block">
                                    <i class="fas fa-briefcase-medical"></i>
                                    <h4>Qualified Doctors</h4>
                                    <p> Recent years have seen significant growth in the use of telehealth, to the point
                                        where more than . </p>
                                </div>
                            </div>

                            <div class="col-sm-6 col-md-6 col-lg-6">
                                <div class="block">
                                    <i class="fas fa-briefcase-medical"></i>
                                    <h4>Qualified Doctors</h4>
                                    <p> Recent years have seen significant growth in the use of telehealth, to the point
                                        where more than . </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- why choose us end -->

    <!-- How Mcare works end -->
    <div class="how_mcare_works">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-12 col-lg-6">
                    <div class="how_mcare_works_text">
                        <h3 class="section_title">How MCARE Online Works</h3>
                        <p> Recent years have seen significant growth in the use of telehealth, to the point where more than
                            . </p>

                        <ul class="theme_list_item mt-3">
                            <li>Recent years have seen significant growth in the use of telehealth.</li>
                            <li>Recent years have seen significant growth in the use of telehealth.</li>
                            <li>Recent years have seen significant growth in the use of telehealth.</li>
                            <li>Recent years have seen significant growth in the use of telehealth.</li>
                            <li>Recent years have seen significant growth in the use of telehealth.</li>
                        </ul>

                        <button class="btn btn-theme mt-4">Make Appointment</button>
                    </div>
                </div>

                <div class="col-md-12 col-lg-6">
                    <img class="w-100" src="{{ asset('coverpage/img/image 9.png') }}" alt="">
                </div>
            </div>
        </div>
    </div>
    <!-- How Mcare works end -->

    <!-- product sale ads start -->
    <div class="sale_ads">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="sale_discount">
                        <img class="w-100" src="{{ asset('coverpage/img/ads1.jpg') }}" alt="">
                        <div class="sale_parcent">
                            <span>Up to</span> <span>50%</span> <span>Sale</span>
                        </div>
                        <div class="sale_text">
                            <p>Buy best medicine from our e pharmacy</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="sale_discount">
                        <img class="w-100" src="{{ asset('coverpage/img/ads2.jpg') }}" alt="">
                        <div class="sale_parcent">
                            <span>Up to</span> <span>50%</span> <span>Sale</span>
                        </div>
                        <div class="sale_text">
                            <p>Free Delivery</p>
                            <p>Buy only 2 products</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- product sale ads end -->


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
                        <p>From emergency department care to remote patient monitoring for chronic care management and
                            access to care from specialists, telehealth is changing the way health care is provided both
                            expanding patient access to routine and specialty care while improving patient satisfaction and
                            outcomes. Recent years have seen significant growth in the use of telehealth, to the point where
                            more than .</p>
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


    <!-- Testimonial Slider Section -->
    <div id="testimonial" class="testimonials_area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section_title_area text-center mb-5">
                        <h3 class="section_title2">Client's Feedback</h3>
                        <p class="sub_title">From emergency department care to remote patient monitoring for chronic
                            care management and access to care from specialists, telehealth is changing the way health care
                            is provided both expanding patient access to routine and specialty care while improving patient
                            satisfaction and outcomes. </p>
                    </div>
                </div>

                <div class="col-12">
                    <div id="testimonialCarousel" class="carousel slide" data-ride="carousel">
                        <!-- Slide Indicators -->
                        <ol class="carousel-indicators">
                            <li data-target="#testimonialCarousel" data-slide-to="0" class="active"></li>
                            <li data-target="#testimonialCarousel" data-slide-to="1"></li>
                            <li data-target="#testimonialCarousel" data-slide-to="2"></li>
                        </ol>
                        <div class="carousel-inner" role="listbox">
                            <!-- Slide 1 -->
                            <div class="carousel-item active">
                                <div class="carousel-content">
                                    <div class="client-img">
                                        <img src="{{ asset('coverpage/img/clients.png') }}" alt="Testimonial Slider">
                                        <div class="client-quote">
                                            <i class="fas fa-quote-right"></i>
                                        </div>
                                    </div>

                                    <div class="testimonials_text">
                                        <h4>Alexa Jonson </h4>
                                        <span>CEO of larajon</span>

                                        <p class="">It is a long established fact that a reader will be
                                            distracted by the readable content of a page when looking at its layout. The
                                            point of using Lorem Ipsum is that it has a more-or-less normal distribution of
                                            letters, as opposed to using ‘Content here, content here’, making it look like
                                            readable English.</p>
                                    </div>
                                </div>
                            </div>
                            <!-- Slide 2 -->
                            <div class="carousel-item">
                                <div class="carousel-content">
                                    <div class="client-img">
                                        <img src="{{ asset('coverpage/img/clients.png') }}" alt="Testimonial Slider">
                                        <div class="client-quote">
                                            <i class="fas fa-quote-right"></i>
                                        </div>
                                    </div>

                                    <div class="testimonials_text">
                                        <h4>Alexa Jonson </h4>
                                        <span>CEO of larajon</span>

                                        <p class="">It is a long established fact that a reader will be
                                            distracted by the readable content of a page when looking at its layout. The
                                            point of using Lorem Ipsum is that it has a more-or-less normal distribution of
                                            letters, as opposed to using ‘Content here, content here’, making it look like
                                            readable English.</p>
                                    </div>
                                </div>
                            </div>
                            <!-- Slide 3 -->
                            <div class="carousel-item">
                                <div class="carousel-content">
                                    <div class="client-img">
                                        <img src="{{ asset('coverpage/img/clients.png') }}" alt="Testimonial Slider">
                                        <div class="client-quote">
                                            <i class="fas fa-quote-right"></i>
                                        </div>
                                    </div>

                                    <div class="testimonials_text">
                                        <h4>Alexa Jonson </h4>
                                        <span>CEO of larajon</span>
                                        <p class="">It is a long established fact that a reader will be
                                            distracted by the readable content of a page when looking at its layout. The
                                            point of using Lorem Ipsum is that it has a more-or-less normal distribution of
                                            letters, as opposed to using ‘Content here, content here’, making it look like
                                            readable English.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Testimonial Slider Section -->

    <!-- contact section area start -->
    <div class="contact_area">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-7 text-center">
                    <div class="contactimg_section">
                        <img src="{{ asset('coverpage/img/contact.png') }}" />
                        <div class="card shadow p-3 contact-box">
                            <h4 class="py-3">
                                We are here for you!
                            </h4>
                            <p class="">
                                <i class="fas fa-quote-left comment_icon"></i>
                                From emergency department care to remote patient monitoring for chronic care management and
                                access to care from specialists, telehealth is changing the way health care is provided both
                                expanding patient access to routine and specialty care while improving patient satisfaction
                                and outcomes. <i class="fas fa-quote-right comment_icon"></i>
                            </p>
                        </div>

                    </div>
                </div>

                <div class="col-md-5 text-center">
                    <div class="contact_section">
                        <h3 class="contact_title">Feel Free to Contact us</h3>
                    </div>
                    <form action="{{ route('cover.contact_us') }}" method="post" id="contact_form">

                        <div class="form">
                            @csrf
                            <div class=" form-group">
                                <input type="text" placeholder="Your Name*" id="c_name" class="form-control"
                                    name="user_name" />
                            </div>
                            <div class=" form-group">
                                <input type="email" placeholder="Your Email*" id="c_email" class="form-control"
                                    name="user_email" />
                            </div>
                            <div class=" form-group">

                                <textarea placeholder="Your Message*" class="form-control text_area" id="c_messag"
                                    name="user_text"></textarea>
                                {{-- <button class="btn btn-theme mt-3">Send</button> --}}
                                @php
                                    $response_url = route('cover-page-v2');
                                @endphp
                                <button type="submit" class="btn btn-theme mt-3"
                                    onclick="contactFunction(this)">Send</button>

                                {{-- <button type="submit"   class="btn btn-signin" >Send</button> --}}

                            </div>
                        </div>
                    </form>
                </div>

            </div>


        </div>
    </div>
    <!-- contact section area end -->

    <!-- footer area start -->
    <div class="footer_area">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <div class="emergency_contact shadow">
                        <i class="fas fa-phone-alt"></i>
                        <i class="fas fa-envelope"></i>
                        <div class="form-row align-items-center">
                            <div class="col-md-5">
                                <h4>Emergency call</h4>
                                <p>{{ isset($po_hospital_details->telephone1) ? $po_hospital_details->telephone1 : '' }}
                                </p>
                            </div>
                            <div class="col-md-2 text-center">
                                <span class="emergency_contact_or">or</span>
                            </div>
                            <div class="col-md-5">
                                <h4>24/7 Email Support</h4>
                                <p>{{ isset($po_hospital_details->email) ? $po_hospital_details->email : '' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <footer>
            <div class="top_footer">
                <div class="container">
                    <div class="row">
                        <div class="col-md-3">
                            <img src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}" />
                            <p class="pt-3 text-light">From emergency department care to remote patient monitoring for
                                chronic care management and access to care from specialists, telehealth is changing the way
                                health care is provided both expanding patient access to routine and specialty care while
                                improving patient satisfaction and outcomes.</p>
                        </div>

                        <div class="col-md-3 footer-links">
                            <h5 class="footer_title">Specialist</h5>
                            <ul>
                                <li> <a href="#">Dental</a></li>
                                <li> <a href="#">Pediatric</a></li>
                                <li> <a href="#">Neurology Management</a></li>
                                <li> <a href="#">Orthopaedics</a></li>
                                <li> <a href="#">Cardiology</a></li>
                            </ul>
                        </div>

                        <div class="col-md-3 footer-links ">
                            <h5 class="footer_title">Links</h5>
                            <ul>
                                <li> <a href="#">Home</a></li>
                                <li> <a href="#">About Us</a></li>
                                <li> <a href="#">Department</a></li>
                                <li> <a href="#">Doctors</a></li>

                            </ul>
                        </div>

                        <div class="col-md-3 footer-links ">
                            <h5 class="footer_title">Contact</h5>
                            <div class="py-2">
                                <span> <i class="fas fa-map-marker-alt pr-1 "> </i> level 1, House450/A, Road 6A, Avenue 6,
                                    Dhaka 1216</span>
                            </div>
                            <div class="py-2">
                                <span> <i class="fas fa-phone-alt pr-1"></i> (886) 710-9709</span>
                            </div>
                            <div class="py-2">
                                <span> <i class="fas fa-envelope pr-1"></i> mediplus@gmail.com</span>
                            </div>
                            <div class="footer_spcial py-2">
                                <a href=""> <i class="fab fa-facebook-f"></i></a>
                                <a href=""> <i class="fab fa-linkedin-in"></i></a>
                                <a href=""> <i class="fab fa-twitter"></i></a>
                                <a href=""> <i class="fab fa-instagram"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="copyright text-center">
                <span>Copyright <i class="far fa-copyright"></i> by H360 Design & Developed by <a
                        href="https://www.nextgenitltd.com/index.php" target="_blank">NEXTGEN INNOVATION LTD.</a> </span>
            </div>
        </footer>
    </div>




    <!-- Appointment Modal -->
    <div class="modal fade" id="bookAppointment" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">

                <div class="modal-body">

                    <!-- Sign-in start -->


                    @include('iCure-Home.sign_in_popup')
                    <!-- sign-in end -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <!-- <button type="button" class="btn btn-success">Sign In</button> -->
                </div>
            </div>
        </div>
    </div>

    <!-- Doctor Details Modal -->
    <div class="modal fade" id="doctor_details" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">

                <div class="modal-body">

                    <h2>Doctor Details</h2>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


@endsection

@push('custom_js')
    <script src="{{ asset('coverpage/js/slick.min.js') }}"></script>
    <script src="{{ asset('e_commerce/js/vendor/jquery-1.12.4.min.js') }}"></script>
    <!-- Popper js -->
    <script src="{{ asset('e_commerce/js/vendor/popper.min.js') }}"></script>
    <!-- Bootstrap V4.1.3 Fremwork js -->
    <script src="{{ asset('e_commerce/js/bootstrap.min.js') }}"></script>
    <!-- Ajax Mail js -->
    <script src="{{ asset('e_commerce/js/ajax-mail.js') }}"></script>
    <!-- Meanmenu js -->
    <script src="{{ asset('e_commerce/js/jquery.meanmenu.min.js') }}"></script>
    <!-- Wow.min js -->
    <script src="{{ asset('e_commerce/js/wow.min.js') }}"></script>
    <!-- Slick Carousel js -->
    <script src="{{ asset('e_commerce/js/slick.min.js') }}"></script>
    <!-- Owl Carousel-2 js -->
    <script src="{{ asset('e_commerce/js/owl.carousel.min.js') }}"></script>
    <!-- Magnific popup js -->
    <script src="{{ asset('e_commerce/js/jquery.magnific-popup.min.js') }}"></script>
    <!-- Isotope js -->
    <script src="{{ asset('e_commerce/js/isotope.pkgd.min.js') }}"></script>
    <!-- Imagesloaded js -->
    <script src="{{ asset('e_commerce/js/imagesloaded.pkgd.min.js') }}"></script>
    <!-- Mixitup js -->
    <script src="{{ asset('e_commerce/js/jquery.mixitup.min.js') }}"></script>
    <!-- Countdown -->
    <script src="{{ asset('e_commerce/js/jquery.countdown.min.js') }}"></script>
    <!-- Counterup -->
    <script src="{{ asset('e_commerce/js/jquery.counterup.min.js') }}"></script>
    <!-- Waypoints -->
    <script src="{{ asset('e_commerce/js/waypoints.min.js') }}"></script>
    <!-- Barrating -->
    <script src="{{ asset('e_commerce/js/jquery.barrating.min.js') }}"></script>
    <!-- Jquery-ui -->
    <script src="{{ asset('e_commerce/js/jquery-ui.min.js') }}"></script>
    <!-- Venobox -->
    <script src="{{ asset('e_commerce/js/venobox.min.js') }}"></script>
    <!-- Nice Select js -->
    <script src="{{ asset('e_commerce/js/jquery.nice-select.min.js') }}"></script>
    <!-- ScrollUp js -->
    <script src="{{ asset('e_commerce/js/scrollUp.min.js') }}"></script>
    <!-- Main/Activator js -->
    <script src="{{ asset('e_commerce/js/main.js') }}"></script>

    <script>
        $(".data-table").DataTable({
            "ordering": false,
            "bPaginate": false,
            "bLengthChange": false,
            "bAutoWidth": false
        });

        $(document).on("click", "#formSearchBtn", function(e) {
            var formID = $("#SearcForm").attr("id");
            var formMethod = $("#SearcForm").attr("method");

            $.ajax({
                data: $('#' + formID).serialize(),
                url: "{{ url('get-doctors-by-specialized') }}",
                type: formMethod,
                beforeSend: function() {
                    //blockUI();
                },
                success: function(data) {
                    console.log(data)
                    $("#doctors_data").html(data);
                },
                complete: function() {
                    // $.unblockUI();
                }
            });
        });


        // new

        function contactFunction(thisElement) {
            event.preventDefault();

            var formID = $(thisElement).parents("form").attr("id");
            var formAction = $(thisElement).parents("form").attr("action");
            var formMethod = $(thisElement).parents("form").attr("method");

            if (formValidation(formID) == false) {
                return;
            }

            if (confirm("Are You Sure?")) {
                $.ajax({
                    async: true,
                    data: $('#' + formID).serialize(),
                    url: formAction,
                    type: formMethod,
                    beforeSend: function() {
                        blockUI();
                    },
                    success: function(data) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Message Sent Successfully',
                            showClass: {
                                popup: 'animate__animated animate__fadeInDown'
                            },
                            hideClass: {
                                popup: 'animate__animated animate__fadeOutUp'
                            }
                        })

                        $("#c_name").val("")
                        $("#c_email").val("")
                        $("#c_messag").val("")

                        $.unblockUI();

                    },
                    error: function(data) {
                        Swal.fire({
                            title: 'Error!',
                            text: 'Do you want to continue',
                            icon: 'error',
                            confirmButtonText: 'Ok'
                        })
                        $.unblockUI();
                    }
                });
            }

            event.stopImmediatePropagation();
        }

        // end

        openDoctorAutocomplete('#primary_doctor', 'doctor_id');
    </script>
@endpush
