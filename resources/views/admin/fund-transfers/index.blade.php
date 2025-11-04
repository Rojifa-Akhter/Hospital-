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
    <h5 class="mb-0 fw-bold">Fund Transfer Manager</h5>
    <small class="text-muted">Accounts / Fund Transfer Manager</small>
</div>

<div class="container-fluid pb-4 pt-2">

    <div class="text-right">
        <a href="{{ route('account.fund-transfers.create') }}" class="btn btn-md btn-primary">Create Fund Transfer</a>
    </div>

    <div class="card mt-2">

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
                <table class="table table-bordered" id="fund-transfer-table">
                    <thead class="bg-primary text-white">
                        <tr id="table-header-row">
                            <th>#</th>
                            <th>Journal Code</th>
                            <th>Transfer Type</th>
                            <th>Amount</th>
                            <th>Journal Date</th>
                            <th>Document Date</th>
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
        const vueInstance = document.getElementById('app')?.__vue__;
        if (vueInstance && vueInstance.$destroy) {
            vueInstance.$destroy();
            console.log('Vue instance destroyed successfully');
        }

        const table = $('#fund-transfer-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('account.fund-transfers.datatable') }}",
                data: function (d) {
                    d.journal_date_from = $('#journal_date_from').val();
                    d.journal_date_to   = $('#journal_date_to').val();
                    d.doc_date_from     = $('#doc_date_from').val();
                    d.doc_date_to       = $('#doc_date_to').val();
                }
            },

            columns: [
                { data: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'journal_code', name: 'mft.voucher_code', orderable: true, searchable: true },
                { data: 'transfer_type', name: 'mft.transfer_type', orderable: true, searchable: true },
                { data: 'total_amount', name: 'mft.total_amount', orderable: true, searchable: false, className: 'text-end' },
                { data: 'journal_date', name: 'aje.journal_date', orderable: true, searchable: false },
                { data: 'doc_date', name: 'aje.doc_date', orderable: true, searchable: false },
                { data: 'prepared_by', name: 'u.user_fullname', orderable: false, searchable: true },
                { data: 'action', orderable: false, searchable: false, className: 'text-center' },
            ],

            columnDefs: [
                { targets: [4, 5], type: 'date-eu' },
            ],

            order: [[4, 'desc']],
        });

        function todayDate() {
            const d = new Date();
            const month = (d.getMonth() + 1).toString().padStart(2, '0');
            const day   = d.getDate().toString().padStart(2, '0');
            return d.getFullYear() + '-' + month + '-' + day;
        }

        $('#filterBtn').on('click', function () {
            if ($('#journal_date_from').val() && !$('#journal_date_to').val()) {
                $('#journal_date_to').val(todayDate());
            }
            if ($('#doc_date_from').val() && !$('#doc_date_to').val()) {
                $('#doc_date_to').val(todayDate());
            }
            table.draw();
        });

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