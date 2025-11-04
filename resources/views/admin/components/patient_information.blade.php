@php
$patient_info = isset($patient_info) && !empty($patient_info) ? $patient_info : [];
$patient_photo = $patient_info ? $patient_info->patient_photo : '';
$gender_txt = $patient_info ? $patient_info->gender_txt : '';

@endphp
<div class="row">
    <div class="col-md-12 text-center">
        <div class="patient_img_radiology float-left">
            {{-- <img src="http://localhost/icure/public/images/doctor.png" alt="">
            {{ dd($patient_info) }} --}}
            @if (!empty($patient_photo))
                @if (!file_exists(asset('images/uploads/patient_images/thumb/' . $patient_photo)))

                    <img class="rounded w-100"
                        src="{{ asset('images/uploads/patient_images/thumb/' . $patient_photo) }}"
                        alt="No Image Found">
                @else
                    @if ($gender_txt == 'Male')
                        <img class="rounded w-100" src="{{ asset('images/boy.jpg') }}" alt="No Image Found">
                    @else
                        <img class="rounded w-100" src="{{ asset('images/no-photo.png') }}" alt="No Image Found">
                    @endif
                @endif
            @else
                @if ($gender_txt == 'Female')
                    <img class="rounded w-100" src="{{ asset('images/girl.jpg') }}" alt="No Image Found">
                @else
                    <img class="rounded w-100" src="{{ asset('images/no-photo.png') }}" alt="No Image Found">
                @endif
            @endif
        </div>

        <div class="patient_information_radiology">
            <table class="">
                <tbody>
                    <tr>
                        <th class="text-left ">Name</th>
                        <th class="text-left px-3">:</th>
                        <td class="text-left"> {{ !empty($patient_info) ? $patient_info->patient_name : '' }} </td>
                    </tr>
                    <tr>
                        <th class="text-left">Age</th>
                        <th class="text-left px-3">:</th>
                        <td class="text-left ">{{ !empty($patient_info) ? $patient_info->age : '' }}</td>
                    </tr>
                    <tr>
                        <th class="text-left">DOB</th>
                        <th class="text-left px-3">:</th>
                        <td class="text-left">
                            {{ !empty($patient_info) ? date('d/m/Y', strtotime($patient_info->patient_dob)) : '' }}
                        </td>
                    </tr>
                    <tr>
                        <th class="text-left">Gender</th>
                        <th class="text-left px-3">:</th>
                        <td class="text-left ">{{ !empty($patient_info) ? $patient_info->gender_txt : '' }}</td>
                    </tr>
                    <tr>
                        <th class="text-left">Blood Group</th>
                        <th class="text-left px-3">:</th>
                        <td class="text-left ">{{ !empty($patient_info) ? $patient_info->blood_group : '' }}</td>
                    </tr>
                    <tr>
                        <th class="text-left">Phone No</th>
                        <th class="text-left px-3">:</th>
                        <td class="text-left">{{ !empty($patient_info) ? $patient_info->mobile1 : '' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
