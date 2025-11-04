<style>
    @page {
        /*margin: 0.5cm 0.3cm;*/
        /*/!*width: 450px;*!/*/
        /*padding:8px;*/
    }

    @page {
        margin-top: 150px;
        margin-bottom: 100px
    }

    .header {
        position: fixed;
        left: 0px;
        top: -130px;
        right: 0px;
        height: 100px;
        text-align: center;
        border-bottom: 1px solid #007bff
    }

    .footer {
        position: fixed;
        left: 0px;
        bottom: -50px;
        right: 0px;
    }

    /*        footer {
            position: fixed;
            left: 0;
            right: 0;
            height: 3cm;
            text-align: center;
            font-size: 9px;
            bottom: -200px;
            }*/
    body {
        /*margin-top: 150px;*/
        margin-left: .5cm;
        margin-right: .5cm;
        /*margin-bottom: 3.5cm;*/
        font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
        font-size: 11px;
    }

    .bg-black {
        background-color: #222;
        color: #fff;
    }


    table {
        border-collapse: collapse;

    }

    table tr td,
    table tr th {
        font-size: 11px;
        border: 1px solid #222;
        font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
        padding: 2px;
        /*border-width: thin;*/
    }

    .border-0 {
        border: 0px;
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

    .w-100 {
        width: 100%;
    }

    .w-5 {
        width: 5%;
    }

    .w-10 {
        width: 10%;
    }

    .w-25 {
        width: 25%;
    }

    .w-50 {
        width: 50%;
    }

    .w-75 {
        width: 75%;
    }

    .w-100 {
        width: 100%;
    }

    .mb-10 {
        margin-bottom: 10px;
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

    .mb-15 {
        margin-bottom: 15px;
    }

    .pb-0 {
        padding-bottom: 0;
    }


    .logo {
        width: 80px;
        display: inline-block;
        float: right;
    }

    .d-flex {
        display: flex;
    }

    .align-items-center {
        align-items: center;
    }

    .hospital-names {
        margin-bottom: 0;
        font-size: 20px;
        padding-bottom: 0;
        color: #007bff
    }

    .information .hospital-address {
        display: block;
        font-size: 12px;
        line-height: 1.2;
        color: #007bff
    }

    .information .hospital-contact {
        display: block;
        font-size: 12px;
        line-height: 1.2;
        width: 480px;
        color: #007bff
    }

    /*    .information{
        margin-left: 10px;
        }*/
    .text-uppercase {
        text-transform: uppercase;
    }

    .title {
        /*background-color: #444;*/
        /*display: inline-block;*/
        font-size: 14px;
        color: #000;
        padding: 5px 10px;
        border-radius: 3px;
        font-weight: bold;
    }
</style>
<?php

$po_hospital_details = DB::table('WSEC_HOSPITAL')->first();

?>


<div class="header">
    <table class="w-100">
        <tr>
            <td class="text-right w-25 border-0">
                <img class="logo"
                    src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}">
            </td>
            <td class="text-center w-50 border-0">
                <div class="information mb-15">
                    <h3 class="hospital-names">
                        {{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }}
                    </h3>
                    <div class="hospital-address">
                        {{ isset($po_hospital_details->addrress1) ? $po_hospital_details->addrress1 : '' }}
                    </div>
                    {{-- <div class="hospital-contact">TEL : DMO-8750011 Ext-3322, Information: 8750011 Ext-4999, </div> --}}
                    <div class="hospital-contact">PHONE:
                        {{ isset($po_hospital_details->telephone1) ? $po_hospital_details->telephone1 : '' }}</div>
                </div>
            </td>
            <td class="text-left w-25 border-0"></td>
        </tr>
    </table>
    {{-- <table style="width: 100%;" class="signature">
            <tr>
                <td style="width: 15%;">
                    <img class="hospital-logo" src="{{ asset('images/uploads/hospital_images/'.$po_hospital_details->logo) }}" width="60" alt="">
                </td>
                <td style="text-align:center;">
                    <span
                    style="font-size: 15px;"> <strong> {{isset($po_hospital_details->hospital_name )? $po_hospital_details->hospital_name : ""}} </strong></span>
                    <br>
                    Address:
                    <span>  {{ isset($po_hospital_details->addrress1) ? $po_hospital_details->addrress1 : ""}}</span><br>
                    Phone No:
                    <span>  {{isset($po_hospital_details->telephone1) ? $po_hospital_details->telephone1 : "" }}</span>
                </td>
            </tr>
        </table> --}}

</div>




<h4 style="">Medicine Transaction Ledger</h4>
<div class="row">
    <div class="col-md-8">
        <strong>Item Name:</strong> {{ $item_name }} <br>
        <strong>Store Name:</strong> {{ $store_name }} <br> {{-- <strong>Current Stock:</strong> {{ $current_stock }} <br> --}}
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <table class="w-100" border="1">
            <thead class="bg-black">
                <tr>
                    <th>SL#</th>
                    <th>Reference No</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Transaction Type</th>
                    <th>Transaction Qty</th>
                    <th>Stock Position</th>
                    <th>Unit Price</th>
                    @if (!empty($transactions))
                        @foreach ($transactions as $trans)
                            @if (strtoupper($trans->trans_type_iss_rcv) == 'GRN')
                                <th>Supplier Name</th>
                            @endif
                        @endforeach
                    @endif
                </tr>
            </thead>
            <tbody>
                @if (!empty($transactions))
                    @php $stock_position = $opening_qty; @endphp
                    @foreach ($transactions as $trans)
                        @php
                            if (
                                strtoupper($trans->trans_type_iss_rcv) == 'ISSUE' ||
                                strtoupper($trans->trans_type_iss_rcv) == 'RCVRTN' ||
                                strtoupper($trans->trans_type_iss_rcv) == 'DAMAGE' ||
                                strtoupper($trans->trans_type_iss_rcv) == 'EXPIRED' ||
                                strtoupper($trans->trans_type_iss_rcv) == 'TRANSOUT'
                            ) {
                                $stock_position = $stock_position - $trans->item_qty;
                            }

                            if (
                                strtoupper($trans->trans_type_iss_rcv) == 'RECEIVE' ||
                                strtoupper($trans->trans_type_iss_rcv) == 'OPEN' ||
                                strtoupper($trans->trans_type_iss_rcv) == 'ISSRTN' ||
                                strtoupper($trans->trans_type_iss_rcv) == 'TRANSIN'
                            ) {
                                $stock_position = $stock_position + $trans->item_qty;
                            }

                        @endphp

                        @php
                         $hospital_code = DB::table('WSEC_HOSPITAL')->first()->hospital_code;
                        @endphp

                        @if (!empty($trans->transref_no) && strtoupper($trans->trans_type) == 'GRN')
                            @php
                                $label = $hospital_code == 'KPJ' ? $trans->itemreceive_uid : $trans->transref_no;
                            @endphp
                        @else
                            $label = $trans->transref_no;
                        @endif
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="text-center">{{ $label }}</td>
                            <td class="text-left">{{ date('d/m/Y', strtotime($trans->trans_date)) }}</td>
                            <td class="text-left">{{ date('h:m:s a', strtotime($trans->trans_date)) }}</td>
                            <td class="text-left">{{ strtoupper($trans->trans_type_iss_rcv) }}</td>
                            <td class="text-right">{{ $trans->item_qty }}</td>
                            <td class="text-right">{{ $stock_position }}</td>
                            <td class="text-right">{{ $trans->cost_price }}</td>
                            @if (strtoupper($trans->trans_type_iss_rcv) == 'GRN')
                                <td class="text-right">{{ $trans->supplier_name }}</td>
                            @endif
                        </tr>
                    @endforeach

                @endif
            </tbody>
        </table>
    </div>
</div>



{{-- <footer style="position: fixed; ">
    <div class="footer">
        <div class="container">
            <table style="width: 100%; padding:3px; margin: 0;border:none;">
                <tr>
                    <td style="font-size: 9px; text-align:left;border:none;">Print Date & Time: <strong>

                            {{ date('d/m/Y') }} {{ $date }}
                        </strong> Printed By: <strong>{{ Session::get('user.ses_user_name') }}</strong></td>
                    <td style="font-size: 9px; text-align: right; border:none;"><strong>Powered By - H360 [NextGen]
                        </strong></td>

                </tr>
            </table>
        </div>
    </div>
</footer> --}}

<div class="footer">
    <table style="width: 100%; border-top: 1px solid;">
        <tr>
            <td class="border-0" width="37%"><strong> Printing Date & Time :</strong>
                ` <?php
                $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
                $date = $dt->format('g:i A');
                ?>
                {{ date('d/m/Y') }} {{ $date }}
                </strong> Printed By: <strong>{{ Session::get('user.ses_user_name') }}</strong></td>
            <td class="border-0" width="33%" style="text-align: right;">Powered By - H360 [NextGen]</td>
        </tr>
    </table>

</div>
