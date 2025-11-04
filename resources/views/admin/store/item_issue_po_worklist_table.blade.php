<table class="table data-table table-striped table-bordered table-hover">
    <thead class="bg-primary">
        <tr>
            <th class="text-center">SL</th>
            <th class="text-center">Purchased Order No</th>
            <th class="text-center">PO Date</th>


            <th class="text-center">Supplier Name</th>
            <th class="text-center">No of Item</th>
            <th class="text-center">Purchase Order (Amount)</th>
            <th class="text-center">Action</th>
        </tr>
    </thead>

    <tbody>
        @if (!empty($all_purchased_orders_worklists))
            @foreach ($all_purchased_orders_worklists as $rbc)
                @php
                    $vat_ind = 0;
                    if ($rbc->vat_amount_itm > 0 || $rbc->discount_amount_itm > 0) {
                        $vat_ind = 1;
                    }
                @endphp
                <tr>
                    <td>{{ $loop->iteration }}</td>

                    <td class="text-left">
                        {{ $rbc->purchase_uid ?: '' }}
                    </td>

                    <td class="text-left">
                        {{ !empty($rbc->purchase_date) ? date('d/m/Y', strtotime($rbc->purchase_date)) : '' }}
                    </td>

                    <td class="text-center">
                        {{ $rbc->supplier_name ?: '' }}
                    </td>
                    <td class="text-left">
                        {{ $rbc->total_qty ?: '' }}
                    </td>
                    <td class="text-right">
                        {{ $rbc->total_amount ?: '' }}
                    </td>


                    <td>
                        <a href="{{ route('supplier_delivery_schedule.show', $rbc->purchaseorder_no_pk) }}"
                            rel="tab" class="btn btn-sm btn-info" title="Supplier Schedule">
                            <i class="fa fa-calendar" aria-hidden="true"></i>
                        </a>
                        @if (Session::get('user.ses_hospital_code') == 'EWMCH')
                            <a target="_blank"
                                href="{{ route('pharmacy.purchase_order_print', $rbc->purchaseorder_no_pk) }}"
                                class="btn btn-sm btn-info" title="Print"><i class="fas fa-print"></i></a>
                        @else
                            @if ($vat_ind == 1)
                                <a target="_blank"
                                    href="{{ route('pharmacy.purchase_order_print_vat', $rbc->purchaseorder_no_pk) }}"
                                    class="btn btn-sm btn-info" title="Print"><i class="fas fa-print"></i></a>
                                {{-- <a href="#" class="btn btn-sm btn-info" title="Send Email">
                            <i class="fa fa-envelope" aria-hidden="true"></i> --}}
                                </a>
                            @else
                                <a target="_blank"
                                    href="{{ route('pharmacy.purchase_order_print', $rbc->purchaseorder_no_pk) }}"
                                    class="btn btn-sm btn-info" title="Print"><i class="fas fa-print"></i></a>
                                {{-- <a href="#" class="btn btn-sm btn-info" title="Send Email">
                        <i class="fa fa-envelope" aria-hidden="true"></i> --}}
                                </a>
                            @endif
                        @endif


                        <!-- <a href="#" class="btn btn-sm btn-success" title="Edit"><i class="fas fa-edit"></i></a> -->
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>
