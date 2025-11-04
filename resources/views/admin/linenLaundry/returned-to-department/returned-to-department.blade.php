<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<style>
    .text-left{
        text-align:left;
    }
</style>

<section id="full_appointment">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-7 mb-1">
                <h5 class="mt-2 mb-0">Linen & Laundry</h5>
                <small>Linen & Laundry / Returned to Department</small>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-lg-12">
                <form action="" method="POST" id="linenLaundryFilterForm" class="searchPOWorklist">
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
                                                <label for="reqmst_no_pk" class="col-sm-4 col-form-label">ID No</label>
                                                <div class="col-sm-8">
                                                    <input class="form-control" type="number" id="reqmst_no_pk" name="reqmst_no_pk" placeholder="ID No" />
                                                </div>
                                            </div>
                                        </div>
    
                                        {{-- Date Range --}}
                                        <div class="col-md-3 col-12">
                                            <div class="form-group form-row">
                                                <label for="from_date" class="col-sm-4 col-form-label">From/To Date</label>
                                                <div class="col-sm-8">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control form-control-sm" placeholder="From Date" name="from_date" id="from_date" autocomplete="off">
                                                        <input type="text" class="form-control form-control-sm" placeholder="To Date" name="to_date" id="to_date" autocomplete="off">
                                                      </div>                                                           
                                                </div>
                                            </div>
                                        </div>
    
                                        {{-- Department --}}
                                        <div class="col-md-3 col-12">
                                            <div class="form-group form-row">
                                                <label for="serviceunit_no_fk" class="col-sm-4 col-form-label">Department</label>
                                                <div class="col-sm-8">
                                                    <select class="form-control form-control-sm select2" name="serviceunit_no_fk" id="serviceunit_no_fk">
                                                        <option value="" selected disabled>Select department</option>
                                                        @if (!empty($departments))
                                                            @foreach ($departments as $department)
                                                                <option value="{{ $department->serviceunit_no_pk }}">{{ $department->serviceunit_name }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
    
                                        <div class="col-md-2 col-12">
                                            <div class="form-group form-row">
                                                <div class="co-12">
                                                    <button class="btn btn-md-global btn-success" id="btnCssdFilter" type="button">Search</button>
                                                    {{-- <button class="btn btn-md-global btn-danger" type="reset" onclick="resetForm()">Reset</button> --}}
                                                    <a rel="tab" href="{{ route('linenLaundry.returnedToDepartment') }}" class="btn btn-md-global btn-danger">Reset</a>
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
                            @include('admin.linenLaundry.returned-to-department.returned-to-department-table')
                        </div>
                    </div>
                </div>
                <div id="details_block">
                    @include('admin.linenLaundry.returned-to-department.returned-to-department-details')
                </div>
                <div id="history_block">
                    @include('admin.linenLaundry.history')
                </div>
            </div>
        </div>
    </div>
</section>

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

    function showDetails(id)
    {
        let route = "{{ route('linenLaundry.returnedToDepartmentDetails', ['id' => ':id']) }}";
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
            error:function(err) {
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

    function showHistory(id)
    {
        let route = "{{ route('linenLaundry.history', ['id' => ':id']) }}";
        route = route.replace(':id', id);

        $.ajax({
            url: route,
            method: "GET",
            beforeSend: function() {
                blockUI();
            },
            success: function(response) {
                $('#history_block').html(response);
            },
            error:function(err) {
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

    // Filter
    $(document).on("click", "#btnCssdFilter", function(e) {
        var formID = $("#linenLaundryFilterForm").attr("id");
        var formMethod = $("#linenLaundryFilterForm").attr("method");

        $.ajax({
            data: $('#' + formID).serialize(),
            url: "{{ route('linenLaundry.returnedToDepartmentFilter') }}",
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
