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
        <h5 class="card-title"><i class="fa fa-user"></i>&nbsp; Patient information
            <?php
            $patientId = isset($patient_info->patient_code) == '' ? '' : $patient_info->patient_code;
            $hospital_code = Session::get('user.ses_hospital_code');
            ?>
            &nbsp;


            <button class="btn btn-outline-success btn-md float-right open-modal mt-2 ml-2 manuAllyimgCapture"
                id="manuAllyimgCapture" style="display: none;" data-modal="common-modal-md" data-action=""
                data-title="Manually Image Capture"><i class="fa fa-camera"></i> Manually Image Capture</button>
            &nbsp;
            <button class="btn btn-outline-primary btn-md float-right open-modal mt-2 imgCapture" id="imgCapture"
                style="display: none;" data-modal="common-modal-md" data-action="" data-title="For Capture New Image"><i
                    class="fa fa-plus"></i> For Capture New Image</button>




        </h5>
    </div>
    <div class="card-body p-2 d-flex align-items-center justify-content-between">
        <div class="patient-infos">
            <table class="table mb-0 table-borderless">
                <tbody>
                    <tr>
                        <th>Name</th>
                        <th class="text-left">:</th>
                        <th class="text-left"></th>
                        <th class="text-left"></th>
                        <td colspan="8" id="patient_name">
                            {{ isset($patient_info->patient_name) ? ucfirst($patient_info->patient_name) : '' }} </td>

                        <th class="text-left">
                            @if ($hospital_code != 'UNICO')
                                Patient ID
                            @else
                                UHID
                            @endif


                        </th>
                        <th class="text-left">:</th>
                        <th class="text-left"></th>
                        <th class="text-left"></th>
                        <td class="text-left" id="patient_code">
                            {{ isset($patient_info->patient_code) ? $patient_info->patient_code : '' }}
                            <strong
                                id="sid">{{ isset($patient_info->service_number) ? '(' . $patient_info->service_number . ')' : '' }}
                            </strong>
                            {{-- <p>AA</p> --}}
                        </td>
                    </tr>
                    <tr>
                        <th class="text-left">Age</th>
                        <th class="text-left">:</th>
                        <th class="text-left"></th>
                        <th class="text-left"></th>
                        <td class="text-left" id="patient_age">
                            {{ isset($patient_info->pat_age) == '0' ? '' : $patient_info->pat_age }}</td>
                        <th class="text-left"></th>
                        <th class="text-left"></th>
                        <th class="text-left"></th>
                        <th class="text-left"></th>
                        <th class="text-left"></th>
                        <th class="text-left"></th>
                        <th class="text-left"></th>
                        <th class="text-right">
                            @if ($hospital_code != 'UNICO')
                                Gender
                            @else
                                Sex
                            @endif
                        </th>

                        <th class="text-left">:</th>
                        <th class="text-left"></th>
                        <th class="text-left"></th>

                        <td class="text-left" id="patient_gender">
                            {{ isset($patient_info->gender_txt) == '' ? '' : $patient_info->gender_txt }}</td>
                    </tr>
                    {{-- <tr>
                        <th class="text-left">Marital Status</th>
                        <th class="text-left">:</th>
                        <th class="text-left"></th>
                        <th class="text-left"></th>
                        <td class="text-left" id="patient_ms">
                            {{ isset($patient_info->marital_status_txt) == 0 ? '' : $patient_info->marital_status_txt }}
                        </td>
                        <th class="text-left"></th>
                        <th class="text-left"></th>
                        <th class="text-right">BG</th>
                        <th class="text-left">:</th>
                        <th class="text-left"></th>
                        <th class="text-left"></th>
                        <td class="text-left" id="patient_bg">
                            {{ isset($patient_info->blood_group_txt) == '' ? '' : $patient_info->blood_group_txt }}
                        </td>


                    </tr> --}}
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
                        @if ($hospital_code != 'UNICO')
                            <th class="text-right">Ref By</th>
                            <th class="text-left">:</th>
                            <th class="text-left"></th>
                            <th class="text-left"></th>
                            <td class="text-left" id="patient_bg">
                                {{ isset($patient_info->doctor_name) == '0' ? '' : $patient_info->doctor_name }}
                            </td>
                        @endif
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="patient-img text-center patient-img " id="patient_img">
            {{-- @if (isset($patient_info->patient_photo))
                    <img class="w-15 float-right rounded"
                        src="{{ asset('images/patient.png') }}/{{ $patient_info->patient_photo }}" alt="" id="patient_img">
                @else
                    @if (isset($patient_info->gender_txt) && $patient_info->gender_txt == 'Male')
                        <img class="w-15 float-right rounded" src="{{ asset('images/boy.jpg') }}" alt="" id="patient_img">
                    @else
                        <img class="w-15 float-right rounded"
                            src="{{ asset('images/uploads/patient_images/886.png') }}" alt="" id="patient_img">
                    @endif
                @endif --}}

            @if ($hospital_code != 'UNICO')

                <?php
                $firstTwoCharacters = substr(isset($patient_info->patient_code), 0, 2);
                ?>
                @if (isset($patient_info->patient_photo))
                    @if (ctype_alpha($firstTwoCharacters))
                        @if (file_exists(public_path('patient_photo/' . $firstTwoCharacters[0] . '/' . $firstTwoCharacters)))
                            <img class="w-15 float-right rounded"
                                src="{{ asset('patient_photo/' . $firstTwoCharacters[0] . '/' . $firstTwoCharacters . '/' . $rcvPat->patient_photo) }}"
                                style="">
                        @else
                            <img class="w-15 float-right rounded"
                                src="{{ asset('patient_photo/OTHER/' . $patient_info->patient_photo) }}" style="">
                        @endif
                    @else
                        <img class="w-15 float-right rounded"
                            src="{{ asset('patient_photo/OTHER/' . $patient_info->patient_photo) }}" style="">
                    @endif
                @endif
            @endif
        </div>
    </div>
</div>
