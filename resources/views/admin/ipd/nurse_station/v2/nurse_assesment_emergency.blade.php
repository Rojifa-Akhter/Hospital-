
<style>

    .custom-form{
        width:100%;
        border:none;
        outline: none;
    }
    .border-left-0{
        border-left:none !important;
    }
    .border-right-0{
        border-right:none !important;
    }
    .medicine_thead{
        background-color: #e1e1e5;
    }
    .w-15{
        width:15%;
    }
    .w-25{
        width:25%;
    }
    .w-8{
        width:8%;
    }
    .w-6{
        width:6%;
    }
    .w-16{
        width:16%;
    }
    .remove_row{
        cursor: pointer;
        background-color: white;
    }
    .fa-star{
        display:none;
    }
    thead {
        position: sticky;
        top: 0px;
        left:0px;
        right:0px;
        background-color: white;
    }
    .fs-12{
        font-size: 14px;
    }
    .pdf-icon{
        font-size: 22px;
        color: red
    }
</style>

<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">

<main id="page-content">
    <section class="fixed_asset">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="row justify-content-between align-items-center bg-white border-bottom sticky-top shadow-sm">
                        <div class="col-md-10">
                            <h5 class="mt-2 mb-0">Nursing Assessment(Emergency)</h5>
                            <small>IPD / Nurse Station / Nursing Assessment(Emergency)</small>
                        </div>
                        <div class="col-md-2">
                            <a class="btn btn-md btn-warning" target="_blank" href="{{route('v2.ipd.download-nurse-assessment-emergency',[$patient_info->patient_no_pk, $patient_info->admission_no_pk])}}">PDF Export</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body pt-2">
                            <div class="row">

                                <div class="col-12 pb-4 text-center">
                                    <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">Patient Name: {{ @$patient_info->patient_name }}</span>
                                    <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">UHID: {{ @$patient_info->patient_code }}</span>
                                    <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">IP No: {{ @$patient_info->admission_uid }}</span>
                                    <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">Admission Date: {{ date('d/m/Y', strtotime($patient_info->admission_date)) }}</span>
                                    <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">Admission Department: {{ $patient_info->admitted_department }}</span>
                                    <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">Bed Category: {{ $patient_info->ward_name }}</span>
                                    <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">Bed No.: {{ $patient_info->bed_name }}</span>
                                </div>


                                <div class="col-md-12">
                                    <form action="{{route('v2.ipd.save-nurse-assessment-emergency')}}" method="post" id="assesmentForm">
                                        @csrf
                                        <input type="hidden" class="custom-form" id="patient_no_pk" name="patient_no_pk" value="{{@$patient_info->patient_no_pk}}">
                                        <input type="hidden" class="custom-form" id="admission_no_pk" name="admission_no_pk" value="{{@$patient_info->admission_no_pk}}">
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-left border-right-0" colspan="1">Date: </th>
                                                            <th colspan="1"><input class="custom-form date_picker" type="text" name="date_of_asses" id="date_of_asses" value="{{@$data->date_of_asses ? date('d-m-Y', strtotime($data->date_of_asses)): date('d-m-Y')}}"></th>
                                                            <th class="text-left border-left-0" colspan="2" >Time of Arrival:</th>
                                                            @php  $time_of_arrival = explode(" ", @$data->time_of_arrival); @endphp
                                                            <th class="text-left border-left-0" colspan="1" ><input type="time" class="custom-form" name="time_of_arrival" id="time_of_arrival" value="{{@$time_of_arrival[1]}}"></th>
                                                            <th class="text-left border-left-0" colspan="2">Means of Arrival:</th>
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
                                                    </thead>

                                                    <tbody>
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
                                                                            <select class="custom-form" name="comm_disease_triage_ind" id="comm_disease_triage_ind" >
                                                                                <option value="1" {{@$data->comm_disease_triage_ind == 1 ? 'selected' : ''}}>No</option>
                                                                                <option value="2" {{@$data->comm_disease_triage_ind == 2 ? 'selected' : ''}}>Yes</option>
                                                                            </select>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="2">
                                                                            Epidemiological history: <input type="text" class="custom-form" name="comm_disease_triage_history" id="comm_disease_triage_history" value="{{@$data->comm_disease_triage_history}}" autocomplete="off">
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="width:80%" class="text-left">
                                                                            History of Travel to endemic areas (within the past 3 weeks)
                                                                        </td>
                                                                        <td >
                                                                            <select class="custom-form" name="epi_history_of_travel_ind" id="epi_history_of_travel_ind" >
                                                                                <option value="1" {{@$data->epi_history_of_travel_ind == 1 ? 'selected' : ''}}>No</option>
                                                                                <option value="2" {{@$data->epi_history_of_travel_ind == 2 ? 'selected' : ''}}>Yes</option>
                                                                            </select>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="width:80%" class="text-left">
                                                                            Close contact with anyone with same symptoms at home, work or your friends
                                                                        </td>
                                                                        <td>
                                                                            <select class="custom-form" name="epi_close_contact_any_ind" id="epi_close_contact_any_ind">
                                                                                <option value="1" {{@$data->epi_close_contact_any_ind == '1' ? 'selected' : ''}}>No</option>
                                                                                <option value="2" {{@$data->epi_close_contact_any_ind == '2' ? 'selected' : ''}}>Yes</option>
                                                                            </select>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="width:80%" class="text-left">
                                                                            Healthcare worker with recent exposure to a highly communicable disease
                                                                        </td>
                                                                        <td>
                                                                            <select class="custom-form" name="epi_healthc_worker_com_ind" id="epi_healthc_worker_com_ind" >
                                                                                <option value="1" {{@$data->epi_healthc_worker_com_ind == 1 ? 'selected' : ''}}>No</option>
                                                                                <option value="2" {{@$data->epi_healthc_worker_com_ind == 2 ? 'selected' : ''}}>Yes</option>
                                                                            </select>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="width:80%" class="text-left">
                                                                            Close contact with animals (Pets / Livestock & their handlers)
                                                                            *If any of the above Epidemiological history is yes, inform on duty medical officer and shift the patient to isolation room.
                                                                            
                                                                        </td>
                                                                        <td>
                                                                            <select class="custom-form" name="epi_close_contact_animal_ind" id="epi_close_contact_animal_ind" >
                                                                                <option value="1" {{@$data->epi_close_contact_animal_ind == '1' ? 'selected' : ''}}>No</option>
                                                                                <option value="2" {{@$data->epi_close_contact_animal_ind == '2' ? 'selected' : ''}}>Yes</option>
                                                                            </select>
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
                                                            <td colspan="6"><input type="text" class="custom-form" name="accompanied_by" id="" value="{{ @$data->accompanied_by }}" autocomplete="off"></td>
                                                            <td colspan="1">Relationship: </td>
                                                            <td colspan="2"><input type="text" class="custom-form" name="relationship" value="{{ @$data->relationship }}" autocomplete="off"></td>
                                                        </tr>
                                                       <tr>
                                                        <td colspan="2" style="text-align: left">Referred by:</td>
                                                        <td colspan="3">
                                                            <select class="custom-form" name="reffered_by_ind" id="reffered_by_ind" >
                                                            <option value="1" {{ @$data->reffered_by_ind == '1'? 'selected' : "" }}>No</option>
                                                            <option value="2" {{ @$data->reffered_by_ind  == '2'? 'selected' : "" }}>Yes</option>
                                                        </select></td>
                                                        <td colspan="6">
                                                            <input type="text" class="custom-form" name="reffered_by_remarks" id="" value="{{ @$data->reffered_by_remarks }}" autocomplete="off" placeholder="Specify">
                                                        </td>
                                                       </tr>

                                                       <tr>
                                                        <td class="text-left" colspan="1">Mother Tongue: </td>
                                                        <td class="text-left" colspan="1"><input type="text" class="custom-form" name="mother_tongue" id="" value="{{ @$data->mother_tongue }}" autocomplete="off"> </td>
                                                        <td class="text-left" colspan="3">Can Speak: Bangla</td>
                                                        <td class="text-left" colspan="1">
                                                            <select class="custom-form" name="speak_bangla_ind" id="speak_bangla_ind" >
                                                            <option value="1" {{ @$data->speak_bangla_ind == '1'? 'selected' : "" }}>No</option>
                                                            <option value="2" {{ @$data->speak_bangla_ind == '2'? 'selected' : "" }}>Yes</option>
                                                            </select> 
                                                        </td>
                                                        <td class="text-left" colspan="1">English:</td>
                                                        <td class="text-left" colspan="1">
                                                            <select class="custom-form" name="speak_english_ind" id="speak_english_ind" >
                                                            <option value="1" {{ @$data->speak_english_ind == '1'? 'selected' : "" }}>No</option>
                                                            <option value="2" {{ @$data->speak_english_ind == '2'? 'selected' : "" }}>Yes</option>
                                                            </select> 
                                                        </td>
                                                        <td class="text-left" colspan="1">Others: </td>
                                                        <td class="text-left" colspan="2"><input type="text" class="custom-form" name="tongue_other" id="" value="{{ @$data->tongue_other }}" autocomplete="off"> </td>
                                                       </tr>
                                                        <tr>
                                                            <td class="text-left" colspan="2">
                                                                General condition:
                                                            </td>
                                                            <td class="text-left" colspan="4">
                                                                <select class="custom-form" name="general_condition" id="">
                                                                    <option value="">Select</option>
                                                                    <option value="1" {{ @$data->general_condition == '1'? 'selected' : "" }}>Conscious and alert</option>
                                                                    <option value="2" {{ @$data->general_condition == '2'? 'selected' : "" }}>Unconscious</option>
                                                                    <option value="3" {{ @$data->general_condition == '3'? 'selected' : "" }}>Restless</option>
                                                                    <option value="4" {{ @$data->general_condition == '4'? 'selected' : "" }}>Drowsy</option>
                                                                    <option value="5" {{ @$data->general_condition == '5'? 'selected' : "" }}>Others</option>
                                                                </select>
                                                            </td>
                                                            <td colspan="5">
                                                                <input type="text" class="custom-form" name="general_condition_other" id="" value="{{ @$data->general_condition_other }}" autocomplete="off" placeholder="Others">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-left" colspan="5">
                                                                <select class="custom-form" name="room_air_o2_ind" id="" >
                                                                    <option value="" >Select</option>
                                                                    <option value="1"  {{ @$data->room_air_o2_ind == '1'? 'selected' : "" }}>Room air</option>
                                                                    <option value="2"  {{ @$data->room_air_o2_ind == '2'? 'selected' : "" }}>O2</option>
                                                                    <option value="3"  {{ @$data->room_air_o2_ind == '3'? 'selected' : "" }}>BiPAP</option>
                                                                    <option value="4"  {{ @$data->room_air_o2_ind == '4'? 'selected' : "" }}>ET tube</option>
                                                                    <option value="5"  {{ @$data->room_air_o2_ind == '5'? 'selected' : "" }}>Tracheostomy</option>
                                                                    <option value="6"  {{ @$data->room_air_o2_ind == '6'? 'selected' : "" }}>Others</option>
                                                                </select>
                                                            </td>
                                                            <td colspan="6">
                                                                <input type="text" class="custom-form" name="room_air_o2_specify" id="" value="{{ @$data->room_air_o2_specify }}" autocomplete="off" placeholder="Other info">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-left" colspan="3">
                                                                Presence of lines/tubes/drains:
                                                            </td>
                                                            <td colspan="4">
                                                                <select class="custom-form" name="presence_lines_tube_ind" id="presence_lines_tube_ind">
                                                                    <option value="1" {{ @$data->presence_lines_tube_ind == '1'? 'selected' : "" }}>No</option>
                                                                    <option value="2" {{ @$data->presence_lines_tube_ind == '2'? 'selected' : "" }}>Yes</option>
                                                                    </select> 
                                                            </td>
                                                            <td colspan="4">
                                                                <input type="text" class="custom-form" name="presence_lines_specify" id="" value="{{ @$data->presence_lines_specify }}" autocomplete="off" placeholder="Specify">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-left" colspan="3">
                                                                Allergies:
                                                            </td>
                                                            <td colspan="4">
                                                                <select class="custom-form" name="allergies_ind" id="allergies_ind">
                                                                    <option value="1" {{ @$data->allergies_ind == '1' ? 'selected' : "" }}>No</option>
                                                                    <option value="2" {{ @$data->allergies_ind == '2' ? 'selected' : "" }}>Yes</option>
                                                                    </select> 
                                                            </td>
                                                            <td colspan="4">
                                                                <input type="text" class="custom-form" name="allergies_specify" id="" value="{{ @$data->allergies_specify }}" autocomplete="off" placeholder="Specify">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-left" colspan="3">
                                                                <select class="custom-form" name="any_cultural_religious" id="" >
                                                                    <option value="">Select</option>
                                                                    <option value="1" {{ @$data->any_cultural_religious == '1'? 'selected' : "" }}>Any cultural</option>
                                                                    <option value="2" {{ @$data->any_cultural_religious == '2'? 'selected' : "" }}>Religious</option>
                                                                    <option value="3" {{ @$data->any_cultural_religious == '3'? 'selected' : "" }}>Special needs</option>
                                                                </select>
                                                            </td>
                                                            <td colspan="8">
                                                                <input type="text" class="custom-form" name="special_needs" id="" value="{{ @$data->special_needs }}" autocomplete="off">
                                                            </td>
                                                        </tr>
                                                      
                                                        <tr>
                                                            <td class="text-center" colspan="11"><b>VULNERABILITY ASSESSMENT</b></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-left" colspan="9"><b>Parameters</b></td>
                                                            <td class="text-left" colspan="2"><b>Yes/No</b></td>
                                                        </tr>

                                                        <tr>
                                                            <td class="text-left" colspan="9">{{'Children <16 yrs'}}</td>
                                                            <td class="text-left" colspan="2">
                                                                <select name="children16" id="children16" class="custom-form">
                                                                    <option value="1" {{@$data->children16 == 1 ? 'selected' : '' }}>No</option>
                                                                    <option value="2" {{@$data->children16 == 2 ? 'selected' : '' }}>Yes</option>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-left" colspan="9">Adolescent</td>
                                                            <td class="text-left" colspan="2">
                                                                <select name="adolescent" id="adolescent" class="custom-form">
                                                                    <option value="1" {{@$data->adolescent == 1 ? 'selected' : '' }}>No</option>
                                                                    <option value="2" {{@$data->adolescent == 2 ? 'selected' : '' }}>Yes</option>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-left" colspan="9">{{'Elderly>65 years'}}</td>
                                                            <td class="text-left" colspan="2">
                                                                <select name="elder65" id="elder65" class="custom-form">
                                                                    <option value="1" {{@$data->elder65 == 1 ? 'selected' : '' }}>No</option>
                                                                    <option value="2" {{@$data->elder65 == 2 ? 'selected' : '' }}>Yes</option>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-left" colspan="9">Frail elderly</td>
                                                            <td class="text-left" colspan="2">
                                                                <select name="frail_elderly" id="frail_elderly" class="custom-form">
                                                                    <option value="1" {{@$data->frail_elderly == 1 ? 'selected' : ''}}>No</option>
                                                                    <option value="2" {{@$data->frail_elderly == 2 ? 'selected' : ''}}>Yes</option>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-left" colspan="9">{{'Terminally ill/dying'}}</td>
                                                            <td class="text-left" colspan="2">
                                                                <select name="terminally_ill" id="terminally_ill" class="custom-form">
                                                                    <option value="1" {{@$data->terminally_ill == 1 ? 'selected' : ''}}>No</option>
                                                                    <option value="2" {{@$data->terminally_ill == 2 ? 'selected' : ''}}>Yes</option>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-left" colspan="9">Not able to do ADL</td>
                                                            <td class="text-left" colspan="2">
                                                                <select name="adl" id="ADL" class="custom-form">
                                                                    <option value="1" {{@$data->adl == 1 ? 'selected' : ''}}>No</option>
                                                                    <option value="2" {{@$data->adl == 2 ? 'selected' : ''}}>Yes</option>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-left" colspan="9">Intense or chronic pain</td>
                                                            <td class="text-left" colspan="2">
                                                                <select name="intense_chronic_pain" id="intense_chronic_pain" class="custom-form">
                                                                    <option value="1" {{@$data->intense_chronic_pain == 1 ? 'selected' : ''}}>No</option>
                                                                    <option value="2" {{@$data->intense_chronic_pain == 2 ? 'selected' : ''}}>Yes</option>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-left" colspan="9">Women in labour</td>
                                                            <td class="text-left" colspan="2">
                                                                <select name="women_labour" id="women_labour" class="custom-form">
                                                                    <option value="1" {{@$data->women_labour == 1? 'selected' : ''}}>No</option>
                                                                    <option value="2" {{@$data->women_labour == 2 ? 'selected' : ''}}>Yes</option>
                                                                </select>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td class="text-left" colspan="9">Women experiencing terminations in pregnancy</td>
                                                            <td class="text-left" colspan="2">
                                                                <select name="women_exp_ter_pregnancy" id="women_exp_ter_pregnancy" class="custom-form">
                                                                    <option value="1" {{@$data->women_exp_ter_pregnancy == 1 ? 'selected' : ''}}>No</option>
                                                                    <option value="2" {{@$data->women_exp_ter_pregnancy == 2 ? 'selected' : ''}}>Yes</option>
                                                                </select>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td class="text-left" colspan="9">Emotional or psychiatric disorders</td>
                                                            <td class="text-left" colspan="2">
                                                                <select name="emotional_disorder" id="emotional_disorder" class="custom-form">
                                                                    <option value="1" {{@$data->emotional_disorder == 1 ? 'selected' : ''}}>No</option>
                                                                    <option value="2" {{@$data->emotional_disorder == 2 ? 'selected' : ''}}>Yes</option>
                                                                </select>
                                                            </td>
                                                            
                                                        </tr>
                                                        <tr>
                                                            <td class="text-left" colspan="9">Suspected of drug and/or alcohol dependency</td>
                                                            <td class="text-left" colspan="2">
                                                                <select name="drug_dependency" id="drug_dependency" class="custom-form">
                                                                    <option value="1" {{@$data->drug_dependency == 1 ? 'selected' : ''}}>No</option>
                                                                    <option value="2" {{@$data->drug_dependency == 2 ? 'selected' : ''}}>Yes</option>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-left" colspan="9">Victims of abuse or neglect</td>
                                                            <td class="text-left" colspan="2">
                                                                <select name="victim_neglect" id="victim_neglect" class="custom-form">
                                                                    <option value="1" {{@$data->victim_neglect == 1 ? 'selected' : ''}}>No</option>
                                                                    <option value="2" {{@$data->victim_neglect == 2 ? 'selected' : ''}}>Yes</option>
                                                                </select>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td class="text-left" colspan="9">Infectious or communicable diseases</td>
                                                            <td class="text-left" colspan="2">
                                                                <select name="infectious_diseases" id="infectious_diseases" class="custom-form">
                                                                    <option value="1" {{@$data->infectious_diseases == 1 ? 'selected' : ''}}>No</option>
                                                                    <option value="2" {{@$data->infectious_diseases == 2 ? 'selected' : ''}}>Yes</option>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-left" colspan="9" >Receiving chemotherapy or radiation therapy</td>
                                                            <td class="text-left" colspan="2">
                                                                <select name="receiving_therapy" id="receiving_therapy" class="custom-form">
                                                                    <option value="1" {{@$data->receiving_therapy == 1 ? 'selected' : ''}}>No</option>
                                                                    <option value="2" {{@$data->receiving_therapy == 2 ? 'selected' : ''}}>Yes</option>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                        
                                                        <tr>
                                                            <td class="text-left" colspan="9">Immune systems are compromised</td>
                                                            <td class="text-left" colspan="2">
                                                                <select name="immune_compromised" id="immune_compromised" class="custom-form">
                                                                    <option value="1" {{@$data->immune_compromised == 1 ? 'selected' : ''}}>No</option>
                                                                    <option value="2" {{@$data->immune_compromised == "2" ? 'selected' : ''}}>Yes</option>
                                                                </select>
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
                                                                <select class="custom-form" name="skin_intact_ind" id="">
                                                                    <option value="1" {{@$data->skin_intact_ind == 1 ? 'selected' : ''}}>No</option>
                                                                    <option value="2" {{@$data->skin_intact_ind == 2 ? 'selected' : ''}}>Yes</option>
                                                                    </select> 
                                                            </td>
                                                            <td colspan="4">
                                                                <input type="text" class="custom-form" name="skin_intact_specify" id="" value="{{ @$data->skin_intact_specify}}" autocomplete="off" placeholder="Specify">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-left" colspan="3">
                                                                Valuable:
                                                            </td>
                                                            <td colspan="4">
                                                                <select class="custom-form" name="valuable_ind" id="">
                                                                    <option value="1" {{@$data->valuable_ind == 1 ? 'selected' : ''}}>No</option>
                                                                    <option value="2" {{@$data->valuable_ind == 2 ? 'selected' : ''}}>Yes</option>
                                                                    </select> 
                                                            </td>
                                                            <td colspan="4">
                                                                <input type="text" class="custom-form" name="valuable_specify" id="" value="{{ @$data->valuable_specify }}" autocomplete="off" placeholder="Specify">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-left" colspan="3">
                                                                Handover to Name, Sign, with Relationship:
                                                            </td>
                                                            <td colspan="4">
                                                                <input type="text" class="custom-form" name="handover_name" id="" value="{{ @$data->handover_name }}" autocomplete="off">
                                                            </td><td class="text-left" colspan="1">Time:
                                                            </td>
                                                            @php  $handover_time = explode(" ", @$data->handover_time); @endphp
                                                            <td colspan="3">
                                                                <input type="time" class="custom-form" name="handover_time" id="" value="{{@$handover_time[1]}}" autocomplete="off" >
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <td colspan="2"><b>Initial assessment completed at:</b></td>
                                                            <td>

                                                                @php  $completed_at = explode(" ", @$data->completed_at); @endphp
                                                                <input type="time" class="custom-form" value="{{@$completed_at[1]}}" name="completed_at">
                                                            </td>
                                                            <td colspan="2"><b>RN Name / sign with Emp ID:</b></td>
                                                            <td>
                                                                <input type="text" id="rn_name" name="rn_name" value="{{@$data->rn_name}}" class="custom-form"/>
                                                                <input type="hidden" id="complete_by" name="complete_by" class="custom-form"  value="{{@$data->complete_by}}" />
                                                            </td>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                            <div class="text-center">
                                                <button class="btn btn-md btn-success w-25" type="button" onclick="saveAssesment()">Save</button>
                                            </div>
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
</main>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script>
        $(document).ready(function(){
            openDoctorAutocomplete('#bystander_signature_name', 'bystander_signature_id');
            openDoctorAutocomplete('#rn_name', 'complete_by');
            $(".date_picker").datepicker({
                format: 'dd-mm-yyyy',
                autoclose: true,
                todayHighlight: true,
                clearBtn: true
                // startDate: new Date()
            }); 
        })
    
        function saveAssesment(){
            let formElement = document.querySelector('#assesmentForm');
            let formData = new FormData(formElement);
            if($('#admission_no_pk').val() == ''){
                alert('Amission no. required');
                return false;
            }
            if($('#patient_no_pk').val() == ''){
                alert('Patient no. required');
                return false;
            }
            
            $.ajax({
                    url:"{{route('v2.ipd.save-nurse-assessment-emergency')}}",
                    type:"post",
                    dataType:"json",
                    data:formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        blockUI();
                    },
                    success:function(data){  
                        $.unblockUI();
                        $('.common-modal-notify').modal('show');
                        $('.common-modal-notify .modal-title').html('Success');
                        $('.common-modal-notify .modal-body').html(data.message);
                    },
                    error:function(err){
                        $.unblockUI();
                        var error = err.responseJSON;
                        $('.common-modal-notify-error').modal('show');
                        $('.common-modal-notify-error .modal-title').html('Failed');
                        $('.common-modal-notify-error .modal-body').html(error.message);
                    },
                    complete: function() {
                        $.unblockUI();
                    }
            });
        }
</script>
