@include('admin.components.pdf_header')

<main>
    <div class="wrapper">
        <div style=" text-align:center; margin-bottom:5px; margin-top:20px  " class="mb-2">
            <span class="report-name" style="width:70%; border:solid black 1px; padding:10px;  "> Leave Entry Report</span>
        </div>
{{--        <div style=" text-align:center;  width:100%; margin-bottom:10px" class="mb-2">--}}


            <span class="report-date"><strong>Date: {{ date("d/m/Y")}}</strong>
            </span>
{{--        </div>--}}
        <section id="lp-items">
            <div class="container">
                <table style="width: 100%;border-collapse:collapse;" cellpadding="1" cellspacing="0" border="1">
                    <tr class="table-tr" style="background-color: #E3E3E3;">
                        <td class="table-td"  scope="col" >
                            <strong>SL</strong>
                        </td>
                        <td class="table-td"  scope="col" >
                            <strong>Card No</strong></td>
                        <td class="table-td"  scope="col" >
                            <strong>Name</strong></td>
                        <td class="table-td" scope="col" >
                            <strong>Leave Date</strong>
                        </td><td class="table-td" scope="col" >
                            <strong>From Date</strong></td>
                        <td class="table-td" scope="col" >
                            <strong>To Date</strong></td>
                        <td class="table-td" scope="col" >
                            <strong>Leave Name</strong></td>

                    </tr>
                    @if(isset($value))
                        @foreach($value as $data)
                            <tr class="table-tr">
                                <td class="table-td" style="text-align: center;" scope="col" >
                                    {{$loop->iteration}}
                                </td>
                                 <td class="table-td" style="text-align: left;" scope="col" >
                                    {{ !empty($data->card_no)?$data->card_no: '' }}</td>
                                <td class="table-td" style="text-align: left;" scope="col" >
                                    {{ !empty($data->full_name)?$data->full_name: ''}}</td>
                                <td class="table-td" style="text-align: left;" scope="col" >
                                     {{!empty($data->leave_dates)? date("d/m/Y", strtotime($data->leave_dates)):''}}
                                <td class="table-td" style="text-align: left;" scope="col" >
                                     {{!empty($data->from_date)?date("d/m/Y", strtotime($data->from_date)) : ''}}
                                <td class="table-td" style="text-align: left;" scope="col" >
                                     {{!empty($data->to_dates)?date("d/m/Y", strtotime($data->to_dates)) : ''}}
                                <td class="table-td" style="text-align: left;" scope="col" >
                                    {{ !empty($data->leave_reason)?$data->leave_reason: '' }} </td>

                            </tr>
                        @endforeach
                    @endif

                </table>
            </div>
        </section>
    </div>
</main>


@include('admin.components.pdf_footer')
