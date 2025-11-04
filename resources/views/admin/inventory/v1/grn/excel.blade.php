<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Doctor Performance Summary Report</title>
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
    @php
      $hospital_code = DB::table('WSEC_HOSPITAL')->first()->hospital_code;
@endphp
</head>

<body>
    <div style="text-align: center; padding:5px">
        <strong>
            <h1> {{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }}</h1>
        </strong>
        <strong>
            <h2>Inventory GRN Worklist</h2>
        </strong>
        {{-- <strong>From : {{ date('d/m/Y',$from_date) }} To:  {{ date('d/m/Y',$to_date) }} </strong> --}}
        <span class="report-date"><strong>From Date: {{ $from_date }}</strong> - <span class="report-date"><strong>To
                    Date: {{ $to_date }}</strong>
            </span>
    </div>
    <table class="table table-bordered mt-3" cellspacing="0" cellpading="0">
        <thead>
            <tr class="">
                <th class="text-center">SL</th>
                <th class="text-center">GRN No.</th>
                <th class="text-center">GRN Date</th>
                <th class="text-center">PO No.</th>
                <th class="text-center">Challan Date</th>
                <th class="text-center">Supplier Name</th>
                <th class="text-center">No. of Item</th>
                <th class="text-center">Amount</th>
                <th class="text-center">GRN By</th>
                <th class="text-center">Status</th>
            </tr>
        </thead>
        <tbody>
            @if(isset($data))
                @foreach($data as $item)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    @if($hospital_code == 'KPJ')
                        <td class="text-center">{{ $item->itemreceive_uid }}</td>
                    @else
                        <td class="text-center">{{ $item->itemreceive_no_pk }}</td>
                    @endif
                                            
                        <td class="text-center">{{ date('d/m/Y', strtotime($item->receive_date)) }}</td>
                    @if($hospital_code == 'KPJ')
                        <td class="text-center">{{ $item->purchase_uid }}</td>
                    @else
                        <td class="text-center">{{ $item->po_no }}</td>
                    @endif
                    <td class="text-center">{{ date('d/m/Y', strtotime($item->challan_date)) }}</td>
                    <td class="text-left">{{ $item->supplier_name }}</td>
                    <td class="text-center">{{ $item->item_q }}</td>
                    <td class="text-right">{{ $item->total_purchase_amount }}</td>
                    <td class="text-left">{{ $item->user_fullname_entry_by }}</td>
                    <td class="text-left">{{ $item->rcv_save_option }}</td>
                </tr>
                @endforeach
            @endif
        </tbody>
    </table>


</body>

</html>
<script>
    // window.print();
    // window.onafterprint = function() {
    //     window.close(); // Close the window after printing
    // }
</script>
