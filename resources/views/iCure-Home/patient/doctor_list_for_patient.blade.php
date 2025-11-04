<div class="row">
   
    @if(!empty($doctor_list))
        @foreach($doctor_list as $doctor_row)

            <div class="col-xl-4 col-lg-6">
                <div class="card text-center user-contact-list">
                    <div class="p-5">
                        <div class="avatar avatar-xxl brround d-block cover-image mx-auto"
                             data-image-src="{{asset('coverpage/img/doc5.jpg')}}"
                             style="background: url({{asset('coverpage/img/doc5.jpg')}}&quot;) center center;"></div>
                        <div class="wrapper mt-3">
                            <p class="mb-0 mt-1 text-dark font-weight-semibold">{{!empty($doctor_row->full_name)?$doctor_row->full_name:"N/A"}} </p>
                            <small
                                class="text-muted">{{!empty($doctor_row->specialization)?$doctor_row->specialization:"N/A"}}</small>
                            <p class="doctor_degree"><i
                                    class="fas fa-graduation-cap"></i>&nbsp; {{!empty($doctor_row->degree1)?$doctor_row->degree1.','.$doctor_row->degree2.','.$doctor_row->degree3:"N/A"}}
                            </p>
                            <p class="rating">
                                @if(!empty($doctor_row->doctor_ratings))
                                    @if($doctor_row->doctor_ratings == 1)
                                        <i class="fas fa-star"></i>
                                    @elseif($doctor_row->doctor_ratings == 2)
                                        <i class="fas fa-star"></i> <i class="fas fa-star"></i>
                                    @elseif($doctor_row->doctor_ratings == 3)
                                        <i class="fas fa-star"></i> <i class="fas fa-star"></i>
                                    @elseif($doctor_row->doctor_ratings == 4)
                                        <i class="fas fa-star"></i> <i class="fas fa-star"></i>
                                    @elseif($doctor_row->doctor_ratings == 5)
                                        <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i
                                            class="fas fa-star"></i> <i class="fas fa-star"></i><i
                                            class="fas fa-star"></i>

                                    @endif
                                @else
                                    {{'N/A'}}
                                @endif

                            </p>
                            <p class="doctor_experience">
                                <span>Experience:</span> {{!empty($doctor_row->experience)?number_format($doctor_row->experience,2):0}}
                            </p>
                            <p class="doctor_fees">
                                <span>Doctor Fees:</span> {{!empty($doctor_row->doctor_fee)?$doctor_row->doctor_fee:0}}
                                BDT</p>
                            <div class="btn-group">
                                <button class=" new-list2 btn btn-primary"><i class="fas fa-phone-alt"></i></button>
                                <button class="new-list2 btn btn-success"><i class="far fa-comment-dots"></i></button>
                            </div>
                        </div>
                        <input type="hidden" id="data_id" value="{{$doctor_row->person_no_pk}}">
                     
                        <div class="">
                            <a class="btn btn-primary btn-svgs mt-5"
                               href="{{route('cover.book-appointment-sign-doctor-by-patient',$doctor_row->person_no_pk)}}">Book
                                Appointment</a>
                            <button class="btn btn-theme2 font-size-12 btn-success mt-5" data-toggle="modal"
                                    data-target="#Patient_details"
                                    data-modal="common-modal-sm" data-action="" id="doc_details"
                                    onclick="docDetails({{  $doctor_row->person_no_pk }})"
                                    data_id="{{$doctor_row->person_no_pk}}">
                                Details
                            </button>

                        </div>
                    </div>
                </div>
            </div>

        @endforeach
    @endif


</div>


<!-- Appointment Modal -->
<div class="modal fade" id="Patient_details" data-backdrop="static" data-keyboard="false" tabindex="-1"
     aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content" id="doctor_data">

            @include('iCure-Home.patient.doctor_details_modal')


            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <!-- <button type="button" class="btn btn-success">Sign In</button> -->
            </div>
        </div>
    </div>
</div>



@push('patient_customjs')
    <script>
        function docDetails(data_id) {
            $.ajax({
                data: {
                    data_id: data_id,
                },
                url: '{{ route('patient.doctor-details') }}',
                type: "get",
                beforeSend: function () {
                    blockUI();
                },
                success: function (data) {
                    console.log(data)

                    // all value
                    $('#doctor_full_name').html(data[0].full_name)
                    $('.doctor_full_name').html(data[0].full_name)
                    $('#user_name').html(data[0].full_name)
                    // $('#license').html(data.bmdc_number)
                    $('#email').html(data[0].email_personal)
                    $('#pat_email').html(data[0].email_personal)
                    // $('#laguge').html(data.full_name)
                    $('#phone').html(data[0].phone_mobile)
                    $('#pat_mobile').html(data[0].phone_mobile)
                    $('#pat_c_address').html(data[0].pe_addr1)
                    $('#expertise').html(data[0].specialization)

                    // schedule
                    data[1].forEach(function (sched_date) {
                        // var toDate=new Date(sched_date.schedule_dt);
                        var start_d = new Date(sched_date.start_time);
                        var end_d = new Date(sched_date.end_time);
                        var sch_date = new Date(sched_date.schedule_dt);
                        var start_time = start_d.toLocaleTimeString().toLowerCase();
                        var end_time = end_d.toLocaleTimeString().toLowerCase();
                        var schedule_date = new Date(sch_date);
                        // var schedule_date = sch_date.toLocaleDateString('en-GB', {timeZone: 'UTC'});

                        var dayNames = new Array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday','Saturday');
                        var currentDate = Math.round(+new Date(sched_date.schedule_dt) / 1000);
                        var nData = new Date(sched_date.schedule_dt);
                        $('#date_time').append(`<tr><th class="left">${schedule_date}</th><th class="bg-success text-white date_day text-left">${dayNames[nData.getDay()]}</th><th class="text-left">${start_time}</th><th class="text-left">${end_time}</th></tr>`)
                        console.log(sched_date.schedule_dt);
                    })
                    // $('.sat').html(data[1].schedule_dt)
                },
                complete: function () {
                    $.unblockUI();
                }
            });
        }
    </script>
@endpush
