<?php
$po_hospital_details = DB::table('WSEC_HOSPITAL')->first();
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Supplier Wise Summary Report</title>
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

        .text-center {
            text-align: center
        }

        .text-right {
            text-align: right
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
                                <?php
                                $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
                                $date = $dt->format('g:i A');
                                ?>
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
                    <div style="width:100%; text-align: center; margin-bottom:20px;">
                        <p style="width:100%;  margin-bottom:20px;">
                        <h3><u>Supplier Wise Purchase Summary Report </u></h3>
                        </p>
                        <p style="text-align: left;"> <strong>From :</strong> {{ $date_from }} <strong>To :</strong>
                            {{ $date_to }}
                        </p>
                    </div>


                    <div>

                        <table border="1" class="m-0" width="100%">
                            <thead class="bg-black" style="background-color: rgb(187, 183, 183);">
                                <tr class="bg-light-blue">
                                    <th class="text-center">SL#</th>
                                    <th class="text-center">Supplier</th>
                                    <th class="text-center">MRR No</th>
                                    <th class="text-center">MRR Date</th>
                                    {{-- <th  class="text-center">Card No.</th> --}}
                                    <th class="text-left">Inv No</th>
                                    <th class="text-center">Inv Date</th>
                                    <th class="text-right">Total Amt</th>
                                    <th class="text-right">Return Amt</th>
                                    <th class="text-right">Vat amt.</th>
                                    <th class="text-right">Spe.Disc</th>
                                    <th class="text-right">Net Amt</th>
                                </tr>
                            </thead>
                            <tbody>

                                @php
                                $sales_total = 0;
                                $sales_discount = 0;
                                $sales_vat = 0;
                                $net_sales = 0;
                                $return_amt_adj = 0;
                                $sub_sales_total = 0;
                                $sub_sales_discount = 0;
                                $sub_sales_vat = 0;
                                $sub_net_sales = 0;
                                $sub_return_amt_adj = 0;

                                $sup_vari1 = 'Test';
                                $sup_vari2 = 'Test';
                                $i = 0;
                                @endphp

                                @if (!empty($supplier_wise))
                                @foreach ($supplier_wise as $suppiler)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    @if ($sup_vari1 != $suppiler->supplier_name)
                                    @php
                                    $sup_vari1 = $suppiler->supplier_name;
                                    @endphp

                                    <td class="text-left" style="width: 100%">
                                        {{ $suppiler->supplier_name }}
                                    </td>
                                    @else
                                    @php
                                    $i++;
                                    @endphp
                                    <td></td>
                                    @endif

                                    <td class="text-center">
                                        {{ $suppiler->itemreceive_uid }}
                                    </td>
                                    <td class="text-center">
                                        {{ date('d/m/y', strtotime($suppiler->challan_date)) }}
                                    </td>

                                    {{-- <td class="text-left">{{$value->person_code}}</td> --}}
                                    <td class="text-left">
                                        {{ $suppiler->challan_no }}
                                    </td>

                                    <td class="text-center">
                                        {{ date('d/m/y', strtotime($suppiler->challan_date)) }}
                                    </td>

                                    <td class="text-right">
                                        {{ number_format(($suppiler->total_received_amount + $suppiler->discount_amount +$suppiler->return_amt_adj) - $suppiler->vat_amount, 2, '.', '') }}
                                    </td>

                                    <td class="text-right">
                                        {{ number_format($suppiler->return_amt_adj, 2, '.', '') }}
                                    </td>
                                    <td class="text-right">
                                        {{ number_format($suppiler->vat_amount, 2, '.', '') }}
                                    </td>
                                    <td class="text-right">
                                        {{ number_format($suppiler->discount_amount, 2, '.', '') }}
                                    </td>

                                    <td class="text-right">
                                        {{ number_format($suppiler->total_received_amount , 2, '.', '') }}
                                    </td>
                                </tr>
                                @if ($sup_vari2 != $suppiler->supplier_name)
                                @if ($supplier_wise_arr[$suppiler->supplier_name] == $i + 1)
                                @php
                                $i = 0;
                                $sup_vari2 = $suppiler->supplier_name;
                                // dd($supplier_wise_total[$suppiler->supplier_name]);
                                @endphp
                                @if ($supplier_wise_total[$suppiler->supplier_name])
                                @foreach ($supplier_wise_total[$suppiler->supplier_name] as $row)
                                <tr>
                                    <td colspan="6" class="text-right">Sub Total</td>
                                    <td class="text-right">
                                        {{ number_format(($row->total_received_amount + $row->discount_amount + $row->return_amt_adj) - $row->vat_amount, 2, '.', '') }}
                                       
                                      
                                    </td>
                                    <td class="text-right">
                                        {{ number_format($row->return_amt_adj, 2, '.', '') }}
                                    </td>
                                    <td class="text-right">
                                        {{ number_format($row->vat_amount, 2, '.', '') }}
                                    </td>
                                    <td class="text-right">
                                        {{ number_format($row->discount_amount, 2, '.', '') }}
                                    </td>

                                    <td class="text-right">
                                        {{ number_format($row->total_received_amount, 2, '.', '') }}
                                    </td>
                                </tr>
                                @endforeach
                                @endif
                                @endif
                                @endif



                                @php
                                // $sup_vari = $suppiler->supplier_name;
                                $sales_total += ($suppiler->total_received_amount + $suppiler->discount_amount+ $suppiler->return_amt_adj) - $suppiler->vat_amount;
                                $sales_discount += $suppiler->discount_amount;
                                $sales_vat += $suppiler->vat_amount;
                                $return_amt_adj += $suppiler->return_amt_adj;
                                $net_sales += $suppiler->total_received_amount ;
                                @endphp
                                @endforeach
                                @endif

                            </tbody>
                            <tfoot>
                                <tr>

                                    <th class="text-right bg-light-blue" colspan="6">Total</th>
                                    <th class="text-right bg-light-blue">{{ number_format($sales_total, 2) }}</th>
                                    <th class="text-right bg-light-blue">{{ number_format($return_amt_adj, 2) }}</th>
                                    <th class="text-right bg-light-blue">{{ number_format($sales_vat, 2) }}</th>
                                    <th class="text-right bg-light-blue">{{ number_format($sales_discount, 2) }}</th>
                                    <th class="text-right bg-light-blue">{{ number_format($net_sales, 2) }}</th>

                                </tr>
                            </tfoot>
                        </table>
                        </table>
                    </div>


                </div>
            </section>
        </div>
    </main>
</body>

</html>