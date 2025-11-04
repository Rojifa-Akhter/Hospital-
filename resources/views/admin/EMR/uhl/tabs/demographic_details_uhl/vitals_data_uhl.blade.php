@if(!empty($vitals_data))
@foreach ($vitals_data as $value)
<tr>
	<td class="text-center">{{$loop->iteration}}</td>
	<td class="text-center">{{ !empty($value->au_entry_at) ? date('d-m-Y', strtotime($value->au_entry_at)) : '' }}</td>
	<td class="text-center">{{$value->pulse_val}}</td>
	<td class="text-center">{{$value->bp_val_sys}} @if (isset($value->bp_val_sys) && $value->bp_val_dia)
		{{ '/' }}
	@endif {{ $value->bp_val_dia }}</td>
	{{-- <td class="text-left">{{$value->chief_complaints}}</td> --}}
	<td class="text-center">{{$value->temp_val}} {{$value->temp_val_time}}</td>
	<td class="text-center">{{$value->height_val}} {{$value->h_mu_name}}</td>
	<td class="text-center">{{$value->weight_val}} {{$value->w_mu_name}}</td>
	<td class="text-center">{{$value->bmi}}</td>
	{{-- <td class="text-left">{{$value->bp_val_dia}} - {{$value->bp_val_sys}}</td> --}}
	{{-- <td class="text-center">{{$value->ofc}}</td> --}}
	<td class="text-center"></td>
	<td class="text-center">{{$value->spo2_value}}</td>
	<td class="text-center"></td>
{{--	<td class="text-left">{{date("d/m/Y", strtotime($value->vital_date))}}</td>--}}
	{{-- <td class="text-left">{{$value->hospital_code}}</td> --}}
</tr>
@endforeach
@endif