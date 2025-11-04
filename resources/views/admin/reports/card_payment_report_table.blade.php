<div class="table-responsive border-top border-right">
    <table class="table table-bordered table-hover mb-0">
        <thead class="bg-light-blue">
            <tr>
                <th class="text-center" scope="col">SL</th>
                <th class="text-center" scope="col">Patient Name</th>
                <th class="text-center" scope="col">Patient ID</th>
                <th class="text-center" scope="col">Receipt Date</th>
                <th class="text-center" scope="col">Payment Mode</th>
                <th class="text-center" scope="col">Payment Mode Type</th>
                <th class="text-center" scope="col">Invoice No(Transaction ID)</th>
                <th class="text-center" scope="col">Received Amount</th>
                <th class="text-center" scope="col">Received By</th>
            </tr>
        </thead>
        <tbody>
            @php
                $total_payable = 0;
                // dd($report_data);
            @endphp
            @if (!empty($report_data))

                @foreach ($report_data as $key => $row)
                    <tr>
                        <td class="text-center bg-light">{{ $loop->iteration }}</td>
                        <td class="text-left"><strong>{{ $row->patient_name }}</strong></td>
                        <td class="text-left"><strong>{{ $row->patient_code }}</strong></td>
                        <td class="text-left" width="80px">{{ date('d/m/Y', strtotime($row->receipt_date)) }}</td>
                        <td class="text-left"><strong>{{ $row->paymood }}</strong></td>
                        <td class="text-left"><strong>{{ $row->pay_mood_type }}</strong></td>
                        <td class="text-left">
                            <strong>
                                {{ $row->paymood == 'CARD' ? $row->card_invoice_no : $row->transaction_id }}
                            </strong>
                        </td>
                        {{-- <td class="text-left"><strong>{{ $row->transaction_id }}</strong></td> --}}
                        <td class="text-right bg-light">{{ number_format($row->pay_amount, 2, '.', '') }}</td>
                        <td class="text-left"><strong>{{ Ucfirst($row->user_name) }}</strong></td>

                    </tr>
                    @php
                        $total_payable += $row->pay_amount;
                    @endphp
                @endforeach
            @else
                <tr>
                    <th class="text-center" scope="col" colspan="6">No Data Available</th>
                </tr>
            @endif
        </tbody>
        <tfoot>
            <tr>
                <th class="text-right" scope="col" colspan="5">Total = </th>
                <th scope="col" class="text-right bg-light-blue">{{ number_format($total_payable, 2, '.', '') }}</th>
                <th class="text-center" scope="col" style="width: 80px;"></th>
            </tr>
        </tfoot>
    </table>
</div>
