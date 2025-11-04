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

<main id="page-content">
    <section class="fixed_asset">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div
                        class="row justify-content-between align-items-center bg-white border-bottom sticky-top shadow-sm">
                        <div class="col-md-11">
                            <h5 class="mt-2 mb-0">Nurse Station</h5>
                            <small>IPD / Nurse Station </small>
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
                                                        <div class="col-4">
                                                            <label class="col-form-label col-form-label-sm"
                                                                for="nurse_station_received">Nurse Station</label>
                                                        </div>

                                                        <div class="col-8">
                                                            <select class="form-control form-control-sm"
                                                                id="nurse_station_received"
                                                                name="nurse_station_received"
                                                                onchange="getReceivedPatient(true)">
                                                                @if (!empty($service_point))
                                                                    @foreach ($service_point as $item)
                                                                        <option value="{{ $item->serviceunit_no_pk }}">
                                                                            {{ $item->serviceunit_name }}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
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
                                                                    <th class="text-center" style="width:5%">Allergies
                                                                        Alert</th>
                                                                    <th class="text-center" style="width:5%">
                                                                        Vulnerability Alert</th>
                                                                    <th class="text-center" style="width:5%">Clinical
                                                                        Alert</th>
                                                                    <th class="text-center" style="width:5%">Bed No</th>
                                                                    <th class="text-left" style="width:13%">Patient Name
                                                                    </th>
                                                                    <th class="text-center" style="width:5%">UHID</th>
                                                                    <th class="text-center" style="width:8%">IP Date
                                                                    </th>
                                                                    <th class="text-center" style="width:4%">IP No</th>
                                                                    <th class="text-left" style="width:15%">Consultant
                                                                    </th>
                                                                    <th class="text-left" style="width:13%">Department
                                                                    </th>
                                                                    <th class="text-left" style="width:9%">Bed Category
                                                                    </th>
                                                                    <th class="text-center" style="width:10%">Action
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

                                        <!-- Receive Request -->
                                        <div class="tab-pane fade " id="receive_patient" role="tabpanel"
                                            aria-labelledby="receive-request">

                                            <div class="row justify-content-center position-center pt-1">

                                                <div class="col-6">
                                                    <div class="row">
                                                        <div class="col-4">
                                                            <label class="col-form-label col-form-label-sm"
                                                                for="nurse_station_receive">Nurse Station</label>
                                                        </div>

                                                        <div class="col-8">
                                                            <select class="form-control form-control-sm"
                                                                id="nurse_station_receive"
                                                                name="nurse_station_receive"
                                                                onchange="getReceivePatient(true)">
                                                                @if (!empty($service_point))
                                                                    @foreach ($service_point as $item)
                                                                        <option value="{{ $item->serviceunit_no_pk }}">
                                                                            {{ $item->serviceunit_name }}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="row">
                                                <div class="col-12">
                                                    <div style="padding-top:10px">
                                                        <div class="table-responsive">
                                                            <table
                                                                class="table table-striped table-bordered table-hover receive_patient_table">
                                                                <thead class="global-uhl-table-bg">
                                                                    <tr>
                                                                        <th class="text-center" style="width:3%">#SL
                                                                        </th>
                                                                        <th class="text-center" style="width:8%">Bed
                                                                            No</th>
                                                                        <th class="text-left" style="width:15%">
                                                                            Patient Name</th>
                                                                        <th class="text-center" style="width:5%">UHID
                                                                        </th>
                                                                        <th class="text-center" style="width:8%">IP
                                                                            Date</th>
                                                                        <th class="text-center" style="width:8%">IP No
                                                                        </th>
                                                                        <th class="text-left" style="width:15%">
                                                                            Consultant</th>
                                                                        <th class="text-left" style="width:15%">
                                                                            Department</th>
                                                                        <th class="text-left" style="width:9%">Bed
                                                                            Category</th>
                                                                        <th class="text-center" style="width:12%">
                                                                            Action</th>
                                                                    </tr>
                                                                </thead>

                                                                <tbody>
                                                                    <tr>
                                                                        <td colspan="10" class="text-center">Data
                                                                            Fetching ...</td>
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

        </div>
    </section>
</main>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script>
    $("body").addClass("sidebar-collapse");
    $(document).ready(function() {
        getReceivedPatient();
    })
