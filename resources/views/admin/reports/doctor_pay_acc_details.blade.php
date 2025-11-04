<!DOCTYPE html>
<html>
<head>
    <title>Doctor Payment Details</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- Paged.js for pagination in print (works in Chrome) -->
    <script src="https://unpkg.com/pagedjs/dist/paged.polyfill.js"></script>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        header {
            position: running(header);
            text-align: center;
            margin-bottom: 10px;
        }

        header h1 {
            margin: 5px 0;
            font-size: 20px;
        }

        header div {
            font-size: 14px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            font-size: 13px;
        }

        th, td {
            border: 1px solid #333;
            padding: 6px;
            text-align: left;
            word-wrap: break-word;
        }

        th {
            background-color: #f0f0f0;
        }

        /* Column widths */
        th:nth-child(1), td:nth-child(1) { width: 15%; }
        th:nth-child(2), td:nth-child(1) { width: 12%; }
        th:nth-child(3), td:nth-child(2) { width: 15%; }
        th:nth-child(4), td:nth-child(3) { width: 15%; }
        th:nth-child(5), td:nth-child(4) { width: 15%; }
        th:nth-child(6), td:nth-child(5) { width: 14%; text-align: right; }
        th:nth-child(7), td:nth-child(6) { width: 14%; text-align: right; }

        .grand-total {
            font-weight: bold;
            font-size: 15px;
            margin-top: 20px;
            text-align: right;
            border-top: 2px solid #333;
            padding-top: 10px;
        }

        /* Print styles */
        @page {
            margin: 100px 30px 60px 30px;

            @top-center {
                content: element(header);
            }

            @bottom-center {
                content: "Page " counter(page) " of " counter(pages);
                font-size: 12px;
            }
        }

        @media print {
            .no-print {
                display: none;
            }
        }

        .no-print {
            margin: 20px;
        }
    </style>
</head>

<body>

    {{-- Paged.js running header --}}
    <header>
        <h1><strong>{{ $po_hospital_details->hospital_name ?? 'Hospital Name' }}</strong></h1>
        <h1>Doctor Payment Details</h1>
        <div>
            Doctor Code: <strong>{{ $results[0]->doc_code ?? '' }}</strong> &nbsp;&nbsp;|&nbsp;&nbsp;
            Doctor Name: <strong>{{ $results[0]->doc_name ?? '' }}</strong>
        </div>
    </header>

    @if(count($results) > 0)
        @php
            $total_sales = 0;
            $total_doctor_amt = 0;
        @endphp

        <table>
            <thead>
                <tr>
                    <th>Pay Proc Date</th>
                    <th>Bill No</th>
                    <th>Payment Date</th>
                    <th>Voucher No</th>
                    <th>Cons Type</th>
                    <th>Sales Amount</th>
                    <th>Doctor Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach($results as $row)
                    <tr>
                        <td>{{ $row->payment_process_date }}</td>
                        <td>{{ $row->invoice_no_fk }}</td>
                        <td>{{ $row->payment_date }}</td>
                        <td>{{ $row->voucher_no }}</td>
                        <td>{{ $row->cons_type }}</td>
                        <td>{{ number_format($row->ledgerdtl_amt_sales, 2) }}</td>
                        <td>{{ number_format($row->doc_amt_item, 2) }}</td>
                    </tr>
                    @php
                        $total_sales += $row->ledgerdtl_amt_sales;
                        $total_doctor_amt += $row->doc_amt_item;
                    @endphp
                @endforeach
            </tbody>
        </table>

        <div class="grand-total">
            Grand Total:&nbsp;&nbsp;
            Sales Amount: {{ number_format($total_sales, 2) }} &nbsp;&nbsp; | &nbsp;&nbsp;
            Doctor Amount: {{ number_format($total_doctor_amt, 2) }}
        </div>
    @else
        <p>No payment details found.</p>
    @endif

    <div class="no-print">
        <button onclick="window.print()">Print</button>
        <a href="{{ url()->previous() }}">Back</a>
    </div>

</body>
</html>
