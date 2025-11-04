@if (!empty($item_details))
    @foreach ($item_details as $item)
        <tr>
            <td> {{ $item->product_name }} </td>
            <td class="text-center"> {{ $item->quantity }} </td>
            <td class="text-center"> {{ number_format($item->product_price, 2) }} </td>
            <td class="text-center"> {{ $item->batch_no }} </td>
            <td class="text-center"> {{ date("Y-m-d",strtotime($item->expiry_date)) }}</td>

        </tr>
    @endforeach
@endif
