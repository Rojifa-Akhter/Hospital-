<style>
    .sticky_header{
        position:sticky;
        top: 37px;
        
    }
</style>

<div class="col-md-12">
    <table class="table data-table table-striped table-bordered table-hover data-table">
        <thead class="bg-light-blue sticky_header">
            <tr>
                <th class="text-center" scope="col">SL</th>
                <th class="text-center" scope="col">Voucher</th>
                <th class="text-center" scope="col" style="width:62px;">Date</th>
                <th class="text-center" scope="col">Patient</th>
                <th class="text-center" scope="col">Age</th>
                <th class="text-center" scope="col">Gender</th>
                <th class="text-center" scope="col">Contact</th>
                <th class="text-center" scope="col">Doctor</th>
                {{-- <th class="text-left" scope="col">Referral</th> --}}
                <th scope="col" class="text-right bg-light-blue">Sales</th>
                <th scope="col" class="text-right bg-light-blue">Discount</th>
                <th scope="col" class="text-right bg-light-blue">Net Sales</th>
                <th scope="col" class="text-right bg-light-blue">Collection</th>
                <th scope="col" class="text-right bg-light-blue">Due</th>
                <th scope="col" class="text-right bg-light-blue">Refund</th>
                <th scope="col" class="text-right bg-light-blue">Net Collection</th>
                <th class="text-center" scope="col" style="width: 80px;">Action</th>
            </tr>
        </thead>
        <tbody>

        <tbody>
            @php
                $final_payable = $final_discount = $final_net_payable = $final_paid = $final_due = $final_refund = $final_net_collection = $final_invoice = 0;
            @endphp
            @if (!empty($marketing_list))

                @foreach ($marketing_list as $key => $dt)
                    <tr class="bg-light-green">
                        <td class="text-left text-bold" colspan="16" style="">
                            <strong>{{ ucfirst($key) }}</strong></td>
                    </tr>
                    @php
                        $refund = 0;
                        $due = 0;
                        $total_invoice = 0;
                        $total_payable = 0;
                        $total_discount = 0;
                        $total_net_payable = 0;
                        $total_paid = 0;
                        $total_due = 0;
                        $total_refund = 0;
                        $total_net_collection = 0;
                        $total_invoice = 0;
                    @endphp
                    @foreach ($dt as $key => $row)
                        <tr>
                            <td class="text-center bg-light">{{ $loop->iteration }}</td>
                            <td class="text-left">{{ $row->invoice_code }} </td>
                            <td class="text-left" width="80px">
                                <div>{{ date('d/m/Y', strtotime($row->invoice_date)) }}</div>
                                <div>{{ date('H:i:s', strtotime($row->invoice_date)) }} </div>
                            </td>
                            <td class="text-left">
                                <div><strong>{{ $row->patient_code }}</strong></div>
                                <div> {{ $row->patient_name }}</div>
                            </td>
                            <td class="text-left" style="word-break: break-all; width: 60px;">{{ $row->age }}</td>
                            <td class="text-left">{{ $row->gender_txt }}</td>
                            <td class="text-left">{{ $row->mobile1 }}</td>
                            {{-- <td class="text-left">{{ $row->prescribed_physio_name }}</td> --}}
                            <td class="text-left">{{ $row->doctor_name }}</td>
                            <td class="text-right bg-light">{{ number_format($row->sales, 2, '.', '') }}</td>
                            <td class="text-right bg-light">{{ number_format($row->discount, 2, '.', '') }}</td>
                            <td class="text-right bg-light">{{ number_format($row->net_sales, 2, '.', '') }}</td>
                            <td class="text-right bg-light">{{ number_format($row->collection, 2, '.', '') }}</td>
                            <td class="text-right bg-light" id="due">{{ number_format($row->due, 2, '.', '') }}
                            </td>
                            <td class="text-right bg-light" id="refund">
                                {{ number_format($row->refund, 2, '.', '') }}</td>
                            <td class="text-right bg-light" id="refund">
                                {{ number_format($row->net_collection, 2, '.', '') }}</td>
                            <td style="width: 80px;">
                                <span Class="btn btn-sm btn-success open-modal btnView"
                                    data-action="{{ route('due-colletion-invoice', $row->invoice_no_pk) }}"
                                    data-modal="common-modal-md" data-title="Invoice Details"
                                    title="View Invoice Details" data-id="{{ $row->invoice_no_pk }}"><i
                                        class="fa fa-eye"></i></span>

                                <a href="{{ route('due-invoice-print', $row->invoice_no_pk) }}"
                                    target="_blank"Class="btn btn-sm btn-warning" title="Print"><i
                                        class="fa fa-print"></i></a>
                            </td>
                        </tr>
                        @php
                            $total_payable += $row->sales;
                            $total_discount += $row->discount;
                            $total_net_payable += $row->net_sales;
                            $total_paid += $row->collection;
                            $total_due += $row->due;
                            $total_refund += $row->refund;
                            $total_net_collection += $row->net_collection;
                            $total_invoice += $row->net_collection;
                        @endphp
                    @endforeach

                    <tr>
                        <th class="text-right" scope="col" colspan="8">Sub Total = </th>
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
                        <th class="text-center" scope="col" style="width: 80px;"></th>
                    </tr>

                    @php
                        $final_payable += $total_payable;
                        $final_discount += $total_discount;
                        $final_net_payable += $total_net_payable;
                        $final_paid += $total_paid;
                        $final_due += $total_due;
                        $final_refund += $total_refund;
                        $final_net_collection += $total_net_collection;
                        $final_invoice += $total_invoice;
                    @endphp
                @endforeach
            @else
                <tr>
                    <th class="text-center" scope="col" colspan="16">No Data Available</th>
                </tr>
            @endif
        </tbody>
        <tfoot>
            <tr>
                <th class="text-right" scope="col" colspan="8">Total = </th>
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
                <th class="text-center" scope="col" style="width: 80px;"></th>
            </tr>
        </tfoot>
    </table>
</div>
