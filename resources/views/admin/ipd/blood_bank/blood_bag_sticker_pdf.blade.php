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
            size: 2.5in 4in landscape;
        }

        body {
            margin-top: 0cm;
            margin-left: 0cm;
            margin-right: 0cm;
            margin-bottom: 0cm;
            font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
            /* font-size: 13px; */
            padding: 10px;
            line-height: 12px;
            text-align: left;
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

            font-size: 12px;
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
        date_default_timezone_set('Asia/Dhaka');
        $cur_date = date('d/m/Y h:i:s');
    @endphp

    @if ($label_info->whole_blood)
    <span style=" font-size:10.5px; padding:0px; margin:0px "> Blood Bag No : {{ $label_info->crossmatch_no_pk }}</span>
    <br>
    <span style=" font-size:10.5px; padding:0px; margin:0px ;"> Blood Group : {{ $label_info->blood_group }}</span> <br>
    <span style=" font-size:10.5px; padding:0px; margin:0px ">Collection Date : {{ $label_info->blood_col_date ? date('d-m-Y', strtotime($label_info->blood_col_date)) : '' }}</span> <br>
    <span style=" font-size:10.5px; padding:0px; margin:0px ">Date of Expiry : {{ $label_info->whole_blood_exp_date ? date('d-m-Y', strtotime($label_info->whole_blood_exp_date)) : '' }}</span><br>
    <span style=" font-size:10.5px; padding:0px; margin:0px ">Component : {{ $label_info->whole_blood}}</span><br>
    <span style=" font-size:10.5px; padding:0px; margin:0px ">Patient Name : {{ $label_info->patient_name }}</span><br>
    <span style=" font-size:10.5px; padding:0px; margin:0px ">Patient ID : {{ $label_info->patient_code }}</span><br>
    <span style=" font-size:10.5px; padding:0px; margin:0px ">Stock ID : {{ $label_info->crossmatch_no_pk }}</span><br>
    <img style="margin-bottom:5px; margin-top:5px; margin-left:35px; " src="data:image/png;base64, {{ $lab_no_barcode }}" width="25%"
    height="30px" />
    @endif
    <br>
    @if ($label_info->prbc_rcc_pcv)
    <span style=" font-size:10.5px; padding:0px; margin:0px "> Blood Bag No : {{ $label_info->crossmatch_no_pk }}</span>
    <br>
    <span style=" font-size:10.5px; padding:0px; margin:0px ;"> Blood Group : {{ $label_info->blood_group }}</span> <br>
    <span style=" font-size:10.5px; padding:0px; margin:0px ">Collection Date : {{ $label_info->blood_col_date ? date('d-m-Y', strtotime($label_info->blood_col_date)) : '' }}</span> <br>
    <span style=" font-size:10.5px; padding:0px; margin:0px ">Date of Expiry : {{ $label_info->prbc_rcc_pcv_exp_date ? date('d-m-Y', strtotime($label_info->prbc_rcc_pcv_exp_date)) : '' }}</span><br>
    <span style=" font-size:10.5px; padding:0px; margin:0px ">Component : {{ $label_info->prbc_rcc_pcv }}</span><br>
    <span style=" font-size:10.5px; padding:0px; margin:0px ">Patient Name : {{ $label_info->patient_name }}</span><br>
    <span style=" font-size:10.5px; padding:0px; margin:0px ">Patient ID : {{ $label_info->patient_code }}</span><br>
    <span style=" font-size:10.5px; padding:0px; margin:0px ">Stock ID : {{ $label_info->crossmatch_no_pk }}</span><br>
    <img style="margin-bottom:5px; margin-top:5px; margin-left:35px;" src="data:image/png;base64, {{ $lab_no_barcode }}" width="25%"
    height="30px" />
    @endif
    <br>

    @if ($label_info->washed_prbc)
    <span style=" font-size:10.5px; padding:0px; margin:0px "> Blood Bag No : {{ $label_info->crossmatch_no_pk }}</span>
    <br>
    <span style=" font-size:10.5px; padding:0px; margin:0px ;"> Blood Group : {{ $label_info->blood_group }}</span> <br>
    <span style=" font-size:10.5px; padding:0px; margin:0px ">Collection Date : {{ $label_info->blood_col_date ? date('d-m-Y', strtotime($label_info->blood_col_date)) : '' }}</span> <br>
    <span style=" font-size:10.5px; padding:0px; margin:0px ">Date of Expiry : {{ $label_info->washed_prbc_exp_date ? date('d-m-Y', strtotime($label_info->washed_prbc_exp_date)) : '' }}</span><br>
    <span style=" font-size:10.5px; padding:0px; margin:0px ">Component : {{ $label_info->washed_prbc }}</span><br>
    <span style=" font-size:10.5px; padding:0px; margin:0px ">Patient Name : {{ $label_info->patient_name }}</span><br>
    <span style=" font-size:10.5px; padding:0px; margin:0px ">Patient ID : {{ $label_info->patient_code }}</span><br>
    <span style=" font-size:10.5px; padding:0px; margin:0px ">Stock ID : {{ $label_info->crossmatch_no_pk }}</span><br>
    <img style="margin-bottom:5px; margin-top:5px; margin-left:35px;" src="data:image/png;base64, {{ $lab_no_barcode }}" width="25%"
    height="30px" />
    @endif
    <br>
    {{-- <div class="section"> --}}
    @if ($label_info->platalet_concentrate)
    <span style=" font-size:10.5px; padding:0px; margin:0px "> Blood Bag No : {{ $label_info->crossmatch_no_pk }}</span>
    <br>
    <span style=" font-size:10.5px; padding:0px; margin:0px ;"> Blood Group : {{ $label_info->blood_group }}</span> <br>
    <span style=" font-size:10.5px; padding:0px; margin:0px ">Collection Date : {{ $label_info->blood_col_date ? date('d-m-Y', strtotime($label_info->blood_col_date)) : '' }}</span> <br>
    <span style=" font-size:10.5px; padding:0px; margin:0px ">Date of Expiry : {{ $label_info->platalet_concentrate_exp_date ? date('d-m-Y', strtotime($label_info->platalet_concentrate_exp_date )) : '' }}</span><br>
    <span style=" font-size:10.5px; padding:0px; margin:0px ">Component : {{ $label_info->platalet_concentrate }}</span><br>
    <span style=" font-size:10.5px; padding:0px; margin:0px ">Patient Name : {{ $label_info->patient_name }}</span><br>
    <span style=" font-size:10.5px; padding:0px; margin:0px ">Patient ID : {{ $label_info->patient_code }}</span><br>
    <span style=" font-size:10.5px; padding:0px; margin:0px ">Stock ID : {{ $label_info->crossmatch_no_pk }}</span><br>
    <img style="margin-bottom:5px; margin-top:5px; margin-left:35px;" src="data:image/png;base64, {{ $lab_no_barcode }}" width="25%"
    height="30px" />
    @endif
    {{-- </div> --}}
</body>

</html>
