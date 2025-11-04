<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<table class="table table-bordered table-striped mb-0 data-table">
    <thead>
        <tr class="bg-light-blue">
            <th class="text-center">SL#</th>
            <th class="text-left">Group Name</th>
            <th class="text-left">Item Description</th>
            <th class="text-center">Unit</th>
            <th class="text-center">Qty</th>
            <th class="text-right">P. Rate</th>
            <th class="text-right">Amount(tk.)</th>
        </tr>
    </thead>
    <tbody>


        @php
            $sales_total = 0;
            $vat_total = 0;
            $dis_total = 0;
            $grand_sales_total = 0;
            $net_sales = 0;
            $return_amt_adj = 0;

            $sup_vari1 = 'Test';
            $sup_vari2 = 'Test';
            $i = 0;
        @endphp
        @if (!empty($supplier_wise_total))
            @foreach ($supplier_wise_total as $key => $suppilers)
                <tr>
                    <td class="text-left" colspan="7"><strong>{{ $key }}</strong></td>
                </tr>
                @foreach ($suppilers as $suppiler)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        @if ($sup_vari1 != $suppiler->generic_name)
                            @php
                                $sup_vari1 = $suppiler->generic_name;
                            @endphp
                            <td class="text-left"
                                rowspan="{{ isset($supplier_wise_arr[$suppiler->supplier_name][$suppiler->generic_name]) ? $supplier_wise_arr[$suppiler->supplier_name][$suppiler->generic_name] : '1' }}">
                                {{ $suppiler->generic_name }}</td>
                        @else
                        @endif


                        <td class="text-left">
                            {{ $suppiler->item_name }}</td>

                        {{-- <td class="text-left">{{$value->person_code}}</td> --}}
                        <td class="text-center">
                            {{ $suppiler->pr_uom_short }}</td>
                        <td class="text-center">
                            {{ $suppiler->unit_qty }}</td>


                        <td class="text-right">
                            {{ number_format($suppiler->purchase_price, 2, '.', '') }}</td>

                        <td class="text-right">
                            {{-- {{ number_format((($suppiler->unit_qty * $suppiler->purchase_price) + ( $suppiler->vat_amount_itm)) - $suppiler->discount_amount_itm, 2, '.', '') }} --}}
                            {{ number_format(($suppiler->unit_qty * $suppiler->purchase_price) + ( $suppiler->vat_amount_itm) - $suppiler->discount_amount_itm)}}
                        </td>

                    </tr>

                    @php

                        $sales_total += (($suppiler->unit_qty * $suppiler->purchase_price) + ( $suppiler->vat_amount_itm)) - $suppiler->discount_amount_itm;

                        $grand_sales_total += (($suppiler->unit_qty * $suppiler->purchase_price) + ( $suppiler->vat_amount_itm)) - $suppiler->discount_amount_itm;

                    @endphp
                @endforeach

                <tr>

                    <th class="text-right bg-light-blue" colspan="6">Sub Total</th>
                    <th class="text-right bg-light-blue">{{ number_format($sales_total, 2) }}</th>

                </tr>
                @php
                    $sup_vari1 = 'Test';
                    $sales_total = 0;
                @endphp
            @endforeach
        @endif
    </tbody>
    <tfoot>
        <tr>

            <th class="text-right bg-light-blue" colspan="6">Grand Total</th>
            <th class="text-right bg-light-blue">{{ number_format($grand_sales_total, 2) }}</th>

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