</script>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function getReceivedPatient(search = null) {
        var receive_patient = $("#nurse_station_received").val();
        $("#nurse_station_receive").val(receive_patient);
        var received_patient = $("#nurse_station_receive").val();

        $.ajax({
            url: "{{ route('v2.ipd.nurse-station-received-patient') }}",
            method: "post",
            data: {
                nurse_station: received_patient
            },
            beforeSend: function() {
                if (search != null) {
                    blockUI();
                }
            },
            success: function(response) {
                console.log(response)
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

    function getReceivePatient(search = null) {

        var received_patient = $("#nurse_station_receive").val();
        $("#nurse_station_received").val(received_patient)

        var receive_patient = $("#nurse_station_received").val();
        $.ajax({
            url: "{{ route('v2.ipd.nurse-station-receive-patient-request') }}",
            method: "post",
            data: {
                nurse_station: receive_patient
            },
            beforeSend: function() {
                if (search != null) {
                    blockUI();
                }
            },
            success: function(response) {
                if (response.data.length != 0) {
                    setReceivePatient(response.data);
                } else {
                    emptyReceiveTable();
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
        $('.received_patient_table tbody').empty();

        var rows = [];
        if ($.fn.DataTable.isDataTable('.received_patient_table')) {
            $('.received_patient_table').DataTable().destroy();
        }

        var table = $('.received_patient_table').DataTable({
            searching: true,
            columnDefs: [{
                    targets: [0, 1, 2, 3, 4, 6, 7, 8],
                    className: 'text-center'
                },
                {
                    targets: [5, 9, 10, 11],
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
            button_group +=
                `<a href="{{ route('v2.ipd.emergency-nurse-note', '') }}/${item.admission_no_pk}" class="btn btn-outline-primary btn-sm bg-none cursor-pointer" data-id="${item.admission_no_pk}" id="admission_id" title="Nurse Note"><i class="fa fa-sticky-note"></i></a>`;
            button_group +=
                `<a href="{{ route('v2.ipd.emergency-nurse-note', '') }}/${item.admission_no_pk}" class="btn btn-outline-secondary btn-sm bg-none cursor-pointer" data-id="${item.admission_no_pk}" id="admission_id" title="Doctor Note"><i class="fa fa-user-md"></i></a>`;
            button_group +=
                `<a href="{{ route('v2.ipd.emergency-nurse-note', '') }}/${item.admission_no_pk}" class="btn btn-outline-success btn-sm bg-none cursor-pointer" data-id="${item.admission_no_pk}" id="admission_id" title="Physiotherapy Note"><i class="fa fa-sticky-note" aria-hidden="true"></i></a>`;
            button_group +=
                `<span id="btn_emr" class="btn btn-warning btn-sm bg-none cursor-pointer" data-id="${item.patient_no_fk}"><i class="fa fa-laptop-medical"></i> EMR</span>`;
            if (item.doc_department == 'EMERGENCY') {
                button_group +=
                    `<a href="{{ route('ipd.emergency-prescription', '') }}/${item.patient_code}/${item.admission_no_pk}/${item.primary_doctor_no_fk}" target="_blank" class="btn btn-outline-success btn-sm bg-none cursor-pointer" data-id="${item.admission_no_pk}" id="admission_id" title="Emergency Prescription"><i class="fa fa-prescription" aria-hidden="true"></i></a>`;
            }

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
                allergyCell,
                vulnerabilityCell,
                clinicalCell,
                item.bed_name,
                `<b>${item.patient_name}</b>`,
                item.patient_no_fk,
                admission_date,
                item.admission_uid,
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

    function setReceivePatient(data) {

        $('.receive_patient_table tbody').empty();

        var rows = [];
        if ($.fn.DataTable.isDataTable('.receive_patient_table')) {
            $('.receive_patient_table').DataTable().destroy();
        }

        var table = $('.receive_patient_table').DataTable({
            searching: true,
            columnDefs: [{
                    targets: [0, 1, 3, 4, 5, 9],
                    className: 'text-center'
                },
                {
                    targets: [2, 6, 7, 8],
                    className: 'text-left'
                }
            ],
            "lengthMenu": [
                [15, 25, 50, 75, 100, -1],
                [15, 25, 50, 75, 100, "All"]
            ],
            "pageLength": 15
        });

        data.forEach(function(item, index) {
            var admission_date = '';
            var button_group = '';

            if (item.admission_date != '') {
                var date = new Date(item.admission_date);
                var day = date.getDate();
                var month = date.getMonth() + 1;
                var year = date.getFullYear();
                admission_date = padZero(day) + "/" + padZero(month) + "/" + year;
            }




            button_group =
                `<button type="button" onclick="receivedPatient('${item.admission_no_pk}','${item.patient_no_fk}')" class="btn btn-sm btn-primary mr-1" Title="Receive Patient">Receive</button>`;
            button_group += `<a href="{{ route('ipd.admission-print-pdf', '') }}/${item.admission_no_pk}"
                                class="btn btn-outline-primary btn-sm bg-none cursor-pointer mr-1"
                                data-id="${item.admission_no_pk}" id="admission_id"
                                title="Admission request form"><i class="fa fa-file-pdf"></i></a>`;




            button_group += `<a href="{{ route('ipd.admission-label-print', '') }}/${item.admission_no_pk}"
                                class="btn btn-outline-primary btn-sm bg-none cursor-pointer"
                                data-id="${item.admission_no_pk}" id="admission_id" title="label Print"><i
                                    class="fa fa-tag"></i></a>`;

            button_group +=
                `<a  Class="btn btn-sm btn-info ml-2" href="{{ route('uhl.wristband-ipd-print', '') }}/${item.admission_no_pk}"  title="Wristband IPD" data-title="Wristband IPD " target="_blank"><i class="fas fa-band-aid" ></i></a>`;


            var rowData = [
                ++index,
                item.bed_name,
                `<b>${item.patient_name}</b>`,
                item.patient_no_fk,
                admission_date,
                item.admission_uid,
                item.primary_doctor_name,
                item.doc_department,
                item.ward_name,
                button_group
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
