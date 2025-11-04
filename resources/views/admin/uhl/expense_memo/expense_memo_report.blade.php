<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IOU/EXPENSE REPORT</title>
    <style>
        /* body {
            font-family: sans-serif;
            margin: 0;
            padding: 0;
        } */

        @page {
            /* margin: .6cm .6cm;    */
            width: 100%;
            height: 100%
        }

        body {
            margin-top: 3cm;
            margin-left: .3cm;
            margin-right: .3cm;
            margin-bottom: 2cm;
            font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
            font-size: 11px;
        }

        footer {
            position: fixed;
            bottom: -.4cm;
            left: 0cm;
            right: 0cm;
            height: .7cm;
            text-align: center;
            padding: 0 1cm;
            border-top: 1px solid;
        }

        /* .signature_ {
            position: fixed;
            bottom: 2cm;
            left: .8cm;
            right: .8cm;
            width: 100%;
            margin-top: -40px;
        } */


        .signature_ {
            position: fixed;
            bottom: 2cm;
            left: .8cm;
            right: .8cm;
            width: 100%;
            margin-top: -60px;
        }

        .signature_ table {
            border-collapse: collapse;
            width: 100%;
        }

        .signature_ td {
            border: none;
            vertical-align: top;
            /* Align content to the top */
            height: 60px;
            /* Set a fixed height for the table cells */
        }

        .signature_ img {
            vertical-align: middle;
            /* Align images vertically in the middle */
        }


        .header {
            text-align: center;
            font-size: 20px;
            margin-bottom: 10px;
        }

        .receipt-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
        }

        .receipt-info span:first-child {
            font-weight: bold;
        }

        .receipt-items {
            border-collapse: collapse;
            width: 100%;
        }

        .receipt-items th,
        .receipt-items td {
            border: 1px solid black;
            padding: 5px 10px;
            font-size: 12px;
        }

        header {
            position: fixed;
            top: -22;
            height: 2cm;
            padding: 0 1cm;
        }
    </style>
</head>

