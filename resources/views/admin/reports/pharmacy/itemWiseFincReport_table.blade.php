<div class="table-responsive border-top border-right">
    <table class="table table-bordered table-hover mb-0">
        <thead class="bg-light-blue">
            <tr>
                <th class="text-center" scope="col">SL</th>
                <th class="text-left" scope="col">Test Name</th>
                <th class="text-center" scope="col">Today Item Qty</th>
                <th class="text-center" scope="col">No of Item</th>
                <th class="text-right" scope="col">Sales Amt.</th>
                <th class="text-right" scope="col">S. Charge</th>
                <th class="text-right" scope="col">Discount</th>
                <th class="text-right" scope="col">Net Payable Amt.</th>
                <th class="text-right" scope="col">Receive Amt.</th>

                {{-- <th scope="col" class="text-right">Dues Amt.</th> --}}
                <th scope="col" class="text-right">Action</th>
            </tr>
        </thead>
        <tbody>
            @php
                $service_charge = $current_item_qty = $total_item_amt = $disc_amount = $net_payable_total = $ledgerdtl_amt_payment = $due_total=$today_current_item_qty = 0;
            @endphp
            @if (!empty($serviceUnitData))
                @foreach ($serviceUnitData as $key => $rows)
                    @php
                        $dept_exp = explode('_', $key);
                        $dept = '';
                        if (!empty($dept_exp)) {
                            $dept = $dept_exp[1];
                        }
                        $dep_service_charge = $dep_current_item_qty = $dep_total_item_amt = $dep_disc_amount = $dep_net_payable_total = $dep_ledgerdtl_amt_payment = $dep_due_total =$today_dep_current_item_qty= 0;
                    @endphp
                    <tr>
                        <td class="text-left" colspan="8"> <strong> {{ $dept }} </strong></td>
                    </tr>
                    @foreach ($rows as $row)
                        @php
                            $net_payable = ($row->total_item_amt+$row->service_charge) - $row->disc_amount;
                            $due = $net_payable - $row->ledgerdtl_amt_payment;

                        @endphp


                        <tr>
                            <td class="text-center ">{{ $loop->iteration }}</td>
                            <td class="text-left">{{ $row->item_name }} </td>
                            <td class="text-center">{{ $row->todays_item_qty }} </td>
                            <td class="text-center">{{ $row->current_item_qty }} </td>
                            <td class="text-right">{{ number_format($row->total_item_amt, 2, '.', '') }}</td>
                            <td class="text-right">{{ number_format($row->service_charge, 2, '.', '') }}</td>
                            <td class="text-right">{{ number_format($row->disc_amount, 2, '.', '') }}</td>

                            <td class="text-right">{{ number_format($net_payable, 2, '.', '') }}</td>
                            <td class="text-right">{{ number_format($row->ledgerdtl_amt_payment, 2, '.', '') }}
                            </td>

                            {{-- <td class="text-right ">{{ number_format($due, 2, '.', '') }}</td> --}}
                            <td scope="col" class="text-right "><span
                                    class="btn btn-sm btn-success open-modal btnView"
                                    data-action="{{ route('item-wise-financial-item-dtl', [$form_date, $to_date, $row->item_no_fk]) }}"
                                    data-modal="common-modal-md" data-title="Item Details" title="View Invoice Details"
                                    data-id="{{ $row->item_no_fk }}"><i class="fa fa-eye"></i></span></td>
                        </tr>

                        @php
                            $dep_service_charge += $row->service_charge;
                            $today_dep_current_item_qty += $row->todays_item_qty;
                            $dep_current_item_qty += $row->current_item_qty;
                            $dep_total_item_amt += $row->total_item_amt;
                            $dep_disc_amount += $row->disc_amount;
                            $dep_net_payable_total += $net_payable;
                            $dep_ledgerdtl_amt_payment += $row->ledgerdtl_amt_payment;
                            $dep_due_total += $due;

                        @endphp
                    @endforeach
                    <tr>
                        <td class="text-right" scope="col" colspan="2"> <strong> Department Total = </strong>
                        </td>
                        <td scope="col" class="text-center bg-light-blue">{{ $today_dep_current_item_qty }}</td>
                        <td scope="col" class="text-center bg-light-blue">{{ $dep_current_item_qty }}</td>
                        <td scope="col" class="text-right bg-light-blue">
                            {{ number_format($dep_total_item_amt, 2, '.', '') }}</td>
                            <td scope="col" class="text-right bg-light-blue">
                            {{ number_format($dep_service_charge, 2, '.', '') }}</td>
                        <td scope="col" class="text-right bg-light-blue">
                            {{ number_format($dep_disc_amount, 2, '.', '') }}</td>

                        <td scope="col" class="text-right bg-light-blue">
                            {{ number_format($dep_net_payable_total, 2, '.', '') }}
                        </td>
                      
                        <td scope="col" class="text-right bg-light-blue">
                            {{ number_format($dep_ledgerdtl_amt_payment, 2, '.', '') }}</td>
                        {{-- <td scope="col" class="text-right bg-light-blue">
                            {{ number_format($dep_due_total, 2, '.', '') }}</td> --}}
                        <td></td>
                    </tr>
                    @php
                        $service_charge += $dep_service_charge;
                        $today_current_item_qty += $today_dep_current_item_qty;
                        $current_item_qty += $dep_current_item_qty;
                        $total_item_amt += $dep_total_item_amt;
                        $disc_amount += $dep_disc_amount;
                        $net_payable_total += $dep_net_payable_total;
                        $ledgerdtl_amt_payment += $dep_ledgerdtl_amt_payment;
                        $due_total += $dep_due_total;
                    @endphp
                @endforeach
            @else
                <tr>
                    <td class="text-center" scope="col" colspan="10">No Data Available</td>
                </tr>
            @endif
        </tbody>
        <tfoot>
            <tr>
                <td class="text-right" scope="col" colspan="2"> <strong> Total = </strong></td>
                <td scope="col" class="text-center bg-light-blue">{{ $today_current_item_qty }}</td>
                <td scope="col" class="text-center bg-light-blue">{{ $current_item_qty }}</td>
                <td scope="col" class="text-right bg-light-blue">
                    {{ number_format($total_item_amt, 2, '.', '') }}</td>
                    <td scope="col" class="text-right bg-light-blue">
                    {{ number_format($service_charge, 2, '.', '') }}</td>
                <td scope="col" class="text-right bg-light-blue">
                    {{ number_format($disc_amount, 2, '.', '') }}</td>

                <td scope="col" class="text-right bg-light-blue">
                    {{ number_format($net_payable_total, 2, '.', '') }}
                </td>
               
                <td scope="col" class="text-right bg-light-blue">
                    {{ number_format($ledgerdtl_amt_payment, 2, '.', '') }}</td>
                {{-- <td scope="col" class="text-right bg-light-blue">{{ number_format($due_total, 2, '.', '') }}
                </td> --}}
                <td></td>


            </tr>
        </tfoot>
    </table>
</div>
