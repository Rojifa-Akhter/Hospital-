<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<style>
    .board_member_img {
        border: 1px solid black;
        width: 50px;
    }
    thead th {
        position: sticky;
        top: 0;
        z-index: 1;
        background: #fff0cb !important;
        color: #101010;
    }
    div[style*="max-height"] {
        border: 1px solid #dee2e6;
    } 
</style>
<form action="{{ route('hrm.store-emp-late-deduction-info') }}" method="POST" id="ov_requisition_approve"
class="">
    @csrf
    <input type="hidden" value="{{$year_month}}" name="year_month">
    <div style="overflow-y: auto; max-height: 535px;">
        <table class="table  table-bordered ">
            <thead class="global-uhl-table-bg">
                <tr>
                    <th class="text-center" scope="col">#SL</th>
                    <th class="text-left" scope="col">Employee Name</th>
                    <th class="text-left" scope="col">Employee Card</th>
                    <th class="text-left" scope="col">Dept.</th>
                    <th style="width:8%" class="text-left" scope="col">Total Late (Days)</th>
                    <th class="text-center" scope="col">Status</th>
                    <th class="text-center" scope="col">Action</th>
                    <th class="text-center" style="width:3%"><input type="checkbox" id="PathselectAll" /></th>
                </tr>
            </thead>

            @if (!empty($lateListdata))
                @foreach ($lateListdata as $data)
                <input type="hidden" name="person_no_fk[{{$data->person_no_fk}}]" value="{{ $data->person_no_fk }}" />
                <input type="hidden" name="no_of_days[{{$data->person_no_fk}}]" value="{{ $data->late_count }}" />
                <tr>
                    <td class="text-center" scope="col">{{ $loop->iteration }}</td>
                    <td class="text-left" scope="col">{{ $data->full_name }}</td>
                    <td class="text-left" scope="col"> {{ $data->person_card_no }}</td>
                    <td class="text-left" scope="col">
                        {{ $data->department != '' ? $data->department : '' }}</td>
                    <td class="text-center" scope="col">
                        {{$data->late_count}}
                    </td>
                    <td class="text-center" scope="col">
                        @if(in_array($data->person_no_fk, $personNos))
                            <span class="badge badge-success">Approved</span>
                        @else
                            <span class="badge badge-danger">Pending</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <a style="cursor:pointer" class="open-modal btn btn-sm btn-secondary" data-action="{{ route('hrm.late-detail',[$data->person_no_fk, $data->attendance_month]) }}"  data-modal="common-modal-md" data-title="Late Detail"  title="Late Detail">
                            <i class="fa fa-eye" aria-hidden="true" style="color: #fff !important"></i>
                        </a>
                        @if(in_array($data->person_no_fk, $personNos))
                            <a style="cursor:pointer" class="open-modal btn btn-sm btn-success" data-action="{{ route('hrm.approved-late-detail',[$data->person_no_fk, $data->attendance_month]) }}"  data-modal="common-modal-sm" data-title="Approved Detail"  title="Approved Detail">
                                <i class="fa fa-eye" aria-hidden="true" style="color: #fff !important"></i>
                            </a>
                            @endif
                    </td>
                    <td class="text-center">
                        @if(!in_array($data->person_no_fk, $personNos))
                            <input type="checkbox" class="late_deduction_item" name="late_deduction_item[]"  value="{{$data->person_no_fk}}">
                        @endif
                        
                    </td>
                </tr>
                @endforeach
            @else
                    <tr>
                        <td class="text-center" colspan="6">No data here</td>
                    </tr>
            @endif
        </table>
    </div>
    <div class="text-right mt-2">
        @php
        $response_action = route('hrm.late-list');
        @endphp
        <button type="button" class="btn btn-success btn-md text-center" onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">Save</button>
    </div>
</form>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}">
</script>
<script>
    $('.data-table').DataTable({
        "ordering": false,
        "bPaginate": false,
        "bLengthChange": false,
        "bAutoWidth": false
    });
    $(document).on("click", ".print", function(e) {

            var itemArray = $(".cheque_item")
                .map(function() {
                    if ($(this).is(":checked")) {
                        return this.value;
                    }
                }).get();
            if (itemArray == "") {
                alert("Please Select Item");
                return false;
            }
            // $('form').attr('action', "{{ route('cheque-print-all') }}");

    });
    $('#PathselectAll').click(function(e) {
        if ($('#PathselectAll').is(':checked')) {
            $('.late_deduction_item').prop('checked', true);
        } else {
            $('.late_deduction_item').prop('checked', false);
        }
    });
</script>
