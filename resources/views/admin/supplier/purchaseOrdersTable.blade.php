<table class="table data-table table-striped table-bordered table-hover">
    <thead class="global-uhl-table-bg">
        <tr>
            <th class="text-center">SL</th>
            <th class="text-center">Supplier Name</th>
            <th class="text-center" width="10%">PO No.</th>
            <th class="text-center" width="15%">PO UID</th>
            <th class="text-center">PO Date</th>
            <th class="text-center">Action</th>
        </tr>
    </thead>
    <tbody>
        @if (!empty($purchaseOrders))
            @php
                $i = 1;
            @endphp
            @foreach ($purchaseOrders as $key => $purchaseOrder)
                @foreach ($purchaseOrder as $index => $item)
                    <tr>
                        @if($index == 0)
                            <td rowspan="{{ $purchaseOrder->count() }}">{{ $i++ }}</td>
                            <td class="text-left" rowspan="{{ $purchaseOrder->count() }}">
                                {{ $item->supplier_name ?: '' }}
                            </td>
                        @else
                            <td style="display: none">&nbsp;</td>
                            <td style="display: none">&nbsp;</td>
                        @endif
                        <td class="text-center">
                            {{ $item->purchaseorder_no_pk ?: '' }}
                        </td>
                        <td class="text-center">
                            {{ $item->purchase_uid ?: '' }}
                        </td>
                        <td class="text-center">
                            {{ !empty($item->purchase_date) ? date('d/m/Y', strtotime($item->purchase_date)) : '' }}
                        </td>
                        <td>
                            <a target="_blank" href="{{ route('v1.purchase-order-print', $item->purchaseorder_no_pk) }}" class="btn btn-sm btn-info" title="Print"><i class="fas fa-print"></i></a>
                            @if(!empty($item->po_doc_attachment_path))
                                <a href="{{ asset('/images/uploads/attachment/'.$item->po_doc_attachment_path) }}" target="_blank" class="btn btn-sm btn-success" title="PO File"><i class="fas fa-file"></i></a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            @endforeach
        @endif
    </tbody>
</table>
