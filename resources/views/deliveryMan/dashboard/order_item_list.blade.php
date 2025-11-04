@if (!empty($item_details))
    @foreach ($item_details as $item)
        <tr>
            <td> {{ $item->product_name }} </td>
            <td class="text-center"> {{ $item->quantity }} </td>
            <td class="text-right"> {{ number_format($item->product_price, 2) }} </td>
            <td class="text-right"> {{ number_format($item->product_price * $item->quantity, 2) }} </td>
        </tr>
    @endforeach
@endif
