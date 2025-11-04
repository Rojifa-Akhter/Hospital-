<div class="table-responsiveX border-top border-right">
    @php
        $total_item_qty = $total_sales = $total_salesreturn = $total_discount = $total_payment = $total_refund = $total_net_collection = $total_net_sales = 0;
    @endphp
    <table class="table table-bordered table-hover mb-0">
        <thead class="bg-light-blue sticky">
            <tr>
                <th class="text-center align-middle" scope="col" rowspan="2">SL</th>
                <th class="text-center align-middle" scope="col" rowspan="2">Date</th>
                <th class="text-center" scope="col" colspan="2">IPD Collection Summary</th>
                <th class="text-center align-middle" scope="col" rowspan="2">Total Collection (IPD)</th>
                <th class="text-center" scope="col" colspan="4">OPD Collection Summary</th>
                <th class="text-center" scope="col" rowspan="2">Total Collection OPD</th>
                <th class="text-center" scope="col" rowspan="2">Total Collection (IPD + OPD)</th>
            </tr>
            <tr>
                <th class="text-center" scope="col">Pharmacy (IPD)</th>
                <th class="text-center" scope="col">Other Services (IPD)</th>
                <th class="text-center" scope="col">Pharmacy (OPD)</th>
                <th class="text-center" scope="col">Investigation (OPD)</th>
                <th class="text-center" scope="col">OPD Procedure</th>
                <th class="text-center align-middle" scope="col">OPD Consultation</th>
            </tr>
        </thead>
        <tbody>
            @if (!empty($serviceUnitData))
                @foreach ($serviceUnitData as $key => $rows)
                    @php
                        $item_qty = $sales = $salesreturn = $discount = $payment = $refund = $net_collection_amount = $net_sales_amount = 0;
                    @endphp
                    <tr>
                        <td class="text-left" colspan="8"> <strong> {{ $rows[0]->dept }} </strong></td>
                    </tr>
                    @foreach ($rows as $row)
                        @php
                            $net_collection = $row->payment - $row->refund;
                            $net_sales = $row->sales - ($row->salesreturn + $row->discount);
                        @endphp
                        <tr>
                            <td class="text-center ">{{ $loop->iteration }}</td>
                            <td class="text-left">{{ $row->item_name }} </td>
                            <td class="text-center">{{ $row->item_qty }} </td>
                            <td class="text-right">{{ number_format($row->sales, 2, '.', '') }}</td>
                            <td class="text-right">{{ number_format($row->salesreturn, 2, '.', '') }}</td>
                            <td class="text-right">{{ number_format($row->discount, 2, '.', '') }}</td>
                            <td class="text-right">{{ number_format($net_sales, 2, '.', '') }}</td>
                            <td class="text-right">{{ number_format($row->payment, 2, '.', '') }}</td>
                            <td class="text-right">{{ number_format($row->refund, 2, '.', '') }}</td>
                            <td class="text-right">{{ number_format($net_collection, 2, '.', '') }}</td>
                            <td scope="col" class="text-right ">
                                {{-- <span
                                    class="btn btn-sm btn-success open-modal btnView"
                                    data-action="{{ route('item-wise-financial-item-dtl', [$form_date, $to_date, $row->item_no_fk]) }}"
                                    data-modal="common-modal-md" data-title="Item Details" title="View Invoice Details"
                                    data-id="{{ $row->item_no_fk }}"><i class="fa fa-eye"></i></span> --}}
                            </td>
                        </tr>

                        @php
                            $item_qty               += $row->item_qty;
                            $sales                  += $row->sales;
                            $salesreturn            += $row->salesreturn;
                            $discount               += $row->discount;
                            $payment                += $row->payment;
                            $refund                 += $row->refund;
                            $net_collection_amount  += $net_collection;
                            $net_sales_amount       += $net_sales;
                        @endphp
                    @endforeach
                    @php
                        $total_item_qty         += $item_qty; 
                        $total_sales            += $sales;
                        $total_salesreturn      += $salesreturn;
                        $total_discount         += $discount;
                        $total_payment          += $payment;
                        $total_refund           += $refund;
                        $total_net_collection   += $net_collection_amount;
                        $total_net_sales        += $net_sales_amount;
                    @endphp
                    <tr>
                        <td class="text-right" scope="col" colspan="2"> <strong> Department Total = </strong></td>
                        <td scope="col" class="text-center bg-light-blue">{{ $item_qty }}</td>
                        <td scope="col" class="text-right bg-light-blue">{{ $sales }}</td>
                        <td scope="col" class="text-right bg-light-blue">{{ $salesreturn }}</td>
                        <td scope="col" class="text-right bg-light-blue">{{ number_format($discount, 2, '.', '') }}</td>
                        <td scope="col" class="text-right bg-light-blue">{{ number_format($net_sales_amount, 2, '.', '') }}</td>
                        <td scope="col" class="text-right bg-light-blue">{{ number_format($payment, 2, '.', '') }}</td>
                        <td scope="col" class="text-right bg-light-blue">{{ number_format($refund, 2, '.', '') }}</td>
                        <td scope="col" class="text-right bg-light-blue">{{ number_format($net_collection_amount, 2, '.', '') }}</td>
                        <td></td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td class="text-center" scope="col" colspan="11">No Data Available</td>
                </tr>
            @endif
        </tbody>
        <tfoot>
            <tr>
                <td class="text-right" scope="col" colspan="2"> <strong> Total = </strong></td>
                <td scope="col" class="text-center bg-light-blue">{{ $total_item_qty }}</td>
                <td scope="col" class="text-right bg-light-blue">{{ $total_sales }}</td>
                <td scope="col" class="text-right bg-light-blue">{{ $total_salesreturn }}</td>
                <td scope="col" class="text-right bg-light-blue">{{ number_format($total_discount, 2, '.', '') }}</td>
                <td scope="col" class="text-right bg-light-blue">{{ number_format($total_net_sales, 2, '.', '') }}</td>
                <td scope="col" class="text-right bg-light-blue">{{ number_format($total_payment, 2, '.', '') }}</td>
                <td scope="col" class="text-right bg-light-blue">{{ number_format($total_refund, 2, '.', '') }}</td>
                <td scope="col" class="text-right bg-light-blue">{{ number_format($total_net_collection, 2, '.', '') }}</td>
                <td scope="col" class="text-right bg-light-blue">0.00</td>
            </tr>
        </tfoot>
    </table>
</div>
