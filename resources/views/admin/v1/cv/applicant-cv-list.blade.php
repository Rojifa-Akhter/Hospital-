<style>
    .upload_label {
        position: absolute;
        left: 50%;
        top: 100%;
        transform: translate(-50%, 0%);
    }

    label.custom-file-label.form-control.upload_app_label {
        line-height: 1.7;
    }
</style>
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('datatables/media/css/jquery.dataTables.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<main id="page-content">
    {{-- <form action="#" id="" method="post"> --}}
    <section class="hr_payroll">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div
                        class="row justify-content-between align-items-center bg-white border-bottom sticky-top shadow-sm">
                        <div class="col-md-9">
                            <h5 class="mt-2 mb-0">CV List</h5>
                            <small>HRM / CV List</small>
                        </div>

                        <div class="col-md-3">
                            <div class="btn-group btn-block" role="group">
                                <button type="submit" class="btn btn-info btn-block btn-md mt-0" target="_blank"
                                    value="" id="PDF">Export PDF</button>
                                <button type="submit" class="btn btn-secondary btn-block btn-md mt-0" target="_blank"
                                    value="" id="EXCEL">Export Excel</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <form action="" id="searchApplicantCV" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header bg-success">
                                <h5><i class="fas fa-search"></i> Search</h5>
                            </div>
                            <div class="card-body">
                                <div class="form-row">
                                    <div class="col-lg-2 col-md-2 col-12">
                                        <div class="form-group">
                                            {{-- <label for="circuler_id" class="col-form-label">Circular ID</label> --}}
                                            <label for="circuler" class="col-form-label">Circular</label>
                                            <input type="text" class="form-control form-control-sm" id="circuler"
                                                name="circuler" placeholder="" value="" />
                                        </div>
                                    </div>

                                    <div class="col-lg-2 col-md-2 col-12">
                                        <div class="form-group">
                                            <label for="full_name" class="col-form-label">Name</label>
                                            {{-- <input type="text" class="form-control form-control-sm"
                                                    id="Name" name="name" placeholder="" value="" /> --}}
                                            <select class="form-control font_size_12 m-auto select2" id="full_name"
                                                name="full_name" required>
                                                <option value="">Select Name</option>
                                                @if (!empty($cvList))
                                                    @foreach ($cvList as $info)
                                                        <option value="{{ $info->full_name }}">
                                                            {{ strtoupper($info->full_name) }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-2 col-md-2 col-12">
                                        <div class="form-group">
                                            <label for="deaprtment" class="col-form-label">Department</label>
                                            {{-- <input type="text" class="form-control form-control-sm" id="deaprtment"
                                                name="deaprtment" placeholder="" value="" /> --}}
                                            <select class="form-control font_size_12 m-auto select2" id="deaprtment"
                                                name="deaprtment" required>
                                                <option value="">Select Department</option>
                                                @if (isset($departments))
                                                    @foreach ($departments as $dept)
                                                        <option value="{{ $dept->serviceunit_no_pk }}">
                                                            {{ $dept->serviceunit_name }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-2 col-md-2 col-12">
                                        <div class="form-group">
                                            <label for="mobile" class="col-form-label">Mobile</label>
                                            <input type="text" class="form-control form-control-sm" id="mobile"
                                                name="mobile" placeholder="Mobile No" value="" />
                                        </div>
                                    </div>

                                    <div class="col-lg-2 col-md-2 col-12">
                                        <div class="form-group">
                                            <label for="post" class="col-form-label">Position</label>
                                            {{-- <input type="text" class="form-control form-control-sm"
                                                    id="Position" name="Position" placeholder="" value="" /> --}}
                                            <select class="form-control font_size_12 m-auto select2" id="post"
                                                name="post" required>
                                                <option value="">Select Post</option>
                                                @if (!empty($cvList))
                                                    @foreach ($cvList as $info)
                                                        <option value="{{ $info->post }}">
                                                            {{ strtoupper($info->post) }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>

                                    {{-- <div class="col-lg-2 col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="exprience" class="col-form-label">Experience</label>
                                                <input type="text" class="form-control form-control-sm"
                                                    id="exprience" name="exprience" placeholder="" value="" />
                                            </div>
                                        </div> --}}


                                    {{-- <div class="col-lg-3 col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="Ex-company-name" class="col-form-label">Ex Company
                                                    Name</label>
                                                <input type="text" class="form-control form-control-sm"
                                                    id="Ex-company-name" name="Ex-company-name" placeholder=""
                                                    value="" />
                                            </div>
                                        </div> --}}
                                    {{-- <div class="col-lg-3 col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="university" class="col-form-label">University</label>
                                                {{-- <input type="text" class="form-control form-control-sm"
                                                    id="university" name="university" placeholder=""
                                                    value="" /> --}}

                                    {{-- <select class="form-control font_size_12 m-auto select2" id="university"
                                            name="university" required>
                                            <option value="">Select University</option>
                                            @if (!empty($education))
                                                @foreach ($education as $edu)
                                                    <option value="{{ $edu->cvapplicant_no_fk }}">
                                                        {{ strtoupper($edu->institute_name) }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div> --}}

                                    {{-- <div class="col-lg-3 col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="education" class="col-form-label">Education</label>
                                                <input type="text" class="form-control form-control-sm"
                                                    id="education" name="education" placeholder="" value="" />
                                            </div>
                                        </div> --}}

                                    <div class="col-lg-2 col-md-6 col-12">
                                        <div class="form-group">
                                            <button type="button" class="btn btn-md btn-success mt-4 btn-md-global"
                                                id="searchApplicantCVButton">Search</button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <form action="#" id="" method="post">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body p-2">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead class="global-uhl-table-bg">
                                            <tr>
                                                <th>SL</th>
                                                <th class="text-left">Applicant ID</th>
                                                <th class="text-left">Applicant Date</th>
                                                <th class="text-left">Name</th>
                                                <th class="text-left">Skills</th>
                                                {{-- <th class="text-left">Position</th> --}}
                                                <th class="text-left">Designation</th>
                                                <th class="text-left">Department</th>
                                                {{-- <th class="text-left">Experience</th>
                                                <th class="text-left">Highest Education</th>
                                                <th class="text-left">District</th> --}}

                                                <th style="width:50px;">Uploaded Photo</th>
                                                <th style="width:50px;">Uploaded CV</th>
                                                <th style="width:50px;">Uploaded Circular </th>
                                                <th class="text-center">Status</th>
                                                <th style="width:50px;">Cal For Interview</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="cvListTable">
                                            @include('admin.v1.cv.applicant-cv-search-table')

                                            @if (!empty($cvList))
                                                @foreach ($cvList as $cv)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td class="text-left">{{ $cv->cvapplicant_uid }}</td>
                                                        <td class="text-left">
                                                            {{ isset($cv->cvapplicant_date) ? date('d-m-Y', strtotime($cv->cvapplicant_date)) : '' }}
                                                        </td>
                                                        <td class="text-left"> {{ $cv->full_name }} </td>
                                                        <td class="text-left"> {{ $cv->skill }} </td>
                                                        {{-- <td class="text-left"> {{ $cv->post }} </td> --}}
                                                        <td class="text-left"> {{ $cv->designation }} </td>

                                                        <td class="text-left">{{ $cv->serviceunit_name }}</td>
                                                        {{-- <td class="text-left"> </td>
                                                        <td class="text-left"> </td>
                                                        <td class="text-left"> </td> --}}
                                                        <td class="text-center">
                                                            @if (isset($cv->photo))
                                                                <a href="{{ asset('uploads/cv/' . $cv->photo) }}"
                                                                    target="_blank"><i class="fa fa-paperclip"
                                                                        aria-hidden="true"></i></a>
                                                            @endif
                                                        </td>
                                                        <td class="text-center">
                                                            @if (isset($cv->upload_cv))
                                                                <a href="{{ asset('uploads/cv/' . $cv->upload_cv) }}"
                                                                    target="_blank"><i class="fa fa-paperclip"
                                                                        aria-hidden="true"></i></a>
                                                            @endif
                                                        </td>
                                                        <td class="text-center">
                                                            @if (isset($cv->upload_circuler))
                                                                <a href="{{ asset('uploads/cv/' . $cv->upload_circuler) }}"
                                                                    target="_blank"><i class="fa fa-paperclip"
                                                                        aria-hidden="true"></i></a>
                                                            @endif
                                                        </td>
                                                        {{-- <td class="text-center">
                                                            @if ($cv->applicant_status == 1)
                                                                <span class="badge badge-primary">Applicant</span>
                                                            @else
                                                                <span class="badge badge-danger">Applicant</span>
                                                            @endif
                                                        </td> --}}
                                                        <td class="text-center">
                                                            @if ($cv->call_for_interview == 1)
                                                                <span class="badge badge-primary">Interview</span>
                                                            @else
                                                                <span class="badge badge-danger">Applicant</span>
                                                            @endif
                                                        </td>
                                                        <td class="text-center">
                                                            <input type="checkbox" id="call_for_interview"
                                                                name="call_for_interview" value="1"
                                                                onclick="callforInterview(this,{{ $cv->cvapplicant_no_pk }})"
                                                                {{ $cv->call_for_interview == 1 ? 'checked' : '' }}>
                                                        </td>
                                                        <td>
                                                            <a href="{{ route('v1.hrm.cv-edit', $cv->cvapplicant_no_pk) }}"
                                                                rel="tab"class="btn btn-sm btn-success">Edit</a>
                                                            <a href="{{ route('v1.hrm.cv-view', $cv->cvapplicant_no_pk) }}"
                                                                class="btn btn-sm btn-info" target="_blank">View</a>
                                                            @if ($cv->call_for_interview == 1)
                                                                <a href="#" class="btn btn-sm btn-danger"
                                                                    onclick="deleteApplicantCV({{ $cv->cvapplicant_no_pk }})"
                                                                    hidden>Discard</a>
                                                            @else
                                                                <a href="#" class="btn btn-sm btn-danger"
                                                                    onclick="deleteApplicantCV({{ $cv->cvapplicant_no_pk }})">Discard</a>
                                                            @endif
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


            </form>


        </div>
    </section>
    {{-- </form> --}}
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


    $(document).on("click", "#searchApplicantCVButton", function(e) {

        var formID = $("#searchApplicantCV").attr("id");
        var formMethod = $("#searchApplicantCV").attr("method");
        console.log('ok');

        $.ajax({
            data: $('#' + formID).serialize(),
            url: "{{ route('v1.hrm.search_cv_list') }}",
            type: "post",
            beforeSend: function() {
                blockUI();

            },
            success: function(data) {
                console.log(data);
                $("#cvListTable").html(data);
            },
            complete: function() {
                $.unblockUI();
            }
        });
    });

    function deleteApplicantCV(cvapplicant_no_pk) {
        console.log(cvapplicant_no_pk);
        var con = confirm('Are you sure?');
        if (con == true) {
            $.ajax({
                type: "post",
                data: {
                    'cvapplicant_no_pk': cvapplicant_no_pk
                },
                url: "{{ route('v1.hrm.remove-applicant-cv', 'cvapplicant_no_pk') }}",
                beforeSend: function() {
                    blockUI();
                },
                success: function(data) {
                    // $("#cvListTable").html(data);
                },
                complete: function(data) {
                    $('.common-modal-notify').modal('show');
                    $('.common-modal-notify .modal-title').html("Success");
                    $('.common-modal-notify .modal-body').html("Data removed successfully.");
                    $.unblockUI();
                }
            });

        } else {
            return false;
        }
    }



    function callforInterview(element, cvapplicant_no_pk) {
        var con = confirm('Are you sure?');

        var call_for_interview = null;
        if ($(element).is(':checked')) {
            call_for_interview = (event.target.value);
        } else {
            call_for_interview = 0;
        }
        console.log(call_for_interview);

        if (con == true) {
            $.ajax({
                type: "post",
                data: {
                    'cvapplicant_no_pk': cvapplicant_no_pk,
                    'call_for_interview': call_for_interview
                },
                url: "{{ route('v1.hrm.update-applicant-interview', 'cvapplicant_no_pk') }}",
                beforeSend: function() {
                    blockUI();
                },
                success: function(data) {
                    console.log(data);
                    window.location.href = "cv-list";
                },
                complete: function(data) {
                    $('.common-modal-notify').modal('show');
                    $('.common-modal-notify .modal-title').html("Success");
                    $('.common-modal-notify .modal-body').html(
                        "Selected the applicant successfully.");
                    $.unblockUI();
                }
            });
        }
    }
</script>
