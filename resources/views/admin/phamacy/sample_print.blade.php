@php
    $hospital = DB::table('wsec_hospital')
        ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
        ->first();
@endphp

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Barcode Print</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <style>
        @page {
            margin: 0cm 0cm;
            /* width: 550px; */
            /* size:  200mm 50mm  landscape; */
            size: 1.2in 2in landscape;
        }

        body {
            margin-top: 0cm;
            margin-left: 0cm;
            margin-right: 0cm;
            margin-bottom: 0cm;
            font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
            /* font-size: 13px; */
            padding: 5px;
            line-height: 9px;
            text-align: center;
        }

        @font-face {
            font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
            font-weight: normal;
            /* font-size: 11px; */
            font-style: normal;
            font-variant: normal;
            src: url("font url");
        }

        .wrapper {

            font-size: 10px;
            font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
            /* width: 100%;
            height: 65px; */
        }
    </style>
</head>

<body>
    @php

        date_default_timezone_set('Asia/Dhaka');
        // $time = Carbon::now();
        $cur_date = date('d/m/Y h:i:s');
    @endphp


    <div class="page-break"></div>

    <img style="margin-bottom:5px " src="data:image/png;base64, {{ $barcode_no }} " width="80%" height="30px" /><br>
    @if (isset($label_info))
        <span
            style=" font-size:10.5px; padding:0px; margin:0px; text-align:left !important; margin-top:15px !important;"><strong>{{ '[' . $label_info->item_code . ']' }}</strong>
        </span>
        <br>
        <span
            style=" font-size:10.5px; padding:0px; margin:0px; text-align:left !important; margin-top:15px !important;"><strong>{{ $label_info->item_name != '' ? $label_info->item_name : '' }}</strong></span>
        <br>
        <span style=" font-size:13.5px; padding:0px; margin:0px; text-align:left !important; margin-top:15px !important;">Price:
            <Strong>{{ number_format($label_info->sales_price, 2) }}</Strong></span>

        {{-- @endif --}}
    @endif


</body>

</html>
