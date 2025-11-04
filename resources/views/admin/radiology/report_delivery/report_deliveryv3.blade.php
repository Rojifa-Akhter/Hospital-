<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css')}}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">

<style>
    /* Soft Colors & Table Styling */
    body {
        background: #f7f9fc;
        font-family: Arial, sans-serif;
    }

    .search-card {
        background: #ffffff;
        border-radius: 8px;
        padding: 15px;
        box-shadow: 0 1px 5px rgba(0, 0, 0, 0.1);
        /* margin-bottom: 20px; */
    }

    .report-buttons button {
        min-width: 180px;
        margin-right: 10px;
    }

    .report-section {
        background: #fff;
        padding: 15px;
        border-radius: 8px;
        box-shadow: 0 1px 5px rgba(0, 0, 0, 0.05);
        margin-bottom: 20px;
    }

    #loadingSpinner {
        display: none;
        text-align: center;
        margin: 20px 0;
    }

    table.dataTable thead {
        background: #e9ecef;
    }

    table.dataTable tbody tr:hover {
        background-color: #f1f8ff;
    }

    #radiologyTable th,
    #radiologyTable td {
        vertical-align: middle;
        text-align: center;
    }

    #radiologyTable th:first-child,
    #radiologyTable td:first-child {
        width: 40px;
    }

    #radiologyTable th:nth-child(2),
    #radiologyTable td:nth-child(2) {
        width: 50px;
    }

    #radiologyTable th:nth-child(11),
    #radiologyTable td:nth-child(11) {
        width: 90px;
    }
</style>

