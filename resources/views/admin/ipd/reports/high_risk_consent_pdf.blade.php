<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Item Type Wise Report</title>
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
                <span class="report-name" style="width:100%; font-size:20px ;  padding:10px;  "> <strong> High Risk Consent
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
                    <div style=" border: 1 solid rgb(177, 175, 175);  border-radius: 5px;">

                        <table width="100%">
                            <tr>
                                <td colspan="2">
                                    <div> <strong> Name of pt </strong></div>
                                    <div>{{ isset($pat_info->patient_name) ? $pat_info->patient_name : 'N/A' }}</div>
                                </td>
                                <td>
                                    <div><strong>UHID No</strong></div>
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
                                <td colspan="2">
                                    <div><strong> Reg. Date</strong></div>
                                    {{ isset($pat_info->reg_date) ? $pat_info->reg_date : '' }}
                                </td>
                                <td colspan="4">
                                    <div> <strong>Referred Doctor</strong></div>
                                    <div>
                                        {{ isset($pat_info->primary_doctor_name) ? $pat_info->primary_doctor_name : 'N/A' }}
                                    </div>
                                </td>
                            </tr>

                        </table>
                    </div>


                    <div style="margin-top:10px">
                        <div>
                            @php
                                $Rreoperative = isset($high_risk_consent->person_name) ? $high_risk_consent->person_name : '';
                            @endphp
                            <?php echo $Rreoperative; ?>
                        </div>

                        <div style="text-align: right; margin-top:50px; margin-bottom:10px">
                            <span> {{ isset($high_risk_consent->representative) ? $high_risk_consent->representative : '' }}</span> <br>
                            <span style="border-top:1px dotted black">( Patient/Representative) Relation of Patient</span>
                        </div>
                        <h3>   Reasons for High Risk</h3>
                        <table width="100%" id="info" style="border-collapse: collapse; margin-bottom:20px; ">
                            <tr>
                                <td style="border:none">
                                    @php
                                        $Rreoperative2 = isset($high_risk_consent->high_riskreason) ? $high_risk_consent->high_riskreason : '';
                                    @endphp

                                    <?php echo $Rreoperative2; ?>

                                </td>
                            </tr>

                        </table>
                        <div style="margin-bottom:10px">
                            I / We also state that , I / We or my / our family shall not hold  {{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }} , it's doctor or any other employee for any consequences whatsoever , it has also been explained to me / us that the TARIFF FOR THE HIGH RISK CASES IS SUBSTANTIALLY HIGHER THAN NON HIGH RISK CASES.
                        </div>
                        <table width="100%" id="info" style="border-collapse: collapse;">
                            <tr>
                                <td style="width: 250px"> <strong>Name of the relative authorizing the surgeon to carry
                                        the operation : </strong> </td>
                                <td>
                                    {{ isset($high_risk_consent->relative_name) ? $high_risk_consent->relative_name : '' }}

                                </td>
                            </tr>
                            <tr>

                                <td style="width: 150px"> <strong>Relationship to the patient : </strong> </td>
                                <td>
                                    {{ isset($high_risk_consent->relationship) ? $high_risk_consent->relationship : '' }}

                                </td>
                            </tr>

                        </table>
                        <table width="100%" id="info" style="border-collapse: collapse;">
                            <tr>
                                <td style="width: 250px" rowspan="2"> <strong>Signed in the presence of witness :
                                    </strong> </td>
                                <td>
                                    {{ isset($high_risk_consent->witness_sign1) ? $high_risk_consent->witness_sign1 : '' }}

                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                {{-- <td style="width: 150px"> <strong>Relationship to the patient  : </strong> </td> --}}
                                <td>
                                    {{ isset($high_risk_consent->witness_sign2) ? $high_risk_consent->witness_sign2 : '' }}
                                </td>
                                <td></td>
                            </tr>

                        </table>
                    </div>
                    <div style="text-align: right;  margin-top:100px;  margin-bottom:10px">
                        <span style="border-top: 2px dotted gray"> Signature of the Doctor </span>
                    </div>
                    <table width="100%" id="info" style="border-collapse: collapse;">
                        <tr>
                            <td style="width: 150px"> <strong>Name of the Doctor who explained the risk : </strong>
                            </td>
                            <td>
                                {{ isset($high_risk_consent->explainery_doctor_name) ? $high_risk_consent->explainery_doctor_name : '' }}

                            </td>
                        </tr>
                        <tr>
                            <td> <strong> Date </strong> </td>
                            <td>
                                {{ isset($high_risk_consent->sig_date) ? date('d-m-Y', strtotime($high_risk_consent->sig_date)) : '' }}
                            </td>
                        </tr>
                    </table>
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
