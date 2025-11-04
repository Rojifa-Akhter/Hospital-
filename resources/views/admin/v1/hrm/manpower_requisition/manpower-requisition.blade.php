<style>
    label.custom-file-label.form-control.upload_app_label {
        line-height: 1.7;
    }
</style>
<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<main id="page-content">
    {{-- <form action="#" id="" method="post"> --}}
    <section class="hr_payroll">
        <div class="container-fluid">
            <div class="row bg-white border-bottom sticky-top shadow-sm">
                <div class="col-md-12">
                    <h5 class="mt-2 mb-0">Manpower Requisition</h5>
                    <small>HRM / Manpower Requisition / Manpower Requisition</small>
                </div>
            </div>
            <form action="{{ route('v1.hrm.manpower-requisition-save') }}" method="post" id="RequisitionForm"
                enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-row">

                                    <input type="hidden" class="form-control form-control-sm" id="manpowreq_no_uid"
                                        name="manpowreq_no_uid" placeholder="" value="{{ $manpowreq_no_uid }}" />
                                    <input type="hidden" class="form-control form-control-sm" id="hdnmanpowreq_no_pk"
                                        name="hdnmanpowreq_no_pk" placeholder="" value="" />

                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="designation_no_fk" class="col-form-label">Designation</label>

                                            <select name="designation_no_fk" id="designation_no_fk"
                                                class="form-control select2">
                                                <option value="">Select</option>
                                                @if (!empty($hrms_designation))
                                                    @foreach ($hrms_designation as $designation)
                                                        <option value="{{ $designation->designation_no_pk }}">
                                                            {{ $designation->designation_name }}</option>
                                                    @endforeach

                                                @endif
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="su_no_fk" class="col-form-label">Department</label>
                                            <select name="su_no_fk" id="su_no_fk" class="form-control select2">
                                                <option value="">Select</option>
                                                @if (!empty($departments))
                                                    @foreach ($departments as $su_name)
                                                        <option value="{{ $su_name->serviceunit_no_pk }}">
                                                            {{ $su_name->serviceunit_name }}</option>
                                                    @endforeach

                                                @endif
                                            </select>
                                        </div>
                                    </div>


                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="required_skills" class="col-form-label">Skill</label>
                                            <input type="text" class="form-control form-control-sm"
                                                id="required_skills" name="required_skills" placeholder=""
                                                value="" />
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="shortage_staff_qty" class="col-form-label">Shortage</label>
                                            <input type="text" class="form-control form-control-sm"
                                                id="shortage_staff_qty" name="shortage_staff_qty" placeholder=""
                                                value="" />
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="expected_date" class="col-form-label">Expected Date</label>
                                            <input type="text" class="form-control form-control-sm date_picker"
                                                id="expected_date" name="expected_date" placeholder="" value="" />
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="salary_range" class="col-form-label">Salary Range</label>
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" id="salary_rangefrom"
                                                    name="salary_rangefrom">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">TO</span>
                                                </div>
                                                <input type="text" class="form-control" id="salary_rangeto"
                                                    name="salary_rangeto">
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-lg-4 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="req_remarks" class="col-form-label">Remarks</label>
                                            <input type="text" class="form-control form-control-sm"
                                                id="req_remarks" name="req_remarks" placeholder="" value="" />
                                        </div>
                                    </div>

                                    <div class="col-lg-1">
                                        <div class="form-group">
                                            <label for="remarks" class="col-form-label"></label>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="urgent_ind"
                                                    id="urgent_ind" />
                                                <label class="form-check-label" for="urgent_ind">
                                                    Urgent
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    @php
                                        $response_action = route('v1.hrm.manpower-requisition');
                                    @endphp
                                    <div class="col-md-1">
                                        <button type="button" class="btn btn-primary uhl_save_btn mt-3"
                                            onclick="btnSaveUpdateUpload(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')"
                                            id="">Save</button>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover data-table">
                                    <thead class="global-uhl-table-bg">
                                        <tr>
                                            <th class="text-center">SL</th>
                                            <th class="text-center">Designation</th>
                                            <th class="text-center">Department</th>
                                            <th class="text-center">Skill</th>
                                            <th class="text-center">Shortage</th>
                                            <th class="text-center">Urgent</th>
                                            <th class="text-center">Expected Date</th>
                                            <th class="text-center">Salary Range</th>
                                            <th class="text-center">Remarks</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (!empty($manpowreq_data))
                                            @foreach ($manpowreq_data as $data)
                                                <tr>
                                                    <td class="text-center">{{ $loop->iteration }}</td>
                                                    <td class="text-center">{{ $data->designation_name }}</td>
                                                    <td class="text-center">{{ $data->serviceunit_name }}</td>
                                                    <td class="text-center">{{ $data->required_skills }}</td>
                                                    <td class="text-center">{{ $data->shortage_staff_qty }}</td>
                                                    <td class="text-center">
                                                        @if ($data->urgent_ind == 1)
                                                            <span style="background-color: red;">Yes</span>
                                                        @elseif ($data->urgent_ind == 0)
                                                            <span style="background-color: green;">No</span>
                                                        @endif
                                                    </td>
                                                    <td class="text-center">
                                                        {{ $data->expected_date ? date('Y-m-d', strtotime($data->expected_date)) : '' }}
                                                    </td>
                                                    <td class="text-center">{{ $data->salary_range }}</td>
                                                    <td class="text-center">{{ $data->req_remarks }}</td>
                                                    <td class="text-center">
                                                        <button class="btn btn-success btn-sm"
                                                            onclick="RequisitionUpdate({{ $data->manpowreq_no_pk }})"><i
                                                                class="far fa-edit"></i></button>
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
    </section>
    {{-- </form> --}}
</main>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>

<script>
    $(document).ready(function() {
        $('.select2').select2();

        $('.data-table').DataTable({
            // "ordering": false,
            "searching": true,
        });
    });

    $(".date_picker").datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        todayHighlight: true,
        clearBtn: true
    });

    function RequisitionUpdate(manpowreq_no_pk) {
        // console.log(manpowreq_no_pk);
        $.ajax({
            type: 'get',
            url: '{{ route('v1.hrm.manpowreq-edit') }}',
            data: {
                manpowreq_no_pk: manpowreq_no_pk
            },
            success: function(data) {
                // console.log(data);
                $("#hdnmanpowreq_no_pk").val(data.manpowreq_no_pk);
                $("#designation_no_fk").val(data.designation_no_fk).trigger('change');
                $("#su_no_fk").val(data.su_no_fk).trigger('change');
                $("#required_skills").val(data.required_skills);
                $("#shortage_staff_qty").val(data.shortage_staff_qty);
                var datePart = data.expected_date.split(" ")[0];
                $("#expected_date").val(datePart);

                var salary_range = data.salary_range;
                var [minSalary, maxSalary] = salary_range.split(" - ");
                $("#salary_rangefrom").val(minSalary);
                $("#salary_rangeto").val(maxSalary);

                $("#req_remarks").val(data.req_remarks);
                if (data.urgent_ind === "1") {
                    $('input[name="urgent_ind"]').prop('checked', true);
                }

            },
            error: function() {

            }
        });
    }
</script>
