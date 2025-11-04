
<style>
  /*  @page {
        margin: 1cm 0.3cm;
        /!*width: 450px;*!/
        padding:8px;
    }*/
  @page { margin-top: 150px; margin-bottom: 120px}
    .header { position: fixed; left: 0px; top: -140px; right: 0px; height: 150px; text-align: center;}
  /*#footer { position: fixed; left: 0px; bottom: 0; right: 0px; }*/
  footer {
      position: fixed;

      left: 0;
      right: 0;
      height: 3cm;
      text-align: center;
      font-size: 9px;
      bottom: -200px;
  }
    body {
        /*margin-top: 5.5cm;*/
        margin-left: .5cm;
        margin-right: .5cm;
        /*margin-bottom: 3.5cm;*/
        font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
        font-size: 11px;
    }

    .bg-black{
        background-color: #222;
        color: #fff;
    }


    table{
        border-collapse:collapse;
    }

    table tr td,
    table tr th{
        font-size: 11px;
        border:1px solid #222;
        font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
        padding: 2px;
        /*border-width: thin;*/
    }
    .border-0{
        border:0px;
    }
    .text-center{
        text-align: center!important;
    }
    .text-left{
        text-align: left!important;
    }
    .text-right{
        text-align: right!important;
    }
    .w-100{
        width: 100%;
    }

    .w-5{
        width: 5%;
    }
    .w-10{
        width: 10%;
    }

    .w-25{
        width: 25%;
    }

    .w-50{
        width: 50%;
    }
    .w-100{
        width: 100%;
    }
    .mb-10{margin-bottom: 10px;}
    .mt-5 { margin-top: 5px; }
    .mt-10 { margin-top: 10px; }
    .mt-20 { margin-top: 20px; }
    .mb-0{ margin-bottom: 0; }
    .mb-15{ margin-bottom: 15px; }
    .pb-0{ padding-bottom: 0; }


    .logo{
        width: 80px;
        display: inline-block;
    }
    .d-flex{
        display: flex;
    }

    .align-items-center{
        align-items: center;
    }

    .hospital-names {
        margin-bottom: 0;
        font-size: 20px;
        padding-bottom: 0;
    }

    .hospital-logo-info .hospital_info .hospital-address{
        font-weight: 500;
        display: block;
        line-height: 1.2;
    }

    .hospital-logo-info .hospital_info .hospital-contact{
        font-weight: 500;
        display: block;
        line-height: 1.2;
        width: 480px;
    }

    .hospital_info{
        margin-left: 10px;
    }
    .text-uppercase{
        text-transform: uppercase; 
    }
    .title{
        /*background-color: #444;*/
        /*display: inline-block;*/
        font-size: 14px;
        color: #000;
        padding: 5px 10px;
        border-radius: 3px;
        font-weight: bold;
    }
</style>


<div class="header" style="width: 100%; margin-top: 0px; margin-bottom: 10px;">
    <table class="w-100 " style="border-bottom: 1px solid #222;">
        <tr>
            <td class="text-right w-25 border-0">
                <img class="logo" src="{{ public_path().'/img/fav-icons/logo-icon.png' }}">
            </td>
            <td class="text-center w-50 border-0">
                <div class="information mb-15">
                    <h3 class="hospital-names">BAF Hospitals</h3>
                    <div class="hospital-address">Bir Uttam Ziaur Rahman Rd, Dhaka 1206</div>
                    <div class="hospital-contact">TEL : DMO-8750011 Ext-3322, Information: 8750011 Ext-4999, </div>
                    <div class="hospital-contact">DDO-8750011 Ext-48781, Sena sastho seba</div>
                </div>
            </td>
            <td class="text-left w-25 border-0"></td>
        </tr>
    </table>

    <div class="row mb-10">
        <table class="w-100">
            <tr>
                <td colspan="2" class="text-center border-0">
                    <span class="text-uppercase title">Current Medecine Stock ({{ $type == 'store'?'Store Wise':'Item Wise' }}) </span>
                </td>
                <td class="text-right border-0">
                    Date: {{ date('d/m/Y') }}
                </td>
            </tr>
        </table>
    </div>
