<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm align-items-center">
        <div class="col-md-12">
            <div class="float-left ">
                <h5 class="mt-2 mb-0">Leave Report</h5>
                <small>Leave / Leave Report</small>
            </div>
        </div>
    </div>
    {{-- Search Panel Start --}}
   <div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5><i class="fa fa-search"></i>Search Panel</h5>
            </div>
            <div class="card-body pt-2 bg-light">
                <form action="{{ route('v1.hrm.search-leave-report-pdf-download') }}" id="searchLeaveReportWorklist" method="post" target="_blank">
                    @csrf
                    <div class="form-group row">
                        <div class="col-md-12">
                            <div class="form-row">
                                <div class="col-md-2">
                                        <div class="form-group">
                                        <label for="su_name" class="col-form-label col-form-label-sm">Department </label>
                                        <select name="su_name" id="su_name" class="select2">
                                            <option value="">Select Department</option>
                                            @if (!empty($service_unit))
                                                @foreach ($service_unit as $dept)
                                                <option value="{{ $dept->serviceunit_no_pk }}">{{ $dept->serviceunit_name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                    <label for="card_no" class="col-form-label col-form-label-sm">Card No.</label>
                                    <input type="text" class="form-control" name="card_no" id="card_no">
                                </div>
                             </div>

                             <div class="col-md-2">
                                <div class="form-group">
                                    <label class="col-form-label col-form-label-sm" for="from_date">Day From</label>
                                    <input type="text" class="form-control form-control-sm m-0 date_picker"
                                        id="from_date" name="from_date" value=""
                                        placeholder="dd-mm-yyyy"/>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="col-form-label col-form-label-sm" for="to_date">Day To</label>
                                    <input type="text" class="form-control form-control-sm m-0 date_picker"
                                        id="to_date" name="to_date" value=""
                                        placeholder="dd-mm-yyyy"/>
                                </div>
                            </div>

                                <div class="col-md-1">
                                    <button type="button" id="leaveReportWorklistSearch" class="btn btn-md btn-md-global btn-success mt-4">Search</button>
                                </div>
                                <div class="col-md-1">
                                    <button type="button" id="leaveReportPdfDownloadButton" class="btn btn-md btn-md-global btn-success mt-4">PDF</button>
                                </div>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
   </div>
    {{-- Search Panel end --}}
    <div class="card">
        <div class="card-body">
            <div class="row mt-2">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped data-table">
                            <thead class="global-uhl-table-bg">
                                <tr>
                                    <th class="text-center">Sl</th>
                                    <th class="text-center">Employee Name</th>
                                    <th class="text-center">Card No</th>
                                    <th class="text-center">Department</th>
                                    <th class="text-center">Designation</th>
                                    <th class="text-center">Leave Type</th>
                                    <th class="text-center">Leave Reason</th>
                                    <th class="text-center">From Date</th>
                                    <th class="text-center">To Date</th>
                                </tr>
                            </thead>
                            <tbody id="searchLeaveReportTable">
                                {{-- @if (!empty($datas))
                                @foreach ($datas as $data)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td class="text-left">{{ $data->full_name }}</td>
                                    <td class="text-left">{{ $data->full_name }}</td>
                                    <td class="text-center">{{ $data->serviceunit_name }}</td>
                                    <td class="text-left">{{ $data->designation_name }}</td>
                                    <td class="text-left">{{ $data->leave_type_lkp_name }}</td>
                                    <td class="text-left">{{ $data->leave_reason }}</td>
                                    <td class="text-center">{{ $data->from_date ? date('d-m-Y', strtotime($data->from_date)) : '' }}</td>
                                    <td class="text-center">{{ $data->to_dates ? date('d-m-Y', strtotime($data->to_dates)) : '' }}</td>
                                </tr>
                                @endforeach
                                @endif --}}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>

<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>

<script>
    $('.select2').select2({});
</script>
<script type="text/javascript">

   $('.data-table').DataTable({
            "ordering": false,
            "searching": true,
            "pageLength": 10

        });

        $(".date_picker").datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true,
            clearBtn: true
        }).attr("autocomplete", "off");

    $(document).on("click", "#leaveReportWorklistSearch", function(e) {
        var formID = $("#searchLeaveReportWorklist").attr("id");
        var formMethod = $("#searchLeaveReportWorklist").attr("method");

        $.ajax({
            data: $('#' + formID).serialize(),
            url: "{{ route('v1.hrm.search-leave-report-worklist') }}",
            type: "post",
            beforeSend: function() {
                blockUI();
            },
            success: function(data) {
                $("#searchLeaveReportTable").html(data);
                // $("#card_no").val('');
                // $("#su_name").val(null).trigger('change');
            },
            complete: function() {
                $.unblockUI();
                $("#searchLeaveReportWorklist").reset();
            }
        });
    });

    $(document).on("click", "#leaveReportPdfDownloadButton", function(e) {
        var formID = $("#searchLeaveReportWorklist").attr("id");
        var formMethod = $("#searchLeaveReportWorklist").attr("method");

        $("#searchLeaveReportWorklist").submit();

    });

</script>
