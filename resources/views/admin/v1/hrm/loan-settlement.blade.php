<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<style>
    label.custom-file-label.form-control.upload_app_label {
        line-height: 1.7;
    }
</style>
<main id="page-content">
    <form action="{{ route('v1.hrm.store-loan-settlement') }}" id="store-loan-settlement" method="post"
        enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="in_req_saveoption" id="in_req_saveoption">
        <input type="hidden" name="loan_req_no_fk" value="{{ $loanList->loan_req_no_pk }}">
        <input type="hidden" name="person_no_fk" value="{{ $loanList->request_by }}">
        <input type="hidden" name="loansettlement_no_pk"
            value="{{ isset($loanDtls[0]->loansettlement_no_pk) ? $loanDtls[0]->loansettlement_no_pk : '' }}">
        <section class="hr_payroll">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row bg-white border-bottom sticky-top shadow-sm">
                            <div class="col-md-12">
                                <h5 class="mt-2 mb-0">Loan Settlement (Loan Installment)</h5>
                                <small>HRM / Loan Settlement (Loan Installment)</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 col-lg-12">

                        <div class="card">
                            <div class="card-body border-bottom-3 p-2">
                                <div class="form-row">
                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="employee_id" class="col-form-label">Employee ID</label>
                                            <input type="text" value="{{ $loanList->person_code }}"
                                                class="form-control form-control-sm" id="employee_id" readonly
                                                name="employee_id" placeholder="" value="" />

                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="name_" class="col-form-label">Name</label>
                                            <input type="text" class="form-control form-control-sm" id="name_"
                                                name="name_" value="{{ $loanList->full_name }}" readonly
                                                placeholder="" value="" />

                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="designation_" class="col-form-label">Designation</label>
                                            <input type="text" class="form-control form-control-sm" id="designation_"
                                                value="{{ $loanList->designation }}" readonly name="designation"
                                                placeholder="" value="" />
                                        </div>
                                    </div>


                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="department" class="col-form-label">Department</label>

                                            <input type="text" class="form-control form-control-sm" id="department"
                                                value="{{ $loanList->su_name }}" readonly name="department"
                                                placeholder="" value="" />
                                        </div>
                                    </div>


                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="loan_id" class="col-form-label">Loan ID</label>
                                            <input type="text" class="form-control form-control-sm" id="loan_id"
                                                value="{{ $loanList->loan_req_uid }}" readonly name="loan_id"
                                                placeholder="" value="" />

                                        </div>
                                    </div>


                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="apporved_date" class="col-form-label">Approved Date</label>
                                            <input type="text" class="form-control form-control-sm date_picker"
                                                id="apporved_date" name="apporved_date" placeholder=""
                                                value="{{ date('d-m-Y') }}" />

                                        </div>
                                    </div>


                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="apporved_amt" class="col-form-label">Approved Amount</label>
                                            <input type="text" class="form-control form-control-sm "
                                                id="apporved_amt" name="apporved_amt" placeholder=""
                                                value="{{ isset($loanInfo[0]->approval_amt) ? $loanInfo[0]->approval_amt : '' }}" />

                                        </div>
                                    </div>


                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="loan_reason" class="col-form-label">Loan Reason</label>
                                            <input type="text" class="form-control form-control-sm"
                                                id="loan_reason" value="{{ $loanList->req_reason }}" readonly
                                                name="loan_reason" placeholder="" value="" />

                                        </div>
                                    </div>


                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="refund_amt" class="col-form-label">Refund Amount</label>
                                            <input type="text" class="form-control form-control-sm"
                                                id="refund_amt" name="refund_amt" placeholder=""
                                                value="{{ isset($loanInfo[0]->refund_amt) ? $loanInfo[0]->refund_amt : '' }}" />

                                        </div>
                                    </div>

                                    <div class="col-lg-2 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="no_fo_install" class="col-form-label">No of
                                                Installment</label>
                                            <input type="text" class="form-control form-control-sm"
                                                id="no_fo_install" onkeyup="calculateInstallmentAmount()"
                                                name="no_fo_install" placeholder=""
                                                value="{{ isset($loanInfo[0]->no_of_installment) ? $loanInfo[0]->no_of_installment : '' }}" />

                                        </div>
                                    </div>


                                    <div class="col-lg-2 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="deduct_salary" class="col-form-label"></label>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="customCheck1"
                                                    name="deduct_from_salary" value="1">
                                                <label class="custom-control-label col-form-label"
                                                    for="customCheck1">Deduct From Salary</label>
                                            </div>

                                        </div>
                                    </div>


                                    <div class="col-lg-2 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="install_amt" class="col-form-label">Installment Amount</label>
                                            <input type="text" class="form-control form-control-sm"
                                                id="install_amt" name="install_amt" placeholder=""
                                                value="{{ isset($loanInfo[0]->installment_amt) ? $loanInfo[0]->installment_amt : '' }}" />

                                        </div>
                                    </div>


                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="ins_start_date" class="col-form-label">Installment Start
                                                Date</label>
                                            <input type="text" class="form-control form-control-sm date_picker"
                                                id="ins_start_date" name="ins_start_date"
                                                onchange="set_nextinstallMent()" placeholder=""
                                                value="{{ date('d-m-Y') }}" />

                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-12 col-12">
                                        <div class="form-group">
                                            <label for="upload_app" class="col-form-label">Upload Approval</label>
                                            <div class="input-group mb-3">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input form-control"
                                                        name="upload_application" id="upload_app">
                                                    <label class="custom-file-label form-control upload_app_label"
                                                        for="upload_app">Upload Approval</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>

                    </div>
                </div>



                <div class="card" id="" class="">
                    <div class="card-body mt-3  d-none">
                        <div class="form-row">
                            <div class="col-lg-3 col-md-6 col-12">
                                <div class="form-group">
                                    <label for="install_num" class="col-form-label">Installment Number</label>
                                    <input type="text" class="form-control form-control-sm" id="install_num"
                                        name="install_num" placeholder="" value="" />

                                </div>
                            </div>

                            <div class="col-lg-3 col-md-6 col-12">
                                <div class="form-group">
                                    <label for="month" class="col-form-label">Month</label>
                                    <input type="text" class="form-control form-control-sm" id="month"
                                        name="month" placeholder="" value="" />

                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-12">
                                <div class="form-group">
                                    <label for="payment_amt" class="col-form-label">Payment Amt.</label>
                                    <input type="text" class="form-control form-control-sm" id="payment_amt"
                                        name="payment_amt" placeholder="" value="" />

                                </div>
                            </div>
                            <div class="col-md-1">
                                <button type="button"
                                    class="btn btn-block btn-success btn-md mt-4 btn-md-global">Add</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body mt-3">
                        <div class="row">
                            <div class="col-12 table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead class="global-uhl-table-bg">
                                        <tr>
                                            <th class="text-center" width="10%">Installment Number</th>
                                            <th class="text-center" width="25%">Month</th>
                                            <th class="text-right">Payment Amount</th>


                                        </tr>
                                    </thead>
                                    <tbody id="inner_row">
                                        @include('admin.v1.hrm.load-settlement-date-time-from-db')
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                @php
                    $response_action = route('v1.hrm.loan-list');
                @endphp

                <div class="row">
                    <div class="col-lg-12 col-md-12 col-12">
                        <div class="card">
                            <div class="card-body p-2">
                                <div class="form-group">
                                    <ul class="list-inline btn__box">
                                        <li class="list-inline-item mb-0 mt-0">
                                            <button type="button" class="btn btn-secondary uhl_save_btn"
                                                onclick="setType('POST');btnSaveUpdateUpload(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')"
                                                id=""
                                                @if (isset($loanInfo[0]->loan_saveoption) && $loanInfo[0]->loan_saveoption == 'POST') disabled @endif>Draft</button>
                                        </li>

                                        <li class="list-inline-item"><button type="button"
                                                onclick="setType('POST');btnSaveUpdateUpload(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')"
                                                class="btn btn-secondary uhl_common_btn"
                                                @if (isset($loanInfo[0]->loan_saveoption) && $loanInfo[0]->loan_saveoption == 'POST') disabled @endif>Post</button></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



            </div>
        </section>
    </form>
</main>
<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script>
    $(".date_picker").datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        todayHighlight: true,
        clearBtn: true
    });

    function calculateInstallmentAmount() {
        var loan_amt = $("#apporved_amt").val();
        var no_of_installment = $("#no_fo_install").val();
        if (loan_amt != '' && no_of_installment != '') {
            var installmentAmount = loan_amt / no_of_installment;
            $("#install_amt").val(installmentAmount.toFixed(2));
        } else {
            if (loan_amt == '') {
                alert("Please Enter Loan amount and Number of Installment")
            }
        }
    }

    function set_nextinstallMent() {
        console.log();
        $.ajax({
            url: "{{ route('v1.hrm.loan-settlement-date-time') }}",
            type: 'POST',
            data: {
                installment: $("#no_fo_install").val(),
                start_date: $("#ins_start_date").val(),
                install_amt: $("#install_amt").val(),
            },
            success: function(result) {
                $("#inner_row").html(result);
            }
        });
    }

    function setType(value) {
        $('#in_req_saveoption').val(value);
    }
</script>
