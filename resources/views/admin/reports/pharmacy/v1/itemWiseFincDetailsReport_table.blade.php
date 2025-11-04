<div class="table-responsiveX border-top border-right">

    @php
        $total_item_qty = $total_sales = $total_salesreturn = $total_discount = $total_payment = $total_refund = $total_net_collection = $total_net_sales = $total_collection = $total_net_payable = $total_duecollection = 0;
    @endphp

    <table class="table table-bordered table-hover mb-0">
        <thead class="bg-light-blue sticky">
            <tr>
                <th class="text-center" scope="col">SL</th>
                <th class="text-left" scope="col">Test Name</th>
                <th class="text-center" scope="col">Item Qty</th>
                <th class="text-right" scope="col">Sales</th>
                <th class="text-right" scope="col">Sales Cancel</th>
                
                <th class="text-right" scope="col">Net Sales</th>
                <th class="text-right" scope="col">Discount</th>
                <th class="text-right" scope="col">Collection</th>
                <th class="text-right" scope="col">Due Collection</th>
                <th class="text-right" scope="col">Refund</th>
                <th class="text-right" scope="col">Net Collection</th>
                <th class="text-right" scope="col">Receivable</th>
            </tr>
        </thead>
        <tbody>
            @if (!empty($serviceUnitData))
                @foreach ($serviceUnitData as $key => $rows)
                    @php
                        $item_qty = $sales = $salesreturn = $discount = $collection = $refund = $duecollection = $net_sales_amount = $net_collection_amount = $net_payable = 0;
                    @endphp
                    <tr>
                        <td class="text-left" colspan="8"> <strong> {{ $rows[0]->dept }} </strong></td>
                    </tr>
                    @foreach ($rows as $row)
                        @php
                            $net_collection = ($row->collection + $row->duecollection) - $row->refund; 
                            $net_sales      = $row->sales - ($row->salesreturn + $row->discount);
                            $payable        = $net_sales - $row->collection;
                        @endphp
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="text-left">{{ $row->item_name }} </td>
                            <td class="text-center">{{ $row->item_qty }} </td>
                            <td class="text-right">{{ number_format($row->sales, 2, '.', '') }}</td>
                            <td class="text-right">{{ number_format($row->salesreturn, 2, '.', '') }}</td>
                           
                            <td class="text-right">{{ number_format($net_sales, 2, '.', '') }}</td>
                            <td class="text-right">{{ number_format($row->discount, 2, '.', '') }}</td>
                            <td class="text-right">{{ number_format($row->collection, 2, '.', '') }}</td>
                            <td class="text-right">{{ number_format($row->duecollection, 2, '.', '') }}</td>
                            <td class="text-right">{{ number_format($row->refund, 2, '.', '') }}</td>
                            <td class="text-right">{{ number_format($net_collection, 2, '.', '') }}</td>
                            <td class="text-right">{{ number_format($payable, 2, '.', '') }}</td>
                        </tr>

                        @php
                            $item_qty               += $row->item_qty;
                            $sales                  += $row->sales;
                            $salesreturn            += $row->salesreturn;
                            $discount               += $row->discount;
                            $collection             += $row->collection;
                            $duecollection          += $row->duecollection;
                            $refund                 += $row->refund;
                            $net_sales_amount       += $net_sales; 
                            $net_collection_amount  += $net_collection; 
                            $net_payable            += $payable; 
                        @endphp
                    @endforeach

                    @php
                        $total_item_qty             += $item_qty; 
                        $total_sales                += $sales;
                        $total_salesreturn          += $salesreturn;
                        $total_discount             += $discount;
                        $total_refund               += $refund;
                        $total_collection           += $collection;
                        $total_duecollection        += $duecollection;
                        $total_net_sales            += $net_sales_amount;
                        $total_net_collection       += $net_collection_amount;
                        $total_net_payable          += $net_payable;
                    @endphp

                    <tr>
                        <td class="text-right" scope="col" colspan="2"> <strong> Department Total = </strong></td>
                        <td scope="col" class="text-center bg-light-blue">{{ $item_qty }}</td>
                        <td scope="col" class="text-right bg-light-blue">{{ number_format($sales, 2, '.', '') }}</td>
                        <td scope="col" class="text-right bg-light-blue">{{ number_format($salesreturn, 2, '.', '') }}</td>
                        
                        <td scope="col" class="text-right bg-light-blue">{{ number_format($net_sales_amount, 2, '.', '') }}</td>
                        <td scope="col" class="text-right bg-light-blue">{{ number_format($discount, 2, '.', '') }}</td>
                        <td scope="col" class="text-right bg-light-blue">{{ number_format($collection, 2, '.', '') }}</td>
                        <td scope="col" class="text-right bg-light-blue">{{ number_format($duecollection, 2, '.', '') }}</td>
                        <td scope="col" class="text-right bg-light-blue">{{ number_format($refund, 2, '.', '') }}</td>
                        <td scope="col" class="text-right bg-light-blue">{{ number_format($net_collection_amount, 2, '.', '') }}</td>
                        <td scope="col" class="text-right bg-light-blue">{{ number_format($net_payable, 2, '.', '') }}</td>
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
                <td scope="col" class="text-right bg-light-blue">{{ number_format($total_sales, 2, '.', '') }}</td>
                <td scope="col" class="text-right bg-light-blue">{{ number_format($total_salesreturn, 2, '.', '') }}</td>
                
                <td scope="col" class="text-right bg-light-blue">{{ number_format($total_net_sales, 2, '.', '') }}</td>
                <td scope="col" class="text-right bg-light-blue">{{ number_format($total_discount, 2, '.', '') }}</td>
                <td scope="col" class="text-right bg-light-blue">{{ number_format($total_collection, 2, '.', '') }}</td>
                <td scope="col" class="text-right bg-light-blue">{{ number_format($total_duecollection, 2, '.', '') }}</td>
                <td scope="col" class="text-right bg-light-blue">{{ number_format($total_refund, 2, '.', '') }}</td>
                <td scope="col" class="text-right bg-light-blue">{{ number_format($total_net_collection, 2, '.', '') }}</td>
                <td scope="col" class="text-right bg-light-blue">{{ number_format($total_net_payable, 2, '.', '') }}</td>
                <td></td>
            </tr>
        </tfoot>
    </table>
</div>
