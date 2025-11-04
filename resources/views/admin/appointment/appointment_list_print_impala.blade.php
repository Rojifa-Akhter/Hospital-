<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Appointment List Print</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

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


        .page-break {
            page-break-before: always;
        }
    </style>
</head>

<body>
    <header>
        <table style="width: 100%;" class="signature">
            @if ($print_type == 'PDF')
                <tr>
                    <td style="width: 15%;">
                    @if(!empty($po_hospital_details->logo) && !file_exists(asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo)))
                    <img class="hospital-logo"
                        src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}" width="60"
                        alt="">
                @endif
                    </td>
                    <td style="text-align:center;">
                        <span style="font-size: 15px;"> <strong>
                                {{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }}
                            </strong></span> <br>
                        Address: <span>
                            {{ isset($po_hospital_details->addrress1) ? $po_hospital_details->addrress1 : '' }}</span><br>
                        Phone No: <span>
                            {{ isset($po_hospital_details->telephone1) ? $po_hospital_details->telephone1 : '' }}</span>
                    </td>
                    <td style=" text-align:right; width: 15%; ">
                        <div style="">
                            <img src="data:image/png;base64, {{ $barcode_no }} " width="100" />
                        </div>

                    </td>
                </tr>
            @else
                <tr>
                    <td style="text-align:center;" colspan="11">
                        <span style="font-size: 15px;"> <strong>
                                {{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }}
                            </strong></span> <br>
                        Address: <span>
                            {{ isset($po_hospital_details->addrress1) ? $po_hospital_details->addrress1 : '' }}</span><br>
                        Phone No: <span>
                            {{ isset($po_hospital_details->telephone1) ? $po_hospital_details->telephone1 : '' }}</span>
                    </td>

                </tr>
            @endif
        </table>
    </header>
    <div style="width: 100%;">
        <div style=" text-align:center; margin-bottom:5px; margin-top:15px  ">
            <span class="report-name" style="width:70%; border:solid black 1px; padding:10px;  "> Appointment
                list</span>
        </div>
        <div style=" text-align:left; margin-bottom:5px; margin-top:5px  ">
        @if(!empty($user_id))
           <strong>User Name :</strong>
                {{ $user_id->user_fullname }}

           @endif
            @if ($from_date != '' && $to_date != '')
                <strong>From date :</strong>
                {{ $from_date != '' ? date('d/m/Y', strtotime($from_date)) : '' }}, <strong> To date
                </strong> : {{ $to_date != '' ? date('d/m/Y', strtotime($to_date)) : '' }}
                @elseif ($from_date != '')
                <strong> Date : </strong>
                {{ $from_date != '' ? date('d/m/Y', strtotime($from_date)) : 'nl' }}
            @endif


        </div>


    </div>
    @if ($print_type == 'PDF')
        <div class="signature_">
            <table style="width: 100%;">
                <tr style=" ">
                    {{-- <td style="text-align:left; ">
                    <span style="padding:5px; border-top: black solid 1px;"> HR & ADMIN
                    </span>
                </td>
                <td style=" ">
                    <span style="padding:5px; border-top: black solid 1px;"> MANAGER (HOSPITAL SERVICE)
                    </span>
                </td>
                <td style=" ">
                    <span style="padding:5px; border-top: black solid 1px;"> ACCOUNT OFFICER
                    </span>
                </td>
                <td style=" ">
                    <span style="padding:5px; border-top: black solid 1px;"> GENERAL MANAGER
                    </span>
                </td> --}}
                    <td style="text-align:right; ">
                        <span style="padding:5px; border-top: black solid 1px;"> MANAGER </span>
                    </td>
                </tr>
            </table>
        </div>
    @endif
    @if ($print_type == 'PDF')
        <footer class="">
            <div class="footer ">
                <div class="container">
                    <table style="width: 100%; padding:3px; margin: 0">
                        <tr>
                            <td style="font-size: 9px; text-align:left;">Print Date: <strong>
                                    @php
                                        date_default_timezone_set('Asia/Dhaka');
                                        $date = date('d/m/Y H:m:s');
                                    @endphp
                                     <span class="report-date"><strong>From Date: {{ $from_date }}</strong> - <span
                                        class="report-date"><strong>To Date: {{ $to_date }}</strong>
                                    </span>


                                </strong> Printed By: <strong>{{ Session::get('user.ses_user_name') }}</strong></td>
                            <td style="font-size: 9px; text-align: right;"><strong>Powered By - H360 [NextGenIT]
                                </strong></td>
                        </tr>
                    </table>
                </div>
            </div>
        </footer>
    @endif


    <main class="">
        <div class="wrapper">

            <section id="lp-items ">
                <div class="container ">

                    <table style="width:100%;border-collapse:collapse;" cellpadding="1" cellspacing="0" border="1">
                        <thead>
                            <tr class="table-tr" style="border-top: 1px solid black">
                                <td class="table-td" style="text-align: center;" scope="col"><strong>SL</strong>
                                </td>
                                <td class="table-td" style="text-align: center;" scope="col"><strong>User Name</strong>
                                </td>
                                <td class="table-td" style="text-align: center;" scope="col"><strong>App.
                                        Date</strong>
                                </td>
                                <td class="table-td" style="text-align: center;" scope="col"><strong>App.
                                        Time</strong>
                                </td>
                                <td class="table-td" style="text-align: center;" scope="col"><strong>Apppointment
                                        No</strong>
                                </td>
                                <td class="table-td" style="text-align: center;" scope="col"><strong>
                                        Patient Id</strong></td>
                                <td class="table-td" style="text-align: center;" scope="col"><strong>
                                        Patient Name</strong></td>
                                <td class="table-td" style="text-align: center;" scope="col"><strong>
                                        Mobile</strong></td>
                                <td class="table-td" style="text-align: center; width:130px" scope="col"><strong>
                                        Doctor Name</strong></td>
                                <td class="table-td" style="text-align: center;" scope="col"><strong>
                                        Department</strong></td>
                                <td class="table-td" style="text-align: center;" scope="col"><strong>
                                        Referal Doctor</strong></td>

                                {{-- <td class="table-td" style="text-align: center;" scope="col">
                                    <strong>CC</strong>
                                </td>
                                <td class="table-td" style="text-align: center;" scope="col">
                                    <strong>Priority</strong>
                                </td> --}}
                                <td class="table-td" style="text-align: center;" scope="col">
                                    <strong>Patient Type</strong>
                                </td>

                                <td class="table-td" style="text-align: center;" scope="col">
                                    <strong>App. Sl. No</strong>
                                </td>
                                <td class="table-td" style="text-align: center;" scope="col">
                                    <strong>Status</strong>
                                </td>

                            </tr>


                        </thead>
                        <tbody>

                            <?php $i = 1; ?>

                            @if (!empty($appointment_rs))

                                @foreach ($appointment_rs as $key => $row)
                                    <tr style="font-size: 10px">
                                        <td class="table-td" style="text-align: center; padding:3px">
                                            {{ $i }}</td>
                                        <td class="table-td" style="text-align: left; padding:3px">
                                            {{ $row->user_fullname }}
                                        </td>
                                        <td class="table-td" style="text-align: left; padding:3px">
                                            {{ $row->appoint_date != '' ? date('d/m/Y', strtotime($row->appoint_date)) : '' }}
                                        </td>
                                        <td class="text-left" style="white-space: nowrap;">
                                            @if (isset($row->start_time) && isset($row->end_time))
                                                <strong>Start Time : </strong>
                                                {{ date('h:i A', strtotime($row->start_time)) }}
                                                <br>
                                                <strong>End Time : </strong>

                                                {{ date('h:i A', strtotime($row->end_time)) }}
                                            @else
                                                <strong>Start Time : </strong>
                                                {{ date('h:i A', strtotime($row->au_entry_at)) }}
                                            @endif

                                        </td>
                                        <td class="table-td" style="text-align: left; padding:3px">
                                            {{ $row->appoint_code }}</td>
                                        <td class="table-td" style="text-align: left; padding:3px">
                                            {{ $row->patient_code }}</td>
                                        <td class="table-td" style="text-align: left; padding:3px">
                                            {{ $row->patient_name }}</td>
                                        <td class="table-td" style="text-align: left; padding:3px">
                                            {{ $row->mobile1}}</td>
                                        <td class="table-td" style="text-align: left;  padding:3px">
                                            {{ $row->full_name }}</td>
                                        <td class="table-td" style="text-align: left;  padding:3px">
                                            {{ $row->su_name }}</td>
                                        <td class="table-td" style="text-align: left;  padding:3px">
                                            <strong>{{ $row->first_ref_code }}</strong> {{ $row->first_ref_name }}
                                        </td>

                                        {{-- <td class="table-td" style="text-align: left;  padding:3px">
                                            {{ $row->chif_complain }}</td>
                                        <td class="table-td" style="text-align: left;  padding:3px">
                                            {{ $row->priority }}</td> --}}
                                        <td class="table-td" style="text-align: left;  padding:3px">
                                            {{ $row->patient_type_code }}</td>

                                        <td class="table-td" style="text-align: center;  padding:3px">
                                            {{ $row->slot_sl }}</td>
                                        <td class="table-td" style="text-align: center;  padding:3px">
                                            {{-- @if ($row->cancel_ind == 1)
                                                Canceled
                                            @elseif ($row->consult_ind == 1)
                                                Prescribed
                                            @else
                                                Pending
                                            @endif --}}


                                            @if ($row->appoint_no_pk == $row->appoint_service_no_fk && $row->cancel_ind == 0)
                                                Payment
                                            @endif

                                            @if ($row->cancel_ind == 0 && $row->appoint_service_no_fk == '')
                                                Pending
                                            @endif

                                            @if ($row->cancel_ind == 1)
                                                Canceled
                                            @endif

                                        </td>

                                    </tr>
                                    <?php $i++; ?>
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
