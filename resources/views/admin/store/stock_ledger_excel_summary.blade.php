<style>
    @page {
        margin: 1cm 0.3cm;
        /*width: 450px;*/
        padding: 8px;
    }

    body {
        /*margin-top: 5.5cm;*/
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
    }

    .hospital-logo-info .hospital_info .hospital-address {
        font-weight: 500;
        display: block;
        line-height: 1.2;
    }

    .hospital-logo-info .hospital_info .hospital-contact {
        font-weight: 500;
        display: block;
        line-height: 1.2;
        width: 480px;
    }

    .hospital_info {
        margin-left: 10px;
    }

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

<div class="row mb-10">

    <table class="w-100">
        <tr>
            <td colspan="2" class="text-center border-0">
                <span class="text-uppercase title">Current MedIcine Stock Summary
                </span>
            </td>
            <!-- <td class="text-right border-0">
                Date: {{ date('d/m/Y') }}
            </td> -->
        </tr>
    </table>
</div>



<div>

    <table class="Medical_Category  m-0" width="100%" border="1">
        <thead class="bg-black" style="background-color: rgb(187, 183, 183);">
            <tr>
                <th class="text-center ">SL#</th>
                <th class="text-left ">Supplier Name</th>
                <th class="text-center ">Cur. Stock</th>
                <th class="text-right ">Total Purchase Price</th>
            </tr>
        </thead>
     
        @if (!empty($stocks_summary))
 
        <tbody>
            @php
            $subTotal = 0;
            $purchase_total = 0;
            $gross_purchase_total = 0;
            @endphp
            @foreach ($stocks_summary as $stock)
            <tr>
                <td style="padding:5px;text-align:center">
                    {{ $loop->iteration }}
                </td>
                <td style="padding:5px;text-align:left">
                    {{ $stock->supplier_name }}
                </td>
                <td style="padding:5px;text-align:center">
                    {{ $stock->current_stock }}
                </td>
                <td style="padding:5px;text-align:right">
                    {{ number_format($stock->total_price , 2, '.', ',') }}
                </td>
            </tr>
            @php
            $subTotal += $stock->current_stock;
            $gross_purchase_total += $stock->total_price ;
            @endphp
           
            @endforeach
           
        </tbody>

        <tfoot>
            <tr>
                <td colspan="2"><strong>Sub-total</strong></td>
                <td style="text-align:center"> <strong> {{ number_format($subTotal , 2, '.', ',') }} </strong></td>
                <td style="text-align:right"> <strong> {{ number_format($gross_purchase_total, 2, '.', ',') }} </strong></td>

            </tr>
        </tfoot>
        @endif
    </table>
</div>