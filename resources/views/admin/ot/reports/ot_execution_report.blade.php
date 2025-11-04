@php
    $hospital = DB::table('wsec_hospital')
        ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
        ->first();
@endphp
{{-- {{ dd($ot_confirmlist) }} --}}
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>OT Execution Report</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    {{-- <link rel="stylesheet" href="{{ public_path().'/css/print.css' }}" media="print"> --}}
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
            margin-bottom: 2cm;
            font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
            font-size: 11px;
        }

        footer {
            position: fixed;
            bottom: 0cm;
            left: 0cm;
            right: 0cm;
            height: .7cm;
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

        table {
            border: 1px solid #222;
            border-spacing: 0;
        }

        td {
            border-bottom: 1px solid #222;
            border-right: 1px solid #222;
        }

        table td:last-child {
            border-right: 0px solid transparent;
        }

        th {
            border-top: 1px solid #222;
        }
    </style>
</head>

<body>
    <header>
        <table style="width: 100%; border:none;" class="signature">
            <tr>
                <td style="width: 15%; border:none;">
                    <img class="hospital-logo"
                        src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}" width="60"
                        alt="">
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

    <div class="signature_">
        <table style="width: 100%;border-spacing: 0; border:none !important;" cellpadding="1">
            <tr class="table-tr">
                <td style="text-align:left; border:none;">
                    <span style="padding:5px; border-top: black solid 1px;"> Employee Signature
                    </span>
                </td>
                <td style="text-align:right; border:none;">
                    <span style="padding:5px; border-top: black solid 1px;"> Approved By </span>
                </td>
            </tr>
        </table>
    </div>



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
                <span class="report-name" style="width:70%; border:solid black 1px; padding:10px;  ">
                    OT Execution Report
                </span>
            </div>
            <div style=" text-align:center;  width:100%; margin-bottom:10px" class="mb-2">


                <span class="report-date"><strong>From Date: {{ $from_date }}</strong> - <span
                        class="report-date"><strong>To Date: {{ $to_date }}</strong>
                    </span>
            </div>
            <section id="lp-items">
                <div class="container">
                    <table style="width: 100%;border-spacing: 0;" cellpadding="1">


                        <thead class="bg-soft-green" style="margin-bottom: 10px">
                            <tr class="table-tr" style="background-color: #E3E3E3;">
                                <th class="table-td" scope="col">
                                    <strong>SL</strong>
                                </th>
                                <th class="table-td" scope="col">
                                    <strong>Patient Name</strong>
                                </th>
                                <th class="table-td" scope="col">
                                    <strong>Prescription ID</strong>
                                </th>
                                <th class="table-td" scope="col">
                                    <strong>Admission ID</strong>
                                </th>
                                <th class="table-td" scope="col">
                                    <strong>Ward Name</strong>
                                </th>
                                <th class="table-td" scope="col">
                                    <strong>Req. ID</strong>
                                </th>
                                <th class="table-td" scope="col">
                                    <strong>Bed Name</strong>
                                </th>
                                {{--										<th class="text-center">Base/Unit</th> --}}
                                <th class="table-td" scope="col">
                                    <strong>Age</strong>
                                </th>
                                <th class="table-td" scope="col">
                                    <strong>Doctor Name</strong>
                                </th>
                                <th class="table-td" scope="col">
                                    <strong>OT Date & Time</strong>
                                </th>
                                <th class="table-td" scope="col">
                                    <strong>Operation Name</strong>
                                </th>
                                <th class="table-td" scope="col">
                                    <strong>OT Status</strong>
                                </th>
                                <th class="table-td" scope="col">
                                    <strong>Prepared By</strong>
                                </th>
                            </tr>

                        </thead>
                        <br>
                        <br>
                        <br>
                        <tbody>

                            @if ($ot_confirmlist)
                                @foreach ($ot_confirmlist as $confirm_list)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td class="text-left">
                                            {{ !empty($confirm_list->patient_name) ? $confirm_list->patient_name : '' }}
                                        </td>
                                        <td class="text-left" style="text-align: center">
                                            {{ !empty($confirm_list->prescription_uid) ? $confirm_list->prescription_uid : '' }}
                                        </td>
                                        <td class="text-left" style="text-align: center">
                                            {{ !empty($confirm_list->admission_uid) ? $confirm_list->admission_uid : '' }}
                                        </td>
                                        <td class="text-left">
                                            {{ !empty($confirm_list->ward_name) ? $confirm_list->ward_name : '' }}
                                        </td>
                                        <td class="text-left" style="text-align: center">
                                            {{ !empty($confirm_list->ot_req_uid) ? $confirm_list->ot_req_uid : '' }}
                                        </td>
                                        <!-- <td class="text-center">Req-01221552</td> -->
                                        <td class="text-left">
                                            {{ !empty($confirm_list->bed_name) ? $confirm_list->bed_name : '' }}
                                        </td>
                                        {{--											<td class="text-left">{{!empty($confirm_list->pat_unit)?$confirm_list->pat_unit: ''}}</td> --}}
                                        <td class="text-left">
                                            {{ !empty($confirm_list->age) ? $confirm_list->age : '' }}</td>
                                        <td class="text-left">
                                            {{ !empty($confirm_list->surg_doctor_name) ? $confirm_list->surg_doctor_name : '' }}
                                        </td>
                                        <td class="text-left">
                                            {{ !empty($confirm_list->ot_date) ? date('d/m/Y', strtotime($confirm_list->ot_date)) : '' }}
                                            {{ !empty($confirm_list->ot_comfirmation_time) || $confirm_list->ot_comfirmation_time != '00:00' ? date('h:i A', strtotime($confirm_list->ot_comfirmation_time)) : '' }}
                                        </td>
                                        <td class="text-left">
                                            {{ !empty($confirm_list->item_name) ? $confirm_list->item_name : '' }}
                                        </td>
                                        <td class="text-left">
                                            {{-- @if ($confirm_list->ot_note_ind == 0)
                                                    <span class="badge badge-warning">OT</span>
                                                @else
                                                <span class="badge badge-success">OT</span>
                                                @endif

                                                @if ($confirm_list->anest_note_ind == 1)
                                                <span class="badge badge-success anes">Anaesthesia</span>
                                                @else
                                                <span class="badge badge-warning anes">Anaesthesia</span>
                                                @endif --}}
                                            @if ($confirm_list->ot_complete_ind == 1)
                                                <span class="badge badge-success ">OT Complete</span>
                                            @else
                                                <span class="badge badge-warning">OT Complete</span>
                                            @endif

                                            @if ($confirm_list->anesth_record == 1)
                                                <span class="badge badge-success ">Anes. Record</span>
                                            @else
                                                <span class="badge badge-warning">Anes. Record</span>
                                            @endif

                                            @if ($confirm_list->op_note == 1)
                                                <span class="badge badge-success ">OT Note</span>
                                            @else
                                                <span class="badge badge-warning">OT Note</span>
                                            @endif

                                            @if ($confirm_list->pre_anes_chkup_frm == 1)
                                                <span class="badge badge-success ">Pre-anes. checkup</span>
                                            @else
                                                <span class="badge badge-warning">Pre-anes. checkup</span>
                                            @endif

                                            @if ($confirm_list->pre_oper_chklist == 1)
                                                <span class="badge badge-success ">Pre-operative Check
                                                    list</span>
                                            @else
                                                <span class="badge badge-warning">Pre-operative Check
                                                    list</span>
                                            @endif

                                            @if ($confirm_list->high_risk_consent == 1)
                                                <span class="badge badge-success ">High Risk Consent</span>
                                            @else
                                                <span class="badge badge-warning">High Risk Consent</span>
                                            @endif


                                        </td>
                                        <td class="text-center">

                                            <strong>
                                                {{ !empty($confirm_list->ot_prepered_by) ? ucwords($confirm_list->ot_prepered_by) : '' }}

                                            </strong>
                                            {{-- <div class="btn-group">
                                                    <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <button type="button" class="btn btn-success btn-sm open-modal" data-modal="common-modal-md" data-title="OT Note" data-action="{{ route('ot.ot-note',$confirm_list->ot_req_no_pk) }}">OT Note</button>
                                                        <button type="button" class="btn btn-info btn-sm open-modal" data-modal="common-modal-md" data-title="Anest. Note" data-action="{{ route('ot.annest-note',$confirm_list->ot_req_no_pk) }}">Anest Note</button>
                                                        <button type="button" class="btn btn-secondary btn-sm">Transfer</button>
                                                    </div>
                                                </div> --}}





                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>

                    </table>
                </div>
            </section>
        </div>
    </main>


</body>

</html>
