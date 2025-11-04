<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Discharge/LAMA/Death Checklist</title>


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
        .header>tbody>tr>td{
            border:none;
        }

        body{
            margin-bottom: 0.6cm;
            margin-left: 1cm;
        }
        .footer-table {
            margin-top: 10px;
        }
        td{
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
        </tbody>
    </table>

    <div style="padding: 7px; border-top:1px dotted black; border-bottom:1px dotted black;text-align:center;margin-top:10px; margin-bottom:20px">
        <span style="font-size: 16px;text-transform:uppercase"><b>Discharge/LAMA/Death ChecklistT</b></span>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th class="text-left" style="width:5%">#SL</th>
                    <th class="text-left" colspan="6">DISCHARGE</th>
                    <th class="text-left" style="width:8%">Yes/No/NA</th>
                </tr>
            </thead>

            <tbody>


                <tr>
                    <td class="text-center">1</td>
                    <td colspan="6" class="text-left">
                        Patient Identification in medicine cover with right patient ,dose,frequency done						
                    </td>

                    <td class="text-center">
                        @if(@$data->pat_identified_dose == 1)
                            {{'No'}}
                        @elseif(@$data->pat_identified_dose == 2)
                            {{'Yes'}}
                        @elseif(@$data->pat_identified_dose == 3)
                            {{'NA'}}
                        @endif
                    </td>
                </tr>

                <tr>
                    <td class="text-center"></td>

                    <td  class="text-left">Verifed by TL</td>
                    <td  class="text-center" style="width: 15%"></td>
                    <td  class="text-center">Name:</td>
                    <td  class="text-center">
                        {{@$data->verified_tl}}
                    </td>
                    <td  class="text-center">Sign</td>
                    <td  class="text-center" colspan="2"></td>

                </tr>


                <tr>
                    <td class="text-center">2</td>
                    <td colspan="6" class="text-left">
                        Discharge medication and summary explained to the patient /by stander
                    </td>

                    <td class="text-center">
                        @if(@$data->explainedpatient == 1)
                            {{'No'}}
                        @elseif(@$data->explainedpatient == 2)
                            {{'Yes'}}
                        @elseif(@$data->explainedpatient == 3)
                            {{'NA'}}
                        @endif
                    </td>
                </tr>
                <tr>
                    <td class="text-center">3</td>
                    <td colspan="6" class="text-left">
                        All medication ticked off in discharge summary (hosoital copy ) and acknowledgement of receipt taken from patient / relatives 

                    </td>

                    <td class="text-center">
                        @if(@$data->patient_rel == 1)
                            {{'No'}}
                        @elseif(@$data->patient_rel == 2)
                            {{'Yes'}}
                        @elseif(@$data->patient_rel == 3)
                            {{'NA'}}
                        @endif
                    </td>
                </tr>

                <tr>
                    <td class="text-center">4</td>
                    <td colspan="6" class="text-left">
                        PFE - Care of tubes ,lines ,drains,pressure injury prevention & management given 
                    </td>

                    <td class="text-center">
                        @if(@$data->pfe_care == 1)
                            {{'No'}}
                        @elseif(@$data->pfe_care == 2)
                            {{'Yes'}}
                        @elseif(@$data->pfe_care == 3)
                            {{'NA'}}
                        @endif
                    </td>
                </tr>
                <tr>
                    <td class="text-center">5</td>
                    <td colspan="6" class="text-left"> PFE - Wound care ,ostomy care,wound dressing ,etc….done </td>

                    <td class="text-center">
                        @if(@$data->pfe_wound == 1)
                            {{'No'}}
                        @elseif(@$data->pfe_wound == 2)
                            {{'Yes'}}
                        @elseif(@$data->pfe_wound == 3)
                            {{'NA'}}
                        @endif
                    </td>
                </tr>
                <tr>
                    <td class="text-center">6</td>
                    <td colspan="6" class="text-left"> Hospital uniform changed to own dress                                                            </td>

                    <td class="text-center">
                        @if(@$data->hos_uniform == 1)
                            {{'No'}}
                        @elseif(@$data->hos_uniform == 2)
                            {{'Yes'}}
                        @elseif(@$data->hos_uniform == 3)
                            {{'NA'}}
                        @endif
                    </td>
                </tr>
                <tr>
                    <td class="text-center">7</td>
                    <td colspan="6" class="text-left"> Removal of ID band  (as required )done                                                            </td>

                    <td class="text-center">
                        @if(@$data->removal_id == 1)
                            {{'No'}}
                        @elseif(@$data->removal_id == 2)
                            {{'Yes'}}
                        @elseif(@$data->removal_id == 3)
                            {{'NA'}}
                        @endif
                    </td>
                </tr>
                <tr>
                    <td class="text-center">8</td>
                    <td colspan="6" class="text-left"> IV Cannula /any other lines /tubes  removed site no bleeding, sealed with micropore .</td>

                    <td class="text-center">
                        @if(@$data->iv_cannula == 1)
                            {{'No'}}
                        @elseif(@$data->iv_cannula == 2)
                            {{'Yes'}}
                        @elseif(@$data->iv_cannula == 3)
                            {{'NA'}}
                        @endif
                    </td>
                </tr>


                <tr>
                    <td class="text-center">9</td>
                    <td colspan="6" class="text-left"> Handed over : Thermometer / Nebulisation mask / o2 mask /Urinal / Bedpan /Plastic basin /Sputum cup / Own Medicines/Fridge medicine / X-ray etc …done </td>

                    <td class="text-center">
                        @if(@$data->handed_over == 1)
                            {{'No'}}
                        @elseif(@$data->handed_over == 2)
                            {{'Yes'}}
                        @elseif(@$data->handed_over == 3)
                            {{'NA'}}
                        @endif
                    </td>
                </tr>

                <tr>
                    <td class="text-center">10</td>
                    <td colspan="6" class="text-left">Received the discharge slip and filed</td>
                    <td class="text-center">
                        @if(@$data->received_slip == 1)
                            {{'No'}}
                        @elseif(@$data->received_slip == 2)
                            {{'Yes'}}
                        @elseif(@$data->received_slip == 3)
                            {{'NA'}}
                        @endif
                    </td>
                </tr>

                <tr>
                    <td class="text-center">11</td>
                    <td colspan="6" class="text-left">Assessed for transportation assistance and arranged as required (Independent/wheel chair/trolley)</td>
                    <td class="text-center">
                        @if(@$data->assessed_for_transport == 1)
                            {{'No'}}
                        @elseif(@$data->assessed_for_transport == 2)
                            {{'Yes'}}
                        @elseif(@$data->assessed_for_transport == 3)
                            {{'NA'}}
                        @endif
                    </td>
                </tr>

                <tr>
                    <td class="text-center">12</td>
                    <td colspan="6" class="text-left">Patient discharged with supportive measures (oxygen /BIPAP/etc….......)</td>
                    <td class="text-center">
                        @if(@$data->discharge_withmeasures == 1)
                            {{'No'}}
                        @elseif(@$data->discharge_withmeasures == 2)
                            {{'Yes'}}
                        @elseif(@$data->discharge_withmeasures == 3)
                            {{'NA'}}
                        @endif
                    </td>
                </tr>

                <tr>
                    <td class="text-center">13</td>
                    <td colspan="6" class="text-left">Bill cleared</td>
                    <td class="text-center">
                        @if(@$data->bill_cleared == 1)
                            {{'No'}}
                        @elseif(@$data->bill_cleared == 2)
                            {{'Yes'}}
                        @elseif(@$data->bill_cleared == 3)
                            {{'NA'}}
                        @endif
                    </td>
                </tr>

                <tr>
                    <td colspan="8" class="text-center fs-3" style="border:none !important;"><b>LAMA</b></td>
                </tr>

                <tr>
                    <td class="text-center">1</td>
                    <td colspan="6" class="text-left">LAMA Consent present</td>
                    <td class="text-center">
                        @if(@$data->lama_consent == 1)
                            {{'No'}}
                        @elseif(@$data->lama_consent == 2)
                            {{'Yes'}}
                        @elseif(@$data->lama_consent == 3)
                            {{'NA'}}
                        @endif
                    </td>
                </tr>

                <tr>
                    <td class="text-center">2</td>
                    <td colspan="6" class="text-left">LAMA Summary given</td>
                    <td class="text-center">
                        @if(@$data->lama_summary == 1)
                            {{'No'}}
                        @elseif(@$data->lama_summary == 2)
                            {{'Yes'}}
                        @elseif(@$data->lama_summary == 3)
                            {{'NA'}}
                        @endif
                    </td>
                </tr>


                <tr>
                    <td colspan="8" class="text-center fs-3" style="border:none !important;"><b>DEATH</b></td>
                </tr>

                <tr>
                    <td class="text-center">1</td>
                    <td colspan="6" class="text-left">Death care given and labelled as per hospital protocols  </td>
                    <td class="text-center">
                        @if(@$data->death_care_given == 1)
                            {{'No'}}
                        @elseif(@$data->death_care_given == 2)
                            {{'Yes'}}
                        @elseif(@$data->death_care_given == 3)
                            {{'NA'}}
                        @endif
                    </td>
                </tr>

                <tr>
                    <td class="text-center">2</td>
                    <td colspan="6" class="text-left">Death certificate handed over to security along with dead body & time</td>
                    <td class="text-center">
                        @if(@$data->death_certificate_body == 1)
                            {{'No'}}
                        @elseif(@$data->death_certificate_body == 2)
                            {{'Yes'}}
                        @elseif(@$data->death_certificate_body == 3)
                            {{'NA'}}
                        @endif
                    </td>
                </tr>



                <tr>
                    <td colspan="8" class="text-left py-2" style="border-left:none; border-right:none">I have received and reviewed my discharge summary with all investigation reports and understand my medication 
                    </td>
                </tr>

                <tr>
                    <td colspan="8" class="text-left py-2" style="border-left:none; border-right:none">schedules ,and the above medication details ,and all the medication received ( as per the bill)
                    </td>
                </tr>


                <tr>
                    <td colspan="4" class="text-left">Name of the Patient /Attenders /Security with Signature </td>
                    <td colspan="4" class="text-left">Relationship with Patient</td>
                </tr>
                <tr>
                    <td colspan="4" class="text-left"></td>
                    <td colspan="4" class="text-left">{{!empty($data->relation_patient) ? $data->relation_patient : 'N/A'}}</td>
                </tr>

                <tr>
                    <td colspan="2" class="text-left">Name of RN with sign :</td>
                    <td colspan="2" class="text-left"></td>
                    <td colspan="2" class="text-left">EMP ID:</td>
                    <td colspan="2" class="text-left"></td>
                </tr>
                <tr>
                    <td colspan="2" class="text-left">Date :</td>
                    <td colspan="2" class="text-left"></td>
                    <td colspan="2" class="text-left">Physically vacated time:</td>
                    <td colspan="2" class="text-left"></td>
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
                    <td style="text-align:left;border:none;width:70%">Staff ID: {{ @$userInfo->user_code }}, Printing Date & Time: {{ date('d/m/Y h:ia') }}</td>
                    <td style="text-align:right;border:none;width:30%">Powered By: NEXTGEN IT</td>
                </tr>
            </tbody>
        </table>
    </section>
</body>
</html>


                          




