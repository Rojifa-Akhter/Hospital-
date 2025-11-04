<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Cashier Receipt Summary</title>
    <style>
        @page{
            margin-left: 5px;
            margin-right: 5px;
        }
        body {
            font-family: 'Arial', sans-serif;
            font-size: 11px;
            color: #333;
        }

        header {
            text-align: center;
            border-bottom: 1px solid #999;
            padding-bottom: 8px;
            margin-bottom: 5px;
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
        <div style="font-size: 12px;">DEBTOR DETAILED AGEING REPORT</div>
        {{-- <div style="font-size: 10px;">Receipt Date: {{ $fromDate }} To {{ $toDate }} </div> --}}
        {{-- <div style="font-size: 10px;">AS OF Date: {{ $toDate }}</div> --}}
        <div style="font-size: 10px;">Report Date: {{ date('d/m/Y') }}</div>
        <div style="font-size: 10px;">AS OF Date: {{ \Carbon\Carbon::parse($toDate)->format('d/m/Y') }}</div>
    </header>

    <div class="row">
    <div class="col-md-12">
        <h4 class="mb-3" style="border-bottom: 1px dotted rgb(179, 176, 176); padding-bottom: 5px;">Debtor Detailed Aging Report</h4>
        <table class="table table-striped table-bordered table-hover data-table">
            <thead class="thead-success">
                <tr>
                    <th class="text-center">SL</th>
                    <th class="text-center">MRN</th>
                    <th class="text-center">CODE</th>
                    <th class="text-left">NAME</th>
                    <th class="text-center">FIN. CLASS</th>
                    <th class="text-center">EPIS. TYPE</th>
                    <th class="text-center">DOCUMENT NO.</th>
                    <th class="text-center">DOCUMENT DATE</th>
                    <th class="text-right">1-30 Days</th>
                    <th class="text-right">31-60 Days</th>
                    <th class="text-right">61-90 Days</th>
                    <th class="text-right">91-120 Days</th>
                    <th class="text-right">121-150 Days</th>
                    <th class="text-right">151-365 Days</th>
                    <th class="text-right"> > 365 Days</th>
                    <th class="text-right">TOTAL</th>  
                </tr>
            </thead>
            <tbody id="cvListTableLeft">
                @php
                    $grandTotal = 0;
                    $grand1_30 = 0;
                    $grand31_60 = 0;
                    $grand61_90 = 0;
                    $grand91_120 = 0;
                    $grand121_150 = 0;
                    $grand151_365 = 0;
                    $grandAbove_365 = 0;
                @endphp

                @foreach ($groupedClientInfo as $clientCode => $group)
                    @php
                        $clientName = $group->first()->ccm_client_name;

                        $subtotal = 0;
                        $sub1_30 = 0;
                        $sub31_60 = 0;
                        $sub61_90 = 0;
                        $sub91_120 = 0;
                        $sub121_150 = 0;
                        $sub151_365 = 0;
                        $subAbove_365 = 0;
                    @endphp

                    {{-- Client Header --}}
                    {{-- <tr style="background-color: #f2f2f2; font-weight: bold;">
                        <td colspan="3" class="text-right">{{ $clientCode }}</td>
                        <td colspan="5" class="text-left">{{ $clientName }}</td>
                        <td colspan="8"></td>
                    </tr> --}}

                    {{-- Client Details --}}
                    <tr>
                        <td colspan="3" class="text-right">{{ $clientCode }}</td>
                        <td colspan="5" class="text-left">{{ $clientName }}</td>
                        <td colspan="3" class="text-right"></td>
                    </tr>
                    
                    @foreach ($group as $data)
                        @php
                            $total = $data->one_to_30 + $data->thirtyone_to_sixty + $data->sixtyone_to_90 + $data->ninetyone_to_120 +
                                    $data->hundred21_to_150 + $data->hundred51_to_365 + $data->above_365;

                            $sub1_30 += $data->one_to_30;
                            $sub31_60 += $data->thirtyone_to_sixty;
                            $sub61_90 += $data->sixtyone_to_90;
                            $sub91_120 += $data->ninetyone_to_120;
                            $sub121_150 += $data->hundred21_to_150;
                            $sub151_365 += $data->hundred51_to_365;
                            $subAbove_365 += $data->above_365;
                            $subtotal += $total;

                            $grand1_30 += $data->one_to_30;
                            $grand31_60 += $data->thirtyone_to_sixty;
                            $grand61_90 += $data->sixtyone_to_90;
                            $grand91_120 += $data->ninetyone_to_120;
                            $grand121_150 += $data->hundred21_to_150;
                            $grand151_365 += $data->hundred51_to_365;
                            $grandAbove_365 += $data->above_365;
                            $grandTotal += $total;
                        @endphp
                        
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="text-center">{{ $data->patient_code }}</td>
                            <td class="text-center"></td>
                            <td class="text-left">{{ $data->patient_name }}</td>
                            <td class="text-center">CO</td>
                            <td class="text-center">{{ $data->module_code }}</td>
                            <td class="text-center">{{ $data->invoice_no_fk }}</td>
                            <td class="text-center">{{ $data->ledger_date }}</td>
                            <td class="text-right">{{ number_format($data->one_to_30, 2) }}</td>
                            <td class="text-right">{{ number_format($data->thirtyone_to_sixty, 2) }}</td>
                            <td class="text-right">{{ number_format($data->sixtyone_to_90, 2) }}</td>
                            <td class="text-right">{{ number_format($data->ninetyone_to_120, 2) }}</td>
                            <td class="text-right">{{ number_format($data->hundred21_to_150, 2) }}</td>
                            <td class="text-right">{{ number_format($data->hundred51_to_365, 2) }}</td>
                            <td class="text-right">{{ number_format($data->above_365, 2) }}</td>
                            <td class="text-right">{{ number_format($total, 2) }}</td>
                        </tr>
                    @endforeach

                    {{-- Subtotal Row --}}
                    <tr style="background-color: #e8f5e9; font-weight: bold;">
                        <td colspan="3" class="text-right">{{ $clientCode }}</td>
                        <td colspan="5" class="text-right">Subtotal for {{ $clientName }}</td>
                        <td class="text-right">{{ number_format($sub1_30, 2) }}</td>
                        <td class="text-right">{{ number_format($sub31_60, 2) }}</td>
                        <td class="text-right">{{ number_format($sub61_90, 2) }}</td>
                        <td class="text-right">{{ number_format($sub91_120, 2) }}</td>
                        <td class="text-right">{{ number_format($sub121_150, 2) }}</td>
                        <td class="text-right">{{ number_format($sub151_365, 2) }}</td>
                        <td class="text-right">{{ number_format($subAbove_365, 2) }}</td>
                        <td class="text-right">{{ number_format($subtotal, 2) }}</td>
                    </tr>
                @endforeach

                {{-- Grand Total --}}
                <tr style="background-color: #d9edf7; font-weight: bold;">
                    <td colspan="8" class="text-right">Grand Total</td>
                    <td class="text-right">{{ number_format($grand1_30, 2) }}</td>
                    <td class="text-right">{{ number_format($grand31_60, 2) }}</td>
                    <td class="text-right">{{ number_format($grand61_90, 2) }}</td>
                    <td class="text-right">{{ number_format($grand91_120, 2) }}</td>
                    <td class="text-right">{{ number_format($grand121_150, 2) }}</td>
                    <td class="text-right">{{ number_format($grand151_365, 2) }}</td>
                    <td class="text-right">{{ number_format($grandAbove_365, 2) }}</td>
                    <td class="text-right">{{ number_format($grandTotal, 2) }}</td>
                </tr>
            </tbody>
        </table>
    </div>
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
