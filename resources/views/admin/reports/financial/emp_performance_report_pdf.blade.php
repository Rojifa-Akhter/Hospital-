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
    <title>IPD Draft Bill</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    {{-- <link rel="stylesheet" href="{{ public_path().'/css/print.css' }}" media="print"> --}}

    <style>
        .custom_inline_input {
            border: 0px;
            outline: 0;
            background-color: transparent;
            border-bottom: 1px dotted #222;
            /*display: block;*/
        }

        .custom_inline_input2 {
            width: 465px;
        }

        .w-30 {
            width: 30%
        }

        .w-50px {
            width: 50px
        }

        .w-100px {
            width: 100px
        }

        .v-align-top {
            vertical-align: top !important;
        }

        table tr {
            border-bottom: none;
        }

        .instraction-page>ul>li {
            margin-bottom: 20px;
        }

        /*  @page {
        margin: 1cm 0.3cm;
        /!*width: 450px;*!/
        padding:8px;
        }*/
        @page {
            margin: 0cm 1cm;
        }

        .header {
            position: fixed;
            left: 0px;
            top: -140px;
            right: 0px;
            height: 100px;
            text-align: center;
        }

        /*#footer { position: fixed; left: 0px; bottom: 0; right: 0px; }*/

        footer {
            position: fixed;
            z-index: 999999999;

            left: 0;
            right: 0;
            height: 3cm;
            text-align: center;
            font-size: 9px;
            bottom: -100px;
            border-top: 1px solid black;
            padding-top: 10px;
        }

        body {
            /*margin-top: 5.5cm;*/
            margin-left: 0cm;
            margin-right: 0cm;
            /*margin-bottom: 3.5cm;*/
            font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
            font-size: 9px;
        }

        .bg-black {
            background-color: #222;
            color: #fff;
        }


        table {
            border-collapse: collapse;
            width: 100%;

        }

        table tr td,
        table tr th {
            font-size: 10px;
            border: 0;
            font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
            padding: 2px;
            /*border-width: thin;*/
        }

        .custom_inline_input {
            border: 0px;
            outline: 0;
            background-color: transparent;
            border-bottom: 1px dotted #222;
        }


        .border-0 {
            border: 0px;
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

        .w-100 {
            width: 100%;
        }

        .w-5 {
            width: 5%;
        }

        .w-10 {
            width: 10%;
        }

        .w-15 {
            width: 15%;
        }

        .w-20 {
            width: 20%;
        }

        .w-25 {
            width: 25%;
        }

        .w-30 {
            width: 30%;
        }

        .w-50 {
            width: 50%;
        }

        .w-100 {
            width: 100%;
        }

        .mb-10 {
            margin-bottom: 10px;
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

        .mb-15 {
            margin-bottom: 15px;
        }

        .mb-10 {
            margin-bottom: 10px;
        }

        .pb-0 {
            padding-bottom: 0;
        }


        .logo {
            width: 80px;
            display: inline-block;
        }

        .d-flex {
            display: flex;
        }

        .align-items-center {
            align-items: center;
        }

        .hospital-names {
            margin-bottom: 0;
            font-size: 20px;
            padding-bottom: 0;
        }

        .hospital-logo-info .hospital_info .hospital-address {
            font-weight: 500;
            display: block;
            line-height: 1.2;
        }

        .hospital-logo-info .hospital_info .hospital-contact {
            font-weight: 500;
            display: block;
            line-height: 1.2;
            width: 480px;
        }

        .hospital_info {
            margin-left: 10px;
        }

        .text-uppercase {
            text-transform: uppercase;
        }

        .title {
            /*background-color: #444;*/
            /*display: inline-block;*/
            font-size: 14px;
            color: #000;
            padding: 5px 50px;
            border-radius: 3px;
            /*font-weight: bold;*/
        }

        .form-heading .title-name {
            font-size: 1.35rem;
            line-height: 1;
            margin-top: 30px;
            margin-bottom: 20px;
        }

        .form-heading h5 {
            font-size: 1rem;
            /*line-height: 1;*/
            margin-top: -10px;
            font-weight: 400;
        }

        .form-heading p {
            font-size: .8rem;
            margin-top: -10px;
        }

        .form-name {
            font-size: 16px;
        }

        .float-left {
            float: left;
        }

        .float-right {
            float: right;
        }

        .d-block {
            display: block;
        }

        .d-inline-block {
            display: inline-block;
        }

        .border-1 {
            border: 1px solid;
        }

        /* .border-bottom {
            border-bottom: 1px solid #dee2e6;
        } */

        .justify-content-between {
            justify-content: space-between;
        }

        .signature {
            width: 100%;
            height: 30px;
            margin-top: 0;
            margin-bottom: 10px;
        }

        .border-right {
            border-right: 1px solid #222;
        }

        .form-check-inline {
            display: inline-block;
            align-items: center;
            padding-left: 0;
            margin-right: 0.2rem;
        }

        .form-check {
            position: relative;
        }

        .form-check-inline .form-check-input {
            position: static;
            margin-top: 5px;
            /*margin-right: 0.3125rem;*/
            margin-left: 0;
        }

        input[type=radio],
        input[type=checkbox] {
            box-sizing: border-box;
            padding: 0;
        }

        .v-align-top {
            vertical-align: top;
        }

        /* .table-bordered td,
        .table-bordered th {
            border: 1px solid #222
        } */

        table,
        th,
        td {
            border: 1px solid black !important;
        }

        .box-sizing {
            border: 1px solid;
            padding: 3px;
            box-shadow: 2px 4px #000;
            background: #eeeded;
        }

        .font-size-12 {
            font-size: 12px !important;
        }

        h2 {
            margin: 2px;
            font-family: vardana;
            font-weight: bold;
        }



        th {
        text-orientation: downright;
        writing-mode: vertical-rl;
        flex-wrap: wrap-reverse;
    }

    .bc-head-txt-label,.dt {
        left: calc(50% - .5rem);
        line-height: 1;
        padding-top: .5rem;
        position: relative;
        -webkit-transform: rotate(180deg);
        transform: rotate(180deg);
        white-space: nowrap;
        -webkit-writing-mode: vertical-rl;
        writing-mode: vertical-rl;
    }
    </style>
</head>

<body onload="window.print()">
    <div class="container-fluid">
        <div class="form-row justify-content-center">
            <div class="col-md-9">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <div class="form-content">
                            <table style="width: 100%; border:5px solid transparent !important" class="signature">
                                <tr style="">
                                    <td style="text-align:center;border:none !important;">
                                        {{-- <img class="hospital-logo"
                                            src="{{ asset('images/uploads/hospital_images/141.jpg') }}" width="80"
                                            alt=""> --}}
                                    </td>
                                </tr>

                                <tr style="">
                                    <td style="text-align:center;border:none !important;">
                                        <span style="font-size: 15px;"> <strong>
                                                {{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }}</strong></span>
                                        <br>
                                        Address:<span>
                                            {{ isset($po_hospital_details->addrress1) ? $po_hospital_details->addrress1 : '' }}</span><br>
                                        {{-- Phone
                                        No:<span>{{ isset($po_hospital_details->telephone1) ? $po_hospital_details->telephone1 : '' }}</span> --}}
                                    </td>
                                </tr>
                            </table>

                            <table class="table table-bordered table-striped mb-0 data-table" style="width: 100%">
                                <thead>
                                    <tr class="bg-light-blue">
                                        <th class="text-center"></th>
                                        <th class="text-center"></th>
                                        <th class="text-center">
                                            <div class="bc-head-txt-label">Ambulance</div>
                                        </th>
                                        <th class="text-center">
                                            <div class="bc-head-txt-label">Emergency</div>
                                        </th>
                                        <th class="text-center">
                                            <div class="bc-head-txt-label">Eye</div>
                                        </th>
                                        <th class="text-center">
                                            <div class="bc-head-txt-label">Radiology</div>
                                        </th>
                                        <th class="text-center">
                                            <div class="bc-head-txt-label">Pathology</div>
                                        </th>
                                        <th class="text-center">
                                            <div class="bc-head-txt-label">IPD</div>
                                        </th>
                                        <th class="text-center">
                                            <div class="bc-head-txt-label">Prescription</div>
                                        </th>
                                        <th class="text-center">
                                            <div class="bc-head-txt-label">Total</div>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td rowspan="3">
                                            <div class="dt"> 30-April-2022</div>
                                        </td>
                                        <td style="text-align: left;">Hariz</td>
                                        <td>10</td>
                                        <td>0</td>
                                        <td>5000</td>
                                        <td>3000</td>
                                        <td>0</td>
                                        <td>0</td>
                                        <td>1000</td>
                                        <td>8010</td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: left;">Tanzil</td>
                                        <td>10</td>
                                        <td>0</td>
                                        <td>5000</td>
                                        <td>3000</td>
                                        <td>0</td>
                                        <td>0</td>
                                        <td>1000</td>
                                        <td>8010</td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: left;">Total</td>
                                        <td>10</td>
                                        <td>0</td>
                                        <td>5000</td>
                                        <td>3000</td>
                                        <td>0</td>
                                        <td>0</td>
                                        <td>1000</td>
                                        <td>8010</td>
                                    </tr>


                                    <tr>
                                        <td rowspan="3">
                                            <div class="dt"> 01-May-2022</div>
                                        </td>
                                        <td style="text-align: left;">Hariz</td>
                                        <td>10</td>
                                        <td>0</td>
                                        <td>5000</td>
                                        <td>3000</td>
                                        <td>0</td>
                                        <td>0</td>
                                        <td>1000</td>
                                        <td>8010</td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: left;">Tanzil</td>
                                        <td>10</td>
                                        <td>0</td>
                                        <td>5000</td>
                                        <td>3000</td>
                                        <td>0</td>
                                        <td>0</td>
                                        <td>1000</td>
                                        <td>8010</td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: left;">Total</td>
                                        <td>10</td>
                                        <td>0</td>
                                        <td>5000</td>
                                        <td>3000</td>
                                        <td>0</td>
                                        <td>0</td>
                                        <td>1000</td>
                                        <td>8010</td>
                                    </tr>

                                    {{-- footer  --}}
                                    <tr>
                                        <td style="text-align: left;" colspan="2"><strong>Total</strong></td>
                                        <td>10</td>
                                        <td>0</td>
                                        <td>5000</td>
                                        <td>3000</td>
                                        <td>0</td>
                                        <td>0</td>
                                        <td>1000</td>
                                        <td>8010</td>
                                    </tr>


                                </tbody>

                            </table>




                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer>
        <!-- <hr style="border: 0.5px solid #000000"> -->
        <!-- <div class="">
            <span style="float:left">Printing Date & Time: {{ date('d/m/Y H:i:s') }} &nbsp;
                <span style="float:right">Powered By: NEXTGEN IT</span>
        </div> -->
        <?php
        $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
        $date = $dt->format('g:i A');
        ?>
        <div class="">
            <span style="float:left;">Prepared By: </span> &nbsp; <span
                style="">Printing Date & Time: {{ date('d/m/Y') }} , {{ $date }} </span>&nbsp;
            <span style="float:right">Powered By: NEXTGEN IT</span>
        </div>
    </footer>
</body>

</html>
