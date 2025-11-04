<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>iCure Priscription</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link rel="stylesheet" href="{{ URL::asset('css/font-css.css?family=Nunito') }}">
    <!-- Styles -->
    <link rel="stylesheet" href="{{ URL::asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('font/css/open-iconic-bootstrap.css') }}">
    <!-- font awesome -->
    <link rel="stylesheet" href="{{ URL::asset('css/all.min.css') }}" />
    <link rel="stylesheet" href="{{ URL::asset('font/code_39/code39_all.css') }}" />
    <!-- custom style -->
    <link rel="stylesheet" href="{{ URL::asset('css/custom.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('css/style.css') }}">
    {{-- <link rel="stylesheet" href="{{ URL::asset('css/reports.css') }}" media="all"> --}}
    <link rel="stylesheet" href="{{ URL::asset('css/print.css') }}" media="print">
    <link rel="stylesheet" href="{{ URL::asset('css/colors.css') }}" media="all">
</head>
<body onload="window.print();">
    <!-- <body> -->
        <div class="wrapper">
            <!-- Main content -->
            <section id="prescription">
                <div class="container">
                    <div class="card">
                        <div class="card-body">
                            <div class="row mt-3 pt-3 pb-3">
                                <div class="col-md-12 text-center">
                                    <h1 class="display-inline-block">Invoice</h1>
                                </div>

                                <div class="col-md-12 ">
                                    {{-- <h4 class="m-0 ml-1">Patient Information</h4> --}}
                                </div>
                                <div class="col-md-12 text-left d-flex mt-5">
                                    <div class="comp_add mt-2">
                                        <table class="table">
                                            <tr>
                                                <th class="border-0 p-0 px-2 text-left">Name</th>
                                                <th class="border-0 p-0 px-2 text-center"> : </th>
                                                <td class="border-0 p-0 px-2 text-left">Atiqul Islam</td>
                                            </tr>

                                            <tr>
                                                <th class="border-0 p-0 px-2 text-left">Age</th>
                                                <th class="border-0 p-0 px-2 text-center"> : </th>
                                                <td class="border-0 p-0 px-2 text-left" colspan="4">27 years &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Gender: </strong> Male &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Contact: </strong> 016546436</td>
                                            </tr>


                                            <tr>
                                                <th class="border-0 p-0 px-2 text-left">Phone No</th>
                                                <th class="border-0 p-0 px-2 text-center"> : </th>
                                                <td class="border-0 p-0 px-2 text-left">+880 1452619823</td>
                                            </tr>

                                            <tr>
                                                <th class="border-0 p-0 px-2 text-left">Address</th>
                                                <th class="border-0 p-0 px-2 text-center"> : </th>
                                                <td class="border-0 p-0 px-2 text-left">House 17/A, Road-17, Banani, Dhaka-1213</td>
                                            </tr>
                                        </table>

                                        <table class="table">
                                            <tr>
                                                <th class="border-0 p-0 px-2 text-left">Doctor</th>
                                                <th class="border-0 p-0 px-2 text-center"> : </th>
                                                <td class="border-0 p-0 px-2 text-left"> Hasnat Mohammad Ullah, &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <i>Cardiology,</i> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; +88 01754585654 .</td>
                                            </tr>
                                        </table>

                                        
                                    </div>

                                    <div class="invoice_details text-center ml-auto">
                                        <div class="invoice_bar_code text-center display-inline-block mb-1">
                                            <img class="w-100" src="{{ asset('images/barcode.gif') }}" alt="">
                                        </div>
                                        <table class="table table-bordered">
                                            <tr>
                                                <th class="p-0 px-2 text-left bg-light">Invoice ID &nbsp; &nbsp; :</th>
                                                <td class="p-0 px-2 text-right">0001T750</td>
                                            </tr>

                                            <tr>
                                                <th class="p-0 px-2 text-left bg-light">Date &nbsp; &nbsp; :</th>
                                                <td class="p-0 px-2 text-right"><?php echo date ('d-m-Y')?></td>
                                            </tr>

                                            <tr>
                                                <th class="p-0 px-2 text-left bg-light">Amount Due &nbsp; &nbsp; :</th>
                                                <td class="p-0 px-2 text-right">502321 <small>Tk</small></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                                <div class="col-md-12"> <hr> </div>

                                <div class="col-md-12 invoice_body">
                                    <table class="table">
                                        <thead class="bg-primary">
                                            <tr>
                                                <th class="bg-primary text-center width-50">SL#</th>
                                                <th class="bg-primary text-center width-100">Code</th>
                                                <th class="bg-primary text-left">Test Name</th>
                                                <th class="bg-primary text-center width-120">S.Room</th>
                                                <th class="bg-primary text-right width-120">Price (<small>Tk</small>)</th>
                                            </tr>
                                        </thead>

                                        <tbody class="min-height-500">
                                            <tr>
                                                <td class="border-0 text-center">01</td>
                                                <td class="border-0 text-center">306</td>
                                                <td class="border-0 text-left">Lipid Profile Serum (Fasting)</td>
                                                <td class="border-0 text-center">2</td>
                                                <td class="border-0 text-right">400.00</td>
                                            </tr>
                                            <tr>
                                                <td class="border-0 text-center">01</td>
                                                <td class="border-0 text-center">306</td>
                                                <td class="border-0 text-left">Lipid Profile Serum (Fasting)</td>
                                                <td class="border-0 text-center">2</td>
                                                <td class="border-0 text-right">400.00</td>
                                            </tr>
                                            <tr>
                                                <td class="border-0 text-center">01</td>
                                                <td class="border-0 text-center">306</td>
                                                <td class="border-0 text-left">Lipid Profile Serum (Fasting)</td>
                                                <td class="border-0 text-center">2</td>
                                                <td class="border-0 text-right">400.00</td>
                                            </tr>
                                            <tr>
                                                <td class="border-0 text-center">01</td>
                                                <td class="border-0 text-center">306</td>
                                                <td class="border-0 text-left">Lipid Profile Serum (Fasting)</td>
                                                <td class="border-0 text-center">2</td>
                                                <td class="border-0 text-right">400.00</td>
                                            </tr>

                                        </tbody>

                                        <tfoot>
                                            <tr style="border-top:2px solid #38C172">
                                                <td class="border-0" colspan="3"><strong>Remarks:</strong></td>
                                                <td class="border-0 text-right"><strong>Amount</strong></td>
                                                <td class="border-0 text-right bg-light">3300.00</td>
                                            </tr>

                                            <tr>
                                                <td class="border-0" colspan="3"><strong>Delivery Date:</strong></td>
                                                <td class="border-0 text-right"><strong>VAT</strong></td>
                                                <td class="border-0 text-right bg-light">0.00</td>
                                            </tr>

                                            <tr>
                                                <td class="border-0" colspan="3"></td>
                                                <td class="border-0 text-right"><strong>(-) Discount</strong></td>
                                                <td class="border-0 text-right bg-light">0.00</td>
                                            </tr>

                                            <tr>
                                                <td class="border-0" colspan="3"></td>
                                                <td class="border-0 text-right"><strong>Urgent Fee</strong></td>
                                                <td class="border-0 text-right bg-light">0.00</td>
                                            </tr>

                                            <tr>
                                                <td class="border-0" colspan="3"></td>
                                                <td class="border-0 text-right"><strong>S. Charge</strong></td>
                                                <td class="border-0 text-right bg-light">0.00</td>
                                            </tr>

                                            <tr>
                                                <td class="border-0"></td>
                                                <td class="border-0 text-right"><strong>In Word :</strong> </td>
                                                <td class="border-0 text-left" colspan=""><span>Thirty three thousand three hundred taka only.</span></td>
                                                <td class="border-0 text-right"><strong>Bill Amount</strong></td>
                                                <td class="border-0 text-right bg-light">3300.00</td>
                                            </tr>

                                            <tr>
                                                <td class="border-0"></td>
                                                <td class="border-0"></td>
                                                <td class="border-0"></td>
                                                <td class="border-0 text-right"><strong>Due</strong></td>
                                                <td class="border-0 text-right bg-light">3300.00</td>
                                            </tr>
                                        </tfoot>
                                    </table>

                                    <div class="table-responsive w-50">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Payment Type</th>
                                                    <th class="text-left" scope="col">Collected By</th>
                                                    <th scope="col">Mode</th>
                                                    <th scope="col">Amount</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Initial Collection</td>
                                                    <td>ADMIN</td>
                                                    <td></td>
                                                    <td>0.00</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div><strong>Prepared By :</strong> <span>ADMIN</span></div>
                                    <div><strong>Modified By :</strong> <span>ADMIN</span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </section>
        </div>
    </body>

    </html>