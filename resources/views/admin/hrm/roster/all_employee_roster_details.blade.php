<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style_custom.css') }}" />
<style>
    table {
        width: 100%;
        border-collapse: collapse;

    }
    tr th,
    tr td {
        white-space: nowrap;
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
    .sticky-col {
        position: sticky;
        background-color: #f7f7f7;
        box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
    }
    .sticky-col-sl{
        left:0;
        z-index: 4;
    }
    .sticky-col-eid,
    .sticky-col-name,
    .sticky-col-desig {
        position: sticky;
        background-color: #f7f7f7;
        box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        z-index: 2;
    }  
</style>
@php
    $ses_hospital_id = Session::get('user.ses_hospital_code');
@endphp
<div class="col-md-12">
    <div class="form-row">
        <div class="col-12">
            <div class="card shadow-xs">
                {{-- <div class="card-header">
                    <h5>All Employee Roster</h5>
                </div> --}}
                <form action="{{ route('roster.store-employee-roster-details') }}" method="post"
                    id="employee-roster-details">
                    @csrf
                    <div class="card-body">
                        <div class="row mt-2">
                            <div class="col-md-12">
                                @if (isset($from_date))
                                    <input type="hidden" name="from_dt" value="{{ $from_date }}">
                                    <input type="hidden" name="to_date" value=" {{ $to_date }}">
                                @endif
                                <div style="overflow-y: auto; max-height: 540px;">
                                    <table class="table table-bordered table-hover table-striped"
                                        style="font-size: 12px !important !important;">
                                        <thead class="" style="background: #ccc"> 
                                            <tr> 
                                                <th class="text-left">Sync Shift</th>
                                                <th class="text-center {{ empty($card_no) ? 'sticky-col sticky-col-sl' : '' }}">Sl</th>
                                                <th class="text-center {{ empty($card_no) ? 'sticky-col sticky-col-eid' : '' }}">EID</th>
                                                <th class="text-left {{ empty($card_no) ? 'sticky-col sticky-col-name' : '' }}">Name</th>
                                                {{-- <th class="text-center">Department</th> --}}
                                                <th class="text-left {{ empty($card_no) ? 'sticky-col sticky-col-desig' : '' }}">Designation</th>
                                                @php
                                                    if (isset($from_date)) {
                                                        $start_date = new DateTime($from_date);
                                                        $end_date = new DateTime($to_date);
                                                        for ($start_date; $start_date <= $end_date; $start_date->modify('+1 day')) {
                                                            $formated_start_date = \Carbon\Carbon::instance($start_date);
                                                            $currentDate = $formated_start_date->toDateString();
                                                            $holidayData = collect($holidayData);
                                                            $isHoliday = $holidayData->contains(function ($holiday) use ($currentDate) {
                                                                return \Carbon\Carbon::parse($holiday->holiday_date)->toDateString() === $currentDate;
                                                            }); 
                                                            echo "<th class='text-center' style='" . ($isHoliday ? 'color:red; font-weight: bold;' : '') . "'>" . $start_date->format('d') . "<br>".$start_date->format('D')."</th>";
                                                        }
                                                    }
                                                @endphp
                                                 <th class="text-center">Total Duty</th>
                                                 <th class="text-center">Total Hour</th>
                                                 <th class="text-center">Total Day Off</th>
                                            </tr>
                                        </thead>
                                        <tbody> 
                                            @if (!empty($hod_emp))
                                                @foreach ($hod_emp as $key => $data)
                                                    @if (isset($emp_info_arr[$data->person_no_pk]))
                                                    @php    
                                                        $total_duty_hour = 0;
                                                        $duty_count = 0;
                                                        $day_off_count = 0;
                                                    @endphp
                                                        <tr>   
                                                            <td class="text-center"><input type="checkbox" class="sync_shift"></td>
                                                            <td class="text-center {{ empty($card_no) ? 'sticky-col sticky-col-sl' : '' }}">{{ $key + 1 }}</td>
                                                            <td class="text-center {{ empty($card_no) ? 'sticky-col sticky-col-eid' : '' }}"> {{ $data->person_code }}</td>
                                                            <td class="text-left {{ empty($card_no) ? 'sticky-col sticky-col-name' : '' }}">
                                                                {{ $data->full_name }}
                                                                <input type="hidden" value="{{ $data->person_no_pk }}"
                                                                    name="user_arr[]">
                                                            </td>
                                                            {{-- <td class="text-left">
                                                            {{ $data->su_name }}</td> --}}
                                                            <td class="text-left {{ empty($card_no) ? 'sticky-col sticky-col-desig' : '' }} ">
                                                                {{ $data->designation }}</td>
                                                            @php
                                                                if (isset($from_date)) {
                                                                    $start_date = new DateTime($from_date);
                                                                    $end_date = new DateTime($to_date);
                                                                }
                                                            @endphp
                                                            @if (isset($from_date))
                                                                @for ($start_date; $start_date <= $end_date; $start_date->modify('+1 day'))
                                                                @php
                                                                    $formated_start_date = \Carbon\Carbon::instance($start_date);
                                                                    $currentDate = $formated_start_date->toDateString();
                                                                    $holidayData = collect($holidayData);
                                                                    $isHoliday = $holidayData->contains(function ($holiday) use ($currentDate) {
                                                                    return \Carbon\Carbon::parse($holiday->holiday_date)->toDateString() === $currentDate;}); 
                                                                @endphp
                                                                    <td class="text-center">
                                                                        <select id="shift"
                                                                            name="duty_shift_{{ $data->person_no_pk }}[]"
                                                                            class="form-control {{ Session::get('user.ses_hospital_code') == 'UNICO' ? 'duty_shift' : '' }}"
                                                                            style="width:44px !important; font-size:11px !important">
                                                                            <option value="">Select</option>
                                                                            @foreach ($shift as $d)
                                                                                @if (isset($roster_arr[$start_date->format('Y-m-d')][$data->person_no_pk]['shift']))
                                                                                    @if ($roster_arr[$start_date->format('Y-m-d')][$data->person_no_pk]['shift'] == $d->shift_no_pk)
                                                                                    @php
                                                                                        $total_duty_hour = $total_duty_hour  + $roster_arr[$start_date->format('Y-m-d')][$data->person_no_pk]['shift_hour'];
                                                                                        if($roster_arr[$start_date->format('Y-m-d')][$data->person_no_pk]['shift_hour'] != '0'){
                                                                                                $duty_count = $duty_count + 1;
                                                                                        }
                                                                                        if($roster_arr[$start_date->format('Y-m-d')][$data->person_no_pk]['shift_hour'] == '0'){
                                                                                                $day_off_count = $day_off_count + 1;
                                                                                        }
                                                                                        @endphp
                                                                                        <option
                                                                                            value="{{ date('Y-m-d h:i a', strtotime($d->start_time)) }}_{{ date('Y-m-d h:i a', strtotime($d->end_time)) }}_{{ $d->shift_no_pk }}_{{ strtoupper($d->shift_code) }}_{{ strtoupper($d->sheft_hour) }}_{{@$isHoliday ? '1' : '0'}}"
                                                                                            selected>
                                                                                            {{ $ses_hospital_id == 'EWMCH' ?  $d->shift_desc :  $d->shift_code }}
                                                                                            {{-- ({{ date('h:i a', strtotime($d->start_time)) }}-{{ date('h:i a', strtotime($d->end_time)) }}) --}}
                                                                                        </option>
                                                                                    @else
                                                                             
                                                                                        <option
                                                                                            value="{{ date('Y-m-d h:i a', strtotime($d->start_time)) }}_{{ date('Y-m-d h:i a', strtotime($d->end_time)) }}_{{ $d->shift_no_pk }}_{{ strtoupper($d->shift_code) }}_{{ strtoupper($d->sheft_hour) }}_{{@$isHoliday ? '1' : '0'}}">
                                                                                            {{ $ses_hospital_id == 'EWMCH' ?  $d->shift_desc :  $d->shift_code }}
                                                                                            {{-- ({{ date('h:i a', strtotime($d->start_time)) }}-{{ date('h:i a', strtotime($d->end_time)) }}) --}}
                                                                                        </option>
                                                                                    @endif
                                                                                @else
                                                                                    <option
                                                                                        value="{{ date('Y-m-d h:i a', strtotime($d->start_time)) }}_{{ date('Y-m-d h:i a', strtotime($d->end_time)) }}_{{ $d->shift_no_pk }}_{{ strtoupper($d->shift_code) }}_{{ strtoupper($d->sheft_hour) }}_{{@$isHoliday ? '1' : '0'}}">
                                                                                        {{ $ses_hospital_id == 'EWMCH' ?  $d->shift_desc :  $d->shift_code }}
                                                                                        {{-- ({{ date('h:i a', strtotime($d->start_time)) }}-{{ date('h:i a', strtotime($d->end_time)) }}) --}}
                                                                                    </option>
                                                                                @endif
                                                                            @endforeach
                                                                        </select>
                                                                    </td>
                                                                @endfor
                                                            @endif
                                                            <td class="text-center"> 
                                                                {{ $duty_count}}
                                                            </td>
                                                            <td class="text-center">
                                                                {{ $total_duty_hour }}
                                                            </td>
                                                            <td class="text-center">
                                                                {{ $day_off_count }}
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="7" class="text-center">
                                                       No data here
                                                    </td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                                @php
                                    $response_action = ($type == 'hr') ? route('roster.all.employee.hr') : route('roster.all.employee');
                                @endphp
                                <div class="text-right mt-2">
                                    <button class="btn btn-success"
                                        onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">
                                        Save </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        const slWidth = $('.sticky-col-sl').outerWidth();
        $('.sticky-col-eid').css(
            'left', slWidth + 'px'
        );
        const joinWidth = $('.sticky-col-eid').outerWidth();
        $('.sticky-col-name').css('left', (slWidth + joinWidth) + 'px');
        const idWidth = $('.sticky-col-name').outerWidth();
        $('.sticky-col-desig').css('left', (slWidth + joinWidth + idWidth) + 'px');
    });

    $(document).ready(function() {
        $("table tbody tr").click(function() {
            $("table tbody tr").css("background-color", "");
            $(this).css("background-color", "#fdf59a"); // Light yellow color
        });
    });
 
    $(document).on('click', 'tr .sync_shift', function () {
    var $tr = $(this).closest('tr');
    var isChecked = $(this).is(':checked');
    var $firstSelect = $tr.find('.duty_shift').first();
    var selectedValue = $firstSelect.val();

    if (isChecked) {
        $tr.find('.duty_shift').each(function(index) {
            if (index !== 0) {
                var $select = $(this);

                // Try to find a PH option that ends with _1
                var $phOption = $select.find('option').filter(function () {
                    var val = $(this).val();
                    return val.includes('PH') && val.endsWith('_1');
                });

                // If PH option exists, select it, else use first select's value
                if ($phOption.length) {
                    $select.val($phOption.val());
                } else {
                    $select.val(selectedValue);
                }
            }
        });
    } 
});



</script>