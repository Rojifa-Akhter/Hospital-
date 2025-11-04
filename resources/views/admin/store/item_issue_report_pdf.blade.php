@php
    $po_hospital_details = DB::table('WSEC_HOSPITAL')->first();
@endphp
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Medical Category Print</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="" />
    <!-- custom style -->
    {{-- <link rel="stylesheet" href="{{ public_path() . '/css/colors.css' }}" media="all"> --}}

    <style>
        @page {
            margin: .5cm .6cm;
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
        .Medical_Category  th ,  .Medical_Category td {
            padding: 5px;
        }
    </style>
</head>

<body>
    <header>
        <table style="width: 100%; border:none;" class="signature">
            <tr>
                <td style="width: 15%; border:none;">
                    <img class="hospital-logo" src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}" width="60" alt="">
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

    <footer style="position: fixed;">
        <div class="footer">
            <div class="container">
                <table style="width: 100%; padding:3px; margin: 0;border:none;">
                    <tr>
                        <td style="font-size: 9px; text-align:left;border:none;">Print Date & Time: <strong>
                                @php
                                    $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
                                    $date = $dt->format('g:i A');
                                @endphp
                                {{ date('d/m/Y') }} {{ $date }}
                            </strong> Printed By: <strong>{{ Session::get('user.ses_user_name') }}</strong></td>
                        <td style="font-size: 9px; text-align: right; border:none;"><strong>Powered By - H360 [NextGen]
                            </strong></td>

                    </tr>
                </table>
            </div>
        </div>
    </footer>

    <main>

        <div class="wrapper">
            <section id="prescription">
                <div class="container">
                    <p style="width:100%; text-align: center; margin-bottom:20px;">
                        <h3> Item Issue Report</h3>
                        <h4>{{!empty($stocks) && $store_id !="" ?'Main Store : '. $stocks[0]->to_store :''}}{{!empty($stocks) && $sub_store_id !="" ?'Sub Store : '. $stocks[0]->to_store :''}}{{ $from_date !="" ?' , From Date :'.  date('d/m/Y',strtotime($from_date)) :''}}{{ $to_date !="" ?' , To Date : ' . date('d/m/Y',strtotime($to_date)) :''}}</h4>
                    </p>

                    <div>
                        <table class="Medical_Category  m-0" width="100%">
                            <thead class="bg-black" style="background-color: rgb(187, 183, 183);">
                                <tr>
                                    <th style="text-align:center " scope="col">Sl.</th>
                                    <th style="text-align:center " scope="col">Indent No</th>
                                    <th style="text-align:left " scope="col">Indent By</th>
                                    <th style="text-align:left " scope="col">Indent Date</th>
                                    <th style="text-align:left " scope="col">Issue Date</th>
                                    <th style="text-align:left " scope="col">Receive By</th>
                                    <th style="text-align:left " scope="col">Receive Date & Time</th>
                                    <th style="text-align:left " scope="col">Item Name</th>
                                    <th style="text-align:center " scope="col">Uom </th>
                                    <th style="text-align:center " scope="col">Issue Qty</th>
                                    <th style="text-align:right " scope="col">Rate</th>
                                    <th style="text-align:right " scope="col">Cost Price</th>
                                    <th style="text-align:right " scope="col">sales price</th>
                                    <th style="text-align:left " scope="col">Issued Store </th>
                                </tr>
                            </thead>
                            <tbody>

                                @if ( !empty($stocks))
                                @foreach ($stocks as $stock)
                                <tr>
                                    <td style="text-align:center">{{ $loop->iteration }}</td>
                                    <td style="text-align:center">{{ $stock->inv_requisition_no_pk }}</td>
                                    <td style="text-align:left">{{ $stock->req_by_name }}</td>
                                    <td style="text-align:left">{{ $stock->req_at !="" ? date('d/m/Y h:i a',strtotime($stock->req_at)) :'' }}</td>
                                    <td style="text-align:left">{{ $stock->issue_at !="" ? date('d/m/Y h:i a',strtotime($stock->issue_at)) :'' }}</td>
                                    <td style="text-align:left">{{$stock->recv_by_name}}</td>
                                    <td style="text-align:left">{{ $stock->recv_at !="" ? date('d/m/Y h:i a',strtotime($stock->recv_at)) :''   }}</td>
                                    <td style="text-align:left">{{ $stock->item_name }}</td>
                                    <td style="text-align:center">{{ $stock->req_uom_name }}</td>
                                    <td style="text-align:center">{{ number_format($stock->issue_quantity, 2) }}</td>
                                    <td style="text-align:right">{{$stock->purchase_price}}</td>
                                    <td style="text-align:right">{{$stock->purchase_price}}</td>
                                    <td style="text-align:right">{{$stock->sales_price}}</td>
                                    <td style="text-align:left">{{ $stock->from_store }}</td>
                                </tr>

                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>




                </div>
            </section>
        </div>
    </main>
</body>

</html>