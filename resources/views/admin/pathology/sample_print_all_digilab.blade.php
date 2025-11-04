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

<body>
    @php

        date_default_timezone_set('Asia/Dhaka');
        // $time = Carbon::now();
        $cur_date = date('d/m/Y h:i:s');
    @endphp
    @if (!empty($barcode))
        @php
            $sl = 0;
        @endphp

        @foreach ($barcode as $bar)
            @php
                $pat_name = '';
                if ($bar->patient_name != '' && isset($bar->patient_name)) {
                    if (Str::length($bar->patient_name) > 16) {
                        $pat_name = substr($bar->patient_name, 0, -(Str::length($bar->patient_name) - 16));
                        $pat_name = substr($bar->patient_name, 0, -(Str::length($bar->patient_name) - 16));
                    } else {
                        $pat_name = $bar->patient_name;
                    }
                }
                if ($bar->test_short_name_list == 'CBC-PBF, PBF') {
                    $sl += 1;
                }
            @endphp
           
            @if ($bar->test_short_name_list == 'CBC')
            @if ($hospital->hospital_code == 'DMHL')
            <div  style="padding-top: 13px;">
            <span style=" font-size:9px; padding:0px; margin:0px ">{{ $pat_name != '' ? $pat_name : '' }} <br>
                <span>UHID:{{$bar->patient_code}}</span>
            <small>
                        @if($bar->gender=="Male")
                           , M 
                        @elseif($bar->gender=="Female")
                           , F 
                        @else 
                           , O 
                        @endif
                    </small>
            </span><br>
                <span style=" font-size:9px; padding:0px; margin:0px ; ">INV:{{ $bar->invoice_code_sl }}</span>,<span style=" font-size:9px; padding:0px; margin:0px ">Age:{{ $bar->age }}</span><br>
                <img style="margin-bottom:3px;  " src="data:image/png;base64, {{ $bar->barcode }} " width="80%"
                    height="30px" /><br>
                    <span style=" font-size:9px; padding:0px; margin:0px "> Lab Code : {{ $bar->lab_code }}</span> <br>
                <span style=" font-size:9px; padding:0px; margin:0px ">CBC</span>,
                <span
                    style=" font-size:9px; padding:0px; margin:0px ">{{ $bar->sc_sample_coll_keyed_time != '' ? date('d/m/Y h:i:s a', strtotime($bar->sc_sample_coll_keyed_time)) : $cur_date }}</span>
                
               
             @else
             <div>
             <img style="margin-bottom:3px;  " src="data:image/png;base64, {{ $bar->barcode }} " width="80%"
                    height="30px" /><br>
                <span style=" font-size:9px; padding:0px; margin:0px "> Lab Code : {{ $bar->lab_code }}</span> <br>
                <span style=" font-size:9px; padding:0px; margin:0px ; ">INV:{{ $bar->invoice_code_sl }}</span>,<span style=" font-size:9px; padding:0px; margin:0px ">Age:{{ $bar->age }}</span><br>
              
                <span style=" font-size:9px; padding:0px; margin:0px ">CBC</span><br>
                <span
                    style=" font-size:9px; padding:0px; margin:0px ">{{ $bar->sc_sample_coll_keyed_time != '' ? date('d/m/Y h:i:s a', strtotime($bar->sc_sample_coll_keyed_time)) : $cur_date }}</span>
                <br>
                <span style=" font-size:9px; padding:0px; margin:0px ">{{ $pat_name != '' ? $pat_name : '' }} <br>
                    <span>UHID:{{$bar->patient_code}}</span>
                    
                </span>
             
             @endif
                @if ($hospital->hospital_code != 'IMPERIAL')             
                <div class="page-break" ></div>
                </div>

                @if ($hospital->hospital_code == 'DMHL')
                <div  style="padding-top: 13px;">
                <span style=" font-size:9px; padding:0px; margin:0px ">{{ $pat_name != '' ? $pat_name : '' }} <br>
                    <span>UHID:{{$bar->patient_code}}</span>
                    
                </span>  
                   <br>
                    <span style=" font-size:9px; padding:0px; margin:0px ; ">INV:{{ $bar->invoice_code_sl }}</span>,<span style=" font-size:9px; padding:0px; margin:0px ">Age:{{ $bar->age }}</span>
                    <br>
                    <img style="margin-bottom:3px;  " src="data:image/png;base64, {{ $bar->barcode }} " width="80%"
                        height="30px" /><br>
                        <span style=" font-size:9px; padding:0px; margin:0px "> Lab Code : {{ $bar->lab_code }}</span><br>
                    <span style=" font-size:9px; padding:0px; margin:0px ">ESR</span>,
                    <span
                        style=" font-size:9px; padding:0px; margin:0px ">{{ $bar->sc_sample_coll_keyed_time != '' ? date('d/m/Y h:i:s a', strtotime($bar->sc_sample_coll_keyed_time)) : $cur_date }}</span>
                  
                                        
                 @else
                    <div>
                    <img style="margin-bottom:3px;  " src="data:image/png;base64, {{ $bar->barcode }} " width="80%"
                        height="30px" /><br>
                    <span style=" font-size:9px; padding:0px; margin:0px "> Lab Code : {{ $bar->lab_code }}</span> <br>
                    <span style=" font-size:9px; padding:0px; margin:0px ; ">INV:{{ $bar->invoice_code_sl }}</span>,<span style=" font-size:9px; padding:0px; margin:0px ">Age:{{ $bar->age }}</span>
                    <br>
                
                    <span style=" font-size:9px; padding:0px; margin:0px ">ESR</span><br>
                    <span
                        style=" font-size:9px; padding:0px; margin:0px ">{{ $bar->sc_sample_coll_keyed_time != '' ? date('d/m/Y h:i:s a', strtotime($bar->sc_sample_coll_keyed_time)) : $cur_date }}</span>
                    <br>
                    <span
                        style=" font-size:9px; padding:0px; margin:0px ">{{ $pat_name != '' ? $pat_name : '' }} <br>
                        <span>UHID:{{$bar->patient_code}}</span>
                        
                    </span>           

                        @endif
                @endif
               
                
            @elseif ($bar->test_short_name_list == 'CBC-PBF, PBF')
                @if ($sl == 1)
                    <img style="margin-bottom:3px;  " src="data:image/png;base64, {{ $bar->barcode }} " width="80%"
                        height="30px" /><br>

                    <span style=" font-size:9px; padding:0px; margin:0px "> Lab Code : {{ $bar->lab_code }}</span>
                    <br>
                    <span style=" font-size:9px; padding:0px; margin:0px ; ">INV:{{ $bar->invoice_code_sl }}</span>, <span style=" font-size:9px; padding:0px; margin:0px ">Age:{{ $bar->age }}</span><br>

                    <span style=" font-size:9px; padding:0px; margin:0px ">CBC , PBF</span><br>
                    <span
                        style=" font-size:9px; padding:0px; margin:0px ">{{ $bar->sc_sample_coll_keyed_time != '' ? date('d/m/Y h:i:s a', strtotime($bar->sc_sample_coll_keyed_time)) : $cur_date }}</span>
                    <br>
                    <span
                        style=" font-size:9px; padding:0px; margin:0px ">{{ $pat_name != '' ? $pat_name : '' }} <br>
                        <span>UHID:{{$bar->patient_code}}</span>
                        
                    </span>
                    <div class="page-break"></div>

                    <img style="margin-bottom:3px;  " src="data:image/png;base64, {{ $bar->barcode }} " width="80%"
                        height="30px" /><br>

                    <span style=" font-size:9px; padding:0px; margin:0px "> Lab Code : {{ $bar->lab_code }}</span>
                    <br>
                    <span style=" font-size:9px; padding:0px; margin:0px ; ">INV:{{ $bar->invoice_code_sl }}</span>,<span style=" font-size:9px; padding:0px; margin:0px ">Age:
                        @php

                            $pat_dob = new \DateTime($bar->dob);
                            $invoice_date = new \DateTime($bar->invoice_date);
                            $interval = $invoice_date->diff($pat_dob);
                        @endphp

                        {{ $interval->format('%yY %mM %dD') }}

                    </span><br>

                    <span style=" font-size:9px; padding:0px; margin:0px ">ESR</span><br>
                    <span
                        style=" font-size:9px; padding:0px; margin:0px ">{{ $bar->sc_sample_coll_keyed_time != '' ? date('d/m/Y h:i:s a', strtotime($bar->sc_sample_coll_keyed_time)) : $cur_date }}</span>
                    <br>
                    <span
                        style=" font-size:9px; padding:0px; margin:0px ">{{ $pat_name != '' ? $pat_name : '' }} <br>
                        <span>UHID:{{$bar->patient_code}}</span>
                        
                    </span>
                    @php
                        return;
                    @endphp
                @endif
            @elseif ($bar->test_short_name_list == 'FBS&2hABF')
                <img style="margin-bottom:3px;  " src="data:image/png;base64, {{ $bar->barcode }} " width="80%"
                    height="30px" /><br>

                <span style=" font-size:9px; padding:0px; margin:0px "> Lab Code : {{ $bar->lab_code }}</span> <br>
                <span style=" font-size:9px; padding:0px; margin:0px ; ">INV:{{ $bar->invoice_code_sl }}</span>,<span style=" font-size:9px; padding:0px; margin:0px ">Age:{{ $bar->age }}</span><br>

                <span style=" font-size:9px; padding:0px; margin:0px ">FBS</span><br>
                <span
                    style=" font-size:9px; padding:0px; margin:0px ">{{ $bar->sc_sample_coll_keyed_time != '' ? date('d/m/Y h:i:s a', strtotime($bar->sc_sample_coll_keyed_time)) : $cur_date }}</span>
                <br>
                <span style=" font-size:9px; padding:0px; margin:0px ">{{ $pat_name != '' ? $pat_name : '' }} <br>
                    <span>UHID:{{$bar->patient_code}}</span>
                   
                </span>
                <div class="page-break"></div>

                <img style="margin-bottom:3px;  " src="data:image/png;base64, {{ $bar->barcode }} " width="80%"
                    height="30px" /><br>

                <span style=" font-size:9px; padding:0px; margin:0px "> Lab Code : {{ $bar->lab_code }}</span> <br>
                <span style=" font-size:9px; padding:0px; margin:0px ; ">INV:{{ $bar->invoice_code_sl }}</span>,<span style=" font-size:9px; padding:0px; margin:0px ">Age:{{ $bar->age }}</span><br>

                <span style=" font-size:9px; padding:0px; margin:0px ">CF</span><br>
                <span
                    style=" font-size:9px; padding:0px; margin:0px ">{{ $bar->sc_sample_coll_keyed_time != '' ? date('d/m/Y h:i:s a', strtotime($bar->sc_sample_coll_keyed_time)) : $cur_date }}</span>
                <br>
                <span style=" font-size:9px; padding:0px; margin:0px ">{{ $pat_name != '' ? $pat_name : '' }} <br>
                    <span>UHID:{{$bar->patient_code}}</span>
                    
                </span>
                <img style="margin-bottom:3px;  " src="data:image/png;base64, {{ $bar->barcode }} " width="80%"
                    height="30px" /><br>

                <span style=" font-size:9px; padding:0px; margin:0px "> Lab Code : {{ $bar->lab_code }}</span> <br>
                <span style=" font-size:9px; padding:0px; margin:0px ; ">INV:{{ $bar->invoice_code_sl }}</span>,<span style=" font-size:9px; padding:0px; margin:0px ">Age:{{ $bar->age }}</span><br>

                <span style=" font-size:9px; padding:0px; margin:0px ">2HABF</span><br>
                <span
                    style=" font-size:9px; padding:0px; margin:0px ">{{ $bar->sc_sample_coll_keyed_time != '' ? date('d/m/Y h:i:s a', strtotime($bar->sc_sample_coll_keyed_time)) : $cur_date }}</span>
                <br>
                <span style=" font-size:9px; padding:0px; margin:0px ">{{ $pat_name != '' ? $pat_name : '' }} <br>
                    <span>UHID:{{$bar->patient_code}}</span>
                    
                </span>
                <img style="margin-bottom:3px;  " src="data:image/png;base64, {{ $bar->barcode }} " width="80%"
                    height="30px" /><br>

                <span style=" font-size:9px; padding:0px; margin:0px "> Lab Code : {{ $bar->lab_code }}</span> <br>
                <span style=" font-size:9px; padding:0px; margin:0px ; ">INV:{{ $bar->invoice_code_sl }}</span>,<span style=" font-size:9px; padding:0px; margin:0px ">Age:{{ $bar->age }}</span><br>

                <span style=" font-size:9px; padding:0px; margin:0px ">C2HABF</span><br>
                <span
                    style=" font-size:9px; padding:0px; margin:0px ">{{ $bar->sc_sample_coll_keyed_time != '' ? date('d/m/Y h:i:s a', strtotime($bar->sc_sample_coll_keyed_time)) : $cur_date }}</span>
                <br>
                <span style=" font-size:9px; padding:0px; margin:0px ">{{ $pat_name != '' ? $pat_name : '' }} <br>
                    <span>UHID:{{$bar->patient_code}}</span>
                    
                </span>
            @elseif ($bar->test_short_name_list == '2h-ABF-CUS, FBSC')
                <img style="margin-bottom:3px;  " src="data:image/png;base64, {{ $bar->barcode }} " width="80%"
                    height="30px" /><br>

                <span style=" font-size:9px; padding:0px; margin:0px "> Lab Code : {{ $bar->lab_code }}</span> <br>
                <span style=" font-size:9px; padding:0px; margin:0px ; ">INV:{{ $bar->invoice_code_sl }}</span>,<span style=" font-size:9px; padding:0px; margin:0px ">Age:{{ $bar->age }}</span><br>

                <span style=" font-size:9px; padding:0px; margin:0px ">FBS</span><br>
                <span
                    style=" font-size:9px; padding:0px; margin:0px ">{{ $bar->sc_sample_coll_keyed_time != '' ? date('d/m/Y h:i:s a', strtotime($bar->sc_sample_coll_keyed_time)) : $cur_date }}</span>
                <br>
                <span style=" font-size:9px; padding:0px; margin:0px ">{{ $pat_name != '' ? $pat_name : '' }} <br>
                    <span>UHID:{{$bar->patient_code}}</span>
                    
                </span>
                <div class="page-break"></div>

                <img style="margin-bottom:3px;  " src="data:image/png;base64, {{ $bar->barcode }} " width="80%"
                    height="30px" /><br>

                <span style=" font-size:9px; padding:0px; margin:0px "> Lab Code : {{ $bar->lab_code }}</span> <br>
                <span style=" font-size:9px; padding:0px; margin:0px ; ">INV:{{ $bar->invoice_code_sl }}</span>,<span style=" font-size:9px; padding:0px; margin:0px ">Age:{{ $bar->age }}</span><br>

                <span style=" font-size:9px; padding:0px; margin:0px ">CF</span><br>
                <span
                    style=" font-size:9px; padding:0px; margin:0px ">{{ $bar->sc_sample_coll_keyed_time != '' ? date('d/m/Y h:i:s a', strtotime($bar->sc_sample_coll_keyed_time)) : $cur_date }}</span>
                <br>
                <span style=" font-size:9px; padding:0px; margin:0px ">{{ $pat_name != '' ? $pat_name : '' }} <br>
                    <span>UHID:{{$bar->patient_code}}</span>
                    
                </span>
                <img style="margin-bottom:3px;  " src="data:image/png;base64, {{ $bar->barcode }} " width="80%"
                    height="30px" /><br>

                <span style=" font-size:9px; padding:0px; margin:0px "> Lab Code : {{ $bar->lab_code }}</span> <br>
                <span style=" font-size:9px; padding:0px; margin:0px ; ">INV:{{ $bar->invoice_code_sl }}</span>,<span style=" font-size:9px; padding:0px; margin:0px ">Age:{{ $bar->age }}</span><br>

                <span style=" font-size:9px; padding:0px; margin:0px ">2HABF</span><br>
                <span
                    style=" font-size:9px; padding:0px; margin:0px ">{{ $bar->sc_sample_coll_keyed_time != '' ? date('d/m/Y h:i:s a', strtotime($bar->sc_sample_coll_keyed_time)) : $cur_date }}</span>
                <br>
                <span
                    style=" font-size:9px; padding:0px; margin:0px ">{{ $pat_name != '' ? $pat_name : '' }} <br>
                    <span>UHID:{{$bar->patient_code}}</span>
                    
                </span>
                <img style="margin-bottom:3px;  " src="data:image/png;base64, {{ $bar->barcode }} " width="80%"
                    height="30px" /><br>

                <span style=" font-size:9px; padding:0px; margin:0px "> Lab Code : {{ $bar->lab_code }}</span> <br>
                <span style=" font-size:9px; padding:0px; margin:0px ; ">INV:{{ $bar->invoice_code_sl }}</span>,<span style=" font-size:9px; padding:0px; margin:0px ">Age:{{ $bar->age }}</span><br>

                <span style=" font-size:9px; padding:0px; margin:0px ">C2HABF</span><br>
                <span
                    style=" font-size:9px; padding:0px; margin:0px ">{{ $bar->sc_sample_coll_keyed_time != '' ? date('d/m/Y h:i:s a', strtotime($bar->sc_sample_coll_keyed_time)) : $cur_date }}</span>
                <br>
                <span
                    style=" font-size:9px; padding:0px; margin:0px ">{{ $pat_name != '' ? $pat_name : '' }} <br>
                    <span>UHID:{{$bar->patient_code}}</span>
                    
                </span>
            @elseif ($bar->test_short_name_list == '2h-ABF-CUS')
                <img style="margin-bottom:3px;  " src="data:image/png;base64, {{ $bar->barcode }} " width="80%"
                    height="30px" /><br>

                <span style=" font-size:9px; padding:0px; margin:0px "> Lab Code : {{ $bar->lab_code }}</span> <br>
                <span style=" font-size:9px; padding:0px; margin:0px ; ">INV:{{ $bar->invoice_code_sl }}</span>,<span style=" font-size:9px; padding:0px; margin:0px ">Age:{{ $bar->age }}</span><br>

                <span style=" font-size:9px; padding:0px; margin:0px ">2HABF</span><br>
                <span
                    style=" font-size:9px; padding:0px; margin:0px ">{{ $bar->sc_sample_coll_keyed_time != '' ? date('d/m/Y h:i:s a', strtotime($bar->sc_sample_coll_keyed_time)) : $cur_date }}</span>
                <br>
                <span
                    style=" font-size:9px; padding:0px; margin:0px ">{{ $pat_name != '' ? $pat_name : '' }} <br>
                    <span>UHID:{{$bar->patient_code}}</span>
                    
                </span>
                <img style="margin-bottom:3px;  " src="data:image/png;base64, {{ $bar->barcode }} " width="80%"
                    height="30px" /><br>

                <span style=" font-size:9px; padding:0px; margin:0px "> Lab Code : {{ $bar->lab_code }}</span> <br>
                <span style=" font-size:9px; padding:0px; margin:0px ; ">INV:{{ $bar->invoice_code_sl }}</span>,<span style=" font-size:9px; padding:0px; margin:0px ">Age:{{ $bar->age }}</span><br>

                <span style=" font-size:9px; padding:0px; margin:0px ">C2HABF</span><br>
                <span
                    style=" font-size:9px; padding:0px; margin:0px ">{{ $bar->sc_sample_coll_keyed_time != '' ? date('d/m/Y h:i:s a', strtotime($bar->sc_sample_coll_keyed_time)) : $cur_date }}</span>
                <br>
                <span
                    style=" font-size:9px; padding:0px; margin:0px ">{{ $pat_name != '' ? $pat_name : '' }} <br>
                    <span>UHID:{{$bar->patient_code}}</span>
                    
                </span>

                    @elseif ($bar->test_short_name_list == 'PBF')
                <img style="margin-bottom:3px;  " src="data:image/png;base64, {{ $bar->barcode }} " width="80%"
                    height="30px" /><br>

                <span style=" font-size:9px; padding:0px; margin:0px "> Lab Code : {{ $bar->lab_code }}</span> <br>
                <span style=" font-size:9px; padding:0px; margin:0px ; ">INV:{{ $bar->invoice_code_sl }}</span>,<span style=" font-size:9px; padding:0px; margin:0px ">Age:{{ $bar->age }}</span><br>

                <span style=" font-size:9px; padding:0px; margin:0px ">PBF</span><br>
                <span
                    style=" font-size:9px; padding:0px; margin:0px ">{{ $bar->sc_sample_coll_keyed_time != '' ? date('d/m/Y h:i:s a', strtotime($bar->sc_sample_coll_keyed_time)) : $cur_date }}</span>
                {{-- <br> --}}
                <span
                    style=" font-size:9px; padding:0px; margin:0px ">{{ $pat_name != '' ? $pat_name : '' }} <br>
                    <span>UHID:{{$bar->patient_code}}</span>
                    
                </span>
                <img style="margin-bottom:3px;  " src="data:image/png;base64, {{ $bar->barcode }} " width="80%"
                    height="30px" /><br>

                <span style=" font-size:9px; padding:0px; margin:0px "> Lab Code : {{ $bar->lab_code }}</span> <br>
                <span style=" font-size:9px; padding:0px; margin:0px ; ">INV:{{ $bar->invoice_code_sl }}</span>,<span style=" font-size:9px; padding:0px; margin:0px ">Age:{{ $bar->age }}</span><br>

                <span style=" font-size:9px; padding:0px; margin:0px ">ESR</span><br>
                <span
                    style=" font-size:9px; padding:0px; margin:0px ">{{ $bar->sc_sample_coll_keyed_time != '' ? date('d/m/Y h:i:s a', strtotime($bar->sc_sample_coll_keyed_time)) : $cur_date }}</span>
                <br>
                <span
                    style=" font-size:9px; padding:0px; margin:0px ">{{ $pat_name != '' ? $pat_name : '' }} <br>
                    <span>UHID:{{$bar->patient_code}}</span>
                    
                </span>
            @elseif ($bar->test_short_name_list == 'FBSC')
                <img style="margin-bottom:3px;  " src="data:image/png;base64, {{ $bar->barcode }} " width="80%"
                    height="30px" /><br>

                <span style=" font-size:9px; padding:0px; margin:0px "> Lab Code : {{ $bar->lab_code }}</span> <br>
                <span style=" font-size:9px; padding:0px; margin:0px ; ">INV:{{ $bar->invoice_code_sl }}</span>,<span style=" font-size:9px; padding:0px; margin:0px ">Age:{{ $bar->age }}</span><br>

                <span style=" font-size:9px; padding:0px; margin:0px ">FBS</span><br>
                <span
                    style=" font-size:9px; padding:0px; margin:0px ">{{ $bar->sc_sample_coll_keyed_time != '' ? date('d/m/Y h:i:s a', strtotime($bar->sc_sample_coll_keyed_time)) : $cur_date }}</span>
                <br>
                <span
                    style=" font-size:9px; padding:0px; margin:0px ">{{ $pat_name != '' ? $pat_name : '' }} <br>
                    <span>UHID:{{$bar->patient_code}}</span>
                    
                </span>
                <div class="page-break"></div>

                <img style="margin-bottom:3px;  " src="data:image/png;base64, {{ $bar->barcode }} " width="80%"
                    height="30px" /><br>

                <span style=" font-size:9px; padding:0px; margin:0px "> Lab Code : {{ $bar->lab_code }}</span> <br>
                <span style=" font-size:9px; padding:0px; margin:0px ; ">INV:{{ $bar->invoice_code_sl }}</span>,<span style=" font-size:9px; padding:0px; margin:0px ">Age:{{ $bar->age }}</span><br>

                <span style=" font-size:9px; padding:0px; margin:0px ">CF</span><br>
                <span
                    style=" font-size:9px; padding:0px; margin:0px ">{{ $bar->sc_sample_coll_keyed_time != '' ? date('d/m/Y h:i:s a', strtotime($bar->sc_sample_coll_keyed_time)) : $cur_date }}</span>
                <br>
                <span
                    style=" font-size:9px; padding:0px; margin:0px ">{{ $pat_name != '' ? $pat_name : '' }} <br>
                    <span>UHID:{{$bar->patient_code}}</span>
                    
                </span>

                    @elseif ($bar->test_short_name_list == '2h-ABF, FBS')
                <img style="margin-bottom:3px;  " src="data:image/png;base64, {{ $bar->barcode }} " width="80%"
                    height="30px" /><br>

                <span style=" font-size:9px; padding:0px; margin:0px "> Lab Code : {{ $bar->lab_code }}</span> <br>
                <span style=" font-size:9px; padding:0px; margin:0px ; ">INV:{{ $bar->invoice_code_sl }}</span>,<span style=" font-size:9px; padding:0px; margin:0px ">Age:{{ $bar->age }}</span><br>

                <span style=" font-size:9px; padding:0px; margin:0px ">FBS-CUS</span><br>
                <span
                    style=" font-size:9px; padding:0px; margin:0px ">{{ $bar->sc_sample_coll_keyed_time != '' ? date('d/m/Y h:i:s a', strtotime($bar->sc_sample_coll_keyed_time)) : $cur_date }}</span>
                <br>
                <span
                    style=" font-size:9px; padding:0px; margin:0px ">{{ $pat_name != '' ? $pat_name : '' }} <br>
                    <span>UHID:{{$bar->patient_code}}</span>
                    
                </span>
                <div class="page-break"></div>

                <img style="margin-bottom:3px;  " src="data:image/png;base64, {{ $bar->barcode }} " width="80%"
                    height="30px" /><br>

                <span style=" font-size:9px; padding:0px; margin:0px "> Lab Code : {{ $bar->lab_code }}</span> <br>
                <span style=" font-size:9px; padding:0px; margin:0px ; ">INV:{{ $bar->invoice_code_sl }}</span>,<span style=" font-size:9px; padding:0px; margin:0px ">Age:{{ $bar->age }}</span><br>

                <span style=" font-size:9px; padding:0px; margin:0px ">2H-CUS</span><br>
                <span
                    style=" font-size:9px; padding:0px; margin:0px ">{{ $bar->sc_sample_coll_keyed_time != '' ? date('d/m/Y h:i:s a', strtotime($bar->sc_sample_coll_keyed_time)) : $cur_date }}</span>
                <br>
                <span
                    style=" font-size:9px; padding:0px; margin:0px ">{{ $pat_name != '' ? $pat_name : '' }} <br>
                    <span>UHID:{{$bar->patient_code}}</span>
                   
                </span>

            @else
                <img style="margin-bottom:3px;  " src="data:image/png;base64, {{ $bar->barcode }} " width="80%"
                    height="30px" /><br>

                <span style=" font-size:9px; padding:0px; margin:0px "> Lab Code : {{ $bar->lab_code }}</span> <br>
                <span style=" font-size:9px; padding:0px; margin:0px ; ">INV:{{ $bar->invoice_code_sl }}</span>,<span style=" font-size:9px; padding:0px; margin:0px ">Age:{{ $bar->age }}</span><br>

                @php
                    $item_code = explode(',', $bar->item_code_list);

                @endphp

                @if (isset($item_code[0]))
                    @if ($item_code[0] == 'OGTT')
                        @php
                            $item_name = explode(',', $bar->test_short_name_list);

                        @endphp
                        <span style=" font-size:9px; padding:0px; margin:0px ">
                            @if (Session::get('user.ses_hospital_code') == 'GMC')
                                {{ isset($item_name[0]) ? $item_name[0] : '' }}
                            @endif

                            @if ($bar->coll_seq == 1)
                            OGTT (FBS)
                            @endif
                        </span>
                    @elseif ($item_code[0] == 'OGTT-2')
                        <span style=" font-size:9px; padding:0px; margin:0px ">
                            @if (Session::get('user.ses_hospital_code') == 'GMC')
                                {{ isset($item_name[0]) ? $item_name[0] : '' }}
                            @endif

                            @if ($bar->coll_seq == 1)
                            OGTT (FBS)
                            @endif

                            @if ($bar->coll_seq == 2)
                           @if(Session::get('user.ses_hospital_code') == "IMPERIAL")  OGTT (2 hours) @else  OGTT (2 hrs 75gm)  @endif
                            @endif
                        </span>
                    @elseif ($item_code[0] == 'OGTT-3')
                        <span style=" font-size:9px; padding:0px; margin:0px ">
                            @if (Session::get('user.ses_hospital_code') == 'GMC')
                                {{ isset($item_name[0]) ? $item_name[0] : '' }}
                            @endif

                            @if ($bar->coll_seq == 1)
                            OGTT (FBS)
                            @endif

                            @if ($bar->coll_seq == 2)
                            @if(Session::get('user.ses_hospital_code') == "IMPERIAL")  OGTT (1 hour) @else  OGTT (1 hrs 75gm)  @endif
                            @endif
                            @if ($bar->coll_seq == 3)
                           @if(Session::get('user.ses_hospital_code') == "IMPERIAL")  OGTT (2 hours) @else  OGTT (2 hrs 75gm)  @endif
                            @endif
                        </span>
                    @else
                        <span
                            style=" font-size:9px; padding:0px; margin:0px ">{{ $bar->test_short_name_list }}</span>
                    @endif
                    <br>
                @else
                    <span style=" font-size:9px; padding:0px; margin:0px ">{{ $bar->test_short_name_list }}</span>
                @endif
                <span
                    style=" font-size:9px; padding:0px; margin:0px ">{{ $bar->sc_sample_coll_keyed_time != '' ? date('d/m/Y h:i:s a', strtotime($bar->sc_sample_coll_keyed_time)) : $cur_date }}</span>
                <br>
                <span
                    style=" font-size:9px; padding:0px; margin:0px ">{{ $pat_name != '' ? $pat_name : '' }} <br>
                    <span>UHID:{{$bar->patient_code}}</span>
                   
                </span>
            @endif
            @if ($loop->iteration != count($barcode))
                <div class="page-break"></div>
            @endif
           
        @endforeach
    @endif
</body>

</html>
