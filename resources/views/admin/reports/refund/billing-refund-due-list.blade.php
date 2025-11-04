<div class="card-header ">
    <h5>
        @if (!empty($type))
            <span class="updatedHeader">Total {{ $type }}</span>
        @endif
        (<span class="text-danger"><?php if (!empty($report_data)) {
            echo count($report_data);
        } else {
            echo 0;
        } ?></span>)
    </h5>
</div>
<div class="card-body">
    <div class="mt-2">
        <div class="table-responsive border-top border-right">
            <table class="table table-bordered table-hover mb-0">
                <thead class="bg-light-blue">
                    <tr>
                        <th class="text-center" scope="col">SL</th>
                        @if ($type == 'Refund')
                            <th class="text-center" scope="col">Voucher</th>
                        @else
                        @if ($report_type != 'OPD')
                            <th class="text-center" scope="col">Admission ID</th>
                            @else
                            <th class="text-center" scope="col">Voucher</th>
                            @endif
                        @endif
                        <th class="text-center" scope="col" style="width:62px;">Date</th>
                        @if ($type == 'Refund')
                            <th class="text-center" scope="col">Cashier name</th>
                        @endif
                        <th class="text-center" scope="col">Patient</th>
                        {{-- <th class="text-center" scope="col">Age</th> --}}
                        {{-- <th class="text-center" scope="col">Gender</th> --}}
                        <th class="text-center" scope="col">Contact</th>
                        @if ($type == 'Refund')
                            <th class="text-center" scope="col">Doctor</th>
                        @endif

                        <th class="text-right" scope="col">
                            @if ($type == 'Refund')
                                Refund
                            @else
                                Due
                            @endif
                        </th>

                    </tr>
                </thead>
                <tbody>
                    @php
                        $total_tk = 0;
                    @endphp
                    @if (!empty($report_data))
                        @foreach ($report_data as $row)
                            <tr>
                                <td class="text-center bg-light">{{ $loop->iteration }}</td>
                                @if ($report_type != 'OPD')
                                    <td class="text-left">{{ $row->admission_no_pk }} </td>
                                    <td class="text-left" width="80px">
                                        <div>{{ date('d/m/Y', strtotime($row->admission_date)) }}</div>
                                    </td>
                                @else
                                    <td class="text-left">{{ $row->invoice_no_pk }} </td>
                                    <td class="text-left" width="80px">
                                        <div>{{ date('d/m/Y', strtotime($row->invoice_date)) }}</div>
                                    </td>
                                @endif
                                @if ($type == 'Refund')
                                    <td class="text-left">{{ $row->cashier_name }}</td>
                                @endif
                                <td class="text-left">
                                    <div><strong>{{ $row->patient_no_pk }}</strong></div>
                                    <div>{{ $row->patient_name }}</div>
                                </td>
                                {{-- <td class="text-left" style="word-break: break-all; width: 60px;">{{ $row->age }} --}}
                                </td>
                                {{-- <td class="text-left">{{ $row->gender_txt }}</td> --}}
                                <td class="text-left">{{ $row->mobile1 }}</td>
                                @if ($type == 'Refund')
                                    <td class="text-left">{{ $row->full_name }}</td>
                                @endif


                                <td class="text-right bg-light" id="refund">
                                    @if ($type == 'Refund')
                                        {{ number_format($row->refund, 2, '.', '') }}
                                    @else
                                        {{ number_format($row->due, 2, '.', '') }}
                                    @endif
                                </td>

                            </tr>
                            @php
                                if ($type == 'Refund') {
                                    $total_tk += $row->refund;
                                } else {
                                    $total_tk += $row->due;
                                }

                            @endphp
                        @endforeach
                    @endif
                </tbody>
                <tfoot>
                    <tr>
                        <th class="text-right" scope="col" colspan="7">Total = </th>
                        <th scope="col" class="text-right bg-light-blue" style="text-align: right;">
                            {{ number_format($total_tk, 2, '.', '') }}</th>
                    </tr>
                </tfoot>
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
