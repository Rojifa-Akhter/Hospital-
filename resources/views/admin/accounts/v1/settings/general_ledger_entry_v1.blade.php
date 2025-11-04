<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<style>
    .select2-container .select2-dropdown {
        width: 400px !important; /* Specify the desired width here */        
    }
    .select2-selection__rendered{
        text-align: left !important;     
    }
    .select2-results__option{
        font-size: 12px !important;
    }
    .text-left{
        text-align:left;
    }
</style>
@php
    $data = collect($get_account_description->getData()->data)->sortBy('type_code')->values();
@endphp
<main id="page-content">
    <section class="fixed_asset">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="row justify-content-between align-items-center bg-white border-bottom sticky-top shadow-sm">
                        <div class="col-md-11">
                            <h5 class="mt-2 mb-0">General Ledger Entry</h5>
                            <small>Accounts / General Ledger Entry</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- form section -->
    <section class="fixed_asset">
        <div class="container-fluid">
            <form action="#" method="post" class="saveAccountLevel" id="saveAccountLevel">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-row">

                                    <div class="col-lg-4 col-md-6 col-12">
                                        <div class="form-group form-row">
                                            <label for="accDescription" class="col-sm-4 col-form-label">Acc. Description</label>
                                            <div class="col-sm-8">
                                                <select type="text" class="form-control form-control-sm select2" id="accDescription" name="accDescription" onchange="fetchGLCode(this.value)">
                                                    <option value="" selected>Select one</option>
                                                    @foreach ($data as $item)                                                        
                                                        <option value="{{$item->acc_5typedescription_no_pk}}">{{$item->type_code}} - {{$item->acc_5type_description}} @if(!empty($item->acc_code_range_5_start) && ($item->acc_code_range_5_end)) ( {{$item->acc_code_range_5_start}} - {{ $item->acc_code_range_5_end}} ) @endif</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-lg-4 col-md-6 col-12">
                                        <div class="form-group form-row">
                                            <label for="" class="col-sm-4 col-form-label">GL Description<span style="color:red">*</span></label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control form-control-sm" id="accName" name="accName" placeholder="General Description" value="" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-6 col-12">
                                        <div class="form-group form-row">
                                            <label for="accCode" class="col-sm-4 col-form-label">GL Code</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control form-control-sm" id="accCode" name="accCode" placeholder="GL Code" value=""/>
                                            </div>
                                        </div>
                                    </div>

                    
                                    <div class="col-lg-4 col-md-6 col-12">
                                        <div class="form-group form-row">
                                            <label for="controlAccount" class="col-sm-4 col-form-label">Control Account</label>
                                            <div class="col-sm-8">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="controlAccount" id="controlAccountYes" value="1"/>
                                                    <label class="form-check-label" for="controlAccountYes">Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="controlAccount" id="controlAccountNo" value="0"/>
                                                    <label class="form-check-label" for="controlAccountNo">No</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-6 col-12">
                                        <div class="form-group form-row mt-2">
                                            <label for="costCenter" class="col-sm-4 col-form-label">Cost Center</label>
                                            <div class="col-sm-8">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="costCenter" id="costCenterYes" value="1"/>
                                                    <label class="form-check-label" for="costCenterYes" >Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="costCenter" id="costCenterNo" value="0"/>
                                                    <label class="form-check-label" for="costCenterNo">No</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-6 col-12">
                                        <div class="form-group form-row mt-2">
                                            <label for="bank" class="col-sm-4 col-form-label">Account Type</label>
                                            <div class="col-sm-8">
                                                <select class="form-control" name="bank" id="bank" >
                                                    <option value="">Select Account Type</option>
                                                    @foreach(\App\Enums\AccountIndicator::getOptions() as $value => $label)
                                                        <option value="{{ $value }}" {{ (old('bank', $account->bank_ind ?? '') == $value) ? 'selected' : '' }}>
                                                            {{ $label }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-6 col-12">
                                        <div class="form-group form-row mt-2">
                                            <label for="status" class="col-sm-4 col-form-label">Status</label>
                                            <div class="col-sm-8">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="status" id="statusYes" value="1" checked/>
                                                    <label class="form-check-label" for="statusYes" >Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="status" id="statusNo" value="0"/>
                                                    <label class="form-check-label" for="statusNo">No</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-6 col-12">
                                        <div class="form-group form-row mt-2">
                                            <label for="recurringCost" class="col-sm-4 col-form-label">Recurring Cost</label>
                                            <div class="col-sm-8">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="recurringCost" id="recurringCostYes" value="1"/>
                                                    <label class="form-check-label" for="recurringCostYes" >Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="recurringCost" id="recurringCostNo" value="0"/>
                                                    <label class="form-check-label" for="recurringCostNo">No</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-6 col-12">
                                        <div class="form-group form-row mt-2">
                                            <label for="default_dr_cr" class="col-sm-4 col-form-label">Default Dr/Cr</label>
                                            <div class="col-sm-8">
                                                <select type="text" class="form-control form-control-sm" id="default_dr_cr" name="default_dr_cr">
                                                    <option value="" selected>Not set</option>
                                                    <option value="DR">DR</option>
                                                    <option value="CR">CR</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-6 col-12">
                                        <div class="form-group form-row">
                                            <label for="default_dr_cr" class="col-sm-4 col-form-label">Depreciation </label>
                                            <div class="col-sm-8">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="depreciation" id="depreciationYes" value="1"/>
                                                    <label class="form-check-label" for="depreciationYes" >Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="depreciation" id="depreciationNo" value="0" checked/>
                                                    <label class="form-check-label" for="depreciationNo">No</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>



                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h5>Mapped To</h5>
                            </div>

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-4 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="balanceSheetReport" class="col-form-label">Balance Sheet Report Asset</label>
                                            <div class="form-check">
                                                <label class="form-check-label" for="currAssetBL"> <input type="radio" class="form-check-input" id="currAssetBL" name="balanceSheetReport" value="Current AssetsBAL"/>Current Assets </label>
                                            </div>
                                            <div class="form-check">
                                                <label class="form-check-label" for="fixedAssetBL"> <input type="radio" class="form-check-input" id="fixedAssetBL" name="balanceSheetReport" value="Fixed & Long Term AssetsBAL"/>Non Current Assets </label>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="balanceSheetReport" class="col-form-label">Liabilities and Shareholders Equity</label>
                                            <div class="form-check">
                                                <label class="form-check-label" for="currLiabilitiesBL"> <input type="radio" class="form-check-input" id="currLiabilitiesBL" name="balanceSheetReport" value="Current LiabilitiesBAL"/>Current Liabilities </label>
                                            </div>
                                            <div class="form-check">
                                                <label class="form-check-label" for="longLiabilitiesBL"> <input type="radio" class="form-check-input" id="longLiabilitiesBL" name="balanceSheetReport" value="Long Term LiabilitiesBAL"/>Non Current Liabilities</label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="balanceSheetReport" class="col-form-label">Owners Equity</label>
                                            <div class="form-check">
                                                <label class="form-check-label" for="ownersEquity"> <input type="radio" class="form-check-input" id="ownersEquity" name="balanceSheetReport" value="Owners EquityOWN"/>Owners Equity </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="incomeStatement" class="col-form-label">Income Statement Report</label><br>
                                            <label for="incomeStatement" class="col-form-label">Income</label>
                                            <div class="form-check">
                                                <label class="form-check-label" for="revenueIS"> <input type="radio" class="form-check-input" id="revenueIS" name="balanceSheetReport" value="RevenueINC"/>Revenue </label>
                                            </div>
                                            <div class="form-check">
                                                <label class="form-check-label" for="otherIncomeIS"> <input type="radio" class="form-check-input" id="otherIncomeIS" name="balanceSheetReport" value="Other IncomeINC"/>Other Income </label>
                                            </div>

                                        </div>

                                        <div class="form-group">
                                            <label for="incomeStatement" class="col-form-label">Expense</label>
                                            <div class="form-check">
                                                <label class="form-check-label" for="costGoodsSoldIS"> <input type="radio" class="form-check-input" id="costGoodsSoldIS" name="balanceSheetReport" value="Cost Of Goods SoldINC"/>Cost Of Goods Sold </label>
                                            </div>
                                            <div class="form-check">
                                                <label class="form-check-label" for="operExpensIS"> <input type="radio" class="form-check-input" id="operExpensIS" name="balanceSheetReport" value="Operating ExpensesINC"/>Operating Expenses </label>
                                            </div>
                                            <div class="form-check">
                                                <label class="form-check-label" for="nonopglIS"> <input type="radio" class="form-check-input" id="nonopglIS" name="balanceSheetReport" value="Non-Operating Gain/LosesINC"/>Non-Operating Gain/Loses </label>
                                            </div>
                                            <div class="form-check">
                                                <label class="form-check-label" for="interestExpenseIS"> <input type="radio" class="form-check-input" id="interestExpenseIS" name="balanceSheetReport" value="Interest ExpenseINC"/>Interest Expense </label>
                                            </div>
                                            <div class="form-check">
                                                <label class="form-check-label" for="taxExpenseIS"> <input type="radio" class="form-check-input" id="taxExpenseIS" name="balanceSheetReport" value="Tax ExpenseINC"/>Tax Expense </label>
                                            </div>
                                            <div class="form-check">
                                                <label class="form-check-label" for="depeIS"> <input type="radio" class="form-check-input" id="depeIS" name="balanceSheetReport" value="Depreciation ExpenseINC"/>Depreciation Expense </label>
                                            </div>
                                            <div class="form-check">
                                                <label class="form-check-label" for="preferenceDIS"> <input type="radio" class="form-check-input" id="preferenceDIS" name="balanceSheetReport" value="Preference DividendINC"/>Preference Dividend </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="cashFlow" class="col-form-label">Cash Flow Report</label>
                                            <div class="form-check">
                                                <label class="form-check-label" for="cbyCF"> <input type="radio" class="form-check-input" id="cbyCF" name="cashFlow" value="Cash at Begining of Year"/>Cash at Begining of Year </label>
                                            </div>
                                            <div class="form-check">
                                                <label class="form-check-label" for="cffaCF"> <input type="radio" class="form-check-input" id="cffaCF" name="cashFlow" value="Cash Flows From Financial Activities"/>Cash Flows From Financial Activities </label>
                                            </div>
                                            <div class="form-check">
                                                <label class="form-check-label" for="cfiaCF"> <input type="radio" class="form-check-input" id="cfiaCF" name="cashFlow" value="Cash Flows From Investing Activities" />Cash Flows From Investing Activities </label>
                                            </div>
                                            <div class="form-check">
                                                <label class="form-check-label" for="cffoaCF"> <input type="radio" class="form-check-input" id="cffoaCF" name="cashFlow" value="Cash Flows From Operating Activities"/>Cash Flows From Operating Activities </label>
                                            </div>
                                            <div class="form-check">
                                                <label class="form-check-label" for="currAssetCF"> <input type="radio" class="form-check-input" id="currAssetCF" name="cashFlow" value="Current Assets"/>Current Assets </label>
                                            </div>
                                            <div class="form-check">
                                                <label class="form-check-label" for="currLiabilitiesCF"> <input type="radio" class="form-check-input" id="currLiabilitiesCF" name="cashFlow" value="Current Liabilities"/>Current Liabilities </label>
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
                        <div class="card mb-2">
                            <div class="card-body">
                                <div class="form-group">
                                    <ul class="list-inline btn__box">
                                        <li class="list-inline-item">
                                            <button type="button" class="btn btn-secondary uhl_save_btn" id="glSaveButton" onclick="saveAccountLevelForm()">Save</button>
                                        </li>

                                        {{-- <li class="list-inline-item"><button type="button" class="btn btn-danger">Cancel</button></li> --}}
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>


            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover accounts_gl_entry_table_v1" id="accountsGLEntryDataTable">
                                    <thead class="global-uhl-table-bg">
                                        <tr>
                                            <th class="text-left" style="width: 3%">SL</th>
                                            <th class="text-left" style="width: 12%">GL Description </th>
                                            <th class="text-left w-5">Status</th>
                                            <th class="text-left w-10">Mapped Report</th>
                                            <th class="text-left w-15">Report Header</th>
                                            <th class="text-left w-5">Cost Center</th>
                                            <th class="text-left w-10">Recurring Cost</th>
                                            <th class="text-left w-5">Control Account</th>
                                            <th class="text-left w-5">GL For</th>
                                            <th class="text-left w-10">Cash Flow Report</th>
                                            <th class="text-left w-10">Report Header</th>
                                            <th class="text-left w-5">Dr/Cr</th>
                                            <th class="text-left w-5">Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                   
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
    <!-- close form section -->
</main>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script>
    $("#saveAccountLevel").validate({
    rules:{
        accName:{
            required:true,
            minlength:2,
            maxlength:200,
            notOnlySpaces: true
        },
        accDescription:{
            required:true, 
        },
        accCode:{
            required:true, 
            minlength:1,
            maxlength:20,
            notOnlySpaces: true
        }
    },
    messages:{
        accName:{
            required: "Please Enter GL Description",
            pattern: "only spaces is not allowed"
        },
        accDescription:{
            required:'Please Select Account Description',
        }
    }
});
</script>

<script>

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
        });

        function fetchGLCode(id){  
            if(id){
                $.ajax({
                    url:"{{route('v1.accounts.get-gl-code','')}}/"+id,
                    method: 'get',
                    beforeSend: function() {
                            blockUI();
                    },
                    success:function(res){
                        $('#glSaveButton').attr('disabled',false);
                        $('#accCode').val(res.code);
                    },
                    error:function(err){
                        $.unblockUI();
                        var error = err.responseJSON;
                        $('#glSaveButton').attr('disabled',true);
                        $('.common-modal-notify-error').modal('show');
                        $('.common-modal-notify-error .modal-title').html('Failed');
                        $('.common-modal-notify-error .modal-body').html(error.message);
                    },
                    complete: function() {
                        $.unblockUI();
                    }
                })
            }
        }

        getGLLedgerListEntry();
        function getGLLedgerListEntry(){
                $.ajax({
                url: "{{route('v1.accounts.get-accounts-general-ledger-entry')}}",
                method: "get",
                success: function(response){
                    if(response.data.length != 0)
                    setTableData(response.data);
                    else
                    emptyTable();
                },
                error:function(err){
                    var error = err.responseJSON;
                    $('.common-modal-notify-error').modal('show');
                    $('.common-modal-notify-error .modal-title').html('Failed');
                    $('.common-modal-notify-error .modal-body').html(error.message); 
                }
            })
        }

        $(document).ready(function(){
            $('.select2').select2();
            $('#accountsGLEntryDataTable').DataTable({
                searching: true,
                columnDefs: [
                        { targets: [0, 3, 4, 5, 6,11], className: 'text-center' },
                        { targets: [1, 2], className: 'text-left' }
                    ],
                    "lengthMenu": [[10, 25, 50, 75, 100, -1], [10, 25, 50, 75, 100, "All"]], 
                    "pageLength": 10 
                });
            $('th').addClass('text-center')

            
        })

        function saveAccountLevelForm(){
                if($('#saveAccountLevel').valid()){ 
                    let formElement = document.querySelector('#saveAccountLevel');
                    let formData = new FormData(formElement);
                    $.ajax({
                        url:"{{route('v1.accounts.save-accounts-general-ledger-entry')}}",
                        type:"post",
                        dataType:"json",
                        data:formData,
                        cache: false,
                        contentType: false,
                        processData: false,
                        beforeSend: function() {
                            blockUI();
                        },
                        success:function(data){
                            if(data.data.length != 0)
                                setTableData(data.data); 
                            $('#accDescription').val(null).trigger('change');
                            $('#saveAccountLevel').trigger('reset');
                            $('.common-modal-notify').modal('show');
                            $('.common-modal-notify .modal-title').html(data.title);
                            $('.common-modal-notify .modal-body').html(data.message);
                        },
                        error:function(err){
                            $.unblockUI();
                            var error = err.responseJSON;
                            $('.common-modal-notify-error').modal('show');
                            $('.common-modal-notify-error .modal-title').html('Failed');
                            $('.common-modal-notify-error .modal-body').html(error.message);
                        },
                        complete: function() {
                        $.unblockUI();
                    }
                    });
                }
            }


            
        function setTableData(data){
            $('.accounts_gl_entry_table_v1 tbody').empty();          
            var rows = [];
            var table = $('#accountsGLEntryDataTable').DataTable();
            var status = "";
            var bl_report = "";
            var cost_center_ind = "";
            var recurring_cost_ind = "";
            var control_acc_ind = "";
            var bank_ind = "";
            var cash_flow_report = "";
            var balance_sheet_ind = "";
            var dr_cr = "";
            data.forEach(function(item, index) {                
                status = item.status == 1 ? 'Active' : 'Inactive';
                cost_center_ind = item.cost_center_ind == 1 ? 'Yes' : 'No';
                recurring_cost_ind = item.recurring_cost_ind == 1 ? 'Yes' : 'No';
                control_acc_ind = item.control_acc_ind == 1 ? 'Yes' : 'No';

                if(item.mapped_report == 'INCOME'){
                    balance_sheet_ind = 'Income Statement';
                }
                else if(item.mapped_report == 'BALANCE'){
                    balance_sheet_ind = 'Balance Statement';
                }

                if(item.bank_ind == 1){
                    bank_ind = 'Bank';
                }
                else if(item.bank_ind == 2){
                    bank_ind = 'Cash';
                }
                else if(item.bank_ind == 3){
                    bank_ind = 'Others';
                }
                
                if(item.cash_flow_ind == 1){
                    cash_flow_report =  item.cashflow_report_header
                }

                var rowData = [
                    ++index,
                    '<span>'+item.account_code+' - '+item.account_name+'</span>',
                    status,
                    balance_sheet_ind,
                    item.report_header,
                    cost_center_ind,
                    recurring_cost_ind,
                    control_acc_ind,
                    bank_ind,
                    'Cash Flow Report',
                    cash_flow_report,
                    item.default_dr_cr,
                    '<a href="{{route('v1.accounts.edit-accounts-level','')}}/'+item.account_no_pk+'" rel="tab" class="btn btn-sm btn-info btn-block text-capitalize">Edit</a>'
                ];

                rows.push(rowData);
            });
            table.clear();
            table.rows.add(rows);
            table.draw();
            
        }

        function emptyTable(){
            $('.accounts_gl_entry_table_v1 tbody').empty();
            $('.accounts_gl_entry_table_v1 tbody').append(`
                <tr>
                    <td colspan="12" class="text-danger text-center">Data Not Found</td>
                </tr>
            `);

        }


</script>