<!-- HTML -->
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row align-items-center bg-white border-bottom shadow-sm sticky-top py-2 px-3">
        <div class="col-md-8">
            <h5 class="mb-0">Report Delivery</h5>
            <small>Search and view patient reports</small>
        </div>

        <!-- Due Reminder Section -->

        <div id="dueReminder" class="alert alert-warning d-none col-md-4 text-center text-danger">
            Total Due Amount: <span id="dueAmount"></span>
        </div>

    </div>


    <!-- Search Form -->
    <div class="row justify-content-center mt-3">
        <div class="col-md-12">
            <form id="searchForm" class="search-card form-row align-items-end">
                @csrf
                <!-- <div class="col-md-2">
                    <label>UHID</label>
                    <input type="hidden" id="hdn_patient_id" name="hdn_patient_id">
                    <input type="text" class="form-control form-control-sm" id="service_number" name="service_number" placeholder="Patient ID">
                </div> -->
                <div class="col-md-3">
                    <label>Admission No</label>
                    <input type="text" class="form-control form-control-sm" id="admission_no" name="admission_no" placeholder="Admission No">
                    <input type="hidden" id="hdn_admission_id" name="hdn_admission_id">
                </div>
                <div class="col-md-4">
                    <label>Date</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">From</div>
                        </div>
                        <input type="text" class="form-control form-control-sm date_picker" id="search_date_from" name="search_date_from" placeholder="dd-mm-yyyy">
                        <div class="input-group-prepend">
                            <div class="input-group-text">To</div>
                        </div>
                        <input type="text" class="form-control form-control-sm date_picker" id="search_date_to" name="search_date_to" placeholder="dd-mm-yyyy">
                    </div>
                </div>
                <div class="col-md-3">
                    <label class="text-danger">Invoice No <span class="text-danger">*</span></label>
                    <input type="text" class="form-control form-control-sm" id="invoice_id" name="invoice_id" placeholder="Invoice No" required>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-success btn-block" id="btnSearch">Search</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Toggle Buttons -->
    <div class="row mt-3">
        <div class="col-md-12 report-buttons text-center">
            <button class="btn btn-outline-primary" id="btnPathology"><i class="fa fa-vials"></i> Pathology Reports</button>
            <button class="btn btn-outline-info" id="btnRadiology"><i class="fa fa-x-ray"></i> Radiology Reports</button>
        </div>
    </div>

    <!-- Loading Spinner -->
    <div class="row">
        <div class="col-md-12" id="loadingSpinner">
            <div class="spinner-border text-primary" role="status"></div>
            <p>Loading reports...</p>
        </div>
    </div>

    <div class="row mt-3" id="welcomeImageSection">
        <div class="col-md-12 text-center">
            <img src="{{asset('images/reportdelivery.png')}}" alt="Search Reports Placeholder" class="img-fluid" style="width: 200px;;">
            <p class="text-danger mt-2">Enter Invoice No. above to view reports</p>
        </div>
    </div>

    <!-- Report Sections -->
        <div class="col-md-12">
            <div class="report-section d-none" id="pathologyWrapper">
            <div class="card shadow-sm mb-3 border-primary">
                    <div class="card-header d-flex justify-content-between align-items-center bg-primary text-white">
                        <!-- Left: Title -->
                        <h5 class="mb-0 col-md-10">
                            <i class="fa fa-x-ray me-2"></i> Pathology Reports
                        </h5>

                        <!-- Right Side: Action Buttons -->
                        <div id="pathActions" class="d-flex gap-2">
                            <button type="button" id="printSelected" class="btn btn-sm btn-warning d-none">
                                <i class="fa fa-print me-1"></i> Print Selected
                            </button>
                            <!-- You can add more buttons here in future -->
                        </div>
                    </div>

                    <div class="table-responsive ">
                        <table id="pathologyTable" class="table table-bordered table-sm" width="100%">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" id="selectAll" checked></th>
                                    <th>#</th>
                                    <th>Invoice Code</th>
                                    <th>Admission ID</th>
                                    <th>Patient Name</th>
                                    <th>Doctor</th>
                                    <th>Test Name</th>
                                    <th>Status</th>
                                    <th>Mobile</th>
                                    <th>SMS</th>
                                    <th>Mail</th>
                                    <th>Print</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="report-section d-none" id="radiologyWrapper">
                <div class="card shadow-sm mb-3 border-primary">
                    <div class="card-header d-flex justify-content-between align-items-center bg-primary text-white">
                        <!-- Left: Title -->
                        <h5 class="mb-0">
                            <i class="fa fa-x-ray me-2"></i> Radiology Reports
                        </h5>

                        <!-- Right: Action Buttons -->
                        <div class="d-flex gap-2" id="radiologyActions">
                            <button type="button" id="printSelectedRadiology" class="btn btn-sm btn-warning d-none">
                                <i class="fa fa-print me-1"></i> Print Selected
                            </button>
                            <!-- "Name Email" button will be appended here dynamically -->
                        </div>
                    </div>

                    <div class="card-body p-2">
                        <div class="table-responsive">
                            <table id="radiologyTable" class="table table-bordered table-striped table-sm mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th><input type="checkbox" id="selectAllRadiology" checked /></th>
                                        <th>Patient Name</th>
                                        <th>Invoice Code</th>
                                        <th>Admission No</th>
                                        <th>Test Name</th>
                                        <th>Received By</th>
                                        <th>Delivered By</th>
                                        <th>Status</th>
                                        <th>SMS</th>
                                        <th>Mail</th>
                                        <th>Print</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
</div>

