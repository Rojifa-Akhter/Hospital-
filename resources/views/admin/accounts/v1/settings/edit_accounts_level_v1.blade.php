<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
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
    $data2 = collect($get_account_description->getData()->data)->sortBy('type_code')->values();
@endphp
<main id="page-content">
    <section class="fixed_asset">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="row justify-content-between align-items-center bg-white border-bottom sticky-top shadow-sm">
                        <div class="col-md-11">
                            <h5 class="mt-2 mb-0">Edit Local General Ledger</h5>
                            <small>Accounts / Edit Local General Ledger</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- form section -->
    <section class="fixed_asset">
        <div class="container-fluid">
            <form action="#" method="post" class="updateAccountLevel" id="updateAccountLevel">
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
                                                <select type="text" class="form-control form-control-sm select2" id="accDescription" name="accDescription">
                                                    <option value="" selected disabled>Select one</option>
                                                    @foreach ($data2 as $item)                                                        
                                                        <option value="{{$item->acc_5typedescription_no_pk}}"   {{$item->acc_5typedescription_no_pk == $data->acc_5typedescription_no_fk ? 'selected' : ''}}>{{$item->type_code}} - {{$item->acc_5type_description}} @if(!empty($item->acc_code_range_5_start) && ($item->acc_code_range_5_end)) ( {{$item->acc_code_range_5_start}} - {{ $item->acc_code_range_5_end}} ) @endif</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-lg-4 col-md-6 col-12">
                                        <div class="form-group form-row">
                                            <label for="" class="col-sm-4 col-form-label">GL Description<span style="color:red">*</span></label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control form-control-sm" id="accName" name="accName" placeholder="General Description" value="{{$data->account_name}}" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-6 col-12">
                                        <div class="form-group form-row">
                                            <label for="accCode" class="col-sm-4 col-form-label">GL Code</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control form-control-sm" id="accCode" name="accCode" placeholder="" value="{{$data->account_code}}" readonly/>
                                                <input type="hidden" class="form-control form-control-sm" id="account_no_pk" name="account_no_pk" placeholder="" value="{{$data->account_no_pk}}" readonly/>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-6 col-12">
                                        <div class="form-group form-row">
                                            <label for="controlAccount" class="col-sm-4 col-form-label">Control Account</label>
                                            <div class="col-sm-8">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="controlAccount" id="controlAccountYes" value="1" {{ $data->control_acc_ind == 1 ? 'checked' : ''}}/>
                                                    <label class="form-check-label" for="controlAccountYes">Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="controlAccount" id="controlAccountNo" value="0" {{ $data->control_acc_ind != 1 ? 'checked' : ''}}/>
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
                                                    <input class="form-check-input" type="radio" name="costCenter" id="costCenterYes" value="1" {{ $data->cost_center_ind == 1 ? 'checked' : ''}}/>
                                                    <label class="form-check-label" for="costCenterYes" >Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="costCenter" id="costCenterNo" value="0" {{ $data->cost_center_ind != 1 ? 'checked' : ''}}/>
                                                    <label class="form-check-label" for="costCenterNo">No</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-6 col-12">
                                        <div class="form-group form-row mt-2">
                                            <label for="bank" class="col-sm-4 col-form-label">Account Type</label>
                                            <div class="col-sm-8">
                                                <select class="form-control" name="bank" id="bank">
                                                    <option value="">Select Account Type</option>
                                                    @foreach(\App\Enums\AccountIndicator::getOptions() as $value => $label)
                                                        <option value="{{ $value }}" {{ $data->bank_ind == $value ? 'selected' : '' }}>
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
                                                    <input class="form-check-input" type="radio" name="status" id="statusYes" value="1" {{ $data->status == 1 ? 'checked' : ''}}/>
                                                    <label class="form-check-label" for="statusYes" >Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="status" id="statusNo" value="0" {{ $data->status != 1 ? 'checked' : ''}}/>
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
                                                    <input class="form-check-input" type="radio" name="recurringCost" id="recurringCostYes" value="1" {{ $data->recurring_cost_ind == 1 ? 'checked' : ''}} />
                                                    <label class="form-check-label" for="recurringCostYes" >Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="recurringCost" id="recurringCostNo" value="0" {{ $data->recurring_cost_ind != 1 ? 'checked' : ''}}/>
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
                                                    <option value="">Not set</option>
                                                    <option value="DR" {{ $data->default_dr_cr == 'DR' ? 'selected' : '' }}>DR</option>
                                                    <option value="CR" {{ $data->default_dr_cr == 'CR' ? 'selected' : '' }}>CR</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-6 col-12">
                                        <div class="form-group form-row">
                                            <label for="default_dr_cr" class="col-sm-4 col-form-label">Depreciation </label>
                                            <div class="col-sm-8">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="depreciation" id="depreciationYes" value="1" {{$data->depreciation_ind == 1 ? 'checked' : ''}}/>
                                                    <label class="form-check-label" for="depreciationYes" >Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="depreciation" id="depreciationNo" value="0" {{$data->depreciation_ind == 0 ? 'checked' : ''}}/>
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
                                                <label class="form-check-label" for="currAssetBL"> <input type="radio" class="form-check-input" id="currAssetBL" name="balanceSheetReport" value="Current AssetsBAL" {{ $data->report_header == 'Current Assets' && $data->mapped_report == 'BALANCE' ? 'checked' : ''}}/>Current Assets </label>
                                            </div>
                                            <div class="form-check">
                                                <label class="form-check-label" for="fixedAssetBL"> <input type="radio" class="form-check-input" id="fixedAssetBL" name="balanceSheetReport" value="Fixed & Long Term AssetsBAL" {{ $data->report_header == 'Fixed & Long Term Assets' && $data->mapped_report == 'BALANCE' ? 'checked' : ''}}/>Non Current Assets </label>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="balanceSheetReport" class="col-form-label">Liabilities and Shareholders Equity</label>
                                            <div class="form-check">
                                                <label class="form-check-label" for="currLiabilitiesBL"> <input type="radio" class="form-check-input" id="currLiabilitiesBL" name="balanceSheetReport" value="Current LiabilitiesBAL" {{ $data->report_header == 'Current Liabilities' && $data->mapped_report == 'BALANCE' ? 'checked' : ''}}/>Current Liabilities </label>
                                            </div>
                                            <div class="form-check">
                                                <label class="form-check-label" for="longLiabilitiesBL"> <input type="radio" class="form-check-input" id="longLiabilitiesBL" name="balanceSheetReport" value="Long Term LiabilitiesBAL" {{ $data->report_header == 'Long Term Liabilities' && $data->mapped_report == 'BALANCE' ? 'checked' : ''}}/>Non Current Liabilities </label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="balanceSheetReport" class="col-form-label">Owners Equity</label>
                                            <div class="form-check">
                                                <label class="form-check-label" for="ownersEquity"> <input type="radio" class="form-check-input" id="ownersEquity" name="balanceSheetReport" value="Owners EquityOWN" {{ $data->report_header == 'Owners Equity' && $data->mapped_report == 'OWNERS' ? 'checked' : ''}}/>Owners Equity </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="incomeStatement" class="col-form-label">Income Statement Report</label><br>
                                            <label for="incomeStatement" class="col-form-label">Income</label>
                                            <div class="form-check">
                                                <label class="form-check-label" for="revenueIS"> <input type="radio" class="form-check-input" id="revenueIS" name="balanceSheetReport" value="RevenueINC" {{ $data->report_header == 'Revenue' && $data->mapped_report == 'INCOME' ? 'checked' : ''}}/>Revenue </label>
                                            </div>                                           
                                            <div class="form-check">
                                                <label class="form-check-label" for="otherIncomeIS"> <input type="radio" class="form-check-input" id="otherIncomeIS" name="balanceSheetReport" value="Other IncomeINC" {{ $data->report_header == 'Other Income' && $data->mapped_report == 'INCOME' ? 'checked' : ''}}/>Other Income </label>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="incomeStatement" class="col-form-label">Expense</label>
  
                                            <div class="form-check">
                                                <label class="form-check-label" for="costGoodsSoldIS"> <input type="radio" class="form-check-input" id="costGoodsSoldIS" name="balanceSheetReport" value="Cost Of Goods SoldINC" {{ $data->report_header == 'Cost Of Goods Sold' && $data->mapped_report == 'INCOME' ? 'checked' : ''}}/>Cost Of Goods Sold </label>
                                            </div>
                                            <div class="form-check">
                                                <label class="form-check-label" for="operExpensIS"> <input type="radio" class="form-check-input" id="operExpensIS" name="balanceSheetReport" value="Operating ExpensesINC" {{ $data->report_header == 'Operating Expenses' && $data->mapped_report == 'INCOME' ? 'checked' : ''}}/>Operating Expenses </label>
                                            </div>
                                            <div class="form-check">
                                                <label class="form-check-label" for="nonopglIS"> <input type="radio" class="form-check-input" id="nonopglIS" name="balanceSheetReport" value="Non-Operating Gain/LosesINC" {{ $data->report_header == 'Non-Operating Gain/Loses' && $data->mapped_report == 'INCOME' ? 'checked' : ''}}/>Non-Operating Gain/Loses </label>
                                            </div>
                                            <div class="form-check">
                                                <label class="form-check-label" for="interestExpenseIS"> <input type="radio" class="form-check-input" id="interestExpenseIS" name="balanceSheetReport" value="Interest ExpenseINC" {{ $data->report_header == 'Interest Expense' && $data->mapped_report == 'INCOME' ? 'checked' : ''}}/>Interest Expense </label>
                                            </div>
                                            <div class="form-check">
                                                <label class="form-check-label" for="taxExpenseIS"> <input type="radio" class="form-check-input" id="taxExpenseIS" name="balanceSheetReport" value="Tax ExpenseINC" {{ $data->report_header == 'Tax Expense' && $data->mapped_report == 'INCOME' ? 'checked' : ''}}/>Tax Expense </label>
                                            </div>
                                            <div class="form-check">
                                                <label class="form-check-label" for="depeIS"> <input type="radio" class="form-check-input" id="depeIS" name="balanceSheetReport" value="Depreciation ExpenseINC" {{ $data->report_header == 'Depreciation Expense' && $data->mapped_report == 'INCOME' ? 'checked' : ''}}/>Depreciation Expense </label>
                                            </div>
        
                                            <div class="form-check">
                                                <label class="form-check-label" for="preferenceDIS"> <input type="radio" class="form-check-input" id="preferenceDIS" name="balanceSheetReport" value="Preference DividendINC" {{ $data->report_header == 'Preference Dividend' && $data->mapped_report == 'INCOME' ? 'checked' : ''}}/>Preference Dividend </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="cashFlow" class="col-form-label">Cash Flow Report</label>
                                            <div class="form-check">
                                                <label class="form-check-label" for="cbyCF"> <input type="radio" class="form-check-input" id="cbyCF" name="cashFlow" value="Cash at Begining of Year" {{ $data->cashflow_report_header == 'Cash at Begining of Year' && $data->cash_flow_ind == 1 ? 'checked' : ''}}/>Cash at Begining of Year </label>
                                            </div>
                                            <div class="form-check">
                                                <label class="form-check-label" for="cffaCF"> <input type="radio" class="form-check-input" id="cffaCF" name="cashFlow" value="Cash Flows From Financial Activities" {{ $data->cashflow_report_header == 'Cash Flows From Financial Activities' && $data->cash_flow_ind == 1 ? 'checked' : ''}}/>Cash Flows From Financial Activities </label>
                                            </div>
                                            <div class="form-check">
                                                <label class="form-check-label" for="cfiaCF"> <input type="radio" class="form-check-input" id="cfiaCF" name="cashFlow" value="Cash Flows From Investing Activities" {{ $data->cashflow_report_header == 'Cash Flows From Investing Activities' && $data->cash_flow_ind == 1 ? 'checked' : ''}}/>Cash Flows From Investing Activities </label>
                                            </div>
                                            <div class="form-check">
                                                <label class="form-check-label" for="cffoaCF"> <input type="radio" class="form-check-input" id="cffoaCF" name="cashFlow" value="Cash Flows From Operating Activities" {{ $data->cashflow_report_header == 'Cash Flows From Operating Activities' && $data->cash_flow_ind == 1 ? 'checked' : ''}}/>Cash Flows From Operating Activities </label>
                                            </div>
                                            <div class="form-check">
                                                <label class="form-check-label" for="currAssetCF"> <input type="radio" class="form-check-input" id="currAssetCF" name="cashFlow" value="Current Assets" {{ $data->cashflow_report_header == 'Current Assets' && $data->cash_flow_ind == 1 ? 'checked' : ''}}/>Current Assets </label>
                                            </div>
                                            <div class="form-check">
                                                <label class="form-check-label" for="currLiabilitiesCF"> <input type="radio" class="form-check-input" id="currLiabilitiesCF" name="cashFlow" value="Current Liabilities" {{ $data->cashflow_report_header == 'Current Liabilities' && $data->cash_flow_ind == 1 ? 'checked' : ''}}/>Current Liabilities </label>
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
                                            <button type="button" class="btn btn-secondary uhl_save_btn" onclick="updateAccountLevelForm()">Save</button>
                                        </li>

                                        {{-- <li class="list-inline-item"><button type="button" class="btn btn-danger">Cancel</button></li> --}}
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
    <!-- close form section -->
</main>
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script>
    $("#updateAccountLevel").validate({
    rules:{
        accName:{
            required:true,
            minlength:2,
            maxlength:200,
            notOnlySpaces: true
        },
        accDescription:{
            required:true,  
        }
    },
    messages:{
        accName:{
            required: "Please Enter GL Description",
            pattern: "only spaces is not allowed"
        },
        accDescription:{
            required:'Account Description Required',  
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
        $(document).ready(function(){
            $('.select2').select2();
            <!-- Submit Form Data -->
            
        })

       function updateAccountLevelForm(){
                if($('#updateAccountLevel').valid()){ 
                    let formElement = document.querySelector('#updateAccountLevel');
                    let formData = new FormData(formElement);
                    $.ajax({
                        url:"{{route('v1.update-accounts-level')}}",
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
</script>

