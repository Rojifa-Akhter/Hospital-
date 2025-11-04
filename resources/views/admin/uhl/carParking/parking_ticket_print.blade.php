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
    <title>Label Print</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <style>
        @page {
            margin: 0cm 0cm;
            /* width: 550px; */
            /* size:  200mm 50mm  landscape; */
            size: 1in 3in landscape;
        }

        body {
            margin-top: 0cm;
            margin-left: 0cm;
            margin-right: 0cm;
            margin-bottom: 0cm;
            font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
            /* font-size: 13px; */
            padding-left: 5px;
            padding-right: 5px;
            line-height: 9px;
            /* text-align: center; */
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

        .page-break {
            page-break-after: always;
        }
    </style>
</head>

<body>
    @php
        $pat_name = '';

        date_default_timezone_set('Asia/Dhaka');
        // $time = Carbon::now();
        $cur_date = date('d/m/Y h:i:s');
    @endphp
    <table style="">
        <tr tyle="">
            <td style="width: 25%;">
                @if (!empty(Session::get('user.ses_hospital_logo')))
                    @php
                        $logo = Session::get('user.ses_hospital_logo');

                    @endphp
                    <img class="" src="{{ asset('images/uploads/hospital_images/' . $logo) }}"
                        style="padding:0px; margin:0px; " width="15" alt="">
                @endif
            </td>
            <td style="">
                <strong style=" font-size:10px; padding:0px; margin:0px ;">
                    {{ Session::get('user.hospital_name') }}</strong>
            </td>
        </tr>
    </table>



    <img style="margin:5px 0px 5px 0px;  " src="data:image/png;base64, {{ $lab_no_barcode }} " width="100%"
        height="30px" />
    @if (isset($label_info))
        @php
            $head = 'hhhhhh';
            $department = 'dddddd';
        @endphp
        <strong style=" font-size:9px; padding:0px; margin:0px ; display: block;text-align: center;">
            {{ Session::get('user.ses_hospital_code') . $head . $department . '/ggggggg'}}</strong>
        <span style="font-size:9px; "><strong> Brand :</strong> llllllllllllll </span>
        <span style="font-size:9px; float:right;  margin-top:3px ;">
            <strong>5/6/2023
            </strong></span>
    @endif

</body>

</html>
