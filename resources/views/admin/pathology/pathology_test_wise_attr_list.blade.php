<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.min.css') }}" rel="stylesheet">
<table class="table data-table-attr-list table-bordered table-striped mb-0">
    <thead>
        <tr class="global-uhl-table-bg">
            <th class="text-center">SL</th>
            <th class="text-center">Attribute Code</th>
            <th class="text-left">Attribute</th>
            <th class="text-center">Unit</th>
            <th class="text-left">Attribute Group</th>
            <th class="text-center">GS</th>
            <th class="text-center">SF</th>
            <th class="text-center">HP</th>
            <th class="text-center">GI</th>
            <th class="text-center">Show</th>
            <th class="text-center">Active</th>
        </tr>
    </thead>
    <tbody>
        @if(!empty($attrList))
        @foreach ($attrList as $record )
        <tr class="tr_attrList">
            <input type="hidden" name="exam_id_hidden" id="exam_id_hidden" value="{{$record->item_no_fk}}">
            <input type="hidden" name="teststruct_no_pk_hidden" id="teststruct_no_pk_hidden" value="{{$record->teststruct_no_pk}}">
            <input type="hidden" name="test_group_no_fk_hidden" id="test_group_no_fk_hidden" value="{{$record->test_group_no_fk}}">

            <td class="text-center sl">{{$record->sl_no}}</td>
            <td class="text-center attr_code">{{$record->teststruct_uid}}</td>
            <td class="text-left attr">{{$record->attr}}</td>
            <td class="text-center unit">{{$record->unit}}</td>
            <td class="text-left attrgroup">{{$record->attrgroup}}</td>
            <td class="text-center group_seq">{{$record->group_seq}}</td>
            <td class="text-center"><input type="checkbox" id="show_ind" name="show_ind" value="{{$record->show_ind}}" @if($record->show_ind == 1) checked @endif ></td>
            <td class="text-center"><input type="checkbox" id="hide_permanent" name="hide_permanent" value="{{$record->hide_permanent}}" @if($record->hide_permanent == 1) checked @endif></td>
            <td class="text-center"><input type="checkbox" id="graph_ind" name="graph_ind" value="{{$record->graph_ind}}" @if($record->graph_ind == 1) checked @endif></td>
            <td class="text-center"><input type="checkbox" id="show_ind" name="show_ind" value="{{$record->rpt_show_ind}}" @if($record->rpt_show_ind == 1) checked @endif></td>
            <td class="text-center"><input type="checkbox" id="status" name="status" value="{{$record->status}}" @if($record->status == 1) checked @endif></td>
        </tr>
        @endforeach
        @endif
    </tbody>
</table>


<script type="application/javascript"
        src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script >

    $(".data-table-attr-list").DataTable({
        "ordering": false,
		"bPaginate": true,
		"bLengthChange": false,
		"bAutoWidth": true
	});
</script>
