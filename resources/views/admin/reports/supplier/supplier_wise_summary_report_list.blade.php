<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<table class="table table-bordered table-striped mb-0 data-table">
    <thead>
        <tr class="bg-light-blue">
            <th class="text-center">SL#</th>
            <th class="text-center">Supplier</th>
            <th class="text-center">MRR No</th>
            <th class="text-center">MRR Date</th>
            {{-- <th  class="text-center">Card No.</th> --}}
            <th class="text-left">Inv No</th>
            <th class="text-center">Inv Date</th>
            <th class="text-right">Total Amt</th>
            <th class="text-right">Return Amt</th>
            <th class="text-right">Vat Amt.</th>
            <th class="text-right">Spe.Disc</th>
            <th class="text-right">Net Amt</th>
        </tr>
    </thead>
    <tbody>


        @php
            $sales_total = 0;
            $sales_discount = 0;
            $sales_vat = 0;
            $net_sales = 0;
            $return_amt_adj = 0;

            $sup_vari1 = 'Test';
            $sup_vari2 = 'Test';
            $i = 0;
        @endphp

        @if (!empty($supplier_wise))
            @foreach ($supplier_wise as $suppiler)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    @if ($sup_vari1 != $suppiler->supplier_name)
                        @php
                            $sup_vari1 = $suppiler->supplier_name;
                        @endphp
                        <td class="text-left"
                            rowspan="{{ isset($supplier_wise_arr[$suppiler->supplier_name]) ? $supplier_wise_arr[$suppiler->supplier_name] : '1' }}">
                            {{ $suppiler->supplier_name }} </td>
                    @else
                        @php
                            $i++;
                        @endphp
                    @endif

                    <td class="text-center">
                        {{ $suppiler->itemreceive_uid }}</td>
                    <td class="text-center">{{ date('d/m/y', strtotime($suppiler->challan_date)) }}</td>

                    {{-- <td class="text-left">{{$value->person_code}}</td> --}}
                    <td class="text-left">
                        {{ $suppiler->challan_no }}</td>

                    <td class="text-center">
                        {{ date('d/m/y', strtotime($suppiler->challan_date)) }}</td>

                    <td class="text-right">
                        {{  number_format(($suppiler->total_received_amount + $suppiler->discount_amount +$suppiler->return_amt_adj) - $suppiler->vat_amount, 2, '.', '')  }}</td>

                    <td class="text-right">
                        {{ number_format($suppiler->return_amt_adj, 2, '.', '') }}</td>
                    <td class="text-right">                      
                    {{ number_format($suppiler->vat_amount, 2, '.', '') }}</td>
                    <td class="text-right">                      
                        {{ number_format($suppiler->discount_amount, 2, '.', '') }}</td>
                    <td class="text-right">
                        {{ number_format($suppiler->total_received_amount, 2, '.', '') }}
                    </td>
                </tr>
                @if ($sup_vari2 != $suppiler->supplier_name)
                    @if ($supplier_wise_arr[$suppiler->supplier_name] == $i + 1)
                        @php
                            $i = 0;
                            $sup_vari2 = $suppiler->supplier_name;
                          //  dd($supplier_wise_total[$suppiler->supplier_name]);
                        @endphp
                        @if ($supplier_wise_total[$suppiler->supplier_name])
                            @foreach ($supplier_wise_total[$suppiler->supplier_name] as $row)
                                <tr>
                                    <td colspan="6" class="text-right">Sub Total</td>
                                    <td class="text-right">{{  number_format(($row->total_received_amount + $row->discount_amount + $row->return_amt_adj) - $row->vat_amount, 2, '.', '') }}</td>
                                    <td class="text-right">{{ number_format($row->return_amt_adj, 2, '.', '') }}</td>
                                    <td class="text-right">{{ number_format($row->vat_amount, 2, '.', '') }}</td>
                                    <td class="text-right">{{ number_format($row->discount_amount, 2, '.', '') }}</td>
                                    <td class="text-right">{{ number_format($row->total_received_amount , 2, '.', '') }}
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    @endif
                @endif
                @php
                    $sales_total +=  ($suppiler->total_received_amount + $suppiler->discount_amount +$suppiler->return_amt_adj) - $suppiler->vat_amount ;
                    $sales_discount += $suppiler->discount_amount;
                    $sales_vat += $suppiler->vat_amount;
                    $return_amt_adj += $suppiler->return_amt_adj;
                    $net_sales += $suppiler->total_received_amount ;
                @endphp
            @endforeach
        @endif
    </tbody>
    <tfoot>
        <tr>

            <th class="text-right bg-light-blue" colspan="6">Grand Total</th>
            <th class="text-right bg-light-blue">{{ number_format($sales_total, 2) }}</th>
            <th class="text-right bg-light-blue">{{ number_format($return_amt_adj, 2) }}</th>
            <th class="text-right bg-light-blue">{{ number_format($sales_vat, 2) }}</th>
            <th class="text-right bg-light-blue">{{ number_format($sales_discount, 2) }}</th>
            <th class="text-right bg-light-blue">{{ number_format($net_sales, 2) }}</th>

        </tr>
    </tfoot>
</table>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>

<script type="text/javascript">
    $('.data-table').DataTable({
        "ordering": false,
        "bPaginate": false,
        "bLengthChange": false,
        "bAutoWidth": false
    });
</script>
