@php
$ses_hospital_name = Session::get('user.ses_hospital_no_pk');
$hospital_info = App\Models\Company::find($ses_hospital_name);

@endphp


<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="" />
    <!-- custom style -->
    <link rel="stylesheet" href="" media="all">
    <style>
        @page {
            margin: 0cm 0cm;
        }

        @font-face {
            font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
            font-weight: normal;
            font-size: 11px;
            font-style: normal;
            font-variant: normal;
            src: url("font url");
        }

        /** Define the header rules **/
        header {
            position: fixed;
            top: 1cm;
            height: 2.5cm;
            border-bottom: 2px solid;
            color: #007FD2;
        }

        header img {
            width: 70px;
        }

        /** Define now the real margins of every page in the PDF **/
        body {
            margin-top: 1cm;
            margin-left: 1cm;
            margin-right: .8cm;
            margin-bottom: 7.5cm;
            font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
            font-size: 11px;
        }

        footer {
            position: fixed;
            bottom: 0cm;
            left: 1cm;
            right: 1cm;
            height: 2cm;
            text-align: center;
            font-size: 9px;
        }

        .tbl-list {
            border-top: 1px solid black;
            border-bottom: 0;
            border-left: 1px solid black;
            border-right: 0;
            border-spacing: 0px;
            border-collapse: separate;
        }

        .tbl-list td,
        .tbl-list th {
            border-bottom: 1px solid black;
            border-right: 1px solid black;
            border-top: 0;
            border-left: 0;
        }

        .tbl-list tr td:last-child {
            border-right: 1px solid black;
        }

        .tbl-list tr td:first-child {
            border-left: 0;
        }

        .tbl-list tr:first-child {
            border-top: 0;
        }

        tfoot tr td {
            font-weight: bold;
        }

        .page-break {
            page-break-after: always;
        }

        .tbl-header {
            background-color: #0073b7;
            color: #ffffff;
        }

        ul {
            padding: 0;
            margin: 0;
            padding-top: 5px;
        }

        ul li {
            margin-bottom: 5px;
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

        .mb-4 {
            margin-bottom: 10px;
        }

        .pb-0 {
            padding-bottom: 0;
        }

        /*Appointment Serial card end*/

        .prescription-header {
            padding: 15px 10px;
            margin-top: 20px;
            border-bottom: 2px solid #003B7A;
        }

        .hospital-names {
            /*font-weight: 600;*/
            margin-bottom: 0;
            font-size: 20px;
            padding-bottom: 0;
            font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
        }

        .hospital-logo-info .hospital_info .hospital-address {
            font-weight: 500;
            display: block;
            line-height: 1.2;
        }

        .hospital-logo-info .hospital_info .hospital-contact {
            font-weight: 500;
            display: block;
            line-height: 1.2;
            width: 480px;
        }

        .hospital_info {
            margin-left: 10px;
        }

        .text-right {
            text-align: right;
        }

        .border-right {
            border-right: 1px solid #000000;
        }

        .teeth-table td {
            border: 1px solid #000;
        }

        .border-less {
            border: 1px solid #fff !important;
        }

        .bg-danger {
            background-color: red;
            color: #fff;
        }

        #doc_sign p {
            margin: 0px;
            padding: 0.2px;
        }

        #doc_sign p:first-of-type {
            font-weight: bold;
        }

        .Medical_Category th {
            padding-top: 5px;
            padding-bottom: 5px;
            text-align: left;
            font-size: 12px;
            /*background-color: #3051e2;*/
            color: rgb(0, 0, 0);

        }

    </style>
</head>

<body>
    {{-- <header>
        <table>
            <tr>
                <td style="text-align: right; width: 250px;">
                    <img src="{{ public_path() . '/img/fav-icons/logo-icon.png' }}">
                </td>
                <td valign="top" style="text-align: center;">
                    <h3 class="hospital-names">{{ $hospital_info->hospital_name }}</h3>
                    <div class="hospital-address">{{ $hospital_info->addrress1 }}</div>
                    <div class="hospital-contact">TEL : {{ $hospital_info->telephone1 }} </div>
                    <div class="hospital-contact"></div>
                </td>
            </tr>
        </table>
    </header> --}}
    <footer>

        <table style="width: 100%; border-top: 1px solid;">
            <tr>
                <td width="37%">Printing Date & Time : {{ date('d/m/Y h:i:s a') }}</td>
                <td></td>
                <td width="33%" style="text-align: right;">Powered By - NextgenIT .</td>
            </tr>
        </table>
        <script type="text/php">
            $font = $fontMetrics->getFont("Arial", "normal");
                                                                			$pdf->page_text(530, 800, "Page {PAGE_NUM} of {PAGE_COUNT}", $font, 7, array(0, 0, 0));
                                                                		</script>
    </footer>

    <main>
        <div class="wrapper">
            <section id="prescription">
                <h4 style=" font-size:18px;text-align: center;padding:5px 30px;background-color:rgb(240, 240, 240);color:black;">
                    Consumption Report</h4>
                <br>
                <div class="container">
                    <table style="width: 100%; border-bottom:1px solid white;">

                        <tr>
                            <td class="text-left"><strong>Issue From : @if ($store != '')
                                        {{ isset($issue_worklist[0]->su_name_from) ? $issue_worklist[0]->su_name_from : '' }}
                                    @endif</strong></td>

                            <td class="text-left"><strong>Date From : </strong> {{ $issue_from }}</td>
                            <td class="text-left"><strong>Date To : </strong> {{ $issue_to }}</td>
                        </tr>

                    </table>
                    <br>
                    <div class="row">
                        <div class="col-12 table-responsive mt-3">
                            <table width="100%"
                                style="margin:10px auto 10px auto;border:1px solid black; border-collapse: collapse;"
                                border="1" class="Medical_Category">
                                <thead class="bg-primary">
                                    <tr>
                                        <th class="text-center ">SL</th>
                                        <th class="text-center">Issue From</th>
                                        <th class="text-center">Issue To</th>
                                        <th class="text-center">Description</th>
                                        <th class="text-center">Referance</th>
                                        <th class="text-center">Item Name</th>
                                        <th class="text-center ">UoM</th>
                                        <th class="text-center ">Item Quantity</th>

                                    </tr>
                                </thead>
                                <tbody id="adjust_worklist">
                                    @if (!empty($issue_worklist))
                                        @foreach ($issue_worklist as $row)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $row->su_name_from }}</td>
                                                <td>{{ ucfirst($row->issue_to) }}</td>
                                                <td>
                                                    @if ($row->issue_to == 'EVENT')
                                                        {{ $row->event_name }}
                                                    @elseif($row->issue_to=="STORE")
                                                        {{ $row->su_name_to }}
                                                    @else
                                                        {{ $row->patient_name_rank }}
                                                    @endif
                                                </td>
                                                <td>{{ $row->itemissue_uid }}</td>
                                                <td>{{ $row->item_name }}</td>
                                                <td>{{ $row->uom_name }}</td>
                                                <td>{{ $row->item_qty }}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>
</body>

</html>
