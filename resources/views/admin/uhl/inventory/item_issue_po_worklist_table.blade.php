<table class="table data-table table-striped table-bordered table-hover">
    <thead class="global-uhl-table-bg">
        <tr>
            <th class="text-center">SL</th>
            <th class="text-center" width="10%">PO No
            </th>
            <th class="text-center">PO Date</th>


            <th class="text-center">Supplier Name</th>
            <th class="text-center">No. of Item</th>
            <th class="text-center" width='20%'>PO Amount
            </th>

            <th class="text-center">
                Status
            </th>


            <th class="text-center">Action</th>
        </tr>
    </thead>

    <tbody>


        @if (!empty($all_purchased_orders_worklists))
            @foreach ($all_purchased_orders_worklists as $rbc)
                @php
                    $total = 0;
                    $vat_ind = 0;
                    if ($rbc->vat_amount_itm > 0 || $rbc->discount_amount_itm > 0) {
                        $vat_ind = 1;
                    }
                @endphp
                <tr>
                    <td>{{ $loop->iteration }}</td>

                    <td class="text-left">
                        {{ $rbc->purchaseorder_no_pk ?: '' }}
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


                        <table width="100%">
                            <tr>
                                <td class="text-left"><strong>Total
                                    </strong>
                                </td>
                                <td class="text-right">
                                    {{ number_format($rbc->total_amount, 2, '.', '') ? number_format($rbc->total_amount, 2, '.', '') : 0 }}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-left">
                                    <strong>VAT/Tax({{ number_format($rbc->vat_percent, 2, '.', '') }}%)</strong>

                                </td>
                                <td class="text-right">
                                    {{ number_format($rbc->vat_amount, 2, '.', '') }}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-left"><strong>Discount
                                        ({{ number_format($rbc->discount_percent, 2, '.', '') }}%)
                                    </strong></td>
                                <td class="text-right">
                                    {{ number_format($rbc->discount_amount, 2, '.', '') }}
                                </td>
                            </tr>
                            @php
                                $total = $rbc->total_amount + $rbc->vat_amount - $rbc->discount_amount;
                            @endphp
                            <tr>
                                <td class="text-left">
                                    <strong>Payable</strong>
                                </td>
                                <td class="text-right">
                                    {{ number_format($total, 2, '.', '') }}
                                </td>
                            </tr>
                        </table>


                    </td>

                    <td class="text-center">
                        {{ ucfirst(strtolower($rbc->po_save_option)) }}
                    </td>

                    <td>
                        @if (Session::get('user.ses_hospital_code') == 'EWMCH')
                            <a href="{{ route('pharmacy.purchase_order_edit', $rbc->purchaseorder_no_pk) }}"
                                class="btn btn-sm btn-info" title="Edit"><i class="fa fa-pencil-alt"
                                    aria-hidden="true"></i></a>


                            <a target="_blank"
                                href="{{ route('pharmacy.purchase_order_print', $rbc->purchaseorder_no_pk) }}"
                                class="btn btn-sm btn-info" title="Print"><i class="fas fa-print"></i></a>
                        @else
                            <a href="{{ route('v1-purchase-order.edit', $rbc->purchaseorder_no_pk) }}"
                                class="btn btn-sm btn-info" title="Edit" rel="tab"><i class="fa fa-pencil-alt"
                                    aria-hidden="true"></i></a>


                            <a target="_blank" href="{{ route('v1.purchase-order-print', $rbc->purchaseorder_no_pk) }}"
                                class="btn btn-sm btn-info" title="Print"><i class="fas fa-print"></i></a>
                                <a href="{{ route('v1.item-receive-grn', $rbc->purchaseorder_no_pk) }}"
                                class="btn btn-sm btn-info" title="grn"  target="_blank">GRN</a>
                        @endif


                        <!-- <a href="#" class="btn btn-sm btn-success" title="Edit"><i class="fas fa-edit"></i></a> -->
                        {{-- <a href="#" class="btn btn-sm btn-info" title="Send Email">
                        <i class="fa fa-envelope" aria-hidden="true"></i>
                    </a> --}}
                        <!-- <span class="btn btn-sm btn-danger" id="po_delete_{{ $rbc->purchaseorder_no_pk }}"
                            data-id='{{ $rbc->purchaseorder_no_pk }}' id="" title="Delete"
                            onclick="deletePo(this)">
                            <i class="fa fa-trash-alt"></i>
                        </span> -->

                    </td>
                </tr>
            @endforeach
        @endif


    </tbody>

</table>
