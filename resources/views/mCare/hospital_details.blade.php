@extends("mCare.layouts.master")
@section('content')
    <!-- Modal end -->

    <!-- Modal end -->
    <div class="hospital_section">
        <div class="container">
            <div class="row">


                {{-- @include('mCare.sidebar') --}}


                <!-- Sidebar -->
                <div class="col-lg-4 col-md-12">
                    <div class="sidebar_filter">
                        <!-- by country -->
                        <div class="country">
                            <h3>By Country</h3>
                            @if (!empty($country))
                                @foreach ($country as $key => $value)
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <input type="checkbox" aria-label="Checkbox for following text input"
                                                    class="hospital_country" value="{{ $value->nationality }}" />
                                            </div>
                                        </div>
                                        <input type="text" class="form-control" aria-label="Text input with checkbox"
                                            value="{{ $value->nationality }} ({{ $value->hospital }})" readonly=""
                                            id="country" />
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <!-- by country -->

                        <!-- by city -->
                        <div class="city">
                            <h3>By City</h3>
                            <div class="input-group mb-2">
                                <input type="text" class="form-control city_search_id" placeholder="Search By City.." />
                            </div>

                            <div class="inner_city_search_data">
                                {{-- @include('mCare.city_doctor_list') --}}
                                @include('mCare.city_hospital_list')

                            </div>
                        </div>
                        <!-- by city -->

                        <!-- By Department -->
                        <div class="Department">
                            <h3>By Department</h3>
                            <div class="input-group mb-2">
                                <input type="text" class="form-control dept_search_id"
                                    placeholder="Search By Department.." />
                            </div>

                            <div class="inner_dept_data">

                                {{-- @include('mCare.dept_doctor_list') --}}
                                @include('mCare.department_hospital_list')

                            </div>
                        </div>
                        <!-- By Department -->

                        <!-- by hospital -->
                        <div class="hospital">
                            <h3>By Hospital</h3>
                            <div class="input-group mb-2">
                                <input type="text" class="form-control hospital_search_id"
                                    placeholder="Search By Hospital.." />
                            </div>

                            <div class="inner_hospital_data">

                                @include('mCare.hospital_doctor_list')
                            </div>
                        </div>
                        <!-- by hospital -->
                    </div>
                </div>
                <!-- Sidebar end-->





                <!-- hospital page right strat -->
                <div class="col-lg-8 col-md-8 col-sm-12">
                    <div class="container">
                        <!-- hospital name -->
                        <div class="hospital_name">
                            <div class="row">
                                <div class="col-lg-8 col-md-12 col-sm-12">
                                    <div class="inner_hospital_name">
                                        <h2>{{ isset($hospital_data->chamber_hospital_name) ? ucfirst($hospital_data->chamber_hospital_name) : 'N/A' }}
                                        </h2>
                                        <p>{{ isset($hospital_data->chamber_hospital_location) ? ucfirst($hospital_data->chamber_hospital_location) : 'N/A' }}
                                        </p>
                                    </div>
                                </div>
                                {{-- <div class="col-lg-4 col-md-12 col-sm-12">
                                    <div class="enquiry text-right">
                                        <a href="#" class="btn">Book Apointment</a>
                                    </div>
                                </div> --}}
                            </div>
                        </div>
                        <!-- doctors name -->
                        <!-- hospital image -->
                        <div class="hospital_image  hospital_gallery">
                            <div class="row hospital_portfolio">
                                <div class="col-md-12 col-sm-12">
                                    <div class="inner_hospital_image">
                                        @if ($hospital_data->image_url != '')
                                            <img class="shadow-lg p-3 bg-white rounded w-80"
                                                src="{{ asset('images/uploads/hospital_images/' . $hospital_data->image_url) }}">
                                        @else
                                            <img class="shadow-lg p-3 bg-white rounded w-80"
                                                src="{{ asset('images/hospital.png') }}" alt="">
                                        @endif

                                        {{-- <img src="{{ asset('coverpage/img/Apollo Hospital Delhi Lobby.jpg') }}"
                                            alt="..." /> --}}
                                    </div>
                                </div>
                                {{-- <div class="col-md-12 col-sm-12">
                                    <div class="inner_hospital_image">
                                        <img src="{{ asset('coverpage/img/Apollo Hospital Delhi Super Deluxe Rooms.jpg') }}"
                                            alt="..." />
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12">
                                    <div class="inner_hospital_image">
                                        <img src="{{ asset('coverpage/img/Apollo Hospital Delhi.jpg') }}" alt="..." />
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12">
                                    <div class="inner_hospital_image">
                                        <img src="{{ asset('coverpage/img/Apollo Wellness Center.jpg') }}" alt="..." />
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12">
                                    <div class="inner_hospital_image">
                                        <img src="{{ asset('coverpage/img/apollo-delhi-infrastructure.jpg') }}"
                                            alt="..." />
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12">
                                    <div class="inner_hospital_image">
                                        <img src="{{ asset('coverpage/img/apollo-technology-delhi.jpg') }}" alt="..." />
                                    </div>
                                </div> --}}
                            </div>
                        </div>
                        <!-- hospital image -->
                        <!-- hospital detail -->
                        <div class="hospital_detail">
                            <div class="row align-items-center">
                                <div class="col-lg-6 col-md-8 col-sm-12">
                                    <div class="joint-list">
                                        <ul>
                                            <li>Established in : <span>
                                                    {{ isset($hospital_data->establishe_year) ? $hospital_data->establishe_year : 'N/A' }}</span>
                                            </li>
                                            <li>Number of beds : <span>
                                                    {{ isset($hospital_data->number_of_bed) ? $hospital_data->number_of_bed : 'N/A' }}</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-4 col-sm-12">
                                    <div class="award-listing text-right">
                                        <ul>
                                            <li>
                                                <img src="{{ asset('coverpage/img/accreditations_83.jpg') }}" alt="" />
                                            </li>
                                            <li>
                                                <img src="{{ asset('coverpage/img/accreditations_85.png') }}" alt="" />
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- hospital detail -->
                        <!-- search doctor -->
                        {{-- <div class="search_doctor">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="inner_search_doctor">
                                        <ul class="list-unstyled list mt-2">
                                            <li class="d-flex align-items-center">
                                                <i class="fas fa-user-md mr-2"></i>
                                                <h3>SEARCH DOCTOR</h3>
                                            </li>
                                            <form>
                                                <div class="form-group">
                                                    <input type="text" class="form-control" id="exampleInputEmail1"
                                                        aria-describedby="emailHelp"
                                                        placeholder="By Department, speciality or doctor name" />
                                                </div>
                                            </form>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                        <!-- search doctor -->
                        <!-- about hospital -->
                        <div class="about_hospital">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="inner_about_hospital">
                                        <ul class="list-unstyled list mt-2">
                                            <li class="d-flex align-items-center">
                                                <i class="far fa-hospital mr-2"></i>
                                                <h3>ABOUT HOSPITAL</h3>
                                            </li>
                                            <li class="marr">
                                                <p>Established in
                                                    {{ isset($hospital_data->establishe_year) ? $hospital_data->establishe_year : 'N/A' }},
                                                    {{ isset($hospital_data->chamber_hospital_name) ? $hospital_data->chamber_hospital_name : 'N/A' }}
                                                    is NABL and JCI
                                                    accredited.</p>

                                            <li class="marr">
                                                <p>
                                                    {{ $hospital_data->chamber_hospital_description }}
                                                </p>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- about hospital -->
                        <!-- team and specialities -->
                        {{-- <div class="team_specialities">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="inner_team_specialities">
                                        <ul class="list-unstyled list mt-2">
                                            <li class="d-flex align-items-center">
                                                <i class="fas fa-stethoscope mr-2"></i>
                                                <h3>TEAM AND SPECIALITIES</h3>
                                            </li>
                                            <li class="marr">
                                                <p>Experienced and renowned doctors in Cardiac Sciences (Cardiology &
                                                    Cardio-thoracic Surgery) and Neurological Sciences (Neurology &
                                                    Neuro-surgery).</p>
                                            </li>
                                            <li class="marr">
                                                <p>Cardiology team achieved a 99.6% success rate in cardiac bypass
                                                    surgeries amongst which 91% were beating heart</p>
                                            </li>
                                            <a href="#" class="btn-link">...Read More</a>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                        <!-- team and specialities -->
                        <!-- top doctors -->
                        <div class="top_doctors">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="similar_doctor_ttile">
                                        <ul class="list-unstyled list mt-2">
                                            <li class="d-flex align-items-center">
                                                <i class="fas fa-user-md mr-2"></i>
                                                <h3>TOP DOCTORS, NEW DELHI</h3>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <!-- slider -->
                            <div class="row g-2 top_doctor_slide">
                                @if (!$hospital_details->isEmpty())
                                    @foreach ($hospital_details as $row)
                                        <div class="col-sm-12">
                                            <div class="card text-center">
                                                <a href="#">
                                                    <div class="user-image">
                                                        @if ($row->photo_name != '')
                                                            <img class="shadow-lg p-3 bg-white rounded "
                                                                src="{{ asset('images/uploads/doctor_images/thumb/' . $row->photo_name) }}">
                                                        @else
                                                            @if ($row->gender_txt == 'Male')
                                                                <img class="shadow-lg p-3 bg-white rounded "
                                                                    src="{{ asset('images/doctor.png') }}" alt="">
                                                            @else
                                                                <img class="shadow-lg p-3 bg-white rounded "
                                                                    src="{{ asset('images/nurse-2.png') }}" alt="">
                                                            @endif
                                                        @endif
                                                    </div>
                                                    <div class="user-content">
                                                        <h5>{{ !empty($row->full_name) ? ucfirst($row->full_name) : 'N/A' }}
                                                        </h5>
                                                        <span>{{ $row->specialization }} Specialist. ,
                                                            {{ !empty($row->experience) ? $row->experience : 'N/A' }}
                                                            years of experience</span>
                                                        <p>Check Profile</p>
                                                        <a href="{{ route('cover.sign-in-for-appointment', $row->person_no_pk) }}"
                                                            class="btn-link">Book Apointment</a>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <!-- slider -->
                            <a href="#" class="btn-danger">Show All Doctors</a>
                        </div>
                        <!-- top doctors -->
                        <!-- doctor by department -->
                        <div class="doctor_by_depart">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="similar_doctor_ttile">
                                        <ul class="list-unstyled list mt-2">
                                            <li class="d-flex align-items-center">
                                                <i class="fas fa-user-md mr-2"></i>
                                                <h3>DOCTORS BY DEPARTMENT</h3>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                @if (!empty($dept))
                                    @foreach ($dept as $key => $value)
                                        <div class="col-lg-3 col-md-6 col-sm-6">
                                            <a href="#"
                                                style="color: #28b270 !important;">{{ !empty($value->specialization) ? ucfirst($value->specialization) : 'N/A' }}({{ !empty($value->specialization_count) ? ucfirst($value->specialization_count) : 'N/A' }})</a>
                                        </div>
                                    @endforeach
                                @endif

                            </div>
                        </div>
                        <!-- doctor by department -->
                        <!-- apointment -->
                        {{-- <div class="apointment">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="inner_apointment text-center">
                                        <h3>Wondering where to start?</h3>
                                        <a href="#" class="btn">Book Apointment</a>
                                        <p>(Get Free opinion, Quote, Medical Visa Invitation and Assistance at every
                                            step of your treatment at Indraprastha Apollo Hospital, New Delhi.)</p>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                        <!-- apointment -->
                        <!-- INFRASTRUCTURE -->
                        {{-- <div class="infrastructure">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="inner_infrastructure">
                                        <ul class="list-unstyled list mt-2">
                                            <li class="d-flex align-items-center">
                                                <i class="far fa-building mr-2"></i>
                                                <h3>INFRASTRUCTURE</h3>
                                            </li>
                                            <li class="marr">
                                                <p>With an area spread over 15 acres, the hospital houses 710 beds.</p>
                                            </li>
                                            <li class="marr">
                                                <p>It has the largest Sleep Lab in Asia and is one of the largest
                                                    Dialysis Units in India.</p>
                                            </li>
                                            <li class="marr">
                                                <p>Maximum number of ICU Beds in a Private Hospital in India.</p>
                                            </li>
                                            <li class="marr">
                                                <p>6 bed dedicated to the Bone</p>
                                            </li>
                                            <a href="#" class="btn-link">...Read More</a>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                        <!-- INFRASTRUCTURE -->
                        <!-- location -->
                        <div class="hospital_location">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="inner_hospital_location">
                                        <ul class="list-unstyled list mt-2">
                                            <li class="d-flex align-items-center">
                                                <i class="fas fa-map-marker-alt mr-2"></i>
                                                <h3>LOCATION</h3>
                                            </li>
                                            <li class="marr">
                                                <strong>{{ isset($hospital_data->chamber_hospital_location) ? ucfirst($hospital_data->chamber_hospital_location) : 'N/A' }}:</strong>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- location -->
                        <!-- hospital adress -->
                        <div class="hospital_adress">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="inner_hospital_adress">
                                        <ul class="list-unstyled list mt-2">
                                            <li class="d-flex align-items-center">
                                                <i class="fas fa-map-marker-alt mr-2"></i>
                                                <h3>HOSPITAL ADDRESS</h3>
                                            </li>
                                            <li>
                                                <p>{{ isset($hospital_data->chamber_hospital_location) ? ucfirst($hospital_data->chamber_hospital_location) : 'N/A' }}
                                                </p>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- hospital adress -->
                        <!-- similar hospital -->
                        {{-- <div class="similar_hospital">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="inner_content text-center">
                                        <ul class="list-unstyled list mt-2">
                                            <li class="d-flex align-items-center">
                                                <i class="far fa-hospital mr-2"></i>
                                                <h3>SIMILAR HOSPITALS</h3>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                @if (!$hospital_details->isEmpty())
                                    @foreach ($hospital_details as $row)
                                        <div class="col-md-4">
                                            <div class="card text-center">
                                                <img class="imgbor"
                                                    src="{{ asset('coverpage/img/Fortis-Gurgaon-Lobby-3.jpg') }}" />
                                                <div class="user-content">
                                                    <h5>
                                                        <a href="#" class="btn-link">{{ isset($hospital_data->chamber_hospital_name) ? $hospital_data->chamber_hospital_name : 'N/A' }},
                                                            {{ isset($hospital_data->chamber_hospital_location) ? ucfirst($hospital_data->chamber_hospital_location) : 'N/A' }}</a>
                                                    </h5>
                                                    <ul>
                                                        <li>
                                                            <img src="{{ asset('coverpage/img/accreditations_83.jpg') }}"
                                                                alt="" />
                                                        </li>
                                                        <li>
                                                            <img src="{{ asset('coverpage/img/accreditations_84.png') }}"
                                                                alt="" />
                                                        </li>
                                                        <li>
                                                            <img src="{{ asset('coverpage/img/accreditations_85.png') }}"
                                                                alt="" />
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif

                            </div>
                        </div> --}}
                        <!-- similar hospital -->
                        <!-- container right side -->
                    </div>
                </div>
                <!-- hospital end -->
            </div>
        </div>
    </div>
    <!-- contact form -->

    <!-- rating -->
    {{-- <div class="hospital_rating text-center">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="inner_rating">
                        <h3>How do you rate the information on this page?</h3>
                        <ul>
                            <li>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </li>
                        </ul>
                        <p>Average 5 based on 1 ratings.</p>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    <!-- rating -->

    {{-- <div class="contact-section">
        <div class="container">
            <div class="contact_form">
                <div class="row">
                    <div class="col-md-12">
                        <div class="contact-title text-center">
                            <ul class="list-unstyled list mt-2">
                                <li class="d-flex align-items-center justify-content-center">
                                    <i class="far fa-calendar-check mr-2"></i>
                                    <h3>Need Help?</h3>
                                </li>
                                <h5>Just let us know. We will be happy to assist you</h5>
                                <p>To overcome restrictions due to Corona Virus, we are offering Paid Tele/Video
                                    Consultation from top doctors. Let us know if you are interested & we will contact
                                    you.</p>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <form>
                            <div class="form-group">
                                <label for="exampleInputName1">Your Name</label>
                                <input type="text" class="form-control" id="exampleInputName1" required />
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Your Email</label>
                                <input type="email" class="form-control" id="exampleInputEmail1"
                                    aria-describedby="emailHelp" required />
                            </div>
                            <div class="form-group">
                                <label for="inlineFormCustomSelectPref">Your Country</label>
                                <select class="custom-select my-1 mr-sm-2" id="inlineFormCustomSelectPref" required>
                                    <option value selected>Select Country</option>
                                    <option value="AU">Australia</option>
                                    <option value="BD">Bangladesh</option>
                                    <option value="CA">Canada</option>
                                    <option value="IN">India</option>
                                    <option value="GB">United Kingdom</option>
                                    <option value="US">United States</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPhone1">Your Phone</label>
                                <input type="number" class="form-control" id="exampleInputPhone1" required />
                            </div>
                            <div class="form-group">
                                <label for="">Describe Your Treatment Requirement</label>
                                <textarea class="form-control" aria-label="With textarea" rows="5" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputDate1">Doctor Appointment Date</label>
                                <input type="date" class="form-control" id="exampleInputDate1" />
                            </div>
                            <div class="form-group form-check">
                                <input type="checkbox" class="form-check-input" id="exampleCheck1" />
                                <label class="form-check-label" for="exampleCheck1">I am OK with Paid Tele/Video
                                    Consultation</label>
                            </div>
                            <button type="submit" class="submitbtn">Submit Your Enquiry</button>
                            <p>After submitting the form, check your email for instructions to share patient information
                                and medical reports.</p>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div> --}}
    <!-- contact form -->
    <!-- footer-section -->


@endsection


@push('customjs')
    <script>
        $(".hospital_portfolio").slick({
            infinite: true,
            slidesToShow: 2,
            slidesToScroll: 2,
            autoPlay: true,
            autoplaySpeed: 2000,
            dots: false,
            arrows: true,
            nextArrow: '<i class="fas fa-chevron-right"></i>',
            prevArrow: '<i class="fas fa-chevron-left"></i>',
            responsive: [{
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        infinite: true,
                        autoPlay: true,
                        autoplaySpeed: 2000,
                        dots: false,
                        arrows: true,
                    },
                },
                {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        dots: false,
                        arrows: false,
                    },
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        dots: false,
                        arrows: false,
                    },
                },
                // You can unslick at a given breakpoint now by adding:
                // settings: "unslick"
                // instead of a settings object
            ],
        });


        $(".top_doctor_slide").slick({
            infinite: true,
            slidesToShow: 4,
            slidesToScroll: 1,
            autoPlay: true,
            autoplaySpeed: 1000,
            dots: true,
            arrows: false,
            responsive: [{
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 1,
                        infinite: true,
                        autoPlay: true,
                        autoplaySpeed: 1000,
                        dots: true,
                        arrows: false,
                    },
                },
                {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        dots: false,
                        arrows: false,
                    },
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        dots: false,
                        arrows: false,
                    },
                },
                // You can unslick at a given breakpoint now by adding:
                // settings: "unslick"
                // instead of a settings object
            ],
        });



        // Add Script

        // Add Script


        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        $(document).on('keyup', '.city_search_id', function(e) {
            const city = $('.city_search_id').val();
            $.ajax({
                url: "{{ route('cover.hospital-search-data-by-city') }}",
                type: 'POST',
                data: {
                    city: city
                },
                beforeSend: function() {
                    // blockUI();
                },
                success: function(data) {
                    console.log(data)
                    $('.inner_city_search_data').html(data);
                },
                complete: function() {
                    // $.unblockUI();
                }
            });
        });


        $(document).on('keyup', '.dept_search_id', function(e) {
            const dept = $('.dept_search_id').val();
            // alert(city)
            $.ajax({
                url: "{{ route('cover.hospital-search-dept') }}",
                type: 'POST',
                data: {
                    dept: dept
                },
                beforeSend: function() {
                    // blockUI();
                },
                success: function(data) {
                    console.log(data)
                    $('.inner_dept_data').html(data);
                },
                complete: function() {
                    // $.unblockUI();
                }
            });
        });


        $(document).on('keyup', '.hospital_search_id', function(e) {
            const hospital = $('.hospital_search_id').val();
            // alert(city)
            $.ajax({
                url: "{{ route('cover.hospital-search-hospital') }}",
                type: 'POST',
                data: {
                    hospital: hospital,
                },
                beforeSend: function() {
                    // blockUI();
                },
                success: function(data) {
                    console.log(data)
                    $('.inner_hospital_data').html(data);
                },
                complete: function() {
                    // $.unblockUI();
                }
            });
        });

        $(".hospital_country").change(function() {
            if (this.checked) {
                //I am checked
                const country = $('.hospital_country').val();
                // alert(country)
                $.ajax({
                    url: "{{ route('cover.hospital-search-data-country-checkbox') }}",
                    type: 'POST',
                    data: {
                        country: country,
                    },
                    beforeSend: function() {
                        // blockUI();
                    },
                    success: function(data) {
                        console.log(data)
                        $('.hospital_gallery').html(data);
                    },
                    complete: function() {
                        // $.unblockUI();
                    }
                });



            } else {
                //I'm not checked
            }
        });

        $(".city_search").change(function() {
            if (this.checked) {
                //I am checked
                const city_id = $('.city_search').val();
                $.ajax({
                    url: "{{ route('cover.hospital-data-city-checkbox') }}",
                    type: 'POST',
                    data: {
                        city_id: city_id,
                    },
                    beforeSend: function() {
                        // blockUI();
                    },
                    success: function(data) {
                        console.log(data)
                        $('.hospital_gallery').html(data);
                    },
                    complete: function() {
                        // $.unblockUI();
                    }
                });



            } else {
                //I'm not checked
            }
        });

        $(document).on('change', '.dept_search', function() {
            if (this.checked) {
                //I am checked
                const dept = $('.dept_search').val();
                $.ajax({
                    url: "{{ route('cover.hospital-data-dept-checkbox') }}",
                    type: 'POST',
                    data: {
                        dept: dept,
                    },
                    beforeSend: function() {
                        // blockUI();
                    },
                    success: function(data) {
                        console.log(data)
                        $('.hospital_gallery').html(data);
                    },
                    complete: function() {
                        // $.unblockUI();
                    }
                });



            } else {
                //I'm not checked
            }
        })




        $(".hospital_search").change(function() {
            if (this.checked) {
                //I am checked
                const hospital = $('.hospital_search').val();
                $.ajax({
                    url: "{{ route('cover.hospital-data-hospital-checkbox') }}",
                    type: 'POST',
                    data: {
                        hospital: hospital,
                    },
                    beforeSend: function() {
                        // blockUI();
                    },
                    success: function(data) {
                        console.log(data)
                        $('.hospital_gallery').html(data);
                    },
                    complete: function() {
                        // $.unblockUI();
                    }
                });



            } else {
                //I'm not checked
            }
        });
    </script>

@endpush
