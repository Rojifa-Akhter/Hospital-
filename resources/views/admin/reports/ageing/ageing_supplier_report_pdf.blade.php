@php $hospital = DB::table('wsec_hospital')->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->first(); @endphp
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Ageing Supplier Report</title>
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
        <table style="width:100%; border:none;">
            <tr>
                <td style="width:15%; border:none;">
                    @if (!empty($po_hospital_details->logo))
                        <img src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}"
                            width="60">
                    @endif
                </td>
                <td style="text-align:center; border:none;">
                    <strong style="font-size:15px;">{{ $po_hospital_details->hospital_name ?? '' }}</strong><br>
                    Address: {{ $po_hospital_details->addrress1 ?? '' }}<br>
                    Phone: {{ $po_hospital_details->telephone1 ?? '' }}
                </td>
                <td style="width:15%; text-align:right; border:none;"></td>
            </tr>
        </table>
    </header>

    <footer>
        <table style="width:100%; border:none;">
            <tr>
                <td style="text-align:left; border:none;">
                    Print Date & Time: <strong>{{ now('Asia/Dhaka')->format('d/m/Y g:i A') }}</strong>
                    | Printed By: <strong>{{ Session::get('user.ses_user_name') }}</strong>
                </td>
                <td style="text-align:right; border:none;"></td>
            </tr>
        </table>
    </footer>

    <main>
        <div style="text-align:center; margin-top:10px;">
            <strong>AGEING SUPPLIER REPORT</strong><br>
            <strong>Date: {{ $report_date }}</strong>
        </div>

        <table cellpadding="1" cellspacing="0" style="margin-top:10px;">
            <thead class="bg-light-blue">
                <tr>
                    <th>SL#</th>
                    <th>Supplier</th>
                    <th>1–30</th>
                    <th>31–60</th>
                    <th>61–90</th>
                    <th>91–120</th>
                    <th>121–150</th>
                    <th>151–180</th>
                    <th>181–210</th>
                    <th>211–360</th>
                    <th>>360</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @php $grandTotal = array_fill(0,9,0); @endphp
                @forelse($report_data as $row)
                    @php
                        $rowTotal =
                            $row->f1to30 +
                            $row->f31to60 +
                            $row->f61to90 +
                            $row->f91to120 +
                            $row->f121to150 +
                            $row->f151to180 +
                            $row->f181to210 +
                            $row->f211to360 +
                            $row->f360;
                        $grandTotal = array_map(
                            function ($val, $key) use ($row) {
                                return $val + $row->{$key};
                            },
                            $grandTotal,
                            [
                                'f1to30',
                                'f31to60',
                                'f61to90',
                                'f91to120',
                                'f121to150',
                                'f151to180',
                                'f181to210',
                                'f211to360',
                                'f360',
                            ],
                        );
                    @endphp
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class="text-left">{{ $row->sup_name }}</td>
                        <td>{{ number_format($row->f1to30, 2) }}</td>
                        <td>{{ number_format($row->f31to60, 2) }}</td>
                        <td>{{ number_format($row->f61to90, 2) }}</td>
                        <td>{{ number_format($row->f91to120, 2) }}</td>
                        <td>{{ number_format($row->f121to150, 2) }}</td>
                        <td>{{ number_format($row->f151to180, 2) }}</td>
                        <td>{{ number_format($row->f181to210, 2) }}</td>
                        <td>{{ number_format($row->f211to360, 2) }}</td>
                        <td>{{ number_format($row->f360, 2) }}</td>
                        <td>{{ number_format($rowTotal, 2) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="12" class="text-center">No data available</td>
                    </tr>
                @endforelse
            </tbody>
            <tfoot class="bg-light-blue">
                @php $overallTotal = array_sum($grandTotal); @endphp
                <tr>
                    <th colspan="2" class="text-right">Grand Total =</th>
                    @foreach ($grandTotal as $val)
                        <th>{{ number_format($val, 2) }}</th>
                    @endforeach
                    <th>{{ number_format($overallTotal, 2) }}</th>
                </tr>
            </tfoot>
        </table>
    </main>
</body>

</html>
