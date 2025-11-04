<main>
    <div class="wrapper">
        <div style=" text-align:center; margin-bottom:5px; margin-top:20px  " class="mb-2">
            <span class="report-name" style="width:70%; border:solid black 1px; padding:10px;  "> Attendance
                Report</span>
        </div>
        <div style=" text-align:center;  width:100%; margin-bottom:10px" class="mb-2">


            <span class="report-date"><strong> Date: </strong> {{ $date }}
            </span>
        </div>
        <section id="lp-items">
            <div class="container">
                <table style="width: 100%;border-collapse:collapse;" cellpadding="1" cellspacing="0" border="1">
                    <tr class="table-tr" style="background-color: #E3E3E3;">
                        <td class="table-td" " scope=" col">
                            <strong>SL</strong>
                        </td>
                        <td class="table-td" " scope=" col">
                            <strong>Card No</strong>
                        </td>
                        <td class="table-td" " scope=" col"><strong>
                                Name</strong></td>
                        <td class="table-td" " scope=" col">
                            <strong>Designation</strong>
                        </td>
                        <td class="table-td" " scope=" col">
                            <strong>In Time</strong>
                        </td>
                        <td class="table-td" " scope=" col">
                            <strong>Out Time</strong>
                        </td>
                        <td class="table-td" " scope=" col">
                            <strong>Early Out</strong>
                        </td>
                        <td class="table-td" " scope=" col">
                            <strong>OTH</strong>
                        </td>
                        <td class="table-td" " scope=" col">
                            <strong>Remark</strong>
                        </td>


                    </tr>
                    {{-- </thead> --}}
                    {{-- <tbody> --}}

                    @if (isset($value))
                        @foreach ($value as $data)
                            <tr class="table-tr">
                                <td class="table-td" style="text-align: center;" scope="col">
                                    <strong>{{ $loop->iteration }}</strong>
                                </td>
                                <td class="table-td" style="text-align: left;" scope="col">
                                    <strong>{{ $data->person_card_no }}</strong>
                                </td>
                                <td class="table-td" style="text-align: left;" scope="col"><strong>
                                        {{ $data->full_name }}</strong></td>
                                <td class="table-td" style="text-align: left;" scope="col">
                                    <strong>{{ $data->designation_name }}</strong>
                                </td>
                                <td class="table-td" style="text-align: center;" scope="col">
                                    <strong>{{ isset($data->in_time) ? date('h:i a', strtotime($data->in_time)) : '' }}</strong>
                                </td>
                                <td class="table-td" style="text-align: center;" scope="col">
                                    <strong>{{ isset($data->out_time) ? date('h:i a', strtotime($data->out_time)) : '' }}</strong>
                                </td>
                                <td class="table-td" style="text-align: center;" scope="col">
                                    <strong>{{ $data->late_time_min }}</strong>
                                </td>
                                <td class="table-td" style="text-align: center;" scope="col">
                                    <strong>{{ $data->over_time_min }}</strong>
                                </td>
                                <td class="table-td" style="text-align: left;" scope="col">
                                    <strong>{{ $data->conflict_comments }}</strong>
                                </td>


                            </tr>
                        @endforeach
                    @endif

                    {{-- </tbody> --}}


                </table>
            </div>
        </section>
    </div>
</main>
</body>

</html>
