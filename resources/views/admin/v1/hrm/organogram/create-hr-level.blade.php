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
    <section class="hr_payroll">
        <div class="container-fluid">
            <div class="row bg-white border-bottom sticky-top shadow-sm">
                <div class="col-md-12">
                    <h5 class="mt-2 mb-0">HRM Organogram</h5>
                    <small>HRM / HRM Organogram / HRM Organogram</small>
                </div>
            </div>
            <form action="{{ route('v1.hrm.save-hr-level') }}" method="post" id="HRLevelSave"
                enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-row">
                                    <input type="hidden" class="form-control form-control-sm" id="hdnorglevel_si_pk"
                                        name="hdnorglevel_si_pk" placeholder="" value="" />


                                    <div class="col-lg-2 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="level_number" class="col-form-label">Level</label>
                                            <input type="text" class="form-control form-control-sm" id="level_number"
                                                name="level_number" placeholder="" value="" />
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="level_text" class="col-form-label">Level Text</label>
                                            <input type="text" class="form-control form-control-sm" id="level_text"
                                                name="level_text" placeholder="" value="" />
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="level_name" class="col-form-label">Level Name</label>
                                            <input type="text" class="form-control form-control-sm" id="level_name"
                                                name="level_name" placeholder="" value="" />
                                        </div>
                                    </div>

                                    <div class="col-lg-1">
                                        <div class="form-group">
                                            <label for="remarks" class="col-form-label"></label>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="default_ind"
                                                    id="default_ind" />
                                                <label class="form-check-label" for="default_ind">
                                                    Default Ind
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    @php
                                        $response_action = route('v1.hrm.create-hr-level');
                                    @endphp
                                    <div class="col-md-1">
                                        <button type="button" class="btn btn-success uhl_save_btn mt-3"
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
                                            <th class="text-center">Level</th>
                                            <th class="text-center">Level Text</th>
                                            <th class="text-center">Level Name</th>
                                            <th class="text-center">Default Ind</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (!empty($hr_levels))
                                            @foreach ($hr_levels as $data)
                                                <tr>
                                                    <td class="text-center">{{ $loop->iteration }}</td>
                                                    <td class="text-center">{{ $data->level_number }}</td>
                                                    <td class="text-center">{{ $data->level_text }}</td>
                                                    <td class="text-center">{{ $data->level_name }}</td>
                                                    <td class="text-center">@if ($data->default_ind == 1)
														<i class="fas fa-check"></i>
													</td>
													@endif

                                                    <td class="text-center">
                                                        <button class="btn btn-success btn-sm"
                                                            onclick="HrLevelUpdate({{ $data->orglevel_si_pk }})"><i
                                                                class="far fa-edit"></i>
                                                        </button>
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

    function HrLevelUpdate(orglevel_si_pk) {
        $.ajax({
            type: 'get',
            url: '{{ route('v1.hrm.hr_level_edit') }}',
            data: {
                orglevel_si_pk: orglevel_si_pk
            },
            success: function(data) {
                console.log(data);
                $("#hdnorglevel_si_pk").val(data.orglevel_si_pk);
                $("#level_number").val(data.level_number);
                $("#level_text").val(data.level_text);
                $("#level_name").val(data.level_name);

                $("#default_ind").val(data.default_ind);
                if (data.default_ind === "1") {
                    $('input[name="default_ind"]').prop('checked', true);
                }

            },
            error: function() {

            }
        });
    }
</script>
