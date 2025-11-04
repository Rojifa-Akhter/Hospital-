<style>
    @page {
        margin: 1.5cm;
    }

    body {
        font-family: 'IBM Plex Sans', Helvetica, Arial, sans-serif;
        font-size: 10px;
        margin: 0;
        color: #333;
    }

    .header {
        text-align: center;
        margin-bottom: 20px;
        font-size: 14px;
        font-weight: bold;
    }

    .hospital-address h1 {
        font-size: 18px;
        margin: 0;
    }

    .hospital-address p {
        font-size: 12px;
        margin: 5px 0;
    }

    .title {
        text-align: center;
        font-size: 14px;
        background-color: #f7f7f7;
        padding: 10px;
        margin-bottom: 20px;
        border: 1px solid #ddd;
        font-weight: bold;
    }

    .form-body {
        margin-top: 20px;
    }

    .heading h2 {
        margin-bottom: 5px;
        font-size: 16px;
    }

    .heading p {
        margin-top: 0;
        font-size: 12px;
        color: #555;
    }

    .table-responsive {
        margin-top: 15px;
        max-height: 500px;
        overflow-y: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        font-size: 9px;
    }

    table th,
    table td {
        padding: 8px;
        border: 1px solid #ddd;
        text-align: center;
    }

    table th {
        background-color: #f2f2f2;
    }

    table td {
        font-size: 10px;
    }

    .signature {
        width: 100%;
        display: flex;
        justify-content: space-between;
        margin-top: 40px;
    }

    .signature div {
        width: 30%;
        text-align: center;
        border-top: 1px solid #000;
        padding-top: 10px;
    }

    footer {
        position: fixed;
        bottom: 5px;
        width: 100%;
        text-align: center;
        font-size: 9px;
        padding-top: 5px;
        border-top: 1px solid #ddd;
    }

    footer span {
        display: block;
    }

    footer span:first-child {
        font-weight: bold;
    }
</style>

