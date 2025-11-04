@php
$hospital = DB::table('wsec_hospital')
    ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
    ->first();
@endphp

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ $type }} wise Report</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    {{-- <link rel="stylesheet" href="{{ public_path().'/css/print.css' }}" media="print"> --}}
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
    </style>
</head>

<body>
    <header>
        <table style="width: 100%; border:none;" class="signature">
            <tr>
                <td style="width: 15%; border:none;">
                    <img class="hospital-logo"
                        src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}" width="60"
                        alt="">
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
        <table style="width: 100%;border-spacing: 0; border:none !important;" cellpadding="1">
            <tr class="table-tr">
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
                        <td style="font-size: 9px; text-align: right; border:none;"><strong>Powered By - H360 [NextGen]
                            </strong></td>

                    </tr>
                </table>
            </div>
        </div>
    </footer>


    <main>
        <div class="wrapper">
            <div style=" text-align:center; margin-bottom:5px; margin-top:20px  " class="mb-2">
                <span class="report-name" style="width:70%; border:solid black 1px; padding:10px;  ">

                    {{ $type }} Wise
                    Report
                </span>
            </div>
            <div style=" text-align:center;  width:100%; margin-bottom:10px" class="mb-2">


                <span class="report-date"><strong>From Date: {{ $from_date }}</strong> - <span
                        class="report-date"><strong>To Date: {{ $to_date }}</strong>
                    </span>
            </div>
            <section id="lp-items">
                <div class="container">
                    <table style="width: 100%;border-spacing: 0;" cellpadding="1">

                        <thead class="bg-soft-green" style="margin-bottom: 10px">
                            <tr class="table-tr" style="background-color: #E3E3E3;">
                                <th class="text-centertable-td" scope="col">SL</th>
                                <th class="text-centertable-td" scope="col">Voucher</th>
                                <th class="text-centertable-td" scope="col">Date</th>
                                <th class="text-centertable-td" scope="col">Patient</th>
                                {{-- <th class="text-centertable-td" scope="col">Age</th>
                                <th class="text-centertable-td" scope="col">Gender</th>
                                <th class="text-centertable-td" scope="col">Contact</th> --}}
                                <th class="text-centertable-td" scope="col">Referral</th>
                                {{-- <th class="text-left" scope="col">Referral</th> --}}
                                <th scope="col" class="text-right table-td">Sales</th>
                                <th scope="col" class="text-right table-td">Discount</th>
                                <th scope="col" class="text-right table-td">Net Sales</th>
                                <th scope="col" class="text-right table-td">Collection</th>
                                <th scope="col" class="text-right table-td">Due</th>
                                <th scope="col" class="text-right table-td">Refund</th>
                                <th scope="col" class="text-right table-td">Net Collection</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $final_payable = $final_discount = $final_net_payable = $final_paid = $final_due = $final_refund = $final_net_collection = $final_invoice = 0;
                            @endphp
                            @if (!empty($marketing_list))

                                @foreach ($marketing_list as $key => $dt)
                                    <tr class="bg-light-green">
                                        <td class="text-left text-bold" colspan="12" style="">
                                            <strong>{{ ucfirst($key) }}</strong>
                                        </td>
                                    </tr>
                                    @php
                                        $refund = 0;
                                        $due = 0;
                                        $total_invoice = 0;
                                        $total_payable = 0;
                                        $total_discount = 0;
                                        $total_net_payable = 0;
                                        $total_paid = 0;
                                        $total_due = 0;
                                        $total_refund = 0;
                                        $total_net_collection = 0;
                                        $total_invoice = 0;
                                    @endphp
                                    @foreach ($dt as $key => $row)
                                        <tr>
                                            <td class="text-center bg-light">{{ $loop->iteration }}</td>
                                            <td class="text-left">{{ $row->invoice_code }} </td>
                                            <td class="text-left">
                                                <div>{{ date('d/m/Y', strtotime($row->invoice_date)) }}</div>
                                                <div>{{ date('H:i:s', strtotime($row->invoice_date)) }} </div>
                                            </td>
                                            <td class="text-left">
                                                <div><strong>{{ $row->patient_code }}</strong></div>
                                                <div> {{ $row->patient_name }}</div>
                                                <div> {{ $row->age }}</div>
                                                <div>{{ $row->gender_txt }}</div>
                                                <div>{{ $row->mobile1 }}</div>
                                            </td>
                                            {{-- <td class="text-left" style="word-break: break-all; width: 60px;">
                                                {{ $row->age }}</td>
                                            <td class="text-left">{{ $row->gender_txt }}</td>
                                            <td class="text-left">{{ $row->mobile1 }}</td> --}}
                                            {{-- <td class="text-left">{{ $row->prescribed_physio_name }}</td> --}}
                                            <td class="text-left">
                                                @if ($type == 'Area')
                                                {{ !empty($row->first_doc_name) ? ucfirst($row->first_doc_name) : '' }}

                                                @else
                                                {{ !empty($row->first_doc_name) ? ucfirst($row->first_doc_name) : ucfirst($row->second_doc_name) }}

                                                @endif
                                                 </td>
                                            <td class="text-right bg-light" style="text-align: right;">
                                                {{ number_format($row->sales, 2, '.', '') }}
                                            </td>
                                            <td class="text-right bg-light" style="text-align: right;">
                                                {{ number_format($row->discount, 2, '.', '') }}
                                            </td>
                                            <td class="text-right bg-light" style="text-align: right;">
                                                {{ number_format($row->net_sales, 2, '.', '') }}</td>
                                            <td class="text-right bg-light">
                                                {{ number_format($row->collection, 2, '.', '') }}</td>
                                            <td class="text-right bg-light" id="due" style="text-align: right;">
                                                {{ number_format($row->due, 2, '.', '') }}
                                            </td>
                                            <td class="text-right bg-light" id="refund" style="text-align: right;">
                                                {{ number_format($row->refund, 2, '.', '') }}</td>
                                            <td class="text-right bg-light" id="refund" style="text-align: right;">
                                                {{ number_format($row->net_collection, 2, '.', '') }}</td>

                                        </tr>
                                        @php
                                            $total_payable += $row->sales;
                                            $total_discount += $row->discount;
                                            $total_net_payable += $row->net_sales;
                                            $total_paid += $row->collection;
                                            $total_due += $row->due;
                                            $total_refund += $row->refund;
                                            $total_net_collection += $row->net_collection;
                                            $total_invoice += $row->net_collection;
                                        @endphp
                                    @endforeach

                                    <tr>
                                        <td class="text-right" style="text-align: right;" scope="col" colspan="5">Sub Total = </td>
                                        <td scope="col" class="text-right bg-light-blue" style="text-align: right;">
                                            {{ number_format($total_payable, 2, '.', '') }}
                                        </td>
                                        <td scope="col" class="text-right bg-light-blue" style="text-align: right;">
                                            {{ number_format($total_discount, 2, '.', '') }}
                                        </td>
                                        <td scope="col" class="text-right bg-light-blue" style="text-align: right;">
                                            {{ number_format($total_net_payable, 2, '.', '') }}
                                        </td>
                                        <td scope="col" class="text-right bg-light-blue" style="text-align: right;">
                                            {{ number_format($total_paid, 2, '.', '') }}</th>
                                        <td scope="col" class="text-right bg-light-blue" style="text-align: right;">
                                            {{ number_format($total_due, 2, '.', '') }}
                                        </td>
                                        <td scope="col" class="text-right bg-light-blue" style="text-align: right;">
                                            {{ number_format($total_refund, 2, '.', '') }}</td>
                                        <td scope="col" class="text-right bg-light-blue" style="text-align: right;">
                                            {{ number_format($total_net_collection, 2, '.', '') }}
                                        </td>
                                    </tr>

                                    @php
                                        $final_payable += $total_payable;
                                        $final_discount += $total_discount;
                                        $final_net_payable += $total_net_payable;
                                        $final_paid += $total_paid;
                                        $final_due += $total_due;
                                        $final_refund += $total_refund;
                                        $final_net_collection += $total_net_collection;
                                        $final_invoice += $total_invoice;
                                    @endphp
                                @endforeach
                            @else
                                <tr>
                                    <th class="text-center" scope="col" colspan="12">No Data Available</th>
                                </tr>
                            @endif
                        </tbody>
                        <tfoot>
                            <tr>
                                <th class="text-right" scope="col" colspan="5">Total = </th>
                                <th scope="col" class="text-right bg-light-blue" style="text-align: right;">
                                    {{ number_format($final_payable, 2, '.', '') }}
                                </th>
                                <th scope="col" class="text-right bg-light-blue" style="text-align: right;">
                                    {{ number_format($final_discount, 2, '.', '') }}
                                </th>
                                <th scope="col" class="text-right bg-light-blue" style="text-align: right;">
                                    {{ number_format($final_net_payable, 2, '.', '') }}
                                </th>
                                <th scope="col" class="text-right bg-light-blue" style="text-align: right;">
                                    {{ number_format($final_paid, 2, '.', '') }}</th>
                                <th scope="col" class="text-right bg-light-blue" style="text-align: right;">
                                    {{ number_format($final_due, 2, '.', '') }}</th>
                                <th scope="col" class="text-right bg-light-blue" style="text-align: right;">
                                    {{ number_format($final_refund, 2, '.', '') }}
                                </th>
                                <th scope="col" class="text-right bg-light-blue" style="text-align: right;">
                                    {{ number_format($final_net_collection, 2, '.', '') }}
                                </th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </section>
        </div>
    </main>


</body>

</html>
