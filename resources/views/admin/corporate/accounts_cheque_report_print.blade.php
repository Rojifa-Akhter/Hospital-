<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ $type }} Report</title>
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
            <div style=" text-align:center; margin-bottom:5px; margin-top:20px  " >
                <span class="report-name" style="width:70%; border:solid black 1px; padding:10px;  ">
                    {{ $type }} Report
                </span>
            </div>
            <div style=" text-align:center;  width:100%;" >

                <span class="report-date">@if($from_date != '01-01-1970')<strong>From Date: {{ $from_date }}</strong> - <span
                        class="report-date"><strong>To Date: {{ $to_date }}</strong></span>@endif
                </span>

            </div>
            <section id="lp-items">
                <div class="container">
                    <table style="width: 100%;border-spacing: 0; margin-top:10px" cellpadding="1">
                        <tr class="table-tr" style="background-color: #E3E3E3;">
                            <td class="table-td" scope="col" style="width: 20px;text-align: left;">
                                <strong>SL#</strong>
                            </td>

                            <td class="table-td" scope="col" style="text-align: left;">
                                <strong>Cheque Date</strong>
                            </td>

                            <td class="table-td" scope="col" style="text-align: left;">
                                <strong>Pay To</strong>
                            </td>

                            <td class="table-td" scope="col" style="text-align: left;">
                                <strong>Bank name</strong>
                            </td>

                            <td class="table-td" scope="col" style="text-align: left;">
                                <strong>Cheque Number</strong>
                            </td>

                            <td class="table-td" scope="col" style="text-align: left;">
                                <strong>Cheque Amount</strong>
                            </td>
                            <td class="table-td" scope="col" style="text-align: left;">
                                <strong>Pay Type</strong>
                            </td>
                            <td class="table-td" scope="col" style="text-align: left;">
                                <strong>Purpose</strong>
                            </td>
                            {{-- <td class="table-td" scope="col" style="text-align: left;">
                                <strong>Prepared by</strong>
                            </td> --}}
                            {{-- <td class="table-td" scope="col" style="text-align: left;">
                                <strong>Print Count</strong>
                            </td> --}}
                            <td class="table-td" scope="col" style="text-align: left;">
                                <strong>Received by</strong>
                            </td>

                        </tr>
                        @php
                            $total_cheque_amt = 0;
                        @endphp
                        @if (!empty($cheques))
                        @foreach ($cheques as $cheque)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="text-left">
                                    {{ !empty($cheque->chq_date) ? date('d/m/Y', strtotime($cheque->chq_date)) : 'N/A' }}
                                </td>
                                <td class="text-left">
                                    {{ !empty($cheque->chq_pay_to) ? $cheque->chq_pay_to : 'N/A' }}
                                </td>
                                <td class="text-left">
                                    {{ !empty($cheque->chq_bank_name) ? $cheque->chq_bank_name : 'N/A' }}
                                </td>
                                <td class="text-right" style="text-align: left;">
                                    {{ !empty($cheque->account_number) ? $cheque->account_number : 'N/A' }}
                                </td>
                                <td class="text-right" style="text-align: right;">
                                    {{ !empty($cheque->chq_amount) ? number_format($cheque->chq_amount,2) : 'N/A' }}

                                </td>
                                <td class="text-left">
                                    @if ($cheque->chq_account_pay_ind == 1)
                                        Cheque
                                    @else
                                        Cash
                                    @endif

                                </td>
                                <td class="text-left">
                                    {{ !empty($cheque->remarks) ? $cheque->remarks : 'N/A' }}
                                </td>
                                {{-- <td class="text-left">
                                    {{ !empty($cheque->user_fullname) ? $cheque->user_fullname : 'N/A' }}
                                </td> --}}
                                {{-- <td class="text-end" style="text-align: center;">
                                    {{ !empty($cheque->print_count) ? $cheque->print_count : '0' }}
                                </td> --}}
                                <td class="text-left"></td>
                                </tr>
                                @php
                                    $total_cheque_amt = $total_cheque_amt + $cheque->chq_amount;
                                @endphp
                            @endforeach
                        @endif

                        <tfoot>
                            <tr>
                                <td style="text-align:right" colspan="5">Total Amount = </td>
                                <td style="text-align:right" ><strong>{{isset($total_cheque_amt) ? number_format($total_cheque_amt, 2) : '0'}}</strong></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tfoot>


                    </table>
                </div>
            </section>
        </div>
    </main>





</body>

</html>
