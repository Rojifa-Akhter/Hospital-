<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Pre Anesthesia Assessment Form</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    {{-- <link rel="stylesheet" href="{{ public_path().'/css/print.css' }}" media="print"> --}}
    {{-- <link rel="stylesheet" href="{{ public_path().'css/purchase_order_print.css' }}" media="print"> --}}
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


        /** Define the header rules **/
        header {
            position: fixed;
            top: 0;
            height: 2cm;
            border-bottom: 1px solid;
            padding: 0 1cm;
        }

        header img {
            /*width: 80px;*/
        }

        /** Define now the real margins of every page in the PDF **/
        body {
            margin-top: 2cm;
            margin-left: .3cm;
            margin-right: .3cm;
            margin-bottom: 2cm;
            font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
            font-size: 11px;
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

        .signature_ {
            position: fixed;
            bottom: 1.6cm;
            left: .8cm;
            right: .8cm;
            width: 100%;
            /* text-align: center; */

            /* border-top: 1px solid; */
        }

        tfoot tr td {
            font-weight: bold;
        }

        .page-break {
            page-break-after: always;
        }

        .mt-5 {
            margin-top: 5px;
        }

        .mt-10 {
            margin-top: 10px;
        }

        .mt-20 {
            margin-top: 20px;
        }

        .mb-0 {
            margin-bottom: 0;
        }

        .mb-5 {
            margin-bottom: 15px;
        }

        .pb-0 {
            padding-bottom: 0;
        }

        /* table {
            border: 1px solid #222;
            border-spacing: 0;
        }

        td {
            border-bottom: 1px solid #222;
            border-right: 1px solid #222;
        }

        table td:last-child {
            border-right: 0px solid transparent;
        }

        th {
            border-top: 1px solid #222;
        } */

        th,
        td {
            padding-left: 5px;
            padding-right: 5px;
        }

        #info td {
            border: 1px solid rgb(177, 175, 175);
        }
    </style>
</head>

