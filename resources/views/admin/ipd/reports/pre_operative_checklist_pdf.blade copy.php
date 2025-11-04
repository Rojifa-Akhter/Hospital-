<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Pre-operative Checklist</title>
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
            /* border-bottom: 1px solid; */
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
            margin-bottom: 1cm;
            font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
            font-size: 14px;
        }

        footer {
            position: fixed;
            bottom: 0cm;
            left: 0cm;
            right: 0cm;
            height: .5cm;
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

        .info td {
            border: 1px solid rgb(177, 175, 175);
        }
        /* table{
            margin-top:10px;
        } */
    </style>
</head>

<body>
    <header>
        <table style="width: 100%; border:none;" class="signature">
            <tr>
                <td style="width: 15%; border:none;">
                    <img class="hospital-logo"
                        src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}" width="60"
                        alt="">
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
                <span class="report-name" style="width:100%; font-size:20px ;  padding:10px;  "> <strong> Preoperative Checklist for Nurse
                    </strong></span>
            </div>
            {{-- <div style=" text-align:center;  width:100%; margin-bottom:10px" class="mb-2">
                <span class="report-date"><strong>From Date: {{ $from_date }}</strong> - <span
                        class="report-date"><strong>To Date: {{ $to_date }}</strong></span>
                </span>
            </div> --}}
            <section id="lp-items">
                <div class="container">
                    <div style="">
                        <h3>Patient Information</h3>
                    </div>
                    <div style="border: 1px solid rgb(177, 175, 175); border-radius: 5px;">
                        <table width="100%">
                            <tr>
                                <td colspan="2">
                                    <strong>Name of Patient:</strong>
                                    <div>{{ isset($pat_info->patient_name) ? $pat_info->patient_name : 'N/A' }}</div>
                                </td>
                                <td>
                                    <strong>Patient ID:</strong>
                                    <div>{{ isset($pat_info->patient_code) ? $pat_info->patient_code : 'N/A' }}</div>
                                </td>
                                <td>
                                    <strong>Age:</strong>
                                    <div>{{ isset($pat_info->age) ? $pat_info->age : 'N/A' }}</div>
                                </td>
                                <td>
                                    <strong>Sex:</strong>
                                    <div>{{ isset($pat_info->gender_txt) ? $pat_info->gender_txt : 'N/A' }}</div>
                                </td>
                                <td>
                                    <strong>Blood Group:</strong>
                                    <div>{{ isset($pat_info->blood_group_text) ? $pat_info->blood_group_text : 'N/A' }}</div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Department:</strong>
                                    <div>{{ isset($pat_info->new_su_name) ? $pat_info->new_su_name : 'N/A' }}</div>
                                </td>
                                <td>
                                    <strong>Ward:</strong>
                                    <div>{{ isset($pat_info->new_ward_name) ? $pat_info->new_ward_name : 'N/A' }}</div>
                                </td>
                                <td>
                                    <strong>Bed:</strong>
                                    <div>{{ isset($pat_info->new_bed_name) ? $pat_info->new_bed_name : 'N/A' }}</div>
                                </td>
                                <td>
                                    <strong>Date:</strong>
                                    <div>{{ isset($pre_operative_checklist->reg_date) ? date('d/m/Y', strtotime($pre_operative_checklist->reg_date)) : 'N/A' }}</div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="6">
                                    <strong>Referred Doctor:</strong>
                                    <div>{{ isset($pat_info->primary_doctor_name) ? $pat_info->primary_doctor_name : 'N/A' }}</div>
                                </td>
                            </tr>
                        </table>
                    </div>
                    
                    <h3><strong> Note: Mark 'Yes/No' against each item by concern person .</strong></h3>

                    <div style="margin-top:10px">
                        <table width="100%" class="info" style="border-collapse: collapse;">
                            <tr>
                                <td style="width: 10px"> <strong> Sl# </strong> </td>
                                <td style="width: 250px"> <strong> Issues </strong> </td>
                                <td style="text-align: center; font-weight:bold">Ward Name</td>
                                <td style="text-align: center; font-weight:bold">OR Nurse</td>
                            </tr>
                            <tr>
                                <td class=''>1 </td>
                                <td class=''>Correct Patient ID, names, age, sex (patient identity)  </td>
                                <td>
                                   {{ isset($pre_operative_checklist->patient_identity1) ? $pre_operative_checklist->patient_identity1 : '' }}
                                </td>
                                <td>
                                  {{ isset($pre_operative_checklist->patient_identity2) ? $pre_operative_checklist->patient_identity2 : '' }}
                                </td>
                            </tr>
                            <tr>
                                <td class=''>2 </td>
                                <td class=''>Nil by Mouth since  </td>
                                <td>
                                  {{ isset($pre_operative_checklist->npo_ensured1) ? $pre_operative_checklist->npo_ensured1 : '' }}
                                </td>
                                <td>
                                  {{ isset($pre_operative_checklist->npo_ensured2) ? $pre_operative_checklist->npo_ensured2 : '' }}
                                </td>
                            </tr>
                            <tr>
                                <td class='' rowspan="2">3 </td>
                                <td class=''>Dress Changed (Clean, Gowned and Cap)</td>
                                <td>
                                    {{ isset($pre_operative_checklist->dress_changed1) ? $pre_operative_checklist->dress_changed1 : '' }}
                                </td>
                                <td>
                                   {{ isset($pre_operative_checklist->dress_changed2) ? $pre_operative_checklist->dress_changed2 : '' }}
                                </td>
                            </tr>
                            <tr>
                                {{-- <td class=''>4 </td> --}}
                                <td class=''>Ornaments/Jewellry/ Amulet /Nail polish removed  </td>
                                <td>
                                 {{ isset($pre_operative_checklist->ornamentjwlryamulet_mv1) ? $pre_operative_checklist->ornamentjwlryamulet_mv1 : '' }}
                                </td>
                                <td>
                                   {{ isset($pre_operative_checklist->ornamentjwlryamulet_mv2) ? $pre_operative_checklist->ornamentjwlryamulet_mv2 : '' }}
                                </td>
                            </tr>
                            <tr>
                                <td class='' rowspan="2">4 </td>
                                <td class=''>Operation Area Clean & Shaved </td>
                                <td>
                                   {{ isset($pre_operative_checklist->opnarea_clean_shaved1) ? $pre_operative_checklist->opnarea_clean_shaved1 : '' }}
                                </td>
                                <td>
                                  {{ isset($pre_operative_checklist->opnarea_clean_shaved2) ? $pre_operative_checklist->opnarea_clean_shaved2 : '' }}
                                </td>
                            </tr>
                            <tr>
                                {{-- <td class=''>6 </td> --}}
                                <td class=''> Operation Site  Marked</td>
                                <td>
                                  {{ isset($pre_operative_checklist->opn_side_marked1) ? $pre_operative_checklist->opn_side_marked1 : '' }}
                                </td>
                                <td>
                                  {{ isset($pre_operative_checklist->opn_side_marked2) ? $pre_operative_checklist->opn_side_marked2 : '' }}
                                </td>
                            </tr>
                            <tr>
                                <td class='' rowspan="2"> 5</td>
                                <td class=''> Consent Form and/ High risk form signed</td>
                                <td>
                                   {{ isset($pre_operative_checklist->consentfrm_sign1) ? $pre_operative_checklist->consentfrm_sign1 : '' }}
                                </td>
                                <td>
                                 {{ isset($pre_operative_checklist->consentfrm_sign2) ? $pre_operative_checklist->consentfrm_sign2 : '' }}
                                </td>
                            </tr>
                            <!-- <tr>
                                {{-- <td class=''> 5</td> --}}
                                <td class=''> High Risk Consent Form Signed </td>
                                <td>
                                  {{ isset($pre_operative_checklist->highriskconsent_frmsign1) ? $pre_operative_checklist->highriskconsent_frmsign1 : '' }}
                                </td>
                                <td>
                                  {{ isset($pre_operative_checklist->highriskconsent_frmsign2) ? $pre_operative_checklist->highriskconsent_frmsign2 : '' }}
                                </td>
                            </tr> -->
                            <tr>
                                <!-- <td class=''> 6</td> -->
                                <td class=''> Pre-Anesthesia Checkup Done </td>
                                <td>
                                  {{ isset($pre_operative_checklist->pre_anesthetic_chkup1) ? $pre_operative_checklist->pre_anesthetic_chkup1 : '' }}
                                </td>
                                <td>
                                    {{ isset($pre_operative_checklist->pre_anesthetic_chkup2) ? $pre_operative_checklist->pre_anesthetic_chkup2 : '' }}
                                </td>
                            </tr>
                            <tr>
                                <td class=''> 6</td>
                                <td class=''> Patient height, weight & BMI measured </td>
                                <td>
                                  {{ isset($pre_operative_checklist->patients_heightweight1) ? $pre_operative_checklist->patients_heightweight1 : '' }}
                                </td>
                                <td>
                                   {{ isset($pre_operative_checklist->patients_heightweight2 ) ? $pre_operative_checklist->patients_heightweight2  : '' }}
                                </td>
                            </tr>
                            <tr>
                                <td class=''> 7</td>
                                <td class=''> Blood is ready in number-Donor standby/ Blood deposited </td>
                                <td>
                                   {{ isset($pre_operative_checklist->blood_is_ready1) ? $pre_operative_checklist->blood_is_ready1 : '' }}
                                </td>
                                <td>
                                  {{ isset($pre_operative_checklist->blood_is_ready2) ? $pre_operative_checklist->blood_is_ready2 : '' }}
                                </td>
                            </tr>

                            <!-- <tr>
                                <td class=''> 9</td>
                                <td class=''> Donor is ready </td>
                                <td>
                                    {{ isset($pre_operative_checklist->donor_is_ready1) ? $pre_operative_checklist->donor_is_ready1 : '' }}
                                </td>
                                <td>
                                  {{ isset($pre_operative_checklist->donor_is_ready2) ? $pre_operative_checklist->donor_is_ready2 : '' }}
                                </td>
                            </tr> -->
                            <tr>
                                <td class=''> 8</td>
                                <td class=''> HBsAg/HCV/HIV </td>
                                <td>
                                  {{ isset($pre_operative_checklist->hbs_ag_hcv_hiv1) ? $pre_operative_checklist->hbs_ag_hcv_hiv1 : '' }}
                                </td>
                                <td>
                                 {{ isset($pre_operative_checklist->hbs_ag_hcv_hiv2) ? $pre_operative_checklist->hbs_ag_hcv_hiv2 : '' }}
                                </td>
                            </tr>
                            <tr>
                                <td class=''> 9</td>
                                <td class=''> All investigation Reports with Radiological Films available (file complete) </td>
                                <td>
                                   {{ isset($pre_operative_checklist->investigationrpt_radiflm1) ? $pre_operative_checklist->investigationrpt_radiflm1 : '' }}
                                </td>
                                <td>
                                  {{ isset($pre_operative_checklist->investigationrpt_radiflm2) ? $pre_operative_checklist->investigationrpt_radiflm2 : '' }}
                                </td>
                            </tr>
                            <tr>
                                <td class=''> 10</td>
                                <td class=''> Monitoring (IV access access / Spo2) opposite to the   operating site </td>
                                <td>
                                   {{ isset($pre_operative_checklist->monitoringopsite_operating1) ? $pre_operative_checklist->monitoringopsite_operating1 : '' }}
                                </td>
                                <td>
                                  {{ isset($pre_operative_checklist->monitoringopsite_operating2) ? $pre_operative_checklist->monitoringopsite_operating2 : '' }}
                                </td>
                            </tr>
                            <tr>
                                <td class=''> 11</td>
                                <td class=''> Allergies </td>
                                <td>
                                 {{ isset($pre_operative_checklist->allergies1) ? $pre_operative_checklist->allergies1 : '' }}
                                </td>
                                <td>
                                 {{ isset($pre_operative_checklist->allergies2) ? $pre_operative_checklist->allergies2 : '' }}
                                </td>
                            </tr>
                            <tr>
                                <td class=''> 12</td>
                                <td class=''> Pacemaker / Artificial Denture/Implant</td>
                                <td>
                                  {{ isset($pre_operative_checklist->pacemaker1) ? $pre_operative_checklist->pacemaker1 : '' }}
                                </td>
                                <td>
                                   {{ isset($pre_operative_checklist->pacemaker2) ? $pre_operative_checklist->pacemaker2 : '' }}
                                </td>
                            </tr>
                            <!-- <tr>
                                <td class=''> 15</td>
                                <td class=''> Artifical Tooth/Denture/Implant </td>
                                <td>
                                  {{ isset($pre_operative_checklist->artificaltooth_denture1) ? $pre_operative_checklist->artificaltooth_denture1 : '' }}
                                </td>
                                <td>
                                   {{ isset($pre_operative_checklist->artificaltooth_denture2) ? $pre_operative_checklist->artificaltooth_denture2 : '' }}
                                </td>
                            </tr> -->
                            <!-- <tr>
                                <td class=''> 16</td>
                                <td class=''> Cornorbidity </td>
                                <td>
                                    {{ isset($pre_operative_checklist->cornorbidity1) ? $pre_operative_checklist->cornorbidity1 : '' }}
                                </td>
                                <td>
                                   {{ isset($pre_operative_checklist->cornorbidity2) ? $pre_operative_checklist->cornorbidity2 : '' }}
                                </td>
                            </tr> -->
                            <tr>
                                <td class=''> 13</td>
                                <td class=''> Anticoagulants in last 5 days </td>
                                <td>
                                  {{ isset($pre_operative_checklist->anticoagulants_last_5days1) ? $pre_operative_checklist->anticoagulants_last_5days1 : '' }}
                                </td>
                                <td>
                                  {{ isset($pre_operative_checklist->anticoagulants_last_5days2) ? $pre_operative_checklist->anticoagulants_last_5days2 : '' }}
                                </td>
                            </tr>
                            <tr>
                                <td class=''> 14</td>
                                <td class=''> Antihypertensive / Bronchodilator/ Other medication taken </td>
                                <td>
                                  {{ isset($pre_operative_checklist->antihpt_bronchodilator1) ? $pre_operative_checklist->antihpt_bronchodilator1 : '' }}
                                </td>
                                <td>
                                  {{ isset($pre_operative_checklist->antihpt_bronchodilator2) ? $pre_operative_checklist->antihpt_bronchodilator2 : '' }}
                                </td>
                            </tr>
                            <tr>
                                <td class=''> 15</td>
                                <td class=''>Hypoglycemic agent/ other (as adv) admitted </td>
                                <td>
                                  {{ isset($pre_operative_checklist->hypoglycemic_agent1) ? $pre_operative_checklist->hypoglycemic_agent1 : '' }}
                                </td>
                                <td>
                                  {{ isset($pre_operative_checklist->hypoglycemic_agent2) ? $pre_operative_checklist->hypoglycemic_agent2 : '' }}
                                </td>
                            </tr>
                            <tr>
                                <td class=''> 16</td>
                                <td class=''> Voided urine </td>
                                <td>
                                  {{ isset($pre_operative_checklist->voided_urine1) ? $pre_operative_checklist->voided_urine1 : '' }}
                                </td>
                                <td>
                                  {{ isset($pre_operative_checklist->voided_urine2) ? $pre_operative_checklist->voided_urine2 : '' }}
                                </td>
                            </tr>

                        </table>
                        <table width="100%" class="info" style="border-collapse: collapse; margin-top:15px" >
                            <tr>
                                <td style="width: 250px">
                                    <strong>Any Additional Information, Implants etc</strong>
                                </td>
                                <td>
                                    {{ isset($pre_operative_checklist->add_info_implants) ? $pre_operative_checklist->add_info_implants : '' }}
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 250px">
                                    <strong>Ward Nurse Name and Signature</strong>
                                </td>
                                <td>
                                    {{ isset($pre_operative_checklist->word_nurse_name) ? $pre_operative_checklist->word_nurse_name : '' }}
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 250px">
                                    <strong>Theatre Nurse Name and Signature</strong>
                                </td>
                                <td>
                                    {{ isset($pre_operative_checklist->theatre_nurse_name) ? $pre_operative_checklist->theatre_nurse_name : '' }}
                                </td>
                            </tr>
                        </table>
                    </div>
                    <!-- <div style="text-align: right;  margin-top:80px">
                        <span style="border-top: 2px dotted gray"> Signature of the Doctor </span>
                    </div> -->
                </div>
            </section>
        </div>
    </main>


    <div class="signature_">
        <table style="width: 98%; border:none;">
            <tr style=" ">
                <td style="text-align:left; border:none;">
                    <span style="padding:5px; border-top: black solid 1px;"> Ward Nurse Name
                    </span>
                </td>
                <td style="text-align:right; border:none;">
                    <span style="padding:5px; border-top: black solid 1px;">Opearting Room Nurse Room</span>
                </td>
            </tr>
        </table>
    </div>


</body>

</html>
<script>
    window.print();
    window.onafterprint = function() {
        window.close(); // Close the window after printing
    }
</script>