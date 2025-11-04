<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.min.css') }}" rel="stylesheet">

<section id="full_lookup_list">
    <div class="container-fluid">
        <!-- Header Section -->
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-12 mb-1">
                <h5 class="mt-2 mb-0">Sales Team Target List</h5>
                <small>Settings / Sales Team / Sales Team Target List</small>
            </div>
        </div>

        <!-- Main Card -->
        <div class="card mt-3 shadow-sm border-0">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Sales Team Target List</h5>
                <button class="btn btn-sm btn-primary open-modal" data-modal="common-modal-md"
                    data-action="{{ route('create-marketing-target-setup') }}" data-title="Create Sales Team">
                    <i class="fa fa-plus mr-1"></i> Create Sales Target
                </button>
            </div>

            <!-- Search Filters -->
            <div class="card-body pb-0">
                <div class="row justify-content-center mb-3">
                    <div class="col-md-10">
                        <div class="card shadow-sm border">
                            <div class="card-header bg-light">
                                <h6 class="mb-0"><i class="fa fa-search"></i> Filter by Employee & Date</h6>
                            </div>
                            <div class="card-body mt-2">
                                <div class="row">
                                    <div class="col-md-6 mb-2">
                                        <input type="text" id="searchEmployee" class="form-control"
                                            placeholder="Search by Employee Name">
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <input type="month" id="searchMonth" class="form-control"
                                            placeholder="Search by Year/Month">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Search -->

            <!-- Table Section -->
            <div class="card-body pt-0">
                <div class="table-responsive">
                    <table id="datatable" class="table table-bordered table-hover table-striped data-table">
                        <thead class="bg-primary text-white text-center">
                            <tr>
                                <th scope="col">Sl#</th>
                                <th scope="col">Team Name</th>
                                <th scope="col">Employee Name</th>
                                <th scope="col">Year/Month</th>
                                <th scope="col">Total Patient</th>
                                <th scope="col">Total Sales</th>
                                <th scope="col">IPD Patient</th>
                                <th scope="col">IPD Sales</th>
                                <th scope="col">OPD Patient</th>
                                <th scope="col">OPD Sales</th>
                                <th class="text-center" scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($salesTeams as $index => $team)
                                <tr>
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td>{{ $team->team_name }}</td>
                                    <td>{{ $team->full_name }}</td>
                                    <td class="text-center">{{ $team->target_year . '/' . $team->target_month }}</td>
                                    <td class="text-center">
                                        {{ $team->achieved_opd_ptn_qty + $team->achieved_ipd_ptn_qty }}
                                    </td>
                                    <td class="text-center">{{ $team->target_amnt }}</td>
                                    <td class="text-center">{{ $team->achieved_ipd_ptn_qty }}</td>
                                    <td class="text-center">{{ $team->achieved_ipd_target_amnt }}</td>
                                    <td class="text-center">{{ $team->achieved_opd_ptn_qty }}</td>
                                    <td class="text-center">{{ $team->achieved_opd_target_amnt }}</td>
                                    <!-- Inside <tbody>, after last <td> of each row -->
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-warning open-modal" data-modal="common-modal-md"
                                            data-action="{{ route('edit-marketing-target-setup', $team->achivement_no_pk) }}"
                                            data-title="Edit Sales Target">
                                            <i class="fa fa-edit"></i> Edit
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- End Table -->
        </div>
    </div>
</section>

<!-- Scripts -->
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script>
    $(document).ready(function() {
        var table = $('#datatable').DataTable({
            responsive: true,
            pageLength: 10,
            ordering: true,
            searching: true,
            autoWidth: false,
        });

        // Employee Name Filter
        $('#searchEmployee').on('keyup', function() {
            table.column(2).search(this.value).draw(); // Column 2 = Employee Name
        });

        // Year/Month Filter
        $('#searchMonth').on('change', function() {
            const val = this.value.replace('-', '/'); // Convert YYYY-MM to YYYY/MM
            table.column(3).search(val).draw(); // Column 3 = Year/Month
        });
    });
</script>
