<style>
    label.custom-file-label.form-control.upload_app_label {
        line-height: 1.7;
    }
</style>
@php
    $exp_data = isset($data) && !empty($data) ? $data : [];
    $hdn_expense_no_pk = $exp_data ? $exp_data->expense_no_pk : '';
    $expense_to        = $exp_data ? $exp_data->expense_to : '';
    $expense_date      = !empty($exp_data->expense_date) ? date('d-m-Y', strtotime($exp_data->expense_date)) : '';
    $expense_name      = $exp_data ? $exp_data->expense_name : '';
    $amount            = $exp_data ? $exp_data->amount : '';
    $change_to         = $exp_data ? $exp_data->charge_to : '';
@endphp
<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<main id="page-content">
    <form action="{{ route('expense_memo_save') }}" id="ExpenseMemoSave" method="post">
        @csrf
        <section class="hr_payroll">
            <div class="container-fluid">
                <div class="row bg-white border-bottom sticky-top shadow-sm">
                    <div class="col-md-12">
                        <h5 class="mt-2 mb-0">Expense</h5>
                        <small>Expense / Expense Memo</small>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-row">
                                    <input type="hidden" name="hdn_expense_no_pk" id="hdn_expense_no_pk" value="{{ $hdn_expense_no_pk }}">
                                    <div class="col-md-3"></div>
                                    <div class="col-md-3">
                                        <label for="expense_to" class="col-form-label">To Mr./Mrs</label> <br>
                                        <input type="text" class="form-control" id="expense_to" name="expense_to"
                                            placeholder="" value="{{ $expense_to }}" autocomplete="off"/>
                                    </div>

                                    <div class="col-md-3">
                                        <label for="expense_date" class="col-form-label">Date<span
                                                style="color: red;">*</span></label>
                                        <input type="text" class="form-control form-control-sm date_picker"
                                            id="expense_date" name="expense_date"
                                            placeholder="" value="{{ $expense_date }}" required autocomplete="off"/>
                                    </div>

                                    <div class="col-md-3"></div>
                                </div>

                                <div class="form-row" style="border: 1px solid black; margin-top:20px;">
                                    <div class="col-md-8">
                                        <label for="expense_name" class="col-form-label">For<span
                                                style="color: red;">*</span></label>
                                        {{-- <input type="text" class="form-control form-control-sm"
                                            id="expense_name" name="expense_name" placeholder=""
                                            value="" required /> --}}
                                        <textarea name="expense_name" class="form-control form-control-sm" id="expense_name" cols="50" rows="2">{{ $expense_name }}</textarea>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="amount" class="col-form-label">Amount</label>
                                        <input type="text" class="form-control form-control-sm" id="amount"
                                            name="amount" placeholder="" value="{{ $amount }}" required autocomplete="off"/>
                                    </div>

                                    <div class="col-md-8">
                                      
                                    </div>

                                    <div class="col-md-4">
                                        <label for="total_amount" class="col-form-label">Total Amount</label>
                                        <input type="text" class="form-control form-control-sm" id="total_amount"
                                            name="total_amount" placeholder="" value="" autocomplete="off"/>
                                    </div>
                                    <div class="col-md-8">
                                      
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="change_to" class="col-form-label">Charge To</label>
                                        <input type="text" class="form-control form-control-sm" id="change_to"
                                            name="change_to" placeholder="" value="{{ $change_to }}" autocomplete="off"/>
                                    </div>

                                </div>
                            </div>

                            @php
                                $response_action = route('expense_memo_worklist');
                            @endphp
                            <div class="card-body p-2">
                                <div class="form-group">
                                    <ul class="list-inline btn__box">
                                        <li class="list-inline-item mb-0 mt-0">
                                            <button type="button" class="btn btn-secondary uhl_save_btn"
                                                onclick="btnSaveUpdateUpload(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')"
                                                id="">Save</button>
                                        </li>

                                        <li class="list-inline-item"><button type="button"
                                                class="btn btn-danger">Cancel</button></li>
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

<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2();
        $(".date_picker").datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true,
            clearBtn: true
        });

    });
</script>
