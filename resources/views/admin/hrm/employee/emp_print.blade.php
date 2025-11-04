<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>
        @if ($emp_ind == 1)
        Employee List
    @elseif($doc_ind == 1)
        Doctor List
    @elseif($ref_ind == 1)
        Referral List
    @else
        List
    @endif
    </title>
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
        <table style="width: 100%;border-spacing: 0; border:none !important;" cellpadding="1">
            <tr class="table-tr">
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



    <footer style="position: fixed;">
        <div class="footer">
            <div class="container">
                <table style="width: 100%; padding:3px; margin: 0;border:none;">
                    <tr>
                        <td style="font-size: 9px; text-align:left;border:none;">Print Date & Time: <strong>
                                <?php
                                $dta = new DateTime('now', new DateTimezone('Asia/Dhaka'));
                                $date = $dta->format('g:i A');
                                ?>
                                {{ date('d/m/Y') }} {{ $date }}
                            </strong> Printed By: <strong>{{ Session::get('user.ses_user_name') }}</strong></td>
                        <td style="font-size: 9px; text-align: right; border:none;"><strong>Powered By - H360 [NextGen]
                            </strong></td>

                    </tr>
                </table>
            </div>
        </div>
    </footer>


    <main>
        <div class="wrapper">
            <section id="lp-items">
                <div class="container">
                    <div style=" text-align:center; margin-bottom:5px; margin-top:25px ">
                        <span class="report-name" style="width:70%; border:solid black 1px; padding:10px;  ">
                            @if ($emp_ind == 1)
                                Employee List
                            @elseif($doc_ind == 1)
                                Doctor List
                            @elseif($ref_ind == 1)
                                Referral List
                            @else
                                List
                            @endif
                        </span>
                    </div>
                    <table style="width: 100%;border-collapse:collapse;" cellpadding="1" cellspacing="0" border="1">
                        <tr class="table-tr" style="background-color: #E3E3E3;">
                            <th>#SL</th>
                            <th>Image</th>
                            <th>Card No</th>
                            <th>Name</th>
                            <th>Age</th>
                            <th>Gender</th>
                            <th>Specialization</th>
                            <th>Designation</th>
                            <th>Department</th>
                            <th>Contact</th>
                            <th>Address</th>
                            <th>Status</th>



                        </tr>
                        {{-- </thead> --}}
                        {{-- <tbody> --}}

                        @if (!empty($employee_info))
                            @foreach ($employee_info as $employee)
                                <tr>
                                    <td style="text-align: center;">{{ $loop->iteration }}</td>
                                    <td>
                                        @if ($employee->photo_name != null)
                                            <img
                                                src="{{ asset('images/uploads/doctor_images/thumb/' . $employee->photo_name) }}">
                                        @else
                                            @if ($employee->gender_txt == 'Male')
                                                <img src="../public/images/doc-1.png" width="50">
                                            @else
                                                <img src="../public/images/nurse-2.png" width="50">
                                            @endif
                                        @endif

                                    </td>
                                    <td> {{ $employee->person_code }} </td>
                                    <td> {{ $employee->full_name }} </td>
                                    <td style="text-align: center;"> {{ $employee->age }} </td>
                                    <td> {{ $employee->gender_txt }} </td>
                                    <td> {{ $employee->specialization }} </td>
                                    <td> {{ $employee->designation }} </td>
                                    <td> {{ $employee->su_name }} </td>
                                    <td> <b>Phone</b> <span>{{ $employee->phone_mobile }}</span><br> <b>Email</b>
                                        <span> {{ $employee->email_personal }} </span> </td>
                                    <td> {{ $employee->pe_addr1 }} </td>

                                    <td>
                                        @if ($employee->status == 1)
                                            <span class="badge badge-md badge-success"> Active</span>
                                        @else
                                            <span class="badge badge-md badge-secondary"> Inactive</span>
                                        @endif
                                    </td>

                                </tr>
                            @endforeach
                        @endif

                        {{-- </tbody> --}}


                    </table>
                </div>
            </section>
        </div>
    </main>

</body>

</html>
