<div class="card shadow-sm">
    <div class="card-header text-danger pt-2 pb-2">
        <div class="row">
            <div class="col">
                @php
                    $prev_date = date('d-m-Y', strtotime('-1 day', strtotime(@$schedule_date)));
                    $next_date = date('d-m-Y', strtotime('+1 day', strtotime(@$schedule_date)));
                    $today = date('d-m-Y');
                @endphp
                <button type="button" class="btn btn-success btn-sm" aria-label="prev"
                    onclick="scheduleCalendar('{{ @$prev_date }}')"><span
                        class="fc-icon fc-icon-chevron-left"></span></button>
                <button type="button" class="btn btn-success btn-sm" aria-label="next"
                    onclick="scheduleCalendar('{{ @$next_date }}')"><span
                        class="fc-icon fc-icon-chevron-right"></span></button>
                <button type="button" class="btn btn-secondary btn-sm"
                    onclick="scheduleCalendar('{{ @$today }}')">Today</button>
            </div>
            <div class="col text-center">
                <input type="hidden" id="hdn_schedule_date" value="{{ @$schedule_date }}">
                <h5 class="text-uppercase">{{ date('l, d M, Y', strtotime(@$schedule_date)) }}</h5>
            </div>
            <div class="col"></div>
        </div>
    </div>

    <div class="card-body p-0" id="appointment_list">
        <div class="table-responsive">
            <table class="table table-bordered" id="calendar">
                <tbody>
                    @php
                        $time = strtotime('9.00 am');
                        $times = [];
                        $halfHour = 60 * 60;
                        $blocks = 12;
                        
                        $is_exist_arr = [];
                    @endphp

                    @while ($blocks)

                        @php
                            $sl = 0;
                            
                            $start_time = date('h:i', $time);
                            $start_time_num = strtotime(date('h:i a', $time)) * 1;
                            $end_time = date('h:i a', $time += $halfHour);
                            $end_time_num = strtotime($end_time);
                            $ampm = strtoupper(date('a', $time));
                        @endphp

                        <tr>
                            <td width="10%" class="bg-light-blue">
                                <h4>{{ $start_time }}</h4> <small>{{ $ampm }}</small>
                            </td>
                            @php $p=0; @endphp
                            @php$border_bottom = '';
                                
                            @endphp
                            @if (!empty($sc_arr))

                                @foreach ($sc_arr as $pat_id => $patient)

                                    @php
                                        
                                        $pat_info = explode('_', $patient);
                                        
                                        $pat_name = $pat_info[0];
                                        $service = $pat_info[1];
                                        $pat_start_time = $pat_info[2];
                                        $pat_end_time = $pat_info[3];
                                        $schedule_id = $pat_info[4];
                                        $invoice_id = $pat_info[5];
                                        
                                        $patient_no = $pat_info[6];
                                        
                                    @endphp

                                    @if (($pat_start_time >= $start_time_num && $pat_end_time < $end_time_num) || ($pat_end_time > $start_time_num && $pat_start_time < $end_time_num))

                                        @if ($pat_end_time > $end_time_num) @php $border_bottom="border-bottom-blue block-day"; @endphp
                                    @else
                                        @if ($pat_end_time >= $start_time_num && $pat_end_time <= $end_time_num)
                                            @php $border_bottom=" block-day"; @endphp @endif
                                        @endif

                                        @if (!isset($is_exist_arr[$pat_id]))
                                            @php $border_top=""; @endphp
                                        @endif

                                        <td class="pb-0 pt-0 {{ $border_bottom }} {{ $border_top }}" width="20%"
                                            style="vertical-align: top; padding-top: 0; padding-bottom: 0 !important;">
                                            <div>
                                                @php
                                                    $pat_sl = $pat_id . '_' . $sl;
                                                @endphp

                                                @if (!isset($is_exist_arr[$pat_id]))
                                                    <div class="card text-white bg-info mt-0 border-0">
                                                        <div class="card-header text-left">
                                                            {{ $pat_name }}

                                                            <span class="pat-sc-details float-right cursor-pointer"
                                                                tabindex="0" data-toggle="popover" data-trigger="focus"
                                                                title="{{ $pat_name }}"
                                                                href="{{ route('physiotherapy.patient-sc-details') }}"><i
                                                                    class="fa fa-eye"></i></span>

                                                        </div>
                                                        <div class="card-body text-left">
                                                            <h5 class="card-title">{{ $service }}</h5>

                                                            @if ($invoice_id == '')

                                                                <a href="{{ route('billing.service-billing', $patient_no . '-' . $schedule_id . '-' . 'physio') }}"
                                                                    class="badge badge-md badge-success p-1 mb-1 cursor-pointer"
                                                                    target="_blank" title="Billing Entry"
                                                                    data-id="{{ $schedule_id }}"><i
                                                                        class="fas fa-file-invoice"></i> Billing</a>


                                                                <!-- <span class="card-text badge badge-success border cursor-pointer p-1 mb-1 " data-id="{{ $schedule_id }}" data-action="{{ route('billing.service-billing', $patient_no) }}" data-title="Billing Entry" title="Billing Entry"  target="_blank"><i class="fa fa-dollar-sign"></i> Billing</span> -->
                                                            @else
                                                                <span
                                                                    class="card-text badge badge-warning border cursor-pointer p-1 mb-1 open-modal"
                                                                    data-id="{{ $invoice_id }}"
                                                                    data-action="{{ route('bill-invoice-physio', $invoice_id) }}"
                                                                    data-title="Billing Entry" title="Billing Entry"
                                                                    data-modal="common-modal-md"><i
                                                                        class="fa fa-dollar-sign"></i> Invoice</span>
                                                            @endif
                                                            <span
                                                                class="card-text badge badge-success border cursor-pointer p-1 mb-1"><i
                                                                    class="fa fa-envelope"></i> Email</span>
                                                            <span
                                                                class="card-text badge badge-success border cursor-pointer p-1 mb-1"><i
                                                                    class="fa fa-sms"></i> Sms</span>
                                                        </div>
                                                    </div>
                                                    @php
                                                        $sl++;
                                                        $is_exist_arr[$pat_id] = $sl;
                                                        
                                                    @endphp

                                                @endif
                                            </div>

                                        </td>
                                    @else
                                        <td></td>
                                    @endif
                                    @php
                                        $p++;
                                    @endphp

                                @endforeach

                                @php $tds = 5-$p; @endphp

                                @for ($m = 0; $m < $tds; $m++)
                                    <td></td>
                                    @php $sl++; @endphp
                                @endfor

                                @php $p=$tds=0; @endphp
                            @else
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            @endif
                        </tr>
                        @php
                            $sl = 0;
                            $blocks--;
                        @endphp
                    @endwhile
                </tbody>
            </table>
        </div>
    </div>
</div>
