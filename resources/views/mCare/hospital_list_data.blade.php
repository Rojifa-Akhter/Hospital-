@empty(!$hospital_info_data)
    @foreach ($hospital_info_data as $record)
        <div class="col-md-6">
            <div class="inner_hospital">
                <span class="hospital-img">

                    @if ($record->image_url != '')
                        <img class="shadow-lg p-3 bg-white rounded w-50"
                            src="{{ asset('images/uploads/hospital_images/thumb/' . $record->image_url) }}">
                    @else
                        <img class="shadow-lg p-3 bg-white rounded w-50" src="{{ asset('images/hospital.png') }}" alt="">
                    @endif
                </span>
                <div class="d-flex flex-column ml-2">
                    <h2>{{ !empty($record->chamber_hospital_name) ? ucfirst($record->chamber_hospital_name) : 'N/A' }},
                        {{ !empty($record->chamber_hospital_location) ? ucfirst($record->chamber_hospital_location) : 'N/A' }}
                    </h2>
                    <ul class="list-unstyled list mt-2">
                        <li class="d-flex align-items-center">
                            <i class="fas fa-map-marker-alt mr-2"></i>
                            <b>{{ !empty($record->chamber_hospital_location) ? ucfirst($record->chamber_hospital_location) : 'N/A' }},
                                {{ !empty($record->CHAMBER_HOSPITAL_COUNTRY) ? ucfirst($record->CHAMBER_HOSPITAL_COUNTRY) : 'N/A' }}</b>
                        </li>
                        <li class="d-flex align-items-center">
                            <i class="far fa-hospital mr-2"></i>
                            <b>Established in:
                                {{ !empty($record->ESTABLISHE_YEAR) ? $record->ESTABLISHE_YEAR : 'N/A' }}</b>
                        </li>
                        <li class="d-flex align-items-center">
                            <i class="fas fa-bed mr-2"></i>
                            <b>Number of Beds:
                                {{ !empty($record->NUMBER_OF_BED) ? $record->NUMBER_OF_BED : 'N/A' }}</b>
                        </li>
                        <li class="d-flex align-items-center">
                            <i class="fas fa-certificate mr-2"></i>
                            <b>Multi Specialty,</b>
                        </li>
                        <a href="{{ route('mcare.hospital-details', $record->chamber_hospital_no_pk) }}"
                            class="btn btn-link">...Read More</a>
                    </ul>
                </div>
            </div>
        </div>

    @endforeach


@endempty
{{-- {{ dd($hospital_info_data) }} --}}
{{-- @if (!empty($hospital_info_data))

    {{-- @if (!$hospital_info_data->isEmpty()) --}}
{{-- @foreach ($hospital_info_data as $india_hospital)
    @php
        $image_path = isset($india_hospital->image_url) ? 'images/uploads/hospital_images/' . $india_hospital->image_url : 'mcare/images/b2.jpg';
    @endphp

    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <a href="{{ route('mcare.hospital-details', $india_hospital->chamber_hospital_no_pk) }}">
            <div class="hospital-box">
                <div class="d-flex flex-row mb-3">
                    <span class="hospital-img"><img src="{{ asset($image_path) }}" alt="Hospital" /></span>
                    <div class="hospital_info d-flex flex-column ml-2">
                        <h2>{{ $india_hospital->chamber_hospital_name }}</h2>
                        <ul class="list-unstyled list mt-2">
                            <li class="d-flex align-items-center">
                                <i class="fas fa-map-marker-alt mr-2"></i>
                                <b>{{ $india_hospital->chamber_hospital_location }}</b>
                            </li>
                            <li class="d-flex align-items-center">
                                <i class="far fa-hospital mr-2"></i>
                                <b>Established in: {{ $india_hospital->establishe_year }}</b>
                            </li>
                            <li class="d-flex align-items-center">
                                <i class="fas fa-bed mr-2"></i>
                                <b>Number of Beds: {{ $india_hospital->number_of_bed }}</b>
                            </li>
                            <li class="d-flex align-items-center">
                                <i class="fas fa-certificate mr-2"></i>
                                <b></b>
                                {{-- <b>{{ $india_hospital->chamber_hospital_speciality }}</b> --}}
{{-- </li>
                            <li class="d-flex align-items-center">
                                <i class="far fa-star mr-2"></i>
                                <b>{{ $india_hospital->chamber_hospital_location }}</b>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </a>
    </div> --}}

{{-- @endforeach --}}
{{-- @else --}}
{{-- <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <h4 class="text-center">No hospital available at this time.</h4>
    </div>
@endif --}}
