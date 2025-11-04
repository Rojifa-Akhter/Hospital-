@extends("mCare.layouts.master")
@section('content')
<style>

.medical-section .products .card {
    border: 1px solid #10a1b6;
}    
.card .product_img_box{
    height: 190px;
    display: flex;
    justify-content: center;
    align-items: center;
    overflow: hidden;
    clear: both;
    width: 100%;
    position: relative;
} 

.card .product_img_box img{
    object-fit: contain;
    max-width: 75%!important;
    object-position: center;
}

.card .product_title{
    display: flex;
    flex-direction: column;
    justify-content: space-evenly;
    height: 75px;
    border-top: 1px solid #10a1b6;
}

</style>
    <!-- banner -->
    {{-- <section class="banner-section"> --}}
    <section class="banner_section">
        <img class="w-100" src="mcare/images/1920X600.jpeg" alt="">{{-- <img class="w-100 banner2" src="mcare/images/banner2.jpg" alt="">
        <img class="w-100 banner3" src="mcare/images/banner3.jpg" alt="">
        <img class="w-100 banner4" src="mcare/images/banner4.jpg" alt="">
        <img class="w-100 banner5" src="mcare/images/banner5.jpg" alt="">
        <img class="w-100 banner6" src="mcare/images/banner6.jpg" alt="">
        <img class="w-100 banner7" src="mcare/images/banner7.jpg" alt="">
        <img class="w-100 banner8" src="mcare/images/banner8.jpg" alt=""> --}}
    </section>
    <!-- banner -->
    <!-- services section -->
    <section class="services-section">
        <h1 class="text-center">our services</h1>
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-sm-6 col-lg-4">
                    <div class="card">
                        <div class="inner-gallery">
                            <img src="mcare/images/hospital.jpeg" alt="" />
                        </div>

                        <div class="card-body text-center">
                            <h5 class="card-title">Hospital</h5>
                            <a href="{{ ENV('ECOMMERCE') }}" class="btn">View More</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 col-sm-6 col-lg-4">
                    <div class="card">
                        <div class="inner-gallery">

                            <img src="mcare/images/doctor.jpeg" alt="" />

                        </div>

                        <div class="card-body text-center">
                            <h5 class="card-title">Doctor</h5>
                            <a href="{{ route('cover.doctor-list') }}" class="btn">View More</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 col-sm-6 col-lg-4">
                    <div class="card">
                        <div class="inner-gallery">

                            <img src="mcare/images/medicine.jpeg" alt="" />

                        </div>

                        <div class="card-body text-center">
                            <h5 class="card-title">Medicine, Health & Beauty</h5>
                            <a href="{{ ENV('ECOMMERCE') }}" target="_blank" class="btn">View More</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- services section -->


    <!-- Hospital section start -->
    <section class="hospital-section">
        <div class="section_header">
            <div class="container-fluid justify-content-between">
                <div class="row align-items-center">
                    <div class="col-md-4 col-sm-6">
                        <h2>Hospital</h2>
                    </div>
                    <div class="col-md-8 col-sm-6">
                        <div class="inner-hospital">
                            <form class="d-flex justify-content-end my-2 my-lg-0" action="" method="post"
                                id="hospital_form_id" onsubmit="return false">
                                @csrf
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Search"
                                        aria-label="Recipient's username with two button addons"
                                        aria-describedby="button-addon4" value="" id="hospital_search_id" />
                                    <div class="input-group-append" id="button-addon4">
                                        <select name="" id="hosptial_category">
                                            <option value="">All Category</option>
                                            <option value="India">India</option>
                                            <option value="Bangladesh">Bangladesh</option>
                                        </select>
                                        <button class="srchbtn srchbtn_hospital" type="button"><i
                                                class="fa fa-search"></i></button>
                                    </div>
                                </div>
                            </form>
                            <a href="{{ route('cover.hospital-list') }}" class="btn">View All</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- INDIA Hospital -->
        <div class="hospitals">
            <div class="container">
                <div class="row justify-content-between align-items-center hospital-content">
                    {{-- <div class="col-6">
                        <h3>India</h3>
                    </div>
                    <div class="col-6 text-right">
                        <a href="{{ route('cover.hospital-list') }}" class="btn">view More</a>
                    </div> --}}
                </div>
            </div>
        </div>

        <!-- Hospital -->
        <div class="container">
            <div class="row hospital_list">
                @include('mCare.search_hospital_list')

            </div>
        </div>
        <!-- Hospital -->
        <!-- INDIA Hospital -->

        <!-- BANGLADESH hospital -->
        {{-- <div class="hospitals">
            <div class="container">
                <div class="row justify-content-between align-items-center hospital-content">
                    <div class="col-6">
                        <h3>Bangladesh</h3>
                    </div>
                    <div class="col-6 text-right">
                        <a href="{{ route('cover.hospital-list') }}" class="btn">view More</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Hospital -->
        <div class="container">
            <div class="row">
                @if (!$hospital_bangladesh->isEmpty())
                    @foreach ($hospital_bangladesh as $bd_hospital)
                        @php
                            $image_path = isset($bd_hospital->image_url) ? 'images/uploads/hospital_images/' . $bd_hospital->image_url : 'mcare/images/b2.jpg';
                        @endphp

                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <div class="hospital-box">
                                <div class="d-flex flex-row mb-3">
                                    <span class="hospital-img"><img src="{{ asset($image_path) }}"
                                            alt="Hospital" /></span>
                                    <div class="d-flex flex-column ml-2">
                                        <h2>{{ $bd_hospital->chamber_hospital_name }}</h2>
                                        <ul class="list-unstyled list mt-2">
                                            <li class="d-flex align-items-center">
                                                <i class="fas fa-map-marker-alt mr-2"></i>
                                                <b>{{ $bd_hospital->chamber_hospital_location }}</b>
                                            </li>
                                            <li class="d-flex align-items-center">
                                                <i class="far fa-hospital mr-2"></i>
                                                <b>Established in: {{ $bd_hospital->establishe_year }}</b>
                                            </li>
                                            <li class="d-flex align-items-center">
                                                <i class="fas fa-bed mr-2"></i>
                                                <b>Number of Beds: {{ $bd_hospital->number_of_bed }}</b>
                                            </li>
                                            <li class="d-flex align-items-center">
                                                <i class="fas fa-certificate mr-2"></i>
                                                <b>{{ $bd_hospital->chamber_hospital_speciality }}</b>
                                            </li>
                                            <li class="d-flex align-items-center">
                                                <i class="far fa-star mr-2"></i>
                                                <b>{{ $bd_hospital->chamber_hospital_location }}</b>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <h4 class="text-center">No hospital available at this time.</h4>
                    </div>

                @endif
            </div>
        </div> --}}

        <!-- hospital box -->
        <!-- BANGLADESH Hospital -->
    </section>
    <!-- Hospital section end-->





    <!-- Doctors section -->
    <section class="doctor-section">
        <div class="section_header">
            <div class="container-fluid justify-content-between">
                <div class="row align-items-center">
                    <div class="col-md-4 col-sm-6 col-sm-6">
                        <h2>Doctor</h2>
                    </div>
                    <div class="col-md-8 col-sm-6 col-sm-6">
                        <div class="inner-doctor">
                            <form class="d-flex justify-content-end my-2 my-lg-0" action="" method="post" id="doctorForm"
                                onsubmit="return false">
                                @csrf
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Search"
                                        aria-label="Recipient's username with two button addons"
                                        aria-describedby="button-addon4" id="search_doctor" />
                                    <div class="input-group-append" id="button-addon4">
                                        <select name="" id="category">
                                            <option value="">All Category</option>
                                            <option value="India">India</option>
                                            <option value="Bangladesh">Bangladesh</option>
                                        </select>
                                        <button class="srchbtn srchbtn_doctors" type="button"><i
                                                class="fa fa-search"></i></button>
                                    </div>
                                </div>
                            </form>
                            <a href="{{ route('cover.doctor-list') }}" class="btn">View All</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- INDIA DOCTOR -->

        <div class="doctors">


            <div class="container">
                <div class="row justify-content-between align-items-center doctor-content">
                    {{-- <div class="col-6">
                        <h3>India</h3>
                    </div>
                    <div class="col-6 text-right">
                        <a href="{{ route('cover.doctor-list') }}" class="btn">view More</a>
                    </div> --}}
                </div>
            </div>
        </div>
        <!-- doctor box -->
        <div class="container">
            <div class="row doctor_list">
                @include('mCare.doctor_wise_list')
            </div>
        </div>
        <!-- doctor box -->
        <!-- INDIA DOCTOR -->

        <!-- BANGLADESH DOCTOR -->
        {{-- <div class="doctors">
            <div class="container">
                <div class="row justify-content-between align-items-center doctor-content">
                    <div class="col-6">
                        <h3>Bangladesh</h3>
                    </div>
                    <div class="col-6 text-right">
                        <a href="{{ route('cover.doctor-list') }}" class="btn">view More</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- doctor box -->
        <div class="container">
            <div class="row">
                @if (!$doctor_ban_list->isEmpty())
                    @foreach ($doctor_ban_list as $banDoc)
                        @php
                            if (isset($banDoc->photo_name)) {
                                $imagePath = 'images/uploads/doctor_images/' . $banDoc->photo_name;
                            } else {
                                if (strtoupper($banDoc->gender_txt) == 'MALE') {
                                    $imagePath = 'mcare/images/dr1.jpg';
                                } else {
                                    $imagePath = 'images/nurse-2.png';
                                }
                            }

                        @endphp
                        <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                            <div class="doctor-box">
                                <div class="d-flex flex-row mb-3">
                                    <span class="doctor-img"><img src="{{ asset($imagePath) }}"
                                            alt="doctor" /></span>
                                    <div class="d-flex flex-column ml-2">
                                        <h2>{{ $banDoc->full_name }}</h2>
                                        <h3>{{ $banDoc->specialization }} Specialist.</h3>
                                        <ul class="list-unstyled list mt-2">
                                            <li class="d-flex align-items-center">
                                                <i class="far fa-hospital mr-3 text-primary"></i>
                                                <span>{{ $banDoc->chamber_hospital_name }} </span>
                                            </li>
                                            <li class="d-flex align-items-center">
                                                <i class="far fa-star mr-2 text-primary"></i>
                                                <b>Highlight</b>
                                            </li>
                                        </ul>
                                        <div class="d-flex flex-column">
                                            @php
                                                echo substr($banDoc->remarks_text, 0, 50) . '...';
                                            @endphp
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                        <h5>No doctor available at this time</h5>
                    </div>
                @endif

            </div>
        </div> --}}
        <!-- doctor box -->
        <!-- BANGLADESH DOCTOR -->
    </section>
    <!-- Doctors section end -->

    <!-- Medicine, Health & Beauty -->
    <section class="medical-section">
        <div class="section_header">
            <div class="container-fluid justify-content-between">
                <div class="row align-items-center">
                    <div class="col-md-4 col-sm-6">
                        <h2>Medicine, Health & Beauty</h2>
                    </div>
                    <div class="col-md-8 col-sm-6">
                        <div class="inner-medical">
                            <form class="d-flex justify-content-end my-2 my-lg-0" method="get"
                                action="{{ ENV('ECOMMERCE') }}/search-product" id="cat_form">
                                @csrf
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Search"
                                        aria-label="Recipient's username with two button addons"
                                        aria-describedby="button-addon4" id="pro_id" name="search_term" />
                                    <div class="input-group-append" id="button-addon4">
                                        <select name="" id='SelectOption'>
                                            <option value="">All Category</option>
                                            <option value="Medicine">
                                                <a class="nav-link" href="{{ ENV('ECOMMEDICINE') }}"
                                                    target="_blank">Medicine</a>
                                            </option>

                                            <option value="Health and Beauty">
                                                <a class="nav-link" href="{{ ENV('ECOMHEALTH') }}"
                                                    target="_blank">Health and Beauty</a>
                                            </option>
                                            {{-- @if (!empty($item_cat_arr))
                                                @foreach ($item_cat_arr as $data)
                                                    <option value="{{ $data->lookupdata_no_pk }}"><a
                                                            class="nav-link"
                                                            href="{{ ENV('ECOMMERCE') }}">{{ $data->lookupdata_name }}</a>
                                                    </option>
                                                @endforeach
                                            @endif --}}
                                        </select>
                                        <button type="submit" class="srchbtn search_cat_id"><i
                                                class="fa fa-search"></i></button>

                                    </div>
                                </div>
                            </form>
                            <a href="{{ ENV('ECOMMERCE') }}" class="btn">View All</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="products">
            <div class="container">
                <div class="row justify-content-between align-items-center product-content">
                    <div class="col-6">
                        <h3>Product</h3>
                    </div>
                    <div class="col-6 text-right">
                        <a href="{{ ENV('ECOMMERCE') }}" class="btn">view More</a>
                    </div>
                </div>
                <div class="row medproduct">


                    @include('mCare.search_product_list')



                </div>
            </div>
        </div>
    </section>
    <!-- Medicine, Health & Beauty -->

    <!-- discount section -->
    <section class="discount-section">
        <div class="container">
            <div class="row align-items-center discount_m">
                <div class="col-md-12 col-sm-12">
                    <div class="inner-discount">
                        <div class="sale_discount">
                            <img class="w-100" src="{{ asset('mcare/images/01.jpg') }}" alt="">
                            {{-- <div class="sale_parcent">
                                <span>Up to</span> <span>50%</span> <span>Sale</span>
                            </div>
                            <div class="sale_text">
                                <p>Buy best medicine from our e pharmacy</p>
                            </div> --}}
                        </div>
                    </div>
                </div>

                <div class="col-md-12 col-sm-12">
                    <div class="inner-discount">
                        <div class="sale_discount">
                            <img class="w-100" src="mcare/images/02.jpg" alt="">
                            {{-- <div class="sale_parcent">
                                <span>Up to</span> <span>50%</span> <span>Sale</span>
                            </div>
                            <div class="sale_text">
                                <p>Buy best medicine from our e pharmacy</p>
                            </div> --}}
                        </div>
                    </div>
                </div>

                <div class="col-md-12 col-sm-12">
                    <div class="inner-discount">
                        <div class="sale_discount">
                            <img class="w-100" src="mcare/images/03.jpg" alt="">
                            {{-- <div class="sale_parcent">
                                <span>Up to</span> <span>50%</span> <span>Sale</span>
                            </div>
                            <div class="sale_text">
                                <p>Buy best medicine from our e pharmacy</p>
                            </div> --}}
                        </div>
                    </div>
                </div>

                <div class="col-md-12 col-sm-12">
                    <div class="inner-discount">
                        <div class="sale_discount">
                            <img class="w-100" src="mcare/images/04.jpg" alt="">
                            {{-- <div class="sale_parcent">
                                <span>Up to</span> <span>50%</span> <span>Sale</span>
                            </div>
                            <div class="sale_text">
                                <p>Buy best medicine from our e pharmacy</p>
                            </div> --}}
                        </div>
                    </div>
                </div>

                <div class="col-md-12 col-sm-12">
                    <div class="inner-discount">
                        <div class="sale_discount">
                            <img class="w-100" src="mcare/images/05.jpg" alt="">
                            {{-- <div class="sale_parcent">
                                <span>Up to</span> <span>50%</span> <span>Sale</span>
                            </div>
                            <div class="sale_text">
                                <p>Buy best medicine from our e pharmacy</p>
                            </div> --}}
                        </div>
                    </div>
                </div>


                <div class="col-md-12 col-sm-12">
                    <div class="inner-discount">
                        <div class="sale_discount">
                            <img class="w-100" src="mcare/images/06.jpg" alt="">
                            {{-- <div class="sale_parcent">
                                <span>Up to</span> <span>50%</span> <span>Sale</span>
                            </div>
                            <div class="sale_text">
                                <p>Buy best medicine from our e pharmacy</p>
                            </div> --}}
                        </div>
                    </div>
                </div>


                <div class="col-md-12 col-sm-12">
                    <div class="inner-discount">
                        <div class="sale_discount">
                            <img class="w-100" src="mcare/images/01.jpg" alt="">
                            {{-- <div class="sale_parcent">
                                <span>Up to</span> <span>50%</span> <span>Sale</span>
                            </div>
                            <div class="sale_text">
                                <p>Buy best medicine from our e pharmacy</p>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- discount section -->

    <!-- Testimonial Slider Section -->
    {{-- <div id="testimonial" class="testimonials_area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section_title_area text-center mb-5">
                        <h3 class="section_title2">Client's Feedback</h3>
                        <p class="sub_title">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam
                            placerat rutrum turpis, sit amet hendrerit metus.</p>
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
                                        <img src="mcare/images/clients.png" alt="Testimonial Slider">
                                        <div class="client-quote">
                                            <i class="fas fa-quote-right"></i>
                                        </div>
                                    </div>

                                    <div class="testimonials_text">
                                        <h4>Alexa Jonson </h4>
                                        <span>CEO of larajon</span>

                                        <p class="">It is a long established fact that a reader will be
                                            distracted by the readable content of a page when looking at its layout. The
                                            point of using Lorem Ipsum is that it has a more-or-less normal distribution
                                            of letters, as opposed to using ‘Content here, content here’, making it look
                                            like readable English.</p>
                                    </div>
                                </div>
                            </div>
                            <!-- Slide 2 -->
                            <div class="carousel-item">
                                <div class="carousel-content">
                                    <div class="client-img">
                                        <img src="mcare/images/clients.png" alt="Testimonial Slider">
                                        <div class="client-quote">
                                            <i class="fas fa-quote-right"></i>
                                        </div>
                                    </div>

                                    <div class="testimonials_text">
                                        <h4>Alexa Jonson </h4>
                                        <span>CEO of larajon</span>

                                        <p class="">It is a long established fact that a reader will be
                                            distracted by the readable content of a page when looking at its layout. The
                                            point of using Lorem Ipsum is that it has a more-or-less normal distribution
                                            of letters, as opposed to using ‘Content here, content here’, making it look
                                            like readable English.</p>
                                    </div>
                                </div>
                            </div>
                            <!-- Slide 3 -->
                            <div class="carousel-item">
                                <div class="carousel-content">
                                    <div class="client-img">
                                        <img src="mcare/images/clients.png" alt="Testimonial Slider">
                                        <div class="client-quote">
                                            <i class="fas fa-quote-right"></i>
                                        </div>
                                    </div>

                                    <div class="testimonials_text">
                                        <h4>Alexa Jonson </h4>
                                        <span>CEO of larajon</span>
                                        <p class="">It is a long established fact that a reader will be
                                            distracted by the readable content of a page when looking at its layout. The
                                            point of using Lorem Ipsum is that it has a more-or-less normal distribution
                                            of letters, as opposed to using ‘Content here, content here’, making it look
                                            like readable English.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    <!-- End Testimonial Slider Section -->

    <div id="testimonial" class="testimonials_area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section_title_area text-center mb-5">
                        <h3 class="section_title2">How MCARE Online Works</h3>
                    </div>
                </div>

                <div class="col-lg-12">
                    <img src="mcare/images/how_works_mcare.jpeg" alt="" width="100%">
                </div>
            </div>
        </div>
    </div>


    <!-- online section -->
    {{-- <section class="online-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="inner-online">
                        <h2>How MCARE Online Works</h2>
                        <p>How can you get access to telemedicine service & treatment in India if required?</p>
                        <ul class="list-unstyled list mt-2">
                            <li class="d-flex align-items-center image_show  shadow-none bg-light rounded" id="1"
                                style="cursor: pointer;">
                                <i class="far fa-check-circle mr-3 text-primary"></i>
                                Step 1: Call us for free consultation >> 01938861472
                            </li>
                            <li class="d-flex align-items-center image_show" id="2" style="cursor: pointer;"><i
                                    class="far fa-check-circle mr-3 text-primary"></i>Step 2: We will choose a doctor based
                                on your health needs.</li>
                            <li class="d-flex align-items-center image_show" id="3" style="cursor: pointer;"><i
                                    class="far fa-check-circle mr-3 text-primary"></i>Step 3: Consult with a Doctor through
                                a video call.</li>
                            <li class="d-flex align-items-center image_show" id="4" style="cursor: pointer;"><i
                                    class="far fa-check-circle mr-3 text-primary"></i>Step 4: If your doctor recommends
                                treatment in India, we will provide all the support you need.</li>
                            <li class="d-flex align-items-center image_show" id="5" style="cursor: pointer;"><i
                                    class="far fa-check-circle mr-3 text-primary"></i>Step 5: We are always available for
                                any post-treatment cooperation.</li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="online-img  img_class" id="img_1">
                        <img src="{{ asset('mcare/images/MCARE Ads Image (1).jpeg') }}" style="width: 360px;" alt="" />
                    </div>

                    <div class="online-img d-none img_class" id="img_2">
                        <img src="{{ asset('mcare/images/MCARE Ads Image (2).jpeg') }}" style="width: 360px;" alt="" />
                    </div>

                    <div class="online-img d-none img_class" id="img_3">
                        <img src="{{ asset('mcare/images/MCARE Ads Image (3).jpeg') }}" style="width: 360px;" alt="" />
                    </div>

                    <div class="online-img d-none img_class" id="img_4">
                        <img src="{{ asset('mcare/images/MCARE Ads Image (4).jpeg') }}" style="width: 360px;" alt="" />
                    </div>

                    <div class="online-img d-none img_class" id="img_5">
                        <img src="{{ asset('mcare/images/MCARE Ads Image (5).jpeg') }}" style="width: 360px;" alt="" />
                    </div>
                </div>
            </div>
            <!-- app -->
            <div class="row align-items-center py-5">
                <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                    <div class="inner-app">
                        <div class="d-flex align-items-center justify-content-between flex-row">
                            <span class="app-img"><img src="mcare/images/app.png" alt="download app" /></span>
                            <div class="d-flex flex-column">
                                <h2>Download the mobile app</h2>
                                <p>To enjoy the full experience, please download the mobile App</p>
                            </div>
                            <a href="#" class="btn">Download Now</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                    <div class="inner-app">
                        <div class="d-flex align-items-center justify-content-between flex-row">
                            <span class="app-img"><img src="images/corona.png" alt="corona" /></span>
                            <div class="d-flex flex-column">
                                <h2>CORONA SYMPTOM CHECKER (FREE)</h2>
                                <p>
                                    Answer some simple questions and get an idea about <br />
                                    whether you are at risk of getting affected by coronavirus
                                </p>
                            </div>
                            <a href="#" class="btn">Check Now</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- app -->
        </div>
    </section> --}}

    <!-- online section -->
@endsection




{{-- Custom Js --}}

@push('mcare_customjs')



    <script>
        $(document).ready(function() {





        });



        $(document).on("click", ".image_show", function() {
            $('.img_class').addClass('d-none');
            $('.image_show').removeClass(' shadow-none bg-light rounded');
            var id = $(this).attr("id")
            $('#' + id).addClass(' shadow-none bg-light rounded');
            $('#img_' + id).removeClass('d-none');
        });



        // search worklist

        // Search Doctor

        $('#doctorForm').keypress(function(e) {
            if (e.which == 13) {
                //e.preventDefault();
                // alert('doctor')
                var search_doctor = $('#search_doctor').val();
                var category = $('#category').val();
                var formID = $("#doctorForm").attr("id");
                var formMethod = $("#doctorForm").attr("method");
                $.ajax({
                    url: "{{ url('coverpage/search-doctor-list') }}",
                    data: {
                        category: category,
                        search_doctor: search_doctor
                    },
                    type: formMethod,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    beforeSend: function() {
                        // blockUI();

                    },
                    success: function(data) {
                        $(".doctor_list").html(data);
                    },
                    complete: function() {
                        //$.unblockUI();
                    }
                });
            }
        });

        $(document).on("click", ".srchbtn_doctors", function(e) {
            var search_doctor = $('#search_doctor').val();
            var category = $('#category').val();
            var formID = $("#doctorForm").attr("id");
            var formMethod = $("#doctorForm").attr("method");
            $.ajax({
                url: "{{ url('coverpage/search-doctor-list') }}",
                data: {
                    category: category,
                    search_doctor: search_doctor
                },
                type: formMethod,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function() {
                    // blockUI();

                },
                success: function(data) {
                    $(".doctor_list").html(data);
                },
                complete: function() {
                    //$.unblockUI();
                }
            });
        });


        $(document).on("change", "#category", function(e) {
            var search_doctor = $('#search_doctor').val();
            var category = $(this).val();
            var formID = $("#doctorForm").attr("id");
            var formMethod = $("#doctorForm").attr("method");
            $.ajax({
                url: "{{ url('coverpage/search-doctor-list') }}",
                data: {
                    category: category,
                    search_doctor: search_doctor
                },
                type: formMethod,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function() {
                    // blockUI();

                },
                success: function(data) {
                    $(".doctor_list").html(data);
                },
                complete: function() {
                    //$.unblockUI();
                }
            });
        });



        // Search Hospital

        $('#hospital_form_id').keypress(function(e) {
            if (e.which == 13) {
                //e.preventDefault();
                var hospital_search_id = $('#hospital_search_id').val();
                var hosptial_category = $('#hosptial_category').val();
                var formID = $("#hospital_form_id").attr("id");
                var formMethod = $("#hospital_form_id").attr("method");
                $.ajax({
                    url: "{{ url('coverpage/search-hospital-list') }}",
                    data: {
                        hospital_search_id: hospital_search_id,
                        hosptial_category: hosptial_category
                    },
                    type: formMethod,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    beforeSend: function() {
                        // blockUI();

                    },
                    success: function(data) {
                        $(".hospital_list").html(data);
                    },
                    complete: function() {
                        //$.unblockUI();
                    }
                });
            }
        });

        $(document).on("click", ".srchbtn_hospital", function(e) {
            var hospital_search_id = $('#hospital_search_id').val();
            var hosptial_category = $('#hosptial_category :selected').val();
            var formID = $("#hospital_form_id").attr("id");
            var formMethod = $("#hospital_form_id").attr("method");
            $.ajax({
                url: "{{ url('coverpage/search-hospital-list') }}",
                data: {
                    hospital_search_id: hospital_search_id,
                    hosptial_category: hosptial_category
                },
                type: formMethod,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function() {
                    // blockUI();

                },
                success: function(data) {
                    $(".hospital_list").html(data);
                },
                complete: function() {
                    //$.unblockUI();
                }
            });
        });

        $(document).on("change", "#hosptial_category", function(e) {
            var hospital_search_id = $('#hospital_search_id').val();
            var hosptial_category = $(this).val();
            console.log(hosptial_category);
            var formID = $("#hospital_form_id").attr("id");
            var formMethod = $("#hospital_form_id").attr("method");
            $.ajax({
                url: "{{ url('coverpage/search-hospital-list') }}",
                data: {
                    hospital_search_id: hospital_search_id,
                    hosptial_category: hosptial_category
                },
                type: formMethod,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function() {
                    // blockUI();

                },
                success: function(data) {
                    $(".hospital_list").html(data);
                },
                complete: function() {
                    //$.unblockUI();
                }
            });
        });




        // Search Product

        // $('#cat_form').keypress(function(e) {
        //     if (e.which == 13) {
        //         var pro_id = $('#pro_id').val();
        //         var cat_id = $('#cat_id').val();
        //         var formID = $("#cat_form").attr("id");
        //         var formMethod = $("#cat_form").attr("method");
        //         $.ajax({
        //             url: "{{ url('coverpage/search-product-list') }}",
        //             data: {
        //                 pro_id: pro_id,
        //                 cat_id: cat_id
        //             },
        //             type: formMethod,
        //             headers: {
        //                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //             },
        //             beforeSend: function() {
        //                 // blockUI();

        //             },
        //             success: function(data) {
        //                 $(".medproduct").html(data);
        //             },
        //             complete: function() {
        //                 //$.unblockUI();
        //             }
        //         });
        //     }
        // });

        // $(document).on("click", ".search_cat_id", function(e) {
        //     var pro_id = $('#pro_id').val();
        //     var cat_id = $('#cat_id').val();
        //     var formID = $("#cat_form").attr("id");
        //     var formMethod = $("#cat_form").attr("method");
        //     $.ajax({
        //         url: "{{ url('coverpage/search-product-list') }}",
        //         data: {
        //             pro_id: pro_id,
        //             cat_id: cat_id
        //         },
        //         type: formMethod,
        //         headers: {
        //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //         },
        //         beforeSend: function() {
        //             // blockUI();

        //         },
        //         success: function(data) {
        //             $(".medproduct").html(data);
        //         },
        //         complete: function() {
        //             //$.unblockUI();
        //         }
        //     });
        // });

        document.getElementById('SelectOption').addEventListener('change', function() {
            val = $("#SelectOption").val();

            console.log(val)
            if (val === 'Medicine') {
                window.open('{{ ENV('ECOMMEDICINE') }}', '_blank');
            }
            if (val === 'Health and Beauty') {
                window.open('{{ ENV('ECOMHEALTH') }}', '_blank');
            }
        });
    </script>
@endpush
