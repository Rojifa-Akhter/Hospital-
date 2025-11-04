@php
    $company_details = \App\Models\Company::where('status', 1)->first();
    $imageURL = isset($company_details->logo)
        ? '/images/uploads/hospital_images/' . $company_details->logo
        : 'images/login_page_logo.png';
    $backgroundColor = isset($company_details->logo_background_color)
        ? $company_details->logo_background_color
        : 'white';
    $width = isset($company_details->width_logo) ? $company_details->width_logo : '100px';
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Referral Doctor Details Item Wise</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KyZXEJXx3b0Qe6g5E5OqFbo5WkVJffxjz5g7zZkFv5zY+g6yt9Zn1v8HcOkq8zV4" crossorigin="anonymous">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            padding: 30px;
            background-color: #f9f9f9;
            color: #333;
        }

        h1 {
            font-size: 2.5rem;
            font-weight: 600;
            margin-bottom: 20px;
            color: #333;
        }

        h3 {
            font-size: 1.75rem;
            font-weight: 500;
            color: #444;
        }

        header {
            margin-bottom: 30px;
        }

        .logo-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo-container img {
            max-width: 150px;
            height: auto;
        }

        .hospital-info {
            text-align: center;
        }

        .hospital-info h3 {
            margin: 0;
            font-size: 1.8rem;
            font-weight: 600;
        }

        .hospital-info div {
            font-size: 1.1rem;
            color: #666;
        }

        .table-responsive {
            margin-top: 30px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        table,
        th,
        td {
            border: 1px solid #dee2e6;
        }

        th,
        td {
            padding: 12px 20px;
            text-align: center;
        }

        tr {
            border-bottom: 1px solid #dee2e6;
        }

        .thead-dark {
            background-color: #343a40;
            color: white;
        }

        .table-striped tbody tr:nth-child(odd) {
            background-color: #f2f2f2;
        }

        .highlight-green {
            color: #28a745;
            font-weight: bold;
        }

        .highlight-blue {
            color: #007bff;
            font-weight: bold;
        }

        .highlight-yellow {
            color: #ffc107;
            font-weight: bold;
        }

        .highlight-red {
            color: #dc3545;
            font-weight: bold;
        }

        .highlight-gray {
            color: #6c757d;
        }

        .no-data-message {
            font-size: 1.2rem;
            color: #ff5722;
            margin-top: 20px;
        }

        @media (max-width: 768px) {
            .logo-container {
                flex-direction: column;
                align-items: center;
            }

            .hospital-info h3 {
                font-size: 1.5rem;
            }
        }

        .table td,
        .table th {
            text-align: center;
        }

        .branch-title {
            font-size: 1.25rem;
            font-weight: bold;
            background-color: #e2e3e5;
            padding: 10px 0;
            color: #333;
        }

        .sub-branch-title {
            font-size: 1.1rem;
            font-weight: bold;
            background-color: #d6d8db;
            padding: 8px 0;
            color: #333;
        }

        .total-row {
            font-weight: bold;
            background-color: #f8f9fa;
        }
    </style>
</head>

<body>
    {{-- {{ dd($ledgerPages) }} --}}
    @foreach ($ledgerPages as $i => $page)
        {{-- {{ dd($page) }} --}}
        {{-- {{ dd($serial,$page['person_no_pk']) }} --}}
        <div style="page-break-before: always;"></div>
        <div
            style="border: 2px solid #4CAF50; padding: 10px; border-radius: 8px; background-color: #f9f9f9; max-width: 90px; margin:left;">
            <strong style="font-size: 50px; color: #333;">
                @foreach ($serial as $record)
                    @if ($page['person_no_pk'] == $record->referral_id)
                        {{ $record->serial }}
                    @endif
                @endforeach
            </strong>
        </div>


        <div class="page">
            <h4>Employee: {{ $page['employee_name'] }} ({{ $page['employee_code'] }})</h4>


            <h3 style="text-align: left;">Invoice Wise Collection Summary - {{ $page['employee_name'] }}</h3>
            <p>Sub: <span>Investigation Statement from (From <?php echo str_replace('-', '/', $from); ?> To <?php echo str_replace('-', '/', $to); ?>)
                    [{{ $page['branch_name'] }}]</span></p>
            <span>
                <strong>Dear Sir / Madam,</strong><br>
                Most Respectfully to state that, Your referral patient statement and profit details are given below
                month of
                <?php echo date('F', strtotime($from)); ?> <br>
                Hope You will accept your share of profit gladly.
            </span>

            {{-- Initialize employee-wise grand total and sum variables --}}
            @php
                $employeeGrandTotal = 0;
                $employeeTotalBill = 0;
                $employeeTotalDiscount = 0;
                $employeeTotalNetBill = 0;
                $totalRecords = 0;
            @endphp
            @foreach ($page['items'] as $itemName => $itemDetails)
                <h4>Item: {{ $itemName }}</h4>
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Invoice Date</th>
                            <th>Invoice ID</th>
                            <th>Patient Name</th>
                            <th>Total Bill Amount</th>
                            <th>Discount Amount</th>
                            <th>Net Bill Amount</th>
                            <th>Profit(%)</th>
                            <th>Total Profit</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Initialize item-wise sum variables --}}
                        @php
                            $itemTotalBill = 0;
                            $itemTotalDiscount = 0;
                            $itemTotalNetBill = 0;
                            $itemTotalProfit = 0;
                        @endphp

                        @foreach ($itemDetails as $detail)
                            @php
                                // Initialize default values for calculations
                                $totalBillAmount = 0;
                                $netBillAmount = (float) $detail['invoicedtl_amt_payment'];
                                $discountAmount = $detail['invoicedtl_amt_discount'];

                                // Check if item_rate and item_qty are valid (not zero)
                                if ($detail['item_rate'] > 0 && $detail['item_qty'] > 0) {
                                    // Calculate totalBillAmount only if item_rate and item_qty are valid
                                    $totalBillAmount = (float) ($detail['item_rate'] * $detail['item_qty']);

                                    $profit = ($totalBillAmount * $detail['max_disc_pct']) / 100;
                                    $totalProfit = $profit - $detail['disc_amt_by_doc'];

                                    // Avoid division by zero if totalBillAmount is zero
                                    if ($totalBillAmount > 0) {
                                        $doctor_discount_percent =
                                            ($detail['disc_amt_by_doc'] * 100) / $totalBillAmount;
                                    } else {
                                        $doctor_discount_percent = 0;
                                    }

                                    // Calculate profit_percent if totalProfit is non-zero
                                    $profit_percent = 0;
                                    if ($totalProfit != 0) {
                                        $profit_percent = $detail['max_disc_pct'] - $doctor_discount_percent;
                                    }
                                } else {
                                    // Set defaults if item_rate or item_qty is zero
                                    $totalBillAmount = 0;
                                    $profit = 0;
                                    $totalProfit = 0;
                                    $doctor_discount_percent = 0;
                                    $profit_percent = 0;
                                }

                                $checkDue = $detail['invoicemst_amt_sales'] - $detail['invoicemst_amt_discount'];

                                // Add the sums to the item totals
                                $itemTotalBill += $totalBillAmount;
                                $itemTotalDiscount += $discountAmount;
                                $itemTotalNetBill += $netBillAmount;
                                // $itemTotalProfit += $totalProfit;

                                // Add the sums to the employee grand total
                                $employeeTotalBill += $totalBillAmount;
                                $employeeTotalDiscount += $discountAmount;
                                $employeeTotalNetBill += $netBillAmount;

                                // Calculate employeeGrandTotal considering payment mismatch
                                if ($detail['due_ind'] == 1) {
                                    // If the checkDue and payment mismatch, keep the grand total as is
                                    $employeeGrandTotal = $employeeGrandTotal;
                                } else {
                                    // Otherwise, add totalProfit to employeeGrandTotal
                                    $employeeGrandTotal += $totalProfit;
                                }

                                if ($detail['due_ind'] == 1) {
                                    $itemTotalProfit += 0;
                                } else {
                                    $itemTotalProfit += $totalProfit;
                                }
                            @endphp

                            <tr>
                                <td>{{ \Carbon\Carbon::parse($detail['invoice_date'])->format('d/m/Y H:i:s') }}</td>
                                <td>{{ $detail['invoice_code'] }}</td>
                                <td>{{ $detail['customer_name'] }}</td>
                                <td>{{ number_format($totalBillAmount, 2) }}</td>
                                <td>{{ number_format($discountAmount, 2) }}</td>
                                <td>{{ number_format($netBillAmount, 2) }}</td>
                                <td>{{ number_format($profit_percent, 2) }}%</td>
                                <td>
                                    @if ($detail['due_ind'] == 1)
                                        <span class='badge badge-outline-danger '>DUE</span>
                                    @else
                                        {{ number_format($totalProfit, 2) }}
                                    @endif
                                </td>
                            </tr>
                        @endforeach

                        {{-- Display item-wise total sums --}}
                        <tr>
                            <td colspan="3" style="text-align: right;"><strong>Item Total:</strong></td>
                            <td><strong>{{ number_format($itemTotalBill, 2) }}</strong></td>
                            <td><strong>{{ number_format($itemTotalDiscount, 2) }}</strong></td>
                            <td><strong>{{ number_format($itemTotalNetBill, 2) }}</strong></td>
                            <td></td>
                            <td><strong>{{ number_format($itemTotalProfit, 2) }}</strong></td>
                        </tr>
                    </tbody>
                </table>
            @endforeach
            <table>
                <tbody>
                    <!-- Summing up the totals -->
                    <tr>
                        <td colspan="3" style="text-align: right;"><strong>Total:</strong></td>
                        <td>{{ number_format($employeeTotalBill, 2) }}</td>
                        <td>{{ number_format($employeeTotalDiscount, 2) }}</td>
                        <td>{{ number_format($employeeTotalNetBill, 2) }}</td>
                        <td></td> <!-- Average profit percentage -->
                        <td>{{ number_format($employeeGrandTotal, 2) }}</td>
                    </tr>
                    <tr>
                        <td>({{ $invoiceCount }}) Invoices</td>
                        <td>({{ $totalRecords }}) Records</td>
                        <td style="text-align: right;"><strong>Grand Total:</strong></td>
                        <td>{{ number_format($employeeTotalBill, 2) }}</td>
                        <td>{{ number_format($employeeTotalDiscount, 2) }}</td>
                        <td>{{ number_format($employeeTotalNetBill, 2) }}</td>
                        <td></td>
                        <td>{{ number_format($employeeGrandTotal, 2) }}</td>
                    </tr>


                    <tr>
                        @php
                            $locale = 'en_US';
                            $fmt = numfmt_create($locale, NumberFormatter::SPELLOUT);
                            $in_words = numfmt_format($fmt, $employeeGrandTotal);
                        @endphp
                        <td colspan="8" style="text-align: right;">Total Profit in Words: <strong>
                                {{ $in_words }}</strong></td>
                    </tr>
                    <tr>
                        <td colspan="8" style="text-align: left;">
                            Thanking You,
                        </td>
                    </tr>

                    <!-- Authorize Signature Section -->
                    <tr>
                        <td colspan="8" style="text-align: left; padding-top: 50px;">
                            <div
                                style="border-top: 1px solid #000; width: 300px; text-align: center; padding-top: 5px;">
                                Authorized Signature
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>





        </div>
    @endforeach



</body>

</html>

<script>
    window.print();
</script>
