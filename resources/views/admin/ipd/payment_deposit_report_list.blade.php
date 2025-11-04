<div class="col-md-12 table-responsive">
    <table class="table data-table table-striped table-bordered table-hover data-table">
        <thead class="bg-light-blue">
            <tr>
                <th scope="col" class="text-center" style="width: 40px;">Sl</th>
                <th scope="col" class="text-left" style="width: 150px;">Deposit Date</th>
                <th scope="col" class="text-left">Deposit No</th>
                <th scope="col" class="text-left">MRN</th>
                <th scope="col" class="text-left">Patient Name</th>
                <th scope="col" class="text-left">Admission No</th>
                <th scope="col" class="text-left">Invoice No</th>
                <th scope="col" class="text-left">Cashier Name</th>
                <th scope="col" class="text-right">Pay Amount</th>
                <th scope="col" class="text-right">Status</th>
                <th scope="col" class="text-right">Action</th>
            </tr>
        </thead>
        <tbody>
            @php
                $total_amount = 0;
            @endphp
            @if (!empty($report_data) && count($report_data) > 0)
                @foreach ($report_data as $row)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td class="text-left">{{ date('d/m/Y', strtotime($row->au_entry_at)) }}</td>
                        <td class="text-left">{{ $row->deposit_no_pk }}</td>
                        <td class="text-left">{{ $row->patient_code }}</td>
                        <td class="text-left">{{ $row->patient_name }}</td>
                        <td class="text-left">{{ $row->admission_no_fk }}</td>
                        {{-- <td class="text-left">{{ unallocate/allocate/refund }}</td> --}}
                        <td class="text-left">{{ $row->invoice_no_fk }}</td>
                        <td class="text-left">{{ $row->cashier_name ?? $row->au_entry_by }}({{  $row->cashier_code}})</td>
                        <td class="text-right">{{ number_format($row->pay_amount, 2) }}</td>
                        <td class="text-right">
                            @if(empty($row->admission_no_fk) && !empty($row->re_invoice_no_fk) && $row->pay_amount < 0)
                                refund ({{ $row->re_invoice_no_fk }})
                           
                            @elseif(empty($row->admission_no_fk) && !empty($row->re_invoice_no_fk) && $row->pay_amount > 0)
                                cancel ({{ $row->re_invoice_no_fk }})
                          
                            @elseif(!empty($row->admission_no_fk))
                                allocate
                            @else
                                unallocate
                            @endif
                        </td>
                        <td class="text-right">
                            <a href="{{ url('bill-invoice-ipd-print-v2/' . $row->invoice_no_fk) }}" target="_blank">
                                <i class="fa fa-eye"></i>
                            </a>
                        </td>
                        
                    </tr>
                    @php
                        $total_amount += $row->pay_amount;
                    @endphp
                @endforeach
            @else
                <tr>
                    <td colspan="12" class="text-center">No Data Available</td>
                </tr>
            @endif
        </tbody>
        <tfoot>
            <tr>
                <th colspan="8" class="text-right">Total =</th>
                <th class="text-right bg-light-blue">{{ number_format($total_amount, 2, '.', '') }}</th>
                <th></th>
                <th></th>
            </tr>
        </tfoot>
    </table>
</div>
