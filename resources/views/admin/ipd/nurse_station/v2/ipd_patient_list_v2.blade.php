<style>
    .receive_patient_table>thead>tr>th {
        font-size: 15px !important;
    }

    .receive_patient_table>tbody>tr>td {
        font-size: 15px !important;
    }

    .received_patient_table>thead>tr>th {
        font-size: 15px !important;
    }

    .received_patient_table>tbody>tr>td {
        font-size: 15px !important;
    }

    .position-center {
        /* margin-bottom: -30px  */
    }
</style>
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">


<main id="page-content">
    <section class="fixed_asset">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div
                        class="row justify-content-between align-items-center bg-white border-bottom sticky-top shadow-sm">
                        <div class="col-md-11">
                            <h5 class="mt-2 mb-0">IPD Patient List</h5>
                            <small>IPD / IPD Patient List</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="tab-content p-0" id="myTabContent">
                                        <!-- Received Patient -->
                                        <div class="tab-pane fade show active" id="received_patient" role="tabpanel"
                                            aria-labelledby="received-patient">
                                            <div class="row justify-content-center position-center pt-1">

                                                <div class="col-6">
                                                    <div class="row">
                                                        <div class="col-8">
                                                            <label for="patient_id">Patient</label>
                                                            <input type="text" class="form-control" id="patient_id"
                                                                name="patient_id" placeholder="Patient ID/Name/Mobile"
                                                                title="Search By Patient ID/ Name/ Mobile" />
                                                            <input type="hidden" class="form-control"
                                                                id="hdn_patient_id" name="hdn_patient_id" />
                                                        </div>
                                                        <div class="col-md-3" style="text-align: left; margin-top:30px">
                                                            <button type="button" class="btn btn-success btn-md mb-2"
                                                                id="btnSearchReport">Search</button>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="table-responsive pt-2">
                                                        <table
                                                            class="table table-striped table-bordered table-hover received_patient_table">
                                                            <thead class="global-uhl-table-bg">
                                                                <tr>
                                                                    <th class="text-center" style="width:3%">#SL</th>

                                                                    <th class="text-center" style="width:5%">Bed No</th>
                                                                    <th class="text-left" style="width:13%">Patient Name
                                                                    </th>
                                                                    <th class="text-center" style="width:5%">Mobile No
                                                                    </th>
                                                                    <th class="text-center" style="width:5%">UHID</th>
                                                                    <th class="text-center" style="width:8%">IP Date
                                                                    </th>
                                                                    <th class="text-center" style="width:4%">IP No</th>
                                                                    <th class="text-center" style="width:13%">Nurse
                                                                        Station</th>
                                                                    <th class="text-left" style="width:15%">Consultant
                                                                    </th>
                                                                    <th class="text-left" style="width:13%">Department
                                                                    </th>
                                                                    <th class="text-left" style="width:9%">Bed Category
                                                                    </th>
                                                                    <th class="text-center" style="width:3%">Action
                                                                    </th>
                                                                </tr>
                                                            </thead>

                                                            <tbody>
                                                                <tr>
                                                                    <td colspan="13" class="text-center">Data Fetching
                                                                        ...</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- Patient Details Modal -->
    <div class="modal fade" id="patientDetailsModal" tabindex="-1" role="dialog" aria-labelledby="patientDetailsLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="patientDetailsLabel">Patient Details</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered table-striped">
                        <tbody>
                            <tr>
                                <th>Bed No</th>
                                <td id="detail-bed"></td>
                            </tr>
                            <tr>
                                <th>Patient Name</th>
                                <td id="detail-name"></td>
                            </tr>
                            <tr>
                                <th>Mobile No</th>
                                <td id="detail-mobile"></td>
                            </tr>
                            <tr>
                                <th>UHID</th>
                                <td id="detail-uhid"></td>
                            </tr>
                            <tr>
                                <th>IP Date</th>
                                <td id="detail-ipdate"></td>
                            </tr>
                            <tr>
                                <th>IP No</th>
                                <td id="detail-ipno"></td>
                            </tr>
                            <tr>
                                <th>Nurse Station</th>
                                <td id="detail-nurse"></td>
                            </tr>
                            <tr>
                                <th>Consultant</th>
                                <td id="detail-consultant"></td>
                            </tr>
                            <tr>
                                <th>Department</th>
                                <td id="detail-department"></td>
                            </tr>
                            <tr>
                                <th>Bed Category</th>
                                <td id="detail-category"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


</main>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>

<script type="text/javascript">
    openPatientAutocomplete('#patient_id');

    $('#btnSearchReport').on('click', function() {
        let patientCode = $('#hdn_patient_id').val();
        console.log("Patient Code:", patientCode);

        if (patientCode) {
            getReceivedPatient(patientCode);
        } else {
            getReceivedPatient(null);
        }
    });

    $('#patient_id').on('keypress', function(e) {
        if (e.which === 13) { 
            e.preventDefault();
            $('#btnSearchReport').click();
        }
    });
</script>

