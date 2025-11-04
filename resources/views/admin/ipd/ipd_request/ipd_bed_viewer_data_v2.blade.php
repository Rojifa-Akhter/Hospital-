@php
    $ipd_admission = isset($ipd) && !empty($ipd) ? $ipd : [];
    $admission_no_pk = $ipd_admission ? $ipd_admission->admission_no_pk : '';
    $admission_uid = $ipd_admission ? $ipd_admission->admission_uid : '';
    $admission_date = $ipd_admission ? $ipd_admission->admission_date : '';
    $primary_doctor_no_fk = $ipd_admission ? $ipd_admission->primary_doctor_no_fk : '';
    $duty_doc_person_no_fk = $ipd_admission ? $ipd_admission->duty_doc_person_no_fk : '';
    $initial_bed_no_fk = $ipd_admission ? $ipd_admission->initial_bed_no_fk : '';
    $curr_bed_no_fk = $ipd_admission ? $ipd_admission->curr_bed_no_fk : '';
    $old_bed_no_fk = $ipd_admission ? $ipd_admission->old_bed_no_fk : '';
    $curr_ward_no_fk = $ipd_admission ? $ipd_admission->curr_ward_no_fk : '';
    $reg_type_no_fk = $ipd_admission ? $ipd_admission->reg_type_no_fk : '';
    $su_no_fk = $ipd_admission ? $ipd_admission->new_su_no_fk : '';
    $prescription_no_fk = $ipd_admission ? $ipd_admission->prescription_no_fk : '';
    $prescription_uid = $ipd_admission ? $ipd_admission->prescription_uid : '';
    $appointment_no_fk = $ipd_admission ? $ipd_admission->appointment_no_fk : '';
    $opd_department_su_no_fk = $ipd_admission ? $ipd_admission->opd_department_su_no_fk : '';
    $opd_department_name = $ipd_admission ? $ipd_admission->opd_department_name : '';
    $status = $ipd_admission ? $ipd_admission->status : '';
    $first_ref_doc_person_no_fk = $ipd_admission ? $ipd_admission->first_ref_doc_person_no_fk : '';
    $second_ref_doc_person_no_fk = $ipd_admission ? $ipd_admission->second_ref_doc_person_no_fk : '';
    $ref_doc_person_no_fk = $ipd_admission ? $ipd_admission->ref_doc_person_no_fk : '';
    $patient_no_fk = $ipd_admission ? $ipd_admission->patient_no_fk : '';

    $IpdAdmissionDetails = isset($IpdAdmissionDetails) && !empty($IpdAdmissionDetails) ? $IpdAdmissionDetails : [];
    $admission_no_pk = $IpdAdmissionDetails ? $IpdAdmissionDetails->admission_no_pk : '';
    $pat_condition = $IpdAdmissionDetails ? $IpdAdmissionDetails->pat_condition : '';
    $arrival_mode = $IpdAdmissionDetails ? $IpdAdmissionDetails->arrival_mode : '';
    $accompanied_by = $IpdAdmissionDetails ? $IpdAdmissionDetails->accompanied_by : '';
    $cause_of_admission = $IpdAdmissionDetails ? $IpdAdmissionDetails->cause_of_admission : '';
    $contact_person = $IpdAdmissionDetails ? $IpdAdmissionDetails->contact_person : '';
    $contact_person_mobile = $IpdAdmissionDetails ? $IpdAdmissionDetails->contact_person_mobile : '';
    $contact_relaion = $IpdAdmissionDetails ? $IpdAdmissionDetails->contact_relaion : '';
    $ward_no_fk = $IpdAdmissionDetails ? $IpdAdmissionDetails->ward_no_fk : '';
    $remarks = $IpdAdmissionDetails ? $IpdAdmissionDetails->remarks : '';
    $pat_valuable_accessories = $IpdAdmissionDetails ? $IpdAdmissionDetails->pat_valuable_accessories : '';

    $admission_data = isset($admission_data) && !empty($admission_data) ? $admission_data : [];
    $curr_bed_no = $admission_data ? $admission_data->curr_bed_no_fk : '';
    $ward_no_pk = $admission_data ? $admission_data->new_ward_no_fk : '';
    $old_bed = $admission_data ? $admission_data->old_bed_no_fk : '';
@endphp

<style>
    .card{
        border-radius: 2%;
    }
    .blink {
    animation: blinker .5s linear infinite;
  }

  @keyframes blinker {
    50% {
      opacity: 0;
    }
    
  }
  .details{
    font-size: 11px !important;
    line-height: 1.2;
 }
