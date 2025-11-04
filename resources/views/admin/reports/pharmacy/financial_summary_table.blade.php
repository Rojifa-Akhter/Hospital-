<div class="col-md-12 table-responsive">
    <table class="table data-table table-striped table-bordered table-hover data-table">
        <thead class="bg-light-blue">
            <tr>
                <th scope="col" class="text-left">Slf</th>
                <th scope="col" class="text-left">Date</th>
                <th scope="col" class="text-left">No of Invoice</th>
                {{-- <th scope="col" class="text-left">No of Consultation</th> --}}
                {{-- <th scope="col" class="text-left">No Of Referral(Inv.)</th> --}}
                {{-- <th scope="col" class="text-left">No of Service</th> --}}
                {{-- <th scope="col" class="text-right" style="width: 100px;">Referral Sales</th> --}}
                <th scope="col" class="text-right" style="width: 100px;">Sales</th>
                <th scope="col" class="text-right" style="width: 100px;">Discount</th>
                <th scope="col" class="text-right" style="width: 100px;">Net Sales</th>
                <th scope="col" class="text-right" style="width: 100px;">Collection</th>
                <th scope="col" class="text-right" style="width: 100px;">Due</th>
                <th scope="col" class="text-right" style="width: 100px;">Refund</th>
                <th scope="col" class="text-right" style="width: 100px;">Net Collection</th>
                {{-- <th class="text-center" scope="col" style="width: 80px;">Action</th> --}}
            </tr>
        </thead>
        <tbody>
            @php
                $total_payable = $total_discount = $total_net_payable = $total_paid = $total_due = $total_dis = $total_refund = $total_pay = $total_net_col = 0;
            @endphp
            @if (!empty($report_data))
                @foreach ($report_data as $row)

                    @php
                        $due = 0;
                        $net_col = 0;
                        $refund = 0;

                    @endphp
                    <tr>
                        <td class="border-1 bg-light text-center" style="text-align: center;">{{ $loop->iteration }}
                        </td>
                        <td class="text-left" scope="col">{{ date('d/m/Y', strtotime($row->invoice_date)) }}</td>
                        <td class="text-left" scope="col">{{ $row->total_invoice_cnt }}</td>
                        {{-- <td class="text-left" scope="col">{{ $row->total_consult_cnt }}</td> --}}
                        {{-- <td class="text-center" scope="col">{{ $row->referral }}</td> --}}
                        {{-- <td scope="col" class="text-left">{{ $row->no_of_service }}</td> --}}
                        {{-- <td scope="col" class="text-right">{{ number_format($row->service_referral, 2) }}</td> --}}
                        <td scope="col" class="text-right">{{ number_format($row->sales, 2) }}</td>
                        <td scope="col" class="text-right">{{ number_format($row->discount, 2) }}</td>
                        <td scope="col" class="text-right">{{ number_format($row->net_sales, 2) }}</td>
                        <td scope="col" class="text-right">{{ number_format($row->collection, 2) }}</td>
                        <td scope="col" class="text-right">
                            {{ number_format($row->due, 2) }}
                        </td>
                        <td scope="col" class="text-right">{{ number_format($row->refund, 2) }}</td>
                        {{-- <td> --}}
                        {{-- <span class="btn btn-sm btn-primary" title="view invoice"><i class="fa fa-print"></i> </span> --}}
                        {{-- <span class="btn btn-sm btn-success" title="payment voucher"><i class="fa fa-id-card"></i> </span> --}}
                        {{-- </td> --}}
                        <td scope="col" class="text-right">{{ number_format($row->net_collection, 2) }}</td>
                    </tr>
                    @php
                        $total_payable += $row->total_invoice_cnt;
                        // $total_discount += $row->service_referral;
                        $total_pay += $row->sales;
                        $total_dis += $row->discount;
                        $total_net_payable += $row->net_sales;
                        $total_paid += $row->collection;
                        $total_due += $row->due;
                        $total_refund += $row->refund;
                        $total_net_col += $row->net_collection;
                    @endphp
                @endforeach
            @else
                <tr>
                    <th class="text-center" scope="col" colspan="9">No Data Available</th>
                </tr>
            @endif
        </tbody>
        <tfoot>
            <tr>
                <th class="text-right" scope="col" colspan="2">Total = </th>
                <th scope="col" class="text-left bg-light-blue">{{ $total_payable }}</th>
                <th scope="col" class="text-right bg-light-blue">{{ number_format($total_pay, 2, '.', '') }}</th>
                <th scope="col" class="text-right bg-light-blue">{{ number_format($total_dis, 2, '.', '') }}</th>
                <th scope="col" class="text-right bg-light-blue">{{ number_format($total_net_payable, 2, '.', '') }}
                </th>
                <th scope="col" class="text-right bg-light-blue">{{ number_format($total_paid, 2, '.', '') }}</th>
                <th scope="col" class="text-right bg-light-blue">{{ number_format($total_due, 2, '.', '') }}</th>
                <th scope="col" class="text-right bg-light-blue">{{ number_format($total_refund, 2, '.', '') }}</th>
                <th scope="col" class="text-right bg-light-blue">{{ number_format($total_net_col, 2, '.', '') }}</th>


            </tr>
        </tfoot>
    </table>
</div>
