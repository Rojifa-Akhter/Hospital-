@include('admin.components.pdf_header')

<main>
    <div class="wrapper">
        <div style=" text-align:center; margin-bottom:5px; margin-top:20px  " class="mb-2">
            <span class="report-name" style="width:70%; border:solid black 1px; padding:10px;  "> Daily Leave Report</span>
        </div>
        <div style=" text-align:center;  width:100%; margin-bottom:10px" class="mb-2">


            <span class="report-date"><strong> From Date: </strong>{{$from_date? $from_date : ''}}
                <strong> To Date: </strong>{{$to_date? $to_date : ''}}

            </span>
        </div>
        <section id="lp-items">
            <div class="container">
                <table style="width: 100%;border-collapse:collapse;" cellpadding="1" cellspacing="0" border="1">
                    <tr class="table-tr" style="background-color: #E3E3E3;">
                        <td class="table-td" scope="col">
                            <strong>SL</strong>
                        </td>
                        <td class="table-td" scope="col">
                            <strong>Card No</strong></td>
                        <td class="table-td" scope="col"><strong>
                                Name</strong></td>
                        <td class="table-td" scope="col">
                            <strong>Designation</strong></td>
                        <td class="table-td" scope="col">
                            <strong>Date Of Joining</strong></td>
                        <td class="table-td" scope="col">
                            <strong>Day From</strong></td>
                        <td class="table-td w-5" scope="col">
                            <strong> Day To &nbsp; &nbsp; &nbsp; &nbsp;</strong></td>
                        <td class="table-td" scope="col">
                            <strong>Leave Count</strong></td>
                        <td class="table-td" scope="col">
                            <strong>Reason</strong></td>


                    </tr>
                    {{-- <tbody>--}}
                        
                    @if(isset($value))
                    @foreach($value as $data)
                    <?php
                    $date1 = date_create($data->from_date);
                    $date2 = date_create($data->to_date);
                    $diff = date_diff($date1, $date2);
                    $diff_date = $diff->format("%a ");
                    ?>
                    <tr class="">
                        <td class="" style="text-align: center;" scope="col">
                            {{$loop->iteration}}
                        </td>
                        <td class="" style="text-align: left;" scope="col">
                            {{$data->person_code}}</td>
                        <td class="" style="text-align: left;" scope="col">
                                {{$data->full_name}}</td>
                        <td class="" style="text-align: left;" scope="col">
                            {{$data->designation_name}}</td>
                        <td class="" style="text-align: left;" scope="col">
                            {{date('d/m/Y',strtotime($data->join_date))}}</td>
                        <td class="" style="text-align: left;" scope="col">
                            {{date('d/m/Y',strtotime($data->from_date ))}}</td>
                        <td class="" style="text-align: left;" scope="col">
                            {{date('d/m/Y',strtotime($data->to_date))}}</td>
                        <td class="" style="text-align: center;" scope="col">
                            {{$diff_date}}</td>
                        <td class="" style="text-align: left;" scope="col">
                            {{$data->leave_reason}}</td>


                    </tr>
                    @endforeach
                    @endif

                    {{-- </tbody>--}}


                </table>
            </div>
        </section>
    </div>
</main>
@include('admin.components.pdf_footer')