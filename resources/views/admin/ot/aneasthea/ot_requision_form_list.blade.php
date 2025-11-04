<!-- resources/views/ipd/operation_requisition_form.blade.php -->

<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<style>
    .dataTables_buttons .btn {
        margin-right: 8px;
    }
</style>
<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm align-items-center mb-3  pt-2">
        <div class="col-md-6">
            <h5>Operation Requisition Form</h5>
            <small>IPD / Operation Requisition Form</small>
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

<!-- ✅ Nurses & Surgeons Data Passed to JS -->
<script>
    window.surgeons = @json($surgeons);
    window.departments = @json($departments);
    window.urgencies = [{
            id: 'Elective',
            text: 'Elective'
        },
        {
            id: 'Emergency',
            text: 'Emergency'
        },
        {
            id: 'Urgent',
            text: 'Urgent'
        }
    ];
</script>
<script>
    $(document).ready(function() {
        $('.select2').select2();

        // Initialize Select2 for dropdowns
        $('.select2').select2();

        // Initialize DataTable with AJAX and server-side processing
        var table = $('#requisition_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('ot.requisition-form-list-data') }}",
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
                        return `<input type="text" class="form-control diagnosis-input" value="${row[4] || ''}">`;
                    }
                },
                {
                    targets: 5,
                    render: function(data, type, row) {
                        return `<input type="text" class="form-control operation-input" value="${row[5] || ''}">`;
                    }
                },
                {
                    targets: 6,
                    render: function(data, type, row) {
                        return `<input type="text" class="form-control estimated-duration-input" value="${row[6] || ''}">`;
                    }
                },
                {
                    targets: 7,
                    render: function(data, type, row) {
                        return `<input type="text" class="form-control surgeon-remark-input" value="${row[7] || ''}">`;
                    }
                },
                {
                    targets: 8,
                    orderable: false,
                    render: function(data, type, row) {
                        const disabled = row[17] ? 'disabled' : '';
                        const selected = row[12];
                        let options = `<option value="">Select Category</option>`;
                        window.urgencies.forEach(u => {
                            options +=
                                `<option value="${u.text}" ${selected == u.text ? 'selected' : ''}>${u.text}</option>`;
                        });
                        return `<select class="form-select urgency-select" ${disabled}>${options}</select>`;
                    }
                },
                {
                    targets: 9,
                    orderable: false,
                    render: function(data, type, row) {
                        // const disabled = row[17] ? 'disabled' : '';
                        // const selected = row[13];
                        // let options = `<option value="">Select Surgeon</option>`;
                        // window.surgeons.forEach(s => {
                        //     options +=
                        //         `<option value="${s.person_no_pk}" ${selected == s.person_no_pk ? 'selected' : ''}>${s.full_name}</option>`;
                        // });
                        // return `<select class="form-select surgeon-select" ${disabled}>${options}</select>`;
                        return row[14]; // gender
                    }
                },
                {
                    targets: 10,
                    orderable: false,
                    render: function(data, type, row) {
                        const obsUrl = `{{ route('obstetric-urgency.print') }}`;
                        const formUrl =
                            `{{ route('ipd.pre-operative-checklist-form', ['__ADMNO__', '__PATNO__']) }}`;
                        const pdfUrl =
                            `{{ route('ipd.pre-operative-checklist-pdf', ['__ADMNO__', '__PATNO__']) }}`;

                        const finalFormUrl = formUrl.replace('__ADMNO__', row[10]).replace(
                            '__PATNO__', row[9]);
                        const finalPdfUrl = pdfUrl.replace('__ADMNO__', row[10]).replace(
                            '__PATNO__', row[9]);

                        if (row[17]) {
                            return `
                            <div class="d-flex align-items-center">
                                <span class="text-success mr-2">${row[18]}</span>
                                <a href="${obsUrl}" class="btn btn-secondary btn-sm" target="_blank">Obstetric Urgency PDF</a>
                            </div>
                            <div class="d-flex align-items-center mt-1">
                                <a href="${finalFormUrl}" class="btn btn-info btn-sm mr-2" target="_blank">Pre‑operative Checklist</a>
                                <a href="${finalPdfUrl}" class="btn btn-warning btn-sm mr-2" target="_blank">Pre‑operative Checklist Report</a>
                            </div>
                        `;
                        } else {
                            return `<button class="btn btn-success btn-sm btn-approve" req-no="${row[8]}">Send Requisition</button>`;
                        }
                    }
                }
            ]
        });
        $('#btnFilter').on('click', function() {
            table.ajax.reload();
        });

        $('#requisition_table tbody').on('click', '.btn-approve', function() {
            const $row = $(this).closest('tr');

            const diagnosis = $row.find('.diagnosis-input').val();
            const operation = $row.find('.operation-input').val();
            const estimated = $row.find('.estimated-duration-input').val();
            const remarks = $row.find('.surgeon-remark-input').val();
            const urgency = $row.find('.urgency-select').val();
            const surgeon = $row.find('.surgeon-select').val();
            // ... other fields as needed

            // Validate before sending
            // if (!surgeon || !urgency) {
            //     alert('Please select both Urgency and Surgeon.');
            //     return;
            // }

            // Gather any needed IDs
            const reqNo = $(this).attr('req-no');
            const patientId = $(this).data('patient-id');
            const admNo = $(this).data('adm-no');

            // Send via AJAX
            $.post("{{ route('ipd.requisition-send') }}", {
                    patient_id: patientId,
                    admNo: admNo,
                    reqNo: reqNo,
                    diagnosis: diagnosis,
                    operation: operation,
                    estimated_duration: estimated,
                    surgeon_remarks: remarks,
                    urgency: urgency,
                    surgeon_id: surgeon,
                    _token: '{{ csrf_token() }}'
                })
                .done(res => {
                    alert(res.message || 'Requisition sent successfully.');
                    table.ajax.reload(null, false);
                })
                .fail(() => {
                    alert('Error sending requisition.');
                });
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
