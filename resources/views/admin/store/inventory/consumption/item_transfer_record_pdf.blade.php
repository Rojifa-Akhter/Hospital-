<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>item transfer record</title>
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
            height: 2.0cm;
            border-bottom: 1px solid;
            padding: 0 1cm;
        }

        header img {
            /*width: 80px;*/
        }

        /** Define now the real margins of every page in the PDF **/
        body {
            margin-top: 2.0cm;
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
    @if ($print_type == 'PDF')
        <header>
            <table style="width: 100%; border:none;" class="signature">
                <tr>


                    <td style="text-align:center; border:none;">
                        <span style="font-size: 25px;"> <strong>
                                {{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }}
                            </strong></span>
                        <br>

                        <span style="font-size: 10px;">
                            Address:
                            {{ isset($po_hospital_details->addrress1) ? $po_hospital_details->addrress1 : '' }}</span><br>

                        <span style="font-size: 10px;">
                            Phone No:
                            {{ isset($po_hospital_details->telephone1) ? $po_hospital_details->telephone1 : '' }}</span>
                    </td>

                </tr>
            </table>
        </header>
        <footer>


                <div >
                    <div class="container">
                        <table style="width: 100%; padding:3px; margin: 0;border:none;">
                            <tr>
                                <td style="font-size: 9px; text-align:left;border:none;">Print Date & Time:
                                    <strong>
                                        <?php
                                        $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
                                        $date = $dt->format('g:i A');
                                        ?>
                                        {{ date('d/m/Y') }} {{ $date }}
                                    </strong> Printed By:
                                    <strong>{{ Session::get('user.ses_user_name') }}</strong>
                                </td>
                                <td style="font-size: 9px; text-align: right; border:none;"><strong>Powered By -
                                        H360
                                        [NextGen]
                                    </strong></td>

                            </tr>
                        </table>
                    </div>
                </div>

        </footer>
    @endif


    @php
        //$prev_date = date('d-m-Y', strtotime('-1 months', strtotime($from_date)));
        //$end_date = date('t-m-Y', strtotime($prev_date));
    @endphp
    <main class="">
        <div class="wrapper">

            <section id="lp-items ">
                <div class="container ">

                    <h2 style="font-size: 15px;text-align:center"><u>Item Transfer Report</u></h2> <br>
                    <br>
                    <table style="width:100%;border-collapse:collapse;" cellpadding="1" cellspacing="0" border="1">
                        <thead class="global-uhl-table-bg">
                            <tr>
                                <th class="text-center " scope="col">SL</th>
                                <th class="text-center " scope="col">Cons. Date</th>
                                <th class="text-left " scope="col">Store Name</th>
                                <th class="text-left " scope="col">Store To</th>
                                <th class="text-left " scope="col">Item Name
                                </th>
                                <th class="text-right " scope="col">Cons.Qty</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (!empty($consumption_data))
                                @foreach ($consumption_data as $data)
                                    <tr>
                                        <td style="text-align:center">{{ $loop->iteration }}</td>
                                        {{-- <td class="text-left">{{ $stock->supplier_name }}</td> --}}
                                        <td style="text-align:center">{{ date('d/m/Y', strtotime($data->trans_date)) }}</td>

                                        <td class="text-left">{{ $data->serviceunit_name_to }}</td>
                                        <td class="text-left">{{ $data->serviceunit_name }}</td>
                                        <td class="text-left">{{ $data->item_name }}</td>

                                        <td style="text-align:right">{{ $data->item_qty }}</td>
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
