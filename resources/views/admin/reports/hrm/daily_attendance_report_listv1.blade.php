<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<style>
    .board_member_img {
        border: 1px solid black;
        width: 50px;
    }
</style>
<table class="table data-table table-bordered ">
    <thead class="global-uhl-table-bg">
        <tr>
            <td class="text-center" scope="col">#SL</td>
            <td class="text-left" scope="col">Date</td>
            <td class="text-left" scope="col">Day</td>
            <td class="text-left" scope="col">Shift</td>
            <td style="width:17%" class="text-left" scope="col">Start Time</td>
            <td style="width:8%" class="text-left" scope="col">End Time</td>

            <td class="text-left" scope="col">In Time</td>
            <td class="text-left" scope="col">Out Time</td>
            <td style="width:8%" class="text-left" scope="col">Status</td>
            <td class="text-left" scope="col">Working Hours</td>
        </tr>
    </thead>

    @if (isset($dailAttendanceReportSearch))
        @foreach ($dailAttendanceReportSearch as $data)
            <tr>
                <td class="text-center" scope="col">{{ $loop->iteration }}</td>
                <td class="text-left" scope="col">
                    {{ date('d/m/Y', strtotime($data->attendance_date)) }}
                    {{-- <div class="board_member_info d-flex justify-content-between">
                        <div class="d-inline-block mr-2 d-flex align-items-center" style="width: 50px;">
                            @if ($data->photo_name != '')
                                <img style="max-width: 100%; max-height:100%" class="rounded"
                                    src="{{ asset('images/uploads/doctor_images/thumb/') }}/{{ $data->photo_name }}"
                                    alt="No Photo">
                            @else
                                <img style="max-width: 100%; max-height:100%" class="rounded" style="width: 100%;"
                                    src="{{ asset('images/no-photo.png') }}" alt="No Photo">
                            @endif
                        </div>

                        <div class="board_member_details d-inline-block" style="width: 75%">

                            <table>
                                <tr>
                                    <td class="border-0 text-left"> <strong>Name</strong> </td>
                                    <td class="border-0 text-left"> : {{ $data->full_name }}</td>
                                </tr>
                                <tr>
                                    <td class="border-0 text-left"> <strong>Card No</strong> </td>
                                    <td class="border-0 text-left"> : {{ $data->person_card_no }}</td>
                                </tr>
                                <tr>
                                    <td class="border-0 text-left"> <strong>Designation</strong> </td>
                                    <td class="border-0 text-left"> : {{ $data->designation_name }}</td>
                                </tr>
                            </table>

                        </div>
                    </div> --}}


                </td>
                <td class="text-left" scope="col"></td>
                <td class="text-left" scope="col">{{ $data->shift_code }}</td>
                <td class="text-left" scope="col">

                    <table>
                        <tr>
                            <td class="border-0 text-left" colspan="2"></td>

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
                <td class="text-left @if($data->entry_type == "2") text-danger @endif" scope="col">
                    {{ isset($data->in_time) ? date('h:i a', strtotime($data->in_time)) : '' }}</td>


                <td class="text-left" scope="col">
                    {{ isset($data->lunch_out_time) ? date('h:i a', strtotime($data->lunch_out_time)) : '' }}</td>

                <td class="text-left" scope="col">
                    {{ isset($data->lunch_in_time) ? date('h:i a', strtotime($data->lunch_in_time)) : '' }}</td>
                <td class="text-left @if($data->entry_type == "2") text-danger @endif" scope="col">
                    {{ isset($data->out_time) ? date('h:i a', strtotime($data->out_time)) : '' }}</td>

                <td class="text-left" scope="col">{{ $data->over_time_min }}</td>
                @php
                    $minutes = $data->late_time_min;
                    $hours = intdiv($minutes, 60) . ':' . $minutes % 60;
                @endphp
            </tr>
        @endforeach
    @endif
</table>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}">
</script>
<script>
    $('.data-table').DataTable({
        "ordering": false,
        "bPaginate": false,
        "bLengthChange": false,
        "bAutoWidth": false
    });
</script>
