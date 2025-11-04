<style>
    .board_member_img {
        border: 1px solid black;
        width: 50px;
    }


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
        bottom: 2.6cm;
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
</style>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Conveyancebill Report</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <style>

    </style>
</head>

<body>
    <header>
        {{-- <table style="width: 100%;" class="signature">
            <tr>
                <td style="width: 10%;">
                    <img class="hospital-logo"
                        src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}"
                        width="60" alt="">
                </td>
                <td style="text-align:center;" class="emon">
                    <span style="font-size: 15px;"> <strong>
                            {{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }}
                        </strong></span> <br>
                    Address: <span>
                        {{ isset($po_hospital_details->addrress1) ? $po_hospital_details->addrress1 : '' }}</span><br>
                    Phone No: <span>
                        {{ isset($po_hospital_details->telephone1) ? $po_hospital_details->telephone1 : '' }}</span>
                </td>
            </tr>
        </table> --}}

        <table style="width: 100%;" class="signature">
            <tr>
                <td style="width: 10%; text-align: center;">
                    <img class="hospital-logo"
                        src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}"
                        width="60" alt="">
                </td>
                <td style="text-align: center;">
                    <span style="font-size: 15px;"> <strong>
                            {{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }}
                        </strong></span> <br>
                    Address: <span>
                        {{ isset($po_hospital_details->addrress1) ? $po_hospital_details->addrress1 : '' }}</span><br>
                    Phone No: <span>
                        {{ isset($po_hospital_details->telephone1) ? $po_hospital_details->telephone1 : '' }}</span>
                </td>
            </tr>
        </table>

    </header>

    <div class="signature_">
        {{-- <table style="width: 100%;">
            <tr style=" ">
                <td style="text-align:left; ">
                    <span style="padding:5px; border-top: black solid 1px;"> Checked By
                    </span>
                </td>
                <td style="text-align:center; ">
                    <span style="padding:5px; border-top: black solid 1px;"> Received By </span>
                </td>
                <td style="text-align:right; ">
                    <span style="padding:5px; border-top: black solid 1px;"> Approved By </span>
                </td>
            </tr>
        </table> --}}

        {{-- <div> --}}
        <!-- <table style="width: 100%; border:none ">
                <tr>
                    <td colspan="2">Department Head Approval </td>
        
                    <td colspan="2" class="text-right">Managing Director Approval</td>
                </tr>
            </table> -->
        <div class="singature" style="margin-top: -70px;">
            <table style="width: 100%; border:none;">
                <tr style="">
                    @if (!empty($signature_data))
                        @if ($signature_data[0]->user_fullname_ent != '')
                            <td style="text-align:left; border:none ">
                                @if ($signature_data[0]->ent_img != '')
                                    <div style="padding:5px"> <img
                                            src="{{ public_path('images/uploads/doctor_images/' . $signature_data[0]->ent_img) }}"
                                            width='60px' style="padding: 0px  !important; margin:0px !important">
                                    </div>
                                @endif
                            </td>
                        @endif
                        @foreach ($signature_data as $key => $value)
                            @php
                                $approval = $value->level_status_text != '' ? explode('-', $value->level_status_text) : '';
                            @endphp

                            @if ($key == 0 && $approval != '' && $approval[1] == 'APPROVED')
                                <td style="text-align:left; border:none " colspan="2">
                                    @if ($value->doctor_signature_image != '')
                                        <div style="padding:5px"> <img
                                                src="{{ public_path('images/uploads/doctor_images/' . $value->doctor_signature_image) }}"
                                                width='60px' style="padding: 0px  !important; margin:0px !important">
                                        </div>
                                    @endif

                                </td>
                            @elseif($key == 1 && count($signature_data) == 2 && $approval != '' && $approval[1] == 'APPROVED')
                                <td style="text-align:right; border:none" colspan="2">
                                    @if ($value->doctor_signature_image != '')
                                        <div style="padding:5px"> <img
                                                src="{{ public_path('images/uploads/doctor_images/' . $value->doctor_signature_image) }}"
                                                width='60px' style="padding: 0px  !important; margin:0px !important">
                                        </div>
                                    @endif
                                </td>
                            @elseif($key == 1 && count($signature_data) == 3 && $approval != '' && $approval[1] == 'APPROVED')
                                <td style="text-align:center; border:none" colspan="2">
                                    @if ($value->doctor_signature_image != '')
                                        <div style="padding:5px"> <img
                                                src="{{ public_path('images/uploads/doctor_images/' . $value->doctor_signature_image) }}"
                                                width='60px' style="padding: 0px  !important; margin:0px !important">
                                        </div>
                                    @endif
                                </td>
                            @elseif($key == 2 && count($signature_data) == 3 && $approval != '' && $approval[1] == 'APPROVED')
                                <td style="text-align:center; border:none" colspan="2">
                                    @if ($value->doctor_signature_image != '')
                                        <div style="padding:5px"> <img
                                                src="{{ public_path('images/uploads/doctor_images/' . $value->doctor_signature_image) }}"
                                                width='60px' style="padding: 0px  !important; margin:0px !important">
                                        </div>
                                    @endif
                                </td>
                            @endif
                        @endforeach
                    @endif
                </tr>


                <tr style="">
                    @if (!empty($signature_data))
                        @if ($signature_data[0]->user_fullname_ent != '')
                            <td style="text-align:left; border:none ">
                                <span style="padding:5px; border-top: black solid 1px;"> <strong>
                                        {{ $signature_data[0]->user_fullname_ent }} </strong></span> <br>
                                <strong> {{ ucwords($signature_data[0]->ent_designation) }}</strong><br>
                                {{ $signature_data[0]->approved_at != '' ? date('d/m/Y', strtotime($signature_data[0]->approved_at)) : '' }}

                            </td>
                        @endif
                        @foreach ($signature_data as $key => $value)
                            @php
                                $approval = $value->level_status_text != '' ? explode('-', $value->level_status_text) : '';
                            @endphp

                            @if ($key == 0 && $approval != '' && $approval[1] == 'APPROVED')
                                <td style="text-align:left; border:none " colspan="2">
                                    <span style="padding:5px; border-top: black solid 1px;"> <strong>
                                            {{ $value->user_fullname }} </strong></span> <br> <strong>
                                        {{ ucwords($value->designation) }}</strong><br>
                                    {{ $value->approved_at != '' ? date('d/m/Y', strtotime($value->approved_at)) : '' }}

                                </td>
                            @elseif($key == 1 && count($signature_data) == 2 && $approval != '' && $approval[1] == 'APPROVED')
                                <td style="text-align:right; border:none" colspan="2">
                                    <span style="padding:5px; border-top: black solid 1px;"> <strong>
                                            {{ $value->user_fullname }} </strong></span> <br> <strong>
                                        {{ ucwords($value->designation) }}</strong><br>
                                    {{ $value->approved_at != '' ? date('d/m/Y', strtotime($value->approved_at)) : '' }}
                                </td>
                            @elseif($key == 1 && count($signature_data) == 3 && $approval != '' && $approval[1] == 'APPROVED')
                                <td style="text-align:center; border:none" colspan="2">
                                    <span style="padding:5px; border-top: black solid 1px;"> <strong>
                                            {{ $value->user_fullname }} </strong></span> <br> <strong>
                                        {{ ucwords($value->designation) }}</strong><br>
                                    {{ $value->approved_at != '' ? date('d/m/Y', strtotime($value->approved_at)) : '' }}
                                </td>
                            @elseif($key == 2 && count($signature_data) == 3 && $approval != '' && $approval[1] == 'APPROVED')
                                <span style="padding:5px; border-top: black solid 1px;"> <strong>
                                        {{ $value->user_fullname }} </strong></span> <br> <strong>
                                    {{ ucwords($value->designation) }}</strong><br>
                                {{ $value->approved_at != '' ? date('d/m/Y', strtotime($value->approved_at)) : '' }}
                                </td>
                            @endif
                        @endforeach
                    @endif
                </tr>
            </table>
        </div>
        {{-- </div> --}}


    </div>

    <footer style="position: fixed;">
        <div class="footer">
            <div class="container">
                <table style="width: 100%; padding:3px; margin: 0">
                    <tr>
                        <td style="font-size: 9px; text-align:left;">
                            </strong> <strong>Staff ID: {{ $userInfo->user_code }}. Printing Date & Time: {{ date('d/m/Y, h:ia') }}</strong></td>
                        <td style="font-size: 9px; text-align: right;"><strong>Powered By: NEXTGEN IT
                            </strong>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </footer>
    <main>
        <div class="wrapper">
            <div style="text-align:center; margin-bottom:20px; margin-left:90px; margin-top:15px;" class="mb-2">
                <h2 class="report-name" style="margin-right:112px;">Conveyance Request</h2>
                <p style="font-size: 13px; text-align: right;">
                    Date: {{ date('d/m/Y') }}
                </p>
            </div>
            <div style="width:100%; margin-bottom:5px" class="mb-2">
                @php
                    $locale = 'en_US';
                    $fmt = numfmt_create($locale, NumberFormatter::SPELLOUT);
                    $in_words = numfmt_format($fmt, $totalAmount);
                @endphp
                <p style="font-size: 13px;">I incurred a sum of TK. <b>{{ $totalAmount }}</b> Taka
                    {{ ucwords($in_words) }} Only for performing the
                    following journey of Official interest which may kindly be approved for payment.</p> <br>
                <strong>Conveyance ID:
                    {{ $req_by->conveyancebillmst_uid ? $req_by->conveyancebillmst_uid : '' }}</strong>
            </div>
            <section id="lp-items">
                <div class="container">
                    <table style="width: 100%;border-collapse:collapse;" cellpadding="1" cellspacing="0" border="1">

                        <thead>
                            <tr class="table-tr" style="background-color: #E3E3E3;">
                                <th class="text-left" scope="col">
                                    <strong>Trip SL</strong>
                                </th>
                                <th class="text-left" scope="col">
                                    <strong>Trip Date</strong>
                                </th>
                                <th class="text-left" scope="col">
                                    <strong>From</strong>
                                </th>
                                <th class="text-left" scope="col">
                                    <strong>To</strong>
                                </th>
                                <th class="text-left" scope="col">
                                    <strong>Transport name</strong>
                                </th>

                                <th class="text-left" scope="col">
                                    <strong>Address</strong>
                                </th>

                                <th class="text-left" width: 120px;" scope="col">
                                    <strong>Purpose</strong>
                                </th>
                                <th class="text-left" scope="col">
                                    <strong>Remarks</strong>
                                </th>
                                <th class="text-left" style="text-align: left;" scope="col">
                                    <strong>Amount</strong>
                                </th>
                                {{-- <th class="text-center" style="text-align: center;" scope="col">
                                    <strong>Status</strong>
                                </th> --}}
                            </tr>
                        </thead>

                        <tbody>
                            @if (!empty($report_data))
                                @foreach ($report_data as $conv_data)
                                    <tr>
                                        <td class="text-left">{{ $conv_data->trip_sl }}</td>
                                        <td class="text-left">
                                            @if (!empty($conv_data->conveyance_date))    
                                            {{ date('d/m/Y', strtotime($conv_data->conveyance_date)) }}
                                            @endif
                                        </td>
                                        <td class="text-left">{{ $conv_data->from_location }}</td>
                                        <td class="text-left">{{ $conv_data->to_location }}</td>
                                        <td class="text-left">{{ $conv_data->transport_name }}</td>
                                        <td class="text-left">{{ $conv_data->description }}</td>
                                        <td class="text-left">{{ $conv_data->purpose_name }}</td>
                                        <td class="text-left">{{ $conv_data->remarks }}</td>
                                        <td class="text-left">TK. {{ $conv_data->amount }}</td>
                                        {{-- <td class="text-center"></td> --}}
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                    <div style="margin-top: 40px;">
                        <strong>Bill Submitted by : {{ $req_by->req_by_name ? $req_by->req_by_name : '' }}</strong>
                    </div>
                </div>
            </section>
        </div>
    </main>
</body>

</html>
