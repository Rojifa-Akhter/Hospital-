<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Referral Payment</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    {{-- <link rel="stylesheet" href="{{ public_path().'/css/print.css' }}" media="print"> --}}
    <style>
        @page {
            /* margin: .5cm .6cm;
            width: 100%;
            height: 100% */
            margin: 0cm 0cm;
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
            /* position: fixed;
            top: .5cm;
            height: 3cm;
            padding-left: 10px; */

            /* position: fixed;
            top: 1cm;
            height: 2.5cm; */
        }



        /** Define now the real margins of every page in the PDF **/
        body {
            /* margin-top: 2cm;
            margin-left: 1cm;
            margin-right: 1cm;
            font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
            font-size: 11px; */

            margin-top: .7cm;
            margin-left: 1.5cm;
            margin-right: 1.5cm;
            /* margin-bottom: 7.5cm; */
            font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
            font-size: 11px;
        }

        footer {
            position: fixed;
            bottom: 0cm;
            left: 0cm;
            right: 0cm;
            height: 1cm;
            text-align: center;
            padding: 0 1cm;
            border-top: 1px solid;

        }

        .signature_ {
            position: fixed;
            z-index: 999999999;
            bottom: 0cm;
            left: 1cm;
            right: 1cm;
            height: 2cm;
            vertical-align: text-bottom;
            padding-bottom: 15px;

            /* text-align: center; */
            /* font-size: 9px; */
        }
    </style>
</head>

