<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Nurse Initial Assesment</title>


    <style>



        .fs-12{
            font-size: 14px;
        }
        .table{
            border-collapse: collapse;
            width:100%;
        }
        .table-bordered{
            border: 1px solid #333;
        }
        td{
            font-size: 13px;
            border: 1px solid #333;
            padding-right:3px;
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
        .w-16{
            width: 16%;
        }
        .w-8{
            width:8%;
        }
        .w-15{
            width:15%;
        }
        .w-25{
            width:25%;
        }
        .text-left{
            text-align: left;
        }
        .text-center{
            text-align: center;
        }
        .text-right{
            text-align: right;
        }
        .header>tbody>tr>td, .header>thead>tr>td{
            border:none;
        }

        body{
            /* margin-top: 4cm; */
            margin-bottom: 0.6cm;
            margin-left: 1cm;
        }
        .footer-table {
            /* position: absolute;
            bottom: 0px;
            width: 100%; */

            margin-top: 10px;
        }
        td{
            page-break-inside: avoid
        }
    </style>
</head>
<body onload="window.print()">

    <table class="table header">
        <thead>
            <tr>
                <td style="width:65%">
                    <ul style="list-style: none; padding-left: 0; display:inline-block;">
                        <li><b>IP No:</b>&nbsp;<span>{{ isset($admission_info->admission_no_pk) ? $admission_info->admission_no_pk : '' }}</span></li>
                        <li><img style="" src="data:image/png;base64, {{ $invoice_barcode }} "></li>
                        <li><span><b>Name:</b>{{ isset($patient_info->patient_name) ? $patient_info->patient_name : '' }}</span>
                            &nbsp;<span><b>Age:</b>{{ isset($patient_info->age) ? $patient_info->age : '' }}</span>
                            &nbsp;<b>Gender:</b><span>{{ isset($patient_info->gender_txt) ? $patient_info->gender_txt : '' }}</span>
                            &nbsp;<b>Bed:</b>&nbsp;<span>{{ isset($admission_info->bed_name) ? $admission_info->bed_name : '' }}</span>
                        </li>
                        <li><b>Con. Number :</b>&nbsp;<span>{{ $patient_info->mobile1 }}</span></li>
                        <li><b>Consultant Name:</b>&nbsp;<span>{{$admission_info->primary_doctor_name}}</span></li>
                    </ul>
                </td>
                <td style="text-align:right;width:35%">
                    <ul style="list-style: none; padding-left: 0;">
                        <li><b>UHID:</b>&nbsp;<span>{{ isset($patient_info->patient_code) ? $patient_info->patient_code : '' }}</span></li>
                        <li><img style="" src="data:image/png;base64, {{ $pat_barcode }} "></li>
                        <li><b>Phone:</b>&nbsp;<span>{{ isset($patient_info->mobile1) ? $patient_info->mobile1 : '' }}</span></li>
                        <li><b>IP Date:</b>&nbsp;<span>{{ date('d/m/Y h:i a', strtotime($admission_info->admission_date)) }}</span></li>
                        @if(!empty($admission_info->dis_datetime))<li><b>Date of Discharge:</b>&nbsp;<span>{{ date('d/m/Y h:i a', strtotime($admission_info->dis_datetime)) }}</span></li>@endif

                    </ul>
                </td>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td colspan="2">
                    <div style="padding: 7px; border-top:1px dotted black; border-bottom:1px dotted black;text-align:center;margin-top:10px; margin-bottom:20px">
                        <span style="font-size: 16px;"><b>NURSE INITIAL ASSESSMENT AND PLAN OF CARE – INPATIENT</b></span>
                    </div>

                    <table class="table table-bordered">

                        <tbody>

                            <tr>
                                <th class="text-left" style="width:5%">Date: </th>
                                <th style="width:5%">{{substr($assessment_info->assessment_date, 0, 10)}}</th>
                                <th class="text-left" colspan="2" style="width:15%">initiated at:</th>
                                <th class="text-left" style="width:10%">{{@$assessment_info->initiated_at}}</th>
                                <th class="text-left" colspan="3" style="width:27%">How admitted</th>
                                <th class="text-left" colspan="2" style="width:20%">{{$assessment_info->admitted_type}}</th>
                                <th class="text-left" style="width:13%">Bystander present:</th>
                                <th class="text-left" style="width:5%">{{$assessment_info->bystander_present == 1 ? 'No' : 'Yes'}}</th>
                            </tr>

                            <tr>
                                <td colspan="6" class="text-left"><b>General condition:</b></td>
                                <td colspan="6">
                                    <option value="1" {{@$assessment_info->general_condition == 1 ? 'selected' : ''}}>CONSCIOUS</option>
                                    <option value="3" {{@$assessment_info->general_condition == 2 ? 'selected' : ''}}>RESTLESSNESS</option>
                                    <option value="5" {{@$assessment_info->general_condition == 3 ? 'selected' : ''}}>DISORIENTED</option>
                                    <option value="4" {{@$assessment_info->general_condition == 4 ? 'selected' : ''}}>DROWSY</option>
                                    <option value="2" {{@$assessment_info->general_condition == 5 ? 'selected' : ''}}>UNCONSCIOUS</option>
                                    <option value="5" {{@$assessment_info->general_condition == 6 ? 'selected' : ''}}>OTHERS</option>
                                </td>
                            </tr>

                            <tr>
                                <td colspan="3" class="text-left"><b>Respiratory Support:</b></td>
                                <td colspan="2">
                                    {{@$assessment_info->room_airtype == 1 ? 'Room air' : ''}}
                                    {{@$assessment_info->room_airtype == 2 ? 'O₂' : ''}}
                                    {{@$assessment_info->room_airtype == 3 ? 'Tracheostomy' : ''}}
                                    {{@$assessment_info->room_airtype == 4 ? 'BiPAP' : ''}}
                                    {{@$assessment_info->room_airtype == 5 ? 'C-PAP' : ''}}
                                    {{@$assessment_info->room_airtype == 6 ? 'Vent' : ''}}
                                </td>
                                <td class="text-left"><b>Mother tongue:</b></td>
                                <td colspan="2">
                                    {{@$assessment_info->mother_tongue == 1 ? 'Bangla' : ''}}
                                    {{@$assessment_info->mother_tongue == 2 ? 'English' : ''}}
                                    {{@$assessment_info->mother_tongue == 3 ? 'Hindi' : ''}}
                                    {{@$assessment_info->mother_tongue == 4 ? 'Others' : ''}}
                                </td>
                                <td class="text-left"><b>Can speak:</b></td>
                                <td colspan="3" >
                                    {{@$assessment_info->multi_language == 1 ? 'Bangla' : ''}}
                                    {{@$assessment_info->multi_language == 2 ? 'English' : ''}}
                                    {{@$assessment_info->multi_language == 3 ? 'Hindi' : ''}}
                                    {{@$assessment_info->multi_language == 4 ? 'Others' : ''}}
                                </td>
                            </tr>

                            <tr>
                                <td class="text-left" colspan="3"><b>Presence of lines/tubes/drains: </b></td>
                                <td> {{$assessment_info->presence_type == 1 ? 'No' : 'Yes'}}</td>
                                <td class="text-left"><b>Specify</b></td>
                                <td>
                                    {{@$assessment_info->presence_specify == 1 ? 'CV Line' : ''}}
                                    {{@$assessment_info->presence_specify == 2 ? 'IV Cannula' : ''}}
                                    {{@$assessment_info->presence_specify == 3 ? 'Folleyes Catheta' : ''}}
                                    {{@$assessment_info->presence_specify == 4 ? 'ICD' : ''}}
                                    {{@$assessment_info->presence_specify == 5 ? 'Ryles Tube' : ''}}
                                    {{@$assessment_info->presence_specify == 6 ? 'Wound Drain' : ''}}
                                    {{@$assessment_info->presence_specify == 7 ? 'Tracheostomy Tube' : ''}}
                                    {{@$assessment_info->presence_specify == 8 ? 'Peg Tube' : ''}}
                                    {{@$assessment_info->presence_specify == 9 ? 'Pig Line' : ''}}
                                    <td>
                                <td class="text-left"><b>Height</b></td>
                                <td class="text-left">{{$assessment_info->height}}</td>
                                <td class="text-left">cm</td>
                                <td class="text-left"><b>Weight</b></td>
                                <td class="text-left" colspan="2">{{$assessment_info->weight}} kg</td>

                            </tr>


                            <tr>
                                <td class="text-left" colspan="4"><b>Any cultural/religious / special needs:</b></td>
                                <td class="text-left" colspan="2">{{$assessment_info->any_cultural}}</td>
                                <td colspan="6" class="text-left"><b>Allergies:</b>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="allergies_yes" value="1" name="allergies" {{$assessment_info->allergies == 1 ? 'checked' : ''}}>
                                        <label class="form-check-label" for="allergies_yes"><b>Yes</b></label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="allergies_no" value="2" name="allergies" {{$assessment_info->allergies == 2 ? 'checked' : ''}}>
                                        <label class="form-check-label" for="allergies_no"><b>Not Known</b></label>
                                    </div>
                                </td>
                            </tr>


                            <tr>
                                <td class="text-left" colspan="2"><b>Eyes open:</b></td>
                                <td class="text-left">{{$assessment_info->eyes_open}}</td>
                                <td class="text-left" colspan="2"><b>Verbal response:</b></td>
                                <td class="text-left">{{$assessment_info->verbal_response}}</td>
                                <td class="text-left" colspan="2"><b>Motor Response:</b></td>
                                <td class="text-left">{{$assessment_info->motor_response}}</td>
                                <td class="text-left" colspan="2"><b>Total score:</b></td>
                                <td class="text-left">{{$assessment_info->total_score}}</td>
                            </tr>


                            <tr>
                                <td class="text-left" colspan="1"><b>Temp:</b></td>
                                <td class="text-left" colspan="1">
                                    <div style="display: flex;justify-content:space-between">
                                        <div>{{@$assessment_info->temp}}</div>
                                        <div>&deg;F</div>
                                    </div>
                                </td>
                                <td class="text-left" colspan="1"><b>Pulse:</b></td>
                                <td class="text-left" colspan="1">
                                    <div style="display: flex;justify-content:space-between">
                                        <div>{{@$assessment_info->pulse}}</div>
                                        <div>/mm</div>
                                    </div>
                                </td>
                                <td class="text-left" colspan="1"><b>Resp:</b></td>
                                <td class="text-left" colspan="1">
                                    <div style="display: flex;justify-content:space-between">
                                        <div>{{@$assessment_info->resp}}</div>
                                        <div>/min</div>
                                    </div>
                                </td>
                                <td class="text-left" colspan="1"><b>BP:</b></td>
                                <td class="text-left" colspan="1">
                                    <div style="display: flex;justify-content:space-between">
                                        <div>{{@$assessment_info->bp_high}}</div>
                                    </div>
                                </td>
                                <td class="text-left" colspan="2">
                                    <div style="display: flex;justify-content:space-between">
                                        <div>{{@$assessment_info->bp_low}}</div>
                                        <div>mmHg</div>
                                    </div>
                                </td>
                                <td class="text-left" colspan="1"><b>SpO2:</b></td>
                                <td class="text-left" colspan="1">
                                    <div style="display: flex; justify-content:space-between">
                                        <div>{{@$assessment_info->spo2}}</div>
                                        <div>%</div>
                                    </div>
                                </td>
                            </tr>


                            <tr>
                                <td class="text-left" colspan="3"><b>Invasive/Non-Invasive/Hiflow:</b></td>
                                <td class="text-left">
                                    {{$assessment_info->invasive_type == 1 ? 'No' : 'Yes'}}
                                </td>
                                <td class="text-left" colspan="3">
                                    if yes, fill the following
                                </td>
                                <td colspan="5">
                                    <input type="text" name="" class="custom-form" value="" disabled>
                                </td>
                            </tr>

                            <tr>
                                <td class="text-left"><b>Mode:</b></td>
                                <td class="text-left">{{$assessment_info->invasive_mode}}</td>
                                <td class="text-left"><b>Rate:</b></td>
                                <td class="text-left">{{$assessment_info->invasive_rate}}</td>
                                <td class="text-left"><b>TV:</b></td>
                                <td class="text-left">{{$assessment_info->invasive_tv}}</td>
                                <td class="text-left" style="white-space: nowrap"><b>Exp TV:</b></td>
                                <td class="text-left">{{$assessment_info->invasive_exptv}}</td>
                                <td class="text-left"><b>Total RR:</b></td>
                                <td class="text-left">{{$assessment_info->invasive_rr}}</td>
                                <td class="text-left"><b>I:E:</b></td>
                                <td class="text-left">{{$assessment_info->invasive_ie}}</td>
                            </tr>

                            <tr>
                                <td class="text-left"><b>FiO2:</b></td>
                                <td class="text-left">{{$assessment_info->invasive_fio2}}</td>
                                <td class="text-left"><b>PEEP/CPAP:</b></td>
                                <td class="text-left">{{$assessment_info->invasive_peep}}</td>
                                <td class="text-left" colspan="3"><b>Peak Airway Pressure:</b></td>
                                <td class="text-left">{{$assessment_info->invasive_peakair}}</td>
                                <td class="text-left" style="white-space: nowrap"><b>Plateaw:</b></td>
                                <td class="text-left">{{$assessment_info->invasive_plateaw}}</td>
                                <td class="text-left"><b>Flow:</b></td>
                                <td class="text-left">{{$assessment_info->invasive_flow}}</td>

                            </tr>


                            <tr>
                                <td class="text-left" colspan="2"><b>Pain:</b></td>
                                <td class="text-left" colspan="10">{{@$assessment_info->pain_mode == 1 ? "No" : "Yes"}}</td>
                            </tr>

                            <tr>
                                <td class="text-left" colspan="2"><b>Precipitating Factor</b></td>
                                <td class="text-left" colspan="2"><b>Type</b></td>
                                <td class="text-left" colspan="2"><b>Location</b></td>
                                <td class="text-left" colspan="2"><b>Pain Score</b></td>
                                <td class="text-left" colspan="2"><b>Fequency</b></td>
                                <td class="text-left" colspan="2"><b>Duration</b></td>
                            </tr>


                            <tr>
                                <td class="text-left" colspan="2">{{$assessment_info->pain_precipitating}}</td>
                                <td class="text-left" colspan="2">{{$assessment_info->pain_type}}</td>
                                <td class="text-left" colspan="2">{{$assessment_info->pain_location}}</td>
                                <td class="text-left" colspan="2">{{$assessment_info->pain_score}}</td>
                                <td class="text-left" colspan="2">
                                    {{$assessment_info->pain_fequesncy == 1 ? 'Constant' : 'Intermittent'}}
                                </td>
                                <td class="text-left" colspan="2">{{$assessment_info->pain_duration}}</td>
                            </tr>


                            <tr>
                                <td colspan="5" class="text-left custom-form">
                                    <b>ORIENTATION ON FOLLOWING (Patient/Attendant)</b>
                                </td>
                                <td colspan="7">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="side_rails" value="1" name="side_rails" {{$assessment_info->side_rails == 1 ? 'checked' : ''}}>
                                        <label class="form-check-label" for="side_rails"><b>Side rails</b></label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="patients_rights" value="1" name="patients_rights" {{$assessment_info->patients_rights == 1 ? 'checked' : ''}}>
                                        <label class="form-check-label" for="patients_rights"><b>Patient rights of privecy and confidentiality</b></label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="visitor_policy" value="1" name="visitor_policy" {{$assessment_info->visitor_policy == 1 ? 'checked' : ''}}>
                                        <label class="form-check-label" for="visitor_policy"><b>Visitor Policy:</b></label>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td class="text-left" colspan="3"><b>Personal AIDS</b></td>
                                <td class="text-left" colspan="2"><b>Dentures</b></td>
                                <td>
                                    {{$assessment_info->dentures == 1 ? 'No' : 'Yes' }}
                                </td>
                                <td class="text-left" colspan="2"><b>Eyewear</b></td>
                                <td>
                                    {{$assessment_info->eyewear == 1 ? 'No' : 'Yes' }}
                                </td>
                                <td class="text-left"><b>Hearing</b></td>
                                <td colspan="2">
                                    {{$assessment_info->hearing == 1 ? 'No' : 'Yes' }}
                                </td>
                            </tr>

                            <tr>
                                <td class="text-left" colspan="6"><b>VULNERABILITY ASSESSMENT</b></td>
                                <td class="text-left" colspan="6"><b>DVT Assessment with Modified WELLS Scoring</b></td>
                            </tr>

                            <tr>
                                <td class="text-left" colspan="4"><b>Parameters</b></td>
                                <td class="text-left"><b>Yes/No</b></td>
                                <td class="text-left" colspan="5"><b>Clinical characteristics</b></td>
                                <td class="text-center"><b>Score</b></td>
                                <td class="text-center"><b>Tick</b></td>
                            </tr>



                            <tr>
                                <td class="text-left" colspan="4">{{'Children <16 yrs'}}</td>
                                <td class="text-left">
                                    {{$assessment_info->children16 == 1 ? 'No' : 'Yes' }}
                                </td>
                                <td class="text-left" colspan="5" rowspan="2">Active Cancer (previous six months or currently receiving palliative treatment)</td>
                                <td class="text-center" rowspan="2">+1</td>
                                <td class="text-center" rowspan="2"> <input class="score" type="checkbox" id="active_cancer" value="1" name="active_cancer" {{@$assessment_info->active_cancer == 1 ? 'checked' : '' }}></td>
                            </tr>

                            <tr>
                                <td class="text-left" colspan="4">Adolescent</td>
                                <td class="text-left">
                                    {{$assessment_info->adolescent == 1 ? 'No' : 'Yes' }}
                                </td>
                            </tr>




                            <tr>
                                <td class="text-left" colspan="4">{{'Elderly>65 years'}}</td>
                                <td class="text-left">{{$assessment_info->elder65 == 1 ? 'No' : 'Yes' }}</td>
                                <td class="text-left" colspan="5" rowspan="2">Paralysis, paresis or recent plaster immobilization of the lower extremities</td>
                                <td class="text-center" rowspan="2">+1</td>
                                <td class="text-center" rowspan="2"> <input class="score" type="checkbox" id="paralysis_paresis" value="1" name="paralysis_paresis" {{@$assessment_info->paralysis_paresis == 1 ? 'checked' : '' }}></td>
                            </tr>

                            <tr>
                                <td class="text-left" colspan="4">Frail elderly</td>
                                <td class="text-left">
                                    {{$assessment_info->frail_elderly == 1 ? 'No' : 'Yes'}}
                                </td>
                            </tr>



                            <tr>
                                <td class="text-left" colspan="4">{{'Terminally ill/dying'}}</td>
                                <td class="text-left">
                                    {{$assessment_info->terminally_ill == 1 ? 'No' : 'Yes'}}
                                </td>
                                <td class="text-left" colspan="5" rowspan="2">Recently bedridden for ≥ 3 days or major surgery within past 12 weeks under general or regional anaesthesia</td>
                                <td class="text-center" rowspan="2">+1</td>
                                <td class="text-center" rowspan="2"> <input type="checkbox" class="score" id="recently_bedridden" value="1" name="recently_bedridden" {{@$assessment_info->recently_bedridden == 1? 'checked' : ''}}></td>
                            </tr>

                            <tr>
                                <td class="text-left" colspan="4">Not able to do ADL</td>
                                <td class="text-left">
                                    {{$assessment_info->adl == 1 ? 'No' : 'Yes'}}
                                </td>
                            </tr>


                            <tr>
                                <td class="text-left" colspan="4">{{'Intense or chronic pain'}}</td>
                                <td class="text-left">{{$assessment_info->intense_chronic_pain == 1 ? 'No' : 'Yes'}}</td>
                                <td class="text-left" colspan="5" rowspan="2">Localised tendemess along the distribution of the deep venous system</td>
                                <td class="text-center" rowspan="2">+1</td>
                                <td class="text-center" rowspan="2"> <input class="score" type="checkbox" id="localised_tendemess" value="1" name="localised_tendemess" {{@$assessment_info->localised_tendemess ? 'checked' : ''}}></td>
                            </tr>

                            <tr>
                                <td class="text-left" colspan="4">Women in labour</td>
                                <td class="text-left">
                                    {{$assessment_info->women_labour == 1? 'No' : 'Yes'}}

                                </td>
                            </tr>





                            <tr>
                                <td class="text-left" colspan="4">Women experiencing terminations in pregnancy</td>
                                <td class="text-left">
                                        {{@$assessment_info->women_exp_ter_pregnancy == 1 ? 'No' : ''}}
                                        {{@$assessment_info->women_exp_ter_pregnancy == 2 ? 'Yes' : ''}}
                                </td>
                                <td class="text-left" colspan="5">Entire leg swollen</td>
                                <td class="text-center">+1</td>
                                <td class="text-center"> <input class="score" type="checkbox" id="dvt_assessment_swollen" value="1" name="dvt_assessment_swollen" {{@$assessment_info->dvt_assessment_swollen == 1? 'checked' : ''}}></td>
                            </tr>

                            <tr>
                                <td class="text-left" colspan="4">Emotional or psychiatric disorders</td>
                                <td class="text-left">
                                         {{@$assessment_info->emotional_disorder == 1 ? 'No' : ''}}
                                         {{@$assessment_info->emotional_disorder == 2 ? 'Yes' : ''}}
                                </td>
                                <td class="text-left" colspan="5" rowspan="2">Emotional or psychiatric disorders Calf swelling > 3 cm when compared with asymptomatic leg (measured 10 cms below tibial tuberosity)	+1</td>
                                <td class="text-center" rowspan="2">+1</td>
                                <td class="text-center" rowspan="2"> <input class="score" type="checkbox" id="dvt_assessment_calfswelling" value="1" name="dvt_assessment_calfswelling" {{@$assessment_info->dvt_assessment_calfswelling == 1 ? 'checked' : ''}}></td>
                            </tr>
                            <tr>
                                <td class="text-left" colspan="4">Suspected of drug and/or alcohol dependency</td>
                                <td class="text-left">
                                        {{@$assessment_info->drug_dependency == 1 ? 'No' : ''}}
                                        {{@$assessment_info->drug_dependency == 2 ? 'Yes' : ''}}
                                </td>

                            </tr>

                            <tr>
                                <td class="text-left" colspan="4">Victims of abuse or neglect</td>
                                <td class="text-left">
                                    {{@$assessment_info->victim_neglect == 1 ? 'No' : ''}}
                                    {{@$assessment_info->victim_neglect == 2 ? 'Yes' : ''}}
                                </td>
                                <td class="text-left" colspan="5" >Pitting Edema (greater than asymptomatic leg)</td>
                                <td class="text-center" >+1</td>
                                <td class="text-center" > <input class="score" type="checkbox" id="dvt_assessment_pittingedema" value="1" name="dvt_assessment_pittingedema" {{@$assessment_info->dvt_assessment_pittingedema == 1? 'checked' : ''}}></td>
                            </tr>

                            <tr>
                                <td class="text-left" colspan="4">Infectious or communicable diseases</td>
                                <td class="text-left">
                                    {{@$assessment_info->infectious_diseases == 1 ? 'No' : ''}}
                                    {{@$assessment_info->infectious_diseases == 2 ? 'Yes' : ''}}
                                </td>
                                <td class="text-left" colspan="5" >Collateral superficial veins (non varicose)</td>
                                <td class="text-center" >+1</td>
                                <td class="text-center" > <input class="score" type="checkbox" id="dvt_assessment_collateral" value="1" name="dvt_assessment_collateral" {{@$assessment_info->dvt_assessment_collateral == 1? 'checked' : ''}}></td>
                            </tr>
                            <tr>
                                <td class="text-left" colspan="4" rowspan="2">Receiving chemotherapy or radiation therapy</td>
                                <td class="text-left" rowspan="2">
                                    {{@$assessment_info->receiving_therapy == 1 ? 'No' : ''}}
                                    {{@$assessment_info->receiving_therapy == 2 ? 'Yes' : ''}}
                                </td>
                                <td class="text-left" colspan="5" >Previously documented DVT</td>
                                <td class="text-center">+1</td>
                                <td class="text-center"><input class="score" type="checkbox" id="dvt_assessment_previousdt" value="1" name="dvt_assessment_previousdt" {{@$assessment_info->dvt_assessment_previousdt == 1? 'checked' : ''}}></td>
                            </tr>
                            <tr>
                                <td class="text-left" colspan="5">Alternative Diagnosis at least as like as deep vein thrombosis -2</td>
                                <td class="text-center">-2</td>
                                <td class="text-center"><input class="score" type="checkbox" id="dvt_assessment_veinthrombosis" value="1" name="dvt_assessment_veinthrombosis" {{@$assessment_info->dvt_assessment_veinthrombosis == 1? 'checked' : ''}}></td>
                            </tr>

                            @php
                            $clinical_total_score = @$assessment_info->active_cancer +
                                                    @$assessment_info->paralysis_paresis +
                                                    @$assessment_info->recently_bedridden +
                                                    @$assessment_info->localised_tendemess +
                                                    @$assessment_info->dvt_assessment_swollen +
                                                    @$assessment_info->dvt_assessment_calfswelling +
                                                    @$assessment_info->dvt_assessment_pittingedema +
                                                    @$assessment_info->dvt_assessment_collateral +
                                                    @$assessment_info->dvt_assessment_previousdt +
                                                    @$assessment_info->dvt_assessment_veinthrombosis
                        @endphp

                            <tr>
                                <td class="text-left" colspan="4">Immune systems are compromised</td>
                                <td class="text-left">{{$assessment_info->immune_compromised == 1? 'No' : 'Yes'}}</td>
                                <td class="text-left" colspan="5" ><b>Total Score</b></td>
                                <td class="text-center"  colspan="2">{{$clinical_total_score}}</td>
                            </tr>

                            <tr>
                                <td class="text-center" colspan="5"><b>Action Plan</b></td>
                                <td class="text-center" colspan="2" rowspan="5"><b>Risk Store</b></td>
                                <td class="text-left" colspan="5" rowspan="3">
                                    @if($clinical_total_score <= 0)
                                        {{'Low Risk'}}
                                    @elseif($clinical_total_score >= 1 && $clinical_total_score <= 2)
                                        {{'Moderate Risk'}}
                                    @elseif($clinical_total_score >= 3)
                                        {{'High Risk'}}
                                    @endif
                                </td>
                            </tr>

                            <tr>
                                <td class="text-left" colspan="5">

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="provide_assistance" value="1" name="provide_assistance" {{$assessment_info->provide_assistance == 1 ? 'checked' : ''}}>
                                        <label class="form-check-label" for="provide_assistance">Provide Assistance in eating/ toileting/personal hygeiene/ mobilisation</label>
                                    </div>

                                </td>

                            </tr>

                            <tr>
                                <td class="text-left" colspan="3">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="pain_management" value="1" name="pain_management" {{$assessment_info->pain_management == 1 ? 'checked' : ''}}>
                                        <label class="form-check-label" for="pain_management">Pain Mangement</label>
                                    </div>
                                </td>

                                <td class="text-left" colspan="2">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="safety_precaution" value="1" name="safety_precaution" {{$assessment_info->safety_precaution == 1 ? 'checked' : ''}}>
                                        <label class="form-check-label" for="safety_precaution">Safety precaution</label>
                                    </div>
                                </td>


                            </tr>

                            <tr>
                                <td class="text-left" colspan="5">

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="initiate_end_care" value="1" name="initiate_end_care" {{$assessment_info->initiate_end_care == 1 ? 'checked' : ''}}>
                                        <label class="form-check-label" for="initiate_end_care">Initiate end of life care</label>
                                    </div>

                                </td>
                                <td class="text-left">If score is ≥ informed to doctor</td>
                                <td class="text-center" colspan="4">
                                    {{$assessment_info->informed_doctor == 1 ? 'No' : 'Yes'}}
                                </td>
                            </tr>

                        </tbody>
                    </table>

                    <h5><b>HISTORY COLLECTION</b></h5>
                    <table class="table table-bordered">

                        <tbody>
                            <tr>
                                <td style="width:25%" class="text-left">Present complaints:</td>
                                <td style="width:75%">{{$assessment_info->present_complaint}}</td>
                            </tr>
                            <tr>
                                <td style="width:25%" class="text-left">Past medical history:</td>
                                <td style="width:75%">{{$assessment_info->past_med_history}}</td>
                            </tr>
                            <tr>
                                <td style="width:25%" class="text-left">Past surgical history:</td>
                                <td style="width:75%">{{$assessment_info->past_surgical_history}}</td>
                            </tr>
                        </tbody>
                    </table>

                    <h5><b>SKIN INTEGRITY</b></h5>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <td class="text-left" style="15%">Skin intact:</td>
                                <td style="5%">
                                    {{$assessment_info->skin_intact == 1 ? 'No' : 'Yes' }}
                                </td>
                                <td style="25%">
                                    Details with PUSH Score
                                </td>
                                <td style="width:55%">{{$assessment_info->skin_intact_details}}</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-left" style="15%">History of previous pressure injury:</td>
                                <td style="5%">
                                    {{$assessment_info->history_injury == 1 ? 'No' : 'Yes'}}
                                </td>
                                <td style="25%">
                                    Pressure injury currently
                                </td>
                                <td style="width:55%">
                                    {{$assessment_info->pressure_injury == 1 ? 'No' : 'Yes'}}
                                </td>
                            </tr>

                            <tr>
                                <td class="text-left" style="15%">Details:</td>
                                <td colspan="3">
                                    {{$assessment_info->pressure_injury_dtl}}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-left" style="15%">Signature of relatives/bystander:</td>
                                <td colspan="3">
                                    {{@$assessment_info->bystander_signature_name}}
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>









    <!-- 2nd page -->
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th style="width: 15%;border:none"></th>
                    <th style="width: 15%;border:none"></th>
                    <th style="width: 15%;border:none"></th>
                    <th style="width: 15%;border:none"></th>
                    <th style="width: 15%;border:none"></th>
                    <th style="width: 25%;border:none"></th>

                </tr>
                <tr>
                    <th colspan="5">MODIFIED BRADEN PRESSURE ULCER RISK ASSESSMENT SCALE</th>
                    <th>Time</th>
                </tr>
            </thead>

            <tbody>
                <tr>
                    <td class="text-left"><b>Sensory perception</b></td>
                    <td colspan="4">
                            {{@$assessment_info->sensory_perception_value == 1 ? 'Completely limited' : ''}}
                            {{@$assessment_info->sensory_perception_value == 2 ? 'Very limited' : ''}}
                            {{@$assessment_info->sensory_perception_value == 3 ? 'Slightly limited' : ''}}
                            {{@$assessment_info->sensory_perception_value == 4 ? 'No impairment' : ''}}
                    </td>
                    <td class="text-center">
                        {{@$assessment_info->sensory_perception_value}}
                    </td>
                </tr>
                <tr>
                    <td class="text-left"><b>Moisture</b></td>
                    <td colspan="4">
                            {{@$assessment_info->moisture_value == 1 ? 'Constantly moist' : ''}}
                            {{@$assessment_info->moisture_value == 2 ? 'Often moist' : ''}}
                            {{@$assessment_info->moisture_value == 3 ? 'Occasionally moist' : ''}}
                            {{@$assessment_info->moisture_value == 4 ? 'Rarely moist' : ''}}
                    </td>
                    <td class="text-center">
                       {{@$assessment_info->moisture_value}}
                    </td>
                </tr>
                <tr>
                    <td class="text-left"><b>Activity</b></td>
                    <td colspan="4">

                            {{@$assessment_info->activity_value == 1 ? 'Bed fast' : ''}}
                            {{@$assessment_info->activity_value == 2 ? 'Chair fast' : ''}}
                            {{@$assessment_info->activity_value == 3 ? 'Walks Occasionally' : ''}}
                            {{@$assessment_info->activity_value == 4 ? 'Walks frequently' : ''}}
                    </td>
                    <td class="text-center">
                       {{@$assessment_info->activity_value}}
                    </td>
                </tr>
                <tr>
                    <td class="text-left"><b>Mobility</b></td>
                    <td colspan="4">
                        {{@$assessment_info->mobility_value == 1 ? 'Completely limited' : ''}}
                        {{@$assessment_info->mobility_value == 2 ? 'Very limited' : ''}}
                        {{@$assessment_info->mobility_value == 3 ? 'Slightly limited' : ''}}
                        {{@$assessment_info->mobility_value == 4 ? 'No limitation' : ''}}
                    </td>
                    <td class="text-center">
                        {{@$assessment_info->mobility_value}}
                    </td>
                </tr>
                <tr>
                    <td class="text-left"><b>Nutrition</b></td>
                    <td colspan="4">
                        {{@$assessment_info->nutrition_value == 1 ? 'Very poor' : ''}}
                        {{@$assessment_info->nutrition_value == 2 ? 'Probably inadequate' : ''}}
                        {{@$assessment_info->nutrition_value == 3 ? 'Adequate' : ''}}
                        {{@$assessment_info->nutrition_value == 4 ? 'Excellent' : ''}}
                    </td>
                    <td class="text-center">
                        {{@$assessment_info->nutrition_value}}
                    </td>
                </tr>
                <tr>
                    <td class="text-left"><b>Friction and shear</b></td>
                    <td colspan="4">
                            {{@$assessment_info->friction_value == 1 ? 'Problem' : ''}}
                            {{@$assessment_info->friction_value == 2 ? 'Potential problem' : ''}}
                            {{@$assessment_info->friction_value == 3 ? 'No apparent problem' : ''}}
                    </td>
                    <td class="text-center">
                        {{@$assessment_info->friction_value}}
                    </td>
                </tr>
                <tr>
                    <td colspan="5" class="text-right"><b>Total score</b></td>
                    <td class="text-center">
                        @php
                            $total_score = @$assessment_info->sensory_perception_value + @$assessment_info->moisture_value + @$assessment_info->activity_value + @$assessment_info->mobility_value
                                            + @$assessment_info->nutrition_value + @$assessment_info->friction_value;

                        @endphp
                        {{$total_score}}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <td>Time</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td>None</td>
                    <td>Mild</td>
                    <td>Moderate</td>
                    <td>High</td>
                    <td>Severe</td>
                </tr>
                <tr>
                    <td>Risk Scale</td>
                    <td>23,22,21,20,19</td>
                    <td>18,17,16,15</td>
                    <td>14,13</td>
                    <td>12,11,10</td>
                    <td>9,8,7,6</td>
                </tr>
                <tr>
                    <td></td>
                    <td class="text-center">A</td>
                    <td class="text-center">B</td>
                    <td class="text-center">C(A+B)</td>
                    <td class="text-center">C(A+B)</td>
                    <td class="text-center">C(A+B)</td>
                </tr>

                <tr>
                    <td colspan="3" class="text-center"> <b>Plan of care for A</b></td>
                    <td colspan="3" class="text-center"> <b>Follow SKIN care bundle for B and C</b></td>
                </tr>




                @php
                   $plan_a = [23,22,21,20,19];
                   $plan_b = [17,17,16,15,14,13,12,11,10,9,8,7,6];
                   $planA = false;
                   $planB = false;
                    if(in_array($total_score, $plan_a)){
                        $planA = true;
                        $planB = false;
                    }
                    else if(in_array($total_score, $plan_b)){
                        $planA = false;
                        $planB = true;
                    }

                @endphp
                <tr>
                    <td colspan="3" style="width: 50%;padding:0px">
                        <div class="plan-a" style="@if($planA == false ) display: none @endif">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td style="width:70%;border-left:none;border-top:none" class="text-left">Educate patient and family</td>
                                            <td style="width:30%;border-right:none;border-top:none">{{@$assessment_info->a_education}}</td>
                                        </tr>
                                        <tr>
                                            <td style="width:70%;border-left:none;" class="text-left">Evaluate the change of patient condition</td>
                                            <td style="width:30%;border-right:none;">{{@$assessment_info->a_evalution}}</td>
                                        </tr>
                                        <tr>
                                            <td style="width:70%;border-left:none;border-bottom:none" class="text-left">Evaluate the skin condition</td>
                                            <td style="width:30%;border-right:none;border-bottom:none">{{@$assessment_info->a_evalution_skin}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                        </div>
                    </td>
                    <td colspan="3" style="width: 50%;padding:0px">
                        <div class="plan-b" style="@if($planB == false ) display: none @endif">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td style="width:70%;border-top:none" class="text-left"><b>Surface:</b> Wringle free bed, appropriate pillows, Special mattress</td>
                                        <td style="width:30%">{{@$assessment_info->bc_surface}}</td>
                                    </tr>
                                    <tr>
                                        <td style="width:70%;border-top:none" class="text-left"><b>Skin:</b> any device used, release the device and do the skin assessment</td>
                                        <td style="width:30%">{{@$assessment_info->bc_skin}}</td>
                                    </tr>
                                    <tr>
                                        <td style="width:70%;border-top:none" class="text-left"><b>Keep moving:</b> mobilisation and 2hrly position change</td>
                                        <td style="width:30%">{{@$assessment_info->bc_moving}}</td>
                                    </tr>
                                    <tr>
                                        <td style="width:70%;border-top:none" class="text-left"><b>In case of Incontinence:</b> keep skin neat and dry, barrier lotion applied, change soiled diaper/under pad immediately</td>
                                        <td style="width:30%">{{@$assessment_info->bc_incontinence}}</td>
                                    </tr>
                                    <tr>
                                        <td style="width:70%;border-top:none" class="text-left"><b>Nutrition/hydration:</b> promote good nutrition and hydration of patient</td>
                                        <td style="width:30%">{{@$assessment_info->bc_nutrition}}</td>
                                    </tr>
                                    <tr>
                                        <td style="width:70%;border-top:none" class="text-left">Educate patient and family daily</td>
                                        <td style="width:30%;border-bottom:none">{{@$assessment_info->bc_educate}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </td>
                </tr>



                <tr>
                    <td colspan="2"><b>Initial assessment completed at:</b></td>
                    <td>

                        @php  $ini_ass_complete_date = explode(" ", @$assessment_info->ini_ass_complete_date); @endphp
                       @if(!empty(@$ini_ass_complete_date[1])) {{date('h:i:s A', strtotime(@$ini_ass_complete_date[1]))}} @endif
                    </td>
                    <td colspan="2"><b>RN Name / sign with Emp ID:</b></td>
                    <td>
                        {{@$assessment_info->rn_sign_name}}
                    </td>
                </tr>

            </thead>
        </table>
    </div>
    <!-- close second page -->

    <section class="footer-table">
        @php
            $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
            $date = $dt->format('g:i A');
        @endphp

        <table style="width:100%" class="table">
            <tbody>
                <tr>
                    <td style="text-align:left;border:none;width:70%">Staff ID: {{ @$userInfo->user_code }}, Printing Date & Time: {{ date('d/m/Y h:ia') }}</td>
                    <td style="text-align:right;border:none;width:30%">Powered By: NEXTGEN IT</td>
                </tr>
            </tbody>
        </table>
    </section>
</body>
</html>







