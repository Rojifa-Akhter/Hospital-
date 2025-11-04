<main id="page-content">

    <link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
    <link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
    <section class="indent_worklist">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="row justify-content-between align-items-center bg-white border-bottom sticky-top shadow-sm">
                        <div class="col-md-7">
                            <h5 class="mt-2 mb-0">P.R Assign Worklist</h5>
                            <small>Inventory/ Store / P.R Assign Worklist</small>
                        </div>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-lg-12">

                    <div class="card">
                        <!-- <div class="card-header">
                                    <ul class="nav nav-pills" id="pills-tab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="pills-indent-tab" data-toggle="pill"
                                                href="#pills-indent" role="tab" aria-controls="pills-indent"
                                                aria-selected="true">Issue Indent</a>
                                        </li>
                                    </ul>
                                </div> -->

                        <!-- <div class="card">
                                    <div class="card-header">
                                        <ul class="nav nav-pills justify-content-center" id="pills-tab" role="tablist">

                                            <li class="nav-item">
                                                <label for="indent_issue">ISSUE PENDING</label>
                                                <input type="radio" name="indent_issue_type" id="indent_issue" value="issue" checked data-action="{{ route('v1.only_item_issues_worklist') }}"/>
                                                <label for="indent_issued">ISSUE PARTIAL PENDING</label>
                                                <input type="radio" name="indent_issue_type" id="indent_issued" value="issued" data-action="{{ route('v1.only_partial_item_issued_worklist') }}">
                                            </li>
                                        </ul>
                                    </div>
                                </div> -->
                        <div class="card-body">
                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="pills-indent" role="tabpanel" aria-labelledby="pills-indent-tab">
                                    <form action="{{ route('v1.assign-pr-list-pdf') }}" method="post" id="" target="_blank">
                                        @csrf
                                        <div class="card">
                                            <div class="card-body pb-4">
                                                <div class="form-row">
                                                    <div class="col-lg-3 col-md-3 col-12">
                                                        <div class="form-group">
                                                        <label for="main_dept" class="">Main Department </label>
                                                            <select class="form-control form-control-sm" id="department_to" name="">
                                                                <option value="">Select One</option>
                                                                @if (!empty($main_stores_list))
                                                                @foreach ($main_stores_list as $row)
                                                                <option data-mainstore="{{ $row->main_store_ind ?? 0 }}" value="{{ $row->serviceunit_no_pk }}" >
                                                                    {{ $row->serviceunit_name }}
                                                                    ({{ $row->main_store_ind == 1 ? 'Main Store' : 'Sub Store' }})
                                                                </option>
                                                                @endforeach
                                                                @endif
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2 col-md-2 col-12">
                                                        <div class="form-group">
                                                            <label for="emp_name">Employee Name </label>
                                                            <input type="text" class="form-control " name="emp_name" id="emp_name" placeholder="Card Number" />
                                                            <input type="hidden" name="emp_id" id="emp_id">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2 col-md-2 col-12">
                                                        <div class="form-group">
                                                            <label for="requsion_no" class="col-form-label">P.R
                                                                No</label>
                                                            <input type="text" class="form-control form-control-sm" id="requsion_no" name="requsion_no" placeholder="" />
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-3 col-md-3 col-sm-12">
                                                        <div class="form-group">
                                                            <label class="col-form-label col-form-label-sm" for="indent_date_from">P.R Date</label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <div class="input-group-text">From</div>
                                                                </div>
                                                                <input type="text" class="form-control form-control-sm m-0 date_picker" id="indent_date_from" name="indent_date_from" value="" placeholder="dd-mm-yyyy" autocomplete="off" />
                                                                <div class="input-group-prepend">
                                                                    <div class="input-group-text">To</div>
                                                                </div>
                                                                <input type="text" class="form-control form-control-sm m-0 date_picker" id="indent_date_to" name="indent_date_to" value="" placeholder="dd-mm-yyyy" autocomplete="off" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2 col-md-2 col-12">
                                                        <div class="form-group">
                                                            <label for="assign_status" class="col-form-label">Assign Status</label>
                                                            <select name="assign_status" id="assign_status" class="form-control">
                                                                <option value="">Select Status</option>
                                                                <option value="ASSIGNED">Assigned</option>
                                                                <option value="PENDING">Pending</option>

                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3 col-md-3 mt-4">
                                                        <div class="btn-group btn-block" role="group">
                                                            <button type="button" class="btn btn-success cess search_pr"><i class="fa fa-search"></i> Search</button>
                                                            <button type="reset" id="reset" class="btn btn-info"><i class="fa fa-redo"></i> Reset</button>
                                                            <button type="submit" class="btn btn-warning">Print PDF </button>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>


                                        </div>
                                    </form>

                                    <div class="card">
                                        <div class="card-body px-0 search_indent_list">
                                            <div class="table-responsive">
                                                @include('admin.uhl.inventory.pr-assign-department-worklist-table')
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
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>

<script>
    openDoctorAutocomplete('#emp_name', 'emp_id', "employee_ind", 1);
    $("body").addClass("sidebar-collapse");
    $('.data-table').DataTable({
        // "ordering": false,
        "searching": true,

    });
    $(".date_picker").datepicker({
        format: 'dd-mm-yyyy',
        todayHighlight: true,
        clearBtn: true,
        autoclose: true,
    })



    $('.search_pr').on('click', function() {
        $.ajax({
            url: "{{ route('v1.search-assign-department-pr-list') }}",
            method: "post",
            data: {
                requsion_no: $('#requsion_no').val(),
                status: $('#status').val(),
                indent_date_from: $('#indent_date_from').val(),
                indent_date_to: $('#indent_date_to').val(),
                emp_id: $('#emp_id').val(),
                assign_status: $('#assign_status').val(),
                department_to: $('#department_to').val(),
            },
            beforeSend: function() {
                blockUI();
            },
            success: function(response) {
                $('.search_indent_list').html(response);
            },
            complete: function() {

                $.unblockUI();
            }
        })

    });

    function clearAssign(element) {
        var pr_dtl_no = $(element).attr('data-prdtlno');
        var item_no = $(element).attr('data-item_no');
        console.log(pr_dtl_no);
        if (confirm('Are You Sure?')) {

            $.ajax({
                url: "{{ route('v1.clear-assign') }}",
                method: "post",
                data: {
                    pr_dtl_no: pr_dtl_no,
                    item_no: item_no
                },
                beforeSend: function() {
                    blockUI();
                },
                success: function(response) {
                    $(".common-modal-notify").modal("show");
                    $(".common-modal-notify .modal-body").html(
                        "<i class='fas fa-stroopwafel fa-spin'></i>"
                    );
                    $(".common-modal-notify .modal-body").html(response.message);

                    $.ajax({
                        url: "{{ route('v1.search-assign-pr-list') }}",
                        method: "post",
                        data: {
                            requsion_no: $('#requsion_no').val(),
                            status: $('#status').val(),
                            indent_date_from: $('#indent_date_from').val(),
                            indent_date_to: $('#indent_date_to').val(),
                            emp_id: $('#emp_id').val(),
                            assign_status: $('#assign_status').val()
                        },
                        beforeSend: function() {
                            blockUI();
                        },
                        success: function(response) {
                            $('.search_indent_list').html(response);
                        },
                        complete: function() {

                            $.unblockUI();
                        }
                    });

                },
                complete: function() {

                    $.unblockUI();
                }
            })

        }
    }
</script>