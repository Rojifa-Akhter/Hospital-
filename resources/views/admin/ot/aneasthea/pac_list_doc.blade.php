<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/datatables/media/css/buttons.dataTables.min.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm align-items-center ">
        <div class="col-md-9">
            <h5 class="mt-2 mb-0">PAC Work List</h5>
            <small>IPD / PAC Work List</small>
        </div>
        {{-- <div id="top-action">
            <a type="button" class="btn btn-primary btn-md" href="{{ route('ot.requisition-form-list-doc') }}">
                Emergency OT Requisition Request
            </a>
        </div> --}}
    </div>
    <div class="card">
        <div class="card-header card-text">
            <h5><i class="fa fa-search"></i>&nbsp; Search</h5>
        </div>
        <div class="card-body">
            <form id="searchForm" action="{{ route('ipd.search-admission-patient') }}" method="post">
                <div class="form-row justify-content-center">
                    <div class="form-group col-md-2">
                        <label class="col-form-label col-form-label-sm" for="service_id">UHID</label>
                        <input type="text" class="form-control" id="patient_id" name="patient_id"
                            placeholder="UHID/Name/Mobile" title="Search By Patient ID/ Name/ Mobile" />
                        <input type="hidden" class="form-control" id="hdn_patient_id" name="hdn_patient_id" />
                    </div>

                    {{-- <div class="form-group col-md-2">
                        <label class="col-form-label col-form-label-sm" for="service_id">Doctor</label>
                        <input type="text" class="form-control " name="doc_name" id="doc_name"
                            placeholder="Card Number" />
                        <input type="hidden" name="doc_id" id="doc_id">
                    </div> --}}

                    <div class="form-group col-md-4">
                        <label class="col-form-label col-form-label-sm" for="admission_date_from">Ref. Date</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">From</div>
                            </div>
                            <input type="text" class="form-control form-control-sm m-0 date-picker"
                                id="admission_date_from" name="admission_date_from" value=""
                                placeholder="dd-mm-yyyy">
                            <div class="input-group-prepend">
                                <div class="input-group-text">To</div>
                            </div>
                            <input type="text" class="form-control form-control-sm m-0 date-picker"
                                id="admission_date_to" name="admission_date_to" value="" placeholder="dd-mm-yyyy">
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="btn-group btn-block mt-4" role="group">
                            <button type="button" class="btn btn-md btn-success btn-md-global" id="btnSearch"
                                data-action="">
                                Search
                            </button>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h5>PAC Work List</h5>
        </div>
        <div class="card-body p-2">
            <div class="form-row">
                <div class="col-md-12">
                    <table id="refs_table" class="display table table-striped table-bordered" style="width: 100%">
                        <thead>
                            <tr>
                                <th data-field="rownumber" data-sortable="true">Sl</th>
                                <th data-field="patient_code" data-sortable="true">UHID</th>
                                <th data-field="patient_name" data-sortable="true">Patient Name</th>
                                <th data-field="full_name" data-sortable="true">Doctor</th>
                                <th data-field="patient_type" data-sortable="true">Patient Type</th>
                                <th data-field="purpose_off_reff" data-sortable="true">Purpose Of Referral</th>
                                <th data-field="diagnosis" data-sortable="true">Diagnosis</th>
                                <th data-field="result_of_inv_note" data-sortable="true">Result Of Invoice Note</th>
                                <th data-field="plane_proc_withdate" data-sortable="true">Plane Procedure</th>
                                <th data-field="reff_date" data-sortable="true">Ref. Date</th>
                                <th data-field="estimated_duration_surge" data-sortable="true">Estimated Duration</th>
                                <th data-field="specefic_req_n_remarks" data-sortable="true">Remarks</th>
                                <th data-field="anes_name" data-sortable="true">Anesthesiologist Name</th>
                                <th data-field="status" data-sortable="true">Status</th>
                                <th data-field="action" data-sortable="true">Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}">
