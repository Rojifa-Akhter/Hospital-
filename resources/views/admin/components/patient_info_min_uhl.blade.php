<style>
    .patient_info_card .info_table tr th {
        font-size: 14px !important;
        color: #0077c1;
    }

    .patient_info_card .info_table tr td {
        font-size: 14px !important
    }

    .patient_info_card .patient_info_img img {
        height: 95px;
        width: 95px;
    }

    .patient_info_card .patient_infos {
        border: 5px solid #0077c13b;
        padding: 0px 20px;
        margin-bottom: 20px;
    }

    .patient_info_card .patient_info_img img {
        border: 5px solid #0077c13b;
        float: left;
    }

    .patient_info_card .patient_infos {
        border: 5px solid #0077c13b;
        padding: 0px 20px;
        margin-bottom: 20px;
    }

    .patient_info_card .patient_infos {
        float: left;
        margin-left: 10px;
    }

    .patient-img {
        width: 65px;
    }

</style>
<div class="card">

    <div class="card-header">
        <h5 class="card-title"><i class="fa fa-user"></i>&nbsp; Patient information</h5>
    </div>
    <div class="card-body p-2 d-flex align-items-center justify-content-between">
        <div class="patient-infos">
            <table class="table mb-0 table-borderless">
                <tbody>
                    {{-- @dd($patient_info) --}}
                    {{-- <tr>
                        <th>Name</th>
                        <th class="text-left">:</th>
                        <th class="text-left"></th>
                        <th class="text-left"></th>
                        <td colspan="8" id="patient_name">
                            {{ isset($patient_info->patient_name) ? ucfirst($patient_info->patient_name) : '' }}</td> --}}

                        {{-- <th class="text-left">Phone No</th>
                        <th class="text-left">:</th>
                        <th class="text-left"></th>
                        <th class="text-left"></th>
                        <td class="text-left" id="phone_number">{{isset($patient_info->mobile1) == '0' ? '' : $patient_info->mobile1 }}</td> --}}
                    {{-- </tr> --}}
                    <tr>
                        <th class="text-left">Name</th>
                        <th class="text-left">:</th>
                        <th class="text-left"></th>
                        <th class="text-left"></th>
                        <td class="text-left" id="patient_name">
                            {{ isset($patient_info->patient_name) ? ucfirst($patient_info->patient_name) : '' }}</td>
                        <th class="text-left"></th>
                        <th class="text-left"></th>
                        <th class="text-right">UHID</th>
                        <th class="text-left">:</th>
                        <th class="text-left"></th>
                        <th class="text-left"></th>
                        <td class="text-left" id="patient_gender">
                            {{ isset($patient_info->patient_code) ? $patient_info->patient_code : '' }}</td>
                    </tr>
                    
                    <tr>
                        <th class="text-left">Age</th>
                        <th class="text-left">:</th>
                        <th class="text-left"></th>
                        <th class="text-left"></th>
                        <td class="text-left" id="patient_age">
                            {{ isset($patient_info->age) == '0' ? '' : $patient_info->age }}</td>
                        <th class="text-left"></th>
                        <th class="text-left"></th>
                        <th class="text-right">Sex</th>
                        <th class="text-left">:</th>
                        <th class="text-left"></th>
                        <th class="text-left"></th>
                        <td class="text-left" id="patient_gender">
                            {{ isset($patient_info->gender_txt) == '' ? '' : $patient_info->gender_txt }}</td>
                    </tr>
                    <tr>
                        <th class="text-left">Marital Status</th>
                        <th class="text-left">:</th>
                        <th class="text-left"></th>
                        <th class="text-left"></th>
                        <td class="text-left" id="patient_ms">
                            {{ isset($patient_info->marital_status_txt) == 0 ? '' : $patient_info->marital_status_txt }}
                        </td>
                        <th class="text-left"></th>
                        <th class="text-left"></th>
                        <th class="text-right">Blood Group</th>
                        <th class="text-left">:</th>
                        <th class="text-left"></th>
                        <th class="text-left"></th>
                        <td class="text-left" id="patient_bg">
                            {{ isset($patient_info->blood_group_txt) == '' ? '' : $patient_info->blood_group_txt }}
                        </td>
                    </tr>
                    <tr>
                        <th class="text-left">Phone No</th>
                        <th class="text-left">:</th>
                        <th class="text-left"></th>
                        <th class="text-left"></th>
                        <td class="text-left" id="patient_ms">
                            {{ isset($patient_info->mobile1) == '0' ? '' : $patient_info->mobile1 }}
                        </td>
                        <th class="text-left"></th>
                        <th class="text-left"></th>
                        {{-- <th class="text-right">Ref By</th>
                        <th class="text-left">:</th>
                        <th class="text-left"></th>
                        <th class="text-left"></th>
                        <td class="text-left" id="patient_bg">
                            {{ isset($patient_info->doctor_name) == '0' ? '' : $patient_info->doctor_name }}
                        </td> --}}
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="patient-img text-center">
            @if (isset($patient_info->patient_photo))
                <img class="w-100 rounded"
                    src="{{ asset('img/uploads/patient_images/thumb/') }}/{{ $patient_info->patient_photo }}"
                    alt="">
            @else
                @if (isset($patient_info->gender_txt) && $patient_info->gender_txt == 'Male')
                    <img class="w-100 rounded" src="{{ asset('images/boy.jpg') }}" alt="">
                @else
                    <img class="w-100 rounded" src="{{ asset('images/girl.jpg') }}" alt="">
                @endif
            @endif
        </div>
    </div>
</div>
