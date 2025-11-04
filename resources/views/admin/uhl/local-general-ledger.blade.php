<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
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

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-row">
                                <div class="col-lg-4 col-md-6 col-12">
                                    <div class="form-group form-row">
                                        <label for="gl-descreiption" class="col-sm-4 col-form-label">GL Description</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm" id="gl-descreiption" name="gl-descreiption" placeholder="" value="" />
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-4 col-md-6 col-12">
                                    <div class="form-group form-row">
                                        <label for="gl-code" class="col-sm-4 col-form-label">GL Code</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm" id="gl-code" name="gl-code" placeholder="" value="" />
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-4 col-md-6 col-12">
                                    <div class="form-group form-row">
                                        <label for="gl-code" class="col-sm-5 col-form-label">Control Account</label>
                                        <div class="col-sm-7">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1" />
                                                <label class="form-check-label" for="inlineRadio1">Yes</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2" />
                                                <label class="form-check-label" for="inlineRadio2">No</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3 col-md-6 col-12">
                                    <div class="form-group form-row mt-2">
                                        <label for="" class="col-sm-5 col-form-label">Cost Center</label>
                                        <div class="col-sm-7">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="costCenter" id="inlineRadio3" value="option3" />
                                                <label class="form-check-label" for="inlineRadio3">Yes</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="costCenter" id="inlineRadio4" value="option4" />
                                                <label class="form-check-label" for="inlineRadio4">No</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-6 col-12">
                                    <div class="form-group form-row mt-2">
                                        <label for="" class="col-sm-3 col-form-label">Bank</label>
                                        <div class="col-sm-9">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="bank" id="inlineRadio5" value="option5" />
                                                <label class="form-check-label" for="inlineRadio5">Bank</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="bank" id="inlineRadio6" value="option6" />
                                                <label class="form-check-label" for="inlineRadio6">Cash</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="bank" id="inlineRadio7" value="option7" />
                                                <label class="form-check-label" for="inlineRadio7">Other</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3 col-md-6 col-12">
                                    <div class="form-group form-row mt-2">
                                        <label for="" class="col-sm-4 col-form-label">Status</label>
                                        <div class="col-sm-8">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="status" id="inlineRadio8" value="option8" />
                                                <label class="form-check-label" for="inlineRadio8">Active</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="status" id="inlineRadio9" value="option9" />
                                                <label class="form-check-label" for="inlineRadio9">Inactive</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-4 col-md-6 col-12">
                                    <div class="form-group form-row mt-2">
                                        <label for="" class="col-sm-4 col-form-label">Recurring Cost</label>
                                        <div class="col-sm-8">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="status" id="inlineRadio10" value="option10" />
                                                <label class="form-check-label" for="inlineRadio10">Yes</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="status" id="inlineRadio11" value="option11" />
                                                <label class="form-check-label" for="inlineRadio11">No</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h5>Mapped TO</h5>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-4 col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="major_group" class="col-form-label">Balance Sheet Report Asset</label>
                                        <div class="form-check">
                                            <label class="form-check-label" for="radio1"> <input type="radio" class="form-check-input" id="radio1" name="balanceSheetReportAsset" value="option12" />Current Assets </label>
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label" for="radio2"> <input type="radio" class="form-check-input" id="radio2" name="balanceSheetReportAsset" value="option13" />Fixed & Long Term Assets </label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="major_group" class="col-form-label">Liabilities and Shareholders Equity</label>
                                        <div class="form-check">
                                            <label class="form-check-label" for="radio18"> <input type="radio" class="form-check-input" id="radio18" name="liaShareholders" value="option29" />Current Liabilities </label>
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label" for="radio19"> <input type="radio" class="form-check-input" id="radio19" name="liaShareholders" value="option30" />Long Term Liabilities </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-4 col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="major_group" class="col-form-label">Income Statement Report</label>
                                        <div class="form-check">
                                            <label class="form-check-label" for="radio3"> <input type="radio" class="form-check-input" id="radio3" name="incomeStatement" value="option14" />Revenue </label>
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label" for="radio4"> <input type="radio" class="form-check-input" id="radio4" name="incomeStatement" value="option15" />Cost Of Goods Sold </label>
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label" for="radio5"> <input type="radio" class="form-check-input" id="radio5" name="incomeStatement" value="option16" />Operating Expenses </label>
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label" for="radio6"> <input type="radio" class="form-check-input" id="radio6" name="incomeStatement" value="option17" />Non-Operating Gain/Loses </label>
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label" for="radio7"> <input type="radio" class="form-check-input" id="radio7" name="incomeStatement" value="option18" />Interest Expense </label>
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label" for="radio8"> <input type="radio" class="form-check-input" id="radio8" name="incomeStatement" value="option19" />Tax Expense </label>
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label" for="radio9"> <input type="radio" class="form-check-input" id="radio9" name="incomeStatement" value="option20" />Depreciation Expense </label>
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label" for="radio10"> <input type="radio" class="form-check-input" id="radio10" name="incomeStatement" value="option21" />Other Income </label>
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label" for="radio11"> <input type="radio" class="form-check-input" id="radio11" name="incomeStatement" value="option22" />Preference Dividend </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="major_group" class="col-form-label">Cash Flow Report</label>
                                        <div class="form-check">
                                            <label class="form-check-label" for="radio12"> <input type="radio" class="form-check-input" id="radio12" name="cashFlow" value="option23" />Cash at Begining of Year </label>
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label" for="radio13"> <input type="radio" class="form-check-input" id="radio13" name="cashFlow" value="option24" />Cash Flows From Financial Activities </label>
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label" for="radio14"> <input type="radio" class="form-check-input" id="radio14" name="cashFlow" value="option25" />Cash Flows From Investing Activities </label>
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label" for="radio15"> <input type="radio" class="form-check-input" id="radio15" name="cashFlow" value="option26" />Cash Flows From Operating Activities </label>
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label" for="radio16"> <input type="radio" class="form-check-input" id="radio16" name="cashFlow" value="option27" />Current Assets </label>
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label" for="radio17"> <input type="radio" class="form-check-input" id="radio17" name="cashFlow" value="option28" />Current Liabilities </label>
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
                                        <button type="button" class="btn btn-secondary uhl_save_btn" id="">Save</button>
                                    </li>

                                    <li class="list-inline-item"><button type="button" class="btn btn-danger">Cancel</button></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<script>
    $("body").addClass("sidebar-collapse");
</script>
