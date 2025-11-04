@php
    $hospital = DB::table('wsec_hospital')
        ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
        ->first();
@endphp
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Sales Report</title>
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <style>
        @page {
            margin: .5cm .6cm;
        }

        body {
            font-family: 'IBM Plex Sans', Helvetica, Arial, sans-serif;
            font-size: 11px;
            margin: 2cm .3cm 2cm .3cm;
        }

        header,
        footer {
            position: fixed;
            left: 0;
            right: 0;
        }

        header {
            top: 0;
            height: 2cm;
            border-bottom: 1px solid #222;
        }

        footer {
            bottom: 0;
            height: .7cm;
            border-top: 1px solid #222;
            font-size: 9px;
            text-align: center;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            border: 1px solid #222;
        }

        th,
        td {
            border: 1px solid #222;
            padding: 3px;
        }

        .bg-light-blue {
            background-color: #e8f4f8;
        }

        .text-right {
            text-align: right;
        }

        .text-left {
            text-align: left;
        }

        .text-center {
            text-align: center;
        }
    </style>
</head>

<body>

    <header>
        <table style="width: 100%; border:none;">
            <tr>
                <td style="width: 15%; border:none;">
                    @if (!empty($po_hospital_details->logo))
                        <img src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}"
                            width="60">
                    @endif
                </td>
                <td style="text-align:center; border:none;">
                    <strong style="font-size: 15px;">{{ $po_hospital_details->hospital_name ?? '' }}</strong><br>
                    Address: {{ $po_hospital_details->addrress1 ?? '' }}<br>
                    Phone: {{ $po_hospital_details->telephone1 ?? '' }}
                </td>
                <td style="width: 15%; text-align:right; border:none;"></td>
            </tr>
        </table>
    </header>

    <footer>
        <table style="width: 100%; border:none;">
            <tr>
                <td style="text-align:left; border:none;">
                    Print Date & Time: <strong>{{ now('Asia/Dhaka')->format('d/m/Y g:i A') }}</strong>
                    | Printed By: <strong>{{ Session::get('user.ses_user_name') }}</strong>
                </td>
            </tr>
        </table>
    </footer>

    <main>
        <div style="text-align:center; margin-top:10px;">
            <strong>SALES REPORT</strong><br>
            <strong>From: {{ $from_date }} To: {{ $to_date }}</strong>
        </div>

        <table cellpadding="1" cellspacing="0" style="margin-top:10px;">
            <thead class="bg-light-blue">
                <tr>
                    <th>SL#</th>
                    <th class="text-left">Debtor Code</th>
                    <th class="text-left">Debtor Name</th>
                    <th class="text-right">OP Bill Count</th>
                    <th class="text-right">OP Sales</th>
                    <th class="text-right">IP Bill Count</th>
                    <th class="text-right">IP Sales</th>
                    <th class="text-right">Total Sales</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $grandOpCount = $grandIpCount = $grandOpSales = $grandIpSales = 0;
                @endphp

                @forelse ($report_data as $row)
                    @php
                        $totalSales = $row->op_sales + $row->ip_sales;
                        $grandOpCount += $row->op_count;
                        $grandIpCount += $row->ip_count;
                        $grandOpSales += $row->op_sales;
                        $grandIpSales += $row->ip_sales;
                    @endphp
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class="text-left">{{ $row->patient_code }}</td>
                        <td class="text-left">{{ $row->patient_name }}</td>
                        <td class="text-right">{{ number_format($row->op_count, 0) }}</td>
                        <td class="text-right">{{ number_format($row->op_sales, 2) }}</td>
                        <td class="text-right">{{ number_format($row->ip_count, 0) }}</td>
                        <td class="text-right">{{ number_format($row->ip_sales, 2) }}</td>
                        <td class="text-right"><strong>{{ number_format($totalSales, 2) }}</strong></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">No data available</td>
                    </tr>
                @endforelse
            </tbody>

            <tfoot class="bg-light-blue">
                @php $grandTotalSales = $grandOpSales + $grandIpSales; @endphp
                <tr>
                    <th colspan="3" class="text-right">Grand Total =</th>
                    <th class="text-right">{{ number_format($grandOpCount, 0) }}</th>
                    <th class="text-right">{{ number_format($grandOpSales, 2) }}</th>
                    <th class="text-right">{{ number_format($grandIpCount, 0) }}</th>
                    <th class="text-right">{{ number_format($grandIpSales, 2) }}</th>
                    <th class="text-right">{{ number_format($grandTotalSales, 2) }}</th>
                </tr>
            </tfoot>
        </table>
    </main>

</body>

</html>
