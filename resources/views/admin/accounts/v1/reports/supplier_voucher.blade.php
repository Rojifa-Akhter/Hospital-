<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Payment Voucher</title>
    <style type="text/css">
        @page {
            margin: 0px;
        }

        body {
            font-family: 'Courier New', monospace;
            font-size: 12px;
            color: #000000;
        }

        h2,
        h3,
        h4 {
            margin: 0;
        }

        .mt {
            margin-top: 10px;
        }

        .mb {
            margin-top: 10px;
        }

        .text_align_center {
            text-align: center;
        }

        .head_td {
            border: 1px dotted #000000;
            margin: 0;
            padding: 3px;
        }

        table tr td {
            line-height: 1.5;
        }

        .head_td_rec {
            margin: 0;
            padding: 2px;
        }

        .text-right {
            text-align: right;
        }

        .text-left {
            text-align: left;
        }

        .head_td_total_double_line {
            margin: 0;
            padding: 3px;
            border-bottom: 5px double #000000;
            border-top: 2px solid #000000;
        }

        .container {
            margin: 10px 10px 10px 10px;
        }

        .voucher_title {
            text-align: center;
        }

        .td-border {
            border: 1px solid #000000;
        }

        .footer-table {
            position: absolute;
            height: 130px;
            bottom: 40px;
            width: 100%;
            border-spacing: 20px 0;
        }

        .footer-text-height {
            line-height: 10px;
        }

        .title-narration {
            line-height: 12px;
            text-align: justify;
        }

        .footer-text-height td {
            width: 20%;
            padding: 0px;
            border-bottom: dotted 1px #000000;
            font-family: 'Courier New', monospace;
            font-size: 12px;
            color: #000000;
            vertical-align: top;
        }

        .footer-text-height td span {
            display: block;
        }

        .footer-text-height.bottom td {
            padding-top: 60px;
            padding-bottom: 10px;
            border-bottom: none;
        }

        .hospital-logo {
            display: block;
            margin: 0 auto;
        }
        .logo_div {
            margin-left: 10px
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row" style="padding-top: 25px;">
            <div class="col-md-12">
                <div class="logo_div text_align_center">
                    @if (isset($org_info->logo) && !empty($org_info->logo))
                        <img class="hospital-logo" src="{{ asset('images/uploads/hospital_images/' . $org_info->logo) }}"
                            width="100" alt="">
                    @endif
                    <div class="text_align_center">
                        <h2>{{ $org_info->hospital_name ?? '' }}</h2>
                        <h4>{{ $org_info->addrress1 ?? '' }}</h4>
                        <h4>Phone No: {{ $org_info->telephone1 ?? '' }}</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="voucher_title">
            <h1>Payment Voucher</h1>
        </div>

        <div class="row">
            <table style="width: 100%; border-top: dotted 1px #000000;">
                <tr>
                    <td class="text-left">PAYMENT VOUCHER #: <strong>{{ $voucher_no ?? '' }}</strong></td>
                    <td class="text-right">
                        Date: <strong>{{ isset($journal_date) ? date('d/m/Y', strtotime($journal_date)) : '' }}</strong>
                    </td>
                </tr>
            </table>
        </div>

        <div class="row mb" style="border-top: dotted 1px #000000;">
            <table style="width: 60%;">
                <tr>
                    <td class="text-left">Creditor/Vendor Code : {{ $subledgerInfo->subledger_code ?? '' }}</td>
                </tr>
                <tr>
                    <td class="text-left">Payee Name : {{ $subledgerInfo->subledger_name ?? '' }}</td>
                </tr>
                <tr>
                    <td class="text-left">Payee Address: {{ $subledgerInfo->address ?? '' }}</td>
                </tr>
                <tr>
                    <td class="text-left">Payee Tel no : {{ $subledgerInfo->tel_no ?? '' }}</td>
                </tr>
            </table>
        </div>

        <div class="row mb">
            <table style="width: 90%;">
                <tr>
                    <td class="text-left">
                        <span>MR/MRS</span><br>
                        <span>Enclosed, Dutch-Bangla Bank Limited Cheque number
                             {{ $acctSuppPayDetails[0]->cheque_no ?? 'N/A' }} being payment for the
                            following</span><br>
                        <span>Kindly issue official receipt and indicate our payment voucher number for
                            reference.</span>
                    </td>
                </tr>
            </table>
        </div>

        <div class="row mb">
            <table style="width: 100%; border-top: dotted 1px #000000;">
                <tr>
                    <td class="text-left">PAYMENT VOUCHER #: <strong>{{ $voucher_no ?? '' }}</strong></td>
                </tr>
            </table>
        </div>

        <div class="row">
            <div class="col-md-12">
                <table style="width:100%" class="mt">
                    <thead>
                        <tr>
                            <th class="head_td text-left" style="width:20%;border-left:none;border-right:none">GRN No
                            </th>
                            <th class="head_td text-left" style="width:20%;border-left:none;border-right:none">Challan
                                No</th>
                            <th class="head_td text-center" style="width:20%;border-left:none;border-right:none">GRN
                                Date</th>
                            <th class="head_td text-center" style="width:20%;border-left:none;border-right:none">Pay
                                Date</th>
                            <th class="head_td text-right" style="width:20%;border-left:none;border-right:none">Amount
                                (Tk.)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $totalPay = 0; @endphp
                        @foreach ($acctSuppPayDetails ?? [] as $item)
                            <tr>
                                <td class="text-left">{{ $item->itemreceive_uid ?? '' }}</td>
                                <td class="text-left">{{ $item->challan_no ?? '' }}</td>
                                <td class="text-center">{{ $item->itemreceive_date ?? '' }}</td>
                                <td class="text-center">{{ $item->payment_date ?? '' }}</td>
                                <td class="text-right">{{ number_format($item->grn_amt ?? 0, 2) }}</td>
                            </tr>
                            @php $totalPay += $item->grn_amt ?? 0; @endphp
                        @endforeach
                    </tbody>

                    <tr>
                        <td colspan="5" style="height: 25px;"></td>
                    </tr>

                    @php
                        function numberToWords($number)
                        {
                            $f = new NumberFormatter('en', NumberFormatter::SPELLOUT);
                            return ucfirst($f->format($number));
                        }
                    @endphp

                    <tr>
                        <td colspan="4" class="text-right"
                            style="border-bottom: dotted 1px #000000;border-top: dotted 1px #000000;">
                            Grand Total :
                        </td>
                        <td class="text-right"
                            style="border-bottom: dotted 1px #000000;border-top: dotted 1px #000000; padding:3px;">
                            {{ number_format($totalPay, 2) }}
                        </td>
                    </tr>
                    <tr>
                        @php
                            $tiotalPayAmount = round($totalPay, 2);
                        @endphp
                        <td colspan="5" class="text-right">
                            <strong>In Words:</strong> {{ numberToWords($tiotalPayAmount) }} Taka Only
                        </td>
                    </tr>
                    <tr>
                        <td colspan="5" class="text-left">
                            Remarks : {{ $acctSuppPayDetails[0]->mst_remarks ?? 'N/A' }}
                        </td>
                    </tr>
                </table>

                <table style="width:100%" class="footer-table">
                    <tr class="footer-text-height">
                        <td class="text-left"><strong>Prepared By</strong></td>
                        <td class="text-left"><strong>Checked By</strong></td>
                        <td class="text-left"><strong>Authorized By</strong></td>
                        <td class="text-left"><strong>Received By</strong></td>
                    </tr>
                    <tr class="footer-text-height bottom">
                        <td class="text-left">{{ $voucher_details[0]->prepare_by ?? '' }}</td>
                        <td class="text-left">
                            <span>NURADILAH SHUIB</span>
                            <span>CHIEF FINANCE OFFICER</span>
                        </td>
                        <td class="text-left">
                            <span>MOHD. TAUFIK ISMAIL</span>
                            <span>CHIEF EXECUTIVE OFFICER</span>
                        </td>
                        <td class="text-left"></td>
                    </tr>
                    <tr>
                        <td colspan="4" class="text-left">
                            Print Date & Time: {{ date('j/n/Y g:i:s A') }}
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</body>

</html>
