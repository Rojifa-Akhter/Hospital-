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
    <title>Appointment Details</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    {{-- <link rel="stylesheet" href="{{ public_path().'/css/print.css' }}" media="print"> --}}
    <style>
        @page {
            margin: .3cm .3cm;
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
            height: 2.0cm;
            border-bottom: 1px solid;
            padding: 0 1cm;
            margin-top: 20px;
        }



        header img {
            /*width: 80px;*/
        }

        /** Define now the real margins of every page in the PDF **/
        body {
            margin-top: <?=$body_top ?>cm;
            margin-left: .3cm;
            margin-right: .3cm;
            margin-bottom: 2cm;
            font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
            font-size: <?=$body_font_size ?>px;
            font-size: 10px;
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
            font-family: 'Helvetica';
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

<body>
    <header>
        <table style="width: 100%; border:none;" class="signature">
            <tr>


                <td style="text-align:center; border:none;">
                    <span style="font-size: 25px;"> <strong>
                            {{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }}
                        </strong></span>
                    <br>

                    <span style="font-size: 10px;">
                        Address:
                        {{ isset($po_hospital_details->addrress1) ? $po_hospital_details->addrress1 : '' }}</span><br>

                    <span style="font-size: 10px;">
                        Phone No:
                        {{ isset($po_hospital_details->telephone1) ? $po_hospital_details->telephone1 : '' }}</span>
                </td>

            </tr>
        </table>
    </header>
    <footer style="font-size:9px;">
        <div class="footer">
            <div class="container">
                <table style="width: 100%; padding:3px; margin: 0">
                    <tr>
                        <td style="font-size: 9px; text-align:left;">Print Date: <strong>
                                @php
                                    date_default_timezone_set('Asia/Dhaka');
                                    $date = date('d/m/Y h:i:s a');
                                @endphp
                                {{ $date }}
                            </strong> Prepared By: <strong>{{ $prepared_by_info->user_fullname }}</strong>, Printed By:
                            <strong>{{ Session::get('user.ses_user_name') }}</strong>
                        </td>
                        <td style="font-size: 9px; text-align: right;"><strong>Powered By - H360 [NextGenIT] </strong>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </footer>
    <main>
        <div class="admission_body text-center" style="margin-left:30px;">
            <table width="100%; border-collapse: collapse;" >
                <tr style="">
                    <td style="text-align:left" width="30%"> <img style=""
                            src="data:image/png;base64, {{ $barcode_pat_no }} " style="width: 120px; " />
                        <br>
                        {{ @$appoint_info->patient_code }}
                    </td>
                    <td class="text-center" colspan="2">
                        <div class="first_part text-center" style="font-size: 20px; margin-bottom: 10px;">
                            <strong>Appointment Details</strong> <br>

                        </div>
                    </td>

                    <td style="text-align: right; padding-right:30px" width="30%">
                        <img style="" src="data:image/png;base64, {{ $barcode_admission_no }} "
                            style="width: 120px; " /> <br>
                        {{ @$appoint_info->appoint_no_pk }}
                    </td>

                </tr>
            </table>
            <table width="100%; border-collapse: collapse;" style="margin-top: 10px;">
                <tr>
                    <td colspan="4" style="text-align: left; font-size:15px; padding-bottom:15px"> <strong> <span
                                style="border-bottom: 1px solid black"> Patient Info</span> </strong></td>
                </tr>
                <tr>
                    <td><strong>Patient Id </strong></td>
                    <td> : {{ @$appoint_info->patient_code }}</td>
                    <td><strong>Appointment No </strong></td>
                    <td> : {{ @$appoint_info->appoint_no_pk }}</td>

                </tr>
                <tr>
                    <td><strong>Patient Name</strong></td>
                    <td> : <strong> {{ @$appoint_info->patient_name }} </strong></td>
                    <td><strong>Mobile No</strong></td>
                    <td> : <strong> {{ @$appoint_info->mobile1 }} </strong></td>
                </tr>
                <tr>
                    {{-- <td><strong>Patient Valueable Accesories</strong></td>
                <td>: {{ @$appoint_info->pat_valuable_accessories }}</td> --}}
                    <td><strong>Age</strong></td>
                    <td> : {{ @$appoint_info->age }}</td>
                    <td><strong>Gender</strong></td>
                    <td> : {{ @$appoint_info->gender_txt }}</td>
                </tr>
                <tr>
                    <td><strong>DOB</strong></td>
                    <td> :
                        {{ @$appoint_info->patient_dob != '' ? date('d/m/Y', strtotime(@$appoint_info->patient_dob)) : '' }}
                    </td>
                    <td><strong> Patient Type </strong></td>
                    <td style="padding-bottom: 10px"> : {{ @$appoint_info->patient_type_code }}</td>
                </tr>

                <tr>
                    <td><strong>Marital Status </strong></td>
                    <td> : {{ @$appoint_info->marital_status_txt }}</td>
                    <td><strong>Spouse Name </strong></td>
                    <td> : {{ @$appoint_info->spouse_name }}</td>
                </tr>

                <tr>
                    <td><strong> Address </strong></td>
                    <td> : {{ @$appoint_info->present_addr }}
                        {{ @$appoint_info->present_district != '' && @$appoint_info->present_addr != '' ? ',' . @$appoint_info->present_district : '' }}
                    </td>
                    <td><strong>Email</strong></td>
                    <td> : {{ $appoint_info->emil  }}</td>
                </tr>

                <tr>
                    <td><strong>Reffering Physician</strong></td>
                    <td> : {{ $appoint_info->first_ref_name  }}</td>
                    <td><strong>Provider</strong></td>
                    <td> : {{ $appoint_info->ccm_client_name  }}</td>
                </tr>

                <tr>
                    <td colspan="4" style="text-align: left; font-size:15px; padding-bottom:15px"> <strong> <span
                                style="border-bottom: 1px solid black"> Appointment Info </span> </strong></td>
                </tr>

                <tr>
                    <td><strong>Doctor Name </strong></td>
                    <td> : {{ @$appoint_info->full_name }}</td>
                    <td><strong>Visit Type </strong></td>
                    <td> :{{ @$appoint_info->new_ward_name != '' ? @$appoint_info->new_ward_name : @$appoint_info->ward_name }}
                    </td>
                </tr>

                <tr>
                    <td><strong>Appointment Type </strong></td>

                    <td> : <strong> {{ @$appoint_info->appoint_type_code }} </strong></td>

                    <td><strong>Reason for visit </strong></td>
                    <td> :
                        {{ @$appoint_info->reason_for_visit != '' ? @$appoint_info->reason_for_visit : '' }}
                    </td>
                </tr>

                <tr>
                    <td><strong>Appointment Date</strong></td>
                    <td> : {{ date('d/m/Y', strtotime(@$appoint_info->appoint_date)) }}</td>
                    <td><strong>Start & End Time</strong></td>
                    <td> :
                        </strong>{{ date('h:i a', strtotime(@$appoint_info->start_time)) }} -
                        {{ date('h:i a', strtotime(@$appoint_info->end_time)) }}
                    </td>
                </tr>

                <tr>
                    <td><strong>Appointment Note</strong></td>
                    <td colspan="3"> : {{ @$appoint_info->appoint_note }}</td>

                </tr>




            </table>

        </div>
    </main>


</body>

</html>
