
<div class="form-row">
    @if(!empty($patient_details))
        @foreach($patient_details as $details)
            <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4">
                <div class="user-card">
                    <div class="card shadow-sm">
                        <div class="card-body text-center">
                            <div class="image">

{{--                                @if ($details->patient_photo != null)--}}
{{--                                    <img class="" style="width: 70%;"--}}
{{--                                         src="{{ asset('images/uploads/patient_images/thumb/' . $details->patient_photo) }}">--}}
                                @if($details->gender_txt == 'Female')
                                    <img class="" style="width: 70%;"
                                         src="{{ asset('images/girl.jpg') }}">
                                @elseif($details->gender_txt == 'Male')
                                    <img class="" style="width: 70%;"
                                         src="{{ asset('images/boy.jpg') }}">
                                @elseif($details->gender_txt == 'Others')
                                    <img class="" style="width: 70%;"
                                         src="{{ asset('images/patient.png') }}">
                                @else
                                    <img class="" style="width: 70%;"
                                         src="{{ asset('images/patient.png') }}">
                                @endif

                            </div>

                            <div class="details">
                                <h6>Patient Name: {{ $details->patient_name }}</h6>
                                <h6>Gender: {{ $details->gender_txt }}</h6>
                                <h6> Occupied Date:<div class="badge badge-primary badge-outlined">{{!empty($details->admission_date)?date("d/m/Y", strtotime($details->admission_date)):"N/A"}}</div> </h6>
                                <h6>Discharge Date:<div class="badge badge-warning badge-outlined">{{!empty($details->dis_date)?date("d/m/Y", strtotime($details->dis_date)):"N/A"}}</div></h6>

                            </div>

                        </div>
                    </div>
                </div>
            </div>

        @endforeach
    @endif
</div>
