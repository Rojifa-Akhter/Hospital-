<!DOCTYPE html>
<html lang="bn">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Nursing Assessment(Emergency)</title>
    <style>
        .fs-12 {
            font-size: 14px;
        }

        .table {
            border-collapse: collapse;
            width: 100%;
        }

        .table-bordered {
            border: 1px solid #333;
        }

        td {
            font-size: 13px;
            border: 1px solid #333;
            padding-right: 3px;
        }


        .form-check {
            position: relative;
            display: block;
            padding-left: 1.25rem;
        }

        .form-check-inline {
            display: inline-block !important;
            margin-right: 1rem;
        }

        .form-check-input {
            position: static;
            margin-top: 0.3rem;
            margin-left: -1.25rem;
        }

        .form-check-label {
            margin-bottom: 0px !important;
        }

        .w-16 {
            width: 16%;
        }

        .w-8 {
            width: 8%;
        }

        .w-15 {
            width: 15%;
        }

        .w-25 {
            width: 25%;
        }

        .text-left {
            text-align: left;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .header>tbody>tr>td {
            border: none;
        }

        body {
            margin-bottom: 0.6cm;
            margin-left: 1cm;
        }

        .footer-table {
            margin-top: 10px;
        }

        td {
            page-break-inside: avoid
        }
    </style>
</head>

<body onload="window.print()">

    <table class="table header">
        <tbody>
            <tr>
                <td style="width:65%">
                    <ul style="list-style: none; padding-left: 0; display:inline-block;">
                        <li><b>IP
                                No:</b>&nbsp;<span>{{ isset($admission_info->admission_no_pk) ? $admission_info->admission_no_pk : '' }}</span>
                        </li>
                        <li><img style="" src="data:image/png;base64, {{ $invoice_barcode }} "></li>
                        <li><span><b>Name: </b>{{ isset($patient_info->patient_name) ? $patient_info->patient_name : '' }}</span>
                            &nbsp;<span><b>Age:</b>{{ isset($patient_info->age) ? $patient_info->age : '' }}</span>
                            &nbsp;<b>Gender: </b><span>{{ isset($patient_info->gender_txt) ? $patient_info->gender_txt : '' }}</span>
                            &nbsp;<b>Bed:</b>&nbsp;<span>{{ isset($admission_info->bed_name) ? $admission_info->bed_name : '' }}</span>
                        </li>
                        <li><b>Con. Number :</b>&nbsp;<span>{{ $patient_info->mobile1 }}</span></li>
                        <li><b>Consultant Name:</b>&nbsp;<span>{{ $admission_info->primary_doctor_name }}</span></li>
                    </ul>
                </td>
                <td style="text-align:right;width:35%">
                    <ul style="list-style: none; padding-left: 0;">
                        <li><b>UHID:</b>&nbsp;<span>{{ isset($patient_info->patient_code) ? $patient_info->patient_code : '' }}</span>
                        </li>
                        <li><img style="" src="data:image/png;base64, {{ $pat_barcode }} "></li>
                        <li><b>Phone:</b>&nbsp;<span>{{ isset($patient_info->mobile1) ? $patient_info->mobile1 : '' }}</span>
                        </li>
                        <li><b>IP
                                Date:</b>&nbsp;<span>{{ date('d/m/Y h:i a', strtotime($admission_info->admission_date)) }}</span>
                        </li>
                        @if (!empty($admission_info->dis_datetime))
                            <li><b>Date of
                                    Discharge:</b>&nbsp;<span>{{ date('d/m/Y h:i a', strtotime($admission_info->dis_datetime)) }}</span>
                            </li>
                        @endif

                    </ul>
                </td>
            </tr>
        </tbody>
    </table>
    <div
        style="padding: 7px; border-top:1px dotted black; border-bottom:1px dotted black;text-align:center;margin-top:10px; margin-bottom:20px">
        <span style="font-size: 16px;text-transform:uppercase"><b>Nursing Assessment(Emergency)</b></span>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <td class="text-left border-right-0" colspan="1">Date: </td>
                    <td colspan="1">{{@$data->date_of_asses ? date('d-m-Y', strtotime($data->date_of_asses)): date('d-m-Y')}}</td>
                    <td class="text-left border-left-0" colspan="2" >Time of Arrival:</td>
                    @php  $time_of_arrival = explode(" ", @$data->time_of_arrival); @endphp
                    <td class="text-left border-left-0" colspan="1" >{{@$time_of_arrival[1] ? date('h:i a', strtotime($time_of_arrival[1])) : ""}}</td>
                    <td class="text-left border-left-0" colspan="2">Means of Arrival:</td>
                    <td class="text-left border-left-0" colspan="4">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="arrival_type" id="arrival_type1" value="1" {{@$data->arrival_type == 1 ? 'checked' : ''}}>
                            <label class="form-check-label" for="arrival_type1">Walking</label>
                          </div>

                          <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="arrival_type" id="arrival_type2" value="2" {{@$data->arrival_type == 2 ? 'checked' : ''}}>
                            <label class="form-check-label" for="arrival_type2">Wheelchair</label>
                          </div>

                          <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="arrival_type" id="arrival_type3" value="3" {{@$data->arrival_type == 3 ? 'checked' : ''}}>
                            <label class="form-check-label" for="arrival_type3">Stretcher</label>
                          </div>

                          <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="arrival_type" id="arrival_type4" value="4" {{@$data->arrival_type == 4 ? 'checked' : ''}}>
                            <label class="form-check-label" for="arrival_type4">Lap</label>
                          </div>

                    </td>
                </tr>
                <tr>
                    <td colspan="5" class="text-left"><b>TRIAGING:</b></td>
                    <td colspan="1">
                        <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="triaging_p1" id="triaging_p1" value="1" {{@$data->triaging_p1 == 1 ? 'checked' : ''}}>
                        <label class="form-check-label" for="triaging_p1">P1</label>
                      </div>
                    </td>
                    <td colspan="2"><div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="triaging_p2" id="triaging_p2" value="2" {{@$data->triaging_p2 == 2 ? 'checked' : ''}}>
                        <label class="form-check-label" for="triaging_p2">P2</label>
                      </div></td>
                    <td colspan="1"><div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="triaging_p3" id="triaging_p3" value="3" {{@$data->triaging_p3 == 3 ? 'checked' : ''}}>
                        <label class="form-check-label" for="triaging_p3">P3</label>
                      </div></td>
                    <td colspan="2" class="text-left"><div class="form-check form-check-inline ">
                        <input class="form-check-input" type="checkbox" name="triaging_p4" id="triaging_p4" value="4" {{@$data->triaging_p4 == 4 ? 'checked' : ''}}>
                        <label class="form-check-label" for="triaging_p4">P4</label>
                      </div></td>
                </tr>
                <tr>
                    <td colspan="5" ><b>COMMUNICABLE DISEASE TRIAGING</b></td>
                    <td colspan="6" ><b>CLINICAL INDICATORS FOR TRIAGING</b></td>
                </tr>
                <tr>
                   <td colspan="5" style="vertical-align: top">
                        <table class="table table-bordered">
                            <tr>
                                <td style="width:80%" class="text-left">
                                    Patient presents Fever with Rash /Cough/Respiratory Distress/Any bleeding manifestation/Intense Headache/Extreme Fatigue. If yes, collect the following epidemiological history
                                </td>
                                <td>
                                    {{@$data->comm_disease_triage_ind == 1 ? 'No' : ''}}
                                    {{@$data->comm_disease_triage_ind == 2 ? 'Yes' : ''}}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    Epidemiological history: {{@$data->comm_disease_triage_history}}
                                </td>
                            </tr>
                            <tr>
                                <td style="width:80%" class="text-left">
                                    History of Travel to endemic areas (within the past 3 weeks)
                                </td>
                                <td >
                                    {{@$data->epi_history_of_travel_ind == 1 ? 'No' : ''}}
                                    {{@$data->epi_history_of_travel_ind == 2 ? 'Yes' : ''}}
                                </td>
                            </tr>
                            <tr>
                                <td style="width:80%" class="text-left">
                                    Close contact with anyone with same symptoms at home, work or your friends
                                </td>
                                <td>
                                   {{@$data->epi_close_contact_any_ind == '1' ? 'No' : ''}}
                                   {{@$data->epi_close_contact_any_ind == '2' ? 'Yes' : ''}}
                                </td>
                            </tr>
                            <tr>
                                <td style="width:80%" class="text-left">
                                    Healthcare worker with recent exposure to a highly communicable disease
                                </td>
                                <td>
                                    {{@$data->epi_healthc_worker_com_ind == 1 ? 'No' : ''}}
                                    {{@$data->epi_healthc_worker_com_ind == 2 ? 'Yes' : ''}}

                                </td>
                            </tr>
                            <tr>
                                <td style="width:80%" class="text-left">
                                    Close contact with animals (Pets / Livestock & their handlers)
                                    *If any of the above Epidemiological history is yes, inform on duty medical officer and shift the patient to isolation room.

                                </td>
                                <td>
                                    {{@$data->epi_close_contact_animal_ind == '1' ? 'No' : ''}}
                                    {{@$data->epi_close_contact_animal_ind == '2' ? 'Yes' : ''}}

                                </td>
                            </tr>
                        </table>
                   </td>
                   <td colspan="6" style="vertical-align: top;">
                        <table class="table table-bordered">
                            <tr>
                                <td><b>P1 RED-0 min </b></td>
                                <td><b>P2 ORANGE-5 min </b></td>
                                <td><b>P3 YELLOW-30 min </b></td>
                                <td><b>P4 GREEN-60 min </b></td>
                            </tr>
                            <tr>
                                <td class="text-left" style="vertical-align: top;">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="cli_ind_p1_airway" id="cli_ind_p1_airway" value="1" {{@$data->cli_ind_p1_airway == '1' ? 'checked' : ''}}>
                                        <label class="form-check-label" for="cli_ind_p1_airway">Airway compromise</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="cli_ind_p1_respiratory" id="cli_ind_p1_respiratory" value="2" {{@$data->cli_ind_p1_respiratory == '2' ? 'checked' : ''}}>
                                        <label class="form-check-label" for="cli_ind_p1_respiratory">Respiratory arrest</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="cli_ind_p1_cardiac" id="cli_ind_p1_cardiac" value="3" {{@$data->cli_ind_p1_cardiac == '3' ? 'checked' : ''}}>
                                        <label class="form-check-label" for="cli_ind_p1_cardiac">Cardiac arrest</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="cli_ind_p1_major_trauma" id="cli_ind_p1_major_trauma" value="4" {{@$data->cli_ind_p1_major_trauma == '4' ? 'checked' : ''}}>
                                        <label class="form-check-label" for="cli_ind_p1_major_trauma">Major trauma</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="cli_ind_p1_unres_patient" id="cli_ind_p1_unres_patient" value="5" {{@$data->cli_ind_p1_unres_patient == '5' ? 'checked' : ''}}>
                                        <label class="form-check-label" for="cli_ind_p1_unres_patient">unresponsive patient (GCS<8)</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="cli_ind_p1_ong_seizure" id="cli_ind_p1_ong_seizure" value="6" {{@$data->cli_ind_p1_ong_seizure == '6' ? 'checked' : ''}}>
                                        <label class="form-check-label" for="cli_ind_p1_ong_seizure">Ongoing seizure</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="cli_ind_p1_major_burns" id="cli_ind_p1_major_burns" value="7" {{@$data->cli_ind_p1_major_burns == '7' ? 'checked' : ''}}>
                                        <label class="form-check-label" for="cli_ind_p1_major_burns">Major burns</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="cli_ind_p1_major_bleed" id="cli_ind_p1_major_bleed" value="8" {{@$data->cli_ind_p1_major_bleed == '8' ? 'checked' : ''}}>
                                        <label class="form-check-label" for="cli_ind_p1_major_bleed">Major bleeding</label>
                                    </div>
                                </td>
                                <td class="text-left" style="vertical-align: top;">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="cli_ind_p2_resp_dist" id="cli_ind_p2_resp_dist" value="1" {{@$data->cli_ind_p2_resp_dist == '1' ? 'checked' : ''}}>
                                        <label class="form-check-label" for="cli_ind_p2_resp_dist">Respiratory distress</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="cli_ind_p2_circ_com" id="cli_ind_p2_circ_com" value="2" {{@$data->cli_ind_p2_circ_com == '2' ? 'checked' : ''}}>
                                        <label class="form-check-label" for="cli_ind_p2_circ_com">Circulatory compromise</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="cli_ind_p2_cardiac_sou" id="cli_ind_p2_cardiac_sou" value="3" {{@$data->cli_ind_p2_cardiac_sou == '3' ? 'checked' : ''}}>
                                        <label class="form-check-label" for="cli_ind_p2_cardiac_sou">Cardiac sounding chest pain</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="cli_ind_p2_acute_drow" id="cli_ind_p2_acute_drow" value="4" {{@$data->cli_ind_p2_acute_drow == '4' ? 'checked' : ''}}>
                                        <label class="form-check-label" for="cli_ind_p2_acute_drow">Acute drowsiness (GCS 9-13)</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="cli_ind_p2_severe_pain" id="cli_ind_p2_severe_pain" value="5" {{@$data->cli_ind_p2_severe_pain == '5' ? 'checked' : ''}}>
                                        <label class="form-check-label" for="cli_ind_p2_severe_pain">Severe pain</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="cli_ind_p2_suspected" id="cli_ind_p2_suspected" value="6" {{@$data->cli_ind_p2_suspected == '6' ? 'checked' : ''}}>
                                        <label class="form-check-label" for="cli_ind_p2_suspected">Suspected sepsis</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="cli_ind_p2_dangerous" id="cli_ind_p2_dangerous" value="7" {{@$data->cli_ind_p2_dangerous == '7' ? 'checked' : ''}}>
                                        <label class="form-check-label" for="cli_ind_p2_dangerous">Dangerous mechanism of injury</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="cli_ind_p2_open_frac" id="cli_ind_p2_open_frac" value="8" {{@$data->cli_ind_p2_open_frac == '8' ? 'checked' : ''}}>
                                        <label class="form-check-label" for="cli_ind_p2_open_frac">Open fractures</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="cli_ind_p2_acute_stro" id="cli_ind_p2_acute_stro" value="9" {{@$data->cli_ind_p2_acute_stro == '9' ? 'checked' : ''}}>
                                        <label class="form-check-label" for="cli_ind_p2_acute_stro">Acute stroke</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="cli_ind_p2_suspected1" id="cli_ind_p2_suspected1" value="10" {{@$data->cli_ind_p2_suspected1 == '10' ? 'checked' : ''}}>
                                        <label class="form-check-label" for="cli_ind_p2_suspected1">Suspected DKA</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="cli_ind_p2_meningococcal" id="cli_ind_p2_meningococcal" value="11" {{@$data->cli_ind_p2_meningococcal == '11' ? 'checked' : ''}}>
                                        <label class="form-check-label" for="cli_ind_p2_meningococcal">Meningococcal sepsis</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="cli_ind_p2_violent" id="cli_ind_p2_violent" value="12" {{@$data->cli_ind_p2_violent == '12' ? 'checked' : ''}}>
                                        <label class="form-check-label" for="cli_ind_p2_violent">Violent or aggressive patients</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="cli_ind_p2_hypoglycemia" id="cli_ind_p2_hypoglycemia" value="13" {{@$data->cli_ind_p2_hypoglycemia == '13' ? 'checked' : ''}}>
                                        <label class="form-check-label" for="cli_ind_p2_hypoglycemia">Hypoglycemia</label>
                                    </div>
                                </td>
                                <td class="text-left" style="vertical-align: top;">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="cli_ind_p3_abc_normal" id="cli_ind_p3_abc_normal" value="1" {{@$data->cli_ind_p3_abc_normal == '1' ? 'checked' : ''}}>
                                        <label class="form-check-label" for="cli_ind_p3_abc_normal">ABC Normal</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="cli_ind_p3_gcs_14" id="cli_ind_p3_gcs_14" value="2" {{@$data->cli_ind_p3_gcs_14 == 2 ? 'checked' : ''}}>
                                        <label class="form-check-label" for="cli_ind_p3_gcs_14">GCS 14-15</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="cli_ind_p3_minor_bleed" id="cli_ind_p3_minor_bleed" value="3" {{@$data->cli_ind_p3_minor_bleed == '3' ? 'checked' : ''}}>
                                        <label class="form-check-label" for="cli_ind_p3_minor_bleed">Minor bleeding</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="cli_ind_p3_moderate_pain" id="cli_ind_p3_moderate_pain" value="4" {{@$data->cli_ind_p3_moderate_pain == '4' ? 'checked' : ''}}>
                                        <label class="form-check-label" for="cli_ind_p3_moderate_pain">Moderate pain</label>
                                    </div>
                                </td>
                                <td class="text-left" style="vertical-align: top;">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="cli_ind_p4_mild_pain" id="cli_ind_p4_mild_pain" value="1" {{@$data->cli_ind_p4_mild_pain == '1' ? 'checked' : ''}}>
                                        <label class="form-check-label" for="cli_ind_p4_mild_pain">Mild pain</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="cli_ind_p4_primary_care" id="cli_ind_p4_primary_care" value="2" {{@$data->cli_ind_p4_primary_care == '2' ? 'checked' : ''}}>
                                        <label class="form-check-label" for="cli_ind_p4_primary_care">Primary care patients</label>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align: left">Accompanied by: </td>
                    <td colspan="6">{{ @$data->accompanied_by }}</td>
                    <td colspan="1">Relationship: </td>
                    <td colspan="2">{{ @$data->relationship }}</td>
                </tr>
               <tr>
                <td colspan="2" style="text-align: left">Referred by:</td>
                <td colspan="3">
                    {{ @$data->reffered_by_ind == '1'? 'No' : "" }}
                    {{ @$data->reffered_by_ind  == '2'? 'Yes' : "" }}
                </td>
                <td colspan="6">
                    {{ @$data->reffered_by_remarks }}
                </td>
               </tr>

               <tr>
                <td class="text-left" colspan="1">Mother Tongue: </td>
                <td class="text-left" colspan="1">{{ @$data->mother_tongue }} </td>
                <td class="text-left" colspan="3">Can Speak: Bangla</td>
                <td class="text-left" colspan="1">
                    {{ @$data->speak_bangla_ind == '1'? 'No' : "" }}
                    {{ @$data->speak_bangla_ind == '2'? 'Yes' : "" }}

                </td>
                <td class="text-left" colspan="1">English:</td>
                <td class="text-left" colspan="1">
                     {{ @$data->speak_english_ind == '1'? 'No' : "" }}
                     {{ @$data->speak_english_ind == '2'? 'Yes' : "" }}
                </td>
                <td class="text-left" colspan="1">Others: </td>
                <td class="text-left" colspan="2">{{ @$data->tongue_other }} </td>
               </tr>
                <tr>
                    <td class="text-left" colspan="2">
                        General condition:
                    </td>
                    <td class="text-left" colspan="4">
                        {{ @$data->general_condition == '1'? 'Conscious and alert' : "" }}
                        {{ @$data->general_condition == '2'? 'Unconscious' : "" }}
                        {{ @$data->general_condition == '3'? 'Restless' : "" }}
                        {{ @$data->general_condition == '4'? 'Drowsy' : "" }}
                        {{ @$data->general_condition == '5'? 'Others' : "" }}
                    </td>
                    <td colspan="5">
                        {{ @$data->general_condition_other }}
                    </td>
                </tr>
                <tr>
                    <td class="text-left" colspan="5">
                        {{ @$data->room_air_o2_ind == '1'? 'Room air' : "" }}
                        {{ @$data->room_air_o2_ind == '2'? 'O2' : "" }}
                        {{ @$data->room_air_o2_ind == '3'? 'BiPAP' : "" }}
                        {{ @$data->room_air_o2_ind == '4'? 'ET tube' : "" }}
                        {{ @$data->room_air_o2_ind == '5'? 'Tracheostomy' : "" }}
                        {{ @$data->room_air_o2_ind == '6'? 'Others' : "" }}
                    </td>
                    <td colspan="6">
                        {{ @$data->room_air_o2_specify }}
                    </td>
                </tr>
                <tr>
                    <td class="text-left" colspan="3">
                        Presence of lines/tubes/drains:
                    </td>
                    <td colspan="4">
                        {{ @$data->presence_lines_tube_ind == '1'? 'No' : "" }}
                        {{ @$data->presence_lines_tube_ind == '2'? 'Yes' : "" }}

                    </td>
                    <td colspan="4">
                        {{ @$data->presence_lines_specify }}
                    </td>
                </tr>
                <tr>
                    <td class="text-left" colspan="3">
                        Allergies:
                    </td>
                    <td colspan="4">
                        {{ @$data->allergies_ind == '1' ? 'No' : "" }}
                        {{ @$data->allergies_ind == '2' ? 'Yes' : "" }}
                    </td>
                    <td colspan="4">
                        {{ @$data->allergies_specify }}
                    </td>
                </tr>
                <tr>
                    <td class="text-left" colspan="3">
                        {{ @$data->any_cultural_religious == '1'? 'Any cultural' : "" }}
                        {{ @$data->any_cultural_religious == '2'? 'Religious' : "" }}
                        {{ @$data->any_cultural_religious == '3'? 'Special needs' : "" }}

                    </td>
                    <td colspan="8">
                        {{ @$data->special_needs }}
                    </td>
                </tr>
            </tbody>
        </table>
        <table class="table table-bordered" style="margin-top: 25px">
            <tbody>
                <tr>
                    <td class="text-center" colspan="11"><b>VULNERABILITY ASSESSMENT</b></td>
                </tr>
                <tr>
                    <td class="text-left" colspan="9"><b>Parameters</b></td>
                    <td class="text-left" colspan="2"><b/No</b></td>
                </tr>

                <tr>
                    <td class="text-left" colspan="9">{{'Children <16 yrs'}}</td>
                    <td class="text-left" colspan="2">
                        {{@$data->children16 == 1 ? 'No' : '' }}
                        {{@$data->children16 == 2 ? 'Yes' : '' }}
                    </td>
                </tr>
                <tr>
                    <td class="text-left" colspan="9">Adolescent</td>
                    <td class="text-left" colspan="2">
                           {{@$data->adolescent == 1 ? 'No' : '' }}
                           {{@$data->adolescent == 2 ? 'Yes' : '' }}
                    </td>
                </tr>
                <tr>
                    <td class="text-left" colspan="9">{{'Elderly>65 years'}}</td>
                    <td class="text-left" colspan="2">
                        {{@$data->elder65 == 1 ? 'No' : '' }}
                        {{@$data->elder65 == 2 ? 'Yes' : '' }}
                    </td>
                </tr>
                <tr>
                    <td class="text-left" colspan="9">Frail elderly</td>
                    <td class="text-left" colspan="2">

                            {{@$data->frail_elderly == 1 ? 'No' : ''}}
                           {{@$data->frail_elderly == 2 ? 'Yes' : ''}}

                    </td>
                </tr>
                <tr>
                    <td class="text-left" colspan="9">{{'Terminally ill/dying'}}</td>
                    <td class="text-left" colspan="2">
                        {{@$data->terminally_ill == 1 ? 'No' : ''}}
                        {{@$data->terminally_ill == 2 ? 'Yes' : ''}}
                    </td>
                </tr>
                <tr>
                    <td class="text-left" colspan="9">Not able to do ADL</td>
                    <td class="text-left" colspan="2">
                        {{@$data->adl == 1 ? 'No' : ''}}
                        {{@$data->adl == 2 ? 'Yes' : ''}}
                    </td>
                </tr>
                <tr>
                    <td class="text-left" colspan="9">Intense or chronic pain</td>
                    <td class="text-left" colspan="2">
                            {{@$data->intense_chronic_pain == 1 ? 'No' : ''}}
                           {{@$data->intense_chronic_pain == 2 ? 'Yes' : ''}}

                    </td>
                </tr>
                <tr>
                    <td class="text-left" colspan="9">Women in labour</td>
                    <td class="text-left" colspan="2">
                            {{@$data->women_labour == 1 ? 'No' : ''}}
                           {{@$data->women_labour == 2  ? 'Yes' : ''}}

                    </td>
                </tr>

                <tr>
                    <td class="text-left" colspan="9">Women experiencing terminations in pregnancy</td>
                    <td class="text-left" colspan="2">

                        {{@$data->women_exp_ter_pregnancy == 1 ? 'No' : ''}}
                           {{@$data->women_exp_ter_pregnancy == 2 ? 'Yes' : ''}}

                    </td>
                </tr>

                <tr>
                    <td class="text-left" colspan="9">Emotional or psychiatric disorders</td>
                    <td class="text-left" colspan="2">
                        {{@$data->emotional_disorder == 1 ? 'No' : ''}}
                        {{@$data->emotional_disorder == 2 ? 'Yes' : ''}}

                    </td>

                </tr>
                <tr>
                    <td class="text-left" colspan="9">Suspected of drug and/or alcohol dependency</td>
                    <td class="text-left" colspan="2">
                            {{@$data->drug_dependency == 1 ? 'No' : ''}}
                           {{@$data->drug_dependency == 2 ? 'Yes' : ''}}

                    </td>
                </tr>
                <tr>
                    <td class="text-left" colspan="9">Victims of abuse or neglect</td>
                    <td class="text-left" colspan="2">
                            {{@$data->victim_neglect == 1 ? 'No' : ''}}
                           {{@$data->victim_neglect == 2 ? 'Yes' : ''}}

                    </td>
                </tr>

                <tr>
                    <td class="text-left" colspan="9">Infectious or communicable diseases</td>
                    <td class="text-left" colspan="2">
                            {{@$data->infectious_diseases == 1 ? 'No' : ''}}
                           {{@$data->infectious_diseases == 2 ? 'Yes' : ''}}

                    </td>
                </tr>
                <tr>
                    <td class="text-left" colspan="9" >Receiving chemotherapy or radiation therapy</td>
                    <td class="text-left" colspan="2">
                            {{@$data->receiving_therapy == 1 ? 'No' : ''}}
                           {{@$data->receiving_therapy == 2 ? 'Yes' : ''}}

                    </td>
                </tr>

                <tr>
                    <td class="text-left" colspan="9">Immune systems are compromised</td>
                    <td class="text-left" colspan="2">
                            {{@$data->immune_compromised == 1 ? 'No' : ''}}
                           {{@$data->immune_compromised == 2 ? 'Yes' : ''}}

                    </td>
                </tr>
                <tr>
                    <td class="text-center" colspan="11"><b>Action Plan</b></td>
                </tr>
                <tr>
                    <td class="text-left" colspan="11">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="provide_assistance" value="1" name="provide_assistance" {{@$data->provide_assistance == 1 ? 'checked' : ''}}>
                            <label class="form-check-label" for="provide_assistance">Provide Assistance in eating/ toileting/personal hygeiene/ mobilisation</label>
                        </div>
                    </td>
                </tr>

                <tr>
                    <td class="text-left" colspan="6">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="pain_management" value="1" name="pain_management" {{@$data->pain_management == 1 ? 'checked' : ''}}>
                            <label class="form-check-label" for="pain_management">Pain Mangement</label>
                        </div>
                    </td>
                    <td class="text-left" colspan="5">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="safety_precaution" value="1" name="safety_precaution" {{@$data->safety_precaution == 1 ? 'checked' : ''}}>
                            <label class="form-check-label" for="safety_precaution">Safety precaution</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="text-left" colspan="11">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="initiate_end_care" value="1" name="initiate_end_care" {{@$data->initiate_end_care == 1 ? 'checked' : ''}}>
                            <label class="form-check-label" for="initiate_end_care">Initiate end of life care</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="text-left" colspan="3">
                        Skin intact:
                    </td>
                    <td colspan="4">
                        {{@$data->skin_intact_ind == 1 ? 'No' : ''}}
                        {{@$data->skin_intact_ind == 2 ? 'Yes' : ''}}

                    </td>
                    <td colspan="4">{{ @$data->skin_intact_specify}}
                    </td>
                </tr>
                <tr>
                    <td class="text-left" colspan="3">
                        Valuable:
                    </td>
                    <td colspan="4">
                            {{@$data->valuable_ind == 1 ? 'No' : ''}}
                           {{@$data->valuable_ind == 2 ? 'Yes' : ''}}

                    </td>
                    <td colspan="4">
                        {{ @$data->valuable_specify }}
                    </td>
                </tr>
                <tr>
                    <td class="text-left" colspan="3">
                        Handover to Name, Sign, with Relationship:
                    </td>
                    <td colspan="4">
                        {{ @$data->handover_name }}
                    </td><td class="text-left" colspan="1">Time:
                    </td>
                    @php $handover_time = explode(" ", @$data->handover_time); @endphp
                    <td colspan="3">
                         {{@$handover_time[1] ? date('h:i a', strtotime($handover_time[1])) : ""}}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <section class="footer-table">
        @php
            $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
            $date = $dt->format('g:i A');
        @endphp

        <table style="width:100%" class="table">
            <tbody>
                <tr>
                    <td style="text-align:left;border:none;width:70%">Staff ID: {{ @$userInfo->user_code }}, Printing
                        Date & Time: {{ date('d/m/Y h:ia') }}</td>
                    <td style="text-align:right;border:none;width:30%">Powered By: NEXTGEN IT</td>
                </tr>
            </tbody>
        </table>
    </section>
</body>

</html>
