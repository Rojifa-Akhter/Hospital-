@extends("mCare.layouts.master")
@section('content')
    <?php
    $str = !empty($doctor_details->doctor_signature) ? $doctor_details->doctor_signature : '';
    $headers = explode(',', $str, 3);

    ?>
    <div class="hospital_section">
        <div class="container">
            <div class="row">

                @include('mCare.sidebar')

                <!-- doctor strat -->
                <div class="col-lg-8 col-md-6 col-sm-12" id="main">
                    <div class="container">
                        <!-- doctors name -->
                        <div class="doctor_name">
                            <div class="row">
                                <div class="col-lg-8 col-md-12 col-sm-12">
                                    <div class="inner_docotor_name">

                                        @if ($doctor_details->photo_name != '')
                                            <img class="rounded w-50"
                                                src="{{ asset('images/uploads/doctor_images/' . $doctor_details->photo_name) }}">
                                        @else
                                            @if (ucfirst($doctor_details->gender_txt) == 'Male')
                                                <img class="rounded w-50" src="{{ asset('images/doctor.png') }}">
                                            @elseif (ucfirst($doctor_details->gender_txt) == 'Female')
                                                <img class="rounded w-50" src="{{ asset('images/nurse-2.png') }}">
                                            @else
                                                <img class="rounded w-50" src="{{ asset('images/doc-1.png') }}">
                                            @endif
                                        @endif

                                        <h2>{{ isset($doctor_details->full_name) ? ucfirst($doctor_details->full_name) : '' }}
                                        </h2>
                                        <p>{{ isset($doctor_details->specialization) ? ucfirst($doctor_details->specialization) : '' }},
                                            {{-- , MD, MBBS, --}}
                                            {{ isset($doctor_details->experience) ? ucfirst($doctor_details->experience) : '' }}
                                            ,
                                            {{ isset($doctor_details->nationality) ? ucfirst($doctor_details->nationality) : '' }}
                                        </p>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-12 col-sm-12">
                                    <div class="enquiry text-right">
                                        <a href="{{ route('cover.sign-in-for-appointment', $doctor_details->person_no_pk) }}"
                                            class="btn btn-primary">Book
                                            Apointment</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- doctors name -->
                        <!-- about doctor -->
                        <div class="about_doctor">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="inner_about_doctor">
                                        <ul class="list-unstyled list mt-2">
                                            <li class="d-flex align-items-center">
                                                <i class="far fa-user-circle mr-2"></i>
                                                <h3>About Doctor</h3>
                                            </li>
                                            <li class="marr">

                                                <p>{!! isset($doctor_details->remarks_text) ? ucfirst($doctor_details->remarks_text) : '' !!}</p>
                                            </li>
                                            {{-- <a href="#" class="btn btn-link">...Read More</a>
                                            <a href="#" class="btn btn-link">...Read Less</a> --}}
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- about doctor -->
                        <!-- Hospital -->
                        <div class="hospital_name">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="inner_about_hospital">
                                        <ul class="list-unstyled list mt-2">
                                            <li class="d-flex align-items-center">
                                                <i class="far fa-hospital mr-2"></i>
                                                <h3>Hospital</h3>
                                            </li>
                                            <li>
                                                <a href="#"
                                                    class="btn btn-link">{{ isset($doctor_details->chamber_hospital_city_name) ? ucfirst($doctor_details->chamber_hospital_city_name) : '' }},
                                                    {{ isset($doctor_details->nationality) ? ucfirst($doctor_details->nationality) : '' }}</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Hospital -->
                        <!-- Specialization -->
                        <div class="specialization">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="inner_specialization">
                                        <ul class="list-unstyled list mt-2">
                                            <li class="d-flex align-items-center">
                                                <i class="fas fa-cog mr-2"></i>
                                                <h3>Specialization</h3>
                                            </li>

                                            <li class="marr">
                                                {{ isset($doctor_details->specialization) ? ucfirst($doctor_details->specialization) : '' }}
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Specialization -->
                        <!-- List Of Treatments -->
                        {{-- <div class="treatment">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="inner_treatments">
                                        <ul class="list-unstyled list mt-2">
                                            <li class="d-flex align-items-center">
                                                <i class="fas fa-stethoscope mr-2"></i>
                                                <h3>List Of Treatments</h3>
                                            </li>
                                            <li class="marr">List Of Treatments</li>
                                            <li class="marr">Adrenal Cancer Treatment</li>
                                            <li class="marr">Anal Cancer Treatment</li>
                                            <li class="marr">Bile Duct Cancer Treatment</li>
                                            <li class="marr">Bladder Cancer</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                        <!-- List Of Treatments -->
                        <!-- apointment -->
                        <div class="apointment">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="inner_apointment text-center">
                                        <h3>Wondering where to start?</h3>

                                        {{-- {{ dd(Auth::user()->user_no_pk) }} --}}
                                        <a href="{{ route('cover.sign-in-for-appointment', $doctor_details->person_no_pk) }}"
                                            class="btn btn-primary">Book
                                            Apointment</a>
                                        <p>(Get Free opinion, Quote, Medical Visa Invitation and Assistance at every step of
                                            your treatment.)</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- apointment -->
                        <!-- Work Experience doctor -->
                        {{-- <div class="work_experience">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="inner_work_experience">
                                        <ul class="list-unstyled list mt-2">
                                            <li class="d-flex align-items-center">
                                                <i class="far fa-id-card mr-2"></i>
                                                <h3>Work Experience of Prof.
                                                    {{ isset($doctor_details->full_name) ? ucfirst($doctor_details->full_name) : '' }}
                                                </h3>
                                            </li>
                                            <li>
                                                <h5>{{ isset($doctor_details->specialization) ? ucfirst($doctor_details->specialization) : '' }},
                                                    {{ isset($doctor_details->nationality) ? ucfirst($doctor_details->nationality) : '' }}
                                                </h5>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                        <!-- Work Experience doctor -->

                        <!-- Education -->
                        {{-- <div class="doctor_education">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="inner_education">
                                        <ul class="list-unstyled list mt-2">
                                            <li class="d-flex align-items-center">
                                                <i class="fas fa-graduation-cap mr-2"></i>
                                                <h3>Education</h3>
                                            </li>
                                            <li class="marr">{!! isset($headers[0]) ? ucfirst($headers[0]) : '' !!}</li>
                                            <li class="marr">{!! isset($headers[1]) ? ucfirst($headers[1]) : '' !!}</li>
                                            <li class="marr">{!! isset($headers[2]) ? ucfirst($headers[2]) : '' !!}</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                        <!-- Education-->
                        <!-- Awards -->
                        {{-- <div class="doctor_awards">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="inner_awards">
                                        <ul class="list-unstyled list mt-2">
                                            <li class="d-flex align-items-center">
                                                <i class="fas fa-award mr-2"></i>
                                                <h3>Awards</h3>
                                            </li>
                                            <li class="marr">{{ 'N/A' }}</li>

                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                        <!-- Awards-->
                        <!-- Location -->
                        {{-- <div class="doctor_location">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="inner_location">
                                        <ul class="list-unstyled list mt-2">
                                            <li class="d-flex align-items-center">
                                                <i class="fas fa-map-marker-alt mr-2"></i>
                                                <h3>Location</h3>
                                            </li>
                                            <li>
                                                <span>{{ !empty($doctor_details->chamber_hospital_location) ? $doctor_details->chamber_hospital_location : 'N/A' }}</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                        <!-- Location-->
                    </div>
                    <!-- doctor personal profile end -->
                    <!-- similar doctor  -->
                    {{-- <div class="similar_doctor_section">
                        <div class="conatiner">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="similar_doctor_ttile">
                                        <ul class="list-unstyled list mt-2">
                                            <li class="d-flex align-items-center">
                                                <i class="far fa-user-circle mr-2"></i>
                                                <h3>DOCTORS SIMILAR TO PROF. DR. SURESH H. ADVANI IN MUMBAI</h3>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="row row align-items-center justify-content-center">
                                <div class="col-lg-6 col-md-12 col-sm-12">
                                    <div class="inner_similiar_profile">
                                        <div class="d-flex flex-row mb-3">
                                            <span class="doctor-img">
                                                <img src="{{ asset('images/doctor.png') }}" alt="doctor" />
                                            </span>
                                            <div class="d-flex flex-column ml-2">
                                                <h2>
                                                    <a href="#" class="drbtn">Dr. Dattatreyudu Nori</a>
                                                </h2>
                                                <h3>Director Medical Oncologist</h3>
                                                <ul class="list-unstyled list mt-2">
                                                    <li>MD</li>
                                                    <li>Mumbai, India</li>
                                                    <li>43 years of experience</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12 col-sm-12">
                                    <div class="inner_similiar_profile">
                                        <div class="d-flex flex-row mb-3">
                                            <span class="doctor-img">
                                                <img src="{{ asset('images/doctor.png') }}" alt="doctor" />
                                            </span>
                                            <div class="d-flex flex-column ml-2">
                                                <h2>
                                                    <a href="#" class="drbtn">Dr. Anil K Dcruz</a>
                                                </h2>
                                                <h3>Head of Department Medical Oncologist</h3>
                                                <ul class="list-unstyled list mt-2">
                                                    <li>MBBS,MS,Diplomate</li>
                                                    <li>Mumbai, India</li>
                                                    <li>33 years of experience</li>
                                                    <a href="#" class="btn-link">Apollo Hospitals, Mumbai</a>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                    <!-- similar doctor  -->
                    <!-- interested section -->
                    {{-- <div class="interested_section">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="inner_intersted">
                                        <ul class="list-unstyled list mt-2">
                                            <li class="d-flex align-items-center">
                                                <i class="far fa-user-circle mr-2"></i>
                                                <h3>You may be interested in</h3>
                                            </li>
                                            <li class="marr">
                                                <a href="#" class="btn_link">Medical Oncologist in Jaslok Hospital,
                                                    Mumbai</a>
                                            </li>
                                            <li class="marr">
                                                <a href="#" class="btn_link">Oncology And Oncosurgery Doctor in
                                                    Jaslok Hospital, Mumbai</a>
                                            </li>
                                            <li class="marr">
                                                <a href="#" class="btn_link">Medical Oncologist in Mumbai</a>
                                            </li>
                                            <li class="marr">
                                                <a href="#" class="btn_link">Oncology And Oncosurgery Doctor in
                                                    Mumbai</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                    <!-- interested section -->
                    <!-- faq doctor -->
                    {{-- <div class="doctor_faq">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="inner_doctor_faq">
                                        <ul class="list-unstyled list mt-2">
                                            <li class="d-flex align-items-center">
                                                <i class="far fa-calendar-alt mr-2"></i>
                                                <h3>Frequently Asked Questions About Prof. Dr. Suresh H. Advani</h3>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!-- accordion -->
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="accordion" id="accordion" role="tablist">
                                        <div class="card">
                                            <div class="card-header" role="tab" id="heading-1">
                                                <h6 class="mb-0">
                                                    <a data-toggle="collapse" href="#collapse-1" aria-expanded="false"
                                                        aria-controls="collapse-1" data-abc="true"
                                                        class="collapsed">Where
                                                        does
                                                        Prof. Dr. Suresh H. Advani
                                                        practice</a>
                                                </h6>
                                            </div>
                                            <div id="collapse-1" class="collapse" role="tabpanel"
                                                aria-labelledby="heading-1" data-parent="#accordion">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="ml-4">
                                                            <p>Prof. Dr. Suresh H. Advani practices at Jaslok Hospital,
                                                                Mumbai</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-header" role="tab" id="heading-2">
                                                <h6 class="mb-0">
                                                    <a class="collapsed" data-toggle="collapse" href="#collapse-2"
                                                        aria-expanded="false" aria-controls="collapse-2"
                                                        data-abc="true">What is
                                                        the
                                                        specialty of Prof. Dr. Suresh H. Advani
                                                    </a>
                                                </h6>
                                            </div>
                                            <div id="collapse-2" class="collapse" role="tabpanel"
                                                aria-labelledby="heading-2" data-parent="#accordion">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="ml-4">
                                                            <p>Prof. Dr. Suresh H. Advani specialty is Medical Oncologist
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-header" role="tab" id="heading-3">
                                                <h6 class="mb-0">
                                                    <a class="collapsed" data-toggle="collapse" href="#collapse-3"
                                                        aria-expanded="false" aria-controls="collapse-3"
                                                        data-abc="true">What is
                                                        the
                                                        experience of Prof. Dr. Suresh H.
                                                        Advani</a>
                                                </h6>
                                            </div>
                                            <div id="collapse-3" class="collapse" role="tabpanel"
                                                aria-labelledby="heading-3" data-parent="#accordion">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="ml-4">
                                                            <p>Prof. Dr. Suresh H. Advani is Medical Oncologist with 43
                                                                years of experience.</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-header" role="tab" id="heading-4">
                                                <h6 class="mb-0">
                                                    <a class="collapsed" data-toggle="collapse" href="#collapse-4"
                                                        aria-expanded="false" aria-controls="collapse-4"
                                                        data-abc="true">What is
                                                        the
                                                        experience of Prof. Dr. Suresh H.
                                                        Advani</a>
                                                </h6>
                                            </div>
                                            <div id="collapse-4" class="collapse" role="tabpanel"
                                                aria-labelledby="heading-4" data-parent="#accordion">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="ml-4">
                                                            <p>Prof. Dr. Suresh H. Advani is Medical Oncologist with 43
                                                                years of experience.</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- accordion -->
                        </div>
                    </div> --}}
                    <!-- faq doctor -->
                    <!-- blog -->
                    {{-- <div class="blog_doctor">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="inner_blog_post">
                                        <ul class="list-unstyled list mt-2">
                                            <li class="d-flex align-items-center">
                                                <i class="fab fa-blogger mr-2"></i>
                                                <h3>BLOGS THAT MAY INTEREST YOU</h3>
                                            </li>
                                            <li class="marr">
                                                <a href="#" class="btn_link">Breast Cancer Treatment in India</a>
                                            </li>
                                            <li class="marr">
                                                <a href="#" class="btn_link">Oral Cancer Treatment in India</a>
                                            </li>
                                            <li class="marr">
                                                <a href="#" class="btn_link">Cervical Cancer Treatment in India</a>
                                            </li>
                                            <li class="marr">
                                                <a href="#" class="btn_link">Cancer Treatment in India</a>
                                            </li>
                                            <li class="marr">
                                                <a href="#" class="btn_link">Cost of Cancer Treatment in India</a>
                                            </li>
                                            <li class="marr">
                                                <a href="#" class="btn_link">Is PET/ CT Scan Important for Cancer
                                                    Investigations?</a>
                                            </li>
                                            <li class="marr">
                                                <a href="#" class="btn_link">A Patient’s Guide To CyberKnife – The
                                                    Cutting Edge Technology in Precision Surgery</a>
                                            </li>
                                            <li class="marr">
                                                <a href="#" class="btn_link">Key Differences Between Gamma Knife and
                                                    CyberKnife Treatment – Procedure, Side-effects, Costs and more </a>
                                            </li>
                                            <li class="marr">
                                                <a href="#" class="btn_link">A Complete Guide to Immunotherapy
                                                    Treatment in India</a>
                                            </li>
                                            <li class="marr">
                                                <a href="#" class="btn_link">The Advantages of Genetic Testing in
                                                    Early Detection and Effective Treatment of Cancer</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                    <!-- blog -->
                    <!-- faq medical-->
                    {{-- <div class="medical_faq">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="inner_medical_faq">
                                        <ul class="list-unstyled list mt-2">
                                            <li class="d-flex align-items-center">
                                                <i class="far fa-calendar-alt mr-2"></i>
                                                <h3>More About Medical Oncologist</h3>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!-- accordion -->
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="accordion" id="accordion" role="tablist">
                                        <div class="card">
                                            <div class="card-header" role="tab" id="heading-10">
                                                <h6 class="mb-0">
                                                    <a data-toggle="collapse" href="#collapse-10" aria-expanded="false"
                                                        aria-controls="collapse-10" data-abc="true"
                                                        class="collapsed">More About
                                                        {{ isset($doctor_details->full_name) ? ucfirst($doctor_details->full_name) : '' }}
                                                        practice</a>
                                                </h6>
                                            </div>
                                            <div id="collapse-10" class="collapse" role="tabpanel"
                                                aria-labelledby="heading-10" data-parent="#accordion">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="ml-4">
                                                            <p>{!! isset($doctor_details->remarks_text) ? ucfirst($doctor_details->remarks_text) : 'N/A' !!}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- accordion -->
                        </div>
                    </div> --}}
                    <!-- faq medical -->
                </div>
                <!-- doctor end -->
            </div>
        </div>
    </div>

@endsection
