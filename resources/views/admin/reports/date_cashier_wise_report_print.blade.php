<?php
$po_hospital_details = DB::table('WSEC_HOSPITAL')
    // ->select('logo', 'hospital_name', 'hospital_name', 'addrress1', 'telephone1')
    ->first();
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>date wise cashier report</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="" />
    <!-- custom style -->


    <style>
        @page {
            padding-bottom: 100px;
        }

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
            font-size: 12px;
        }

        footer {
            bottom: 0;
            left: 0cm;
            right: 0cm;
        }

        .signature_ {
            position: fixed;
            bottom: 1.6cm;
            left: .8cm;
            right: .8cm;
            width: 100%;
        }

        .tr_border td,
        .tr_border th {
            border: 1px solid #222;
        }
    </style>

</head>
@php
    $invoice_arr = 0;
    $invoice_su_arr[] = [];
@endphp

<body>

    <table style="width: 100%;border-collapse:collapse;" cellpadding="1" cellspacing="0">
        <thead>
            <tr>
                <td colspan="12" style="">
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
                    <div style="text-align: center;"> <strong>
                            @if ($po_hospital_details->hospital_code == 'GMC')
                                Cashier Wise Collection Report
                            @else
                                Date Wise
                                Cashier Report
                            @endif
                        </strong> </div>
                    <div style=" text-align:center;  width:100%; margin-bottom:10px" class="mb-2">
                        <span class="report-date"><strong>From Date: {{ $from_date }}</strong> - <span
                                class="report-date"><strong>To Date: {{ $to_date }}</strong></span>
                        </span>
                    </div>
                </td>
            </tr>
            <tr class="tr_border">
                <td class="table-td" scope="col">
                    <strong>SL</strong>
                </td>
                <td class="table-td" scope="col">
                    <strong>Invoice Date</strong>
                </td>
                <td class="table-td" scope="col">
                    <strong>Ledger Date</strong>
                </td>
                <td class="table-td" scope="col">
                    <strong>Patient Name</strong>
                </td>
                <td class="table-td" style="text-align: center;" scope="col">
                    <strong>Transaction No</strong>
                </td>
                <td class="table-td" style="text-align: center;" scope="col">
                    <strong>Invoice No</strong>
                </td>
                <td class="table-td" scope="col" style="text-align: right;">
                    <strong>Sales</strong>
                </td>
                <td class="table-td" scope="col" style="text-align: right;">
                    <strong>Discount</strong>
                </td>
                @if (Session::get('user.ses_hospital_code') != 'EWMCH')
                    <td class="table-td" scope="col" style="text-align: right;"> <strong>Cancel</strong>
                    </td>
                @endif
                <td class="table-td" scope="col" style="text-align: right;">
                    <strong>Net Sales</strong>
                </td>
                <td class="table-td" scope="col" style="text-align: right;">
                    <strong>Collection</strong>
                </td>
                @if (Session::get('user.ses_hospital_code') == 'DMHL' && Session::get('user.serviceunit') == 'Cafeteria')
                    <td class="table-td" scope="col" style="text-align: right;">
                        <strong>Due Collection</strong>
                    </td>
                @endif
                <td class="table-td" scope="col" style="text-align: right;">
                    <strong>Refund</strong>
                </td>
                <td class="table-td" scope="col" style="text-align: right;">
                    <strong>Net Collection</strong>
                </td>
            </tr>
        </thead>
        <tbody class="tr_border">
            <div style="display: none">
                {{ $invoice_count = 0 }}
                {{ $sales_total_final_final = 0 }}
                {{ $sales_discount_final = 0 }}
                {{ $collection_final = 0 }}
                {{ $invoice_count_final = 0 }}
                {{ $net_sales_final = 0 }}
                {{ $due_collection_final = 0 }}
                {{ $due_final = 0 }}
                {{ $refund_final = 0 }}
                {{ $netcollection_final = 0 }}
                {{ $net_sales_cancel = 0 }}
            </div>
            @if (!empty($cashier_arr))
                @foreach ($cashier_arr as $key1 => $cashier_arr1)
                    @if (Session::get('user.ses_hospital_code') == 'GMC')
                        <tr>
                            <td class="text-left" colspan="14"> <strong>{{ $key1 }}</strong></td>
                        </tr>
                    @else
                        <tr>
                            <td class="text-left" colspan="13"> <strong>{{ $key1 }}</strong></td>
                        </tr>
                    @endif
                    @foreach ($cashier_arr1 as $key => $value)
                        @php
                            $str = $key;
                            $service_point = explode('_', $str);
                        @endphp
                        @if (Session::get('user.ses_hospital_code') == 'GMC')
                            <tr>
                                <td class="text-left" colspan="14">
                                    <strong> {{ $service_point[1] }} </strong>
                                </td>
                            </tr>
                        @else
                            <tr>
                                <td class="text-left" colspan="13">
                                    <strong> {{ $service_point[1] }} </strong>
                                </td>
                            </tr>
                        @endif

                        <div style="display: none">

                            {{ $sl_count = 0 }}
                            {{ $sales_total = 0 }}
                            {{ $sales_discount = 0 }}
                            {{ $net_sales = 0 }}
                            {{ $due_collection_total = 0 }}
                            {{ $due = 0 }}
                            {{ $due_total = 0 }}
                            {{ $collection = 0 }}
                            {{ $refund = 0 }}
                            {{ $net_collection = 0 }}
                            {{ $sales_cancel = 0 }}
                        </div>
                        @foreach ($value as $data)
                            @php
                                $invoice_su_arr[$service_point[1]][$key1][$data->invoice_code] = $data->invoice_code;
                                $due = $data->ledger_amt_due > 0 ? round($data->ledger_amt_due) : 0;

                            @endphp


                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="text-center">
                                    {{ date('d/m/Y', strtotime($data->invoice_date)) }}
                                </td>
                                <td class="text-center">
                                    {{ date('d/m/Y', strtotime($data->ledger_datetime)) }}
                                </td>
                                <td class="text-center">
                                    {{ $data->customer_name }} <br>
                                    {{ $data->mobile1 }}

                                </td>
                                {{-- <td class="text-center">{{$value->counter_name}}</td> --}}
                                <td class="text-right" style="text-align: center;">
                                    {{ $data->ledgertrn_no_pk }}
                                </td>
                                <td class="text-right" style="text-align: center;">
                                    {{ $data->invoice_code }}
                                </td>
                                <td class="text-right" style="text-align: right;">
                                    {{ number_format(round($data->ledger_amt_sales), 2) }}
                                </td>

                                <td class="text-right" style="text-align: right;">
                                    {{ number_format($data->ledger_amt_discount, 2) }}
                                </td>

                                @if (Session::get('user.ses_hospital_code') != 'EWMCH')
                                    <td class="text-right" style="text-align: right;">
                                        {{ number_format(round($data->sales_cancel), 2) }}
                                    </td>
                                @endif
                                <td class="text-right" style="text-align: right;">
                                    {{ number_format(round($data->ledger_amt_sales_net), 2) }}
                                </td>
                                <td class="text-right" style="text-align: right;">
                                    @php
                                        $net_sales_arif =
                                            round($data->ledger_amt_sales) -
                                            round($data->ledger_amt_discount) -
                                            round($data->sales_cancel, 2);
                                        $collection_arif = round($data->ledger_amt_payment);
                                        if ($net_sales_arif == 0 && $collection_arif > 0) {
                                            $due_amount_arif = $collection_arif - $net_sales_arif;
                                        } else {
                                            $due_amount_arif = 0;
                                        }

                                    @endphp

                                    @if (Session::get('user.ses_hospital_code') == 'DMHL' && Session::get('user.serviceunit') == 'Cafeteria')
                                        @if ($net_sales_arif == 0 && $collection_arif > 0)
                                            {{ number_format(round(0), 2) }}
                                        @else
                                            {{ number_format(round($data->ledger_amt_payment), 2) }}
                                        @endif
                                    @else
                                        {{ number_format(round($data->ledger_amt_payment), 2) }}
                                    @endif

                                </td>
                                @if (Session::get('user.ses_hospital_code') == 'DMHL' && Session::get('user.serviceunit') == 'Cafeteria')
                                    <td class="text-right" style="text-align: right;">
                                        {{ number_format($due_amount_arif, 2) }}
                                    </td>
                                @endif


                                <td class="text-right" style="text-align: right;">
                                    {{ number_format($data->refund, 2) }}
                                </td>
                                <td class="text-right" style="text-align: right;">
                                    {{ number_format($data->ledger_amt_payment - $data->refund, 2) }}
                                </td>
                                <div style="display: none">

                                </div>
                                <div style="display: none">
                                    {{ $sales_total += $data->ledger_amt_sales }}
                                </div>
                                <div style="display: none">
                                    {{ $sales_discount += $data->ledger_amt_discount }}
                                </div>
                                <div style="display: none">
                                    @if (Session::get('user.ses_hospital_code') == 'DMHL' && Session::get('user.serviceunit') == 'Cafeteria')
                                        @if ($net_sales_arif == 0 && $collection_arif > 0)
                                            {{ $collection = $collection }}
                                        @else
                                            {{ $collection += $data->ledger_amt_payment }}
                                        @endif
                                    @else
                                        {{ $collection += $data->ledger_amt_payment }}
                                    @endif

                                </div>
                                <div style="display: none">
                                    {{ $net_sales += $data->ledger_amt_sales_net - $data->sales_cancel }}
                                </div>

                                <div style="display: none">
                                    {{ $due_collection_total += $due_amount_arif }}
                                </div>

                                @if (Session::get('user.ses_hospital_code') != 'EWMCH')
                                    <div style="display: none">
                                        {{ $sales_cancel += $data->sales_cancel }}
                                    </div>
                                @endif

                                <div style="display: none">{{ $due_total += $due }}</div>
                                <div style="display: none">
                                    {{ $invoice_count += round($data->ledger_amt_due) }}
                                </div>
                                <div style="display: none">{{ $refund += $data->refund }}</div>
                                <div style="display: none">
                                    {{ $net_collection += $data->ledger_amt_payment - $data->refund }}
                                </div>
                            </tr>
                            @php
                                $sl_count += 1;
                            @endphp
                        @endforeach
                        @php
                            $invoice_arr += count($invoice_su_arr[$service_point[1]][$key1]);
                        @endphp
                        <tr>
                            <td class="text-right" style="text-align: right;" colspan="5"><strong>Sub
                                    Total = </strong></td>
                            <td class="text-right" style="text-align: left;">
                                <strong>{{ count($invoice_su_arr[$service_point[1]][$key1]) }}</strong>
                            </td>
                            <td class="text-right" style="text-align: right;">
                                <strong>{{ number_format($sales_total, 2) }}</strong>
                            </td>

                            <td class="text-right" style="text-align: right;">
                                <strong>{{ number_format($sales_discount, 2) }}</strong>
                            </td>
                            @if (Session::get('user.ses_hospital_code') != 'EWMCH')
                                <td class="text-right" style="text-align: right;">
                                    <strong>{{ number_format($sales_cancel, 2) }}</strong>
                                </td>
                            @endif
                            <td class="text-right" style="text-align: right;">
                                <strong>{{ number_format($net_sales, 2) }}</strong>
                            </td>

                            <td class="text-right" style="text-align: right;">
                                <strong>{{ number_format($collection, 2) }}</strong>
                            </td>


                            @if (Session::get('user.ses_hospital_code') == 'DMHL' && Session::get('user.serviceunit') == 'Cafeteria')
                                <td class="text-right" style="text-align: right;">
                                    <strong>{{ number_format($due_collection_total, 2) }}</strong>
                                </td>
                            @endif
                            <td class="text-right" style="text-align: right;">
                                <strong>{{ number_format($refund, 2) }}</strong>
                            </td>
                            <td class="text-right" style="text-align: right;">
                                <strong>{{ number_format($net_collection, 2) }}</strong>
                            </td>



                            <div style="display: none">{{ $sales_total_final_final += $sales_total }}
                            </div>
                            <div style="display: none">{{ $sales_discount_final += $sales_discount }}
                            </div>
                            <div style="display: none">{{ $collection_final += $collection }}</div>
                            <div style="display: none">{{ $net_sales_final += $net_sales }}</div>
                            <div style="display: none">{{ $due_final += $due_total }}</div>
                            <div style="display: none">{{ $refund_final += $refund }}</div>
                            <div style="display: none">{{ $due_collection_final += $due_collection_total }}</div>
                            <div style="display: none">{{ $netcollection_final += $net_collection }}
                            </div>
                            @if (Session::get('user.ses_hospital_code') != 'EWMCH')
                                <div style="display: none">{{ $net_sales_cancel += $sales_cancel }}</div>
                            @endif

                            @php
                                $invoice_count_final += $sl_count;
                            @endphp
                        </tr>
                    @endforeach
                @endforeach

            @endif
            <tr>
                <th class="text-right" style="text-align: right;" colspan="5">Total =</th>
                <th class="text-right bg-light-blue" style="text-align: left;">
                    {{ isset($distinct_invoice_count) ? $distinct_invoice_count : '' }}
                </th>
                <th class="text-right bg-light-blue" style="text-align: right;">
                    {{ number_format($sales_total_final_final, 2) }}
                </th>
                <th class="text-right bg-light-blue" style="text-align: right;">
                    {{ number_format($sales_discount_final, 2) }}
                </th>
                @if (Session::get('user.ses_hospital_code') != 'EWMCH')
                    <th class="text-right bg-light-blue" style="text-align: right;">
                        {{ number_format($net_sales_cancel, 2) }}
                    </th>
                @endif
                <th class="text-right bg-light-blue" style="text-align: right;">
                    {{ number_format($net_sales_final, 2) }}
                </th>
                <th class="text-right bg-light-blue" style="text-align: right;">
                    {{ number_format($collection_final, 2) }}
                </th>

                @if (Session::get('user.ses_hospital_code') == 'DMHL' && Session::get('user.serviceunit') == 'Cafeteria')
                    <th class="text-right bg-light-blue" style="text-align: right;">
                        {{ number_format($due_collection_final, 2) }}
                    </th>
                @endif
                {{-- <th class="text-right bg-light-blue" style="text-align: right;">
                    {{ number_format($due_final, 2) }} </th> --}}
                <th class="text-right bg-light-blue" style="text-align: right;">
                    {{ number_format($refund_final, 2) }}
                </th>
                <th class="text-right bg-light-blue" style="text-align: right;">
                    {{ number_format($netcollection_final, 2) }}
                </th>

            </tr>
        </tbody>

        <tfoot>
            <tr>
                <td style="width: 100%; padding-top: 50px;" colspan="12">
                    @if (Session::get('user.ses_hospital_code') == 'JKMH')
                        <div class="">
                            <table style="width: 100%; border:none ">
                                <tr style=" ">
                                    <td style="text-align:left; border:none ">
                                        <span style="padding:5px; border-top: black solid 1px;"> Prepared By</span>
                                    </td>
                                    <td style="text-align:left; border:none ">
                                        <span style="padding:5px; border-top: black solid 1px;">Manager Accounts</span>
                                    </td>

                                    <td style="text-align:center; border:none">
                                        <span style="padding:5px; border-top: black solid 1px;">DGM
                                        </span>
                                    </td>

                                    <td style="text-align:right; border:none">
                                        <span style="padding:5px; border-top: black solid 1px;">DMD
                                        </span>
                                    </td>

                                </tr>
                            </table>

                        </div>
                    @else
                        <div class="">
                            <table style="width: 100%; border:none;">
                                <tr style=" ">
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
                    @endif

                </td>
            </tr>
            <tr>
                <td style="width: 100%; " colspan="12">
                    <table style="width: 100%; ">
                        <tr>
                            <td style="font-size: 9px; text-align:left;border:none;">Print Date & Time: <strong>
                                    <?php
                                    $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
                                    $date = $dt->format('g:i A');
                                    ?>
                                    {{ date('d/m/Y') }} {{ $date }}
                                </strong> Printed By: <strong>{{ Session::get('user.ses_user_name') }}</strong></td>
                            <td style="font-size: 9px; text-align: right; border:none;"><strong>Powered By - H360
                                    [NextGen]
                                </strong></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </tfoot>
    </table>
    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>

</html>
