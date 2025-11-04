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
    <title>Asset Depreciation Report</title>
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
            <strong>Date: {{ date('d/m/Y') }}</strong>
            {{-- <strong>Date: {{ $report_date }}</strong> --}}
        </div>

        <table cellpadding="1" cellspacing="0" style="margin-top:10px;">
            <thead class="bg-light-blue">
                <tr>
                    <th>SL</th>
                    <th>Sub Category</th>
                    <th>Tag No</th>
                    <th>GRN Date</th>
                    <th>Vendor Name</th>
                    <th>Description</th>
                    <th>P.O No</th>
                    <th>GRN No</th>
                    <th>Qty</th>
                    <th>Month</th>
                    <th>Additions (BDT)</th>
                    <th>Total Rate</th>
                    <th>Already Depreciation AMT</th>
                    <th>Balance AMT</th>
                    <th>Last Depreciation Date</th>
                    <th>Depreciation Percentage</th>
                    <th>Depreciation Per Month</th>
                    <th>Depreciation (BDT)</th>
                    {{-- <th>Location</th> --}}
                </tr>
            </thead>
            <tbody>
                @forelse ($asset_depreciations as $value)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $value->sub_catagory }}</td>
                        <td>{{ $value->tag_ud }}</td>
                        <td>{{ date('d/m/Y', strtotime($value->grn_date)) }}</td>
                        <td>{{ $value->supplier_name }}</td>
                        <td>{{ $value->item_name }}</td>
                        <td>{{ $value->po_no }}</td>
                        <td>{{ $value->grn_no }}</td>
                        <td>{{ $value->qty }}</td>
                        <td>{{ $value->months }}</td>
                        <td>{{ '' }}</td>
                        <td>{{ $value->rate }}</td>
                        <td>{{ $value->already_dep_amt }}</td>
                        <td>
                            @if ($value->rate > $value->already_dep_amt)
                                {{ $value->rate - $value->already_dep_amt }}
                            @else
                                0
                            @endif
                        </td>
                        <td>{{ $value->last_dep_date != null ? date('d/m/Y', strtotime($value->last_dep_date)) : '-' }}
                        </td>
                        <td>{{ $value->depreciation_percentage }}</td>
                        <td>{{ $value->per_month }}</td>
                        <td>
                            @if ($value->months > 0)
                                {{ number_format($value->per_month, 2) }}
                                @php $total_amount += $value->per_month; @endphp
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="12" class="text-center">No data available</td>
                    </tr>
                @endforelse
            </tbody>
            {{-- <tfoot class="bg-light-blue">
                <tr>
                    <th colspan="2" class="text-right">Grand Total =</th>
                    @php $overallTotal = array_sum($grandTotal); @endphp
                    @foreach ($grandTotal as $value)
                        <th>{{ number_format($value, 2) }}</th>
                    @endforeach
                    <th>{{ number_format($overallTotal, 2) }}</th>
                </tr>
            </tfoot> --}}
        </table>
    </main>

</body>

</html>
