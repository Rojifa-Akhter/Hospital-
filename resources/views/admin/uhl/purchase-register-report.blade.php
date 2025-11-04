<style>
    .board_member_img {
        border: 1px solid black;
        width: 50px;
    }


    @page {
        margin: .5cm .6cm;
        width: 100%;
        height: 100%
    }

    #lp-items {
    width: 100%;
  }

  .container {
    max-width: 100%;
    padding: 0;
  }

  table {
    width: 100%;
    border-collapse: collapse;
  }

    @font-face {
        font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
        font-weight: normal;
        font-size: 10px;
        font-style: normal;
        font-variant: normal;
        src: url("font url");
    }


    /** Define the header rules **/
    header {
        position: fixed;
        top: 0;
        /* height: 2cm; */
        padding: 0 1cm;
    }

    header img {
        /*width: 80px;*/
    }

    /** Define now the real margins of every page in the PDF **/
    body {
        margin-top: 2.5cm;
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
        bottom: 2.6cm;
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
</style>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Report</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
</head>

<body>
    <header>
       <table style="width: 100%;" class="signature">
            <tr>
                <td style="width: 10%; text-align: center;">
                    <img class="hospital-logo"
                        src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}"
                        width="60" alt="">
                </td>
                <td style="text-align: center;">
                    <span style="font-size: 15px;"> <strong> 
                            {{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }}
                        </strong></span> <br>
                    Address: 
                    <span>{{ isset($po_hospital_details->addrress1) ? $po_hospital_details->addrress1 : '' }}</span>
                    <br>
                    Phone No:
                    <span>{{ isset($po_hospital_details->telephone1) ? $po_hospital_details->telephone1 : '' }}</span>
                    <br>
                    <strong>Purchase Account Book</strong>
                    <br>
                    <strong style="margin-right: 5px;"> Date of: @if (!empty($d))
                        {{ date('d-m-Y', strtotime($d)) }}
                  
                    @endif</strong>
                </td>
            </tr>
        </table>

    </header>

    <div class="signature_">
        <div class="singature" style="margin-top: -70px;">
            <table style="width: 100%; border:none;">
            </table>
        </div>
    </div>

    <footer style="position: fixed;">
        <div class="footer">
            <div class="container">
                <table style="width: 100%; padding:3px; margin: 0">
                    <tr>
                        <td style="font-size: 9px; text-align:left;">Print Date: <strong>
                                @php
                                    date_default_timezone_set('Asia/Dhaka');
                                    $date = date('d/m/Y H:m:s');
                                @endphp
                                {{ $date }}
                            </strong> Printed By: <strong>{{ Session::get('user.ses_user_name') }}</strong></td>
                        <td style="font-size: 9px; text-align: right;"><strong>Powered By - H360 [NextGenIT]
                            </strong>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </footer>

    <main>
        <div class="wrapper">
            {{-- <div style="text-align:center; margin-bottom:20px; margin-left:90px; margin-top:15px;" class="mb-2">
                <h2 class="report-name" style="margin-right:112px;">Purchase Account Book</h2>
                <strong style="margin-right: 120px;"> Date of: @if (!empty($d))
                    {{ date('d-m-Y', strtotime($d)) }}
                @else
                    {{ '' }}
                @endif</strong>
            </div> --}}
           
            <section id="lp-items">
                <div class="container">
                    <table style="width: 100%;border-collapse:collapse;" cellpadding="1" cellspacing="0" border="1">
                        <thead>
                            <tr class="table-tr" style="background-color: #E3E3E3;">
                                <th rowspan="3" class="text-left" scope="col">SL No</th>
                                <th rowspan="3" class="text-left" scope="col">Date</th>
                                <th colspan="2" scope="col" style="text-align: center">Opening Balance of Input Stock</th>
                                <th colspan="14" scope="col" style="text-align: center">Purchased Stock</th>
                                <th colspan="2" scope="col" style="text-align: center">Closing Balance of Stock</th>
                                <th rowspan="3" scope="col" style="text-align: center">Comments</th>
                            </tr>

                            <tr class="table-tr2" style="background-color: #E3E3E3;">   
                                <th rowspan="2" style="text-align: center" scope="col">Qty (Unit)</th>
                                <th rowspan="2" style="text-align: center" scope="col">Value (Excluding All type of Taxes)</th>
                                <th rowspan="2" style="text-align: center" scope="col">Challan No/ Bill of entry No</th>
                                <th rowspan="2" style="text-align: center" scope="col">Date</th>
                                <th colspan="3" style="text-align: center" scope="col">Seller/Supplier</th>
                                <th rowspan="2" style="text-align: center" scope="col">Description</th>
                                <th rowspan="2" style="text-align: center" scope="col">Quantity</th>
                                <th rowspan="2" style="text-align: center" scope="col">Value (Excluding all type of taxes)</th>
                                <th rowspan="2" style="text-align: center" scope="col">Supplementary Duty( If Have)</th>
                                <th rowspan="2" style="text-align: center" scope="col">VAT</th>
                                <th colspan="2" style="text-align: center" scope="col">Total Stock Quty</th>
                                <th colspan="2" style="text-align: center" scope="col">Stock Consumption for Production / Process</th>
                                <th rowspan="2" style="text-align: center" scope="col">Quantity (Unit)</th>
                                <th rowspan="2" style="text-align: center" scope="col">Value (Excluding all type of taxes)</th>
                            </tr>

                            <tr class="table-tr" style="background-color: #E3E3E3;">
                                <th class="text-left" scope="col">Name</th>
                                <th class="text-left" scope="col">Address</th>
                                <th class="text-left" scope="col">Registered / Enlist / National ID NO</th>
                                <th class="text-left" scope="col">Qty (Unit)</th>
                                <th class="text-left" scope="col">Value (Excluding all type of taxes)</th>
                                <th class="text-left" scope="col">Qty (Unit)</th>
                                <th class="text-left" scope="col">Value (Excluding all type of taxes)</th>
                            </tr>

                        </thead>

                        <tbody>
                            <tr>
                                <td style="text-align: center">(1)</td>
                                <td style="text-align: center">(2)</td>
                                <td style="text-align: center">(3)</td>
                                <td style="text-align: center">(4)</td>
                                <td style="text-align: center">(5)</td>
                                <td style="text-align: center">(6)</td>
                                <td style="text-align: center">(7)</td>
                                <td style="text-align: center">(8)</td>
                                <td style="text-align: center">(9)</td>
                                <td style="text-align: center">(10)</td>
                                <td style="text-align: center">(11)</td>
                                <td style="text-align: center">(12)</td>
                                <td style="text-align: center">(13)</td>
                                <td style="text-align: center">(14)</td>
                                <td style="text-align: center">(15)=(3+11)</td>
                                <td style="text-align: center">(16)=(4+12)</td>
                                <td style="text-align: center">(17)</td>
                                <td style="text-align: center">(18)</td>
                                <td style="text-align: center">(19)=(15-17)</td>
                                <td style="text-align: center">(20)=(16-18)</td>
                                <td style="text-align: center">(21)</td>
                                </tr>

                     @if (!empty($data))
                         @foreach ($data as $value)
                         <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $value->challan_date ? date('d/m/Y', strtotime($value->challan_date)) : '' }}</td>
                            <td>{{ $value->opening_qty }}</td>
                            <td style="text-align: right;">{{ number_format($value->opening_qty * $value->opening_rate, 2) }}</td>
                            <td>{{ $value->challan_no }}</td>
                            <td>{{ $value->challan_date ? date('d/m/Y', strtotime($value->challan_date)) : '' }}</td>
                            <td>{{ $value->supplier_name }}</td>
                            <td>{{ $value->addr1 }}</td>
                            <td>{{ $value->supp_tin }}</td>
                            <td>{{ $value->item_name }}</td>
                            <td style="text-align: right;">{{ number_format($value->qty, 2) }}</td>
                            <td style="text-align: right;">{{ number_format($value->qty * $value->trade_price, 2) }}</td>
                            <td>-</td>
                            <td style="text-align: right;">{{ number_format($value->vat_amount_itm, 2) }}</td>
                            <td style="text-align: right;">{{ number_format($value->opening_qty + $value->qty,2) }}</td>
                            <td style="text-align: right;">{{ number_format($value->opening_qty * $value->opening_rate + $value->qty * $value->trade_price, 2)}}</td>
                            <td style="text-align: right;">{{ number_format($value->consumption_qty, 2) }}</td>
                            <td style="text-align: right;">{{ number_format($value->consumption_qty * $value->con_rate, 2) }}</td>
                            <td style="text-align: right;">{{ number_format(($value->opening_qty + $value->qty) - ($value->consumption_qty), 2) }}</td>
                            <td style="text-align: right;">{{ number_format(($value->opening_qty * $value->opening_rate + $value->qty * $value->trade_price) - ($value->consumption_qty * $value->con_rate), 2) }}</td>
                            <td>{{ $value->remarks }}</td>
                            </tr>
                         @endforeach
                     @endif
                                                
                       </tbody>
                    </table>
                </div>
            </section>
        </div>
    </main>
</body>

</html>
