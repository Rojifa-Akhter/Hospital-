<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<style>
    .table {
        color: #222 !important;
    }

</style>

@include("admin.dashboards.total_data_account")
<div class="form-row mt-2 justify-content-center">
    <div class="col-12">
        <h6 class="py-1 px-2 bg-flat-color-12 d-block">Search Panel</h6>
    </div>
</div>
<form id="searchForm" method="post" action="">
    @csrf
    <div class="form-row mt-2 justify-content-center">
        <div class="col-md-3">
            <div class="form-group m-0">
                <input type="hidden" id="doctor_id" name="doctor_id" value="" />
                <input type="text" class="form-control form-control-sm m-0" id="primary_doctor" name="primary_doctor"
                    maxlength="50" value="" placeholder="Doctor Code" required />
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group m-0">
                <input type="hidden" id="type" name="type" value="{{ $type }}">
                <input type="text" class="form-control form-control-sm m-0" id="item_value" name="item_value"
                    maxlength="50" value="" placeholder="Item Name" required />
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group m-0">
                <select class="form-control select2" id="department_wise_filter" name="department_wise_filter">
                    <option value="">Select Department</option>
                    @if (!empty($requestDepts))
                        @foreach ($requestDepts as $rd)
                            <option value="{{ $rd->serviceunit_no_pk }}">
                                {{ $rd->serviceunit_name }}</option>
                        @endforeach
                    @endif
                </select>
            </div>
        </div>
    </div>
    <div class="form-row mt-2 justify-content-center">
        <div class="col-md-5">
            <div class="input-group input-daterange">
                <div class="input-group-prepend">
                    <div class="input-group-text">From</div>
                </div>
                <input type="text" class="form-control form-control-sm m-0 date_picker form-date"
                    id="dashboard_date_from" name="date_from" value="" placeholder="dd/mm/yyyy">
                <div class="input-group-prepend">
                    <div class="input-group-text">To</div>
                </div>
                <input type="text" class="form-control form-control-sm m-0 date_picker to-date" id="dashboard_date_to"
                    name="date_to" value="" placeholder="dd/mm/yyyy">
            </div>
        </div>
        <div class="col-4">
            <span class="btn btn-md btn-success btn-block" id="dash_popup_search">
                <i class="fa fa-search mr-1"></i> Search</span>
        </div>
    </div>
</form>
<div class="col-md-12" id="dashboard_search_data">

    @include('admin.dashboards.dashboard_popup_list')

</div>

<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script>
    openDoctorAutocomplete('#primary_doctor', 'doctor_id');
    // openItemAutocomplete('#item_id');
    openPtaItemAutocomplete('#item_value', 'item_name', '', function(item, obj) {
        $('#item_id').val(item.item_code);
        obj.stopImmediatePropagation();
    });
    $('.form-date').datepicker({
        todayHighlight: true,
        clearBtn: true,
        autoclose: true,
        endDate: '+0d',
        'format': 'dd/mm/yyyy'
    });
    $('.to-date').datepicker({
        todayHighlight: true,
        clearBtn: true,
        autoclose: true,
        endDate: '+0d',
        'format': 'dd/mm/yyyy'
    });
    $(document).ready(function() {
        $('.select2').select2();
    });


    // Search
    $(document).on("click", "#dash_popup_search", function(e) {
        var formID = $("#searchForm").attr("id");
        var formMethod = $("#searchForm").attr("method");
        $("#searchForm").attr('action', "{{ url('report/cashier-wise-report-search') }}");
        $.ajax({
            data: $('#' + formID).serialize(),
            url: "{{ url('dashboard/search-data') }}",
            type: formMethod,
            beforeSend: function() {
                blockUI();

            },
            success: function(data) {
                $("#dashboard_search_data").html(data);
            },
            complete: function() {
                $.unblockUI();
            }
        });
    });
</script>
