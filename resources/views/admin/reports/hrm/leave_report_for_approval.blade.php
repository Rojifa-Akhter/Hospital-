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
    <title>Leave Report</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <style>

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
                <td style="text-align: center; padding-right:80px;">
                    <span style="font-size: 15px;"> <strong>
                            {{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }}
                        </strong></span> <br>
                    Address: <span>
                        {{ isset($po_hospital_details->addrress1) ? $po_hospital_details->addrress1 : '' }}</span><br>
                    Phone No: <span>
                        {{ isset($po_hospital_details->telephone1) ? $po_hospital_details->telephone1 : '' }}</span> <br>
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
     
        {{-- </div> --}}


    </div>

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
    <main>
        <div class="wrapper">
            <div style="text-align:center; margin-bottom:20px; margin-left:90px; margin-top:0px;" class="mb-2">
                <h3 class="report-name" style="margin-right:112px;">Employee Information</h3>
            </div>

            <table style="width: 100%;border-collapse:collapse; margin-bottom: 20px; border:0;" cellpadding="1" cellspacing="0" border="1">
                <thead>
                    <tr class="table-tr">
                        <th style="text-align: center" scope="col">
                            <strong>Name: </strong>{{ $personDetails->full_name }} 
                        </th>
                        <th style="text-align: center" scope="col">
                            <strong>Employee Id: </strong>{{ $personDetails->person_code }} 
                        </th>
                        <th style="text-align: center" scope="col">
                            <strong>Department: </strong>{{ $personDetails->su_name }}
                        </th>
                        <th class="text-center" scope="col">
                            <strong>Designation: </strong> {{ $personDetails->designation }}
                        </th>
                    </tr>
                </thead>
            </table>

            <div style="text-align:center; margin-bottom:20px; margin-left:90px; margin-top:0px;" class="mb-2">
                <h3 class="report-name" style="margin-right:112px;">Leave Information</h3>
            </div>
            <div style="width:100%; margin-bottom:5px" class="mb-2">
                {{-- <p style="font-size: 13px;">I incurred a sum of TK. <b>{{ $totalAmount }}</b> Taka
                    {{ ucwords($in_words) }} Only for performing the
                    following journey of Official interest which may kindly be approved for payment.</p> <br> --}}
                {{-- <strong>Conveyance ID:
                    {{ $req_by->conveyancebillmst_uid ? $req_by->conveyancebillmst_uid : '' }}</strong> --}}
            </div>
            <section id="lp-items">
                <div class="container">
                    <table style="width: 100%;border-collapse:collapse;" cellpadding="1" cellspacing="0" border="1">
                        <thead>
                            <tr class="table-tr" style="background-color: #E3E3E3;">
                                <th style="text-align: center" scope="col">
                                    <strong>SL</strong>
                                </th>
                                <th style="text-align: left" scope="col">
                                    <strong>Leave Type</strong>
                                </th>
                                <th class="text-left" scope="col">
                                    <strong>Entitled</strong>
                                </th>
                                <th class="text-left" scope="col">
                                    <strong>Availed</strong>
                                </th>
                                {{-- <th class="text-left" scope="col">
                                    <strong>Late Deducted</strong>
                                </th> --}}

                                <th class="text-left" scope="col">
                                    <strong>Balance</strong>
                                </th>
                            </tr>
                        </thead>

                        <tbody>
                            @if (!empty($info))
                                @foreach ($info as $leave_data)
                                    <tr>
                                        <td style="text-align: center">{{ $loop->iteration }}</td>
                                        <td class="text-left">{{ $leave_data->leave_type_lkp_name }}</td>
                                        <td style="text-align: center">{{ $leave_data->no_of_days }}</td>
                                        <td style="text-align: center">{{ $leave_data->leave }}</td>
                                        {{-- <td class="text-left"></td> --}}
                                        <td style="text-align: center">{{ $leave_data->no_of_days - $leave_data->leave }}</td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>

                    <div style="text-align:center; margin-bottom:20px; margin-left:90px; margin-top:15px;" class="mb-2">
                        <h3 class="report-name" style="margin-right:112px;">Approval Pending Leaves</h3>
                    </div>
                    <table style="width: 100%;border-collapse:collapse; margin-top:20px;" cellpadding="1" cellspacing="0" border="1">
                        <thead>
                            <tr class="table-tr" style="background-color: #E3E3E3;">
                                <th style="text-align: center" scope="col">
                                    <strong>SL</strong>
                                </th>
                                <th style="text-align: left" scope="col">
                                    <strong>Leave Type</strong>
                                </th>
                                <th class="text-left" scope="col">
                                    <strong>From Date</strong>
                                </th>
                                <th class="text-left" scope="col">
                                    <strong>To Date</strong>
                                </th>
                                <th class="text-left" scope="col">
                                    <strong>Total Days</strong>
                                </th>
                                <th class="text-left" scope="col">
                                    <strong>Reason</strong>
                                </th>
                            </tr>
                        </thead>

                        <tbody>
                            @if (!empty($appliedLeave))
                                @foreach ($appliedLeave as $applied_data)
                                    <tr>
                                        <td style="text-align: center">{{ $loop->iteration }}</td>
                                        <td class="text-left">{{ $applied_data->leave_type_name }}</td>
                                        <td style="text-align: center">
                                            @if (!empty($applied_data->from_date))    
                                            {{ date('d/m/Y', strtotime($applied_data->from_date)) }}
                                            @endif
                                        </td>
                                        <td style="text-align: center">
                                            @if (!empty($applied_data->to_dates))
                                                {{ date('d/m/Y', strtotime($applied_data->to_dates)) }}
                                            @endif
                                        </td>
                                        <td style="text-align: center">
                                            @if (!empty($applied_data->from_date) && !empty($applied_data->to_dates))
                                            <?php
                                                $date1 = new DateTime($applied_data->from_date);
                                                $date2 = new DateTime($applied_data->to_dates);
                                                $interval = $date1->diff($date2);
                                                echo $interval->days + 1;
                                            ?>
                                            @endif
                                        </td>
                                        <td style="text-align: left">{{ $applied_data->leave_reason }} {{ isset($applied_data->al_dayoff_date) ? '(HD: '. date('d-m-Y', strtotime($applied_data->al_dayoff_date)).')' :  "" }}</td>
                                    </tr>
                                    
                                @endforeach
                            @endif
                        </tbody>
                    </table>

                    <div style="text-align:center; margin-bottom:20px; margin-left:90px; margin-top:15px;" class="mb-2">
                        <h3 class="report-name" style="margin-right:112px;">Availed Leave Details</h3>
                    </div>

                   <table style="width: 100%;border-collapse:collapse; margin-top:20px;" cellpadding="1" cellspacing="0" border="1">
                        <thead>
                            <tr class="table-tr" style="background-color: #E3E3E3;">
                                <th style="text-align: center" scope="col">
                                    <strong>SL</strong>
                                </th>
                                <th style="text-align: left" scope="col">
                                    <strong>Leave Type</strong>
                                </th>
                                <th class="text-left" scope="col">
                                    <strong>From Date</strong>
                                </th>
                                <th class="text-left" scope="col">
                                    <strong>To Date</strong>
                                </th>
                                <th class="text-left" scope="col">
                                    <strong>Total Days</strong>
                                </th>
                                <th class="text-left" scope="col">
                                    <strong>Reason</strong>
                                </th>
                            </tr>
                        </thead>

                        <tbody>
                            @if (!empty($availedInfo))
                                @foreach ($availedInfo as $availed_data)
                                    <tr>
                                        <td style="text-align: center">{{ $loop->iteration }}</td>
                                        <td class="text-left">{{ $availed_data->leave_type_name }}</td>
                                        <td style="text-align: center">
                                            @if (!empty($availed_data->from_date))    
                                            {{ date('d/m/Y', strtotime($availed_data->from_date)) }}
                                            @endif
                                        </td>
                                        <td style="text-align: center">
                                            @if (!empty($availed_data->to_dates))
                                                {{ date('d/m/Y', strtotime($availed_data->to_dates)) }}
                                            @endif
                                        </td>
                                        <td style="text-align: center">
                                            @if (!empty($availed_data->from_date) && !empty($availed_data->to_dates))
                                            <?php
                                                $date1 = new DateTime($availed_data->from_date);
                                                $date2 = new DateTime($availed_data->to_dates);
                                                $interval = $date1->diff($date2);
                                                echo $interval->days + 1;
                                            ?>
                                            @endif
                                        </td>
                                        <td style="text-align: left">{{ $availed_data->leave_reason }}</td>
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
