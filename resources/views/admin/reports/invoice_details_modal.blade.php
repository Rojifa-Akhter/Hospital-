<div class="table-responsive">
    @if ($invoice_no_pk)
        <h6 class="mb-2">
            <strong>Bill No:</strong> {{ $invoice_no_pk }}
        </h6>
    @endif
    <table class="table table-bordered table-sm">
        <thead class="bg-light-blue">
            <tr>
                <th>SL#</th>
                <th>Item Name</th>
                <th>Item Code</th>
                <th>Item Type</th>
                <th>Sales</th>
                <th>Payment</th>
                <th>Discount</th>
            </tr>
        </thead>
        <tbody>
            @php
                $total_sales = 0;
                $total_payment = 0;
                $total_discount = 0;
            @endphp

            @forelse($invoices as $inv)
                @php
                    $total_sales += $inv->sales;
                    $total_payment += $inv->payment;
                    $total_discount += $inv->discount;
                @endphp
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $inv->item_name }}</td>
                    <td>{{ $inv->item_no_fk }}</td>
                    <td>{{ $inv->item_type_name }}</td>
                    <td class="text-right">{{ number_format($inv->sales, 2) }}</td>
                    <td class="text-right">{{ number_format($inv->payment, 2) }}</td>
                    <td class="text-right">{{ number_format($inv->discount, 2) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center text-danger">No ledger details found</td>
                </tr>
            @endforelse
        </tbody>

        @if (count($invoices) > 0)
            <tfoot>
                <tr class="bg-light-blue font-weight-bold">
                    <td colspan="4" class="text-right">Total</td>
                    <td class="text-right">{{ number_format($total_sales, 2) }}</td>
                    <td class="text-right">{{ number_format($total_payment, 2) }}</td>
                    <td class="text-right">{{ number_format($total_discount, 2) }}</td>
                </tr>
            </tfoot>
        @endif
    </table>
</div>