<!-- JS -->
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js')}}"></script>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script>
    $(document).ready(function() {
        openInvoiceAutocomplete("#invoice_id");
        openAdmissionAutocomplete('#admission_no', 'patient_name');
        $("body").addClass("sidebar-collapse");

        // Initialize datepicker
        $('.date_picker').datepicker({
            todayHighlight: true,
            autoclose: true,
            clearBtn: true,
            endDate: '+0d',
            format: 'dd-mm-yyyy'
        });

        let pathologyTable = null;
        let radiologyTable = null;

        // Pass session value to JS
        const emailSendInd = {{ Session::get('user.email_send_ind', 0)}};

        // -----------------------------
        // Pathology Table
        // -----------------------------
        function initPathologyTable() {
            pathologyTable = $('#pathologyTable').DataTable({
                serverSide: true,
                processing: true,
                destroy: true,
                pageLength: 10,
                ajax: {
                    url: "{{ route('report-delivery.pathology') }}",
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('input[name="_token"]').val()
                    },
                    data: function(d) {
                        d.service_number = $('#service_number').val();
                        d.admission_no = $('#admission_no').val();
                        d.hdn_admission_id = $('#hdn_admission_id').val();
                        d.search_date_from = $('#search_date_from').val();
                        d.search_date_to = $('#search_date_to').val();
                        d.invoice_id = $('#invoice_id').val();
                    },
                    dataSrc: function(json) {
                        return json.data.map((row, index) => {
                            const dueAmt = json.total_due || 0;
                            let dueReminder = '';
                            if (dueAmt > 0) {
                                console.log(dueAmt)
                                $('#dueAmount').text(dueAmt.toFixed(2));
                                $('#dueReminder').removeClass('d-none');
                                $('#printSelected').addClass('d-none');
                                $('#nameEmailBtnPath').remove();
                            } else {
                                $('#dueReminder').addClass('d-none');
                                $('#printSelected').removeClass('d-none');
                               
                                 if ($('#nameEmailBtnPath').length === 0) {
                                    const nameEmailBtnPath = `
                                        <button type="button" id="nameEmailBtnPath" class="btn btn-sm btn-info ml-2">
                                            <i class="fa fa-envelope me-1"></i> Email All Report
                                        </button>`;
                                    
                                    // Append after the print button
                                    $('#pathActions').parent().append(nameEmailBtnPath);
                                }
                            }

                            // Status badge
                            let result_status = '';
                            if (row.lab_result_final_key_ind == 1) result_status = '<span class="badge bg-success">Finalized</span>';
                            else if (row.lab_result_verify_key_ind == 1) result_status = '<span class="badge bg-primary">Verified</span>';
                            else if (row.lab_result_prepared_key_ind == 1) result_status = '<span class="badge bg-warning text-dark">Prepared</span>';
                            else result_status = '<span class="badge bg-secondary">Pending</span>';

                            // Urgent row color
                            const rowClass = (row.delivery_status_no == 2) ? 'bg-warning text-black' : '';

                            // Print button
                            let print_button = '';

                                // --- Print Button ---
                                if (dueAmt <= 0 && row.report_url && row.report_no_fk) {
                                    print_button += `<a href="${row.print_url}" class="btn btn-sm btn-warning me-1" target="_blank">Print</a>`;
                                } else {
                                    print_button += `<span class="badge bg-danger me-1">Please clear Due Bill First</span>`;
                                }

                                // --- Delivery Button ---
                                if (row.report_delivered_ind == 1) {
                                    // Already delivered → green button
                                    print_button += `
                                        <span class="btn btn-outline-success btn-md"
                                            data-url="${row.delivery_url}"
                                            data-report_id="${row.report_no_fk}">
                                            <i class="fa fa-arrow-right"></i>
                                        </span>
                                    `;
                                } else {
                                    // Not delivered → red button if due is cleared or admission exists
                                    if (dueAmt <= 0 || row.admission_no_pk != '') {
                                        print_button += `
                                            <span class="btn btn-outline-danger btn-md"
                                                data-delivery_ind="${row.report_delivered_ind}"
                                                data-report_id="${row.report_no_fk}"
                                                data-url="${row.delivery_url}"
                                                onclick="deliveryUpdate(this)">
                                                <i class="fa fa-arrow-right"></i>
                                            </span>
                                        `;
                                    }
                                }
                            // let print_button = `<span class="badge bg-danger">Please clear Due Bill First</span>`;
                            // if (dueAmt <= 0 && row.report_url && row.report_no_fk) {
                            //     print_button = `<a href="${row.print_url}" class="btn btn-sm btn-warning" target="_blank">Print</a>`;
                            // }

                            // SMS button
                            let sms_button = '';
                            if (row.mobile1 && row.sms_ind == 1 && (dueAmt <= 0 || row.admission_no_pk != '')) {
                                const sendUrl = "{{ route('send-sms-lab-report') }}";
                                const invoiceDate = row.invoice_date ? row.invoice_date_formatted : '';
                                const downloadUrl = 'http://115.127.139.2:8085/h360_uhl/public/patient-portal/login';
                                const smsText = `Radiology Report (Invoice: ${row.invoice_code} dated ${invoiceDate}) is ready. Download from: ${downloadUrl}. UHID: ${row.patient_code}, Mobile: ${row.mobile1}. Helpline: {{ Session::get('user.hospital_telephone1') }}`;
                                const btnClass = row.sms_ind == 1 ? 'btn-outline-success' : 'btn-outline-info';
                                sms_button = `<button type="button" class="btn btn-sm ${btnClass} bg-none cursor-pointer" onclick="pathologyFunc.sendLabReportSms(this,'${row.mobile1}','${smsText}','${row.invoice_no_fk}','${sendUrl}')"><i class="fa fa-paper-plane"></i></button>`;
                            }

                            // Mail button
                            let mail_button = '';
                            if (row.email && emailSendInd == 1 && (dueAmt <= 0 || row.admission_no_pk != '')) {
                                const sendUrl = "{{ route('send-mail-lab-report') }}";
                                const btnClass = row.mail_ind == 1 ? 'btn-outline-success' : 'btn-outline-info';
                                mail_button = `<button type="button" class="btn btn-sm ${btnClass} bg-none cursor-pointer" onclick="pathologyFunc.sendLabReportMail(this,'${row.patient_no_fk}','${row.report_no_fk}','${sendUrl}')"><i class="fa fa-envelope"></i></button>`;
                            }

                            const due_amount = `<span class="text-danger">(${dueAmt})</span>`;

                            return {
                                select_checkbox: `<input type="checkbox" class="rowSelect" value="${row.report_no_fk}" checked/>`,
                                DT_RowIndex: index + 1,
                                invoice_code: row.invoice_code,
                                admission_no_pk: row.admission_no_pk,
                                patient_name: row.patient_name,
                                doctor_name: row.doctor_name,
                                test_name: row.item_name,
                                result_status: result_status,
                                mobile: row.mobile1,
                                due_amount: due_amount,
                                report_url: row.report_url,
                                sms_button: sms_button,
                                mail_button: mail_button,
                                print_button: print_button,
                                rowClass: rowClass
                            };
                        });
                    }
                },
                columns: [{
                        data: 'select_checkbox',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'invoice_code'
                    },
                    {
                        data: 'admission_no_pk'
                    },
                    {
                        data: 'patient_name'
                    },
                    {
                        data: 'doctor_name'
                    },
                    {
                        data: 'test_name'
                    },
                    {
                        data: 'result_status'
                    },
                    {
                        data: 'mobile'
                    },
                    {
                        data: 'sms_button',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'mail_button',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'print_button',
                        orderable: false,
                        searchable: false
                    }
                ],
                rowCallback: function(row, data) {
                    if (data.rowClass) $(row).addClass(data.rowClass);
                }
            });

            // Select all/deselect all
            $('#selectAll').on('click', function() {
                const checked = $(this).prop('checked');
                $('.rowSelect').prop('checked', checked);
            });

            // Print selected
            $('#printSelected').off('click').on('click', function() {
                let selectedReports = [];
                $('.rowSelect:checked').each(function() {
                    selectedReports.push($(this).val());
                });

                if (selectedReports.length === 0) {
                    alert('Please select at least one report');
                    return;
                }

                // Open batch print route
                const printUrl = "{{ route('pathology.batch-print') }}?reports=" + selectedReports.join(',');
                window.open(printUrl, '_blank');
            });
        }



        $(document).on('click', '#nameEmailBtnPath', function () {
                    let selected = [];

                    $('.rowSelect:checked').each(function () {
                        selected.push($(this).val());
                    });

                    if (selected.length === 0) {
                        alert("Please select at least one report!");
                        return;
                    }

                    // Confirm email sending
                    if (!confirm("Send selected reports via email?")) return;

                    // Send AJAX request
                    $.ajax({
                        url: "{{ route('pathology.reports.emailMultiple') }}",
                        method: "POST",
                        data: {
                            ids: selected,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function (response) {
                            alert("Email sent successfully!");
                            // Optionally disable checkboxes or show a status
                        },
                        error: function (xhr, status, error) {
                            alert("Something went wrong while sending emails.");
                            console.error(xhr.responseText);
                        }
                    });
                });

               


        // -----------------------------
        // Radiology Table
        // -----------------------------
        function initRadiologyTable() {
            let table = $('#radiologyTable').DataTable({
                serverSide: true,
                processing: true,
                destroy: true,
                pageLength: 10,
                ajax: {
                    url: "{{ route('report-delivery.radiology') }}",
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('input[name="_token"]').val()
                    },
                    data: function(d) {
                        d.service_number = $('#service_number').val();
                        d.hdn_patient_id = $('#hdn_patient_id').val();
                        d.admission_no = $('#admission_no').val();
                        d.hdn_admission_id = $('#hdn_admission_id').val();
                        d.search_date_from = $('#search_date_from').val();
                        d.search_date_to = $('#search_date_to').val();
                        d.invoice_id = $('#invoice_id').val();
                    },
                    dataSrc: function(json) {
                        return json.data.map((row, index) => {


                            const dueAmt = json.totalDue || 0;
                            let dueReminder = '';
                            if (dueAmt > 0) {
                                $('#dueAmount').text(dueAmt.toFixed(2));
                                $('#dueReminder').removeClass('d-none');
                                $('#printSelectedRadiology').addClass('d-none');                               
                            } else {                               
                                $('#dueReminder').addClass('d-none');
                                $('#printSelectedRadiology').removeClass('d-none');
                                 if ($('#nameEmailBtn').length === 0) {
                                    const nameEmailBtn = `
                                        <button type="button" id="nameEmailBtn" class="btn btn-sm btn-info ml-2">
                                            <i class="fa fa-envelope me-1"></i> Email All Report
                                        </button>`;
                                    
                                    $('#radiologyActions').append(nameEmailBtn);
                                }
                                // $('#nameEmailBtn').remove();
                            }




                            let statusBadge = row.finalize_key_ind ? '<span class="badge bg-success">Finalized</span>' :
                                row.verify_key_ind ? '<span class="badge bg-primary">Verified</span>' :
                                row.result_prepared_key_ind ? '<span class="badge bg-warning text-dark">Prepared</span>' :
                                '<span class="badge bg-secondary">Pending</span>';

                            // // SMS button
                            // let sms_button = '';
                            // if (row.mobile1 && row.sms_ind == 1 && (dueAmt <= 0 || row.admission_no_pk != '')) {
                            //     const sendUrl = "{{ route('send-sms-lab-report') }}";
                            //     const invoiceDate = row.invoice_date ? row.invoice_date_formatted : '';
                            //     const downloadUrl = 'http://115.127.139.2:8085/h360_uhl/public/patient-portal/login';
                            //     const smsText = `Radiology Report (Invoice: ${row.invoice_code} dated ${invoiceDate}) is ready. Download from: ${downloadUrl}. UHID: ${row.patient_code}, Mobile: ${row.mobile1}. Helpline: {{ Session::get('user.hospital_telephone1') }}`;
                            //     const btnClass = row.sms_ind == 1 ? 'btn-outline-success' : 'btn-outline-info';
                            //     sms_button = `<button type="button" class="btn btn-sm ${btnClass} bg-none cursor-pointer" onclick="pathologyFunc.sendLabReportSms(this,'${row.mobile1}','${smsText}','${row.invoice_no_fk}','${sendUrl}')"><i class="fa fa-paper-plane"></i></button>`;
                            // }

                            // // Mail button
                            // let mail_button = '';
                            // if (row.email && emailSendInd == 1 && (dueAmt <= 0 || row.admission_no_pk != '')) {
                            //     const sendUrl = "{{ route('send-mail-lab-report') }}";
                            //     const btnClass = row.mail_ind == 1 ? 'btn-outline-success' : 'btn-outline-info';
                            //     mail_button = `<button type="button" class="btn btn-sm ${btnClass} bg-none cursor-pointer" onclick="pathologyFunc.sendLabReportMail(this,'${row.patient_no_fk}','${row.report_no_fk}','${sendUrl}')"><i class="fa fa-envelope"></i></button>`;
                            // }

                            let print_button = `<span class="badge bg-danger">Please clear Due Bill First</span>`;
                            let admitted = row.admission_no_pk !== '';
                            if (dueAmt < 0) {
                                print_button = `<a class="btn btn-sm btn-warning text-black" 
                                    href="{{ url('radiology/rad-report-pdf') }}/${row.radinvoicedtl_no_pk}" 
                                    target="_blank">Print</a>`;
                            }
                            if (admitted != null) {
                                print_button = `<a class="btn btn-sm btn-warning text-black" 
                                    href="{{ url('radiology/rad-report-pdf') }}/${row.radinvoicedtl_no_pk}" 
                                    target="_blank">Print</a>`;
                                // $('#printSelectedRadiology').removeClass('d-none');
                            }

                            return {
                                DT_RowIndex: index + 1,
                                select_checkbox: `<input type="checkbox" class="radiologyCheckbox" value="${row.radinvoicedtl_no_pk}" checked />`,
                                patient_name: row.patient_name,
                                invoice_code: row.invoice_code,
                                admission_no_pk: row.admission_no_pk,
                                item_name: row.item_name,
                                receive_by: row.ic_image_capture_keyed_time || '-',
                                delivery_by: row.delivery_dttm || '-',
                                status: statusBadge,
                                sms_button: '',
                                mail_button: '',
                                print_button: print_button
                            };
                        });
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'select_checkbox',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'patient_name'
                    }, {
                        data: 'invoice_code'
                    },
                    {
                        data: 'admission_no_pk'
                    },
                    {
                        data: 'item_name'
                    },
                    {
                        data: 'receive_by'
                    },
                    {
                        data: 'delivery_by'
                    },
                    {
                        data: 'status',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'sms_button',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'mail_button',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'print_button',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            // Select All Checkbox
            $('#selectAllRadiology').on('click', function() {
                $('.radiologyCheckbox').prop('checked', this.checked);
            });

          // Print Selected Reports
            $('#printSelectedRadiology').off('click').on('click', function() {
                let selected = [];
                $('.radiologyCheckbox:checked').each(function() {
                    selected.push($(this).val());
                });

                if (selected.length === 0) {
                    alert("Please select at least one report!");
                    return;
                }

                let url = "{{ route('radiology.reports.printMultiple') }}?ids=" + selected.join(",");
                window.open(url, "_blank");
            });


            $(document).on('click', '#nameEmailBtn', function () {
                    let selected = [];

                    $('.radiologyCheckbox:checked').each(function () {
                        selected.push($(this).val());
                    });

                    if (selected.length === 0) {
                        alert("Please select at least one report!");
                        return;
                    }

                    // Confirm email sending
                    if (!confirm("Send selected reports via email?")) return;

                    // Send AJAX request
                    $.ajax({
                        url: "{{ route('radiology.reports.emailMultiple') }}",
                        method: "POST",
                        data: {
                            ids: selected,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function (response) {
                            alert("Email sent successfully!");
                            // Optionally disable checkboxes or show a status
                        },
                        error: function (xhr, status, error) {
                            alert("Something went wrong while sending emails.");
                            console.error(xhr.responseText);
                        }
                    });
                });


            return table;
        }




        // -----------------------------
        // Button Clicks
        // -----------------------------
        $('#btnRadiology').click(function() {
            $('#welcomeImageSection').fadeOut();
            if ($('#hdn_admission_id').val() === '') {
                if ($('#invoice_id').val() === '') {
                    alert('Please give an Invoice ID');
                    $('#invoice_id').focus();
                    return;
                }
            }

            $('#radiologyWrapper').removeClass('d-none');
            $('#pathologyWrapper').addClass('d-none');
            if (radiologyTable) radiologyTable.ajax.reload();
            else initRadiologyTable();
        });

        $('#btnPathology').click(function() {
            $('#welcomeImageSection').fadeOut();
            if ($('#hdn_admission_id').val() === '') {
                if ($('#invoice_id').val() === '') {
                    alert('Please give an Invoice ID');
                    $('#invoice_id').focus();
                    return;
                }
            }
            $('#pathologyWrapper').removeClass('d-none');
            $('#radiologyWrapper').addClass('d-none');
            if (pathologyTable) pathologyTable.ajax.reload();
            else initPathologyTable();
        });

        $('#btnSearch').click(function() {
            $('#welcomeImageSection').fadeOut();
            $('#pathologyWrapper, #radiologyWrapper').addClass('d-none');
            $('#loadingSpinner').show();
            initPathologyTable();
            $('#pathologyWrapper').removeClass('d-none');
            $('#loadingSpinner').hide();
        });

        // Print buttons
        $('#printPathology, #printRadiology').click(function() {
            window.print();
        });
    });
     function deliveryUpdate(element) {
                    if (confirm("Are you sure?")) {
                        let report_id = $(element).data('report_id');

                        $.ajax({
                            data: {
                                report_id: report_id,
                            },
                            url: "{{ route('report-delivery-from-list') }}",
                            type: "post",
                            beforeSend: function() {
                                blockUI();
                            },
                            success: function(data) {
                                // Refresh search results
                                $('#searchResult').click();

                                // Trigger pathology tab after save
                                $('#btnPathology').click();
                            },
                            complete: function() {
                                $.unblockUI();
                            }
                        });
                    }
                }

</script>