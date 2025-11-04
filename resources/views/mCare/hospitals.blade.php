@extends("mCare.layouts.master")
@section('content')

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





                <!-- hospital strat -->
                <div class="col-md-8" id="main">
                    <div class="hospital_gallery">
                        <div class="row">

                            @include('mCare.hospital_list_data')


                            <div class="pagination">
                                {{ $hospital_info_data->render() }}
                            </div>


                            {{-- <div class="col-md-6">
                                <div class="inner_hospital">
                                    <span class="hospital-img"><img src="images/b2.jpg" alt="Hospital"></span>
                                    <div class="d-flex flex-column ml-2">
                                        <h2>BLK Super Speciality Hospital, New Delhi</h2>
                                        <ul class="list-unstyled list mt-2">
                                            <li class="d-flex align-items-center">
                                                <i class="fas fa-map-marker-alt mr-2"></i>
                                                <b>New Delhi, India</b>
                                            </li>
                                            <li class="d-flex align-items-center">
                                                <i class="far fa-hospital mr-2"></i>
                                                <b>Established in: 1959</b>
                                            </li>
                                            <li class="d-flex align-items-center">
                                                <i class="fas fa-bed mr-2"></i>
                                                <b>Number of Beds: 650</b>
                                            </li>
                                            <li class="d-flex align-items-center">
                                                <i class="fas fa-certificate mr-2"></i>
                                                <b>Super Specialty,</b>
                                            </li>
                                            <a href="#" class="btn btn-link">...Read More</a>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="inner_hospital">
                                    <span class="hospital-img"><img src="images/b2.jpg" alt="Hospital"></span>
                                    <div class="d-flex flex-column ml-2">
                                        <h2>Kokilaben Dhirubhai Ambani Hospital Mumbai</h2>
                                        <ul class="list-unstyled list mt-2">
                                            <li class="d-flex align-items-center">
                                                <i class="fas fa-map-marker-alt mr-2"></i>
                                                <b>Mumbai, India</b>
                                            </li>
                                            <li class="d-flex align-items-center">
                                                <i class="far fa-hospital mr-2"></i>
                                                <b>Established in: 2006</b>
                                            </li>
                                            <li class="d-flex align-items-center">
                                                <i class="fas fa-bed mr-2"></i>
                                                <b>Number of Beds: 750</b>
                                            </li>
                                            <li class="d-flex align-items-center">
                                                <i class="fas fa-certificate mr-2"></i>
                                                <b>Multi Specialty</b>
                                            </li>
                                            <a href="#" class="btn btn-link">...Read More</a>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="inner_hospital">
                                    <span class="hospital-img"><img src="images/b2.jpg" alt="Hospital"></span>
                                    <div class="d-flex flex-column ml-2">
                                        <h2>Nanavati Super Specialty Hospital, Mumbai</h2>
                                        <ul class="list-unstyled list mt-2">
                                            <li class="d-flex align-items-center">
                                                <i class="fas fa-map-marker-alt mr-2"></i>
                                                <b>Mumbai, India</b>
                                            </li>
                                            <li class="d-flex align-items-center">
                                                <i class="far fa-hospital mr-2"></i>
                                                <b>Established in: 1950</b>
                                            </li>
                                            <li class="d-flex align-items-center">
                                                <i class="fas fa-bed mr-2"></i>
                                                <b>Number of Beds: 350</b>
                                            </li>
                                            <li class="d-flex align-items-center">
                                                <i class="fas fa-certificate mr-2"></i>
                                                <b>Super Specialty,</b>
                                            </li>
                                            <a href="#" class="btn btn-link">...Read More</a>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="inner_hospital">
                                    <span class="hospital-img"><img src="images/b2.jpg" alt="Hospital"></span>
                                    <div class="d-flex flex-column ml-2">
                                        <h2>Global Hospitals, Chennai</h2>
                                        <ul class="list-unstyled list mt-2">
                                            <li class="d-flex align-items-center">
                                                <i class="fas fa-map-marker-alt mr-2"></i>
                                                <b>Chennai, India</b>
                                            </li>
                                            <li class="d-flex align-items-center">
                                                <i class="far fa-hospital mr-2"></i>
                                                <b>Established in: 1999</b>
                                            </li>
                                            <li class="d-flex align-items-center">
                                                <i class="fas fa-bed mr-2"></i>
                                                <b>Number of Beds: 1000</b>
                                            </li>
                                            <li class="d-flex align-items-center">
                                                <i class="fas fa-certificate mr-2"></i>
                                                <b>Multi Specialty</b>
                                            </li>
                                            <a href="#" class="btn btn-link">...Read More</a>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="inner_hospital">
                                    <span class="hospital-img"><img src="images/b2.jpg" alt="Hospital"></span>
                                    <div class="d-flex flex-column ml-2">
                                        <h2>Apollo Hospital Bangalore Bannerghatta Road</h2>
                                        <ul class="list-unstyled list mt-2">
                                            <li class="d-flex align-items-center">
                                                <i class="fas fa-map-marker-alt mr-2"></i>
                                                <b>Bangalore, India</b>
                                            </li>
                                            <li class="d-flex align-items-center">
                                                <i class="far fa-hospital mr-2"></i>
                                                <b>Established in: 2007</b>
                                            </li>
                                            <li class="d-flex align-items-center">
                                                <i class="fas fa-bed mr-2"></i>
                                                <b>Number of Beds: 250</b>
                                            </li>
                                            <li class="d-flex align-items-center">
                                                <i class="fas fa-certificate mr-2"></i>
                                                <b>Multi Specialty</b>
                                            </li>
                                            <a href="#" class="btn btn-link">...Read More</a>
                                        </ul>
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div>

                <!-- hospital end -->
            </div>
        </div>
    </div>

@endsection

@push('customjs')
    <script>
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

        $(".hospital_country").click(function() {
            if (this.checked) {
                //I am checked
                const country = $(this).val();
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
                        // $('.hospital_gallery').html(data);
                    },
                    complete: function() {
                        // $.unblockUI();
                    }
                });



            } else {
                //I'm not checked
            }
        });

        $(".city_search").click(function() {
            if (this.checked) {
                //I am checked
                const city_id = $(this).val();
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

        $(document).on('click', '.dept_search', function() {
            if (this.checked) {
                //I am checked
                const dept = $(this).val();
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




        $(".hospital_search").click(function() {
            if (this.checked) {
                //I am checked
                const hospital = $(this).val();
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
