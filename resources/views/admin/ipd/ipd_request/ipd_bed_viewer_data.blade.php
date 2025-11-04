@php
    $ipd_admission = (isset($ipd) && (!empty($ipd))) ? $ipd : [];
    $admission_no_pk = ($ipd_admission) ? $ipd_admission->admission_no_pk : '';
    $admission_uid = ($ipd_admission) ? $ipd_admission->admission_uid : '';
    $admission_date = ($ipd_admission) ? $ipd_admission->admission_date : '';
    $primary_doctor_no_fk = ($ipd_admission) ? $ipd_admission->primary_doctor_no_fk : '';
    $duty_doc_person_no_fk = ($ipd_admission) ? $ipd_admission->duty_doc_person_no_fk : '';
    $initial_bed_no_fk = ($ipd_admission) ? $ipd_admission->initial_bed_no_fk : '';
    $curr_bed_no_fk = ($ipd_admission) ? $ipd_admission->curr_bed_no_fk : '';
    $old_bed_no_fk = ($ipd_admission) ? $ipd_admission->old_bed_no_fk : '';
    $curr_ward_no_fk = ($ipd_admission) ? $ipd_admission->curr_ward_no_fk : '';
    $reg_type_no_fk = ($ipd_admission) ? $ipd_admission->reg_type_no_fk : '';
    $su_no_fk = ($ipd_admission) ? $ipd_admission->new_su_no_fk : '';
    $prescription_no_fk = ($ipd_admission) ? $ipd_admission->prescription_no_fk : '';
    $prescription_uid = ($ipd_admission) ? $ipd_admission->prescription_uid : '';
    $appointment_no_fk = ($ipd_admission) ? $ipd_admission->appointment_no_fk : '';
    $opd_department_su_no_fk = ($ipd_admission) ? $ipd_admission->opd_department_su_no_fk : '';
    $opd_department_name = ($ipd_admission) ? $ipd_admission->opd_department_name : '';
    $status = ($ipd_admission) ? $ipd_admission->status : '';
    $first_ref_doc_person_no_fk = ($ipd_admission) ? $ipd_admission->first_ref_doc_person_no_fk : '';
    $second_ref_doc_person_no_fk = ($ipd_admission) ? $ipd_admission->second_ref_doc_person_no_fk : '';
    $ref_doc_person_no_fk = ($ipd_admission) ? $ipd_admission->ref_doc_person_no_fk : '';
    $patient_no_fk = ($ipd_admission) ? $ipd_admission->patient_no_fk : '';


    $IpdAdmissionDetails = (isset($IpdAdmissionDetails) && (!empty($IpdAdmissionDetails))) ? $IpdAdmissionDetails : [];
    $admission_no_pk = ($IpdAdmissionDetails) ? $IpdAdmissionDetails->admission_no_pk : '';
    $pat_condition = ($IpdAdmissionDetails) ? $IpdAdmissionDetails->pat_condition : '';
    $arrival_mode = ($IpdAdmissionDetails) ? $IpdAdmissionDetails->arrival_mode : '';
    $accompanied_by = ($IpdAdmissionDetails) ? $IpdAdmissionDetails->accompanied_by : '';
    $cause_of_admission = ($IpdAdmissionDetails) ? $IpdAdmissionDetails->cause_of_admission : '';
    $contact_person = ($IpdAdmissionDetails) ? $IpdAdmissionDetails->contact_person : '';
    $contact_person_mobile = ($IpdAdmissionDetails) ? $IpdAdmissionDetails->contact_person_mobile : '';
    $contact_relaion = ($IpdAdmissionDetails) ? $IpdAdmissionDetails->contact_relaion : '';
    $ward_no_fk = ($IpdAdmissionDetails) ? $IpdAdmissionDetails->ward_no_fk : '';
    $remarks = ($IpdAdmissionDetails) ? $IpdAdmissionDetails->remarks : '';
    $pat_valuable_accessories = ($IpdAdmissionDetails) ? $IpdAdmissionDetails->pat_valuable_accessories : '';



$admission_data = (isset($admission_data) && (!empty($admission_data))) ? $admission_data : [];
$curr_bed_no = ($admission_data) ? $admission_data->curr_bed_no_fk : '';
$ward_no_pk = ($admission_data) ? $admission_data->new_ward_no_fk : '';
$old_bed = ($admission_data) ? $admission_data->old_bed_no_fk : '';
@endphp
<style>
    .bed {
        text-align: center;

        margin-top: 10px;
        transition: all 0.3s;
    }

    .bed.available {
        border: 1px solid #498739;
    }

    .bed.available .bed-text {
        background-color: #60c57f;
    }

    .bed.occupied {
        border: 1px solid #43464b;
        cursor: not-allowed;
        filter: grayscale(100%) !important;
        opacity: 0.3;
    }

    .bed.occupied .bed-text {
        background-color: #43464b;
    }

    .bed.active {
        border: 1px solid #535673;
    }

    .bed.active .bed-text {
        background-color: #535673;
    }


    .bed-img {
        padding: 10px 10px 0px 10px;

    }

    .bed-text {
        padding: 2px 10px;
        background-color: #60c57f;
        color: #fff;
        margin-top: 15px;
    }

    .bed.not_ready {
        cursor: not-allowed;
    }

    .bed#pat_ocupied {
        background-color: #6cb2eb !important;
    }

    .bed#pat_ocupied .bed-text {
        background-color: #6cb2eb !important;
    }

    .bed.not_ready {
        background-color: yellow !important;
    }

    .bed.not_ready .bed-text {
        background-color: #8c8c00;
    }
