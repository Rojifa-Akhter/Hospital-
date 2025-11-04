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
            <h5 class="mt-2 mb-0">OT Requisition List</h5>
            <small>OT / OT Requisition List</small>
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
            <h5>OT Requisition List</h5>
        </div>
        <div class="card-body p-2">
            <div class="form-row">
                <div class="col-md-12">
                    <table id="refs_table" class="display table table-striped table-bordered" style="width: 100%">
                        <thead>
                            {{-- <tr>
                                        <th>Sl</th>
                                        <th>UHID</th>
                                        <th>IP No</th> <!-- Newly Added -->
                                        <th>Patient Name</th>
                                        <th>Doctor</th>
                                        <th>OT Status</th> <!-- Renamed -->
                                        <th>Accepted By OT?</th> <!-- Newly Added -->
                                        <th>Action</th>
                                    </tr> --}}
                            <tr>
                                <th data-field="rownumber">Sl</th>
                                <th data-field="patient_code">UHID</th>
                                <th data-field="ip_no">IP No.</th>
                                <th data-field="patient_name">Patient Name</th>
                                <th data-field="full_name">Doctor</th>
                                <th data-field="SCHEDULE_DT">Planned Date</th>
                                <th data-field="planned_time">Planned Time</th>
                                <th data-field="status">Status</th>
                                {{-- <th data-field="action">Action</th> --}}
                                {{-- <th data-field="action">Action</th>
    <th data-field="action">Action</th> --}}
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
        order: [
            [2, "desc"]
        ],
        ajax: {
            url: "{{ route('ot/ot-requisiton-list-data') }}",
            type: "POST",
            data: function(d) {
                d.service_number = $('#hdn_patient_id').val();
                d.doc_id = $('#doc_id').val();
                d.admission_date_from = $('#admission_date_from').val();
                d.admission_date_to = $('#admission_date_to').val();
                d.doc = "DOC";
            }
        },
        columnDefs: [
            {
                targets: 0,
                render: (data, type, row, meta) => meta.row + meta.settings._iDisplayStart + 1
            },
            {
                targets: 1,
                render: (data, type, row) => row[1] // UHID
            },
            {
                targets: 2,
                render: (data, type, row) => row[10] // IP No
            },
            {
                targets: 3,
                render: (data, type, row) => row[3] // Patient Name
            },
            {
                targets: 4,
                render: (data, type, row) => row[4] // Doctor
            },
            {
                targets: 5,
                render: function(data, type, row) {
                    const rawDate = row[5];
                    if (!rawDate) return '';
                    const dateObj = new Date(rawDate);
                    const day = String(dateObj.getDate()).padStart(2, '0');
                    const month = String(dateObj.getMonth() + 1).padStart(2, '0');
                    const year = dateObj.getFullYear();
                    return `${day}/${month}/${year}`;
                }
            },
            {
                targets: 6,
                render: (data, type, row) => {
                    const start = row[12];
                    const end = row[13];

                    const formatTime = (datetime) => {
                        if (!datetime) return '';
                        const timePart = datetime.split(' ')[1];
                        const [hour, minute] = timePart.split(':');
                        const h = parseInt(hour);
                        const ampm = h >= 12 ? 'PM' : 'AM';
                        const hour12 = h % 12 || 12;
                        return `${hour12}:${minute} ${ampm}`;
                    };

                    const startTime = formatTime(start);
                    const endTime = formatTime(end);

                    return `<strong>${startTime} - ${endTime}</strong>`;
                }
            },
            {
                targets: 7,
                render: function(data, type, row) {
                    const confirmationInd = row[16]; // ot_comfirmation_ind
                    const confirmedBy = row[14]; // user_name
                    const confirmationTime = row[15]; // ot_comfirmation_time
                    const status = row[14]; // ACCEPT/REJECT

                    if (confirmationInd === "1") {
                        return `
                            <div>
                                <span class="badge bg-primary">Confirmed</span><br>
                                <small><strong>Confirmed By:</strong> ${confirmedBy || 'N/A'}</small><br>
                                <small><strong>Confirmed Date & Time:</strong> ${confirmationTime || 'N/A'}</small>
                            </div>
                        `;
                    } else if (status === "ACCEPT") {
                        return '<span class="badge bg-success">Accepted</span>';
                    } else if (status === "REJECT") {
                        return '<span class="badge bg-danger">Rejected</span>';
                    } else {
                        return '<span class="badge bg-warning text-dark">Pending</span>';
                    }
                }
            }
        ],
       rowCallback: function(row, data, index) {
    $(row).removeClass('bg-success bg-danger bg-white');

    const status = data[14];
    const isConfirmed = data[16] === "1"; // confirmed indicator

    if (isConfirmed) {
        $(row).css('background-color', '#d4edda'); // light green for confirmed
    } else if (status === "ACCEPT") {
        $(row).css('background-color', '#e2f0fb'); // light blue for accepted
    } else if (status === "REJECT") {
        $(row).css('background-color', '#f8d7da'); // light red for rejected
    } else {
        $(row).css('background-color', '#fff3cd'); // light yellow for pending
    }
}
    });
});
</script>
