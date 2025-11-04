<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">

<style>
    .card-body-compact {
        padding: 0.75rem;
    }

    .fw-bold {
        font-weight: 600;
    }

    .fw-semibold {
        font-weight: 500;
    }

    .text-end {
        text-align: right;
    }

    .text-center {
        text-align: center;
    }

    .text-danger {
        color: #dc3545;
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
    <h5 class="mb-0 fw-bold">Debit Note List</h5>
    <small class="text-muted">Accounts / Debit Note List</small>
</div>

<div class="container-fluid pb-4 pt-2">
    <div class="card">
        <div class="card-body card-body-compact border-bottom">
            <div class="card-title">
                <h6 class="mb-0 fw-bold">Filter Options</h6>
            </div>
            <div class="row mb-3">
                <div class="col-md-3">
                    <label class="form-label">Journal Date From</label>
                    <input type="date" id="journal_date_from" class="form-control">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Journal Date To</label>
                    <input type="date" id="journal_date_to" class="form-control">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Document Date From</label>
                    <input type="date" id="doc_date_from" class="form-control">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Document Date To</label>
                    <input type="date" id="doc_date_to" class="form-control">
                </div>
            </div>

            <div>
                <button id="filterBtn" class="btn btn-primary btn-md">Filter</button>
                <button id="resetBtn" class="btn btn-secondary btn-md">Reset</button>
            </div>
        </div>

        <div class="card-body card-body-compact">
            <div class="table-responsive">
                <table class="table table-bordered" id="debit-notes-table">
                    <thead class="bg-primary">
                        <tr id="table-header-row">
                            <th>#</th>
                            <th>Sub Ledger Type</th>
                            <th>Sub Ledger</th>
                            <th>Journal Code</th>
                            <th>Created At</th>                           
                            <th>Journal Date</th>
                            <th>Document Date</th>
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

        const vueInstance = document.getElementById('app').__vue__;
        if (vueInstance && vueInstance.$destroy) {
            vueInstance.$destroy();
            console.log('Vue instance destroyed successfully');
        }

        const table = $('#debit-notes-table').DataTable({
            processing: true,
            serverSide: true,

            ajax: {
                url: "{{ route('account.debit-notes.datatable') }}",
                data: function (d) {
                    d.journal_date_from = $('#journal_date_from').val();
                    d.journal_date_to   = $('#journal_date_to').val();
                    d.doc_date_from     = $('#doc_date_from').val();
                    d.doc_date_to       = $('#doc_date_to').val();
                }
            },

            columns: [
                { data: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'sub_ledger_type_name', name: 'ast.subledgertype_name', orderable: false, searchable: true },
                { data: 'sub_ledger_name', name: 'asn.subledger_name', orderable: false, searchable: true },
                { data: 'journal_code', name: 'aje.journal_code', orderable: false, searchable: true },
                { data: 'au_entry_at', name: 'aje.au_entry_at', orderable: true, searchable: false },
                { data: 'journal_date', name: 'aje.journal_date', orderable: true, searchable: false },
                { data: 'doc_date', name: 'aje.doc_date', orderable: true, searchable: false },
                { data: 'dr_account_amount', name: 'aje.dr_account_amount', orderable: false, searchable: false },
                { data: 'prepared_by', name: 'u.user_fullname', orderable: false, searchable: true },
                { data: 'action', orderable: false, searchable: false },
            ],

            columnDefs: [
                { targets: [4, 5, 6], type: 'date-eu' }
            ],

            order: [[4, 'desc']],
        });

        function todayDate() {
            let d = new Date();
            let month = (d.getMonth() + 1).toString().padStart(2, '0');
            let day   = d.getDate().toString().padStart(2, '0');
            return d.getFullYear() + '-' + month + '-' + day;
        }

        // Filter button
        $('#filterBtn').on('click', function () {
            if ($('#journal_date_from').val() && !$('#journal_date_to').val()) {
                $('#journal_date_to').val(todayDate());
            }
            if ($('#doc_date_from').val() && !$('#doc_date_to').val()) {
                $('#doc_date_to').val(todayDate());
            }
            table.draw();
        });

        // Reset button
        $('#resetBtn').on('click', function () {
            $('#journal_date_from, #journal_date_to, #doc_date_from, #doc_date_to').val('');
            table.draw();
        });

        $('#journal_date_from').on('change', function () {
            $('#journal_date_to').attr('min', $(this).val());
        });

        $('#doc_date_from').on('change', function () {
            $('#doc_date_to').attr('min', $(this).val());
        });
    })();
</script>