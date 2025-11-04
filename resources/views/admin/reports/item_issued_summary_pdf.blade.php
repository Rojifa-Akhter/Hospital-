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
        <div style="font-size: 12px;">Item Issued Summary Report</div>
        <div style="font-size: 10px;">Report Date: {{ date('d-m-Y') }}</div>
    </header>

    
    <div class="row">
        <div class="container-fluid">
            @foreach ($issuedSummaryGroup as $supplier => $items)
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <strong>Supplier:</strong> {{ $supplier ?? 'N/A' }}
                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm mb-0" style="table-layout: fixed; width: 100%;">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="text-center" style="width: 5%;">SL</th>
                                        <th class="text-center" style="width: 10%;">Item Code</th>
                                        <th class="text-left" style="width: 30%;">Item Name</th>
                                        <th class="text-right" style="width: 10%;">Current Stock</th>
                                        <th class="text-right" style="width: 10%;">Total Issued</th>
                                        <th class="text-right" style="width: 15%;">Last 3 Months Issued</th>
                                        <th class="text-right" style="width: 10%;">Last Month Issued</th>
                                        <th class="text-right" style="width: 10%;">Avg. L3M Issued</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($items as $index => $item)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td class="text-center">{{ $item->item_no_pk }}</td>
                                            <td class="text-left" style="white-space: normal; word-wrap: break-word;">{{ $item->item_name }}</td>
                                            <td class="text-right">{{ number_format($item->current_stock, 2) }}</td>
                                            <td class="text-right">{{ number_format($item->total_issued, 2) }}</td>
                                            <td class="text-right">{{ number_format($item->l3missued, 2) }}</td>
                                            <td class="text-right">{{ number_format($item->lmissued, 2) }}</td>
                                            <td class="text-right">{{ number_format($item->l3maissued, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            @endforeach

        </div>
            
    </div>


</body>
</html>
