@if(!empty($doctor_list))
    @foreach($doctor_list as $doctor_row)
        <div class="col-sm-12 col-md-6 col-xl-4">
            <div class="doctor_card">
                <div class="doctor_image">
                    <img class="w-100" src="{{asset('coverpage/img/doc5.jpg')}}" alt="">
                    @if($doctor_row->nationality != '')
                        <div class="doctor_country">
                            <span>{{!empty($doctor_row->nationality)?$doctor_row->nationality:""}}</span>

                        </div>
                    @endif
                </div>

                <div class="doctor_info text-center">
                    <h5 class="doctor_name">{{!empty($doctor_row->full_name)?$doctor_row->full_name:"N/A"}} </h5>
                    <p class="doctor_speciality">{{!empty($doctor_row->specialization)?$doctor_row->specialization:"N/A"}}</p>
                    <p class="doctor_degree"><i class="fas fa-graduation-cap"></i>&nbsp;&nbsp;MBBS, MPH, PGT (Internal Medicine) </p>
                </div>

                <div class="doctor_info_overlay text-center">
                    <div class="info_overlay">
                        <h5 class="doctor_name">{{!empty($doctor_row->full_name)?$doctor_row->full_name:"N/A"}}  </h5>
                        <p class="doctor_speciality">{{!empty($doctor_row->specialization)?$doctor_row->specialization:"N/A"}}</p>
                        <p class="doctor_degree"><i class="fas fa-graduation-cap"></i>&nbsp;&nbsp;MBBS, MPH, PGT (Internal Medicine) </p>
                        <p class="rating"><i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i></p>
                        <p class="doctor_experience"><span>Experience:</span> {{!empty($doctor_row->experience)?$doctor_row->experience:""}}</p>
                        <p class="doctor_fees"><span>Doctor Fees:</span> {{!empty($doctor_row->doctor_fee)?$doctor_row->doctor_fee:0}} BDT</p>
                        <div class="btn-group">
                            <button class="btn"> <i class="fa fa-video"></i></button>
                            <button class="btn"> <i class="fas fa-phone-alt"></i></button>
                            <button class="btn"> <i class="far fa-comment-dots"></i></button>
                            <button class="btn"> <i class="fas fa-map-marker-alt"></i></button>
                        </div>
                        <div class="btn-group btn-block">
                            <?php $auth = !empty(Auth::user()->user_fullname)?Auth::user()->user_fullname:'';?>
                            @if($auth != '')
                                <a class="btn btn-theme2 font-size-12" href="{{route('cover.book-appointment-sign-doctor',$doctor_row->person_no_pk)}}" >Book Appointment</a>
                            @else
                                <button class="btn btn-theme2 font-size-12" data-toggle="modal" data-target="#bookAppointment"  >Book Appointment</button>
                            @endif
                            <button class="btn btn-theme2 font-size-12" data-toggle="modal" data-target="#doctor_details"  data-action="{{route('ipd.admission-list-edit', $doctor_row->person_no_pk)}}">Details</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @endforeach
@endif
