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
                <span class="report-name" style="width:100%; font-size:20px ;  padding:10px;  "> <strong> Pre-operative Instructions</strong></span>
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
                                <td colspan="2">
                                    <div> <strong> Name of patient </strong></div>
                                    <div>{{ isset($pat_info->patient_name) ? $pat_info->patient_name : 'N/A' }}</div>
                                </td>

                                <td>
                                    <div><strong>Age</strong></div>
                                    {{ isset($pat_info->age) ? $pat_info->age : 'N/A' }}
                                </td>
                                <td>
                                    <div><strong>Sex</strong></div>
                                    {{ isset($pat_info->gender_txt) ? $pat_info->gender_txt : 'N/A' }}
                                </td>


                            </tr>
                            <tr>

                                <td>
                                    <div><strong>Date</strong></div>
                                    {{ isset($anesthetics_checkup_form->ot_date) ? date('d-m-Y', strtotime($anesthetics_checkup_form->ot_date)) : 'N/A' }}
                                </td>
                                <td>
                                    <div> <strong> Department </strong></div>
                                    <div>{{ isset($pat_info->new_su_name) ? $pat_info->new_su_name : 'N/A' }}</div>
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

                                <td>
                                    <div><strong> Blood Group</strong></div>
                                    {{ isset($pat_info->blood_group_text) ? $pat_info->blood_group_text : 'N/A' }}
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
                                <td>
                                    <strong> Preoperative Diagnosis : </strong>
                                    {{ isset($anesthetics_checkup_form->preoperative_diagnosis) ? $anesthetics_checkup_form->preoperative_diagnosis : '' }}
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <strong> Date of Surgery : </strong>
                                    {{ isset($anesthetics_checkup_form->scheduled_surgery_date) ? date('d/m/Y', strtotime($anesthetics_checkup_form->scheduled_surgery_date)) : '' }}
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <div> <strong>Name of treating Doctor:</strong></div>
                                    <div>
                                        {{ isset($anesthetics_checkup_form->doctor_name) ? $anesthetics_checkup_form->doctor_name : 'N/A' }}
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong> Surgery : </strong>
                                    {{ isset($anesthetics_checkup_form->operation) ? $anesthetics_checkup_form->operation : '' }}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Previous Anesthesia Complication (if any):</strong>
                                    {{ isset($anesthetics_checkup_form->pre_anes_and_comp) ? $anesthetics_checkup_form->pre_anes_and_comp : '' }}
                                </td>
                            </tr>

                        </table>
                    </div>


                    <h2>Pre-operative Instructions</h2>
                    <table width="100%" id="info" style="margin-top:10px">
                        <tr>
                            <td><strong>1. NPO :
                                {{ isset($anesthetics_checkup_form->pre_operative_ins1) ? $anesthetics_checkup_form->pre_operative_ins1 : '' }} </strong>
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
