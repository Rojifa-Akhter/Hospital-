<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Cashier Receipt Summary</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            font-size: 11px;
            color: #333;
        }

        header {
            text-align: center;
            border-bottom: 1px solid #999;
            padding-bottom: 8px;
            margin-bottom: 20px;
        }

        .hospital-title {
            font-size: 18px;
            font-weight: bold;
            color: #000;
        }

        .section-title {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 6px;
            border-bottom: 1px solid #ccc;
            padding-bottom: 3px;
            color: #034636;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        thead {
            background-color: #f0f0f0;
        }

        th, td {
            border:  1px dotted #464545;
            padding: 6px 4px;
        }

        th {
            text-align: center;
            font-weight: bold;
            font-size: 11px;
        }

        td.text-right {
            text-align: right;
        }

        td.text-center {
            text-align: center;
        }

        td.text-left {
            text-align: left;
        }

        tfoot td {
            font-weight: bold;
            background-color: #f9f9f9;
        }

        .column-sl { width: 5%; }
        .column-date { width: 15%; }
        .column-code { width: 10%; }
        .column-cashier { width: 25%; }
        .column-cash, .column-card, .column-cheque, .column-total {
            width: 11.25%;
        }
    </style>
</head>

<body>

    <header>
       
        <div class="hospital-title"> {{ $po_hospital_details->hospital_name ?? 'Hospital Name' }}</div>
        <div>Cashier Summary Receipt Listing</div>
        <div style="font-size: 10px;">Receipt Date: {{ $form_date }} To {{ $to_date }} </div>
        <div style="font-size: 10px;">Report Date: {{ date('d-m-Y') }}</div>
    </header>

    
        <div class="row">
            {{-- Collection Listing --}}
            <div class="section-title">Collection Listing</div>
            <table>
                <thead>
                    <tr>
                        <th class="column-sl">SL</th>
                        <th class="column-date">DATE</th>
                        <th class="column-code">TILL CODE</th>
                        <th class="column-cashier">CASHIER</th>
                        <th class="column-cash">CASH</th>
                        <th class="column-cash">MBANKING</th>
                        <th class="column-card">CARD</th>
                        <th class="column-cheque">CHEQUE</th>
                        <th class="column-total">TOTAL</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $totalCashL = $totalCardL = $totalMbankingL = $totalChequeL = $totalCollectionL = 0;
                    @endphp
                    @foreach ($cashier_collections as $data)
                        @php
                            $totalCashL += $data->cash;
                            $totalCardL += $data->card;
                            $totalChequeL += $data->cheque;
                            $totalMbankingL += $data->mbanking;
                            $totalCollectionL += $data->collection;
                        @endphp
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="text-center">{{ $data->ledger_date }}</td>
                            <td class="text-center">{{ $data->user_code }}</td>
                            <td class="text-left">{{ $data->cashier_name }}</td>
                            <td class="text-right">{{ number_format($data->cash, 2) }}</td>
                            <td class="text-right">{{ number_format($data->mbanking, 2) }}</td>
                            <td class="text-right">{{ number_format($data->card, 2) }}</td>
                            <td class="text-right">{{ number_format($data->cheque, 2) }}</td>
                            <td class="text-right">{{ number_format($data->collection, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4" class="text-right">Sub Total</td>
                        <td class="text-right">{{ number_format($totalCashL, 2) }}</td>
                        <td class="text-right">{{ number_format($totalMbankingL, 2) }}</td>
                        <td class="text-right">{{ number_format($totalCardL, 2) }}</td>
                        <td class="text-right">{{ number_format($totalChequeL, 2) }}</td>
                        <td class="text-right">{{ number_format($totalCollectionL, 2) }}</td>
                    </tr>
                </tfoot>
            </table>

            {{-- Refund Listing --}}
            <div class="section-title">Refund Listing</div>
            <table>
                <thead>
                    <tr>
                        <th class="column-sl">SL</th>
                        <th class="column-date">DATE</th>
                        <th class="column-code">TILL CODE</th>
                        <th class="column-cashier">CASHIER</th>
                        <th class="column-cash">CASH</th>
                        <th class="column-cash">MBANKING</th>
                        <th class="column-card">CARD</th>
                        <th class="column-cheque">CHEQUE</th>
                        <th class="column-total">TOTAL</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $totalCashR = $totalCardR =$totalMbankingR  = $totalChequeR = $totalCollectionR = 0;
                    @endphp
                    @foreach ($cashier_refunds as $data)
                        @php
                            $totalCashR += $data->refund_cash;
                            $totalCardR += $data->refund_card;
                            $totalMbankingR += $data->refund_mb;
                            $totalChequeR += $data->refund_cq;
                            $totalCollectionR += $data->refund;
                        @endphp
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="text-center">{{ $data->ledger_date }}</td>
                            <td class="text-center">{{ $data->user_code }}</td>
                            <td class="text-left">{{ $data->cashier_name }}</td>
                            <td class="text-right">{{ number_format($data->refund_cash, 2) }}</td>
                            <td class="text-right">{{ number_format($data->refund_mb, 2) }}</td>
                            <td class="text-right">{{ number_format($data->refund_card, 2) }}</td>
                            <td class="text-right">{{ number_format($data->refund_cq, 2) }}</td>
                            <td class="text-right">{{ number_format($data->refund, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4" class="text-right">Sub Total</td>
                        <td class="text-right">{{ number_format($totalCashR, 2) }}</td>
                        <td class="text-right">{{ number_format($totalMbankingR, 2) }}</td>
                        <td class="text-right">{{ number_format($totalCardR, 2) }}</td>
                        <td class="text-right">{{ number_format($totalChequeR, 2) }}</td>
                        <td class="text-right">{{ number_format($totalCollectionR, 2) }}</td>
                    </tr>
                    <tr style="background-color: #eaf7ea; font-weight: bold; color: #034636; border-top: 2px solid #034636;">
                        <td colspan="4" class="text-right">Grand Total (Collection - Refund)</td>
                        <td class="text-right">{{ number_format($totalCashL - $totalCashR, 2) }}</td>
                        <td class="text-right">{{ number_format($totalMbankingL - $totalMbankingR, 2) }}</td>
                        <td class="text-right">{{ number_format($totalCardL - $totalCardR, 2) }}</td>
                        <td class="text-right">{{ number_format($totalChequeL - $totalChequeR, 2) }}</td>
                        <td class="text-right">{{ number_format($totalCollectionL - $totalCollectionR, 2) }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    {{-- Signature Section --}}
<div style="margin-top: 50px; width: 100%; font-family: Arial, sans-serif; font-size: 12px;">
    <table style="width: 100%; border-collapse: collapse;">
        <tr>
            <td style="width: 50%; padding: 10px;">
                <div><strong>Checked By :</strong></div>
                <div style="margin-top: 30px;">________________________</div>
                <div style="margin-top: 5px;">(SIGNATURE)</div>
            </td>
            <td style="width: 50%; padding: 10px;">
                <div>&nbsp;</div>
                <div style="margin-top: 30px;">______________________________</div>
                <div style="margin-top: 5px;">(NAME)</div>
            </td>
        </tr>
        <tr>
            <td style="width: 50%; padding: 10px;">
                <div><strong>Verified By :</strong></div>
                <div style="margin-top: 30px;">________________________</div>
                <div style="margin-top: 5px;">(SIGNATURE)</div>
            </td>
            <td style="width: 50%; padding: 10px;">
                <div>&nbsp;</div>
                <div style="margin-top: 30px;">______________________________</div>
                <div style="margin-top: 5px;">(NAME)</div>
            </td>
        </tr>
    </table>
</div>

</body>
</html>
