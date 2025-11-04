@if ($hospital_india != '')
    {{-- @if (!$hospital_india->isEmpty()) --}}
    @foreach ($hospital_india as $india_hospital)
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
                                    <b>{{ $india_hospital->chamber_hospital_speciality }}</b>
                                </li>
                                <li class="d-flex align-items-center">
                                    <i class="far fa-star mr-2"></i>
                                    <b>{{ $india_hospital->chamber_hospital_location }}</b>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </a>
        </div>

    @endforeach
@else
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <h4 class="text-center">No hospital available at this time.</h4>
    </div>
@endif
