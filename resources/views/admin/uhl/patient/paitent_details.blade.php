<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">

<main id="page-content">
    <link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}">
    <form action="#">
        <section class="paitent__registration_details">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row bg-white border-bottom sticky-top shadow-sm">
                            <div class="col-md-12 mb-1">
                                <h5 class="mt-2 mb-0">Patient Details</h5>
                                <small>Patient / Patient Details</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 col-lg-12">
                        <form action="{{ route('patient-print', 'PDF') }}" method="POST" id="patient-search"
                            target="_blank">
                            @csrf
                            <div class="card">
                                <div class="card-header">
                                    <div class="form-row align-items-center">
                                        <div class="col-lg-4 col-md-12">
                                            <div class="form-group form-row">
                                                <label for="facility__type"
                                                    class="col-sm-4 col-form-label">Facility</label>
                                                <div class="col-sm-8">
                                                    <select class="form-control form-control-sm" id="facility__type"
                                                        name="facility__type">
                                                        <option value="">UHL Hospital</option>
                                                        <option value=""></option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="card-body border-bottom-3 p-2">
                                    <div class="form-row">
                                        <div class="col-lg-3 col-md-6 col-12">
                                            <div class="form-group form-row">
                                                <label for="uhid_" class="col-sm-4 col-form-label">UHID /
                                                    Name</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control form-control-sm" id="uhid" name="uhid" placeholder="" />
                                                        <input type="hidden" class="form-control" id="hdn_patient_id" name="hdn_patient_id" value="">
                                                </div>
                                            </div>
                                        </div>

                                        <!-- mother uhid(when baby select than show this input field)  -->
                                        <!-- <div class="col-lg-3 col-md-6 col-12">
                                    <div class="form-group form-row">
                                        <label for="mother_uhid" class="col-sm-4 col-form-label">Mother UHID</label>
                                       <div class="col-sm-8">
                                           <input type="text" class="form-control form-control-sm" id="mother_uhid" name="mother_uhid" placeholder="" />
                                       </div>
                                    </div>
                                </div> -->
                                        <!-- mother uhid  -->

                                        <!-- <div class="col-lg-3 col-md-6 col-12">
                                            <div class="form-group form-row">
                                                <label for="patient_name" class="col-sm-4 col-form-label">Patient
                                                    Name</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="patient_name" name="patient_name" placeholder="" />
                                                </div>
                                            </div>
                                        </div> -->

                                        <!-- <div class="col-lg-3 col-md-6 col-12">
                                            <div class="form-group form-row">
                                                <label for="patient_type" class="col-sm-4 col-form-label">Reg
                                                    Type</label>
                                                <div class="col-sm-8">
                                                    <select class="form-control form-control-sm" id="patient_type"
                                                        name="patient_type">
                                                        <option value="">Select</option>
                                                        @if (!empty($pat_type))
                                                            @foreach ($pat_type as $pat)
                                                                <option value="{{ $pat->patient_type_no_pk }}"
                                                                    data-attr="{{ strtoupper($pat->patient_type_code) }}">
                                                                    {{ $pat->patient_type_code }}</option>
                                                            @endforeach

                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                        </div> -->



                                        <div class="col-lg-6 col-md-6 col-12">
                                            <div class="form-group form-row">
                                                <label for="address" class="col-sm-3 col-form-label">Address</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="address" name="address" placeholder="" />
                                                </div>
                                            </div>
                                        </div>



                                        <div class="col-lg-3 col-md-6 col-12 d-none">
                                            <div class="form-group form-row">
                                                <label for="dob_" class="col-sm-4 col-form-label">DOB</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="dob_" name="dob_" placeholder="" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-md-6 col-12  d-none">
                                            <div class="form-group form-row">
                                                <label for="guardian_name" class="col-sm-4 col-form-label">Guardian
                                                    Name</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="guardian_name" name="guardian_name" placeholder="" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-md-6 col-12  d-none">
                                            <div class="form-group form-row">
                                                <label for="emp_" class="col-sm-4 col-form-label">EMP #</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="emp_" name="emp_" placeholder="" />
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                    <div class="form-row">
                                    <div class="col-lg-3 col-md-6 col-12">
                                            <div class="form-group form-row">
                                                <label for="mobile_number" class="col-sm-4 col-form-label">Mobile
                                                    #</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="mobile_number" name="mobile_number" placeholder="" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-1 col-md-1 col-1">
                                            <div class="form-group form-row">
                                                <button type="button" id="searchPatient"
                                                    class="btn btn-success uhl_common_btn btn-md btn-block btn-md-global"><i
                                                        class="fa fa-search"></i>
                                                    Search</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h5>Registered Patient List</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover table-striped data-table  ">
                                        <thead class="global-uhl-table-bg">
                                            <tr>
                                                <th></th>
                                                <th>UHID</th>
                                                <th>Patient Name</th>
                                                <th>DOB</th>
                                                <th>Age/Gender</th>
                                                <th>Company</th>
                                                <th>Mobile #</th>
                                                <th>Patient Address</th>
                                                <th>Guardian Name</th>
                                                <th>Reg. Type</th>
                                                <th>Print Count</th>
                                                <th style="width:100px!important">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </section>
    </form>
