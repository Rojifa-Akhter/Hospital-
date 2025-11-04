<div class="table-responsive border-top border-right">
    <table class="table table-bordered table-hover mb-0">
        <thead class="global-uhl-table-bg">
            <tr>
                <th class="text-center" scope="col">SL</th>
                <th class="text-center" scope="col" style="width:62px;">Date</th>
                <th class="text-center" scope="col">Patient Name</th>
                <th class="text-center" scope="col">Corporate Name</th>
                <th scope="col" class="text-right global-uhl-table-bg">Payable</th>
                {{-- <th scope="col" class="text-right global-uhl-table-bg">Discount</th>
                <th scope="col" class="text-right global-uhl-table-bg">Net Payable</th> --}}
            </tr>
        </thead>
        <tbody>
            @php
                $total_sales = $total_discount = $total_net_payable = 0;
                $counter = 0;
            @endphp
            @if (!empty($report_data))
                @foreach ($report_data as $key => $row)
                    <?php $counter = $counter + 1; ?>
                    @if ($row->sales > 1)
                        <tr>
                            <td class="text-center global-uhl-table-bg">{{ $counter }}</td>
                            <td class="text-left" width="80px">
                                <div>{{ date('d/m/Y', strtotime($row->invoice_date)) }}</div>
                            </td>
                            <td class="text-left">{{ $row->customer_name }}</td>
                            <td class="text-left">{{ $row->ccm_client_name }}</td>
                            <td class="text-right global-uhl-table-bg">{{ number_format($row->sales, 2, '.', '') }}
                            </td>
                            {{-- <td class="text-right global-uhl-table-bg">
                                {{ number_format($row->discount, 2, '.', '') }}</td>
                            <td class="text-right global-uhl-table-bg">{{ number_format($row->payment, 2, '.', '') }}
                            </td> --}}
                        </tr>
                    @endif
                    @php
                        $total_sales += $row->sales;
                        $total_discount += $row->discount;
                        $total_net_payable += $row->payment;
                    @endphp
                @endforeach
            @else
                <tr>
                    <th class="text-center" scope="col" colspan="15">No Data Available</th>
                </tr>
            @endif
        </tbody>
        <tfoot>
            <tr>
                <th class="text-right" scope="col" colspan="4">Total = </th>
                <th scope="col" class="text-right global-uhl-table-bg">
                    {{ number_format($total_sales, 2, '.', '') }}
                </th>
                {{-- <th scope="col" class="text-right global-uhl-table-bg">
                    {{ number_format($total_discount, 2, '.', '') }}
                </th>
                <th scope="col" class="text-right global-uhl-table-bg">
                    {{ number_format($total_net_payable, 2, '.', '') }}</th> --}}
            </tr>
        </tfoot>
    </table>
</div>
