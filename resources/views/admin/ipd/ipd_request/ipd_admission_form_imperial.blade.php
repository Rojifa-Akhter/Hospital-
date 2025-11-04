@php
    $hospital = DB::table('wsec_hospital')
        ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
        ->first();
    // dd( $hospital);
    $body_font_size = $po_hospital_details->hospital_code == 'GMC' ? 14 : 11;
    $footer_bottom = $po_hospital_details->hospital_code == 'GMC' ? 25 : 10;
    $signature_bottom = $po_hospital_details->hospital_code == 'GMC' ? 2.6 : 1.6;
    $body_top = $po_hospital_details->hospital_code == 'GMC' ? 3.8 : 3;
    $footer_border = $po_hospital_details->hospital_code == 'GMC' ? 'none' : '1px solid #000';
@endphp

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>IPD Admission Form</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    {{-- <link rel="stylesheet" href="{{ public_path().'/css/print.css' }}" media="print"> --}}
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
        /* header {
            position: fixed;
            top: 0;
            height: 2.5cm;
            border-bottom: 1px solid;
            padding-top: 10px;
        } */

        header img {
            /*width: 80px;*/
        }

        /** Define now the real margins of every page in the PDF **/
        body {
            margin-top: 1cm;
            margin-left: .3cm;
            margin-right: .3cm;
            margin-bottom: 2cm;
            font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
            font-size: <?=$body_font_size ?>px;
        }

        footer {
            position: fixed;
            z-index: 999999999;
            left: 10px;
            right: 10px;
            height: 0.7cm;
            text-align: center;
            font-size: 9px;
            bottom: <?=$footer_bottom ?>px;
            /*border-top: 1px solid black;*/
            /* padding-top: 5px; */
            border-top: <?=$footer_border ?>;
        }

        .signature_ {
            position: fixed;
            bottom: <?=$signature_bottom ?>cm;
            left: .8cm;
            right: 1.6cm;
            width: 100%;
            /* text-align: center; */

            /* border-top: 1px solid; */
        }

        main tr {
            line-height: 20px;
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

        @page {
            margin: 0cm 0cm;
        }

        @font-face {
            font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
            font-weight: normal;
            font-style: normal;
            font-variant: normal;
            src: url("font url");
        }


        .page-break {
            page-break-after: always;
        }

        /*body part */
        .border-bottom {
            border-bottom: 1px solid #000;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .text-left {
            text-align: left;
        }

        .w-100 {
            width: 100%;
        }

        .w-50 {
            width: 50%;
        }

        .w-70 {
            width: 70%;
        }

        .w-30 {
            width: 30%;
        }
    </style>
</head>

<body onload="window.print()">
    <header>
        <table style="width: 100%; border:5px solid transparent !important" class="signature">
            <tr style="">
                <td style="text-align:left; width:0px;">
                    {{-- <img class="hospital-logo"
                        src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}" width="120"
                        alt="" style="margin-left:22px;"> --}}
                    @if (!empty($po_hospital_details->logo))
                        <img src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}"
                            width="100px" alt="" style="margin-left:22px;" />
                    @endif
                </td>

                <td style="text-align:left;">
                    <h1 class="mb-0" style="margin-top:0px">
                        {{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }}</h1>
                    {{-- Address:<span>
                        {{ isset($po_hospital_details->addrress1) ? $po_hospital_details->addrress1 : '' }}</span><br>
                    Phone
                    No:<span>{{ isset($po_hospital_details->telephone1) ? $po_hospital_details->telephone1 : '' }}</span> --}}
                    <p class="mb-0 " style="font-size:18px; margin-top:8px">
                        {{ isset($po_hospital_details->addrress1) ? $po_hospital_details->addrress1 : '' }}</p>

                    <p class="mb-0 "style="font-size:18px; margin-top:8px">
                        {{ isset($po_hospital_details->telephone1) ? $po_hospital_details->telephone1 : '' }}</p>


                </td>
            </tr>
        </table>
    </header>
    <footer style="font-size:9px;">
        <div class="footer">
            <div class="container">
                <table style="width: 100%; padding:3px; margin: 0">
                    <tr>
                        <td style="font-size: 9px; text-align:left;">Print Date:
                            @php
                                date_default_timezone_set('Asia/Dhaka');
                                $date = date('d/m/Y h:i:s a');
                            @endphp
                            {{ $date }}
                            Prepared By: {{ $prepared_by_info->user_fullname }}, Printed By:
                            {{ Session::get('user.ses_user_name') }}
                        </td>
                        <td style="font-size: 9px; text-align: right;">Powered By - H360 [NextGenIT]
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </footer>
    <main>
        <div class="admission_body text-center" style="margin-left:30px;">

            <table width="100%; border-collapse: collapse;" style="margin-top:10px">
                <tr style="">
                    <td style="text-align:left;font-size:12px;" width="20%"> <img style=""
                            src="data:image/png;base64, {{ $barcode_pat_no }} " style="width: 120px; " />
                        <br>
                        Patient ID: {{ $admission_pat->patient_code }}
                    </td>
                    <td style="width: 60%">
                        <p
                            style="text-align: center;
            margin: 0 auto;
            padding: 5px;
            width: 60%;
            font-size: 20px !important;
            background: aliceblue;
            border: 2px solid #000;
            border-radius: 7px;
            font-family: IBM Plex Sans,Helvetica,Arial,sans-serif;
            font-weight: bold;
            ">
                            Admission Form</p>
                    </td>
                    <td style="text-align: right; padding-right:30px;font-size:12px;" width="20%">
                        <img style="" src="data:image/png;base64, {{ $barcode_admission_no }} "
                            style="width: 120px; " /> <br>
                        Admission ID: {{ $admission_pat->admission_uid }}
                    </td>

                </tr>
            </table>



            <table width="100%; border-collapse: collapse;" style="">
                <tr>
                    <td colspan="6" style="border-bottom:1px solid #000;padding-top:20px;">
                        <div class="first_part text-left" style="font-size: 20px;">
                            <strong
                                style="
                        font-size: 20px !important;
                        background: aliceblue;
                        font-family: IBM Plex Sans,Helvetica,Arial,sans-serif;
                        font-weight: bold;
                        ">Patient
                                Info <br>

                        </div>
                    </td>
                </tr>


                <tr>
                    <td style="width:21%;text-align:left; font-size:14px">Patient Name</td>
                    <td style="width:3%;text-align:left;">:</td>
                    <td style="width:31%;text-align:left;  font-size:14px">
                        {{ ucfirst($admission_pat->patient_name) }}
                    </td>

                    <td style="width:21%;text-align:right; font-size:14px">Gender</td>
                    <td style="width:3%;text-align:left;">:</td>
                    <td style="width:31%;text-align:left;  font-size:14px">
                        {{ ucfirst($admission_pat->gender_txt) }}
                    </td>

                    {{-- <td style="width:18%;text-align:left; font-size:14px">Date Of Admission</td>
                    <td style="width:2%;text-align:left;">:</td>
                    <td style="width:25%;text-align:left;  font-size:13px;">
                        {{ date('d/m/Y h:i:s a', strtotime($admission_pat->admission_date)) }}

                    </td> --}}
                </tr>

                <tr>
                    <td style="width:21%;text-align:left; font-size:14px">Age</td>
                    <td style="width:3%;text-align:left;">:</td>
                    <td style="width:31%;text-align:left;  font-size:14px">
                        {{ $admission_pat->age }}
                    </td>

                    <td style="width:21%;text-align:right; font-size:14px">Occupation</td>
                    <td style="width:3%;text-align:left;">:</td>
                    <td style="width:31%;text-align:left;  font-size:14px">

                    </td>
                </tr>

                <tr>
                    <td style="width:21%;text-align:left; font-size:14px">Marital Status</td>
                    <td style="width:3%;text-align:left;">:</td>
                    <td style="width:31%;text-align:left;  font-size:14px">
                        {{ ucfirst($admission_pat->marital_status_txt) }}
                    </td>

                    <td style="width:21%;text-align:right; font-size:14px">Religion</td>
                    <td style="width:3%;text-align:left;">:</td>
                    <td style="width:31%;text-align:left;  font-size:14px">
                        {{ ucfirst($admission_pat->religion_txt) }}
                    </td>
                </tr>

                <tr>
                    <td style="width:21%;text-align:left; font-size:14px">Mobile</td>
                    <td style="width:3%;text-align:left;">:</td>
                    <td style="width:31%;text-align:left;  font-size:14px">
                        {{ $admission_pat->mobile1 }}
                    </td>

                    <td style="width:21%;text-align:right; font-size:14px">C/O</td>
                    <td style="width:3%;text-align:left;">:</td>
                    <td style="width:31%;text-align:left;  font-size:14px">
                        {{ !empty($admission_pat->accompanied_by) ? ucfirst($admission_pat->accompanied_by) : '' }}
                    </td>
                </tr>
                <tr>
                    <td style="width:21%;text-align:left; font-size:14px">Father's/Spouse Name</td>
                    <td style="width:3%;text-align:left;">:</td>
                    <td style="width:31%;text-align:left;  font-size:14px" colspan="4">
                        {{ !empty($admission_pat->father_name) ? ucfirst($admission_pat->father_name) : '' }}
                    </td>
                </tr>
                <tr>
                    <td style="width:21%;text-align:left; font-size:14px">Mother's Name</td>
                    <td style="width:3%;text-align:left;">:</td>
                    <td style="width:31%;text-align:left;  font-size:14px" colspan="4">
                        {{ !empty($admission_pat->mother_name) ? ucfirst($admission_pat->mother_name) : '' }}

                    </td>
                </tr>

                <tr>
                    <td style="width:21%;text-align:left; font-size:14px">Present Address</td>
                    <td style="width:3%;text-align:left;">:</td>
                    <td style="width:82%;text-align:left;font-size:14px " colspan="4"><span
                            style="  ">{{ $admission_pat->present_addr }}
                            {{ $admission_pat->present_district != '' && $admission_pat->present_addr != '' ? ',' . $admission_pat->present_district : '' }}</span>
                    </td>
                </tr>

                <tr>
                    <td style="width:21%;text-align:left; font-size:14px">Permanent Address</td>
                    <td style="width:3%;text-align:left;">:</td>
                    <td style="width:82%;text-align:left;font-size:14px " colspan="4"><span
                            style="  ">{{ $admission_pat->present_addr }}
                            {{ $admission_pat->present_district != '' && $admission_pat->present_addr != '' ? ',' . $admission_pat->present_district : '' }}</span>
                    </td>
                </tr>

                {{-- Additional Info  --}}


                <tr>
                    <td colspan="6" style="border-bottom:1px solid #000;padding-top:20px;">
                        <div class="first_part text-left" style="font-size: 20px;">
                            <strong
                                style="
                        font-size: 20px !important;
                        background: aliceblue;
                        font-family: IBM Plex Sans,Helvetica,Arial,sans-serif;
                        font-weight: bold;
                        ">Additional
                                Info <br>

                        </div>
                    </td>
                </tr>


                <tr>
                    <td style="width:21%;text-align:left; font-size:14px">NID</td>
                    <td style="width:3%;text-align:left;">:</td>
                    <td style="width:31%;text-align:left;  font-size:14px">
                        {{ '' }}
                    </td>

                    <td style="width:21%;text-align:right; font-size:14px">Email</td>
                    <td style="width:3%;text-align:left;">:</td>
                    <td style="width:31%;text-align:left;  font-size:14px">
                        {{ !empty($admission_pat->email) ? ucfirst($admission_pat->email) : '' }}
                    </td>
                </tr>

                <tr>
                    <td style="width:21%;text-align:left; font-size:14px">Valuable Accessories</td>
                    <td style="width:3%;text-align:left;">:</td>
                    <td style="width:31%;text-align:left;  font-size:14px">
                        {{ !empty($admission_pat->pat_valuable_accessories) ? ucfirst($admission_pat->pat_valuable_accessories) : '' }}
                    </td>

                    <td style="width:21%;text-align:right; font-size:14px">Referral</td>
                    <td style="width:3%;text-align:left;">:</td>
                    <td style="width:31%;text-align:left;  font-size:14px">
                        {{ !empty($admission_pat->refrral_doctor_name) ? ucfirst($admission_pat->refrral_doctor_name) : '' }}
                    </td>
                </tr>


                <tr>
                    <td style="width:21%;text-align:left; font-size:14px">Cause Of Admission</td>
                    <td style="width:3%;text-align:left;">:</td>
                    <td style="width:82%;text-align:left;font-size:14px " colspan="4"><span
                            style="  ">{{ !empty($admission_pat->cause_of_admission) ? ucfirst($admission_pat->cause_of_admission) : '' }}</span>
                    </td>
                </tr>
                <tr>
                    <td style="width:21%;text-align:left; font-size:14px">Patient Condition</td>
                    <td style="width:3%;text-align:left;">:</td>
                    <td style="width:82%;text-align:left;font-size:14px " colspan="4"><span
                            style="  ">{{ !empty($admission_pat->pat_condition) ? ucfirst($admission_pat->pat_condition) : '' }}</span>
                    </td>
                </tr>


                <tr>
                    <td style="width:21%;text-align:left; font-size:14px"></td>
                    <td style="width:3%;text-align:left;"></td>
                    <td style="width:82%;text-align:left;font-size:14px " colspan="4"><span style="  "></span>
                    </td>
                </tr>


                {{-- Emergency Contact  --}}
                <tr>
                    <td colspan="6" style="border-bottom:1px solid #000;padding-top:20px;">
                        <div class="first_part text-left" style="font-size: 20px;">
                            <strong
                                style="
                        font-size: 20px !important;
                        background: aliceblue;
                        font-family: IBM Plex Sans,Helvetica,Arial,sans-serif;
                        font-weight: bold;
                        ">Emergency
                                Contact <br>

                        </div>
                    </td>
                </tr>
                <tr>
                    <td style="width:21%;text-align:left; font-size:14px">Name</td>
                    <td style="width:3%;text-align:left;">:</td>
                    <td style="width:82%;text-align:left;font-size:14px " colspan="4"><span
                            style="  ">{{ !empty($admission_pat->contact_person) ? $admission_pat->contact_person : '' }}</span>
                    </td>
                </tr>




                <tr>
                    <td style="width:21%;text-align:left; font-size:14px">Relation With Patient</td>
                    <td style="width:3%;text-align:left;">:</td>

                    <td style="width:82%;text-align:left;font-size:14px " colspan="4"><span
                            style="  ">{{ !empty($admission_pat->contact_relaion) ? $admission_pat->contact_relaion : '' }}</span>
                    </td>
                </tr>
                <tr>
                    <td style="width:21%;text-align:left; font-size:14px">Contact Number</td>
                    <td style="width:3%;text-align:left;">:</td>
                    <td style="width:82%;text-align:left;font-size:14px " colspan="4"><span
                            style="  ">{{ !empty($admission_pat->contact_person_mobile) ? $admission_pat->contact_person_mobile : '' }}</span>
                    </td>
                </tr>


                {{-- Admission Infor  --}}
                <tr>
                    <td colspan="6" style="border-bottom:1px solid #000;padding-top:20px;">
                        <div class="first_part text-left" style="font-size: 20px;">
                            <strong
                                style="
                        font-size: 20px !important;
                        background: aliceblue;
                        font-family: IBM Plex Sans,Helvetica,Arial,sans-serif;
                        font-weight: bold;
                        ">Admission
                                Info <br>

                        </div>
                    </td>
                </tr>
                {{-- <tr>
                    <td style="width:21%;text-align:right; font-size:14px">Admission/Indoor ID</td>
                    <td style="width:3%;text-align:left;">:</td>
                    <td style="width:82%;text-align:left;font-size:14px " colspan="4"><span
                            style="  ">{{ $admission_pat->present_addr }}
                            {{ $admission_pat->present_district != '' && $admission_pat->present_addr != '' ? ',' . $admission_pat->present_district : '' }}</span>
                    </td>
                </tr> --}}
                <tr>
                    <td style="width:21%;text-align:left; font-size:14px">Admission Date & Time</td>
                    <td style="width:3%;text-align:left;">:</td>
                    <td style="width:82%;text-align:left;font-size:14px " colspan="4"><span
                            style="  ">{{ date('d/m/Y h:i:s a', strtotime($admission_pat->admission_date)) }}</span>
                    </td>
                </tr>
                <tr>
                    <td style="width:21%;text-align:left; font-size:14px">Ward/Cabin No.</td>
                    <td style="width:3%;text-align:left;">:</td>
                    <td style="width:82%;text-align:left;font-size:14px " colspan="4">
                        {{ $admission_pat->ward_name != '' ? $admission_pat->ward_name : $admission_pat->ward_name }}
                        ({{ $admission_pat->new_bed_name != '' ? $admission_pat->new_bed_name : $admission_pat->bed_name }})
                    </td>
                </tr>
                <tr>
                    <td style="width:21%;text-align:left; font-size:14px">Referred By</td>
                    <td style="width:3%;text-align:left;">:</td>
                    <td style="width:82%;text-align:left;font-size:14px " colspan="4"><span
                            style="  ">{{ !empty($admission_pat->first_ref_doctor_name) ? ucfirst($admission_pat->first_ref_doctor_name) : '' }}</span>
                    </td>
                </tr>
                <tr>
                    <td style="width:21%;text-align:left; font-size:14px">Department</td>
                    <td style="width:3%;text-align:left;">:</td>
                    <td style="width:82%;text-align:left;font-size:14px " colspan="4"><span
                            style="  ">{{ !empty($admission_pat->admitted_department) ? ucfirst($admission_pat->admitted_department) : '' }}</span>
                    </td>
                </tr>
                <tr>
                    <td style="width:21%;text-align:left; font-size:14px">Admtted Under</td>
                    <td style="width:3%;text-align:left;">:</td>
                    <td style="width:82%;text-align:left;font-size:14px " colspan="4"><span
                            style="  ">{{ !empty($admission_pat->primary_doctor_name) ? ucfirst($admission_pat->primary_doctor_name) : '' }}</span>
                    </td>
                </tr>
                <tr>
                    <td style="width:21%;text-align:left; font-size:14px">Remarks</td>
                    <td style="width:3%;text-align:left;">:</td>
                    <td style="width:82%;text-align:left;font-size:14px " colspan="4"><span
                            style="  ">{{ !empty($admission_pat->adm_remarks) ? ucfirst($admission_pat->adm_remarks) : '' }}</span>
                    </td>
                </tr>
                </tr>
                </tr>
                </tr>
            </table>

        </div>
    </main>

    <div class="" style="margin-top: 1cm;margin-left:30px;font-size:14px">
        <table style="width: 100%;">
            <tr style=" ">
                <td style="width: 75%;text-align:left;padding-top:20px;">
                    <span style="padding:5px; border-top: black solid 1px;"> Signature of Guardian/ Patient
                    </span>
                </td>

                <td style="text-align:left; width:25%;">
                    <span style="padding:5px; border-top: black solid 1px;"> Admitted By
                    </span>
                </td>

            </tr>
        </table>
    </div>

    <div class="" style="margin-left:30px;font-size:14px">
        <table style="width: 100%;">
            <tr style=" ">
                <td style="text-align:left; width:100%;">
                    <span>
                        I Hereby declare that all information given above in this form are true.
                    </span>
                </td>
            </tr>
        </table>
    </div>
</body>

</html>
