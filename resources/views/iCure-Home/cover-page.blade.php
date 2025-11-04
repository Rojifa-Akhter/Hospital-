<!DOCTYPE html>
<html lang="en">
<head>
    <title>H360 - Medical, Health Care and Doctor Clinic</title>
    <!-- Required meta tags -->
    @include('layouts.head')
</head>

<body data-spy="scroll" data-offset="70">
<!-- Start Preloader Area -->
<div class="preloader-area">
    <div class="spinner">
        <div class="rect1"></div>
        <div class="rect2"></div>
        <div class="rect3"></div>
        <div class="rect4"></div>
        <div class="rect5"></div>
    </div>
</div>
<!-- End Preloader Area -->

<!-- Start Navbar Area -->
@include('layouts.top_menu')
<!-- End Navbar Area -->

<!-- Start Main Banner Area -->
<div id="home" class="main-banner">
    <div class="d-table">
        <div class="d-table-cell">
            <div class="container">
                <div class="row">
                    <div class="col-lg-7 col-md-12">
                        <div class="hero-slides">
                            <div class="hero-content">
                                <h1>Providing Quality Health Care. Your Health is Our Top Priority with <span>Comprehensive</span></h1>
                                <p>
                                    From emergency department care to remote patient monitoring for chronic care management and access to care from specialists, telehealth is changing the way health care is provided both expanding patient access to routine and specialty care while improving patient satisfaction and outcomes. Recent years have seen significant growth in the use of telehealth, to the point where more than .
                                </p>
                                <a href="{{route('appointment-book')}}" class="btn btn-success">Book Your Appointment</a>
                            </div>

                            <div class="hero-content">
                                <h1>Providing Quality Health Care. Your Health is Our Top Priority with <span>Comprehensive</span></h1>
                                <p>
                                    From emergency department care to remote patient monitoring for chronic care management and access to care from specialists, telehealth is changing the way health care is provided both expanding patient access to routine and specialty care while improving patient satisfaction and outcomes. Recent years have seen significant growth in the use of telehealth, to the point where more than .
                                </p>
                                <a href="{{route('appointment-book')}}" class="btn btn-success">Book Your Appointment</a>
                            </div>

                            <div class="hero-content">
                                <h1>Providing Quality Health Care. Your Health is Our Top Priority with <span>Comprehensive</span></h1>
                                <p>
                                    From emergency department care to remote patient monitoring for chronic care management and access to care from specialists, telehealth is changing the way health care is provided both expanding patient access to routine and specialty care while improving patient satisfaction and outcomes. Recent years have seen significant growth in the use of telehealth, to the point where more than .
                                </p>
                                <a href="{{route('appointment-book')}}" class="btn btn-success">Book Your Appointment</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Main Banner Area -->

<!-- Start Boxes Area -->
<section class="boxes-area ptb-100">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6">
                <div class="single-box">
                    <i class="icofont-doctor"></i>
                    <h3>Qualified Doctors</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="single-box">
                    <i class="icofont-ambulance-cross"></i>
                    <h3>Emergency Care</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="single-box">
                    <i class="icofont-operation-theater"></i>
                    <h3>Operation Theater</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="single-box">
                    <i class="icofont-stretcher"></i>
                    <h3>24 Hours Service</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Boxes Area -->