</script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>

<script>
    $("body").addClass("sidebar-collapse");
    $("#sidebar-left").addClass("active");
    $("#content").addClass("active");
    openPatientAutocomplete('#patient_id');
    openDoctorAutocomplete('#doc_name', 'doc_id'); //'referral_agent_ind','1,2'
    $(".date-picker").datepicker({
        format: 'dd-mm-yyyy',
        todayHighlight: true,
        clearBtn: true,
        autoclose: true
    });

    $(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#btnSearch').on('click', function() {
            $('#refs_table').DataTable().ajax.reload();
        });

        const table = $('#refs_table').DataTable({
            processing: true,
            serverSide: true,
            "order": [
                [2, "desc"]
            ],
            ajax: {
                url: "{{ route('ot.pac-list-doc-data') }}",
                type: "POST",
                data: function(d) {
                    d.service_number = $('#hdn_patient_id').val();
                    d.doc_id = $('#doc_id').val();
                    d.admission_date_from = $('#admission_date_from').val();
                    d.admission_date_to = $('#admission_date_to').val();
                    d.doc = "DOC";
                }
            },
            columns: Array(14).fill({
                data: null
            }), // 14 null columns
            columnDefs: [{
                    targets: 0,
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    targets: 1,
                    render: function(data, type, row) {
                        return row[1];
                    }
                },
                {
                    targets: 2,
                    render: function(data, type, row) {
                        return row[2];
                    }
                },
                {
                    targets: 3,
                    render: function(data, type, row) {
                        return row[3];
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
                        return row[6];
                    }
                },
                {
                    targets: 7,
                    render: function(data, type, row) {
                        return row[7];
                    }
                },
                {
                    targets: 8,
                    render: function(data, type, row) {
                        return row[8];
                    }
                },
                {
                    targets: 9,
                    render: function(data, type, row) {
                        const rawDate = row[9];
                        if (!rawDate) return '';
                        const dateObj = new Date(rawDate);
                        const day = String(dateObj.getDate()).padStart(2, '0');
                        const month = String(dateObj.getMonth() + 1).padStart(2, '0');
                        const year = dateObj.getFullYear();
                        return `${day}/${month}/${year}`;
                    }
                },
                {
                    targets: 10,
                    render: function(data, type, row) {
                        return row[10];
                    }
                },
                {
                    targets: 11,
                    render: function(data, type, row) {
                        return row[11];
                    }
                },
                {
                    targets: 12,
                    render: function(data, type, row) {
                        return '<span class="badge bg-warning text-dark">' + row[15] +
                            '</span>';

                    }
                },
                {
                    targets: 13,
                    render: function(data, type, row) {
                        if (row[14] == "") {
                            return '<span class="badge bg-warning text-dark">Pending</span>';
                        } else if (row[14] == "ACCEPT") {
                            return '<span class="badge bg-success">Fit For Surgery</span>';
                        } else if (row[14] == "REJECT") {
                            return '<span class="badge bg-danger">Deferred</span>';
                        } else {
                            return '<span class="badge bg-warning text-dark">Pending</span>';
                        }
                    }
                },
                {
                    targets: 14,
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        const reff_no = row[13] ||
                            ''; // Assuming 14th column is REFF_ANES_DEPT_NO_PK
                        const status = (row[14] || '')
                            .toUpperCase(); // FEEDBACK_TYPE: ACCEPT / REJECT / PENDING etc.
                        const patient_no = row[18] || '';

                        const ref_url = `{{ route('ot.pac-accept', ['__ID__']) }}`.replace(
                            '__ID__', reff_no);
                           const docForm = `{{ route('ot.requisition-form-list-doc') }}`;
                        const req_url = `{{ route('ot.requisition-form-list-doc') }}`;
                        const def_url = `{{ route('ot.pac-deferred', ['__ID__']) }}`.replace(
                            '__ID__', reff_no);
                        const pacPdfUrl =
                            `{{ route('ipd.anaesthetic-refferral-form-pdf', ['__ID__']) }}`
                            .replace('__ID__', reff_no);
                        const reportUrl =
                            "{{ url('/') }}/ipd/pre-anesthetic-patient-checkup-doc-pdf/" +
                            patient_no + '/' + reff_no;

                        let buttons = '';

                        if (status !== 'ACCEPT' && status !== 'REJECT') {
                            // PENDING
                            buttons +=
                                `<span class="badge bg-success text-dark">Pending</span>`;
                        } else if (status === 'ACCEPT') {
                            // ACCEPTED
                            buttons += `
        <a type="button" class="btn btn-warning btn-sm" target="_blank" href="${pacPdfUrl}">
            PAC (Anaesthetic Referral Form)
        </a>
      
         <a class="btn btn-sm btn-warning ml-1" target="_blank" href="${reportUrl}">
      Pre-operative Instructions
    </a>
    `;

                            const admission_req_no = row[16]; // admission_req_no_fk
                            const admission_no = row[17]; // admission_no

                            function isEmpty(value) {
                                return value == null || (typeof value === 'string' && value
                                    .trim().length === 0);
                            }

                            const reqEmpty = isEmpty(admission_req_no);
                            const noEmpty = isEmpty(admission_no);

                            if (!reqEmpty && noEmpty) {
                                buttons +=
                                    `<span class="badge bg-success"><i class="fa fa-check-circle"></i> Request Sent</span>`;
                            } else if (!reqEmpty && !noEmpty) {
                                buttons +=
                                    `<span class="badge bg-primary  mt-1"><i class="fa fa-bed"></i> Admitted</span>`;
                            } else {
                                buttons += `
                                 

  `;
                            }
                        } else if (status === 'REJECT') {
                            // REJECTED
                            buttons += `
        <a type="button" class="btn btn-warning btn-sm" target="_blank" href="${pacPdfUrl}">
            Rejected Form
        </a>
    `;
                        }


                        // If status === 'REJECT' → show nothing

                        return buttons;
                    }
                }

            ],
            rowCallback: function(row, data, index) {
                $(row).removeClass('bg-success bg-danger bg-white');

                if (data[14] == "") {
                    $(row).css('background-color', 'green'); // green
                } else if (data[14] == "ACCEPT") {
                    $(row).css('background-color', '#ffffff'); // white
                } else if (data[14] == "REJECT") {
                    $(row).css('background-color', '#f8d7da'); // red
                }
            }
        });
    });


    function admissionRequest(thisElement) {
        const reff_id = $(thisElement).attr('anes-id');

        if (!reff_id) {
            alert('Missing referral ID.');
            return;
        }

        $.ajax({
            url: "{{ route('ipd.admission-request-update') }}",
            type: "POST",
            data: {
                reff_id: reff_id,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function() {
                blockUI();
                $(".common-modal-notify").modal("show");
                $(".common-modal-notify .modal-body").html("");
                $(thisElement).prop('disabled', true).text('Processing...');
            },
            success: function(data) {
                $('#refs_table').DataTable().ajax.reload();
                $(thisElement).closest("tr").remove();
                $(".common-modal-notify .modal-title").html(data.title || "Success");
                $(".common-modal-notify .modal-body").html(data.msg || "Admission request completed.");
            },
            error: function(data) {
                $('#refs_table').DataTable().ajax.reload();
                const response = data.responseJSON;
                $(".common-modal-notify-error").modal("show");
                $(".common-modal-notify-error .modal-title").html("Validation Error");
                $(".common-modal-notify-error .modal-body").html(response?.errors?.msg ||
                    "An error occurred.");
            },
            complete: function() {
                $.unblockUI();
                $(thisElement).prop('disabled', false).text('Request Admission');
            }
        });
    }
</script>
