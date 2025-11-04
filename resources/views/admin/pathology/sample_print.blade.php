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
            padding: 0cm 0cm;
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
            padding: 0px;
            line-height: 8px;
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

        .page-break {
            page-break-after: always;
        }
    </style>
</head>
@php
$body_padding_top=$label_info->test_short_name_list == 'CBC' ? "padding-top:13px;":'';
@endphp

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

    @if ($label_info->test_short_name_list == 'CBC')

    @if (isset($label_info))
    @if ($hospital->hospital_code == 'DMHL')

    <div style="<?= $body_padding_top; ?>">       
            <span style=" font-size:9px; padding:0px; margin:0px ">{{ $pat_name != '' ? $pat_name : '' }} <br> <span>UHID:{{$label_info->patient_code}}</span> 
                    <small> , 
                        @if($label_info->gender=="Male")
                            M 
                        @elseif($label_info->gender=="Female")
                            F 
                        @else 
                            O 
                        @endif
                    </small>
            </span>
            <br>
            <span style=" font-size:9px; padding:0px; margin:0px ; "> INV:{{ $label_info->invoice_code_sl }}</span>,<span style=" font-size:9px; padding:0px; margin:0px ">Age:{{ $label_info->age }} </span><br>
            <img style="margin-bottom:3px " src="data:image/png;base64, {{ $lab_no_barcode }} " width="80%" height="30px" /><br>
            <span style=" font-size:9px; padding:0px; margin:0px "> Lab No : {{ $label_info->lab_code }}</span>
            <br>
            <span style=" font-size:9px; padding:0px; margin:0px ">CBC</span>,

            <span style=" font-size:9px; padding:0px; margin:0px ">{{ $label_info->sc_sample_coll_keyed_time != '' ? date('d/m/Y h:i:s a', strtotime($label_info->sc_sample_coll_keyed_time)) : $cur_date }}</span>       
    </div>
    @else
    <img style="margin-bottom:3px " src="data:image/png;base64, {{ $lab_no_barcode }} " width="80%" height="30px" /><br>
    <span style=" font-size:9px; padding:0px; margin:0px "> Lab No : {{ $label_info->lab_code }}</span>
    <br>

    <span style=" font-size:9px; padding:0px; margin:0px ; "> INV:{{ $label_info->invoice_code_sl }}</span>,<span style=" font-size:9px; padding:0px; margin:0px ">Age:{{ $label_info->age }} </span><br>

    <span style=" font-size:9px; padding:0px; margin:0px ">CBC</span>
    <br>
    <span style=" font-size:9px; padding:0px; margin:0px ">{{ $label_info->sc_sample_coll_keyed_time != '' ? date('d/m/Y h:i:s a', strtotime($label_info->sc_sample_coll_keyed_time)) : $cur_date }}</span>
    <br>
    <span style=" font-size:9px; padding:0px; margin:0px ">{{ $pat_name != '' ? $pat_name : '' }} <br> <span>UHID:{{$label_info->patient_code}}</span> 
    <small> , 
                        @if($label_info->gender=="Male")
                            M 
                        @elseif($label_info->gender=="Female")
                            F 
                        @else 
                            O 
                        @endif
                    </small>
    </span>

    @endif
    @if ($hospital->hospital_code != 'IMPERIAL')
    <div class="page-break"></div>

    @if (isset($label_info))
    @if ($hospital->hospital_code == 'DMHL')
    <div style="<?= $body_padding_top; ?>">
        <span style=" font-size:9px; padding:0px; margin:0px ">{{ $pat_name != '' ? $pat_name : '' }} <br> <span>UHID:{{$label_info->patient_code}}</span> 
        <small> , 
                        @if($label_info->gender=="Male")
                            M 
                        @elseif($label_info->gender=="Female")
                            F 
                        @else 
                            O 
                        @endif
                    </small>
        </span>

        <br>

        <span style=" font-size:9px; padding:0px; margin:0px ; "> INV:{{ $label_info->invoice_code_sl }}</span>,<span style=" font-size:9px; padding:0px; margin:0px ">Age:
            @php

            $pat_dob = new \DateTime($label_info->dob);
            $invoice_date = new \DateTime($label_info->invoice_date);
            $interval = $invoice_date->diff($pat_dob);
            @endphp
            {{-- {{ $label_info->age }} --}}
            {{ $interval->format('%yY %mM %dD') }}
        </span><br>
        <img style="margin-bottom:3px " src="data:image/png;base64, {{ $lab_no_barcode }} " width="80%" height="30px" /><br>
        <span style=" font-size:9px; padding:0px; margin:0px "> Lab No :
            {{ $label_info->lab_code }}</span><br>
        <span style=" font-size:9px; padding:0px; margin:0px ">ESR</span>,

        <span style=" font-size:9px; padding:0px; margin:0px ">{{ $label_info->sc_sample_coll_keyed_time != '' ? date('d/m/Y h:i:s a', strtotime($label_info->sc_sample_coll_keyed_time)) : $cur_date }}</span>


    </div>

    @else
    <img style="margin-bottom:3px " src="data:image/png;base64, {{ $lab_no_barcode }} " width="80%" height="30px" /><br>
    <span style=" font-size:9px; padding:0px; margin:0px "> Lab No :
        {{ $label_info->lab_code }}</span>
    <br>

    <span style=" font-size:9px; padding:0px; margin:0px ; "> INV:{{ $label_info->invoice_code_sl }}</span>,<span style=" font-size:9px; padding:0px; margin:0px ">Age:
        @php

        $pat_dob = new \DateTime($label_info->dob);
        $invoice_date = new \DateTime($label_info->invoice_date);
        $interval = $invoice_date->diff($pat_dob);
        @endphp
        {{-- {{ $label_info->age }} --}}
        {{ $interval->format('%yY %mM %dD') }}
    </span><br>

    <span style=" font-size:9px; padding:0px; margin:0px ">ESR</span><br>

    <span style=" font-size:9px; padding:0px; margin:0px ">{{ $label_info->sc_sample_coll_keyed_time != '' ? date('d/m/Y h:i:s a', strtotime($label_info->sc_sample_coll_keyed_time)) : $cur_date }}</span>
    <br>
    <span style=" font-size:9px; padding:0px; margin:0px ">{{ $pat_name != '' ? $pat_name : '' }} <br> <span>UHID:{{$label_info->patient_code}}</span> 
    <small> , 
                        @if($label_info->gender=="Male")
                            M 
                        @elseif($label_info->gender=="Female")
                            F 
                        @else 
                            O 
                        @endif
                    </small>
    </span>



    @endif
    @endif


    @endif

    @endif
    @elseif ($label_info->test_short_name_list == 'CBC-PBF, PBF')
    <img style="margin-bottom:3px " src="data:image/png;base64, {{ $lab_no_barcode }} " width="80%" height="30px" /><br>
    @if (isset($label_info))
    <span style=" font-size:9px; padding:0px; margin:0px "> Lab No : {{ $label_info->lab_code }}</span>
    <br>
    <span style=" font-size:9px; padding:0px; margin:0px ; "> INV:{{ $label_info->invoice_code_sl }}</span>, <span style=" font-size:9px; padding:0px; margin:0px ">Age:{{ $label_info->age }} </span><br>
    <span style=" font-size:9px; padding:0px; margin:0px ">CBC , PBF</span>
    <br>
    <span style=" font-size:9px; padding:0px; margin:0px ">{{ $label_info->sc_sample_coll_keyed_time != '' ? date('d/m/Y h:i:s a', strtotime($label_info->sc_sample_coll_keyed_time)) : $cur_date }}</span>
    <br>
    <span style=" font-size:9px; padding:0px; margin:0px ">{{ $pat_name != '' ? $pat_name : '' }} <br> <span>UHID:{{$label_info->patient_code}}</span> 
    <small> , 
                        @if($label_info->gender=="Male")
                            M 
                        @elseif($label_info->gender=="Female")
                            F 
                        @else 
                            O 
                        @endif
                    </small>
    </span>


    <div class="page-break"></div>

    <img style="margin-bottom:3px " src="data:image/png;base64, {{ $lab_no_barcode }} " width="80%" height="30px" /><br>
    @if (isset($label_info))
    <span style=" font-size:9px; padding:0px; margin:0px "> Lab No :
        {{ $label_info->lab_code }}</span>
    <br>
    <span style=" font-size:9px; padding:0px; margin:0px ; "> INV:{{ $label_info->invoice_code_sl }}</span>,<span style=" font-size:9px; padding:0px; margin:0px ">Age:{{ $label_info->age }} </span><br>
    <span style=" font-size:9px; padding:0px; margin:0px ">ESR</span>
    <br>
    <span style=" font-size:9px; padding:0px; margin:0px ">{{ $label_info->sc_sample_coll_keyed_time != '' ? date('d/m/Y h:i:s a', strtotime($label_info->sc_sample_coll_keyed_time)) : $cur_date }}</span>
    <br>
    <span style=" font-size:9px; padding:0px; margin:0px ">{{ $pat_name != '' ? $pat_name : '' }} <br> <span>UHID:{{$label_info->patient_code}}</span> 
    <small> , 
                        @if($label_info->gender=="Male")
                            M 
                        @elseif($label_info->gender=="Female")
                            F 
                        @else 
                            O 
                        @endif
                    </small>
    </span>
    @endif
    @endif
    @elseif ($label_info->test_short_name_list == 'CRP, Malaria')
    <img style="margin-bottom:3px " src="data:image/png;base64, {{ $lab_no_barcode }} " width="80%" height="30px" /><br>
    @if (isset($label_info))
    <span style=" font-size:9px; padding:0px; margin:0px "> Lab No : {{ $label_info->lab_code }}</span>
    <br>
    <span style=" font-size:9px; padding:0px; margin:0px ; "> INV:{{ $label_info->invoice_code }}</span>,<span style=" font-size:9px; padding:0px; margin:0px ">Age:{{ $label_info->age }}</span><br>
    <span style=" font-size:9px; padding:0px; margin:0px ">CRP</span>
    <br>
    <span style=" font-size:9px; padding:0px; margin:0px ">{{ $label_info->sc_sample_coll_keyed_time != '' ? date('d/m/Y h:i:s a', strtotime($label_info->sc_sample_coll_keyed_time)) : $cur_date }}</span>
    <br>
    <span style=" font-size:9px; padding:0px; margin:0px ">{{ $pat_name != '' ? $pat_name : '' }} <br> <span>UHID:{{$label_info->patient_code}}</span> 
    <small> , 
                        @if($label_info->gender=="Male")
                            M 
                        @elseif($label_info->gender=="Female")
                            F 
                        @else 
                            O 
                        @endif
                    </small>
    </span>

    <div class="page-break"></div>

    <img style="margin-bottom:3px " src="data:image/png;base64, {{ $lab_no_barcode }} " width="80%" height="30px" /><br>
    @if (isset($label_info))
    <span style=" font-size:9px; padding:0px; margin:0px "> Lab No :
        {{ $label_info->lab_code }}</span>
    <br>
    <span style=" font-size:9px; padding:0px; margin:0px ; ">INV:{{ $label_info->invoice_code_sl }}</span>,<span style=" font-size:9px; padding:0px; margin:0px ">Age:{{ $label_info->age }}</span><br>
    <span style=" font-size:9px; padding:0px; margin:0px ">ICT For Malaria</span>
    <br>
    <span style=" font-size:9px; padding:0px; margin:0px ">{{ $label_info->sc_sample_coll_keyed_time != '' ? date('d/m/Y h:i:s a', strtotime($label_info->sc_sample_coll_keyed_time)) : $cur_date }}</span>
    <br>
    <span style=" font-size:9px; padding:0px; margin:0px ">{{ $pat_name != '' ? $pat_name : '' }} <br> <span>UHID:{{$label_info->patient_code}}</span> 
                    <small> , 
                        @if($label_info->gender=="Male")
                            M 
                        @elseif($label_info->gender=="Female")
                            F 
                        @else 
                            O 
                        @endif
                    </small>
    </span>
    @endif
    @endif
    @elseif ($label_info->test_short_name_list == 'FBS&2hABF')
    <img style="margin-bottom:3px;  " src="data:image/png;base64, {{ $lab_no_barcode }} " width="80%" height="30px" /><br>

    <span style=" font-size:9px; padding:0px; margin:0px "> Lab No : {{ $label_info->lab_code }}</span> <br>
    <span style=" font-size:9px; padding:0px; margin:0px ; ">INV:{{ $label_info->invoice_code_sl }}</span>,<span style=" font-size:9px; padding:0px; margin:0px ">Age:{{ $label_info->age }}</span><br>

    <span style=" font-size:9px; padding:0px; margin:0px ">FBS</span><br>
    <span style=" font-size:9px; padding:0px; margin:0px ">{{ $label_info->sc_sample_coll_keyed_time != '' ? date('d/m/Y h:i:s a', strtotime($label_info->sc_sample_coll_keyed_time)) : $cur_date }}</span>
    <br>
    <span style=" font-size:9px; padding:0px; margin:0px ">{{ $pat_name != '' ? $pat_name : '' }} <br> <span>UHID:{{$label_info->patient_code}}</span> 
    <small> , 
                        @if($label_info->gender=="Male")
                            M 
                        @elseif($label_info->gender=="Female")
                            F 
                        @else 
                            O 
                        @endif
                    </small>
    </span>
    <div class="page-break"></div>

    <img style="margin-bottom:3px;  " src="data:image/png;base64, {{ $lab_no_barcode }} " width="80%" height="30px" /><br>

    <span style=" font-size:9px; padding:0px; margin:0px "> Lab No : {{ $label_info->lab_code }}</span> <br>
    <span style=" font-size:9px; padding:0px; margin:0px ; ">INV:{{ $label_info->invoice_code_sl }}</span>,<span style=" font-size:9px; padding:0px; margin:0px ">Age:{{ $label_info->age }}</span><br>

    <span style=" font-size:9px; padding:0px; margin:0px ">CF</span><br>
    <span style=" font-size:9px; padding:0px; margin:0px ">{{ $label_info->sc_sample_coll_keyed_time != '' ? date('d/m/Y h:i:s a', strtotime($label_info->sc_sample_coll_keyed_time)) : $cur_date }}</span>
    <br>
    <span style=" font-size:9px; padding:0px; margin:0px ">{{ $pat_name != '' ? $pat_name : '' }} <br> <span>UHID:{{$label_info->patient_code}}</span> 
    <small> , 
                        @if($label_info->gender=="Male")
                            M 
                        @elseif($label_info->gender=="Female")
                            F 
                        @else 
                            O 
                        @endif
                    </small>
    </span>
    <img style="margin-bottom:3px;  " src="data:image/png;base64, {{ $lab_no_barcode }} " width="80%" height="30px" /><br>

    <span style=" font-size:9px; padding:0px; margin:0px "> Lab No : {{ $label_info->lab_code }}</span>
    <br>
    <span style=" font-size:9px; padding:0px; margin:0px ; ">INV:{{ $label_info->invoice_code_sl }}</span>,<span style=" font-size:9px; padding:0px; margin:0px ">Age:{{ $label_info->age }}</span><br>

    <span style=" font-size:9px; padding:0px; margin:0px ">2HABF</span><br>
    <span style=" font-size:9px; padding:0px; margin:0px ">{{ $label_info->sc_sample_coll_keyed_time != '' ? date('d/m/Y h:i:s a', strtotime($label_info->sc_sample_coll_keyed_time)) : $cur_date }}</span>
    <br>
    <span style=" font-size:9px; padding:0px; margin:0px ">{{ $pat_name != '' ? $pat_name : '' }} <br> <span>UHID:{{$label_info->patient_code}}</span> 
    <small> , 
                        @if($label_info->gender=="Male")
                            M 
                        @elseif($label_info->gender=="Female")
                            F 
                        @else 
                            O 
                        @endif
                    </small>
    </span>
    <img style="margin-bottom:3px;  " src="data:image/png;base64, {{ $lab_no_barcode }} " width="80%" height="30px" /><br>

    <span style=" font-size:9px; padding:0px; margin:0px "> Lab No : {{ $label_info->lab_code }}</span>
    <br>
    <span style=" font-size:9px; padding:0px; margin:0px ; ">INV:{{ $label_info->invoice_code_sl }}</span>,<span style=" font-size:9px; padding:0px; margin:0px ">Age:{{ $label_info->age }}</span><br>

    <span style=" font-size:9px; padding:0px; margin:0px ">C2HABF</span><br>
    <span style=" font-size:9px; padding:0px; margin:0px ">{{ $label_info->sc_sample_coll_keyed_time != '' ? date('d/m/Y h:i:s a', strtotime($label_info->sc_sample_coll_keyed_time)) : $cur_date }}</span>
    <br>
    <span style=" font-size:9px; padding:0px; margin:0px ">{{ $pat_name != '' ? $pat_name : '' }} <br> <span>UHID:{{$label_info->patient_code}}</span> 
    <small> , 
                        @if($label_info->gender=="Male")
                            M 
                        @elseif($label_info->gender=="Female")
                            F 
                        @else 
                            O 
                        @endif
                    </small>
    </span>
    @elseif ($label_info->test_short_name_list == '2h-ABF-CUS, FBSC')
    <img style="margin-bottom:3px;  " src="data:image/png;base64, {{ $lab_no_barcode }} " width="80%" height="30px" /><br>

    <span style=" font-size:9px; padding:0px; margin:0px "> Lab No : {{ $label_info->lab_code }}</span>
    <br>
    <span style=" font-size:9px; padding:0px; margin:0px ; ">INV:{{ $label_info->invoice_code_sl }}</span>,<span style=" font-size:9px; padding:0px; margin:0px ">Age:{{ $label_info->age }}</span><br>

    <span style=" font-size:9px; padding:0px; margin:0px ">FBS</span><br>
    <span style=" font-size:9px; padding:0px; margin:0px ">{{ $label_info->sc_sample_coll_keyed_time != '' ? date('d/m/Y h:i:s a', strtotime($label_info->sc_sample_coll_keyed_time)) : $cur_date }}</span>
    <br>
    <span style=" font-size:9px; padding:0px; margin:0px ">{{ $pat_name != '' ? $pat_name : '' }} <br> <span>UHID:{{$label_info->patient_code}}</span> 
    <small> , 
                        @if($label_info->gender=="Male")
                            M 
                        @elseif($label_info->gender=="Female")
                            F 
                        @else 
                            O 
                        @endif
                    </small>
    </span>
    <div class="page-break"></div>

    <img style="margin-bottom:3px;  " src="data:image/png;base64, {{ $lab_no_barcode }} " width="80%" height="30px" /><br>

    <span style=" font-size:9px; padding:0px; margin:0px "> Lab No : {{ $label_info->lab_code }}</span>
    <br>
    <span style=" font-size:9px; padding:0px; margin:0px ; ">INV:{{ $label_info->invoice_code_sl }}</span>,<span style=" font-size:9px; padding:0px; margin:0px ">Age:{{ $label_info->age }}</span><br>
    <span style=" font-size:9px; padding:0px; margin:0px ">CF</span><br>
    <span style=" font-size:9px; padding:0px; margin:0px ">{{ $label_info->sc_sample_coll_keyed_time != '' ? date('d/m/Y h:i:s a', strtotime($label_info->sc_sample_coll_keyed_time)) : $cur_date }}</span>
    <br>
    <span style=" font-size:9px; padding:0px; margin:0px ">{{ $pat_name != '' ? $pat_name : '' }} <br> <span>UHID:{{$label_info->patient_code}}</span> 
    <small> , 
                        @if($label_info->gender=="Male")
                            M 
                        @elseif($label_info->gender=="Female")
                            F 
                        @else 
                            O 
                        @endif
                    </small>
    </span>
    <img style="margin-bottom:3px;  " src="data:image/png;base64, {{ $lab_no_barcode }} " width="80%" height="30px" /><br>

    <span style=" font-size:9px; padding:0px; margin:0px "> Lab No : {{ $label_info->lab_code }}</span>
    <br>
    <span style=" font-size:9px; padding:0px; margin:0px ; "> INV:{{ $label_info->invoice_code_sl }}</span>,<span style=" font-size:9px; padding:0px; margin:0px ">Age:{{ $label_info->age }}</span><br>

    <span style=" font-size:9px; padding:0px; margin:0px ">2HABF</span><br>
    <span style=" font-size:9px; padding:0px; margin:0px ">{{ $label_info->sc_sample_coll_keyed_time != '' ? date('d/m/Y h:i:s a', strtotime($label_info->sc_sample_coll_keyed_time)) : $cur_date }}</span>
    <br>
    <span style=" font-size:9px; padding:0px; margin:0px ">{{ $pat_name != '' ? $pat_name : '' }} <br> <span>UHID:{{$label_info->patient_code}}</span> 
    <small> , 
                        @if($label_info->gender=="Male")
                            M 
                        @elseif($label_info->gender=="Female")
                            F 
                        @else 
                            O 
                        @endif
                    </small>
    </span>
    <img style="margin-bottom:3px;  " src="data:image/png;base64, {{ $lab_no_barcode }} " width="80%" height="30px" /><br>

    <span style=" font-size:9px; padding:0px; margin:0px "> Lab No : {{ $label_info->lab_code }}</span>
    <br>
    <span style=" font-size:9px; padding:0px; margin:0px ; ">INV:{{ $label_info->invoice_code_sl }}</span>,<span style=" font-size:9px; padding:0px; margin:0px ">Age:{{ $label_info->age }}</span><br>

    <span style=" font-size:9px; padding:0px; margin:0px ">C2HABF</span><br>
    <span style=" font-size:9px; padding:0px; margin:0px ">{{ $label_info->sc_sample_coll_keyed_time != '' ? date('d/m/Y h:i:s a', strtotime($label_info->sc_sample_coll_keyed_time)) : $cur_date }}</span>
    <br>
    <span style=" font-size:9px; padding:0px; margin:0px ">{{ $pat_name != '' ? $pat_name : '' }} <br> <span>UHID:{{$label_info->patient_code}}</span> 
    <small> , 
                        @if($label_info->gender=="Male")
                            M 
                        @elseif($label_info->gender=="Female")
                            F 
                        @else 
                            O 
                        @endif
                    </small>
    </span>
    @elseif ($label_info->test_short_name_list == '2h-ABF-CUS')
    <img style="margin-bottom:3px;  " src="data:image/png;base64, {{ $lab_no_barcode }} " width="80%" height="30px" /><br>

    <span style=" font-size:9px; padding:0px; margin:0px "> Lab No : {{ $label_info->lab_code }}</span>
    <br>
    <span style=" font-size:9px; padding:0px; margin:0px ; ">INV:{{ $label_info->invoice_code_sl }}</span>,<span style=" font-size:9px; padding:0px; margin:0px ">Age:{{ $label_info->age }}</span><br>

    <span style=" font-size:9px; padding:0px; margin:0px ">2HABF</span><br>
    <span style=" font-size:9px; padding:0px; margin:0px ">{{ $label_info->sc_sample_coll_keyed_time != '' ? date('d/m/Y h:i:s a', strtotime($label_info->sc_sample_coll_keyed_time)) : $cur_date }}</span>
    <br>
    <span style=" font-size:9px; padding:0px; margin:0px ">{{ $pat_name != '' ? $pat_name : '' }} <br> <span>UHID:{{$label_info->patient_code}}</span> 
    <small> , 
                        @if($label_info->gender=="Male")
                            M 
                        @elseif($label_info->gender=="Female")
                            F 
                        @else 
                            O 
                        @endif
                    </small>
    </span>
    <img style="margin-bottom:3px;  " src="data:image/png;base64, {{ $lab_no_barcode }} " width="80%" height="30px" /><br>

    <span style=" font-size:9px; padding:0px; margin:0px "> Lab No : {{ $label_info->lab_code }}</span>
    <br>
    <span style=" font-size:9px; padding:0px; margin:0px ; ">INV:
        {{ $label_info->invoice_code_sl }}</span>,<span style=" font-size:9px; padding:0px; margin:0px ">Age:{{ $label_info->age }}</span><br>

    <span style=" font-size:9px; padding:0px; margin:0px ">C2HABF</span><br>
    <span style=" font-size:9px; padding:0px; margin:0px ">{{ $label_info->sc_sample_coll_keyed_time != '' ? date('d/m/Y h:i:s a', strtotime($label_info->sc_sample_coll_keyed_time)) : $cur_date }}</span>
    <br>
    <span style=" font-size:9px; padding:0px; margin:0px ">{{ $pat_name != '' ? $pat_name : '' }} <br> <span>UHID:{{$label_info->patient_code}}</span> 
    <small> , 
                        @if($label_info->gender=="Male")
                            M 
                        @elseif($label_info->gender=="Female")
                            F 
                        @else 
                            O 
                        @endif
                    </small>
    </span>
    @elseif ($label_info->test_short_name_list == 'FBSC')
    <img style="margin-bottom:3px;  " src="data:image/png;base64, {{ $lab_no_barcode }} " width="80%" height="30px" /><br>

    <span style=" font-size:9px; padding:0px; margin:0px "> Lab No : {{ $label_info->lab_code }}</span>
    <br>
    <span style=" font-size:9px; padding:0px; margin:0px ; ">INV:
        {{ $label_info->invoice_code_sl }}</span>,<span style=" font-size:9px; padding:0px; margin:0px ">Age:{{ $label_info->age }}</span><br>

    <span style=" font-size:9px; padding:0px; margin:0px ">FBS</span><br>
    <span style=" font-size:9px; padding:0px; margin:0px ">{{ $label_info->sc_sample_coll_keyed_time != '' ? date('d/m/Y h:i:s a', strtotime($label_info->sc_sample_coll_keyed_time)) : $cur_date }}</span>
    <br>
    <span style=" font-size:9px; padding:0px; margin:0px ">{{ $pat_name != '' ? $pat_name : '' }} <br> <span>UHID:{{$label_info->patient_code}}</span> 
    <small> , 
                        @if($label_info->gender=="Male")
                            M 
                        @elseif($label_info->gender=="Female")
                            F 
                        @else 
                            O 
                        @endif
                    </small>
    </span>
    <div class="page-break"></div>

    <img style="margin-bottom:3px;  " src="data:image/png;base64, {{ $lab_no_barcode }} " width="80%" height="30px" /><br>

    <span style=" font-size:9px; padding:0px; margin:0px "> Lab No : {{ $label_info->lab_code }}</span>
    <br>
    <span style=" font-size:9px; padding:0px; margin:0px ; ">INV:
        {{ $label_info->invoice_code_sl }}</span>,<span style=" font-size:9px; padding:0px; margin:0px ">Age:{{ $label_info->age }}</span><br>

    <span style=" font-size:9px; padding:0px; margin:0px ">CF</span><br>
    <span style=" font-size:9px; padding:0px; margin:0px ">{{ $label_info->sc_sample_coll_keyed_time != '' ? date('d/m/Y h:i:s a', strtotime($label_info->sc_sample_coll_keyed_time)) : $cur_date }}</span>
    <br>
    <span style=" font-size:9px; padding:0px; margin:0px ">{{ $pat_name != '' ? $pat_name : '' }} <br> <span>UHID:{{$label_info->patient_code}}</span> 
    <small> , 
                        @if($label_info->gender=="Male")
                            M 
                        @elseif($label_info->gender=="Female")
                            F 
                        @else 
                            O 
                        @endif
                    </small>
    </span>

    {{-- new  --}}
    @elseif ($label_info->test_short_name_list == '2h-ABF, FBS')


    <img style="margin-bottom:3px;  " src="data:image/png;base64, {{ $lab_no_barcode }} " width="80%" height="30px" /><br>

    <span style=" font-size:9px; padding:0px; margin:0px "> Lab No : {{ $label_info->lab_code }}</span>
    <br>
    <span style=" font-size:9px; padding:0px; margin:0px ; ">INV:
        {{ $label_info->invoice_code_sl }}</span>,<span style=" font-size:9px; padding:0px; margin:0px ">Age:{{ $label_info->age }}</span><br>

    <span style=" font-size:9px; padding:0px; margin:0px ">FBS</span><br>
    <span style=" font-size:9px; padding:0px; margin:0px ">{{ $label_info->sc_sample_coll_keyed_time != '' ? date('d/m/Y h:i:s a', strtotime($label_info->sc_sample_coll_keyed_time)) : $cur_date }}</span>
    <br>
    <span style=" font-size:9px; padding:0px; margin:0px ">{{ $pat_name != '' ? $pat_name : '' }} <br> <span>UHID:{{$label_info->patient_code}}</span> 
    <small> , 
                        @if($label_info->gender=="Male")
                            M 
                        @elseif($label_info->gender=="Female")
                            F 
                        @else 
                            O 
                        @endif
                    </small>
    </span>
    <div class="page-break"></div>

    <img style="margin-bottom:3px;  " src="data:image/png;base64, {{ $lab_no_barcode }} " width="80%" height="30px" /><br>

    <span style=" font-size:9px; padding:0px; margin:0px "> Lab No : {{ $label_info->lab_code }}</span>
    <br>
    <span style=" font-size:9px; padding:0px; margin:0px ; ">INV:
        {{ $label_info->invoice_code_sl }}</span>,<span style=" font-size:9px; padding:0px; margin:0px ">Age:{{ $label_info->age }}</span><br>

    <span style=" font-size:9px; padding:0px; margin:0px ">FBS-CUS</span><br>
    <span style=" font-size:9px; padding:0px; margin:0px ">{{ $label_info->sc_sample_coll_keyed_time != '' ? date('d/m/Y h:i:s a', strtotime($label_info->sc_sample_coll_keyed_time)) : $cur_date }}</span>
    <br>
    <span style=" font-size:9px; padding:0px; margin:0px ">{{ $pat_name != '' ? $pat_name : '' }} <br> <span>UHID:{{$label_info->patient_code}}</span> 
    <small> , 
                        @if($label_info->gender=="Male")
                            M 
                        @elseif($label_info->gender=="Female")
                            F 
                        @else 
                            O 
                        @endif
                    </small>
    </span>




    @elseif ($label_info->test_short_name_list == 'FBS - 2h ABF')
    <img style="margin-bottom:3px;  " src="data:image/png;base64, {{ $lab_no_barcode }} " width="80%" height="30px" /><br>

    <span style=" font-size:9px; padding:0px; margin:0px "> Lab No : {{ $label_info->lab_code }}</span>
    <br>
    <span style=" font-size:9px; padding:0px; margin:0px ; ">INV:
        {{ $label_info->invoice_code_sl }}</span>,<span style=" font-size:9px; padding:0px; margin:0px ">Age:{{ $label_info->age }}</span><br>

    <span style=" font-size:9px; padding:0px; margin:0px ">FBS-CUS</span><br>
    <span style=" font-size:9px; padding:0px; margin:0px ">{{ $label_info->sc_sample_coll_keyed_time != '' ? date('d/m/Y h:i:s a', strtotime($label_info->sc_sample_coll_keyed_time)) : $cur_date }}</span>
    <br>
    <span style=" font-size:9px; padding:0px; margin:0px ">{{ $pat_name != '' ? $pat_name : '' }} <br> <span>UHID:{{$label_info->patient_code}}</span> 
    <small> , 
                        @if($label_info->gender=="Male")
                            M 
                        @elseif($label_info->gender=="Female")
                            F 
                        @else 
                            O 
                        @endif
                    </small>
    </span>
    <div class="page-break"></div>

    <img style="margin-bottom:3px;  " src="data:image/png;base64, {{ $lab_no_barcode }} " width="80%" height="30px" /><br>

    <span style=" font-size:9px; padding:0px; margin:0px "> Lab No : {{ $label_info->lab_code }}</span>
    <br>
    <span style=" font-size:9px; padding:0px; margin:0px ; ">INV:
        {{ $label_info->invoice_code_sl }}</span>,<span style=" font-size:9px; padding:0px; margin:0px ">Age:{{ $label_info->age }}</span><br>

    <span style=" font-size:9px; padding:0px; margin:0px ">2H-CUS</span><br>
    <span style=" font-size:9px; padding:0px; margin:0px ">{{ $label_info->sc_sample_coll_keyed_time != '' ? date('d/m/Y h:i:s a', strtotime($label_info->sc_sample_coll_keyed_time)) : $cur_date }}</span>
    <br>
    <span style=" font-size:9px; padding:0px; margin:0px ">{{ $pat_name != '' ? $pat_name : '' }} <br> <span>UHID:{{$label_info->patient_code}}</span> 
    <small> , 
                        @if($label_info->gender=="Male")
                            M 
                        @elseif($label_info->gender=="Female")
                            F 
                        @else 
                            O 
                        @endif
                    </small>
    </span>
    @elseif ($label_info->test_short_name_list == '2hrs, FBS')
    <img style="margin-bottom:3px;  " src="data:image/png;base64, {{ $lab_no_barcode }} " width="80%" height="30px" /><br>

    <span style=" font-size:9px; padding:0px; margin:0px "> Lab No : {{ $label_info->lab_code }}</span>
    <br>
    <span style=" font-size:9px; padding:0px; margin:0px ; ">INV:
        {{ $label_info->invoice_code_sl }}</span>,<span style=" font-size:9px; padding:0px; margin:0px ">Age:{{ $label_info->age }}</span><br>

    <span style=" font-size:9px; padding:0px; margin:0px ">FBS</span><br>
    <span style=" font-size:9px; padding:0px; margin:0px ">{{ $label_info->sc_sample_coll_keyed_time != '' ? date('d/m/Y h:i:s a', strtotime($label_info->sc_sample_coll_keyed_time)) : $cur_date }}</span>
    <br>
    <span style=" font-size:9px; padding:0px; margin:0px ">{{ $pat_name != '' ? $pat_name : '' }} <br> <span>UHID:{{$label_info->patient_code}}</span> 
    <small> , 
                        @if($label_info->gender=="Male")
                            M 
                        @elseif($label_info->gender=="Female")
                            F 
                        @else 
                            O 
                        @endif
                    </small>
    </span>
    <div class="page-break"></div>

    <img style="margin-bottom:3px;  " src="data:image/png;base64, {{ $lab_no_barcode }} " width="80%" height="30px" /><br>

    <span style=" font-size:9px; padding:0px; margin:0px "> Lab No : {{ $label_info->lab_code }}</span>
    <br>
    <span style=" font-size:9px; padding:0px; margin:0px ; ">INV:
        {{ $label_info->invoice_code_sl }}</span>,<span style=" font-size:9px; padding:0px; margin:0px ">Age:{{ $label_info->age }}</span><br>

    <span style=" font-size:9px; padding:0px; margin:0px ">2hrs</span><br>
    <span style=" font-size:9px; padding:0px; margin:0px ">{{ $label_info->sc_sample_coll_keyed_time != '' ? date('d/m/Y h:i:s a', strtotime($label_info->sc_sample_coll_keyed_time)) : $cur_date }}</span>
    <br>
    <span style=" font-size:9px; padding:0px; margin:0px ">{{ $pat_name != '' ? $pat_name : '' }} <br> <span>UHID:{{$label_info->patient_code}}</span> 
    <small> , 
                        @if($label_info->gender=="Male")
                            M 
                        @elseif($label_info->gender=="Female")
                            F 
                        @else 
                            O 
                        @endif
                    </small>
    </span>

    @elseif ($label_info->test_short_name_list == 'PBF')
    <img style="margin-bottom:3px;  " src="data:image/png;base64, {{ $lab_no_barcode }} " width="80%" height="30px" /><br>

    <span style=" font-size:9px; padding:0px; margin:0px "> Lab No : {{ $label_info->lab_code }}</span>
    <br>
    <span style=" font-size:9px; padding:0px; margin:0px ; ">INV:
        {{ $label_info->invoice_code_sl }}</span>,<span style=" font-size:9px; padding:0px; margin:0px ">Age:{{ $label_info->age }}</span><br>

    <span style=" font-size:9px; padding:0px; margin:0px ">PBF</span><br>
    <span style=" font-size:9px; padding:0px; margin:0px ">{{ $label_info->sc_sample_coll_keyed_time != '' ? date('d/m/Y h:i:s a', strtotime($label_info->sc_sample_coll_keyed_time)) : $cur_date }}</span>
    <br>
    <span style=" font-size:9px; padding:0px; margin:0px ">{{ $pat_name != '' ? $pat_name : '' }} <br> <span>UHID:{{$label_info->patient_code}}</span> 
    <small> , 
                        @if($label_info->gender=="Male")
                            M 
                        @elseif($label_info->gender=="Female")
                            F 
                        @else 
                            O 
                        @endif
                    </small>
    </span>
    <div class="page-break"></div>

    <img style="margin-bottom:3px;  " src="data:image/png;base64, {{ $lab_no_barcode }} " width="80%" height="30px" /><br>

    <span style=" font-size:9px; padding:0px; margin:0px "> Lab No : {{ $label_info->lab_code }}</span>
    <br>
    <span style=" font-size:9px; padding:0px; margin:0px ; ">INV:
        {{ $label_info->invoice_code_sl }}</span>,<span style=" font-size:9px; padding:0px; margin:0px ">Age:{{ $label_info->age }}</span><br>

    <span style=" font-size:9px; padding:0px; margin:0px ">ESR</span><br>
    <span style=" font-size:9px; padding:0px; margin:0px ">{{ $label_info->sc_sample_coll_keyed_time != '' ? date('d/m/Y h:i:s a', strtotime($label_info->sc_sample_coll_keyed_time)) : $cur_date }}</span>
    <br>
    <span style=" font-size:9px; padding:0px; margin:0px ">{{ $pat_name != '' ? $pat_name : '' }} <br> <span>UHID:{{$label_info->patient_code}}</span> 
    <small> , 
                        @if($label_info->gender=="Male")
                            M 
                        @elseif($label_info->gender=="Female")
                            F 
                        @else 
                            O 
                        @endif
                    </small>
    </span>
    @elseif ($label_info->test_short_name_list == '2hrAFB, FBS')
    <img style="margin-bottom:3px;  " src="data:image/png;base64, {{ $lab_no_barcode }} " width="80%" height="30px" /><br>

    <span style=" font-size:9px; padding:0px; margin:0px "> Lab No : {{ $label_info->lab_code }}</span>
    <br>
    <span style=" font-size:9px; padding:0px; margin:0px ; ">INV:
        {{ $label_info->invoice_code_sl }}</span>,<span style=" font-size:9px; padding:0px; margin:0px ">Age:{{ $label_info->age }}</span><br>

    <span style=" font-size:9px; padding:0px; margin:0px ">FBS</span><br>
    <span style=" font-size:9px; padding:0px; margin:0px ">{{ $label_info->sc_sample_coll_keyed_time != '' ? date('d/m/Y h:i:s a', strtotime($label_info->sc_sample_coll_keyed_time)) : $cur_date }}</span>
    <br>
    <span style=" font-size:9px; padding:0px; margin:0px ">{{ $pat_name != '' ? $pat_name : '' }} <br> <span>UHID:{{$label_info->patient_code}}</span> 
    <small> , 
                        @if($label_info->gender=="Male")
                            M 
                        @elseif($label_info->gender=="Female")
                            F 
                        @else 
                            O 
                        @endif
                    </small>
    </span>
    <div class="page-break"></div>

    <img style="margin-bottom:3px;  " src="data:image/png;base64, {{ $lab_no_barcode }} " width="80%" height="30px" /><br>

    <span style=" font-size:9px; padding:0px; margin:0px "> Lab No : {{ $label_info->lab_code }}</span>
    <br>
    <span style=" font-size:9px; padding:0px; margin:0px ; ">INV:
        {{ $label_info->invoice_code_sl }}</span>,<span style=" font-size:9px; padding:0px; margin:0px ">Age:{{ $label_info->age }}</span><br>

    <span style=" font-size:9px; padding:0px; margin:0px ">2hrAFB</span><br>
    <span style=" font-size:9px; padding:0px; margin:0px ">{{ $label_info->sc_sample_coll_keyed_time != '' ? date('d/m/Y h:i:s a', strtotime($label_info->sc_sample_coll_keyed_time)) : $cur_date }}</span>
    <br>
    <span style=" font-size:9px; padding:0px; margin:0px ">{{ $pat_name != '' ? $pat_name : '' }} <br> <span>UHID:{{$label_info->patient_code}}</span> 
    <small> , 
                        @if($label_info->gender=="Male")
                            M 
                        @elseif($label_info->gender=="Female")
                            F 
                        @else 
                            O 
                        @endif
                    </small>
    </span>

    @elseif ($label_info->test_short_name_list == 'PBF')
    <img style="margin-bottom:3px;  " src="data:image/png;base64, {{ $lab_no_barcode }} " width="80%" height="30px" /><br>

    <span style=" font-size:9px; padding:0px; margin:0px "> Lab No : {{ $label_info->lab_code }}</span>
    <br>
    <span style=" font-size:9px; padding:0px; margin:0px ; ">INV:
        {{ $label_info->invoice_code_sl }}</span>,<span style=" font-size:9px; padding:0px; margin:0px ">Age:{{ $label_info->age }}</span><br>

    <span style=" font-size:9px; padding:0px; margin:0px ">PBF</span><br>
    <span style=" font-size:9px; padding:0px; margin:0px ">{{ $label_info->sc_sample_coll_keyed_time != '' ? date('d/m/Y h:i:s a', strtotime($label_info->sc_sample_coll_keyed_time)) : $cur_date }}</span>
    <br>
    <span style=" font-size:9px; padding:0px; margin:0px ">{{ $pat_name != '' ? $pat_name : '' }} <br> <span>UHID:{{$label_info->patient_code}}</span> 
    <small> , 
                        @if($label_info->gender=="Male")
                            M 
                        @elseif($label_info->gender=="Female")
                            F 
                        @else 
                            O 
                        @endif
                    </small>
    </span>
    <div class="page-break"></div>

    <img style="margin-bottom:3px;  " src="data:image/png;base64, {{ $lab_no_barcode }} " width="80%" height="30px" /><br>

    <span style=" font-size:9px; padding:0px; margin:0px "> Lab No : {{ $label_info->lab_code }}</span>
    <br>
    <span style=" font-size:9px; padding:0px; margin:0px ; ">INV:
        {{ $label_info->invoice_code_sl }}</span>,<span style=" font-size:9px; padding:0px; margin:0px ">Age:{{ $label_info->age }}</span><br>

    <span style=" font-size:9px; padding:0px; margin:0px ">ESR</span><br>
    <span style=" font-size:9px; padding:0px; margin:0px ">{{ $label_info->sc_sample_coll_keyed_time != '' ? date('d/m/Y h:i:s a', strtotime($label_info->sc_sample_coll_keyed_time)) : $cur_date }}</span>
    <br>
    <span style=" font-size:9px; padding:0px; margin:0px ">{{ $pat_name != '' ? $pat_name : '' }} <br> <span>UHID:{{$label_info->patient_code}}</span> 
    <small> , 
                        @if($label_info->gender=="Male")
                            M 
                        @elseif($label_info->gender=="Female")
                            F 
                        @else 
                            O 
                        @endif
                    </small>
    </span>
    {{-- end  --}}

    @else
    <img style="margin-bottom:3px " src="data:image/png;base64, {{ $lab_no_barcode }} " width="80%" height="30px" /><br>
    @if (isset($label_info))
    <span style=" font-size:9px; padding:0px; margin:0px "> Lab No :
        {{ $label_info->lab_code }}</span>
    <br>
    <span style=" font-size:9px; padding:0px; margin:0px ; "> INV:{{ $label_info->invoice_code_sl }}</span>,<span style=" font-size:9px; padding:0px; margin:0px ">Age:{{ $label_info->age }}</span><br>
    @php
    $item_code = explode(',', $label_info->item_code_list);

    @endphp
    @if (isset($item_code[0]))
    @if ($item_code[0] == 'OGTT')
    @php
    $item_name = explode(',', $label_info->test_short_name_list);

    @endphp
    <span style=" font-size:9px; padding:0px; margin:0px ">
        @if (Session::get('user.ses_hospital_code') == 'GMC')
        {{ isset($item_name[0]) ? $item_name[0] : '' }}
        @endif

        @if ($label_info->coll_seq == 1)
        OGTT (FBS)
        @endif
    </span>
    @elseif ($item_code[0] == 'OGTT-2')
    <span style=" font-size:9px; padding:0px; margin:0px ">
        @if (Session::get('user.ses_hospital_code') == 'GMC')
        {{ isset($item_name[0]) ? $item_name[0] : '' }}
        @endif

        @if ($label_info->coll_seq == 1)
        OGTT (FBS)
        @endif

        @if ($label_info->coll_seq == 2)
        @if(Session::get('user.ses_hospital_code') == "IMPERIAL") OGTT (2 hours) @else OGTT (2 hrs 75gm) @endif
        @endif
    </span>
    @elseif ($item_code[0] == 'OGTT-3')
    <span style=" font-size:9px; padding:0px; margin:0px ">
        @if (Session::get('user.ses_hospital_code') == 'GMC')
        {{ isset($item_name[0]) ? $item_name[0] : '' }}
        @endif

        @if ($label_info->coll_seq == 1)
        OGTT (FBS)
        @endif

        @if ($label_info->coll_seq == 2)
        @if(Session::get('user.ses_hospital_code') == "IMPERIAL") OGTT (1 hour) @else OGTT (1 hrs 75gm) @endif

        @endif
        @if ($label_info->coll_seq == 3)
        @if(Session::get('user.ses_hospital_code') == "IMPERIAL") OGTT (2 hours) @else OGTT (2 hrs 75gm) @endif
        @endif
    </span>
    @else
    <span style=" font-size:9px; padding:0px; margin:0px ">{{ $label_info->test_short_name_list }}</span>
    @endif
    @else
    <span style=" font-size:9px; padding:0px; margin:0px ">{{ $label_info->test_short_name_list }}</span>
    @endif
    <br>
    <span style=" font-size:9px; padding:0px; margin:0px ">{{ $label_info->sc_sample_coll_keyed_time != '' ? date('d/m/Y h:i:s a', strtotime($label_info->sc_sample_coll_keyed_time)) : $cur_date }}</span>
    <br>
    <span style=" font-size:9px; padding:0px; margin:0px ">{{ $pat_name != '' ? $pat_name : '' }} <br> <span>UHID:{{$label_info->patient_code}}</span> 
    <small> , 
                        @if($label_info->gender=="Male")
                            M 
                        @elseif($label_info->gender=="Female")
                            F 
                        @else 
                            O 
                        @endif
                    </small>
    </span>
    @endif


    @endif
    {{-- @endif --}}




</body>

</html>