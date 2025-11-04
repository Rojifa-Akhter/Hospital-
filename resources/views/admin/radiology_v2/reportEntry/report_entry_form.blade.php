<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
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
            <div class="col-12 d-flex justify-content-center align-items-center">
                <form id="radiology_report_entry" method="POST" class="radiology_report_entry">
                    @csrf
                    <div class="card">
                        <div class="card-body p-3">
                            <div class="row mb-4">
                                <div class="col-md-12 col-12">
                                    <div class="form-group">
                                        <label for="menu">Department</label>
                                        <select name="menu" id="menu" class="form-control form-control-sm">
                                            @foreach ($dept as $item)
                                                <option value="{{ $item->serviceunit_no_pk }}">{{ $item->serviceunit_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="menu">Menu</label>
                                        <select name="menu" id="menu" class="form-control form-control-sm">
                                            @foreach ($allMenus as $item)
                                                <option value="{{ $item->menu_no_pk }}">{{ $item->menu_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            

                        </div>
                    </div>

                    <div class="card mb-2">
                        <div class="card-body p-3">
                            <div class="form-group">
                                <ul class="list-inline btn__box">
                                    <li class="list-inline-item">
                                        <button type="button" class="btn btn-secondary uhl_save_btn"
                                            id="item_type_wise_form" onclick="saveRADIOLOGYReport()">Save</button>
                                    </li>
                                    <li class="list-inline-item">
                                        <button type="reset" class="btn btn-secondary">Reset</button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>


        <div class="card">
            <div class="card-body p-2">
                <table class="table table-striped table-bordered table-hover" id="radiologyReportDataTable">
                    <thead class="global-uhl-table-bg">
                        <tr class="table-primary">
                            <th class="text-left" style="width: 5%">#SL</th>
                            <th class="text-left" style="width: 28%">Report Name</th>
                            <th class="text-left"style="width: 30%">Report Name Show</th>
                            <th class="text-left" style="width: 23%">Menu</th>
                            <th class="text-center" style="width: 7%">Status</th>
                            <th class="text-left" style="width: 7%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="6" class="text-center">Data Fetching ...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</section>

<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $("#radiology_report_entry").validate({
            rules: {
                sql_query: {
                    required: true
                },
                report_name: {
                    required: true
                },
                report_name_show: {
                    required: true
                },
                menu: {
                    required: true
                },
            },
            messages: {
                sql_query: {
                    required: 'SQL Query Required!'
                },
                report_name: {
                    required: 'Report Name Required!'
                },
                report_name_show: {
                    required: 'Report Name Show Required!'
                },
                menu: {
                    required: 'Store Required!'
                },
            }
        })
    });
</script>

<script>
    var count = 1;
    var new_count = 1;

    function addRowPC() {
        count += 1;
        var tbl = `<tr class="radiology-report-row" id="tbl${count}">
    
                    <td>
                        <input type="text"  class="form-control form-control-sm" id="reportparam_name${count}" name="reportparam_name[]" placeholder="Parameter Name" value="" />
                    </td>

                    <td>
                        <input type="text"  class="form-control form-control-sm" id="parameter_label${count}" name="parameter_label[]" placeholder="Parameter Label" value="" />
                    </td>

                    <td>
                        <select class="form-control form-control-sm" id="parameter_type${count}" name="parameter_type[]">
                            <option value="1" selected>Numeric</option>
                            <option value="2">Date</option>
                            <option value="3">Text</option>
                            <option value="4">Drop Down</option>
                        </select>
                       
                    </td>
                    
                    <td>
                         <input type="text" name="value_list_sql[]" value="" class="form-control form-control-sm" placeholder="Sql Query">
                    </td>

                    <td>
                        <span class="btn btn-warning remove_row_radiology_report"><i class="fas fa-trash" style="color:red"></i></span>
                    </td>

                    
                </tr>`;

        $('.parameter_configuration tbody').append(tbl);

    }

    $(document).ready(function() {
        $(document).on("click", ".remove_row_radiology_report", function() {
            if (confirm('Are you sure?')) {
                var id = $(this).closest('.radiology-report-row').attr('id');
                $("#" + id).remove();
            }

        })
        $(document).on("click", ".remove_row_radiology_report_column", function() {
            if (confirm('Are you sure?')) {
                var id = $(this).closest('.radiology-report-row-column').attr('id');
                $("#" + id).remove();
            }

        })
    })


    // Column Configuration
    function addRowCC() {
        new_count += 1;
        var tbl = `<tr class="radiology-report-row-column" id="tbl2${new_count}">
                    <td>
                        <input type="text" class="form-control form-control-sm" id="sl${new_count}" name="sl[]" placeholder="SL" value="${new_count}"/>
                    </td>
                    <td>
                        <input type="text" class="form-control form-control-sm" id="column_heading_name${new_count}" name="column_heading_name[]" placeholder="Heading Name"/>
                    </td>

                    <td>
                        <input type="text" class="form-control form-control-sm" id="column_name_actual${new_count}" name="column_name_actual[]" placeholder="Name Actual"/>
                    </td>

                    <td>
                        <select class="form-control form-control-sm" id="value_type${new_count}" name="value_type[]">
                            <option value="1" selected>Number</option>
                            <option value="2">Date</option>
                            <option value="3">Text</option>
                            <option value="4">Number & Number Format</option>
                        </select>
                    </td>


                    <td>
                        <select class="form-control form-control-sm" id="alignment_type${new_count}" name="alignment_type[]">
                            <option value="text-left" selected>Left</option>
                            <option value="text-center">Center</option>
                            <option value="text-right">Right</option>
                        </select>
                    </td>

                    <td class="text-center">
                         <select class="form-control form-control-sm" id="sum_ind${new_count}" name="sum_ind[]">
                            <option value="0" selected>No</option>
                            <option value="1">Yes</option>
                        </select>
                    </td>
                    
                    <td class="text-center">
                        <select class="form-control form-control-sm" id="show_ind${new_count}" name="show_ind[]">
                            <option value="0">No</option>
                            <option value="1" selected>Yes</option>
                        </select>
                    </td>
                    <td>
                        <span class="btn btn-warning remove_row_radiology_report_column"><i class="fas fa-trash" style="color:red"></i></span>
                    </td>

                </tr>`;

        $('.column_configuration tbody').append(tbl);
    }
</script>

<script>
    getRADIOLOGYReport();

    function getRADIOLOGYReport() {
        $.ajax({
            url: "{{ route('reports.get-radiology-report') }}",
            method: "get",
            success: function(response) {
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

    function saveRADIOLOGYReport() {
        let formElement = document.querySelector('#radiology_report_entry');
        let formData = new FormData(formElement);
        if ($('#radiology_report_entry').valid()) {

            $.ajax({
                url: "{{ route('reports.radiology-report-generate') }}",
                type: "post",
                dataType: "json",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    blockUI();
                    $('#radiology_report_entry button[type="submit"]').prop('disabled', true);
                },
                success: function(data) {
                    if (data.success == true) {
                        getRADIOLOGYReport();
                        resetForm();
                        $.unblockUI();
                        $('.common-modal-notify').modal('show');
                        $('.common-modal-notify .modal-title').html(data.title);
                        $('.common-modal-notify .modal-body').html(data.message);
                    }
                },
                error: function(err) {
                    $.unblockUI();
                    var error = err.responseJSON;
                    $('.common-modal-notify-error').modal('show');
                    $('.common-modal-notify-error .modal-title').html('Failed');
                    $('.common-modal-notify-error .modal-body').html(error.message);
                },
                complete: function() {
                    $.unblockUI();
                    $('#radiology_report_entry button[type="submit"]').prop('disabled', false);
                }
            });
        }
    }

    function resetForm() {
        $(".table_identity tr:not(#tblhead0,#tblhead1,#tblhead2,#tblhead3,#tbl0,#tbl1)").empty();
        $("#menu").val('');
        $("#reportparam_name0").val('');
        $("#parameter_label0").val('');
        $("#column_heading_name0").val('');
        $("#column_name_actual0").val('');
        $("#report_name").val('');
        $("#report_name_show").val('');
    }

    function setTableData(data) {

        if ($.fn.DataTable.isDataTable('#radiologyReportDataTable')) {
            $('#radiologyReportDataTable').DataTable().destroy();
        }
        $('#radiologyReportDataTable tbody').empty();
        var rows = [];
        var table = $('#radiologyReportDataTable').DataTable({
            searching: true,
            columnDefs: [{
                    targets: [0, 4, 5],
                    className: 'text-center'
                },
                {
                    targets: [1, 2, 3],
                    className: 'text-left'
                },
            ],
            "lengthMenu": [
                [10, 25, 50, 75, 100, -1],
                [10, 25, 50, 75, 100, "All"]
            ],
            "pageLength": 10
        });
        var status = "";
        data.forEach(function(item, index) {
            if ((item.status) == '1')
                status = '<span class="badge badge-success">Active</span>';
            else
                status = '<span class="badge badge-danger">Inactive</span>';

            var rowData = [
                ++index,
                '<span>' + item.report_name + '</span>',
                '<span>' + item.report_name_show + '</span>',
                item.menu_name,
                status,
                '<span class="btn btn-sm btn-success open-modal" data-action="{{ route('report.radiology-report-details', '') }}/' +
                item.report_no_pk +
                '" data-modal="common-modal-md" data-title="Report Details" title="Report Details" data-id="' +
                item.report_no_pk +
                '"><i class="fas fa-eye"></i></span>&nbsp;<span><a href="{{ route('reports.edit-radiology-report', '') }}/' +
                item.report_no_pk +
                '" target="_blank" class="btn btn-sm btn-info"><i class="fas fa-edit"></i></a><span>'
            ];
            rows.push(rowData);
        });
        table.clear();
        table.rows.add(rows);
        table.draw();

    }

    function emptyTable() {

        $('#radiologyReportDataTable tbody').empty();
        $('#radiologyReportDataTable tbody').append(`
                <tr>
                    <td colspan="6" class="text-danger text-center">Data Not Found</td>
                </tr>
            `);

    }
</script>
