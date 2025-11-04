

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
            z-index: 999999999;

            left: 0;
            right: 0;
            height: 3cm;
            text-align: center;
            font-size: 9px;
            bottom: -130px;
            border-top: 1px solid black;
            padding-top: 10px;
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

        .table td,
        .table th{
            padding: 5px!important;
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
    						<div class="" style=" height: 180px; margin: 10px 0px;">
    							<div class="patient-information d-flex align-items-center">
    								<div class="text-left">
    									<ul style="list-style: none; padding-left: 0;">
                                            <li style="margin-top: 5px;"><i style="color: blue;"><b>Customer Copy</b></i></li>
                                            <li style="margin-top: 5px;"><b>Date :</b>&nbsp;<span>11-12-2021 (8:30:00PM)</span></li>
                                            <li style="margin-top: 5px;"><b>Bill No :</b>&nbsp;<span>0120136542</span></li>
                                            <li style="margin-top: 5px;"><b>Name :</b>&nbsp;<span>Akhtaruzzaman Bappy</span> </li>
                                            <li style="margin-top: 5px;"><b>Age :</b>&nbsp;<span>40Y-08M-12D</span> </li>
                                            <li style="margin-top: 5px;"><b>Gender :</b>&nbsp;<span>Male</span> </li>
                                            <li style="margin-top: 5px;"><b>Contact No :</b>&nbsp;<span>+880 1251462542</span></li>
                                            <li style="margin-top: 5px;"><b>Ref. By :</b>&nbsp;<span>Dr.MD. Jahangir Kabir,  MBBS, BCS, FCPS</span> </li>
                                            <li style="margin-top: 5px;"><b>Sec. Ref. :</b>&nbsp;<span></span> </li>
                                        </ul>
                                    </div>

                                    <div class="text-right">
                                       <ul style="list-style: none; padding-left: 0;">
                                          <li><i>11-12-2021 (8:30:00PM)</i> </li>
                                          <li><img src="{{ asset('images/barcode.gif') }}" alt="" style="width: 120px; margin: 5px 0px;"></li>
                                          <li><i style="color: blue;"><b>Duplicate Copy</b></i></li>
                                      </ul>
                                  </div>
                              </div>
                          </div>



                          <div class="form-body">
                             {{-- <div class="heading text-center border-bottom mb-10"><h2>Hospital and Consultant Bill</h2></div> --}}
                             <table class="table mt-3">
                                <thead>
                                   <tr class="">
                                      <th class="text-left">SL</th>
                                      <th class="text-center">Code</th>
                                      <th class="text-left" colspan="2">Test Name</th>
                                      <th class="text-center">Room No.</th>
                                      <th class="text-right">Amount</th>
                                  </tr>
                              </thead>
                              <tbody style="border-top: 1px solid #222!important; border-bottom: 1px solid #222!important;">
                                <tr>
                                  <td class="text-left">01</td>
                                  <td class="text-center">01106</td>
                                  <td class="text-left" colspan="2">Random Glucose</td>
                                  <td class="text-center">203(Lavel-2)</td>
                                  <td class="text-right">100.00</td>
                              </tr>

                              <tr>
                                  <td class="text-left">02</td>
                                  <td class="text-center">01106</td>
                                  <td class="text-left" colspan="2">Random Glucose</td>
                                  <td class="text-center">203(Lavel-2)</td>
                                  <td class="text-right">100.00</td>
                              </tr>

                              <tr>
                                  <td class="text-left">03</td>
                                  <td class="text-center">01106</td>
                                  <td class="text-left" colspan="2">Random Glucose</td>
                                  <td class="text-center">203(Lavel-2)</td>
                                  <td class="text-right">100.00</td>
                              </tr>

                              <tr>
                                  <td class="text-left">04</td>
                                  <td class="text-center">01106</td>
                                  <td class="text-left" colspan="2">Random Glucose</td>
                                  <td class="text-center">203(Lavel-2)</td>
                                  <td class="text-right">100.00</td>
                              </tr>

                              <tr>
                                  <td class="text-left">05</td>
                                  <td class="text-center">01106</td>
                                  <td class="text-left" colspan="2">Random Glucose</td>
                                  <td class="text-center">203(Lavel-2)</td>
                                  <td class="text-right">100.00</td>
                              </tr>
                              <tr>
                                  <td class="text-left">01</td>
                                  <td class="text-center">01106</td>
                                  <td class="text-left" colspan="2">Random Glucose</td>
                                  <td class="text-center">203(Lavel-2)</td>
                                  <td class="text-right">100.00</td>
                              </tr>

                              <tr>
                                  <td class="text-left">02</td>
                                  <td class="text-center">01106</td>
                                  <td class="text-left" colspan="2">Random Glucose</td>
                                  <td class="text-center">203(Lavel-2)</td>
                                  <td class="text-right">100.00</td>
                              </tr>

                              <tr>
                                  <td class="text-left">03</td>
                                  <td class="text-center">01106</td>
                                  <td class="text-left" colspan="2">Random Glucose</td>
                                  <td class="text-center">203(Lavel-2)</td>
                                  <td class="text-right">100.00</td>
                              </tr>

                              <tr>
                                  <td class="text-left">04</td>
                                  <td class="text-center">01106</td>
                                  <td class="text-left" colspan="2">Random Glucose</td>
                                  <td class="text-center">203(Lavel-2)</td>
                                  <td class="text-right">100.00</td>
                              </tr>

                              <tr>
                                  <td class="text-left">05</td>
                                  <td class="text-center">01106</td>
                                  <td class="text-left" colspan="2">Random Glucose</td>
                                  <td class="text-center">203(Lavel-2)</td>
                                  <td class="text-right">100.00</td>
                              </tr>


                          </tbody>
                          <tfoot>

                              <tr>
                                  <th class="text-left" rowspan="3" colspan="4" style="padding: 5px;">
                                    <span style="font-size: 50px; line-height: 1; border: 5px solid
                                    #dee2e6; border-left-color: #dee2e6; color: #dee2e6; padding: 10px; margin: 10px;">PAID</span>
                                </th>
                                <td class="text-right"><b>Item Total Tk. :</b></td>
                                <td class="text-right">2100.00</td>
                            </tr>

                            <tr>
                              <td class="text-right"><b>(-)Discount Tk. :</b></td>
                              <td class="text-right">100.00</td>
                          </tr>

                          <tr>
                              <td class="text-right"><b>Net Payable Tk. :</b></td>
                              <td class="text-right">2000.00</td>
                          </tr>

                          <tr>
                            <td class="text-left" rowspan="2" colspan="4"><b>In Word :</b> Two Thousand One Hundred Taka Only</td>
                            <td class="text-right"><b>Total Payment Tk. :</b></td>
                            <td class="text-right">2000.00</td>
                        </tr>

                        <tr>
                          <td class="text-right"><b>Due Tk. :</b></td>
                          <td class="text-right">0.00</td>
                      </tr>

                  </tfoot>
              </table>
          </div>


          <div class="total-calculation" style="border: 1px solid #dee2e6; padding: 10px; margin-top: 10px;">
             <table class="table table-bordered mt-3">
                <tbody>
                  <tr>
                      <td class="text-left"><b>Initial Collection</b></td>
                      <td class="text-center"><b>ADMIIN</b></td>
                      <td class="text-center"><b>CASH</b></td>
                      <td class="text-right">12749.00</td>
                  </tr>
                  <tr>
                    <td class="text-left"><b>Due Collection</b></td>
                    <td class="text-center"><b>ADMIIN</b></td>
                    <td class="text-center"><b>CASH</b></td>
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


<footer>
    <!-- <hr style="border: 0.5px solid #000000"> -->
    <div class="">
        <span style="float:left"><b>Printing Date & Time:</b>{{ date('d/m/Y H:i:s') }} &nbsp; <b>Prepared By :</b> NG ADMIN
            <span style="float:right">Powered By: NEXTGEN IT</span>
        </div>
    </footer>