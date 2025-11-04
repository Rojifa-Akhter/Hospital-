<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">

<section id="full_lookup_list">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm">
            <div class="col-md-12">
                <div class="float-left">
                    <h5 class="mt-2 mb-0">Accounts Integration Payroll List</h5>
                    <small>Settings / Accounts Integration Setup / Accounts Integration List</small>
                </div>
                <div id="top-action">
                    <button class="btn btn-outline-primary btn-md bg-none float-right mt-2 ml-2 open-modal"
                        data-modal="common-modal-sm" data-action="{{ route('accounts-integration-payroll.create') }}"
                        data-title="Add New Paymood Accounts Integration">Add New Payroll Accounts Integration</button>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h5>Accounts Integration Payroll List </h5>
            </div>
            <div class="card-body">
                <div class="row mt-2">
                    <div class="col-md-12 table-responsive">
                        <table id="datatable" class="table table-bordered table-hover table-striped data-table">
                            <thead class="bg-primary">
                                <tr>
                                    <th class="text-center" scope="col">Sl#</th>
                                    <th class="text-center" scope="col">Salary BreakDown</th>
                                    <th class="text-center" scope="col">Bank Name</th>
                                    <th class="text-center" scope="col">CR Account Name (%)</th>
                                    <th class="text-center" scope="col">DR Account Name (%)</th>
                                    <th class="text-center width-150" scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (!empty($payroll_list))
                                    @foreach ($payroll_list as $pay)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $pay->payroll_breakdown_code }}</td>
                                            <td>{{ $pay->bank_name }}</td>
                                            <td>{{ @$pay->account_name_cr }} ({{ $pay->trn_cr_account_percent }} %)</td>
                                            <td>{{ @$pay->account_name_dr }}  ({{ $pay->trn_dr_account_percent }} %)</td>
                                            <td> <span Class="btn btn-sm btn-primary open-modal"
                                                    data-id="{{ $pay->integrationpayroll_no_pk }}"
                                                    data-action="{{ route('accounts-integration-payroll.edit', $pay->integrationpayroll_no_pk) }}"
                                                    data-modal="common-modal-sm" data-title="Edit Account Integration Paymood" title="Edit"><i
                                                        class="fa fa-pencil-alt"></i></span>
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
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}">
</script>
<script>
    $(document).ready(function() {
        var datatable = $('.data-table').DataTable();
    });
</script>
