<div class="row">
    <div class="col-md-12">
        <h4 class="mb-3" style="border-bottom: 1px dotted rgb(179, 176, 176); padding-bottom: 5px;">SUMMARY RECEIPT LISTING BY TYPE</h4>
        <table class="table table-striped table-bordered table-hover data-table">
            <thead class="thead-success">
                <tr>
                    <th class="text-center" rowspan="2">SL</th>
                    <th class="text-center" rowspan="2">DATE</th>
                    <th class="text-center" rowspan="2">TILL CODE</th>
                    <th class="text-left" rowspan="2">CASHIER</th>
                    <th class="text-center" colspan="4">COLLECTION</th>
                    <th class="text-center" colspan="4">REFUND</th>
                    <th class="text-center" colspan="4">DEPOSIT</th>
                    <th class="text-center" colspan="4">BLOOD DEPOSIT</th>
                    <th class="text-center" rowspan="2">TOTAL</th>
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
