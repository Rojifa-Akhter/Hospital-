@if(!empty($purchase_item))
@foreach($purchase_item as $item)
<tr>
	<input type="hidden"  name="item_ids[]" value="{{ $item->item_no_pk }}">
	<input type="hidden"  name="item_quantities[]" value="{{ $item->entry_qty }}">
	<input type="hidden"  name="item_prices[]" value="{{ $item->entry_qty }}">

	<td class="text-center">{{ $loop->iteration }} </td>
	<td class="text-center">{{ $item->item_code   }}</td>

	<td class="text-center">{{ $item->item_name }}</td>
	<td class="text-center"></td>
	
	<td class="text-center">{{ $item->purchase_price}}</td>
	<td class="text-center">{{ $item->item_rate }}</td>
	
	
	<td class="text-right "><input type="" name="text" class="text-right " onkeyup="calculateTotal(this,{{ $item->purchase_price }})" value="{{ $item->entry_qty }}"></td>
	<td  class="text-center"><span class="item_list">{{ $item->purchase_price*$item->entry_qty }}</span></td>
	<td><a href="javascript:void(0)" class="btn btn-sm btn-danger remove-item-btn" title="Remove"><i class="fa fa-times-circle"></i></a></td>
	
</tr>
@endforeach
@endif