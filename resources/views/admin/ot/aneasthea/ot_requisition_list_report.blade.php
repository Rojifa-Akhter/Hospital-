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
            <h5 class="mt-2 mb-0">Doctor Wise Performed OT</h5>
            <small>OT / Doctor Wise Performed OT</small>
        </div>
    </div>

    <div class="card">
        <div class="card-header card-text">
            <h5><i class="fa fa-search"></i>&nbsp; Search</h5>
        </div>
        <div class="card-body">
            <form id="exportForm" action="{{ route('doctor-wise-surgery-export') }}" method="post">
                @csrf
                <input type="hidden" id="hdn_report_type" name="hdn_report_type">
                <div class="form-row justify-content-center">
                    <div class="form-group col-md-2">
                        <label class="col-form-label col-form-label-sm" for="service_id">UHID</label>
                        <input type="text" class="form-control" id="patient_id" name="patient_id"
                            placeholder="UHID/Name/Mobile" title="Search By Patient ID/ Name/ Mobile" />
                        <input type="hidden" class="form-control" id="hdn_patient_id" name="hdn_patient_id" />
                    </div>
                    <div class="form-group col-md-2">
                        <label class="col-form-label col-form-label-sm" for="service_id">Doctor</label>
                        <input type="text" class="form-control " name="doc_name" id="doc_name"
                            placeholder="Card Number" />
                        <input type="hidden" name="doc_id" id="doc_id">
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

                    <div class="col-md-4">
                        <div class="btn-group btn-block mt-4" role="group">
                            <button type="button" class="btn btn-md btn-success" id="btnSearch">Search</button>
                            <button type="button" class="btn btn-md btn-danger" id="btnPdf">Export PDF</button>
                            <button type="button" class="btn btn-md btn-primary" id="btnExcel">Export Excel</button>

                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5>
                Doctor Wise Performed OT List</h5>
        </div>
        <div class="card-body p-2">
            <div class="form-row">
                <div class="col-md-12">
                    <table id="doc_table" class="display table table-striped table-bordered" style="width: 100%">
                        <thead>
                            <tr>
                                <th data-field="rownumber">Sl</th>
                                <th data-field="ip_no">IP No.</th>
                                <th data-field="patient_name">Patient Name</th>
                                <th data-field="patient_name">Age</th>
                                <th data-field="patient_name">Department</th>
                                <th data-field="patient_name">Item Code</th>
                                <th data-field="doctor_name">Surgeon Name</th>
                                <th data-field="anesthesiologist_name_primary">Anesthesiologist name</th>
                                <th data-field="surgery_name">Surgery Name</th>
                                <th data-field="ot_room">Ward</th>
                                <th data-field="ot_room">Under Pakage</th>
                                <th data-field="ot_room">Net Amt</th>
                                <th data-field="completed_date">Completed Date</th>
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
            $('#doc_table').DataTable().ajax.reload();
        });

        const table = $('#doc_table').DataTable({
            processing: true,
            serverSide: true,
            order: [
                [2, "desc"] // Assuming sorting by the 3rd column (patient_name or ip_no)
            ],
            ajax: {
                url: "{{ route('doctor-wise-surgery-list-data') }}",
                type: "POST",
                data: function(d) {
                    d.service_number = $('#hdn_patient_id').val();
                    d.doc_id = $('#doc_id').val();
                    d.admission_date_from = $('#admission_date_from').val();
                    d.admission_date_to = $('#admission_date_to').val();
                    d.hdn_report_type = $('#hdn_report_type').val();
                    d.doc = "DOC";
                }
            },
            columns: [{
                    targets: 0,
                    render: (data, type, row, meta) => meta.row + meta.settings._iDisplayStart + 1
                },
                {
                    targets: 1, // admission_uid
                    render: (data, type, row) => row[1]
                },
                {
                    targets: 2, // patient_name
                    render: (data, type, row) => row[2]
                },
                {
                    targets: 3, // age
                    render: (data, type, row) => row[3]
                },
                {
                    targets: 4, // ipd_department_name
                    render: (data, type, row) => row[4]
                },
                {
                    targets: 5, // item_code (empty in DB, so possibly computed here or returned manually)
                    render: (data, type, row) => row[5] || '-'
                },
                {
                    targets: 6, // surg_doctor_name
                    render: (data, type, row) => row[6]
                },
                {
                    targets: 7, // actual_anest_name
                    render: (data, type, row) => row[7]
                },
                {
                    targets: 8, // item_name
                    render: (data, type, row) => row[8]
                },
                {
                    targets: 9, // ward_name
                    render: (data, type, row) => row[9]
                },
                {
                    targets: 10, // package (empty)
                    render: (data, type, row) => row[10] || '-'
                },
                {
                    targets: 11, // net amount (empty)
                    render: (data, type, row) => row[11] || '-'
                },
                {
                    targets: 12, // ot_completed_date
                    render: (data, type, row) => {
                        const rawDate = row[12];
                        if (!rawDate) return '';
                        const dateObj = new Date(rawDate);
                        return `${String(dateObj.getDate()).padStart(2, '0')}/${String(dateObj.getMonth() + 1).padStart(2, '0')}/${dateObj.getFullYear()}`;
                    }
                }
            ],
            rowCallback: function(row, data, index) {
                // Reset background classes/colors first
                $(row).removeClass('bg-success bg-danger bg-warning bg-info');

                // Apply background color based on 'status' or 'confirmed' status
                // Adjust data keys as per your data source

                const status = data.status ? data.status.toUpperCase() : '';
                const isConfirmed = data.ot_comfirmation_ind == "1" || data.confirmed == "1";

                if (isConfirmed) {
                    $(row).css('background-color', '#d4edda'); // Light green - confirmed
                } else if (status === "ACCEPT") {
                    $(row).css('background-color', '#e2f0fb'); // Light blue - accepted
                } else if (status === "REJECT") {
                    $(row).css('background-color', '#f8d7da'); // Light red - rejected
                } else {
                    $(row).css('background-color', '#fff3cd'); // Light yellow - pending/others
                }
            }
        });
    });
    $('#btnExcel').on('click', function() {
        exportFile('excel');
    });

    $('#btnPdf').on('click', function() {
        exportFile('pdf');
    });

    function exportFile(type) {
        $('#hdn_report_type').val(type);

        if (type === 'pdf') {
            $('#exportForm').attr('target', '_blank');
        } else {
            $('#exportForm').removeAttr('target');
        }

        $('#exportForm').submit();
    }


    //     function exportFile(type) {
    //     const data = {
    //         service_number: $('#hdn_patient_id').val(),
    //         doc_id: $('#doc_id').val(),
    //         admission_date_from: $('#admission_date_from').val(),
    //         admission_date_to: $('#admission_date_to').val(),
    //         doc: 'DOC',
    //         export_type: type // 'pdf' or 'excel'
    //     };

    //     $.ajax({
    //         url: "{{ route('doctor-wise-surgery-export') }}",
    //         type: 'POST',
    //         data: data,
    //         xhrFields: {
    //             responseType: 'blob'
    //         },
    //         success: function (blob, status, xhr) {
    //             const disposition = xhr.getResponseHeader('Content-Disposition');
    //             let filename = '';
    //             if (disposition && disposition.indexOf('filename=') !== -1) {
    //                 const matches = /filename[^;=\n]*=((['"]).*?\2|[^;\n]*)/.exec(disposition);
    //                 if (matches && matches[1]) filename = matches[1].replace(/['"]/g, '');
    //             }
    //             if (!filename) filename = type === 'pdf' ? 'export.pdf' : 'export.xlsx';

    //             const url = window.URL.createObjectURL(blob);
    //             const a = document.createElement('a');
    //             a.href = url;
    //             a.download = filename;
    //             document.body.appendChild(a);
    //             a.click();
    //             a.remove();
    //             window.URL.revokeObjectURL(url);
    //         },
    //         error: function (xhr, status, error) {
    //             alert('Export failed. Please try again.');
    //             console.error('AJAX error:', error);
    //         }
    //     });
    // }
</script>