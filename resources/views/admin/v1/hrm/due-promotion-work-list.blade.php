<style>
    label.custom-file-label.form-control.upload_app_label {
        line-height: 1.7;
    }
</style>
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<link rel="stylesheet" href="{{ asset('datatables/media/css/jquery.dataTables.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<main id="page-content">
    <section class="hr_payroll">
        <div class="container-fluid">
            <div class="row bg-white border-bottom sticky-top shadow-sm">
                <div class="col-md-12">
                    <h5 class="mt-2 mb-0">Due Promotion WorkList</h5>
                    <small>HRM / Due Promotion WorkList</small>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header bg-success">
                            <h5><i class="fas fa-search"></i> Search</h5>
                        </div>
                        <form action="#" method="post" id="searchPromotion">
                            @csrf
                            <div class="card-body">
                                <div class="form-row">

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="date" class="col-form-label">Date</label>
                                            <div class="input-group">
                                                <input type="text" id="from_date" name="from_date"
                                                    class="form-control form-control-sm date_picker" placeholder="From"
                                                    required="" />
                                                <input type="text" id="to_date" name="to_date"
                                                    class="form-control form-control-sm date_picker" placeholder="To"
                                                    required="" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="department" class="col-form-label">Employee</label>
                                            <select class="form-control font_size_12 m-auto select2" id="employee_name"
                                                name="employee_name" required>
                                                <option value="">Select Employee</option>
                                                @if (!empty($employee))
                                                    @foreach ($employee as $emp)
                                                        <option value="{{ $emp->person_no_pk }}">
                                                            {{ strtoupper($emp->full_name) }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="department" class="col-form-label">Department</label>
                                            <select class="form-control font_size_12 m-auto select2" id="su_name"
                                                name="su_name" required>
                                                <option value="">Select Department</option>
                                                @if (!empty($department))
                                                    @foreach ($department as $service)
                                                        <option value="{{ $service->serviceunit_no_pk }}">
                                                            {{ strtoupper($service->serviceunit_name) }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-2 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="from_dseignation" class="col-form-label">From
                                                Grade</label>
                                            <select class="form-control font_size_12 m-auto select2" id="from_grade"
                                                name="from_grade" required>
                                                <option value="">Select One </option>
                                                @if (!empty($grade))
                                                    @foreach ($grade as $value)
                                                        <option value="{{ $value->grade_no_pk }}">
                                                            {{ $value->grade_name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-2 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="to_dseignation" class="col-form-label">To Grade</label>
                                            <select class="form-control font_size_12 m-auto select2" id="to_grade"
                                                name="to_grade" required>
                                                <option value="">Select One </option>
                                                @if (!empty($grade))
                                                    @foreach ($grade as $value)
                                                        <option value="{{ $value->grade_no_pk }}">
                                                            {{ $value->grade_name }} </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-1">
                                        <button type="button" class="btn btn-md btn-success mt-4 btn-md-global"
                                            id="searchPromotionButton">Search</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <form action="{{ route('v1.hrm.promotion_trans_store') }}" method="POST" id="promotion-save"
                enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped data-table table-bordered table-hover"
                                        id="userTable">
                                        <thead class="global-uhl-table-bg">
                                            <tr>
                                                <th>SL</th>
                                                <th class="text-left">Employee ID</th>
                                                <th class="text-left">Name</th>
                                                <th class="text-left">Department</th>
                                                <th class="text-left">Join Date</th>
                                                <th class="text-left">Last Promotion Date</th>
                                                <th class="text-left">Last Designation</th>
                                                <th class="text-left">Current Designation</th>
                                                <th class="text-left">Duration of Current Designation</th>
                                                <th class="text-left">Due Date</th>
                                                <th class="text-left">Current Salary</th>
                                                <th class="text-left">Promoted Designation</th>
                                                <th class="text-left">Apply Increment</th>
                                                <th class="text-left">Increment(%)</th>
                                                <th class="text-left">Est. Increment Amount</th>
                                                <th class="text-left">Est. Increment Salary</th>
                                                {{-- <th class="text-left">Increment Details</th> --}}
                                                {{-- <th class="text-center">Send for Approval</th> --}}
                                                <th class="text-left">Effective Date</th>
                                                <th class="text-center">Action</th>

                                            </tr>
                                        </thead>
                                        <tbody id="duePromotionkListTable">
                                            @include('admin.v1.hrm.due-promotion-work-list-search-table')
                                            {{-- <tr>
                                                <td class="text-left"></td>
                                                <input type="hidden" name="emp_id[]">
                                                <td class="text-left"></td>
                                                <input type="hidden" name="emp_name[]">
                                                <td class="text-left"></td>
                                                <input type="hidden" name="department[]">
                                                <td class="text-left"></td>
                                                <input type="hidden" name="join_date[]">
                                                <td class="text-left"></td>
                                                <input type="hidden" name="last_promotion_date[]">
                                                <td class="text-left"></td>
                                                <input type="hidden" name="last_designation[]">
                                                <td class="text-left"></td>
                                                <input type="hidden" name="current_designation[]">
                                                <td class="text-left"></td>
                                                <input type="hidden" name="current_designation_duration[]">
                                                <td class="text-left"></td>
                                                <input type="hidden" name="date_of_due[]">
                                                <td class="text-left"></td>
                                                <input type="hidden" name="gross_salary[]">
                                                <td class="text-left"></td>
                                                <input type="hidden" name="expected_designation[]">
                                                 <td class="text-left"></td>
                                                <input type="checkbox" name="">
                                                <td class="text-left"></td>
                                                <input type="hidden" name="increment[]">
                                                <td class="text-left"></td>
                                                <input type="hidden" name="estimated_increment_amout[]">
                                                <td class="text-left"></td>
                                                <input type="hidden" name="estimated_increment_salary[]">
                                                <td class="text-left"></td>
                                                <input type="hidden" name="increment_details[]"> --}}
                                            {{-- <td class="text-center">
                                                    <input type="checkbox" id="" name="">
                                                </td>
                                                <td class="text-center"></td> --}}

                                            {{-- </tr> --}}


                                        </tbody>

                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12 col-md-12 col-12">
                        <div class="card">
                            <div class="card-body p-2">
                                <div class="form-group">
                                    <ul class="list-inline btn__box">
                                        <li class="list-inline-item mb-0 mt-0">
                                            @php
                                                $response_action = route('v1.hrm.promotion_work_list');
                                            @endphp
                                            <button class="btn btn-secondary uhl_save_btn"
                                                onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">
                                                Save</button>
                                        </li>

                                        {{-- <li class="list-inline-item"><button type="button"
                                                class="btn btn-danger">Cancel</button></li> --}}
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </form>

        </div>
    </section>
</main>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}">
</script>
<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2();
    });

    $('.data-table').DataTable({
        "ordering": true,
        "bPaginate": false,
        "bLengthChange": false,
        "bAutoWidth": false,
        "paging": true,
        "searching": true,
    });

    $("body").addClass("sidebar-collapse");
    $(".date_picker").datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        todayHighlight: true,
        clearBtn: true
    });


    $(document).on("click", "#searchPromotionButton", function(e) {

        var formID = $("#searchPromotion").attr("id");
        var formMethod = $("#searchPromotion").attr("method");

        $.ajax({
            data: $('#' + formID).serialize(),
            url: "{{ route('v1.hrm.search_promotion_work_list') }}",
            type: "post",
            beforeSend: function() {
                blockUI();

            },
            success: function(data) {
                console.log(data);
                $("#duePromotionkListTable").html(data);
            },
            complete: function() {
                $.unblockUI();
            }
        });
    });
</script>
