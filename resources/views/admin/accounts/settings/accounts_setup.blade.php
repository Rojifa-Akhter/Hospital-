<link rel="stylesheet" href=" {{ asset('css/jstree.min.css') }}" />
<style>
    .jstree-default .jstree-anchor {
        line-height: 35px;
        height: 35px;
    }

    .jstree-default .jstree-leaf>.jstree-ocl {
        background-position: -68px 0px;
    }

    .jstree-default .jstree-closed>.jstree-ocl {
        background-position: -100px 0px;
    }

    .jstree-default .jstree-open>.jstree-ocl {
        background-position: -132px 0px;
    }

    .jstree-icon:empty {
        vertical-align: middle;
    }

    .table tr td,
    .table tr th {
        vertical-align: middle;
    }

    .save_loader {
        display: none;
    }

    .cash_flow {
        display: none;
    }

    .income_exp {
        display: none;
    }

    .posting_head {
        display: none;
    }

    .account_edit_pre_loader {
        display: none;
    }

    .voucher_type_form{
        display: none;
    }

    .voucher_type_message {
        display: none;
    }

    .save_loader_voucher_type {
        display: none;
    }

</style>


<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top shadow-sm">
        <div class="col-md-12 mb-1">
            <h5 class="mt-2 mb-0">Accounts Setup</h5>
            <small>Accounts / Settings / Accounts Setup</small>
        </div>
    </div>

    <div class="card">
        <div class="card-body p-2" style="min-height:calc(100vh - 125px);">
            <div class="form-row">
                <div class="col-md-12">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        {{-- <li class="nav-item">
                            <a class="nav-link active" id="account-type-tab" data-toggle="tab" href="#account-type"
                                role="tab" aria-controls="account-type" aria-selected="true">ACCOUNT TYPE</a>
                        </li> --}}

                        <li class="nav-item">
                            <a class="nav-link active" id="chart-of-accounts-tab" data-toggle="tab"
                                href="#chart-of-accounts" role="tab" aria-controls="chart-of-accounts"
                                aria-selected="true">CHART OF ACCOUNT</a>
                        </li>

                        {{-- <li class="nav-item">
                            <a class="nav-link" id="cost-center-tab" data-toggle="tab" href="#cost-center"
                                role="tab" aria-controls="cost-center" aria-selected="true">COST CENTER</a>
                        </li> --}}

                        <li class="nav-item">
                            <a class="nav-link" id="accounts-levels-tab" data-toggle="tab" href="#accounts-levels"
                                role="tab" aria-controls="accounts-levels" aria-selected="true">ACCOUNTS LEVELS</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" id="voucher-type-tab" data-toggle="tab" href="#voucher-type"
                                role="tab" aria-controls="voucher-type" aria-selected="true">VOUCHER TYPE</a>
                        </li>

                    </ul>


                    <div class="tab-content p-0" id="myTabContent">
                        <div class="tab-pane fade" id="account-type" role="tabpanel"
                            aria-labelledby="account-type-tab">
                            <div class="row justify-content-center">
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header text-center bg-primary text-white">
                                            <h5>Account Type Information</h5>
                                        </div>
                                        <div class="card-body p-2">
                                            <div class="container">
                                                <div class="row">
                                                    <div class="col-md-12 mb-2">
                                                        @include('admin.accounts.settings.acc_type_form')
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="table-responsive">

                                                <table class="table table-bordered table-striped mb-0 acct_type_table">
                                                    <thead>
                                                        <tr>
                                                            <th>#SL</th>
                                                            <th>Account Code</th>
                                                            <th>Account Type</th>
                                                            <th>Status</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>1</td>
                                                            <td></td>
                                                            <td>CAPITAL</td>
                                                            <td></td>
                                                            <td>
                                                                <span class="btn btn-sm btn-primary edit_acct_type" data-toggle="modal" data-target="#acct_type"><i
                                                                    class="fa fa-pencil-alt"></i></span>
                                                                
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>

                                                <div class="modal fade" id="acct_type" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header bg-primary">
                                                                <h5 class="modal-title" id="exampleModalLabel">Edit Account Type</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="{{route('update-acc-type')}}" id="acc_type" method="post">
                                                                    @csrf
                                                                    <input type="hidden" name="acct_type_no_pk" id="edt_acct_type_no_pk"/>
                                                                    <input type="hidden" name="acct_type_code" id="edt_acct_type_code"/>
                                                                    <div class="form-group">
                                                                        <label for="acct_type_name">Account type name</label>
                                                                        <input type="text" name="acct_type_name" class="form-control" id="edt_acct_type_name">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="acct_type_sl">SL No.</label>
                                                                        <select name="acct_type_sl" class="form-control" id="edt_acct_type_sl">
                                                                            <option value="">Select serial no</option>
                                                                            <option value="1">1</option>
                                                                            <option value="2">2</option>
                                                                            <option value="3">3</option>
                                                                            <option value="4">4</option>
                                                                            <option value="5">5</option>
                                                                            <option value="6">6</option>
                                                                            <option value="7">7</option>
                                                                            <option value="8">8</option>
                                                                            <option value="9">9</option>
                                                                            <option value="10">10</option>
                                                                            <option value="11">11</option>
                                                                            <option value="12">12</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="status">Status</label>
                                                                        <select name="status" class="form-control" id="edt_status">
                                                                            <option value="">Select status</option>
                                                                            <option value="1">Yes</option>
                                                                            <option value="0">No</option>
                                                                            
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <div class="row">
                                                                              <div class="form-check form-check-inline" style="margin:16px;">
                                                                                <input class="form-check-input" type="checkbox" id="edt_cashflow_ind" name="cashflow_ind" value="1"/>
                                                                                <label class="form-check-label" for="inlineCheckbox1">Cashflow</label>
                                                                              </div>
                                                                              <div class="form-check form-check-inline">
                                                                                <input class="form-check-input" type="checkbox" id="edt_income_exp_ind" name="income_exp_ind" value="1"/>
                                                                                <label class="form-check-label" for="inlineCheckbox2">Income & Expense</label>
                                                                              </div>
                                                                        </div>
                                                                    </div>
                                                                    <div  class="form-group">
                                                                    <button type="submit" class="btn btn-primary update_acc_type">Submit</button>
                                                                    <span class="save_loader pl-3"> <i class='fas fa-stroopwafel fa-spin'></i></span>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>



                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade show active" id="chart-of-accounts" role="tabpanel"
                            aria-labelledby="chart-of-accounts-tab">
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="card">
                                        <div class="card-body p-2">
                                            <div class="chart_of_account_tree">
                                            
                                            </div>

                                            
                                            <div class="modal fade" id="add_acct_account_head_root" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel-root" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        
                                                        <div class="modal-header bg-primary">
                                                            <h5 class="modal-title" id="exampleModalLabel-root">Add Account Head</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="float-right p-3 last_account_code">
                                                            <strong>Last account code</strong> {{@$last_account_code->getData()->data->account_code}}
                                                        </div>
                                                        <div class="modal-body">
                                                            
                                                            <form action="{{route('save-chart-of-accounts')}}" id="acc_type" method="post">
                                                                @csrf
                                                                <input type="hidden" name="account_no_fk_root_0" id="root_account_no_fk_root_0"/>
                                                                <div class="form-group">
                                                                    <label for="acct_type_code">Account code</label>
                                                                    <input type="text" name="account_code" class="form-control" id="root_account_code" readonly value="{{((int)@$last_account_code->getData()->data->account_code+1)}}">
                                                                
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="acct_type_name">Account name</label>
                                                                    <input type="text" name="account_name" class="form-control" id="root_account_name">
                                                                </div>
                                                                <div class="form-group cash_flow">
                                                                    <label for="acct_type_sl">Cash Flow Category</label>
                                                                    <select name="cashflow_category_no_fk" class="form-control" id="root_cashflow_category_no_fk">
                                                                        <option value="">Select cash flow category</option>
                                                                        @foreach($cashflow_category->getData()->data as $cashflow)
                                                                        <option value="{{$cashflow->cashflow_category_no_pk}}">{{$cashflow->cashflow_category_name}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                {{-- <div class="form-group income_exp">
                                                                    <label for="acct_type_sl">Income & Expense</label>
                                                                    <select name="income_exp_type" class="form-control" id="root_income_exp_type">
                                                                        <option value="">Select income & expense type</option>
                                                                        <option value="DIRECT">Direct</option>
                                                                        <option value="INDIRECT">Indirect</option>
                                                                        
                                                                    </select>
                                                                </div> --}}
                                                                <div class="form-group">
                                                                    <label for="acct_type_name">Income & Expense Nature</label>
                                                                    <select name="ledger_group_name" class="form-control" id="root_ledger_group_name">
                                                                        <option value="">Select ledger group</option>
                                                                        <option value="income">Income</option>
                                                                        <option value="expense">Expense</option>
                                                                        
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="acct_type_sl">SL No.</label>
                                                                    <select name="account_no_sl" class="form-control" id="root_account_no_sl">
                                                                        <option value="">Select serial no</option>
                                                                        <option value="1">1</option>
                                                                        <option value="2">2</option>
                                                                        <option value="3">3</option>
                                                                        <option value="4">4</option>
                                                                        <option value="5">5</option>
                                                                        <option value="6">6</option>
                                                                        <option value="7">7</option>
                                                                        <option value="8">8</option>
                                                                        <option value="9">9</option>
                                                                        <option value="10">10</option>
                                                                        <option value="11">11</option>
                                                                        <option value="12">12</option>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="status">Status</label>
                                                                    <select name="status" class="form-control" id="root_status">
                                                                        <option value="">Select status</option>
                                                                        <option value="1">Yes</option>
                                                                        <option value="0">No</option>
                                                                        
                                                                    </select>
                                                                </div>
                                                                <div  class="form-group">
                                                                <button type="submit" class="btn btn-primary save_chart_of_account">Submit</button>
                                                                <span class="save_loader pl-3"> <i class='fas fa-stroopwafel fa-spin'></i></span>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <input type="hidden" name="input_prefix" id="input_prefix"/>
                                            <div class="modal fade" id="add_acct_account_head_subroot_first" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel-root" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        
                                                        <div class="modal-header bg-primary">
                                                            <h5 class="modal-title" id="exampleModalLabel-root">Add Account Head</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="float-right p-3 last_account_code">
                                                            <strong>Last account code</strong> {{@$last_account_code->getData()->data->account_code}}
                                                        </div>
                                                        <div class="modal-body">
                                                            
                                                            <form action="{{route('save-chart-of-accounts')}}" id="acc_type" method="post">
                                                                @csrf
                                                                <input type="hidden" name="account_no_fk_root_0" id="subroot_first_account_no_fk_root_0"/>
                                                                <div class="form-group">
                                                                    <label for="acct_type_code">Account code</label>
                                                                    <input type="text" name="account_code" class="form-control" id="subroot_first_account_code" readonly value="{{((int)@$last_account_code->getData()->data->account_code+1)}}">
                                                                
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="acct_type_name">Account name</label>
                                                                    <input type="text" name="account_name" class="form-control" id="subroot_first_account_name">
                                                                </div>
                                                                {{-- <div class="form-group cash_flow">
                                                                    <label for="acct_type_sl">Cash Flow Category</label>
                                                                    <select name="cashflow_category_no_fk" class="form-control" id="cashflow_category_no_fk">
                                                                        <option value="">Select cash flow category</option>
                                                                        @foreach($cashflow_category->getData()->data as $cashflow)
                                                                        <option value="{{$cashflow->cashflow_category_no_pk}}">{{$cashflow->cashflow_category_name}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="form-group income_exp">
                                                                    <label for="acct_type_sl">Income & Expense</label>
                                                                    <select name="income_exp_type" class="form-control" id="income_exp_type">
                                                                        <option value="">Select income & expense type</option>
                                                                        <option value="DIRECT">Direct</option>
                                                                        <option value="INDIRECT">Indirect</option>
                                                                        
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="acct_type_name">Ledger Group name</label>
                                                                    <input type="text" name="ledger_group_name" class="form-control" id="ledger_group_name">
                                                                </div> --}}
                                                                <div class="form-group">
                                                                    <label for="acct_type_name">Income & Expense Nature</label>
                                                                    <select name="ledger_group_name" class="form-control" id="subroot_first_ledger_group_name">
                                                                        <option value="">Select ledger group</option>
                                                                        <option value="income">Income</option>
                                                                        <option value="expense">Expense</option>
                                                                        
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <div class="row">
                                                                          <div class="form-check form-check-inline" style="margin:16px;">
                                                                            <input class="form-check-input" type="checkbox" id="subroot_first_posting_head_ind" name="posting_head_ind" value="1"/>
                                                                            <label class="form-check-label" for="inlineCheckbox1">Is Transectional Head ?</label>
                                                                          </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="acct_type_sl">SL No.</label>
                                                                    <select name="account_no_sl" class="form-control" id="subroot_first_account_no_sl">
                                                                        <option value="">Select serial no</option>
                                                                        <option value="1">1</option>
                                                                        <option value="2">2</option>
                                                                        <option value="3">3</option>
                                                                        <option value="4">4</option>
                                                                        <option value="5">5</option>
                                                                        <option value="6">6</option>
                                                                        <option value="7">7</option>
                                                                        <option value="8">8</option>
                                                                        <option value="9">9</option>
                                                                        <option value="10">10</option>
                                                                        <option value="11">11</option>
                                                                        <option value="12">12</option>
                                                                    </select>
                                                                </div>
                                                                
                                                                <div class="form-group">
                                                                    <label for="status">Status</label>
                                                                    <select name="status" class="form-control" id="subroot_first_status">
                                                                        <option value="">Select status</option>
                                                                        <option value="1">Yes</option>
                                                                        <option value="0">No</option>
                                                                        
                                                                    </select>
                                                                </div>
                                                                <div  class="form-group">
                                                                <button type="submit" class="btn btn-primary save_chart_of_account">Submit</button>
                                                                <span class="save_loader pl-3"> <i class='fas fa-stroopwafel fa-spin'></i></span>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <input type="hidden" name="account_no_pk" id="edit_account_no_pk"/>
                                            <input type="hidden" name="cashflow_ind" id="edit_cashflow_ind"/>
                                            <input type="hidden" name="income_exp_ind" id="edit_income_exp_ind"/>
                                            
                                            <div class="modal fade" id="add_acct_account_head_root_edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel-root" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div style="position: absolute;
                                                        width: 100%;
                                                        height: 100%;
                                                        background-color: #000;
                                                        z-index: 999;
                                                        opacity: 0.6;
                                                        line-height: 41em;" class="account_edit_pre_loader">
                                                            <i class='fas fa-stroopwafel fa-spin' style="position: relative; left:45%;"></i>
                                                        </div>
                                                        <div class="modal-header bg-primary">
                                                            <h5 class="modal-title" id="exampleModalLabel-root">Edit Account Head</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                       
                                                        <div class="modal-body">
                                                            
                                                            <form action="{{route('update-chart-of-accounts')}}" id="acc_type" method="post">
                                                                @csrf
                                                                
                                                                <div class="form-group">
                                                                    <label for="acct_type_name">Account name</label>
                                                                    <input type="text" name="account_name" class="form-control" id="edit_account_name">
                                                                </div>
                                                                <div class="form-group cash_flow">
                                                                    <label for="acct_type_sl">Cash Flow Category</label>
                                                                    <select name="cashflow_category_no_fk" class="form-control" id="edit_cashflow_category_no_fk">
                                                                        <option value="">Select cash flow category</option>
                                                                        @foreach($cashflow_category->getData()->data as $cashflow)
                                                                        <option value="{{$cashflow->cashflow_category_no_pk}}">{{$cashflow->cashflow_category_name}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                {{-- <div class="form-group income_exp">
                                                                    <label for="acct_type_sl">Income & Expense</label>
                                                                    <select name="income_exp_type" class="form-control" id="edit_income_exp_type">
                                                                        <option value="">Select income & expense type</option>
                                                                        <option value="DIRECT">Direct</option>
                                                                        <option value="INDIRECT">Indirect</option>
                                                                        
                                                                    </select>
                                                                </div> --}}
                                                                <div class="form-group">
                                                                    <label for="acct_type_name">Income & Expense Nature</label>
                                                                   
                                                                    <select name="ledger_group_name" class="form-control" id="edit_ledger_group_name">
                                                                        <option value="">Select type</option>
                                                                        <option value="income">Income</option>
                                                                        <option value="expense">Expense</option>
                                                                        
                                                                    </select>
                                                                </div>
                                                                <div class="form-group posting_head">
                                                                    <div class="row">
                                                                          <div class="form-check form-check-inline" style="margin:16px;">
                                                                            <input class="form-check-input" type="checkbox" id="edit_posting_head_ind" name="posting_head_ind" value="1"/>
                                                                            <label class="form-check-label" for="inlineCheckbox1">Is Transectional Head ?</label>
                                                                          </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="acct_type_sl">SL No.</label>
                                                                    <select name="account_no_sl" class="form-control" id="edit_account_no_sl">
                                                                        <option value="">Select serial no</option>
                                                                        <option value="1">1</option>
                                                                        <option value="2">2</option>
                                                                        <option value="3">3</option>
                                                                        <option value="4">4</option>
                                                                        <option value="5">5</option>
                                                                        <option value="6">6</option>
                                                                        <option value="7">7</option>
                                                                        <option value="8">8</option>
                                                                        <option value="9">9</option>
                                                                        <option value="10">10</option>
                                                                        <option value="11">11</option>
                                                                        <option value="12">12</option>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="status">Status</label>
                                                                    <select name="status" class="form-control" id="edit_status">
                                                                        <option value="">Select status</option>
                                                                        <option value="1">Yes</option>
                                                                        <option value="0">No</option>
                                                                        
                                                                    </select>
                                                                </div>
                                                                <div  class="form-group">
                                                                <button type="submit" class="btn btn-primary update_chart_of_account">Update</button>
                                                                <span class="save_loader pl-3"> <i class='fas fa-stroopwafel fa-spin'></i></span>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            




                                            <div class="modal fade" id="add_acct_account_head_subroot" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel-root" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        
                                                        <div class="modal-header bg-primary">
                                                            <h5 class="modal-title" id="exampleModalLabel-root">Add Account Head</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="float-right p-3 last_account_code">
                                                            <strong>Last account code</strong> {{@$last_account_code->getData()->data->account_code}}
                                                        </div>
                                                        <div class="modal-body">
                                                            
                                                            <form action="{{route('save-chart-of-accounts')}}" id="acc_type" method="post">
                                                                @csrf
                                                                <input type="hidden" name="account_no_fk_root_0" id="subroot_account_no_fk_root_0"/>
                                                                <div class="form-group">
                                                                    <label for="acct_type_code">Account code</label>
                                                                    <input type="text" name="account_code" class="form-control" id="subroot_account_code" readonly value="{{((int)@$last_account_code->getData()->data->account_code+1)}}">
                                                                
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="acct_type_name">Account name</label>
                                                                    <input type="text" name="account_name" class="form-control" id="subroot_account_name">
                                                                </div>
                                                                {{-- <div class="form-group cash_flow">
                                                                    <label for="acct_type_sl">Cash Flow Category</label>
                                                                    <select name="cashflow_category_no_fk" class="form-control" id="cashflow_category_no_fk">
                                                                        <option value="">Select cash flow category</option>
                                                                        @foreach($cashflow_category->getData()->data as $cashflow)
                                                                        <option value="{{$cashflow->cashflow_category_no_pk}}">{{$cashflow->cashflow_category_name}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="form-group income_exp">
                                                                    <label for="acct_type_sl">Income & Expense</label>
                                                                    <select name="income_exp_type" class="form-control" id="income_exp_type">
                                                                        <option value="">Select income & expense type</option>
                                                                        <option value="DIRECT">Direct</option>
                                                                        <option value="INDIRECT">Indirect</option>
                                                                        
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="acct_type_name">Ledger Group name</label>
                                                                    <input type="text" name="ledger_group_name" class="form-control" id="ledger_group_name">
                                                                </div> --}}
                                                                <div class="form-group">
                                                                    <label for="acct_type_name">Income & Expense Nature</label>
                                                                    <select name="ledger_group_name" class="form-control" id="subroot_ledger_group_name">
                                                                        <option value="">Select ledger group</option>
                                                                        <option value="income">Income</option>
                                                                        <option value="expense">Expense</option>
                                                                        
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <div class="row">
                                                                          <div class="form-check form-check-inline" style="margin:16px;">
                                                                            <input class="form-check-input" type="checkbox" id="subroot_posting_head_ind" name="posting_head_ind" value="1"/>
                                                                            <label class="form-check-label" for="inlineCheckbox1">Is Transectional Head ?</label>
                                                                          </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="acct_type_sl">SL No.</label>
                                                                    <select name="account_no_sl" class="form-control" id="subroot_account_no_sl">
                                                                        <option value="">Select serial no</option>
                                                                        <option value="1">1</option>
                                                                        <option value="2">2</option>
                                                                        <option value="3">3</option>
                                                                        <option value="4">4</option>
                                                                        <option value="5">5</option>
                                                                        <option value="6">6</option>
                                                                        <option value="7">7</option>
                                                                        <option value="8">8</option>
                                                                        <option value="9">9</option>
                                                                        <option value="10">10</option>
                                                                        <option value="11">11</option>
                                                                        <option value="12">12</option>
                                                                    </select>
                                                                </div>
                                                                
                                                                <div class="form-group">
                                                                    <label for="status">Status</label>
                                                                    <select name="status" class="form-control" id="subroot_status">
                                                                        <option value="">Select status</option>
                                                                        <option value="1">Yes</option>
                                                                        <option value="0">No</option>
                                                                        
                                                                    </select>
                                                                </div>
                                                                <div  class="form-group">
                                                                <button type="submit" class="btn btn-primary save_chart_of_account">Submit</button>
                                                                <span class="save_loader pl-3"> <i class='fas fa-stroopwafel fa-spin'></i></span>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <span class="save_loader pl-3"> <i class='fas fa-stroopwafel fa-spin'></i></span>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="cost-center" role="tabpanel" aria-labelledby="cost-center-tab">
                            <div class="jstree">
                                <ul>
                                    <li> Central Pharmacy <span title="Add Account Head Group"
                                            class="btn btn-info btn-sm" style="margin-top:-3px; margin-right:5px;"><i
                                                class="fa fa-plus"></i></span>
                                        <ul>
                                            <li>OPD Parmacy</li>
                                        </ul>
                                    </li>
                                </ul>
                                <ul>
                                    <li> Central Store <span title="Add Account Head Group" class="btn btn-info btn-sm"
                                            style="margin-top:-3px; margin-right:5px;"><i
                                                class="fa fa-plus"></i></span>
                                        <ul>
                                            <li>Central Store</li>
                                        </ul>
                                    </li>
                                </ul>
                                <ul>
                                    <li> Echo <span title="Add Account Head Group" class="btn btn-info btn-sm"
                                            style="margin-top:-3px; margin-right:5px;"><i
                                                class="fa fa-plus"></i></span>
                                        <ul>
                                            <li>Echo</li>
                                        </ul>
                                    </li>
                                </ul>
                                <ul>
                                    <li> Finance Division<span title="Add Account Head Group"
                                            class="btn btn-info btn-sm" style="margin-top:-3px; margin-right:5px;"><i
                                                class="fa fa-plus"></i></span>
                                        <ul>
                                            <li>Finance</li>
                                            <li>Material Management</li>
                                        </ul>
                                    </li>
                                </ul>

                                <ul>
                                    <li>General Support Service<span title="Add Account Head Group"
                                            class="btn btn-info btn-sm" style="margin-top:-3px; margin-right:5px;"><i
                                                class="fa fa-plus"></i></span>
                                        <ul>
                                            <li>Bio Medical</li>
                                            <li>Electrical</li>
                                            <li>Maintenance
                                                <ul>
                                                    <li>Mechanical</li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>



                                <ul>
                                    <li>HR<span title="Add Account Head Group" class="btn btn-info btn-sm"
                                            style="margin-top:-3px; margin-right:5px;"><i
                                                class="fa fa-plus"></i></span>
                                        <ul>
                                            <li>HR Service Delivery
                                                <ul>
                                                    <li></li>
                                                </ul>
                                            </li>
                                            <li>Planning, Recruitment and Training
                                                <ul>
                                                    <li></li>
                                                </ul>
                                            </li>
                                            <li>Rewards Management</li>


                                        </ul>
                                    </li>
                                </ul>




                            </div>
                        </div>

                        <div class="tab-pane fade" id="accounts-levels" role="tabpanel"
                            aria-labelledby="accounts-levels-tab">
                            <div class="row">
                                <div class="col-md-12 table-responsive">
                                    <div style="position: absolute;
                                                        width: 100%;
                                                        height: 100%;
                                                        background-color: #000;
                                                        z-index: 999;
                                                        opacity: 0.6;
                                                        line-height: 41em;" class="account_edit_pre_loader">
                                                            <i class='fas fa-stroopwafel fa-spin' style="position: relative; left:45%;"></i>
                                                        </div>
                                    <input type="hidden" name="account_type_action" id="account_type_action" value="{{route('request-get-accounts-level','')}}"/>
                                    <table class="table table-bordered table-striped mb-0 mt-4 accounts_level">
                                        <thead>
                                            <tr class="bg-primary">
                                                <th class="text-center w-5">SL</th>
                                                <th class="text-center w-10">UD AC No</th>
                                                <th class="text-left w-10">Account Head</th>
                                                <th class="text-left w-20">
                                                    <select class="form-control" id="account_level_acct_type" name="account_level_acct_type"
                                                        style=" margin-bottom: 0px !important;">
                                                        <option value="all">A/C Type</option>
                                                        @foreach($root_accounts as $account)
                                                            <option value="{{$account->account_no_pk}}">{{$account->account_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </th>
                                                <th class="text-left">
                                                    <select class="form-control" id="" name=""
                                                        style=" margin-bottom: 0px !important;">
                                                        <option>Statement Level</option>
                                                    </select>
                                                </th>
                                                <th class="text-left">Cash Flow Group</th>
                                                <th class="text-left">C/R Category</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="voucher-type" role="tabpanel"
                            aria-labelledby="voucher-type-tab">
                            <div class="row justify-content-center">
                                <div class="col-md-8">
                                    <div class="card">
                                        <div class="card-header text-center bg-primary text-white">
                                            <h5 class="float-left">Voucher Type Information</h5>
                                            <button class="btn btn-success float-right add_voucher_type"><i class="fa fa-plus"></i> Add</button>
                                            <span class="voucher_type_message"></span>
                                            <div class="voucher_type_form">
                                                <form method="post" action="#">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <input type="text" name="voucher_type_code" class="form-control" id="voucher_type_code" placeholder="code ex.VT001">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <input type="text" name="voucher_type_name" class="form-control" id="voucher_type_name" placeholder="Type name">
                                                        </div>
                                                        <div class="col-md-3">
                                                            <button type="submit" class="btn btn-primary save_voucher_type" style="position: relative; float:left;"><span class="save_loader_voucher_type pl-3" style="display: none; float:left;"><i class="fas fa-stroopwafel fa-spin"></i></span> Submit</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="card-body p-2">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-striped mb-0 get_vouchertype">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center w-5">SL#</th>
                                                            <th class="text-center w-5">Code</th>
                                                            <th class="text-left">Name</th>
                                                            <th class="text-center w-10">Status</th>
                                                            <th class="text-center w-10">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if(isset($voucher_type->getData()->data))
                                                        @php
                                                            $i = 1;
                                                        @endphp
                                                        @foreach($voucher_type->getData()->data as $vtype)
                                                        <tr>
                                                            <td class="text-center">{{$i}}</td>
                                                            <td class="text-left">{{$vtype->voucher_type_code}}</td>
                                                            <td class="text-left">{{$vtype->voucher_type_name}}</td>
                                                            <td class="text-center status_render{{$vtype->voucher_type_no_pk}}" colspan="2">
                                                                @if($vtype->status == 1)
                                                                <button
                                                                    class="btn btn-block btn-outline-success bg-transperant type_active_inactive"
                                                                    data-voucher_type_no_pk="{{$vtype->voucher_type_no_pk}}" data-status="{{$vtype->status}}" type="button"><span class="save_loader vtype{{$vtype->voucher_type_no_pk}} pl-3" style="display: none;"><i class="fas fa-stroopwafel fa-spin"></i></span> Active </button>
                                                                @else
                                                                <button
                                                                    class="btn btn-block btn-danger type_active_inactive"
                                                                    data-voucher_type_no_pk="{{$vtype->voucher_type_no_pk}}" data-status="{{$vtype->status}}" type="button"><span class="save_loader vtype{{$vtype->voucher_type_no_pk}} pl-3" style="display: none;"><i class="fas fa-stroopwafel fa-spin"></i></span> Inactive </button>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        @php
                                                            $i++;
                                                        @endphp
                                                        @endforeach
                                                        @endif
                                                    </tbody>
                                                </table>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>




</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.js"></script>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function(){

        $.ajax({
            url: "{{route('tree-view')}}",
            method: "get",
            success: function(response){
                $('.chart_of_account_tree').html(response);
            }
        })

        $('body').on('click','.add_voucher_type', function(){
            $('.voucher_type_form').show();
            $(this).hide();
        });

        $('body').on('click','.save_voucher_type', function(e){
            e.preventDefault();
            let _this = $(this);
            $.ajax({
                url: "{{route('add-vouchertype')}}",
                method: "post",
                data: {
                    'voucher_type_code': $('#voucher_type_code').val(),
                    'voucher_type_name': $('#voucher_type_name').val()
                },
                beforeSend: function() {
                    $('.save_voucher_type').attr('disabled',true)
                    $('.save_loader_voucher_type').show();
                },
                success: function(success) {
                    $('.voucher_type_form').hide();
                    $('.add_voucher_type').show();
                    
                    if (success.success == true) {
                        $('.get_vouchertype tbody').empty();
                        $.ajax({
                            url: "{{route('get-vouchertype')}}",
                            method: "get",
                            success: function(response) {
                                    console.log('voucher type',response.data)
                                    let i = 1;
                                    Array.from(response.data).forEach(type => {
                                        $('.get_vouchertype tbody').append(`
                                            <tr>
                                                <td class="text-center">${i}</td>
                                                <td class="text-center">${type.voucher_type_code}</td>
                                                <td class="text-left">${type.voucher_type_name}</td>
                                                <td class="text-center status_render${type.voucher_type_no_pk}" colspan="2">
                                                    
                                                    <button
                                                        class="btn btn-block ${type.status == 1 ? 'btn-outline-success bg-transperant' : 'btn-danger'} type_active_inactive"
                                                        data-voucher_type_no_pk="${type.voucher_type_no_pk}" data-status="${type.status}" type="button"><span class="save_loader vtype${type.voucher_type_no_pk} pl-3" style="display: none;"><i class="fas fa-stroopwafel fa-spin"></i></span> Active </button>
                                                    
                                                </td>
                                            </tr>
                                        `);
                                        i++;
                                    });

                                    $('.save_voucher_type').attr('disabled',false)
                                    $('.save_loader_voucher_type').hide();
                            }
                        })
                    } else {
                        $('.voucher_type_message').show()
                        $('.voucher_type_message').text(success.message)
                        setTimeout(function(){
                            $('.voucher_type_message').hide();
                            $('.save_voucher_type').attr('disabled',false)
                            $('.save_loader_voucher_type').hide();
                        },1500)
                    }
                    e.stopImmediatePropagation()
                }
            })
        });

        $('body').on('click','.type_active_inactive', function(){
            let _this = $(this)
            $.ajax({
                url: "{{route('set-vouchertype-status')}}",
                method: "post",
                data: {
                    id: $(this).data('voucher_type_no_pk'),
                    status: $(this).data('status')
                },
                beforeSend:function() {
                    $('.vtype'+_this.data('voucher_type_no_pk')).show();
                    _this.attr('disabled',true)
                },
                success: function(response) {
                    if (response.data.status == 1) {
                        $('.status_render'+response.data.voucher_type_no_pk).empty();
                        $('.status_render'+response.data.voucher_type_no_pk).html(`
                            <button
                                class="btn btn-block btn-outline-success bg-transperant type_active_inactive"
                                data-voucher_type_no_pk="${response.data.voucher_type_no_pk}" data-status="${response.data.status}" type="button"><span class="save_loader vtype${response.data.voucher_type_no_pk} pl-3" style="display: none;"><i class="fas fa-stroopwafel fa-spin"></i></span> Active </button>
                        `)
                    } else {
                        $('.status_render'+response.data.voucher_type_no_pk).empty();
                        $('.status_render'+response.data.voucher_type_no_pk).html(`
                            <button
                                class="btn btn-block btn-danger type_active_inactive"
                                data-voucher_type_no_pk="${response.data.voucher_type_no_pk}" data-status="${response.data.status}" type="button"><span class="save_loader vtype${response.data.voucher_type_no_pk} pl-3" style="display: none;"><i class="fas fa-stroopwafel fa-spin"></i></span> Inactive </button>
                        `)
                    }

                    $('.vtype'+response.data.voucher_type_no_pk).hide();
                    
                    console.log(response.data.status)
                }
            })
        })
        

        
        $.ajax({
            url: "{{route('get-accounts-level')}}",
            method: 'get',
            beforeSend: function() {
                $('.account_edit_pre_loader').show();
            },
            success: function(success) {
                $('.accounts_level tbody').empty();
                Array.from(success.data).forEach(acc_level => {
                    $('.accounts_level tbody').append(`
                        <tr>
                            <td>${acc_level.sl}</td>
                            <td>${acc_level.acc_code}</td>
                            <td>${acc_level.acc_name}</td>
                            <td>${acc_level.acc_type_name != null ? acc_level.acc_type_name : ''}</td>
                            <td>${acc_level.cashflow_category_name != null ? acc_level.cashflow_category_name : ''}</td>
                            <td></td>
                            <td></td>
                            <td class="text-center" style="padding: 2px;">
                                <button class="btn btn-sm btn-info btn-block text-capitalize"
                                    type="button">
                                    <span class="fa fa-edit"></span> Edit
                                </button>
                            </td>
                        </tr>
                    `);
                })

                $('.account_edit_pre_loader').hide();
            },
            error: function(err) {

            }
        })

        $('body').on('change','#account_level_acct_type', function(){
            let acct_type_url = $('#account_type_action').val();
            $.ajax({
                url:acct_type_url+"/"+$(this).val(),
                method: 'get',
                beforeSend: function() {
                    $('.account_edit_pre_loader').show();
                },
                success: function(success) {
                    $('.accounts_level tbody').empty();
                    Array.from(success.data).forEach(acc_level => {
                        $('.accounts_level tbody').append(`
                            <tr>
                                <td>${acc_level.sl}</td>
                                <td>${acc_level.acc_code}</td>
                                <td>${acc_level.acc_name}</td>
                                <td>${acc_level.acc_type_name != null ? acc_level.acc_type_name : ''}</td>
                                <td>${acc_level.cashflow_category_name != null ? acc_level.cashflow_category_name : ''}</td>
                                <td></td>
                                <td></td>
                                <td class="text-center" style="padding: 2px;">
                                    <button class="btn btn-sm btn-info btn-block text-capitalize"
                                        type="button">
                                        <span class="fa fa-edit"></span> Edit
                                    </button>
                                </td>
                            </tr>
                        `);
                    })

                    $('.account_edit_pre_loader').hide();
                }
            })
        })



        $.ajax({
            url: "{{ route('get-acc-type') }}",
            method: 'get',
            beforeSend: function() {
                $('.save_loader').show();
            },
            success: function(response) {

                
                $('.acct_type_table > tbody').empty();
                //$('.save_loader').html('<strong style="color:green;">'+response.message+'</strong>');
               
                let a = 1;
                response.data.forEach(acct => {
                    $('.acct_type_table > tbody').append(`
                        <tr>
                            <td>${a}</td>
                            <td>${acct.acct_type_code}</td>
                            <td>${acct.acct_type_name}</td>
                            <td>${acct.status == 1 ? 'Active' : 'Inactive'}</td>
                            <td>
                                <span class="btn btn-sm btn-primary edit_acct_type" data-toggle="modal" data-acct_type_no_pk="${acct.acct_type_no_pk}" data-cashflow_ind="${acct.cashflow_ind}" data-income_exp_ind="${acct.income_exp_ind}" data-acct_type_name="${acct.acct_type_name}" data-acct_type_code="${acct.acct_type_code}" data-acct_type_sl="${acct.acct_type_sl}" data-status="${acct.status}" data-target="#acct_type"><i
                                    class="fa fa-pencil-alt"></i></span>
                                
                            </td>
                        </tr>

                    `)

                    a++;
                });
                setTimeout(function() {
                    $('.save_loader').html("<i class='fas fa-stroopwafel fa-spin'></i>");
                    $('.save_loader').hide();
                    
                    $('#acct_type_code').val('')
                    $('#acct_type_name').val('')
                    $('#acct_type_sl').val('')
                    $('#status').val('')
                }, 2000)

            },
            error: function(err) {
                $('.save_loader').html('<strong style="color:red;">' + JSON.parse(err.responseText)
                    .message + '</strong>');
            }
        })


        $('body').on('click', '.save_acc_type', function(e) {
            $('#acc_type').validate({ // initialize the plugin
                rules: {
                    acct_type_code: {
                        required: true,
                    },
                    acct_type_name: {
                        required: true,
                    }
                }
            });

            if ($('#cashflow_ind').prop('checked') == true) {
                $('#cashflow_ind').val(1)
            } else {
                $('#cashflow_ind').val(0)
            }

            if ($('#income_exp_ind').prop('checked') == true) {
                $('#income_exp_ind').val(1)
            } else {
                $('#income_exp_ind').val(0)
            }

            let _this = $(this)
            e.preventDefault();
            $.ajax({
                url: "{{ route('save-acc-type') }}",
                method: 'post',
                data: {
                    acct_type_code: $('#acct_type_code').val(),
                    acct_type_name: $('#acct_type_name').val(),
                    acct_type_sl: $('#acct_type_sl').val(),
                    status: $('#status').val(),
                    cashflow_ind: $('#cashflow_ind').val(),
                    income_exp_ind: $('#income_exp_ind').val()
                },
                beforeSend: function() {
                    $('.save_loader').show();
                    _this.attr("disabled", true)
                    e.stopImmediatePropagation()
                },
                success: function(response) {
                    $('.acct_type_table > tbody').empty();
                    //$('.save_loader').html('<strong style="color:green;">'+response.message+'</strong>');
                    $('.save_loader').html(
                        '<strong style="color:green;">Account type inserted successfully</strong>');
                    let a = 1;
                    response.data.forEach(acct => {
                        $('.acct_type_table > tbody').append(`
                            <tr>
                                <td>${a}</td>
                                <td>${acct.acct_type_code}</td>
                                <td>${acct.acct_type_name}</td>
                                <td>${acct.status == 1 ? 'Active' : 'Inactive'}</td>
                                <td>
                                    <span class="btn btn-sm btn-primary edit_acct_type" data-toggle="modal" data-cashflow_ind="${acct.cashflow_ind}" data-income_exp_ind="${acct.income_exp_ind}" data-acct_type_no_pk="${acct.acct_type_no_pk}" data-acct_type_name="${acct.acct_type_name}" data-acct_type_code="${acct.acct_type_code}" data-acct_type_sl="${acct.acct_type_sl}" data-status="${acct.status}" data-target="#acct_type"><i
                                        class="fa fa-pencil-alt"></i></span>
                                    
                                </td>
                            </tr>

                        `)

                        a++;
                    });
                    setTimeout(function() {
                        $('.save_loader').html("<i class='fas fa-stroopwafel fa-spin'></i>");
                        $('.save_loader').hide();
                        _this.attr("disabled", false)
                        $('#acct_type_code').val('')
                        $('#acct_type_name').val('')
                        $('#acct_type_sl').val('')
                        $('#status').val('')
                    }, 2000)

                    e.stopImmediatePropagation()
                },
                error: function(err) {
                    $('.save_loader').html('<strong style="color:red;">' + JSON.parse(err.responseText)
                        .message + '</strong>');
                }
            })
        })

        $('body').on('click', '.update_acc_type', function(e) {
            $('#acc_type').validate({ // initialize the plugin
                rules: {
                    acct_type_code: {
                        required: true,
                    },
                    acct_type_name: {
                        required: true,
                    }
                }
            });


            if ($('#edt_cashflow_ind').prop('checked') == true) {
                $('#edt_cashflow_ind').val(1)
            } else {
                $('#edt_cashflow_ind').val(0)
            }

            if ($('#edt_income_exp_ind').prop('checked') == true) {
                $('#edt_income_exp_ind').val(1)
            } else {
                $('#edt_income_exp_ind').val(0)
            }

            let _this = $(this)
            e.preventDefault();
            $.ajax({
                url: "{{ route('update-acc-type') }}",
                method: 'post',
                data: {
                    acct_type_no_pk: $('#edt_acct_type_no_pk').val(),
                    acct_type_code: $('#edt_acct_type_code').val(),
                    acct_type_name: $('#edt_acct_type_name').val(),
                    acct_type_sl: $('#edt_acct_type_sl').val(),
                    status: $('#edt_status').val(),
                    cashflow_ind: $('#edt_cashflow_ind').val(),
                    income_exp_ind: $('#edt_income_exp_ind').val()
                },
                beforeSend: function() {
                    $('.save_loader').show();
                    _this.attr("disabled", true)
                    e.stopImmediatePropagation()
                },
                success: function(response) {
                    $('#acct_type').modal('hide')
                    $('.acct_type_table > tbody').empty();
                    //$('.save_loader').html('<strong style="color:green;">'+response.message+'</strong>');
                    $('.save_loader').html(
                        '<strong style="color:green;">Account type updated successfully</strong>');
                    let a = 1;
                    response.data.forEach(acct => {
                        $('.acct_type_table > tbody').append(`
                            <tr>
                                <td>${a}</td>
                                <td>${acct.acct_type_code}</td>
                                <td>${acct.acct_type_name}</td>
                                <td>${acct.status == 1 ? 'Active' : 'Inactive'}</td>
                                <td>
                                    <span class="btn btn-sm btn-primary edit_acct_type" data-cashflow_ind="${acct.cashflow_ind}" data-income_exp_ind="${acct.income_exp_ind}" data-toggle="modal" data-acct_type_no_pk="${acct.acct_type_no_pk}" data-acct_type_name="${acct.acct_type_name}" data-acct_type_code="${acct.acct_type_code}" data-acct_type_sl="${acct.acct_type_sl}" data-status="${acct.status}" data-target="#acct_type"><i
                                        class="fa fa-pencil-alt"></i></span>
                                    
                                </td>
                            </tr>

                        `)

                        a++;
                    });
                    setTimeout(function() {
                        $('.save_loader').html("<i class='fas fa-stroopwafel fa-spin'></i>");
                        $('.save_loader').hide();
                        _this.attr("disabled", false)
                        $('#acct_type_code').val('')
                        $('#acct_type_name').val('')
                        $('#acct_type_sl').val('')
                        $('#status').val('')
                    }, 2000)

                    e.stopImmediatePropagation()
                },
                error: function(err) {
                    $('.save_loader').html('<strong style="color:red;">' + JSON.parse(err.responseText)
                        .message + '</strong>');
                }
            })
        })

        // $('body').on('shown.bs.modal','#acct_type', function(){
        //     let cashflow_ind = $('#edt_cashflow_ind').val()
        //     let income_exp_ind = $('#edt_income_exp_ind').val()

            
        //     if (cashflow_ind == 1) {
        //         $('#cashflow_ind').val(1)
        //         $('#cashflow_ind').prop('checked',true);
        //     } else {
        //         $('#cashflow_ind').val(0)
        //         $('#cashflow_ind').prop('checked',false);
        //     }

        //     if (income_exp_ind == 1) {
        //         $('#income_exp_ind').val(1)
        //         $('#income_exp_ind').prop('checked', true)
        //     } else {
        //         $('#income_exp_ind').val(0)
        //         $('#income_exp_ind').prop('checked', false)
        //     }
        // })

        $('body').on('click', '.edit_acct_type',function(){
            let acct_type_no_pk = $(this).data('acct_type_no_pk')
            let acct_type_name = $(this).data('acct_type_name')
            let acct_type_code = $(this).data('acct_type_code')
            let acct_type_sl = $(this).data('acct_type_sl');
            let acct_type_status = $(this).data('status');
            let cashflow_ind = $(this).data('cashflow_ind')
            let income_exp_ind = $(this).data('income_exp_ind')

            $('#edt_acct_type_no_pk').val(acct_type_no_pk)
            $('#edt_acct_type_code').val(acct_type_code)
            $('#edt_acct_type_name').val(acct_type_name)
            $('#edt_acct_type_sl').val(acct_type_sl);
            $('#edt_status').val(acct_type_status)
            

            
            if (cashflow_ind == 1) {
                $('#edt_cashflow_ind').val(1)
                $('#edt_cashflow_ind').prop('checked',true);
            } else {
                $('#edt_cashflow_ind').val(0)
                $('#edt_cashflow_ind').prop('checked',false);
            }

            if (income_exp_ind == 1) {
                $('#edt_income_exp_ind').val(1)
                $('#edt_income_exp_ind').prop('checked', true)
            } else {
                $('#edt_income_exp_ind').val(0)
                $('#edt_income_exp_ind').prop('checked', false)
            }
        });

        $('body').on('click','.root_child', function(){
            const cashflow_ind = $(this).data('cashflow_ind');
            const income_exp_ind = $(this).data('income_exp_ind');
            const root_id = $(this).data('root_id')
            const modal_step = $(this).data('step')
            
            let prefix = '';

            if (modal_step == "subroot_first") {
                prefix = 'subroot_first_'
                $('#input_prefix').val(prefix);
            } else if(modal_step == "subroot") {
                prefix = 'subroot_'
                $('#input_prefix').val(prefix);
            } else {
                prefix = 'root_'
                $('#input_prefix').val(prefix);
            }

            let input_prefix = $('#input_prefix').val()


            $('#'+input_prefix+'account_no_fk_root_0').val(root_id)

            if (cashflow_ind == "1") {
                $('.cash_flow').show();
            } else {
                $('.cash_flow').hide();
            }

            if (income_exp_ind == "1") {
                $('.income_exp').show();
            } else {
                $('.income_exp').hide();
            }

            $.ajax({
                url: "{{route('last-account-code')}}",
                method: "get",
                success: function(response) {
                    $('.last_account_code').html('<strong>Last account code</strong> '+response.data.original.data.account_code)
                    $('#'+input_prefix+'account_code').val((parseInt(response.data.original.data.account_code)+1))
                }
            })
        })

        $('body').on('click','.subroot_first_child', function(){
            const root_id = $(this).data('root_id')
            const modal_step = $(this).data('step')
            
            let prefix = '';

            if (modal_step == "subroot_first") {
                prefix = 'subroot_first_'
                $('#input_prefix').val(prefix);
            } else if(modal_step == "subroot") {
                prefix = 'subroot_'
                $('#input_prefix').val(prefix);
            } else {
                prefix = 'root_'
                $('#input_prefix').val(prefix);
            }

            let input_prefix = $('#input_prefix').val()

            $('#'+input_prefix+'account_no_fk_root_0').val(root_id)


            $.ajax({
                url: "{{route('last-account-code')}}",
                method: "get",
                success: function(response) {
                    $('.last_account_code').html('<strong>Last account code</strong> '+response.data.original.data.account_code)
                    $('#'+input_prefix+'account_code').val((parseInt(response.data.original.data.account_code)+1))
                }
            })
        })

        $('body').on('click','.subroot_child', function(){
            const root_id = $(this).data('root_id')
            const modal_step = $(this).data('step')
            
            let prefix = '';

            if (modal_step == "subroot_first") {
                prefix = 'subroot_first_'
                $('#input_prefix').val(prefix);
            } else if(modal_step == "subroot") {
                prefix = 'subroot_'
                $('#input_prefix').val(prefix);
            } else {
                prefix = 'root_'
                $('#input_prefix').val(prefix);
            }

            let input_prefix = $('#input_prefix').val()

            $('#'+input_prefix+'account_no_fk_root_0').val(root_id)


            $.ajax({
                url: "{{route('last-account-code')}}",
                method: "get",
                success: function(response) {
                    $('.last_account_code').html('<strong>Last account code</strong> '+response.data.original.data.account_code)
                    $('#'+input_prefix+'account_code').val((parseInt(response.data.original.data.account_code)+1))
                }
            })
        })

        $('body').on('shown.bs.modal','#add_acct_account_head_root', function (e) {
            let input_prefix = $('#input_prefix').val()
            $('#'+input_prefix+'account_name').focus()
        })

        $('body').on('shown.bs.modal','#add_acct_account_head_subroot_first', function (e) {
            let input_prefix = $('#input_prefix').val()
            $('#'+input_prefix+'account_name').focus()
        })

        $('body').on('shown.bs.modal','#add_acct_account_head_subroot', function (e) {
            let input_prefix = $('#input_prefix').val()
            $('#'+input_prefix+'account_name').focus()
        })

        $('body').on('click','.save_chart_of_account', function(e){
            e.preventDefault();
            const _this = $(this)
            let posting_head_ind = 0;
            let input_prefix = $('#input_prefix').val()

            if ($('#'+input_prefix+'posting_head_ind').prop('checked') == true) {
                
                posting_head_ind = 1
            }

            $.ajax({
                url: "{{route('save-chart-of-accounts')}}",
                method: "post",
                data: {
                    account_no_fk_root_0: $('#'+input_prefix+'account_no_fk_root_0').val(),
                    account_code: $('#'+input_prefix+'account_code').val(),
                    account_name: $('#'+input_prefix+'account_name').val(),
                    income_exp_type: $('#'+input_prefix+'income_exp_type').val(),
                    ledger_group_name:$('#'+input_prefix+'ledger_group_name').val(),
                    account_no_sl: $('#'+input_prefix+'account_no_sl').val(),
                    status:$('#'+input_prefix+'status').val(),
                    cashflow_category_no_fk: $('#'+input_prefix+'cashflow_category_no_fk').val(),
                    posting_head_ind: $('#'+input_prefix+'posting_head_ind').prop('checked') == true ? 1 : 0
                },
                beforeSend: function() {
                    $('.save_loader').show();
                    _this.attr("disabled", true)
                    e.stopImmediatePropagation()
                },
                success: function(response) {
                    $('#add_acct_account_head_root').modal('hide')
                    $('#add_acct_account_head_subroot_first').modal('hide')
                    $('#add_acct_account_head_subroot').modal('hide')
                    //$('.acct_type_table > tbody').empty();
                    
                    $('.save_loader').html(
                        '<strong style="color:green;">Account head inserted successfully</strong>');
                    // let a = 1;
                    // response.data.forEach(acct => {
                    //     $('.acct_type_table > tbody').append(`
                    //         <tr>
                    //             <td>${a}</td>
                    //             <td>${acct.acct_type_code}</td>
                    //             <td>${acct.acct_type_name}</td>
                    //             <td>${acct.status == 1 ? 'Active' : 'Inactive'}</td>
                    //             <td>
                    //                 <span class="btn btn-sm btn-primary edit_acct_type" data-cashflow_ind="${acct.cashflow_ind}" data-income_exp_ind="${acct.income_exp_ind}" data-toggle="modal" data-acct_type_no_pk="${acct.acct_type_no_pk}" data-acct_type_name="${acct.acct_type_name}" data-acct_type_code="${acct.acct_type_code}" data-acct_type_sl="${acct.acct_type_sl}" data-status="${acct.status}" data-target="#acct_type"><i
                    //                     class="fa fa-pencil-alt"></i></span>
                                    
                    //             </td>
                    //         </tr>

                    //     `)

                    //     a++;
                    // });

                    $.ajax({
                        url: "{{route('tree-view')}}",
                        method: "get",
                        beforeSend: function(){
                            $('.save_loader').hide();
                            $('.chart_of_account_tree').html('<span class="chart_save_loader pl-3" style="display: block;"><i class="fas fa-stroopwafel fa-spin"></i></span>');
                        },
                        success: function(response){
                            $('.save_loader').hide();
                            $('.chart_save_loader').hide();
                            $('.chart_of_account_tree').html(response);
                        }
                    })

                    

                    setTimeout(function() {
                        $('.save_loader').html("<i class='fas fa-stroopwafel fa-spin'></i>");
                        
                        _this.attr("disabled", false)
                        $('#'+input_prefix+'account_code').val('')
                        $('#'+input_prefix+'account_name').val('')
                        $('#'+input_prefix+'cashflow_category_no_fk').val('')
                        $('#'+input_prefix+'income_exp_type').val('')
                        $('#'+input_prefix+'ledger_group_name').val('')
                        $('#'+input_prefix+'account_no_sl').val('')
                        $('#'+input_prefix+'status').val('')
                    }, 2000)

                    

                    e.stopImmediatePropagation()
                },
                error: function(err) {
                    $('.save_loader').html('<strong style="color:red;">' + JSON.parse(err.responseText)
                        .message + '</strong>');
                }
            })
        })


        $('body').on('click','.update_chart_of_account', function(e){
            e.preventDefault();
            const _this = $(this)
            let posting_head_ind = 0;
            let input_prefix = $('#input_prefix').val()

            if ($('#edit_posting_head_ind').prop('checked') == true) {
                
                posting_head_ind = 1
            }

            // $('#edit_account_no_pk').val(account_no_pk)
            // $('#edit_cashflow_ind').val(cashflow_ind)
            // $('#edit_income_exp_ind').val(income_exp_ind)
            
            // $('#edit_account_name').val(account_name)
            // $('#edit_income_exp_type').val(income_exp_type)
            // $('#edit_ledger_group_name').val(ledger_group_name)
            // $('#edit_account_no_sl').val(account_no_sl)
            // $('#edit_status').val(status)

            $.ajax({
                url: "{{route('update-chart-of-accounts')}}",
                method: "post",
                data: {
                    account_no_pk: $('#edit_account_no_pk').val(),
                    account_name: $('#edit_account_name').val(),
                    income_exp_type: $('#edit_income_exp_type').val(),
                    ledger_group_name:$('#edit_ledger_group_name').val(),
                    account_no_sl: $('#edit_account_no_sl').val(),
                    status:$('#edit_status').val(),
                    cashflow_category_no_fk: $('#edit_cashflow_category_no_fk').val(),
                    posting_head_ind: $('#edit_posting_head_ind').prop('checked') == true ? 1 : 0,
                    cashflow_ind: $('#edit_cashflow_ind').val(),
                    income_exp_ind: $('#edit_income_exp_ind').val()
                },
                beforeSend: function() {
                    $('.save_loader').show();
                    _this.attr("disabled", true)
                    e.stopImmediatePropagation()
                },
                success: function(response) {
                    $('#add_acct_account_head_root_edit').modal('hide')
                    $('#add_acct_account_head_root').modal('hide')
                    $('#add_acct_account_head_subroot_first').modal('hide')
                    $('#add_acct_account_head_subroot').modal('hide')
                    //$('.acct_type_table > tbody').empty();
                    
                    $('.save_loader').html(
                        '<strong style="color:green;">Account head inserted successfully</strong>');
                    // let a = 1;
                    // response.data.forEach(acct => {
                    //     $('.acct_type_table > tbody').append(`
                    //         <tr>
                    //             <td>${a}</td>
                    //             <td>${acct.acct_type_code}</td>
                    //             <td>${acct.acct_type_name}</td>
                    //             <td>${acct.status == 1 ? 'Active' : 'Inactive'}</td>
                    //             <td>
                    //                 <span class="btn btn-sm btn-primary edit_acct_type" data-cashflow_ind="${acct.cashflow_ind}" data-income_exp_ind="${acct.income_exp_ind}" data-toggle="modal" data-acct_type_no_pk="${acct.acct_type_no_pk}" data-acct_type_name="${acct.acct_type_name}" data-acct_type_code="${acct.acct_type_code}" data-acct_type_sl="${acct.acct_type_sl}" data-status="${acct.status}" data-target="#acct_type"><i
                    //                     class="fa fa-pencil-alt"></i></span>
                                    
                    //             </td>
                    //         </tr>

                    //     `)

                    //     a++;
                    // });

                    $.ajax({
                        url: "{{route('tree-view')}}",
                        method: "get",
                        beforeSend: function(){
                            $('.save_loader').hide();
                            //$('.chart_of_account_tree').html('<span class="chart_save_loader pl-3" style="display: block;"><i class="fas fa-stroopwafel fa-spin"></i></span>');
                        },
                        success: function(response){
                            $('.save_loader').hide();
                            $('.chart_save_loader').hide();
                            //$('.chart_of_account_tree').html(response);
                        }
                    })

                    

                    setTimeout(function() {
                        $('.save_loader').html("<i class='fas fa-stroopwafel fa-spin'></i>");
                        
                        _this.attr("disabled", false)
                        $('#edit_account_name').val('')
                        $('#edit_cashflow_category_no_fk').val('')
                        $('#edit_income_exp_type').val('')
                        $('#edit_ledger_group_name').val('')
                        $('#edit_account_no_sl').val('')
                        $('#edit_status').val('')
                    }, 1000)

                    

                    e.stopImmediatePropagation()
                },
                error: function(err) {
                    $('.save_loader').html('<strong style="color:red;">' + JSON.parse(err.responseText)
                        .message + '</strong>');
                }
            })
        })


        $('body').on('click','.root_first_edit', function(e){
            let account_no_pk = $(this).attr('data-account_no_pk');
            let cashflow_ind = $(this).attr('data-cashflow_ind');
            let income_exp_ind = $(this).attr('data-income_exp_ind');
            let posting_head_ind = $(this).attr('data-posting_head_ind');
            let account_name = $(this).attr('data-account_name');
            let income_exp_type = $(this).attr('data-income_exp_type');
            let ledger_group_name = $(this).attr('data-ledger_group_name');
            let cashflow_category_no = $(this).attr('data-cashflow_category_no_fk');
            let account_no_sl = $(this).attr('data-account_no_sl');
            let status = $(this).attr('data-status')
            

            $('#edit_account_no_pk').val(account_no_pk)
            $('#edit_cashflow_ind').val(cashflow_ind)
            $('#edit_income_exp_ind').val(income_exp_ind)
            $('#edit_cashflow_category_no_fk').val(cashflow_category_no)
            
            $('#edit_account_name').val(account_name)
            $('#edit_income_exp_type').val(income_exp_type)
            $('#edit_ledger_group_name').val(ledger_group_name)
            $('#edit_account_no_sl').val(account_no_sl)
            $('#edit_status').val(status)
            if (posting_head_ind == 1) {

                $('#edit_posting_head_ind').prop('checked',true);
                $('#edit_posting_head_ind').val(1)

            } else {

                $('#edit_posting_head_ind').prop('checked',false);
                $('#edit_posting_head_ind').val(0)

            }

            let _this = $(this)
           
            $('#add_acct_account_head_root_edit').on('show.bs.modal', function(c){
                $.ajax({
                    url: "{{route('accounts.get-chartof-account-byid')}}",
                    method: "get",
                    data: {
                        account_no_pk: $('#edit_account_no_pk').val()
                    },
                    beforeSend: function(){
                        account_no_pk = _this.attr('data-account_no_pk');
                        c.stopImmediatePropagation();
                        $('.account_edit_pre_loader').show();
                    },
                    success: function(response) {
                      
                        let cashflow_ind = $('#edit_cashflow_ind').val()
                        let income_exp_ind = $('#edit_income_exp_ind').val()
                        let posting_head_ind = $('#edit_posting_head_ind').val()
                        
                        if (cashflow_ind == 1) {
                            $('.cash_flow').show();
                        } else {
                            $('.cash_flow').hide();
                        }

                        if (income_exp_ind == 1) {
                            $('.income_exp').show();
                        } else {
                            $('.income_exp').hide();
                        }

                        if (posting_head_ind == 1) {
                            $('.posting_head').show();
                        } else {
                            $('.posting_head').hide();
                        }

                        
                        $('.account_edit_pre_loader').hide();
                        c.stopImmediatePropagation();
                    }
                })
                
            })
        })
    });
</script>
