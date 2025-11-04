@if(!empty($vitals_data))
@foreach ($vitals_data as $value)
<tr>
	<td class="text-center">{{$loop->iteration}}</td>
	<td class="text-left">{{$value->chief_complaints}}</td>
	<td class="text-left">{{$value->temp_val}} {{$value->temp_val_time}}</td>
	<td class="text-left">{{$value->height_val}} {{$value->h_mu_name}}</td>
	<td class="text-left">{{$value->weight_val}} {{$value->w_mu_name}}</td>
	<td class="text-left">{{$value->bp_val_dia}} - {{$value->bp_val_sys}}</td>
	<td class="text-left">{{$value->pulse_val}}</td>
	<td class="text-left">{{$value->ofc}}</td>
{{--	<td class="text-left">{{date("d/m/Y", strtotime($value->vital_date))}}</td>--}}
	<td class="text-left">{{$value->hospital_code}}</td>
</tr>
@endforeach
@endif
