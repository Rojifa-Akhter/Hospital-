<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Cashier Receipt Summary</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            font-size: 11px;
            color: #333;
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

        .section-title {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 6px;
            border-bottom: 1px solid #ccc;
            padding-bottom: 3px;
            color: #034636;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        thead {
            background-color: #f0f0f0;
        }

        th, td {
            border:  1px dotted #464545;
            padding: 6px 4px;
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

        .column-sl { width: 5%; }
        .column-date { width: 15%; }
        .column-code { width: 10%; }
        .column-cashier { width: 25%; }
        .column-cash, .column-card, .column-cheque, .column-total {
            width: 11.25%;
        }
    </style>
</head>

<body>

    <header>
       
        <div class="hospital-title"> {{ $po_hospital_details->hospital_name ?? 'Hospital Name' }}</div>
        <div>Consultant Daily Charge Listing</div>
        <div style="font-size: 10px;">Receipt Date: {{ $fromDate }} To {{ $toDate }} </div>
        <div style="font-size: 10px;">Report Date: {{ date('d-m-Y') }}</div>
        <div style="font-size: 10px; padding-bottom:1px;"><strong>Consultant :</strong> {{ $doctorLedgers[0]->doc_code ?? 'N/A' }} - {{ $doctorLedgers[0]->doc_name ?? 'N/A' }}  </div>
    </header>

    <div class="col-md-12">
        <h4 class="mb-3" style="border-bottom: 1px dotted rgb(179, 176, 176); padding-bottom: 5px;">
            Consultant Daily Charge Listing
        </h4>
        <table class="table table-striped table-bordered table-hover data-table">
            <thead class="thead-success">
                <tr>
                    <th class="text-center">SL</th>
                    {{-- <th class="text-center">Trans Date</th> --}}
                    <th class="text-center">Bill DATE</th>
                    <th class="text-center">Bill No</th>
                    <th class="text-center">MRN</th>
                    <th class="text-left">Patient Name</th>
                    {{-- <th class="text-left">Doctor Code</th>
                    <th class="text-left">Doctor Name</th> --}}
                    <th class="text-center">Episode Type</th>
                    {{-- <th class="text-left">Status</th> --}}
                    <th class="text-right">Cons Charge</th>
                    {{-- <th class="text-right">Discount</th>
                    <th class="text-right">Payable</th>
                    <th class="text-right">Payment</th>
                    <th class="text-right">Due</th> --}}
                </tr>
            </thead>
            <tbody id="doctorLedgerTable">
                @php
                    $totalSales = 0;
                    $totalDiscount = 0;
                    $totalPayable = 0;
                    $totalPayment = 0;
                    $totalDue = 0;
                @endphp
                @foreach ($doctorLedgers as $data)
                    @php
                        $totalSales += $data->ledger_amt_sales;
                        // $totalDiscount += $data->ledger_amt_discount;
                        // $totalPayable += $data->payable;
                        // $totalPayment += $data->ledger_amt_payment;
                        // $totalDue += $data->due;
                    @endphp
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        {{-- <td class="text-center">{{ $data->ledger_date }}</td> --}}
                        <td class="text-center">{{ $data->invoice_date }}</td>
                        <td class="text-center">{{ $data->invoice_no_pk }}</td>
                        <td class="text-center">{{ $data->patient_code }}</td>
                        <td class="text-left">{{ $data->patient_name }}</td>
                        {{-- <td class="text-left">{{ $data->doc_code }}</td>
                        <td class="text-left">{{ $data->doc_name }}</td> --}}
                        <td class="text-center">{{ $data->cons_type }}</td>
                        {{-- <td class="text-left"> {!! $data->due > 0 ? '<span class="text-danger">Due</span>' : '<span class="text-success">Paid</span>' !!} </td> --}}
                        <td class="text-right">{{ number_format($data->ledger_amt_sales, 2) }}</td>
                        {{-- <td class="text-right">{{ number_format($data->ledger_amt_discount, 2) }}</td> --}}
                        {{-- <td class="text-right">{{ number_format($data->payable, 2) }}</td> --}}
                        {{-- <td class="text-right">{{ number_format($data->ledger_amt_payment, 2) }}</td> --}}
                        {{-- <td class="text-right">{{ number_format($data->due, 2) }}</td> --}}
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="font-weight-bold bg-light">
                    <td colspan="6" class="text-right">Grand Total</td>
                    <td class="text-right">{{ number_format($totalSales, 2) }}</td>
                    {{-- <td class="text-right">{{ number_format($totalDiscount, 2) }}</td> --}}
                    {{-- <td class="text-right">{{ number_format($totalPayable, 2) }}</td> --}}
                    {{-- <td class="text-right">{{ number_format($totalPayment, 2) }}</td> --}}
                    {{-- <td class="text-right">{{ number_format($totalDue, 2) }}</td> --}}
                </tr>
            </tfoot>
        </table>
    </div>
    {{-- Signature Section --}}
{{-- <div style="margin-top: 50px; width: 100%; font-family: Arial, sans-serif; font-size: 12px;">
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
</div> --}}
</body>
</html>
<script>

</script>
