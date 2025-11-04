<div class="table-responsive">
    <table class="table table-bordered table-sm">
        <thead class="bg-light-blue">
            <tr>
                <th>SL#</th>
                <th>Invoice No</th>
                <th>MRN</th>
                <th>Sales</th>
                <th>Collection</th>
                <th>Discount</th>
            </tr>
        </thead>
        <tbody>
            @php
                $total_sales = 0;
                $total_collection = 0;
                $total_discount = 0;
            @endphp

            @forelse($discounts as $disc)
                @php
                    $total_sales += $disc->sales;
                    $total_collection += $disc->collection;
                    $total_discount += $disc->discount;
                @endphp
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $disc->invoice_no_fk }}</td>
                    <td>{{ $disc->patient_no_fk }}</td>
                    <td class="text-right">{{ number_format($disc->sales, 2) }}</td>
                    <td class="text-right">{{ number_format($disc->collection, 2) }}</td>
                    <td class="text-right">{{ number_format($disc->discount, 2) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center text-danger">No discount records found</td>
                </tr>
            @endforelse
        </tbody>
        @if(count($discounts) > 0)
        <tfoot>
            <tr class="bg-light-blue font-weight-bold">
                <td colspan="3" class="text-right">Total</td>
                <td class="text-right">{{ number_format($total_sales, 2) }}</td>
                <td class="text-right">{{ number_format($total_collection, 2) }}</td>
                <td class="text-right">{{ number_format($total_discount, 2) }}</td>
            </tr>
        </tfoot>
        @endif
    </table>
</div>
