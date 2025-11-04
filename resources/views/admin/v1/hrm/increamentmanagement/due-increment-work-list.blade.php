<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<main id="page-content">
        <section class="hr_payroll">
            <div class="container-fluid">
                <div class="row bg-white border-bottom sticky-top shadow-sm">
                    <div class="col-md-12">
                        <h5 class="mt-2 mb-0">Due Increment Work List</h5>
                        <small>HRM / Due Increment Work List</small>
                    </div>
                </div>
                <form method="post" id="searchEmployeeDueIncrmForm">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body p-2">
                                    <div class="form-row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="date">Date</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control date_picker" name="date_from"
                                                    autocomplete="off" placeholder="From Date"  />
                                                    <input type="text" class="form-control date_picker" name="date_to"
                                                    autocomplete="off" placeholder="To Date"  />
                                                    {{-- <input type="text" id="date" name="date" class="form-control" placeholder="From" required="" />
                                                    <input type="text" id="" name="" class="form-control" placeholder="To" required="" /> --}}
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
                                        <div class="col-md-2">
                                            <button type="button"  id="searchEmployeeDueIncrmStatus"class="btn btn-md btn-secondary mt-4 btn-md-global">Search</button>
                                        </div>
                                        <div class="col-lg-1 col-md-6 col-12"></div>
                                        {{-- <div class="col-lg-2 col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="increment" class="col-form-label">Increment(%)</label>
                                                <input type="text" class="form-control form-control-sm" id="increment" name="increment" placeholder="" value="" />
                                            </div>
                                        </div> --}}
                                        {{-- <div class="col-md-1 text-right">
                                            <button type="button" id="" class="btn btn-md btn-secondary mt-4 btn-md-global">Set Proposed</button>
                                        </div> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body p-2">
                                <div class="table-responsive" id="due-increament-table">
                                    @include('admin.v1.hrm.increamentmanagement.due-increment-list-table')
                                </div>
                            </div>
                        </div>
                    </div>
                {{-- </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card mb-2">
                            <div class="card-body">
                                <div class="form-group">
                                    <ul class="list-inline btn__box">
                                        <li class="list-inline-item">
                                            <button type="button" class="btn btn-secondary uhl_save_btn" id="">Save</button>
                                        </li>
                                        <li class="list-inline-item"><button type="button" class="btn btn-danger">Cancel</button></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}
            </div>
        </section>
</main>
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

        $(document).on("click", "#searchEmployeeDueIncrmStatus", function(e) {
        // if ($('#card_hidn').val() =="") {
        //     alert('Enter Referral Code');
        //     return;
        // }

        var formID = $("#searchEmployeeDueIncrmForm").attr("id");
        var formMethod = $("#searchEmployeeDueIncrmForm").attr("method");

        $.ajax({
            data: $('#' + formID).serialize(),
            url: "{{ route('v1.hrm.search-employee-due-increament') }}",
            type: "post",
            beforeSend: function() {
                blockUI();

            },
            success: function(data) {
                $("#due-increament-table").html(data);
            },
            complete: function() {
                $.unblockUI();
            }
        });
    });

    </script>
