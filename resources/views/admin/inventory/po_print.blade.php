<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Lp Report</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    {{-- <link rel="stylesheet" href="{{ public_path().'/css/print.css' }}" media="print"> --}}
    <style>
        @page {
            margin: .5cm 0cm;
            width: 100%;
            height: 100%
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
            height: 2.3cm;
            border-bottom: 1px solid;
            padding: 0 1cm;
        }

        header img {
            /*width: 80px;*/
        }

        /** Define now the real margins of every page in the PDF **/
        body {
            margin-top: 4cm;
            margin-left: .8cm;
            margin-right: .8cm;
            margin-bottom: 1cm;
            font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
            font-size: 11px;
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

        tbody tr td {
            padding-top: 10px;
            padding-bottom: 10px;
        }

        table tr td .table-td2 {
            text-align: right;
        }

        /* .sum {
            text-align: right;
        }  */

    </style>
</head>

<body>
    <header>
        <table style="width: 100%;">
            <tr>
                <td style="width: 10%;">
                    <img class="hospital-logo" src="{{ asset('images/kbmh.jpg') }}" width="60" alt="">
                </td>
                <td style=" text-align:right; width: 50%;">
                    <img src="data:image/png;base64, {{ $barcode_no }} " width="100" />
                </td>
            </tr>

        </table>
        <div style="width: 100%;">
            <div style=" text-align:center; margin-bottom:5px; margin-top:15px  ">
                <span class="report-name" style="width:70%; border:solid black 1px; padding:10px;  "> Purchase Order
                    Details</span>
            </div>
            <div style=" text-align:center;  width:100%; margin-bottom:5px" class="mb-2">


                <span class="report-date"><strong> Date: </strong> {{ date('m/d/Y') }}


                </span>
            </div>
        </div>
    </header>
    <main>
        <div class="wrapper">

            <section id="lp-items">
                <div class="container">



                    <table width="100%">

                        <tr class="table-tr">
                            <td class="table-td" colspan="" scope="">
                                <strong>Company</strong>
                                <strong>name</strong> : NExtGenIt <br>
                                <strong>Address</strong> : Dhaka <br>
                                <strong>Contact</strong> : 019747744 <br>
                                <strong>Email</strong> : nextgen@gmail.com <br>
                            </td>
                            <td class="table-td2" colspan="" scope="" style="text-align: right;">
                                <strong>Supplier</strong>
                                <strong>name</strong> : Mizan <br>
                                <strong>Address</strong> : Dhaka <br>
                                <strong>Contact</strong> : 019747744 <br>
                                <strong>Email</strong> : mizan@gmail.com <br>
                            </td>
                        </tr>


                    </table>


                </div>

                <table style="width:100%;border-collapse:collapse;" cellpadding="1" cellspacing="0" border="1">
                    <thead style="">
                        <tr class="table-tr" style="background-color: #E3E3E3;">
                            <td class="table-td" " scope=" col" style="text-align: center;">
                                <strong>SL</strong>
                            </td>
                            <td class="table-td" " scope=" col" style="text-align: center;">
                                <strong>Item No</strong>
                            </td>
                            <td class="table-td" " scope=" col" style="text-align: center;"><strong>
                                    Description</strong></td>
                            <td class="table-td" " scope=" col" style="text-align: center;">
                                <strong>QTY</strong>
                            </td>
                            <td class="table-td" " scope=" col" style="text-align: center;">
                                <strong>Unit Price</strong>
                            </td>
                            <td class="table-td" " scope=" col" style="text-align: center;">
                                <strong>Total</strong>
                            </td>

                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $subtotal = 0;
                        @endphp
                        @if (isset($list))
                            @foreach ($list as $value)
                                @php
                                    $total = $value->entry_qty * $value->item_rate;
                                    $subtotal = $subtotal + $total;
                                @endphp


                                <tr class="table-tr">
                                    <td class="table-td" style="text-align: center;" scope="col">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td class="table-td" style="text-align: center;" scope="col">
                                        {{ $value->item_no_fk }}
                                    </td>
                                    <td class="table-td" style="text-align: left;" scope="col">
                                        {{ $value->remarks_text }}
                                    </td>
                                    <td class="table-td" style="text-align: center;" scope="col">
                                        {{ $value->entry_qty }}
                                    </td>
                                    <td class="table-td" style="text-align: right;" scope="col">
                                        {{ $value->item_rate }}
                                    </td>
                                    <td class="table-td" style="text-align: right;" scope="col">
                                        {{ $total }}
                                    </td>
                                </tr>
                            @endforeach
                        @endif

                        <tr style="text-align: right;">
                            <td colspan="5">

                                <strong>Subtotal</strong>

                                <br>
                                <strong>Discount</strong>

                                <br>
                                <strong>Subtotal Less Discount</strong>


                                <br>

                                <strong>Tax Rate</strong>

                                <br>
                                <strong>Total Tax</strong>


                                <br>
                                <strong>Shipping</strong>

                                <br>
                                <strong>Others</strong>


                                <br>
                                <strong>Total</strong>


                            </td>
                            <td>
                                <div style="border-bottom: gray solid 1px;"> {{ $subtotal }}</div>
                                <div style="border-bottom: gray solid 1px;"> 00</div>
                                <div style="border-bottom: gray solid 1px;"> 00</div>
                                <div style="border-bottom: gray solid 1px;"> 0%</div>
                                <div style="border-bottom: gray solid 1px;"> 00</div>
                                <div style="border-bottom: gray solid 1px;"> 00</div>
                                <div style="border-bottom: gray solid 1px;"> 00</div>
                                <div style="background-color:  #E3E3E3 ;"> {{ $subtotal }}</div>
                            </td>
                        </tr>

                    </tbody>


                </table>

        </div>
        </section>
        </div>
    </main>
    <div class="signature " style=" margin-top:40px; ">
        <spam style="border-top: gray solid 1px; ">
            Authorized Signature
        </spam>
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
                            </strong></td>
                        <td style="font-size: 9px; text-align: right;"><strong>Powered By - H360 [NextGenIT] </strong>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </footer>
</body>

</html>
