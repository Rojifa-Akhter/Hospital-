<style>
    label.custom-file-label.form-control.upload_app_label {
        line-height: 1.7;
    }
</style>
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<main id="page-content">

    <section class="hr_payroll">
        <div class="container-fluid">
            <div class="row bg-white border-bottom sticky-top shadow-sm">
                <div class="col-md-12">
                    <h5 class="mt-2 mb-0">Job Circulation Work List</h5>
                    <small>HRM / Job Circulation Work List</small>
                </div>
            </div>

            <form action="#" method="post" id="searchCircular">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header bg-success">
                                <h5><i class="fas fa-search"></i> Search</h5>
                            </div>
                            <div class="card-body">
                                <div class="form-row">
                                    <div class="col-lg-4 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="position" class="col-form-label">Position</label>
                                            <select class="form-control select2" id="position" name="position">
                                                <option value="">Select</option>
                                                @if (isset($data))
                                                    @foreach ($data as $value)
                                                        <option value="{{ $value->position_name }}">
                                                            {{ $value->position_name }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="designation" class="col-form-label">Designation</label>
                                            <select class="form-control select2" id="designation" name="designation">
                                                <option value="">Select</option>
                                                @if (isset($data))
                                                    @foreach ($data as $value)
                                                        <option value="{{ $value->designation_name }}">
                                                            {{ $value->designation_name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>


                                    <div class="col-lg-4 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="department" class="col-form-label">Department</label>
                                            <select class="form-control select2" id="department" name="department">
                                                <option value="">Select</option>
                                                @if (isset($data))
                                                    @foreach ($data as $value)
                                                        <option value="{{ $value->serviceunit_name }}">
                                                            {{ $value->serviceunit_name }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-6 col-12">
                                        <div class="form-group">
                                            <label class="col-form-label col-form-label-sm"
                                                for="search_date_from">Closing Date</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">From</div>
                                                </div>
                                                <input type="text" class="form-control form-control-sm date_picker"
                                                    id="search_date_from" name="search_date_from" value=""
                                                    placeholder="" />
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">To</div>
                                                </div>
                                                <input type="text" class="form-control form-control-sm date_picker"
                                                    id="search_date_to" name="search_date_to" placeholder="" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <button type="button" id="jobCircularSearchButton"
                                            class="btn btn-md btn-success mt-4 btn-md-global">Search</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            {{-- <form action="#" id="" method=""> --}}
            {{-- @csrf --}}
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead class="global-uhl-table-bg">
                                        <tr>
                                            <th class="text-left">SL</th>
                                            <th class="text-left">Circular ID</th>
                                            <th class="text-left">Circular Date</th>
                                            <th class="text-left">Position</th>
                                            <th class="text-left">Designation</th>
                                            <th class="text-left">Department</th>
                                            <th class="text-left">Closing Date</th>
                                            <th class="text-left">Applicant</th>
                                            <th class="text-left">No. of Inteview Called</th>
                                            <th class="text-left">Employeed</th>
                                            <th class="text-center" style="width:120px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="jobCircularWorklistTable">
                                        @include('admin.v1.hrm.hrmselection.job-circulation-work-list-search-table')
                                        @if (!empty($data))
                                            @foreach ($data as $work_list_data)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td class="text-left">{{ $work_list_data->jobcircular_uid }}
                                                    </td>
                                                    <td class="text-left">
                                                        {{ date('d/m/Y', strtotime($work_list_data->jobcircular_date)) }}
                                                    </td>
                                                    <td class="text-left">{{ $work_list_data->position_name }}</td>
                                                    <td class="text-left">{{ $work_list_data->designation_name }}
                                                    </td>
                                                    <td class="text-left">{{ $work_list_data->serviceunit_name }}
                                                    </td>
                                                    <td class="text-left">
                                                        {{ date('d/m/Y', strtotime($work_list_data->jobcircular_closing_date)) }}
                                                    </td>
                                                    <td class="text-left">
                                                        @if ($work_list_data->total > 1)
                                                            {{ $work_list_data->total . ' Applicants' }}
                                                        @elseif ($work_list_data->total <= 1)
                                                            {{ $work_list_data->total . ' Applicant' }}
                                                        @else{
                                                            {{ $work_list_data->total . ' Applicant' }}
                                                            }
                                                        @endif
                                                    </td>
                                                    <td class="text-left">
                                                        @if ($work_list_data->total_call > 1)
                                                            {{ $work_list_data->total_call . ' Applicants' }}
                                                        @elseif ($work_list_data->total_call <= 1)
                                                            {{ $work_list_data->total_call . ' Applicant' }}
                                                        @else{
                                                            {{ 0 . 'Applicant' }}
                                                            }
                                                        @endif
                                                    </td>
                                                    <td class="text-left"></td>
                                                    <td>
                                                        <a href="{{ route('v1.hrm.job-circulation-edit', $work_list_data->jobcircular_no_pk) }}"
                                                            class="btn mb-1 btn-sm btn-success">Edit</a>
                                                        {{-- <a href="#"
                                                                class="btn mb-1 btn-sm btn-info data-modal="common-modal"
                                                                data-title="View Employee Information"
                                                                title="View Employee Information"">View</a> --}}
                                                        <a class="btn mb-1 btn-info btn-sm open-modal"
                                                            data-modal="common-modal"
                                                            data-action="{{ route('v1.hrm.view-all-applicants', $work_list_data->jobcircular_no_pk) }}"
                                                            data-title="All Applicants for this Circular">View
                                                            Applicant</a>
                                                        <a href="{{ route('v1.hrm.cv-entry', $work_list_data->jobcircular_no_pk) }}"
                                                            class="btn mb-1 btn-sm btn-success" target="_blank">Add
                                                            Applicant</a>
                                                        <a data-modal="common-modal"
                                                            data-action="{{ route('v1.hrm.view-circular', $work_list_data->jobcircular_no_pk) }}"
                                                            class="btn mb-1 btn-info btn-sm open-modal"
                                                            data-title="View Circular">View
                                                            Circular
                                                        </a>
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
            {{-- </form> --}}

        </div>
    </section>
</main>
<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>

<script>
    $(document).ready(function() {
        $('.select2').select2();
    });
    $(".date_picker").datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        todayHighlight: true,
        clearBtn: true
    });


    $(document).on("click", "#jobCircularSearchButton", function(e) {
        var formID = $("#searchCircular").attr("id");
        var formMethod = $("#searchCircular").attr("method");

        $.ajax({
            data: $('#' + formID).serialize(),
            url: "{{ route('v1.hrm.job-circulation-search') }}",
            type: "post",
            beforeSend: function() {
                blockUI();
            },
            success: function(data) {
                $("#jobCircularWorklistTable").html(data);
            },
            complete: function() {
                $.unblockUI();
                $("#searchCircular").reset();
            }
        });
    });
</script>
