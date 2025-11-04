<!-- CSS Links -->
<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
<link href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<style>
    body {
        background-color: #f0f8ff;
    }

    h4 {
        border-radius: 5px;
    }

    .card {
        border: 2px solid #007bff;
        border-radius: 15px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
    }

    .status-completed {
        background-color: #ffcccc !important;
    }

    .status-start {
        background-color: #ccffcc !important;
    }

    .status-received {
        background-color: #cce5ff !important;
    }

    .btn-group-status button {
        margin-right: 5px;
    }

    .table thead {
        background: linear-gradient(to right, #4e73df, #1cc88a);
        color: white;
    }

    .form-label {
        font-weight: bold;
    }

    .form-row .col {
        margin-bottom: 10px;
    }
</style>

<div class="container-fluid mt-3">
    <h4 class="text-center bg-gradient p-3 text-white" style="background: linear-gradient(90deg, #36d1dc, #5b86e5);">
        Investigation Appointment List
    </h4>

    <div class="card mb-3">
        <div class="card-header bg-info text-white font-weight-bold">Search Filters</div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="card p-2 mb-2">
                        <label class="form-label">Patient Name</label>
                        <input type="text" class="form-control mb-2" placeholder="Enter patient name">

                        <label class="form-label">Investigation Type</label>
                        <select class="form-control">
                            <option>All</option>
                            <option>Ultrasonography</option>
                            <option>X-Ray</option>
                            <option>MRI</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card p-2 mb-2">
                        <label class="form-label">Machine</label>
                        <select class="form-control mb-2">
                            <option>All</option>
                            <option>USG-1</option>
                            <option>USG-2</option>
                            <option>USG-5</option>
                        </select>

                        <label class="form-label">Status</label>
                        <select class="form-control">
                            <option>All</option>
                            <option>Completed</option>
                            <option>Start</option>
                            <option>Received</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-row align-items-end">
                <div class="col">
                    <label class="form-label">From Date</label>
                    <input type="date" class="form-control">
                </div>
                <div class="col">
                    <label class="form-label">To Date</label>
                    <input type="date" class="form-control">
                </div>
                <div class="col-auto">
                    <div class="form-check mt-4">
                        <input class="form-check-input" type="checkbox" id="activeCheck">
                        <label class="form-check-label" for="activeCheck">Active</label>
                    </div>
                </div>
                <div class="col">
                    <button class="btn btn-primary btn-block">Refresh</button>
                </div>
                <div class="col">
                    <button class="btn btn-secondary btn-block">Export</button>
                </div>
                <div class="col">
                    <button class="btn btn-warning btn-block">Print</button>
                </div>
            </div>
        </div>
    </div>

    <div class="btn-group btn-group-status mb-3">
        <button class="btn btn-success">Start</button>
        <button class="btn btn-warning">Delay</button>
        <button class="btn btn-danger">End</button>
        <button class="btn btn-dark">Cancelled</button>
        <button class="btn btn-info">History</button>
    </div>

    <table id="appointmentListStatus" class="table table-bordered table-hover table-striped">
        <thead>
            <tr>
                <th>SL</th>
                <th>Remarks</th>
                <th>HCN</th>
                <th>Patient Name</th>
                <th>Date</th>
                <th>Time</th>
                <th>Service Name</th>
                <th>Mobile</th>
                <th>Machine</th>
                <th>Age/Sex</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody id="statusList">
            <!-- Dynamic content will be loaded here -->
        </tbody>
    </table>
</div>

<!-- JS Links -->
<script src="{{ asset('node_modules/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script>
    $(document).ready(function() {
        $.ajax({
            url: '{{ route('radiology-appointment-status-data') }}',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                let rows = '';
                $.each(data, function(index, item) {
                    rows += `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${item.remarks ?? ''}</td>
                            <td>${item.hcn ?? ''}</td>
                            <td>${item.patient_name ?? ''}</td>
                            <td>${item.appoint_date ?? ''}</td>
                            <td>${item.shed_str_time ?? ''}</td>
                            <td>${item.item_name ?? ''}</td>
                            <td>${item.mobile ?? ''}</td>
                            <td>${item.room_name ?? ''}</td>
                            <td>${(item.age ?? '') + ' / ' + (item.gender_txt ?? '')}</td>
                            <td>${item.report_status ?? ''}</td>
                        </tr>
                    `;
                });

                if (rows === '') {
                    rows = `<tr><td colspan="11" class="text-center text-muted">No data found.</td></tr>`;
                }

                $('#statusList').html(rows);
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                $('#statusList').html(
                    `<tr><td colspan="11" class="text-danger text-center">Data load failed.</td></tr>`
                );
            }
        });
    });
</script>
