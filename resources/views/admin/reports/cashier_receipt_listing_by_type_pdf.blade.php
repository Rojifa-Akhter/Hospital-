<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Receipt Summary Listing By TYpe</title>
    <style>
        @page {
            size: A4 landscape;
            /* margin: 20mm; */
            margin-left: .1cm;
            margin-right: .1cm;

            @bottom-center {
                content: "Page " counter(page) " of " counter(pages);
                font-size: 10px;
                color: #555;
            }
        }
    body {
        font-family: 'Arial', sans-serif;
        font-size: 11px;
        color: #333;
        margin: 5;
    }

    header {
        text-align: center;
        border-bottom: 1px dotted #999;
        padding-bottom: 5px;
        margin-bottom: 5px;
    }

    .hospital-title {
        font-size: 16px;
        font-weight: bold;
        color: #000;
    }

    .section-title {
        font-size: 12px;
        font-weight: bold;
        margin-bottom: 5px;
        border-bottom: 1px solid #ccc;
        padding-bottom: 2px;
        color: #034636;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 5px;
        table-layout: fixed;
    }

    thead {
        background-color: #f0f0f0;
    }

    th, td {
        border: .5px dotted #969595;
        padding: 1px 1px;
        word-wrap: break-word;
    }

    th {
        text-align: center;
        font-weight: bold;
        font-size: 10px;
    }

    td {
        font-size: 10px;
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

    tr {
        page-break-inside: avoid;
    }

    tfoot td {
        font-weight: bold;
        background-color: #f9f9f9;
    }

    h4.mb-3 {
        font-size: 12px;
        margin-bottom: 10px;
    }

    .signature-table td {
        padding: 8px;
        font-size: 12px;
    }

    .column-sl { width: 3%; }
    .column-date { width: 10%; }
    .column-code { width: 6%; }
    .column-cashier { width: 10%; }
    .column-payment { width: 5%; }
</style>

</head>

<body>

    <header>
       
        <div class="hospital-title"> {{ $po_hospital_details->hospital_name ?? 'Hospital Name' }}</div>
        <div>Cashier Summary Receipt Listing</div>
        <div style="font-size: 10px;">Receipt Date: {{ $form_date }} To {{ $to_date }} </div>
        <div style="font-size: 10px;">Report Date: {{ date('d-m-Y h:i A') }}</div>
    </header>
    <div class="row">
    <div class="col-md-12">
        <h4 class="mb-3" style="border-bottom: 1px dotted rgb(179, 176, 176); padding-bottom: 5px; text-align:center;">SUMMARY RECEIPT LISTING BY TYPE</h4>
        <table class="table table-striped table-bordered table-hover data-table">
            <thead class="thead-success">
                <tr>
                    <th class="text-center" rowspan="2">SL</th>
                    <th class="text-center" rowspan="2">DATE</th>
                    <th class="text-center" rowspan="2">TILL CODE</th>
                    <th class="column-cashier text-left" rowspan="2">CASHIER</th>
                    <th class="text-center" colspan="4">COLLECTION</th>
                    <th class="text-center" colspan="4">REFUND</th>
                    <th class="text-center" colspan="4">DEPOSIT</th>
                    <th class="text-center" colspan="4">BLOOD DEPOSIT</th>
                    <th class="text-center" style="width: 7%" rowspan="2">TOTAL</th>
                </tr>
                <tr>
                    <th class="text-right">CASH</th>
                    <th class="text-right">MBANKING</th>
                    <th class="text-right">CARD</th>
                    <th class="text-right">CHEQUE</th>
                    <th class="text-right">CASH</th>
                    <th class="text-right">MBANKING</th>
                    <th class="text-right">CARD</th>
                    <th class="text-right">CHEQUE</th>
                    <th class="text-right">CASH</th>
                    <th class="text-right">MBANKING</th>
                    <th class="text-right">CARD</th>
                    <th class="text-right">CHEQUE</th>
                    <th class="text-right">CASH</th>
                    <th class="text-right">MBANKING</th>
                    <th class="text-right">CARD</th>
                    <th class="text-right">CHEQUE</th>
                </tr>       
            </thead>
            <tbody id="cvListTableLeft">
                @php
                    $totalCashL = 0;
                    $totalCardL = 0;
                    $totalChequeL = 0;
                    $totalMbankingL = 0;
                    $totalCollectionL = 0;

                    $totalCashD = 0;
                    $totalCardD = 0;
                    $totalChequeD = 0;
                    $totalMbankingD = 0;
                    $totalCollectionD = 0;

                    $totalCashBD = 0;
                    $totalCardBD = 0;
                    $totalChequeBD = 0;
                    $totalMbankingBD = 0;
                    $totalCollectionBD = 0;

                    $totalCashR = 0;
                    $totalCardR = 0;
                    $totalMbankingR = 0;
                    $totalChequeR = 0;
                    $totalCollectionR = 0;

                @endphp
                @foreach ($cashier_collections as $data)
                    @php
                        $totalCashL += $data->cash;
                        $totalCardL += $data->card;
                        $totalChequeL += $data->cheque;
                        $totalMbankingL += $data->mbanking;
                        $totalCollectionL += $data->collection;

                        $totalCashR += $data->refund_cash;
                        $totalCardR += $data->refund_card;
                        $totalChequeR += $data->refund_cq;
                        $totalMbankingR += $data->refund_mb;
                        $totalCollectionR += $data->refund;
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
                        <td class="text-right">{{ number_format($data->refund_cash, 2) }}</td>
                        <td class="text-right">{{ number_format($data->refund_mb, 2) }}</td>
                        <td class="text-right">{{ number_format($data->refund_card, 2) }}</td>
                        <td class="text-right">{{ number_format($data->refund_cq, 2) }}</td>

                        <td class="text-right">{{ number_format(0, 2) }}</td>
                        <td class="text-right">{{ number_format(0, 2) }}</td>
                        <td class="text-right">{{ number_format(0, 2) }}</td>
                        <td class="text-right">{{ number_format(0, 2) }}</td>

                        <td class="text-right">{{ number_format(0, 2) }}</td>
                        <td class="text-right">{{ number_format(0, 2) }}</td>
                        <td class="text-right">{{ number_format(0, 2) }}</td>
                        <td class="text-right">{{ number_format(0, 2) }}</td>

                        <td class="text-right">{{ number_format($data->collection-$data->refund, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="font-weight-bold bg-light">
                    <td colspan="4" class="text-right">Grand Total</td>
                    <td class="text-right">{{ number_format($totalCashL, 2) }}</td>
                    <td class="text-right">{{ number_format($totalMbankingL, 2) }}</td>
                    <td class="text-right">{{ number_format($totalCardL, 2) }}</td>
                    <td class="text-right">{{ number_format($totalChequeL, 2) }}</td>
                    <td class="text-right">{{ number_format($totalCashR, 2) }}</td>
                    <td class="text-right">{{ number_format($totalMbankingR, 2) }}</td>
                    <td class="text-right">{{ number_format($totalCardR, 2) }}</td>
                    <td class="text-right">{{ number_format($totalChequeR, 2) }}</td>

                    <td class="text-right">{{ number_format($totalCashD, 2) }}</td>
                    <td class="text-right">{{ number_format($totalMbankingD, 2) }}</td>
                    <td class="text-right">{{ number_format($totalCardD, 2) }}</td>
                    <td class="text-right">{{ number_format($totalChequeD, 2) }}</td>

                    <td class="text-right">{{ number_format($totalCashBD, 2) }}</td>
                    <td class="text-right">{{ number_format($totalMbankingBD, 2) }}</td>
                    <td class="text-right">{{ number_format($totalCardBD, 2) }}</td>
                    <td class="text-right">{{ number_format($totalChequeBD, 2) }}</td>

                    <td class="text-right">{{ number_format((($totalCollectionL+$totalCollectionD+$totalCollectionBD)-$totalCollectionR), 2) }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
</div> 
    {{-- Signature Section --}}
<div style="margin-top: 10px; width: 100%; font-family: Arial, sans-serif; font-size: 12px;">
    <table style="width: 50%; border-collapse: collapse;">
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

<div style="margin-top: 1px dotted rgb(168, 167, 167) !important;">
        @if (isset($pdf))
            <script type="text/php">
                if (isset($pdf)) {
                    $pdf->page_script('
                        if ($PAGE_COUNT > 1) {
                            $font = $fontMetrics->get_font("Arial", "normal");
                            $size = 10;
                            $pageText = "Page " . $PAGE_NUM . " of " . $PAGE_COUNT;
                            $pdf->text(500, 820, $pageText, $font, $size);
                        }
                    ');
                }
            </script>
        @endif
    </div>

</body>
</html>
