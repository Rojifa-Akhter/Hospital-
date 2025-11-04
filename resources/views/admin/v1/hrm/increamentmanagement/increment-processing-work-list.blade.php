<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">

<main id="page-content">
        <section class="hr_payroll">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row bg-white border-bottom sticky-top shadow-sm">
                            <div class="col-md-12">
                                <h5 class="mt-2 mb-0">Increment Processing Work List</h5>
                                <small>HRM / Increment Processing Work List</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header bg-success">
                                <h5><i class="fas fa-search"></i> Search</h5>
                            </div>
                            <form method="post" id="searchEmployeeIncreamentProcessingForm">
                                @csrf
                                <div class="card-body">
                                    <div class="form-row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="from_date">Date</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control date_picker" name="date_from" 
                                                    autocomplete="off" placeholder="From Date"  />
                                                    <input type="text" class="form-control date_picker" name="date_to" 
                                                    autocomplete="off" placeholder="To Date"  />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="department" class="col-form-label">Department</label>
                                                <select class="form-control form-control-sm  select2"
                                                    id="department" name="department">
                                                    <option value="">Select Department</option>
                                                    @if (!empty($service_unit))
                                                        @foreach ($service_unit as $service)
                                                            <option value="{{ $service->serviceunit_no_pk }}">
                                                                {{ strtoupper($service->serviceunit_name) }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-1">
                                            <button type="button" id="searchEmployeeIncProcessingStatus" class="btn btn-md btn-success mt-4 btn-md-global">Search</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body p-2">
                                <div class="table-responsive" id="increment-processing-list-table">
                                    @include('admin.v1.hrm.increamentmanagement.increment-processing-list-table')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
 
</main>
<script>
    $("body").addClass("sidebar-collapse");

</script>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Notification Award</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-row">
                    <div class="col-lg-7 col-md-12 col-12">
                        <div class="form-group">
                            <label for="effective-date" class="col-form-label">Effective Date</label>
                            <input type="text" class="form-control form-control-sm" id="effective-date" name="effective-date" placeholder="" value="" />
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-12 col-12">
                        <div class="form-group">
                            <label for="amount" class="col-form-label">Amount</label>
                            <input type="text" class="form-control form-control-sm" id="amount" name="amount" placeholder="" value="" />
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-12">
                        <div class="form-group">
                            <label for="remarks" class="col-form-label">Remarks</label>
                            <textarea class="form-control form-control-sm" name="remarks" id="remarks" rows="3"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary uhl_save_btn">Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script>
$("body").addClass("sidebar-collapse");
$('.select2').select2();
    $(function() {
            $('.date_picker').datepicker({
                todayHighlight: true,
                clearBtn: true,
                autoclose: true,
                // endDate: '+0d',
                format: 'dd-mm-yyyy',
            });
        });

    $(document).on("click", "#searchEmployeeIncProcessingStatus", function(e) {
        var formID = $("#searchEmployeeIncreamentProcessingForm").attr("id");
        var formMethod = $("#searchEmployeeIncreamentProcessingForm").attr("method");

        $.ajax({
            data: $('#' + formID).serialize(),
            url: "{{ route('v1.hrm.search-employee-increament-processing') }}",
            type: "post",
            beforeSend: function() {
                blockUI();

            },
            success: function(data) {
                $("#increment-processing-list-table").html(data);
            },
            complete: function() {
                $.unblockUI();
            }
        });
    });

</script>
