<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Financial Report</title>
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

        .bg-soft-blue{
            color: #61056d;
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
    </style>

</head>

<body>
    <main>
        <div class="bg-soft-blue" style="background-color: #11c054;">
            <p style="text-align: center; font-size:25px; color: #fff;">Financial Report</p>
        </div>
        <table class="table" style="width: 100%;">
            <tr>
                <th style="width: 20%" class="border-0 p-0 text-left"><span style="font-size: 15px;">iCure Hospital</span></th>
                <td style="width: 50%" class="border-0 p-0 text-left"></td>
                <td rowspan="5" style="width: 30%">
                    <table class="table table-bordered">
                        <tr>
                            <th style="width: 40%" class="p-0 px-2 text-left bg-light">Report</th>
                            <td class="p-0 px-2 text-right">Financial</td>
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
                        <th class="bg-soft-green text-center">SL#</th>
                        <th class="bg-soft-green text-left" scope="col">Voucher</th>
                        <th class="bg-soft-green text-left" scope="col" style="width:62px;">Date</th>
                        <th class="bg-soft-green text-left" scope="col">Patient</th>
                        <th class="bg-soft-green text-left" scope="col">Age</th>
                        <th class="bg-soft-green text-left" scope="col">Gender</th>
                        <th class="bg-soft-green text-left" scope="col">Contact</th>
                        <th class="bg-soft-green text-left" scope="col">Pysiotherapist</th>
                        <th class="bg-soft-green text-left" scope="col">Referral</th>
                        <th scope="col" class="bg-soft-green text-right">Payable</th>
                        <th scope="col" class="bg-soft-green text-right">Discount</th>
                        <th scope="col" class="bg-soft-green text-right">Net Payable</th>
                        <th scope="col" class="bg-soft-green text-right">Paid</th>
                        <th scope="col" class="bg-soft-green text-right">Due</th>
                    </tr>
                </thead>

                <tbody style="border-bottom: 1px solid #000000;">
                    <tr>
                        <td class="text-center">1</td>
                        <td class="text-left" scope="col">1001</td>
                        <td class="text-left" scope="col" style="widtd:62px;">25-APR-2020</td>
                        <td class="text-left" scope="col">Asif Rahman</td>
                        <td class="text-left" scope="col">32</td>
                        <td class="text-left" scope="col">Male</td>
                        <td class="text-left" scope="col">0173283728</td>
                        <td class="text-left" scope="col">Hasan Ali</td>
                        <td class="text-left" scope="col">Dr. Jinat Billa</td>
                        <td scope="col" class="text-right">3400.00</td>
                        <td scope="col" class="text-right">400.00</td>
                        <td scope="col" class="text-right">2000.00</td>
                        <td scope="col" class="text-right">1000.00</td>
                        <td scope="col" class="text-right">0.00</td>
                    </tr>
                </tbody>
                {{-- @php
                    // $amt_in_word = new \NumberFormatter( 'en_US', \NumberFormatter::SPELLOUT);

                    $discount = number_format(0,2,".","");
                    $payment = number_format(0,2,".","");
                    $payable = number_format(($total - $discount),2,".","");
                    $due = number_format(($total - $payment),2,".","");
                @endphp --}}
            </table>
        </div>
    </main>
</body>

</html>