<style>
    .round_shape {
        width: 25px;
        height: 25px;
        background: red;
        color: #fff;
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        margin-left: 5px;
    }
       .custom-select {
    height: 100%!important;
    line-height: 1 !important;
}
.myDiv{
    display:none;
} 
.keep_me {
    margin-right: 5px;
}
.list-group-item {
    background: none;
    border-top: 1px solid #ffffff !important;
    border-bottom: 1px solid #e3e3e3;
}
.list-group-item {
    padding: .3rem;
}
</style>

<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<main id="page-content">
    <form action="#" id="">
        <section class="paitent__registration_details">
            <div class="container-fluid">
                <div class="row bg-white border-bottom sticky-top shadow-sm">
                    <div class="col-md-12">
                        <h5 class="mt-2 mb-0">Cafe Gift Shop</h5>
                        <small>Cafe Gift Shop / Cafeterria Billing</small>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h5>Bill Entry</h5>
                            </div>
                            <div class="card-body border-bottom-3 p-2">
                                <div class="form-row">
                                    <div class="col-md-3">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="customer_type_radio" id="walk_in_patient" value="1" />
                                            <label class="form-check-label" for="walk_in_patient">Walk In</label>
                                        </div>

                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="customer_type_radio" id="registered" value="2" />
                                            <label class="form-check-label" for="registered">Registered</label>
                                        </div>

                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="customer_type_radio" id="admitted" value="3" />
                                            <label class="form-check-label" for="admitted">Admitted</label>
                                            <span class="round_shape">0</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group form-row">
                                            <label for="service_point" class="col-sm-4 col-form-label">Service Point</label>
                                            <div class="col-sm-8">
                                                <select name="service_point" id="service_point" class="form-control">
                                                    <option value="" selected>Select One</option>
                                                    <option value="">Pharmacy</option>
                                                    <option value="">Nurse Station</option>
                                                    <option value="">Cash Counter</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="col-lg-4 col-md-6 col-12">
                                        <div class="form-group form-row">
                                            <label for="per_name" class="col-sm-4 col-form-label">Name</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control form-control-sm" id="per_name" name="per_name" placeholder="" value="" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-6 col-12">
                                        <div class="form-group form-row">
                                            <label for="mobile_no" class="col-sm-4 col-form-label">Mobile No</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control form-control-sm" id="mobile_no" name="mobile_no" placeholder="" value="" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-6 col-12">
                                        <div class="form-group form-row">
                                            <label for="address" class="col-sm-4 col-form-label">Address</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control form-control-sm" id="address" name="address" placeholder="" value="" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body p-2 border-top">
                                <div class="form-row">
                                    <div class="col-md-12">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1"><i class="fa fa-barcode" style="font-size: 24px;"></i></span>
                                            </div>
                                            <input type="text" class="form-control" placeholder="Search Item by Barcode No/Item Code/ Item Name" aria-label="Username" aria-describedby="basic-addon1" />
                                        </div>
                                    </div>

                                    <div class="col-12 mt-2" id="item_table_con">
                                        <div class="text-right">
                                            <input type="checkbox" class="keep_me" name="item_dis_ind" id="item_dis_ind" value="1" checked="checked" />
                                            <label for="item_dis_ind">Item Discount</label> <input type="radio" name="item_dis_radio" class="item_dis_radio keep_me" id="item_dis_perc" value="1" checked="checked" /> (%)
                                            <input type="radio" name="item_dis_radio" class="item_dis_radio keep_me" id="item_dis_amt" disabled="disabled" value="2" />
                                            (Amt)
                                        </div>
                                    </div>
                                    <div class="col-md-12 table-responsive">
                                        <table id="item_table" class="table table-striped table-bordered table-hover">
                                            <thead class="global-uhl-table-bg">
                                                <tr>
                                                    <th class="text-center ">#</th>
                                                    <th class="text-left" style="width: 400px;">Item Description</th>
                                                    <th class="text-right ">Rate</th>
                                                    <th class="text-right ">Quantity</th>

                                                    <th class=" text-right">Stock QTY</th>
                                                    <th class="">UOM</th>
                                                    <th class="text-right ">Dis.</th>
                                                    <th class="text-right ">Sub Total</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 col-lg-12">
                        <div class="card">
                            <div class="card-body border-bottom-3 p-2">
                                <div class="form-row">
                                    <div class="col-md-4">
                                        <div class="form-row">
                                             <div class="col-md-12 col-12">
                                                <div class="input-group mb-3">
                                                  <div class="input-group-prepend">
                                                    <label class="input-group-text" for="inputGroupSelect01">Discount</label>
                                                  </div>
                                                  <select class="custom-select" id="inputGroupSelect01">
                                                    <option selected>General</option>
                                                    <option value="1">One</option>
                                                    <option value="2">Two</option>
                                                    <option value="3">Three</option>
                                                  </select>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="input-group mb-2">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon1">%</span>
                                                    </div>
                                                    <input type="text" class="form-control form-control-sm text-right" id="" name="" placeholder="Hospital" readonly="readonly" />
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <input type="text" class="form-control form-control-sm text-right" id="" name="" placeholder="Amount" value="" disabled="disabled" />
                                            </div>

                                            <div class="col-md-12 col-12">
                                                <div class="form-group form-row">
                                                    <label for="discount_by" class="col-sm-4 col-form-label">Discount By</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control form-control-sm" id="discount_by" name="discount_by" placeholder="" value="" />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12 col-12">
                                                <div class="form-group form-row">
                                                    <label for="req_by" class="col-sm-4 col-form-label">Request By</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control form-control-sm" id="req_by" name="req_by" placeholder="" value="" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- tab -->
                                   
                                            <div class="form-row">
                                                <div class="col-md-12">
                                                    <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                                                         <div class="btn-group bg-none w-100" data-toggle="buttons" aria-label="First group">
                                                            <label class="btn btn-outline-primary bg-none active">
                                                                  <input type="radio" name="demo" class="keep_me" value="One"/>CASH
                                                             </label>
                                                              <label class="btn btn-outline-primary bg-none">
                                                                   <input type="radio" name="demo" class="keep_me" value="Two"/>CARD
                                                             </label>

                                                              <label class="btn btn-outline-primary bg-none">
                                                                    <input type="radio" name="demo" class="keep_me" value="Three"/>Mbanking
                                                             </label>
                                                             <label class="btn btn-outline-primary bg-none ">
                                                                    <input type="radio" name="demo" class="keep_me" value="Four"/>CHEQUE
                                                             </label>
                                                             <label class="btn btn-outline-primary bg-none ">
                                                                    <input type="radio" name="demo" class="keep_me" value="Five"/>DEPOSITED
                                                             </label>
                                                         </div>
                                                     </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <div id="showOne" class="myDiv">
                                                        <div class="mb-2 mt-2">
                                                            <input type="text" class="form-control" name="cash_amount" id="cash_amount" value="" placeholder="Paid Amount"/>
                                                        </div>
                                                        <div class="mb-2 mt-2">
                                                            <input type="text" class="form-control" id="cash_bd_amount" placeholder="Given Amount"/>
                                                        </div>

                                                        <div class="mb-2 mt-2">
                                                            <input type="text" id="change_amount" class="form-control" placeholder="0" />
                                                        </div> 

                                                        <div class="mb-2 mt-2 d-flex justify-content-between align-items-center">
                                                            <div class="left">
                                                                    <button type="button" class="btn btn-md btn-success">Save</button>
                                                                    <span class="btn btn-md btn-info">Clear</span>
                                                                    <a href="#" class="btn btn-danger btn-md">Exit</a>
                                                                
                                                            </div>
                                                            <div class="right">
                                                                <button type="button" class="btn btn-md btn-success">Add</button>

                                                            </div>
                                                        </div> 
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <div id="showTwo" class="myDiv">
                                                        <div class="mb-2 mt-2">
                                                            <select class="form-control" id="card_type" name="card_type">
                                                               <option value="">Card Type</option>
                                                               <option value="visa">Visa</option>
                                                               <option value="master">Master</option>
                                                               <option value="City Maxx">City Maxx</option>
                                                           </select>
                                                        </div>
                                                           
                                                           <div class="mb-2 mt-2">
                                                               <input type="text" class="form-control " name="card_amount" id="card_amount" checked="checked" value="" placeholder="Amount" />
                                                           </div>
                                                           <div class="mb-2 mt-2">
                                                               <select class="form-control" id="card_type" name="card_type">
                                                                  <option value="">Bank Name</option>
                                                                  <option value="">DBBL</option>
                                                                  <option value="">BANK ASIA</option>
                                                                  <option value="">City BANK</option>
                                                              </select>
                                                           </div>
                                                           
                                                           <div class=" mb-2 mt-2">
                                                               <input type="text" class="form-control" name="holder_name" id="card_holder_name" checked="checked" value="" placeholder="Holder Name" />
                                                           </div>

                                                           <div class="mb-2 mt-2">
                                                               <input type="text" class="form-control" name="card_no" id="card_no" value="" placeholder="Card No (minimum 4 digits)" minlength="4" maxlength="20" />
                                                           </div>
                                                         
                                                        <div class="mb-2 mt-2 d-flex justify-content-between align-items-center">
                                                            <div class="left">
                                                                    <button type="button" class="btn btn-md btn-success">Save</button>
                                                                    <span class="btn btn-md btn-info">Clear</span>
                                                                    <a href="#" class="btn btn-danger btn-md">Exit</a>
                                                                
                                                            </div>
                                                            <div class="right">
                                                                <button type="button" class="btn btn-md btn-success">Add</button>

                                                            </div>
                                                        </div> 
                                                    </div>
                                                </div>


                                                <div class="col-md-12">
                                                    <div id="showThree" class="myDiv">
                                                        <div class="mb-2 mt-2">
                                                            <select class="form-control" id="card_type" name="card_type">
                                                               <option value="">Mobile Banking Name</option>
                                                               <option value="">BKash</option>
                                                               <option value="">Nogod</option>
                                                               <option value="">Rocket</option>
                                                           </select>
                                                        </div>
                                                        <div class="mb-2 mt-2">
                                                            <input type="text" class="form-control" name="" id="" checked="checked" value="" placeholder="Amount" />

                                                        </div>
                                                        <div class="mb-2 mt-2">
                                                            <input type="text" class="form-control" name="" id="" checked="checked" value="" placeholder="Transection ID" />

                                                        </div>

                                                        <div class="mb-2 mt-2 d-flex justify-content-between align-items-center">
                                                            <div class="left">
                                                                    <button type="button" class="btn btn-md btn-success">Save</button>
                                                                    <span class="btn btn-md btn-info">Clear</span>
                                                                    <a href="#" class="btn btn-danger btn-md">Exit</a>
                                                                
                                                            </div>
                                                            <div class="right">
                                                                <button type="button" class="btn btn-md btn-success">Add</button>

                                                            </div>
                                                        </div> 
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <div id="showFour" class="myDiv">
                                                        <div class="mb-2 mt-2">
                                                            <input type="text" class="form-control" name="" id="" checked="checked" value="" placeholder="Amount" />
                                                        </div>
                                                        <div class="mb-2 mt-2">
                                                            <select class="form-control" id="card_type" name="card_type">
                                                               <option value="">Bank Name</option>
                                                               <option value="">DBBL</option>
                                                               <option value="">Bank Asia</option>
                                                               <option value="">Brac Bank</option>
                                                               <option value="">City Bank</option>
                                                           </select>
                                                        </div>
                                                        
                                                        <div class="mb-2 mt-2">
                                                            <input type="text" class="form-control" name="" id="" checked="checked" value="" placeholder="Holder Name" />

                                                        </div>
                                                        <div class="mb-2 mt-2">
                                                            <input type="text" class="form-control" name="" id="" checked="checked" value="" placeholder="Cheque No" />

                                                        </div>

                                                        <div class="mb-2 mt-2 d-flex justify-content-between align-items-center">
                                                            <div class="left">
                                                                    <button type="button" class="btn btn-md btn-success">Save</button>
                                                                    <span class="btn btn-md btn-info">Clear</span>
                                                                    <a href="#" class="btn btn-danger btn-md">Exit</a>
                                                                
                                                            </div>
                                                            <div class="right">
                                                                <button type="button" class="btn btn-md btn-success">Add</button>

                                                            </div>
                                                        </div> 
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <div id="showFive" class="myDiv">
                                                        <div class="mb-2 mt-2">
                                                            <div class="left">
                                                                    <button type="button" class="btn btn-md btn-success">Save</button>
                                                                    <span class="btn btn-md btn-info">Clear</span>
                                                                    <a href="#" class="btn btn-danger btn-md">Exit</a>
                                                                
                                                            </div>
                                                            
                                                        </div> 
                                                    </div>
                                                </div>



                                            </div>
                                        <!-- tab -->
                                    </div>

                                    <div class="col-md-8">
                                        <div class="row">
                                            <div class="col-12 table-responsive">
                                                <table  class="table table-striped table-bordered table-hover" style="min-height: 143px;">
                                                    <thead class="global-uhl-table-bg">
                                                        <tr>
                                                            <th class="text-center">Mode</th>
                                                            <th class="text-right">Amount</th>
                                                            <th class="text-center">Type (Card/Mbank)</th>
                                                            <th class="text-center">Bank</th>
                                                            <th class="text-center">Transaction ID</th>
                                                            <th class="text-center">Card No</th>
                                                            <th class="text-center">Holder Name</th>

                                                            
                                                        </tr>
                                                    </thead>
                                                    <tbody>  
                                                    </tbody>
                                                </table>
                                            </div>
                                         </div>

                                         <div class="row">
                                             <div class="col-md-12">
                                                 <ul class="list-group bg-light-blue list-group-flush bg-light-blue rounded mb-2 border">
                                                 <li class="list-group-item">
                                                     <h5 class="float-left mr-2">Total Amount</h5>
                                                     <span class="float-right btn btn-outline-danger bg-none btn-md" id="item_total">0</span>
                                                 </li>
                                                 <li class="list-group-item">
                                                     <div class="form-row">
                                                         <div class="col-md-6">
                                                             <span class="mr-2 float-left d-none">Service Charge</span>
                                                             <div class="float-left d-none">
                                                                 <input type="text" class="form-control mb-0" id="s_charge" name="s_charge" value="" placeholder="0.00" readonly="readonly" style="width: 70px; text-align: right;" />
                                                             </div>
                                                         </div>
                                                         <div class="col-md-6 text-right">
                                                             <span class="mr-2">Urgent Fee</span>
                                                             <div class="float-right">
                                                                 <input
                                                                     type="text"
                                                                     class="form-control float-right number_only"
                                                                     id="urgent_fee"
                                                                     name="urgent_fee"
                                                                     placeholder="0.00"
                                                                     style="width: 70px; text-align: right;" 
                                                                     readonly="readonly"
                                                                 />
                                                             </div>
                                                         </div>
                                                     </div>
                                                 </li>

                                                 <li class="list-group-item">
                                                     <div class="form-row">
                                                         <div class="col-md-12 text-right">
                                                             <span class="mr-2">Discount</span>
                                                             <div class="float-right">
                                                                 <input type="text" class="form-control float-right number_only" id="total_discount_amount" name="total_discount_amount" value="" readonly="readonly" placeholder="0.00" style="width: 70px; text-align: right;" />

                                                                 <input
                                                                     type="text"
                                                                     class="form-control float-right number_only"
                                                                     id="discount_percent"
                                                                     name="discount_percent"
                                                                     placeholder="%"
                                                                     readonly="readonly"
                                                                     style="width: 50px; text-align: right;"
                                                                     value="0"
                                                                 />
                                                                 (%)
                                                             </div>
                                                         </div>
                                                     </div>
                                                 </li>

                                                 <li class="list-group-item">
                                                     <div class="float-right">
                                                         <input type="text" id="total_payable" name="total_payable" class="form-control number_only" style="width: 70px; text-align: right;" placeholder="" readonly="readonly" value="" />
                                                     </div>
                                                     <span class="float-right mr-2">Payable Amount</span>
                                                 </li>
                                                 <li class="list-group-item">
                                                     <div class="float-right">
                                                         <input type="text" id="discount_adj" name="discount_adj" class="form-control number_only" style="width: 70px; text-align: right;" placeholder="" readonly="readonly" value="" />
                                                     </div>
                                                     <span class="float-right mr-2">Discount Adj. Amt</span>
                                                 </li>
                                                 <li class="list-group-item">
                                                     <div class="float-right">
                                                         <input type="text" id="pay_amount" name="total_payment" class="form-control number_only" style="width: 70px; text-align: right;" placeholder="" readonly="readonly" value="0" />
                                                     </div>
                                                     <span class="float-right mr-2">Payment Amount</span>
                                                 </li>
                                                 <li class="list-group-item">
                                                     <input type="hidden" class="form-control mb-0" id="total_due" name="total_due" />

                                                     <span class="float-right btn btn-outline-danger bg-none btn-md" id="total_due_data">0</span>
                                                     <h5 class="float-right mr-2">Due</h5>
                                                 </li>
                                             </ul>
                                             </div>

                                         </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>
    </form>
</main>
<script>
    $("body").addClass("sidebar-collapse");
</script>
<script>
$(document).ready(function(){
    $('input[type="radio"]').click(function(){
        var demovalue = $(this).val(); 
        $("div.myDiv").hide();
        $("#show"+demovalue).show();
    });
});
</script>