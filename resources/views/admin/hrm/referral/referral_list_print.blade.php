<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Financial Report</title>
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
    </style>
</head>

<body>
<header>
    <table style="width: 100%;" class="signature">
        <tr>
            <td style="width: 15%;">
                <img class="hospital-logo" src="{{ asset('images/uploads/hospital_images/'.$po_hospital_details->logo) }}" width="60" alt="">
            </td>
            <td style="text-align:center;">
                <span
                    style="font-size: 15px;"> <strong> {{isset($po_hospital_details->hospital_name )? $po_hospital_details->hospital_name : ""}} </strong></span>
                <br>
                Address:
                <span>  {{ isset($po_hospital_details->addrress1) ? $po_hospital_details->addrress1 : ""}}</span><br>
                Phone No:
                <span>  {{isset($po_hospital_details->telephone1) ? $po_hospital_details->telephone1 : "" }}</span>
            </td>
            <td style=" text-align:right; width: 15%; ">
                <div style="">
                    <img src="data:image/png;base64, {{ $barcode_no }} " width="100"/>
                </div>

            </td>
        </tr>
    </table>
</header>
<footer style="position: fixed;">
    <div class="footer">
        <div class="container">
            <table style="width: 100%; padding:3px; margin: 0">
                <tr>
                    <td style="font-size: 9px; text-align:left;">Print Date: <strong>
                            @php
                            date_default_timezone_set('Asia/Dhaka');
                            $date = date("d/m/Y H:m:s");
                            @endphp
                            {{$date}}
                        </strong> Printed By: <strong>{{Session::get('user.ses_user_name')}}</strong></td>
                    <td style="font-size: 9px; text-align: right;"><strong>Powered By - H360 [NextGenIT] </strong></td>
                </tr>
            </table>
        </div>
    </div>
</footer>

<main>
    <div class="wrapper">
        <div style=" text-align:center; margin-bottom:5px; margin-top:20px  " class="mb-2">
            <span class="report-name"
                  style="width:70%; border:solid black 1px; padding:10px;  "> Referral List</span>
        </div>

        <section id="lp-items">
            <div class="container">
                <table style="width: 100%;border-collapse:collapse;" border="1" cellpadding="1" cellspacing="0" >
                    <thead class="bg-soft-green">
                    <tr>
                        <th class="bg-soft-green text-center">SL#</th>
                        <th class="bg-soft-green text-left" scope="col">Image</th>
                        <th class="bg-soft-green text-left" scope="col" >Doc-ID</th>
                        <th class="bg-soft-green text-left" scope="col">Name</th>
                        <th class="bg-soft-green text-left" scope="col">Age</th>
                        <th class="bg-soft-green text-left" scope="col">Gender</th>
                        <th class="bg-soft-green text-left" scope="col">Specialization</th>

                        <th scope="col" class="bg-soft-green text-right">Department</th>
                        <th scope="col" class="bg-soft-green text-right">Contact</th>
                        <th scope="col" class="bg-soft-green text-right">Address</th>
                        <th scope="col" class="bg-soft-green text-right">Email</th>
                        <!-- <th scope="col" class="bg-soft-green text-right">Status</th> -->
                    </tr>
                    </thead>

                    <tbody>
                    @if(!empty($sql))
                        @foreach($sql as $key=>$row)
                            <tr>
                                <td class="border-1 bg-light text-center" style="text-align: center;">{{ $loop->iteration }}</td>
                                 <td class="border-1 bg-light text-left">
                                    @if($row->photo_name !=null)
                                    <img src="../public/images/uploads/doctor_images/thumb, {{$row->photo_name}}" width="50">

                                @else
                                <img src="../public/images/no-photo.png" width="50" >
                                @endif
                                </td>
                                <td class="border-1 bg-light text-left"><strong>{{ $row->person_code }}</strong></td>
                                <td class="border-1 bg-light text-left">{{ $row->full_name }}</td>
                                <td class="border-1 bg-light text-left">{{ $row->age }}</td>
                                <td class="border-1 bg-light text-left">{{ $row->gender_txt }}</td>
                                <td class="border-1 bg-light text-left">{{ $row->specialization }}</td>


                                <td class="border-1 bg-light text-right" >{{ $row->serviceunit_name }}</td>
                                <td class="border-1 bg-light text-right">{{ $row->phone_mobile }}</td>
                                <td class="border-1 bg-light text-right">{{ $row->pe_addr1 }}</td>
                                <td class="border-1 bg-light text-right">{{$row->email_personal }}</td>

                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</main>


<div class="signature_">
    <table style="width: 100%;">
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


</body>

</html>
