<div class="row">
    <div class="col-md-12">
        <table class="table table-striped table-bordered table-hover data-table">
            <thead class="thead-success">
                <tr>
                    <th class="text-center">SL</th>
                    <th class="text-center">Bill DATE</th>
                    <th class="text-center">Bill No</th>
                    <th class="text-center">Item Type</th>
                    <th class="text-center">MRN</th>
                    <th class="text-left">Patient Name</th>
                    <th class="text-left">Doctor Code</th>
                    <th class="text-left">Doctor Name</th>
                    <th class="text-center">Episode Type</th>
                    <th class="text-center">Doctor Payment</th>
                    <th class="text-right">Charge</th>
                    <th class="text-right">Doctor Amount</th>
                </tr>
            </thead>
            <tbody id="doctorLedgerTable">
                @php
                    $totalSales = 0;
                    $totalDoctorAmt = 0;
                @endphp
                @foreach ($doctorLedgers as $data)
                    @php
                        $totalSales += $data->ledger_amt_sales;
                        $doctorAmt = $data->doc_amt;
                        $totalDoctorAmt += $doctorAmt;
                    @endphp
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td class="text-center">{{ \Carbon\Carbon::parse($data->invoice_date)->format('d/m/Y') }}</td>
                        <td class="text-center">{{ $data->invoice_no_pk }}</td>
                        <td class="text-center">{{ $data->item_type_name }}</td>
                        <td class="text-center">{{ $data->patient_code }}</td>
                        <td class="text-left">{{ $data->patient_name }}</td>
                        <td class="text-left">{{ $data->doc_code }}</td>
                        <td class="text-left">{{ $data->doc_name }}</td>
                        <td class="text-center">{{ $data->cons_type }}</td>
                        <td class="text-center">{{ $data->doc_payment_ind ? "Done" : "Not Done" }}</td>
                        <td class="text-right">{{ number_format($data->ledger_amt_sales, 2) }}</td>
                        <td class="text-right">{{ number_format($doctorAmt, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="font-weight-bold bg-light">
                    <td colspan="10" class="text-right">Grand Total</td>
                    <td class="text-right">{{ number_format($totalSales, 2) }}</td>
                    <td class="text-right">{{ number_format($totalDoctorAmt, 2) }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
