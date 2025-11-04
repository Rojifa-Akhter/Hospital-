<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/datatables/media/css/buttons.dataTables.min.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm align-items-center ">
        <div class="col-md-10">
            <h5 class="mt-2 mb-0">Anesthesia Referred List</h5>
            <small>Anesthesia Referred List</small>
        </div>

        <div id="top-action col-md-2">
            <a type="button" class="btn btn-primary btn-md" href="{{ route('uhl.appointment') }}">
                Create Appointment
            </a>
        </div>
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
            <h5>Anesthesia Referred List</h5>
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
                                <th data-field="age" data-sortable="true">Age</th>
                                <th data-field="reff_doc" data-sortable="true">Referred Doctor</th>
                                <th data-field="dept" data-sortable="true">Dept</th>
                                <th data-field="reff_date" data-sortable="true">Referred Date</th>
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
<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>

<script>
    $("body").addClass("sidebar-collapse");
    $("#sidebar-left, #content").addClass("active");
    openPatientAutocomplete('#patient_id');
    openDoctorAutocomplete('#doc_name', 'doc_id');
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

        $('#btnSearch').on('click', () => $('#refs_table').DataTable().ajax.reload());

        const table = $('#refs_table').DataTable({
            processing: true,
            serverSide: true,
            order: [
                [2, 'desc']
            ],
            ajax: {
                url: "{{ route('anesthetia-reffered-list-data') }}",
                type: "POST",
                data: d => {
                    d.service_number = $('#hdn_patient_id').val();
                    d.doc_id = $('#doc_id').val();
                    d.admission_date_from = $('#admission_date_from').val();
                    d.admission_date_to = $('#admission_date_to').val();
                    d.doc = "DOC";
                }
            },
            columns: Array(8).fill({
                data: null
            }),
            columnDefs: [{
                    targets: 0,
                    render: (data, type, row, meta) => meta.row + meta.settings._iDisplayStart + 1
                },
                {
                    targets: 1,
                    render: (data, type, row) => row[1]
                },
                {
                    targets: 2,
                    render: (data, type, row) => row[2]
                },
                {
                    targets: 3,
                    render: (data, type, row) => row[3]
                },
                {
                    targets: 4,
                    render: (data, type, row) => row[5]
                },
                {
                    targets: 5,
                    render: (data, type, row) => row[6]
                },
                {
                    targets: 6,
                    render: function(data, type, row) {
                        const rawDate = row[11];
                        if (!rawDate) return '';
                        const dateObj = new Date(rawDate);
                        const day = String(dateObj.getDate()).padStart(2, '0');
                        const month = String(dateObj.getMonth() + 1).padStart(2, '0');
                        const year = dateObj.getFullYear();
                        return `${day}/${month}/${year}`;
                    }

                },
                {
                    targets: 7,
                    render: function(data, type, row, meta) {
                        const pres_id = row[12] || '';
                        const ref_url = `{{ route('v2.op_summary_pdf_uhl', ['__ID__']) }}`
                            .replace('__ID__', pres_id);

                        // Build the HTML string for the button
                        const button = `
      <a class="btn btn-sm btn-warning ml-1" 
         target="_blank" href="${ref_url}">
        Print OP Summary
      </a>
    `;
                        return button; // ✅ Must return the HTML string
                    }
                },

            ],
        });
    });
</script>
