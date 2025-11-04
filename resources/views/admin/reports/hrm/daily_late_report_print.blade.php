@include('admin.components.pdf_header')
<main>
    <div class="wrapper">
        <div style=" text-align:center; margin-bottom:5px; margin-top:20px  " class="mb-2">
            <span class="report-name" style="width:70%; border:solid black 1px; padding:10px;  "> Daily Late
                Report</span>
        </div>
        <div style=" text-align:center;  width:100%; margin-bottom:10px" class="mb-2">


            <span class="report-date"><strong>From Date: {{ $date_from }}</strong> - <span
                    class="report-date"><strong>To Date: {{ $date_to }}</strong>
                </span>
        </div>
        <section id="lp-items">
            <div class="container">
                <table style="width: 100%;border-collapse:collapse;" cellpadding="1" cellspacing="0" border="1">
                    <tr class="table-tr" style="background-color: #E3E3E3;">
                        <th class="table-td" style="text-align: center;" scope="col">
                            <strong>SL</strong>
                        </th>
                        <th class="table-td" style="text-align: center;" scope="col">
                            <strong>Card No</strong>
                        </th>
                        <th class="table-td" style="text-align: center;" scope="col"><strong>
                                Name</strong></th>
                        <th class="table-td" style="text-align: center;" scope="col">
                            <strong>Designation</strong>
                        </th>
                        <th class="table-td" style="text-align: center;" scope="col">
                            <strong>In Time</strong>
                        </th>
                        <th class="table-td" style="text-align: center;" scope="col">
                            <strong>Late Time</strong>
                        </th>

                    </tr>
                    {{-- </thead> --}}
                    {{-- <tbody> --}}
                    @if (isset($value))
                        @foreach ($value as $data)
                            <tr class="table-tr">
                                <td class="table-td" style="text-align: center;" scope="col">
                                    {{ $loop->iteration }}
                                </td>
                                <td class="table-td" style="text-align: left;" scope="col">
                                    {{ $data->person_card_no }}</td>
                                <td class="table-td" style="text-align: left;" scope="col"><strong>
                                        {{ $data->full_name }}</td>
                                <td class="table-td" style="text-align: left;" scope="col">
                                    {{ $data->designation_name }}</td>
                                <td class="table-td" style="text-align: center;" scope="col">
                                    {{ isset($data->in_time) ? date('h:i a', strtotime($data->in_time)) : '' }}</td>
                                @php
                                    $minutes = $data->late_time_min;
                                    $hours = intdiv($minutes, 60) . ':' . $minutes % 60;
                                @endphp
                                <td class="table-td" style="text-align: center;" scope="col">
                                    {{ $hours }} hour</td>

                            </tr>
                        @endforeach
                    @endif
                    {{-- </tbody> --}}


                </table>
            </div>
        </section>
    </div>
</main>


@include('admin.components.pdf_footer')
