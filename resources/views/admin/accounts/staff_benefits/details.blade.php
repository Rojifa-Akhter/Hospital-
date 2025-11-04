<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>H360 - Invoice</title>
    <style>
        body {
            font-family: "Roboto", Arial, sans-serif;
            font-size: 14px;
            margin: 30px;
            background-color: #fff;
            color: #000;
        }

        .invoice-box {
            max-width: 850px;
            margin: auto;
            padding: 25px 30px;
            background: #fff;
            border-radius: 8px;
            border: 1px solid #000;
        }

        .header {
            text-align: center;
            border-bottom: 1px solid #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .header h2 {
            margin: 0;
            font-size: 22px;
            font-weight: bold;
        }

        .info p {
            margin: 4px 0;
            line-height: 1.4;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 13px;
        }

        table th,
        table td {
            padding: 8px;
            border: 1px solid #000;
        }

        table thead {
            background-color: #f5f5f5;
        }

        table tbody tr:nth-child(even) {
            background-color: #fafafa;
        }

        .right {
            text-align: right;
        }

        .center {
            text-align: center;
        }

        .total-box {
            margin-top: 20px;
            text-align: right;
            font-size: 16px;
            font-weight: bold;
            background: #f9f9f9;
            padding: 10px;
            /* border: 1px solid #000; */
            border-radius: 6px;
        }

        .footer {
            text-align: center;
            font-size: 12px;
            color: #444;
            margin-top: 25px;
            border-top: 1px dashed #000;
            padding-top: 10px;
        }

        /* Print Button Style */
        #printBtn {
            background-color: #000;
            color: white;
            border: none;
            padding: 10px 22px;
            font-size: 14px;
            border-radius: 4px;
            cursor: pointer;
        }

        #printBtn:hover {
            background-color: #444;
        }

        @media print {
            #printBtn {
                display: none;
            }

            body {
                background: #fff;
            }

            .invoice-box {
                border: none;
            }
        }
    </style>
</head>

<body>
    <!-- Print Button -->
    <div style="text-align: right; margin-bottom: 20px;">
        <button id="printBtn" onclick="printInvoice()">🖨️ Print Invoice</button>
    </div>

    <!-- Invoice Section -->
    <div id="invoice" class="invoice-box">
        <div class="header">
            <h2>Money Receipt</h2>
        </div>

        <div class="info">
            {{-- <p><b>UHID:</b> 20252175</p>
            <p><b>Patient Name:</b> RUNA AKTER</p>
            <p><b>Age:</b> 32Y 5M 28D &nbsp;&nbsp; <b>Sex:</b> Female</p>
            <p><b>Contact:</b> 01949092282</p> --}}
            <div style="display: flex; flex-wrap: wrap; justify-content: space-between">
                <div>
                    <p><b>Debtor Code:</b> {{ $firstData->debtor_code }}</p>
                    <p><b>Debtor Name:</b> {{ $firstData->debtor_name }}</p>
                </div>
                <div>
                    <p><b>Invoice ID:</b> {{ $firstData->ar_invoice_no_pk }}</p>
                    <p><b>Date of Invoice:</b> {{ date('d/m/Y', strtotime($firstData->arstaffledgerdtl_date)) }}</p>
                </div>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>SL#</th>
                    <th>Admission ID</th>
                    <th>Invoice No</th>
                    <th class="right">Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($fincStaffBenefitsDetals as $fincStaffBenefitsDetal)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class="center">{{ $fincStaffBenefitsDetal->admission_no_fk }}</td>
                        <td class="center">{{ $fincStaffBenefitsDetal->invoice_no_fk }}</td>
                        <td class="right">{{ number_format($fincStaffBenefitsDetal->amount, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="total-box">
            Total Sum: {{ number_format($totalAmount, 2) }} Tk Only
        </div>
        <p><b>In Word:</b> {{ ucwords($amountInWords) }} Taka Only</p>
        {{-- <p><b>Cash Receipt In:</b> {{ $firstData->pay_mode == 'CS' ? 'CASH' : $firstData->pay_mode }}</p> --}}
        <p><b>Billed By:</b> {{ $firstData->cashier_name }}
            ({{ date('d/m/Y g:i A', strtotime($firstData->arstaffledgerdtl_date)) }})</p>

        <div class="footer">
            Print: <span id="printDate"></span>
        </div>
    </div>

    <script>
        function printInvoice() {
            var printContents = document.getElementById('invoice').innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
        }

        //date and time for print footer
        function formatDateTime(date) {
            const dd = String(date.getDate()).padStart(2, '0');
            const mm = String(date.getMonth() + 1).padStart(2, '0'); // Months start at 0
            const yyyy = date.getFullYear();

            let hours = date.getHours();
            const minutes = String(date.getMinutes()).padStart(2, '0');
            const ampm = hours >= 12 ? 'pm' : 'am';
            hours = hours % 12 || 12;

            return `${dd}-${mm}-${yyyy} / ${hours}:${minutes} ${ampm}`;
        }

        document.getElementById('printDate').innerText = formatDateTime(new Date());

        function printInvoice() {
            document.getElementById('printDate').innerText = formatDateTime(new Date());
            var printContents = document.getElementById('invoice').innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
        }
    </script>
</body>

</html>
