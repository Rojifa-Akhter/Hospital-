@php
    $company_details = $lead_unit = \App\Models\Company::where('status', 1)->first();
    $imageURL = isset($company_details->logo)
        ? '/images/uploads/hospital_images/' . $company_details->logo
        : 'images/login_page_logo.png';
    $backgroundColor = isset($company_details->logo_background_color)
        ? $company_details->logo_background_color
        : 'white';
    $width = isset($company_details->width_logo) ? $company_details->width_logo : '100 px';
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

    {{-- <header>
        <div class="logo-container">
             <div class="hospital-info">
                <h3>{{ $company_details->hospital_name }}</h3>
                <div>{{ $company_details->addrress1 }}</div>
                <div>TEL: {{ $company_details->telephone1 }}</div>
            </div>
        </div>
    </header> --}}
{{-- {{ dd($serial,$referral_name->person_no_pk) }} --}}
    <!-- Page Title -->
    {{-- <h3 style="text-align: left;">Invoice Wise Collection Summary - {{ $referral_name->full_name }}</h3> --}}
    <div style="border: 2px solid #4CAF50; padding: 10px; border-radius: 8px; background-color: #f9f9f9; max-width: 90px; margin:left;">
        <strong style="font-size: 50px; color: #333;">
            @foreach ($serial as $record)
                @if ($referral_name->person_no_pk == $record->referral_id)
                    {{ $record->serial }}
                @endif
            @endforeach
        </strong>
    </div>

    <h3 style="text-align: left;">{{ $referral_name->person_code }} - {{ $referral_name->full_name }}</h3>


    <?php // Example date string in d-m-y format
    $formattedDate = DateTime::createFromFormat('d-m-y', $from);
    ?>


    <p>Sub: <span>Investigation Statement from (From <?php echo str_replace('-', '/', $from); ?> To <?php echo str_replace('-', '/', $to); ?>)
            [{{ $branch_name }}]</span></p>
    <span>
        <strong>Dear Sir / Madam,</strong><br>
        Most Respectfully to state that, Your referral patient statement and profit details are given below month of
        <?php echo $formattedDate ? $formattedDate->format('F-Y') : 'Invalid date'; ?> <br>
        Hope You will accept your share of profit gladly.
    </span>
    <!-- Branch-wise Report Table -->
    @if (count($referralData) > 0)

        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead class="thead-dark">
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
                    @php
                        // Initialize the sum variables for all referrals
                        $sumTotalBillAmount = 0;
                        $sumDiscountAmount = 0;
                        $sumNetBillAmount = 0;
                        $sumProfitPercent = 0; // For calculating average profit percent
                        $sumTotalProfit = 0;

                        // Initialize counters
                        $totalInvoiceCount = 0;
                        $totalRecords = 0;
                    @endphp

                    @foreach ($referralData as $itemName => $items)
                        <tr>
                            <td colspan="8" style="text-align: left">
                                <strong>{{ $itemName }}</strong>
                            </td>
                        </tr>

                        @php
                            // Initialize sum variables for the item (per group or per referral)
                            $itemWiseTotalBill = 0;
                            $itemWiseTotalDiscount = 0;
                            $itemWiseTotalNetBill = 0;
                            $itemWiseTotalProfit = 0;
                        @endphp

                        @foreach ($items as $ref)
                            @php
                                // Initialize default values for calculations
                                $totalBillAmount = 0;

                                $discountAmount = $ref->invoicedtl_amt_discount;

                                // Check if item_rate and item_qty are valid (not zero)
                                if ($ref->item_rate > 0 && $ref->item_qty > 0) {
                                    // Calculate totalBillAmount only if item_rate and item_qty are valid
                                    $totalBillAmount = (float) ($ref->item_rate * $ref->item_qty);

                                    $profit = ($totalBillAmount * $ref->max_disc_pct) / 100;
                                    $totalProfit = $profit - $ref->disc_amt_by_doc;

                                    // Avoid division by zero if totalBillAmount is zero
                                    if ($totalBillAmount > 0) {
                                        $doctor_discount_percent = ($ref->disc_amt_by_doc * 100) / $totalBillAmount;
                                    } else {
                                        $doctor_discount_percent = 0;
                                    }

                                    // Calculate profit_percent if totalProfit is non-zero
                                    $profit_percent = 0;
                                    if ($totalProfit != 0) {
                                        $profit_percent = $ref->max_disc_pct - $doctor_discount_percent;
                                    }
                                } else {
                                    // Set defaults if item_rate or item_qty is zero
                                    $totalBillAmount = 0;
                                    $profit = 0;
                                    $totalProfit = 0;
                                    $doctor_discount_percent = 0;
                                    $profit_percent = 0;
                                }
                                $netBillAmount = (float) $totalBillAmount - $discountAmount;
                                // Check due amounts
                                $checkDue = $totalBillAmount - $ref->invoicedtl_amt_discount;

                                // Sum up the values for all referrals
                                $sumTotalBillAmount += $totalBillAmount;
                                $sumDiscountAmount += $discountAmount;
                                $sumNetBillAmount += $netBillAmount;
                                $sumProfitPercent += $profit_percent;

                                // Handle total profit sum based on payment mismatch
                                if ($ref->due_ind == 1) {
                                    $sumTotalProfit = $sumTotalProfit;
                                } else {
                                    $sumTotalProfit += $totalProfit;
                                }

                                // Sum up the values for the current item (group)
                                $itemWiseTotalBill += $totalBillAmount;
                                $itemWiseTotalDiscount += $discountAmount;
                                $itemWiseTotalNetBill += $netBillAmount;

                                if ($ref->due_ind == 1) {
                                    $itemWiseTotalProfit += 0;
                                } else {
                                    $itemWiseTotalProfit += $totalProfit;
                                }

                                // Increment the counters
                                $totalRecords++; // Increment total records for each referral
                            @endphp

                            <tr>
                                <td>{{ \Carbon\Carbon::parse($ref->invoice_date)->format('d/m/Y H:i:s') }}</td>
                                <td>{{ $ref->invoice_code }}</td>
                                <td>{{ $ref->customer_name }}</td>
                                <td>{{ number_format($totalBillAmount, 2) }}</td>
                                <td>{{ number_format($discountAmount, 2) }}</td>
                                <td>{{ number_format($netBillAmount, 2) }}</td>
                                <td>{{ number_format($profit_percent, 2) }}%</td>
                                <td>
                                    @if ($ref->due_ind == 1)
                                        <span class='badge badge-outline-danger '>DUE</span>
                                    @else
                                        {{ number_format($totalProfit, 2) }}
                                    @endif
                                </td>
                            </tr>
                        @endforeach

                        <!-- After each referral/item, display the item-wise total in the next row -->
                        <tr>
                            <td colspan="3" style="text-align: right;"><strong>Item-wise Total:</strong></td>
                            <td>{{ number_format($itemWiseTotalBill, 2) }}</td>
                            <td>{{ number_format($itemWiseTotalDiscount, 2) }}</td>
                            <td>{{ number_format($itemWiseTotalNetBill, 2) }}</td>
                            <td></td> <!-- For profit percentage -->
                            <td>{{ number_format($itemWiseTotalProfit, 2) }}</td>
                        </tr>
                    @endforeach

                    <!-- Summing up the totals -->
                    <tr>
                        <td colspan="3" style="text-align: right;"><strong>Total:</strong></td>
                        <td>{{ number_format($sumTotalBillAmount, 2) }}</td>
                        <td>{{ number_format($sumDiscountAmount, 2) }}</td>
                        <td>{{ number_format($sumNetBillAmount, 2) }}</td>
                        <td></td> <!-- Average profit percentage -->
                        <td>{{ number_format($sumTotalProfit, 2) }}</td>
                    </tr>

                    <!-- Doctor Grand Total -->
                    <tr>
                        <td>({{ $invoiceCount }}) Invoices</td>
                        <td>({{ $totalRecords }}) Records</td>
                        <td style="text-align: right;"><strong>Grand Total:</strong></td>
                        <td>{{ number_format($sumTotalBillAmount, 2) }}</td>
                        <td>{{ number_format($sumDiscountAmount, 2) }}</td>
                        <td>{{ number_format($sumNetBillAmount, 2) }}</td>
                        <td></td>
                        <td>{{ number_format($sumTotalProfit, 2) }}</td>
                    </tr>
                    <tr>
                        @php
                            $locale = 'en_US';
                            $fmt = numfmt_create($locale, NumberFormatter::SPELLOUT);
                            $in_words = numfmt_format($fmt, $sumTotalProfit);
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
    @else
        <div class="no-data-message">
            <strong>No data found for the selected referral.</strong>
        </div>
    @endif




</body>

</html>

<script>
    window.print();
    // window.onafterprint = function() {
    //     window.close();
    // }
</script>
