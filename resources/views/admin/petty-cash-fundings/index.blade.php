<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">

<style>
    .card-body-compact {
        padding: 0.75rem;
    }

    .fw-semibold {
        font-weight: 500;
    }

    .form-label {
        font-weight: 600;
        font-size: 0.75rem;
        color: #000;
    }

    .form-check-input {
        position: static;
        margin-top: 0;
        margin-left: 0;
    }

    .checkbox-cell {
        width: 40px;
        text-align: center;
        vertical-align: middle;
    }

    input[type="checkbox"]:disabled {
        cursor: not-allowed;
    }
</style>

<div class="bg-white border-bottom shadow-sm px-3 py-2">
    <h5 class="mb-0 font-weight-bold">Petty Cash Reimbursement</h5>
    <small class="text-muted">Accounts / Petty Cash Reimbursement</small>
</div>

<div class="container-fluid pb-4 pt-2">

    <div class="text-right">
        <a href="{{ route('petty-cash-fundings.create') }}" class="btn btn-md btn-primary">Create Reimbursement</a>
    </div>

    <div class="card mt-2">
        <div class="card-body card-body-compact border-bottom">
            <div class="card-title">
                <h6 class="mb-0 fw-bold">Filter Options</h6>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">Journal Date From</label>
                    <input type="date" id="journal_date_from" class="form-control">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Journal Date To</label>
                    <input type="date" id="journal_date_to" class="form-control">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Bank Account</label>
                    <select id="bank_account_id" class="form-control">
                        <option value="">All Bank Accounts</option>
                        @foreach ($bankAccounts as $account)
                            <option value="{{ $account->account_no_pk }}">{{ $account->account_code }} - {{ $account->account_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div>
                <button id="filterBtn" class="btn btn-primary btn-md">Filter</button>
                <button id="resetBtn" class="btn btn-secondary btn-md">Reset</button>
            </div>            
        </div>
        <div class="card-body card-body-compact">

            <div class="table-responsive">
                <table class="table table-bordered" id="petty-cash-fundings-table">
                    <thead class="bg-primary">
                        <tr id="table-header-row">
                            <th>#</th>
                            <th>Journal Code</th>
                            <th>Created At</th>
                            <th>Journal Date</th>
                            <th>Bank Account</th>
                            <th>Petty Cash Account</th>
                            <th>Amount</th>
                            <th>Prepared By</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
           
        </div>
    </div>

</div>

<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script>
    (function () {
        const table = $('#petty-cash-fundings-table').DataTable({
            processing: true,
            serverSide: true,

            ajax: {
                url: "{{ route('petty-cash-fundings.datatable') }}",
                data: function (d) {
                    d.journal_date_from = $('#journal_date_from').val();
                    d.journal_date_to   = $('#journal_date_to').val();
                    d.amount_from       = $('#amount_from').val();
                    d.amount_to         = $('#amount_to').val();
                    d.bank_account_id   = $('#bank_account_id').val();
                }
            },

            columns: [
                { data: 'DT_RowIndex', orderable: false, searchable: false }, 
                { data: 'journal_code', name: 'pcf.journal_code', orderable: false, searchable: true },
                { data: 'created_at', name: 'pcf.created_at', orderable: true, searchable: false },
                { data: 'journal_date', name: 'pcf.journal_date', orderable: true, searchable: false }, 
                { data: 'bank_account_name', name: 'bank_acct.account_name', orderable: false, searchable: true },
                { data: 'petty_account_name', name: 'petty_acct.account_name', orderable: false, searchable: true },
                { data: 'amount', name: 'pcf.amount', orderable: true, searchable: false },
                { data: 'prepared_by', name: 'u.user_fullname', orderable: false, searchable: true },
                { data: 'action', orderable: false, searchable: false },
            ],

            columnDefs: [
                { targets: [1, 2, 3], type: 'date-eu' }
            ],

            order: [[1, 'desc']],
        });

        $('#filterBtn').on('click', function () {
            if ($('#journal_date_from').val() && !$('#journal_date_to').val()) {
                $('#journal_date_to').val(new Date().toISOString().split('T')[0]);
            }

            table.draw();
        });

        $('#resetBtn').on('click', function () {
            $('#journal_date_from, #journal_date_to, #bank_account_id').val('');
            table.draw();
        });

        $('#journal_date_from').on('change', function () {
            $('#journal_date_to').attr('min', $(this).val());
        });
    })();
</script>
