<!DOCTYPE html>
<html lang="bn">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- <title>Document</title> --}}


    <style>
        .border-left-0 {
            border-left: none !important;
        }

        .border-right-0 {
            border-right: none !important;
        }

        thead {
            background-color: white;
        }

        .fs-12 {
            font-size: 16px;
        }

        .table {
            border-collapse: collapse;
            width: 100%;
        }

        .table-bordered {
            border: 1px solid #333;
        }

        td {
            font-size: 15px;
            border: 1px solid #333;
            padding-right: 3px;
        }


        .form-check {
            position: relative;
            display: block;
            padding-left: 1.25rem;
        }

        .form-check-inline {
            display: inline-block !important;
            margin-right: 1rem;
        }

        .form-check-input {
            position: static;
            margin-top: 0.3rem;
            margin-left: -1.25rem;
        }

        .form-check-label {
            margin-bottom: 0px !important;
        }

        .w-16 {
            width: 16%;
        }

        .w-8 {
            width: 8%;
        }

        .w-15 {
            width: 15%;
        }

        .w-25 {
            width: 25%;
        }

        .text-left {
            text-align: left;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .header>tbody>tr>td,
        .header>thead>tr>td {
            border: none;
        }

        body {
            /* margin-top: 4cm; */
            margin-bottom: 0.6cm;
            margin-left: 1cm;
        }

        .footer-table {
            position: bottom;
            bottom: 0px;
            width: 95%;

            margin-top: 10px;
        }

        td {
            page-break-inside: avoid
        }
    </style>
</head>

<body onload="window.print()">

    <table class="table header">
        <thead>
            <tr>
                <td style="width:65%">
                    <ul style="list-style: none; padding-left: 0; display:inline-block;">
                        <li><b>IP
                                No:</b>&nbsp;<span>{{ isset($admission_info->admission_no_pk) ? $admission_info->admission_no_pk : '' }}</span>
                        </li>
                        <li><img style="" src="data:image/png;base64, {{ $invoice_barcode }} "></li>
                        <li><span><b>Name:</b>{{ isset($patient_info->patient_name) ? $patient_info->patient_name : '' }}</span>
                            &nbsp;<span><b>Age:</b>{{ isset($patient_info->age) ? $patient_info->age : '' }}</span>
                            &nbsp;<b>Gender:</b><span>{{ isset($patient_info->gender_txt) ? $patient_info->gender_txt : '' }}</span>
                            &nbsp;<b>Bed:</b>&nbsp;<span>{{ isset($admission_info->bed_name) ? $admission_info->bed_name : '' }}</span>
                        </li>
                        <li><b>Con. Number :</b>&nbsp;<span>{{ $patient_info->mobile1 }}</span></li>
                        <li><b>Consultant Name:</b>&nbsp;<span>{{ $admission_info->primary_doctor_name }}</span></li>
                    </ul>
                </td>
                <td style="text-align:right;width:35%">
                    <ul style="list-style: none; padding-left: 0;">
                        <li><b>UHID:</b>&nbsp;<span>{{ isset($patient_info->patient_code) ? $patient_info->patient_code : '' }}</span>
                        </li>
                        <li><img style="" src="data:image/png;base64, {{ $pat_barcode }} "></li>
                        <li><b>Phone:</b>&nbsp;<span>{{ isset($patient_info->mobile1) ? $patient_info->mobile1 : '' }}</span>
                        </li>
                        <li><b>IP
                                Date:</b>&nbsp;<span>{{ date('d/m/Y h:i a', strtotime($admission_info->admission_date)) }}</span>
                        </li>
                        @if (!empty($admission_info->dis_datetime))
                            <li><b>Date of
                                    Discharge:</b>&nbsp;<span>{{ date('d/m/Y h:i a', strtotime($admission_info->dis_datetime)) }}</span>
                            </li>
                        @endif

                    </ul>
                </td>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td colspan="2">
                    <div
                        style="padding: 7px; border-top:1px dotted black; border-bottom:1px dotted black;text-align:center;margin-top:10px; margin-bottom:20px">
                        <span style="font-size: 16px;"><b>HAEMODIALYSIS UNIT TREATMENT WORKSHEET</b></span>
                    </div>


                    <div>
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-bordered">
                                    <tr>
                                        <td>HD Machine</td>
                                        <td>{{ @$haemodialysistw->hd_machine }}</td>
                                    </tr>
                                    <tr>
                                        <td>Bath</td>
                                        <td>{{ @$haemodialysistw->bath }}</td>
                                    </tr>
                                    <tr>
                                        <td>Dialyzer Type</td>
                                        <td>{{ @$haemodialysistw->dialyzer_type }}</td>
                                    </tr>
                                    <tr>
                                        <td>Dry Wt</td>
                                        <td>{{ @$haemodialysistw->dry_wt }}</td>
                                    </tr>
                                    <tr>
                                        <td>Starting Time</td>
                                        <td>{{ @$haemodialysistw->start_time }}</td>
                                    </tr>
                                    <tr>
                                        <td>Finishing Time</td>
                                        <td>{{ @$haemodialysistw->finish_time }}</td>
                                    </tr>
                                    <tr>
                                        <td>Duration of HD</td>
                                        <td>{{ @$haemodialysistw->duration }}</td>
                                    </tr>
                                    <tr>
                                        <td>Heparin Bolus</td>
                                        <td>{{ @$haemodialysistw->heparin_bolus }}</td>
                                    </tr>
                                    <tr>
                                        <td>Heparin Hourly</td>
                                        <td>{{ @$haemodialysistw->heparin_hourly }}</td>
                                    </tr>
                                    <tr>
                                        <td>Total Heparin</td>
                                        <td>{{ @$haemodialysistw->total_heparin }}</td>
                                    </tr>
                                    <tr>
                                        <td>Access</td>
                                        <td>{{ @$haemodialysistw->acess }}</td>
                                    </tr>
                                </table>
                            </div>

                            <div class="col-md-6">
                                <h3><b>Treatment Data Form:</b></h3>
                                <table class="table table-bordered text-center">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Pre-HD</th>
                                            <th>Post-HD</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Wt</td>
                                            <td>{{ @$haemodialysistw->tpre_wt }}</td>
                                            <td>{{ @$haemodialysistw->tpost_wt }}</td>
                                        </tr>
                                        <tr>
                                            <td>BP</td>
                                            <td>{{ @$haemodialysistw->tpre_bp }}</td>
                                            <td>{{ @$haemodialysistw->tpost_bp }}</td>
                                        </tr>
                                        <tr>
                                            <td>Temp</td>
                                            <td>{{ @$haemodialysistw->tpre_temp }}</td>
                                            <td>{{ @$haemodialysistw->tpost_temp }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="col-md-6">
                                <h3><b>Treatment Data for Today:</b></h3>
                                <table class="table table-bordered text-center">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Pre-HD</th>
                                            <th>Post-HD</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Wt</td>
                                            <td>{{ @$haemodialysistw->pre_wt }}</td>
                                            <td>{{ @$haemodialysistw->post_wt }}</td>
                                        </tr>
                                        <tr>
                                            <td>BP-Standing</td>
                                            <td>{{ @$haemodialysistw->pre_bs }}</td>
                                            <td>{{ @$haemodialysistw->post_bs }}</td>
                                        </tr>
                                        <tr>
                                            <td>BP-Sitting</td>
                                            <td>{{ @$haemodialysistw->pre_bps }}</td>
                                            <td>{{ @$haemodialysistw->post_bps }}</td>
                                        </tr>
                                        <tr>
                                            <td>Temp</td>
                                            <td>{{ @$haemodialysistw->pre_temp }}</td>
                                            <td>{{ @$haemodialysistw->post_temp }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div> <br>

                            <div class="col-md-6">
                                <table class="table table-bordered text-center">
                                    <tbody>
                                        <tr>
                                            <td>Wt. Gain</td>
                                            <td>{{ @$haemodialysistw->gain }}</td>
                                        </tr>
                                        <tr>
                                            <td>Dry Wt.</td>
                                            <td>{{ @$haemodialysistw->dry }}</td>
                                        </tr>
                                        <tr>
                                            <td>UF Goal</td>
                                            <td>{{ @$haemodialysistw->goal }}</td>
                                        </tr>
                                        <tr>
                                            <td>IVF/BT during HD</td>
                                            <td>{{ @$haemodialysistw->ivf }}</td>
                                        </tr>
                                        <tr>
                                            <td>Medication</td>
                                            <td>{{ @$haemodialysistw->med }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="col-md-12">
                                <label><b>Pre-HD Remarks:</b>{{ @$haemodialysistw->pre }}</label>

                            </div> <br>

                            @php
                                $time_list = json_decode(@$haemodialysistw->time ?? '[]', true);
                                $bp = json_decode(@$haemodialysistw->bp ?? '[]', true);
                                $pr = json_decode(@$haemodialysistw->pr ?? '[]', true);
                                $bf = json_decode(@$haemodialysistw->bf ?? '[]', true);
                                $df = json_decode(@$haemodialysistw->df ?? '[]', true);
                                $tmp = json_decode(@$haemodialysistw->tmp ?? '[]', true);
                                $ap = json_decode(@$haemodialysistw->ap ?? '[]', true);
                                $vp = json_decode(@$haemodialysistw->vp ?? '[]', true);
                                $ufr = json_decode(@$haemodialysistw->ufr ?? '[]', true);
                                $hep = json_decode(@$haemodialysistw->hep ?? '[]', true);
                                $cond = json_decode(@$haemodialysistw->cond ?? '[]', true);
                            @endphp

                            <div class="col-md-12">
                                <table class="table table-bordered text-center">
                                    <thead>
                                        <tr>
                                            <th>TIME</th>
                                            <th>BP</th>
                                            <th>PR</th>
                                            <th>BF</th>
                                            <th>DF</th>
                                            <th>TMP</th>
                                            <th>AP</th>
                                            <th>VP</th>
                                            <th>UFR</th>
                                            <th>HEP</th>
                                            <th>COND</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($time_list as $i => $time)
                                            <tr>
                                                <td>{{ $time }}</td>
                                                <td>{{ $bp[$i] ?? '' }}</td>
                                                <td>{{ $pr[$i] ?? '' }}</td>
                                                <td>{{ $bf[$i] ?? '' }}</td>
                                                <td>{{ $df[$i] ?? '' }}</td>
                                                <td>{{ $tmp[$i] ?? '' }}</td>
                                                <td>{{ $ap[$i] ?? '' }}</td>
                                                <td>{{ $vp[$i] ?? '' }}</td>
                                                <td>{{ $ufr[$i] ?? '' }}</td>
                                                <td>{{ $hep[$i] ?? '' }}</td>
                                                <td>{{ $cond[$i] ?? '' }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="11" class="text-muted">No treatment data</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>


                    <table class="table table-bordered">
                        <tr>
                            <td colspan="2"><label><b>Complication if any:</b> {{ @$haemodialysistw->cfa }}</label>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2"><label><b>Post-HD Remarks:</b>{{ @$haemodialysistw->post }}</label></td>
                        </tr>
                        <tr>
                            <td><label><b>Signature of Doctor:</b>{{ @$haemodialysistw->doc }}</label></td>
                            <td><label><b>Signature of Nurse:</b>{{ @$haemodialysistw->nurse }}</label></td>
                        </tr>
                    </table>




                </td>
            </tr>
        </tbody>
    </table>


    <section class="footer-table">
        @php
            $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
            $date = $dt->format('g:i A');
        @endphp

        <table style="width:100%" class="table">
            <tbody>
                <tr>
                    <td style="text-align:left;border:none;width:70%"><strong>Staff ID:</strong>
                        {{ @$userInfo->user_code }}, <strong>Printing Date & Time:</strong>
                        {{ date('d/m/Y h:ia') }}
                    </td>
                    <td style="text-align:right;border:none;width:30%"><strong>Powered By: NEXTGEN
                            IT</strong></td>
                </tr>
            </tbody>
        </table>
    </section>
    </td>
    </tr>
    </tbody>
    </table>
</body>

</html>
