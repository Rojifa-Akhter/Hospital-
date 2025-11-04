<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm align-items-center">
        <div class="col-md-12">
            <div class="float-left ">
                <h5 class="mt-2 mb-0">Show Balance Leave List</h5>
                <small>Settings / Show Balance Leave List</small>
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
                <form action="{{ route('hr.search_leave_balance_pdf_download') }}" id="searchLeaveBalanceformhr" method="post" target="_blank">
                    @csrf
                    <div class="form-group row">
                        <div class="col-md-12">
                            <div class="form-row">

                                <div class="col-md-3">
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
                                <div class="col-md-3">
                                    <div class="form-group">
                                    <label for="card_no" class="col-form-label col-form-label-sm">Card No.</label>
                                    <input type="text" class="form-control" name="card_no" id="card_no">
                                </div>
                             </div>
                                <div class="col-md-1">
                                    <button type="button" id="leaveBalanceSearchButton" class="btn btn-md btn-md-global btn-success mt-4">Search</button>
                                </div>
                                <div class="col-md-1">
                                    <button type="button" id="leaveBalancePdfDownloadButton" class="btn btn-md btn-md-global btn-success mt-4">Download</button>
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
                                    <th style="width: 180px" class="text-center">Employee Name</th>
                                    <th style="width: 180px" class="text-center">Card No.</th>
                                    <th class="text-center">Designation</th>
                                    <th class="text-center">Department</th>
                                    <th class="text-center">Leave Balance</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody id="searchBalanceLeaveTable">
                                @if (!empty($balance_leave))
                                @foreach ($balance_leave as $data)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td class="text-left">{{ $data->full_name }}</td>
                                    <td class="text-center">{{ $data->card_no }}</td>
                                    <td class="text-left">{{ $data->designation_name }}</td>
                                    <td class="text-left">{{ $data->serviceunit_name }}</td>
                                    <td class="text-center">{{ $data->total_balance - $data->total_leave }}</td>
                                    <td class="text-center">
                                        <span Class="btn btn-sm open-modal" style="background-color: #770CCB"
                                        data-id="{{ $data->person_no_pk }}"
                                        data-action="{{ route('hr.show-leave-details-for-hr', $data->person_no_pk) }}" data-modal="common-modal-md"
                                        data-title="View Leave Details" title="View Leave Details"><i
                                        class="fa fa-eye text-white"></i></span>
                                        <span Class="btn btn-sm btn-success open-modal"
                                        data-id="{{ $data->person_no_pk }}"
                                        data-action="{{ route('hr.show-availed-leave-details', $data->person_no_pk) }}" data-modal="common-modal-lg"
                                        data-title="View Availed Details" title="View Availed Details"><i
                                        class="fa fa-eye text-white"></i>
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                                @endif
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

    $(".date_picker").attr("autocomplete", "off");

    $(document).on("click", "#leaveBalanceSearchButton", function(e) {
        var formID = $("#searchLeaveBalanceformhr").attr("id");
        var formMethod = $("#searchLeaveBalanceformhr").attr("method");

        $.ajax({
            data: $('#' + formID).serialize(),
            url: "{{ route('hr.search_leave_balance') }}",
            type: "post",
            beforeSend: function() {
                blockUI();
            },
            success: function(data) {
                $("#searchBalanceLeaveTable").html(data);
            },
            complete: function() {
                $.unblockUI();
                $("#searchLeaveBalanceformhr").reset();
            }
        });
    });

    $(document).on("click", "#leaveBalancePdfDownloadButton", function(e) {
        var formID = $("#searchLeaveBalanceformhr").attr("id");
        var formMethod = $("#searchLeaveBalanceformhr").attr("method");

        $("#searchLeaveBalanceformhr").submit();

    });

</script>

