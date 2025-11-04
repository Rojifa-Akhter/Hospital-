<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<style>
    .text-left {
        text-align: left;
    }
</style>

<section id="full_appointment">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-7 mb-1">
                <h5 class="mt-2 mb-0">CSSD</h5>
                <small>CSSD / Receive from Department</small>
            </div>
            <div class="col-lg-5 col-md-5 col-12 mt-2">
                <div class="text-right">
                    <button id="receiveByCssd" class="btn btn-success uhl_common_outline_btn">Receive by CSSD</button>
                    <button id="cancelByCssd" class="btn btn-danger uhl_cancel_outline_btn">Cancel by CSSD</button>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-lg-12">
                <div class="tab-contentX">
                    <div class="tab-pane fade show active" id="pending-sample" role="tabpanel"
                        aria-labelledby="received-by-challan-tab">
                        <form action="" method="POST" id="cssdFilterForm" class="searchPOWorklist">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header ">
                                            <h5><i class="fa fa-search"></i> Search Panel</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="form-row">
                                                {{-- ID No --}}
                                                <div class="col-md-2 col-12">
                                                    <div class="form-group form-row">
                                                        <label for="reqmst_no_pk" class="col-sm-4 col-form-label">ID
                                                            No</label>
                                                        <div class="col-sm-8">
                                                            <input class="form-control" type="number" id="reqmst_no_pk"
                                                                name="reqmst_no_pk" placeholder="ID No" />
                                                        </div>
                                                    </div>
                                                </div>

                                                {{-- Date Range --}}
                                                <div class="col-md-3 col-12">
                                                    <div class="form-group form-row">
                                                        <label for="from_date" class="col-sm-4 col-form-label">From/To
                                                            Date</label>
                                                        <div class="col-sm-8">
                                                            <div class="input-group">
                                                                <input type="text"
                                                                    class="form-control form-control-sm"
                                                                    placeholder="From Date" name="from_date"
                                                                    id="from_date" autocomplete="off">
                                                                <input type="text"
                                                                    class="form-control form-control-sm"
                                                                    placeholder="To Date" name="to_date" id="to_date"
                                                                    autocomplete="off">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                {{-- Department --}}
                                                <div class="col-md-3 col-12">
                                                    <div class="form-group form-row">
                                                        <label for="serviceunit_no_fk"
                                                            class="col-sm-4 col-form-label">Department</label>
                                                        <div class="col-sm-8">
                                                            <select class="form-control form-control-sm select2"
                                                                name="serviceunit_no_fk" id="serviceunit_no_fk">
                                                                <option value="" selected disabled>Select
                                                                    department</option>
                                                                @if (!empty($departments))
                                                                    @foreach ($departments as $department)
                                                                        <option
                                                                            value="{{ $department->serviceunit_no_pk }}">
                                                                            {{ $department->serviceunit_name }}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-2 col-12">
                                                    <div class="form-group form-row">
                                                        <div class="co-12">
                                                            <button class="btn btn-md-global btn-success"
                                                                id="btnCssdFilter" type="button">Search</button>
                                                            {{-- <button class="btn btn-md-global btn-danger" type="reset" onclick="resetForm()">Reset</button> --}}
                                                            <a rel="tab"
                                                                href="{{ route('cssd.cssdPendingReceive') }}"
                                                                class="btn btn-md-global btn-danger">Reset</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive" id="receive-from-department-table">
                                    @include('admin.cssd.receive-from-department.receive-from-department-table')
                                </div>
                            </div>
                        </div>
                        <div id="details_block">
                            @include('admin.cssd.receive-from-department.receive-from-department-details')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Cancel CSSD Modal -->
    <div class="modal fade" id="cancelCssdModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">Cancel by CSSD</h5>
                    <button type="button"  data-bs-dismiss="modal" aria-label="Close">X</button>
                </div>
                <div class="modal-body">
                    <label for="cancelRemarks">Remarks</label>
                    <textarea id="cancelRemarks" class="form-control" rows="3" placeholder="Enter cancellation remarks"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="confirmCancelCssd" class="btn btn-danger">Confirm Cancel</button>
                </div>
            </div>
        </div>
    </div>
    

