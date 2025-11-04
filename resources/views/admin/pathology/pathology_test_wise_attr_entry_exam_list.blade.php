<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.min.css') }}" rel="stylesheet">
<table class="table data-table-exam-list table-hover table-striped table-bordered mb-0">
    <thead>
        <tr class="global-uhl-table-bg">
            <th class="text-left">ID</th>
            <th class="text-left">Name</th>
        </tr>
    </thead>

    <tbody>
        @if(!empty($examList))
        @foreach ($examList as $record )
            <tr>
                <input type="hidden" name="exam_id_hidden" id="exam_id_hidden" value="{{$record->item_no_pk}}">
                <input type="hidden" name="item_name_hidden" id="item_name_hidden" value="{{$record->item_name}}">
                <input type="hidden" name="su_name_hidden" id="su_name_hidden" value="{{$record->serviceunit_name}}">
                <input type="hidden" name="sam_name_hidden" id="sam_name_hidden" value="{{$record->sam_name}}">
                <td class="text-left exam_uid">{{$record->item_code}}</td>
                <td class="text-left exam_name">{{$record->item_name}}</td>
            </tr>
        @endforeach
        @endif
    </tbody>
</table>

<script type="application/javascript"
        src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script >

    $(".data-table-exam-list").DataTable({
        "ordering": false,
		"bPaginate": true,
		"bLengthChange": false,
		"bAutoWidth": true
	});
</script>
