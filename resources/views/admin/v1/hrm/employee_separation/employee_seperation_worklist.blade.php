<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<main id="page-content">
    <form action="" id="SeperationWorklistSearch" method="POST" target="_blank">
        @csrf
        <section class="hr_payroll">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div
                            class="row justify-content-between align-items-center bg-white border-bottom sticky-top shadow-sm">
                            <div class="col-md-9">
                                <h5 class="mt-2 mb-0">Employee Seperation</h5>
                                <small>HRM / Employee Seperation</small>
                            </div>

                            <div class="col-md-3">
                                <div class="btn-group btn-block" role="group">
                                    <button type="submit" class="btn btn-info btn-block btn-md mt-0 print"
                                        value="1" id="PDF">Export PDF</button>
                                    <button type="submit" class="btn btn-secondary btn-block btn-md mt-0 print"
                                        value="2" id="EXCEL">Export Excel</button>

                                    {{-- <button type='submit'
                                        class="btn btn-info btn-block btn-md btn-md-global mt-0 print" value="1"><i
                                            class="fa fa-file-pdf"></i> Export PDF</button>
                                    <button type='submit'
                                        class="btn btn-primary btn-block btn-md btn-md-global mt-0 print"
                                        value="2"><i class="far fa-file-excel"></i> Export EXCEL</button> --}}
                                </div>
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
                            <div class="card-body">
                                <div class="form-row">

                                    <div class="col-lg-2 col-md-3 col-12">
                                        <div class="form-group">
                                            <label for="department" class="col-form-label">Department</label>
                                            <select class="form-control form-control-sm select2" name="department"
                                                id="department">
                                                <option value="">Select</option>
                                                @if (!empty($departments))
                                                    @foreach ($departments as $department)
                                                        <option value="{{ $department->serviceunit_no_pk }}">
                                                            {{ $department->serviceunit_name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-2 col-md-2 col-12">
                                        <div class="form-group">
                                            <label for="separation_type" class="col-form-label">Separation Type</label>
                                            <select class="form-control form-control-sm select2" name="separation_type"
                                                id="separation_type">
                                                <option value="">Select</option>
                                                <option value="Resignation">Resignation</option>
                                                <option value="Termination">Termination</option>
                                                <option value="Unauthorised">Unauthorised</option>
                                                <option value="Retirement">Retirement</option>
                                                <option value="Poor Performance">Poor Performance</option>
                                                <option value="Long Time Absent">Long Time Absent</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-1 col-md-3 col-12">
                                        <div class="form-group">
                                            <label for="separation_status" class="col-form-label">Status</label>
                                            <select class="form-control form-control-sm" name="separation_status"
                                                id="separation_status">
                                                <option value="">Select</option>
                                                <option value="POST">POST</option>
                                                <option value="DRAFT">DRAFT</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="from_date" class="col-form-label">Seperation Date</label>
                                            <div class="input-group">
                                                <input type="text" id="from_date" name="from_date"
                                                    class="form-control date_picker" placeholder="From Date" />
                                                <input type="text" id="to_date" name="to_date"
                                                    class="form-control date_picker" placeholder="To Date" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-1">
                                        <button type="button" id="SeperationWorklistSearchButton"
                                            class="btn btn-md btn-success mt-4 btn-md-global">Search</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body p-2">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead class="global-uhl-table-bg">
                                            <tr>
                                                <th class="text-left">SL</th>
                                                <th class="text-left">Emp ID</th>
                                                <th class="text-left">Name</th>
                                                <th class="text-left">Designation</th>
                                                <th class="text-left">Department</th>
                                                <th class="text-left">Joining Date</th>
                                                <th class="text-left">Job Length</th>
                                                <th class="text-left">Date of Application</th>
                                                <th class="text-left">Type</th>
                                                <th class="text-left">Exp. Date of Separation</th>
                                                <th class="text-left">Last Working Day</th>
                                                <th class="text-left">Remarks</th>
                                                <th class="text-center">Status</th>
                                                <th class="text-center">Attachment</th>
                                                {{-- <th class="text-center">Approval Status</th> --}}
                                                <th class="text-center">Action</th>

                                            </tr>
                                        </thead>
                                        <tbody id="EmployeeSeperationTable">
                                            @include('admin.v1.hrm.employee_separation.employee_seperation_worklist_search_table')
                                            {{-- @if (!empty($employee_separation_data))
                                                @foreach ($employee_separation_data as $data)
                                                    <tr>
                                                        <td class="text-left">{{ $loop->iteration }}</td>
                                                        <td class="text-left">{{ $data->emp_seprtn_person_no_fk }}</td>
                                                        <td class="text-left">{{ $data->employee_name }}</td>
                                                        <td class="text-left">{{ $data->designation_name }}</td>
                                                        <td class="text-left">{{ $data->serviceunit_name }}</td>
                                                        <td class="text-left">
                                                            {{ date('Y/m/d', strtotime($data->join_date)) }}</td>
                                                        <td class="text-left">{{ $data->job_length }}</td>
                                                        <td class="text-left">{{ $data->emp_seprtn_application_date }}
                                                        </td>
                                                        <td class="text-left">{{ $data->seprtn_type }}</td>
                                                        <td class="text-left">{{ $data->emp_seprtn_expected_date }}
                                                        </td>
                                                        <td class="text-left">
                                                            {{ $data->emp_seprtn_application_remarks }}</td>
                                                        <td class="text-center">{{ $data->save_option }}</td>
                                                        <td class="text-center"></td>
                                                        <td class="text-center">
                                                            <a href="#"
                                                                class="btn btn-md btn-outline-primary"><i
                                                                    class="fas fa-eye"></i></a>
                                                        </td>
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
        </section>
    </form>
</main>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script>
    $(document).ready(function() {

        $('.data-table').DataTable({
            // "ordering": false,
            "searching": true,
        });

        $("body").addClass("sidebar-collapse");
        $('.select2').select2();
        $(".date_picker").datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true,
            clearBtn: true
        });

    });


    $(document).on("click", "#SeperationWorklistSearchButton", function(e) {

        var formID = $("#SeperationWorklistSearch").attr("id");
        var formMethod = $("#SeperationWorklistSearch").attr("method");
        console.log('ok');

        $.ajax({
            data: $('#' + formID).serialize(),
            url: "{{ route('v1.hrm.search-seperation-worklist') }}",
            type: "post",
            beforeSend: function() {
                blockUI();

            },
            success: function(data) {
                console.log(data);
                $("#EmployeeSeperationTable").html(data);
            },
            complete: function() {
                $.unblockUI();
            }
        });
    });

    $(document).on("click", ".print", function(e) {
        var print = $(this).val();
        if (print == 1) {
            $('form').attr('action', "{{ route('v1.hrm.employee-separation-worklist-print') }}");
        }
        if (print == 2) {
            $('form').attr('action', "{{ route('v1.hrm.employee-separation-worklist-excel') }}");
        }
    });
</script>
