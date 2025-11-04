<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<style>
    label.custom-file-label.form-control.upload_app_label {
        line-height: 1.7;
    }
</style>
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<main id="page-content">

    <section class="hr_payroll">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="row bg-white border-bottom sticky-top shadow-sm">
                        <div class="col-md-12">
                            <h5 class="mt-2 mb-0">Loan Request</h5>
                            <small>HRM / Loan Request</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12 col-lg-12">
                    <form action="{{ route('v1.hrm.store-loan-request') }}" method="post" enctype="multipart/form-data"
                        id="hrm-loan-request">
                        @csrf
                        <input type="hidden" name="in_req_saveoption" id="in_req_saveoption">
                        <div class="card">
                            <div class="card-body border-bottom-3 p-2">
                                <div class="form-row">
                                    <div class="col-lg-2 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="load_id" class="col-form-label">Loan ID</label>
                                            <input type="text" class="form-control form-control-sm" id="load_id"
                                                name="loan_req_uid" placeholder="" value="{{ $getUid }}"
                                                readonly />

                                        </div>
                                    </div>


                                    <div class="col-lg-2 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="req_reason" class=" col-form-label">Request Reason</label>
                                            <input type="text" class="form-control form-control-sm" id="req_reason"
                                                name="req_reason" placeholder="" value="" required />

                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="expected_date" class=" col-form-label">Expected Date</label>

                                            <input type="text" class="form-control form-control-sm date_picker"
                                                id="exp_date" placeholder="dd-mm-yyyy" name="expected_date"
                                                placeholder="" value="" required />

                                        </div>
                                    </div>

                                    <div class="col-lg-2 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="loan_amt" class=" col-form-label">Loan Amount</label>

                                            <input type="text" class="form-control form-control-sm number_only"
                                                id="loan_amt" name="loan_amt" placeholder="" value="" required />

                                        </div>
                                    </div>

                                    <div class="col-lg-2 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="no_of_installment" class=" col-form-label">No of
                                                Installment</label>

                                            <input type="text" class="form-control form-control-sm number_only"
                                                id="no_of_installment" name="no_of_installment" placeholder=""
                                                onkeyup="calculateInstallmentAmount()" value="" required />

                                        </div>
                                    </div>


                                    <div class="col-lg-2 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="installment_amt" class=" col-form-label">Installment
                                                Amount</label>

                                            <input type="text" class="form-control form-control-sm number_only"
                                                id="installment_amt" name="installment_amt" placeholder=""
                                                value="" required readonly />

                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-12 col-12">
                                        <div class="form-group ">
                                            <label for="reamrks_" class=" col-form-label">Loan Req Desc.</label>

                                            <textarea class="form-control" id="loan_req_desc" name="loan_req_desc" rows="3"></textarea>

                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-12 col-12">
                                        <div class="form-group">
                                            <label for="reamrks_" class="col-form-label">Remarks</label>
                                            <textarea class="form-control" name="reamrks" rows="3"></textarea>

                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-12 col-12">
                                        <div class="form-group">
                                            <label for="upload_app" class="col-form-label">Upload
                                                Application</label>
                                            <div class="input-group mb-3">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input form-control"
                                                        name="upload_application" id="upload_app">
                                                    <label class="custom-file-label form-control upload_app_label"
                                                        for="upload_app">Upload Application</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @php
                                        $response_action = route('v1.hrm.loan-request');
                                    @endphp
                                    <div class="col-lg-6 col-md-12 col-12">
                                        <div class="form-group">
                                            <label for="" class="col-form-label"></label>
                                            <ul class="list-inline btn__box text-right">
                                                <li class="list-inline-item mb-0 mt-0">
                                                    <button type="button" class="btn btn-secondary uhl_save_btn"
                                                        onclick="setType('DRAFT');btnSaveUpdateUpload(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')"
                                                        id="">Draft</button>
                                                </li>

                                                <li class="list-inline-item"><button type="button"
                                                        onclick="setType('POST');btnSaveUpdateUpload(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')"
                                                        class="btn btn-secondary uhl_common_btn">Post</button></li>


                                            </ul>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>


            <div class="card" id="">
                <div class="card-body mt-3">
                    <div class="row">
                        <div class="col-12 table-responsive">
                            <table class="table table-striped table-bordered table-hover">
                                <thead class="global-uhl-table-bg">
                                    <tr>
                                        <th class="text-center">Loan ID</th>
                                        <th class="text-center">Request Date</th>
                                        <th class="text-center">Loan Reason</th>
                                        <th class="text-left">Loan Request Description</th>
                                        <th class="text-left">Requested Amount</th>
                                        <th class="text-left">Approved Date</th>
                                        <th class="text-left">Approved Amount</th>
                                        <th class="text-left">Number of Installment</th>
                                        <th class="text-left">Installment Amount</th>
                                        <th class="text-left">Refunded Installment</th>
                                        <th class="text-left">Refunded Amount</th>
                                        <th class="text-left">Uploaded Document</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Action</th>

                                    </tr>
                                </thead>
                                <tbody>

                                    @if (!empty($loanList))
                                        @foreach ($loanList as $loan)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td class="text-center">
                                                    {{ date('d/m/Y', strtotime($loan->au_entry_at)) }}</td>
                                                <td class="text-left">{{ $loan->req_reason }}</td>
                                                <td class="text-left">
                                                    {{ substr($loan->loan_req_desc, 0, 50) }}
                                                    {{ Str::length($loan->loan_req_desc) > 50 ? '...' : '' }}
                                                </td>
                                                <td class="text-right">{{ number_format($loan->loan_amt, 2) }}</td>
                                                <td class="text-center"></td>
                                                <td class="text-center"></td>
                                                <td class="text-right">{{ $loan->no_of_installment }}</td>
                                                <td class="text-right">{{ number_format($loan->installment_amt, 2) }}
                                                </td>
                                                <td class="text-center"></td>
                                                <td class="text-center"></td>
                                                <td class="text-center">
                                                    @if (isset($loan->upload_application))
                                                        <a href="{{ asset('uploads/hrm/' . $loan->upload_application) }}"
                                                            target="_blank">{{ $loan->upload_application }}</a>
                                                    @endif
                                                </td>
                                                <td class="text-center">{{ $loan->req_saveoption }}</td>
                                                <td class="text-center" style="width: 120px;">
                                                    {{-- @if ($loan->req_saveoption == 'POST')
                                                      <a href="#" rel="tab" class="btn btn-sm btn-info" title="Edit"><i class="fa fa-pencil-alt"></i></a>
                                                       @else
                                                          <a href="{{ route('v1.hrm.edit-loan-request', $loan->loan_req_no_pk) }}"
                                                              rel="tab" class="btn btn-sm btn-info"
                                                              title="Edit"><i class="fa fa-pencil-alt"></i></a>
                                                      @endif  --}}

                                                    {{-- <a href="#" class="btn btn-sm btn-success">Application</a> --}}


                                                    <a href="{{ route('v1.hrm.edit-loan-request', $loan->loan_req_no_pk) }}"
                                                        rel="tab" class="btn btn-sm btn-info" title="Edit"><i
                                                            class="fa fa-pencil-alt"></i></a>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>




        </div>
    </section>

</main>

<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script>
    $(".date_picker").datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        todayHighlight: true,
        clearBtn: true
    });

    function setType(value) {
        $('#in_req_saveoption').val(value);
    }

    function calculateInstallmentAmount() {
        var loan_amt = $("#loan_amt").val();
        var no_of_installment = $("#no_of_installment").val();
        if (loan_amt != '' && no_of_installment != '') {
            var installmentAmount = loan_amt / no_of_installment;
            $("#installment_amt").val(installmentAmount.toFixed(2));
        } else {
            if (loan_amt == '') {
                alert("Please Enter Loan amount and Number of Installment")
            }
        }
    }
</script>
