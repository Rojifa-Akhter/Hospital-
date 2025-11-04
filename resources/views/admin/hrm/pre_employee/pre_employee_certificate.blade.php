<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Pre Employment Health Checkup Certificate</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="" />
    <!-- custom style -->

    <style>
        /* @page {
            padding-bottom: 100px;
        } */

        @font-face {
            font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
            font-weight: normal;
            font-size: 10px;
            font-style: normal;
            font-variant: normal;
            src: url("font url");
        }

        body {
            font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
            font-size: 17px;
            padding: 0px 30px;
        }
/* 
        footer {
        position: fixed;
        z-index: 999999999;

        left: 0;
        right: 0;
        height: 3cm;
        text-align: center;
        font-size: 9px;
        bottom: -100px;

        padding-top: 10px;
    } */

        /* .signature_ {
            position: fixed;
            bottom: 1.6cm;
            left: .8cm;
            right: .8cm;
            width: 100%;
        }

        .tr_border td,
        .tr_border th {
            border: 1px solid #222;
        } */
    </style>

</head>
<body>
    <div class="top_wrap" style="margin-top:105px">
        <?php 
        $certificate_date = isset($certificateData[0]->certificate_date) ? date('d/m/Y', strtotime($certificateData[0]->certificate_date)): "";
        $au_update_at = isset($certificateData[0]->au_update_at) ? date('d/m/Y', strtotime($certificateData[0]->au_update_at)): "" ;
        ?>
        <p style="float:left"><strong>Date: </strong>{{ isset($certificateData[0]->au_update_at) ? $au_update_at : $certificate_date  }}</p>
        <p style="float:right"><strong>Certificate No: </strong> {{ isset($certificateData[0]->cerificate_code) ? $certificateData[0]->cerificate_code : "" }}</p>
    </div>
    <div style="text-align:center; padding-top: 14px; clear:both">
        <h2 style="font-size: 21px">PRE-EMPLOYMENT HEALTH CHECKUP CERTIFICATE</h2>    
    </div>
    <div style="text-align:left; margin-top:60px;">
       <p>This is to certify that {{$certificateData[0]->gender_lookup_no_fk == "3002115" ? "Mr. " : ($certificateData[0]->gender_lookup_no_fk == "6" ? "Ms. " : "")}} {{ucwords(strtolower($certificateData[0]->full_name))}}, Aged: {{$certificateData[0]->pat_age}}, UHID: {{$certificateData[0]->patient_code}} has been examined as part of the pre-employment health checkup to determine {{$certificateData[0]->gender_lookup_no_fk == "3002115" ? "his " : ($certificateData[0]->gender_lookup_no_fk == "6" ? "her " : "")}} medical fitness for employment at Unico Hospitals PLC. </p> 
    </div>
    <?php 
    
    ?>
    <div style="text-align:left; margin-top:35px;">
       <p>Based on the examination and reports, I certify that {{$certificateData[0]->gender_lookup_no_fk == "3002115" ? "Mr. " : ($certificateData[0]->gender_lookup_no_fk == "6" ? "Ms. " : "")}} {{ucwords(strtolower($certificateData[0]->full_name))}} is: </p> 
       <div class="form-check">
        <input class="form-check-input" type="checkbox" value="" <?= isset($certificateData[0]->emp_status) &&  $certificateData[0]->emp_status == "Medically Fit" ? "checked" : "" ?>>
        <label class="form-check-label" for="flexCheckDefault">
            Medically Fit
        </label>
      </div>
       <div class="form-check">
        <input class="form-check-input" type="checkbox" value="" <?= isset($certificateData[0]->emp_status) &&  $certificateData[0]->emp_status == "Unfit" ? "checked" : "" ?>>
        <label class="form-check-label" for="flexCheckDefault">
            Unfit
        </label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="checkbox" value="" <?= isset($certificateData[0]->emp_status) &&  $certificateData[0]->emp_status == "Temporary Unfit" ? "checked" : "" ?>>
        <label class="form-check-label" for="flexCheckChecked">
        Temporarily Unfit 
        </label>
      </div>
       <p>
            @if(isset($certificateData[0]->remarks) )
                <strong>Reamrks: </strong>
            @endif
            {{isset($certificateData[0]->remarks) ? $certificateData[0]->remarks : ""}}
       </p>
    </div>
    <div class="signature" style="margin-top:150px">
        <p style="{{ !isset($doctor_signature_image) ? 'margin-bottom: 55px' : '' }}">
            Approved By
        </p>
        @if (isset($doctor_signature_image))
            <img src="{{ asset('images/uploads/doctor_images/thumb/' . $doctor_signature_image) }}"
            alt="image" style="width: 120px;height:30px">
        @endif
        <?php
            $cleanedSignature = str_replace('<br>Unico Hospital Limited', '', $doctor_signature);
        ?>
        {!! $cleanedSignature !!} 
    </div>
        
    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>

</html>
