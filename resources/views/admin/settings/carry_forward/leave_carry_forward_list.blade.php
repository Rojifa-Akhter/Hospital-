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
<form action="{{ route('hrm.save-leave-carry-forward') }}" method="POST" id="leave_carry_forward_id"
class="">
    @csrf
        <div class="text-right mt-2">
            @php
                $response_action = route('hrm.leave-carry-forward');
            @endphp
            <button type="button" class="btn btn-success btn-md text-right mb-2" onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">Approve</button>
        </div>
        <table class="table  table-bordered">
            <thead class="global-uhl-table-bg">
                <tr>
                    <th class="text-center" scope="col">#SL</th>
                    <th class="text-left" scope="col" >Employee Name</th>
                    <th class="text-left" scope="col">Card No.</th>
                    <th class="text-left" scope="col">Designation</th>
                    <th class="text-left" scope="col">Department</th>
                    <th class="text-center" scope="col">Leave Balance</th>
                    <th class="text-center" scope="col">Status</th>
                    <th class="text-center" style="width:3%"><input type="checkbox" id="PathselectAll" /></th>

                    
                </tr>
            </thead> 
                 <input type="hidden" name="year" value="{{ $year }}" />
            @if (count($leaveCarryForwardData) > 0)
                @foreach ($leaveCarryForwardData as $data)
                    <input type="hidden" name="person_no_pk[{{$data->person_no_pk}}]" value="{{ $data->person_no_pk }}" />
                    <input type="hidden" name="person_code[{{$data->person_no_pk}}]" value="{{ $data->person_code }}" />
                    <input type="hidden" name="full_name[{{$data->person_no_pk}}]" value="{{ $data->full_name }}" />
                    <input type="hidden" name="leave_type_lkp_no_fk[{{$data->person_no_pk}}]" value="{{ $data->leave_type_lkp_no_fk }}" />
                    <input type="hidden" name="balance[{{$data->person_no_pk}}]" value="{{ $data->balance }}" />
                   
                    <tr>
                        <td class="text-center" scope="col">{{ $loop->iteration }}</td>
                        <td class="text-left" scope="col">{{ $data->full_name }}</td>
                        <td class="text-left" scope="col"> {{ $data->person_code }}</td>
                        <td class="text-left" scope="col">{{$data->designation_name}}</td>
                        <td class="text-left" scope="col">{{$data->serviceunit_name}}</td>
                        <td class="text-center" scope="col">{{ $data->balance }}</td>
                        <td class="text-center" scope="col">
                            @if(isset($data->leave_balance))
                                <span class="badge badge-success">Approved</span>
                            @else
                                <span class="badge badge-danger">Pending</span>
                            @endif
                        </td>
                        <td class="text-center">
                            @if(isset($data->leave_balance))
                            @else
                                <input type="checkbox" class="leave_item" name="leave_item[]"  value="{{$data->person_no_pk}}">
                            @endif
                            
                             </td>

                    </tr>
                @endforeach
            @else
                    <tr>
                        <td class="text-center" colspan="7">No data found here</td>
                    </tr>
            @endif
        </table>
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
            $('.leave_item').prop('checked', true);
        } else {
            $('.leave_item').prop('checked', false);
        }
    });
    $(".timepicker").timepicker({
                defaultTime: new Date(),
                interval: false,
                // 'timeFormat': '24'
                // showInputs: false,
                showMeridian: false,
                minuteStep:1,
                // setTime: null
    });
</script>