<!-- Start Departments Area -->
<section id="department" class="departments-area ptb-100 bg-f9faff">
    <div class="container">
        <div class="section-title">
            <h3>Our Departments</h3>
            <span>Which Services We Provide</span>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
        </div>

        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="tab">
                    <ul class="tabs">
                        <li>
                            <a href="#">
                                <i class="icofont-heart-beat"></i>
                                <br />
                                Cardiology
                            </a>
                        </li>

                        <li>
                            <a href="#">
                                <i class="icofont-brain"></i>
                                <br />
                                Neurology
                            </a>
                        </li>

                        <li>
                            <a href="#">
                                <i class="icofont-crutch"></i>
                                <br />
                                Orthopedics
                            </a>
                        </li>

                        <li>
                            <a href="#">
                                <i class="icofont-xray"></i>
                                <br />
                                Radiology
                            </a>
                        </li>

                        <li>
                            <a href="#">
                                <i class="icofont-surgeon"></i>
                                <br />
                                Surgery
                            </a>
                        </li>

                        <li>
                            <a href="#">
                                <i class="icofont-laboratory"></i>
                                <br />
                                Urology
                            </a>
                        </li>
                    </ul>

                    <div class="tab_content">
                        <div class="tabs_item">
                            <div class="row">
                                <div class="col-lg-6 col-md-12">
                                    <div class="tabs_item_img">
                                        <img src="{{ asset('site-assets/img/department-img1.jpg') }}" alt="department" />
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-12">
                                    <div class="tabs_item_content">
                                        <h3>Welcome to Cardiology Department</h3>
                                        <p>This department provides medical care to patients who have problems with their heart or circulation. It treats people on an inpatient and outpatient basis.</p>
                                        <ul>
                                            <li>Electrocardiogram (ECG)</li>
                                            <li>Echocardiograms (ultrasound scan of the heart)</li>
                                            <li>24-hour blood pressure tests</li>
                                            <li>Electrocardiogram (ECG)</li>
                                        </ul>
                                        <a href="#" class="btn">Subscribe Now</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tabs_item">
                            <div class="row">
                                <div class="col-lg-6 col-md-12">
                                    <div class="tabs_item_img">
                                        <img src="{{ asset('site-assets/img/department-img1.jpg') }}" alt="department" />
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-12">
                                    <div class="tabs_item_content">
                                        <h3>Welcome to Neurology Department</h3>
                                        <p>This department provides medical care to patients who have problems with their heart or circulation. It treats people on an inpatient and outpatient basis.</p>
                                        <ul>
                                            <li>Electrocardiogram (ECG)</li>
                                            <li>Echocardiograms (ultrasound scan of the heart)</li>
                                            <li>24-hour blood pressure tests</li>
                                            <li>Electrocardiogram (ECG)</li>
                                        </ul>
                                        <a href="#" class="btn">Subscribe Now</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tabs_item">
                            <div class="row">
                                <div class="col-lg-6 col-md-12">
                                    <div class="tabs_item_img">
                                        <img src="{{ asset('site-assets/img/department-img1.jpg') }}" alt="department" />
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-12">
                                    <div class="tabs_item_content">
                                        <h3>Welcome to Orthopedics Department</h3>
                                        <p>This department provides medical care to patients who have problems with their heart or circulation. It treats people on an inpatient and outpatient basis.</p>
                                        <ul>
                                            <li>Electrocardiogram (ECG)</li>
                                            <li>Echocardiograms (ultrasound scan of the heart)</li>
                                            <li>24-hour blood pressure tests</li>
                                            <li>Electrocardiogram (ECG)</li>
                                        </ul>
                                        <a href="#" class="btn">Subscribe Now</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tabs_item">
                            <div class="row">
                                <div class="col-lg-6 col-md-12">
                                    <div class="tabs_item_img">
                                        <img src="{{ asset('site-assets/img/department-img1.jpg') }}" alt="department" />
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-12">
                                    <div class="tabs_item_content">
                                        <h3>Welcome to Radiology Department</h3>
                                        <p>This department provides medical care to patients who have problems with their heart or circulation. It treats people on an inpatient and outpatient basis.</p>
                                        <ul>
                                            <li>Electrocardiogram (ECG)</li>
                                            <li>Echocardiograms (ultrasound scan of the heart)</li>
                                            <li>24-hour blood pressure tests</li>
                                            <li>Electrocardiogram (ECG)</li>
                                        </ul>
                                        <a href="#" class="btn">Subscribe Now</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tabs_item">
                            <div class="row">
                                <div class="col-lg-6 col-md-12">
                                    <div class="tabs_item_img">
                                        <img src="{{ asset('site-assets/img/department-img1.jpg') }}" alt="department" />
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-12">
                                    <div class="tabs_item_content">
                                        <h3>Welcome to Surgery Department</h3>
                                        <p>This department provides medical care to patients who have problems with their heart or circulation. It treats people on an inpatient and outpatient basis.</p>
                                        <ul>
                                            <li>Electrocardiogram (ECG)</li>
                                            <li>Echocardiograms (ultrasound scan of the heart)</li>
                                            <li>24-hour blood pressure tests</li>
                                            <li>Electrocardiogram (ECG)</li>
                                        </ul>
                                        <a href="#" class="btn">Subscribe Now</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tabs_item">
                            <div class="row">
                                <div class="col-lg-6 col-md-12">
                                    <div class="tabs_item_img">
                                        <img src="{{ asset('site-assets/img/department-img1.jpg') }}" alt="department" />
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-12">
                                    <div class="tabs_item_content">
                                        <h3>Welcome to Urology Department</h3>
                                        <p>This department provides medical care to patients who have problems with their heart or circulation. It treats people on an inpatient and outpatient basis.</p>
                                        <ul>
                                            <li>Electrocardiogram (ECG)</li>
                                            <li>Echocardiograms (ultrasound scan of the heart)</li>
                                            <li>24-hour blood pressure tests</li>
                                            <li>Electrocardiogram (ECG)</li>
                                        </ul>
                                        <a href="#" class="btn">Subscribe Now</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Departments Area -->

