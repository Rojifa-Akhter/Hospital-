@php
$analyzer = (isset($analyzer_list) && (!empty($analyzer_list))) ? $analyzer_list : [];
@endphp

@if(!empty($analyzer))
	<table class="table table-hover border-0 mb-0">
        @foreach ($analyzer as $record )
			<tr class="tr_analyzerList"> 
				<input type="hidden" name="analyzerattr_no_pk_hidden" id="analyzerattr_no_pk_hidden" value="{{$record->analyzerattr_no_pk}}">
				<input type="hidden" name="machine_attrib_hidden" id="machine_attrib_hidden" value="{{$record->machine_attrib}}">
				<input type="hidden" name="panel_attrib_hidden" id="panel_attrib_hidden" value="{{$record->panel_attrib}}">
				<input type="hidden" name="normal_result_hidden" id="normal_result_hidden" value="{{$record->normal_result}}">
				<input type="hidden" name="unit_hidden" id="unit_hidden" value="{{$record->unit}}">
				<input type="hidden" name="analyzer_no_hidden" id="analyzer_no_hidden" value="{{$record->analyzer_no}}">
				
				<td class="text-left border-0">{{$record->analyzer_name}}</td>
				<td class="text-right border-0"><input type="checkbox" id="status" name="status" value="{{$record->status}}" @if($record->status == 1) checked @endif></td>
			</tr>
		@endforeach
		{{-- <tr>
			<td class="text-left border-0">Md Nazmul Islam</td>
			<td class="text-right border-0"><input type="checkbox" name="" id="" checked></td>
		</tr> --}}
	</table>
@endif