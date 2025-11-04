<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />

<section id="full_doctor_list">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-12 mb-1">
                <h5 class="mt-2 mb-0">Referral List</h5>
                <small>Settings / Referral List</small>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5><i class="fa fa-search"></i> Search Panel</h5>
            </div>
            <div class="card-body pt-2">
                <form id="empRefsearch" method="post" action="{{ route('referral_print') }}" target="_blank">
                    @csrf

                    <div class="form-row justify-content-center">
                        <div class="col-sm-2">
                            <label for="emp_name">Referral Code</label>
                            <input type="text" class="form-control " name="emp_name" id="emp_name"
                                placeholder="Enter Referral Code" />
                            <input type="hidden" name="emp_id" id="emp_id">
                        </div>

                        <div class="col-sm-2">
                            <label for="doctor_code">Department</label>
                            <select class="form-control form-control-sm select2" name="service_unit" id="service_unit">
                                <option value="">Select</option>

                                @if (!empty($service_unit))
                                    @foreach ($service_unit as $value)
                                        <option value="{{ $value->serviceunit_no_pk }}">
                                            {{ $value->serviceunit_name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="col-sm-2">
                            <label for="patient_id">Marketing Officer</label>
                            <select class="form-control form-control-sm select2" name="merketing_id" id="merketing_id">
                                <option value="">Select Marketing Officer</option>
                                @if (!empty($Mragents))
                                    @foreach ($Mragents as $key => $value)
                                        <option value="{{ $value->person_no_pk }}">{{ $value->full_name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <div class="col-sm-2">
                            <label for="patient_id">Referral Type</label>
                            <select class="form-control form-control-sm select2" name="ref_type" id="ref_type">
                                <option value="">Select</option>
                                @if (!empty($referralTypesDt))
                                    @foreach ($referralTypesDt as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <input type="hidden" value="" name="hdn_report_type" id="hdn_report_type">
                        <div class="col-md-4">
                            <div class="btn-group btn-block " role="group">
                                <button type="button" class="btn btn-md btn-success btn-block mt-4" id="emp_search"
                                    onclick=""> <i class="fas fa-search"></i> Search</button>


                                <button type="button" id="IPD"
                                    class="btn btn-md btn-primary btn-block mt-4 print" target="_blank"
                                    onclick="exportPDFIPD()"><i class="fa fa-print"></i> Export In
                                    PDF</button>

                                <button type="button" id="exportinexcel" onclick="exportPDF(this)"
                                    class="btn btn-md btn-warning btn-block mt-4 print"><i
                                        class="fa
                                                 fa-file-excel"></i>
                                    Export In
                                    Excel</button>


                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>


        <div class="card">
            <div class="card-header ">
                <h5>Referral List
                    <!-- 	<button class="btn btn-sm btn-primary float-right open-modal" data-modal="common-modal" data-action="{{ route('doctor.create') }}" data-title="Create New Employee">Add Employee</button> -->
                </h5>
            </div>

            <div class="card-body" id="doctor-list">
                <div class="row mt-2">
                    <div class="col-md-12 table-responsive">
                        <table id="datatable" class="table table-bordered table-hover table-striped" border="1">
                            <thead class="global-uhl-table-bg">
                                <tr>
                                    <th scope="col">#SL </th>
                                    {{-- <th scope="col">Image</th> --}}
                                    <th scope="col">Referral Code</th>
                                    {{-- <th scope="col">Card No</th> --}}
                                    <th scope="col" class="text-left">Referral Name</th>
                                    {{-- <th scope="col">Age</th> --}}
                                    {{-- <th scope="col">Gender</th> --}}
                                    {{-- <th scope="col">Specialization</th> --}}
                                    {{-- <th scope="col">Designation</th> --}}
                                    <th scope="col">Department</th>
                                    {{-- <th scope="col">Contact</th> --}}
                                    <th scope="col">Address</th>
                                    <th scope="col">Marketing Officer</th>
                                    <th scope="col">Referral Type</th>
                                    <th scope="col">Payable</th>

                                    {{-- <th scope="col">Status</th> --}}
                                    {{-- <th scope="col" style="width:150px;">Action</th> --}}
                                </tr>
                            </thead>
                            <tbody id="emp_info">
                                {{-- @include('admin.hrm.employee.emp_info') --}}
                            </tbody>
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
    openDoctorAutocomplete('#emp_name', 'emp_id', "employee_ind", 1);
    $("body").addClass("sidebar-collapse");

    $(document).ready(function() {
        // Fetch agent options for the selects (row[5] and row[6])
        $.ajax({
            url: "{{ route('marketing.get-agents') }}",
            method: "GET",
            success: function(response) {
                // Extract the agents array from the response
                var agents = response.agents;

                // Fetch referral types
                $.ajax({
                    url: "{{ route('marketing.get-referral-types') }}",
                    method: "GET",
                    success: function(response) {
                        // Extract referral types array from the response
                        var referralTypes = response.referral_types;

                        // Initialize DataTable
                        var datatable = $('#datatable').DataTable({
                            "ordering": false,
                            "language": {
                                "infoFiltered": ""
                            },
                            "processing": true,
                            "serverSide": true,
                            "ajax": {
                                "url": "{{ route('marketing.referral-doctor-list') }}",
                                "dataType": "json",
                                "type": "POST",
                                "data": {
                                    _token: "{{ csrf_token() }}"
                                }
                            },
                            "columnDefs": [{
                                    "targets": -1,
                                    "data": "Edit",
                                    "render": function(data, type, row,
                                        meta) {
                                        var checked = row[7] == 1 ?
                                            'checked' : '';
                                        return `<input type="checkbox" class="checkbox-toggle" data-person_id="${row[8]}" data-id="${row[0]}" ${checked}>`;
                                    }
                                },
                                {
                                    "targets": 5, // Target column 5 for agent selection (person_no_pk, full_name)
                                    "data": "agent5", // Assuming 'agent5' contains the agent data for this row
                                    "render": function(data, type, row,
                                        meta) {
                                        var selectHTML =
                                            '<select class="select5" data-id="' +
                                            row[0] +
                                            '" data-person_id="' + row[
                                                8] + '">';

                                        // Default option for agent if no agent is selected
                                        selectHTML +=
                                            `<option value="">Select Referral Agent</option>`;

                                        // Populate the agents
                                        $.each(agents, function(index,
                                            agent) {
                                            var selected = (row[
                                                        9] ==
                                                    agent
                                                    .person_no_pk
                                                ) ?
                                                'selected' : '';
                                            selectHTML +=
                                                `<option value="${agent.person_no_pk}" ${selected}>${agent.full_name}</option>`;
                                        });

                                        selectHTML += '</select>';
                                        return selectHTML;
                                    }
                                },
                                {
                                    "targets": 6, // Target column 6 for referral type selection
                                    "data": "referral_type", // Assuming 'referral_type' contains the type data for this row
                                    "render": function(data, type, row,
                                        meta) {
                                        var selectHTML =
                                            '<select class="select6" data-id="' +
                                            row[0] +
                                            '" data-person_id="' + row[
                                                8] + '">';

                                        // Default option for referral type if no type is selected
                                        selectHTML +=
                                            `<option value="">Select Referral Type</option>`;

                                        // Loop through referralTypes and populate the dropdown
                                        $.each(referralTypes, function(
                                            id, name) {
                                            var selected = (row[
                                                        10] ==
                                                    id) ?
                                                'selected' : '';
                                            selectHTML +=
                                                `<option value="${id}" ${selected}>${name}</option>`;
                                        });

                                        selectHTML += '</select>';
                                        return selectHTML;
                                    }
                                }
                            ]
                        });

                        // Handle checkbox toggle
                        $('#datatable tbody').on('change', '.checkbox-toggle',
                            function() {
                                var checkbox = $(this);
                                var isChecked = checkbox.prop('checked');
                                var rowId = checkbox.data('id');
                                var person_id = checkbox.data('person_id');

                                // Send AJAX request to update the state of the checkbox (checked/unchecked)
                                $.ajax({
                                    url: "{{ route('marketing.update-checkbox-status') }}",
                                    method: "POST",
                                    data: {
                                        _token: "{{ csrf_token() }}",
                                        id: rowId,
                                        person_id: person_id,
                                        status: isChecked ? 1 : 0
                                    },
                                    success: function(response) {
                                        console.log(
                                            "Checkbox status updated"
                                        );
                                    },
                                    error: function(error) {
                                        console.error(
                                            "Error updating checkbox status"
                                        );
                                    }
                                });
                            });

                        // Handle change in select for row[5] (Agent selection)
                        $('#datatable tbody').on('change', '.select5', function() {
                            var select = $(this);
                            var selectedValue = select.val();
                            var rowId = select.data('id');
                            var personId = select.data(
                                'person_id'
                                ); // Get the person_id from the select element

                            // Send AJAX request to save selected value for referral agent
                            $.ajax({
                                url: "{{ route('marketing.update-referral-agent') }}", // Route for updating referral agent
                                method: "POST",
                                data: {
                                    _token: "{{ csrf_token() }}",
                                    person_id: personId, // Pass the person_id
                                    value: selectedValue // Pass the selected referral agent
                                },
                                success: function(response) {
                                    console.log(
                                        "Referral agent updated successfully"
                                    );
                                },
                                error: function(error) {
                                    console.error(
                                        "Error updating referral agent"
                                    );
                                }
                            });
                        });

                        // Handle change in select for row[6] (Referral type selection)
                        $('#datatable tbody').on('change', '.select6', function() {
                            var select = $(this);
                            var selectedValue = select.val();
                            var rowId = select.data('id');
                            var personId = select.data(
                                'person_id'
                                ); // Get the person_id from the select element

                            // Send AJAX request to save selected value for referral type
                            $.ajax({
                                url: "{{ route('marketing.update-referral-type') }}", // Route for updating referral type
                                method: "POST",
                                data: {
                                    _token: "{{ csrf_token() }}",
                                    person_id: personId, // Pass the person_id
                                    value: selectedValue // Pass the selected referral type
                                },
                                success: function(response) {
                                    console.log(
                                        "Referral type updated successfully"
                                    );
                                },
                                error: function(error) {
                                    console.error(
                                        "Error updating referral type"
                                    );
                                }
                            });
                        });

                    },
                    error: function(error) {
                        console.error("Error fetching referral types", error);
                    }
                });
            },
            error: function(error) {
                console.error("Error fetching agents", error);
            }
        });
    });



    // search

    $(document).on('click', '#emp_search', function() {
    // Retrieve form data and URLs
    var formID = $("#empRefsearch").attr("id");
    var formMethod = $("#empRefsearch").attr("method");
    var imgUrl = '{{ URL::asset('images/uploads/doctor_images') }}';
    var docImgName = "doc-1.png";
    var nurseImgName = "nurse-2.png";
    var defaultImgUrl = '{{ URL::asset('images') }}';

    // Empty the table and destroy the previous DataTable instance
    $('#datatable').empty();
    if ($.fn.DataTable.isDataTable('#datatable')) {
        $('#datatable').DataTable().clear().destroy();
    }

    // Make AJAX call to fetch agents and referral types
    $.ajax({
        url: "{{ route('marketing.get-agents') }}",
        method: "GET",
        success: function(response) {
            // Populate global agents array
            var agents = response.agents;

            $.ajax({
                url: "{{ route('marketing.get-referral-types') }}",
                method: "GET",
                success: function(response) {
                    // Populate global referralTypes array
                    var referralTypes = response.referral_types;

                    // Reinitialize DataTable with search results
                    $('#datatable').DataTable({
                        "searching": false,
                        "processing": true,
                        "serverSide": true,
                        "pageLength": 50,
                        "order": [[0, "desc"]],
                        "ajax": {
                            "url": "{{ url('referral_search') }}",
                            "dataType": "json",
                            "type": "POST",
                            data: {
                                emp_id: $('input[name="emp_id"]').val(),
                                service_unit: $('#service_unit').val(),
                                merketing_id: $('#merketing_id').val(),
                                ref_type: $('#ref_type').val()
                            }
                        },
                        "columnDefs": [
                            {
                                "targets": -1,
                                "data": "Edit",
                                "render": function(data, type, row) {
                                    var checked = row[7] == 1 ? 'checked' : '';
                                    return `<input type="checkbox" class="checkbox-toggle" data-person_id="${row[8]}" data-id="${row[0]}" ${checked}>`;
                                }
                            },
                            {
                                "targets": 5, // Target column 5 for agent selection (person_no_pk, full_name)
                                "data": "agent5", // Assuming 'agent5' contains the agent data for this row
                                "render": function(data, type, row) {
                                    var selectHTML = '<select class="select5" data-id="' + row[0] + '" data-person_id="' + row[8] + '">';
                                    selectHTML += `<option value="">Select Referral Agent</option>`;

                                    // Populate the agents dropdown
                                    $.each(agents, function(index, agent) {
                                        var selected = (row[9] == agent.person_no_pk) ? 'selected' : '';
                                        selectHTML += `<option value="${agent.person_no_pk}" ${selected}>${agent.full_name}</option>`;
                                    });

                                    selectHTML += '</select>';
                                    return selectHTML;
                                }
                            },
                            {
                                "targets": 6, // Target column 6 for referral type selection
                                "data": "referral_type", // Assuming 'referral_type' contains the type data for this row
                                "render": function(data, type, row) {
                                    var selectHTML = '<select class="select6" data-id="' + row[0] + '" data-person_id="' + row[8] + '">';
                                    selectHTML += `<option value="">Select Referral Type</option>`;

                                    // Populate the referral types dropdown
                                    $.each(referralTypes, function(id, name) {
                                        var selected = (row[10] == id) ? 'selected' : '';
                                        selectHTML += `<option value="${id}" ${selected}>${name}</option>`;
                                    });

                                    selectHTML += '</select>';
                                    return selectHTML;
                                }
                            }
                        ]
                    });

                    // Handle checkbox toggle
                    $('#datatable tbody').on('change', '.checkbox-toggle', function() {
                        var checkbox = $(this);
                        var isChecked = checkbox.prop('checked');
                        var rowId = checkbox.data('id');
                        var person_id = checkbox.data('person_id');

                        // Send AJAX request to update the checkbox status
                        $.ajax({
                            url: "{{ route('marketing.update-checkbox-status') }}",
                            method: "POST",
                            data: {
                                _token: "{{ csrf_token() }}",
                                id: rowId,
                                person_id: person_id,
                                status: isChecked ? 1 : 0
                            },
                            success: function(response) {
                                console.log("Checkbox status updated");
                            },
                            error: function(error) {
                                console.error("Error updating checkbox status");
                            }
                        });
                    });

                    // Handle change in select for row[5] (Agent selection)
                    $('#datatable tbody').on('change', '.select5', function() {
                        var select = $(this);
                        var selectedValue = select.val();
                        var rowId = select.data('id');
                        var personId = select.data('person_id');

                        // Send AJAX request to save the selected value for referral agent
                        $.ajax({
                            url: "{{ route('marketing.update-referral-agent') }}",
                            method: "POST",
                            data: {
                                _token: "{{ csrf_token() }}",
                                person_id: personId,
                                value: selectedValue
                            },
                            success: function(response) {
                                console.log("Referral agent updated successfully");
                            },
                            error: function(error) {
                                console.error("Error updating referral agent");
                            }
                        });
                    });

                    // Handle change in select for row[6] (Referral type selection)
                    $('#datatable tbody').on('change', '.select6', function() {
                        var select = $(this);
                        var selectedValue = select.val();
                        var rowId = select.data('id');
                        var personId = select.data('person_id');

                        // Send AJAX request to save the selected value for referral type
                        $.ajax({
                            url: "{{ route('marketing.update-referral-type') }}",
                            method: "POST",
                            data: {
                                _token: "{{ csrf_token() }}",
                                person_id: personId,
                                value: selectedValue
                            },
                            success: function(response) {
                                console.log("Referral type updated successfully");
                            },
                            error: function(error) {
                                console.error("Error updating referral type");
                            }
                        });
                    });
                },
                error: function(error) {
                    console.error("Error fetching referral types", error);
                }
            });
        },
        error: function(error) {
            console.error("Error fetching agents", error);
        }
    });
});


    function exportPDF(element) {
        $("#hdn_report_type").val("EXCEL");
        $("#empRefsearch").submit();
    }

    function exportPDFIPD(element) {
        $("#hdn_report_type").val("PDF");
        $("#empRefsearch").submit();
    }
</script>
