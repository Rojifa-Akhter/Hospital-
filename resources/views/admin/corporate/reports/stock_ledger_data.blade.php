<div class="table-responsive border-top border-right">
    <table class="table table-bordered table-hover mb-0">
        <thead class="bg-light-blue">
            <tr>
                <th class="text-center" scope="col" rowspan="2">SL</th>
                <th class="text-center" scope="col" rowspan="2">Corporate ID</th>
                <th class="text-center" scope="col" style="width:62px;" colspan="3">Contact</th>
                <th class="text-center" scope="col" rowspan="2">Signed Date</th>
                <th class="text-center" scope="col" rowspan="2">Start Date</th>
                <th class="text-center" scope="col" rowspan="2">End Date</th>
                <th class="text-center" scope="col" rowspan="2">Patient Count</th>
                <th scope="col" class="text-right bg-light-blue" rowspan="2">Sales</th>
                <th scope="col" class="text-right bg-light-blue" rowspan="2">Collection</th>
                <th scope="col" class="text-right bg-light-blue" rowspan="2">Due</th>
                <th class="text-center" scope="col" style="width: 80px;" rowspan="2">Action</th>
            </tr>

            <tr>
                <th class="text-center" scope="col">Person</th>
                <th class="text-center" scope="col">Designation</th>
                <th class="text-center" scope="col">Mobile</th>
            </tr>
        </thead>
        <tbody>
            @php
                $total_payable = $total_paid = $total_due = 0;
            @endphp

            @if (!empty($report_data))
                @foreach ($report_data as $row)
                    <tr>
                        <td class="text-center bg-light">{{ $loop->iteration }}</td>
                        <td class="text-left">{{ $row->ccm_client_code }} </td>
                        <td class="text-left"> {{ $row->contact_person }}</td>
                        <td class="text-left"> {{ $row->designation_name }}</td>
                        <td class="text-left"> {{ $row->contact_mobile }}</td>
                        <td class="text-center">
                            {{ !empty($row->contract_sign_date) ? date('d/m/y', strtotime($row->contract_sign_date)) : '' }}
                        </td>
                        <td class="text-center">
                            {{ !empty($row->start_date) ? date('d/m/y', strtotime($row->start_date)) : '' }}</td>
                        <td class="text-center">
                            {{ !empty($row->expire_date) ? date('d/m/y', strtotime($row->expire_date)) : '' }}</td>
                        <td class="text-center"> {{ $row->patient_count }}</td>
                        <td class="text-right bg-light">{{ number_format($row->net_sales, 2, '.', '') }}</td>
                        <td class="text-right bg-light">{{ number_format($row->collection, 2, '.', '') }}</td>
                        <td class="text-right bg-light">{{ number_format($row->due, 2, '.', '') }}</td>
                        <td style="width: 200px;">
                            {{-- <span Class="btn btn-sm btn-success open-modal btnView" data-action=""
                                data-modal="common-modal-md" data-title="Monthly Bill" title="View Monthly Bill"
                                data-id="" disabled><i class="fa fa-money-bill-alt"></i> Monthly Bill</span>

                            <a href="" target="_blank" Class="btn btn-sm btn-warning" title="Agreement"><i
                                    class="fa fa-file-contract" disabled></i> Agreement</a> --}}
                        </td>
                    </tr>
                    @php
                        $total_payable += $row->net_sales;
                        $total_paid += $row->collection;
                        $total_due += $row->due;
                    @endphp
                @endforeach
            @else
                <tr>
                    <th class="text-center" scope="col" colspan="13">No Data Available</th>
                </tr>
            @endif
        </tbody>
        <tfoot>
            <tr>
                <th class="text-right" scope="col" colspan="9">Total = </th>
                <th scope="col" class="text-right bg-light-blue">{{ number_format($total_payable, 2, '.', '') }}</th>
                <th scope="col" class="text-right bg-light-blue">{{ number_format($total_paid, 2, '.', '') }}</th>
                <th scope="col" class="text-right bg-light-blue">{{ number_format($total_due, 2, '.', '') }}</th>
                <th class="text-center" scope="col" style="width: 80px;"></th>
            </tr>
        </tfoot>
    </table>
</div>
