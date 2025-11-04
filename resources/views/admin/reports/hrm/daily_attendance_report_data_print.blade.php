<style>
    .board_member_img {
        border: 1px solid black;
        width: 50px;
    }

</style>

@include('admin.components.pdf_header')
<div style="width: 100%;">
    <div style=" text-align:center; margin-bottom:5px; margin-top:15px  ">
        <span class="report-name" style="width:70%; border:solid black 1px; padding:10px;  "> Daily Attendance
            Report</span>
    </div>
    <div style=" text-align:center;  width:100%; margin-bottom:5px" class="mb-2">
        <span class="report-date"><strong> Date: </strong> {{ $from_date }} </br> <strong> Day:
                {{ date('D', strtotime($from_date)) }} </strong>

        </span>
    </div>
</div>
</header>
<main>


    <table style="width: 100%;border-collapse:collapse;" cellpadding="1" cellspacing="0" border="1">
        <thead class="bg-primary">
            <tr>
                <th style="width: 5px">Sl#</th>
                <th style="width: 200px">Employee</th>
                <th style="width: 150px">Shift</th>
                <th>In </th>
                <th>Out</th>
                <th>Late Min</th>
                <th>Remarkes</th>
            </tr>
        </thead>

        <tbody>
            @php
            $listSl = 0; @endphp
            @if (!empty($emp_data))
                @foreach ($emp_data as $dept => $dept_data)
                    @php
                        $dep = 0;

                    @endphp
                    @foreach ($dept_data as $desig => $data)
                        @php
                            $des = 0;
                            $listSl++;
                            $dep++;

                        @endphp


                        <tr>
                            <td style="text-align: center;">{{ $listSl }}</td>

                            <td class="">
                                <div>
                                    <div class=" board_member_img "
                                        style="display: inline-block; margin-left: 5px; margin-top: 20px;">
                                        @if (!empty($data->photo_name))
                                            <img class="w-100 "
                                                src="{{ asset('images/uploads/doctor_images/thumb/') }}/{{ $data->photo_name }}"
                                                alt="" width="50" ;>
                                        @else
                                            <img class="w-100" src="{{ asset('images/no-photo.png') }}" alt=""
                                                style=" margin-top: 20px" width="40px" ;>
                                        @endif
                                    </div>
                                    <div style="display: inline-block; margin-left: 5px">
                                        {{ $data->person_card_no }} <br>
                                        {{ $data->full_name }}<br>
                                        {{ $data->designation_name }}<br>
                                        JD : {{ date('d/m/Y', strtotime($data->join_date)) }}<br>

                                    </div>
                                </div>

                            </td>
                            <td scope="col" style="text-align: center;">
                                <table>
                                    <tr>
                                        <td class="border-0 text-left" colspan="2"> {{ $data->shift_code }}
                                            ({{ date('h:i a', strtotime($data->duty_in_time)) }} -
                                            {{ date('h:i a', strtotime($data->duty_out_time)) }}) </td>
                                    </tr>

                                </table>
                            </td>
                            <td class="table-td" style="text-align: center;" scope="col">
                                {{ date('h:i a', strtotime($data->in_time)) }}
                            </td>
                            <td class="table-td" style="text-align: center;" scope="col">
                                {{ date('h:i a', strtotime($data->out_time)) }}
                            </td>
                            {{-- <td class="table-td" style="text-align: center;" scope="col" >
                        {{$data->over_time_min}}
                     </td> --}}
                            @php
                                $minutes = $data->late_time_min;
                                $hours = intdiv($minutes, 60) . ':' . $minutes % 60;
                            @endphp
                            <td class="table-td" style="text-align: center;" scope="col">
                                {{ $hours }} hour
                            </td>
                            <td class="table-td" style="text-align: left;" scope="col">
                                {{ $data->attendance_status_text }}
                            </td>
                        </tr>
                    @endforeach
                @endforeach
            @endif
        </tbody>

    </table>
</main>


@include('admin.components.pdf_footer')
