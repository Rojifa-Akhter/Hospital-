
    @include('admin.uhl.ipd-patient-discharge-request-form')
    <div class="">
        <div class="col-md-12">
            <div class="row" id="">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped data-table">
                        <thead class="global-uhl-table-bg">
                            <tr>
                                <th>SL</th>
                                <th class="text-left">Admission No</th>
                                <th class="text-left">Admission Date</th>
                                <th class="text-left">Patient ID</th>
                                <th class="text-left">Patient Name</th>
                                <th class="text-left">Age</th>
                                <th class="text-left">Gender</th>
                                <th class="text-left">Mobile No</th>
                                <th class="text-left">Bed/Ward</th>
                                <th class="text-left">Primary Doctor</th>
                                <th class="text-right">Total Bill</th>
                                <th class="text-right">Discount</th>
                                <th class="text-right">Deposit</th>
                                <th class="text-right">Due</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>


                            @if (!empty($ipdpatList))
                            @foreach ($ipdpatList as $row)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $row['ADMISSION_NO_PK'] }}</td>
                                <td>{{ date('d/m/Y', strtotime($row['ADMISSION_DATE'])) }}</td>
                                <td>{{ $row['PATIENT_NO_PK'] }}</td>
                                <td>{{ $row['PATIENT_NAME'] }}</td>
                                <td>{{ $row['AGE'] }}</td>
                                <td>{{ $row['GENDER'] }}</td>
                                <td>{{ $row['MOBILE'] }}</td>
                                <td>{{ $row['BED_NAME'] }}</td>
                                <td>{{ $row['DOCTOR_NAME'] }}</td>
                                <td class="text-right">{{ number_format($row['SALES'],2) }}</td>
                                <td class="text-right">{{ number_format($row['DISCOUNT'],2) }}</td>
                                <td class="text-right">{{ number_format($row['PAYMENT'],2) }}</td>
                                <td class="text-right">{{ number_format($row['SALES'] - ($row['PAYMENT'] + $row['DISCOUNT']),2) }}</td>
                                <td>
                                    <div>
                                        <a target="_blank" href="{{ route('ipd.ipd-payment', $row['ADMISSION_NO_PK']) }}" class="btn btn-sm btn-success mb-1 mt-2"><i class="fa fa-money-bill"></i> Make
                                            Payment</a>

                                        {{-- <a href="{{ route('billing.service-billing', $row['PATIENT_NO_PK'] . '-' . $row['ADMISSION_NO_PK'] . '-' . 'ipd') }}"
                                        class="btn btn-sm btn-success" target="_blank"><i class="fa fa-receipt"></i>
                                        Service Billing</a> --}}
                                    </div>

                                    <div>
                                        {{-- <a href="{{ route('ipd.ipd-final-bill-print', $row['ADMISSION_NO_PK']) }}"
                                        class="btn btn-sm btn-success" target="_blank"><i class="fa fa-book"></i> Final Bill</a>

                                        <a href="{{ route('ipd.ipd-draft-print', $row['ADMISSION_NO_PK']) }}" target="_blank" class="btn btn-sm btn-success mb-1 mt-2"><i class="fa fa-print"></i> Draft Bills</a>
                                    </div>


                                    <button data-action="{{ route('ipd.ipd-update-discharge', $row['ADMISSION_NO_PK']) }}" onclick="updateDischargeInd(this)" class="btn btn-sm btn-danger mb-1 mt-2" title="Discharge" rel="tab"><i class="fa fa-person"></i> Discharge</button> --}}
                                </td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>



<script>
$('.date-picker').datepicker({
            todayHighlight: true,
            clearBtn: true,
            autoclose: true,
            endDate: '+0d',
            'format': 'dd-mm-yyyy'
        });
</script>