<!-- Start Why Choose Us Area -->
<section id="about" class="why-choose-us ptb-100 bg-f9faff">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-12">
                <div class="row about-image">
                    <div class="col-6 col-lg-6 col-md-6">
                        <div class="image">
                            <img src="{{ asset('site-assets/img/about-img1.jpg') }}" alt="about" />
                        </div>
                    </div>

                    <div class="col-6 col-lg-6 col-md-6">
                        <div class="image">
                            <img src="{{ asset('site-assets/img/about-img2.jpg') }}" alt="about" />
                        </div>
                    </div>

                    <div class="col-6 col-lg-6 col-md-6">
                        <div class="image mt-30">
                            <img src="{{ asset('site-assets/img/about-img3.jpg') }}" alt="about" />
                        </div>
                    </div>

                    <div class="col-6 col-lg-6 col-md-6">
                        <div class="image mt-30">
                            <img src="{{ asset('site-assets/img/about-img4.jpg') }}" alt="about" />
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-md-12">
                <div class="section-title">
                    <h3>Why Choose Us</h3>
                    <span>Read About Us</span>
                </div>

                <div class="why-choose-us-text">
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum ultrices gravida. Risus commodo viverra maecenas accumsan facilisis.</p>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>

                    <ul>
                        <li>We provide high-quality services for the whole family.</li>
                        <li>Risus commodo viverra maecenas</li>
                        <li>Your health is our top priority</li>
                        <li>Affordable medical, dental and women's health care.</li>
                        <li>Quis ipsum suspendisse ultrices gravida.</li>
                        <li>We provide high-quality services for the whole family.</li>
                    </ul>

                    <a href="#" class="btn">Our Work</a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Why Choose Us Area -->

