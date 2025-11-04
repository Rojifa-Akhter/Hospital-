<div class="card-header ">
    <h5>
       <p><span class="updatedHeader">IPD</span>  Doctor Wise Service</p>
    </h5>
</div>
<div class="card-body">
    <div class="mt-2">
        <div class="table-responsive border-top border-right">
            <table class="table table-bordered table-hover mb-0">
                <thead class="bg-light-blue">

                    <tr>
                        <th class="text-center" scope="col">SL</th>
                        <th class="text-center" scope="col" style="width:62px;">Date</th>
                        <th class="text-center" scope="col">Invoice Id</th>
                        <th class="text-center" scope="col">Consultant Type</th>
                        <th class="text-center" scope="col">Admission No</th>
                        <th class="text-center" scope="col">Patient Name</th>
                        <th class="text-center" scope="col">Ward</th>
                        <th class="text-center" scope="col">Bed</th>
                        <th class="text-center" scope="col">Fee</th>

                    </tr>
                </thead>
                <tbody>
                    <?php
                    $total_doctor_consultation_fee = 0;
                    ?>
                    <?php
                    $total_fee = 0;
                    $total_patient = 0;
                    ?>

                    @if (!empty($report_arr))
                        @foreach ($report_arr as $key => $row)
                            <tr>
                                <th colspan="9" style="text-align: left;">{{ $key }}</th>
                            </tr>
                            <tr>
                                <td class="text-center bg-light">{{ $loop->iteration }}</td>
                                <td class="text-left" width="80px">
                                    <div>{{ date('d/m/y', strtotime($row->invoice_date)) }}</div>
                                </td>
                                <td class="text-left">{{ !empty($row->invoice_no_pk) ? $row->invoice_no_pk : '' }} </td>
                                <td class="text-left">
                                    {{ !empty($row->item_type_name) ? ucfirst($row->item_type_name) : '' }} </td>
                                <td class="text-left">{{ !empty($row->admission_no_pk) ? $row->admission_no_pk : '' }}
                                </td>
                                <td class="text-left">
                                    {{ !empty($row->patient_name) ? ucfirst($row->patient_name) : '' }}
                                </td>
                                <td class="text-left">{{ !empty($row->ward_name) ? ucfirst($row->ward_name) : '' }}
                                </td>
                                <td class="text-left">{{ !empty($row->bed_name) ? ucfirst($row->bed_name) : '' }} </td>
                                <td class="text-right">
                                    {{ !empty($row->item_rate) ? number_format($row->item_rate, 2) : '0.00' }} </td>



                                <div style="display: none">{{ $total_fee += round($row->item_rate) }}</div>
                        @endforeach
                    @endif
                    <tr>
                        <td class="text-right" colspan="8">Sub Total</td>
                        <td class="text-right"><strong>{{ number_format($total_fee, 2) }}</strong></td>

                    </tr>
                    <div style="display: none">{{ $total_doctor_consultation_fee += round($total_fee) }}</div>



                </tbody>
                <tfoot>
                    <tr>
                        <th class="text-right" scope="col" colspan="8">Total = </th>
                        <th scope="col" class="text-right bg-light-blue" style="text-align: right;">
                            <strong>{{ number_format($total_doctor_consultation_fee, 2) }}</strong>
                        </th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<script>
    $(document).on('change', '#pat_type', function() {
        var selectedValue = $('#pat_type').find(":selected").text();
        $('.updatedHeader').text(selectedValue)
        $('#type').val(selectedValue)
    });
</script>
