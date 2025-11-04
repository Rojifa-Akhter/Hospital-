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
        width: 100px;
    }

</style>
<div class="card">

    <div class="card-header">
        <h5 class="card-title"><i class="fa fa-user"></i>&nbsp; Patient information</h5>
    </div>
    <div class="card-body p-2 d-flex align-items-center justify-content-between">
        <div class="patient-infos">
            <table class="table mb-0 table-borderless" width='100%'>
                <tbody>
                    <tr>
                        <th>Name</th>
                        <th class="text-left">:</th>                        
                        <td id="patient_name">
                            {{ isset($patient_info->patient_name) ? ucfirst($patient_info->patient_name) : '' }}
                        </td>
                        <th class="text-left">UHID</th>
                        <th class="text-left">:</th>
                        <td class="text-left">{{isset($patient_info->patient_code) == '' ? '' : $patient_info->patient_code }}</td>
                    </tr>
                    <tr>
                        <th class="text-left">Age</th>
                        <th class="text-left">:</th>                       
                        <td class="text-left" id="patient_age">
                            {{ isset($patient_info->pat_age) == '0' ? '' : $patient_info->pat_age }}
                        </td>                       
                        <th class="text-left">Sex</th>
                        <th class="text-left">:</th>                       
                        <td class="text-left" id="patient_gender">
                            {{ isset($patient_info->gender_txt) == '' ? '' : $patient_info->gender_txt }}</td>
                    </tr>
                    <tr>                       
                        <th class="text-left">Blood Group</th>
                        <th class="text-left">:</th>
                        <td class="text-left" id="patient_bg">
                            {{ isset($patient_info->blood_group_txt) == '' ? '' : $patient_info->blood_group_txt }}
                        </td>
                        <th class="text-left">Phone No</th>
                        <th class="text-left">:</th>                       
                        <td class="text-left" id="patient_ms">
                            {{ isset($patient_info->mobile1) == '0' ? '' : $patient_info->mobile1 }}
                        </td>

                    </tr>
                    <tr>                       
                        <th class="text-left">Doctor Name</th>
                        <th class="text-left">:</th>
                        <td class="text-left" id="patient_bg" colspan="4">
                            {{ isset($patient_info->doctor_name) == '0' ? '' : ucwords($patient_info->doctor_name) }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="patient-img text-center">
            @if (isset($patient_info->patient_photo))
                <img class="w-120 rounded" id="pt_photo"
                    src="{{ asset('images/uploads/patient_images/thumb/') }}/{{ $patient_info->patient_photo }}"
                    alt="">
            @else
                @if (isset($patient_info->gender_txt) && $patient_info->gender_txt == 'Male')
                    <img class="w-100 rounded" id="pt_photo" src="{{ asset('images/boy.jpg') }}" alt="">
                @else
                    <img class="w-100 rounded" id="pt_photo" src="{{ asset('images/girl.jpg') }}" alt="">
                @endif
            @endif
        </div>
    </div>
</div>
