<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Daily Appointment Patient Report</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="{{ asset('print/pdf.css') }}" media="all">
    <style>
        @page {
            margin: 0cm 0cm;
        }
        @font-face {
            font-family: 'Helvetica';
            font-weight: normal;
            font-style: normal;
            font-variant: normal;
            src: url("font url");
        }

        /** Define the header rules **/
        header {
            position: fixed;
            top: 1cm;
            left: 1cm;
            right: 1cm;
            height: 8cm;
        }

        /** Define now the real margins of every page in the PDF **/
        body {
            margin-top: 3cm;
            margin-left: 1cm;
            margin-right: 1cm;
            margin-bottom: 2.5cm;
            font-family: Helvetica, sans-serif;
            font-size: .65rem;
            border: 1px solid #918f8f !important;
        }

        footer {
            position: fixed;
            bottom: 0cm;
            left: 0cm;
            right: 0cm;
            height: 2cm;
            text-align: center;
            font-size: 11px;
        }
        .page-break {
            page-break-after: always;
        }
        .pagenum:after {
            content: counter(page);
        }
        .doctor_info img{
            padding: 5px;
            width: 40px;
            float: left;
            border: 1px solid #222;
            border: 1px solid #95e0b3;
            margin: 0 5px;
        }

        .doctor_info .doctor_info_data{
            margin-left: 10px;
        }

        .doctor_info .doctor_info_data ul{
            margin: 0px;
        }
    </style>

</head>

<body>
    <main>
        <div class="bg-soft-blue" style="background-color: #11c054;">
            <p style="text-align: center; font-size:25px; color: #fff;">Daily Patient Appointment Report</p>
        </div>
        <table class="table" style="width: 100%;">
            <tr>
                <th style="width: 20%" class="border-0 p-0 text-left"><span style="font-size: 15px;">iCure Hospital</span></th>
                <td style="width: 50%" class="border-0 p-0 text-left"></td>
                <td rowspan="5" style="width: 30%">
                    <table class="table table-bordered">
                        <tr>
                            <th style="width: 40%" class="p-0 px-2 text-left bg-light">Report</th>
                            <td class="p-0 px-2 text-right">Daily Patient Appointment Summary</td>
                        </tr>
                        <tr>
                            <th class="p-0 px-2 text-left bg-light">Date</th>
                            <td class="p-0 px-2 text-right">{{ date('d-m-Y') }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <th class="border-0 p-0 text-left"></th>
                <td class="border-0 p-0 text-left" colspan="0"></td>
            </tr>


            {{-- <tr>
                <th class="border-0 p-0 px-2 text-left">Phone No</th>
                <td class="border-0 p-0 px-2 text-left">: +880 1452619823</td>
            </tr> --}}

            {{-- <tr>
                <th class="border-0 p-0 px-2 text-left">Address</th>
                <td class="border-0 p-0 px-2 text-left">: House 17/A, Road-17, Banani, Dhaka-1213</td>
            </tr> --}}
            <tr>
                <th class="border-0 p-0 px-2 text-left"></th>
                <td class="border-0 p-0 px-2 text-left"> <i></i></td>
            </tr>
        </table>
        <div class="invoice_body">
            <table class="table">
                <thead class="bg-soft-green">
                    <tr>
                        <th class="text-center" scope="col">SL</th>
                        <th class="text-left" scope="col">Code</th>
                        <th class="text-left" scope="col" style="width:62px;">Date</th>
                        <th class="text-left" scope="col">Patient</th>
                        <th class="text-left" scope="col">Doctor</th>
                        <th class="text-left" scope="col">Chif Complain</th>
                        <th class="text-left" scope="col">Status</th>
                    </tr>
                </thead>

                <tbody>
                    @if(!empty($report_data))
                    @foreach($report_data as $key=>$row)
                    <tr>
                        <td class="text-center bg-light">{{ $loop->iteration }}</td>
                        <td class="text-left">{{ $row->appoint_code }} </td>
                        <td class="text-left">{{ $row->appoint_date }}</td>
                        <td class="text-left">
                            <div class="doctor_info">
                                <img src="{{asset ('images/doctor.png')}}" alt="doctor image" class="rounded" >
                                <div class="doctor_info_data">
                                    <ul style="list-style: none;">
                                        <li><strong>{{ $row->patient_code }} :</strong> {{ $row->patient_name }}</li>
                                        <li><strong>G: </strong>{{ $row->gender_txt }}, <strong>Ph: </strong>{{ $row->mobile1 }},<strong>Age: </strong>{{ $row->age }}</li>
                                    </ul>
                                </div>
                            </div>
                        </td>
                        <td class="text-left">
                            <div class="doctor_info">
                                <img src="{{asset ('images/doctor.png')}}" alt="doctor image" class="rounded" >
                                <div class="doctor_info_data">
                                    <ul style="list-style: none;">
                                        <li>{{ $row->full_name }}</li>
                                        <li><i>{{ $row->specialization }},</i> <strong>Ph :</strong> {{ $row->phone_mobile }}</li>
                                    </ul>
                                </div>
                            </div>
                        </td>
                        <td>{{ $row->chif_complain }}</td>
                        <td>
                            @if($row->cancel_ind == 1)
                            <span class="badge badge-danger">Canceled</span>
                            @elseif($row->cancel_ind == 0)
                            <span class="badge badge-primary">Proceed</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                @else
                <tr>
                    <th class="text-center" scope="col" colspan="11">No Data Available</th>
                </tr>
                @endif
                </tbody>
            </table>
        </div>
    </main>
    <footer>
        <span class="pagenum"></span>
    </footer>
</body>

</html>