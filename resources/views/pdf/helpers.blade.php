@php
$po_hospital_details = DB::table('WSEC_HOSPITAL')->first();
$dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));

$date = $dt->format('g:i A');
$today_date_time = date('d/m/Y H:i:s A');
$printed_by = Session::get('user.ses_user_name');
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'Report' }}</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th,
        td {
            border: 1px solid #444;
            padding: 6px;
            font-size: 11px;
            word-break: break-word;
        }

        th {
            background-color: #f0f8ff;
            text-align: left;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .text-left {
            text-align: left;
        }

        .header-table td {
            border: none !important;
        }

        .report-title {
            font-size: 16px;
            font-weight: bold;
            text-align: center;
            margin-top: 10px;
        }

        .filters-panel {
            margin-top: 10px;
            width: 100%;
            font-size: 11px;
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            border: 1px solid #ccc;
            padding: 5px;
            background: #f9f9f9;
        }

        .filters-panel div {
            display: flex;
            gap: 5px;
            align-items: center;
        }

        @media print {
            @page {
                margin-bottom: 1.2cm;

                @bottom-left {
                    content: "Printed: {{ $today_date_time }} by {{ $printed_by }}";
                    font-size: 10px;
                }

                @bottom-center {
                    content: "Powered By: [NEXTGEN]";
                    font-size: 10px;
                }

                @bottom-right {
                    content: "Page " counter(page) " of " counter(pages);
                    font-size: 10px;
                }
            }

            @page: first {
                @top-right {
                    content: none;
                }
            }

            .result-data {
                font-size: 12px;
            }

            .watermark {
                display: block;
            }
        }

        th {
            background-color: #f0f8ff;
            text-align: left;
            white-space: nowrap;
            /* 🟢 এক লাইনে রাখবে */
        }
    </style>
</head>

<body>
    {{-- Watermark (hidden by default) --}}
    <div class="watermark" style="position: absolute; top: 40%; left: 20%; font-size: 50px; color: rgba(0,0,0,0.1); transform: rotate(-30deg); display: none;">
        CONFIDENTIAL
    </div>

    {{-- Hospital Header --}}
    <table class="header-table">
        <tr>
            <td style="width: 15%;">
                @if(!empty($po_hospital_details->logo))
                <img src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}" width="60" alt="Hospital Logo">
                @endif
            </td>
            <td style="text-align: center;">
                <div style="font-size: 16px;"><strong>{{ $po_hospital_details->hospital_name ?? '' }}</strong></div>
                <div>Address: {{ $po_hospital_details->addrress1 ?? '' }}</div>
                <div>Phone No: {{ $po_hospital_details->telephone1 ?? '' }}</div>
            </td>
            <td style="width: 15%; text-align: right;">
                @if(!empty($barcode_no))
                <img src="data:image/png;base64, {{ $barcode_no }}" width="100" />
                @endif
            </td>
        </tr>
    </table>

    {{-- Report Title --}}
    <div class="report-title">
        {{ $title ?? 'Print Report' }}
    </div>

    {{-- Filters Section --}}
    @if(!empty($filters))
    <div class="filters-panel">
        <strong style="flex-basis: 100%;">Search Parameters:</strong>
        @foreach($filters as $key => $value)
        @if(!empty($value))
        <div>
            <span><strong>{{ $key }}:</strong></span>
            <span>{{ $value }}</span>
        </div>
        @endif
        @endforeach
    </div>
    @endif

    {{-- Dynamic Table --}}
    <table>
        <thead>
            <tr>
                @foreach($headers as $head)
                <th class="text-center">{{ $head }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @forelse($rows as $row)
            <tr>
                @foreach($row as $cell)
                <td>{!! $cell !!}</td>
                @endforeach
            </tr>
            @empty
            <tr>
                <td colspan="{{ count($headers) }}" class="text-center">No data available</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Trigger print --}}
    <script>
        window.onload = function() {
            window.print();
        };
    </script>
</body>

</html>