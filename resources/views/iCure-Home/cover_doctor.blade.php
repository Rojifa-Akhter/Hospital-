@extends('iCure-Home.includes.cover_master')
@section('cover_content')
    <!-- preloader Start -->
    <div class="preloader-wrap">
        <div class="preloader">
            <img src="{{asset('coverpage/img/loader.gif')}}" alt="">
            <!-- <span></span><span></span><span></span><span></span> -->
        </div>
    </div>
    <!-- preloader End -->


    <!-- Slider Start -->
    <div class="doctor_hero_section">
        <div class="hero_section">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="hero_text">
                            <h1>Doctor</h1>
                            <b>Home <i class="fas fa-angle-double-right"> </i> <span>Doctor</span> </b>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Slider end -->

    <div class="find_doctors">
        <div class="container">
            <div class="form-row">
                <div class="col-md-12">
                    <div class="text-center mb-3">
                        <h2 class="">Find the best doctor</h2>
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="col-md-3">
                    <div class="form-group">
                        <select class="form-control shadow-sm">
                            <option>Select Country*</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <select class="form-control shadow-sm">
                            <option>Select Specialist*</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <select class="form-control shadow-sm">
                            <option>Select Doctor</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-1">
                    <button class="btn btn-theme2 btn-block"><i class="fa fa-search"></i></button>
                </div>
            </div>

            <div class="doctors">
                <div class="row">
                    <div class="col-sm-12 col-md-6 col-xl-3">
                        <div class="doctor_card">
                            <div class="doctor_image">
                                <img class="w-100" src="{{asset('coverpage/img/doc1.png')}}" alt="">
                            </div>

                            <div class="doctor_info">
                                <h5 class="doctor_name">Dr. Royal Matthew </h5>
                                <p class="doctor_degree"><i class="fas fa-graduation-cap"></i>&nbsp;&nbsp;MBBS, DCO, MPHO </p>
                                <p class="rating"><i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i></p>
                                <p class="doctor_experience"><span>Experience:</span> 5 years</p>
                                <p class="doctor_fees"><span>Doctor Fees:</span> 100 BDT</p>
                                <button class="btn btn-theme2 font-size-14 btn-block">Book Appointment</button>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6 col-xl-3">
                        <div class="doctor_card">
                            <div class="doctor_image">
                                <img class="w-100" src="{{asset('coverpage/img/doc2.jpg')}}" alt="">
                            </div>

                            <div class="doctor_info">
                                <h5 class="doctor_name">Dr. Royal Matthew </h5>
                                <p class="doctor_degree"><i class="fas fa-graduation-cap"></i>&nbsp;&nbsp;MBBS, DCO, MPHO </p>
                                <p class="rating"><i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i></p>
                                <p class="doctor_experience"><span>Experience:</span> 5 years</p>
                                <p class="doctor_fees"><span>Doctor Fees:</span> 100 BDT</p>
                                <button class="btn btn-theme2 font-size-14 btn-block">Book Appointment</button>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6 col-xl-3">
                        <div class="doctor_card">
                            <div class="doctor_image">
                                <img class="w-100" src="{{asset('coverpage/img/doc3.jpg')}}" alt="">
                            </div>

                            <div class="doctor_info">
                                <h5 class="doctor_name">Dr. Royal Matthew </h5>
                                <p class="doctor_degree"><i class="fas fa-graduation-cap"></i>&nbsp;&nbsp;MBBS, DCO, MPHO </p>
                                <p class="rating"><i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i></p>
                                <p class="doctor_experience"><span>Experience:</span> 5 years</p>
                                <p class="doctor_fees"><span>Doctor Fees:</span> 100 BDT</p>
                                <button class="btn btn-theme2 font-size-14 btn-block">Book Appointment</button>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6 col-xl-3">
                        <div class="doctor_card">
                            <div class="doctor_image">
                                <img class="w-100" src="{{asset('coverpage/img/doc4.jpg')}}" alt="">
                            </div>

                            <div class="doctor_info">
                                <h5 class="doctor_name">Dr. Royal Matthew </h5>
                                <p class="doctor_degree"><i class="fas fa-graduation-cap"></i>&nbsp;&nbsp;MBBS, DCO, MPHO </p>
                                <p class="rating"><i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i></p>
                                <p class="doctor_experience"><span>Experience:</span> 5 years</p>
                                <p class="doctor_fees"><span>Doctor Fees:</span> 100 BDT</p>
                                <button class="btn btn-theme2 font-size-14 btn-block">Book Appointment</button>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6 col-xl-3">
                        <div class="doctor_card">
                            <div class="doctor_image">
                                <img class="w-100" src="{{asset('coverpage/img/doc1.png')}}" alt="">
                            </div>

                            <div class="doctor_info">
                                <h5 class="doctor_name">Dr. Royal Matthew </h5>
                                <p class="doctor_degree"><i class="fas fa-graduation-cap"></i>&nbsp;&nbsp;MBBS, DCO, MPHO </p>
                                <p class="rating"><i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i></p>
                                <p class="doctor_experience"><span>Experience:</span> 5 years</p>
                                <p class="doctor_fees"><span>Doctor Fees:</span> 100 BDT</p>
                                <button class="btn btn-theme2 font-size-14 btn-block">Book Appointment</button>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6 col-xl-3">
                        <div class="doctor_card">
                            <div class="doctor_image">
                                <img class="w-100" src="{{asset('coverpage/img/doc2.jpg')}}" alt="">
                            </div>

                            <div class="doctor_info">
                                <h5 class="doctor_name">Dr. Royal Matthew </h5>
                                <p class="doctor_degree"><i class="fas fa-graduation-cap"></i>&nbsp;&nbsp;MBBS, DCO, MPHO </p>
                                <p class="rating"><i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i></p>
                                <p class="doctor_experience"><span>Experience:</span> 5 years</p>
                                <p class="doctor_fees"><span>Doctor Fees:</span> 100 BDT</p>
                                <button class="btn btn-theme2 font-size-14 btn-block">Book Appointment</button>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6 col-xl-3">
                        <div class="doctor_card">
                            <div class="doctor_image">
                                <img class="w-100" src="{{asset('coverpage/img/doc3.jpg')}}" alt="">
                            </div>

                            <div class="doctor_info">
                                <h5 class="doctor_name">Dr. Royal Matthew </h5>
                                <p class="doctor_degree"><i class="fas fa-graduation-cap"></i>&nbsp;&nbsp;MBBS, DCO, MPHO </p>
                                <p class="rating"><i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i></p>
                                <p class="doctor_experience"><span>Experience:</span> 5 years</p>
                                <p class="doctor_fees"><span>Doctor Fees:</span> 100 BDT</p>
                                <button class="btn btn-theme2 font-size-14 btn-block">Book Appointment</button>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6 col-xl-3">
                        <div class="doctor_card">
                            <div class="doctor_image">
                                <img class="w-100" src="{{asset('coverpage/img/doc4.jpg')}}" alt="">
                            </div>

                            <div class="doctor_info">
                                <h5 class="doctor_name">Dr. Royal Matthew </h5>
                                <p class="doctor_degree"><i class="fas fa-graduation-cap"></i>&nbsp;&nbsp;MBBS, DCO, MPHO </p>
                                <p class="rating"><i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i></p>
                                <p class="doctor_experience"><span>Experience:</span> 5 years</p>
                                <p class="doctor_fees"><span>Doctor Fees:</span> 100 BDT</p>
                                <button class="btn btn-theme2 font-size-14 btn-block">Book Appointment</button>
                            </div>
                        </div>
                    </div>



                </div>
            </div>
        </div>
    </div>


    <div class="our_popular_doctors">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section_title_area text-center mb-5">
                        <h3 class="section_title2">Our Popular Doctors</h3>
                        <p class="sub_title">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam placerat rutrum turpis, sit amet hendrerit metus.</p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="popular_doctor">
                        <div class="form-row">
                            <div class="col-sm-12 col-md-12 col-xl-6">
                                <div class="popular_doctor_image">
                                    <img class="w-100" src="{{asset('coverpage/img/doc8.jpg')}}" alt="">
                                    <div class="doctor_country"><span>Singapore</span></div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-12 col-xl-6">
                                <div class="popular_doctor_infos">
                                    <h2 class="doctor_name">Dr. Royal Matthew</h2>
                                    <p class="doctor_speciality">Ophthalmology</p>
                                    <p class="rating"><i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i></p>
                                    <p class="doctor_degree"><i class="fas fa-graduation-cap"></i>&nbsp;&nbsp;MBBS, DCO, MPHO </p>
                                    <p class="doctor_experience"><span>Experience:</span> 5 years</p>
                                    <p class="doctor_fees"><span>Doctor Fees:</span> 100 BDT</p>

                                    <button class="btn btn-theme2 font-size-14 btn-block">Make Appionment</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="popular_doctor">
                        <div class="form-row">
                            <div class="col-sm-12 col-md-12 col-xl-6">
                                <div class="popular_doctor_image">
                                    <img class="w-100" src="{{asset('coverpage/img/doc7.jpg')}}" alt="">
                                    <div class="doctor_country"><span>Singapore</span></div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-12 col-xl-6">
                                <div class="popular_doctor_infos">
                                    <h2 class="doctor_name">Dr. Royal Matthew</h2>
                                    <p class="doctor_speciality">Ophthalmology</p>
                                    <p class="rating"><i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i></p>
                                    <p class="doctor_degree"><i class="fas fa-graduation-cap"></i>&nbsp;&nbsp;MBBS, DCO, MPHO </p>
                                    <p class="doctor_experience"><span>Experience:</span> 5 years</p>
                                    <p class="doctor_fees"><span>Doctor Fees:</span> 100 BDT</p>

                                    <button class="btn btn-theme2 font-size-14 btn-block">Make Appionment</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="popular_doctor">
                        <div class="form-row">
                            <div class="col-sm-12 col-md-12 col-xl-6">
                                <div class="popular_doctor_image">
                                    <img class="w-100" src="{{asset('coverpage/img/doc8.jpg')}}" alt="">
                                    <div class="doctor_country"><span>Singapore</span></div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-12 col-xl-6">
                                <div class="popular_doctor_infos">
                                    <h2 class="doctor_name">Dr. Royal Matthew</h2>
                                    <p class="doctor_speciality">Ophthalmology</p>
                                    <p class="rating"><i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i></p>
                                    <p class="doctor_degree"><i class="fas fa-graduation-cap"></i>&nbsp;&nbsp;MBBS, DCO, MPHO </p>
                                    <p class="doctor_experience"><span>Experience:</span> 5 years</p>
                                    <p class="doctor_fees"><span>Doctor Fees:</span> 100 BDT</p>

                                    <button class="btn btn-theme2 font-size-14 btn-block">Make Appionment</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="popular_doctor">
                        <div class="form-row">
                            <div class="col-sm-12 col-md-12 col-xl-6">
                                <div class="popular_doctor_image">
                                    <img class="w-100" src="{{asset('coverpage/img/doc7.jpg')}}" alt="">
                                    <div class="doctor_country"><span>Singapore</span></div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-12 col-xl-6">
                                <div class="popular_doctor_infos">
                                    <h2 class="doctor_name">Dr. Royal Matthew</h2>
                                    <p class="doctor_speciality">Ophthalmology</p>
                                    <p class="rating"><i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i></p>
                                    <p class="doctor_degree"><i class="fas fa-graduation-cap"></i>&nbsp;&nbsp;MBBS, DCO, MPHO </p>
                                    <p class="doctor_experience"><span>Experience:</span> 5 years</p>
                                    <p class="doctor_fees"><span>Doctor Fees:</span> 100 BDT</p>

                                    <button class="btn btn-theme2 font-size-14 btn-block">Make Appionment</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="popular_doctor">
                        <div class="form-row">
                            <div class="col-sm-12 col-md-12 col-xl-6">
                                <div class="popular_doctor_image">
                                    <img class="w-100" src="{{asset('coverpage/img/doc8.jpg')}}" alt="">
                                    <div class="doctor_country"><span>Singapore</span></div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-12 col-xl-6">
                                <div class="popular_doctor_infos">
                                    <h2 class="doctor_name">Dr. Royal Matthew</h2>
                                    <p class="doctor_speciality">Ophthalmology</p>
                                    <p class="rating"><i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i></p>
                                    <p class="doctor_degree"><i class="fas fa-graduation-cap"></i>&nbsp;&nbsp;MBBS, DCO, MPHO </p>
                                    <p class="doctor_experience"><span>Experience:</span> 5 years</p>
                                    <p class="doctor_fees"><span>Doctor Fees:</span> 100 BDT</p>

                                    <button class="btn btn-theme2 font-size-14 btn-block">Make Appionment</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="popular_doctor">
                        <div class="form-row">
                            <div class="col-sm-12 col-md-12 col-xl-6">
                                <div class="popular_doctor_image">
                                    <img class="w-100" src="{{asset('coverpage/img/doc7.jpg')}}" alt="">
                                    <div class="doctor_country"><span>Singapore</span></div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-12 col-xl-6">
                                <div class="popular_doctor_infos">
                                    <h2 class="doctor_name">Dr. Royal Matthew</h2>
                                    <p class="doctor_speciality">Ophthalmology</p>
                                    <p class="rating"><i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i></p>
                                    <p class="doctor_degree"><i class="fas fa-graduation-cap"></i>&nbsp;&nbsp;MBBS, DCO, MPHO </p>
                                    <p class="doctor_experience"><span>Experience:</span> 5 years</p>
                                    <p class="doctor_fees"><span>Doctor Fees:</span> 100 BDT</p>

                                    <button class="btn btn-theme2 font-size-14 btn-block">Make Appionment</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Download app start -->
    <div class="download_app">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="device_image">
                        <img class="w-100" src="{{asset('coverpage/img/mobile_device.png')}}" alt="">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="device_text">
                        <h3>Download MCARE mobile app</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam placerat rutrum turpis, sit amet hendrerit metus vulputate id. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam placerat rutrum turpis, sit amet hendrerit metus vulputate id.</p>
                    </div>

                    <div class="store_logo">
                        <img src="img/app_store.png" alt="">
                        <img src="img/play_store.png" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Download app end -->

    <!-- contact section area start -->
    <div class="contact_area">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-7 text-center">
                    <div class="contactimg_section">
                        <img src="{{asset('coverpage/img/contact.png')}}" />
                        <div class="card shadow p-3 contact-box">
                            <h4 class="py-3">
                                We are here for you!
                            </h4>
                            <p class="">
                                <i class="fas fa-quote-left comment_icon"></i>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam placerat rutrum turpis, sit amet hendrerit metus vulputate id. <i class="fas fa-quote-right comment_icon"></i>
                            </p>
                        </div>

                    </div>
                </div>

                <div class="col-md-5 text-center">
                    <div class="contact_section">
                        <h3 class="contact_title">Feel Free to Contact us</h3>
                    </div>
                    <div class="form">
                        <div class=" form-group">
                            <input  type="text" placeholder="Your Name*" class="form-control" />
                        </div>
                        <div class=" form-group">
                            <input type="email" placeholder="Your Email*" class="form-control" />
                        </div>
                        <div class=" form-group">

                            <textarea  placeholder="Your Email*" class="form-control text_area" ></textarea>
                            <button class="btn btn-theme mt-3">Send</button>
                        </div>
                    </div>
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
                                <p>(866) 710-9709</p>
                            </div>
                            <div class="col-md-2 text-center">
                                <span class="emergency_contact_or">or</span>
                            </div>
                            <div class="col-md-5">
                                <h4>24/7  Email Support</h4>
                                <p>mediplus@gmail.com</p>
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
                            <img src="{{asset('coverpage/img/mcare_logo.png')}}"/>
                            <p class="pt-3 text-light">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam placerat rutrum turpis, sit amet hendrerit metus vulputate id.</p>
                        </div>

                        <div class="col-md-3 footer-links">
                            <h5 class="footer_title">Specialist</h5>
                            <ul>
                                <li> <a href="#">Dental</a></li>
                                <li>  <a href="#">Pediatric</a></li>
                                <li> <a href="#">Neurology Management</a></li>
                                <li>  <a href="#">Orthopaedics</a></li>
                                <li>  <a href="#">Cardiology</a></li>
                            </ul>
                        </div>

                        <div class="col-md-3 footer-links ">
                            <h5 class="footer_title">Links</h5>
                            <ul>
                                <li> <a href="#">Home</a></li>
                                <li>  <a href="#">About Us</a></li>
                                <li> <a href="#">Department</a></li>
                                <li>  <a href="#">Doctors</a></li>

                            </ul>
                        </div>

                        <div class="col-md-3 footer-links ">
                            <h5 class="footer_title">Contact</h5>
                            <div class="py-2">
                                <span> <i class="fas fa-map-marker-alt pr-1 "> </i>  level 1,  House450/A, Road 6A, Avenue 6, Dhaka 1216</span>
                            </div>
                            <div class="py-2">
                                <span> <i class="fas fa-phone-alt pr-1"></i>  (886) 710-9709</span>
                            </div>
                            <div class="py-2">
                                <span> 	 <i class="fas fa-envelope pr-1"></i> mediplus@gmail.com</span>
                            </div>
                            <div class=" d-flex py-2">
                                <a  >   <i class="fa fa-facebook px-2"   > </i></a>

                                <a> <i class="fa fa-linkedin px-2" aria-hidden="true"></i></a>
                                <a> <i class="fa fa-twitter px-2" aria-hidden="true"></i> </a>
                                <a> <i class="fa fa-instagram px-2" aria-hidden="true"></i> </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="copyright text-center">
                <span>Copyright <i class="far fa-copyright"></i> 2021 by Mcare. All Rights Reserved </span>
            </div>
        </footer>
    </div>
    <!-- footer  area end -->

@endsection
