@if ($doctor_indian_list != '')
    {{-- @if (!$doctor_indian_list->isEmpty()) --}}
    @foreach ($doctor_indian_list as $banDoc)
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
        <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
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
@else
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <h4 class="text-center">No doctor available at this time</h4>
    </div>
@endif