<script>
    $("body").addClass("sidebar-collapse");
    $(document).ready(function() {
        getReceivedPatient();
    })

    $(document).on("click", ".btn-details", function() {
        var patient = $(this).data("patient");

        // Fill modal fields
        $("#detail-bed").text(patient.bed_name || '');
        $("#detail-name").text(patient.patient_name || '');
        $("#detail-mobile").text(patient.contact_person_mobile || '');
        $("#detail-uhid").text(patient.patient_no_fk || '');
        $("#detail-ipdate").text(patient.admission_date || '');
        $("#detail-ipno").text(patient.admission_uid || '');
        $("#detail-nurse").text(patient.nurse_station || '');
        $("#detail-consultant").text(patient.primary_doctor_name || '');
        $("#detail-department").text(patient.doc_department || '');
        $("#detail-category").text(patient.ward_name || '');
        // Show modal
        $("#patientDetailsModal").modal("show");
    });
</script>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function getReceivedPatient(search = null) {
        $.ajax({
            url: "{{ route('v2.ipd.get-ipd-patient-list-v2') }}",
            method: "post",
            data: {
                patient_no: search
                // nurse_station: received_patient
            },
            beforeSend: function() {
                if (search != null) {
                    blockUI();
                }
            },
            success: function(response) {
                if (response.data.length != 0) {
                    setReceivedPatient(response.data);
                } else {
                    emptyTable();
                }
            },
            error: function(err) {
                var error = err.responseJSON;
                $('.common-modal-notify-error').modal('show');
                $('.common-modal-notify-error .modal-title').html('Failed');
                $('.common-modal-notify-error .modal-body').html(error.message);
            },
            complete: function() {
                $.unblockUI();
            }
        })
    }




    function setReceivedPatient(data) {
        console.log(data);
        $('.received_patient_table tbody').empty();

        var rows = [];
        if ($.fn.DataTable.isDataTable('.received_patient_table')) {
            $('.received_patient_table').DataTable().destroy();
        }

        var table = $('.received_patient_table').DataTable({
            searching: true,
            columnDefs: [{
                    targets: [0, 1, 3, 4, 5],
                    className: 'text-center'
                },
                {
                    targets: [2, 6, 7, 8, 9, 10, 11],
                    className: 'text-left'
                }
            ],
            "lengthMenu": [
                [15, 25, 50, 75, 100, -1],
                [15, 25, 50, 75, 100, "All"]
            ],
            "pageLength": 15
        });

        var button_group = ``;
        data.forEach(function(item, index) {
            var admission_date = '';

            if (item.admission_date != '') {
                var date = new Date(item.admission_date);
                var day = date.getDate();
                var month = date.getMonth() + 1;
                var year = date.getFullYear();
                admission_date = padZero(day) + "/" + padZero(month) + "/" + year;
            }

            button_group = ``;

            button_group += `
                <span class="btn btn-info btn-sm ml-1 btn-details" data-patient='${JSON.stringify(item)}'>
                    <i class="fa fa-info-circle"></i>
                </span>
            `;


            // button_group +=
            //     `<span id="btn_emr" class="btn btn-warning btn-sm bg-none cursor-pointer" data-id="${item.patient_no_fk}"><i class="fa fa-laptop-medical"></i> EMR</span>`;


            var allergyCell = item.allergy_alert == 1 ?
                '<div style="background-color:#ff8080;color:white;padding:4px;border-radius:3px;">Yes</div>' :
                'No';

            var vulnerabilityCell = item.vulnerability_alert == 1 ?
                '<div style="background-color:#ffff66;color:black;padding:4px;border-radius:3px;">Yes</div>' :
                'No';

            var clinicalCell = item.clinial_alert >= 4 ?
                '<div style="background-color:#ffad33;color:white;padding:4px;border-radius:3px;">Yes</div>' :
                'No';

            var rowData = [
                ++index,
                item.bed_name,
                `<b>${item.patient_name}</b>`,
                item.contact_person_mobile,
                item.patient_no_fk,
                admission_date,
                item.admission_uid,
                item.nurse_station,
                item.primary_doctor_name,
                item.doc_department,
                item.ward_name,
                button_group,
            ];
            rows.push(rowData);
        });
        table.clear();
        table.rows.add(rows);
        table.draw();

    }






    function emptyTable() {
        $('.received_patient_table tbody').empty();
        $('.received_patient_table tbody').append(`
                <tr>
                    <td colspan="13" class="text-danger text-center">Data Not Found</td>
                </tr>
            `);
    }

    function emptyReceiveTable() {
        $('.receive_patient_table tbody').empty();
        $('.receive_patient_table tbody').append(`
                <tr>
                    <td colspan="10" class="text-danger text-center">Data Not Found</td>
                </tr>
            `);
    }

    function padZero(number) {
        return number < 10 ? "0" + number : number;
    }


    $(document).on("click", "#btn_emr", function(e) {
        var hdn_patient_id = $(e.target).attr('data-id');
        if (hdn_patient_id == "") {
            $('.common-modal-notify-error').modal('show');
            $('.common-modal-notify-error .modal-title').html("Validation Error");
            $('.common-modal-notify-error .modal-body').html("You did not select any Patient");
            return;
        }

        window.open("{{ route('emr.patient-emr') }}/" + hdn_patient_id, "_blank");
    });
</script>
