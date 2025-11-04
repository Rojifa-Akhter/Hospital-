<div class="col-md-12 table-responsive">
    <table class="table data-table table-striped table-bordered table-hover data-table">
        <thead class="bg-light-blue">
            <tr>
                <th class="text-center" scope="col">SL</th>
                <th class="text-center" scope="col">Area Name</th>
                <th class="text-center" scope="col">Total Patient</th>
                {{-- <th class="text-left" scope="col">Referral</th> --}}
                <th scope="col" class="text-right bg-light-blue">Sales</th>
                <th scope="col" class="text-right bg-light-blue">Discount</th>
                <th scope="col" class="text-right bg-light-blue">Net Sales</th>
                <th scope="col" class="text-right bg-light-blue">Collection</th>
                <th scope="col" class="text-right bg-light-blue">Due</th>
                <th scope="col" class="text-right bg-light-blue">Refund</th>
                <th scope="col" class="text-right bg-light-blue">Net Collection</th>
            </tr>
        </thead>
        <tbody>

        <tbody>
            @php
                $final_t_patient = $final_payable = $final_discount = $final_net_payable = $final_paid = $final_due = $final_refund = $final_net_collection = $final_invoice = 0;
            @endphp
            @if (!empty($marketing_list))
            @php
                $total_payable = $total_discount = $total_net_payable = $total_paid = $total_due = $total_refund = $total_net_collection = $t_patient = 0;
            @endphp
                @foreach ($marketing_list as $key => $row)
                    <tr>
                        <td class="text-center bg-light">{{ $loop->iteration }}</td>
                        <td class="text-left">{{ $row->patient_area_name }} </td>
                        <td class="text-right" >{{ $row->total_patient }} </td>
                        <td class="text-right bg-light">{{ number_format($row->total_sales, 2, '.', '') }}</td>
                        <td class="text-right bg-light">{{ number_format($row->total_discount, 2, '.', '') }}</td>
                        <td class="text-right bg-light">{{ number_format($row->total_net_sales, 2, '.', '') }}</td>
                        <td class="text-right bg-light">{{ number_format($row->total_collection, 2, '.', '') }}</td>
                        <td class="text-right bg-light" id="due">{{ number_format($row->total_due, 2, '.', '') }}
                        </td>
                        <td class="text-right bg-light" id="refund">
                            {{ number_format($row->total_refund, 2, '.', '') }}</td>
                        <td class="text-right bg-light" id="refund">
                            {{ number_format($row->total_net_collection, 2, '.', '') }}</td>
                    </tr>
                    @php
                        $total_payable += $row->total_sales;
                        $total_discount += $row->total_discount;
                        $total_net_payable += $row->total_net_sales;
                        $total_paid += $row->total_collection;
                        $total_due += $row->total_due;
                        $total_refund += $row->total_refund;
                        $t_patient += $row->total_patient;
                        $total_net_collection += $row->total_net_collection;
                    @endphp
                @endforeach
                <tr>
                    <th class="text-right" scope="col" colspan="2">Sub Total = </th>
                    <th scope="col" class="text-right bg-light-blue">
                        {{ number_format($t_patient) }}
                    </th>

                    <th scope="col" class="text-right bg-light-blue">
                        {{ number_format($total_payable, 2, '.', '') }}
                    </th>
                    <th scope="col" class="text-right bg-light-blue">
                        {{ number_format($total_discount, 2, '.', '') }}
                    </th>
                    <th scope="col" class="text-right bg-light-blue">
                        {{ number_format($total_net_payable, 2, '.', '') }}
                    </th>
                    <th scope="col" class="text-right bg-light-blue">
                        {{ number_format($total_paid, 2, '.', '') }}</th>
                    <th scope="col" class="text-right bg-light-blue">{{ number_format($total_due, 2, '.', '') }}
                    </th>
                    <th scope="col" class="text-right bg-light-blue">
                        {{ number_format($total_refund, 2, '.', '') }}</th>
                    <th scope="col" class="text-right bg-light-blue">
                        {{ number_format($total_net_collection, 2, '.', '') }}
                    </th>
                </tr>

                @php
                    $final_payable += $total_payable;
                    $final_discount += $total_discount;
                    $final_net_payable += $total_net_payable;
                    $final_paid += $total_paid;
                    $final_due += $total_due;
                    $final_refund += $total_refund;
                    $final_net_collection += $total_net_collection;
                    $final_t_patient += $t_patient;
                @endphp
            @else
                <tr>
                    <th class="text-center" scope="col" colspan="16">No Data Available</th>
                </tr>
            @endif
        </tbody>
        <tfoot>
            <tr>
                <th class="text-right" scope="col" colspan="2">Total = </th>
                <th scope="col" class="text-right bg-light-blue">{{ number_format($final_t_patient) }}
                <th scope="col" class="text-right bg-light-blue">{{ number_format($final_payable, 2, '.', '') }}
                </th>
                <th scope="col" class="text-right bg-light-blue">{{ number_format($final_discount, 2, '.', '') }}
                </th>
                <th scope="col" class="text-right bg-light-blue">
                    {{ number_format($final_net_payable, 2, '.', '') }}
                </th>
                <th scope="col" class="text-right bg-light-blue">{{ number_format($final_paid, 2, '.', '') }}</th>
                <th scope="col" class="text-right bg-light-blue">{{ number_format($final_due, 2, '.', '') }}</th>
                <th scope="col" class="text-right bg-light-blue">{{ number_format($final_refund, 2, '.', '') }}
                </th>
                <th scope="col" class="text-right bg-light-blue">
                    {{ number_format($final_net_collection, 2, '.', '') }}
                </th>
            </tr>
        </tfoot>
    </table>
</div>
