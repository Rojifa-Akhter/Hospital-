<!-- @if(!empty($receive_arr))
@foreach($receive_arr as $row)
<tr>
	<td class="text-center">{{ $loop->iteration }}</td>
	<td class="text-center">{{ $row->prescription_uid }}</td>
	<td class="text-center">{{ $row->lab_uid }}</td>
	<td class="text-center">{{ date("d/m/Y", strtotime($row->report_delivery_date)) }}</td>
	<td class="text-center">{{ $row->test_name_list }}</td>
	<td class="text-center">{{ $row->container_name }}</td>
	<td class="text-center"></td>
	<td class="text-center"><button class="btn btn-sm btn-success">Recive</button></td>
</tr>
@endforeach
@else
<tr>
	<td colspan="8"><div class="alert alert-warning m-2 border">No Data Found</div></td>
</tr>
@endif -->