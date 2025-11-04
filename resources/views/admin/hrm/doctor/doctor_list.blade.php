<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<section id="full_doctor_list">

    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-12 mb-1">
                <h5 class="mt-2 mb-0">Doctor List</h5>
                <small>Hrm / Doctor Setup / Doctor List</small>
            </div>
        </div>
        <div class=" " style="width: 100%; margin: auto">
            <div class=" card ">
                <div class="card-header">
                    <h5><i class="fa fa-search"></i> Search Panel</h5>
                </div>
                <div class="card-body pt-2">
                    <form id="refFrmSearch" method="post" action="{{ route('doc_print') }}" target="_blank">
                        @csrf

                        <div class="form-row justify-content-center">
                            <label for="" class=" col-form-label col-form-label-sm ">Card Number</label>
                            <div class="col-md-1">
                                <!-- <label for="app_date">Card Number</label> -->
                                <input type="text" class="form-control " name="doc_name" id="doc_name"
                                    placeholder="Card Number" />
                                <input type="hidden" name="doc_id" id="doc_id">
                            </div>

                            <label for="" class=" col-form-label col-form-label-sm ">Specialization</label>
                            <div class="col-md-2">
                                <select class="form-control form-control-sm select2" name="specialization_id"
                                    id="specialization_id">
                                    <option value="">Select</option>
                                    @if (!empty($specialization))
                                        @foreach ($specialization as $key => $value)
                                            <option value="{{ $key }}"> {{ strtoupper($value) }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <input type="hidden" value="" name="hdn_report_type" id="hdn_report_type">
                            <label for="" class=" col-form-label col-form-label-sm ">Service Unit</label>
                            <div class="col-md-2">
                                <select class="form-control form-control-sm select2" name="service_unit"
                                    id="service_unit">
                                    <option value="">Select</option>
                                    @if (!empty($service_unit))
                                        @foreach ($service_unit as $value)
                                            <option value="{{ $value->serviceunit_no_pk }}">
                                                {{ $value->serviceunit_name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>

                            <label for="doctor_type" class=" col-form-label col-form-label-sm ">Doctor Type</label>
                            <div class="col-md-1">
                                <select class="form-control form-control-sm select2" name="doctor_type" id="doctor_type">
                                    <option value="">Select</option>
                                    <option value="internal">Internal</option>
                                    <option value="external">External</option>
                                </select>
                            </div>


                            <!-- <div class="col-sm-2">
       <label for="patient_id">HR Attendence Type</label>
       <select class="form-control form-control-sm select2" name="hr_type">
        <option value="">Select</option>
        @if (!empty($hr_type))
@foreach ($hr_type as $key => $value)
<option value="{{ $key }}">{{ $value }}</option>
@endforeach
@endif
       </select>
      </div>

      <div class="col-sm-2">
       <label for="cheif_compl">Job Type</label>
       <select class="form-control form-control-sm select2" name="job_type">
        <option value="">Select</option>
        @if (!empty($job_type))
@foreach ($job_type as $key => $value)
<option value="{{ $key }}">{{ $value }}</option>
@endforeach
@endif
       </select>
      </div>

      <div class="col-sm-2">
       <label for="app_priority">Roaster Setup</label>
       <select class="form-control font_size_12 m-auto" id="roster_type" name="roster_type">
        <option value="" selected="selected">Select Roster Type</option>
        <option value="General"	>	General	</option>
        <option value="Roster" >Roster	</option>
       </select>
      </div>

      <div class="col-sm-2">
       <input type="checkbox" name="emp_ind" value="1" id="emp_ind">
       <label for="emp_ind">Employee</label><br>

       <input type="checkbox" name="doc_ind" value="1" id="doc_ind">
       <label for="doc_ind">Doctor</label> <br>

       <input type="checkbox" name="ref_ind" value="1" id="ref_ind">
       <label for="ref_ind">Referral</label>
      </div>	 -->


                            <button type="button" class="btn btn-md btn-success  " id="ref_search" onclick=""> <i
                                    class="fas fa-search"></i> Search</button>
                            <button type='submit' class="btn btn-primary  btn-md ml-2" target="_blank"
                                onclick="exportPDFDoctorList()"> Export
                                PDF</button>
                            <button type='submit' class="btn btn-primary  btn-md ml-2" target="_blank"
                                onclick="exportExcel()"><i class="fa fa-print"></i> Export
                                Excel</button>

                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="card">
            <!-- <div class="card-header ">
    <h5>Doctor List
     <button class="btn btn-sm btn-primary float-right open-modal" data-modal="common-modal" data-action="{{ route('employees.create') }}" data-title="Create New Employee">Add Doctor</button>
    </h5>
   </div> -->

            <div class="card-body" id="doctor-list">
                <div class="row mt-2">
                    <div class="col-md-12 table-responsive">
                        <table id="datatable"
                            class="table data-table table-bordered table-hover table-striped doctor_list">
                            <thead class="bg-primary">
                                <tr>
                                    <th scope="col">#SL</th>
                                    <th scope="col">Image</th>
                                    <th scope="col">Doc-ID</th>
                                    <th scope="col">Card No</th>
                                    <th scope="col" class="text-left">Name</th>
                                    <th scope="col">Age</th>
                                    <th scope="col">Gender</th>
                                    <th scope="col">Specialization</th>
                                    <th scope="col">Designation</th>
                                    <th scope="col">Department</th>
                                    <th scope="col">Contact</th>
                                    <th scope="col">Address</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Status</th>
                                    <th scope="col" style="width:150px;">Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}">
</script>
<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script>
    $("body").addClass("sidebar-collapse");
    openDoctorAutocomplete('#doc_name', 'doc_id', 'doctor_ind', '1');
    $('.select2').select2();
    $(document).ready(function() {
        // $('.data-table').DataTable();

        var datatable = $('.data-table').DataTable({
            "ordering": false,
            "language": {
                "infoFiltered": ""
            },
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "{{ url('get-doctor-list') }}",
                "dataType": "json",
                "type": "POST",
                "data": {
                    _token: "{{ csrf_token() }}"
                }
            },
            "columnDefs": [{
                    "targets": 1,
                    "render": function(data, type, row, meta) {
                        if (row[1] != null) {
                            return '<img src="../public/images/uploads/doctor_images/thumb/' +
                                row[1] + '" >';
                        } else {
                            if (row[6] == 'Male') {
                                return '<img src="../public/images/doc-1.png" width="50" >';
                            } else {
                                return '<img src="../public/images/nurse-2.png" width="50" >';
                            }
                        }
                    }
                },

                {
                    "targets": -1,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {

                        var doctor_schedule = '{{ route('doctor-schedule', ':id') }}';
                        doctor_schedule = doctor_schedule.replace(':id', row[14]);

                        var show_action = '{{ route('employees.show', ':id') }}';
                        show_action = show_action.replace(':id', row[14]);

                        var edit_action = '{{ route('employees.edit', ':id') }}';
                        edit_action = edit_action.replace(':id', row[14]);
                        var card_action = '{{ route('referral-card-print', ':id') }}';
                        card_action = card_action.replace(':id', row[14]);

                        var doctor_fee_setup = '{{ route('doctor-fee-setup', ':id') }}';
                        doctor_fee_setup = doctor_fee_setup.replace(':id', row[14]);

                        return '<span Class="btn btn-sm open-modal" style="background-color: #770CCB"  data-id="' +
                            row[14] + '" data-action="' + show_action +
                            '" data-modal="common-modal" data-title="View Doctor Information" title="View Doctor Information"><i class="fa fa-eye text-white"></i></span>&nbsp;<span Class="btn btn-sm btn-primary open-modal" data-id="' +
                            row[14] + '" data-action="' + edit_action +
                            '" data-modal="common-modal" data-title="Edit Doctor Information" title="Edit Doctor Information"><i class="fa fa-pencil-alt"></i></span>&nbsp;<a  data-id="' +
                            row[14] + '" href="' + card_action +
                            '"  target="_blank" Class="btn btn-sm btn-success" title="Card"><i class="fa fa-address-card "></i></a>&nbsp;<span Class="btn btn-sm open-modal" style="background-color: rgb(249, 72, 125)" data-id="' +
                            row[14] + '" data-action="' + doctor_schedule +
                            '" data-modal="common-modal" data-title="Create Schedule" title="Create Schedule"><i class="fa fa-calendar-plus text-white"></i></span>&nbsp;<span  Class="btn btn-sm open-modal" style="background-color: #FFA500" title="Billing Setup" data-modal="common-modal-sm" data-title="Doctor Fee" data-action="' +
                            doctor_fee_setup +
                            '"><i class="fa fa-money-bill text-white"></i></span>';
                    }
                }

            ]
        });



        $('body').on('click', '#ref_search', function() {

            var formID = $("#refFrmSearch").attr("id");

            var formMethod = $("#refFrmSearch").attr("method");
            $('.doctor_list').empty();
            $('.doctor_list').DataTable().destroy();
            $('.doctor_list').DataTable({
                "searching": false,
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "{{ url('get-doctor-list-search') }}",
                    "dataType": "json",
                    "type": "post",
                    data: {
                        doc_id: $('#doc_id').val(),
                        su_id: $('#service_unit').val(),
                        specialization_id: $('#specialization_id').val(),
                        doctor_type: $('#doctor_type').val(),

                        // hdn_patient_id:$('input[name="hdn_patient_id"]').val(),
                        // admission_id:$('input[name="admission_id"]').val(),
                        // date_to:$('input[name="date_to"]').val(),
                        // date_from:$('input[name="date_from"]').val(),
                        // full_paid: $('#full_paid').is(':checked') ? $('input[name="full_paid"]').val() : '',
                        // due_bill:$('#due_bill').is(':checked') ? $('input[name="due_bill"]').val() : '',
                        // all_paid:$('#all_paid').is(':checked') ? $('input[name="all_paid"]').val() : '',

                    }
                },
                "columnDefs": [{
                        "targets": 1,
                        "render": function(data, type, row, meta) {
                            if (row[1] != null) {
                                return '<img src="../public/images/uploads/doctor_images/thumb/' +
                                    row[1] + '" >';
                            } else {
                                if (row[6] == 'Male') {
                                    return '<img src="../public/images/doc-1.png" width="50" >';
                                } else {
                                    return '<img src="../public/images/nurse-2.png" width="50" >';
                                }
                            }
                        }
                    },

                    {
                        "targets": -1,
                        "data": "Edit",
                        "render": function(data, type, row, meta) {

                            var doctor_schedule =
                                '{{ route('doctor-schedule', ':id') }}';
                            doctor_schedule = doctor_schedule.replace(':id', row[14]);

                            var show_action = '{{ route('employees.show', ':id') }}';
                            show_action = show_action.replace(':id', row[14]);

                            var edit_action = '{{ route('employees.edit', ':id') }}';
                            edit_action = edit_action.replace(':id', row[14]);

                            var doctor_fee_setup =
                                '{{ route('doctor-fee-setup', ':id') }}';
                            doctor_fee_setup = doctor_fee_setup.replace(':id', row[14]);

                            return '<span Class="btn btn-sm open-modal" style="background-color: #770CCB"  data-id="' +
                                row[14] + '" data-action="' + show_action +
                                '" data-modal="common-modal" data-title="View Doctor Information" title="View Doctor Information"><i class="fa fa-eye text-white"></i></span>&nbsp;<span Class="btn btn-sm btn-primary open-modal" data-id="' +
                                row[14] + '" data-action="' + edit_action +
                                '" data-modal="common-modal" data-title="Edit Doctor Information" title="Edit Doctor Information"><i class="fa fa-pencil-alt"></i></span>&nbsp;<span  data-id="' +
                                row[14] +
                                '" Class="btn btn-sm btn-success" title="Card"><i class="fa fa-address-card "></i></span>&nbsp;<span Class="btn btn-sm open-modal" style="background-color: rgb(249, 72, 125)" data-id="' +
                                row[14] + '" data-action="' + doctor_schedule +
                                '" data-modal="common-modal" data-title="Create Schedule" title="Create Schedule"><i class="fa fa-calendar-plus text-white"></i></span>&nbsp;<span  Class="btn btn-sm open-modal" style="background-color: #FFA500" title="Billing Setup" data-modal="common-modal-sm" data-title="Doctor Fee" data-action="' +
                                doctor_fee_setup +
                                '"><i class="fa fa-money-bill text-white"></i></span>';
                        },

                    }
                ]
            });
        });





    });

    function exportPDFDoctorList(element) {
        $("#hdn_report_type").val("PDF");
        $("#refFrmSearch").submit();
    }

    function exportExcel(element) {
        $("#hdn_report_type").val("EXCEL");
        $("#refFrmSearch").submit();
    }
</script>
