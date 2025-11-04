<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <style>
        @page {
            margin-top: 0.5cm;
            margin-bottom: 0.5cm;
            margin-left: 0.5cm;
            margin-right: 0.5cm;
            height: 29.7cm;
            width: 21 cm;
        }

        body {
            margin-top: 0.5cm;
            margin-left: 0.5cm;
            margin-right: 0.5cm;
            /*margin-bottom: 3.5cm;*/
            font-size: 10px;
        }

        .clearfix:after {
            content: "";
            display: table;
            clear: both;
        }

        a {
            color: #0087C3;
            text-decoration: none;
        }


        header {
            padding: 10px 0;
            margin-bottom: 20px;
            border-bottom: 1px solid #AAAAAA;
        }

        #logo {
            float: right;
            margin-top: 8px;
        }

        #logo img {
            height: 70px !important;
        }

        #logo img.barcode_img {
            height: 20px !important;
        }

        #company {
            float: left;
            text-align: left;
        }


        #details {
            margin-bottom: 50px;
        }

        #client {
            padding-left: 6px;
            border-left: 6px solid #0087C3;
            float: left;
        }

        #client .to {
            color: #777777;
        }

        h2.name {
            font-size: 1.4em;
            font-weight: normal;
            margin: 0;
        }

        .candidate_name {
            margin: 0px;
        }

        #invoice {
            float: right;
            text-align: right;
        }

        #invoice h1 {
            color: #0087C3;
            font-size: 2.4em;
            line-height: 1em;
            font-weight: normal;
            margin: 0 0 10px 0;
        }

        #invoice .date {
            font-size: 1.1em;
            color: #777777;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
            margin-bottom: 20px;
        }

        table th {
            padding: 10px;
            background: #a7a7a7;
            text-align: center;
            border-bottom: 1px solid #FFFFFF;
            color: #fff;
            font-size: 18px;
            text-transform: uppercase;

        }

        table td {
            padding: 10px;
            /*background: #EEEEEE;*/
            text-align: center;
            border-bottom: 1px solid #FFFFFF;
        }




        table th {
            /*white-space: nowrap;*/
            font-weight: normal;
        }

        table td h3 {
            color: #57B223;
            font-size: 1.2em;
            font-weight: normal;
            margin: 0 0 0.2em 0;
        }

        table .no {
            color: #FFFFFF;
            font-size: 1.6em;
            background: #57B223;
        }

        table .desc {
            text-align: left;
        }

        table .unit {
            background: #DDDDDD;
        }

        table .qty {}

        table .total {
            background: #57B223;
            color: #FFFFFF;
        }

        table td.unit,
        table td.qty,
        table td.total {
            font-size: 1.2em;
        }

        table tbody tr:last-child td {
            border: none;
        }

        table tfoot td {
            padding: 10px 20px;
            background: #FFFFFF;
            border-bottom: none;
            font-size: 1.2em;
            white-space: nowrap;
            border-top: 1px solid #AAAAAA;
        }

        table tfoot tr:first-child td {
            border-top: none;
        }

        table tfoot tr:last-child td {
            color: #57B223;
            font-size: 1.4em;
            border-top: 1px solid #57B223;

        }

        table tfoot tr td:first-child {
            border: none;
        }

        #thanks {
            font-size: 2em;
            margin-bottom: 50px;
        }

        #notices {
            padding-left: 6px;
            border-left: 6px solid #0087C3;
        }

        #notices .notice {
            font-size: 1.2em;
        }

        /*footer {
            color: #777777;
            width: 100%;
            height: 30px;
            position: absolute;
            bottom: 0;
            border-top: 1px solid #AAAAAA;
            padding: 8px 0;
            text-align: center;
            }*/

        .d-flex {
            display: -webkit-box !important;
            display: -ms-flexbox !important;
            display: flex !important;
        }

        .align-items-center {
            -webkit-box-align: center !important;
            -ms-flex-align: center !important;
            align-items: center !important;
        }

        .justify-content-center {
            -webkit-box-pack: center !important;
            -ms-flex-pack: center !important;
            justify-content: center !important;
        }

        .text-center {
            text-align: center !important;
        }

        .text-left {
            text-align: left !important;
        }

        .text-right {
            text-align: right !important;
        }

        .mb-0 {
            margin-bottom: 0px;
        }

        .mt-0 {
            margin-top: 0px;
        }

        .p-0 {
            padding: 0px;
        }

        .p-2 {
            padding: 2px;
        }

        .py-3 {
            padding-top: 3px;
            padding-bottom: 3px;
        }

        .px-10 {
            padding-left: 10px;
            padding-right: 10px;
        }

        .px-8 {
            padding-left: 8px;
            padding-right: 8px;
        }

        .px-5 {
            padding-left: 5px;
            padding-right: 5px;
        }

        .w-100 {
            width: 100%;
        }

        .company-logo {
            margin-top: 35px;
            margin-right: 10px;
        }

        .header_text {
            padding: 5px;
            font-size: 18px;
            text-align: center;
            background-color: #dbeae0;
            color: #000;
        }

        .text-green {
            color: green;
        }

        .font-size24 {
            font-size: 24px;
        }

        .font-size22 {
            font-size: 22px;
        }

        .font-size20 {
            font-size: 20px;
        }

        .font-size18 {
            font-size: 18px;
        }

        .font-size16 {
            font-size: 16px;
        }

        .font-size14 {
            font-size: 14px;
        }

        .font-weight400 {
            font-weight: 400;
        }

        .font-weight500 {
            font-weight: 500;
        }

        .font-weight700 {
            font-weight: 700;
        }

        .border-bottom1 {
            border-bottom: 1px solid #222;
        }

        .border {
            border: 1px solid #222;
        }

        footer {
            position: fixed;
            bottom: 3pxcm;
            left: 0cm;
            right: 0cm;
            height: .7cm;
            text-align: center;
            padding: 0 1cm;
            border-top: 1px solid;
        }

        .signature_ {
            position: fixed;
            bottom: 2cm;
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
    </style>

</head>

<body>

    <footer style="border-top: 1px solid transparent;">

        <table style="border:0px; border-top:1px solid #222; font-size:10px !important">
            <?php
            // $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
            // $date = $dt->format('g:i A');
            date_default_timezone_set('Asia/Dhaka');
            $date = date('d/m/Y h:i a'); // $dt->format('g:i A');
            ?>
            <tr>
                <td style="border: 0px; padding-top: 5px; text-align: left; padding-left:20px; ">Prepared By:
                    {{ Session::get('user.ses_user_name') }} &nbsp;&nbsp; Printing Date & Time: {{ $date }}
                </td>
                <td style="border: 0px; padding-top: 5px; width:30%;padding-right:20px;">Powered By: [NEXTGEN]</td>
            </tr>
        </table>
    </footer>
    </footer>



    <main>
        {{--    {{dd($po_hospital_details)}} --}}
        <div class="form-heading  border-bottom pb-3" style="margin-bottom: 6px;">
            <div id="logo" style="display:inline-block !important; ">
                @if (!empty($po_hospital_details->logo))
                    {{--                <img src="{{ asset('images/uploads/hospital_images/logo_2021_05_19_06_48.jpg') }}" /> --}}
                    <img src="{{ asset('images/uploads/hospital_images/' . $po_hospital_details->logo) }}" />
                @endif

                <div>
                    <strong>Patient ID: </strong><span>{{ $patient_barcode }}</span>
                    <br>
                    <br>
                    <img class="barcode_img" src="data:image/png;base64, {{ $pat_barcode }} " width="100" />
                </div>
            </div>
            <div class="hospital-address" style="display:inline-block !important; ">
                <h1 class="mb-0 ">
                    {{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }}</h1>
                <br>
                <p class="mb-0 ">{{ isset($po_hospital_details->addrress1) ? $po_hospital_details->addrress1 : '' }}
                </p>
                <br>
                <p class="mb-0 ">{{ isset($po_hospital_details->telephone1) ? $po_hospital_details->telephone1 : '' }}
                </p>
                <br>
            </div>
        </div>

        <div class="" style="border: 1px solid #AAAAAA; padding: 5px;">
            <table class="mb-0">
                <tr>
                    <td class="text-left py-3 px-5 font-size14 font-weight700">Name</td>
                    <td class="text-left py-3 px-5 font-size14 font-weight700">:</td>
                    <td class="text-left py-3 px-5 font-size14">
                        {{ isset($patient_info->salutation) ? $patient_info->salutation : '' }}
                        {{ isset($patient_info->patient_name) ? ucfirst($patient_info->patient_name) : 'N/A' }}</td>
                    <td class="text-left py-3 px-5 font-size14 font-weight700">Age</td>
                    <td class="text-left py-3 px-5 font-size14 font-weight700">:</td>
                    <td class="text-left py-3 px-5 font-size14">
                        {{ isset($patient_info->age) ? $patient_info->age : 'N/A' }}</td>
                </tr>

                <tr>
                    <td class="text-left py-3 px-5 font-size14 font-weight700">DOB</td>
                    <td class="text-left py-3 px-5 font-size14 font-weight700">:</td>
                    <td class="text-left py-3 px-5 font-size14">
                        {{ isset($patient_info->dob) ? date('d/m/Y', strtotime($patient_info->dob)) : 'N/A' }}</td>
                    <td class="text-left py-3 px-5 font-size14 font-weight700">Gender</td>
                    <td class="text-left py-3 px-5 font-size14 font-weight700">:</td>
                    <td class="text-left py-3 px-5 font-size14">
                        {{ isset($patient_info->gender_txt) ? $patient_info->gender_txt : 'N/A' }}</td>
                </tr>

                <tr>
                    <td class="text-left py-3 px-5 font-size14 font-weight700">Father</td>
                    <td class="text-left py-3 px-5 font-size14 font-weight700">:</td>
                    <td class="text-left py-3 px-5 font-size14">
                        {{ isset($patient_info->father_name) ? $patient_info->father_name : 'N/A' }}</td>
                    <td class="text-left py-3 px-5 font-size14 font-weight700">Mother</td>
                    <td class="text-left py-3 px-5 font-size14 font-weight700">:</td>
                    <td class="text-left py-3 px-5 font-size14">{{ 'N/A' }}</td>
                </tr>

                <tr>
                    <td class="text-left py-3 px-5 font-size14 font-weight700">National ID</td>
                    <td class="text-left py-3 px-5 font-size14 font-weight700">:</td>
                    <td class="text-left py-3 px-5 font-size14">
                        {{ isset($patient_info->national_id) ? $patient_info->national_id : 'N/A' }}</td>

                    <td class="text-left py-3 px-5 font-size14 font-weight700">Marital Status</td>
                    <td class="text-left py-3 px-5 font-size14 font-weight700">:</td>
                    <td class="text-left py-3 px-5 font-size14">
                        {{ isset($patient_info->marital_status_txt) ? $patient_info->marital_status_txt : 'N/A' }}</td>
                </tr>

                <tr>
                    <td class="text-left py-3 px-5 font-size14 font-weight700">Contact No.</td>
                    <td class="text-left py-3 px-5 font-size14 font-weight700">:</td>
                    <td class="text-left py-3 px-5 font-size14">
                        {{ isset($patient_info->mobile1) ? $patient_info->mobile1 : 'N/A' }}</td>
                    <td class="text-left py-3 px-5 font-size14 font-weight700">Email</td>
                    <td class="text-left py-3 px-5 font-size14 font-weight700">:</td>
                    <td class="text-left py-3 px-5 font-size14">
                        {{ isset($patient_info->email) ? $patient_info->email : 'N/A' }}</td>
                </tr>
                <tr>
                    <td class="text-left py-3 px-5 font-size14 font-weight700">Address</td>
                    <td class="text-left py-3 px-5 font-size14 font-weight700">:</td>
                    <td class="text-left py-3 px-5 font-size14" colspan="10">
                        {{ isset($patient_info->present_addr) ? $patient_info->present_addr : 'N/A' }}</td>
                </tr>
                {{--            <tr> --}}
                {{--                <td class="text-left py-3 px-5 font-size14 font-weight700">Consultant</td> --}}
                {{--                <td class="text-left py-3 px-5 font-size14 font-weight700">:</td> --}}
                {{--                <td class="text-left py-3 px-5 font-size14" >{{ isset($patient_info->primary_doctor_name) ? $patient_info->primary_doctor_name : 'N/A' }}</td> --}}
                {{--                <td class="text-left py-3 px-5 font-size14 font-weight700">Admitted on</td> --}}
                {{--                <td class="text-left py-3 px-5 font-size14 font-weight700">:</td> --}}
                {{--                <td class="text-left py-3 px-5 font-size14">{{ isset($patient_info->admission_date) ? date('d/m/Y',strtotime($patient_info->admission_date)) : 'N/A' }}</td> --}}
                {{--            </tr> --}}
            </table>
        </div>

        <div id="details" class="clearfix" style="margin-top: 10px">


            <div class="border">
                <table class="mb-0">
                    <tbody class="">
                        <tr class="header_text">
                            <td class="py-3 px-5 font-size14 border-bottom1" style="text-align: center; width: 40%;">
                                <b>EMR Report</b>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- <div class="header_text" style="">Billing Details</div> -->


            {{-- Health Details End --}}
            <div class="heading text-left mb-5">
                <h2>Health Details</h2>
            </div>
            @if (!$chronic_data->isEmpty())
                <div class="sub-heading ml-2 text-left mb-5">
                    <p style="margin-right: 20px;">Chronic Disease</p>
                </div>

                <div class="border">
                    <table class="mb-0">
                        <tbody class="">
                            <tr class="header_text">
                                <td class="py-3 px-5 font-size14 border-bottom1" style="text-align: left; width: 10%;">
                                    <b>SL</b>
                                </td>
                                <td class="py-3 px-5 font-size14 border-bottom1" style="text-align: left; width: 30%;">
                                    <b>Name</b>
                                </td>
                                <td class="py-3 px-5 font-size14 border-bottom1" style="text-align: left; width: 20%;">
                                    <b>Pres. Id</b>
                                </td>
                                <td class="py-3 px-5 font-size14 border-bottom1" style="text-align: left; width: 20%;">
                                    <b>Date Of Detection</b>
                                </td>
                                <td class="py-3 px-5 font-size14 border-bottom1" style="text-align: left; width: 20%;">
                                    <b>Hospital</b>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <table class="">
                    @foreach ($chronic_data as $chronic_row)
                        <tr>
                            <td class="px-5 py-3 font-size14 font-weight500 border-bottom1"
                                style="text-align: left; width: 10%;">{{ $loop->iteration }}</td>
                            {{--                        <td class="px-5 py-3 text-right font-size14 font-weight500 border-bottom1" style="text-align: center; width: 30%;"> {{!empty($alergies_row->allergies_name)?$alergies_row->allergies_name: "N/A"}}</td> --}}
                            <td class="px-5 py-3 font-size14 font-weight500 border-bottom1"
                                style="text-align: left; width: 30%;">
                                {{ !empty($chronic_row->chronic_dis_name) ? $chronic_row->chronic_dis_name : 'N/A' }}
                            </td>
                            <td class="px-5 py-3 font-size14 font-weight500 border-bottom1"
                                style="text-align: left; width: 20%;">
                                {{ !empty($chronic_row->prescription_no_fk) ? $chronic_row->prescription_no_fk : 'N/A' }}
                            </td>
                            <td class="px-5 py-3 font-size14 font-weight500 border-bottom1"
                                style="text-align: left; width: 20%;">
                                {{ !empty($chronic_row->date_of_chronic_disease) ? date('d/m/Y', strtotime($chronic_row->date_of_chronic_disease)) : 'N/A' }}
                            </td>
                            <td class="px-5 py-3 font-size14 font-weight500 border-bottom1"
                                style="text-align: left; width: 20%;"></td>
                        </tr>
                    @endforeach
                </table>
            @endif

            {{-- Health Details End --}}

            {{--        Health Details Start --}}
            @if (!$alergies_data->isEmpty())

                <div class="sub-heading ml-2 text-left mb-5">
                    <p style="margin-right: 20px;">Allergies</p>
                </div>

                <div class="border">
                    <table class="mb-0">
                        <tbody class="">
                            <tr class="header_text">
                                <td class="py-3 px-5 font-size14 border-bottom1"
                                    style="text-align: left; width: 10%;"><b>SL</b></td>
                                <td class="py-3 px-5 font-size14 border-bottom1"
                                    style="text-align: left; width: 30%;">
                                    <b>Name</b>
                                </td>
                                <td class="py-3 px-5 font-size14 border-bottom1"
                                    style="text-align: left; width: 20%;"><b>Pres. Id</b></td>
                                <td class="py-3 px-5 font-size14 border-bottom1"
                                    style="text-align: left; width: 20%;">
                                    <b>Date Of Detection</b>
                                </td>
                                <td class="py-3 px-5 font-size14 border-bottom1"
                                    style="text-align: left; width: 20%;"><b>Hospital</b></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <table class="">
                    @foreach ($alergies_data as $alergies_row)
                        <tr>
                            <td class="px-5 py-3 font-size14 font-weight500 border-bottom1"
                                style="text-align: left; width: 10%;">{{ $loop->iteration }}</td>
                            {{--                        <td class="px-5 py-3 text-right font-size14 font-weight500 border-bottom1" style="text-align: center; width: 30%;"> {{!empty($alergies_row->allergies_name)?$alergies_row->allergies_name: "N/A"}}</td> --}}
                            <td class="px-5 py-3 font-size14 font-weight500 border-bottom1"
                                style="text-align: left; width: 30%;">
                                {{ !empty($alergies_row->allergies_name) ? $alergies_row->allergies_name : 'N/A' }}
                            </td>
                            <td class="px-5 py-3 font-size14 font-weight500 border-bottom1"
                                style="text-align: left; width: 20%;">
                                {{ !empty($alergies_row->prescription_no_fk) ? $alergies_row->prescription_no_fk : 'N/A' }}
                            </td>
                            <td class="px-5 py-3 font-size14 font-weight500 border-bottom1"
                                style="text-align: left; width: 20%;">
                                {{ !empty($alergies_row->date_of_allergies) ? date('d/m/Y', strtotime($alergies_row->date_of_allergies)) : 'N/A' }}
                            </td>
                            <td class="px-5 py-3 font-size14 font-weight500 border-bottom1"
                                style="text-align: left; width: 20%;"></td>
                        </tr>
                    @endforeach
                </table>
            @endif



            {{--        Vitals Details Start --}}
            @if (!$prescription_data->isEmpty())
                <div class="heading text-left mb-5">
                    <h2>Prescription Details</h2>
                </div>
                <div class="sub-heading ml-2 text-left mb-5">
                    <p style="margin-right: 20px;">Prescription</p>
                </div>

                <div class="border">
                    <table class="mb-0">
                        <tbody class="">
                            <tr class="header_text">
                                <td class="py-3 px-5 font-size14 border-bottom1" style="width:5%; text-align:left;">
                                    <b>SL</b>
                                </td>
                                <td class="py-3 px-5 font-size14 border-bottom1" style="width:10%; text-align:left;">
                                    <b>Pres. ID</b>
                                </td>
                                <td class="py-3 px-5 font-size14 border-bottom1" style="width:15%; text-align:left;">
                                    <b>Patient Name</b>
                                </td>
                                <td class="py-3 px-5 font-size14 border-bottom1" style="width:8%; text-align:left;">
                                    <b>Gender</b>
                                </td>
                                <td class="py-3 px-5 font-size14 border-bottom1" style="width:7%; text-align:left;">
                                    <b>Age</b>
                                </td>
                                <td class="py-3 px-5 font-size14 border-bottom1" style="width:15%; text-align:left;">
                                    <b>Department</b>
                                </td>
                                <td class="py-3 px-5 font-size14 border-bottom1" style="width:10%; text-align:left;">
                                    <b>Date</b>
                                </td>
                                <td class="py-3 px-5 font-size14 border-bottom1" style="width:10%; text-align:left;">
                                    <b>Hospital</b>
                                </td>
                                <td class="py-3 px-5 font-size14 border-bottom1" style="width:20%; text-align:left;">
                                    <b>Doctor Signature</b>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <table class="">
                    @foreach ($prescription_data as $value)
                        <tr>
                            <td
                                class="px-5 py-3 font-size14 font-weight500 border-bottom1"style="width:5%; text-align:left;">
                                {{ $loop->iteration }}</td>
                            <td class="px-5 py-3 font-size14 font-weight500 border-bottom1"
                                style="width:10%; text-align:left;"> {{ $value->prescription_uid }}</td>
                            <td class="px-5 py-3 font-size14 font-weight500 border-bottom1"
                                style="width:15%; text-align:left;">{{ $value->patient_name }}</td>
                            <td class="px-5 py-3 font-size14 font-weight500 border-bottom1"
                                style="width:8%; text-align:left;">{{ $value->gender_txt }}</td>
                            <td class="px-5 py-3 font-size14 font-weight500 border-bottom1"
                                style="width:7%; text-align:left;">{{ $value->age }}</td>
                            <td class="px-5 py-3 font-size14 font-weight500 border-bottom1"
                                style="width:15%; text-align:left;">{{ $value->su_name }}</td>
                            <td class="px-5 py-3 font-size14 font-weight500 border-bottom1"
                                style="width:10%; text-align:left;">
                                {{ date('d/m/Y', strtotime($value->au_entry_at)) }}</td>
                            <td class="px-5 py-3 font-size14 font-weight500 border-bottom1"
                                style="width:10%; text-align:left;">{{ $value->hospital_code }}</td>
                            <td class="px-5 py-3 font-size14 font-weight500 border-bottom1"
                                style="width:20%; text-align:left;"><?php echo $value->doctor_signature; ?></td>
                        </tr>
                    @endforeach
                </table>
            @endif

            {{-- Vitals Details End --}}

            {{--        Vitals Details Start --}}
            @if (!$vitals_data->isEmpty())
                <div class="heading text-left mb-5">
                    <h2>Vital Details</h2>
                </div>
                <div class="sub-heading ml-2 text-left mb-5">
                    <p style="margin-right: 20px;">Vitals</p>
                </div>

                <div class="border">
                    <table class="mb-0">
                        <tbody class="">
                            <tr class="header_text">
                                <td class="py-3 px-5 font-size14 border-bottom1" style="text-align: left; widht:5%;">
                                    <b>SL</b>
                                </td>
                                <td class="py-3 px-5 font-size14 border-bottom1" style="text-align:left; width:25%;">
                                    <b>Chief Complaints</b>
                                </td>
                                <td class="py-3 px-5 font-size14 border-bottom1" style="text-align:left; width:10%;">
                                    <b>Temperature</b>
                                </td>
                                <td class="py-3 px-5 font-size14 border-bottom1" style="text-align:left; width:8%;">
                                    <b>Height</b>
                                </td>
                                <td class="py-3 px-5 font-size14 border-bottom1" style="text-align:left; width:8%;">
                                    <b>Weight</b>
                                </td>
                                <td class="py-3 px-5 font-size14 border-bottom1" style="text-align:left; width:8%;">
                                    <b>Dia-Sys</b>
                                </td>
                                <td class="py-3 px-5 font-size14 border-bottom1" style="text-align:left; width:8%;">
                                    <b>Pulse</b>
                                </td>
                                <td class="py-3 px-5 font-size14 border-bottom1" style="text-align:left; width:8%;">
                                    <b>OFC</b>
                                </td>
                                <td class="py-3 px-5 font-size14 border-bottom1" style="text-align:left; width:20%;">
                                    <b>Prescribed Hospital</b>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <table class="">
                    @foreach ($vitals_data as $value)
                        <tr>
                            <td class="px-5 py-3 font-size14 font-weight500 border-bottom1"
                                style="text-align: left;widht:5%;">{{ $loop->iteration }}</td>
                            <td class="px-5 py-3 font-size14 font-weight500 border-bottom1"
                                style="text-align:left; width:25%;">
                                {{ !empty($value->chief_complaints) ? $value->chief_complaints : '' }}</td>
                            <td class="px-5 py-3 font-size14 font-weight500 border-bottom1"
                                style="text-align:left; width:10%;">
                                {{ !empty($value->temp_val) ? $value->temp_val : '' }}
                                {{ !empty($value->temp_val_time) ? $value->temp_val_time : '' }}</td>
                            <td class="px-5 py-3 font-size14 font-weight500 border-bottom1"
                                style="text-align:left; width:8%;">
                                {{ !empty($value->height_val) ? $value->height_val : '' }}
                                {{ !empty($value->h_mu_name) ? $value->h_mu_name : '' }}</td>
                            <td class="px-5 py-3 font-size14 font-weight500 border-bottom1"
                                style="text-align:left; width:8%;">
                                {{ !empty($value->weight_val) ? $value->weight_val : '' }}
                                {{ !empty($value->w_mu_name) ? $value->w_mu_name : '' }}</td>
                            <td class="px-5 py-3 font-size14 font-weight500 border-bottom1"
                                style="text-align:left; width:8%;">
                                {{ !empty($value->bp_val_dia) ? $value->bp_val_dia : '' }} -
                                {{ !empty($value->bp_val_sys) ? $value->bp_val_sys : '' }}</td>
                            <td class="px-5 py-3 font-size14 font-weight500 border-bottom1"
                                style="text-align:left; width:8%;">
                                {{ !empty($value->pulse_val) ? $value->pulse_val : '' }}</td>
                            <td class="px-5 py-3 font-size14 font-weight500 border-bottom1"
                                style="text-align:left; width:8%;">{{ !empty($value->ofc) ? $value->ofc : '' }}</td>
                            <td class="px-5 py-3 font-size14 font-weight500 border-bottom1"
                                style="text-align:left; width:20%;">
                                {{ !empty($value->hospital_code) ? $value->hospital_code : '' }}</td>
                        </tr>
                    @endforeach
                </table>
            @endif

            {{-- Vitals Details End --}}

            {{--        Current Medication --}}
            @if (!$medical_equiment->isEmpty())
                <div class="heading text-left mb-5">
                    <h2>Current Medical Usage</h2>
                </div>
                <div class="sub-heading ml-2 text-left mb-5">
                    <p style="margin-right: 20px;">Current Medication</p>
                </div>
                <div class="border">
                    <table class="mb-0">
                        <tbody class="">
                            <tr class="header_text">
                                <td class="py-3 px-5 font-size14 border-bottom1" style="text-align: left; width: 5%;">
                                    <b>SL</b>
                                </td>
                                <td class="py-3 px-5 font-size14 border-bottom1"
                                    style="text-align: left; width: 25%;"><b>Generic</b></td>
                                <td class="py-3 px-5 font-size14 border-bottom1"
                                    style="text-align: left; width: 20%;"><b>Brand</b></td>
                                <td class="py-3 px-5 font-size14 border-bottom1"
                                    style="text-align: left; width: 10%;"><b>Dose</b></td>
                                <td class="py-3 px-5 font-size14 border-bottom1"
                                    style="text-align: left; width: 10%;"><b>Duration</b></td>
                                <td class="py-3 px-5 font-size14 border-bottom1"
                                    style="text-align: left; width: 10%;"><b>Item Qty</b></td>
                                <td class="py-3 px-5 font-size14 border-bottom1"
                                    style="text-align: left; width: 10%;"><b>Hospital</b></td>
                                <td class="py-3 px-5 font-size14 border-bottom1"
                                    style="text-align: left; width: 10%;"><b>Prescription Id</b></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <table class="">
                    @foreach ($medical_equiment as $medical_equiment_row)
                        <tr>
                            <td class="px-5 py-3 font-size14 font-weight500 border-bottom1"
                                style="text-align: left; width: 5%;">{{ $loop->iteration }}</td>
                            <td class="px-5 py-3 font-size14 font-weight500 border-bottom1"
                                style="text-align: left; width: 25%;">
                                {{ !empty($medical_equiment_row->generic_name) ? $medical_equiment_row->generic_name : 'N/A' }}
                            </td>
                            <td class="px-5 py-3 font-size14 font-weight500 border-bottom1"
                                style="text-align: left; width: 20%;">
                                {{ !empty($medical_equiment_row->brand_name) ? $medical_equiment_row->brand_name : 'N/A' }}
                            </td>
                            <td class="px-5 py-3 font-size14 font-weight500 border-bottom1"
                                style="text-align: left; width: 10%;">
                                {{ !empty($medical_equiment_row->dosage) ? $medical_equiment_row->dosage : 'N/A' }}
                            </td>
                            <td class="px-5 py-3 font-size14 font-weight500 border-bottom1"
                                style="text-align: left; width: 10%;">
                                {{ !empty($medical_equiment_row->duration) ? $medical_equiment_row->duration : 'N/A' }}
                                {{ !empty($medical_equiment_row->duration_mu) ? $medical_equiment_row->duration_mu : 'N/A' }}
                            </td>
                            <td class="px-5 py-3 font-size14 font-weight500 border-bottom1"
                                style="text-align: left; width: 10%;">
                                {{ !empty($medical_equiment_row->item_qty) ? $medical_equiment_row->item_qty : 'N/A' }}
                            </td>
                            <td class="px-5 py-3 font-size14 font-weight500 border-bottom1"
                                style="text-align: left; width: 10%;">
                                {{ !empty($medical_equiment_row->hospital_code) ? $medical_equiment_row->hospital_code : 'N/A' }}
                            </td>
                            <td class="px-5 py-3 font-size14 font-weight500 border-bottom1"
                                style="text-align: left; width: 10%;">
                                {{ !empty($medical_equiment_row->prescription_uid) ? $medical_equiment_row->prescription_uid : 'N/A' }}
                            </td>
                        </tr>
                    @endforeach
                </table>
            @endif

            {{--        Current Medication end --}}





            {{--        Medical Equiment --}}
            @if (!$current_equiment_data->isEmpty())
                <div class="heading text-left mb-5">
                    <h2>Current Equipment Usage</h2>
                </div>
                {{--        <div class="sub-heading ml-2 text-left mb-5"><p style="margin-right: 20px;">Current Equipment Usage</p></div> --}}
                <div class="border">
                    <table class="mb-0">
                        <thead>

                            <tr class="header_text">
                                <td class="py-3 px-5 font-size14 border-bottom1"
                                    style="width: 10%; text-align: left;"><b>SL</b></td>
                                <td class="py-3 px-5 font-size14 border-bottom1"
                                    style="width: 40%; text-align: left;"><b>Equipment Name</b></td>
                                <td class="py-3 px-5 font-size14 border-bottom1"
                                    style="width: 25%; text-align: left;"><b>Date of Engage</b></td>
                                <td class="py-3 px-5 font-size14 border-bottom1"
                                    style="width: 25%; text-align: left;"><b>Date of Discharge</b></td>
                            </tr>
                        </thead>
                        <tbody class="">
                            @foreach ($current_equiment_data as $value)
                                <tr>
                                    <td class="px-5 py-3 font-size14 font-weight500 border-bottom1"
                                        style="width: 10%; text-align: left;">{{ $loop->iteration }}</td>
                                    <td class="px-5 py-3 font-size14 font-weight500 border-bottom1"
                                        style="width: 40%; text-align: left;"> {{ $value->medequ_name }}</td>
                                    <td class="px-5 py-3 font-size14 font-weight500 border-bottom1"
                                        style="width: 25%; text-align: left;">
                                        {{ date('d/m/Y', strtotime($value->medequ_start_date)) }}</td>
                                    <td class="px-5 py-3 font-size14 font-weight500 border-bottom1"
                                        style="width: 25%; text-align: left;">
                                        {{ date('d/m/Y', strtotime($value->medequ_end_date)) }} </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

            {{--        medical equiment end --}}



            {{--        Lab Equiment --}}
            @if (!$lab_data->isEmpty())
                <div class="heading text-left mb-5">
                    <h2>Pathology Lab Data</h2>
                </div>
                {{--        <div class="sub-heading ml-2 text-left mb-5"><p style="margin-right: 20px;">Lab Data</p></div> --}}

                <div class="border">
                    <table class="mb-0">
                        <thead>
                            <tr class="header_text">
                                <td class="py-3 px-5 font-size14 border-bottom1" style="width: 5%; text-align: left;">
                                    <b>SL</b>
                                </td>
                                <td class="py-3 px-5 font-size14 border-bottom1" style="width: 15%;text-align: left;">
                                    <b>Invoice Code</b>
                                </td>
                                <td class="py-3 px-5 font-size14 border-bottom1" style="width: 30%;text-align: left;">
                                    <b>Test Name</b>
                                </td>
                                <td class="py-3 px-5 font-size14 border-bottom1" style="width: 15%;text-align: left;">
                                    <b>Date</b>
                                </td>
                                <td class="py-3 px-5 font-size14 border-bottom1" style="width: 15%;text-align: left;">
                                    <b>Admission ID</b>
                                </td>
                                <td class="py-3 px-5 font-size14 border-bottom1" style="width: 20%;text-align: left;">
                                    <b>Hospital</b>
                                </td>
                            </tr>
                        </thead>
                        <tbody class="">
                            @foreach ($lab_data as $value)
                                <tr>
                                    <td class="px-5 py-3 font-size14 font-weight500 border-bottom1"
                                        style="width: 5%; text-align: left;">{{ $loop->iteration }}</td>
                                    <td class="px-5 py-3 font-size14 font-weight500 border-bottom1"
                                        style="width: 15%;text-align: left;"> {{ $value->invoice_code }}</td>
                                    <td class="px-5 py-3 font-size14 font-weight500 border-bottom1"
                                        style="width: 30%;text-align: left;">{{ $value->item_name }}</td>
                                    <td class="px-5 py-3 font-size14 font-weight500 border-bottom1"
                                        style="width: 15%;text-align: left;">
                                        {{ !empty($value->report_delivary_date) ? date('d/m/Y', strtotime($value->report_delivary_date)) : '' }}
                                    </td>
                                    <td class="px-5 py-3 font-size14 font-weight500 border-bottom1"
                                        style="width: 15%;text-align: left;">{{ $value->lab_code }}</td>
                                    <td class="px-5 py-3 font-size14 font-weight500 border-bottom1"
                                        style="width: 20%;text-align: left;"></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

            {{--        Lab Data equiment end --}}

            {{--        Radiology Equiment --}}
            @if (!$radiology_data->isEmpty())
                <div class="heading text-left mb-5">
                    <h2>Radiology Data</h2>
                </div>
                {{--            <div class="sub-heading ml-2 text-left mb-5"><p style="margin-right: 20px;">Radiology Data</p></div> --}}

                <div class="border">
                    <table class="mb-0">
                        <thead>
                            <tr class="header_text">
                                <td class="py-3 px-5 font-size14 border-bottom1" style="width: 5%;"><b>SL</b></td>
                                <td class="py-3 px-5 font-size14 border-bottom1" style="width: 25%;"><b>Invoice
                                        Code</b></td>
                                <td class="py-3 px-5 font-size14 border-bottom1"
                                    style="width: 35%; text-align: left;"><b>Test Name</b></td>
                                <td class="py-3 px-5 font-size14 border-bottom1"
                                    style="width: 35%; text-align: left;"><b>PACS Info</b></td>
                                <td class="py-3 px-5 font-size14 border-bottom1" style="width: 10%;"><b>Date</b></td>
                                <td class="py-3 px-5 font-size14 border-bottom1" style="width: 25%;"><b>Hospital</b>
                                </td>
                                {{--                        <td class="text-right py-3 px-5 font-size14 border-bottom1"><b>Report Info</b></td> --}}
                            </tr>
                        </thead>
                        <tbody class="">
                            @foreach ($radiology_data as $value)
                                <tr>
                                    <td class="px-5 py-3 font-size14 font-weight500 border-bottom1"
                                        style="width: 5%;">{{ $loop->iteration }}</td>
                                    <td class="px-5 py-3 font-size14 font-weight500 border-bottom1"
                                        style="width: 25%;">{{ $value->invoice_code }}</td>
                                    <td class="px-5 py-3 font-size14 font-weight500 border-bottom1"
                                        style="width: 35%; text-align: left;">{{ $value->item_name }}</td>
                                    <td class="px-5 py-3 font-size14 font-weight500 border-bottom1"
                                    style="width: 35%; text-align: left;">
                                        @if ($image)
                                            @foreach ($image as $val)
                                                @if ($value->radinvoicedtl_no_pk == $val->radinvoicedtl_no_pk)
                                                    <figure id="main_figure">
                                                        <a href="{{ asset('images/uploads/image_capture/' . $val->resultimg_path) }}"
                                                            data-lightbox="roadtrip">
                                                            <img src="{{ asset('images/uploads/image_capture/' . $val->resultimg_path) }}"
                                                                alt=""
                                                                style="width:50px; height:30px; margin-bottom:10px">

                                                        </a>
                                                    </figure>
                                                @endif
                                            @endforeach
                                        @endif
                                    </td>
                                    <td class="px-5 py-3 font-size14 font-weight500 border-bottom1"
                                        style="width: 10%;">
                                        {{ !empty($value->invoice_date) ? date('d/m/Y', strtotime($value->invoice_date)) : '' }}
                                    </td>
                                    <td class="px-5 py-3 font-size14 font-weight500 border-bottom1"
                                        style="width: 25%;">{{ $value->hospital_code }}</td>





                                    {{--                        <td class="px-5 py-3 text-right font-size14 font-weight500 border-bottom1"></td> --}}
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

            {{--        Radiology Data equiment end --}}

            {{--        current  Equiment start --}}
            {{--        @if (!$current_equiment_data->isEmpty()) --}}
            {{--            <div class="heading text-left mb-5"><h2>Medical Equipment Data</h2></div> --}}
            {{--            <div class="sub-heading ml-2 text-left mb-5"><p style="margin-right: 20px;">Medical Equipment Data</p></div> --}}

            {{--            <div class="border"> --}}
            {{--                <table class="mb-0"> --}}
            {{--                    <tbody > --}}
            {{--                    <tr class="header_text"> --}}
            {{--                        <td class="py-3 px-5 font-size14 border-bottom1" style="text-align: left;"><b>SL</b></td> --}}
            {{--                        <td class="py-3 px-5 font-size14 border-bottom1" style="text-align: left; width: 30%;"><b>Equipment Name</b></td> --}}
            {{--                        <td class="py-3 px-5 font-size14 border-bottom1" style="text-align: center;"><b>Date of Engage</b></td> --}}
            {{--                        <td class="py-3 px-5 font-size14 border-bottom1" style="text-align: center;"><b>Date of Discharge</b></td> --}}
            {{--                    </tr> --}}
            {{--                    </tbody> --}}
            {{--                </table> --}}
            {{--            </div> --}}
            {{--            <table class=""> --}}
            {{--                @foreach ($current_equiment_data as $value) --}}
            {{--                    <tr> --}}
            {{--                        <td class="px-5 py-3 font-size14 font-weight500 border-bottom1" style="text-align: left;">{{$loop->iteration}}</td> --}}
            {{--                        <td class="px-5 py-3 font-size14 font-weight500 border-bottom1" style="text-align: left; width: 30%;">{{$value->medequ_name}}</td> --}}
            {{--                        <td class="px-5 py-3 font-size14 font-weight500 border-bottom1" style="text-align: center;">{{date("d/m/Y", strtotime($value->medequ_start_date))}}</td> --}}
            {{--                        <td class="px-5 py-3 font-size14 font-weight500 border-bottom1" style="text-align: center;"> {{date("d/m/Y", strtotime($value->medequ_end_date))}}</td> --}}
            {{--                        --}}{{--                        <td class="px-5 py-3 text-right font-size14 font-weight500 border-bottom1"></td> --}}
            {{--                    </tr> --}}
            {{--                @endforeach --}}
            {{--            </table> --}}
            {{--        @endif --}}

            {{--        Current Data equiment end --}}

            {{--        Surgical start --}}
            @if (!$sergical_data->isEmpty())
                <div class="heading text-left mb-5">
                    <h2>Surgical History Data</h2>
                </div>
                {{--            <div class="sub-heading ml-2 text-left mb-5"><p style="margin-right: 20px;">Surgical History Data</p></div> --}}

                <div class="border">
                    <table class="mb-0">
                        <thead>
                            <tr class="header_text">
                                <td class="py-3 px-5 font-size14 border-bottom1" style="text-align: left;"><b>SL</b>
                                </td>
                                <td class="py-3 px-5 font-size14 border-bottom1" style="text-align: left;">
                                    <b>Admission Id</b>
                                </td>
                                <td class="py-3 px-5 font-size14 border-bottom1" style="text-align: left;"><b>Ward
                                        Name</b></td>
                                <td class="py-3 px-5 font-size14 border-bottom1" style="text-align: left;"><b>Bed
                                        Name</b></td>
                                {{--                        <td class="text-right py-3 px-5 font-size14 border-bottom1" style="width: 10%;"><b>Base</b></td> --}}
                                <td class="py-3 px-5 font-size14 border-bottom1" style="text-align: left;"><b>Age</b>
                                </td>
                                <td class="py-3 px-5 font-size14 border-bottom1" style="text-align: left;"><b>Surgeon
                                        Name</b></td>
                                <td class="py-3 px-5 font-size14 border-bottom1" style="text-align: left;"><b>OT
                                        Date</b></td>
                                <td class="py-3 px-5 font-size14 border-bottom1" style="text-align: left;">
                                    <b>Operation Name</b>
                                </td>
                                <td class="py-3 px-5 font-size14 border-bottom1" style="text-align: left;">
                                    <b>Hospital</b>
                                </td>
                            </tr>
                        </thead>
                        <tbody class="">
                            @foreach ($sergical_data as $value)
                                <tr>
                                    <td class="px-5 py-3 font-size14 font-weight500 border-bottom1"
                                        style="text-align: left;">{{ $loop->iteration }}</td>
                                    <td class="px-5 py-3 font-size14 font-weight500 border-bottom1"
                                        style="text-align: left;">{{ $value->admission_uid }}</td>
                                    <td class="px-5 py-3 font-size14 font-weight500 border-bottom1"
                                        style="text-align: left;">{{ $value->ward_name }}</td>
                                    <td class="px-5 py-3 font-size14 font-weight500 border-bottom1"
                                        style="text-align: left;">{{ $value->bed_name }}</td>
                                    {{--                        <td class="px-5 py-3 text-right font-size14 font-weight500 border-bottom1" style="width: 10%;"></td> --}}
                                    <td class="px-5 py-3 font-size14 font-weight500 border-bottom1"
                                        style="text-align: left;">{{ isset($value->age) }}</td>
                                    <td class="px-5 py-3 font-size14 font-weight500 border-bottom1"
                                        style="text-align: left;">{{ isset($value->surg_doctor_name) }}</td>
                                    <td class="px-5 py-3 font-size14 font-weight500 border-bottom1"
                                        style="text-align: left;">
                                        {{ isset($value->ot_date) ? date('d/m/Y', strtotime($value->ot_date)) : '' }}
                                    </td>
                                    <td class="px-5 py-3 font-size14 font-weight500 border-bottom1"
                                        style="text-align: left;">{{ isset($value->surg_doctor_name) }}</td>
                                    <td class="px-5 py-3 font-size14 font-weight500 border-bottom1"
                                        style="text-align: left;"> {{ isset($value->hospital_code) }}</td>
                                    {{--                        <td class="px-5 py-3 text-right font-size14 font-weight500 border-bottom1"></td> --}}
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

            {{--        Current Data equiment end --}}


            {{--        Hospitalized start --}}
            @if (!$hospitalized_data->isEmpty())
                <div class="heading text-left mb-5">
                    <h2>Hospitalized History Data</h2>
                </div>
                {{--            <div class="sub-heading ml-2 text-left mb-5"><p style="margin-right: 20px;">Surgical History Data</p></div> --}}

                <div class="border">
                    <table class="mb-0">
                        <thead>
                            <tr class="header_text">
                                <td class="py-3 px-5 font-size14 border-bottom1" style="text-align: left;"><b>SL</b>
                                </td>
                                <td class="py-3 px-5 font-size14 border-bottom1" style="text-align: left;">
                                    <b>Admission Date</b>
                                </td>
                                <td class="py-3 px-5 font-size14 border-bottom1" style="text-align: left;">
                                    <b>Admission Id</b>
                                </td>
                                <td class="py-3 px-5 font-size14 border-bottom1" style="text-align: left;"><b>Ward
                                        Name</b></td>
                                <td class="py-3 px-5 font-size14 border-bottom1" style="text-align: left;"><b>Bed
                                        Name</b></td>
                                {{--                        <td class="text-right py-3 px-5 font-size14 border-bottom1" style="width: 10%;"><b>Base</b></td> --}}
                                <td class="py-3 px-5 font-size14 border-bottom1" style="text-align: left;"><b>Dis.
                                        Date</b></td>
                                <td class="py-3 px-5 font-size14 border-bottom1" style="text-align: left;"><b>Dis.
                                        Type</b></td>
                                <td class="py-3 px-5 font-size14 border-bottom1" style="text-align: left;">
                                    <b>Hospital</b>
                                </td>
                            </tr>
                        </thead>
                        <tbody class="">
                            @foreach ($hospitalized_data as $value)
                                <tr>
                                    <td class="px-5 py-3 font-size14 font-weight500 border-bottom1"
                                        style="text-align: left;">{{ $loop->iteration }}</td>
                                    <td class="px-5 py-3 font-size14 font-weight500 border-bottom1"
                                        style="text-align: left;">
                                        {{ date('d/m/Y', strtotime($value->admission_date)) }}</td>
                                    <td class="px-5 py-3 font-size14 font-weight500 border-bottom1"
                                        style="text-align: left;">{{ $value->admission_uid }}</td>
                                    <td class="px-5 py-3 font-size14 font-weight500 border-bottom1"
                                        style="text-align: left;">{{ $value->ward_name }}</td>
                                    {{--                        <td class="px-5 py-3 text-right font-size14 font-weight500 border-bottom1" style="width: 10%;"></td> --}}
                                    <td class="px-5 py-3 font-size14 font-weight500 border-bottom1"
                                        style="text-align: left;">{{ $value->bed_name }}</td>
                                    <td class="px-5 py-3 font-size14 font-weight500 border-bottom1"
                                        style="text-align: left;">
                                        {{ !empty($value->dis_date) ? date('d/m/Y', strtotime($value->dis_date)) : 'N/A' }}
                                    </td>
                                    <td class="px-5 py-3 font-size14 font-weight500 border-bottom1"
                                        style="text-align: left;">
                                        {{ !empty($value->dis_reason) ? $value->dis_reason : 'N/A' }}</td>
                                    <td class="px-5 py-3 font-size14 font-weight500 border-bottom1"
                                        style="text-align: left;">
                                        {{ !empty($value->hospital_name) ? $value->hospital_name : 'N/A' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

            {{--        Hospitalized equiment end --}}

            {{--        Immunization  Equiment start --}}
            @if (!$immunization_data->isEmpty())
                <div class="heading text-left mb-5">
                    <h2>Immunization History Data</h2>
                </div>
                {{--            <div class="sub-heading ml-2 text-left mb-5"><p style="margin-right: 20px;">Immunization History Data</p></div> --}}

                <div class="border">
                    <table class="mb-0">
                        <tbody class="">
                            <tr class="header_text">
                                <td class="py-3 px-5 font-size14 border-bottom1"
                                    style="width: 20%; text-align: left;"><b>SL</b></td>
                                <td class="py-3 px-5 font-size14 border-bottom1"
                                    style="width: 20%; text-align: left;"><b>Date</b></td>
                                <td class="py-3 px-5 font-size14 border-bottom1"
                                    style="width: 40%; text-align: left;"><b>Immunization Name</b></td>
                                <td class="py-3 px-5 font-size14 border-bottom1"
                                    style="width: 20%; text-align: left;"><b>Dose Number</b></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <table>
                    @foreach ($immunization_data as $value)
                        <tr>
                            <td class="px-5 py-3 font-size14 font-weight500 border-bottom1"
                                style="width: 20%; text-align: left;">{{ $loop->iteration }}</td>
                            <td class="px-5 py-3 font-size14 font-weight500 border-bottom1"
                                style="width: 20%; text-align: left;">
                                {{ !empty($value->immunization_start_date) ? date('d/m/Y', strtotime($value->immunization_start_date)) : '' }}
                            </td>
                            <td class="px-5 py-3 font-size14 font-weight500 border-bottom1"
                                style="width: 40%; text-align: left;">{{ $value->immunization_name }}</td>
                            <td class="px-5 py-3 font-size14 font-weight500 border-bottom1"
                                style="width: 20%; text-align: left;">{{ $value->dose_number }}</td>
                        </tr>
                    @endforeach
                </table>
            @endif

            {{--        Immunization Data equiment end --}}

            {{--        family Disease start --}}
            @if (!$family_disease_data->isEmpty())
                <div class="heading text-left mb-5">
                    <h2> Family Disease Data</h2>
                </div>
                {{--            <div class="sub-heading ml-2 text-left mb-5"><p style="margin-right: 20px;"> Family Disease Data</p></div> --}}

                <div class="border">
                    <table class="mb-0">
                        <tbody class="">
                            <tr class="header_text">
                                <td class="py-3 px-5 font-size14 border-bottom1" style="width: 10%;text-align: left;">
                                    <b>SL</b>
                                </td>
                                <td class="py-3 px-5 font-size14 border-bottom1" style="width: 10%;text-align: left;">
                                    <b>Relative</b>
                                </td>
                                <td class="py-3 px-5 font-size14 border-bottom1" style="width: 15%;text-align: left;">
                                    <b>Disease</b>
                                </td>
                                <td class="py-3 px-5 font-size14 border-bottom1" style="width: 15%;text-align: left;">
                                    <b>From Date</b>
                                </td>
                                <td class="py-3 px-5 font-size14 border-bottom1" style="width: 15%;text-align: left;">
                                    <b>To Date</b>
                                </td>
                                <td class="py-3 px-5 font-size14 border-bottom1" style="width: 10%;text-align: left;">
                                    <b>Severity</b>
                                </td>
                                <td class="py-3 px-5 font-size14 border-bottom1" style="width: 15%;text-align: left;">
                                    <b>Suffered Duration</b>
                                </td>
                                <td class="py-3 px-5 font-size14 border-bottom1" style="width: 10%;text-align: left;">
                                    <b>Death</b>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <table class="">
                    @foreach ($family_disease_data as $value)
                        <tr>
                            <td class="px-5 py-3 font-size14 font-weight500 border-bottom1"
                                style="width: 10%;text-align: left;">{{ $loop->iteration }}</td>
                            <td class="px-5 py-3 font-size14 font-weight500 border-bottom1"
                                style="width: 10%;text-align: left;">{{ $value->relation_name }}</td>
                            <td class="px-5 py-3 font-size14 font-weight500 border-bottom1"
                                style="width: 15%;text-align: left;">{{ $value->disease_name }}</td>
                            <td class="px-5 py-3 font-size14 font-weight500 border-bottom1"
                                style="width: 15%;text-align: left;">
                                {{ !empty($value->date_from) ? date('d/m/Y', strtotime($value->date_from)) : '' }}</td>
                            <td class="px-5 py-3 font-size14 font-weight500 border-bottom1"
                                style="width: 15%;text-align: left;">
                                {{ !empty($value->date_to) ? date('d/m/Y', strtotime($value->date_to)) : '' }}</td>
                            <td class="px-5 py-3 font-size14 font-weight500 border-bottom1"
                                style="width: 10%;text-align: left;">{{ $value->severity }}</td>
                            <td class="px-5 py-3 font-size14 font-weight500 border-bottom1"
                                style="width: 15%;text-align: left;">{{ $value->suffered_duration }}</td>
                            <td class="px-5 py-3 font-size14 font-weight500 border-bottom1"
                                style="width: 10%;text-align: left;">
                                @if ($value->death_bydisease_ind == 1)
                                    <span class="badge badge-primary">Yes</span>
                                @else
                                    <span class="badge badge-warning">No</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </table>
            @endif

            {{--        Immunization Data equiment end --}}




        </div>
    </main>
</body>

</html>
