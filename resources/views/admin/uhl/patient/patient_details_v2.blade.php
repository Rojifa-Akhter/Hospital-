<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<style>
    .text-left{
        text-align:left;
    }
</style>
<main id="page-content">
    <section class="fixed_asset">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="row justify-content-between align-items-center bg-white border-bottom sticky-top shadow-sm">
                        <div class="col-md-11">
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
                                            <label for="uhid_" class="col-sm-4 col-form-label">UHID / Name</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control form-control-sm"
                                                    id="uhid" name="uhid" placeholder="" />
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
                                <table class="table table-bordered table-hover table-striped data-table  " id="patientList">
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
                                            <th>Entry By</th>
                                            <th>Updated By</th>
                                            <th style="width:200px!important">Action</th>
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
</main>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script>
      openPatientAutocomplete('#uhid', 'patient_name');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        <!-- Fetch Table Data -->
        fetchData();

        function fetchData() {
            $.ajax({
                url: "{{ url('hospital-patient-list') }}",
                method: "POST",
                beforeSend: function() {
                    blockUI();
                },
                success: function(response) {
                    if(response.data.length != 0) {
                        setTableData(response.data);
                    } else {
                        emptyTable();
                    }
                },
                error:function(err) {
                    var error = err.responseJSON;
                    $('.common-modal-notify-error').modal('show');
                    $('.common-modal-notify-error .modal-title').html('Failed');
                    $('.common-modal-notify-error .modal-body').html(error.message);
                },
                complete: function() {
                    $.unblockUI();
                }
            });
        }

        $(document).ready(function() {
            $('#patientList').DataTable({
                searching: true,
                columnDefs: [
                        { targets: [0, 2, 3, 4, 5], className: 'text-center' },
                        { targets: [1], className: 'text-left' }
                    ],
                    "lengthMenu": [[10, 25, 50, 75, 100, -1], [10, 25, 50, 75, 100, "All"]],
                    "pageLength": 10
                });
            $('th').addClass('text-center');
        });

        $(document).ready(function(e) {
            $('#searchPatient').on('click', function() {
                searchPatient();
            });
        });

        <!-- Submit Form Data -->
        function searchPatient() {
            let formElement = document.querySelector('#patient-search');
            let formData = new FormData(formElement);

            /*
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
            */

            $.ajax({
                url: "{{ url('hospital-patient-search') }}",
                type: "POST",
                dataType: "json",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    blockUI();
                },
                success: function(data) {
                    if(data.data.length != 0) {
                        setTableData(data.data);

                        $('#accountsGroupSave').trigger('reset');
                        // $('.common-modal-notify').modal('show');
                        // $('.common-modal-notify .modal-title').html(data.title);
                        // $('.common-modal-notify .modal-body').html(data.message);
                    }
                },
                error:function(err) {
                    $.unblockUI();
                    var error = err.responseJSON;
                    $('.common-modal-notify-error').modal('show');
                    $('.common-modal-notify-error .modal-title').html('Failed');
                    $('.common-modal-notify-error .modal-body').html(error.message);
                },
                complete: function() {
                    $.unblockUI();
                }
            });
        }

       
        function setTableData(data) {
            $('.data-table tbody').empty();
            var rows = [];
            var table = $('#patientList').DataTable();
            var status = "";
            data.forEach(function(item, index) {
                let show_action = "{{ route('registration.show', ':id') }}";
                show_action = show_action.replace(':id', item.patient_no_pk);

                // let edit_action = "{{ route('registration.edit', ':id') }}";
                let edit_action = "{{ route('uhl.patient-registration-edit', ':id') }}";
                edit_action = edit_action.replace(':id', item.patient_no_pk);

                let card_action = "{{ route('patient-card', ':id') }}";
                card_action = card_action.replace(':id', item.patient_no_pk);

                let wristBandSelf = "{{ route('uhl.wristband-self-print', ':id') }}";
                wristBandSelf = wristBandSelf.replace(':id', item.patient_no_pk+'*'+'SELF');

                let wristBandAttendent = "{{ route('uhl.wristband-self-print', ':id') }}";
                wristBandAttendent = wristBandAttendent.replace(':id', item.patient_no_pk+'*'+'ATTENDENT');

                const actions = '<span  Class="btn btn-sm btn-dark open-modal" data-id="' + item.patient_no_pk + '" data-action="' + show_action +
                    '" data-modal="common-modal-xl" data-title="View Patient Information" title="View Patient Information"><i class="fa fa-eye"></i></span>&nbsp;<span  Class="btn btn-sm btn-primary open-modal" data-id="' +
                    item.patient_no_pk + '" data-action="' + edit_action +
                    '" data-modal="common-modal-xl" data-title="Edit Patient Information" title="Edit Patient Information"><i class="fa fa-pencil-alt"></i></span>&nbsp;<span  Class="btn btn-sm btn-success open-modal" data-id="' +
                    item.patient_no_pk + '" data-action="' + card_action +
                    '" data-modal="common-modal-sm" title="Card" data-title="Membership Card"><i class="fa fa-address-card "></i></span><a  Class="btn btn-sm btn-info ml-2" data-id="' +item.patient_no_pk + '" href="' + wristBandSelf +'"  title="Wristband Self" data-title="Wristband Self "  target="_blank"><i class="fas fa-band-aid"></i></a><a  Class="btn btn-sm btn-info ml-2" data-id="' +item.patient_no_pk + '" href="' + wristBandAttendent +'"  title="Wristband Self" data-title="Wristband Self " target="_blank"><i class="fas fa-band-aid" ></i></a>';
                
                let entry_by_date=new Date(item.au_entry_at);
                let update_by_date=new Date(item.au_entry_at);
                let entry_by=item.entry_user_name !=null ? `${item.entry_user_name} <br> ${entry_by_date.getDate()}/${entry_by_date.getMonth()+1}/${entry_by_date.getFullYear()}`:'';
                let updated_by=item.user_fullname !=null ? `${item.user_fullname} <br> ${update_by_date.getDate()}/${update_by_date.getMonth()+1}/${update_by_date.getFullYear()}`:'';
                let rowData = [
                    ++index,
                    item.patient_code,
                    item.patient_name,
                    new Date(item.dob).toLocaleDateString('en-GB'),
                    item.age + ' / ' + item.gender_txt,
                    item.ccm_client_name,
                    item.mobile1,
                    item.present_addr,
                    item.guardian_name,
                    item.patient_type_code,
                    item.print_count,
                    entry_by,
                    updated_by,
                    actions
                ];
                rows.push(rowData);
            });
            table.clear();
            table.rows.add(rows);
            table.draw();
        }
        function emptyTable() {
            $('.data-table tbody').empty();
            $('.data-table tbody').append(`
                <tr>
                    <td colspan="7" class="text-danger text-center">Data Not Found</td>
                </tr>
            `);
        }
</script>