<!-- Start Who We Are Area -->
<section class="who-we-are ptb-100">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-12">
                <div class="section-title">
                    <h3>Who We Are</h3>
                    <span>Meet the Entire Doctor</span>
                </div>

                <div class="who-we-are-text">
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida. Risus commodo viverra maecenas accumsan
                        facilisis.
                    </p>
                    <a href="#" class="btn btn-success">Book Your Appointment</a>
                </div>
            </div>

            <div class="col-lg-8 col-md-12">
                <ul class="team-members">
                    <li class="clearfix">
                        <div class="member-details">
                            <div>
                                <img src="{{ asset('site-assets/img/doctor-img1.png') }}" alt="doctor" />
                                <div class="member-info">
                                    <h3>DR. John Doe</h3>
                                    <p>Dental Specialist</p>
                                    <ul>
                                        <li><a href="#" class="icofont-facebook"></a></li>
                                        <li><a href="#" class="icofont-twitter"></a></li>
                                        <li><a href="#" class="icofont-linkedin"></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="member-details">
                            <div>
                                <img src="{{ asset('site-assets/img/doctor-img2.png') }}" alt="doctor" />
                                <div class="member-info">
                                    <h3>DR. John Doe</h3>
                                    <p>Dental Specialist</p>
                                    <ul>
                                        <li><a href="#" class="icofont-facebook"></a></li>
                                        <li><a href="#" class="icofont-twitter"></a></li>
                                        <li><a href="#" class="icofont-linkedin"></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="member-details">
                            <div>
                                <img src="{{ asset('site-assets/img/doctor-img3.png') }}" alt="doctor" />
                                <div class="member-info">
                                    <h3>DR. John Doe</h3>
                                    <p>Dental Specialist</p>
                                    <ul>
                                        <li><a href="#" class="icofont-facebook"></a></li>
                                        <li><a href="#" class="icofont-twitter"></a></li>
                                        <li><a href="#" class="icofont-linkedin"></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </li>

                    <li class="clearfix">
                        <div class="member-details">
                            <div>
                                <img src="{{ asset('site-assets/img/doctor-img4.png') }}" alt="doctor" />
                                <div class="member-info">
                                    <h3>DR. John Doe</h3>
                                    <p>Dental Specialist</p>
                                    <ul>
                                        <li><a href="#" class="icofont-facebook"></a></li>
                                        <li><a href="#" class="icofont-twitter"></a></li>
                                        <li><a href="#" class="icofont-linkedin"></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="member-details">
                            <div>
                                <img src="{{ asset('site-assets/img/doctor-img2.png') }}" alt="doctor" />
                                <div class="member-info">
                                    <h3>DR. John Doe</h3>
                                    <p>Dental Specialist</p>
                                    <ul>
                                        <li><a href="#" class="icofont-facebook"></a></li>
                                        <li><a href="#" class="icofont-twitter"></a></li>
                                        <li><a href="#" class="icofont-linkedin"></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="member-details">
                            <div>
                                <img src="{{ asset('site-assets/img/doctor-img1.png') }}" alt="doctor" />
                                <div class="member-info">
                                    <h3>DR. John Doe</h3>
                                    <p>Dental Specialist</p>
                                    <ul>
                                        <li><a href="#" class="icofont-facebook"></a></li>
                                        <li><a href="#" class="icofont-twitter"></a></li>
                                        <li><a href="#" class="icofont-linkedin"></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </li>

                    <li class="clearfix">
                        <div class="member-details">
                            <div>
                                <img src="{{ asset('site-assets/img/doctor-img1.png') }}" alt="doctor" />
                                <div class="member-info">
                                    <h3>DR. John Doe</h3>
                                    <p>Dental Specialist</p>
                                    <ul>
                                        <li><a href="#" class="icofont-facebook"></a></li>
                                        <li><a href="#" class="icofont-twitter"></a></li>
                                        <li><a href="#" class="icofont-linkedin"></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="member-details">
                            <div>
                                <img src="{{ asset('site-assets/img/doctor-img4.png') }}" alt="doctor" />
                                <div class="member-info">
                                    <h3>DR. John Doe</h3>
                                    <p>Dental Specialist</p>
                                    <ul>
                                        <li><a href="#" class="icofont-facebook"></a></li>
                                        <li><a href="#" class="icofont-twitter"></a></li>
                                        <li><a href="#" class="icofont-linkedin"></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="member-details">
                            <div>
                                <img src="{{ asset('site-assets/img/doctor-img2.png') }}" alt="doctor" />
                                <div class="member-info">
                                    <h3>DR. John Doe</h3>
                                    <p>Dental Specialist</p>
                                    <ul>
                                        <li><a href="#" class="icofont-facebook"></a></li>
                                        <li><a href="#" class="icofont-twitter"></a></li>
                                        <li><a href="#" class="icofont-linkedin"></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>
