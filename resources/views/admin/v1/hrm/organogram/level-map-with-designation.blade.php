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
                    <small>HRM / Level Map with Designation / Level Map with Designation</small>
                </div>
            </div>
            <form action="{{ route('v1.hrm.level_map_designation_save') }}" method="post" id="LevelMapSave"
                enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-row">
                                    <input type="hidden" class="form-control form-control-sm"
                                        id="hdnorganogramlvlmapdg_no_pk_seq" name="hdnorganogramlvlmapdg_no_pk_seq"
                                        placeholder="" value="" />

                                    <div class="col-lg-3 col-md-3 col-12">
                                        <div class="form-group">
                                            <label for="orglevel_si_fk" class="col-form-label">Level</label>
                                            <select name="orglevel_si_fk" id="orglevel_si_fk"
                                                class="form-control select2">
                                                <option value="">Select</option>
                                                @if (!empty($hr_level))
                                                    @foreach ($hr_level as $level)
                                                        <option data-type="" value="{{ $level->orglevel_si_pk }}">
                                                            {{ $level->level_name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-3 col-12">
                                        <div class="form-group">
                                            <label for="designation_no_fk" class="col-form-label">Designation</label>
                                            <select name="designation_no_fk" id="designation_no_fk"
                                                class="form-control select2">
                                                <option value="">Select</option>
                                                @if (!empty($hr_designation))
                                                    @foreach ($hr_designation as $designation)
                                                        <option value="{{ $designation->designation_no_pk }}">
                                                            {{ $designation->designation_name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>

                                    @php
                                        $response_action = route('v1.hrm.hr_level_map_designation');
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
                                        <th class="text-center" style="width: 200px;">SL</th>
                                        <th class="text-left">Designation</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (!empty($data_with_label))
                                        @foreach ($data_with_label as $label => $data)
                                            @php
                                                $lavel_exp = explode('_', $label);
                                            @endphp
                                            <tr>
                                                <th colspan="3" class="text-left">
                                                    <b>{{ $label != '' ? $lavel_exp[1] : '' }}</b>
                                                </th>
                                            </tr>
                                            @foreach ($data as $value)
                                                <tr>
                                                    <td class="text-center">{{ $loop->iteration }}</td>
                                                    <td class="text-left"> {{ $value->designation_name }}</td>
                                                    <td class="text-center">
                                                        <button class="btn btn-success btn-sm"
                                                            onclick="Update({{ $value->organogramlvlmapdg_no_pk }})">
                                                            <i class="far fa-edit"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-danger btn-sm deleteRow"
                                                            title="Remove"
                                                            onclick="Delete({{ $value->organogramlvlmapdg_no_pk }})"><i
                                                                class="oi oi-circle-x"></i></button>
                                                    </td>
                                                </tr>
                                            @endforeach
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

    function Update(organogramlvlmapdg_no_pk) {
        $.ajax({
            type: 'get',
            url: '{{ route('v1.hrm.level_map_designation_edit') }}',
            data: {
                organogramlvlmapdg_no_pk: organogramlvlmapdg_no_pk
            },
            success: function(data) {
                // console.log(data);
                $("#hdnorganogramlvlmapdg_no_pk_seq").val(data.organogramlvlmapdg_no_pk)
                $("#orglevel_si_fk").val(data.orglevel_si_fk).trigger('change');
                $("#designation_no_fk").val(data.designation_no_fk).trigger('change');
            },
            error: function() {

            }
        });
    }


    // $("#parameter_table").on('click', '.deleteRow', function() {
    //     $(this).closest('tr').remove();
    // });

    function Delete(organogramlvlmapdg_no_pk) {
        var confirmation = confirm("Are you sure?");
        if (confirmation) {
            // var $trToDelete = $('[data-organogramlvlmapdg_no_pk="' + organogramlvlmapdg_no_pk + '"]');
            $.ajax({
                type: 'post',
                url: '{{ route('v1.hrm.level_map_designation_delete') }}',
                data: {
                    organogramlvlmapdg_no_pk: organogramlvlmapdg_no_pk
                },
                beforeSend: function() {
                    blockUI();

                },
                success: function(data) {
                    // $trToDelete.remove();
                    location.reload();
                },
                error: function() {

                },
                // complete: function() {
                //     $.unblockUI();
                // }
            });
        } else {

        }
    }
</script>
