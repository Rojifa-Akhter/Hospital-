@extends("mCare.layouts.master")
@section('content')

    <!-- Modal end -->
    <div class="doctors_section">
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
                                                    class="country_id" value="{{ $value->nationality }}" />
                                            </div>
                                        </div>
                                        <input type="text" class="form-control " aria-label="Text input with checkbox"
                                            value="{{ $value->nationality }} ({{ $value->doctor }})" readonly=""
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
                                <input type="text" class="form-control" placeholder="Search By City.." id="city" />
                            </div>

                            <div class="inner_city">
                                @include('mCare.city_doctor_list')

                            </div>
                        </div>
                        <!-- by city -->

                        <!-- By Department -->
                        <div class="Department">
                            <h3>By Department</h3>
                            <div class="input-group mb-2">
                                <input type="text" class="form-control" placeholder="Search By Department.." id="dept" />
                            </div>

                            <div class="inner_dept">

                                @include('mCare.dept_doctor_list')

                            </div>
                        </div>
                        <!-- By Department -->

                        <!-- by hospital -->
                        <div class="hospital">
                            <h3>By Hospital</h3>
                            <div class="input-group mb-2">
                                <input type="text" class="form-control" placeholder="Search By Hospital.."
                                    id="hospital" />
                            </div>

                            <div class="inner_hospital">

                                @include('mCare.hospital_doctor_list')
                            </div>
                        </div>
                        <!-- by hospital -->

                        <!-- BEST DOCTORS -->
                        <div class="best_doctors">
                            <h3>BEST DOCTORS</h3>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <input type="checkbox" aria-label="Checkbox for following text input" />
                                    </div>
                                </div>
                                <input type="text" class="form-control" aria-label="Text input with checkbox"
                                    value="Best Doctors in India" readonly="" />
                            </div>
                        </div>
                        <!-- BEST DOCTORS -->
                    </div>
                </div>
                <!-- Sidebar end-->



                <!-- doctor strat -->
                <div class="col-lg-8 col-md-12" id="main">
                    <div class="doctors_gallery">
                        <div class="row" id="doctor_data">
                            @include('mCare.doctor_list')

                            <div class="pagination">
                                {{ $doctor_info_data->render() }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- doctor end -->
            </div>
        </div>
    </div>

@endsection


@push('customjs')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        $(document).on('keyup', '#city', function(e) {
            const city = $('#city').val();
            // alert(city)
            $.ajax({
                url: "{{ route('cover.doctor-search-data-city') }}",
                type: 'POST',
                data: {
                    city: city
                },
                beforeSend: function() {
                    // blockUI();
                },
                success: function(data) {
                    console.log(data)
                    $('.inner_city').html(data);
                },
                complete: function() {
                    // $.unblockUI();
                }
            });
        });


        $(document).on('keyup', '#dept', function(e) {
            const dept = $('#dept').val();
            // alert(city)
            $.ajax({
                url: "{{ route('cover.doctor-search-data-dept') }}",
                type: 'POST',
                data: {
                    dept: dept
                },
                beforeSend: function() {
                    // blockUI();
                },
                success: function(data) {
                    console.log(data)
                    $('.inner_dept').html(data);
                },
                complete: function() {
                    // $.unblockUI();
                }
            });
        });


        $(document).on('keyup', '#hospital', function(e) {
            const hospital = $('#hospital').val();
            // alert(city)
            $.ajax({
                url: "{{ route('cover.doctor-search-data-hospital') }}",
                type: 'POST',
                data: {
                    hospital: hospital,
                },
                beforeSend: function() {
                    // blockUI();
                },
                success: function(data) {
                    console.log(data)
                    $('.inner_hospital').html(data);
                },
                complete: function() {
                    // $.unblockUI();
                }
            });
        });

        $(".country_id").click(function() {
            if (this.checked) {
                //I am checked
                const country = $(this).val();
                $.ajax({
                    url: "{{ route('cover.doctor-search-data-country-checkbox') }}",
                    type: 'POST',
                    data: {
                        country: country,
                    },
                    beforeSend: function() {
                        // blockUI();
                    },
                    success: function(data) {
                        console.log(data)
                        $('#doctor_data').html(data);
                    },
                    complete: function() {
                        // $.unblockUI();
                    }
                });



            } else {
                //I'm not checked
            }
        });

        $(".city_id").click(function() {
            if (this.checked) {
                //I am checked
                const city_id = $(this).val();
                $.ajax({
                    url: "{{ route('cover.doctor-search-data-city-checkbox') }}",
                    type: 'POST',
                    data: {
                        city_id: city_id,
                    },
                    beforeSend: function() {
                        // blockUI();
                    },
                    success: function(data) {
                        console.log(data)
                        $('#doctor_data').html(data);
                    },
                    complete: function() {
                        // $.unblockUI();
                    }
                });



            } else {
                //I'm not checked
            }
        });

        $(".dept_id").click(function() {
            if (this.checked) {
                //I am checked
                const dept = $(this).val();
                $.ajax({
                    url: "{{ route('cover.doctor-search-data-dept-checkbox') }}",
                    type: 'POST',
                    data: {
                        dept: dept,
                    },
                    beforeSend: function() {
                        // blockUI();
                    },
                    success: function(data) {
                        console.log(data)
                        $('#doctor_data').html(data);
                    },
                    complete: function() {
                        // $.unblockUI();
                    }
                });



            } else {
                //I'm not checked
            }
        });


        $(".hospital_search").click(function() {
            if (this.checked) {
                //I am checked
                const hospital = $(this).val();
                $.ajax({
                    url: "{{ route('cover.doctor-search-data-hospital-checkbox') }}",
                    type: 'POST',
                    data: {
                        hospital: hospital,
                    },
                    beforeSend: function() {
                        // blockUI();
                    },
                    success: function(data) {
                        console.log(data)
                        $('#doctor_data').html(data);
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
