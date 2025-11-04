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
    <h5 class="mb-0 fw-bold">Bank Commission Setup</h5>
    <small class="text-muted">Setup List</small>
</div>

<div class="container-fluid pb-4 pt-2">

    <div class="card">
        {{-- <h5 class="card-header">Credit Notes Table</h5> --}}
        <div class="card-body card-body-compact">

            <div class="table-responsive">
                <table class="table table-bordered" id="setup-table">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Account Name</th>
                            <th scope="col">Commission Rates</th>
                            <th scope="col" class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($chartOfAccounts as $coa)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $coa['account_name'] }}</td>
                                <td>
                                    @if (!empty($coa['commission_rates']))
                                        <ul class="list-unstyled mb-0">
                                            @foreach ($coa['commission_rates'] as $rate)
                                                <li class="small text-muted">
                                                    <strong>{{ $rate['payment_method_name'] }}:</strong>
                                                    {{ number_format($rate['commission_rate'], 2) }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <span class="text-muted small">—</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('admin.bank-commission-setup.show', $coa['account_no_pk']) }}" class="btn btn-sm btn-outline-primary" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>

<script>
    (function () {

        const table = $('#setup-table').DataTable({
            columns: [
                { orderable: true, searchable: false },
                { orderable: false, searchable: true },
                { orderable: false, searchable: false },
                { orderable: false, searchable: false }
            ]
        });

    })();
</script>

