<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Medical Category Print</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="" />
    <!-- custom style -->
    <link rel="stylesheet" href="{{ public_path().'/css/colors.css' }}" media="all">
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
            top: .8cm;
            height: 2.5cm;
            border-bottom:2px solid;
            color: #007FD2;
        }
        header img{ width: 70px; }

        /** Define now the real margins of every page in the PDF **/
        body {
            margin-top: 3.5cm;
            margin-left: .8cm;
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
            height: 3cm;
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

        .tbl-list td, .tbl-list th {
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

        tfoot tr td{ font-weight: bold; }
        .page-break {
            page-break-after: always;
        }
        .tbl-header { background-color: #0073b7; color: #ffffff; }

        ul {
            padding: 0;
            margin: 0;
            padding-top: 5px;
        }
        ul li{ margin-bottom: 5px; }

        .mt-5 { margin-top: 5px; }
        .mt-10 { margin-top: 10px; }
        .mt-20 { margin-top: 20px; }
        .mb-0{ margin-bottom: 0; }
        .mb-5{ margin-bottom: 15px; }
        .pb-0{ padding-bottom: 0; }
        .w-10{ width: 100%; }

        /*Appointment Serial card end*/

        .prescription-header{
            padding: 15px 10px;
            margin-top: 20px;
            border-bottom: 2px solid #003B7A;
        }

        .hospital-name {
            font-weight: 600;
            margin-bottom: 0;
            font-size: 20px;
            padding-bottom: 0;
            font-family: Helvetica, sans-serif;
        }

        .hospital-logo-info .hospital_info .hospital-address{
            font-weight: 500;
            display: block;
            line-height: 1.2;
        }

        .hospital-logo-info .hospital_info .hospital-contact{
            font-weight: 500;
            display: block;
            line-height: 1.2;
            width: 480px;
        }

        .hospital_info{
            margin-left: 10px;
        }
        .text-right{ text-align: right; }
        .text-left{ text-align: left; }
        .text-center{ text-align: center; }

        .Medical_Category {
            font-family: Arial, Helvetica, sans-serif;
            /*border-collapse: collapse;*/
            width: 100%;
        }

        .Medical_Category td, #Medical_Category th {
            /*border: 1px solid #ddd;*/
            /*padding: 5px;*/
        }

        /*.Medical_Category tr:nth-child(even){background-color: #f2f2f2;}*/

        /*.Medical_Category tr:hover {background-color: #ddd;}*/

        .Medical_Category th {
            padding-top: 5px;
            padding-bottom: 5px;
            text-align: left;
            font-size: 12px;
            /*background-color: #3051e2;*/
            color: rgb(0,0,0);
        }
    </style>
</head>
<body>
<header>
    <table>
        <tr>
            <td style="text-align: right; width: 250px;">
                <img src="{{ public_path().'/img/fav-icons/logo-icon.png' }}">
            </td>
            <td valign="top" style="text-align: center;">
                <h3 class="hospital-name">BAF Hospital Management</h3>
                <div class="hospital-address">Dhaka Cantonment, Dhaka 1206</div>
                <div class="hospital-contact">TEL : DMO-8750011 Ext-3322, Information: 8750011 Ext-4999, </div>
                <div class="hospital-contact">DDO-8750011 Ext-48781, Sena satho seba</div>
            </td>
        </tr>
    </table>
</header>
<footer>
    <table style="width: 100%; border-top: 1px solid;">
        <tr>
            <td width="37%">Printing Date & Time : {{ date("d/m/Y h:i:s a") }}</td>
            <td></td>
            <td width="33%" style="text-align: right;">Powered By - Logic Software Ltd.</td>
        </tr>
    </table>

</footer>

<main>
    <div class="wrapper">
        <section id="prescription">
            <div class="container">
                <p style = "width:100%; text-align: center; margin-bottom:20px;"><h3><strong>Current SIL/DIL Report</strong></h3></p>
                @if(!empty($sildilList))
                    <div>
                        <table class="Medical_Category">
                            <tr>
                                <td class="text-left border-0">
                                  
                                </td>

                                <td class="text-right border-0">
                                    Total Record: {{ !empty($sildilList)? count($sildilList): 0 }}
                                </td>
                            </tr>
                        </table>
                        <table class="Medical_Category" border="1">
                            <thead class="bg-black">
                            <tr>
                                <th width="" class="text-center"><strong>SL#</strong></th>
								<th width="" class="text-center"><strong>Date</strong></th>
								<th width="" class="text-center"><strong>Patient Name</strong></th>
                                <th width="" class="text-center"><strong>Service Number</strong></th>
                                <th width="" class="text-center"><strong>Age</strong></th>
                                <th width="" class="text-center"><strong>Organization</strong></th>
                                <th width="" class="text-center"><strong>Listing</strong></th>
                            </tr>
                            </thead>
                            <tbody>
                                @if(!empty($sildilList))
                                @php
                                $totalItems = !empty($sildilList)?count($sildilList):0;
                                @endphp
                                @foreach($sildilList as $record)
                                    <tr>
                                        <td class="text-center">{{$loop->iteration}}</td>
										<td class="text-left">{{!empty($record->sil_dil_date)?date('d/m/Y',strtotime($record->sil_dil_date)):null}}</td>
										<td class="text-left">{{!empty($record->patient_name_rank)?$record->patient_name_rank:''}}</td>
										<td class="text-left">{{!empty($record->service_number)?$record->service_number:''}}</td>
										<td class="text-left">{{!empty($record->age)?$record->age :''}}</td>
										<td class="text-left">{{!empty($record->service_organization)?$record->service_organization:''}}</td>
										<td class="text-left">{{!empty($record->sil_dil_ind)?$record->sil_dil_ind :''}}</td>
                                    </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                @else
                    Sorry !!! No Data Found.
                @endif
            </div>
        </section>
    </div>
</main>
</body>

</html>