</style>

<div class="form-row">

    @if(!empty($data))
        @foreach($data as $ipds_bed)
        {{--            {{ $ipds_bed->su_no_fk.','. $ipds_bed->ward_no_fk.','.$su_no_fk .','.$ward_no_pk  }} <br>--}}
            @if($curr_bed_no !="")

                @if($su_no_fk == $ipds_bed->su_no_fk &&  $ward_no_pk  == $ipds_bed->ward_no_fk)

                    @if($curr_bed_no_fk == $ipds_bed->bed_no_pk )
                        @php
                            if($ipds_bed->bed_status == 1)
                            {
                                $status = "available";

                            }
                            elseif($ipds_bed->bed_status == 2)
                            {
                                $status = "occupied";
                            }
                            elseif($ipds_bed->bed_status == 3)
                            {
                                $status = "not_ready";
                            }

                        @endphp
                        <div class="col-md-3 cursor-pointer" onclick="bedViewer.getBedDetails(this)"
                             id="{{ $ipds_bed->bed_no_pk }}" data-ward="{{ $ipds_bed->ward_no_fk}}" data-su="{{ $ipds_bed->su_no_fk}}" data-status="{{ $ipds_bed->bed_status  }}">
                            <div class="bed {{ $status  }} "
                                 id="{{($ipds_bed->bed_no_pk == $curr_bed_no_fk) ? 'pat_ocupied' : ''}}">
                                <div class="bed-img">
                                    <img src="{{asset('images/hospital-bed.png')}}" class="w-100" alt="">
                                </div>
                                <div class="bed-text">
                                    <b>{{$ipds_bed->bed_name}}</b>
                                </div>
                            </div>
                        </div>
                    @else


                        @php
                            if($ipds_bed->bed_status == 1)
                            {
                                $status = "available";

                            }
                            elseif($ipds_bed->bed_status == 2)
                            {
                                $status = "occupied";
                            }
                            elseif($ipds_bed->bed_status == 3)
                            {
                                $status = "not_ready";
                            }

                        @endphp
                        <div class="col-md-3 cursor-pointer" onclick="bedViewer.getBedDetails(this)"
                             id="{{ $ipds_bed->bed_no_pk }}" data-ward="{{ $ipds_bed->ward_no_fk}}" data-su="{{ $ipds_bed->su_no_fk}}" data-status="{{ $ipds_bed->bed_status  }}">
                            <div class="bed {{ $status  }} "
                                 id="{{($ipds_bed->bed_no_pk == $curr_bed_no_fk) ? 'pat_ocupied' : ''}}">
                                <div class="bed-img">
                                    <img src="{{asset('images/hospital-bed.png')}}" class="w-100" alt="">
                                </div>
                                <div class="bed-text">
                                    <b>{{$ipds_bed->bed_name}}</b>
                                </div>
                            </div>
                        </div>
                    @endif
                @endif
            @else


                @php
                    if($ipds_bed->bed_status == 1)
                    {
                        $status = "available";

                    }
                    elseif($ipds_bed->bed_status == 2)
                    {
                        $status = "occupied";
                    }
                    elseif($ipds_bed->bed_status == 3)
                    {
                        $status = "not_ready";
                    }

                @endphp
                <div class="col-md-3 cursor-pointer" onclick="bedViewer.getBedDetails(this)"
                     id="{{ $ipds_bed->bed_no_pk }}" data-ward="{{ $ipds_bed->ward_no_fk}}" data-su="{{ $ipds_bed->su_no_fk}}" data-status="{{ $ipds_bed->bed_status  }}">
                    <div class="bed {{ $status  }} "
                         id="{{($ipds_bed->bed_no_pk == $curr_bed_no_fk) ? 'pat_ocupied' : ''}}">
                        <div class="bed-img">
                            <img src="{{asset('images/hospital-bed.png')}}" class="w-100" alt="">
                        </div>
                        <div class="bed-text">
                            <b>{{$ipds_bed->bed_name}}</b>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    @else
        <table class="table">
            <tr id="first" class="mt-2">
                <td class="text-center" colspan="5">
                    <img src="{{ asset('images/empty2.png') }}">
                </td>
            </tr>
        </table>

    @endif
</div>



