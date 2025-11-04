<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Corporate {{ $type }} Report</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    {{-- <link rel="stylesheet" href="{{ public_path().'/css/print.css' }}" media="print"> --}}
    <style>
        @page {
            margin: .5cm .6cm;
            /* width: 100%;
            height: 100% */
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

        /* table {
            border: 1px solid #222;
            border-spacing: 0;
        }

        td {
            border-bottom: 1px solid #222;
            border-right: 1px solid #222;
            padding: 5px !important;
        }

        table td:last-child {
            border-right: 0px solid transparent;
        }

        th {
            border-top: 1px solid #222;
            padding: 5px !important;
        } */

        header {
            /* position: fixed;
            top: 0;
            height: 2cm;
            border-bottom: 1px solid;
            padding: 0 1cm; */
            position: fixed;
            top: 0;
            height: 2.5cm;
            border-bottom: 1px solid;
            /* padding: 0 1cm; */
            /* padding-top: 10px; */
        }

        header img {
            /*width: 80px;*/
        }

        /** Define now the real margins of every page in the PDF **/
        body {
            /* margin-top: 2cm;
            margin-left: .3cm;
            margin-right: .3cm;
            margin-bottom: 2cm;
            font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
            font-size: 11px; */
            margin-top: 3cm;
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
            /* position: fixed;
            z-index: 999999999;
            left: 10px;
            right: 10px;
            height: 0.7cm;
            text-align: center;
            font-size: 9px;
            bottom: 10px;
            /*border-top: 1px solid black;*/
            /* padding-top: 5px; */
            border-top: 1px solid;
            */
        }
    </style>
</head>

<body>
    {{-- <header>
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
    </header> --}}
    {{-- <header>
        <table style="width: 100%; border:5px solid transparent !important" class="signature">
            @if ($po_hospital_details->report_header_image_prshde_ind == 1)
                <tr style="">
                    <td style="width: 15%;">
                        <img class="hospital-logo"
                            src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}"
                            width="60" alt="">
                    </td>
                    <td style="text-align:center;">
                        <span style="font-size: 15px;"> <strong>
                                {{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }}</strong></span>
                        <br>
                        Address:<span>
                            {{ isset($po_hospital_details->addrress1) ? $po_hospital_details->addrress1 : '' }}</span><br>
                        Phone
                        No:<span>{{ isset($po_hospital_details->telephone1) ? $po_hospital_details->telephone1 : '' }}</span>
                    </td>
                </tr>
            @else
                <tr>
                    <td style="text-align: center; border:5px solid transparent !important">
                        @if ($po_hospital_details->report_header_image != '')
                            <img class="hospital-logo"
                                src="{{ asset('images/uploads/hospital_images/' . $po_hospital_details->report_header_image) }}"
                                width="250px" alt="">
                        @endif

                    </td>
                </tr>
            @endif
        </table>
    </header> --}}

    <div class="signature_">

        <table style="width: 100%;border-spacing: 0; border:none !important;" cellpadding="1">
            @if ($print_type != 'EXCEL')
                <tr class="table-tr">
                    <td style="text-align:left; border:none;">
                        <span style="padding:5px; border-top: black solid 1px;"> Billing In-Charge
                        </span>
                    </td>
                    <td style="text-align:center; border:none;">
                        <span style="padding:5px; border-top: black solid 1px;"> Business Development In-Charge
                        </span>
                    </td>
                    <td style="text-align:right; border:none;">
                        <span style="padding:5px; border-top: black solid 1px;"> Head of Accounts </span>
                    </td>
                </tr>
            @endif
        </table>
    </div>

    @if ($print_type != 'EXCEL')
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

    <main>
        <div class="wrapper">
            @if ($print_type != 'EXCEL')
                <div style=" text-align:center; margin-bottom:5px; margin-top:20px  " class="mb-2">
                    <span class="report-name" style="width:70%; border:solid black 1px; padding:10px;  "> Corporate
                        {{ ucwords(strtolower($type)) }}
                        Report</span>
                </div>


                <div style=" text-align:center; margin-bottom:5px; margin-top:20px  " class="mb-2">
                    <span> <strong>Pay To : </strong>
                        {{ ucwords(strtolower($corporate_name)) }}
                    </span>
                </div>
                <div style=" text-align:center;  width:100%; margin-bottom:10px" class="mb-2">


                    <span class="report-date"><strong>From Date: {{ $from_date }}</strong> - <span
                            class="report-date"><strong>To Date: {{ $to_date }}</strong>
                        </span>
                </div>
            @else
                <table width="100%" style="border: none; font-size:12px">
                    <tr>
                        <td colspan="3">
                            <strong>Pay To : </strong>
                            {{ ucwords(strtolower($corporate_name)) }} <br>
                            <span class="report-date"><strong>From Date: {{ $from_date }}</strong> - <span
                                    class="report-date"><strong>To Date: {{ $to_date }}</strong>
                                </span>
                        </td>
                        <td colspan="3">
                            <table width="100%" border="1">
                                <tr>
                                    <td>ETTN No.#</td>
                                    <td colspan="2">198810405811</td>
                                </tr>
                                <tr>
                                    <td>BIN No.#</td>
                                    <td colspan="2">001873857-0102</td>
                                </tr>
                                <tr>
                                    <td>Invoice#</td>
                                    <td colspan="2">2022-10033</td>
                                </tr>
                                <tr>
                                    <td>Billing Period</td>
                                    <td colspan="2">{{$from_date .' to '. $to_date}}</td>
                                </tr>
                                <tr>
                                    <td>Due Date</td>
                                    <td colspan="2"></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            @endif
            <section id="lp-items">
                <div class="container">
                    <table style="width: 100%;border-spacing: 0;mergin-bottom:100px" border='1' cellpadding="1">
                        {{-- <div style="display: none">
                            {{ $sales_total = 0 }}
                            {{ $sales_discount = 0 }}
                            {{ $net_sales = 0 }}
                            {{ $collection = 0 }}
                            {{ $invoice_count = 0 }}
                            {{ $sales_due = 0 }}
                            {{ $sales_refund = 0 }}
                            {{ $total_net_collection = 0 }}
                        </div> --}}

                        <thead class="bg-soft-green">
                            @if ($type == 'DETAILS')
                                <tr class="table-tr" style="background-color: #111; color:white;">
                                    <th class="text-left table-td" scope="col">Sl</th>
                                    <th class="text-left table-td" scope="col"> Invoice Info</th>
                                    {{-- <th class="text-left table-td" scope="col">Corporate Name</th> --}}
                                    <th class="text-left table-td" scope="col">Patient Name</th>
                                    <th class="text-left table-td" scope="col">Patient Age</th>
                                    <th class="text-right table-td" style="text-align:right;" scope="col">Pass No.
                                    </th>
                                    <th class="text-right table-td" style="text-align:right;" scope="col">Bill Amount
                                    </th>
                                </tr>
                            @elseif ('SUMMARY')
                                <tr class="table-tr" style="background-color: #111; color:white;">
                                    <th class="text-center table-td" scope="col">Sl</th>
                                    <th class="text-center" scope="col">Date</th>
                                    <th class="text-left table-td" scope="col">Corporate ID</th>
                                    <th class="text-left table-td" scope="col">Name</th>
                                    <th class="text-left table-td" scope="col">Patient Count</th>
                                    <th class="text-right table-td" style="text-align:right;" scope="col">Sales</th>
                                    <th class="text-right table-td" style="text-align:right;" scope="col">Collection
                                    </th>
                                    <th class="text-right table-td" style="text-align:right;" scope="col">Due</th>
                                </tr>
                            @endif
                        </thead>
                        <br>

                        </tr>


                        @php
                            $total_sales = $total_collection = $total_due = 0;
                            $counter = 0;
                        @endphp
                        @if (!empty($report_data))
                            @foreach ($report_data as $key => $row)
                                @if ($type == 'DETAILS')
                                    @if ($row->net_sales < 1)
                                        @if ($row->collection < 1)
                                            <?php $counter = $counter + 1; ?>
                                            <tr>
                                                <td style="text-align: center">{{ $counter }}</td>
                                                <td class="text-left;" style="width:10px;">
                                                    Inv
                                                    No.:{{ !empty($row->invoice_code) ? $row->invoice_code : '' }}<br>
                                                    Inv Date :{{ date('d/m/y', strtotime($row->invoice_date)) }}
                                                </td>
                                                {{-- <td class="text-left">
                                            {{ !empty($row->ccm_client_code) ? $row->ccm_client_name : '' }}</td> --}}
                                                <td class="text-left">
                                                    {{-- <strong>ID :</strong> {{ !empty($row->patient_code) ? $row->patient_code : '' }}<br> --}}
                                                    {{ !empty($row->patient_name) ? $row->patient_name : '' }}
                                                    {{-- <strong>Age :</strong>{{ !empty($row->age) ? $row->age : '' }}, --}}
                                                    {{-- <strong> Ph : </strong>{{ !empty($row->mobile1) ? $row->mobile1 : '' }}, --}}
                                                </td>
                                                <td class="text-left">{{ !empty($row->age) ? $row->age : '' }}</td>
                                                <td style="text-align:right;width:50px;">
                                                    {{ !empty($row->passport_no) ? $row->passport_no : '' }}
                                                </td>
                                                <td style="text-align:right;width:50px;">
                                                    {{ !empty($row->collection) ? number_format($row->collection, 2, '.', '') : 0 }}
                                                </td>
                                            </tr>
                                            @php
                                                $total_sales += $row->net_sales;
                                                $total_collection += $row->collection;
                                                $total_due += $row->due;
                                            @endphp
                                        @endif
                                    @endif
                                @elseif ($type == 'SUMMARY')
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td class="text-center">{{ date('d/m/y', strtotime($row->invoice_date)) }}
                                        </td>
                                        <td class="text-left">
                                            {{ !empty($row->ccm_client_code) ? $row->ccm_client_code : '' }}</td>
                                        <td class="text-left">
                                            {{ !empty($row->patient_name) ? $row->patient_name : '' }}</td>
                                        <td class="text-left">
                                            {{ !empty($row->patient_count) ? $row->patient_count : '' }}</td>
                                        <td class="text-right" style="text-align:right;">
                                            {{ !empty($row->sales) ? number_format($row->net_sales, 2, '.', '') : 0 }}
                                        </td>
                                        <td class="text-right" style="text-align:right;">
                                            {{ !empty($row->collection) ? number_format($row->collection, 2, '.', '') : 0 }}
                                        </td>
                                        <td class="text-right" style="text-align:right;">
                                            {{ !empty($row->due) ? number_format($row->due, 2, '.', '') : 0 }}
                                        </td>
                                    </tr>
                                    @php
                                        $total_sales += $row->net_sales;
                                        $total_collection += $row->collection;
                                        $total_due += $row->due;
                                    @endphp
                                @endif
                            @endforeach
                        @else
                            <tr>
                                @if ($type == 'DETAILS')
                                    <th class="text-center" style="text-align: right;" scope="col"
                                        colspan="9">No
                                        Data Available</th>
                                @elseif ($type == 'SUMMARY')
                                    <th class="text-center" style="text-align: right;" scope="col"
                                        colspan="8">No
                                        Data Available</th>
                                @endif

                            </tr>
                        @endif





                        <tfoot>
                            @if ($type == 'DETAILS')
                                @php
                                    $colclass = 5;
                                @endphp
                            @elseif ($type == 'SUMMARY')
                                @php
                                    $colclass = 5;
                                @endphp
                            @endif

                            <tr>
                                <th class="text-right" scope="col" colspan="{{ $colclass }}"
                                    style="text-align: right; padding:5px;">Total = </th>
                                <th scope="col" class="text-right bg-light-blue"
                                    style="text-align: right;  padding:5px;">
                                    {{ number_format($total_sales, 2, '.', '') }}</th>
                                {{-- <th scope="col" class="text-right bg-light-blue"
                                    style="text-align: right;  padding:5px;">
                                    {{ number_format($total_collection, 2, '.', '') }}
                                </th>
                                <th scope="col" class="text-right bg-light-blue"
                                    style="text-align: right;  padding:5px;">
                                    {{ number_format($total_due, 2, '.', '') }}</th> --}}
                            </tr>
                        </tfoot>
                    </table>
                    @if ($print_type = 'EXCEL')
                        <table>
                            <tr></tr>
                            <tr></tr>
                            <tr></tr>
                            <tr></tr>


                            <tr>
                                <td style="text-align: center; "> <span
                                        style=" border-top: 1px solid black !importent"> Billing In-Charge</span></td>
                                <td colspan="2" style="text-align: center; "><span
                                        style=" border-top: 1px solid black !importent"> Bussiness Developmnet
                                        In-Charge </span></td>
                                <td colspan="3" style="text-align: center; "> <span
                                        style=" border-top: 1px solid black !importent"> Head Of Accounts </span></td>
                            </tr>
                        </table>

                        <table width="100%">
                            <tr></tr>
                            <tr></tr>
                            <tr>
                                <td colspan="6">
                                    <strong>Payment Instraction :</strong>
                                    <p>
                                        Payment through Cheque/Pay Order/DD, please issue in favour of
                                        <strong>  "{{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }}</strong>
                                        ." Payment through Bank (Bank Tranfer / BEFTN /RTGS) , please use either of
                                        following
                                    </p>
                                </td>
                            </tr>
                        </table>
                        <table>
                            <tr></tr>
                            <tr></tr>
                        </table>
                        <table width="100%" border="1">

                            <tr>
                                <td>A/C Name</td>
                                <td colspan="3"><strong>  "{{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }}</strong></td>
                            </tr>
                            <tr>
                                <td>A/C No</td>
                                <td colspan="3">{{'1323405518001'}}</td>
                            </tr>
                            <tr>
                                <td>Bank Name</td>
                                <td colspan="3">The City Bank Ltd</td>
                            </tr>
                            <tr>
                                <td>Branch</td>
                                <td colspan="3">Gulshan Women Branch</td>
                            </tr>
                            <tr>
                                <td>Routing No</td>
                                <td colspan="3">{{number_format('225251174')}}</td>
                            </tr>
                        </table>
                        <table width="100%">
                            <tr></tr>
                            <tr>
                                <td colspan="6">
                                    <strong> **Note : </strong> All amounts are exclusive of TAX & VAT.
                                </td>
                            </tr>
                        </table>
                    @endif
                </div>



            </section>
        </div>

    </main>


</body>

</html>
