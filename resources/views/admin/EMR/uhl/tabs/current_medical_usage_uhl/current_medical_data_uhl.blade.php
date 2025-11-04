@if(isset($medical_equiment))
@foreach ($medical_equiment as $value)
<tr>
	<td class="text-center">{{$loop->iteration}}</td>
	<td class="text-center">{{ !empty($value->au_entry_at) ? date('d-m-Y', strtotime($value->au_entry_at)) : '' }}</td>
	<td class="text-left">{{$value->generic_name}}</td>
	<td class="text-left">{{$value->brand_name}}</td>
	<td class="text-left">{{$value->dosage}}</td>
	<td class="text-left">{{$value->duration}} {{ $value->duration_mu }}</td>
	<td class="text-left">{{$value->item_qty}}</td>
	{{-- <td class="text-left">{{$value->hospital_code}}</td> --}}
</tr>
@endforeach
@else

<tr>
	<td colspan="10" class="text-center">No Data Found</td>
</tr>
@endif