<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />

<section id="full_appointment">
    <div class="container-fluid pb-4">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-10 mb-1">
                <h5 class="mt-2 mb-0">Accounts Payment</h5>
                <small>Billing / Accounts Payment</small>
            </div>
            @php
                $invoice_ref_edit_ind = Session::get('user.ses_invoice_ref_edit_ind');
                $hospital_code = Session::get('user.ses_hospital_code');
            @endphp
        </div>
        <input type="hidden" name="invoice_ref_edit_ind" id="invoice_ref_edit_ind" value="{{ $invoice_ref_edit_ind }}">

        <input type="hidden" name="hospital_code" id="hospital_code"
            value="{{ Session::get('user.ses_hospital_code') }}">

        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-file-invoice"></i> Payment Voucher</h5>
            </div>
            <div class="card-body pt-2">
                <form id="frmSearch" method="post" action="{{ route('appointments.appointments_list_print') }}">
                    @csrf

                    <input type="hidden" id="page-view-type" name="page_view_type">

                    <div class="form-group form-row">
                        <div class="col-sm-4">
                            <label for="sub_ledger_type ">Sub Ledger Type <span class="text-danger">*</span></label>
                            <select class="form-control select2" id="sub_ledger_type" name="sub_ledger_type" required>
                                <option value="">Select Sub Ledger Type</option>
                                @if (isset($subLedgers))
                                    @foreach ($subLedgers as $subLedger)
                                        <option value="{{ $subLedger->acct_subledger_typeno_pk }}"
                                            data-code="{{ $subLedger->subledgertype_code }}"
                                            data-debit-account-no="{{ $subLedger->dr_account_no_fk }}"
                                            data-credit-account-no="{{ $subLedger->cr_account_no_fk }}"
                                            data-debit-account-code="{{ $subLedger->dr_account_code }}"
                                            data-credit-account-code="{{ $subLedger->cr_account_code }}">
                                            {{ $subLedger->subledgertype_code }} -
                                            {{ $subLedger->subledgertype_name }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <div class="col-sm-4">
                            <label for="subLedger ">Sub Ledger <span class="text-danger">*</span></label>
                            <select class="form-control select2" id="subLedger" name="sub_ledger" required>
                                <option value="">Select Sub Ledger</option>
                                <!-- Populated dynamically -->
                            </select>
                        </div>

                        <div class="col-sm-4">
                            <label for="payment_date">Payment Date</label>
                            <input type="text" class="form-control payment_date" name="payment_date"
                                value="{{ date('d-m-Y') }}" id="payment_date" placeholder="From Date"
                                autocomplete="off" />
                        </div>

                        <div class="col-sm-4">
                            <label for="type">Type <span class="text-danger">*</span></label>
                            <select class="form-control select2" id="type" name="type" required>
                                <option value="">Select Type</option>
                                <option value="1">Bank</option>
                                <option value="4">Cash</option>
                            </select>
                        </div>

                        <div class="col-sm-4">
                            <label for="account_number">Account Name <span class="text-danger">*</span></label>
                            <select class="form-control select2" id="account_number" name="account_number" required>
                                <option value="">Select Account Name</option>
                            </select>
                        </div>

                        <div class="col-sm-4" id="pay_type_container" style="display: none;">
                            <label for="pay_type">Pay Type <span class="text-danger">*</span></label>
                            <select class="form-control select2" id="pay_type" name="pay_type" required>
                                <option value="">Select Pay Type</option>
                                <option value="cheque">Cheque</option>
                                <option value="ft">FT</option>
                            </select>
                        </div>

                        <div class="col-sm-4" id="cheque_fields_container" style="display: none;">
                            <label for="cheque_date">Cheque Date <span class="text-danger">*</span></label>
                            <input type="text" class="form-control date_picker" id="cheque_date" name="cheque_date"
                                placeholder="Cheque Date" autocomplete="off" />
                        </div>

                        <div class="col-sm-4" id="cheque_number_container" style="display: none;">
                            <label for="cheque_number">Cheque Number <span class="text-danger">*</span></label>
                            <select class="form-control select2" id="cheque_number" name="cheque_number" required>
                                <option value="">Select Cheque Number</option>
                            </select>
                        </div>

                        <div class="col-sm-4" id="transaction_no_container" style="display: none;">
                            <label for="transaction_no">Transaction No <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="transaction_no" name="transaction_no"
                                placeholder="Transaction No" autocomplete="off" />
                        </div>

                        <div class="col-sm-12">
                            <label for="remarks" class="col-form-label s-12">Remarks/Purpose <span
                                    class="text-danger">*</span></label>
                            <textarea class="form-control" id="remarks" name="remarks" rows="3" maxlength="58" required></textarea>
                        </div>

                        <div class="col-sm-4 mt-4">
                            <button type="reset" class="btn btn-info btn-md btn-md-global" id="btnReset"
                                onclick="window.location.reload();">
                                <i class="fa fa-redo"></i>
                                Reset
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="tab-content mt-0 mb-0 pt-0 pb-0" id="myTabContent">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <h5 class="mt-2 mb-0">Payment Details</h5>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="dataTable"
                            class="table table-bordered table-hover table-striped bill-list-opd w-100">
                            <thead class="global-uhl-table-bg">
                                <tr>
                                    <th>SL</th>
                                    <th>Journal Code</th>
                                    <th>Document Date</th>
                                    <th>Account Name</th>
                                    <th>DR Amount</th>
                                    <th>CR Amount</th>
                                    <th>Remarks</th>
                                </tr>
                            </thead>
                            <tbody id="paymentTableBody">
                                <tr>
                                    <td colspan="7" class="text-center text-muted">No data available</td>
                                </tr>
                            </tbody>

                            <tfoot>
                                <tr>
                                    <th colspan="5" class="text-right">Payment Value</th>
                                    <th colspan="2" id="paymentValue">0.00</th>
                                </tr>
                                <tr>
                                    <td colspan="7" class="text-right">
                                        <button type="button" id="btnSubmitPayment" class="btn btn-success">
                                            <i class="fa fa-save"></i> Submit
                                        </button>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script src="//cdn.datatables.net/plug-ins/1.10.11/sorting/date-eu.js" type="text/javascript"></script>
<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
@php
    $p_route = isset($row->patient_no_pk) ? route('patient-card', $row->patient_no_pk) : '#';
@endphp

<script>
    openInvoiceAutocomplete("#app_date");

    $(function() {
        $('.date_picker').datepicker({
            todayHighlight: true,
            clearBtn: true,
            autoclose: true,
            format: 'dd-mm-yyyy'
        });

        $('.payment_date').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true,
            clearBtn: true,
            endDate: '0d'
        });

    });

    $('.date_picker').datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        todayHighlight: true,
        clearBtn: true,
    });

    $('.payment_date').datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        todayHighlight: true,
        clearBtn: true,
        endDate: '0d'
    });

    $('.select2').select2();
    openPatientAutocomplete('#patient_id');
    openDoctorAutocomplete('#doctor_code', 'hdn_doctor_id');

    var date = new Date();
    var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());

    function numberWithCommas(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    var edit_ind = "";

    $(document).ready(function() {
        const accountsData = JSON.parse('@json($accounts)');
        const typeSelect = $('#type');
        const accountSelect = $('#account_number');

        typeSelect.on('change', function() {
            const typeValue = $(this).val();
            populateAccounts(typeValue);
            accountSelect.val('').trigger('change');
        });

        function populateAccounts(type) {
            accountSelect.empty().append('<option value="">Select Account Name</option>');

            if (type === '') {
                return;
            }

            const filteredAccounts = accountsData.filter(account => account.bank_ind.toString() === type);

            accountSelect.append(
                filteredAccounts.map(account =>
                    `<option value="${account.account_no_pk}">${account.account_code} – ${account.account_name}</option>`
                ).join('')
            );
        }

        typeSelect.trigger('change');

        const chequeFieldsContainer = $('#cheque_fields_container');
        const chequeNumberContainer = $('#cheque_number_container');
        const transactionNoContainer = $('#transaction_no_container');
        const payTypeContainer = $('#pay_type_container');

        typeSelect.on('change', function() {
            const typeValue = $(this).val();

            // Populate Account Name dropdown
            populateAccounts(typeValue);
            accountSelect.val('').trigger('change');

            // Show/hide cheque fields
            if (typeValue === '1') { // Bank
                payTypeContainer.show();
            } else { // Cash or empty
                payTypeContainer.hide();

                transactionNoContainer.hide();
                chequeFieldsContainer.hide();
                chequeNumberContainer.hide();

                $('#cheque_number').val('').trigger('change');
                $('#pay_type').val('').trigger('change');
            }
        });

        const payTypeSelect = $('#pay_type');

        payTypeSelect.on('change', function() {
            const payTypeValue = $(this).val();

            if (payTypeValue === 'cheque') {
                chequeFieldsContainer.show();
                chequeNumberContainer.show();
                transactionNoContainer.hide();

                $('.cheque_date').datepicker({
                    format: 'dd-mm-yyyy',
                    autoclose: true,
                    todayHighlight: true,
                    clearBtn: true,
                });

                $('#transaction_no').val('');
            } else if (payTypeValue === 'ft') {
                chequeFieldsContainer.hide();
                chequeNumberContainer.hide();
                transactionNoContainer.show();

                // Optional: clear values
                $('#cheque_date').val('');
                $('#cheque_number').val('').trigger('change');
            }
        });

    });

    $('#sub_ledger_type').on('change select2:clear', function() {
        const subLedgerType = $(this);
        const selectedOption = subLedgerType.find('option:selected');
        const typePk = subLedgerType.val();

        const subLedger = $('#subLedger');
        subLedger.find('option:not([value=""])').remove();
        subLedger.val('').trigger('change');

        $('#dr-account-no').val('');
        $('#dr-account-code').val('');

        if (!typePk) {
            return;
        }

        const drAccountNo = selectedOption.data('debit-account-no');
        const drAccountCode = selectedOption.data('debit-account-code');
        if (!drAccountNo) {
            subLedgerType.val('').trigger('change');
            alert('The selected Sub Ledger Type has no Debit Account assigned. Please contact admin.');
            return;
        }

        // $('#dr-account-no').val(drAccountNo);
        // $('#dr-account-code').val(drAccountCode);

        $.ajax({
            url: '{{ route('accounts.get-sub-ledgers-by-type') }}',
            type: 'POST',
            data: {
                sub_ledger_type_pk: typePk
            },
            dataType: 'json',
            beforeSend: function() {
                blockUI();
            },
            success: function(response) {
                console.log('Sub Ledgers response:', response);
                if (response.data?.length > 0) {
                    response.data.forEach(item => {
                        subLedger.append(
                            $('<option>', {
                                value: item.acct_subledger_no_pk,
                                text: item.subledger_code + ' - ' + item
                                    .subledger_name,
                                'data-doctor-name': item.subledger_name
                            })
                        );
                    });

                    subLedger.val('').trigger('change');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error fetching sub ledgers:', error);
            },
            complete: function() {
                $.unblockUI();
            }
        });
    });

    $('#subLedger').on('change', function() {
        const tableBody = $('#paymentTableBody');
        const pymntVal = $('#paymentValue');
        let subLedgerId = $(this).val();

        if (!subLedgerId) {
            tableBody.html('<tr><td colspan="6" class="text-center text-muted">No data available</td></tr>');
            return;
        }

        $.ajax({
            url: "{{ route('doctor.payment.details') }}",
            type: 'POST',
            data: {
                sub_ledger_no: subLedgerId,
                _token: '{{ csrf_token() }}'
            },
            beforeSend: function() {
                blockUI();
            },
            success: function(response) {
                console.log(response);
                if (response.success && response.data.length > 0) {
                    let rows = '';
                    let totalCr = 0;
                    let totalDr = 0;

                    window.paymentDetails = response.data.map((item, i) => ({
                        ...item,
                        remarks: ''
                    }));

                    response.data.forEach((item, index) => {
                        totalCr += parseFloat(item.cr_amt) || 0;
                        totalDr += parseFloat(item.dr_amt) || 0;

                        rows += `
                            <tr>
                                <td>${index + 1}</td>
                                <td>${item.voucher_no ?? ''}</td>
                                <td>${(new Date(item.journal_date)).getDate()}/${(new Date(item.journal_date)).getMonth() + 1}/${(new Date(item.journal_date)).getFullYear()}</td>
                                <td>${item.account_name ?? ''}</td>
                                <td>${parseFloat(item.dr_amt ?? 0).toFixed(2)}</td>
                                <td>${parseFloat(item.cr_amt ?? 0).toFixed(2)}</td>
                                <td><input type="text" class="form-control form-control-sm remark-input" data-i="${index}" placeholder="Enter Remarks"/></td>
                            </tr>`;
                    });

                    const paymentValue = totalDr - totalCr;

                    tableBody.html(rows);
                    pymntVal.text(paymentValue.toFixed(2));

                    $(document).on('input', '.remark-input', e => {
                        window.paymentDetails[$(e.target).data('i')].remarks = e.target
                            .value;
                    });
                } else {
                    tableBody.html(
                        '<tr><td colspan="7" class="text-center text-muted">No data found</td></tr>'
                    );
                    pymntVal.text('0.00');
                }
            },
            error: function(xhr, status, error) {
                console.error(error);
                tableBody.html(
                    '<tr><td colspan="7" class="text-center text-danger">Error loading data</td></tr>'
                );
                pymntVal.text('0.00');
            },
            complete: function() {
                $.unblockUI();
            }
        });
    });

    $(document).on('change', '#account_number', function() {
        const bankPk = $(this).find('option:selected').val();
        const chequeDropdown = $('#cheque_number');

        chequeDropdown.find('option:not([value=""])').remove();

        if (bankPk) {
            $.ajax({
                url: '{{ route('cheque-printing.get-cheques') }}',
                type: 'GET',
                headers: {
                    'Accept': 'application/json'
                },
                data: {
                    bank_pk: bankPk
                },
                beforeSend: function() {
                    blockUI();
                },
                success: function(response) {
                    if (response.data && response.data.cheques.length > 0) {
                        // console.log(response.data.cheques);
                        response.data.cheques.forEach(function(cheque) {
                            const option = $('<option>', {
                                value: cheque.cheque_number,
                                text: cheque.cheque_number
                            });
                            option.attr('data-verified-pk', cheque.cheque_verified_pk);
                            option.attr('data-detail-pk', cheque.cheque_detail_pk);
                            chequeDropdown.append(option);
                        });
                    }
                    //  else {
                    //     alert('No cheques found for the selected bank');
                    // }
                },
                error: function(xhr) {
                    console.error(xhr);
                    alert('Error fetching cheques. Please try again later.');
                },
                complete: function() {
                    $.unblockUI();
                }
            });
        }
    });

    $('#btnSubmitPayment').on('click', function() {
        const subLedgerId = $('#subLedger').val();
        const paymentValue = $('#paymentValue').text();
        const paymentDate = $('#payment_date').val();
        const type = $('#type').val();
        const accountNumber = $('#account_number').val();
        const chequeDate = $('#cheque_date').val();
        const chequeNumber = $('#cheque_number').val();
        const chequeDetailPk = $('#cheque_number').find('option:selected').data('detail-pk');
        const remarks = $('#remarks').val();
        const payType = $('#pay_type').val();
        const transactionNo = $('#transaction_no').val();

        const doctorName = $('#subLedger').find('option:selected').data('doctor-name');

        if (!subLedgerId) {
            alert('Please select a Sub Ledger before submitting.');
            return;
        }

        if (!type) {
            alert('Please select Type.');
            return;
        }

        if (!accountNumber) {
            alert('Please select Account Name.');
            return;
        }

        if (type === '1') { // Bank
            if (payType === 'cheque') {
                if (!chequeDate) {
                    alert('Please select Cheque Date.');
                    return;
                }
                if (!chequeNumber) {
                    alert('Please enter Cheque Number.');
                    return;
                }
            } else if (payType === 'ft') {
                if (!transactionNo) {
                    alert('Please enter Transaction No.');
                    return;
                }
            } else {
                alert('Please select Pay Type.');
                return;
            }
        }

        if (paymentValue <= 0) {
            alert('Payment Value must be greater than zero.');
            return;
        }

        if (!paymentDate) {
            alert('Please select Payment Date.');
            return;
        }

        if (!remarks) {
            alert('Please enter remarks.');
            return;
        }

        if (!confirm('Are you sure you want to submit this payment?')) {
            return;
        }

        const details = window.paymentDetails || [];

        $.ajax({
            url: "{{ route('accounts.submit-payment') }}",
            type: 'POST',
            data: {
                sub_ledger_no: subLedgerId,
                payment_value: paymentValue,
                payment_date: paymentDate,
                type: type,
                pay_type: payType,
                account_number: accountNumber,
                cheque_date: chequeDate,
                cheque_number: chequeNumber,
                cheque_detail_pk: chequeDetailPk,
                transaction_no: transactionNo,
                doctor_name: doctorName,
                remarks: remarks,
                payment_details: details,
                _token: '{{ csrf_token() }}'
            },
            beforeSend: function() {
                blockUI();
            },
            success: function(response) {
                $('.common-modal-notify').modal('show');
                $('.common-modal-notify .modal-title').html('Success!!');
                $('.common-modal-notify .modal-body').html(response.message);

                let doctorpaymstId = response.finc_doctorpaymst_id;
                window.open("/accounts/payment/" + doctorpaymstId + "/voucher", "_blank");

                window.location.reload();
            },
            error: function(xhr) {
                let error = xhr.responseJSON;
                $('.common-modal-notify-error').modal('show');
                $('.common-modal-notify-error .modal-title').html('Failed');
                $('.common-modal-notify-error .modal-body').html(error.message);
            },
            complete: function() {
                $.unblockUI();
            }
        });
    });
</script>
