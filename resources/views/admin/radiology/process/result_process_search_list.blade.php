<table class="table table-bordered table-hover table-striped m-0 mt-2">
    <thead class="bg-primary">
    <tr>
        <th>SL#</th>
        <th>Invoice No </th>
        <th>LAB No</th>
        <th>LAB ID</th>
        <th>Sample Coll. Date</th>
        <th>Exam Name</th>
        <th>Specimen</th>
        <th>Container</th>
        <th>Analyzer</th>
        <th>Status</th>
        <th>Status</th>
        <th>
            <input type="checkbox" id="selectAll" />
        </th>
        <th>Print</th>
    </tr>
    </thead>
    <tbody>

    @if(!empty($invoice_item_arr))

        @foreach($invoice_item_arr as $row)

            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td>{{ $row->invoice_code }}</td>
                <td></td>
                <td>{{ $row->lab_code }}</td>
                <td>{{ date('d/m/Y', strtotime($row->sc_sample_coll_keyed_time)) }}</td>
                <td>{{ $row->item_name }}</td>
                <td>{{ $row->sam_name }}</td>
                <td>{{ $row->container_name }}</td>
                @if($row->lab_result_prepared_key_ind == 1)
                    <td>Done</td>
                @else
                    <td></td>
                @endif

                @if($row->lab_result_prepared_key_ind == 1)
                    <td>Done</td>
                @else
                    <td></td>
                @endif

                @if($row->lab_result_final_key_ind == 1)
                    <td>Finalized</td>
                @elseif($row->lab_result_verify_key_ind == 1)
                    <td>Verified</td>
                @else
                    @if($row->lab_result_prepared_key_ind == 1)
                        <td>Prepared</td>
                    @else
                        <td></td>
                    @endif
                @endif
                <td class="text-center" >
                    <input type="hidden" name="hdn_lab_id" value="{{ $row->invoice_no_fk }}">
                    <input class="chk_sample_item_{{ $row->lab_no_pk }}" type="checkbox" name="chk_sample_item_dtl[]" value="{{ $row->report_no_fk }}" >
                </td>
                <td>
                    {{--                    @if( $type ==2   )--}}
                    {{--                        <a href="{{ url('result-entry-form', [$row->report_no_fk, $type]) }}" rel="tab" class="btn btn-sm btn-info text-white">Finalize Result</a>--}}
                    {{--                        <a href="{{ url('path/bc-report-pdf', $row->report_no_fk) }}" class="btn btn-sm btn-warning" target="_blank">Print</a>--}}
                    {{--                    @else--}}
                    {{--                        <a href="{{ url('result-entry-form', [$row->report_no_fk, $type]) }}" rel="tab" class="btn btn-sm btn-info text-white">Result</a>--}}
                    <a href="{{ url('path/bc-report-pdf', $row->report_no_fk) }}" class="btn btn-sm btn-warning" target="_blank">Report</a>
                    <a href="{{ url('path/bc-report-pdf', $row->report_no_fk) }}" class="btn btn-sm btn-success" target="_blank">Label</a>
                    {{--                    @endif--}}
                </td>
            </tr>
        @endforeach

    @else
        <tr>
            <td colspan="11" class="text-danger">No Data Found</td>
        </tr>
    @endif

    @if(empty($invoice_item_arr))
        <tr>
            <td class="text-center"></td>
            <td class="text-center"></td>
            <td class="text-left"></td>
            <td class="text-center"></td>
            <td class="text-left"></td>
            <td class="text-right"></td>
            <td class="text-right"></td>
            <td class="text-right"></td>
            <td class="text-right"></td>
            <td class="text-left"></td>
            <td class="text-left"></td>
            <td class="text-center"></td>
            <td class="text-left"></td>
            <td class="text-center"></td>
            <td class="text-center"></td>
        </tr>

    @else
        <tr>
            <td class="text-center"></td>
            <td class="text-center"></td>
            <td class="text-left"></td>
            <td class="text-center"></td>
            <td class="text-left"></td>
            <td class="text-right"></td>
            <td class="text-right"></td>
            <td class="text-right"></td>
            <td class="text-right"></td>
            <td class="text-left"></td>
            <td class="text-left"></td>
            <td class="text-center">
                @php
                    $response_action = route('pcrm.processed-list');
                @endphp
                <button class="btn btn-sm btn-success" onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')"><i class="fas fa-save"></i> Collect All</button>

            </td>
            <td class="text-left"></td>
            <td class="text-center"></td>
            <td class="text-center"></td>
        </tr>

    @endif

    </tbody>

</table>
<script>
    $('#selectAll').click(function(e){
        var table= $(e.target).closest('table');
        $('td input:checkbox',table).prop('checked',this.checked);
    });


</script>
