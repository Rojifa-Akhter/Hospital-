@if(!empty($lab_data))
@foreach ($lab_data as $value)
<tr>
	<td class="text-center">{{$loop->iteration}}</td>
	<td class="text-left">{{ !empty($value->invoice_date) ? date('d-m-Y', strtotime($value->invoice_date)) : '' }}</td>
	{{-- <td class="text-left">{{$value->invoice_code}}</td> --}}
	<td class="text-left">{{$value->item_name}}</td>
	{{-- <td class="text-left">{{!empty($value->report_delivary_date)?date("d/m/Y", strtotime($value->report_delivary_date)):""}}</td> --}}
	{{-- <td class="text-left">{{$value->lab_code}}</td> --}}
	{{-- <td class="text-left"></td> --}}
	<td class="text-center">
        <a href="{{ route('path.bc-report-pdf', $value ->report_no_fk) }}" class="btn btn-outline-primary btn-sm bg-none cursor-pointer " target="_blank"><i class="fa fa-file-pdf"></i></a>
    </td>
</tr>
@endforeach
@else

<tr>
	<td colspan="10" class="text-center">No Data Found</td>
</tr>
@endif