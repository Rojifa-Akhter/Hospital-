<table class="table table-bordered table-hover table-striped data-table">
    <thead class="global-uhl-table-bg">
        <tr>
            <th class="text-center">Sl</th>
            <th class="text-center">Item No</th>
            <th class="text-center">Generic Name</th>
            <th class="text-center">Item Name</th>
            <th class="text-center">Quantity</th>
            <th class="text-center">MRP</th>
            <th class="text-center">Cost Price</th>
            <th class="text-center" style="width: 10%;">Store Name</th>
            <th class="text-center">Supplier Name</th>
        </tr>
    </thead>
    <tbody id="searchOPDSellsReportTable">
        {{-- @php
            $totalCollection = 0;
        @endphp --}}

        @if (!empty($datas))
        @foreach ($datas as $data)
        <tr>
            <td class="text-center">{{ $loop->iteration }}</td>
            <td class="text-center">{{ $data->item_no_fk }}</td>
            {{-- <td class="text-center">{{ $data->invoice_date ? date('d/m/Y', strtotime($data->invoice_date)) : '' }}</td> --}}
            <td class="text-left">{{ $data->generic_name }}</td>
            <td class="text-left">{{ $data->item_name }}</td>
            <td class="text-center">{{ $data->qty }}</td>
            <td class="text-right">{{ $data->item_rate }}</td>
            <td class="text-right">{{ $data->purchase_price }}</td>
            <td class="text-left">{{ $data->store_name }}</td>
            <td class="text-left">{{ $data->supplier_name }}</td>
            {{-- <td class="text-right" style="width: 15%;">{{ number_format($data->item_wise_collection, 2) }}</td> --}}
        </tr>

        {{-- @php
        $totalCollection += $datas->item_wise_collection;
        @endphp --}}

        @endforeach
        @endif
    </tbody>
    {{-- <tfoot>
        <tr>
            <td colspan="5" class="text-right"><strong>TOTAL :</strong></td>
            <td class="text-right"><b>{{ number_format($totalCollection, 2) }}</b></td>
        </tr>
    </tfoot> --}}
        
</table>

  