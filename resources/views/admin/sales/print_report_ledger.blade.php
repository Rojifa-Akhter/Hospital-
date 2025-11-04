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
            margin: 0;
            padding: 20px;
            background-color: #f8f9fa;
            color: #333;
        }

        h1,
        h4 {
            font-weight: bold;
            color: #333;
        }

        h1 {
            font-size: 2rem;
        }

        h4 {
            font-size: 1.25rem;
        }

        .logo-container {
            text-align: center;
            margin-bottom: 30px;
        }

        .logo-container img {
            max-width: 150px;
            height: auto;
        }

        .hospital-info {
            text-align: center;
            margin-bottom: 40px;
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

        .page-break {
            page-break-before: always;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            padding: 12px 15px;
            text-align: center;
            border: 1px solid #ddd;
        }

        th {
            background-color: #007bff;
            color: white;
        }

        tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .highlight-green {
            color: #28a745;
            font-weight: bold;
        }

        .highlight-red {
            color: #dc3545;
            font-weight: bold;
        }

        .footer-total {
            margin-top: 20px;
            font-weight: bold;
            text-align: right;
        }

        .footer-total td {
            padding: 10px;
        }

        .footer-total td strong {
            font-size: 1.2rem;
        }

        .no-data-message {
            font-size: 1.2rem;
            color: #ff5722;
            margin-top: 20px;
        }

        @media (max-width: 768px) {

            th,
            td {
                padding: 8px 10px;
                font-size: 0.9rem;
            }
        }
    </style>
</head>

<body>
    {{-- Loop through the ledger pages --}}
    @foreach ($ledgerPages as $i => $page)
        <div class="page-break"></div>

        <div class="page">
            
            {{-- Agent Header --}}
            <h4>Referral Bill Summary - [Mkt. Staff: {{ $page['employee_code'] }} - {{ $page['employee_name'] }}]</h4>
            <p>From ({{ str_replace('-', '/', $date_from) }} To {{ str_replace('-', '/', $date_to) }})</p>

            {{-- Initialize grand total variables --}}
            @php
                $employeeGrandTotal = 0;
                $total_invoice_final = 0;
                $employeeTotalNetBill = 0;
            @endphp

            {{-- Display Referral Data Table --}}
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>SL#</th>
                        <th>Referral ID</th>
                        <th>Referral Name</th>
                        <th>Branch Name</th>
                        <th>Invoice Qty</th>
                        <th>Sales Amt.</th>
                        <th>Net Profit</th>
                        <th>Remarks</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Iterate through items for this page --}}
                    @foreach ($page['items'] as $row)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $row['referral_id'] ?? '' }}</td>
                            <td>{{ $row['referral_name'] ?? '' }}</td>
                            <td>{{ $row['branch_name'] ?? '' }}</td>
                            <td>{{ number_format($row['total_invoice_qty'], 0) }}</td>
                            <td>{{ number_format($row['total_sales'], 2) }}</td>

                            @php
                                $payable_profit = $row['total_doctor_profit'] - $row['total_doctor_discount'];
                            @endphp
                            <td>{{ number_format($payable_profit, 2) }}</td>
                            <td></td>
                        </tr>

                        {{-- Accumulate totals --}}
                        @php
                            $employeeGrandTotal += $row['total_sales'];
                            $total_invoice_final += $row['total_invoice_qty'];
                            $employeeTotalNetBill += $payable_profit;
                        @endphp
                    @endforeach
                </tbody>
                <tfoot class="footer-total">
                    <tr>
                        <td colspan="4"><strong>Total:</strong></td>

                        <td><strong>{{ $total_invoice_final }}</strong></td>
                        <td><strong>{{ number_format($employeeGrandTotal, 2) }}</strong></td>
                        <td><strong>{{ number_format($employeeTotalNetBill, 2) }}</strong></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    @endforeach

    <script>
        window.print();
    </script>
</body>

</html>
