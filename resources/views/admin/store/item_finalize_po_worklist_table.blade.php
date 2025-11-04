<table class="table data-table table-striped table-bordered table-hover">
    <thead class="bg-primary">
        <tr>
            <th class="text-center">SL</th>
            <th class="text-center">Purchased Order No</th>
            <th class="text-center">PO Date</th>


            <th class="text-center">Supplier Name</th>
            <th class="text-center">No. of Item</th>
            <th class="text-center">Purchase Order (Amount)</th>
            <th>
                Action

            </th>

            <th class="text-center">Action</th>
        </tr>
    </thead>

    <tbody>


        @if (!empty($all_purchased_orders_worklists))
            @foreach ($all_purchased_orders_worklists as $rbc)
              @php
                    $vat_ind = 0;
                    if(($rbc->vat_amount_itm>0)||($rbc->discount_amount_itm>0))
                    {
                       $vat_ind = 1;
                    }
              @endphp

                <tr>
                    <td>{{ $loop->iteration }}</td>

                    <td class="text-left">
                        {{ $rbc->purchase_uid ?: '' }}
                    </td>

                    <td class="text-center">
                        {{ !empty($rbc->purchase_date) ? date('d/m/Y', strtotime($rbc->purchase_date)) : '' }}
                    </td>

                    <td class="text-center">
                        {{ $rbc->supplier_name ?: '' }}
                    </td>
                    <td class="text-center">
                        {{ $rbc->total_qty ?: '' }}
                    </td>
                    <td class="text-right">
                        {{ number_format($rbc->total_amount, 2) ?: '' }}
                    </td>
                    <td class="text-center">
                        <input type="checkbox" name="purchase_order_pk_no[]" value="{{ $rbc->purchaseorder_no_pk }}">
                    </td>

                    <td>
                        @if($vat_ind==1)
                        <a target="_blank"
                            href="{{ route('pharmacy.purchase_order_print_vat', $rbc->purchaseorder_no_pk) }}"
                            class="btn btn-sm btn-info" title="Print"><i class="fas fa-print"></i>
                        </a>
                        @else
                        <a target="_blank"
                        href="{{ route('pharmacy.purchase_order_print', $rbc->purchaseorder_no_pk) }}"
                        class="btn btn-sm btn-info" title="Print"><i class="fas fa-print"></i>
                        </a>
                        @endif
                        {{-- <a href="#" class="btn btn-sm btn-info" title="Send Email">
                            <i class="fa fa-envelope" aria-hidden="true"></i> --}}

                        <!-- <a href="#" class="btn btn-sm btn-success" title="Edit"><i class="fas fa-edit"></i></a> -->
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
    @if (!empty($all_purchased_orders_worklists))
        <tfoot class="text-center">
            @php
                $response_url = route('pharmacy.item_finalize_po_worklist');
            @endphp
            <td colspan="6">
                <input type="hidden" id="issue_finalize_ind" name="issue_finalize_ind">

            </td>
            <td>
                <input type="button" class="btn btn-sm btn-info" name="issue_btn" value="Issue"
                    onclick="updateInd('issue');btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_url }}')">

            </td>
            <td></td>
        </tfoot>
    @endif
</table>
