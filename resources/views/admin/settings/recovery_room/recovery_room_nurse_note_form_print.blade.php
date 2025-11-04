<!DOCTYPE html>
<html lang="bn">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>OT Checklist Form</title>
    <link rel="stylesheet" href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}">
    <link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">

    <link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
    <link href="{{ asset('css/redactor.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('asset/timepicker/css/timepicker.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <style>
        @page {
            margin: .5cm .6cm;
            width: 100%;
            height: 100%
        }

        @font-face {
            font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
            font-weight: normal;
            font-size: 10px;
            font-style: normal;
            font-variant: normal;
            src: url("font url");
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        td {
            border: 1px solid #000;
            padding: 12px;
        }

        .no-border {
            border: none !important;
        }

        .center-text {
            text-align: center;
        }

        .bold {
            font-weight: bold;
        }

        footer {
            position: fixed;
            bottom: 0cm;
            left: 0cm;
            right: 0cm;
            height: .7cm;
            text-align: center;
            padding: 0 1cm;
            border-top: 1px solid;
        }


        tfoot tr td {
            font-weight: bold;
        }
    </style>


</head>



<body onload="window.print()">
    <header>
        <table style="width: 100%; border:none;" class="signature">
            <tr>
                <td style="width: 15%; border:none;">
                    <img class="hospital-logo"
                        src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}"
                        width="60" alt="">
                </td>
                <td style="text-align:center; border:none;">
                    <span style="font-size: 15px;"> <strong>
                            {{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }}
                        </strong></span>
                    <br>
                    Address:
                    <span>
                        {{ isset($po_hospital_details->addrress1) ? $po_hospital_details->addrress1 : '' }}</span><br>
                    Phone No:
                    <span>
                        {{ isset($po_hospital_details->telephone1) ? $po_hospital_details->telephone1 : '' }}</span>
                </td>
                <td style=" text-align:right; width: 15%;  border:none;">
                    <div style="">
                        <img src="data:image/png;base64, {{ $barcode_no }} " width="100" />
                    </div>

                </td>
            </tr>
        </table>
    </header>

    <footer style="position: fixed;">
        <div class="footer">
            <div class="container">
                <table style="width: 100%; padding:3px; margin: 0;border:none;">
                    <tr>
                        <td style="font-size: 9px; text-align:left;border:none;">Print Date & Time: <strong>
                                <?php
                                $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
                                $date = $dt->format('g:i A');
                                ?>
                                {{ date('d/m/Y') }} {{ $date }}
                            </strong> Printed By: <strong>{{ Session::get('user.ses_user_name') }}</strong></td>
                        <td style="font-size: 9px; text-align: right; border:none;"><strong>Powered By - H360 [NextGen]
                            </strong></td>
                    </tr>
                </table>
            </div>
        </div>
    </footer>


    <main>
        <div class="nursesNotes__form">
            <form action="" method="post" id="NURSESNOTEFORM">
                @csrf

                <div class="container-fluid mt-5">



                    <table width="100%" border="1" style="margin-bottom: 10px">
                        <tr>
                            <td><strong>UHID:</strong>
                                {{ isset($pat_data->patient_code) ? $pat_data->patient_code : '' }}
                            </td>
                            <td colspan="2"><strong>Patient Name:</strong>
                                {{ isset($pat_data->patient_name) ? $pat_data->patient_name : '' }}
                            </td>
                            {{-- <td><strong>Cabin:</strong>
                                {{ isset($pat_data->new_ward_name) ? $pat_data->new_ward_name : '' }}
                            </td> --}}
                        </tr>
                        <tr>
                            <td colspan="3"><strong>Received at Date & Time:</strong>
                                {{ isset($nurse_info->received_date) ? date('d-m-Y h:i A', strtotime($nurse_info->received_date)) : '' }}

                            </td>
                        </tr>
                        <tr>
                            <td colspan="3"><strong>Transfer out at:</strong>
                                @php
                                    $transfer_out = explode(' ', @$nurse_info->transfer_out);
                                @endphp
                                {{ $transfer_out[1] ?? '' }}
                            </td>

                        </tr>
                        <tr>
                            @php
                                $anesthesiaTypes = json_decode($nurse_info->anesthesia_type ?? '[]', true) ?? [];
                            @endphp

                            <td colspan="3">
                                <strong>Type of anesthesia:</strong>


                                <label>
                                    <input type="checkbox" name="anesthesia_type[]" value="General"
                                        {{ in_array('General', $anesthesiaTypes) ? 'checked' : '' }}>
                                    General
                                </label> &nbsp;

                                <label>
                                    <input type="checkbox" name="anesthesia_type[]" value="Spinal"
                                        {{ in_array('Spinal', $anesthesiaTypes) ? 'checked' : '' }}>
                                    Spinal
                                </label> &nbsp;

                                <label>
                                    <input type="checkbox" name="anesthesia_type[]" value="Epidural"
                                        {{ in_array('Epidural', $anesthesiaTypes) ? 'checked' : '' }}>
                                    Epidural
                                </label> &nbsp;

                                <label>
                                    <input type="checkbox" name="anesthesia_type[]" value="TIVA"
                                        {{ in_array('TIVA', $anesthesiaTypes) ? 'checked' : '' }}>
                                    TIVA
                                </label> &nbsp;

                                <label>
                                    <input type="checkbox" name="anesthesia_type[]" value="LA"
                                        {{ in_array('LA', $anesthesiaTypes) ? 'checked' : '' }}>
                                    LA
                                </label>
                            </td>

                        </tr>
                        <tr>
                            <td colspan="3">
                                <strong>Others:</strong>
                                {{ isset($nurse_info->anesthesia_others) ? $nurse_info->anesthesia_others : '' }}
                            </td>

                        </tr>
                        @php
                            $airwayDevices = json_decode($nurse_info->airway_device ?? '[]', true) ?? [];
                        @endphp

                        <tr>
                            <td colspan="3">
                                <strong>Airway Device:</strong>

                                <label>
                                    <input type="checkbox" name="airway_device[]" value="Nil"
                                        {{ in_array('Nil', $airwayDevices) ? 'checked' : '' }}>
                                    Nil
                                </label> &nbsp;

                                <label>
                                    <input type="checkbox" name="airway_device[]" value="Oral"
                                        {{ in_array('Oral', $airwayDevices) ? 'checked' : '' }}>
                                    Oral
                                </label> &nbsp;

                                <label>
                                    <input type="checkbox" name="airway_device[]" value="Nasal"
                                        {{ in_array('Nasal', $airwayDevices) ? 'checked' : '' }}>
                                    Nasal
                                </label> &nbsp;

                                <label>
                                    <input type="checkbox" name="airway_device[]" value="LMA"
                                        {{ in_array('LMA', $airwayDevices) ? 'checked' : '' }}>
                                    LMA
                                </label> &nbsp;

                                <label>
                                    <input type="checkbox" name="airway_device[]" value="OETT"
                                        {{ in_array('OETT', $airwayDevices) ? 'checked' : '' }}>
                                    OETT
                                </label> &nbsp;

                                <label>
                                    <input type="checkbox" name="airway_device[]" value="NETT"
                                        {{ in_array('NETT', $airwayDevices) ? 'checked' : '' }}>
                                    NETT
                                </label> &nbsp;

                                <label>
                                    <input type="checkbox" name="airway_device[]" value="Tracheostomy"
                                        {{ in_array('Tracheostomy', $airwayDevices) ? 'checked' : '' }}>
                                    Tracheostomy
                                </label>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="3">
                                <strong>Respiration:</strong>
                                {{ isset($nurse_info->respiration) ? $nurse_info->respiration : '' }}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <p><strong>Monitor in Recovery Room Chart (Opposite Leaf):</strong>
                                    Pulse (●), SBP (˅ ), DBP ( ˄) , SpO2, Respiratory rate, Pain score (1-10),
                                    Nausea/Vomiting score (Nil-0, Nausea-1, Vomiting -2), Urine in ml, Drain in
                                    ml (if any),
                                    Level of consciousness (Awake-3, Respond to verbal stimuli-2, Respond to
                                    painful stimuli -1, Not responding-0).</p>
                            </td>

                        </tr>
                    </table> <br>
                    <h3>Medications at Recovery Room</h3>
                    <table width="100%" border="1" style="margin-bottom: 10px" id="medicationsTable">
                        <thead>
                            <tr>
                                <th>Time</th>
                                <th>Drug/Dose/Route</th>
                                <th>Remark</th>

                            </tr>
                        </thead>
                        <tbody>



                            @isset($med_time)
                                @if (is_array($med_time) && count($med_time) > 0)
                                    @foreach ($med_time as $i => $time)
                                        <tr>
                                            <td>{{ $time }}</td>
                                            <td>{{ $med_drug[$i] ?? '' }}</td>
                                            <td>{{ $med_sign[$i] ?? '' }}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            @endisset

                        </tbody>

                    </table> <br>
                    <p><strong>Recovery Events Note (If
                            any):
                        </strong>{{ isset($nurse_info->recovery_events) ? $nurse_info->recovery_events : '' }}
                    </p>


                    <br>
                    <table width="100%" border="1" style="margin-bottom: 10px">
                        <tbody>
                            <tr>
                                <td colspan="4" class="section-title"><strong>Aldrete and Kronlik Modified
                                        Post-Anesthetic Recovery Score</strong></td>
                            </tr>
                            <tr>
                                <td><strong>Consciousness</strong></td>
                                <td><strong>Arrival</strong></td>
                                <td><strong>Consciousness</strong></td>
                                <td><strong>On Discharge</strong></td>
                            </tr>

                            <tr>
                                <td class="text-start">




                                    {{ isset($nurse_info->conscious_rouse_arrival) && $nurse_info->conscious_rouse_arrival == 0 ? ' Not responding' : '' }}



                                    {{ isset($nurse_info->conscious_rouse_arrival) && $nurse_info->conscious_rouse_arrival == 2 ? 'Fully awake' : '' }}



                                    {{ isset($nurse_info->conscious_rouse_arrival) && $nurse_info->conscious_rouse_arrival == 1 ? 'Rousable on calling' : '' }}


                                </td>
                                <td>
                                    {{ isset($nurse_info->conscious_fully_arrival) ? $nurse_info->conscious_fully_arrival : '0' }}
                                </td>
                                <td class="text-start">




                                    {{ isset($nurse_info->conscious_rouse_thirty) && $nurse_info->conscious_rouse_thirty == 0 ? ' Not responding' : '' }}



                                    {{ isset($nurse_info->conscious_rouse_thirty) && $nurse_info->conscious_rouse_thirty == 2 ? 'Fully awake' : '' }}



                                    {{ isset($nurse_info->conscious_rouse_thirty) && $nurse_info->conscious_rouse_thirty == 1 ? 'Rousable on calling' : '' }}


                                </td>
                                <td>
                                    {{ isset($nurse_info->conscious_fully_thirty) ? $nurse_info->conscious_fully_thirty : '0' }}
                                </td>

                            </tr>

                            {{-- Activity --}}
                            <tr>
                                <td colspan="3" class="section-title text-left"><strong> Activity (Able to move
                                        voluntarily or
                                        on command)</strong></td>
                            </tr>

                            <tr>
                                <td class="text-start">



                                    {{ isset($nurse_info->activity_two_arrival) && $nurse_info->activity_two_arrival == 2 ? '4 extremities (Able to Lift head or good hand grip)' : '' }}


                                    {{ isset($nurse_info->activity_two_arrival) && $nurse_info->activity_two_arrival == 1 ? '2 extremities' : '' }}

                                    {{ isset($nurse_info->activity_two_arrival) && $nurse_info->activity_two_arrival == 0 ? '0 extremities' : '' }}



                                </td>
                                <td>
                                    {{ isset($nurse_info->activity_four_arrival) ? $nurse_info->activity_four_arrival : '0' }}
                                </td>
                                <td class="text-start">



                                    {{ isset($nurse_info->activity_two_thirty) && $nurse_info->activity_two_thirty == 2 ? '4 extremities (Able to Lift head or good hand grip)' : '' }}


                                    {{ isset($nurse_info->activity_two_thirty) && $nurse_info->activity_two_thirty == 1 ? '2 extremities' : '' }}

                                    {{ isset($nurse_info->activity_two_thirty) && $nurse_info->activity_two_thirty == 0 ? '0 extremities' : '' }}



                                </td>
                                <td>
                                    {{ isset($nurse_info->activity_four_thirty) ? $nurse_info->activity_four_thirty : '0' }}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" class="section-title text-left"><strong>Respiration</strong></td>
                            </tr>
                            {{-- Respiration --}}
                            <tr>
                                <td class="text-start">



                                    {{ isset($nurse_info->resp_dyspnea_arrival) && $nurse_info->resp_dyspnea_arrival == 0 ? 'Apneic' : '' }}


                                    {{ isset($nurse_info->resp_dyspnea_arrival) && $nurse_info->resp_dyspnea_arrival == 2 ? 'Able to breathe deeply and cough easily' : '' }}


                                    {{ isset($nurse_info->resp_dyspnea_arrival) && $nurse_info->resp_dyspnea_arrival == 1 ? 'Dyspneic or with limited breathing' : '' }}


                                </td>
                                <td>
                                    {{ isset($nurse_info->resp_deep_arrival) ? $nurse_info->resp_deep_arrival : '0' }}
                                </td>
                                <td class="text-start">



                                    {{ isset($nurse_info->resp_dyspnea_thirty) && $nurse_info->resp_dyspnea_thirty == 0 ? 'Apneic' : '' }}


                                    {{ isset($nurse_info->resp_dyspnea_thirty) && $nurse_info->resp_dyspnea_thirty == 2 ? 'Able to breathe deeply and cough easily' : '' }}


                                    {{ isset($nurse_info->resp_dyspnea_thirty) && $nurse_info->resp_dyspnea_thirty == 1 ? 'Dyspneic or with limited breathing' : '' }}


                                </td>
                                <td>
                                    {{ isset($nurse_info->resp_deep_thirty) ? $nurse_info->resp_deep_thirty : '0' }}
                                </td>
                            </tr>

                            {{-- SpO₂ --}}
                            <tr>
                                <td colspan="3" class="section-title text-left"><strong>SpO₂</strong></td>
                            </tr>
                            <tr>
                                <td class="text-start">



                                    {{ isset($nurse_info->spo2_oxygen_arrival) && $nurse_info->spo2_oxygen_arrival == 0 ? ' ≤92% despite O2 supplement' : '' }}



                                    {{ isset($nurse_info->spo2_oxygen_arrival) && $nurse_info->spo2_oxygen_arrival == 1 ? 'Need O2 to maintain ≥92%' : '' }}


                                    {{ isset($nurse_info->spo2_oxygen_arrival) && $nurse_info->spo2_oxygen_arrival == 2 ? ' ≥92% on room air' : '' }}


                                </td>
                                <td>
                                    {{ isset($nurse_info->spo2_room_arrival) ? $nurse_info->spo2_room_arrival : '0' }}
                                </td>
                                <td class="text-start">



                                    {{ isset($nurse_info->spo2_oxygen_thirty) && $nurse_info->spo2_oxygen_thirty == 0 ? ' ≤92% despite O2 supplement' : '' }}



                                    {{ isset($nurse_info->spo2_oxygen_thirty) && $nurse_info->spo2_oxygen_thirty == 1 ? 'Need O2 to maintain ≥92%' : '' }}


                                    {{ isset($nurse_info->spo2_oxygen_thirty) && $nurse_info->spo2_oxygen_thirty == 2 ? ' ≥92% on room air' : '' }}


                                </td>
                                <td>
                                    {{ isset($nurse_info->spo2_room_thirty) ? $nurse_info->spo2_room_thirty : '0' }}
                                </td>
                            </tr>

                            {{-- Blood Pressure --}}
                            <tr>
                                <td colspan="3" class="section-title text-left"> <strong>Blood Pressure</strong>
                                </td>
                            </tr>
                            <tr>

                                <td class="text-start">




                                    {{ isset($nurse_info->bp_fifty_arrival) && $nurse_info->bp_fifty_arrival == 0 ? 'Systolic BP if ± 50% preanesthetic level' : '' }}



                                    {{ isset($nurse_info->bp_fifty_arrival) && $nurse_info->bp_fifty_arrival == 1 ? 'Systolic BP if ± 20% to 50% preanesthetic level' : '' }}


                                    {{ isset($nurse_info->bp_fifty_arrival) && $nurse_info->bp_fifty_arrival == 2 ? ' Systolic BP if ± 20% preanesthetic level' : '' }}


                                </td>
                                <td>
                                    {{ isset($nurse_info->bp_twenty_arrival) ? $nurse_info->bp_twenty_arrival : '0' }}
                                </td>
                                <td class="text-start">




                                    {{ isset($nurse_info->bp_fifty_thirty) && $nurse_info->bp_fifty_thirty == 0 ? 'Systolic BP if ± 50% preanesthetic level' : '' }}



                                    {{ isset($nurse_info->bp_fifty_thirty) && $nurse_info->bp_fifty_thirty == 1 ? 'Systolic BP if ± 20% to 50% preanesthetic level' : '' }}


                                    {{ isset($nurse_info->bp_fifty_thirty) && $nurse_info->bp_fifty_thirty == 2 ? ' Systolic BP if ± 20% preanesthetic level' : '' }}


                                </td>
                                <td>
                                    {{ isset($nurse_info->bp_twenty_thirty) ? $nurse_info->bp_twenty_thirty : '0' }}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4" class="section-title text-left">Total Score at Discharge
                                    with Time</td>


                            </tr>
                            <tr>
                                <td>
                                    @php
                                        $aldrete_arr_time = explode(' ', @$nurse_info->bp_high_arrival);
                                        $aldrete_arr_time_fmt = isset($aldrete_arr_time[1])
                                            ? date('h:i A', strtotime($aldrete_arr_time[1]))
                                            : '';
                                    @endphp
                                    <label><strong>Time:</strong></label>
                                    {{ $aldrete_arr_time_fmt }}
                                </td>


                                <td>
                                    <strong>Total:</strong>
                                    {{ isset($nurse_info->total_arrival) ? $nurse_info->total_arrival : '0' }}
                                </td>


                                <td>
                                    @php
                                        $aldrete_time = explode(' ', @$nurse_info->bp_high_thirty);
                                        $aldrete_time_fmt = isset($aldrete_time[1])
                                            ? date('h:i A', strtotime($aldrete_time[1]))
                                            : '';
                                    @endphp
                                    <label><strong>Time:</strong></label>
                                    {{ $aldrete_time_fmt }}
                                </td>
                                <td>
                                    <strong>Total:</strong>
                                    {{ isset($nurse_info->total_thirtymin) ? $nurse_info->total_thirtymin : '0' }}
                                </td>

                            </tr> <br>
                            <tr>
                                <td colspan="4" class="section-title"><strong>Ramsay Sedation Scale</strong></td>

                            </tr>
                            <tr>
                                <th>Patient Characteristic</th>
                                <th>Arrival</th>
                                <th>Patient Characteristic</th>
                                <th>On Discharge</th>
                            </tr>
                            <tr>
                                <td class="text-start">
                                    {{ isset($nurse_info->rss_awake_cooperative_arrival) && $nurse_info->rss_awake_cooperative_arrival == 1 ? 'Awake; agitated or restless or both' : '' }}
                                    {{ isset($nurse_info->rss_awake_cooperative_arrival) && $nurse_info->rss_awake_cooperative_arrival == 2 ? 'Awake; cooperative, oriented, and tranquil' : '' }}
                                    {{ isset($nurse_info->rss_awake_cooperative_arrival) && $nurse_info->rss_awake_cooperative_arrival == 3 ? 'Awake but responds to commands only' : '' }}
                                    {{ isset($nurse_info->rss_awake_cooperative_arrival) && $nurse_info->rss_awake_cooperative_arrival == 4 ? 'Asleep; brisk response to light glabellar tap or loud auditory stimulus' : '' }}
                                    {{ isset($nurse_info->rss_awake_cooperative_arrival) && $nurse_info->rss_awake_cooperative_arrival == 5 ? 'Asleep; sluggish response to light glabellar tap or loud auditory stimulus' : '' }}
                                    {{ isset($nurse_info->rss_awake_cooperative_arrival) && $nurse_info->rss_awake_cooperative_arrival == 6 ? 'Asleep; no response to glabellar tap or loud auditory stimulus' : '' }}


                                </td>
                                <td>
                                    {{ isset($nurse_info->rss_awake_agitated_arrival) ? $nurse_info->rss_awake_agitated_arrival : '0' }}

                                <td class="text-start">
                                    {{ isset($nurse_info->rss_awake_cooperative_thirty) && $nurse_info->rss_awake_cooperative_thirty == 1 ? 'Awake; agitated or restless or both' : '' }}
                                    {{ isset($nurse_info->rss_awake_cooperative_thirty) && $nurse_info->rss_awake_cooperative_thirty == 2 ? 'Awake; cooperative, oriented, and tranquil' : '' }}
                                    {{ isset($nurse_info->rss_awake_cooperative_thirty) && $nurse_info->rss_awake_cooperative_thirty == 3 ? 'Awake but responds to commands only' : '' }}
                                    {{ isset($nurse_info->rss_awake_cooperative_thirty) && $nurse_info->rss_awake_cooperative_thirty == 4 ? 'Asleep; brisk response to light glabellar tap or loud auditory stimulus' : '' }}
                                    {{ isset($nurse_info->rss_awake_cooperative_thirty) && $nurse_info->rss_awake_cooperative_thirty == 5 ? 'Asleep; sluggish response to light glabellar tap or loud auditory stimulus' : '' }}
                                    {{ isset($nurse_info->rss_awake_cooperative_thirty) && $nurse_info->rss_awake_cooperative_thirty == 6 ? 'Asleep; no response to glabellar tap or loud auditory stimulus' : '' }}


                                </td>
                                <td>
                                    {{ isset($nurse_info->rss_awake_agitated_thirty) ? $nurse_info->rss_awake_agitated_thirty : '0' }}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4" class="section-title text-left">Score at Discharge With Time</td>

                            </tr>
                            <tr>
                                <td>
                                    @php
                                        $ramsay_arr_time = explode(' ', @$nurse_info->rss_commands_30);
                                        $ramsay_arr_time_fmt = isset($ramsay_arr_time[1])
                                            ? date('h:i A', strtotime($ramsay_arr_time[1]))
                                            : '';
                                    @endphp
                                    <label><strong>Time:</strong></label>
                                    {{ $ramsay_arr_time_fmt }}
                                </td>

                                <td><label for=""><strong>Total:</strong></label>
                                    {{ isset($nurse_info->ramsay_arrival_total) ? $nurse_info->ramsay_arrival_total : '0' }}
                                </td>


                                <td>
                                    @php
                                        $ramsay_time = explode(' ', @$nurse_info->rss_commands_arr);
                                        $ramsay_time_fmt = isset($ramsay_time[1])
                                            ? date('h:i A', strtotime($ramsay_time[1]))
                                            : '';
                                    @endphp
                                    <label><strong>Time:</strong></label>
                                    {{ $ramsay_time_fmt }}
                                </td>
                                <td>
                                    <label for=""><strong>Total:</strong></label>
                                    {{ isset($nurse_info->ramsay_thirtymin_total) ? $nurse_info->ramsay_thirtymin_total : '0' }}
                                </td>
                            </tr> <br> <br>

                            <tr>
                                <td colspan="4" class="section-title"><strong>Modified Bromage Score</strong></td>


                            </tr>
                            <tr>
                                <th>Patient Characteristic</th>
                                <th>Arrival</th>
                                <th>Patient Characteristic</th>
                                <th>On Discharge</th>
                            </tr>

                            <tr>
                                <td class="text-start">

                                    {{ isset($nurse_info->bromage_almost_arr) && $nurse_info->bromage_almost_arr == 1 ? 'Complete Motor block; Unable to move feet or knees' : '' }}
                                    {{ isset($nurse_info->bromage_almost_arr) && $nurse_info->bromage_almost_arr == 2 ? 'Almost Complete Block; Only able to move feet; unable to flex knees' : '' }}
                                    {{ isset($nurse_info->bromage_almost_arr) && $nurse_info->bromage_almost_arr == 3 ? 'Partial Block Remains; Just able to flex knees with free movement of feet' : '' }}
                                    {{ isset($nurse_info->bromage_almost_arr) && $nurse_info->bromage_almost_arr == 4 ? 'No Residual Motor block; full flexion of knee and feet' : '' }}



                                </td>
                                <td>
                                    {{ isset($nurse_info->bromage_complete_arr) ? $nurse_info->bromage_complete_arr : '0' }}
                                </td>
                                <td class="text-start">

                                    {{ isset($nurse_info->bromage_discharge) && $nurse_info->bromage_discharge == 1 ? 'Complete Motor block; Unable to move feet or knees' : '' }}
                                    {{ isset($nurse_info->bromage_discharge) && $nurse_info->bromage_discharge == 2 ? 'Almost Complete Block; Only able to move feet; unable to flex knees' : '' }}
                                    {{ isset($nurse_info->bromage_discharge) && $nurse_info->bromage_discharge == 3 ? 'Partial Block Remains; Just able to flex knees with free movement of feet' : '' }}
                                    {{ isset($nurse_info->bromage_discharge) && $nurse_info->bromage_discharge == 4 ? 'No Residual Motor block; full flexion of knee and feet' : '' }}



                                </td>
                                <td>{{ isset($nurse_info->bromage_complete_30) ? $nurse_info->bromage_complete_30 : '0' }}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4" class="section-title text-left">Score at Discharge With Time</td>

                            </tr>

                            <tr>
                                <td>
                                    @php
                                        $bromage_arr_time = explode(' ', @$nurse_info->bromage_partial_30);
                                        $bromage_arr_time_fmt = isset($bromage_arr_time[1])
                                            ? date('h:i A', strtotime($bromage_arr_time[1]))
                                            : '';
                                    @endphp
                                    <label><strong>Time:</strong></label>
                                    {{ $bromage_arr_time_fmt }}
                                </td>


                                <td><label for=""><strong>Total:</strong></label>
                                    {{ isset($nurse_info->bromage_arrival_total) ? $nurse_info->bromage_arrival_total : '0' }}
                                </td>
                                <td>
                                    @php
                                        $bromage_time = explode(' ', @$nurse_info->bromage_partial_arr);
                                        $time_12h = isset($bromage_time[1])
                                            ? date('h:i A', strtotime($bromage_time[1]))
                                            : '';
                                    @endphp
                                    <label><strong>Time:</strong></label>
                                    {{ $time_12h }}
                                </td>


                                <td><label for=""><strong>Total:</strong></label>
                                    {{ isset($nurse_info->bromage_thirtymin_total) ? $nurse_info->bromage_thirtymin_total : '0' }}
                                </td>
                            </tr>

                        </tbody>


                    </table>




                </div>


            </form>
        </div>

    </main>





</body>

</html>
