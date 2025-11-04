<div class="col-md-12 table-responsive">

    <table class="table data-table table-striped table-bordered table-hover data-table">
        <thead class="bg-light-blue">
            <tr>
                <th scope="col" class="text-left" style="width: 20px;">Sl</th>
                <th scope="col" class="text-left"  style="width: 150px;">Invoice Date</th>
                <th scope="col" class="text-left"  >Invoice No</th>
                <th scope="col" class="text-left"  >Cashier Name</th>
                <th scope="col" class="text-right" >Sales</th>
                <th scope="col" class="text-right" >Discount</th>
                <th scope="col" class="text-right" >Sales Return</th>
                <th scope="col" class="text-right" >Discount Return</th>
             
                <th scope="col" class="text-right" >Collection</th>
                <th scope="col" class="text-right" >Refund</th>
                <th scope="col" class="text-right" >Due</th>

            </tr>
        </thead>
        <tbody>
            @php
                $total_sales = $total_discount = $total_sales_return = $total_discount_return = $total_net_sales = $total_collection = $total_refund = $total_due= 0;
            @endphp
            @if (!empty($report_data))
                @foreach ($report_data as $row)

                    @php                      
                        $net_sales=(($row->sales - $row->returns) - ($row->discount  - $row->discountr)) ;                      
                    @endphp
                    <tr>
                        <td class="border-1 bg-light text-center" style="text-align: center;">{{ $loop->iteration }}
                        </td>
                        <td class="text-left" scope="col">{{ date('d/m/Y', strtotime($row->invoice_date)) }}</td>
                        <td class="text-left" scope="col">{{ $row->invoice_no_fk }}</td>
                        <td class="text-left" scope="col">{{ $row->cashier }}</td>
                        <td scope="col" class="text-right">{{ number_format($row->sales, 2) }}</td>
                        <td scope="col" class="text-right">{{ number_format($row->discount, 2) }}</td>
                        <td scope="col" class="text-right">{{ number_format($row->returns, 2) }}</td>
                        <td scope="col" class="text-right">{{ number_format($row->discountr, 2) }}</td>
                       
                        <td scope="col" class="text-right">{{ number_format($row->collection, 2) }}</td>
                        <td scope="col" class="text-right">{{ number_format($row->refund, 2) }}</td>
                        <td scope="col" class="text-right">{{ number_format($row->due, 2) }}</td>

                    </tr>
                    @php

                    $total_sales +=$row->sales;
                    $total_discount +=$row->discount;
                    $total_sales_return +=$row->returns;
                    $total_discount_return +=$row->discountr;
                   
                    $total_collection +=$row->collection;
                    $total_refund +=$row->refund;
                    $total_due +=$row->due;
                    @endphp
                @endforeach
            @else
                <tr>
                    <th class="text-center" scope="col" colspan="11">No Data Available</th>
                </tr>
            @endif
        </tbody>
        <tfoot>
            <tr>
                <th class="text-right" scope="col" colspan="4">Total = </th>
              
                <th scope="col" class="text-right bg-light-blue">{{ number_format($total_sales, 2, '.', '') }}</th>
                <th scope="col" class="text-right bg-light-blue">{{ number_format($total_discount, 2, '.', '') }}</th>
                <th scope="col" class="text-right bg-light-blue">{{ number_format($total_sales_return, 2, '.', '') }}</th>
                <th scope="col" class="text-right bg-light-blue">{{ number_format( $total_discount_return, 2, '.', '') }}
                </th>
              
                <th scope="col" class="text-right bg-light-blue">{{ number_format($total_collection, 2, '.', '') }}</th>
                <th scope="col" class="text-right bg-light-blue">{{ number_format( $total_refund, 2, '.', '') }}</th>
                <th scope="col" class="text-right bg-light-blue">{{ number_format($total_due, 2, '.', '') }}</th>
              


            </tr>
        </tfoot>
    </table>
</div>
