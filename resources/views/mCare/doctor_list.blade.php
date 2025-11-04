@empty(!$doctor_info_data)
    @foreach ($doctor_info_data as $record)
        <div class="col-md-6">
            <div class="inner_doctor">
                <span class="doctor-img">
                    @if ($record->photo_name != '')
                        <img class="shadow-lg p-3 bg-white rounded w-50"
                            src="{{ asset('images/uploads/doctor_images/' . $record->photo_name) }}">
                    @else
                        @if ($record->gender_txt == 'Male')
                            <img class="shadow-lg p-3 bg-white rounded w-50" src="{{ asset('images/doctor.png') }}" alt="">
                        @else
                            <img class="shadow-lg p-3 bg-white rounded w-50" src="{{ asset('images/nurse-2.png') }}"
                                alt="">
                        @endif
                    @endif

                </span>
                {{-- <div class="d-flex flex-column ml-2">
                    <h2>{{ !empty($record->full_name) ? ucfirst($record->full_name) : 'N/A' }}
                    </h2>
                    <p>{{ !empty($record->specialization) ? ucfirst($record->specialization) : 'N/A' }},
                        {{ !empty($record->chamber_hospital_location) ? $record->chamber_hospital_location : 'N/A' }},
                        {{ !empty($record->experience) ? $record->experience : 'N/A' }} years of
                        experience
                    </p>
                    <ul class="list-unstyled list mt-2">

                        <li class="d-flex align-items-center">
                            <i class="far fa-hospital mr-2"></i>
                            <span>{{ !empty($record->chamber_hospital_location) ? ucfirst($record->chamber_hospital_name) : 'N/A' }},
                                {{ !empty($record->chamber_hospital_location) ? ucfirst($record->chamber_hospital_location) : 'N/A' }}</span>
                        </li>

                        <li class="d-flex align-items-center">
                            <i class="far fa-star mr-2"></i>
                            <b>Highlights</b>
                        </li>
                        <a href="{{ route('mcare.doctor-details', $record->person_no_pk) }}"
                            class="btn btn-link">...Read
                            More</a>
                    </ul>
                </div> --}}

                <div class="d-flex flex-row mb-3">
                    {{-- <span class="doctor-img"><img src="{{ asset($imagePath) }}" alt="doctor" /></span> --}}
                    <div class="doctor_info d-flex flex-column ml-2">
                        <h2>{{ $record->full_name }}</h2>
                        <p>{{ $record->specialization }} Specialist.</p>
                        <ul class="list-unstyled list mt-2">
                            <li class="d-flex align-items-center">
                                <i class="far fa-hospital mr-3 text-primary"></i>
                                <span>{{ $record->chamber_hospital_name }} </span>
                            </li>
                            <li class="d-flex align-items-center">
                                <i class="far fa-star mr-2 text-primary"></i>
                                <b>Highlight</b>
                            </li>
                            <div class="inner-highlight">
                                @php
                                    echo $record->remarks_text;
                                @endphp
                            </div>

                            <a href="{{ route('mcare.doctor-details', $record->person_no_pk) }}"
                                class="btn btn-link">...Read
                                More</a>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endempty







{{-- @if ($doctor_info_data != '') --}}
{{-- @if (!$doctor_indian_list->isEmpty()) --}}
{{-- @foreach ($doctor_info_data as $banDoc)
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
        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
            <a href="{{ route('mcare.doctor-details', $banDoc->person_no_pk) }}">
                <div class="doctor-box">
                    <div class="d-flex flex-row mb-3">
                        <span class="doctor-img"><img src="{{ asset($imagePath) }}" alt="doctor" /></span>
                        <div class="doctor_info d-flex flex-column ml-2">
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
                                <div class="inner-highlight">
                                    @php
                                        echo $banDoc->remarks_text;
                                    @endphp
                                </div>
                            </ul>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    @endforeach
@else --}}
{{-- <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <h4 class="text-center">No doctor available at this time</h4>
    </div>
@endif --}}
