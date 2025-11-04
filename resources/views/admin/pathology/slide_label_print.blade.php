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
            size: 25mm 25mm landscape;
        }

        body {
            margin-top: 0cm;
            margin-left: 0cm;
            margin-right: 0cm;
            margin-bottom: 0cm;
            font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
            /* font-size: 13px; */
            padding-left: 2px;
            padding-right: 2px;
            padding-top: 15px;
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
            font-style: bold !important;
            font-size: 10px;
            color: black;
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
        if ($label_info->patient_name != '' && isset($label_info->patient_name)) {
            if (Str::length($label_info->patient_name) > 16) {
                $pat_name = substr($label_info->patient_name, 0, -(Str::length($label_info->patient_name) - 16));
                $pat_name = substr($label_info->patient_name, 0, -(Str::length($label_info->patient_name) - 16));
            } else {
                $pat_name = $label_info->patient_name;
            }
        }

        date_default_timezone_set('Asia/Dhaka');
        // $time = Carbon::now();
        $cur_date = date('d/m/Y h:i:s');
    @endphp

    <div class="wrapper">
        <div style="font-size: 12px; font-family: Arial, sans-serif; font-weight: bold; margin: 0 0 4px 0; border-bottom: 1px solid #000;">
    {{ strtoupper($hospital->hospital_code) }}
</div>

        {{-- <strong>Patient Code:</strong> {{ $label_info->patient_code }} <br> --}}
        <strong style="margin-top:5px">INV:</strong> {{ $label_info->invoice_code }} <br>
        <span style="font-size: 9px;"><b>{{ $pat_name }}</b> </span><br>
      {{-- <strong>Collected Time:</strong> <br> --}}
        {{ !empty($label_info->sc_sample_coll_keyed_time) && strtotime($label_info->sc_sample_coll_keyed_time) ? date('d/m/Y', strtotime($label_info->sc_sample_coll_keyed_time)) : '' }}
    </div>




</body>

</html>
