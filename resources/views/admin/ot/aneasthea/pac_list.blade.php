{{-- CSS --}}
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/datatables/media/css/buttons.dataTables.min.css') }}">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />

{{-- Custom Style --}}
<style>
    .btn-group-vertical .btn {
        width: 100%;
    }

    .btn-group {
        min-width: 240px;
    }

    .btn-sm {
        font-size: 0.75rem;
        padding: 0.25rem 0.5rem;
    }

    .btn-outline-primary {
        border-color: #007bff;
        color: #007bff;
    }

    .btn-outline-warning {
        border-color: #ffc107;
        color: #856404;
    }

    .btn-outline-primary:hover,
    .btn-outline-warning:hover {
        background-color: #f1f1f1;
    }
</style>

<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm align-items-center">
        <div class="col-md-6">
            <h5 class="mt-2 mb-0">IPD Assessment Work List</h5>
            <small>IPD / IPD Assessment Work List</small>
        </div>
    </div>

    {{-- Search Card --}}
    <div class="card">
        <div class="card-header card-text">
            <h5><i class="fa fa-search"></i>&nbsp; Search</h5>
        </div>
        <div class="card-body">
            <form id="searchForm">
                <div class="form-row justify-content-center">
                    <div class="form-group col-md-2">
                        <label class="col-form-label-sm">UHID</label>
                        <input type="text" class="form-control" id="patient_id" placeholder="UHID/Name/Mobile" />
                        <input type="hidden" id="hdn_patient_id" />
                    </div>

                    <div class="form-group col-md-2">
                        <label class="col-form-label-sm">Doctor</label>
                        <input type="text" class="form-control" id="doc_name" placeholder="Card Number" />
                        <input type="hidden" id="doc_id" />
                    </div>

                    <div class="form-group col-md-4">
                        <label class="col-form-label-sm">Ref. Date</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">From</div>
                            </div>
                            <input type="text" class="form-control form-control-sm date-picker"
                                id="admission_date_from" placeholder="dd-mm-yyyy">
                            <div class="input-group-prepend">
                                <div class="input-group-text">To</div>
                            </div>
                            <input type="text" class="form-control form-control-sm date-picker"
                                id="admission_date_to" placeholder="dd-mm-yyyy">
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="btn-group btn-block mt-4">
                            <button type="button" class="btn btn-success" id="btnSearch">Search</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Tabs --}}
    <ul class="nav nav-tabs mt-2" id="tabStatus" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="pending-tab" data-toggle="tab" href="#pending" role="tab">⏳ Pending</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="accepted-tab" data-toggle="tab" href="#accepted" role="tab">✅ Accepted</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="deferred-tab" data-toggle="tab" href="#deferred" role="tab">❌ Deferred</a>
        </li>
    </ul>
    <input type="hidden" id="auth_id" name="auth_id" value="{{ Session::get('user.user_code') }}">
    <div class="tab-content" id="tabContent">
        <div class="tab-pane fade show active" id="pending" role="tabpanel">
            @include('admin.ot.aneasthea.aneastheia-assessment-table', [
                'status' => 'PENDING',
                'tableId' => 'table_pending',
            ])
        </div>
        <div class="tab-pane fade" id="accepted" role="tabpanel">
            @include('admin.ot.aneasthea.aneastheia-assessment-table', [
                'status' => 'ACCEPT',
                'tableId' => 'table_accepted',
            ])
        </div>
        <div class="tab-pane fade" id="deferred" role="tabpanel">
            @include('admin.ot.aneasthea.aneastheia-assessment-table', [
                'status' => 'REJECT',
                'tableId' => 'table_deferred',
            ])
        </div>
    </div>
</div>

{{-- JS --}}
<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>