</main>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>

<script>
    openPatientAutocomplete('#uhid');
    $(document).ready(function() {

        var searchdata = $('#patient-search').serialize();
        // ,
        //             searchdata: searchdata
        var datatable = $('.data-table').DataTable({
            "searching": true,
            "processing": true,
            "serverSide": true,
            // "searchable": true,

            "order": [
                [0, "desc"]
            ],
            "language": {
                "infoFiltered": ""
            },

            "ajax": {
                "url": "{{ url('hospital-patient-list') }}",
                "dataType": "json",
                "type": "POST",
                "data": {
                    _token: "{{ csrf_token() }}"
                }
            },
            "columnDefs": [{
                    "targets": 3,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {
                        return new Date(row[3]).toLocaleDateString('en-GB');


                    }
                },
                {
                    "targets": 4,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {
                        var ccm_client_name = row[15] != null ? "" + row[15] + "/" : "";
                        var ccm_client_code = row[4] != null ? row[4] : "";

                        return ccm_client_name + ccm_client_code;
                    }
                },
                {
                    "targets": 5,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {
                        var ccm_client_name = row[10] != null ?
                            " <strong> Corporate Name : </strong> " + row[10] : "";
                        var ccm_client_code = row[11] != null ?
                            "<br><strong> Corporate Code : </strong>" + row[11] : "";
                        var contact_person = row[12] != null ?
                            "<br> <strong> Contact Person : </strong>" + row[12] : "";
                        var contact_no = row[13] != null ?
                            "<br> <strong>Contact No :</strong> " + row[13] : "";
                        var contract_sign_date = row[14] != null ?
                            "<br> <strong>Contact Singing Date : </strong>" + row[14] : "";

                        return ccm_client_name + ccm_client_code + contact_person + contact_no;
                    }
                },
                {
                    "targets": 6,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {


                        return row[5];
                    }
                },
                {
                    "targets": 7,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {


                        return row[6];
                    }
                },
                {
                    "targets": 8,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {


                        return '';
                    }
                },
                {
                    "targets": 9,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {


                        return  row[16];
                    }
                },
                {
                    "targets": 10,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {


                        return  row[17];
                    }
                },
                {
                    "targets": -1,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {

                        var show_action = '{{ route('registration.show', ':id') }}';
                        show_action = show_action.replace(':id', row[0]);

                        var edit_action = '{{ route('registration.edit', ':id') }}';
                        edit_action = edit_action.replace(':id', row[0]);

                        var card_action = '{{ route('patient-card', ':id') }}';
                        card_action = card_action.replace(':id', row[0]);

                        return '<span  Class="btn btn-sm btn-dark open-modal" data-id="' + row[
                                0] + '" data-action="' + show_action +
                            '" data-modal="common-modal" data-title="View Patient Information" title="View Patient Information"><i class="fa fa-eye"></i></span>&nbsp;<span  Class="btn btn-sm btn-primary open-modal" data-id="' +
                            row[0] + '" data-action="' + edit_action +
                            '" data-modal="common-modal-md" data-title="Edit Patient Information" title="Edit Patient Information"><i class="fa fa-pencil-alt"></i></span>&nbsp;<span  Class="btn btn-sm btn-success open-modal" data-id="' +
                            row[0] + '" data-action="' + card_action +
                            '" data-modal="common-modal-sm" title="Card" data-title="Membership Card"><i class="fa fa-address-card "></i></span>';
                    }
                },
                {
                    "targets": 0,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {


                        return `${meta.row + 1}`;
                    }
                },
            ]
        });

        $(document).on('click', '#searchPatient', function() {

            // var formID = $("#patient-search").attr("id");
            // var formMethod = $("#frmSearch").attr("method");
            $('.data-table').empty();
            $('.data-table').DataTable().destroy();

            var searchdata = $('#patient-search').serialize();

            var datatable = $('.data-table').DataTable({
                "searching": false,
                "processing": true,
                "serverSide": true,
                "order": [
                    [0, "desc"]
                ],
                "ajax": {
                    "url": "{{ url('hospital-patient-search') }}",
                    "dataType": "json",
                    "type": "POST",

                    data: {
                        hdn_patient_id: $('input[name="hdn_patient_id"]').val(),
                        patient_name: $('input[name="patient_name"]').val(),
                        patient_gender: $('#patient_gender').val(),
                        patient_age: $('#patient_age').val(),
                        patient_nid: $('#patient_nid').val(),
                        patient_marital_status: $('#patient_marital_status').val(),
                        patient_religion: $('#patient_religion').val(),
                        patient_status: $('#patient_status').val(),
                        patient_blood: $('#patient_blood').val(),
                        patient_type: $('#patient_type').val(),
                        corporate_name: $('#corporate_name').val(),
                        mobile_number: $('#mobile_number').val(),
                        address: $('#address').val(),
                    }
                },
                "columnDefs": [{
                        "targets": 3,
                        "data": "Edit",
                        "render": function(data, type, row, meta) {
                            return new Date(row[3]).toLocaleDateString('en-GB');


                        }
                    },
                    {
                        "targets": 4,
                        "data": "Edit",
                        "render": function(data, type, row, meta) {
                            var ccm_client_name = row[15] != null ? "" + row[15] + "/" :
                                "";
                            var ccm_client_code = row[4] != null ? row[4] : "";

                            return ccm_client_name + ccm_client_code;
                        }
                    },
                    {
                        "targets": 5,
                        "data": "Edit",
                        "render": function(data, type, row, meta) {
                            var ccm_client_name = row[10] != null ?
                                " <strong> Corporate Name : </strong> " + row[10] : "";
                            var ccm_client_code = row[11] != null ?
                                "<br><strong> Corporate Code : </strong>" + row[11] :
                                "";
                            var contact_person = row[12] != null ?
                                "<br> <strong> Contact Person : </strong>" + row[12] :
                                "";
                            var contact_no = row[13] != null ?
                                "<br> <strong>Contact No :</strong> " + row[13] : "";
                            var contract_sign_date = row[14] != null ?
                                "<br> <strong>Contact Singing Date : </strong>" + row[
                                    14] : "";

                            return ccm_client_name + ccm_client_code + contact_person +
                                contact_no;
                        }
                    },
                    {
                        "targets": 6,
                        "data": "Edit",
                        "render": function(data, type, row, meta) {


                            return row[5];
                        }
                    },
                    {
                        "targets": 7,
                        "data": "Edit",
                        "render": function(data, type, row, meta) {


                            return row[6];
                        }
                    },
                    {
                        "targets": 8,
                        "data": "Edit",
                        "render": function(data, type, row, meta) {


                            return '';
                        }
                    },
                    {
                        "targets": 9,
                        "data": "Edit",
                        "render": function(data, type, row, meta) {


                            return  row[16];
                        }
                    },
                    {
                    "targets": 10,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {


                        return  row[17];
                    }
                },
                    {
                        "targets": -1,
                        "data": "Edit",
                        "render": function(data, type, row, meta) {

                            var show_action =
                                '{{ route('registration.show', ':id') }}';
                            show_action = show_action.replace(':id', row[0]);

                            var edit_action =
                                '{{ route('registration.edit', ':id') }}';
                            edit_action = edit_action.replace(':id', row[0]);

                            var card_action = '{{ route('patient-card', ':id') }}';
                            card_action = card_action.replace(':id', row[0]);

                            return '<span  Class="btn btn-sm btn-dark open-modal" data-id="' +
                                row[
                                    0] + '" data-action="' + show_action +
                                '" data-modal="common-modal" data-title="View Patient Information" title="View Patient Information"><i class="fa fa-eye"></i></span>&nbsp;<span  Class="btn btn-sm btn-primary open-modal" data-id="' +
                                row[0] + '" data-action="' + edit_action +
                                '" data-modal="common-modal-md" data-title="Edit Patient Information" title="Edit Patient Information"><i class="fa fa-pencil-alt"></i></span>&nbsp;<span  Class="btn btn-sm btn-success open-modal" data-id="' +
                                row[0] + '" data-action="' + card_action +
                                '" data-modal="common-modal-sm" title="Card" data-title="Membership Card"><i class="fa fa-address-card "></i></span>';
                        }
                    },
                    {
                        "targets": 0,
                        "data": "Edit",
                        "render": function(data, type, row, meta) {


                            return `${meta.row + 1}`;
                        }
                    },
                ]
            });
        });
    });
</script>