<div class="container" style="margin-top: 15px;">
    <div class="form-row justify-content-center">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <div class="form-content">
                        <div class="header">
                            <div class="hospital-address">
                                <h1>{{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }}
                                </h1>
                                <p>{{ isset($po_hospital_details->addrress1) ? $po_hospital_details->addrress1 : '' }}
                                </p>
                                <p>{{ isset($po_hospital_details->telephone1) ? $po_hospital_details->telephone1 : '' }}
                                </p>
                            </div>
                        </div>

                        <div class="form-body">
                            <div class="heading" style="text-align: center;">
                                <h2 class="text-center">
                                    @if ($type == 'referral_summary')
                                        Referral Bill Report
                                    @elseif ($type == 'referral_performance')
                                        Referral Performance Report
                                    @elseif ($type == 'referral_summary_1')
                                        Referral Bill Summary-01 Report
                                    @elseif ($type == 'referral_summary_2')
                                        Referral Bill Summary-02 Report
                                    @endif


                                </h2>
                                <p>From: {{ $date_from }} - To: {{ $date_to }}</p>
                            </div>

                            <div>
                                @if ($type == 'referral_summary' || $type == 'referral_performance')



                                    @if ($type == 'referral_performance' && $agent != '')
                                        <h2>Marketing Officer:
                                            <strong>{{ $agent_dt->person_code }}</strong>-{{ $agent_dt->full_name }}
                                        </h2>
                                    @endif
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>SL#</th>
                                                {{-- <th>
                                                @if ($type != 'referral_performance')
                                                    <input type="checkbox" id="select-all" /> <!-- Select All Checkbox -->
                                                @else
                                                    <input type="checkbox" id="select-all" disabled /> <!-- Select All Checkbox -->
                                                @endif
                                            </th> --}}
                                                <th>Referral Name</th>
                                                <th>Branch Name</th>
                                                <th>Invoice Qty</th>
                                                <th>Total Test Qty</th>

                                                <th>Total Sales Amount</th>

                                                <th>Payment</th> <!-- Corrected to match SQL field -->
                                                <th>Discount On Sales</th>
                                                <th>Net Sales Amount</th>
                                                @if ($type != 'referral_performance')
                                                    <th>Doctor Profit</th>
                                                    <th>Discount From Profit</th>
                                                @endif
                                                <th>Payable Profit</th>
                                                <th>Collection Amount</th> <!-- Corrected to match SQL field -->
                                                <th>Balance Due Amount</th> <!-- Corrected to match SQL field -->

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                // Initialize totals for each column
                                                $total_invoice_qty = 0;
                                                $total_test_qty = 0;
                                                $total_sales = 0;
                                                $total_payment = 0;
                                                $total_discount_by_org = 0;
                                                $total_discount = 0;
                                                $total_doctor_discount = 0;
                                                $total_net_sales = 0;
                                                $total_due = 0;
                                                $total_doctor_profit = 0;
                                                $total_payable_profit = 0;
                                                $total_collection_amount = 0; // Add this variable
                                            @endphp

                                            @foreach ($data as $row)
                                                <tr>
                                                    <!-- Individual Row Checkbox -->
                                                    <td class="text-center">{{ $loop->iteration }}</td>
                                                    {{-- <td class="text-center">
                                                    @if ($type != 'referral_performance')
                                                        <input type="checkbox" class="select-row" data-id="{{ $row->referral_id }}"
                                                            {{ $row->referral_payable_ind == 1 ? 'checked' : '' }} />
                                                    @else
                                                        <input type="checkbox" class="select-row" disabled
                                                            {{ $row->referral_payable_ind == 1 ? 'checked' : '' }}
                                                            data-id="{{ $row->referral_id }}" />
                                                    @endif

                                                </td> --}}
                                                    <td>
                                                        {{ $row->referral_name ?? 'Total' }}
                                                    </td>
                                                    <td>{{ $row->branch_name ?? '' }}</td>
                                                    <td class="text-center">
                                                        {{ number_format($row->total_invoice_qty, 0) }}</td>

                                                    <td class="text-center">
                                                        {{ number_format($row->total_test_qty, 0) }}</td>

                                                    <td class="text-right">{{ number_format($row->total_sales, 2) }}
                                                    </td>

                                                    <td class="text-right">{{ number_format($row->total_payment, 2) }}
                                                    </td>
                                                    <!-- Corrected to match SQL field -->
                                                    <td class="text-right">{{ number_format($row->total_discount, 2) }}
                                                    </td>
                                                    <td class="text-right">
                                                        {{ number_format($row->total_net_sales, 2) }}</td>
                                                    @if ($type != 'referral_performance')
                                                        <td class="text-right">
                                                            {{ number_format($row->total_doctor_profit, 2) }}</td>
                                                        <td class="text-right">
                                                            {{ number_format($row->total_doctor_discount, 2) }}</td>
                                                        <!-- Assuming it's "Discount from Profit" -->
                                                    @endif

                                                    @php
                                                        $payable_profit =
                                                            $row->total_doctor_profit - $row->total_doctor_discount;
                                                    @endphp
                                                    <td class="text-right">{{ number_format($payable_profit, 2) }}</td>

                                                    <td class="text-right">

                                                        {{ number_format($row->total_payment, 2) }}

                                                    </td>
                                                    <td class="text-right">{{ number_format($row->total_due, 2) }}</td>


                                                    @php
                                                        // Accumulate totals for footer
                                                        $total_invoice_qty += $row->total_invoice_qty;
                                                        $total_test_qty += $row->total_test_qty;
                                                        $total_sales += $row->total_sales;
                                                        $total_payment += $row->total_payment;
                                                        $total_discount_by_org += $row->total_discount_by_org;
                                                        $total_discount += $row->total_discount;
                                                        $total_doctor_discount += $row->total_doctor_discount;
                                                        $total_net_sales += $row->total_net_sales;
                                                        $total_due += $row->total_due;
                                                        $total_doctor_profit += $row->total_doctor_profit;
                                                        $total_payable_profit += $payable_profit;
                                                        $total_collection_amount += $row->total_payment; // Accumulate this value
                                                    @endphp
                                                </tr>
                                            @endforeach
                                        </tbody>

                                        <tfoot>
                                            <tr>
                                                <td colspan="3"><strong>Total</strong></td>
                                                <td class="text-center">{{ number_format($total_invoice_qty, 0) }}</td>

                                                <td class="text-center">{{ number_format($total_test_qty, 0) }}</td>

                                                <td class="text-right">{{ number_format($total_sales, 2) }}</td>

                                                <td class="text-right">{{ number_format($total_payment, 2) }}</td>
                                                <!-- Corrected to match SQL field -->
                                                <td class="text-right">{{ number_format($total_discount, 2) }}</td>
                                                <td class="text-right">{{ number_format($total_net_sales, 2) }}</td>
                                                @if ($type != 'referral_performance')
                                                    <td class="text-right">{{ number_format($total_doctor_profit, 2) }}
                                                    </td>
                                                    <td class="text-right">
                                                        {{ number_format($total_doctor_discount, 2) }}</td>
                                                    <!-- Assuming it's "Discount from Profit" -->
                                                @endif
                                                <td class="text-right">{{ number_format($total_payable_profit, 2) }}
                                                </td>

                                                <!-- Add the total collection and due amounts -->
                                                <td class="text-right">{{ number_format($total_collection_amount, 2) }}
                                                </td>
                                                <!-- Add this line for total collection -->

                                                <td class="text-right">{{ number_format($total_due, 2) }}</td>
                                                <!-- Add this line for total due -->

                                            </tr>
                                        </tfoot>
                                    </table>
                                @elseif ($type == 'referral_summary_1')
                                    @if ($type == 'referral_summary_1' && $agent != '')
                                        <h2>Marketing Officer:
                                            <strong>{{ $agent_dt->person_code }}</strong>-{{ $agent_dt->full_name }}
                                        </h2>
                                    @endif
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>SL#</th>
                                                <th>Referral Name</th>
                                                <th>Referral Address</th>
                                                <th>Total Invoice Qty</th>
                                                <th>Total Test Qty</th>
                                                <th>Total Sales Amount</th>
                                                <th>Discount On Sales</th>
                                                <th>Payable Amount</th>
                                                <th>Collection Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                // Initialize totals for each column
                                                $total_invoice_qty = 0;
                                                $total_test_qty = 0;
                                                $total_sales = 0;
                                                $total_discount = 0;
                                                $total_net_sales = 0;
                                                $total_due = 0;
                                                $total_doctor_profit = 0;
                                            @endphp

                                            @foreach ($data as $row)
                                                <tr>
                                                    <!-- Individual Row Checkbox -->
                                                    <td class="text-center">{{ $loop->iteration }}</td>
                                                    <td>
                                                        {{ $row->referral_name ?? 'total' }}
                                                    </td>
                                                    <td>{{ $row->referral_addr ?? '' }}</td>
                                                    <td class="text-center">
                                                        {{ number_format($row->total_invoice_qty, 0) }}</td>
                                                    <td class="text-center">
                                                        {{ number_format($row->total_test_qty, 0) }}</td>
                                                    <td class="text-right">{{ number_format($row->total_sales, 2) }}
                                                    </td>
                                                    <td class="text-right">{{ number_format($row->total_discount, 2) }}
                                                    </td>
                                                    <td class="text-right">
                                                        {{ number_format($row->total_net_sales, 2) }}</td>
                                                    <td class="text-right">
                                                        {{ number_format($row->total_doctor_profit, 2) }}</td>
                                                </tr>

                                                @php
                                                    // Accumulate totals for footer
                                                    $total_invoice_qty += $row->total_invoice_qty;
                                                    $total_test_qty += $row->total_test_qty;
                                                    $total_sales += $row->total_sales;
                                                    $total_discount += $row->total_discount;
                                                    $total_net_sales += $row->total_net_sales;
                                                    $total_due += $row->total_due;
                                                    $total_doctor_profit += $row->total_doctor_profit;
                                                @endphp
                                            @endforeach
                                        </tbody>

                                        <tfoot>
                                            <tr>
                                                <td colspan="3"><strong>Total</strong></td>
                                                <td class="text-center">{{ number_format($total_invoice_qty, 0) }}</td>
                                                <td class="text-center">{{ number_format($total_test_qty, 0) }}</td>
                                                <td class="text-right">{{ number_format($total_sales, 2) }}</td>
                                                <td class="text-right">{{ number_format($total_discount, 2) }}</td>
                                                <td class="text-right">{{ number_format($total_net_sales, 2) }}</td>
                                                <td class="text-right">{{ number_format($total_doctor_profit, 2) }}
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                @elseif ($type == 'referral_summary_2')
                                    @if ($type == 'referral_summary_2' && $agent != '')
                                        <h2>Marketing Officer:
                                            <strong>{{ $agent_dt->person_code }}</strong>-{{ $agent_dt->full_name }}
                                        </h2>
                                    @endif
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>SL#</th>
                                                <th>Referral Name</th>
                                                <th>Referral Address</th>
                                                <th>Total Invoice Qty</th>
                                                <th>Total Sales Amount</th>
                                                <th>Payable Profit</th>
                                                <th>Remarks</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                // Initialize totals for each column
                                                $total_invoice_qty = 0;
                                                $total_test_qty = 0;
                                                $total_sales = 0;
                                                $total_discount = 0;
                                                $total_net_sales = 0;
                                                $total_due = 0;
                                                $total_doctor_profit = 0;
                                            @endphp

                                            @foreach ($data as $row)
                                                <tr>
                                                    <!-- Individual Row Checkbox -->
                                                    <td class="text-center">{{ $loop->iteration }}</td>
                                                    <td>
                                                        {{ $row->referral_name ?? 'total' }}
                                                    </td>
                                                    <td>{{ $row->referral_addr ?? '' }}</td>
                                                    <td class="text-center">
                                                        {{ number_format($row->total_invoice_qty, 0) }}</td>
                                                    <td class="text-right">{{ number_format($row->total_sales, 2) }}
                                                    </td>
                                                    <td class="text-right">
                                                        {{ number_format($row->total_payable_profit, 2) }}</td>
                                                    <td class="text-right">

                                                    </td>
                                                </tr>

                                                @php
                                                    // Accumulate totals for footer
                                                    $total_invoice_qty += $row->total_invoice_qty;
                                                    $total_sales += $row->total_sales;
                                                    $total_doctor_profit += $row->total_payable_profit;
                                                @endphp
                                            @endforeach
                                        </tbody>

                                        <tfoot>
                                            <tr>
                                                <td colspan="3"><strong>Total</strong></td>
                                                <td class="text-center">{{ number_format($total_invoice_qty, 0) }}</td>
                                                <td class="text-right">{{ number_format($total_sales, 2) }}</td>
                                                <td class="text-right">{{ number_format($total_doctor_profit, 2) }}
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>




                                @endif
                            </div>
                        </div>

                        {{-- <footer>
                            <span>Prepared By: {{ @$userInfo->user_fullname }}</span>
                            <span>Printing Date & Time: {{ date('d/m/Y') }}</span>
                            <span>Powered By: NEXTGEN IT</span>
                        </footer> --}}

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    window.print();
    window.onafterprint = function() {
        window.close();
    }
</script>
