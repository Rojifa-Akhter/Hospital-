<!DOCTYPE html>
<html>
<head>
    <style>
        @page {
            margin: 5px 0px;
            size: 80mm 50mm;
        }
        body {
            margin: 0;
            font-family: 'IBM Plex Sans', Helvetica, Arial, sans-serif;
            font-size: 10px;
            line-height: 150%;
        }
        .hospital-header {
            border-bottom: 1px solid black;
            padding-top: 2px;
            text-align: center;
            margin-bottom: 5px;
        }
        .meal-header {
            padding-top: 2px;
            text-align: center;
            margin-bottom: 5px;
        }

        .section {
            border: 1px solid black;
            /* height: 50mm; */
            padding: 5px;
            margin-bottom: 5px;
            page-break-inside: avoid;
        }
    </style>
</head>
@php
    $hospital = DB::table('wsec_hospital')
        ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
        ->first();
@endphp
<body onload="window.print()">

@if(!empty($data))
    <section class="section">
        <div class="hospital-header">
            <span style="font-size: 12px;">
                <strong>{{ $hospital->hospital_name ?? '' }}</strong>
            </span>
        </div>
        <div class="meal-header">
            <span style="font-size: 10px;">
                <strong>Patient Meal Details</strong>
            </span>
        </div>

        <div><strong>Bed: <span style="text-decoration:underline;">{{ $data->new_bed_name }}</span></strong></div>
        <div><strong>Diet type: <span style="text-decoration:underline">{{ $data->remarks }}</span>  </strong></div>
        <div><strong>Meal type:</strong> {{ $cafeteria[$data->category] ?? $data->category }}</div>
        <div><strong>IP:</strong> {{ $data->admission_no_pk }} ,<strong>Ward:</strong> {{ $data->new_ward_name }}</div>
        <div><strong>UHID:</strong> {{ $data->patient_no_fk }} , <strong>Patient Name:</strong> {{ $data->patient_name }}</div>
        <div><strong>Admission Date & Time:</strong> {{ date('d/m/Y h:i a', strtotime($data->admission_date)) }}</div>
        <div><strong>Doctor Name:</strong> {{ $data->primary_doctor_name }}</div>
        <div><strong>Meal Date & Time:</strong> {{ date('d/m/Y h:i a', strtotime($data->search_date)) }}</div>
        <div><strong>Printing Date:</strong> {{ date('d/m/Y h:i a') }}</div>
    </section>
@endif

</body>
</html>
