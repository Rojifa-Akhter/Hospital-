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
        <div class="col-md-9">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-2">
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
                                    @if ($reptype == 'MO')
                                        Medical Officer Performance Report
                                    @else
                                        Doctor Performance Report
                                    @endif


                                </h2>
                                <p>From: {{ $date_from }} - To: {{ $date_to }}</p>
                            </div>

                            <div>
                                @if ($reptype == 'MO')
                                    <table id="report_table" class="table table-bordered table-striped table-hover">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>SL#</th>
                                                <th>Marketing Officer ID</th>
                                                <th>Officer Name and Designation</th>
                                                <th>Invoice qty</th>
                                                <th>Test qty</th>
                                                <th>Total Sales</th>
                                                <th>Payment</th>
                                                <th>Discount</th>
                                                <th>Net Sales</th>
                                                <th>Due</th>
                                                <th>Remarks</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (!empty($reportData))
                                                @php
                                                    $totalInvoice = 0;
                                                    $totalTest = 0;
                                                    $totalSales = 0;
                                                    $totalPayment = 0;
                                                    $totalDiscount = 0;
                                                    $totalNetSales = 0;
                                                    $totalDue = 0;
                                                @endphp
                                                @foreach ($reportData as $data)
                                                    <tr>
                                                        <td class="text-center">{{ $loop->iteration }}</td>
                                                        <td>{{ $data->mkt_officer_id ?? 'N/A' }}</td>
                                                        <td>{{ $data->mkt_officer_name_desig ?? 'N/A' }}</td>
                                                        <td>{{ $data->invoice_qty ?? '0' }}</td>
                                                        <td>{{ $data->test_qty ?? '0' }}</td>
                                                        <td class="text-right">
                                                            {{ number_format((float) ($data->total_sales ?? 0), 2) }}
                                                        </td>
                                                        <td class="text-right">
                                                            {{ number_format((float) ($data->payment ?? 0), 2) }}</td>
                                                        <!-- Fixed 'payemnt' typo -->
                                                        <td class="text-right">
                                                            {{ number_format((float) ($data->discount ?? 0), 2) }}</td>
                                                        <td class="text-right">
                                                            {{ number_format((float) ($data->net_sales ?? 0), 2) }}
                                                        </td>
                                                        <td class="text-right">
                                                            {{ number_format((float) ($data->due ?? 0), 2) }}</td>
                                                        <td>{{ $data->remarks ?? 'No issues' }}</td>
                                                    </tr>

                                                    @php
                                                        $totalInvoice += $data->invoice_qty ?? 0;
                                                        $totalTest += $data->test_qty ?? 0;
                                                        $totalSales += $data->total_sales ?? 0;
                                                        $totalPayment += $data->payment ?? 0;
                                                        $totalDiscount += $data->discount ?? 0;
                                                        $totalNetSales += $data->net_sales ?? 0;
                                                        $totalDue += $data->due ?? 0;
                                                    @endphp
                                                @endforeach
                                            @endif
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="3" style="text-align: right">Total</td>
                                                <td>{{ $totalInvoice }}</td>
                                                <td>{{ $totalTest }}</td>
                                                <td class="text-right">{{ number_format((float) $totalSales, 2) }}</td>
                                                <td class="text-right">{{ number_format((float) $totalPayment, 2) }}
                                                </td>
                                                <td class="text-right">{{ number_format((float) $totalDiscount, 2) }}
                                                </td>
                                                <td class="text-right">{{ number_format((float) $totalNetSales, 2) }}
                                                </td>
                                                <td class="text-right">{{ number_format((float) $totalDue, 2) }}</td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                @else
                                    <table id="report_table" class="table table-bordered table-striped table-hover">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>SL#</th>
                                                <th>Referral Name and Address</th>
                                                <th>Officer Name and Designation</th>
                                                <th>Invoice qty</th>
                                                <th>Test qty</th>
                                                <th>Total Sales</th>
                                                <th>Payment</th>
                                                <th>Discount</th>
                                                <th>Net Sales</th>
                                                <th>Due</th>
                                                <th>Remarks</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (!empty($reportData))
                                                @php
                                                    $totalInvoice = 0;
                                                    $totalTest = 0;
                                                    $totalSales = 0;
                                                    $totalPayment = 0;
                                                    $totalDiscount = 0;
                                                    $totalNetSales = 0;
                                                    $totalDue = 0;
                                                @endphp
                                                @foreach ($reportData as $data)
                                                    <tr>
                                                        <td class="text-center">{{ $loop->iteration }}</td>
                                                        <td>{{ $data->referral_name ?? 'N/A' }}-{{ $data->referral_addr ?? 'N/A' }}
                                                        </td>
                                                        <td>{{ $data->mkt_officer_id ?? 'N/A' }}-{{ $data->mkt_officer_name_desig ?? 'N/A' }}
                                                        </td>
                                                        <td>{{ $data->invoice_qty ?? '0' }}</td>
                                                        <td>{{ $data->test_qty ?? '0' }}</td>
                                                        <td class="text-right">
                                                            {{ number_format((float) ($data->total_sales ?? 0), 2) }}
                                                        </td>
                                                        <td class="text-right">
                                                            {{ number_format((float) ($data->payment ?? 0), 2) }}</td>
                                                        <!-- Fixed 'payemnt' typo -->
                                                        <td class="text-right">
                                                            {{ number_format((float) ($data->discount ?? 0), 2) }}</td>
                                                        <td class="text-right">
                                                            {{ number_format((float) ($data->net_sales ?? 0), 2) }}
                                                        </td>
                                                        <td class="text-right">
                                                            {{ number_format((float) ($data->due ?? 0), 2) }}</td>
                                                        <td>{{ $data->remarks ?? 'No issues' }}</td>
                                                    </tr>

                                                    @php
                                                        $totalInvoice += $data->invoice_qty ?? 0;
                                                        $totalTest += $data->test_qty ?? 0;
                                                        $totalSales += $data->total_sales ?? 0;
                                                        $totalPayment += $data->payment ?? 0;
                                                        $totalDiscount += $data->discount ?? 0;
                                                        $totalNetSales += $data->net_sales ?? 0;
                                                        $totalDue += $data->due ?? 0;
                                                    @endphp
                                                @endforeach
                                            @endif
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="3">Total</td>
                                                <td>{{ $totalInvoice }}</td>
                                                <td>{{ $totalTest }}</td>
                                                <td class="text-right">{{ number_format((float) $totalSales, 2) }}</td>
                                                <td class="text-right">{{ number_format((float) $totalPayment, 2) }}
                                                </td>
                                                <td class="text-right">{{ number_format((float) $totalDiscount, 2) }}
                                                </td>
                                                <td class="text-right">{{ number_format((float) $totalNetSales, 2) }}
                                                </td>
                                                <td class="text-right">{{ number_format((float) $totalDue, 2) }}</td>
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
