<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Pre Anesthesia Checkup Form</title>
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
        <div class="wrapper">
            <div style=" text-align:center; margin-bottom:5px; margin-top:20px  " class="mb-2">
                <span class="report-name" style="width:100%; font-size:20px ;  padding:10px;  "> <strong> Pre Anesthesia
                        Checkup Form </strong></span>
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
                                <td>
                                    <div><strong>UHID No:</strong></div>
                                    {{ isset($pat_info->patient_code) ? $pat_info->patient_code : 'N/A' }}
                                </td>
                                <td>
                                    <div> <strong> Name of patient </strong></div>
                                    <div>{{ isset($pat_info->patient_name) ? $pat_info->patient_name : 'N/A' }}</div>
                                </td>

                                <td>
                                    <div><strong>Age</strong></div>
                                    {{ isset($pat_info->age) ? $pat_info->age : 'N/A' }}
                                </td>



                            </tr>
                            {{-- <tr>

                                <td>
                                    <div><strong>Date</strong></div>
                                    {{ isset($anesthetics_checkup_form->ot_date) ? date('d-m-Y', strtotime($anesthetics_checkup_form->ot_date)) : 'N/A' }}
                                </td>
                                <td>
                                    <div> <strong> Department </strong></div>
                                    <div>{{ isset($pat_info->new_su_name) ? $pat_info->new_su_name : 'N/A' }}</div>
                                </td>


                            </tr> --}}
                            <tr>
                                <td>
                                    <div><strong>Sex</strong></div>
                                    {{ isset($pat_info->gender_txt) ? $pat_info->gender_txt : 'N/A' }}
                                </td>
                                <td colspan="2">
                                    <div><strong> Blood Group</strong></div>
                                    {{ isset($pat_info->blood_group_text) ? $pat_info->blood_group_text : 'N/A' }}
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <strong> Weight </strong>
                                    <div>
                                        {{ isset($anesthetics_checkup_form->weight) ? $anesthetics_checkup_form->weight : 'N/A' }}
                                    </div>
                                </td>
                                <td>
                                    <strong> Height </strong>
                                    <div>
                                        {{ isset($anesthetics_checkup_form->height) ? $anesthetics_checkup_form->height : 'N/A' }}
                                    </div>
                                </td>
                                <td>
                                    <strong> BMI </strong>
                                    <div>
                                        {{ isset($anesthetics_checkup_form->bmi) ? $anesthetics_checkup_form->bmi : 'N/A' }}
                                    </div>
                                </td>



                            </tr>



                            <tr>
                                <td>
                                    <strong> Smooker : </strong>
                                    {{ isset($anesthetics_checkup_form->smooker) ? $anesthetics_checkup_form->smooker : '' }}
                                </td>

                                <td>
                                    <strong> Alcohol : </strong>
                                    {{ isset($anesthetics_checkup_form->alcohol) ? $anesthetics_checkup_form->alcohol : '' }}
                                </td>

                                <td>
                                    <strong> Artificial Denture : </strong>
                                    {{ isset($anesthetics_checkup_form->airway_artificial_denture) ? $anesthetics_checkup_form->airway_artificial_denture : '' }}
                                </td>

                            </tr>


                            <tr>
                                <td colspan="3">
                                    <strong> Preoperative Diagnosis : </strong>
                                    {{ isset($anesthetics_checkup_form->preoperative_diagnosis) ? $anesthetics_checkup_form->preoperative_diagnosis : '' }}
                                </td>
                            </tr>

                            <tr>
                                <td colspan="3">
                                    <strong> Date of Surgery : </strong>
                                    {{ isset($anesthetics_checkup_form->scheduled_surgery_date) ? date('d/m/Y', strtotime($anesthetics_checkup_form->scheduled_surgery_date)) : '' }}
                                </td>
                            </tr>

                            <tr>
                                <td colspan="3">
                                    <div> <strong>Name of treating Doctor:</strong></div>
                                    <div>
                                        {{ isset($anesthetics_checkup_form->doctor_name) ? $anesthetics_checkup_form->doctor_name : 'N/A' }}
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3">
                                    <strong> Surgery : </strong>
                                    {{ isset($anesthetics_checkup_form->operation) ? $anesthetics_checkup_form->operation : '' }}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3">
                                    <strong>Previous Anesthesia Complication (if any):</strong>
                                    {{ isset($anesthetics_checkup_form->pre_anes_and_comp) ? $anesthetics_checkup_form->pre_anes_and_comp : '' }}
                                </td>
                            </tr>

                        </table>
                    </div>

                    <h2>Co-existing disease with duration :</h2>
                    <table width="100%" id="info">

                        <tr>
                            <td style="">
                                <strong> Hypertension : </strong>
                                {{ isset($anesthetics_checkup_form->hypertension) ? $anesthetics_checkup_form->hypertension : '' }}
                            </td>
                            <td style="">
                                <strong> IHD : </strong>
                                {{ isset($anesthetics_checkup_form->ihd) ? $anesthetics_checkup_form->ihd : '' }}
                            </td>

                            <td style="">
                                <strong> MI: </strong>
                                {{ isset($anesthetics_checkup_form->myocardial) ? $anesthetics_checkup_form->myocardial : '' }}
                            </td>
                            <td>
                                <strong>Bronchial Asthma/COPD : </strong>
                                {{ isset($anesthetics_checkup_form->asthma) ? $anesthetics_checkup_form->asthma : '' }}
                            </td>
                        </tr>

                        <tr>
                            <td style="">
                                <strong>Diabetes :</strong>
                                {{ isset($anesthetics_checkup_form->diabetes) ? $anesthetics_checkup_form->diabetes : '' }}
                            </td>
                            <td style="">
                                <strong>Thyroid disorder :</strong>
                                {{ isset($anesthetics_checkup_form->thyroid_disorder) ? $anesthetics_checkup_form->thyroid_disorder : '' }}
                            </td>
                            <td style="">
                                <strong> Cough :</strong>
                                {{ isset($anesthetics_checkup_form->pre_cough) ? $anesthetics_checkup_form->pre_cough : '' }}
                            </td>
                            <td style="">
                                <strong> Chest Pain: </strong>
                                {{ isset($anesthetics_checkup_form->chestpain) ? $anesthetics_checkup_form->chestpain : '' }}
                            </td>
                        </tr>

                        <tr>
                            <td colspan="4">
                                <strong>Others :</strong>
                                {{ isset($anesthetics_checkup_form->others_medical_problem) ? $anesthetics_checkup_form->others_medical_problem : '' }}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4">
                                <strong> Present Medication : </strong>
                                {{ isset($anesthetics_checkup_form->present_medication) ? $anesthetics_checkup_form->present_medication : '' }}
                            </td>
                        </tr>

                        <tr>
                            <td colspan="4">
                                <strong> Allergy: </strong>
                                {{ isset($anesthetics_checkup_form->allergy) ? $anesthetics_checkup_form->allergy : '' }}
                            </td>
                        </tr>

                    </table>


                    <h2>Investigations</h2>
                    <table width="100%" id="info" style="margin-top:10px">
                        <tr>
                            <td colspan="1">
                                <h4>CBC-</h4>
                            </td>
                            <td colspan="2"><strong>HB :</strong>
                                {{ isset($anesthetics_checkup_form->hb_pcv) ? $anesthetics_checkup_form->hb_pcv : '' }}
                            </td>
                            <td colspan="2"><strong>PCV :</strong>
                                {{ isset($anesthetics_checkup_form->pcv) ? $anesthetics_checkup_form->pcv : '' }}</td>
                            <td colspan="2"><strong>TC :</strong>
                                {{ isset($anesthetics_checkup_form->tc) ? $anesthetics_checkup_form->tc : '' }}</td>
                            <td colspan="2"><strong>Platelet :</strong>
                                {{ isset($anesthetics_checkup_form->platelet_count) ? $anesthetics_checkup_form->platelet_count : '' }}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="1">
                                <h4>Blood Sugar-</h4>
                            </td>
                            <td><strong>FBS :</strong>
                                {{ isset($anesthetics_checkup_form->fbs_rbs) ? $anesthetics_checkup_form->fbs_rbs : '' }}
                            </td>
                            <td><strong>RBS :</strong>
                                {{ isset($anesthetics_checkup_form->rbs) ? $anesthetics_checkup_form->rbs : '' }}</td>
                            <td colspan="2"><strong>HbA1C :</strong>
                                {{ isset($anesthetics_checkup_form->hba1c) ? $anesthetics_checkup_form->hba1c : '' }}
                            </td>
                            <td colspan="2"><strong>S. Creat. :</strong>
                                {{ isset($anesthetics_checkup_form->screatinine) ? $anesthetics_checkup_form->screatinine : '' }}
                            </td>
                            <td colspan="2"><strong>Bl. Urea :</strong>
                                {{ isset($anesthetics_checkup_form->urea) ? $anesthetics_checkup_form->urea : '' }}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="1">
                                <h4>Electrolyte-</h4>
                            </td>
                            <td colspan="2"><strong>Na :</strong>
                                {{ isset($anesthetics_checkup_form->na) ? $anesthetics_checkup_form->na : '' }}</td>
                            <td colspan="2"><strong>K :</strong>
                                {{ isset($anesthetics_checkup_form->k) ? $anesthetics_checkup_form->k : '' }}</td>
                            <td colspan="2"><strong>CL :</strong>
                                {{ isset($anesthetics_checkup_form->cl) ? $anesthetics_checkup_form->cl : '' }}</td>
                            <td colspan="2"><strong>Ca :</strong>
                                {{ isset($anesthetics_checkup_form->ca) ? $anesthetics_checkup_form->ca : '' }}</td>
                        </tr>
                        <tr>
                            <td colspan="1">
                                <h4>Coagulation-</h4>
                            </td>
                            <td><strong>PT :</strong>
                                {{ isset($anesthetics_checkup_form->pt) ? $anesthetics_checkup_form->pt : '' }}</td>
                            <td><strong>APTT :</strong>
                                {{ isset($anesthetics_checkup_form->aptt) ? $anesthetics_checkup_form->aptt : '' }}
                            </td>
                            <td colspan="2"><strong>INR :</strong>
                                {{ isset($anesthetics_checkup_form->inr) ? $anesthetics_checkup_form->inr : '' }}</td>
                            <td colspan="2"><strong>BT :</strong>
                                {{ isset($anesthetics_checkup_form->bt) ? $anesthetics_checkup_form->bt : '' }}</td>
                            <td colspan="2"><strong>CT :</strong>
                                {{ isset($anesthetics_checkup_form->ct) ? $anesthetics_checkup_form->ct : '' }}</td>
                        </tr>
                        <tr>
                            <td colspan="1">
                                <h4>ABG-</h4>
                            </td>
                            <td><strong>pH :</strong>
                                {{ isset($anesthetics_checkup_form->ph) ? $anesthetics_checkup_form->ph : '' }}</td>
                            <td><strong>PaO<sub>2</sub> :</strong>
                                {{ isset($anesthetics_checkup_form->pao2) ? $anesthetics_checkup_form->pao2 : '' }}
                            </td>
                            <td><strong>PaCO<sub>2</sub> :</strong>
                                {{ isset($anesthetics_checkup_form->paco2) ? $anesthetics_checkup_form->paco2 : '' }}
                            </td>
                            <td><strong>HCO<sub>3</sub> :</strong>
                                {{ isset($anesthetics_checkup_form->hco3) ? $anesthetics_checkup_form->hco3 : '' }}
                            </td>
                            <td><strong>BE :</strong>
                                {{ isset($anesthetics_checkup_form->be) ? $anesthetics_checkup_form->be : '' }}</td>
                            <td><strong>HbsAg :</strong>
                                {{ isset($anesthetics_checkup_form->hbsag) ? $anesthetics_checkup_form->hbsag : '' }}
                            </td>
                            <td><strong>HCB :</strong>
                                {{ isset($anesthetics_checkup_form->hcv) ? $anesthetics_checkup_form->hcv : '' }}</td>
                            <td><strong>HIV :</strong>
                                {{ isset($anesthetics_checkup_form->hiv) ? $anesthetics_checkup_form->hiv : '' }}</td>
                        </tr>
                        <tr>
                            <td colspan="1">
                                <h4>TFT-</h4>
                            </td>
                            <td colspan="2"><strong>T3 :</strong>
                                {{ isset($anesthetics_checkup_form->t3_t4) ? $anesthetics_checkup_form->t3_t4 : '' }}
                            </td>
                            <td colspan="3"><strong>T4 :</strong>
                                {{ isset($anesthetics_checkup_form->t4) ? $anesthetics_checkup_form->t4 : '' }}</td>
                            <td colspan="3"><strong>TSH :</strong>
                                {{ isset($anesthetics_checkup_form->tsh) ? $anesthetics_checkup_form->tsh : '' }}</td>
                        </tr>
                        <tr>
                            <td colspan="1">
                                <h4>LFT-</h4>
                            </td>
                            <td colspan="2"><strong>Alt :</strong>
                                {{ isset($anesthetics_checkup_form->alt) ? $anesthetics_checkup_form->alt : '' }}</td>
                            <td colspan="2"><strong>Ast :</strong>
                                {{ isset($anesthetics_checkup_form->ast) ? $anesthetics_checkup_form->ast : '' }}</td>
                            <td colspan="2"><strong>Alk Ph :</strong>
                                {{ isset($anesthetics_checkup_form->alkph) ? $anesthetics_checkup_form->alkph : '' }}
                            </td>
                            <td colspan="2"><strong>T.Bilirubin :</strong>
                                {{ isset($anesthetics_checkup_form->sbilirubin) ? $anesthetics_checkup_form->sbilirubin : '' }}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="1">
                                <h4>T.Protein-</h4>
                            </td>
                            <td colspan="4"><strong>Ab :</strong>
                                {{ isset($anesthetics_checkup_form->ab) ? $anesthetics_checkup_form->ab : '' }}</td>
                            <td colspan="4"><strong>Glob :</strong>
                                {{ isset($anesthetics_checkup_form->glob) ? $anesthetics_checkup_form->glob : '' }}
                            </td>
                        </tr>
                    </table>

                    <table width="100%" id="info" style="margin-top:10px">
                        <tr>
                            <td><strong>CXR :</strong>
                                {{ isset($anesthetics_checkup_form->cxr) ? $anesthetics_checkup_form->cxr : '' }}</td>
                            <td><strong>ECG :</strong>
                                {{ isset($anesthetics_checkup_form->ecg) ? $anesthetics_checkup_form->ecg : '' }}</td>
                            <td><strong>Echo :</strong>
                                {{ isset($anesthetics_checkup_form->echo) ? $anesthetics_checkup_form->echo : '' }}
                            </td>
                            <td><strong>Others :</strong>
                                {{ isset($anesthetics_checkup_form->others) ? $anesthetics_checkup_form->others : '' }}
                            </td>
                        </tr>
                    </table>


                    <!-- Vital Signs -->
                    <h2>Vital Signs</h2>
                    <table width="100%" id="info" style="margin-top:10px">
                        <tr>
                            <td><strong>Pulse :</strong>
                                {{ isset($anesthetics_checkup_form->pulse) ? $anesthetics_checkup_form->pulse : '' }}
                            </td>
                            <td><strong>Jaundice :</strong>
                                {{ isset($anesthetics_checkup_form->jaundice) ? $anesthetics_checkup_form->jaundice : '' }}
                            </td>
                        </tr>
                        <tr>
                            <td><strong>BP :</strong>
                                {{ isset($anesthetics_checkup_form->bp) ? $anesthetics_checkup_form->bp : '' }}</td>
                            <td><strong>Cyanosis :</strong>
                                {{ isset($anesthetics_checkup_form->cyanosis) ? $anesthetics_checkup_form->cyanosis : '' }}
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Temperature :</strong>
                                {{ isset($anesthetics_checkup_form->temperature) ? $anesthetics_checkup_form->temperature : '' }}
                            </td>
                            <td><strong>Oedema :</strong>
                                {{ isset($anesthetics_checkup_form->oedema) ? $anesthetics_checkup_form->oedema : '' }}
                            </td>
                        </tr>
                        <tr>
                            <td><strong>SPO<sub>2</sub> :</strong>
                                {{ isset($anesthetics_checkup_form->spo2) ? $anesthetics_checkup_form->spo2 : '' }}
                            </td>
                            <td><strong>Cough :</strong>
                                {{ isset($anesthetics_checkup_form->cough) ? $anesthetics_checkup_form->cough : '' }}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2"><strong>Anemia :</strong>
                                {{ isset($anesthetics_checkup_form->anemia) ? $anesthetics_checkup_form->anemia : '' }}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2"><strong>Others :</strong>
                                {{ isset($anesthetics_checkup_form->clinical_exam_others) ? $anesthetics_checkup_form->clinical_exam_others : '' }}
                            </td>
                        </tr>
                    </table>

                    <h2>Systemic Examination</h2>
                    <table width="100%" id="info" style="margin-top:10px">
                        <tr>
                            <td><strong>Central Nervous system :</strong>
                                {{ isset($anesthetics_checkup_form->cns) ? $anesthetics_checkup_form->cns : '' }}</td>
                            <td><strong>Cardiovascular system :</strong>
                                {{ isset($anesthetics_checkup_form->cvs) ? $anesthetics_checkup_form->cvs : '' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Respiratory System :</strong>
                                {{ isset($anesthetics_checkup_form->respiratory_system) ? $anesthetics_checkup_form->respiratory_system : '' }}
                            </td>
                            <td><strong>Others :</strong>
                                {{ isset($anesthetics_checkup_form->systemic_others) ? $anesthetics_checkup_form->systemic_others : '' }}
                            </td>
                        </tr>
                    </table>


                    <h2>Consideration for Operating Room Anesthesiologist</h2>
                    <table width="100%" id="info" style="margin-top:10px">
                        <tr>
                            <td><strong>Artificial denture :</strong>
                                {{ isset($anesthetics_checkup_form->coniser_artificial_denture) ? $anesthetics_checkup_form->coniser_artificial_denture : '' }}
                            </td>
                            <td><strong>Airway Assessment :</strong>
                                {{ isset($anesthetics_checkup_form->airway_exam) ? $anesthetics_checkup_form->airway_exam : '' }}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2"><strong>Co-Existing Disease :</strong>
                                {{ isset($anesthetics_checkup_form->co_existing) ? $anesthetics_checkup_form->co_existing : '' }}
                            </td>
                        </tr>
                        <tr>
                            <td><strong>ASA :</strong>
                                {{ isset($anesthetics_checkup_form->asa_class) ? $anesthetics_checkup_form->asa_class : '' }}
                            </td>
                            <td><strong>NYHA :</strong>
                                {{ isset($anesthetics_checkup_form->nyha_classification) ? $anesthetics_checkup_form->nyha_classification : '' }}
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Mallampati grade :</strong>
                                {{ isset($anesthetics_checkup_form->mallampati_grade) ? $anesthetics_checkup_form->mallampati_grade : '' }}
                            </td>
                            <td><strong>Type of Anesthesia Discussed :</strong>
                                {{ isset($anesthetics_checkup_form->type_of_anesthesia_discussed) ? $anesthetics_checkup_form->type_of_anesthesia_discussed : '' }}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2"><strong>Pain Relief Discussed :</strong>
                                {{ isset($anesthetics_checkup_form->pain_relief_discussed) ? $anesthetics_checkup_form->pain_relief_discussed : '' }}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2"><strong>Risk factor (if any) :</strong>
                                {{ isset($anesthetics_checkup_form->risk_factor) ? $anesthetics_checkup_form->risk_factor : '' }}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2"><strong>Others :</strong>
                                {{ isset($anesthetics_checkup_form->other2) ? $anesthetics_checkup_form->other2 : '' }}
                            </td>
                        </tr>
                    </table>


                    <h2>Pre-operative Instructions</h2>
                    <table width="100%" id="info" style="margin-top:10px">
                        <tr>
                            <td><strong>1. NPO :
                                    {{ isset($anesthetics_checkup_form->pre_operative_ins1) ? $anesthetics_checkup_form->pre_operative_ins1 : '' }}
                                </strong>
                                hours before operation/Till further order</td>
                        </tr>
                        <tr>
                            <td><strong>2. Drugs / Premedication :</strong>
                                {{ isset($anesthetics_checkup_form->pre_operative_ins2) ? $anesthetics_checkup_form->pre_operative_ins2 : '' }}
                            </td>
                        </tr>
                        <tr>
                            <td><strong>3. Blood Donor Standby(Cross-matched) :</strong>
                                {{ isset($anesthetics_checkup_form->pre_operative_ins3) ? $anesthetics_checkup_form->pre_operative_ins3 : '' }}
                                Unit</td>
                        </tr>
                        <tr>
                            <td><strong>4. Whole Blood :</strong>
                                {{ isset($anesthetics_checkup_form->whole_blood) ? $anesthetics_checkup_form->whole_blood : '' }}
                                Unit</td>
                        </tr>
                        <tr>
                            <td><strong>Packed red blood cell :</strong>
                                {{ isset($anesthetics_checkup_form->red_blood) ? $anesthetics_checkup_form->red_blood : '' }}
                                Unit</td>
                        </tr>
                        <tr>
                            <td><strong>Fresh frozen plasma :</strong>
                                {{ isset($anesthetics_checkup_form->fresh_frosen_plasma) ? $anesthetics_checkup_form->fresh_frosen_plasma : '' }}
                                Unit</td>
                        </tr>
                        <tr>
                            <td><strong>5. Further advice :</strong>
                                {{ isset($anesthetics_checkup_form->further_advice) ? $anesthetics_checkup_form->further_advice : '' }}
                            </td>
                        </tr>
                    </table>


                    <table width="100%" id="info"style="margin-top:10px">
                        <tr>
                            <td><strong>Accepted for operation Under :</strong></td>
                            <td><strong>GA :</strong>
                                {{ isset($anesthetics_checkup_form->ga) ? $anesthetics_checkup_form->ga : '' }}</td>
                            <td><strong>RA :</strong>
                                {{ isset($anesthetics_checkup_form->ra) ? $anesthetics_checkup_form->ra : '' }}</td>
                            <td><strong>MAC :</strong>
                                {{ isset($anesthetics_checkup_form->monitored_care) ? $anesthetics_checkup_form->monitored_care : '' }}
                            </td>
                        </tr>
                    </table>


                    <table width="100%" id="info" style="margin-top:10px">
                        <tr>
                            <td><strong>Anesthesiologist :</strong>
                                {{ isset($anesthetics_checkup_form->full_name) ? $anesthetics_checkup_form->full_name : '' }}
                            </td>
                            <td><strong>Date :</strong>
                                {{ isset($anesthetics_checkup_form->anesthesia_date) ? date('Y-m-d', strtotime($anesthetics_checkup_form->anesthesia_date)) : date('Y-m-d') }}
                            </td>
                        </tr>
                    </table>





                </div>
            </section>
        </div>
    </main>
</body>

</html>
