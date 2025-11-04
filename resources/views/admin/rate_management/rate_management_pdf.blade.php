<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Item Rate List Print</title>
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
        <table style="width: 100%; border:none;">
            <tr style=" ">
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
            <div style=" text-align:center; margin-bottom:5px; margin-top:20px  " class="mb-2">
                <span class="report-name" style="width:70%; border:solid black 1px; padding:10px;  "> Item Rate list
                    Report</span>
            </div>
            <section id="lp-items ">
                <div class="container ">

                    <table style="width:100%;border-collapse:collapse;" cellpadding="1" cellspacing="0" border="1">
                        <thead>




                            <tr class="table-tr" style="border-top: 1px solid black">
                                <td class="table-td" style="text-align: center;" scope="col"><strong>SL</strong>
                                </td>
                                <td class="table-td" style="text-align: center;" scope="col"><strong>Item
                                        No</strong>
                                </td>
                                <td class="table-td" style="text-align: center;" scope="col"><strong>Item
                                        Type</strong>
                                </td>
                                <td class="table-td" style="text-align: center;" scope="col"><strong>
                                        Department Name</strong></td>
                                <td class="table-td" style="text-align: center; width:130px" scope="col"><strong>
                                        Item Name</strong></td>
                                <td class="table-td" style="text-align: center; " scope="col"><strong>
                                        Sale Price</strong></td>
                                <td class="table-td" style="text-align: center;" scope="col"><strong>
                                        Urgent Fee</strong></td>
                                <td class="table-td" style="text-align: center;" scope="col"><strong>
                                        Default Discount</strong></td>
                                <td class="table-td" style="text-align: center;" scope="col">
                                    <strong>Last Updated Date</strong>
                                </td>
                                <td class="table-td" style="text-align: center;" scope="col">
                                    <strong>Status</strong>
                                </td>

                            </tr>


                        </thead>
                        <tbody>

                            <?php $i = 1; ?>

                            @if (!empty($data))

                                @foreach ($data as $key => $row)
                                    <tr style="font-size: 10px">
                                        <td class="table-td" style="text-align: center; padding:3px">
                                            {{ $loop->iteration }}</td>
                                        <td class="table-td" style="text-align: left; padding:3px">
                                            {{ !empty($row->item_no_pk) ? $row->item_no_pk : '' }}
                                        </td>

                                        <td class="table-td" style="text-align: left; padding:3px">
                                            {{ !empty($row->item_type) ? $row->item_type : '' }}
                                        </td>

                                        <td class="table-td" style="text-align: left; padding:3px">
                                            {{ !empty($row->serviceunit_name) ? ucfirst($row->serviceunit_name) : '' }}
                                        </td>

                                        <td class="table-td" style="text-align: left; padding:3px">
                                            {{ !empty($row->item_name) ? ucfirst($row->item_name) : '' }}</td>
                                        <td class="table-td" style="text-align: right; padding:3px">
                                            {{ !empty($row->last_sales_price > 0) ? number_format($row->last_sales_price, 2) : 0 }}
                                        </td>
                                        <td class="table-td" style="text-align: right; padding:3px">
                                            {{ !empty($row->urgent_fee_pct) ? number_format($row->urgent_fee_pct, 2) : 0 }}
                                        </td>
                                        <td class="table-td" style="text-align: right;  padding:3px">
                                            {{ !empty($row->default_discount_pct) ? number_format($row->default_discount_pct, 2) : 0 }}
                                        </td>
                                        <td class="table-td" style="text-align: right;  padding:3px">
                                            {{ $row->last_update_date != '' ? date('d/m/y', strtotime($row->last_update_date)) : '' }}
                                        </td>

                                        <td class="table-td" style="text-align: center;  padding:3px">
                                            @if ($row->status == 1)
                                                <p>Active</p>
                                            @else
                                                <p>Inactive</p>
                                            @endif
                                        </td>


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
