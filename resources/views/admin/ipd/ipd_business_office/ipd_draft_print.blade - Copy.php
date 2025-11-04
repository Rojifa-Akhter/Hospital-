

<style>
	.custom_inline_input{
		border: 0px;
		outline: 0;
		background-color: transparent;
		border-bottom: 1px dotted #222;
		/*display: block;*/
	}
	.custom_inline_input2{
		width: 465px;
	}
	.w-30{
		width: 30%
	}
	.w-50px{
		width: 50px
	}
	.w-100px{
		width: 100px
	}

	.v-align-top{
		vertical-align: top!important;
	}

	table tr{
		border-bottom: none;
	}

	.instraction-page > ul > li{
		margin-bottom: 20px;
	}
</style>


<style>
  /*  @page {
        margin: 1cm 0.3cm;
        /!*width: 450px;*!/
        padding:8px;
        }*/
        @page {
        	/*margin-top: 150px;*/
        	/*margin-bottom: 120px*/
        }
        .header {
        	position: fixed;
        	left: 0px;
        	top: -140px;
        	right: 0px;
        	height: 150px;
        	text-align: center;
        }

        /*#footer { position: fixed; left: 0px; bottom: 0; right: 0px; }*/

        footer {
        	position: fixed;

        	left: 0;
        	right: 0;
        	height: 3cm;
        	text-align: center;
        	font-size: 9px;
        	bottom: -200px;
        }
        body {
        	/*margin-top: 5.5cm;*/
        	margin-left: 0cm;
        	margin-right: 0cm;
        	/*margin-bottom: 3.5cm;*/
        	font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
        	font-size: 10px;
        }

        .bg-black{
        	background-color: #222;
        	color: #fff;
        }


        table{
        	border-collapse:collapse;
        	width: 100%;

        }

        table tr td,
        table tr th{
        	font-size: 11px;
        	border:0;
        	font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
        	padding: 2px;
        	/*border-width: thin;*/
        }
        .custom_inline_input{
        	border: 0px;
        	outline: 0;
        	background-color: transparent;
        	border-bottom: 1px dotted #222;
        }	


        .border-0{
        	border:0px;
        }
        .text-center{
        	text-align: center!important;
        }
        .text-left{
        	text-align: left!important;
        }
        .text-right{
        	text-align: right!important;
        }
        .w-100{
        	width: 100%;
        }

        .w-5{
        	width: 5%;
        }
        .w-10{
        	width: 10%;
        }
        .w-15{
        	width: 15%;
        }
        .w-20{
        	width: 20%;
        }

        .w-25{
        	width: 25%;
        }

        .w-30{
        	width: 30%;
        }

        .w-50{
        	width: 50%;
        }
        .w-100{
        	width: 100%;
        }
        .mb-10{margin-bottom: 10px;}
        .mt-5 { margin-top: 5px; }
        .mt-10 { margin-top: 10px; }
        .mt-20 { margin-top: 20px; }
        .mb-0{ margin-bottom: 0; }
        .mb-15{ margin-bottom: 15px; }
        .mb-10{ margin-bottom: 10px; }
        .pb-0{ padding-bottom: 0; }


        .logo{
        	width: 80px;
        	display: inline-block;
        }
        .d-flex{
        	display: flex;
        }

        .align-items-center{
        	align-items: center;
        }

        .hospital-names {
        	margin-bottom: 0;
        	font-size: 20px;
        	padding-bottom: 0;
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
        .text-uppercase{
        	text-transform: uppercase; 
        }
        .title{
        	/*background-color: #444;*/
        	/*display: inline-block;*/
        	font-size: 14px;
        	color: #000;
        	padding: 5px 50px;
        	border-radius: 3px;
        	/*font-weight: bold;*/
        }

        .form-heading .title-name{
        	font-size: 1.35rem;
        	line-height: 1;
        	margin-top:30px;
        	margin-bottom:20px;
        }

        .form-heading h5{
        	font-size: 1rem;
        	/*line-height: 1;*/
        	margin-top:-10px;
        	font-weight: 400;
        }
        .form-heading p{
        	font-size: .8rem;
        	margin-top: -10px;
        }
        .form-name{
        	font-size: 16px;
        }

        .float-left{
        	float: left;
        }

        .float-right{
        	float: right;
        }

        .d-block{
        	display: block;
        }
        .d-inline-block{
        	display: inline-block;
        }
        .border-1{
        	border:1px solid;
        }
        .border-bottom{
        	border-bottom: 1px solid #dee2e6;
        }

        .justify-content-between{
        	justify-content: space-between;
        }
        .signature{
        	width: 100%;
        	height: 30px;
        	margin-top: 20px;
        	margin-bottom: 10px;
        }

        .border-right{
        	border-right: 1px solid #222;
        }

        .form-check-inline {
        	display: inline-block;
        	align-items: center;
        	padding-left: 0;
        	margin-right: 0.2rem;
        }

        .form-check {
        	position: relative;
        }

        .form-check-inline .form-check-input {
        	position: static;
        	margin-top: 5px;
        	/*margin-right: 0.3125rem;*/
        	margin-left: 0;
        }
        input[type=radio], input[type=checkbox] {
        	box-sizing: border-box;
        	padding: 0;
        }
        .v-align-top{
        	vertical-align: top;
        }

        .table-bordered td,
        .table-bordered th{
        	border: 1px solid #222
        }
    </style>


    <div class="container-fluid">
    	<div class="form-row justify-content-center">
    		<div class="col-md-9">
    			<div class="card border-0 shadow-sm">
    				<div class="card-body p-4">
    					<div class="form-content">
    						<div class="form-heading text-center border-bottom pb-3">
    							<div class="hospital-address">
    								<h1 class="mb-0 text-center">Khwaja Badrudduja Modern Hospital</h1> <br>
    								<p class="mb-0 text-center">Aziz Mansion, Shufipur, Kaliakair, Gazipur.</p> <br>
    								<p class="mb-0 text-center">Phone : 01776-606262, 01687-625565</p> <br>
    							</div>
    						</div>
    						<div class="" style="border: 1px solid #dee2e6; height: 140px; padding: 10px; margin-top: 10px;">
    							<div class="patient-information d-flex align-items-center">
    								<div class="text-left">
    									<ul style="list-style: none; padding-left: 0;">
    										<li><b>Admission ID :</b>&nbsp;<span>0120136542</span></li>
    										<li><img src="{{ asset('images/barcode.gif') }}" alt="" style="width: 120px; margin: 5px 0px;"></li>
    										<li><b>Name :</b>&nbsp;<span>Akhtaruzzaman Bappy</span> </li>
    										<li><b>Age :</b>&nbsp;<span>40Y-08M-12D</span> </li>
    										<li><b>Gender :</b>&nbsp;<span>Male</span> </li>
    										<li><b>Bed :</b>&nbsp;<span></span> 101(Ward: General)</li>
    										<li><b>Con. Name :</b>&nbsp;<span>KBMH</span> </li>
    									</ul>
    								</div>
    								<div class="text-right">
    									<ul style="list-style: none; padding-left: 0;">
    										<li><b>Patient ID :</b>&nbsp;<span>632159871232</span> </li>
    										<li><img src="{{ asset('images/barcode.gif') }}" alt="" style="width: 120px; margin: 5px 0px;"></li>
    										<li><b>Phone :</b>&nbsp;<span>01726500000</span> </li>
    										<li><b>Date Of Admission :</b>&nbsp;<span>11-12-2021 (8:30:00PM)</span> </li>
    									</ul>
    								</div>
    							</div>
    						</div>



    						<div class="form-body">
    							<div class="heading text-center border-bottom mb-10"><h2>Hospital and Consultant Bill</h2></div>
    							<table class="table table-bordered mt-3">
    								<thead>
    									<tr class="bg-black">
    										<th class="text-center">SL</th>
    										<th class="text-left">Service Type</th>
    										<th class="text-left" colspan="2">Description</th>
    										<th class="text-right">Amount</th>
    									</tr>
    								</thead>
    								<tbody>
    									<tr>
    										<td class="text-center">01</td>
    										<td class="text-left">Hospital</td>
    										<td class="text-left" colspan="2">Admission Fee</td>
    										<td class="text-right">100.00</td>
    									</tr>
    									<tr>
    										<td class="text-center">02</td>
    										<td class="text-left">Rent</td>
    										<td class="text-left" colspan="2"> (Ward: General) 101 x 1day</td>
    										<td class="text-right">600.00</td>
    									</tr>
    									<tr>
    										<td class="text-center">03</td>
    										<td class="text-left">Hospital</td>
    										<td class="text-left" colspan="2">Duty Doctor Charge</td>
    										<td class="text-right">200.00</td>
    									</tr>
    									<tr>
    										<td class="text-center">04</td>
    										<td class="text-left">Hospital</td>
    										<td class="text-left" colspan="2">Service Charge</td>
    										<td class="text-right">100.00</td>
    									</tr>
    									<tr>
    										<td class="text-center">05</td>
    										<td class="text-left">Hospital</td>
    										<td class="text-left" colspan="2">Amount for Process (Bed, Rent, Duty Doctor & Service Charge)</td>
    										<td class="text-right">1000.00</td>
    									</tr>

    									<tr>
    										<td class="text-center" rowspan="3" colspan="3"><b>Due In Word :</b> Two Thousand One Hundred Taka Only</td>
    										<td class="text-right"><b>Bill :</b></td>
    										<td class="text-right">2100.00</td>
    									</tr>

    									<tr>
    										<td class="text-right"><b>Paid :</b></td>
    										<td class="text-right">0.00</td>
    									</tr>

    									<tr>
    										<td class="text-right"><b>Due :</b></td>
    										<td class="text-right">2100.00</td>
    									</tr>

    									<tr>
    										<td class="text-center">06</td>
    										<td class="text-left">Investigation</td>
    										<td class="text-left" colspan="2">Charge</td>
    										<td class="text-right">2850.00</td>
    									</tr>

    									<tr>
    										<td class="text-center" rowspan="3" colspan="3"><b>Due In Word :</b> Two Thousand Eight Hundred Fifty Taka Only</td>
    										<td class="text-right"><b>Bill :</b></td>
    										<td class="text-right">2850.00</td>
    									</tr>

    									<tr>
    										<td class="text-right"><b>Paid :</b></td>
    										<td class="text-right">0.00</td>
    									</tr>

    									<tr>
    										<td class="text-right"><b>Due :</b></td>
    										<td class="text-right">2850.00</td>
    									</tr>

    									<tr>
    										<td class="text-center">07</td>
    										<td class="text-left">Pharmacy</td>
    										<td class="text-left" colspan="2">Bill</td>
    										<td class="text-right">7799.00</td>
    									</tr>

    									<tr>
    										<td class="text-center" rowspan="3" colspan="3"><b>Due In Word :</b> Seven Thousand Seven Hundred Ninety Nine Taka Only</td>
    										<td class="text-right"><b>Bill :</b></td>
    										<td class="text-right">7799.00</td>
    									</tr>

    									<tr>
    										<td class="text-right"><b>Paid :</b></td>
    										<td class="text-right">0.00</td>
    									</tr>

    									<tr>
    										<td class="text-right"><b>Due :</b></td>
    										<td class="text-right">7799.00</td>
    									</tr>
    								</tbody>
    							</table>
    						</div>


    						<div class="total-calculation" style="border: 1px solid #dee2e6; padding: 10px; margin-top: 10px;">
    							<table>
    								<tbody>
    									<tr>
    										<th class="text-left" rowspan="5"><span style="font-size: 60px; line-height: 1; border: 5px solid
    										#dee2e6; border-left-color: #dee2e6; color: #dee2e6; padding: 10px;">DRAFT</span></th>
    									</tr>
    									<tr>
    										<td class="text-right"><b>Total Amount :</b></td>
    										<td class="text-right">12749.00</td>
    									</tr>

    									<tr>
    										<td class="text-right"><b>Total Paid :</b></td>
    										<td class="text-right">0.00</td>
    									</tr>

    									<tr>
    										<td class="text-right"><b>Discount & Adjustment :</b></td>
    										<td class="text-right">0.00</td>
    									</tr>

    									<tr>
    										<td class="text-right"><b>Receivable :</b></td>
    										<td class="text-right">12749.00</td>
    									</tr>

    									
    								</tbody>
    							</table>
    						</div>
    					</div>
    				</div>
    			</div>
    		</div>
    	</div>
    </div>