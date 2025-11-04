<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.min.css') }}" rel="stylesheet">
<hr>
<table class="table test-reference-value table-borderless mb-0">
    <thead>
    <tr class="global-uhl-table-bg">
        <th class="text-left">Gender</th>
        <th class="text-left">Age Group</th>
        <th class="text-left w-5">DD</th>
        <th class="text-left w-5">MM</th>
        <th class="text-left w-5">YY</th>
        <th class="text-left">Normal Result</th>
        <th class="text-left">CMP</th>
        <th class="text-left w-10">Normal Range</th>
        <th class="text-left w-10">Critical Range</th>
        <th class="text-center">Action</th>
    </tr>
    </thead>
    <tbody>
    @if(!empty($refvalList))
        @foreach ($refvalList as $record )
            <tr>
                <td class="text-left gender">{{$record->gender}}</td>
                <td class="text-left group_name">{{$record->group_name}}
                    <input type="hidden" id="ref_group_no_fk" name="ref_group_no_fk" value="{{$record->ref_group_no_fk}}">
                </td>
                <td class="text-left">
                    <input type="text" class="form-control custom-form" id="tr_high_age_dd" name="high_age_dd" value="{{$record->high_age_dd}}" placeholder="" readonly>
                    <input type="text" class="form-control custom-form" id="tr_low_age_dd" name="low_age_dd" value="{{$record->low_age_dd}}" placeholder="" readonly>
                </td>
                <td class="text-left">
                    <input type="text" class="form-control custom-form" id="tr_high_age_mm" name="high_age_mm" value="{{$record->high_age_mm}}" placeholder="" readonly>
                    <input type="text" class="form-control custom-form" id="tr_low_age_mm" name="low_age_mm" value="{{$record->low_age_mm}}" placeholder="" readonly>
                </td>
                <td class="text-left">
                    <input type="text" class="form-control custom-form" id="tr_high_age_yy" name="high_age_yy" value="{{$record->high_age_yy}}" placeholder="" readonly>
                    <input type="text" class="form-control custom-form" id="tr_low_age_yy" name="low_age_yy" value="{{$record->low_age_yy}}" placeholder="" readonly>
                </td>
                <td class="text-left normal_result">{{$record->normal_result}}</td>
                <td class="text-left com_operator">{{$record->com_operator}}</td>
                <td class="text-left">
                    <div class="input-group mb-2">
                        <input type="text" class="form-control" id="tr_low_result" name="low_result" value="{{$record->low_result}}" placeholder="0" readonly>
                        <input type="text" class="form-control" id="tr_high_result" name="high_result" value="{{$record->high_result}}" placeholder="0" readonly>
                    </div>
                </td>


                <td class="text-left">
                    <div class="input-group mb-2">
                        <input type="text" class="form-control" id="tr_low_critical_result" name="low_critical_result" value="{{$record->low_critical_result}}" placeholder="0" readonly>
                        <input type="text" class="form-control" id="tr_high_critical_result" name="high_critical_result" value="{{$record->high_critical_result}}" placeholder="0" readonly>
                    </div>
                </td>
                <td class="text-center">
                    <button class="btn btn-sm btn-success btn-attrRefval-edit" data-val="{{$record->referencevalue_no_pk}}" data-teststruct_no_fk="{{$record->teststruct_no_fk}}"><i class="fas fa-edit"></i></button>
                    <button class="btn btn-sm btn-danger btn-attrRefval-remove" data-val="{{$record->referencevalue_no_pk}}" data-teststruct_no_fk="{{$record->teststruct_no_fk}}"><i class="fas fa-trash"></i></button>
                </td>
            </tr>

        @endforeach
    @endif


    </tbody>

</table>
<script type="application/javascript"
        src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script >

    $(".test-reference-value").DataTable({
        "ordering": false,
		"bPaginate": true,
		"bLengthChange": false,
		"bAutoWidth": true
	});
</script>
