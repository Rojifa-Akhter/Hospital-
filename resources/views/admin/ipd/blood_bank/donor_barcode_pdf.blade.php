<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Donor Barcode Print</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <style>
        @page {
            margin: 0cm 0cm;
            size: 1.3in 2in landscape;
        }

        body {
            margin-top: 0cm;
            margin-left: 0cm;
            margin-right: 0cm;
            margin-bottom: 0cm;
            font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
            padding-left: 2px;
            padding-right: 2px;
            padding-top: 15px;
            line-height: 11px;
            text-align: center;
          
        }

        @font-face {
            font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
            font-weight: normal;
            font-style: normal;
            font-variant: normal;
            src: url("font url");
        }

        /* .wrapper {
            font-style: bold !important;
            font-size: 12px;
            color: black;
            font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
        } */

        .wrapper {
            font-style: bold !important;
            font-size: 12px;
            color: black;
            font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
        }


        .page-break {
            page-break-after: always;
        }
    </style>
</head>

<body>
    @php
    $pat_name = '';
    if ($label_info->donor_name != '' && isset($label_info->donor_name)) {
    if (Str::length($label_info->donor_name) > 16) {
    $pat_name = substr($label_info->donor_name, 0, -(Str::length($label_info->donor_name) - 16));
    $pat_name = substr($label_info->donor_name, 0, -(Str::length($label_info->donor_name) - 16));
    } else {
    $pat_name = $label_info->donor_name;
    }
    }

    date_default_timezone_set('Asia/Dhaka');
    $cur_date = date('d/m/Y h:i:s');
    @endphp
    <div class="wrapper">
        <div>
            <img style="margin-bottom:5px " src="data:image/png;base64, {{ $lab_no_barcode }} " width="80%" height="30px" /><br>
             {{$pat_name}} <br> 
            <label for="">Donor ID: </label> {{$label_info->donor_no_pk}} <br>
            <label for="">Requisition No: </label> {{$label_info->blood_req_no_fk}} <br> <br>
            <small>Print time {{date('d/m/Y h:i a')}}</small>
        </div>
    </div>
</body>
</html>