</div>

<footer >
    <table style="width: 100%; border-top: 1px solid; border-bottom: none">
        <tr>
            <td width="37%">Printing Date & Time : {{ date("d/m/Y h:i:s a") }}</td>
            <td></td>
            <td width="33%" style="text-align: right;">Powered By - Logic Software Ltd.</td>
        </tr>
    </table>
</footer>


@if(!empty($type) && $type == 'store' && !empty($stocks))

    @foreach($stocks as $stock)
        @php
            $subTotal = 0
        @endphp
        <div>
            <table class="w-100" >
                <tr>
                    <td class="text-left border-0">
                        Store Name: {{ $stock['store_name'] }}
                    </td>

                    <td class="text-right border-0">
                        Total Items: {{ !empty($stock['stocks'])? count($stock['stocks']): 0 }}
                    </td>
                </tr>
            </table>
            <table class="w-100 m-0" border="1">
                <thead class="bg-black">
                    <tr>
                        <th class="text-center w-5">SL#</th>
                        <th class="text-left w-10">PVMS</th>
                        <th class="text-left w-5">Pack Type</th>
                        <th class="text-left">Item Name</th>
                        <th class="text-left w-5">UOM</th>
                        <th class="text-right w-10">Re-Order</th>
                        <th class="text-right w-10">Cur. Stock</th>
                        <th class="text-left w-10">Status</th>
                    </tr>
                </thead>
                <tbody>
                @if(!empty($stock['stocks']))
                    @php
                        $totalItems = !empty($stock['stocks'])?count($stock['stocks']):0;
                    @endphp
                    @foreach($stock['stocks'] as $stock)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="text-left">{{ $stock->pvms_no }}</td>
                            <td class="text-left">{{ $stock->pack_type }}</td>
                            <td class="text-left">{{ $stock->item_name }}</td>
                            <td class="text-left">{{ $stock->uom_name }}</td>
                            <td class="text-right">{{ $stock->re_order_level }}</td>
                            <td class="text-right">{{ $stock->current_stock }}</td>
                            <td class="text-left"><span class="badge bg-danger text-white">{{ $stock->stock_status_text }}</span></td>
                        </tr>
                        @php
                            $subTotal += $stock->current_stock;
                        @endphp
                    @endforeach
                    <tr>
                        <td colspan="4" ></td>

                        <td colspan="2"><strong>Sub-total</strong></td>
                        <td class="text-right">{{ $subTotal }}</td>
                        <td style="border: none"></td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>
    @endforeach

@endif

@if(!empty($type) && $type == 'item' && !empty($stocks))
        <div class="row">
            <table class=" m-0" border="1">
                <thead class="bg-black">
                <tr>
                    <th class="text-center w-5">SL#</th>
                    <th class="text-left w-10">PVMS</th>
                    <th class="text-left w-5">Pack Type</th>
                    <th class="text-left">Item Name</th>
                    <th class="text-left w-5">UOM</th>
                    <th class="text-right w-10">Re-Order</th>
                    <th class="text-right w-10">Total Cur. Stock</th>
                    {{--<th class="text-left w-10">Status</th>--}}
                </tr>
                </thead>
                <tbody>
                @foreach($stocks as $stock)

                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="text-left">{{ $stock['item_name'] }}</td>
                            <td class="text-left">{{ $stock['pack_type'] }}</td>
                            <td class="text-left">{{ $stock['item_name'] }}</td>
                            <td class="text-left">{{ $stock['uom_name'] }}</td>
                            <td class="text-right">{{ $stock['re_order_level'] }}</td>
                            <td class="text-right">
                                {{ array_sum($stock['current_stocks']) }}
                            </td>

                        </tr>

                @endforeach
                </tbody>
            </table>
        </div>


@endif


