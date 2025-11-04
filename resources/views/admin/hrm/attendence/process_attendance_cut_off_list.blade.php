<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<style>
    tr td {
        white-space: nowrap;
    }
</style>
<form action="{{ route('hrm.salary_sheet_update_frm_attendance') }}" method="post" id="Monthly_attendance_store">
    <table class="table table-bordered table-hover table-striped">
        <thead class="global-uhl-table-bg">
            <tr>
                <th class="text-left" scope="col">ID</th>
                <th class="text-left" scope="col">Name</th>
                <th class="text-left" scope="col">Designation</th>
                <th class="text-left" scope="col">Department</th>
                <th class="text-left" scope="col">Year-Month</th>
                <th class="text-left" scope="col">D.O.M</th>
                <th class="text-left" scope="col">working-Days</th>
                <th class="text-left" scope="col">Weekend</th>
                <th class="text-left" scope="col">Absent</th>
                <th class="text-left" scope="col">Late</th>
                <th class="text-left" scope="col">SL</th>
                <th class="text-left" scope="col">CL</th>
                <th class="text-left" scope="col">T.Leave-days</th>
                <th class="text-left" scope="col">LWP</th>
                <th class="text-left" scope="col">G.F</th>
                <th class="text-left" scope="col">Deduct.</th>
                <th class="text-left" scope="col">Allowance</th>
                <th class="text-left" scope="col">Paid Days</th>
                <th class="text-left" scope="col" style="width:72px">Over Time</th>
            </tr>
        </thead>
        <tbody>
            @if (isset($data))
                @foreach ($data as $sample_row)
                    <tr>
                        <td>
                            <input type="hidden" name="person_card_no[]" id="person_card_no"
                                value="{{ $sample_row->person_card_no }}" />
                            {{ $sample_row->person_card_no }}
                        </td>
                        <td>{{ $sample_row->full_name }}</td>
                        <td>{{ $sample_row->designation_name }}</td>
                        <td>{{ $sample_row->serviceunit_name }}</td>
                        <td style="text-align: center">
                            <input type="hidden" name="attendance_yyyymm[]" id="attendance_yyyymm"
                                value="{{ $sample_row->attendance_yyyymm }}" />
                            {{ $sample_row->attendance_yyyymm }}
                        </td>
                        <td style="text-align: center">{{ $sample_row->month_days }}</td>

                        @php
                            $holidays_diff = isset($sample_row->holidays) ? $sample_row->holidays : $sample_row->month_days - $sample_row->working_days;
                        @endphp
                        <td style="text-align: center">{{ $sample_row->month_days - $holidays_diff }}</td>
                        <td style="text-align: center">
                            {{ $holidays_diff }}</td>
                        <td style="text-align: center">{{ $sample_row->absent_days }}</td>
                        <td style="text-align: center">{{ $sample_row->late_days }}</td>
                        <td style="text-align: center">{{ $sample_row->sick_leave }}</td>
                        <td style="text-align: center">{{ $sample_row->casual_leave }}</td>
                        <td style="text-align: center">{{ $sample_row->sick_leave + $sample_row->casual_leave }}</td>
                        <td style="text-align: center">{{ $sample_row->leave_withoutpay_days }}</td>
                        <td style="text-align: center">{{ $sample_row->general_festival_days }}</td>
                        <td style="text-align: center">{{ $sample_row->amount_deduct }}</td>
                        <td style="text-align: center">{{ $sample_row->amount_allowance }}</td>
                        <td style="text-align: center">
                            {{ $sample_row->month_days - $sample_row->absent_days - $sample_row->leave_withoutpay_days }}
                        </td>
                        <td>
                            @if (isset($sample_row->ot_time))
                                <?php
                                $hour = floor($sample_row->ot_time / 60);

                                $min = $sample_row->ot_time - floor($sample_row->ot_time / 60) * 60;
                                ?>
                                {{ $hour }} : {{ $min }} hr
                            @else
                                0
                            @endif
                        </td>
                    </tr>
                @endforeach
            @else
            <tr>
                <td colspan="19" style="text-center">No data available</td>
            </tr>
            @endif
        </tbody>
    </table>
</form>

<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>

<script>
    $('.data-table').DataTable({
        "lengthMenu": [
            [50],
            [50]
        ]
    });
</script>
