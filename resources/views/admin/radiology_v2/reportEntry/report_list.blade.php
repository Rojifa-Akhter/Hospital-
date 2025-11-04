<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}">
<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.min.css') }}" rel="stylesheet">

<style>
    /* Card Styling */
    .card {
        border: 1px solid #ddd;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
    }

    /* Card Body Padding */
    .card-body {
        padding: 15px;
    }

    /* Table Styling */
    .table {
        width: 100%;
        margin-bottom: 1rem;
        background-color: transparent;
    }

    .table th,
    .table td {
        padding: 0.75rem;
        vertical-align: top;
        border-top: 1px solid #dee2e6;
    }

    .table-bordered {
        border: 1px solid #dee2e6;
    }

    .table-striped tbody tr:nth-of-type(odd) {
        background-color: rgba(0, 0, 0, 0.05);
    }

    /* Form Control Styling */
    .form-control-sm {
        height: calc(1.25em + 0.75rem + 2px);
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
        line-height: 1.5;
        border-radius: 0.2rem;
    }

    /* Flexbox Layout for Buttons */
    .btn__box {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .col-md-5 {
            flex: 0 0 100%;
            max-width: 100%;
        }
    }
</style>

<section>
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm">
            <div class="col-md-12">
                <div class="float-left">
                    <h5 class="mt-2 mb-0">Radiology Report Entry</h5>
                    <small>Radiology Entry / Radiology Report Entry</small>
                </div>
            </div>
        </div>
        <div class="row">
            <!-- Left Column: Department & Menu Selection -->
            <div class="col-12  d-flex justify-content-center align-items-center">
                <div class="card col-8">
                    <div class="card-body">
                        <form id="radiology_report_entry" method="POST" class="radiology_report_entry">
                            @csrf
                            <div class="form-group">
                                <label for="department">Department</label>
                                <select name="department" id="department" class="form-control form-control-sm">
                                    <option value="">Select Department</option>
                                    @foreach ($dept as $item)
                                        <option value="{{ $item->serviceunit_no_pk }}">{{ $item->serviceunit_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="menu">Menu</label>
                                <select name="menu" id="menu" class="form-control form-control-sm">
                                    <option value="">Select Menu</option>
                                    @foreach ($allMenus as $item)
                                        <option value="{{ $item->menu_no_pk }}">{{ $item->menu_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </form>

                        <!-- Department-wise Route Table -->
                        <table class="table table-striped table-bordered table-hover" id="deptWiseMenu">
                            <thead>
                                <tr>
                                    {{-- <th>#SL</th> --}}
                                    <th>Menu Name</th>
                                    <th>Feature Name</th>
                                    {{-- <th>Route Name</th> --}}
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="5" class="text-center">Data Fetching ...</td>
                                </tr>
                            </tbody>
                        </table>

                        <!-- Buttons Section -->
                        <div class="text-right">
                            <button type="button" class="btn btn-success" id="saveButton">Save</button>
                            <button type="reset" class="btn btn-primary">Reset</button>
                            <button type="button" class="btn btn-secondary" onclick="exitForm()">Exit</button>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Right Column: Department-wise Route Table -->
            {{-- <div class="col-md-8">
                <div class="card">
                    <div class="card-body p-2">
                        <table class="table table-striped table-bordered table-hover" id="radiologyReportDataTable">
                            <thead class="global-uhl-table-bg">
                                <tr class="table-primary">
                                    <th class="text-left" style="width: 5%">#SL</th>
                                    <th class="text-left" style="width: 28%">Report Name</th>
                                    <th class="text-left" style="width: 23%">Route Name</th>
                                    <th class="text-center" style="width: 7%">Status</th>
                                    <th class="text-left" style="width: 7%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="5" class="text-center">Data Fetching ...</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div> --}}
        </div>

        <!-- Buttons Section -->
        {{-- <div class="row">
            <div class="col-12 text-right">
                <button type="button" class="btn btn-secondary" id="item_type_wise_form"
                    onclick="saveRADIOLOGYReport()">Save</button>
                <button type="reset" class="btn btn-secondary">Reset</button>
                <button type="button" class="btn btn-secondary" onclick="exitForm()">Exit</button>
            </div>
        </div> --}}


        <div class="card">
            <div class="card-body p-2">
                <table class="table table-striped table-bordered table-hover" id="radiologyReportDataTable">
                    <thead class="global-uhl-table-bg">
                        <tr class="table-primary">
                            <th class="text-left" style="width: 5%">#SL</th>
                            {{-- <th class="text-left" style="width: 28%">Menu Name</th> --}}
                            <th class="text-left" style="width: 28%">Feature Name</th>
                            {{-- <th class="text-left" style="width: 23%">Route Name</th> --}}
                            <th class="text-center" style="width: 7%">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($groupedFeatures as $key => $features)
                            <tr>
                                <td colspan="5" class="text-left font-weight-bold">{{ $key }}</td>
                            </tr>
                            @foreach ($features as $item)
                                <tr>
                                    <td>{{ $loop->parent->iteration }}.{{ $loop->iteration }}</td>
                                    <td>{{ $item->features_name }}</td>
                                    {{-- <td>{{ $item->features_code }}</td> --}}
                                    {{-- <td>{{ $item->page_url }}</td> --}}
                                    <td class="text-center">
                                        <span class="badge badge-success">Active</span>
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>


            </div>
        </div>
    </div>
</section>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>

<script>
    $(document).ready(function() {
        getRadiologyData();

        function getRadiologyData() {
            $.ajax({
                url: "{{ route('reports/get-radiology-menu-list') }}",
                method: "get",
                success: function(response) {
                    console.log(response)
                    if (response.data.length != 0) {
                        setTableData(response.data);
                    } else {
                        emptyTable();
                    }
                },
                error: function(err) {
                    var error = err.responseJSON;
                    $('.common-modal-notify-error').modal('show');
                    $('.common-modal-notify-error .modal-title').html('Failed');
                    $('.common-modal-notify-error .modal-body').html(error.message);
                }
            })
        }

        function setTableData(data) {
            // Check if DataTable is already initialized and destroy it to reinitialize with new data
            if ($.fn.DataTable.isDataTable('#radiologyReportDataTable')) {
                $('#radiologyReportDataTable').DataTable().destroy();
            }

            // Clear any existing rows in the table
            $('#radiologyReportDataTable tbody').empty();

            var rows = [];
            var table = $('#radiologyReportDataTable').DataTable({
                searching: true,
                columnDefs: [{
                        targets: [0, 4], // Apply styling to the first and last columns
                        className: 'text-center'
                    },
                    {
                        targets: [1, 2, 3], // Apply styling to the other columns
                        className: 'text-left'
                    }
                ],
                "lengthMenu": [
                    [10, 25, 50, 75, 100, -1],
                    [10, 25, 50, 75, 100, "All"]
                ],
                "pageLength": 10,
                rowGroup: {
                    dataSrc: 1, // Group by 'module' (second column in the row data)
                    startRender: function(rows, group) {
                        // Generate a unique color for each group (module)
                        var uniqueColor = getRandomColor();

                        // Create the group row with the specified color
                        var td = '<td colspan="5" style="background-color: ' + uniqueColor + ';">' +
                            group + '</td>';
                        return $('<tr/>').append(td);
                    }
                }
            });

            // Loop through each module and its features
            $.each(data, function(module, features) {
                // Loop through each feature in the current module
                features.forEach(function(item) {
                    // Determine the status based on the feature status
                    var status = item.status == '1' ?
                        '<span class="badge badge-success">Active</span>' :
                        '<span class="badge badge-danger">Inactive</span>';

                    // Create a new row with the data for the DataTable
                    var rowData = [
                        item.sl, // Serial number
                        item.module, // Module name
                        item.features_name, // Feature name
                        item.page_url, // Route name (page URL)
                        status // Status (Active/Inactive)
                    ];

                    // Push the row data to the rows array
                    rows.push(rowData);
                });
            });

            // Add the new rows to the DataTable
            table.clear();
            table.rows.add(rows);
            table.draw();
        }

        function getRandomColor() {
            return '#' + Math.floor(Math.random() * 16777215).toString(16);
        }




        let selectedRoutes = [];

        // Function to generate route data
        function generateRouteData(departmentName, menuName) {
            const slugifiedDept = slugify(departmentName);
            const slugifiedMenu = slugify(menuName);

            return [{
                    menu_name: menuName,
                    feature_name: `${departmentName} Sample Collection`.replace(/\s+/g, ' ').trim(),
                    route_name: `radiology/radiology-sample-`,
                    status: 'Active'
                },
                {
                    menu_name: menuName,
                    feature_name: `${departmentName} Result Entry Worklist`.replace(/\s+/g, ' ').trim(),
                    route_name: `radiology/result-entry-`,
                    status: 'Active'
                },
                {
                    menu_name: menuName,
                    feature_name: `${departmentName} Result Finalized Worklist`.replace(/\s+/g, ' ').trim(),
                    route_name: `radiology/result-finalize-`,
                    status: 'Active'
                },
                // {
                //     menu_name: menuName,
                //     feature_name: `${departmentName} Result Finalized Worklist`.replace(/\s+/g, ' ').trim(),
                //     route_name: `radt/result-finalized-print-`,
                //     status: 'Active'
                // }
            ];
        }


        // Function to slugify text
        function slugify(text) {
            return text
                .toString()
                .toLowerCase()
                .replace(/\s+/g, '-') // Replace spaces with -
                .replace(/[^\w\-]+/g, '') // Remove all non-word chars
                .replace(/\-\-+/g, '-') // Replace multiple - with single -
                .replace(/^-+/, '') // Trim - from start of text
                .replace(/-+$/, ''); // Trim - from end of text
        }

        // Trigger menu change to update route table
        $('#menu').change(function() {
            const departmentId = $('#department').val();
            const menuId = $(this).val();
            const departmentName = $('#department option:selected').text();
            const menuName = $('#menu option:selected').text();

            if (departmentId && menuId) {
                const routeData = generateRouteData(departmentName, menuName);
                const tableBody = $('#deptWiseMenu tbody');
                tableBody.empty();

                routeData.forEach((route, index) => {
                    const row = $('<tr/>');
                    row.append(`<td>${route.menu_name}</td>`);
                    row.append(`<td>${route.feature_name}</td>`);
                    // row.append(`<td>${route.route_name}</td>`);
                    row.append(`<td>${route.status}</td>`);
                    row.append(
                        '<td><button class="btn btn-sm btn-primary">Add This Feature</button></td>'
                    );
                    tableBody.append(row);
                });

                // Store the route data in the selectedRoutes array
                selectedRoutes = routeData;
            }
        });

        // Save button click handler
        $('#saveButton').click(function() {
            const departmentId = $('#department').val();
            const menuId = $('#menu').val();
            if (!departmentId || !menuId) {
                alert("Please select both department and menu.");
            } else {
                // Send the selectedRoutes array to the server via AJAX
                $.ajax({
                    url: "{{ route('radiology-feature-wise-route-save') }}",

                    type: 'POST',
                    data: {
                        department_id: departmentId,
                        menuId: menuId,
                        Features_id: menuId,
                        routes: selectedRoutes
                    },
                    success: function(data) {
                        getRadiologyData();
                        if (data.title == "Success") {
                            $(".common-modal-notify").modal("show");
                            $(".common-modal-notify .modal-body").html(
                                "<i class='fas fa-stroopwafel fa-spin'></i>"
                            );
                            $(".common-modal-notify .modal-title").html(data.title);
                            $(".common-modal-notify .modal-body").html(data.msg);
                            setTimeout(function() {
                                location.reload();
                            }, 3000); // Reload after 3 seconds
                        } else {
                            $(".common-modal-notify-error").modal("show");
                            $(".common-modal-notify-error .modal-title").html(
                                data.title
                            );
                            $(".common-modal-notify-error .modal-body").html(
                                data.msg
                            );
                        }
                    },
                    error: function() {
                        alert('An error occurred while saving routes.');
                    }
                });
            }
        });
    });

    function emptyTable() {

        $('#radiologyReportDataTable tbody').empty();
        $('#radiologyReportDataTable tbody').append(`
        <tr>
            <td colspan="6" class="text-danger text-center">Data Not Found</td>
        </tr>
    `);

    }
</script>
