<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Doctor Payment Ledger</title>
    <style>
        body {
            font-family: 'Courier New', Courier, monospace;
            font-size: 11px;
            color: #000;
        }

        header {
            text-align: center;
            border-bottom: 1px solid #999;
            padding-bottom: 8px;
            margin-bottom: 20px;
        }

        .hospital-title {
            font-size: 18px;
            font-weight: bold;
            color: #000;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        thead {
            background-color: #f0f0f0;
        }

        th,
        td {
            border: 1px dotted #5e5d5d;
            padding: 6px 4px;
            color: #000;
        }

        th {
            text-align: center;
            font-weight: bold;
            font-size: 11px;
        }

        td.text-right {
            text-align: right;
        }

        td.text-center {
            text-align: center;
        }

        td.text-left {
            text-align: left;
        }

        tfoot td {
            font-weight: bold;
            background-color: #f9f9f9;
        }
    </style>
</head>

<body>

    <header>
        <div class="hospital-title">{{ $po_hospital_details->hospital_name ?? 'Hospital Name' }}</div>
        <div>Consultant Daily Charge Listing</div>
        <div style="font-size: 10px; padding-bottom:1px;">
            <strong>Transaction Date:</strong> {{ $form_date }} To {{ $to_date }}
        </div>
        <div style="font-size: 10px; padding-bottom:5px;">
            <strong>Report Date:</strong> {{ date('d-m-Y') }}
        </div>
        <div style="font-size: 10px; padding-bottom:1px;">
            <strong>Consultant :</strong>
            {{ $doctorLedgers[0]->doc_code ?? 'N/A' }} - {{ $doctorLedgers[0]->doc_name ?? 'N/A' }}
        </div>
    </header>

    <div class="col-md-12">
        <table class="table table-striped table-bordered table-hover data-table">
            <thead class="thead-success">
                <tr>
                    <th class="text-center">SL</th>
                    <th class="text-center">Bill DATE</th>
                    <th class="text-center">Bill No</th>
                    <th class="text-center">MRN</th>
                    <th class="text-left">Patient Name</th>
                    <th class="text-center">Episode Type</th>
                    <th class="text-center">Doctor Payment</th>
                    <th class="text-right">Charge</th>
                    <th class="text-right">Doctor Amount</th>
                </tr>
            </thead>
            <tbody id="doctorLedgerTable">
                @php
                    $totalSales = 0;
                    $totalDoctorAmt = 0;
                @endphp
                @foreach ($doctorLedgers as $data)
                    @php
                        $totalSales += $data->ledger_amt_sales;
                        $doctorAmt = $data->doc_amt;
                        $totalDoctorAmt += $doctorAmt;

                    @endphp
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td class="text-center">{{ \Carbon\Carbon::parse($data->invoice_date)->format('d-m-Y') }}</td>
                        <td class="text-center">{{ $data->invoice_no_pk }}</td>
                        <td class="text-center">{{ $data->patient_code }}</td>
                        <td class="text-left">{{ $data->patient_name }}</td>
                        <td class="text-center">{{ $data->cons_type }}</td>
                        <td class="text-center">{{ $data->doc_payment_ind ? "Done" : "Not Done" }}</td>
                        <td class="text-right">{{ number_format($data->ledger_amt_sales, 2) }}</td>
                        <td class="text-right">{{ number_format($doctorAmt, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="font-weight-bold bg-light">
                    <td colspan="7" class="text-right">Grand Total</td>
                    <td class="text-right">{{ number_format($totalSales, 2) }}</td>
                    <td class="text-right">{{ number_format($totalDoctorAmt, 2) }}</td>
                </tr>
            </tfoot>
        </table>
    </div>

    <div style="margin-top: 10px; width: 100%;">
        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <td style="width: 50%; padding: 10px;">
                    <div><strong>Checked By :</strong></div>
                    <div style="margin-top: 30px;">________________________</div>
                    <div style="margin-top: 5px;">(SIGNATURE)</div>
                </td>
                <td style="width: 50%; padding: 10px;">
                    <div>&nbsp;</div>
                    <div style="margin-top: 30px;">______________________________</div>
                    <div style="margin-top: 5px;">(NAME)</div>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; padding: 10px;">
                    <div><strong>Verified By :</strong></div>
                    <div style="margin-top: 30px;">________________________</div>
                    <div style="margin-top: 5px;">(SIGNATURE)</div>
                </td>
                <td style="width: 50%; padding: 10px;">
                    <div>&nbsp;</div>
                    <div style="margin-top: 30px;">______________________________</div>
                    <div style="margin-top: 5px;">(NAME)</div>
                </td>
            </tr>
        </table>
    </div>

</body>

</html>
