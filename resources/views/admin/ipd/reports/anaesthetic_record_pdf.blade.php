<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Anesthesia record Report</title>
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
                <span class="report-name" style="width:100%; font-size:20px ;  padding:10px;  "> <strong> Anesthesia
                        Record </strong></span>
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
                                <div> <strong> Name of pt </strong></div>
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
                                {{ isset($pat_info->blood_group_txt) ? $pat_info->blood_group_txt : 'N/A' }}
                            </td>

                        </tr>
                        <tr>
                            {{-- <td>
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
                            </td> --}}
                            <td>
                                <div><strong>Weight (kg)</strong></div>
                                {{ isset($anaesthetist_record_data->weight) ? $anaesthetist_record_data->weight : 'N/A' }}
                            </td>
                            <td>
                                <div><strong>Preop. Diag</strong></div>
                                {{ isset($anaesthetist_record_data->preep_diag) ? $anaesthetist_record_data->preep_diag : 'N/A' }}
                            </td>
                            <td>
                                <div><strong>Proposed Op</strong></div>
                                {{ isset($anaesthetist_record_data->proposed_op) ? $anaesthetist_record_data->proposed_op : 'N/A' }}
                            </td>
                            <td>
                                <div> <strong> Co-Existing Disease </strong></div>
                                <div>
                                    {{ isset($anaesthetist_record_data->co_existing_disease) ? $anaesthetist_record_data->co_existing_disease : 'N/A' }}
                                </div>
                            </td>
                            <td>
                                <div><strong>Previous anaes</strong></div>
                                {{ isset($anaesthetist_record_data->previous_anaes) ? $anaesthetist_record_data->previous_anaes : 'N/A' }}
                            </td>
                            <td>
                                <div><strong>Allergy</strong></div>
                                {{ isset($anaesthetist_record_data->allergy) ? $anaesthetist_record_data->allergy : 'N/A' }}
                            </td>

                        </tr>
                        
                    </table>
                </div>

                <div style="">
                    <h3>Pre induction Check list</h3>
                </div>
                <div style=" border: .5 solid rgb(177, 175, 175);">

                    <table width="100%">
                        <tr>

                            <td>
                                <div><strong>Pulse/min :</strong></div>
                                {{isset($anaesthetist_record_data->pulse_min) ? $anaesthetist_record_data->pulse_min :'N/A'}}
                            </td>
                            <td>
                                <div><strong>BP (mmHg) :</strong></div>
                                {{isset($anaesthetist_record_data->bp_mmhg) ? $anaesthetist_record_data->bp_mmhg :'N/A'}} / {{isset($anaesthetist_record_data->bp_mmhg_2) ? $anaesthetist_record_data->bp_mmhg_2 :'N/A'}}
                            </td>
                            <td>
                                <div><strong>Heart :</strong></div>
                                {{isset($anaesthetist_record_data->heart) ? $anaesthetist_record_data->heart :'N/A'}}
                            </td>
                            <td>
                                <div> <strong> Lungs :</strong></div>
                                <div>{{isset($anaesthetist_record_data->lungs) ? $anaesthetist_record_data->lungs :'N/A'}}</div>
                            </td>

                        </tr>
                        <tr>

                            <td>
                                <div><strong>Teeth :</strong></div>
                                {{isset($anaesthetist_record_data->teeth) ? $anaesthetist_record_data->teeth :'N/A'}}
                            </td>
                            <td>
                                <div><strong>Anaemia :</strong></div>
                                {{isset($anaesthetist_record_data->anaemia) ? $anaesthetist_record_data->anaemia :'N/A'}}
                            </td>
                            <td>
                                <div><strong>HB% :</strong></div>
                                {{isset($anaesthetist_record_data->hb) ? $anaesthetist_record_data->hb :'N/A'}}
                            </td>
                            <td>
                                <div> <strong> {{ isset($anaesthetist_record_data->fbs_rbs) ? $anaesthetist_record_data->fbs_rbs : 'N/A' }} :</strong></div>
                                <div>
                                    {{isset($anaesthetist_record_data->fbs_rbs_text) ? $anaesthetist_record_data->fbs_rbs_text :'N/A'}}
                                </div>
                            </td>
                            <td>
                                <div><strong>B. Urea :</strong></div>
                                {{isset($anaesthetist_record_data->b_urea) ? $anaesthetist_record_data->b_urea :'N/A'}}
                            </td>

                        </tr>
                        <tr>


                            <td>
                                <div><strong>S.Creatinine :</strong></div>
                                {{isset($anaesthetist_record_data->s_creatinine) ? $anaesthetist_record_data->s_creatinine :'N/A'}}
                            </td>
                            <td>
                                <div><strong>S.Bilirubin :</strong></div>
                                {{isset($anaesthetist_record_data->s_bilirubin) ? $anaesthetist_record_data->s_bilirubin :'N/A'}}
                            </td>
                            <td>
                                <!-- <div> <strong>  GRI   :</strong></div>
                                    <div>
                                        {{isset($anaesthetist_record_data->gri) ? $anaesthetist_record_data->gri :'N/A'}}
                                    </div> -->
                            </td>

                            <td>
                                <div><strong>CXR :</strong></div>
                                {{isset($anaesthetist_record_data->cxr) ? $anaesthetist_record_data->cxr :'N/A'}}
                            </td>

                        </tr>


                        <tr>

                            <td>
                                <div><strong>Chest Pain :</strong></div>
                                {{isset($anaesthetist_record_data->chest_pain) ? $anaesthetist_record_data->chest_pain :'N/A'}}
                            </td>
                            <td>
                                <div><strong>NYHA :</strong></div>
                                {{isset($anaesthetist_record_data->nyha) ? $anaesthetist_record_data->nyha :'N/A'}}
                            </td>
                            <td>
                                <div><strong>ASA Class :</strong></div>
                                {{isset($anaesthetist_record_data->asa_class) ? $anaesthetist_record_data->asa_class :'N/A'}}
                            </td>

                            <td>
                                <div><strong>Mallampati Grading :</strong></div>
                                {{isset($anaesthetist_record_data->mallampati_grading) ? $anaesthetist_record_data->mallampati_grading :'N/A'}}
                            </td>

                        </tr>
                        <tr>
                            <!-- <td colspan="3">
                                    @php
                                    $Rreoperative=  isset($anaesthetist_record_data->for_anaesthetist) ? $anaesthetist_record_data->for_anaesthetist :'N/A';
                                 @endphp
                                    <div> <strong>  Rreoperative advice   :</strong> <br> For Anesthesiologist</div>
                                    <div>
                                        <?php echo  $Rreoperative ?>
                                    </div>
                                </td> -->
                            <td>
                                <div><strong>ECG :</strong></div>
                                {{isset($anaesthetist_record_data->ecg) ? $anaesthetist_record_data->ecg :'N/A'}}
                            </td>
                            <td>
                                <div><strong>S. Electrolyles : </strong> <br> <strong> NA+ :</strong></div>
                                {{isset($anaesthetist_record_data->electrolyles_na) ? $anaesthetist_record_data->electrolyles_na :'N/A'}}
                            </td>
                            <td>
                                <div><strong>K+ :</strong></div>
                                {{isset($anaesthetist_record_data->electrolyles_k) ? $anaesthetist_record_data->electrolyles_k :'N/A'}}
                            </td>
                            <td>
                                <div><strong>Ci :</strong></div>
                                {{isset($anaesthetist_record_data->electrolyles_ci) ? $anaesthetist_record_data->electrolyles_ci :'N/A'}}
                            </td>
                            <td>
                                <div><strong>Echo :</strong></div>
                                {{isset($anaesthetist_record_data->echo) ? $anaesthetist_record_data->echo :'N/A'}}
                            </td>


                        </tr>
                        <tr>
                            <td>
                                <div><strong>Consent :</strong></div>
                                {{isset($anaesthetist_record_data->consent) ? $anaesthetist_record_data->consent :'N/A'}}
                            </td>
                            <td>
                                <div><strong>Fasting :</strong></div>
                                {{isset($anaesthetist_record_data->fasting) ? $anaesthetist_record_data->fasting :'N/A'}}
                            </td>
                            <td>
                                <div><strong>Premed taken :</strong></div>
                                {{isset($anaesthetist_record_data->premed_taken) ? $anaesthetist_record_data->premed_taken :'N/A'}}
                            </td>
                            <td>
                                <div><strong>Blood available :</strong></div>
                                {{isset($anaesthetist_record_data->blood_available) ? $anaesthetist_record_data->blood_available :'N/A'}}
                            </td>
                            <td>
                                <div><strong>Anesthesia Machine check :</strong></div>
                                {{isset($anaesthetist_record_data->anes_mach_check) ? $anaesthetist_record_data->anes_mach_check :'N/A'}}
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <div><strong>Suction check :</strong></div>
                                {{isset($anaesthetist_record_data->suction_check) ? $anaesthetist_record_data->suction_check :'N/A'}}
                            </td>
                            <td>
                                <div><strong>Scavenger check :</strong></div>
                                {{isset($anaesthetist_record_data->scavenger_check) ? $anaesthetist_record_data->scavenger_check :'N/A'}}
                            </td>
                            <td colspan="3">
                                <div> <strong>Pre induction assessment by attending Anesthesiologis :</strong></div>
                                {{isset($anaesthetist_record_data->others) ? $anaesthetist_record_data->others :'N/A'}}
                            </td>
                            <!-- <td colspan="2">
                                    <div><strong>Maintenance drugs related to anaesthesia :</strong></div>
                                    {{isset($anaesthetist_record_data->maintenance_drugs) ? $anaesthetist_record_data->maintenance_drugs :'N/A'}}
                                </td> -->
                        </tr>
                        <tr>

                            <td colspan="5">
                                <div><strong>Assessed by : :</strong></div>
                                <strong>Dr. Name :</strong><br>
                                {{isset($pat_info->primary_doctor_name) ? $pat_info->primary_doctor_name :'N/A'}} <br>
                                <strong>Date of Assessment :</strong><br>
                                {{isset($anaesthetist_record_data->assessment_date) ? date('d/m/Y',strtotime($anaesthetist_record_data->assessment_date)) :''}}
                            </td>
                        </tr>
                    </table>
                </div>

                <div style="">
                    <h3>Pre induction Check list</h3>
                </div>
                <div style=" border: .5 solid rgb(177, 175, 175);">

                    <table width="100%">
                        <tr>
                            <td>
                                <div> <strong> Advice :</strong></div>
                                {{isset($anaesthetist_record_data->preoperative_advice) ? $anaesthetist_record_data->preoperative_advice :'N/A'}}
                            </td>
                            <td>
                                <div> <strong> Anesthesia Technique :</strong></div>
                                {{isset($anaesthetist_record_data->anaesthetic_technique) ? $anaesthetist_record_data->anaesthetic_technique :'N/A'}}
                            </td>
                            <td>
                                <div> <strong> GA/RA/MAC : </strong></div>
                                <div>{{isset($anaesthetist_record_data->accepted_for) && $anaesthetist_record_data->accepted_for ? $anaesthetist_record_data->accepted_for : 'N/A'}}</div>
                            </td>
                            <td>
                                {{isset($anaesthetist_record_data->inlineradioepcasp) ? $anaesthetist_record_data->inlineradioepcasp :'N/A'}}
                            </td>
                            <td>
                                <div> <strong> Others : </strong></div>
                                <div>{{isset($anaesthetist_record_data->technique_others) && $anaesthetist_record_data->technique_others ? $anaesthetist_record_data->technique_others : 'N/A'}}</div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div> <strong> Date of Opn :</strong></div>
                                {{isset($anaesthetist_record_data->opn_date) ? date('d-m-Y',strtotime($anaesthetist_record_data->opn_date)) :'N/A'}}
                            </td>
                            <td>
                                <div><strong>Surgon Name :</strong></div>
                                {{isset($anaesthetist_record_data->surgon_name) ? $anaesthetist_record_data->surgon_name :'N/A'}}
                            </td>
                            <td>
                                <div><strong>Opn :</strong></div>
                                {{isset($anaesthetist_record_data->opn) ? $anaesthetist_record_data->opn :'N/A'}}
                            </td>
                            <td>
                                <div><strong>Anaesth :</strong></div>
                                {{isset($anaesthetist_record_data->anaesth) ? $anaesthetist_record_data->anaesth :'N/A'}}
                            </td>


                        </tr>

                        <tr>

                            <td>
                                <div><strong>Dmim<sup>-1</sup>(%) :</strong></div>
                                {{isset($anaesthetist_record_data->dmim) ? $anaesthetist_record_data->dmim :'N/A'}}
                            </td>
                            <td>
                                <!-- <div><strong>N2O(%) :</strong></div>
                                {{isset($anaesthetist_record_data->n20) ? $anaesthetist_record_data->n20 :'N/A'}} -->
                            </td>

                            <td>
                                <div><strong>Lmim<sup>-1</sup>(%) :</strong></div>
                                {{isset($anaesthetist_record_data->lmim) ? $anaesthetist_record_data->lmim :'N/A'}}
                            </td>
                            <td>
                                <!-- <div><strong>Air(%) :</strong></div>
                                {{isset($anaesthetist_record_data->air) ? $anaesthetist_record_data->air :'N/A'}} -->
                            </td>
                            <td>
                                <div><strong>Lmim Halo (%) :</strong></div>
                                {{isset($anaesthetist_record_data->lmim_halo) ? $anaesthetist_record_data->lmim_halo :'N/A'}}
                            </td>
                        </tr>

                        <tr>
                            <td colspan="2">
                                <div><strong>Monitoring :</strong></div>
                                <strong> pules:</strong> {{isset($anaesthetist_record_data->monitoring_pules) ? $anaesthetist_record_data->monitoring_pules :'N/A'}}
                                <strong> bp:</strong> {{isset($anaesthetist_record_data->monitoring_bp) ? $anaesthetist_record_data->monitoring_bp :'N/A'}}
                                <strong> ecg:</strong>{{isset($anaesthetist_record_data->monitoring_ecg) ? $anaesthetist_record_data->monitoring_ecg :'N/A'}}
                                <strong> spo <sub>2</sub>:</strong> {{isset($anaesthetist_record_data->monitoring_spo) ? $anaesthetist_record_data->monitoring_spo :'N/A'}}
                                <strong> ptco <sub>2</sub>: </strong>{{isset($anaesthetist_record_data->monitoring_ptco) ? $anaesthetist_record_data->monitoring_ptco :'N/A'}}
                            </td>
                            <td colspan="3">
                                <strong> NIBP:</strong> {{isset($anaesthetist_record_data->nibp) ? $anaesthetist_record_data->nibp :'N/A'}}
                                <strong> FiO <sub>2</sub>:</strong> {{isset($anaesthetist_record_data->fio2) ? $anaesthetist_record_data->fio2 :'N/A'}}
                                <strong> Temp:</strong>{{isset($anaesthetist_record_data->temp) ? $anaesthetist_record_data->temp :'N/A'}}
                                <strong> Agent Monitor :</strong> {{isset($anaesthetist_record_data->agent_monitor) ? $anaesthetist_record_data->agent_monitor :'N/A'}}
                                <strong> NMB Monitor: </strong>{{isset($anaesthetist_record_data->nmb_monitor) ? $anaesthetist_record_data->nmb_monitor :'N/A'}}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="5">
                                <strong> CVP (site & cannula):</strong> {{isset($anaesthetist_record_data->cvp) ? $anaesthetist_record_data->cvp :'N/A'}}
                                <strong> Art line( Site & cannula):</strong> {{isset($anaesthetist_record_data->art_line) ? $anaesthetist_record_data->art_line :'N/A'}}
                                <strong> NG tube:</strong>{{isset($anaesthetist_record_data->ng_tube) ? $anaesthetist_record_data->ng_tube :'N/A'}}
                                <strong> Urinary catheter:</strong> {{isset($anaesthetist_record_data->urinary_catheter) ? $anaesthetist_record_data->urinary_catheter :'N/A'}}
                                <strong> Others: </strong>{{isset($anaesthetist_record_data->monitoring_others) ? $anaesthetist_record_data->monitoring_others :'N/A'}}
                            </td>

                        </tr>
                        <tr>
                            <td>
                                <div><strong>Positioning :</strong></div>
                                <strong> Supine :</strong>{{isset($anaesthetist_record_data->supine) ? $anaesthetist_record_data->supine :'N/A'}}
                            </td>
                            <td>
                                <strong> Lithotomy :</strong>{{isset($anaesthetist_record_data->lithotomy) ? $anaesthetist_record_data->lithotomy :'N/A'}}
                            </td>

                            <td>
                                <strong> Prone :</strong>{{isset($anaesthetist_record_data->prone) ? $anaesthetist_record_data->prone :'N/A'}}
                            </td>
                            <td>
                                <strong> Lateral-R / L :</strong>{{isset($anaesthetist_record_data->lateral_r_l) ? $anaesthetist_record_data->lateral_r_l :'N/A'}}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong> Others :</strong>{{isset($anaesthetist_record_data->positioning_others) ? $anaesthetist_record_data->positioning_others :'N/A'}}
                            </td>
                            <td>
                                <strong> Eye protected :</strong>{{isset($anaesthetist_record_data->eye_protected) ? $anaesthetist_record_data->eye_protected :'N/A'}}
                            </td>

                            <td>
                                <strong> P point padded :</strong>{{isset($anaesthetist_record_data->p_point_padded) ? $anaesthetist_record_data->p_point_padded :'N/A'}}
                            </td>
                            <td>
                                <strong> Troniquet :</strong>{{isset($anaesthetist_record_data->troniquet) ? $anaesthetist_record_data->troniquet :'N/A'}}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div><strong>Intubation :</strong></div>
                                <strong> Asleep :</strong>{{isset($anaesthetist_record_data->asleep) ? $anaesthetist_record_data->asleep :'N/A'}}
                            </td>
                            <td>
                                <strong> Direct :</strong>{{isset($anaesthetist_record_data->direct) ? $anaesthetist_record_data->direct :'N/A'}}
                            </td>
                            <td>
                                <strong> Oral :</strong>{{isset($anaesthetist_record_data->oral) ? $anaesthetist_record_data->oral :'N/A'}}
                            </td>
                            <td>
                                <strong> Awake :</strong>{{isset($anaesthetist_record_data->awake) ? $anaesthetist_record_data->awake :'N/A'}}
                            </td>
                            <td>
                                <strong> Blind :</strong>{{isset($anaesthetist_record_data->blind) ? $anaesthetist_record_data->blind :'N/A'}}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong> Nasal- R / L :</strong>{{isset($anaesthetist_record_data->nasal_r_l) ? $anaesthetist_record_data->nasal_r_l :'N/A'}}
                            </td>
                            <td>
                                <strong> In Situ :</strong>{{isset($anaesthetist_record_data->in_situ) ? $anaesthetist_record_data->in_situ :'N/A'}}
                            </td>
                            <td>
                                <strong> Fibreoptic :</strong>{{isset($anaesthetist_record_data->fibreoptic) ? $anaesthetist_record_data->fibreoptic :'N/A'}}
                            </td>
                            <td>
                                <strong> Tracheostomy :</strong>{{isset($anaesthetist_record_data->tracheostomy) ? $anaesthetist_record_data->tracheostomy :'N/A'}}
                            </td>
                            <td>
                                <strong> Rapid sequence :</strong>{{isset($anaesthetist_record_data->rapid_sequence) ? $anaesthetist_record_data->rapid_sequence :'N/A'}}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <strong> Mask ventilation- Easy / Difficult :</strong>{{isset($anaesthetist_record_data->ventilation_easy_difficult) ? $anaesthetist_record_data->ventilation_easy_difficult :'N/A'}}
                            </td>
                            <td colspan="2">
                                <strong>External Laryngeal manipulation :</strong>{{isset($anaesthetist_record_data->ext_lary_maniptn) ? $anaesthetist_record_data->ext_lary_maniptn :'N/A'}}
                            </td>
                            <td>
                                <strong> Stylet/ Bogie :</strong>{{isset($anaesthetist_record_data->stylet_bogie) ? $anaesthetist_record_data->stylet_bogie :'N/A'}}
                            </td>

                        </tr>
                        <tr>
                            <td>
                                <strong> Intubation grade :</strong>{{isset($anaesthetist_record_data->intubation_grade) ? $anaesthetist_record_data->intubation_grade :'N/A'}}
                            </td>
                            <td>
                                <strong> Throat pack :</strong>{{isset($anaesthetist_record_data->throat_pack) ? $anaesthetist_record_data->throat_pack :'N/A'}}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <div><strong>Condition on leaving Q.T :</strong></div>
                                {{isset($anaesthetist_record_data->conditioning_leaving) ? $anaesthetist_record_data->conditioning_leaving :'N/A'}}
                            </td>

                        </tr>
                        <tr>
                            <td colspan="1">
                                <div><strong>Volume : {{isset($anaesthetist_record_data->peth_fenta) ? $anaesthetist_record_data->peth_fenta :'N/A'}} </strong></div>
                                {{isset($anaesthetist_record_data->peth_fenta_text) ? $anaesthetist_record_data->peth_fenta_text :'N/A'}}
                            </td>
                            <td colspan="1">
                                <div><strong> {{isset($anaesthetist_record_data->diaz_mida) ? $anaesthetist_record_data->diaz_mida :'N/A'}}</strong></div>
                                {{isset($anaesthetist_record_data->diaz_mida_text) ? $anaesthetist_record_data->diaz_mida_text :'N/A'}}
                            </td>
                            <td colspan="1">
                                <div><strong> TPS</strong></div>
                                {{isset($anaesthetist_record_data->tps) ? $anaesthetist_record_data->tps :'N/A'}}
                            </td>
                            <td colspan="2">
                                <div><strong> Others</strong></div>
                                {{isset($anaesthetist_record_data->others_volume) ? $anaesthetist_record_data->others_volume :'N/A'}}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div><strong>Type & Needle Size :</strong></div>
                                <div><strong>Space:</strong></div>
                                {{isset($anaesthetist_record_data->space) ? $anaesthetist_record_data->space :'N/A'}}
                            </td>
                            <td>
                                <br>
                                <div><strong> Drug :</strong></div>
                                {{isset($anaesthetist_record_data->drug) ? $anaesthetist_record_data->drug :'N/A'}}
                            </td>
                            <td>
                                <br>
                                <div><strong> Dose</strong></div>
                                {{isset($anaesthetist_record_data->dose) ? $anaesthetist_record_data->dose :'N/A'}}
                            </td>
                            <td>
                                <br>
                                <div><strong> Adjuvant</strong></div>
                                {{isset($anaesthetist_record_data->adjuvant) ? $anaesthetist_record_data->adjuvant :'N/A'}}
                            </td>
                            <td>
                                <br>
                                <div><strong> Volume</strong></div>
                                {{isset($anaesthetist_record_data->volume) ? $anaesthetist_record_data->volume :'N/A'}}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <div><strong>Airway :</strong></div>
                                <strong> Supraglottic airway: </strong> {{isset($anaesthetist_record_data->supraglottic_airway) ? $anaesthetist_record_data->supraglottic_airway :'N/A'}},
                                <strong> {{isset($anaesthetist_record_data->airway) ? $anaesthetist_record_data->airway :'N/A'}} : {{isset($anaesthetist_record_data->airway_ora_nasal) ? $anaesthetist_record_data->airway_ora_nasal :'N/A'}}</strong>
                                {{isset($anaesthetist_record_data->airway_text) ? $anaesthetist_record_data->airway_text :'N/A'}}
                                <div>
                                    <strong>ETT (Cuffed/Non cuffed) : </strong> {{isset($anaesthetist_record_data->ett_cuffed_non_cuffed) ? $anaesthetist_record_data->ett_cuffed_non_cuffed :'N/A'}}
                                </div>
                            </td>
                            <td colspan="2">
                                <div><strong>Respitation :</strong></div>
                                <div><strong> {{isset($anaesthetist_record_data->respitation_sp_co) ? $anaesthetist_record_data->respitation_sp_co :'N/A'}} : {{isset($anaesthetist_record_data->respitation_manual_ventilator) ? $anaesthetist_record_data->respitation_manual_ventilator :'N/A'}}</strong></div>
                                {{isset($anaesthetist_record_data->respitation_sp_co_text) ? $anaesthetist_record_data->respitation_sp_co_text :'N/A'}}
                                {{isset($anaesthetist_record_data->respitation_manu_venti_text) ? ' , '.$anaesthetist_record_data->respitation_manu_venti_text :'N/A'}}
                            </td>

                        </tr>
                        <tr>
                            <td>
                                <div><strong>Breathing system:</strong></div>
                                <strong>circle:</strong> {{isset($anaesthetist_record_data->ciccuit_circle) ? $anaesthetist_record_data->ciccuit_circle :'N/A'}}
                            </td>
                            <td>
                                <strong>Bain’s:</strong> {{isset($anaesthetist_record_data->ciccuit_bain) ?  $anaesthetist_record_data->ciccuit_bain :'N/A'}}
                            </td>
                            <td>
                                <strong>Ayre’s T pice :</strong> {{isset($anaesthetist_record_data->ciccuit_t_piece)? $anaesthetist_record_data->ciccuit_t_piece :'N/A'}}
                            </td>
                            <td>
                                <strong>O 2 supplement only:</strong> {{isset($anaesthetist_record_data->supplement_only) ?  $anaesthetist_record_data->supplement_only :'N/A'}}
                            </td>
                            <td>
                                <strong>Magill's : </strong> {{isset($anaesthetist_record_data->ciccuit_magill) ?  $anaesthetist_record_data->ciccuit_magill :'N/A'}}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>MAP. D.Sodalime :</strong> {{isset($anaesthetist_record_data->ciccuit_sodalime) ?  $anaesthetist_record_data->ciccuit_sodalime :'N/A'}}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div><strong>Ventilation</strong></div>
                                <strong>Controlled :</strong> {{isset($anaesthetist_record_data->controlled) ?  $anaesthetist_record_data->controlled :'N/A'}}
                            </td>
                            <td colspan="2">
                                <strong>Spontaneous/ Assisted :</strong> {{isset($anaesthetist_record_data->spontaneous_assisted) ?  $anaesthetist_record_data->spontaneous_assisted :'N/A'}}
                            </td>
                            <td colspan="2">
                                <strong>HFV/ Jet ventilation :</strong> {{isset($anaesthetist_record_data->hfv_jet_ventilation) ?  $anaesthetist_record_data->hfv_jet_ventilation :'N/A'}}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div><strong>Gas</strong></div>
                                <strong>O <sub>2</sub> :</strong> {{isset($anaesthetist_record_data->spontaneous_assisted) ?  $anaesthetist_record_data->spontaneous_assisted :'N/A'}}
                            </td>
                            <td>
                                <strong>N2 O :</strong> {{isset($anaesthetist_record_data->n2o) ?  $anaesthetist_record_data->n2o :'N/A'}}
                            </td>
                            <td>
                                <strong>Volatile-Isolurane/ Sevoflurane:</strong> {{isset($anaesthetist_record_data->vol_iso_sevof) ?  $anaesthetist_record_data->vol_iso_sevof :'N/A'}}
                            </td>
                            <td>
                                <strong>Air:</strong> {{isset($anaesthetist_record_data->air) ?  $anaesthetist_record_data->air :'N/A'}}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div><strong>Regional Technique</strong></div>
                                <strong>Type :</strong> {{isset($anaesthetist_record_data->regional_type) ?  $anaesthetist_record_data->regional_type :'N/A'}}
                            </td>
                            <td>
                                <strong>Site/Approach/leve :</strong> {{isset($anaesthetist_record_data->site_approach_level) ?  $anaesthetist_record_data->site_approach_level :'N/A'}}
                            </td>
                            <td>
                                <strong>Needle :</strong> {{isset($anaesthetist_record_data->needle) ?  $anaesthetist_record_data->needle :'N/A'}}
                            </td>
                            <td>
                                <strong>Needle size :</strong> {{isset($anaesthetist_record_data->needle_size) ?  $anaesthetist_record_data->needle_size :'N/A'}}
                            </td>
                            <td>
                                <strong>Single Shot :</strong> {{isset($anaesthetist_record_data->single_shot) ?  $anaesthetist_record_data->single_shot :'N/A'}}
                            </td>

                        </tr>
                        <tr>
                            <td>
                                <strong>Catheter:</strong> {{isset($anaesthetist_record_data->catheter) ?  $anaesthetist_record_data->catheter :'N/A'}}
                            </td>
                            <td>
                                <strong>Ultrasound guided:</strong> {{isset($anaesthetist_record_data->ultrasound_guided) ?  $anaesthetist_record_data->ultrasound_guided :'N/A'}}
                            </td>
                            <td>
                                <strong>Nerve stimulator:</strong> {{isset($anaesthetist_record_data->nerve_stimulator) ?  $anaesthetist_record_data->nerve_stimulator :'N/A'}}
                            </td>
                            <td>
                                <strong>Drugs:</strong> {{isset($anaesthetist_record_data->drugs) ?  $anaesthetist_record_data->drugs :'N/A'}}
                            </td>
                            <td>
                                <strong>Assessment-Complete/ partial/ failed:</strong> {{isset($anaesthetist_record_data->ass_comp_partial) ?  $anaesthetist_record_data->ass_comp_partial :'N/A'}}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div><strong>Condition on leaving OT</strong></div>
                                <strong>Induction agent used</strong> {{isset($anaesthetist_record_data->induction_agent_used) ?  $anaesthetist_record_data->induction_agent_used :'N/A'}}
                            </td>
                            <td>
                                <strong>Analgesia used</strong> {{isset($anaesthetist_record_data->analgesia_used) ?  $anaesthetist_record_data->analgesia_used :'N/A'}}
                            </td>
                            <td>
                                <strong>Muscle relaxant used</strong> {{isset($anaesthetist_record_data->muscle_relaxant_used) ?  $anaesthetist_record_data->muscle_relaxant_used :'N/A'}}
                            </td>
                            <td>
                                <strong>Crystalloid fluid used</strong> {{isset($anaesthetist_record_data->crystalloid_fluid_used) ?  $anaesthetist_record_data->crystalloid_fluid_used :'N/A'}}
                            </td>
                            <td>
                                <strong>Colloid fluid used</strong> {{isset($anaesthetist_record_data->colloid_fluid_used) ?  $anaesthetist_record_data->colloid_fluid_used :'N/A'}}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Blood product used</strong> {{isset($anaesthetist_record_data->blood_product_used) ?  $anaesthetist_record_data->blood_product_used :'N/A'}}
                            </td>
                            <td>
                                <strong>Additional drug used</strong> {{isset($anaesthetist_record_data->additional_drug_used) ?  $anaesthetist_record_data->additional_drug_used :'N/A'}}
                            </td>
                            <td>
                                <strong>Reversal drugs</strong> {{isset($anaesthetist_record_data->reversal_drugs) ?  $anaesthetist_record_data->reversal_drugs :'N/A'}}
                            </td>
                            <td>
                                <strong>Urine output</strong> {{isset($anaesthetist_record_data->urine_output) ?  $anaesthetist_record_data->urine_output :'N/A'}}
                            </td>
                            <td>
                                <strong>Blood loss (Approx)</strong> {{isset($anaesthetist_record_data->blood_loss) ?  $anaesthetist_record_data->blood_loss :'N/A'}}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <strong> {{isset($anaesthetist_record_data->cuff_non_cutpvc) ? $anaesthetist_record_data->cuff_non_cutpvc :'N/A'}}</strong>
                                <br>
                                {{isset($anaesthetist_record_data->yes_no) ? $anaesthetist_record_data->yes_no :'N/A'}}
                            </td>
                            <td colspan="2">

                                <div><strong> LASpray :</strong></div>
                                {{isset($anaesthetist_record_data->laspray_yes_no) ? $anaesthetist_record_data->laspray_yes_no :'N/A'}}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <div style="margin-top:100px ">
                                    <strong> Courtesy by <br>{{isset($anaesthetist_record_data->injected_by_name) ? $anaesthetist_record_data->injected_by_name.'Ing. Calypsol Ing.' :''}} </strong>

                                </div>

                            </td>
                            <td colspan="2">
                                <div style="margin-top:100px ">
                                    <strong> Sing. of Anesthesiologist</strong> <br>
                                    {{isset($anaesthetist_record_data->sign_anaesthetist_name) ? $anaesthetist_record_data->sign_anaesthetist_name :'N/A'}}
                                </div>

                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </section>
        </div>
    </main>


    {{-- <div class="signature_">
        <table style="width: 100%; border:none;">
            <tr style=" ">
                <td style="text-align:left; border:none;">
                    <span style="padding:5px; border-top: black solid 1px;"> Employee Signature
                    </span>
                </td>
                <td style="text-align:right; border:none;">
                    <span style="padding:5px; border-top: black solid 1px;"> Approved By </span>
                </td>
            </tr>
        </table>
    </div> --}}


</body>

</html>
