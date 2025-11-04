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
    <title>Ageing Summary Report</title>
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
            text-align: center;
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
                <td style="text-align:right; border:none;">
                </td>
            </tr>
        </table>
    </footer>

    <main>
        <div style="text-align:center; margin-top:10px;">
            <strong style="">AGEING SUMMARY REPORT</strong><br>
            <strong>Date: {{ $report_date }}</strong>
        </div>

        <table cellpadding="1" cellspacing="0" style="margin-top:10px;">
            <thead class="bg-light-blue">
                <tr>
                    <th>SL#</th>
                    <th>Debtor Category</th>
                    <th>1–30</th>
                    <th>31–60</th>
                    <th>61–90</th>
                    <th>91–120</th>
                    <th>121–150</th>
                    <th>151–180</th>
                    <th>181–210</th>
                    <th>211–365</th>
                    <th>>365</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @php $grandTotal = array_fill(0, 9, 0); @endphp
                @forelse ($report_data as $category => $buckets)
                    @php
                        $categoryTotal = array_sum($buckets);
                    @endphp
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class="text-left"><strong>{{ ucfirst($category) }}</strong></td>
                        @foreach ($buckets as $i => $value)
                            <td>{{ number_format($value, 2) }}</td>
                            @php $grandTotal[$i] += $value; @endphp
                        @endforeach
                        <td><strong>{{ number_format($categoryTotal, 2) }}</strong></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="12" class="text-center">No data available</td>
                    </tr>
                @endforelse
            </tbody>
            <tfoot class="bg-light-blue">
                <tr>
                    <th colspan="2" class="text-right">Grand Total =</th>
                    @php $overallTotal = array_sum($grandTotal); @endphp
                    @foreach ($grandTotal as $value)
                        <th>{{ number_format($value, 2) }}</th>
                    @endforeach
                    <th>{{ number_format($overallTotal, 2) }}</th>
                </tr>
            </tfoot>
        </table>
    </main>

</body>

</html>
