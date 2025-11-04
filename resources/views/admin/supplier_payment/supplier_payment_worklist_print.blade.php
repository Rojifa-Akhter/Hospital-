<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Lp Report</title>
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
            padding-bottom: 5px;
        }

        header img {
            /*width: 80px;*/
        }

        /** Define now the real margins of every page in the PDF **/
        body {
            margin-top: 2.5cm;
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
            <tr>
                <td style="width: 25%;">
                    @if (!empty($po_hospital_details->logo))
                        <img class="hospital-logo"
                            src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}"
                            width="60" alt="">
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
                <td style=" text-align:right; width: 25%; ">
                    <div style="">
                        <img src="data:image/png;base64, {{ $barcode_no }} " width="100px" height="30px" />
                    </div>

                </td>
            </tr>
        </table>
    </header>
    <div style="width: 100%; margin-bottom:5px; margin-top:10px ">
        <div style=" text-align:center;  ">
            <span class="report-name" style="width:70%; border:solid black 1px; padding:10px;  "> Supplier Payment
                Report</span>
        </div>
    </div>

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
                                {{ $date }}
                            </strong> Printed By: <strong>{{ Session::get('user.ses_user_name') }}</strong></td>
                        <td style="font-size: 9px; text-align: right;"><strong>Powered By - H360 [NextGenIT]
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


                    <table style="margin:0; padding: 0; width:100%; border-collapse:collapse;">

								&nbsp;
								{{-- @if ($supplier_name != '')

								<tr>
									<th style="text-align: left ;border:none;padding:5px;width:100px"> Supplier Name </th>
									<td style="text-align: left ;border:none"> : {{ $supplier_name }}</td>
								</tr>
								@endif
								@if ($po != '')

								<tr>
									<th style="text-align: left ;border:none;padding:5px;width:100px"> PO </th>
									<td style="text-align: left ;border:none"> : {{ $po }}</td>
								</tr>
								@endif --}}
								@if ($from_date != '' && $to_date != '')

								<tr>
									<th style="text-align: left ;border:none;padding:5px;width:100px"> From date </th>
									<td style="text-align: left ;border:none"> : {{ date('d/m/Y', strtotime($from_date)) }}, <strong> To date
									</strong> : {{date('d/m/Y', strtotime($to_date))  }}</td>
								</tr>
								@elseif ($from_date !="")
								<tr>
									<th style="text-align: left ;border:none;padding:5px;width:100px"> Date</th>
									<td style="text-align: left ;border:none"> : {{date('d/m/Y', strtotime($from_date)) }}</td>
								</tr>
                                @else
                                <tr>
									<th style="text-align: left ;border:none;padding:5px;width:100px"> Date</th>
									<td style="text-align: left ;border:none"> : {{date('d/m/Y') }}</td>
								</tr>
								@endif

							</table>
                    <table style="width:100%;border-collapse:collapse;" cellpadding="1" cellspacing="0" border="1">
                        <thead class="bg-primary">
                            <tr>
                                <th class="text-center">Sl</th>
                                <th class="text-center">Ledger UID</th>
                                <th class="text-center">PO UID</th>
                                <th class="text-center">Payment Date</th>
                                <th class="text-center" style="width: 150px">Pay Mode</th>
                                <th class="text-center">Bill/Challan</th>
                                <th class="text-center">Bill/Challan Date</th>
                                <th class="text-left">Payment Status</th>
                                <th class="text-right">PO Amt.</th>
                                <th class="text-right">Payment Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($type == 'payment')
                                @if (!empty($payment_data))
                                    @php
                                        $total = 0;
                                        $total_po = 0;
                                    @endphp
                                    @foreach ($payment_data as $key => $data)
                                        @php
                                            $sup_pay_total = 0;
                                            $sup_po_total = 0;
                                            $supplier_name = explode('_', $key);
                                        @endphp

                                        <tr>
                                            <td class="text-left" colspan="10"> <strong> Uid =
                                                    {{ $supplier_name[2] }}, Name = {{ $supplier_name[1] }}
                                                </strong>
                                            </td>
                                        </tr>
                                        @foreach ($data as $value)
                                            @php
                                                $sup_pay_total += $value->po_amount_payment;
                                                $sup_po_total += $value->po_amount;
                                            @endphp
                                            <tr>
                                                <td style="text-align: center">{{ $loop->iteration }}</td>
                                                <td style="text-align: center">
                                                    {{ !empty($value->supledger_no_uid) ? ucfirst($value->supledger_no_uid) : '' }}
                                                </td>
                                                <td style="text-align: center">
                                                    {{ !empty($value->purchase_uid) ? ucfirst($value->purchase_uid) : '' }}
                                                </td>

                                                <td class="text-left">
                                                    {{ !empty($value->supledger_date) ? date('d/m/Y', strtotime($value->supledger_date)) : '' }}
                                                </td>
                                                <td class="text-left">
                                                    @if ($value->pay_mode == 'cash')
                                                        {{ !empty($value->pay_mode) ? $value->pay_mode : '' }}
                                                    @else
                                                        {{ !empty($value->pay_mode) ? $value->pay_mode : '' }}

                                                        <div > <strong> Cheque No : </strong> </div>
                                                        {{ !empty($value->pay_cqcc_number) ? $value->pay_cqcc_number : '' }}

                                                        <div ><strong>Cheque Holder Name : </strong></div>
                                                        {{ !empty($value->pay_cqcc_holder_name) ? $value->pay_cqcc_holder_name : '' }}

                                                        <div ><strong>Pay Bank Name : </strong></div>
                                                        {{ !empty($value->pay_bank_name) ? $value->pay_bank_name : '' }}
                                                    @endif
                                                </td>


                                                <td class="text-left">
                                                    {{ !empty($value->bill_challan_number) ? $value->bill_challan_number : '' }}
                                                </td>
                                                <td class="text-left">
                                                    {{ !empty($value->bill_challan_date) ? date('d/m/Y', strtotime($value->bill_challan_date)) : '' }}
                                                </td>

                                                <td class="text-left">
                                                    {{-- @if ($value->prepared_ind == 1)
                                                        <span
                                                            class="badge badge-warning">{{ ucfirst('Prepared') }}</span>,
                                                            @endif --}}
                                                    @if ($value->issue_ind == 1)
                                                        <span
                                                            class="badge badge-success">{{ ucfirst('paid') }}</span>,
                                                            @endif
                                                    @if ($value->finalized_ind == 1)
                                                        <span
                                                            class="badge badge-primary">{{ ucfirst('finalize') }}</span>,
                                                            @endif
                                                    @if ($value->po_fullpaid_ind == 1)
                                                        <span
                                                            class="badge badge-primary">{{ ucfirst('Full Paid') }}</span>,
                                                            @endif
                                                    @if ($value->cancel_ind == 1)
                                                        <span
                                                            class="badge badge-danger">{{ ucfirst('cancelled') }}</span>,

                                                    @endif
                                                    {{-- <span class="badge ">{{ $payment_status !="" ? $payment_status : ""  }}</span> --}}

                                                </td>
                                                <td class="text-right" style="text-align: right">
                                                    {{ !empty($value->po_amount) ? number_format($value->po_amount, 2) : '' }}
                                                </td>
                                                <td class="text-right" style="text-align: right">
                                                    {{ !empty($value->po_amount_payment) ? number_format($value->po_amount_payment, 2) : '' }}
                                                </td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td class="text-right" style="text-align: right" colspan="9">
                                                <strong>Sub-Total </strong>
                                            </td>
                                            {{-- <td class="text-right" style="text-align: right" colspan=""> <strong>
                                                    {{ number_format($sup_po_total, 2) }}
                                                </strong>
                                            </td> --}}
                                            <td class="text-right" style="text-align: right" colspan=""> <strong>
                                                    {{ number_format($sup_pay_total, 2) }}
                                                </strong>
                                            </td>
                                        </tr>
                                        @php
                                            $total += $sup_pay_total;
                                            $total_po += $sup_po_total;
                                        @endphp
                                    @endforeach
                                    <tr>
                                        <td style="text-align: right" colspan="9"> <strong>Net Amount</strong></td>
                                        {{-- <td style="text-align: right" colspan=""> <strong>
                                                {{ number_format($total_po, 2) }}
                                            </strong>
                                        </td> --}}
                                        <td style="text-align: right" colspan=""> <strong>
                                                {{ number_format($total, 2) }}
                                            </strong>
                                        </td>
                                    </tr>
                                @endif

                                {{-- @elseif ($type == 'finalize')
                                        @if (!empty($finalize_data))
                                            @foreach ($finalize_data as $data)
                                                <tr>
                                                    <td class="text-left">{{ $loop->iteration }}</td>
                                                    <td class="text-left">
                                                        {{ !empty($data->supplier_name) ? $data->supplier_name : '' }}</td>
                                                    <td class="text-left">
                                                        {{ !empty($data->pay_cqcc_number) ? $data->pay_cqcc_number : '' }}</td>
                                                    <td class="text-left">
                                                        {{ !empty($data->supledger_date) ? date('d/m/Y', strtotime($data->supledger_date)) : '' }}
                                                    </td>
                                                    <td class="text-left">
                                                        {{ !empty($data->payment_amount) ? $data->payment_amount : '' }}</td>
                                                    <td class="text-right">
                                                        {{ !empty($data->bill_challan_number) ? $data->bill_challan_number : '' }}
                                                    </td>
                                                    <td class="text-left">
                                                        {{ !empty($data->bill_challan_date) ? date('d/m/Y H:i', strtotime($data->bill_challan_date)) : '' }}
                                                    </td>
                                                    <td class="text-center">
                                                        @if ($data->prepared_ind == 1)
                                                            <span class="badge badge-warning">{{ 'draft' }}</span>
                                                        @elseif ($data->issue_ind == 1)
                                                            <span class="badge badge-success">{{ 'paid' }}</span>
                                                        @elseif ($data->finalized_ind == 1)
                                                            <span class="badge badge-primary">{{ 'finalize' }}</span>
                                                        @elseif ($data->cancel_ind == 1)
                                                            <span class="badge badge-danger">{{ 'cancelled' }}</span>
                                                        @endif
                                                    </td>
                                                    <td class="text-center"><button
                                                            class="btn btn-outline-primary btn-md">{{ 'Detail' }}</button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif


                                    @elseif ($type == 'disbursement')
                                        @if (!empty($disbursement_data))
                                            @foreach ($disbursement_data as $data)
                                                <tr>
                                                    <td class="text-left">{{ $loop->iteration }}</td>
                                                    <td class="text-left">
                                                        {{ !empty($data->supplier_name) ? $data->supplier_name : '' }}</td>
                                                    <td class="text-left">
                                                        {{ !empty($data->pay_cqcc_number) ? $data->pay_cqcc_number : '' }}</td>
                                                    <td class="text-left">
                                                        {{ !empty($data->supledger_date) ? date('d/m/Y', strtotime($data->supledger_date)) : '' }}
                                                    </td>
                                                    <td class="text-left">
                                                        {{ !empty($data->payment_amount) ? $data->payment_amount : '' }}</td>
                                                    <td class="text-right">
                                                        {{ !empty($data->bill_challan_number) ? $data->bill_challan_number : '' }}
                                                    </td>
                                                    <td class="text-left">
                                                        {{ !empty($data->bill_challan_date) ? date('d/m/Y H:i', strtotime($data->bill_challan_date)) : '' }}
                                                    </td>

                                                    <td class="text-center">
                                                        @if ($data->prepared_ind == 1)
                                                            <span class="badge badge-warning">{{ 'draft' }}</span>
                                                        @elseif ($data->issue_ind == 1)
                                                            <span class="badge badge-success">{{ 'paid' }}</span>
                                                        @elseif ($data->finalized_ind == 1)
                                                            <span class="badge badge-primary">{{ 'finalize' }}</span>
                                                        @elseif ($data->cancel_ind == 1)
                                                            <span class="badge badge-danger">{{ 'cancelled' }}</span>
                                                        @endif
                                                    </td>
                                                    <td class="text-center"><button
                                                            class="btn btn-outline-primary btn-md">{{ 'Detail' }}</button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif --}}
                            @endif


                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </main>
    <footer class="">
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
    </footer>
</body>

</html>