<body>
    <header>
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
                        {{ isset($po_hospital_details->telephone1) ? $po_hospital_details->telephone1 : '' }}</span> <br> <br>
                        <strong><span>IOU Report</span></strong>
                </td>
            </tr>
        </table>
    </header>

    <div class="signature_">
        <div class="singature">
            <table style="width: 100%; border:none;">
                <tr style="">
                    @if (!empty($signature_data))
                        @if ($expense_data)
                            <td style="text-align:left; border:none ">
                                @if ($expense_data->doctor_signature_image != '')
                                    <div style="padding:5px"> <img
                                            src="{{ public_path('images/uploads/doctor_images/' . $expense_data->doctor_signature_image) }}"
                                            width='50px' style="padding: 0px  !important; margin:0px !important">
                                    </div>
                                @endif
                            </td>
                        @endif
                        @foreach ($signature_data as $key => $value)
                            @php
                                $approval =
                                    $value->level_status_text != '' ? explode('-', $value->level_status_text) : '';
                            @endphp

                            @if ($key == 0 && $approval != '' && $approval[1] == 'APPROVED')
                                <td style="text-align:left; border:none " colspan="2">
                                    @if ($value->doctor_signature_image != '')
                                        <div style="padding:5px"> <img
                                                src="{{ public_path('images/uploads/doctor_images/' . $value->doctor_signature_image) }}"
                                                width='50px' style="padding: 0px  !important; margin:0px !important">
                                        </div>
                                    @endif

                                </td>
                            @elseif($key == 1 && count($signature_data) == 2 && $approval != '' && $approval[1] == 'APPROVED')
                                <td style="text-align:right; border:none" colspan="2">
                                    @if ($value->doctor_signature_image != '')
                                        <div style="padding:5px"> <img
                                                src="{{ public_path('images/uploads/doctor_images/' . $value->doctor_signature_image) }}"
                                                width='50px' style="padding: 0px  !important; margin:0px !important">
                                        </div>
                                    @endif
                                </td>
                            @elseif($key == 1 && count($signature_data) == 3 && $approval != '' && $approval[1] == 'APPROVED')
                                <td style="text-align:center; border:none" colspan="2">
                                    @if ($value->doctor_signature_image != '')
                                        <div style="padding:5px"> <img
                                                src="{{ public_path('images/uploads/doctor_images/' . $value->doctor_signature_image) }}"
                                                width='50px' style="padding: 0px  !important; margin:0px !important">
                                        </div>
                                    @endif
                                </td>
                            @elseif($key == 2 && count($signature_data) == 3 && $approval != '' && $approval[1] == 'APPROVED')
                                <td style="text-align:center; border:none" colspan="2">
                                    @if ($value->doctor_signature_image != '')
                                        <div style="padding:5px"> <img
                                                src="{{ public_path('images/uploads/doctor_images/' . $value->doctor_signature_image) }}"
                                                width='50px' style="padding: 0px  !important; margin:0px !important">
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
                                    <span style="padding:5px; border-top: black solid 1px;">
                                        <strong>{{ $value->user_fullname }}</strong>
                                    </span> <br> 
                                    <strong>{{ ucwords($value->designation) }}</strong><br>
                                    {{ $value->approved_at != '' ? date('d/m/Y', strtotime($value->approved_at)) : '' }}
                                </td>
                            @elseif($key == 1 && count($signature_data) == 2 && $approval != '' && $approval[1] == 'APPROVED')
                                <td style="text-align:right; border:none" colspan="2">
                                    <span style="padding:5px; border-top: black solid 1px;"> 
                                        <strong>{{ $value->user_fullname }}</strong>
                                    </span> 
                                            <br><strong> {{ ucwords($value->designation) }}</strong><br>
                                    {{ $value->approved_at != '' ? date('d/m/Y', strtotime($value->approved_at)) : '' }}
                                </td>
                            @elseif($key == 1 && count($signature_data) == 3 && $approval != '' && $approval[1] == 'APPROVED')
                                <td style="text-align:center; border:none" colspan="2">
                                    <span style="padding:5px; border-top: black solid 1px;"> <strong>
                                            {{ $value->user_fullname }} </strong>
                                    </span> 
                                    <br><strong>{{ ucwords($value->designation) }}</strong><br>
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
    </div>

    <div class="receipt-info">
        <span style="margin-left:3px;">Memo No. {{ $expense_data ? $expense_data->memo_no : '' }}</span>
        <span style="margin-left:550px;">Date: {{ $expense_data ? date('d-m-Y', strtotime($expense_data->expense_date)) : '' }}</span>
    </div>
    <div class="receipt-info">
        <span style="">To</span>
        <span style="margin-left: 45px;">{{ $expense_data ? $expense_data->expense_to : '' }}</span>
    </div>
    <table class="receipt-items">
        <tr>
            <th>For</th>
            <th>AMOUNT</th>
        </tr>
        <tr>
            <td>{{ $expense_data ? $expense_data->expense_name : '' }}</td>
            <td style="text-align: right;">{{ $expense_data ? $expense_data->amount : '' }}</td>
        </tr>
        <tr>
            <th colspan="" style="text-align: right;">Total Amount</th>
            <th colspan="" style="text-align: right;">{{ $expense_data ? $expense_data->amount : '' }}</th>
        </tr>
        <tr>
            @php
                $locale = 'en_US';
                $fmt = numfmt_create($locale, NumberFormatter::SPELLOUT);
                $in_words = numfmt_format($fmt, $expense_data->amount);
            @endphp
            <th colspan="2" style="text-align: left;">Taka (In words) : <span>{{ ucwords($in_words) }}</span></th>
        </tr>
        <tr>
            <th colspan="2" style="text-align: left;">Change to <span style="margin-left: 30px;">: {{ $expense_data->charge_to }}</span>
            </th>
        </tr>
    </table>

    <div style="margin-top: 40px;">
        {{-- <strong> </strong> --}}
        <strong style="margin-left: 5px;">Payment Status : {{ $expense_data->payment_ind != 1 ? 'Unpaid' : 'Paid' }} <span style="margin-left: 55px;">Settlement Status :</span> {{ $expense_data->sattle_ind != 1 ? 'Unsetteled' : 'Settled' }}</strong>
    </div>
    {{-- <div style="margin-top: 10px;">
        <strong>Settlement Status : </strong>
        <strong style="margin-left: 20px;">{{ $expense_data->sattle_ind != 1 ? 'Unsetteled' : 'Settled' }}</strong>
    </div> --}}

    <footer style="position: fixed;">
        <div class="footer">
            <div class="container">
                <table style="width: 100%; padding:3px; margin: 0">
                    <tr>
                        <td style="font-size: 9px; text-align:left;">Print Date: <strong>
                                @php
                                    date_default_timezone_set('Asia/Dhaka');
                                    $date = date('d/m/Y H:m:s');
                                @endphp
                                {{ $date }}
                            </strong> Printed By: <strong>{{ Session::get('user.ses_user_name') }}</strong></td>
                        <td style="font-size: 9px; text-align: right;"><strong>Powered By - H360 [NextGenIT]
                            </strong>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </footer>
</body>
</html>
