<link rel="stylesheet" href="{{asset('uhl_assets/css/uhl_style.css')}}">
<div class="container-fluid">
    <div class="row ">
        <div class="col-xs-12 col-sm- 12 col-md-12 col-lg-12 col-xl-12">
            <div class="card shadow-sm mt-1" id="amount_info">
                <div class="card-body p-1">
                    <div class="right_side">
                        <div class="form-row">
                            <div class="col-md-12 mt-2">
                                @php
                                    $discount_apply=Session::get('user.ses_hospital_code')=="KPJ" ? '' :'d-none';
                                @endphp
                                <div class="form-row  <?= $discount_apply?>">
                                    <div class="col-md-3 ">
                                        <div class="form-group">
                                            <div class="input-group mb-2">
                                                <div class="input-group-prepend">
                                                    <label class="input-group-text" for="cmb_discount">Discount&nbsp;&nbsp;</label>
                                                </div>
                                                <select class="custom-select keep_me" id="cmb_discount" name="cmb_discount" style="height:auto!important;">
                                                    <option value="0">Discount Type</option>
                                                    @if (!empty($disctype))
                                                    @foreach ($disctype as $key => $dtype)
                                                    <option value="{{ $key }}" {{ $key == 'GENERAL' ? 'selected' : '' }}>
                                                        {{ $dtype }}
                                                    </option>
                                                    @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2 percent_hospital">
                                        <div class="input-group  mb-2">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1">%</span>
                                            </div>
                                            <input type="text" class="form-control text-right number_only hospital_disc" id="discount_percent_hospital" name="discount_percent_hospital" placeholder="Hospital" onkeyup="" value="{{ isset($patientId->maximum_percent) ? $patientId->maximum_percent : 0 }}" />
                                            {{-- && isset($patientId->applied_consult_ind) && $patientId->applied_consult_ind == 1 --}}
                                        </div>
                                    </div>
                                    <div class="col-md-2 percent_hospital">
                                        <input type="text" class="form-control text-right number_only hospital_disc" id="discount_amount_hospital" name="discount_amount_hospital" placeholder="Amount" onkeyup="calculateTotalDis(this)" value="">
                                    </div>
                                    <div class="form-group col-md-2 d-none percent_doctor">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1">%</span>
                                            </div>
                                            <input type="text" class="form-control text-right number_only doctor_disc" id="discount_percent_doctor" name="discount_percent_doctor" placeholder="Doctor" onkeyup="" onkeyup="" value="" />
                                        </div>
                                    </div>
                                    <div class="form-group col-md-2 d-none percent_doctor">
                                        <input type="text" class="form-control text-right number_only doctor_disc" id="discount_amount_doctor" name="discount_amount_doctor" placeholder="Amount" onkeyup="calculateTotalDis(this)" value="">
                                    </div>
                                  
                                </div>
                                 @php
                                    $textHide=  strtoupper($bill_type) == "IPD"  || strtoupper($bill_type) == "OT"? 'd-none':'';
                                @endphp
                                <div class="form-row <?= $textHide ?> ">
                                    <div class="col-md-3">
                                        <div class="form-group form-row">
                                            <!-- <label for="dis_doctor_code" class="col-sm-4 col-form-label">Discount By</label> -->
                                            <div class="col-sm-12">
                                                <input type="text" name="" placeholder="Discount By" id="dis_doctor_code" class="form-control" value="">
                                                <input type="hidden" name="hdn_dis_doctor_id" id="hdn_dis_doctor_id" value="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2 ">
                                        <div class="form-group form-row">
                                            <!-- <label for="dis_requ_by" class="col-sm-4 col-form-label">Request By</label> -->
                                            <div class="col-sm-12">
                                                <input type="text" name="dis_requ_by" placeholder=" Request By" id="dis_requ_by" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    @php
                                    $hospital_code = DB::table('WSEC_HOSPITAL')->first()->hospital_code;
                                    @endphp
                                    @if ($hospital_code != 'IMPALA')
                                    <div class="col-md-2">
                                        <div class="form-group form-row">
                                            <!-- <label for="bill_remarks" class="col-sm-4 col-form-label">Remarks</label> -->
                                            <div class="col-sm-12">
                                                <input type="text" name="bill_remarks" placeholder="Remarks" id="bill_remarks" class="form-control" >
                                                <!-- value="{{ $po_hospital_details->discount_remarks_voucher }} " -->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 d-none">
                                        <div class="form-group form-row">
                                            <label for="raport_delivery_date" class="col-md-4 col-form-label">Delivery Date</label>
                                            <div class="col-sm-6">
                                                <input type="text" name="raport_delivery_date" placeholder="dd-mm-yyyy" id="raport_delivery_date" class="form-control date_picker">
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                          
                            <div class="col-md-12 mt-3 <?= $textHide ?>">
                                <div class="clearfix">
                                    <!-- <div align="center"><i class="fas fa-money-bill-alt" style="font-size: 20px;color: #60c57f;"></i></div> -->
                                    <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                                        <div class="btn-group bg-none w-100" data-toggle="buttons" aria-label="First group">
                                            @if (!empty($paymodes))
                                            @foreach ($paymodes as $key => $paymode)
                                            <label class="btn btn-outline-primary payMode bg-none <?= $key == 'CS' ? 'active' : ' '?>">
                                                <input type="radio" name="pay_mode" id="option" class="keep_me" value="{{ $key }}" {{ $key == 'CS' ? 'checked' : ' ' }}>
                                                {{ $paymode }}
                                            </label>
                                            @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row border-top mt-1">
                                    <div class="col-md-12">
                                        <div class="" id="cash">
                                            <div class="form-row">
                                                <div class="col-md-3">
                                                   <div class="mb-2 mt-2">
                                                       <input type="text" class="form-control cash_amount number_only " name="cash_amount" id="cash_amount" value="" placeholder="Paid Amount" onkeyup="billingEngine.calculatePayment(this)">
                                                   </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="mb-2 mt-2">
                                                        <input type="text" class="form-control number_only" id='cash_bd_amount' placeholder="Given Amount" onkeyup="billingEngine.calculatePayment(this)">
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="mb-2 mt-2">
                                                        <input type="text" id="change_amount" class="form-control number_only" placeholder="Change Amount">
                                                    </div>
                                                </div>

                                                <div class="col-md-1">
                                                    <div class=" float-right mt-1 text-white">
                                                        <button type="button" onkedown="addFuntion(this)" onclick="addFuntion(this)" name="cash_amount" id="cash_add" class="global_add_btn"><i class="fas fa-plus"></i> Add </button>
                                                    </div>
                                                </div>

                                            </div>



                                            <!-- <button type="button" name="cash_amount" id="cash_add"  onclick="addFuntion(this)">Add</button> -->

                                        </div>
                                        <div id="payment_method_cheque" class="d-none">
                                            <div class="form-row">
                                                <div class="col-md-2">
                                                    <div class="cheque_field mb-2 mt-2">
                                                        <input type="text" class="form-control check_amount number_only" name="check_amount" id="check_amount" checked="checked" value="" placeholder="Amount">
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="cheque_field mb-2 mt-2">
                                                        <select class="form-control select2 payment_method_1" id="bank_name" name="bank_name">
                                                            <option value="">Bank name</option>
                                                            @if ($bank_name)
                                                            @foreach ($bank_name as $value)
                                                            <option value="{{ $value }}">
                                                                {{ $value }}
                                                            </option>
                                                            @endforeach
                                                            @endif
                                                        </select>
                                                        <!-- <input type="text" class="form-control payment_method_1 " name="bank_name" id="bank_name" checked="checked" value="" placeholder="Bank Name"> -->
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="cheque_field mb-2 mt-2">
                                                        <input type="text" class="form-control payment_method_1
                                                                                        " name="holder_name" id="holder_name" checked="checked" value="" placeholder="Holder Name">
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="cheque_field mb-2 mt-2">
                                                        <input type="text" class="form-control payment_method_1" name="check_no" id="check_no" checked="checked" value="" maxlength="16" placeholder="Cheque No">
                                                    </div>
                                                </div>

                                                <div class="col-md-1">
                                                   <!-- <span class="btn btn-md btn-success float-right mt-2" name="check_amount" id="check_add" onclick="addFuntion(this)" >Add</span> -->
                                                   <div class=" float-right mt-1 text-white">
                                                       <button type="button" onkedown="addFuntion(this)" onclick="addFuntion(this)" value="" name="check_amount" id="check_add" class="global_add_btn"><i class="fas fa-plus"></i> Add </button>
                                                   </div>
                                                </div>
                                            </div>

                                        </div>




                                        <div class="d-none" id="payment_method_card">
                                            <div class="form-row">
                                                <div class="col-md-2">
                                                    <select class="form-control mb-2 mt-2" id="card_type" name="card_type">
                                                        <option value="">Card Type</option>
                                                        @if (!empty($card_type))
                                                            @foreach ($card_type as $key => $item)
                                                                <option value="{{$item}}">{{$item}}</option>
                                                            @endforeach                                                              
                                                        @endif
                                                       
                                                    </select>
                                                </div>

                                                <div class="col-md-2">
                                                    <div class="cheque_field mb-2 mt-2">
                                                        <input type="text" class="form-control card_amount number_only" name="card_amount" id="card_amount" checked="checked" value="" placeholder="Amount">
                                                    </div>
                                                </div>

                                                <div class="col-md-2">
                                                    <div class="cheque_field mb-2 mt-2">
                                                        <select class="form-control select2 bank_name_card" id="bank_name_card" name="bank_name_card">
                                                            <option value="">Bank name</option>
                                                            @if ($bank_name)
                                                            @foreach ($bank_name as $value)
                                                            <option value="{{ $value }}">
                                                                {{ $value }}
                                                            </option>
                                                            @endforeach
                                                            @endif
                                                        </select>
                                                        <!-- <input type="text" class="form-control payment_method_1 " name="bank_name_card" id="bank_name_card" checked="checked" value="" placeholder="Bank Name"> -->
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="cheque_field mb-2 mt-2">
                                                        <input type="text" class="form-control payment_method_1
                                                                                        " name="holder_name" id="card_holder_name" checked="checked" value="" placeholder="Holder Name">
                                                    </div>
                                                </div>

                                                <div class="col-md-2">
                                                    <div class="card-field mb-2 mt-2">
                                                        <input type="text" class="form-control payment_method_2 " name="card_no" id="card_no" value="" placeholder="Card No (minimum 4 digits)" minlength="4" maxlength="23">
                                                    </div>
                                                </div>

                                                <div class="col-md-1">
                                                    <!-- <span class="btn btn-md btn-success float-right mt-2" name="card_amount" id="card_add" onclick="addFuntion(this)">Add</span> -->
                                                    <div class=" float-right mt-1 text-white">
                                                        <button type="button" onkedown="addFuntion(this)" onclick="addFuntion(this)" value="" name="card_amount" id="card_add" class="global_add_btn">
                                                            <i class="fas fa-plus"></i> Add </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-none" id="payment_method_bkash">
                                            <div class="form-row">
                                                <div class="col-md-3">
                                                    <select class="form-control mb-2 mt-2" id="mBanking_type" name="mBanking_type">
                                                        <option value="">Mobile Banking Name</option>
                                                        @if (!empty($mBanking ))
                                                            @foreach ($mBanking as $value)
                                                            <option value="{{$value}}">{{$value}}</option>
                                                            @endforeach
                                                        @endif
                                                       
                                                        
                                                    </select>
                                                </div>


                                                <div class="col-md-4">
                                                    <div class="cheque_field mb-2 mt-2">
                                                        <input type="text" class="form-control mBank_amount number_only" name="mBank_amount" id="mBank_amount" checked="checked" value="" placeholder="Amount">
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="cheque_field mb-2 mt-2">
                                                        <input type="text" class="form-control payment_method_1 " name="bkash_txn_id" id="bkash_txn_id" checked="checked" value="" placeholder="Transection ID">
                                                    </div>
                                                </div>

                                                <div class="col-md-1">
                                                    <!-- <span class="btn btn-md btn-success float-right mt-2" name="bkash_amount" id="bkash_add" onclick="addFuntion(this)">Add</span> -->
                                                    <div class=" float-right mt-1 text-white">
                                                        <button type="button" onkedown="addFuntion(this)" onclick="addFuntion(this)" value="Add" name="bkash_amount" id="bkash_add" class="global_add_btn">
                                                            <i class="fas fa-plus"></i> Add </button>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="d-none" id="payment_method_deposited">
                                        <div class="form-row">
                                                <div class="col-md-3">
                                                   <div class="mb-2 mt-2">
                                                     <select class="form-control" id="deposit_type" name="deposit_type" onchange="getDipositAmt(this)">
                                                     <option value="">select</option>
                                                     @if(!empty($deposit_type))
                                                        @foreach($deposit_type as $kye => $value)
                                                        <option value="{{$kye}}">{{$value}}</option>
                                                        @endforeach
                                                       @endif 
                                                     </select>
                                                   </div>
                                                </div>
                                                <div class="col-md-3">
                                                   <div class="mb-2 mt-2">
                                                       <input type="text" class="form-control cash_amount number_only " name="deposited_amt" id="deposited_amt" value="" readonly>
                                                   </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="mb-2 mt-2">
                                                        <input type="text" class="form-control number_only" id='payment_deposited_amt' placeholder="0.00" >
                                                    </div>
                                                </div>

                                                <div class="col-md-1">
                                                    <div class=" float-right mt-1 text-white">
                                                        <button type="button" onkedown="addFuntion(this)" onclick="addFuntion(this)" name="" id="deposited_add" class="global_add_btn"><i class="fas fa-plus"></i> Add </button>
                                                    </div>
                                                </div>

                                        </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class=" clearfix table-responsive mt-2 col-md-12 <?= $textHide ?>">
                                <table class="table table-hover fixed_header table-bordered">
                                    <thead class="global-uhl-table-bg">
                                        <tr>
                                            <th>Mode</th>
                                            <th style="text-align: right;">Amount</th>
                                            <th>Type (Card/Mbank)</th>
                                            <th>Bank</th>
                                            <th>Transaction ID</th>
                                            <th>Card No</th>
                                            <th>Holder Name</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbody">
                                                                    <!-- <tr>
                                        <td><input type="text" name="" id="mode" value=""></td>
                                        <td><input type="text" name="" id="all_amount" value=""></td>
                                        <td><input type="text" name="" id="type_card_mbank" value=""></td>
                                        <td><input type="text" name="" id="bank" value=""></td>
                                        <td><input type="text" name="" id="cand_trans_id" value=""></td>
                                    </tr> -->
                                    </tbody>
                                    <tfoot id="tfoot">
                                    </tfoot>
                                </table>
                            </div>

                            <div class="col-md-12 mt-3">
                             <ul class="billing_foot">

                                <li>
                                    <label class="col-form-label">Grand Total </label>
                                     <span class="btn btn-outline-danger bg-none btn-md d-none" id="item_total">
                                            <?php echo isset($total_p) ? $total_p : 0.0; ?></span>
                                     <span class="btn btn-outline-danger bg-none btn-md" id="item_rate_total">
                                            <?php echo isset($total_p) ? $total_p : 0.0; ?></span>
                                </li>


                                <li>
                                    <label class="col-form-label">Service Fee</label>
                                    <input type="text" class="form-control mb-0" id="s_charge" name="s_charge" value="" placeholder="0.00" readonly="readonly"  style="width: 70px; text-align: right;">
                                </li>

                                <li>
                                    <label class="col-form-label">Emergency Fee</label>
                                    <input type="text" class="form-control number_only" id="urgent_fee" name="urgent_fee" placeholder="0.00" style="width:70px; text-align: right;"  readonly="readonly">
                                </li>

                                <li class="d-none">
                                    <label class="col-form-label">Vat</label>
                                    <input type="text" class="form-control mb-0 number_only" id="item_vat" name="item_vat" value="{{ isset($vat_amt) ? $vat_amt : 0 }}" placeholder="0.00"  style="width: 70px; text-align: right;" readonly="readonly">
                                </li>

                                <li>
                                    <label class="col-form-label">Discount Amt.</label>
                                        <input type="text" class="form-control number_only" id="total_discount_amount" name="total_discount_amount" value="" readonly="readonly" placeholder="0.00" style="width:70px; text-align: right;">
                                        <input type="text" class="form-control number_only" id="discount_percent" name="discount_percent" placeholder="%" readonly="readonly" style="width:50px; text-align: right;"  value="0">(%)
                                </li>

                                <li>
                                   <label class="col-form-label">Payable Amt.</label>
                                   <input type="text" id="total_payable" name="total_payable" class="form-control number_only" style="width: 70px; text-align: right;" placeholder=""  readonly="readonly" value="{{ isset($total_p) ? $total_p : 0.0 }}">
                                </li>

                                <li>
                                   <label class="col-form-label">Payment Amt</label>
                                    <input type="text" id="pay_amount" name="total_payment" class="form-control number_only" style="width: 70px; text-align: right;" placeholder="" readonly="readonly" onkeyup="billingEngine.calculatePayment(this)" value="0">
                                </li>

                                <li>
                                    <label class="col-form-label">Due</label>
                                    <input type="hidden" class="form-control mb-0" id="total_due" name="total_due">
                                    <span class="btn btn-outline-danger bg-none btn-md" id="total_due_data">
                                        <?php echo isset($total_p) ? $total_p : 0.0; ?></span>
                                </li>
                             </ul>


                                    {{-- <li class="list-group-item">
                                        <div class="float-right">
                                            <input id="given_amount" name="given_amount" type="text" class="form-control" style="width: 70px; text-align: right;" placeholder="" maxlength="8" readonly="readonly" onkeyup="billingEngine.calculatePayment(this)">
                                        </div>
                                        <span class="float-right mr-2">Given Amount</span>
                                    </li>
                                    <li class="list-group-item">
                                        <div class="float-right">
                                            <input type="text" class="form-control number_only" id="change_amount" name="change_amount" placeholder="00.00" disabled="disabled" style="width: 70px; text-align: right;">
                                        </div>
                                        <span class="float-right mr-2">Change Amount</span>
                                    </li> --}}


                            </div>
                            <input type="hidden" value="" id="given_amount" name="given_amount">
                            <div class="col-md-12" style="text-align: right">
                                <input type="hidden" name="hdn_patient_id1" value="" readonly="readonly">
                                <input type="hidden" name="bill_type" id="bill_type" value="{{isset($bill_type) ? $bill_type :''}}" >
                                @php
                                $bill_id = '';
                                $response_url_page ='';
                              
                                if ($page_type == 'app') {
                                    if (Session::get('user.ses_hospital_code')=="UNICO") {
                                        // $page_type = route('bill-invoice-app', $bill_id);
                                        $page_type = route('bill-invoice-app-print-v2', $bill_id);
                                    }else{
                                        $page_type = route('bill-invoice-app', $bill_id);
                                    }
                                    $response_url_page = route('uhl.billing-invoice-form');
                                } elseif ($page_type == 'physio') {
                                    $page_type = route('bill-invoice-physio', $bill_id);
                                    $response_url_page = route('uhl.billing-invoice-form');
                                } else {
                                // $page_type = route('bill-invoice-v1', $bill_id);
                                    if ($bill_type =="PKG") {
                                        $page_type = route('bill-invoice-print-A5-pkg', $bill_id);
                                        $response_url_page = route('uhl.billing-invoice-form');
                                    }else{
                                        $page_type = route('bill-invoice-print-A5-v1', $bill_id);
                                        $response_url_page = route('service-item-from-prescription');
                                    }
                                   
                                }
                                $response_url = $page_type;
                               
                                if ($bill_type == "OT") {
                                    // dd($bill_type,$patientId->admission_no_pk,$patientId);
                                    $response_url_page = route('uhl.billing-invoice-form', $patientId->patient_no_pk.'-'.$patientId->admission_no_pk.'-OT');
                                    
                                }elseif(strtoupper($bill_type) == "IPD"){
                                    $response_url_page = url()->previous();
                                }else{
                                    if(Session::get('user.ses_hospital_code')=="KPJ"){
                                        $response_url_page =route('uhl.billing-invoice-form');// Route::current();// for KPJ
                                        
                                    }else{
                                    $response_url_page = route('service-item-from-prescription');//uhl.billing-invoice-form
                                    }
                                }
                               
                               
                                @endphp
                                <button type="button" class="btn btn-secondary uhl_save_btn" data-response_action="{{ $response_url }}" data-response-url="{{ $response_url_page }}" onclick="billingEngine.createBillV2(this)">Save</button>
                                {{-- <span class="btn btn-md btn-info" onclick=" billingEngine.resetBillForm()">Clear</span> --}}
                                {{-- <a href="{{ route('home') }}" class="btn btn-danger btn-secondary" rel="tab" title="Click here to go back to Dashboard">Exit</a> --}}
                                {{-- <span class="badge float-right">BDT</span> --}}
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
