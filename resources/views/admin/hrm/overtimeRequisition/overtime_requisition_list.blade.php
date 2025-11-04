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
<form action="{{ route('hrm.overtime_requisition_approve') }}" method="POST" id="ov_requisition_approve"
class="">
    @csrf
    <div style="overflow-y: auto; max-height: 528px;">
        <table class="table  table-bordered ">
            <thead class="global-uhl-table-bg">
                <tr>
                    <th class="text-center" scope="col">#SL</th>
                    <th class="text-left" scope="col" style="width:12%">Atten.Date</th>
                    <th class="text-left" scope="col" style="width:12%">Employee Card</th>
                    <th class="text-left" scope="col" style="width:17%">Employee Name</th>
                    <th class="text-left" scope="col" style="width:13%">Dept.</th>
                    <th style="width:13%" class="text-left" scope="col">Shift</th>
                    <th style="width:8%" class="text-center" scope="col">In Time</th>
                    <th style="width:8%" class="text-center" scope="col">Out Time</th>
                    <th style="width:8%" class="text-center" scope="col">Overtime Time<br>(hr : min)</th>
                    <th class="text-center" style="width:3%"><input type="checkbox" id="PathselectAll" /></th>
                </tr>
            </thead>

            @if (isset($overtimeRequisitiondata))
                @foreach ($overtimeRequisitiondata as $data)

                    <input type="hidden" name="person_no_fk[{{$data->attendance_no_pk}}]" value="{{ $data->person_no_fk }}" />
                    <input type="hidden" name="person_card_no[{{$data->attendance_no_pk}}]" value="{{ $data->person_card_no }}" />
                    <input type="hidden" name="attendance_date[{{$data->attendance_no_pk}}]" value="{{ $data->attendance_date }}" />
                    <input type="hidden" name="duty_in_time[{{$data->attendance_no_pk}}]" value="{{ $data->duty_in_time }}" />
                    <input type="hidden" name="duty_out_time[{{$data->attendance_no_pk}}]" value="{{ $data->duty_out_time }}" />
                    <input type="hidden" name="over_time_min[{{$data->attendance_no_pk}}]" value="{{ $data->over_time_min }}" />
                    <tr>
                        <td class="text-center" scope="col">{{ $loop->iteration }}</td>
                        <td class="text-left" scope="col">{{ date('d/m/Y', strtotime($data->attendance_date)) }}</td>
                        <td class="text-left" scope="col"> {{ $data->person_card_no }}</td>
                        <td class="text-left" scope="col">{{ $data->full_name }}</td>
                        <td class="text-left" scope="col">
                            {{ $data->serviceunit_name != '' ? $data->serviceunit_name : '' }}</td>
                        <td class="text-left" scope="col">

                            <table>
                                <tr>
                                    <td class="border-0 text-left" colspan="2"> {{ $data->shift_code }} </td>

                                </tr>
                                <tr>
                                    <td class="border-0 text-left"> <strong>Duty In </strong> </td>
                                    <td class="border-0 text-left"> :
                                        {{ isset($data->duty_in_time) ? date('h:i a', strtotime($data->duty_in_time)) : '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="border-0 text-left"> <strong>Duty Out </strong> </td>
                                    <td class="border-0 text-left"> :
                                        {{ isset($data->duty_in_time) ? date('h:i a', strtotime($data->duty_out_time)) : '' }}
                                    </td>
                                </tr>
                            </table>

                        </td>
                        <td class="text-center @if($data->entry_type == "2") text-danger @endif" scope="col" >
                            @if (
                                !isset($data->in_time) ||
                                    $data->leave_entry_ind == 1
                                    // ||
                                    // $data->shift_code == 'OFFDAY' ||
                                    // $data->shift_code == 'DAYOFF'
                                    )
                                -
                            @else
                                {{ isset($data->in_time) ? date('h:i a', strtotime($data->in_time)) : '' }}
                            @endif
                        </td>

                        <td class="text-center @if($data->entry_type == "2") text-danger @endif" scope="col">

                            @if (isset($data->in_time) && !isset($data->out_time))
                                No Out Time
                            @elseif (!isset($data->in_time) && !isset($data->out_time))
                                -
                            @elseif($data->leave_entry_ind == 1)
                            {{-- || $data->shift_code == 'OFFDAY' || $data->shift_code == 'DAYOFF' --}}
                                -
                            @elseif ($data->in_time == $data->out_time)
                                No Out Time
                            @else
                                {{ isset($data->out_time) ? date('h:i a', strtotime($data->out_time)) : '' }}
                            @endif
                        </td>

                        <td class="text-center" scope="col">
                                @php
                                    if(isset($data->out_time)){
                                        if(Session::get('user.ses_hospital_code') == 'UNICO'){
                                            $time =  explode(" ", $data->out_time);
                                            $to_time = strtotime($time[1]);
                                            $from_time = strtotime('18:00:00');
                                        }else{
                                            $to_time = strtotime(($data->shift_code == "OFFDAY") ? $data->in_time : $data->out_time);
                                            $from_time = strtotime(($data->shift_code == "OFFDAY") ? $data->out_time : $data->duty_out_time);
                                        }
                                        $ot_min = ($to_time - $from_time) / 60;
                                        $hr = intdiv($ot_min, 60) == 0 ? '00' :  intdiv($ot_min, 60);
                                        $min = $ot_min % 60 == 0 ? '00' :  $ot_min % 60;
                                        // $earlyMinutes = $data->early_time_min;
                                        $otHours =  $hr. ':' . $min;
                                    }else{
                                        $ot_min = 0;
                                    }
                                @endphp
                                @if ($ot_min % 60 > 0 || intdiv($ot_min, 60) > 0)

                                    <input type="text" class="form-control timepicker"  name="overtime[{{$data->attendance_no_pk}}]" value="{{$otHours}}">
                                    <input type="hidden" class="form-control timepicker"  name="overtime_hidden[{{$data->attendance_no_pk}}]" value="{{$otHours}}">
                                @else
                                    <input type="text" class="form-control timepicker" name="overtime[{{$data->attendance_no_pk}}]" value="{{$otHours}}">
                                    <input type="hidden" class="form-control timepicker"  name="overtime_hidden[{{$data->attendance_no_pk}}]" value="{{$otHours}}">
                                @endif

                        </td>
                        <td class="text-center"> <input type="checkbox" class="requisition_item" name="requisition_item[]"  value="{{$data->attendance_no_pk}}"> </td>
                    </tr>
                @endforeach
            @endif
        </table>
    </div>
    <div class="text-right mt-2">
        @php
        $response_action = route('hrm.overtime_requisition');
        @endphp
        <button type="button" class="btn btn-success btn-md text-right" onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">Approve</button>
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
            $('.requisition_item').prop('checked', true);
        } else {
            $('.requisition_item').prop('checked', false);
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
