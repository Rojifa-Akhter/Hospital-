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
        margin-top: 2cm;
        margin-left: .3cm;
        margin-right: .3cm;
        margin-bottom: 2cm;
        font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
        font-size: 9px;
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
    }

    td {
        border-bottom: 1px solid #222;
        border-right: 1px solid #222;
    }

    table td:last-child {
        border-right: 0px solid transparent;
    }

    th {
        border-top: 1px solid #222;
    }
</style>

@if($print_type == 'PDF')
    <header>
        <table style="width: 100%; border:none;" class="signature">
            <tr>
                <td style="width: 15%; border:none;">
                    <img class="hospital-logo"
                        src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}"
                        width="60" alt="">
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

    <div class="signature_">
        <table style="width: 100%; border:none;">
            <tr style=" ">
                <td style="text-align:left; border:none;">
                    <span style="padding:5px; border-top: black solid 1px;"> Employee Signature
                    </span>
                </td>
                <td style="text-align:right; border:none;">
                    <span style="padding:5px; border-top: black solid 1px;"> Approved By </span>
                </td>
            </tr>
        </table>
    </div>

    <footer style="position: fixed;">
        <div class="footer">
            <div class="container">
                <table style="width: 100%; padding:3px; margin: 0;border:none;">
                    <tr>
                        <td style="font-size: 9px; text-align:left;border:none;">Print Date & Time: <strong>
                                <?php
                                $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
                                $date = $dt->format('g:i A');
                                ?>
                                {{ date('d/m/Y') }} {{ $date }}
                            </strong> Printed By: <strong>{{ Session::get('user.ses_user_name') }}</strong></td>
                        <td style="font-size: 9px; text-align: right; border:none;"><strong>Powered By - H360
                                [NextGen]
                            </strong></td>

                    </tr>
                </table>
            </div>
        </div>
    </footer>
@endif

<div style="text-align: center; padding:5px">
    {{-- <strong> BIN Card - From date: {{ $from_date }}, To date: {{ $to_date }}</strong> --}}
</div>

{{-- <table width="100%">
    <tbody>
        <tr>
            @if ($from_date != '' && $to_date != '')
                <th style="text-align: left ;border:none;padding:5px;width:100px"> From date </th>
                <td style="text-align: left ;border:none"> : {{ $from_date }}, <strong> To date </strong> : {{ $to_date }}</td>            @elseif ($from_date != '')
                <th style="text-align: left ;border:none;padding:5px;width:100px"> Date</th>
                <td style="text-align: left ;border:none"> : {{ $from_date }}</td>
            @endif
        </tr>
    </tbody>
</table> --}}

<table style="width:100%;border-collapse:collapse;" cellpadding="1" cellspacing="0" border="1">
    <thead>
        <tr>
            <th class="text-center" style="width: 20%;">Date</th>
            <th class="text-center" style="width: 40%;">Transaction Detail</th>
            <th class="text-left" style="width: 10%;">Opening Qty</th>
            <th class="text-left" style="width: 10%;">Issued Qty</th>
            <th class="text-left" style="width: 10%;">Received Qty</th>
            <th class="text-center" style="width: 10%;">Balance Qty</th>
        </tr>
    </thead>
    <tbody>
        @if (!empty($items))
            @foreach($items as $idx => $item)
                @foreach($item as $key => $row)
                    <tr>
                        <td colspan="6"><b>Item: {{ $idx }}</b></td>
                    </tr>
                    <tr>
                        <td colspan="6"><b>Store: {{ $key }}</b></td>
                    </tr>

                    {{-- @php
                        $subTotalOpBal = $subTotalStockOut = $subTotalStockIn = $subTotalClBal = 0;
                    @endphp --}}
                    <?php  
                    $total_op_bal = 0;
                    $total_stock_out = 0;
                    $total_stock_in = 0;
                    $total_cl_bal = 0;
                    ?>
                    
                    @foreach($row as $i => $data)
                        {{-- @php
                            $subTotalOpBal += $data->op_bal;
                            $subTotalStockOut += $data->stock_out;
                            $subTotalStockIn += $data->stock_in;
                            $subTotalClBal += $data->cl_bal;
                        @endphp --}}
                        <tr>
                            <td style="text-align:center">{{ date('d/m/Y h:iA', strtotime($data->tran_date)) }}</td>
                            <td style="text-align:left">{{ $data->tran_details }}</td>
                            <td style="text-align:center" width="5%">{{ $data->op_bal }}</td>
                            <td style="text-align:center" width="5%">{{ $data->stock_out }}</td>
                            <td style="text-align:center" width="5%">{{ $data->stock_in }}</td>
                            <td style="text-align:center" width="5%">{{ $data->cl_bal }}</td>
                        </tr>
                        <?php
                        $total_op_bal += $data->op_bal;
                        $total_stock_out += $data->stock_out;
                        $total_stock_in += $data->stock_in;
                        $total_cl_bal += $data->cl_bal;
                    ?>
                    @endforeach

                    {{-- <tr>
                        <td colspan="2" style="text-align:right">Sub Total</td>
                        <td style="text-align:center">{{ $subTotalOpBal }}</td>
                        <td style="text-align:center">{{ $subTotalStockOut }}</td>
                        <td style="text-align:center">{{ $subTotalStockIn }}</td>
                        <td style="text-align:center">{{ $subTotalClBal }}</td>
                    </tr>
                    <tr>
                        <td colspan="2" style="text-align:right">Total</td>
                        <td style="text-align:center">{{ $subTotalOpBal }}</td>
                        <td style="text-align:center">{{ $subTotalStockOut }}</td>
                        <td style="text-align:center">{{ $subTotalStockIn }}</td>
                        <td style="text-align:center">{{ $subTotalClBal }}</td>
                    </tr> --}}
                    <tr>
                        <td colspan="2" class="text-right" style="text-align:right"><strong>Total=</strong></td>
                        <td style="text-align:center">{{$total_op_bal}}</td>
                        <td style="text-align:center">{{$total_stock_out}}</td>
                        <td style="text-align:center">{{$total_stock_in}}</td>
                        <td style="text-align:center">{{$total_cl_bal}}</td>
                    </tr>
                @endforeach        
            @endforeach
        @endif
    </tbody>
</table>