<script>
    $("body").addClass("sidebar-collapse");
    $("#sidebar-left").addClass("active");
    $("#content").addClass("active");
    openPatientAutocomplete('#patient_id');
    openDoctorAutocomplete('#doc_name', 'doc_id');

    $(".date-picker").datepicker({
        format: 'dd-mm-yyyy',
        todayHighlight: true,
        clearBtn: true,
        autoclose: true
    });

    const tableIds = ['table_pending', 'table_accepted', 'table_deferred'];
    const statuses = ['PENDING', 'ACCEPT', 'REJECT'];

    function initializeTable(tableId, status) {
        $('#' + tableId).DataTable({
            "searching": true,
            "processing": true,
            "serverSide": true,
            "lengthMenu": [10, 25, 50, 75, 100, 200, 300],
            "order": [
                [13, "desc"]
            ],
            ajax: {
                url: "{{ route('ot.pac-list-data') }}",
                type: "POST",
                data: function(d) {
                    d.service_number = $('#hdn_patient_id').val();
                    d.doc_id = $('#doc_id').val();
                    d.admission_date_from = $('#admission_date_from').val();
                    d.admission_date_to = $('#admission_date_to').val();
                    d.status_filter = status;
                }
            },
            columns: Array(15).fill({
                data: null
            }),
            columnDefs: [...commonColumnDefs()]
        });
    }

    function commonColumnDefs() {
        return [{
                targets: 0,
                render: (data, type, row, meta) => meta.row + meta.settings._iDisplayStart + 1
            },
            ...[1, 2, 3, 4, 5, 6, 7, 8].map(i => ({
                targets: i,
                render: (data, type, row) => row[i]
            })),
            {
                targets: 9,
                render: (data, type, row) => row[16] || '<span class="text-danger">Not Yet Admitted</span>'
            },
            {
                targets: 10,
                render: (data, type, row) => {
                    const rawDate = row[9];
                    if (!rawDate) return '';
                    const dateObj = new Date(rawDate);
                    return `${String(dateObj.getDate()).padStart(2, '0')}/${String(dateObj.getMonth() + 1).padStart(2, '0')}/${dateObj.getFullYear()}`;
                }
            },
            {
                targets: 11,
                render: (data, type, row) => row[10]
            },
            {
                targets: 12,
                render: (data, type, row) => row[11]
            },
            {
                targets: 13,
                render: (data, type, row) => {
                    const status = row[14];
                    if (!status) return '<span class="badge bg-warning text-dark">Pending</span>';
                    if (status === "ACCEPT") return '<span class="badge bg-success">Fit For Surgery</span>';
                    if (status === "REJECT") return '<span class="badge bg-danger">Deferred</span>';
                    return '<span class="badge bg-secondary">Unknown</span>';
                }
            },
            // {
            //     targets: 14,
            //     orderable: false,
            //     searchable: false,
            //     render: (data, type, row) => {
            //         const reff_no = row[13] || '';
            //         const status = (row[14] || '').toUpperCase();
            //         const ref_url = `{{ route('ot.pac-accept', ['__ID__']) }}`.replace('__ID__', reff_no);
            //         const def_url = `{{ route('ot.pac-deferred', ['__ID__']) }}`.replace('__ID__', reff_no);
            //         const pacPdfUrl = `{{ route('ipd.anaesthetic-refferral-form-pdf', ['__ID__']) }}`.replace(
            //             '__ID__', reff_no);

            //         let buttons = '';
            //         if (status === 'ACCEPT' || status === 'REJECT') {
            //             buttons +=
            //                 `<a href="${pacPdfUrl}" target="_blank" class="btn btn-warning btn-sm mb-1"><i class="fa fa-file-pdf-o"></i> View Form</a>`;
            //         } else {
            //             buttons += `
            //                 <button type="button" class="btn btn-success btn-sm mb-1 open-modal" data-modal="common-modal-xl" data-title="PAC Accept" data-action="${ref_url}">
            //                     <i class="fa fa-check"></i> Accept
            //                 </button>
            //                 <button type="button" class="btn btn-danger btn-sm mb-1 open-modal" data-modal="common-modal-xl" data-title="OT Deferred" data-action="${def_url}">
            //                     <i class="fa fa-times-circle"></i> Deferred
            //                 </button>`;
            //         }

            //         return `<div class="btn-group-vertical">${buttons}</div>`;
            //     }
            // }
            {
                targets: 14,
                orderable: false,
                searchable: false,
                render: function(data, type, row) {
                    const authId = $('input[name="auth_id"]').val();
                    const reff_no = row[13] || '';
                    const status = (row[14] || '').toUpperCase();
                    const patient_no = row[17] || '';
                    const patient_code = row[1] || '';
                    const formUrl = "{{ url('/') }}/ipd/pre-anesthetic-patient-checkup-form/" +
                        patient_no + '/' + reff_no;

                    const reportUrl = "{{ url('/') }}/ipd/pre-anesthetic-patient-checkup-pdf/" +
                        patient_no + '/' + reff_no;
                    const rfForDoctor = "{{ route('ipd.anaesthetic-refferral-form-doc-pdf', ['__ID__']) }}"
                        .replace('__ID__', reff_no);
                    let html = '';
                    if (status === 'ACCEPT') {
                        const pacPdfUrl = "{{ route('ipd.anaesthetic-refferral-form-pdf', ['__ID__']) }}"
                            .replace('__ID__', reff_no);

                        const html = `
    <div class="d-flex flex-wrap gap-1 mb-1">
      <a class="btn btn-warning btn-sm" target="_blank" href="${pacPdfUrl}">
        PAC (Anaesthetic Referral Form)
      </a>
    </div>
  `;
                        return html;
                    }

                    if (status !== 'ACCEPT') {
                        const acceptUrl = "{{ route('ot.pac-accept', ['__ID__']) }}".replace('__ID__',
                            reff_no);
                        const deferUrl = "{{ route('ot.pac-deferred', ['__ID__']) }}".replace('__ID__',
                            reff_no);

                        html += `<div class=" gap-1">
                             <a class="btn btn-sm btn-warning" href="${rfForDoctor}" target="_blank" class="btn ml-1 btn-outline-success btn-sm bg-none cursor-pointer" id="admission_id" title="Emergency Prescription">ANESTHETIC REFERRAL FORM  </a>

    </div>`;
                    }

                    // Example: additional forms/reports


                    html += `<div class="btn-group mb-1 me-1 mt-2" role="group">
    
    <a class="btn btn-sm btn-warning ml-1" target="_blank" href="${reportUrl}">
      Pre‑Anesthesia Assessment PDF
    </a>
  </div>`;

                    return html;
                }
            }


        ];
    }

    $(document).ready(function() {
        tableIds.forEach((id, idx) => initializeTable(id, statuses[idx]));
    });

    $('#btnSearch').on('click', function() {
        tableIds.forEach((id, idx) => {
            $('#' + id).DataTable().ajax.reload();
        });
    });
</script>