</style>
<div class="form-row" >
    {{-- @dd($data) --}}
    @if (isset($data) && !empty($data))

        @foreach ($data as $ipds_bed)
            @if ($ipds_bed->bed_status != '')
                @php
                    $background_color = '';
                    $font_color = '';
                    if ($ipds_bed->admission_no_pk != '' && $ipds_bed->ns_receive_ind == 0) {
                        $background_color = 'background-color:#38C172;';
                        $font_color = 'color:black !important;';
                    } elseif ($ipds_bed->dis_req_ind == 1 && $ipds_bed->dis_ind == 0) {
                        $background_color = 'background-color:#C7FF84;';
                        $font_color = 'color:black !important;';
                    } elseif ($ipds_bed->bed_status == 1) {
                        $background_color = 'background-color:white;';
                        $font_color = 'color:black !important;';
                    } elseif ($ipds_bed->bed_status == 2) {
                        $background_color = 'background-color:#0baefa;';
                        $font_color = 'color:black !important;';
                    } elseif ($ipds_bed->bed_status == 3) {
                        $background_color = 'background-color:#b56dbd;';
                        $font_color = 'color:black !important;';
                    }

                @endphp
               
                <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4" onclick="bedViewer.getBedDetails(this)" id="{{ $ipds_bed->bed_no_pk }}" data-ward="{{ $ipds_bed->ward_no_fk}}" data-su="{{ $ipds_bed->su_no_fk}}" data-status="{{ $ipds_bed->bed_status  }}">
                    <div class="user-card">
                        <div class="card shadow-sm" style="<?= $background_color ?> border:1px dotted black">
                            <div class="card-body text-center">
                                <div style="text-align: left">
                                    <img width="40px" src="{{ asset('images/ipd.png') }}"
                                        class="<?= $ipds_bed->admission_no_pk != '' && $ipds_bed->ns_receive_ind == 0 ? 'blink' : '' ?>">
                                    @if ($ipds_bed->patient_name != '')
                                        <span style="<?= $font_color ?>  font-size:12px" class="">
                                            {{-- {{ !empty($ipds_bed->new_bed_name) ? $ipds_bed->new_bed_name : '' }}/
                                            {{ !empty($ipds_bed->new_ward_name) ? $ipds_bed->new_ward_name : '' }} --}}
                                            {{ !empty($ipds_bed->bed_name) ? $ipds_bed->bed_name : '' }}/
                                            {{ !empty($ipds_bed->ward_name) ? $ipds_bed->ward_name : '' }}
                                        </span>
                                    @else
                                        <span style="<?= $font_color ?>  font-size:12px">
                                            {{ !empty($ipds_bed->bed_name) ? $ipds_bed->bed_name : '' }}/
                                            {{ !empty($ipds_bed->ward_name) ? $ipds_bed->ward_name : '' }}
                                        </span>
                                    @endif

                                </div>
                                <div class="details">

                                    {{-- <strong>Ward Name: {{ !empty($ipds_bed->ward_name) ? $ipds_bed->ward_name : '' }}, Department:
                                {{ !empty($ipds_bed->serviceunit_name) ? $ipds_bed->serviceunit_name : '' }}</strong> --}}
                                 @if($ipds_bed->bed_status == 1 || $ipds_bed->bed_status == 3)

                                 @else
                                    <span style="color: black"> {{ $ipds_bed->patient_name }}</span> <br>
                                    <span style="color: black"> {{ isset($ipds_bed->patient_code) && $ipds_bed->patient_code !="" ? 'UHID :'. $ipds_bed->patient_code :''   }}</span> <br>
                                    <span style="color: black"> {{ isset( $ipds_bed->admission_no_pk) && $ipds_bed->admission_no_pk !="" ? 'IP No : '. $ipds_bed->admission_no_pk :'' }}</span> <br>
                                    <small style="color: black"> {{ isset( $ipds_bed->admission_date) && $ipds_bed->admission_date !="" ? 'Admitted Date : '. date('d/m/Y h:i a',strtotime($ipds_bed->admission_date)) :'' }}</small> <br>                                    
                                    <small style="color: black"> {{ isset( $ipds_bed->primary_doctor_name) && $ipds_bed->primary_doctor_name !="" ? 'Doctor Name : '. $ipds_bed->primary_doctor_name :'' }}</small>
                                 @endif  
                                    <br>
                                    @if ($ipds_bed->admission_no_pk != '' && $ipds_bed->ns_receive_ind == 0)
                                        <strong class="badge blink" style="<?= $font_color ?>">New Admitted</strong>
                                    @elseif($ipds_bed->dis_req_ind == 1)
                                        <strong class="badge " style="<?= $font_color ?>word-wrap: break-word;">On Discharge process</strong>
                                    @elseif ($ipds_bed->bed_status == 1)
                                        <strong class="badge " style="<?= $font_color ?>">Available</strong>
                                    @elseif($ipds_bed->bed_status == 2)
                                        <strong class="badge " style="<?= $font_color ?>">Occupied</strong>
                                    @elseif($ipds_bed->bed_status == 3)
                                        <strong class="badge " style="<?= $font_color ?>">Not Ready</strong>
                                    @endif
                                </div>

                              
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            {{-- @if ($curr_bed_no != '')

                @if ($su_no_fk == $ipds_bed->su_no_fk && $ward_no_pk == $ipds_bed->ward_no_fk)

                    @if ($curr_bed_no_fk == $ipds_bed->bed_no_pk)
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
            @endif --}}
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
