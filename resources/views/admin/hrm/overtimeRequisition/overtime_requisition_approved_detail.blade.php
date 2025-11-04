<link rel="stylesheet" href="{{ asset('asset/timepicker/css/timepicker.css') }}">
<div class="row">
    <div class="col-sm-12 col-lg-12 col-xl-12">
            <div class="form-group row">
                <div class="col-md-12">
                    <div style="font-size: 14px">
                        <p class="mb-0">Employee Name: <strong>{{$overtimeRequisitionDetailData[0]->full_name}}</strong></p>
                        <p class="mb-0">Card No.: <strong>{{$overtimeRequisitionDetailData[0]->person_card_no}}</strong></p>
                        <p class="mb-0" >Department: <strong>{{$overtimeRequisitionDetailData[0]->department}}</strong></p>
                        <p>Approved By: <strong>{{$overtimeRequisitionDetailData[0]->user_fullname}}
                            {{-- {{isset($overtimeRequisitionDetailData[0]->approve_date) ? ' ('.date('d-m-Y', strtotime($overtimeRequisitionDetailData[0]->approve_date)). ')': ""}} --}}
                        </strong></p>
                    </div>
                    <form action="{{ route('hrm.overtime_requisition_finalize') }}" method="POST" id="ot_approve">
                    @csrf
                    @php
                        $response_action = route('hrm.overtime_requisition_approved_list');
                    @endphp
                        @if(count($finalizedData) == 0)
                            <div class="text-right mb-2">
                                <button type="button" class="btn btn-sm btn-primary finalize">Finalize</button>
                            </div>
                        @endif
                        <table class="table table-bordered table-striped">
                            <thead class="global-uhl-table-bg">
                                <td>#SL</td>
                                <td class="text-left">1st Approved date</td>
                                <td class="text-left">Att. Date</td>
                                <td class="text-left">Actual OT</td>
                                <td class="text-left">Approved OT</td>
                                {{-- @if(count($finalizedData) == 0)
                                    <th class="text-center" style="width:3%"><input type="checkbox" id="PathselectAll" /></th>
                                @endif --}}
                            </thead>
                            <tbody>
                                @foreach($overtimeRequisitionDetailData as $key => $data)
                                <tr>
                                    <td class="text-center">{{ $key+1 }}</td>
                                    <td class="text-left">{{ isset($data->approve_date) ? date('d-m-Y', strtotime($data->approve_date)) : ""}}</td>
                                    <td class="text-left">{{ date('d-m-Y', strtotime($data->attendance_date))}}</td>
                                    <td class="text-left">
                                        <?php
                                            $actHour = intval(floor($data->actual_ot_time / 60)) > 0 ? intval(floor($data->ot_time / 60)) : '00';

                                            $actMin = intval($data->actual_ot_time -  floor($data->actual_ot_time / 60) * 60) > 0 ? intval($data->actual_ot_time -  floor($data->actual_ot_time / 60) * 60) : '00';
                                            $actOtHours =  $actHour. ':' . $actMin;
                                        ?>
                                            {{-- {{ $hour}} {{$min}} --}}
                                          {{ $actOtHours }}
                                    </td>
                                    <td class="text-left">
                                        <?php
                                            $hour = intval(floor($data->ot_time / 60)) > 0 ? intval(floor($data->ot_time / 60)) : '00';

                                            $min = intval($data->ot_time -  floor($data->ot_time / 60) * 60) > 0 ? intval($data->ot_time -  floor($data->ot_time / 60) * 60) : '00';
                                            $otHours =  $hour. ':' . $min;
                                        ?>
                                            {{-- {{ $hour}} {{$min}} --}}

                                            <input type="text" class="form-control timepicker"  name="overtime[{{$data->dailyot_no_pk}}]" value="{{$otHours}}">
                                    </td>
                                    <input type="hidden" class="ot_item" name="ot_item[]" value="{{ $data->dailyot_no_pk }}">
                                    {{-- @if(count($finalizedData) == 0)
                                    <td class="text-center">
                                        @if($data->finalize_ind != 1)
                                            <input type="checkbox" class="ot_item" name="ot_item[]" value="{{ $data->dailyot_no_pk }}">
                                        @endif
                                    </td>
                                    @endif --}}
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script type="application/javascript" src="{{ asset('asset/timepicker/js/timepicker.js') }}"></script>
    <script>
        $(".timepicker").timepicker({
            defaultTime: new Date(),
            interval: false,
            // 'timeFormat': '24'
            // showInputs: false,
            showMeridian: false,
            minuteStep:1,
            // setTime: null
        });

        // $('#PathselectAll').click(function(e) {
        //     if ($('#PathselectAll').is(':checked')) {
        //         $('.ot_item').prop('checked', true);
        //     } else {
        //         $('.ot_item').prop('checked', false);
        //     }
        // });

        // document.getElementById("PathselectAll").addEventListener("change", function () {
        //     const checkboxes = document.querySelectorAll('.ot_item');
        //     checkboxes.forEach(checkbox => checkbox.checked = this.checked);
        // });

        // function validateCheckboxes() {
        //     const checkboxes = document.querySelectorAll('.ot_item');
        //     const isChecked = Array.from(checkboxes).some(checkbox => checkbox.checked);
        //     if (!isChecked) {
        //         alert("Please check any box !!");
        //         return false;
        //     }
        //     return true;
        // }

        document.querySelector('.finalize').addEventListener('click', function(e) {
            // if (validateCheckboxes()) {
                btnSaveUpdateUpload(e.target, '', '', '', '', dynamicFunc.afterSaveLoadPage,
                '{{ $response_action }}')
            // }       
        })
    </script>


