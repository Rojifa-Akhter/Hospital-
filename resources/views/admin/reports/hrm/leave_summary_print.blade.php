@include('admin.components.pdf_header')
<main>
    <div class="wrapper">
        <div style=" text-align:center; margin-bottom:5px; margin-top:20px  " class="mb-2">
            <span class="report-name" style="width:70%; border:solid black 1px; padding:10px;  ">Leave Summary
                Report</span>
        </div>
        <div style=" text-align:center;  width:100%; margin-bottom:10px" class="mb-2">


            <span class="report-date">
                <strong>From Date: </strong> {{$from_date }}
                <strong>To Date: </strong> {{ $to_date }}
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
                            <strong>EMP Code</strong>
                        </th>
                        <th class="table-td" style="text-align: center;" scope="col"><strong>
                                Name</strong></th>
                        <th class="table-td" style="text-align: center;" scope="col">
                            <strong>Desig.</strong>
                        </th>
                        <th class="table-td" style="text-align: center;" scope="col">
                            <strong>Dep.</strong>
                        </th>
                        <th class="table-td" style="text-align: center;" scope="col">
                            <strong>L.Request</strong>
                        </th>
                        <th class="table-td" style="text-align: center;" scope="col">
                            <strong>Available Leave</strong>
                        </th>
                        <th class="table-td" style="text-align: center;" scope="col">
                            <strong>Approved Leave</strong>
                        </th>
                        </th>

                    </tr>
                    @if (isset($leave_summary))
                        @foreach ($leave_summary as $data)
                            <tr class="table-tr">
                                <td class="table-td" style="text-align: center;" scope="col">{{ $loop->iteration }}</td>
                                <td class="table-td" style="text-align: left;" scope="col">{{ $data->person_code }}</td>
                                <td class="table-td" style="text-align: left;" scope="col">{{$data->full_name}}</td>
                                <td class="table-td" style="text-align: left;" scope="col">{{$data->designation_name}}</td>
                                <td class="table-td" style="text-align: left;" scope="col">{{$data->su_name}}</td>
                                <td class="table-td" style="text-align: center;" scope="col">{{$data->leave_request}}</td>
                                <td class="table-td" style="text-align: center;" scope="col">{{$data->available_leave}}</td>
                                <td class="table-td" style="text-align: center;" scope="col">{{$data->approved_leave}}</td>

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