<body>
    <header>
        <table style="width: 100%; border:none;" class="signature">
            <tr>
                <td style="width: 15%; border:none;">
                    <img class="hospital-logo" src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}" width="60" alt="">
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
        <div class="wrapper">
            <div style=" text-align:center; margin-bottom:5px; margin-top:20px  " class="mb-2">
                <span class="report-name" style="width:100%; font-size:20px ;  padding:10px;  "> <strong> Pre Anesthesia Assessment Form </strong></span>
            </div>
            {{-- <div style=" text-align:center;  width:100%; margin-bottom:10px" class="mb-2">
                <span class="report-date"><strong>From Date: {{ $from_date }}</strong> - <span class="report-date"><strong>To Date: {{ $to_date }}</strong></span>
            </span>
        </div> --}}
        <section id="lp-items">
            <div class="container">
                <div style="">
                    <h3>Patient Information</h3>
                </div>
                <div style=" border: 1 solid rgb(177, 175, 175);  border-radius: 5px;">

                    <table width="100%">
                        <tr>
                            <td colspan="2">
                                <div> <strong> Name of patient </strong></div>
                                <div>{{ isset($pat_info->patient_name) ? $pat_info->patient_name : 'N/A' }}</div>
                            </td>
                            <td>
                                <div><strong>Patient Id</strong></div>
                                {{ isset($pat_info->patient_code) ? $pat_info->patient_code : 'N/A' }}
                            </td>
                            <td>
                                <div><strong>Age</strong></div>
                                {{ isset($pat_info->age) ? $pat_info->age : 'N/A' }}
                            </td>
                            <td>
                                <div><strong>Sex</strong></div>
                                {{ isset($pat_info->gender_txt) ? $pat_info->gender_txt : 'N/A' }}
                            </td>
                            <td>
                                <div><strong> B. Group</strong></div>
                                {{ isset($pat_info->blood_group_text) ? $pat_info->blood_group_text : 'N/A' }}
                            </td>

                        </tr>
                        <tr>
                            <td>
                                <div> <strong> Department </strong></div>
                                <div>{{ isset($pat_info->new_su_name) ? $pat_info->new_su_name : 'N/A' }}</div>
                            </td>
                            <td>
                                <div><strong>Ward</strong></div>
                                {{ isset($pat_info->new_ward_name) ? $pat_info->new_ward_name : 'N/A' }}
                            </td>
                            <td>
                                <div><strong>Bed</strong></div>
                                {{ isset($pat_info->new_bed_name) ? $pat_info->new_bed_name : 'N/A' }}
                            </td>
                            <td>
                                <div><strong>Date</strong></div>
                                {{ isset($anesthetics_checkup_form->ot_date) ? date('d-m-Y',strtotime($anesthetics_checkup_form->ot_date)) : 'N/A' }}
                            </td>
                        </tr>

                        <tr>
                            <td colspan="6">
                                <div> <strong>Referred Doctor</strong></div>
                                <div>
                                    {{ isset($pat_info->primary_doctor_name) ? $pat_info->primary_doctor_name : 'N/A' }}
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
                <table width="100%" id="info" style="border-collapse: collapse;margin-top:10px">
                    <tr>
                        <td>
                            <strong> Weight </strong>
                            <div> {{ isset($anesthetics_checkup_form->weight)  ? $anesthetics_checkup_form->weight: 'N/A' }}</div>
                        </td>
                        <td>
                            <strong> Height </strong>
                            <div>{{ isset($anesthetics_checkup_form->height)  ? $anesthetics_checkup_form->height: 'N/A' }}</div>
                        </td>
                        <td>
                            <strong> BMI </strong>
                            <div> {{ isset($anesthetics_checkup_form->bmi)  ? $anesthetics_checkup_form->bmi: 'N/A' }}</div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong> Smoker : </strong>
                            <div> {{ isset($anesthetics_checkup_form->smooker)  ? $anesthetics_checkup_form->smooker : '' }} </div>
                        </td>
                        <td>
                            <strong> Alcohol : </strong> 
                            <div> {{ isset($anesthetics_checkup_form->alcohol) ? $anesthetics_checkup_form->alcohol: '' }} </div> 
                        </td>
                        <td>
                            <strong> Artificial Denture : </strong> 
                            <div> {{ isset($anesthetics_checkup_form->artificial_denture) ? $anesthetics_checkup_form->artificial_denture: '' }} </div> 
                        </td>
                    </tr>
                </table>
                <table width="100%" id="info" style="border-collapse: collapse;">
                    <tr>
                        <td colspan="6">
                            <strong>Previous Anesthesia : (Complications if any)</strong>
                            {{ isset($anesthetics_checkup_form->previous_anesthesia)  ? $anesthetics_checkup_form->previous_anesthesia : '' }}
                        </td>
                    </tr>
                    {{-- <tr>
                        <td>
                            <strong> Associated Medical Problem: </strong>
                            {{ isset($anesthetics_checkup_form->associated_medical_problem)  ? $anesthetics_checkup_form->associated_medical_problem : '' }}
                        </td>
                    </tr> --}}

                    <tr>
                        <td colspan="6"><strong>Co-existing diseases with duration :</strong></td>
                    </tr>
                        <tr>
                            <td style="">
                                <strong> Hypertension : </strong> 
                                <div>{{ isset($anesthetics_checkup_form->hypertension) ? $anesthetics_checkup_form->hypertension : '' }}</div>
                            </td>
                            <td style="">
                                <strong> IHD : </strong> 
                                <div>{{ isset($anesthetics_checkup_form->ihd) ? $anesthetics_checkup_form->ihd : '' }}</div>
                            </td>

                            <td style="">
                                <strong> Myocardial infarction: </strong> 
                                <div>{{ isset($anesthetics_checkup_form->myocardial) ? $anesthetics_checkup_form->myocardial : '' }}</div>
                            </td>
                            <td style="">
                                <strong>Diabetes : </strong>
                                <div>{{ isset($anesthetics_checkup_form->diabetes) ? $anesthetics_checkup_form->diabetes : '' }}</div>
                            </td>
                            <td style="">
                                <strong>Thyroid disorder : </strong>
                                <div>{{ isset($anesthetics_checkup_form->thyroid_disorder) ? $anesthetics_checkup_form->thyroid_disorder : '' }}</div>
                            </td>
                            <td style="">
                                <strong>Others : </strong>
                                <div>{{ isset($anesthetics_checkup_form->others_medical_problem) ? $anesthetics_checkup_form->others_medical_problem : '' }}</div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="6">
                                <strong> Present Medication: </strong>
                                {{ isset($anesthetics_checkup_form->present_medication)  ? $anesthetics_checkup_form->present_medication : '' }}
                            </td>
                        </tr>

                    <tr>
                        <td colspan="6">
                            <strong> Allergy: </strong>
                            {{ isset($anesthetics_checkup_form->allergy)  ? $anesthetics_checkup_form->allergy : '' }}
                        </td>
                    </tr>
                    {{-- <tr>
                        <td colspan="6">
                            <strong> Condition of Teeth: </strong>
                            {{ isset($anesthetics_checkup_form->condition_of_teeth)  ? $anesthetics_checkup_form->condition_of_teeth : '' }}
                        </td>
                    </tr> --}}
                </table>
                {{-- <table width="100%" id="info" style="border-collapse: collapse;margin-top:10px">
                    <tr>
                        <td>
                            <strong>Allergy : </strong> {{ isset($anesthetics_checkup_form->allergy)  ? $anesthetics_checkup_form->allergy: '' }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong> Smooker : </strong> {{ isset($anesthetics_checkup_form->smooker)  ? $anesthetics_checkup_form->smooker : '' }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong> Alcohol : </strong> {{ isset($anesthetics_checkup_form->alcohol) ? $anesthetics_checkup_form->alcohol: '' }}
                        </td>
                    </tr>

                </table> --}}
                {{-- <h2>Associated Medical Problem with duration :</h2> --}}
                {{-- <table width="100%" id="info" style="border-collapse: collapse;margin-top:10px">
                    <tr>
                        <td style="">
                            <strong> Hypertension : </strong> {{ isset($anesthetics_checkup_form->hypertension) ? $anesthetics_checkup_form->hypertension : '' }}
                        </td>
                        <td style="">
                            <strong> IHD : </strong> {{ isset($anesthetics_checkup_form->ihd) ? $anesthetics_checkup_form->ihd : '' }}
                        </td>

                        <td style="">
                            <strong> Myocardial infarction: </strong> {{ isset($anesthetics_checkup_form->myocardial) ? $anesthetics_checkup_form->myocardial : '' }}
                        </td>
                        <td style="">
                            <strong>Diabetes :</strong>
                            {{ isset($anesthetics_checkup_form->diabetes) ? $anesthetics_checkup_form->diabetes : '' }}
                        </td>
                        <td style="">
                            <strong>Thyroid disorder :</strong>
                            {{ isset($anesthetics_checkup_form->thyroid_disorder) ? $anesthetics_checkup_form->thyroid_disorder : '' }}
                        </td>
                        <td style="">
                            <strong>Others :</strong>
                            {{ isset($anesthetics_checkup_form->others_medical_problem) ? $anesthetics_checkup_form->others_medical_problem : '' }}
                        </td>
                    </tr>

                </table> --}}
                <table width="100%" id="info" style="border-collapse: collapse;margin-top:10px">
                    {{-- <tr>
                        <td>
                            <strong> Present Medication: </strong>
                            {{ isset($anesthetics_checkup_form->present_medication)  ? $anesthetics_checkup_form->present_medication : '' }}
                        </td>
                    </tr> --}}
                    {{-- <tr>
                        <td>
                            <strong>Previous anesthesia- number & anesthesia type and complication ( If any) : </strong> {{ isset($anesthetics_checkup_form->pre_anes_and_comp) ? $anesthetics_checkup_form->pre_anes_and_comp : '' }}
                        </td>
                    </tr> --}}
                </table>
                <div style="margin-top:10px">

                    <table width="100%" id="info" style="border-collapse: collapse;">
                        <tr>
                            <td>
                                <strong> Preoperative Diagnosis : </strong> {{ isset($anesthetics_checkup_form->preoperative_diagnosis)  ? $anesthetics_checkup_form->preoperative_diagnosis: '' }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong> Proposed surgery : </strong> {{ isset($anesthetics_checkup_form->proposed_surgery)  ? $anesthetics_checkup_form->proposed_surgery : '' }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong> Date of Surgery : </strong> {{ isset($anesthetics_checkup_form->scheduled_surgery_date) ? date('d/m/Y', strtotime($anesthetics_checkup_form->scheduled_surgery_date)) : '' }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong> Operation : </strong> {{ isset($anesthetics_checkup_form->operation) ? $anesthetics_checkup_form->operation : '' }}
                            </td>
                        </tr>
                    </table>

                    {{-- <h2>Pre-Operative Data :</h2> --}}
                    <table width="100%" id="info" style="border-collapse: collapse;">
                        <!-- <tr>
                            <td colspan="4">
                                <strong> Clinical Examination : </strong> {{ isset($anesthetics_checkup_form->clinical_exam)  ? $anesthetics_checkup_form->clinical_exam: '' }}
                            </td>

                        </tr> -->
                        <tr>
                            <td colspan="4">
                                <strong> General Examination : </strong> {{ isset($anesthetics_checkup_form->general_exam)  ? $anesthetics_checkup_form->general_exam: '' }}
                            </td>

                        </tr>
                        <tr>
                            <td>
                                <strong>Pulse : </strong>
                            </td>
                            <td>
                                {{ isset($anesthetics_checkup_form->pulse)  ? $anesthetics_checkup_form->pulse: '' }}
                            </td>
                            <td>
                                <strong> Jaundice : </strong>
                            </td>
                            <td>
                                {{ isset($anesthetics_checkup_form->jaundice)  ? $anesthetics_checkup_form->jaundice: '' }}
                            </td>

                        </tr>
                        <tr>
                            <td>
                                <strong>BP : </strong>
                            </td>
                            <td>
                                {{ isset($anesthetics_checkup_form->bp)  ? $anesthetics_checkup_form->bp: '' }}
                            </td>
                            <td>
                                <strong> Cyanosis : </strong>
                            </td>
                            <td>
                                {{ isset($anesthetics_checkup_form->cyanosis)  ? $anesthetics_checkup_form->cyanosis: '' }}
                            </td>

                        </tr>
                        <tr>
                            <td>
                                <strong>Temperature : </strong>
                            </td>
                            <td>
                                {{ isset($anesthetics_checkup_form->temperature)  ? $anesthetics_checkup_form->temperature: '' }}
                            </td>
                            <td>
                                <strong> Odema : </strong>
                            </td>
                            <td>
                                {{ isset($anesthetics_checkup_form->oedema)  ? $anesthetics_checkup_form->oedema: '' }}
                            </td>

                        </tr>
                        <tr>

                            <td>
                                <strong> SPO<sub>2</sub> : </strong>
                            </td>
                            <td>
                                {{ isset($anesthetics_checkup_form->spo2)  ? $anesthetics_checkup_form->spo2: '' }}
                            </td>
                            <td>
                                <strong>Anemia : </strong>
                            </td>
                            <td>
                                {{ isset($anesthetics_checkup_form->anemia)  ? $anesthetics_checkup_form->anemia: '' }}
                            </td>

                        </tr>
                        <tr>
                            <td colspan="2">
                                <strong>Systemic Examination : </strong>
                                {{ isset($anesthetics_checkup_form->systemic_exam)  ? $anesthetics_checkup_form->systemic_exam: '' }}
                            </td>
                            <td>
                                <strong>Cough : </strong>
                            </td>
                            <td>
                                {{ isset($anesthetics_checkup_form->cough)  ? $anesthetics_checkup_form->cough: '' }}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <strong>Central Nervous system : </strong>
                                {{ isset($anesthetics_checkup_form->cns)  ? $anesthetics_checkup_form->cns: '' }}
                            </td>
                            <td>
                                <strong>Others : </strong>
                            </td>
                            <td>
                                {{ isset($anesthetics_checkup_form->clinical_exam_others)  ? $anesthetics_checkup_form->clinical_exam_others: '' }}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4">
                                <strong>Cardiovascular system : </strong>
                                {{ isset($anesthetics_checkup_form->cvs)  ? $anesthetics_checkup_form->cvs: '' }}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4">
                                <strong> Respiratory System : </strong>
                                {{ isset($anesthetics_checkup_form->respiratory_system)  ? $anesthetics_checkup_form->respiratory_system: '' }}
                            </td>
                        </tr>
                        <!-- <tr>
                            <td colspan="4">
                                <strong>GIT : </strong>
                                {{ isset($anesthetics_checkup_form->git)  ? $anesthetics_checkup_form->git: '' }}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4">
                                <strong> Renal System : </strong>
                                {{ isset($anesthetics_checkup_form->renal_system)  ? $anesthetics_checkup_form->renal_system: '' }}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4">
                                <strong> Metabolic : </strong>
                                {{ isset($anesthetics_checkup_form->metabolic)  ? $anesthetics_checkup_form->metabolic: '' }}
                            </td>
                        </tr> -->
                        <tr>
                            <td colspan="4">
                                <strong> Others: </strong>
                                {{ isset($anesthetics_checkup_form->others)  ? $anesthetics_checkup_form->others : '' }}
                            </td>
                        </tr>
                    </table>

                    <h2>Airway Assessment : </h2>
                    <table width="100%" id="info" style="border-collapse: collapse;">
                        {{-- <tr>
                            <td colspan="4">
                                <strong> Airway Assessment: </strong>
                                {{ isset($anesthetics_checkup_form->airway_exam)  ? $anesthetics_checkup_form->airway_exam : '' }}
                            </td>
                        </tr> --}}

                        <tr>
                            <td colspan="4">
                                <strong> Mouth opening > 2 fingers: </strong>
                                {{ isset($anesthetics_checkup_form->mouth_opening)  ? $anesthetics_checkup_form->mouth_opening : '' }}
                            </td>
                        </tr>
                        
                        <tr>
                            <td colspan="4">
                                <strong> Thyromental distance > 3 fingers: </strong>
                                {{ isset($anesthetics_checkup_form->thyromental_distance)  ? $anesthetics_checkup_form->thyromental_distance : '' }}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4">
                                <strong> Neck Movement- Full/ Restricted: </strong>
                                {{ isset($anesthetics_checkup_form->neck_movement) && $anesthetics_checkup_form->neck_movement == 1 ? 'Full' : 'Restricted' }}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="">
                                <strong>
                                    {{ isset($anesthetics_checkup_form->short_neck)  ? $anesthetics_checkup_form->short_neck : '' }} </strong>
                            </td>
                            <td colspan="">
                                <strong>
                                    {{ isset($anesthetics_checkup_form->neck_swelling)  ? $anesthetics_checkup_form->neck_swelling : '' }} </strong>
                            </td>
                            <td colspan="2">
                                <strong>
                                    {{-- {{ isset($anesthetics_checkup_form->neck_movement)  ? $anesthetics_checkup_form->neck_movement : '' }}  --}}
                                </strong>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="4">
                                <strong> Artificial denture : </strong>
                                {{ isset($anesthetics_checkup_form->airway_artificial_denture) && $anesthetics_checkup_form->airway_artificial_denture == 1 ? 'Yes' : 'No' }}

                            </td>
                        </tr>
                        <tr>
                            <td colspan="4">
                                <strong> Mallampati : </strong>
                                {{ isset($anesthetics_checkup_form->mallampati_score)  ? $anesthetics_checkup_form->mallampati_score : '' }}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4">
                                <strong> Presence Beard: </strong>
                                {{ isset($anesthetics_checkup_form->presence_of_bread)  ? $anesthetics_checkup_form->presence_of_bread : '' }}
                            </td>
                        </tr>

                    </table>
                    {{-- <h2>Summary note/ Consideration for attending anesthesiologist:</h2> --}}
                    <h2>Consideration for operating room anesthesiologist:</h2>
                    <table width="100%" id="info" style="border-collapse: collapse;">
                        <tr>
                            <td colspan="4">
                                <strong> Artificial Denture : </strong>
                                {{ !empty($anesthetics_checkup_form->coniser_artificial_denture) && $anesthetics_checkup_form->coniser_artificial_denture == '1' ? 'Yes' : 'No' }}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4">
                                <strong> Airway : </strong>
                                {{ !empty($anesthetics_checkup_form->airway) && $anesthetics_checkup_form->airway == '1' ? 'Normal' : 'Difficult' }}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4">
                                <strong>Co-Existing Disease : </strong>
                               {{ isset($anesthetics_checkup_form->co_existing) ? $anesthetics_checkup_form->co_existing : '' }}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4">
                                <strong> ASA Class : </strong>
                                {{ isset($anesthetics_checkup_form->asa_class1) ? $anesthetics_checkup_form->asa_class1 : '' }}  {{ isset($anesthetics_checkup_form->asa_class2) ? $anesthetics_checkup_form->asa_class2 : '' }}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4">
                                <strong> NYHA Classification: </strong>
                                {{ isset($anesthetics_checkup_form->nyha_classification)  ? $anesthetics_checkup_form->nyha_classification : '' }}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4">
                                <strong> Mallampati grade : </strong>
                                {{ isset($anesthetics_checkup_form->mallampati_grade)  ? $anesthetics_checkup_form->mallampati_grade : '' }}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4">
                                <strong> Type of Anesthesia Discussed : </strong>
                                {{ isset($anesthetics_checkup_form->tad_ga)  ? $anesthetics_checkup_form->tad_ga : '' }} &nbsp;&nbsp;&nbsp;&nbsp;
                                {{ isset($anesthetics_checkup_form->tad_spinal)  ? $anesthetics_checkup_form->tad_spinal : '' }} &nbsp;&nbsp;&nbsp;&nbsp;
                                {{ isset($anesthetics_checkup_form->tad_epidural)  ? $anesthetics_checkup_form->tad_epidural : '' }} &nbsp;&nbsp;&nbsp;&nbsp;
                                {{ isset($anesthetics_checkup_form->tad_nerve_block)  ? $anesthetics_checkup_form->tad_nerve_block : '' }}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4">
                                <strong> Pain Relief Discussed: </strong>
                                {{ isset($anesthetics_checkup_form->prd_pca)  ? $anesthetics_checkup_form->prd_pca : '' }} &nbsp;&nbsp;&nbsp;&nbsp;
                                {{ isset($anesthetics_checkup_form->prd_epidural_infusion)  ? $anesthetics_checkup_form->prd_epidural_infusion : '' }} &nbsp;&nbsp;&nbsp;&nbsp;
                                {{ isset($anesthetics_checkup_form->prd_pceaororal)  ? $anesthetics_checkup_form->prd_pceaororal : '' }} &nbsp;&nbsp;&nbsp;&nbsp;
                                {{ isset($anesthetics_checkup_form->prd_im)  ? $anesthetics_checkup_form->prd_im : '' }} &nbsp;&nbsp;&nbsp;&nbsp;
                                {{ isset($anesthetics_checkup_form->prd_iv)  ? $anesthetics_checkup_form->prd_iv : '' }} &nbsp;&nbsp;&nbsp;&nbsp;
                                {{ isset($anesthetics_checkup_form->prd_per_rectal)  ? $anesthetics_checkup_form->prd_per_rectal : '' }}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4">
                                <strong> Risk factor( if any): </strong>
                                {{ isset($anesthetics_checkup_form->risk_factor)  ? $anesthetics_checkup_form->risk_factor : '' }}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4">
                                <strong> Others: </strong>
                                {{ isset($anesthetics_checkup_form->remarks)  ? $anesthetics_checkup_form->remarks : '' }}
                            </td>
                        </tr>
                    </table>
                    <h2>Investigation</h2>
                    <table width="100%" id="info" style="border-collapse: collapse;">
                        <tr>
                            <td>
                                <strong> HB : </strong>
                                {{ isset($anesthetics_checkup_form->hb_pcv) ? $anesthetics_checkup_form->hb_pcv : '' }}
                            </td>
                            <td>
                                <strong> PCV : </strong>
                                {{ isset($anesthetics_checkup_form->pcv) ? $anesthetics_checkup_form->pcv : '' }}
                            </td>
                            <td>
                                <strong> WBC : </strong>
                                {{ isset($anesthetics_checkup_form->wbc) ? $anesthetics_checkup_form->wbc : '' }}
                            </td>
                            <td>
                                <strong> Platelets : </strong>
                                {{ isset($anesthetics_checkup_form->platelet_count) ? $anesthetics_checkup_form->platelet_count : '' }}
                            </td>
                            <td>
                                <strong> Blood sugar:( Fasting/Random) : </strong>
                                {{-- {{ isset($anesthetics_checkup_form->fbs_rbs) ? $anesthetics_checkup_form->fbs_rbs : '' }} --}}
                                {{ !empty($anesthetics_checkup_form->blood_suger) && $anesthetics_checkup_form->blood_suger == '1' ? 'Yes' : 'No' }}
                            </td>

                        </tr>
                        <tr>
                            <td>
                                <strong> HbA1C : </strong>
                                {{ isset($anesthetics_checkup_form->hba1c) ? $anesthetics_checkup_form->hba1c : '' }}
                            </td>
                            <td>
                                <strong> Blood Group : </strong>
                                {{ isset($anesthetics_checkup_form->blood_group) ? $anesthetics_checkup_form->blood_group : '' }}
                            </td>
                            <td>
                                <strong> TSH : </strong>
                                {{ isset($anesthetics_checkup_form->tsh) ? $anesthetics_checkup_form->tsh : '' }}
                            </td>
                            <td>
                                <strong>T3/T4: </strong>
                                {{ isset($anesthetics_checkup_form->t3_t4) ? $anesthetics_checkup_form->t3_t4 : '' }}
                            </td>
                          
                            <td>
                                <!-- <strong> SGPT : </strong>
                                {{ isset($anesthetics_checkup_form->sgpt) ? $anesthetics_checkup_form->sgpt : '' }} -->
                            </td>

                        </tr>
                        
                        <tr>
                            <td>
                                <strong>Serum - [Na+]: </strong>
                                {{ isset($anesthetics_checkup_form->na) ? $anesthetics_checkup_form->na : '' }}
                            </td>
                            <td>
                                <strong> [K+] : </strong>
                                {{ isset($anesthetics_checkup_form->k) ? $anesthetics_checkup_form->k : '' }}
                            </td>
                            <td>
                                <strong> [CL] : </strong>
                                {{ isset($anesthetics_checkup_form->cl) ? $anesthetics_checkup_form->cl : '' }}
                            </td>
                            <td>
                                <strong> Creat. : </strong>
                                {{ isset($anesthetics_checkup_form->screatinine) ? $anesthetics_checkup_form->screatinine : '' }}
                            </td>
                            <td>
                                <strong>Urea : </strong>
                                {{ isset($anesthetics_checkup_form->urea) ? $anesthetics_checkup_form->urea : '' }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Coags - PT : </strong>
                                {{ isset($anesthetics_checkup_form->pt) ? $anesthetics_checkup_form->pt : '' }}
                            </td>
                            <td>
                                <strong> APTT : </strong>
                                {{ isset($anesthetics_checkup_form->aptt) ? $anesthetics_checkup_form->aptt : '' }}
                            </td>

                            <td>
                                <strong>INR : </strong>
                                {{ isset($anesthetics_checkup_form->inr) ? $anesthetics_checkup_form->inr : '' }}
                            </td>
                            <td>
                                 <strong> BT : </strong>
                                {{ isset($anesthetics_checkup_form->bt) ? $anesthetics_checkup_form->bt : '' }}
                            </td>
                            <td>
                                <strong>CT: </strong>
                                {{ isset($anesthetics_checkup_form->ct) ? $anesthetics_checkup_form->ct : '' }}
                            </td>

                        </tr>
                        <tr>

                            <td>
                                <strong>ABG - pH : </strong>
                                {{ isset($anesthetics_checkup_form->ph) ? $anesthetics_checkup_form->ph : '' }}
                            </td>
                            <td>
                                <strong>ABG - paO <sub>2</sub> : </strong>
                                {{ isset($anesthetics_checkup_form->pao2) ? $anesthetics_checkup_form->pao2 : '' }}
                            </td>
                            <td>
                                <strong>ABG - paCO <sub>2</sub> : </strong>
                                {{ isset($anesthetics_checkup_form->paco2) ? $anesthetics_checkup_form->paco2 : '' }}
                            </td>
                           
                            <td>
                                <strong>BE : </strong>
                                {{ isset($anesthetics_checkup_form->be) ? $anesthetics_checkup_form->be : '' }}
                            </td>
                            <td>
                                <strong>HCo <sub>3</sub> : </strong>
                                {{ isset($anesthetics_checkup_form->nco2) ? $anesthetics_checkup_form->nco2 : '' }}
                            </td>

                        </tr>
                        <tr>
                            <td>
                                <strong> HbsAg : </strong>
                                {{ isset($anesthetics_checkup_form->hbsag) ? $anesthetics_checkup_form->hbsag : '' }}
                            </td>
                            <td>
                                <strong> HCB : </strong>
                                {{ isset($anesthetics_checkup_form->hcv) ? $anesthetics_checkup_form->hcv : '' }}
                            </td>

                            <td>
                                <strong>HIV : </strong>
                                {{ isset($anesthetics_checkup_form->hiv) ? $anesthetics_checkup_form->hiv : '' }}
                            </td>
                            <td></td>
                            <td></td>
                        </tr>

                        <tr>
                            <td colspan="3">
                                <strong>Liver function test</strong>
                                {{ isset($anesthetics_checkup_form->lft) ? $anesthetics_checkup_form->lft : '' }}
                            </td>
                            <td colspan="2">
                                <strong>CXR : </strong>
                                {{ isset($anesthetics_checkup_form->cxr) ? $anesthetics_checkup_form->cxr : '' }}
                            </td>
                        </tr>

                        <tr>
                            <td colspan="3">
                                <strong>ECG : </strong>
                                {{ isset($anesthetics_checkup_form->ecg) ? $anesthetics_checkup_form->ecg : '' }}
                            </td>
                            <td colspan="2">
                                <strong>Echo : </strong>
                                {{ isset($anesthetics_checkup_form->echo) ? $anesthetics_checkup_form->echo : '' }}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="5">
                                <strong>Others : </strong>
                                {{ isset($anesthetics_checkup_form->other2) ? $anesthetics_checkup_form->other2 : '' }}
                            </td>
                        </tr>
                    </table>
                    <table width="100%" id="info" style="border-collapse: collapse;">
                        {{-- <tr>
                            <td colspan="4">
                                <strong> ASA Class: </strong>
                                {{ isset($anesthetics_checkup_form->asa_class)  ? $anesthetics_checkup_form->asa_class : '' }}
                            </td>
                        </tr> --}}
                        {{-- <tr>
                            <td colspan="4">
                                <strong> NYHA Classification: </strong>
                                {{ isset($anesthetics_checkup_form->nyha_classification)  ? $anesthetics_checkup_form->nyha_classification : '' }}
                            </td>
                        </tr> --}}
                    </table>

                    <table width="100%" id="info" style="border-collapse: collapse;">
                        {{-- <tr>
                            <td>
                                <strong>Thyroid function test/LFT : </strong>
                                {{ isset($anesthetics_checkup_form->lft) ? $anesthetics_checkup_form->lft : '' }}
                            </td>
                            <td>
                                <strong>CXR : </strong>
                                {{ isset($anesthetics_checkup_form->cxr) ? $anesthetics_checkup_form->cxr : '' }}
                            </td>

                        </tr> --}}
                        {{-- <tr>
                            <td>
                                <strong>ECG : </strong>
                                {{ isset($anesthetics_checkup_form->ecg) ? $anesthetics_checkup_form->ecg : '' }}
                            </td>
                            <td>
                                <strong>Echo : </strong>
                                {{ isset($anesthetics_checkup_form->echo) ? $anesthetics_checkup_form->echo : '' }}
                            </td>
                            <!-- <td>
                                <strong>ABG</strong>
                                {{ isset($anesthetics_checkup_form->abg) ? $anesthetics_checkup_form->abg : '' }}
                            </td> -->

                        </tr> --}}
                        {{-- <td>
                            <strong>Blood - Saved : </strong>
                            {{ isset($anesthetics_checkup_form->saved) ? $anesthetics_checkup_form->saved : '' }}
                        </td>
                        <td>
                            <strong> Cross matched :</strong>
                            {{ isset($anesthetics_checkup_form->cross_matched) ? $anesthetics_checkup_form->cross_matched : '' }}
                        </td> --}}

                        {{-- </tr> --}}
                        {{-- <tr>
                            <td colspan="2">
                                <strong>Others : </strong>
                                {{ isset($anesthetics_checkup_form->other2) ? $anesthetics_checkup_form->other2 : '' }}
                            </td>
                        </tr> --}}
                    </table>
                    {{-- <h2>Preoperative Instructions:</h2>
                    <table width="100%" id="info" style="border-collapse: collapse;">
                        <tr>
                            <td style="width: 200px;">
                                <strong>Nil by mouth : </strong>
                            </td>
                            <td>
                                {{ isset($anesthetics_checkup_form->nil_by_mouth) ? $anesthetics_checkup_form->nil_by_mouth : '' }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Drugs/Premedication : </strong>
                            </td>
                            <td>
                                {{ isset($anesthetics_checkup_form->drugs_premedication) ? $anesthetics_checkup_form->drugs_premedication : '' }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Further advice : </strong>
                            </td>
                            <td>
                                {{ isset($anesthetics_checkup_form->further_advice) ? $anesthetics_checkup_form->further_advice : '' }}
                            </td>
                        </tr>
                    </table> --}}
                    {{-- <h2>Special Note / considerations for the attending anesthesiologist:</h2> --}}
                    {{-- <h2>Further Advice :</h2> --}}
                    <table width="100%" id="info" style="border-collapse: collapse;margin-top:10px">

                        <tr>
                            <td colspan="2"><h4>Pre Operative Instruction :</h4></td>
                        </tr>

                        <tr>
                            <td colspan="2">
                                <strong>1.</strong>
                                NPO- {{ isset($anesthetics_checkup_form->pre_operative_ins1) ? $anesthetics_checkup_form->pre_operative_ins1 : '' }} hours before operation.
                            </td>
                        </tr>

                        <tr>
                            <td colspan="2">
                                <strong>2. Drugs / Premedication : </strong>
                                {{ isset($anesthetics_checkup_form->pre_operative_ins2) ? $anesthetics_checkup_form->pre_operative_ins2 : '' }}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <strong>3. Blood Donor Standby (cross-matched) : </strong>
                                {{ isset($anesthetics_checkup_form->blood_doner_standby) ? $anesthetics_checkup_form->blood_doner_standby : '' }}
                            </td>
                        </tr>

                        <tr>
                            <td colspan="">
                                <strong>4. Blood for Operation : </strong> 
                            </td>
                            <td>
                                <span>Whole Blood : {{ isset($anesthetics_checkup_form->whole_blood) ? $anesthetics_checkup_form->whole_blood : '' }} Unit </span> <br>
                                <span>Packed Red Blood :  {{ isset($anesthetics_checkup_form->red_blood) ? $anesthetics_checkup_form->red_blood : '' }} Unit</span> <br>
                                 <span>Fresh Frozen Plasma  : {{ isset($anesthetics_checkup_form->fresh_frosen_plasma) ? $anesthetics_checkup_form->fresh_frosen_plasma : '' }} Unit</span> 
                            </td>
                        </tr>

                        <tr>
                            <td colspan="2">Further Advice :</td>
                        </tr> 
                        <tr>
                            <td colspan="2">                              
                               <?php echo isset($anesthetics_checkup_form->special_note1) ? $anesthetics_checkup_form->special_note1 : '' ?>
                            </td>
                        </tr>
                    </table>

                    {{-- <h2>Pre Operative Instruction:</h2>
                    <table width="100%" id="info" style="border-collapse: collapse;">
                        <tr>
                            <td>

                                1. NPO- {{ isset($anesthetics_checkup_form->pre_operative_ins1) ? $anesthetics_checkup_form->pre_operative_ins1 : '' }} hours before operation.
                            </td>

                        </tr>
                        <tr>
                            <td>
                                <strong>2. Drugs / Premedication</strong>
                                {{ isset($anesthetics_checkup_form->pre_operative_ins2) ? $anesthetics_checkup_form->pre_operative_ins2 : '' }}
                            </td>

                        </tr>
                        <tr>
                            <td>
                                <strong>3.</strong>
                                {{ isset($anesthetics_checkup_form->pre_operative_ins3) ? $anesthetics_checkup_form->pre_operative_ins3 : '' }}
                            </td>

                        </tr>
                        <tr>
                            <td>
                                <strong>4.</strong>
                                {{ isset($anesthetics_checkup_form->pre_operative_ins4) ? $anesthetics_checkup_form->pre_operative_ins4 : '' }}
                            </td>

                        </tr>
                        <tr>
                            <td>
                                <strong>5.</strong>
                                {{ isset($anesthetics_checkup_form->pre_operative_ins5) ? $anesthetics_checkup_form->pre_operative_ins5 : '' }}
                            </td>

                        </tr>
                    </table> --}}

                    {{-- @dd($anesthetics_checkup_form->revwfor_opn_under) --}}
                    @if(isset($anesthetics_checkup_form->accepted_for_opn_under)  || isset($anesthetics_checkup_form->revwfor_opn_under) )
                    <table width="100%" id="info" style="border-collapse: collapse;">
                        <tr>
                            <td colspan="3" style="text-align:center">
                                <strong> {{ isset($anesthetics_checkup_form->accepted_for_opn_under) ? $anesthetics_checkup_form->accepted_for_opn_under : '' }} </strong>
                            </td>
                            {{-- <td colspan="3" style="text-align:center">
                                <strong> {{ isset($anesthetics_checkup_form->revwfor_opn_under) ? $anesthetics_checkup_form->revwfor_opn_under : '' }} </strong>
                            </td> --}}

                        </tr>
                        <tr>
                            <td>
                                <strong> {{ isset($anesthetics_checkup_form->ga) ? $anesthetics_checkup_form->ga : '' }} </strong>
                            </td>
                            <td>
                                <strong> {{ isset($anesthetics_checkup_form->ra) ? $anesthetics_checkup_form->ra : '' }} </strong>
                            </td>
                            <td>
                                <strong> {{ isset($anesthetics_checkup_form->monitored_care) ? $anesthetics_checkup_form->monitored_care : '' }} </strong>
                            </td>
                            <td>
                                <strong> {{ isset($anesthetics_checkup_form->ga2) ? $anesthetics_checkup_form->ga2 : '' }} </strong>
                            </td>
                            <td>
                                <strong>{{ isset($anesthetics_checkup_form->ra2) ? $anesthetics_checkup_form->ra2 : '' }} </strong>
                            </td>
                            <td>
                                <strong> {{ isset($anesthetics_checkup_form->monitored_care2) ? $anesthetics_checkup_form->monitored_care2 : '' }} </strong>
                            </td>

                        </tr>

                    </table>
                    @endif

                </div>
              {{-- <p> <strong> Reviewed by Anesthesiologist Name </strong></p> --}}
              
                <div style="margin-top:50px">
                    <strong> Anesthesiologist : </strong>
                 @if(isset($anesthetics_checkup_form->doctor_signature))   <span style=""> <?php echo  trim($anesthetics_checkup_form->doctor_signature); ?> </span>@endif
                </div>

                <strong>Date : {{ isset($anesthetics_checkup_form->record_date) ? date('d-m-Y', strtotime($anesthetics_checkup_form->record_date)) : '' }}</strong>

                {{-- <h2> Preinduction Assessment by attending Anesthesiologist </h2>
                <table width="100%" id="info" style="border-collapse: collapse;">
                    <tr>
                        <td>
                            <strong>Pulse :</strong> {{ isset($anesthetics_checkup_form->preinduction_assessment_pulse) ? $anesthetics_checkup_form->preinduction_assessment_pulse : '' }}
                        </td>
                        <td>
                            <strong>BP :</strong> {{ isset($anesthetics_checkup_form->preinduction_assessment_bp) ? $anesthetics_checkup_form->preinduction_assessment_bp : '' }}
                        </td>
                        <td>
                            <strong>Temp :</strong> {{ isset($anesthetics_checkup_form->preinduction_assessment_temp) ? $anesthetics_checkup_form->preinduction_assessment_temp : '' }}
                        </td>
                        <td>
                            <strong>Resp :</strong> {{ isset($anesthetics_checkup_form->preinduction_assessment_pulse) ? $anesthetics_checkup_form->preinduction_assessment_resp : '' }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong>Cough :</strong> {{ isset($anesthetics_checkup_form->preinduction_assessment_cough) ? $anesthetics_checkup_form->preinduction_assessment_cough : '' }}
                        </td>
                        <td>
                            <strong>GCS :</strong> {{ isset($anesthetics_checkup_form->preinduction_assessment_gcs) ? $anesthetics_checkup_form->preinduction_assessment_gcs : '' }}
                        </td>
                        <td>
                            <strong>Others :</strong> {{ isset($anesthetics_checkup_form->preinduction_assessment_others) ? $anesthetics_checkup_form->preinduction_assessment_others : '' }}
                        </td>
                        <td>
                            <strong>Any significant changes :</strong> {{ isset($anesthetics_checkup_form->any_significant_changes) ? $anesthetics_checkup_form->any_significant_changes : '' }}
                        </td>
                    </tr>
                </table> --}}

                @if(isset($anesthetics_checkup_form->doctor_signature_2))
                <div style="margin-top:70px">
                    <span style=""> <?php echo  trim($anesthetics_checkup_form->doctor_signature_2); ?> </span>
                </div>
                @endif
            </div>
        </section>
        </div>
    </main>
</body>

</html>