</section>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script type="text/javascript">
    // $("body").addClass("sidebar-collapse");

    $(document).ready(function() {
        $('.select2').select2();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // const currentDate = new Date();

        $('#from_date').datepicker({
            todayHighlight: true,
            clearBtn: true,
            autoclose: true,
            format: 'dd/mm/yyyy',
        })
        // .datepicker('setDate', currentDate);

        $('#to_date').datepicker({
            todayHighlight: true,
            clearBtn: true,
            autoclose: true,
            format: 'dd/mm/yyyy',
        })
        // .datepicker('setDate', currentDate);
    });

    function showDetails(id) {
        let route = "{{ route('cssd.receiveFromDepartment.details', ['id' => ':id']) }}";
        route = route.replace(':id', id);

        $.ajax({
            url: route,
            method: "GET",
            beforeSend: function() {
                blockUI();
            },
            success: function(response) {
                $('#details_block').html(response);
            },
            error: function(err) {
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

    var _checkedValues = [];

    $('.check').click(function() {
        // const value = $("input[type='checkbox']").val();

        const value = $(this).val();

        if ($(this).prop('checked') == true) {
            if (_checkedValues.indexOf(value) == -1) {
                _checkedValues.push(value);
            }
        } else {
            _checkedValues.splice(_checkedValues.indexOf(value), 1);
        }
    });

    $('#receiveByCssd').click(function() {
        console.log("Ids: " + _checkedValues);

        if (_checkedValues.length == 0) {
            alert('Please select an item first.');
            return false;
        }

        if (!confirm('Are you sure to Receive to Department?')) {
            return false;
        }

        $.ajax({
            url: "{{ route('cssd.receiveByCssd') }}",
            method: "POST",
            data: {
                ids: _checkedValues
            },
            beforeSend: function() {
                blockUI();
            },
            success: function(response) {
                _checkedValues = [];
                $('#details_block').html(response);

                $('.common-modal-notify').modal('show');
                $('.common-modal-notify .modal-title').html('Success!!');
                $('.common-modal-notify .modal-body').html('Successfully Returned to Department.');
                location.reload();
            },
            error: function(err) {
                var error = err.responseJSON;
                $('.common-modal-notify-error').modal('show');
                $('.common-modal-notify-error .modal-title').html('Failed');
                $('.common-modal-notify-error .modal-body').html(error.message);
            },
            complete: function() {
                $.unblockUI();
            }
        });
    });

    // cancel by department
    $('#cancelByCssd').click(function() {
        if (_checkedValues.length == 0) {
            alert('Please select an item first.');
            return false;
        }

        // Open modal instead of confirm
        $('#cancelCssdModal').modal('show');
    });

    $('#confirmCancelCssd').click(function() {
        let remarks = $('#cancelRemarks').val().trim();

        if (remarks === "") {
            alert('Remarks are required.');
            return false;
        }

        $.ajax({
            url: "{{ route('cssd.cancelByCssd') }}",
            method: "POST",
            data: {
                ids: _checkedValues,
                remarks: remarks,
                _token: "{{ csrf_token() }}"
            },
            beforeSend: function() {
                blockUI();
            },
            success: function(response) {
                _checkedValues = [];
                $('#details_block').html(response);
                $('#cancelCssdModal').modal('hide');

                $('.common-modal-notify').modal('show');
                $('.common-modal-notify .modal-title').html(response.title);
                $('.common-modal-notify .modal-body').html(response.msg);
                location.reload();
            },
            error: function(err) {
                var error = err.responseJSON;
                $('#cancelCssdModal').modal('hide');

                $('.common-modal-notify-error').modal('show');
                $('.common-modal-notify-error .modal-title').html('Failed');
                $('.common-modal-notify-error .modal-body').html(error.message);
            },
            complete: function() {
                $.unblockUI();
            }
        });
    });



    // Filter
    $(document).on("click", "#btnCssdFilter", function(e) {
        var formID = $("#cssdFilterForm").attr("id");
        var formMethod = $("#cssdFilterForm").attr("method");

        $("#cssdFilterForm").attr('action', "{{ route('cssd.receiveFromDepartmentFilter') }}");
        $.ajax({
            data: $('#' + formID).serialize(),
            url: "{{ route('cssd.receiveFromDepartmentFilter') }}",
            type: formMethod,
            beforeSend: function() {
                blockUI();
            },
            success: function(response) {
                $("#receive-from-department-table").html(response);
                $("#details_block").html('');
            },
            complete: function() {
                $.unblockUI();
            }
        });
    });
</script>
