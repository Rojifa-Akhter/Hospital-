<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            margin-left: 0cm;
            margin-right: 0cm;
            font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
            font-size: 9px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        table tr td,
        table tr th {
            font-size: 10px;
            border: 0;
            font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
            padding: 2px;
        }

        .text-center {
            text-align: center !important;
        }

        .text-left {
            text-align: left !important;
        }

        .text-right {
            text-align: right !important;
        }

        .d-flex {
            display: flex;
        }

        .align-items-center {
            align-items: center;
        }

        .table-bordered td,
        .table-bordered th {
            border: 1px solid #222
        }

        body {
            margin-bottom: 2.8cm;
            font-family: 'Roboto', sans-serif;
            color: black;
        }

        footer {
            position: fixed;
            z-index: 999999999;
            left: 0;
            right: 0;
            height: 3cm;
            text-align: center;
            font-size: 9px;
            bottom: -100px;
        }

        .signature {
            position: fixed;
            z-index: 999999999;
            left: 0;
            right: 0;
            height: 6.7cm;
            text-align: center;
            font-size: 9px;
            bottom: -100px;
            margin-top: 10px;
        }
    </style>
</head>
<header>
    <table width="100%">
        <tr>
            <td style="width: 15%;">
                @if (!empty($po_hospital_details->logo))
                <img src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}" width="60px" />
                @endif
            </td>
            <td>
                <span style="font-size: 13px;">
                    <strong> {{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }} </strong>
                </span>
                <br>
                <span>
                    {{ isset($po_hospital_details->addrress1) ? $po_hospital_details->addrress1 : '' }}
                </span>
                <br>
                <span>
                    {{ isset($po_hospital_details->telephone1) ? $po_hospital_details->telephone1 : '' }}
                </span>
            </td>
        </tr>
    </table>
    <div style="text-align: center;font-size: 12px; font-style:bold">
        <span>Center Store To Supply Chain</span>
        <p>Bill Process No: {{isset($grn_data_arr) && !empty($grn_data_arr) ? $grn_data_arr[0]->pmnt_reqmst_no_fk :''}} </p>
    </div>

</header>
<div class="signature">
    <table style="width: 100%; border:none ; ">
        <tbody>
            <tr style="">
                <td style="text-align:left; border:none ">
                    <span style="padding:5px; border-top: black solid 1px;"> <strong>Store Incharge </strong></span>
                </td>
                <td style="text-align:right; border:none ">
                    <span style="padding:5px; border-top: black solid 1px;"> <strong>Receive to supply chain </strong></span>
                </td>
            </tr>
        </tbody>
    </table>
</div>
<footer>
    <?php
    $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
    $date = $dt->format('g:i A');
    ?>
    <div class="" style=" border-top: 1px solid black;">
        <span style="">printed By: {{ $userInfo->user_fullname }}</span> &nbsp; <span style="">Printing Date & Time: {{ date('d/m/Y') }} , {{ $date }} </span>&nbsp;
        <span>Powered By: NEXTGEN IT</span>
    </div>
</footer>

<body>
    <div>
        <table class="table table-bordered" style="">
            <thead>
                <tr>
                    <th class="text-center" style="width: 30px;">Sl.</th>
                    <th class="text-center">Bill Process Date</th>
                    <th class="text-center">Invoice No</th>
                    <th class="text-center">GRN No</th>
                    <th class="text-center">PO No</th>
                    <th class="text-center">Challan No</th>
                    <th>Store</th>
                    <th>Supplier</th>
                    <th class="text-right">Receive Amt</th>
                    <th class="text-right">Return Amt</th>
                    <th class="text-right">Current Amt</th>
                    <th class="text-center">Status </th>
                </tr>
            </thead>
            <tbody>
                @php
                $total_receive_amt=0;
                $total_return_amt=0;
                $total_current_amt=0;
                @endphp
                @if (isset($grn_data_arr))
                 @php
                $groupedData = $grn_data_arr->groupBy('bill_or_invoice_no');
                @endphp
                @foreach ($groupedData as $invoiceNo => $group)
                <tr>
                    <td colspan="12" style="background-color: #f0f0f0;"><strong>Invoice No: {{ $invoiceNo }}</strong></td>
                </tr>

                @php
                $receive_amt=0;
                $return_amt=0;
                $current_amt=0;
                @endphp
                @foreach ($group as $value)
                <tr>
                    <td style="text-align: center;">{{$loop->iteration}}</td>
                    <td class="text-center">
                        {{ $value->au_entry_at !="" ? date('d/m/Y',strtotime($value->au_entry_at)):''  }}
                    </td>
                    <td class="text-center">{{$value->bill_or_invoice_no}}</td>
                    <td class="text-center">{{$value->itemreceive_no_fk}}</td>
                    <td class="text-center">{{$value->purchaseorder_no_fk }}</td>
                    <td class="text-center">{{$value->challan_no}}</td>
                    <td>{{$value->serviceunit_name}}</td>
                    <td>{{$value->supplier_name}}</td>
                    <td class="text-right">{{number_format($value->grnmst_amnt,2,'.','')}}</td>
                    <td class="text-right">{{number_format($value->grnrtn_amt,2,'.','')}}</td>
                    <td class="text-right">{{number_format($value->payable_amnt,2,'.','')}}</td>
                    <td class="text-center">
                        @if($value->approval_ind ==1)
                        <strong> Approved</strong>
                        @else
                        <strong> Pending</strong>
                        @endif
                    </td>
                </tr>
                @php
                $receive_amt +=$value->grnmst_amnt;
                $return_amt +=$value->grnrtn_amt;
                $current_amt +=$value->payable_amnt;
                @endphp
                @endforeach
                <tr>
                    <td class="text-right" colspan="8"><strong>Sub-Total =</strong></td>
                    <td class="text-right">{{number_format($receive_amt,2,'.','')}}</td>
                    <td class="text-right">{{number_format($return_amt,2,'.','')}}</td>
                    <td class="text-right">{{number_format($current_amt,2,'.','')}}</td>
                    <td></td>
                </tr>
                @php
                $total_receive_amt +=$receive_amt;
                $total_return_amt +=$return_amt;
                $total_current_amt +=$current_amt;
                @endphp
                @endforeach
                @endif
            </tbody>
            <tfoot>
                <tr>
                    <td class="text-right" colspan="8"><strong>Grand-Total =</strong></td>
                    <td class="text-right">{{number_format($total_receive_amt,2,'.','')}}</td>
                    <td class="text-right">{{number_format($total_return_amt,2,'.','')}}</td>
                    <td class="text-right">{{number_format($total_current_amt,2,'.','')}}</td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
    </div>

</body>

</html>