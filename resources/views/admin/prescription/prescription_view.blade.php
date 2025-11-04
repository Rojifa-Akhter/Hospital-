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
    <link rel="stylesheet" href="{{ URL::asset('css/reports.css') }}" media="all">
    <link rel="stylesheet" href="{{ URL::asset('css/print.css') }}" media="print">
    <link rel="stylesheet" href="{{ URL::asset('css/colors.css') }}" media="all">
    <style>

        .prescripton_view .chef_problems dl dd{
            margin-left: 20px;
            margin-bottom: 0px;
            font-size: 15px;
        }

        .prescripton_view .chef_problems dl dt{
            font-size: 15px;
        }
    </style>

</head>
<body onload="window.print();">

    <!-- <body> -->
        <div class="wrapper">
            <!-- Main content -->
            <section id="prescription">
                <div class="container">
                    <div class="row bg-primary text-white mt-3 pt-3 pb-3">
                        <div class="col-md-12 text-left d-flex ">
                            <div class="all_data">
                                <div class="comp_name">
                                    <h1>Patient Details</h1>
                                </div>
                                <div class="comp_add">
                                    <span>Patient ID : PAT-403 <br> Prescription ID : Pres-6932</span>
                                </div>
                            </div>
                            <div class="comp_logo text-right ml-auto">
                                <img class="w-100" src="{{ URL::asset('images/hospital_logo.png') }}" alt="">
                            </div>
                        </div>
                    </div>

                    @include('admin.components.patient_info_min')


                    <div class="col-md-12 mb-2">
                        <div class="row">
                            <div class="col-md-6">
                                <h4 class="display-inline-block">History :</h4> <span class="btn btn-md ml-1 bg-primary text-white"><?php echo date('d-m-Y')?></span><span class="btn btn-md ml-1 bg-primary text-white"><?php echo date('d-m-Y')?></span><span class="btn btn-md ml-1 bg-primary text-white"><?php echo date('d-m-Y')?></span>
                            </div>
                            <div class="col-md-6 text-right">
                                <h4 class="display-inline-block">Date :</h4> <span class="ml-1"><?php echo date('d-m-Y h:i:a')?></span>
                            </div>
                        </div>
                    </div>
                    <hr class="m-0">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <h4>R<sub>x</sub></h4>
                        </div>
                    </div>

                    <div class="row prescription_body">
                        <div class="col-md-12 d-flex">
                            <div class="chef_problems border-right">
                                <dl>
                                    <dt>01. Chief Complaint</dt>
                                    <dd>Abdominal Pain</dd>
                                    <dd>Back Pain</dd>

                                    <dt>02. General Examinations</dt>
                                    <dd>General Examinations-1</dd>
                                    <dd>General Examinations-4</dd>

                                    <dt>03. Investigations</dt>
                                    <dd>Investigations-2</dd>
                                    <dd>Investigations-3</dd>
                                </dl>
                            </div>

                            <div class="prescribe border-left">
                                <dl>
                                    <dt>01. CAPSULE.Zif-CI</dt>
                                    <dd>Generic Name: Zinc Sulfate + Folic Acid + Carbony Iron</dd>
                                    <dd>Instruction: (1+0+0) Before Meal For 15 Days</dd>
                                </dl>

                                <dl>
                                    <dt>02. CAPSULE.Zif-CI</dt>
                                    <dd>Generic Name: Zinc Sulfate + Folic Acid + Carbony Iron</dd>
                                    <dd>Instruction: (1+0+0) Before Meal For 15 Days</dd>
                                </dl>

                                <div class="advice">
                                    <strong>Advice :</strong> <span>Do not Do Heavy Work, Eat your dinner at least 3Hour before bedtime.</span>
                                </div>

                                <div class="nextvisit">
                                    <strong>Next Visit Date :</strong> <span>03-05-2020 ,Wednesday</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row bg-primary pt-2 pb-2">
                        <div class="col-md-12">
                            <div class="presc_footer d-flex">
                                <div class="cont_phone">
                                    <span><i class="fa fa-phone"></i>&nbsp +8801725245264</span>
                                </div>
                                <div class="cont_email ml-auto">
                                    <span><i class="fa fa-envelope"></i>&nbsp info@hcclinic.com </span>    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </body>

    </html>