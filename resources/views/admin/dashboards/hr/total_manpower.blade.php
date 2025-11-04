<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<div class="form-row">
    <div class="col-md-6">
        <div class="total-sales text-center bg-flat-color-7 py-3">
            <p class="mb-2">Total Employees</p>
            @php
                $total_manpower_data = isset($popup_total_manpower_sales_data['ROW02COL01T']) ? explode('_',$popup_total_manpower_sales_data['ROW02COL01T']) : [];
            @endphp
            <h4 class="mb-0">{{ isset($total_manpower_data[0]) ? $total_manpower_data[0] : '' }}</h4>
        </div>
    </div>
    <div class="col-md-6">
        <div class="total-collection text-center bg-flat-color-4 py-3">
            <p class="mb-2">Total Offday Employees</p>
            <h4 class="mb-0">
                @if($type == '2')
                    @php
                        $late_manpower_data = isset($popup_total_manpower_sales_data['ROW02COL02T']) ? explode('_',$popup_total_manpower_sales_data['ROW02COL02T']) : [];
                    @endphp
                    <h4 class="mb-0">{{ isset($late_manpower_data[0]) ? $late_manpower_data[0] : '' }}</h4>

                @elseif($type == '5')
                    @php
                        $absent_manpower_data = isset($popup_total_manpower_sales_data['ROW02COL02T']) ? explode('_',$popup_total_manpower_sales_data['ROW02COL02T']) : [];
                    @endphp
                    <h4 class="mb-0">{{ isset($absent_manpower_data[0]) ? $absent_manpower_data[0] : '' }}</h4>

                @elseif($type == '4')
                    @php
                        $leave_manpower_data = isset($popup_total_manpower_sales_data['ROW02COL02T']) ? explode('_',$popup_total_manpower_sales_data['ROW02COL02T']) : [];
                    @endphp
                    <h4 class="mb-0">{{ isset($leave_manpower_data[0]) ? $leave_manpower_data[0] : '' }}</h4>

                @elseif($type == '3')
                    @php
                        $sick_manpower_data = isset($popup_total_manpower_sales_data['ROW02COL02T']) ? explode('_',$popup_total_manpower_sales_data['ROW02COL02T']) : [];
                    @endphp
                    <h4 class="mb-0">{{ isset($sick_manpower_data[0]) ? $sick_manpower_data[0] : '' }}</h4>

                @elseif($type == '6')
                    @php
                        $offday_manpower_data = isset($popup_total_manpower_sales_data['ROW02COL02T']) ? explode('_',$popup_total_manpower_sales_data['ROW02COL02T']) : [];
                    @endphp
                    <h4 class="mb-0">{{ isset($offday_manpower_data[0]) ? $offday_manpower_data[0] : '' }}</h4>
                @endif
            </h4>
        </div>
    </div>
</div>

<div class="form-row mt-2 justify-content-center">
    <div class="col-12">
        <h6 class="py-1 px-2 bg-flat-color-12 d-block">Search Panel</h6>
    </div>
</div>
<form action="" method="post" id="searchForm">
    <input type="hidden" value="{{$type}}" name="type">
    @csrf
    <div class="form-row">
        <div class="col-md-5">
            <div class="input-group input-daterange">
                <div class="input-group-prepend">
                    <div class="input-group-text">From</div>
                </div>
                <input type="text" class="form-control form-control-sm m-0 date_picker" id="dashboard_date_from" name="start" value="" placeholder="dd/mm/yyyy">
                <div class="input-group-prepend">
                    <div class="input-group-text">To</div>
                </div>
                <input type="text" class="form-control form-control-sm m-0 date_picker" id="dashboard_date_to" name="end" value="" placeholder="dd/mm/yyyy">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group m-0">
                <select class="form-control" id="department_wise_filter" name="department_wise_filter">
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
        <div class="col-4">
            <span class="btn btn-md btn-success btn-block" id="hr_popup_search">
                <i class="fa fa-search mr-1"></i> Search</span>
        </div>
    </div>
</form>
<table class="table table-bordered table-hover mb-0">
    <thead>
    <tr>
        <th class="text-center">SL#</th>
        <th class="text-left">Date</th>
        <th class="text-left">Employe Card No</th>
        <th class="text-left">Name</th>
        <th class="text-left">Designation</th>
        <th class="text-center">In Time</th>
        <th class="text-center">Lunch In</th>
        <th class="text-center">Lunch Out</th>
        <th class="text-center">Out Time</th>
    </tr>
    </thead>
    <tbody>
        <div id="hr_list">
            @include('admin.dashboards.hr.hr_list_data')
        </div>

    </tbody>
</table>


<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script>
    $('.date_picker').datepicker({
        todayHighlight: true,
        clearBtn: true,
        autoclose: true,
        endDate: '+0d',
        'format':'dd/mm/yyyy'
    });

    $(document).on("click", "#hr_popup_search", function(e) {
        var formID = $("#searchForm").attr("id");
        var formMethod = $("#searchForm").attr("method");
        $.ajax({
            data: $('#' + formID).serialize(),
            url:"{{ url('dashboard/hr-data-search') }}",
            type: formMethod,
            beforeSend: function() {
                blockUI();

            },
            success: function(data) {
                $("#cashier_report_data").html(data);
            },
            complete: function() {
                $.unblockUI();
            }
        });
    });
</script>
