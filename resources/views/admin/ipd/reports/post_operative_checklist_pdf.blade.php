<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Pre-operative Checklist</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    {{-- <link rel="stylesheet" href="{{ public_path().'/css/print.css' }}" media="print"> --}}
    {{-- <link rel="stylesheet" href="{{ public_path().'css/purchase_order_print.css' }}" media="print"> --}}
    <style>
        @page {
            margin: .5cm .6cm;
            width: 100%;
            height: 100%
        }

        @font-face {
            font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
            font-weight: normal;
            font-size: 10px;
            font-style: normal;
            font-variant: normal;
            src: url("font url");
        }

        /** Define the header rules **/
        header {
            position: fixed;
            top: 0;
            height: 2cm;
            border-bottom: 1px solid;
            padding: 0 1cm;
        }

        header img {
            /*width: 80px;*/
        }

        /** Define now the real margins of every page in the PDF **/
        body {
            margin-top: 2cm;
            margin-left: .3cm;
            margin-right: .3cm;
            margin-bottom: 1cm;
            font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
            font-size: 14px;
        }

        footer {
            position: fixed;
            bottom: 0cm;
            left: 0cm;
            right: 0cm;
            height: .5cm;
            text-align: center;
            padding: 0 1cm;
            border-top: 1px solid;
        }

        .signature_ {
            position: fixed;
            bottom: 1.6cm;
            left: .8cm;
            right: .8cm;
            width: 100%;
            /* text-align: center; */

            /* border-top: 1px solid; */
        }

        tfoot tr td {
            font-weight: bold;
        }

        .page-break {
            page-break-after: always;
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

        .mb-5 {
            margin-bottom: 15px;
        }

        .pb-0 {
            padding-bottom: 0;
        }

        th,
        td {
            padding-left: 5px;
            padding-right: 5px;
        }

        .info td {
            border: 1px solid rgb(177, 175, 175);
        }

        li {
            font-size: 25px;
        }
    </style>
</head>

<body>
    <header>
        <table style="width: 100%; border:none;" class="signature">
            <tr>
                <td style="width: 15%; border:none;">
                    <img class="hospital-logo"
                        src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}"
                        width="60" alt="">
                </td>
                <td style="text-align:center; border:none;">
                    <span style="font-size: 15px;"> <strong>
                            {{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }}
                        </strong></span>
                    <br>
                    Address:
                    <span>
                        {{ isset($po_hospital_details->addrress1) ? $po_hospital_details->addrress1 : '' }}</span><br>
                    Phone No:
                    <span>
                        {{ isset($po_hospital_details->telephone1) ? $po_hospital_details->telephone1 : '' }}</span>
                </td>
                <td style=" text-align:right; width: 15%;  border:none;">
                    <div style="">
                        <img src="data:image/png;base64, {{ $barcode_no }} " width="100" />
                    </div>

                </td>
            </tr>
        </table>
    </header>

    <footer style="position: fixed;">
        <div class="footer">
            <div class="container">
                <table style="width: 100%; padding:3px; margin: 0;border:none;">
                    <tr>
                        <td style="font-size: 9px; text-align:left;border:none;">Print Date & Time: <strong>
                                <?php
                                $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
                                $date = $dt->format('g:i A');
                                ?>
                                {{ date('d/m/Y') }} {{ $date }}
                            </strong> Printed By: <strong>{{ Session::get('user.ses_user_name') }}</strong></td>
                        <td style="font-size: 9px; text-align: right; border:none;"><strong>Powered By - H360 [NextGen]
                            </strong></td>
                    </tr>
                </table>
            </div>
        </div>
    </footer>

    <main>
        <div class="wrapper">
            <div style=" text-align:center; margin-bottom:5px; margin-top:20px  " class="mb-2">
                <span class="report-name" style="width:100%; font-size:20px ;  padding:10px;  "> <strong> Post
                        Anesthesia Instructions
                    </strong></span>
            </div>

            <section id="lp-items">
                <div class="container">
                    <div style="">
                        <h3>Patient Information</h3>
                    </div>
                    <div style="border: 1px solid rgb(177, 175, 175); border-radius: 5px;">
                        <table width="100%">
                            <tr>
                                <td>
                                    <div><strong>UHID</strong></div>
                                    {{ isset($pat_info->patient_code) ? $pat_info->patient_code : 'N/A' }}
                                </td>
                                {{-- <td>
                                    <div><strong>IP No</strong></div>
                                    {{ isset($pat_info->admission_uid) ? $pat_info->admission_uid : 'N/A' }}

                                </td> --}}
                                <td>
                                    <div> <strong>Patient Name </strong></div>
                                    <div>{{ isset($pat_info->patient_name) ? $pat_info->patient_name : 'N/A' }}</div>
                                </td>

                                <td>
                                    <div><strong>Age</strong></div>
                                    {{ isset($pat_info->age) ? $pat_info->age : 'N/A' }}
                                </td>
                                <td>
                                    <div><strong>Sex</strong></div>
                                    {{ isset($pat_info->gender_txt) ? $pat_info->gender_txt : 'N/A' }}
                                </td>
                                 <td>
                                    <div><strong>Reg. Date</strong></div>
                                    {{ isset($pat_info->reg_date) ? date('Y-m-d', strtotime($pat_info->reg_date)) : date('Y-m-d') }}
                                </td>
                                <td>
                                    <strong>Consultant</strong>
                                    <div>
                                        {{ isset($pre_operative_checklist->doctor_name) ? $pre_operative_checklist->doctor_name : 'N/A' }}
                                    </div>
                                </td>


                            </tr>
                            {{-- <tr>
                                <td>
                                    <div><strong>Cabin</strong></div>
                                    {{ isset($pat_info->new_ward_name) ? $pat_info->new_ward_name : 'N/A' }}
                                </td>
                                <td>
                                    <div><strong>Bed Category</strong></div>
                                    {{ isset($pat_info->new_bed_name) ? $pat_info->new_bed_name : 'N/A' }}
                                </td>

                                 <td>
                                    <div> <strong> Department </strong></div>
                                    <div>{{ isset($pat_info->new_su_name) ? $pat_info->new_su_name : 'N/A' }}</div>
                                </td>



                            </tr> --}}
                            
                        </table>
                    </div>

                    <div>
                        <div class="card-header text-center">
                            <h2 class="card-title mb-0 text-left"><strong>Post Anesthesia Instructions</strong>
                            </h2>
                        </div>
                        <table width="100%" border="1" style="margin-top:5px">
                            <tr>

                                <td colspan="3"><strong>Position:
                                    </strong>{{ $pre_operative_checklist->position ?? '' }}</td>
                                <td colspan="2"><strong>Others:
                                    </strong>{{ $pre_operative_checklist->flow_mint ?? '' }}</td>
                            </tr>

                            <tr>
                                <td colspan="3"><strong>Oxygen: </strong>
                                    {{ $pre_operative_checklist->oxygen ?? '' }}
                                </td>
                                <td><strong>Others: </strong>{{ $pre_operative_checklist->monitor_dtl ?? '' }}</td>
                                <td><strong>(Flow @ L/min):</strong> {{ $pre_operative_checklist->flow_hr ?? '' }} hr
                                </td>
                            </tr>

                            <tr>
                                <td colspan="2"><strong>Nothing per oral (NPO) till:</strong></td>
                                <td colspan="3">{{ $pre_operative_checklist->npo ?? '' }} hr</td>
                            </tr>

                            <tr>
                                <td colspan="2"><strong>Monitor</strong></td>
                                <td colspan="3">
                                    Pulse, Blood pressure, Respiratory rate, SpO₂, Temp, Surgical drain (if any),
                                    Nasogastric suction (if any), Sanitary pad (if any) at 5-minute intervals for 15
                                    minutes,
                                    then 10-minute intervals for 30 minutes, and then 15-minute intervals for 1 hour.
                                </td>
                            </tr>

                            <tr>
                                <td colspan="2"><strong>Record</strong></td>
                                <td colspan="3">
                                    Pulse, Blood pressure, Respiratory rate, SpO₂, Temp, Surgical drain (if any),
                                    Nasogastric suction (if any), Sanitary pad (if any) at 1-hour intervals.
                                </td>
                            </tr>

                            <tr>
                                <td colspan="5"><strong>Care of Anesthetized (paralyzed/numbed) area</strong></td>
                            </tr>

                            <tr>
                                <td colspan="5"><strong>Encourage change of posture</strong> as soon as possible by
                                    him/herself</td>
                            </tr>

                            <tr>
                                <td colspan="5"><strong>Analgesia:</strong> {!! $pre_operative_checklist->analgesia ?? '' !!}</td>
                            </tr>

                            <tr>
                                <td colspan="5"><strong>Fluid & Others:</strong> {!! $pre_operative_checklist->fluid ?? '' !!}</td>
                            </tr>

                            <tr>
                                <td colspan="5"><strong>Special Instructions:</strong> {!! $pre_operative_checklist->special_instructions ?? '' !!}</td>
                            </tr>

                            <tr>
                                <td colspan="2"><strong>Shift to:</strong></td>
                                <td colspan="3">{{ $pre_operative_checklist->shift_to ?? '' }}</td>
                            </tr>

                            <tr>
                                <td colspan="2"><strong>Anesthesiologists:</strong></td>
                                <td>{{ $pre_operative_checklist->anesthesiologist ?? '' }}</td>
                                <td><strong>Surgeons:</strong></td>
                                <td>{{ $pre_operative_checklist->surgeons ?? '' }}</td>
                            </tr>
                        </table>


                    </div>
                </div>
            </section>
        </div>
    </main>
</body>

</html>
<script>
    window.print();
    window.onafterprint = function() {
        window.close(); // Close the window after printing
    }
</script>
