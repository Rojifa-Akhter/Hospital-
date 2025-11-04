<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<main id="page-content">
    <form action="" target="_blank" class="searchmanpowreq" method="post" id="requisitionSearch">
        @csrf
        <section class="hr_payroll">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div
                            class="row justify-content-between align-items-center bg-white border-bottom sticky-top shadow-sm">
                            <div class="col-md-9">
                                <h5 class="mt-2 mb-0">Manpower Requisition Work list</h5>
                                <small>HRM / Manpower Requisition / Manpower Requisition Work list</small>
                            </div>

                            <div class="col-md-3">
                                <div class="btn-group btn-block" role="group">
                                    <button type='submit'
                                        class="btn btn-info btn-block btn-md btn-md-global mt-0 print" value="1"><i
                                            class="fa fa-file-pdf"></i> Export PDF</button>
                                    <button type='submit'
                                        class="btn btn-primary btn-block btn-md btn-md-global mt-0 print"
                                        value="2"><i class="far fa-file-excel"></i> Export EXCEL</button>
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

                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="designation" class="col-form-label">Designation</label>
                                            <select class="form-control form-control-sm select2" id="designation"
                                                name="designation">
                                                <option value="">Select</option>
                                                @if (!empty($hrms_designation))
                                                    @foreach ($hrms_designation as $designations)
                                                        <option value="{{ $designations->designation_no_pk }}">
                                                            {{ $designations->designation_name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="deaprtment" class="col-form-label">Department</label>
                                            <select class="form-control form-control-sm select2" id="deaprtment"
                                                name="deaprtment">
                                                <option value="">Select</option>
                                                @if (!empty($departments))
                                                    @foreach ($departments as $dept)
                                                        <option value="{{ $dept->serviceunit_no_pk }}">
                                                            {{ $dept->serviceunit_name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="skill" class="col-form-label">Skill</label>
                                            <input type="text" class="form-control form-control-sm" id="skill"
                                                name="skill" placeholder="" value="" />
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <button type="button" class="btn btn-md btn-success mt-4 btn-md-global"
                                            id="requisitionSearchButton">Search</button>
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

                                            </tr>
                                        </thead>
                                        <tbody id="requisitionTable">
                                            @include('admin.v1.hrm.manpower_requisition.requisition-work-search-table')
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
                                                        <td class="text-center">{{ $data->required_skills }}</td>

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
    </form>
</main>

<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>

<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>

<script>
    $(document).ready(function() {
        $('.select2').select2();

        $('.data-table').DataTable({ 
            "searching": true,
        });

        $(".date_picker").datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true,
            clearBtn: true
        });

    });
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


    $(document).on("click", "#requisitionSearchButton", function(e) {
        var formID = $("#requisitionSearch").attr("id");
        var formMethod = $("#requisitionSearch").attr("method");

        $.ajax({
            data: $('#' + formID).serialize(),
            url: "{{ route('v1.hrm.search_hmanpowreq') }}",
            type: "post",
            beforeSend: function() {
                blockUI();
            },
            success: function(data) {
                $("#requisitionTable").html(data);
            },
            complete: function() {
                $.unblockUI();
                // $("#requisitionSearch").reset();
            }
        });
        e.stopImmediatePropagation();
    });

    $(document).on("click", ".print", function(e) {
        var print = $(this).val();
        if (print == 1) {
            $('form').attr('action', "{{ route('v1.hrm.manpowreq-worklist-print') }}");
        }
        if (print == 2) {
            $('form').attr('action', "{{ route('v1.hrm.manpowreq-worklist-excel') }}");
        }
    });

</script>
