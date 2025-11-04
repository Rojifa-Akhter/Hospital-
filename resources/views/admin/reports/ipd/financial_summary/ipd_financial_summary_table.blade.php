                                                                                                                                                                                                                                                                                          <div class="col-md-12 table-responsive">
    <table class="table data-table table-striped table-bordered table-hover data-table">
        <thead class="global-uhl-table-bg">
            <tr>
                <th scope="col" class="text-left">Sl</th>
                <th scope="col" class="text-left">Date</th>
{{--                <th scope="col" class="text-left">No of Invoice</th>--}}
                <th scope="col" class="text-left">No of Consultation</th>
                <th scope="col" class="text-left">No Of Referral(Inv.)</th>
                <th scope="col" class="text-right">No of Service</th>
                <th scope="col" class="text-right" style="width: 100px;">Referral Sales</th>
                <th scope="col" class="text-right" style="width: 100px;">Payable</th>
                <th scope="col" class="text-right" style="width: 100px;">Discount</th>
                <th scope="col" class="text-right" style="width: 100px;">Net Payable</th>
                <th scope="col" class="text-right" style="width: 100px;">Paid</th>
                <th scope="col" class="text-right" style="width: 100px;">Due</th>
                <th scope="col" class="text-right" style="width: 100px;">Refund</th>
{{--                <th class="text-center" scope="col" style="width: 80px;">Action</th>--}}
            </tr>
        </thead>
        <tbody>
            @php
            $total_payable = $total_discount = $total_net_payable = $total_paid = $total_due = $total_dis = $total_refund= $total_pay = 0;
            @endphp
            @if(!empty($report_data))
                @foreach($report_data as $row)

                @php
                $due=0;
                $refund=0;
                if($row->due >= 0){
                 $due=$row->due;
                 }else{
                  $refund=abs($row->due);
                  }

                @endphp

                    <tr>
                        <td class="border-1 bg-light text-center" style="text-align: center;">{{ $loop->iteration }}</td>
                        <td class="text-left" scope="col">{{ date("d/m/Y", strtotime($row->invo_date)) }}</td>
{{--                        <td class="text-center" scope="col">{{ $row->total_invoice_cnt }}</td>--}}
                        <td class="text-center" scope="col">{{ $row->total_consult_cnt }}</td>
                        <td class="text-center" scope="col">{{ $row->referral }}</td>
                        <td scope="col" class="text-right">{{ $row->no_of_service }}</td>
                        <td scope="col" class="text-right">{{ number_format($row->service_referral, 2) }}</td>
                        <td scope="col" class="text-right">{{ number_format($row->payable, 2) }}</td>
                        <td scope="col" class="text-right">{{ number_format($row->discount, 2) }}</td>
                        <td scope="col" class="text-right">{{ number_format($row->net_payable, 2) }}</td>
                        <td scope="col" class="text-right">{{ number_format($row->paid, 2) }}</td>
                        <td scope="col" class="text-right">{{  number_format($due, 2) }}</td>
                        <td scope="col" class="text-right">{{ number_format( $refund, 2) }}</td>
{{--                        <td>--}}
{{--                            <span class="btn btn-sm btn-primary" title="View Invoice"><i class="fa fa-print"></i> </span>--}}
{{--                            <span class="btn btn-sm btn-success" title="Payment Voucher"><i class="fa fa-id-card"></i> </span>--}}
{{--                        </td>--}}
                    </tr>
                    @php
                    $total_payable += $row->no_of_service;
                    $total_discount += $row->service_referral;
                    $total_pay += $row->payable;
                    $total_dis += $row->discount;
                    $total_net_payable += $row->net_payable;
                    $total_paid += $row->paid;
                    $total_due += $due;
                    $total_refund +=$refund;
                    @endphp
                @endforeach
            @else
                <tr>
                    <th class="text-center" scope="col" colspan="12">No Data Available</th>
                </tr>
            @endif
        </tbody>
        <tfoot>
            <tr>
                <th class="text-right" scope="col" colspan="4">Total = </th>
                <th scope="col" class="text-right global-uhl-table-bg">{{ $total_payable }}</th>
                <th scope="col" class="text-right global-uhl-table-bg">{{ number_format($total_discount,2,".","") }}</th>
                <th scope="col" class="text-right global-uhl-table-bg">{{ number_format($total_pay,2,".","") }}</th>
                <th scope="col" class="text-right global-uhl-table-bg">{{ number_format($total_dis,2,".","") }}</th>
                <th scope="col" class="text-right global-uhl-table-bg">{{ number_format($total_net_payable,2,".","") }}</th>
                <th scope="col" class="text-right global-uhl-table-bg">{{ number_format($total_paid,2,".","") }}</th>
                <th scope="col" class="text-right global-uhl-table-bg">{{ number_format($total_due,2,".","") }}</th>
                <th scope="col" class="text-right global-uhl-table-bg">{{ number_format($total_refund,2,".","") }}</th>
            </tr>
        </tfoot>
    </table>
</div>

