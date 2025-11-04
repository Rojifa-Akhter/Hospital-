<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css')}}">
<link rel="stylesheet" href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}">

<style>
    .dataTables_wrapper .dataTables_filter input {
        width: 190px;
        margin-top: 10px;
    }
</style>
<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm align-items-center">
        <div class="col-md-6">
            <h5 class="mt-2 mb-0">Pathology Item Setup</h5>
            <small>Item Setup / Pathology Item Setup</small>
        </div>
        <div class="col-md-6">
            <div id="top-action m-0 text-right">
                <a rel="tab" href="#" class="btn btn-outline-primary btn-md float-right"><i class="fa fa-desktop"></i>&nbsp;Pathology
                    Item Worklist</a>
            </div>
        </div>
    </div>

    <div class="form-row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-header"><h5>Exam List</h5></div>

                <div class="card-body">
                    <form action="" method="post" id="pathology-item-search"> @csrf
                        <div class="form-row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="col-form-label col-form-label-sm" for="item_id">Item Name</label>
                                    <input type="text" class="form-control form-control-sm m-0" id="item_id"
                                           name="pathology_setup_item_name"
                                           value="" placeholder="Item Name"/>
                                    <input type="hidden" id="hdn_item_item_id_0" name="hdn_item_item_id_0" value="">
                                </div>
                            </div>
                        </div>


                        <div class="form-row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="pathology_setup_sample"
                                           class="col-form-label col-form-label-sm">Sample</label>
                                    <select class="form-control" id="pathology_setup_sample"
                                            name="pathology_setup_sample">
                                        <option value="">Select Pathology Sample</option>
                                        <option value="1">Winword (Histo+Cyto New)</option>
                                        <option value="2">Sample-2</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="pathology_setup_department" class="col-form-label col-form-label-sm">Department</label>
                                    <select class="form-control select2" id="pathology_setup_department"
                                            name="pathology_setup_department">
                                        <option value="0">Select Department</option>
                                        @foreach($pathology as $key=> $value)
                                            <option value="{{$key}}">{{$value}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                        </div>


                        <div class="form-row">

                            <div class="col-md-10">
                                <div class="form-group">
                                    <label for="pathology_setup_template"
                                           class="col-form-label col-form-label-sm">Template</label>
                                    <select class="form-control" id="pathology_setup_template"
                                            name="pathology_setup_template">
                                        <option value="">Select Template</option>
                                        @foreach($labs_testtemplate as $lab_temp)
                                            <option
                                                value="{{$lab_temp->test_temp_no_pk}}">{{$lab_temp->temp_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="pathology_setup_template"
                                   class="col-form-label col-form-label-sm col-4">Status</label>
                            <div class="col-8">
                                <div class="custom-control custom-radio custom-control-inline text-center">
                                    <input type="radio" id="all" name="pathology_exam_list_status"
                                           value="2" class="custom-control-input" value="2" checked="checked">
                                    <label class="custom-control-label" for="all">All</label>
                                </div>

                                <div class="custom-control custom-radio custom-control-inline text-center">
                                    <input type="radio" id="status_active" name="pathology_exam_list_status"
                                           value="1" class="custom-control-input">
                                    <label class="custom-control-label" for="status_active">Active</label>
                                </div>

                                <div class="custom-control custom-radio custom-control-inline text-center">
                                    <input type="radio" id="status_inactive" value="3" name="pathology_exam_list_status"
                                           class="custom-control-input">
                                    <label class="custom-control-label" for="status_inactive">Inactive</label>
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-12 mt-3 text-right">
                                <div class="border-top pt-2">
                                    @php
                                        $reportAction = route("pathology-item-setup-search");
                                    @endphp

                                    <button type="button"
                                            onclick="generateReport(this,'pathology-item-search','{{$reportAction}}')"
                                            class="btn btn-md btn-success">Search
                                    </button>
                                        <a href="{{route('item.pathology-item-setup')}}" type="button"
                                       class="btn btn-md btn-danger">Reset</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

            </div>

            <div class="card">
                <div class="card-body">
                    <div class="form-row ">
                        <div id="search-result" class="col-12 table-responsive">
                            <table id="data-table"
                                   class="data-table table-bordered table-hover table-striped mt-2 border mb-0">
                                <thead class="bg-light">
                                <tr>
                                    <th class="text-left w-5">ID</th>
                                    <th class="text-left">Name</th>
                                    <th class="text-left">Action</th>
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
        <div class="col-md-9" id="result-data">
            @include("admin.settings.item.pathology_item_setup_form")
        </div>
    </div>
</div>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js')}}"></script>
<script type="application/javascript"
        src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script>
    $("#data-table").DataTable({
        "ordering": false,
        // "bPaginate": false,
        "bLengthChange": false,
        "bAutoWidth": false,
        "status": false
    });

    function generateReport(thisElement, formID, reportAction) {
        $.ajax({
            data: $('#' + formID).serialize(),
            url: reportAction,
            type: "post",
            beforeSend: function () {
                $("#data-table").DataTable().destroy();
                blockUI();
            },
            success: function (data) {
                $("#search-result").html(data);
            },
            complete: function () {
                $("#data-table").DataTable({
                    "ordering": false,
                    // "bPaginate": false,
                    "bLengthChange": false,
                    "bAutoWidth": false,
                    "status": false
                });
                $.unblockUI();
            }
        });

    }

    openItemAutocomplete($("#item_id"), 'LAB', '#hdn_item_item_id_0', '#item_id');

    $('.select2').select2({});
    $(document).ready(function () {
        $(document).on("click", ".edit_item", function () {
            var item_id = $(this).attr("data-item_id");
            var edit_action = $(this).attr("data-action");
            $.ajax({
                data: {item_id: item_id},
                url: edit_action,
                type: "get",
                beforeSend: function () {
                    blockUI();
                },
                success: function (data) {
                    $("#result-data").html(data);
                },
                complete: function () {
                    //$(".data-table").DataTable();
                    $.unblockUI();
                }
            });
        });
    });
</script>