<body>
    {{-- @if ($po_hospital_details->report_header_image_prshde_ind == 1) --}}
    <header style="border-bottom: 1px solid; width:100%; padding-left:1cm">
        <table style="width: 100%; " class="signature">
            @if ($po_hospital_details->report_header_image != '')
                <tr>
                    <td style="">

                        <img class="hospital-logo"
                            src="{{ asset('images/uploads/hospital_images/' . $po_hospital_details->report_header_image) }}"
                            width="400px" alt="">

                    </td>
                </tr>
            @else
                <tr style="">
                    <td style="width: 10%;">
                        <img class="hospital-logo"
                            src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}"
                            style="background-color: {{ $po_hospital_details->logo_background_color }};  padding-right:15px"
                            alt="" width="80px">
                    </td>
                    <td style="text-align:left;">
                        <span style="font-size: 15px;"> <strong>
                                {{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }}
                            </strong></span> <br>
                        Address: <span>
                            {{ isset($po_hospital_details->addrress1) ? $po_hospital_details->addrress1 : '' }}</span><br>
                        Phone No: <span>
                            {{ isset($po_hospital_details->telephone1) ? $po_hospital_details->telephone1 : '' }}</span>
                    </td>
                </tr>
            @endif
        </table>
    </header>
    {{-- @else
    <header>
        <table style="width: 100%; " class="signature">
            <tr>
                <td style="text-align: center ">

                </td>
            </tr>
        </table>
    </header>
    @endif --}}


    <footer style=" ">
        <?php
        $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
        $date = $dt->format('g:i A');
        ?>


        <table style="width: 100%;">
            <tr>
                <td width="" style="">Printing Date: {{ date('d/m/Y') }} , {{ $date }}, Printed By:
                    {{ Session::get('user.ses_user_name') }} , Powered By - [NextGen]</td>
            </tr>
        </table>
        <script type="text/php">
            $font = $fontMetrics->getFont("Arial", "normal");
                                                                                        $pdf->page_text(530, 800, "Page {PAGE_NUM} of {PAGE_COUNT}", $font, 7, array(0, 0, 0));
                                                                                    </script>
    </footer>

    <main>
        <div class="wrapper">
            <div style=" text-align:center; margin-bottom:5px; margin-top:20px  " class="mb-2">
                <span class="report-name" style="width:70%; border:solid black 1px; padding:10px;  "> Referral Payment
                </span>
            </div>
            <section id="">
                <div class="container">
                    {{-- <table style="width: 100%;">
                    <tr>
                        <td><strong>Invoice Id :</strong> {{$ref_data->invoice_code}}</td>
                        <td style="text-align: right;"><span class="report-date"><strong>Invoice Date: </strong>{{ date("d/m/Y", strtotime($ref_data->invoice_date)) }}
                        </span></td>
                    </tr>
                    <tr>

                    </tr>
                </table>
                <table style="width: 100%;">
                    <tr>
                        <td><strong>Doctor Name :</strong> {{$ref_data->full_name}} ,<strong>Patient Name:</strong>{{$ref_data->customer_name}},<strong>Patient Age:</strong>{{ $ref_data->age_yy }}, <strong>Marketing By:</strong>{{$ref_data->full_name}},<strong>Date:</strong>{{ date("d/m/Y", strtotime($ref_data->invoice_date)) }}</td>
                    </tr>
                    <tr>

                    </tr>
                </table> --}}

                    <div class="" style=" border: 1px solid #dee2e6;   margin-bottom:10px ;">
                        <table width="100%">
                            <tr>
                                <td colspan="2"> <img style=""
                                        src="data:image/png;base64, {{ $patient_code }} " /></td>
                                {{-- <td></td> --}}
                                {{-- <td></td> --}}
                                <td colspan="2" style="text-align: right"> <img style=""
                                        src="data:image/png;base64, {{ $barcode_no }} " /></td>
                            </tr>
                            <tr>
                                <td><b>Patient ID </b></td>
                                <td> : {{ $ref_data->patient_code }}</td>
                                <td style="text-align: right"><b>Invoice ID </b> :</td>
                                <td style="text-align: right">{{ $ref_data->invoice_code }}</td>
                            </tr>
                            <tr>
                                <td><b> Patient Name </b></td>
                                <td> : {{ $ref_data->customer_name }}</td>
                                <td style="text-align: right"><b>Invoice Date </b> :</td>
                                <td style="text-align: right">{{ date('d/m/Y', strtotime($ref_data->invoice_date)) }}
                                </td>
                            </tr>
                            <tr>
                                <td><b>Age </b></td>
                                <td > : {{ $ref_data->age }}</td>
                                <td style="text-align: right;"><b>Prepared By</b>:</td>
                                <td style="text-align: right; font-size:10px;"> <b style=" font-size:9px !important;">{{ ucfirst($ref_data->user_name) }}</b> (
                                    <span >{{ date('d/m/Y h:i A', strtotime($ref_data->process_date)) }} )</span></td>
                            </tr>
                            <tr>

                                <td>
                                    @if (!empty($ref_data->full_name))
                                        <b>Doctor Name </b>
                                    @endif
                                    @if (!empty($ref_data->first_ref_doc_name))
                                        <b>First Referral Name </b>
                                    @endif
                                    @if (!empty($ref_data->second_ref_doc_name))
                                        <b>Second Referral Name </b>
                                    @endif
                                </td>
                                <td colspan="3">
                                    @if (!empty($ref_data->full_name))
                                        : {{ $ref_data->full_name }} <strong>(Doctor ID :{{$ref_data->doc_person_code}})</strong>
                                    @endif
                                    @if (!empty($ref_data->first_ref_doc_name))
                                        : {{ $ref_data->first_ref_doc_name }}
                                    @endif
                                    @if (!empty($ref_data->second_ref_doc_name))
                                        : {{ $ref_data->second_ref_doc_name }}
                                    @endif
                                </td>

                            </tr>
                            @if ($ref_data->marketing_agent_name != '')
                            <tr>
                                <td><strong>Marketing By</strong></td>
                                    <td colspan="3">
                                        @if (!empty($ref_data->marketing_agent_name))
                                            : {{ $ref_data->marketing_agent_name }} <strong>(Agent ID :{{$ref_data->marketing_agent_code}})</strong>
                                        @endif
                                        {{-- @if (!empty($ref_data->first_ref_doc_name))
                                            : {{ $ref_data->first_ref_doc_name }}
                                        @endif
                                        @if (!empty($ref_data->second_ref_doc_name))
                                            : {{ $ref_data->second_ref_doc_name }}
                                        @endif --}}
                                    </td>
                            </tr>
                            @endif

                        </table>

                    </div>

                    <table style="width: 100%;border-collapse:collapse;" cellpadding="1" cellspacing="0" border="1">
                        <tr class="table-tr" style="">
                            <td class="table-td" style="width: 15px" scope="col">
                                <strong>SL</strong>
                            </td>
                            <td class="table-td" scope="col">
                                <strong></strong>Item Code
                            </td>
                            <td class="table-td" scope="col">
                                <strong>Item Name </strong>
                            </td>
                            <td class="table-td" style="width: 100px; text-align:right" scope="col">
                                <strong> Rate</strong>
                            </td>

                        </tr>
                        <div style="display: none">
                            {{ $total_comission = 0 }}
                            {{ $total_discount = 0 }}
                            {{ $net_comission = 0 }}
                        </div>
                        @if (isset($ref_data_invoice))
                            @foreach ($ref_data_invoice as $value)
                                <tr class="table-tr">
                                    <td style="text-align: center">{{ $loop->iteration }}</td>
                                    <td>{{ $value->item_no_fk }}</td>
                                    <td>{{ !empty($value->item_name) ? $value->item_name : '' }} </td>
                                    <td class="text-right" style="text-align: right">
                                        {{ number_format($value->item_rate, 2) }}</td>
                                    <div style="display: none">{{ $total_comission += $value->item_rate }}</div>
                                    <div style="display: none; ">
                                        {{ $total_discount += $value->ledgerdtl_amt_discount }}</div>
                                    <div style="display: none">{{ $net_comission += $value->ledgerdtl_amt_payment }}
                                    </div>
                                </tr>
                            @endforeach
                        @endif

                        @php
                            $payable = number_format($invoice_amount->ledger_amt_sales - $invoice_amount->ledger_amt_discount - $invoice_amount->ledger_amt_payment, 2);

                            $locale = 'en_US';
                            $fmt = numfmt_create($locale, NumberFormatter::SPELLOUT);
                            $in_words = numfmt_format($fmt, abs($ref_comission));
                        @endphp
                        <tfoot>
                            <tr>
                                <td style="text-align: left; border: 0;" colspan="2">
                                    {{-- <span><strong>Post
                                    By:</strong>{{ Session::get('user.ses_user_name') }}</span>,<span><strong>Payment
                                    Receive By:</strong>{{ Session::get('user.ses_user_name') }}</span> --}}
                                    In Word : {{ strtoupper($in_words) }} TAKA ONLY
                                    <br>
                                    Pay to : {{ $ref_name }}
                                </td>

                                <td class="text-right" style="text-align: right;border: 0;">

                                    @if ($print_dt > 1)
                                    {{-- <table>
                                        <tr>
                                            <td class="text-right" colspan="3" style="padding: 2px !important;"> --}}
                                                <span
                                                    style="font-size: 30px !important; line-height: 1; border: 5px solid
                           #0a0a0a; border-left-color: #060607; color: #101011; padding: 10px;">
                                                    <strong>
                                                        Duplicate
                                                    </strong>
                                                </span>
                                            {{-- </td>
                                        </tr>
                                    </table> --}}
                                @endif



                                    Total Bill
                                    <br>
                                    Total Discount
                                    <br>

                                    Payment
                                    <br>
                                    @if ($payable >= 0)
                                        Net Payable
                                    @else
                                        Refund
                                    @endif


                                    <br>
                                    Net Comission
                                </td>
                                <td class="text-right" style="text-align: right;border: 0;">




                                    <span>{{ number_format($invoice_amount->ledger_amt_sales, 2) }}</span>
                                    <br>
                                    <span>{{ number_format($invoice_amount->ledger_amt_discount, 2) }}</span><br>
                                    <span>{{ number_format($invoice_amount->ledger_amt_payment, 2) }}</span><br>


                                    {{-- {{ $payable > 0 ? number_format($payable, 2) : number_format(abs($payable), 2) }} --}}
                                    <span>{{ number_format(abs($payable), 2) }}</span><br>
                                    <span><strong> {{ number_format($ref_comission, 2) }}</strong></span>

                                </td>
                            </tr>
                        </tfoot>

                    </table>
                    <br>




                    <table style="width: 100%;" class="signature_">
                        <tr style=" ">
                            <td style="text-align:left; ">
                                <span style="padding:5px; border-top: black solid 1px;"> Employee Signature
                                </span>
                            </td>
                            <td style="text-align:right; ">
                                <span style="padding:5px; border-top: black solid 1px;"> Approved By </span>
                            </td>
                        </tr>
                    </table>
                </div>
            </section>
        </div>
    </main>




</body>

</html>
