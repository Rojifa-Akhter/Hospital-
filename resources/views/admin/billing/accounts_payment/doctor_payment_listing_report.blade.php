<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Doctor Payment Listing Report</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            margin: 30px;
            font-size: 13px;
            color: #000;
        }

        h2 {
            text-align: center;
            margin-bottom: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid #000;
        }

        th,
        td {
            padding: 6px 8px;
            text-align: center;
        }

        .button-container {
            margin-bottom: 15px;
            text-align: right;
        }

        .btn {
            display: inline-block;
            padding: 6px 14px;
            margin-left: 8px;
            font-size: 13px;
            font-weight: bold;
            border: 1px solid #000;
            background: #f9f9f9;
            color: #000;
            cursor: pointer;
            border-radius: 4px;
            transition: background 0.2s ease-in-out;
        }

        .btn:hover {
            background: #e6e6e6;
        }

        .btn-print {
            border-color: green;
            color: green;
        }

        .btn-back {
            text-decoration: none;
            border-color: blue;
            color: blue;
        }

        .no-data {
            text-align: center;
            font-style: italic;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .summary-table {
            width: auto;
            margin: 30px 0 30px auto;
            border-collapse: collapse;
        }

        .summary-table td {
            padding: 10px 20px;
            font-weight: bold;
            font-size: 14px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #000;
            padding-bottom: 15px;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: bold;
        }

        .header p {
            margin: 5px 0;
            font-size: 13px;
        }

        .summary-label {
            text-align: right;
            background-color: #f0f0f0;
        }

        .summary-value {
            text-align: right;
            background-color: #fff;
        }

        .total-row {
            background-color: #e8f4f8 !important;
        }

        .signature {
            margin-top: 40px;
        }

        .signature p {
            display: inline-block;
            border-top: 1px solid #000;
            padding-top: 5px;
        }

        .footer {
            margin-top: 20px;
            font-size: 12px;
            width: 100%;
        }

        .footer-left {
            float: left;
        }

        .footer-right {
            float: right;
        }

        /* Clear floats */
        .clearfix::after {
            content: "";
            display: table;
            clear: both;
        }

        /* Hide buttons in print */
        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body>
    <!-- Buttons -->
    <div class="no-print button-container">
        <button class="btn btn-print" onclick="window.print()">🖨️ Print</button>
        <a href="{{ route('accounts.payment.list') }}" class="btn btn-back">⬅️ Back</a>
    </div>

    <!-- Header -->
    <div class="header">
        <h1>KPJ SPECIALIZED HOSPITAL & NURSING COLLEGE</h1>
        <p>C/12, Tetuibari, Kasimpur Gazipur (Near DEPZ) , Bangladesh</p>
        <p>Phone: 01810-008080. 0244077030. 0244077031. | Email: info@sfmmkpjsh.com</p>
        <p><strong>Doctor Payment Listing Report</strong></p>
    </div>

    <!-- Title -->
    <h2>Doctor Payment Listing Report ( {{ date('d/m/Y', strtotime($dateFrom)) }} To {{ date('d/m/Y', strtotime($dateTo)) }} )</h2>

    <!-- Table -->
    <table>
        <thead>
            <tr>
                <tr>
                    <th>SL</th>
                    <th>Doctor Name</th>
                    <th>Journal Code</th>
                    <th>Date</th>
                    <th>Amount</th>
                </tr>
            </tr>
        </thead>
        <tbody>
            @php
                $totalAmount = 0;
            @endphp
            @if (empty($doctorPayments) || count($doctorPayments) == 0)
                <tr>
                    <td colspan="9" class="text-center">Data Not Found</td>
                </tr>
            @else
                @foreach ($doctorPayments as $index => $row)
                    @php
                        $totalAmount += $row->amount ?? 0;
                    @endphp
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $row->subledger_name ?? '' }}</td>
                        <td>{{ $row->journal_code ?? '' }}</td>
                        <td>{{ isset($row->payment_date) && $row->payment_date != null ? date('d/m/Y', strtotime($row->payment_date)) : '' }}</td>
                        <td class="text-right">{{ number_format($row->amount, 2) }}</td>
                    </tr>
                @endforeach
            @endif
            <tr>
                <td colspan="4" style="font-weight: bold">Total Amount</td>
                <td class="text-right" style="font-weight: bold">{{ number_format($totalAmount, 2) }}</td>
            </tr>
        </tbody>
    </table>

    <!-- Signature -->
    <div class="signature">
        <p>Signature</p>
    </div>

    <!-- Footer -->
    <div class="footer clearfix">
        <div class="footer-left">
            Print Date: {{ now()->format('d/m/Y H:i:s') }}
            {{-- Prepared By: {{ $prepared_by ?? 'Super' }},
            Printed By: {{ $printed_by ?? 'ADMIN' }} --}}
        </div>
        <div class="footer-right">
            Powered By - H360 [NextGen Innovation Ltd.]
        </div>
    </div>
</body>

</html>
