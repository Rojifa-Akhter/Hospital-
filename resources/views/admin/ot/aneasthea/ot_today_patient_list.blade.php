<!-- resources/views/ipd/operation_requisition_form.blade.php -->

<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<style>
    .dataTables_buttons .btn {
        margin-right: 8px;
    }

    .highlight-date {
        display: inline-block;
        background-color: #ffff99;
        /* pastel yellow */
        padding: 2px 4px;
        border-radius: 3px;
    }
</style>
<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm align-items-center mb-3  pt-2">
        <div class="col-md-6">
            <h5>Today Patient Requisition</h5>
            <small>OT / Today Patient Requisition</small>
        </div>
    </div>

    <!-- Filter Form -->
    <!-- Filter + Export Section -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body bg-light rounded">
            <form id="filterForm" class="row align-items-end g-3">
                <div class="col-md-4">
                    <label for="department" class="form-label text-primary fw-semibold">🧪 Department</label>
                    <select id="department" name="department" class="form-select select2 border-primary">
                        <option value="">Select Department</option>
                        @foreach ($departments as $dept)
                            <option value="{{ $dept->serviceunit_no_pk }}">{{ $dept->serviceunit_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <label for="urgency_category" class="form-label text-danger fw-semibold">⚠️ Surgical Urgency</label>
                    <select id="urgency_category" name="urgency_category" class="form-select select2 border-danger">
                        <option value="">Select Category</option>
                        <option value="Elective">Elective</option>
                        <option value="Emergency">Emergency</option>
                        <option value="Urgent">Urgent</option>
                    </select>
                </div>

                <div class="col-md-4 d-flex justify-content-between align-items-end">
                    <button type="button" id="btnFilter" class="btn btn-outline-primary w-50 me-2">
                        🔍 Filter
                    </button>

                    <button type="button" id="btnPrint" class="btn btn-outline-success w-50 me-2 ml-1">
                        🔍 Export PDF
                    </button>

                </div>
            </form>
        </div>
    </div>


    <!-- Requisition Table -->
    <table id="requisition_table" class="table table-striped table-bordered" style="width: 100%">
        <thead>
            <tr>
                <th>Sl</th>
                <th>Patient Name</th>
                <th>Age</th>
                <th>Sex</th>
                <th>Diagnosis</th>
                <th>Proposed Operation</th>
                <th>Planned Procedure Date & Time</th>
                <th>Estimated Duration</th>
                <th>Surgeon's Remarks</th>
                <th>Surgical Urgency</th>
                <th>Surgeon In charge</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

<script src="{{ asset('node_modules/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2();
        // SideBar Collapse
        $("body").addClass("sidebar-collapse");
        $("#sidebar-left").addClass("active");
        $("#content").addClass("active");

        // Initialize Select2 for dropdowns
        $('.select2').select2();


        // Initialize DataTable with AJAX and server-side processing
        var table = $('#requisition_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('ot.todays-patient-list-data') }}",
                type: "POST",
                data: function(d) {
                    d.department = $('#department').val();
                    d.urgency_category = $('#urgency_category').val();
                }
            },
            columns: Array(11).fill({
                data: null
            }),
            columnDefs: [{
                    targets: 0,
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    targets: 1,
                    render: function(data, type, row) {
                        return row[1]; // patient_name
                    }
                },
                {
                    targets: 2,
                    render: function(data, type, row) {
                        return row[2]; // age
                    }
                },
                {
                    targets: 3,
                    render: function(data, type, row) {
                        return row[3]; // gender
                    }
                },
                {
                    targets: 4,
                    render: function(data, type, row) {
                        return row[4];

                    }
                },
                {
                    targets: 5,
                    render: function(data, type, row) {
                        return row[5];

                    }
                },
                {
                    targets: 6,
                    render: function(data, type, row) {
                        const raw = row[21];
                        const dt = new Date(raw);
                        const day = String(dt.getDate()).padStart(2, '0');
                        const month = String(dt.getMonth() + 1).padStart(2, '0');
                        const year = dt.getFullYear();

                        const time = dt.toLocaleTimeString('en-US', {
                            hour12: true,
                            hour: 'numeric',
                            minute: '2-digit',
                            second: '2-digit'
                        });

                        return `<span class="highlight-date">${day}/${month}/${year}<br>${time}</span>`;
                    }
                },

                {
                    targets: 7,
                    render: function(data, type, row) {
                        return row[6];

                    }
                },
                {
                    targets: 8,
                    render: function(data, type, row) {
                        return row[7];

                    }
                },
                {
                    targets: 9,
                    render: function(data, type, row) {
                        return row[12];
                    }
                },
                {
                    targets: 10,
                    render: function(data, type, row) {
                        return row[14]; // gender
                    }
                },
                {
                    targets: 11,
                    render: function(data, type, row) {
                        if (row[17]) {
                            const dt = new Date(row[20]);
                            const day = String(dt.getDate()).padStart(2, '0');
                            const month = String(dt.getMonth() + 1).padStart(2, '0');
                            const year = dt.getFullYear();
                            const time = dt.toLocaleTimeString('en-US', {
                                hour12: true,
                                hour: 'numeric',
                                minute: '2-digit',
                                second: '2-digit'
                            });

                            const bookingUrl =
                                "{{ route('ot.appointment-status', ['__req__']) }}"
                                .replace('__req__', row[22]);

                            let html = `
                                    <div>
                                        Confirmed By: <span class="text-success mr-2">${row[18]}</span><br>
                                        Confirmed Date & Time: <span class="text-success mr-2">
                                        ${day}/${month}/${year} ${time}
                                        </span>
                                    </div>
                                   
                                    `;

                            // Add PDF button when OT is booked (row[23] == 0)
                            if (row[23] == 0 || row[23] == '0') {
                                const pdfUrl = "{{ route('ot.book-pdf', ['__req__']) }}"
                                    .replace('__req__', row[8]);
                                html += `<div class="d-flex justify-content-center align-items-center mt-1">
                                    <a href="${pdfUrl}" class="btn btn-success btn-sm" target="_blank">
                                    Already Booked (Show PDF)
                                    </a>
                                `;
                            }else{
                                 html += `
                                     <div class="d-flex justify-content-center align-items-center mt-1">
                                        <a href="${bookingUrl}" class="btn btn-info btn-sm mr-2" target="_blank">
                                        Book OT Slot
                                        </a>
                                `;
                            }

                            html += `</div>`;
                            return html;
                        }

                        // No else block — renders empty cell when row[17] is false
                        return '';
                    }
                }

            ]
        });
        $('#btnFilter').on('click', function() {
            table.ajax.reload();
        });


        $('#btnPrint').on('click', function() {
            const department = $('#department').val();
            const urgency = $('#urgency_category').val();

            // Construct the URL manually with query parameters
            const url = new URL("{{ route('ot.requisition.export-pdf') }}", window.location.origin);
            url.searchParams.append('department', department);
            url.searchParams.append('urgency_category', urgency);

            // Open in a new tab
            window.open(url.toString(), '_blank');
        });

    });
</script>
