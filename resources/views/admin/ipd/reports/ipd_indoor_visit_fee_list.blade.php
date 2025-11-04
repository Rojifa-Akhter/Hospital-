<div class="card-header ">
    <h5>
        <span class="updatedHeader">Ipd Doctor Visit List</span>
    </h5>
</div>
<div class="card-body">
    <div class="mt-2">
        <div class="table-responsive border-top border-right">
            <table class="table table-bordered table-hover mb-0">
                <thead class="bg-light-blue">

                    {{-- <tr>
                        <th class="text-center" scope="col">SL</th>
                        <th class="text-center" scope="col" style="width:62px;">Date</th>
                        <th class="text-center" scope="col">Invoice Id</th>
                        <th class="text-center" scope="col">Consultant Type</th>
                        <th class="text-center" scope="col">Admission No</th>
                        <th class="text-center" scope="col">Patient Name</th>
                        <th class="text-center" scope="col">Ward</th>
                        <th class="text-center" scope="col">Bed</th>
                        <th class="text-center" scope="col">Fee</th>

                    </tr> --}}

                    <tr>
                        <th class="text-center" scope="col">SL</th>
                        <th class="text-center" scope="col">Doctor Name</th>
                        <th class="text-center" scope="col">Visit Type</th>
                        <th class="text-center" scope="col">Morning & Time</th>
                        <th class="text-center" scope="col">Evening & Time</th>
                        <th class="text-center" scope="col">Night & Time</th>

                    </tr>
                </thead>
                <tbody>

                    @if (!empty($report_arr))
                        @foreach ($report_arr as $key => $dt)
                            <?php
                            $total_fee = 0;
                            $total_patient = 0;
                            ?>

                            <tr>
                                <th colspan="9" style="text-align: left;">{{ $key }}</th>
                            </tr>
                            @foreach ($dt as $row)
                                <tr>
                                    <td class="text-center bg-light">{{ $loop->iteration }}</td>
                                    <td> {{ !empty($row->doc_name) ? ucfirst($row->doc_name) : '' }} </td>

                                    <td class="text-left">
                                        {{ !empty($row->visit_type) ? ucfirst($row->visit_type) : '' }} </td>

                                    <td class="text-center">
                                        @if (date('G', strtotime($row->doctor_visit_date_time)) < 15)
                                            {{ date('d/m/y H:i a', strtotime($row->doctor_visit_date_time)) }}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if (date('G', strtotime($row->doctor_visit_date_time)) > 15 && date('G', strtotime($row->doctor_visit_date_time)) < 19)
                                            {{ date('d/m/y H:i a', strtotime($row->doctor_visit_date_time)) }}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if (date('G', strtotime($row->doctor_visit_date_time)) > 19 && date('G', strtotime($row->doctor_visit_date_time)) < 25)
                                            {{ date('d/m/y H:i a', strtotime($row->doctor_visit_date_time)) }}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                <tr>
                            @endforeach
                            {{-- <tr>
                                <td class="text-right" colspan="8">Sub Total</td>
                                <td class="text-right"><strong>{{ number_format($total_fee, 2) }}</strong></td>
                            </tr>
                            <div style="display: none">{{ $total_doctor_consultation_fee += round($total_fee) }}</div> --}}
                        @endforeach
                    @endif




                </tbody>
                {{-- <tfoot>
                    <tr>
                        <th class="text-right" scope="col" colspan="8">Total = </th>
                        <th scope="col" class="text-right bg-light-blue" style="text-align: right;">
                            <strong>{{ number_format($total_doctor_consultation_fee, 2) }}</strong>
                        </th>
                    </tr>
                </tfoot> --}}
            </table>
        </div>
    </div>
</div>

<script>
    // $(document).on('change', '#pat_type', function() {
    //     var selectedValue = $('#pat_type').find(":selected").text();
    //     $('.updatedHeader').text(selectedValue)
    //     $('#type').val(selectedValue)
    // });
</script>
