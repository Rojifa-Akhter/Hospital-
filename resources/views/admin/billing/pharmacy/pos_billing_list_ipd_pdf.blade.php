<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Doctor Performance Summary Report</title>
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
            height: 2.5cm;
            border-bottom: 1px solid;
            padding: 0 1cm;
        }

        header img {
            /*width: 80px;*/
        }

        /** Define now the real margins of every page in the PDF **/
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

        th,
        td {
            padding: 5px;
        }
    </style>
</head>

<body>
    <header>
        <table style="width: 100%; border:5px solid transparent !important" class="signature">
            {{-- @if ($po_hospital_details->report_header_image_prshde_ind == 1) --}}
            <tr style="">
                <td style="width: 15%; border-right:1px solid transparent!important">
                @if(!empty($po_hospital_details->logo) && !file_exists(asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo)))
                    <img class="hospital-logo"
                        src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}" width="60"
                        alt="">
                @endif

                </td>
                <td style="">
                    <span style="font-size: 15px;"> <strong>
                            {{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }}</strong></span>
                    <br>
                    Address:<span>
                        {{ isset($po_hospital_details->addrress1) ? $po_hospital_details->addrress1 : '' }}</span><br>
                    Phone
                    No:<span>{{ isset($po_hospital_details->telephone1) ? $po_hospital_details->telephone1 : '' }}</span>
                </td>
            </tr>
            {{-- @else
                <tr>
                    <td style="text-align: center">
                        @if ($po_hospital_details->report_header_image != '')
                            <img class="hospital-logo"
                                src="{{ asset('images/uploads/hospital_images/' . $po_hospital_details->report_header_image) }}"
            width="250px" alt="">
            @endif

            </td>
            </tr>
            @endif --}}
        </table>
    </header>
    <div style="width: 100%;">
        <div style=" text-align:center; margin-bottom:5px; margin-top:15px  ">
            <span class="report-name" style="width:70%; border:solid black 1px; padding:10px;  ">Medicine Bill
            </span>
        </div>
    </div>

    <div class="signature_">
        <table style="width: 100%;">
            <tr style=" ">

                <td style="text-align:right; ">
                    <span style="padding:5px; border-top: black solid 1px;"> MANAGER </span>
                </td>
            </tr>
        </table>
    </div>

    <footer class="">
        <div class="footer ">
            <div class="container">
                <table style="width: 100%; padding:3px; margin: 0">
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


    <main class="">
        <div class="wrapper">

            <section id="lp-items ">
                <div class="container ">
                    <table style="width: 100%">
                        @if (!empty($bill_info))
                        <tr>
                            <th style="text-align: left; width:15%"> Admission Id </th>
                            <th style="text-align: left"> : {{ $bill_info[0]->admission_no_pk }}</th>

                            <th style="text-align: ; width:15%">Patient Code </th>
                            <th style="text-align: left"> : {{ $bill_info[0]->patient_code }}</th>

                            <th style="text-align: left; width:15%">Patient Name </th>
                            <th style="text-align: left"> : {{ $bill_info[0]->patient_name }} </th>
                        </tr>
                        <tr>
                            <th style="text-align: left; width:15%">Genger </th>
                            <th style="text-align: left"> : {{ $bill_info[0]->patient_gender }}</th>

                            <th style="text-align: ; width:15%">Mobile </th>
                            <th style="text-align: left"> : {{ $bill_info[0]->mobile1 }}</th>
                            @php
                                $pat_dob = new \DateTime($bill_info[0]->dob);
                                $invoice_date = new \DateTime( $bill_info[0]->admission_date);
                                $interval = $invoice_date->diff($pat_dob);

                            @endphp
                            <th style="text-align: left; width:15%">Age </th>
                            <th style="text-align: left"> : {{ $interval->format('%yY %mM %dD') }} {{ $bill_info[0]->age }} </th>
                        </tr>
                        <tr>
                            <th style="text-align: left; width:15%">Department </th>
                            <th style="text-align: left"> : {{ $bill_info[0]->su_name }}</th>

                            <th style="text-align: ; width:15%">Ward </th>
                            <th style="text-align: left"> : {{ $bill_info[0]->ward_name }}</th>

                            <th style="text-align: left; width:15%">Bed </th>
                            <th style="text-align: left"> : {{ $bill_info[0]->bed_name }} </th>
                        </tr>
                        @endif

                    </table>

                    <table style="width:100%;border-collapse:collapse;" cellpadding="1" cellspacing="0" border="1">
                        <thead>
                            <tr>
                                <th style="line-height: 1.6;text-align: center" scope="">SL</th>
                                <th style="line-height: 1.6;text-align: left" scope="">Invoice Info</th>
                                {{-- <th style="text-align: left" scope="col">Patient Info</th> --}}
                                <th style="text-align: left" scope="col">
                                    <table style="width: 100%">
                                        <tr style="line-height: .8;">
                                            <th style="width: 65%;text-align: left">Item Info</th>
                                            <th style="width: 10%;text-align:right">Qty</th>
                                            <th style="width: 10%;text-align:right">Cx. Qty</th>
                                            <th style="width: 20%;text-align:right">Amt.</th>
                                        </tr>
                                        {{-- @foreach ($item_info as $item)
                                        @if ($value->invoice == $item->invoice_no_fk)
                                                <tr>
                                                    <td style="width: 65%;">{{ $item->item_name }}</td>
                                        <td style="width: 10%;text-align:right">{{ $item->current_item_qty }}</td>
                                        <td style="width: 10%;text-align:right">{{ $item->cancel_qty }}</td>
                                        <td style="width: 20%;text-align:right">{{ $item->total_item_amt }}</td>
                            </tr>

                            @endif
                            @endforeach --}}
                    </table>

                    </th>
                    {{-- <th style="text-align: left" scope="col">Cx. Qty</th>
                                <th style="text-align: left" scope="col">Qty</th> --}}
                    <th style="text-align: right" scope="col">Sales Amt.</th>
                    {{-- <th style="text-align: right" scope="col">Discount Amt.</th>
                                <th style="text-align: right" scope="col">Payment Amt.</th>
                                <th style="text-align: right" scope="col">Due</th>
                                <th style="text-align: right" scope="col">Refunt</th> --}}

                    </tr>


                    </thead>
                    <tbody>
                        @php
                        $sl = 1;
                        $sales = 0;
                        $sales_cancel = 0;
                        $net_sales = 0;
                        $refunt_amt = 0;
                        $dis = 0;
                        $payment = 0;
                        $due = 0;
                        $refund = 0;
                        $total_sales = 0;
                        $total_sales_cancel = 0;
                        $total_net_sales = 0;
                        $total_refund_amt = 0;
                        $total_dis = 0;
                        $total_payment = 0;
                        $total_due = 0;
                        $total_refund = 0;
                        @endphp
                        @if (!empty($bill_info))

                        @foreach ($bill_info as $value)
                        @php
                        $net_sales = $value->ledger_amt_sales != '' ? $value->ledger_amt_sales : 0;
                        $sales = $value->sales != '' ? $value->sales : 0;
                        $sales_cancel = $value->sales_cancel != '' ? $value->sales_cancel : 0;
                        $refunt_amt = $value->refund != '' ? $value->refund : 0;
                        $dis = $value->discount != '' ? $value->discount : 0;
                        $payment = $value->collection != '' ? $value->collection : 0;
                        $payable = (($sales -$refunt_amt) - $dis) - $payment;
                        $due = $payable >= 0 ? $payable : 0;
                        $refund = $refunt_amt > 0 ? abs($refunt_amt) :0;
                        @endphp
                        <tr>
                            <td style="text-align: center" scope="col">{{ $sl++ }}</td>
                            <td style="line-height: 80%;text-align: left" scope="">
                                Invoice Id = {{ $value->invoice }} <br>
                                Invoice Date =
                                {{ $value->invoice_date != '' ? date('d/m/Y', strtotime($value->invoice_date)) : '' }}
                                <br>
                                Invoice time
                                ={{ $value->au_entry_time != '' ? date('h:i:s a', strtotime($value->au_entry_time)) : '' }}
                            </td>
                            {{-- <td style="text-align: left" scope="col">
                                            Admission Id = {{ $value->admission_no_pk }} <br>
                            {{ $value->patient_code }} <br>
                            {{ $value->patient_name }} <br>
                            {{ $value->patient_gender }} <br>
                            {{ $value->mobile1 }}
                            </td> --}}
                            <td style="text-align: left" scope="col">

                                @if (!empty($item_info))
                                @php
                                $no = 1;
                                @endphp
                                <table style="width: 100%">
                                    {{-- <tr>
                                                        <th style="width: 5%"></th>
                                                        <th style="width: 10%;text-align:right">Qty</th>
                                                        <th style="width: 10%;text-align:right">Cx. Qty</th>
                                                        <th style="width: 20%;text-align:right">Amt.</th>
                                                    </tr> --}}
                                    @foreach ($item_info as $key => $item)
                                    @if ($value->invoice == $item->invoice_no_fk)
                                    <tr style="line-height: .05;">
                                        <td style="width: 65%;">{{ $no++ }}.
                                            {{ $item->item_name }}
                                        </td>
                                        <td style="width: 10%;text-align:right">
                                            {{ $item->item_qty }}
                                        </td>
                                        <td style="width: 10%;text-align:right">
                                            {{ $item->cancel_qty }}
                                        </td>
                                        <td style="width: 20%;text-align:right">
                                            {{ $item->total_item_amt }}
                                        </td>
                                    </tr>
                                    @endif
                                    @endforeach
                                </table>
                                @endif
                            </td>
                            {{-- <td style="text-align: right" scope="col">
                                            @if (!empty($item_info))
                                                @php
                                                    $no = 1;
                                                @endphp
                                                @foreach ($item_info as $item)
                                                    @if ($value->invoice == $item->invoice_no_fk)
                                                        <table>
                                                            <tr>

                                                                <td>{{ $item->current_item_qty }}</td>
                        </tr>
                        </table>
                        @endif
                        @endforeach
                        @endif


                        </td>
                        <td style="text-align: right" scope="col">
                            @if (!empty($item_info))
                            @php
                            $no = 1;
                            @endphp
                            @foreach ($item_info as $item)
                            @if ($value->invoice == $item->invoice_no_fk)
                            <table>
                                <tr>

                                    <td>{{ $item->total_item_amt }}</td>
                                </tr>
                            </table>
                            @endif
                            @endforeach
                            @endif


                        </td> --}}
                        <td style="text-align: right" scope="col">{{ number_format(round($net_sales), 2) }}
                        </td>
                        {{-- <td style="text-align: right" scope="col">{{ number_format($dis, 2) }}</td>
                        <td style="text-align: right" scope="col">{{ number_format($payment, 2) }}
                        </td>
                        <td style="text-align: right" scope="col">{{ number_format($due, 2) }}</td>
                        <td style="text-align: right" scope="col">{{ number_format($refund, 2) }}
                        </td> --}}

                        </tr>

                        @php
                        $total_net_sales +=round($net_sales);
                        $total_sales += $sales;
                        $total_sales_cancel += $sales_cancel;
                        $total_refund_amt += $refunt_amt;
                        $total_dis += $dis;
                        $total_payment += $payment;
                        $total_due += $due;
                        $total_refund += $refund;
                        @endphp
                        @endforeach
                        <tr>
                            <th style=" line-height: .5;text-align: right" colspan="3">
                                <h3> Total Sales Amt </h3>
                                <h3> Cancel Amt </h3>
                                <h3> Net Sales Amt </h3>
                                <h3> Total Discount </h3>
                                {{-- <h3> Total Refund </h3> --}}
                                <h3> Total Payment </h3>
                                <h3> Total Due</h3>
                                <h3> Total Refund</h3>
                            </th>
                            <td style=" line-height: .5;text-align: right" scope="col">
                                @php
                                $total_payment = $total_payment - abs($total_refund_amt);
                                $due_refunt=($total_net_sales - $total_dis) - $total_payment ;
                                @endphp
                                <h4>{{ number_format($total_sales, 2) }} </h4>
                                <h4>{{ number_format($total_sales_cancel, 2) }} </h4>
                                <h4>{{ number_format($total_net_sales, 2) }} </h4>
                                <h4>{{ number_format($total_dis, 2) }} </h4>
                                {{-- <h4>{{ number_format($total_refund_amt, 2) }} </h4> --}}
                                <h4>{{ number_format($total_payment, 2) }} </h4>
                                <h4>{{ $due_refunt >=0?  number_format($due_refunt, 2) : 0  }} </h4>
                                <h4>{{ $due_refunt < 0?  number_format(abs($due_refunt), 2) : 0 }} </h4>
                            </td>

                            {{--
                                    <td style="text-align: right" scope="col">
                                        <strong>{{ number_format($total_dis, 2) }} </strong> </td>
                            <td style="text-align: right" scope="col"> <strong>
                                    {{ number_format($total_payment, 2) }} </strong> </td>
                            <td style="text-align: right" scope="col"> <strong>
                                    {{ number_format($total_due, 2) }} </strong> </td>
                            <td style="text-align: right" scope="col">
                                <strong>{{ number_format($total_refund, 2) }} </strong>
                            </td> --}}

                        </tr>
                        @endif
                    </tbody>


                    </table>
                </div>
            </section>
        </div>
    </main>




    {{-- <footer class="">
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
        </strong></td>
    </tr>
    </table>
    </div>
    </div>
    </footer> --}}
</body>

</html>
