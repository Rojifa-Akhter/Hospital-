<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Department Wise Pdf Report</title>
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
    {{-- <header>
        <table style="width: 100%;" class="signature">
            <tr>
                <td style="width: 20%;">
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
                        <img src="data:image/png;base64, {{ $barcode_no }} " width="200" height="40" />
                    </div>

                </td>
            </tr>
        </table>
    </header> --}}
    <div style="width: 100%;">
            <div style=" text-align:center; margin-bottom:5px; margin-top:15px  ">
                <span class="report-name" style="width:70%; border:solid black 1px; padding:10px;  "> Department Wise Performance Report</span>
            </div>

            <div style=" text-align:center;  width:100%; margin-bottom:10px" class="mb-2">


                <span class="report-date"><strong>From Date: {{ $from_date }}</strong> - <span
                        class="report-date"><strong>To Date: {{ $to_date }}</strong>
                    </span>
            </div>


    </div>

    <main class="">
        <div class="wrapper">

            <section id="lp-items ">
                <div class="container ">

                    <table style="width:100%;border-collapse:collapse;" cellpadding="1" cellspacing="0" border="1">
                        <thead>
                            <tr class="table-tr" style="background-color: #E3E3E3;  ">
                                <th class="table-td"> <strong>SL# </strong></th>
                                <th class="table-td"> <strong>Module Name</strong></th>
                                <th class="table-td"> <strong>Patient Type</strong></th>
                                <th class="table-td"> <strong>Total Patient </strong></th>
                                <th class="table-td"> <strong>Item Quantity </strong></th>
                                <th class="table-td"> <strong>Payment </strong></th>
                                {{-- <th class="table-td"> <strong>Payment </strong></th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $final_quantity = 0;
                            $final_patient = 0;
                            $final_investigation = 0;
                            $final_opd = 0;
                            $final_ipd = 0;
                            $final_corporate = 0;
                            $final_academic = 0;
                            $final_total = 0;
                            // price
                            $final_quantity_price = 0;
                            $final_patient_price = 0;
                            $final_investigation_price = 0;
                            $final_opd_price = 0;
                            $final_ipd_price = 0;
                            $final_corporate_price = 0;
                            $final_academic_price = 0;
                            $final_total_price = 0;
                            ?>
                            @if (!empty($parent_dt))
                                @foreach ($parent_dt as $key1 => $value)
                                    <?php
                                    $total_quantity = 0;
                                    $total_patient = 0;
                                    $total_investigation = 0;
                                    $total_opd = 0;
                                    $total_ipd = 0;
                                    $total_corporate = 0;
                                    $total_academic = 0;
                                    $total_total = 0;
                                    // price
                                    $total_quantity_price = 0;
                                    $total_patient_price = 0;
                                    $total_investigation_price = 0;
                                    $total_opd_price = 0;
                                    $total_ipd_price = 0;
                                    $total_corporate_price = 0;
                                    $total_academic_price = 0;
                                    $total_total_price = 0;
                                    $total_item_qty = 0;
                                    ?>
                                    <tr>
                                        <td colspan="6" class="text-left">
                                            <strong>{{ !empty($key1) ? $key1 : 'N/A' }}</strong>
                                        </td>
                                    </tr>
                                    @foreach ($value as $key2 => $dt)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                    
                                            <td class="text-center">
                                                <div>{{ !empty($dt->module_code) ? $dt->module_code : '' }}</div>
                                            </td>
                                            <td class="text-center" >
                                                <div><strong>{{ !empty($dt->patient_type_code) ? $dt->patient_type_code : '' }}</strong></div>
                                            </td>
                                            <td class="text-center" style="text-align: center;">
                                                <div> {{ !empty($dt->pat_total) ? $dt->pat_total : '' }}</div>
                                            </td>
                                            <td class="text-center" style="text-align: center;">
                                                <div> {{ !empty($dt->item_total_qty) ? $dt->item_total_qty : '' }}</div>
                                            </td>
                                            <td class="text-right" style="text-align: right;">
                                                <div>
                                                    {{ !empty($dt->item_total_amt_payment) ? number_format($dt->item_total_amt_payment, 2) : 0 }}
                                                </div>
                                            </td>
                    
                                        </tr>
                    
                                        <div style="display: none">{{ $total_patient += $dt->pat_total }}
                                        </div>
                                        <div style="display: none">{{ $total_item_qty += $dt->item_total_qty }}
                                        </div>
                                        <div style="display: none">{{ $total_investigation += 0 }}
                                        </div>
                                        <div style="display: none">{{ $total_opd += 0 }}
                                        </div>
                                        <div style="display: none">{{ $total_ipd += 0 }}
                                        </div>
                                        <div style="display: none">{{ $total_corporate += 0 }}
                                        </div>
                                        <div style="display: none">{{ $total_academic += 0 }}
                                        </div>
                                        <div style="display: none">{{ $total_total += 0 }}
                                        </div>
                                        {{-- price  --}}
                                        <div style="display: none">{{ $total_patient_price += $dt->item_total_amt_payment }}
                                        </div>
                                        <div style="display: none">{{ $total_investigation_price += 0 }}
                                        </div>
                                        <div style="display: none">{{ $total_opd_price += 0 }}
                                        </div>
                                        <div style="display: none">{{ $total_ipd_price += 0 }}
                                        </div>
                                        <div style="display: none">{{ $total_corporate_price += 0 }}
                                        </div>
                                        <div style="display: none">{{ $total_academic_price += 0 }}
                                        </div>
                                        <div style="display: none">{{ $total_total_price += 0 }}
                                        </div>
                                    @endforeach
                    
                                    <tr>
                                        <th class="text-right" colspan="3" style="text-align: right;">Sub Total =</th>
                                        <th class="text-center bg-light-blue"style="text-align: center;">
                                            <div><strong>{{ $total_patient }}</strong></div>
                                        </th>
                                        <th class="text-center bg-light-blue"style="text-align: center;">
                                            <div><strong>{{ $total_item_qty }}</strong></div>
                                        </th>
                                        <th class="text-right bg-light-blue"style="text-align: right;">
                                            <div><strong>{{ number_format($total_patient_price, 2) }}</strong></div>
                                        </th>
                                        {{-- <th class="text-center bg-light-blue">
                                            <div>{{ number_format($total_ipd, 2) }}</div>
                                            <div><strong>{{ number_format($total_ipd_price, 2) }}</strong></div>
                                        </th>
                                        <th class="text-center bg-light-blue">
                                            <div>{{ number_format($total_corporate, 2) }}</div>
                                            <div><strong>{{ number_format($total_corporate_price, 2) }}</strong></div>
                                        </th>
                                        <th class="text-center bg-light-blue">
                                            <div>{{ number_format($total_academic, 2) }}</div>
                                            <div><strong>{{ number_format($total_academic_price, 2) }}</strong></div>
                                        </th>
                                        <th class="text-center bg-light-blue">
                                            <div>{{ number_format($total_total, 2) }}</div>
                                            <div><strong>{{ number_format($total_total_price, 2) }}</strong></div>
                                        </th> --}}
                                    </tr>
                    
                                    {{-- final  --}}
                    
                                    <div style="display: none">{{ $final_patient += $total_patient }}
                                    </div>
                                    <div style="display: none">{{ $final_investigation += $total_item_qty }}
                                    </div>
                                    <div style="display: none">{{ $final_opd += 0 }}
                                    </div>
                                    <div style="display: none">{{ $final_ipd += 0 }}
                                    </div>
                                    <div style="display: none">{{ $final_corporate += 0 }}
                                    </div>
                                    <div style="display: none">{{ $final_academic += 0 }}
                                    </div>
                                    <div style="display: none">{{ $final_total += 0 }}
                                    </div>
                                    {{-- price  --}}
                                    <div style="display: none">{{ $final_patient_price += $total_patient_price }}
                                    </div>
                                    <div style="display: none">{{ $final_investigation_price += 0 }}
                                    </div>
                                    <div style="display: none">{{ $final_opd_price += 0 }}
                                    </div>
                                    <div style="display: none">{{ $final_ipd_price += 0 }}
                                    </div>
                                    <div style="display: none">{{ $final_corporate_price += 0 }}
                                    </div>
                                    <div style="display: none">{{ $final_academic_price += 0 }}
                                    </div>
                                    <div style="display: none">{{ $final_total_price += 0 }}
                                    </div>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="8">No Data Found</td>
                                </tr>
                    
                            @endif
                        </tbody>
                        <tfoot>
                            <tr>
                                <th class="text-right" colspan="3" style="text-align:right;">Total =</th>
                                <th class="text-center bg-light-blue" style="text-align: center;">
                                    <div><strong>{{ $final_patient }}</strong></div>
                                </th>
                                <th class="text-center bg-light-blue" style="text-align: center;">
                                    <div><strong>{{ $final_investigation }}</strong></div>
                                </th>
                                <th class="text-right bg-light-blue" style="text-align: right;">
                                    <div><strong>{{ number_format($final_patient_price, 2) }}</strong></div>
                                </th>
                                {{-- <th class="text-center bg-light-blue">
                                    <div>{{ number_format($total_ipd, 2) }}</div>
                                    <div><strong>{{ number_format($total_ipd_price, 2) }}</strong></div>
                                </th>
                                <th class="text-center bg-light-blue">
                                    <div>{{ number_format($total_corporate, 2) }}</div>
                                    <div><strong>{{ number_format($total_corporate_price, 2) }}</strong></div>
                                </th>
                                <th class="text-center bg-light-blue">
                                    <div>{{ number_format($total_academic, 2) }}</div>
                                    <div><strong>{{ number_format($total_academic_price, 2) }}</strong></div>
                                </th>
                                <th class="text-center bg-light-blue">
                                    <div>{{ number_format($total_total, 2) }}</div>
                                    <div><strong>{{ number_format($total_total_price, 2) }}</strong></div>
                                </th> --}}
                            </tr>
                        </tfoot>

                    </table>
                </div>
            </section>
        </div>
    </main>
</body>

</html>
