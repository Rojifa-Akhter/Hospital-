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
    <title>Referral Doctor Details</title>
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
            /* display: flex; */
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

    <header>
        <div class="logo-container">
            <img src="{{ asset('images/uploads/hospital_images/' . $company_details->logo) }}" alt="Logo">
            <div class="hospital-info">
                <h3>{{ $company_details->hospital_name }}</h3>
                <div>{{ $company_details->addrress1 }}</div>
                <div>TEL: {{ $company_details->telephone1 }}</div>
            </div>
        </div>
    </header>

    <!-- Page Title -->
    <h3 style="text-align: center;">Invoice Wise Collection Summary - {{ $referral_name->full_name }}</h3>
    <h3 style="text-align: center;">{{ date('d/m/Y') }}</h3>

    <!-- Branch-wise Report Table -->
    @if (count($referralData) > 0)
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>Invoice ID</th>
                        <th>Invoice Date</th>
                        <th>User Name</th>
                        <th>Patient Name</th>
                        <th>Total Amount</th>
                        <th>Discount Amount</th>
                        {{-- <th>Due</th> --}}
                        <th>New Coll. Amount</th>
                        <th>Net Bill Amount</th>
                        <th>Due Coll. Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        // Initialize grand totals
                        $grandTotalSales = 0;
                        $grandTotalPayment = 0;
                        $grandTotalDiscount = 0;
                        $grandTotalNetBillAmount = 0;
                        $grandTotalDue = 0;
                        $grandTotal_new = 0;
                        $grandTotal_old = 0;
                    @endphp
                    @foreach ($referralData as $branchName => $invoices)
                        @php
                            // Initialize branch-level totals
                            $branchTotalSales = 0;
                            $branchTotalPayment = 0;
                            $branchTotalDiscount = 0;
                            $branchTotalNetBillAmount = 0;
                            $branchTotalDue = 0;
                            $branchTotal_new = 0;
                            $branchTotal_old = 0;
                        @endphp
                        <tr>
                            <td colspan="9" class="text-left font-weight-bold branch-title border-bottom" style="text-align: left">{{ $branchName }}</td>
                        </tr>

                        @foreach ($invoices as $subBranch => $dt)
                            @php
                                // Initialize sub-branch-level totals
                                $subBranchTotalSales = 0;
                                $subBranchTotalPayment = 0;
                                $subBranchTotalDiscount = 0;
                                $subBranchTotalNetBillAmount = 0;
                                $subBranchTotalDue = 0;
                                $subtotal_new = 0;
                                $subtotal_old = 0;
                            @endphp

                            <tr>
                                <td colspan="9" class="text-left font-weight-bold sub-branch-title" style="text-align: left">Terminal: {{ $subBranch }}</td>
                            </tr>

                            @foreach ($dt as $invoice)
                                @php
                                    // Ensure correct addition of amounts
                                    $subBranchTotalSales += (float)$invoice->total_sales;
                                    $subBranchTotalPayment += (float)$invoice->new_collection;
                                    $subBranchTotalDiscount += (float)$invoice->discount;
                                    $subBranchTotalNetBillAmount += (float)$invoice->net_bill_amnt;
                                    $subBranchTotalDue += (float)$invoice->due_collection;

                                    if ($invoice->invoice_trn_number_lm == 0) {
                                        $subtotal_new++;
                                    } else {
                                        $subtotal_old++;
                                    }

                                    // Add sub-branch totals to the branch totals
                                    $branchTotalSales += (float)$invoice->total_sales;
                                    $branchTotalPayment += (float)$invoice->new_collection;
                                    $branchTotalDiscount += (float)$invoice->discount;
                                    $branchTotalNetBillAmount += (float)$invoice->net_bill_amnt;
                                    $branchTotalDue += (float)$invoice->due_collection;

                                    if ($invoice->invoice_trn_number_lm == 0) {
                                        $branchTotal_new++;
                                    } else {
                                        $branchTotal_old++;
                                    }

                                    // Add branch totals to the grand totals
                                    $grandTotalSales += (float)$invoice->total_sales;
                                    $grandTotalPayment += (float)$invoice->new_collection;
                                    $grandTotalDiscount += (float)$invoice->discount;
                                    $grandTotalNetBillAmount += (float)$invoice->net_bill_amnt;
                                    $grandTotalDue += (float)$invoice->due_collection;

                                    if ($invoice->invoice_trn_number_lm == 0) {
                                        $grandTotal_new++;
                                    } else {
                                        $grandTotal_old++;
                                    }

                                @endphp

                                <tr>
                                    <td>{{ $invoice->invoice_no_fk }}</td>
                                    <td>{{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d/m/Y H:i:s') }}</td>
                                    <td>{{ $invoice->user_info }}</td>
                                    <td>{{ $invoice->patient_name }}</td>

                                    <td class="highlight-green">{{ number_format($invoice->total_sales, 2) }}</td>
                                    <td class="highlight-yellow">{{ number_format($invoice->discount, 2) }}</td>
                                    {{-- <td class="highlight-gray">{{ number_format($invoice->due_collection, 2) }}</td> --}}
                                    <td class="highlight-blue">{{ number_format($invoice->new_collection, 2) }}</td>
                                    <td class="highlight-red">{{ number_format($invoice->net_bill_amnt, 2) }}</td>
                                    <td class="highlight-gray">{{ number_format($invoice->due_collection, 2) }}</td>
                                </tr>
                            @endforeach

                            <tr class="total-row">
                                <td colspan="2" class="text-center font-weight-bold highlight-blue">{{ 'New '.$subtotal_new .' + '.'Old '.$subtotal_old }}</td>
                                <td colspan="2" class="text-center font-weight-bold">Sub-Branch Total</td>
                                <td class="font-weight-bold">{{ number_format($subBranchTotalSales, 2) }}</td>
                                <td class="font-weight-bold">{{ number_format($subBranchTotalDiscount, 2) }}</td>
                                {{-- <td class="font-weight-bold">{{ number_format($subBranchTotalDue, 2) }}</td> --}}
                                <td class="font-weight-bold">{{ number_format($subBranchTotalPayment, 2) }}</td>
                                <td class="font-weight-bold">{{ number_format($subBranchTotalNetBillAmount, 2) }}</td>
                                <td class="font-weight-bold">{{ number_format($subBranchTotalDue, 2) }}</td>
                            </tr>
                        @endforeach

                        <tr class="total-row">
                            <td colspan="2" class="text-center font-weight-bold highlight-blue">{{ 'New '.$branchTotal_new .' + '.'Old '.$branchTotal_old }}</td>

                            <td colspan="2" class="text-center font-weight-bold">Branch Total</td>
                            <td class="font-weight-bold">{{ number_format($branchTotalSales, 2) }}</td>
                            <td class="font-weight-bold">{{ number_format($branchTotalDiscount, 2) }}</td>
                            {{-- <td class="font-weight-bold">{{ number_format($branchTotalDue, 2) }}</td> --}}
                            <td class="font-weight-bold">{{ number_format($branchTotalPayment, 2) }}</td>
                            <td class="font-weight-bold">{{ number_format($branchTotalNetBillAmount, 2) }}</td>
                            <td class="font-weight-bold">{{ number_format($branchTotalDue, 2) }}</td>
                        </tr>

                    @endforeach

                    <tr class="total-row">
                        <td colspan="2" class="text-center font-weight-bold highlight-blue">{{ 'New '.$grandTotal_new .' + '.'Old '.$grandTotal_old }}</td>

                        <td colspan="2" class="text-center font-weight-bold">Grand Total</td>
                        <td class="font-weight-bold">{{ number_format($grandTotalSales, 2) }}</td>
                        <td class="font-weight-bold">{{ number_format($grandTotalDiscount, 2) }}</td>
                        {{-- <td class="font-weight-bold">{{ number_format($grandTotalDue, 2) }}</td> --}}
                        <td class="font-weight-bold">{{ number_format($grandTotalPayment, 2) }}</td>
                        <td class="font-weight-bold">{{ number_format($grandTotalNetBillAmount, 2) }}</td>
                        <td class="font-weight-bold">{{ number_format($grandTotalDue, 2) }}</td>
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