<!-- End Who We Are Area -->

<!-- Start Fun Facts Area -->
<section class="fun-facts-area ptb-100">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6">
                <div class="fun-fact">
                    <i class="icofont-wink-smile"></i>
                    <h3 class="count">25000</h3>
                    <span>Happy Patients</span>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="fun-fact">
                    <i class="icofont-doctor-alt"></i>
                    <h3 class="count">180</h3>
                    <span>Experienced Doctors</span>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="fun-fact">
                    <i class="icofont-patient-bed"></i>
                    <h3 class="count">1200</h3>
                    <span>Number of Hospitals</span>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="fun-fact">
                    <i class="icofont-bed"></i>
                    <h3 class="count">2800</h3>
                    <span>Number of Beds</span>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Fun Facts Area -->




<!-- Start Contact Area -->
<section id="contact" class="contact-area ptb-100">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6">
                <div class="contact-box">
                    <h3><i class="icofont-google-map"></i> Address</h3>
                    <p>
                        <a href="https://www.google.com/maps/place/Exercisplan+4,+111+49+Stockholm,+Sweden/data=!4m2!3m1!1s0x465f9d5641a77669:0xe02744b36aab9f53?ved=2ahUKEwi38ZaU0rXfAhVWeH0KHY5CBWYQ8gEwAHoECAAQAQ" target="_blank">
                            H# 17 (1st Floor), Road- 17/A, Block- E, Banani, Dhaka- 1213
                        </a>
                    </p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="contact-box">
                    <h3><i class="icofont-envelope"></i> Email</h3>
                    <p><a href="#">info@iCure.com</a></p>
                    <p><a href="#">support@iCure.com</a></p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="contact-box">
                    <h3><i class="icofont-phone"></i> Phone</h3>
                    <p><a href="#">+44 4587 458</a></p>
                    <p><a href="#">+44 4587 459</a></p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="contact-box">
                    <h3><i class="icofont-clock-time"></i> Opening Hours</h3>
                    <ul>
                        <li>Monday - Friday <span>6AM - 9PM</span></li>
                        <li>Sunday <span>6AM - 5PM</span></li>
                    </ul>
                </div>
            </div>

            <div class="col-lg-4 col-md-12">
                <div class="get-in-touch">
                    <h3>Get in Touch</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Risus commodo viverra maecenas accumsan lacus vel facilisis.</p>
                    <ul>
                        <li>
                            <a href="#"><i class="icofont-facebook"></i></a>
                        </li>
                        <li>
                            <a href="#"><i class="icofont-twitter"></i></a>
                        </li>
                        <li>
                            <a href="#"><i class="icofont-linkedin"></i></a>
                        </li>
                        <li>
                            <a href="#"><i class="icofont-instagram"></i></a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="col-lg-8 col-md-12">
                <form id="contactForm">
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group">
                                <input type="text" class="form-control" name="name" id="name" required data-error="Please enter your name" placeholder="Name" />
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6">
                            <div class="form-group">
                                <input type="email" class="form-control" name="email" id="email" required data-error="Please enter your email" placeholder="Email" />
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>

                        <div class="col-lg-12 col-md-12">
                            <div class="form-group">
                                <textarea name="message" class="form-control" id="message" cols="30" rows="4" required data-error="Write your message" placeholder="Message"></textarea>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>

                        <div class="col-lg-12 col-md-12">
                            <button type="submit" class="btn">Send Message</button>
                            <div id="msgSubmit" class="h3 text-center hidden"></div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<!-- End Contact Area -->




@include('layouts.footer')
</body>
</html>
