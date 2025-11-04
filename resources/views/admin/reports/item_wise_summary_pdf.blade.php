<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Item Wise Summary Report</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <style>
        @page {
            margin: .5cm .6cm;
            width: 100%;
            height: 100%
        }

        @font-face {
            font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
            font-weight: normal;
            font-size: 9px;
            font-style: normal;
            font-variant: normal;
            src: url("font url");
        }


        /** Define the header rules **/
        header {
            position: fixed;
            top: 0;
            height: 2cm;
            border-bottom: 1px solid;
            padding: 0 1cm;
        }

        header img {
            /*width: 80px;*/
        }

        /** Define now the real margins of every page in the PDF **/
        body {
            margin-top: 0.5cm;
            margin-left: .3cm;
            margin-right: .3cm;
            margin-bottom: 2cm;
            font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
            font-size: 10px;
        }

        footer {
            position: fixed;
            bottom: 0cm;
            left: 0cm;
            right: 0cm;
            height: .7cm;
            text-align: center;
            padding: 0 1cm;
            border-top: 1px solid;
        }

        .signature_ {
            position: fixed;
            bottom: 1.6cm;
            left: .8cm;
            right: .8cm;
            width: 100%;
            /* text-align: center; */

            /* border-top: 1px solid; */
        }

        tfoot tr td {
            font-weight: bold;
        }

        .page-break {
            page-break-after: always;
        }

        .mt-5 {
            margin-top: 5px;
        }

        .mt-10 {
            margin-top: 10px;
        }

        .mt-20 {
            margin-top: 20px;
        }

        .mb-0 {
            margin-bottom: 0;
        }

        .mb-5 {
            margin-bottom: 15px;
        }

        .pb-0 {
            padding-bottom: 0;
        }

        table {
            border: 1px solid #222;
            border-spacing: 0;
            width: 100%
        }

        td {
            border: 1px solid #222;
            padding: 7px;
            font-size: 12px;
        }

        table td:last-child {
            border-right: 0px solid transparent;
        }

        th {
            border: 1px solid #222;
            font-size: 14px;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .text-left {
            text-align: left;
        }
    </style>
</head>

<body>

    <header>
        <table style="width: 100%; border:none;" class="signature">
            <tr>
                <td style="width: 15%; border:none;">
                    <img class="hospital-logo"
                        src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}" width="60"
                        alt="">
                </td>
                <td style="text-align:center; border:none;">
                    <span style="font-size: 15px;"> <strong>
                            {{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }}
                        </strong></span>
                    <br>
                    Address:
                    <span>
                        {{ isset($po_hospital_details->addrress1) ? $po_hospital_details->addrress1 : '' }}</span><br>
                    Phone No:
                    <span>
                        {{ isset($po_hospital_details->telephone1) ? $po_hospital_details->telephone1 : '' }}</span>
                </td>
                <td style=" text-align:right; width: 15%;  border:none;">
                    <div style="">
                        <img src="data:image/png;base64, {{ $barcode_no }} " width="100" />
                    </div>

                </td>
            </tr>
        </table>
    </header>

    <div style="text-align: center; padding:25px">
       
        <strong>
            <h2>Item Wise Summary Report</h2>
        </strong>
        {{-- <strong>From : {{ date('d/m/Y',$from_date) }} To:  {{ date('d/m/Y',$to_date) }} </strong> --}}
        <span class="report-date"><strong>From Date: {{ $from_date }}</strong> - <span
            class="report-date"><strong>To Date: {{ $to_date }}</strong>
        </span>
    </div>
    <table class="table data-table table-bordered table-hover table-striped">
        <thead class="bg-primary">
            <tr>
                <th class="text-center">SL#</th>
                <th class="text-center">Test Name</th>
                <th class="text-center">Collected</th>
                <th class="text-center">Received</th>
                <th class="text-center">Verified</th>
                <th class="text-center">Finalized</th>
            </tr>
        </thead>
        <tbody>
            @if (!empty($data) && count($data) > 0)
                <div style="display: none">
                    {{ $collect_quantity_final = 0 }}
                    {{ $received_qty_final = 0 }}
                    {{ $verified_qty_final = 0 }}
                    {{ $finalized_qty_final = 0 }}
                </div>
                @foreach ($data as $key => $dt)
                    <div style="display: none">
                        {{ $collect_quantity_total = 0 }}
                        {{ $received_qty_total = 0 }}
                        {{ $verified_qty_total = 0 }}
                        {{ $finalized_qty_total = 0 }}
                    </div>
                    <tr>
                        <td colspan="6" class="text-left bg-light-blue">
                            <strong>
                                {{ $key }}

                            </strong>
                        </td>
                    </tr>
                    @foreach ($dt as $value)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="text-left">{{ $value->item_name }}</td>
                            <td class="text-center">
                                {{ !empty($value->collect_quantity) ? $value->collect_quantity : 'N/A' }}</td>
                            <td class="text-center">{{ !empty($value->received_qty) ? $value->received_qty : 'N/A' }}
                            </td>
                            <td class="text-center">{{ !empty($value->verified_qty) ? $value->verified_qty : 'N/A' }}
                            </td>
                            <td class="text-center">{{ !empty($value->finalized_qty) ? $value->finalized_qty : 'N/A' }}
                            </td>

                            <div style="display: none">
                                {{ $collect_quantity_total += !empty($value->collect_quantity) ? $value->collect_quantity : 0 }}
                            </div>
                            <div style="display: none">
                                {{ $received_qty_total += !empty($value->received_qty) ? $value->received_qty : 0 }}
                            </div>
                            <div style="display: none">
                                {{ $verified_qty_total += !empty($value->verified_qty) ? $value->verified_qty : 0 }}
                            </div>
                            <div style="display: none">
                                {{ $finalized_qty_total += !empty($value->finalized_qty) ? $value->finalized_qty : 0 }}
                            </div>
                        </tr>
                    @endforeach
                    <tr>
                        <th class="text-right" colspan="2">Sub Total =</th>
                        <th class="text-center bg-light-blue">{{ $collect_quantity_total }}</th>
                        <th class="text-center bg-light-blue">{{ $received_qty_total }}</th>
                        <th class="text-center bg-light-blue">{{ $verified_qty_total }}</th>
                        <th class="text-center bg-light-blue">{{ $finalized_qty_total }}</th>
                    </tr>

                    <div style="display: none">{{ $collect_quantity_final += $collect_quantity_total }}</div>
                    <div style="display: none">{{ $received_qty_final += $received_qty_total }}</div>
                    <div style="display: none">{{ $verified_qty_final += $verified_qty_total }}</div>
                    <div style="display: none">{{ $finalized_qty_final += $finalized_qty_total }}</div>
                @endforeach
            @else
                <tr>
                    <td colspan="6" class="text-center">No data available</td>
                </tr>
            @endif
            @if (!empty($data) && count($data) > 0)
            <tr>
                <th class="text-right" colspan="2">Total =</th>
                <th class="text-center bg-light-blue">{{ $collect_quantity_final }}</th>
                <th class="text-center bg-light-blue">{{ $received_qty_final }}</th>
                <th class="text-center bg-light-blue">{{ $verified_qty_final }}</th>
                <th class="text-center bg-light-blue">{{ $finalized_qty_final }}</th>
            </tr>
        @endif
        </tbody>
        <tfoot>

        </tfoot>
    </table>





    


</body>

</html>
<script>
    window.print();
    window.onafterprint = function() {
        window.close(); // Close the window after printing
    }
</script>
