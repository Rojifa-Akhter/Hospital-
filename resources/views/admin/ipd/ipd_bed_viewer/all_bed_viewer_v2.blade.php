<style>
    .card {
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
</style>

<div class="form-row">
    @php
        $new_admited = 0;
        $on_discharge_process = 0;
        $available = 0;
        $occupied = 0;
        $not_ready = 0;
    @endphp

    @if (!empty($ipds_bed))
        @foreach ($ipds_bed as $data)
            @if ($data->bed_status != '')
                @php
                    $background_color = '';
                    $font_color = '';
                    if ($data->admission_no_pk != '' && $data->ns_receive_ind == 0) {
                        $background_color = 'background-color:#38C172;';
                        $font_color = 'color:black !important;';
                    } elseif ($data->dis_req_ind == 1 && $data->dis_ind == 0) {
                        $background_color = 'background-color:#C7FF84;';
                        $font_color = 'color:black !important;';
                    } elseif ($data->bed_status == 1) {
                        $background_color = 'background-color:white;';
                        $font_color = 'color:black !important;';
                    } elseif ($data->bed_status == 2) {
                        $background_color = 'background-color:#0baefa;';
                        $font_color = 'color:black !important;';
                    } elseif ($data->bed_status == 3) {
                        $background_color = 'background-color:#b56dbd;';
                        $font_color = 'color:black !important;';
                    }

                @endphp

                <div class="col-sm-12 col-md-4 col-lg-2 col-xl-2">
                    <div class="user-card">
                        <div class="card shadow-sm" style="<?= $background_color ?> border:1px dotted black">
                            <div class="card-body text-center">
                                <div style="text-align: left">
                                    <img width="40px" src="{{ asset('images/ipd.png') }}"
                                        class="<?= $data->admission_no_pk != '' && $data->ns_receive_ind == 0 ? 'blink' : '' ?>">
                                    @if ($data->patient_name != '')
                                        <span style="<?= $font_color ?>  font-size:12px" class="">
                                            {{ !empty($data->new_bed_name) ? $data->new_bed_name : '' }}/
                                            {{ !empty($data->new_ward_name) ? $data->new_ward_name : '' }}
                                        </span>
                                    @else
                                        <span style="<?= $font_color ?>  font-size:12px">
                                            {{ !empty($data->bed_name) ? $data->bed_name : '' }}/
                                            {{ !empty($data->ward_name) ? $data->ward_name : '' }}
                                        </span>
                                    @endif

                                </div>
                                <div class="details">
                                    {{-- @dd($ipds_bed) --}}
                                    {{-- <strong>Ward Name: {{ !empty($data->ward_name) ? $data->ward_name : '' }}, Department:
                                        {{ !empty($data->serviceunit_name) ? $data->serviceunit_name : '' }}</strong> --}}
                                    <span style="color: black"> {{ $data->patient_name }}</span> <br>
                                    <span style="color: black">
                                        {{ $data->patient_code != '' ? 'UHID :' . $data->patient_code : '' }}</span> <br>
                                    <span style="color: black">
                                        {{ $data->admission_no_pk != '' ? 'IP No : ' . $data->admission_no_pk : '' }}</span>
                                    <br>
                                    <small style="color: black">
                                        {{ $data->admission_date != '' ? 'Admitted Date : ' . date('d/m/Y h:i a', strtotime($data->admission_date)) : '' }}</small>
                                    <br>
                                    <small style="color: black">
                                        {{ $data->primary_doctor_name != '' ? 'Doctor Name : ' . $data->primary_doctor_name : '' }}</small>
                                    <br>


                                    @if ($data->admission_no_pk != '' && $data->ns_receive_ind == 0)
                                        <strong class="badge blink" style="<?= $font_color ?>">New Admitted</strong>
                                        @php $new_admited +=1; @endphp
                                    @elseif($data->dis_req_ind == 1)
                                        <strong class="badge " style="<?= $font_color ?>">On Discharge process</strong>
                                        @php $on_discharge_process +=1; @endphp
                                    @elseif ($data->bed_status == 1)
                                        <strong class="badge " style="<?= $font_color ?>">Available</strong>
                                        @php $available +=1; @endphp
                                    @elseif($data->bed_status == 2)
                                        <strong class="badge " style="<?= $font_color ?>">Occupied</strong>
                                        @php $occupied +=1; @endphp


                                        <a href="{{ route('ipd.admission-print-pdf','') }}/{{ $data->admission_no_pk }}"
                                            class="btn btn-outline-primary btn-sm bg-none cursor-pointer mr-1"
                                            target="_blank"
                                            data-id="{{ route('ipd.admission-print-pdf','') }}/{{ $data->admission_no_pk }}" id="admission_id"
                                            title="Admission request form"><i class="fa fa-file-pdf"></i></a>

                                        <a href="{{ route('ipd.admission-label-print','') }}/{{ $data->admission_no_pk }}"
                                            target="_blank"
                                            class="btn btn-outline-primary btn-sm bg-none cursor-pointer"
                                            data-id="{{ route('ipd.admission-label-print','') }}/{{ $data->admission_no_pk }}" id="admission_id" title="label Print"><i
                                                class="fa fa-tag"></i></a>

                                        <a target="_blank" Class="btn btn-sm btn-info ml-2" 
                                            href="{{ route('uhl.wristband-ipd-print','') }}/{{ $data->admission_no_pk }}" 
                                            title="Wristband IPD" data-title="Wristband IPD " target="_blank"><i class="fas fa-band-aid" ></i></a>

                                    @elseif($data->bed_status == 3)
                                        <strong class="badge " style="<?= $font_color ?>">Not Ready</strong>
                                        @php $not_ready +=1; @endphp
                                    @endif
                                    @php

                                    @endphp
                                </div>

                                <div class="actions">
                                    <div class="btn-group btn-block">
                                        @if ($data->ns_receive_ind == 0 && $data->admission_no_pk !='')
                                           
                                             <button type="button" onclick="receivedPatient({{ $data->admission_no_pk }}, {{ $data->patient_no_fk }})"
                                            class="btn btn-sm btn-primary mr-1" Title="Receive Patient">Receive</button>

                                            <a href="{{ route('ipd.admission-print-pdf','') }}/{{ $data->admission_no_pk }}"
                                                class="btn btn-outline-primary btn-sm bg-none cursor-pointer mr-1"
                                                target="_blank"
                                                data-id="{{ route('ipd.admission-print-pdf','') }}/{{ $data->admission_no_pk }}" id="admission_id"
                                                title="Admission request form"><i class="fa fa-file-pdf"></i></a>

                                            <a href="{{ route('ipd.admission-label-print','') }}/{{ $data->admission_no_pk }}"
                                                target="_blank"
                                                class="btn btn-outline-primary btn-sm bg-none cursor-pointer"
                                                data-id="{{ route('ipd.admission-label-print','') }}/{{ $data->admission_no_pk }}" id="admission_id" title="label Print"><i
                                                    class="fa fa-tag"></i></a>

                                            <a target="_blank" Class="btn btn-sm btn-info ml-2" 
                                                href="{{ route('uhl.wristband-ipd-print','') }}/{{ $data->admission_no_pk }}" 
                                                title="Wristband IPD" data-title="Wristband IPD " target="_blank"><i class="fas fa-band-aid" ></i></a>

                                        @elseif($data->admission_no_pk =='')
                                           
                                        @else                                           
                                            <button type="button" class="btn btn-sm btn-primary mr-1" Title="Received Patient">Received</button>
                                        @endif
                                      
                                        

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    @endif

    @php
        $color_code =
            '<span style="color:#38C172"> New Admitted : ( ' .
            $new_admited .
            ' ) </span> , <span style="color:#a0df55"> On Discharge process : ( ' .
            $on_discharge_process .
            ' )</span> , <span style="color:#white"> Available : ( ' .
            $available .
            ' ) </span> , <span style="color:#0baefa"> Occupied : ( ' .
            $occupied .
            ' )</span> , <span style="color:#b56dbd"> Not Ready : ( ' .
            $not_ready .
            ' )</span>';

    @endphp
    <input type="hidden" name="color_code" id="color_code" value="{{ $color_code }}">
</div>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(document).ready(function() {
        $('#top-action1').html($('#color_code').val());
    });

    function receivedPatient(admissionNoPk, patient_no_fk) {

        if (confirm("Are you sure?")) {
            let nurse_station_no = $('#nurse_station').val();
            $.ajax({
                url: "{{ route('v2.ipd.nurse-station-received-patient-update') }}",
                method: "post",
                data: {
                    admission_no_pk: admissionNoPk,
                    patient_no_fk: patient_no_fk,
                    nurse_station_no: nurse_station_no,
                },
                beforeSend: function() {
                    blockUI();
                },
                success: function(response) {
                    bedFunc.bedListDataV2();
                    $('.common-modal-notify').modal('show');
                    $('.common-modal-notify .modal-title').html('Success');
                    $('.common-modal-notify .modal-body').html(response.message);
                },
                error: function(err) {
                    var error = err.responseJSON;
                    $('.common-modal-notify-error').modal('show');
                    $('.common-modal-notify-error .modal-title').html('Failed');
                    $('.common-modal-notify-error .modal-body').html(error.message);
                },
                complete: function() {
                    $.unblockUI();
                }
            })
        }
    }
</script>
