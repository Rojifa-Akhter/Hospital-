<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Schedule of Jakat Fund Report</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

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


        .page-break {
            page-break-before: always;
        }
    </style>
</head>

<body>
    <header>
        <table style="width: 100%;" class="signature">
            <tr>
                <td style="width: 15%;">
                    @if (!empty($po_hospital_details->logo))
                        <img class="hospital-logo"
                            src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}"
                            width="60" alt="">
                    @endif
                </td>
                <td style="text-align:center;">
                    <span style="font-size: 15px;"> <strong>
                            {{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }}
                        </strong></span> <br>
                    Address: <span>
                        {{ isset($po_hospital_details->addrress1) ? $po_hospital_details->addrress1 : '' }}</span><br>
                    Phone No: <span>
                        {{ isset($po_hospital_details->telephone1) ? $po_hospital_details->telephone1 : '' }}</span>
                </td>
                <td style=" text-align:right; width: 15%; ">
                    <div style="">
                        <img src="data:image/png;base64, {{ $barcode_no }} " width="100" />
                    </div>

                </td>
            </tr>
        </table>
    </header>
    <div style="width: 100%;">
        <div style=" text-align:center; margin-bottom:5px; margin-top:15px  ">
            <span class="report-name" style="width:70%; border:solid black 1px; padding:10px;  ">
                Schedule of Jakat fund Report</span>
        </div>
    </div>

    <div class="signature_">
        <table style="width: 100%;">
            <tr style=" ">
                <td style="text-align:left; ">
                    <span style="padding:5px; border-top: black solid 1px;"> PREPARED BY
                    </span>
                </td>
                <td style=" ">
                    <span style="padding:5px; border-top: black solid 1px;"> MANAGER ACCOUNTS
                    </span>
                </td>
                <td style="">
                    <span style="padding:5px; border-top: black solid 1px;"> DGM
                    </span>
                </td>
                <td>
                    <span style="padding:5px; border-top: black solid 1px;"> DMD
                    </span>
                </td>
                <td style="text-align:right; ">
                    <span style="padding:5px; border-top: black solid 1px;"> CHAIRMAN </span>
                </td>
            </tr>
        </table>
    </div>

    <footer class="">
        <div class="footer ">
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
                            </strong></td>
                    </tr>
                </table>
            </div>
        </div>
    </footer>


    <main class="">
        <div class="wrapper">

            <section id="lp-items ">
                <div class="container ">


                    <table style="margin:0; padding: 0; width:100%; border-collapse:collapse;">

                        &nbsp;
                        {{-- @if ($supplier_name != '')

								<tr>
									<th style="text-align: left ;border:none;padding:5px;width:100px"> Supplier Name </th>
									<td style="text-align: left ;border:none"> : {{ $supplier_name }}</td>
								</tr>
								@endif
                                --}}
                        @if ($religion != null)
                            <tr>
                                <th style="text-align: left ;border:none;padding:5px;width:100px"> Patient Type </th>
                                <td style="text-align: left ;border:none"> : {{ $religion }}</td>
                            </tr>
                        @endif
                        @if ($from_date != '' && $to_date != '')
                            <tr>
                                <th style="text-align: left ;border:none;padding:5px;width:100px"> From date </th>
                                <td style="text-align: left ;border:none"> : {{ $from_date }} <strong> To date
                                    </strong> : {{ $to_date }}</td>
                            </tr>
                        @elseif ($from_date != '')
                            <tr>
                                <th style="text-align: left ;border:none;padding:5px;width:100px"> Date</th>
                                <td style="text-align: left ;border:none"> : {{ $from_date }}</td>
                            </tr>
                        @endif

                    </table>
                    <table style="width:100%;border-collapse:collapse;" cellpadding="1" cellspacing="0" border="1">
                        <thead>
                            <tr class="table-tr" style="background-color: #E3E3E3;  ">
                                <th class=" table-td"> <strong>SL# </strong></th>
                                <th class=" table-td"> <strong>Name of the Patient</strong></th>
                                <th class=" table-td"> <strong>Religion</strong></th>
                                <th class=" table-td"> <strong>Address</strong></th>
                                <th class=" table-td"> <strong>Reg No</strong></th>
                                <th class=" table-td"> <strong>Type</strong></th>
                                <th class=" table-td"> <strong>Date </strong></th>
                                <th class=" table-td"> <strong>Bill Amount</strong></th>
                                <th class=" table-td"> <strong>Zakat Fund</strong></th>
                            </tr>


                        </thead>
                        <tbody>
                            @php
                                $total_sales = $zakat_fund = 0;
                            @endphp
                            @if (!empty($jakat))

                                @foreach ($jakat as $row)
                                    <tr>
                                        <td class="text-center" style="text-align: center;padding:5px">
                                            {{ $loop->iteration }}
                                        </td>
                                        <td class="text-center" style="padding:5px">{{ $row->patient_name }}
                                        </td>
                                        <td class="text-center" style="padding:5px">{{ $row->religion_txt }}
                                        </td>
                                        <td class="text-left" style="padding:5px">
                                            {{ $row->present_addr }}
                                        </td>
                                        <td class="text-center" style="padding:5px">
                                            {{ $row->patient_code }}
                                        </td>

                                        <td class="text-center" style="text-align: right;padding:5px">
                                            @if ($row->module_code == 'OPD')
                                                Outdoor
                                            @elseif($row->module_code == 'IPD')
                                                Indoor
                                            @elseif($row->module_code == 'PHR')
                                                Pharmacy
                                            @elseif($row->module_code == 'PHR-I')
                                                Pharmacy
                                            @endif
                                        </td>

                                        <td style="text-align: right;padding:5px">
                                            {{ date('d/m/Y', strtotime($row->invoice_date)) }}
                                        </td>
                                        <td style="text-align: right;padding:5px">
                                            {{ number_format($row->sales, 2) }}
                                        </td>

                                        <td style="text-align: right;padding:5px">
                                            {{ number_format($row->zakatfund, 2) }}
                                        </td>

                                    </tr>
                                    @php
                                        $total_sales += $row->sales;
                                        $zakat_fund += $row->zakatfund;
                                        // $total_dis += $row->discount;
                                        // $total_net_payable += $row->net_sales;
                                        // $total_paid += $row->collection;
                                        // $total_due += $row->due;
                                        // $total_refund += $row->refund;
                                        // $total_net_col += $row->net_collection;
                                    @endphp
                                @endforeach
                            @endif
                            <tr>
                                <th class="text-right" scope="col" colspan="7">Total = </th>
                                {{-- <th class="text-right" scope="col" colspan="7">Total = </th> --}}

                                <th scope="col" class="text-right bg-light-blue">
                                    {{ number_format($total_sales, 2, '.', '') }}</th>
                                <th scope="col" class="text-right bg-light-blue">
                                    {{ number_format($zakat_fund, 2, '.', '') }}</th>
                                {{-- <th scope="col" class="text-right bg-light-blue">{{ number_format($total_dis, 2, '.', '') }}</th>
                                        <th scope="col" class="text-right bg-light-blue">{{ number_format($total_net_payable, 2, '.', '') }}</th>
                                        <th scope="col" class="text-right bg-light-blue">{{ number_format($total_paid, 2, '.', '') }}</th>
                                        <th scope="col" class="text-right bg-light-blue">{{ number_format($total_due, 2, '.', '') }}</th>
                                        <th scope="col" class="text-right bg-light-blue">{{ number_format($total_refund, 2, '.', '') }}</th>
                                        <th scope="col" class="text-right bg-light-blue">{{ number_format($total_net_col, 2, '.', '') }}</th> --}}
                            </tr>
                        </tbody>
                        {{-- <tfoot> --}}

                        {{-- </tfoot> --}}
                    </table>
                </div>
            </section>
        </div>
    </main>
    <footer class="">
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
                            </strong></td>
                    </tr>
                </table>
            </div>
        </div>
    </footer>
</body>

</html>
