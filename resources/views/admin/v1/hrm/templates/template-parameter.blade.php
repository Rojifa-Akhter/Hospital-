<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<style>
    label.custom-file-label.form-control.upload_app_label {
        line-height: 1.7;
    }
</style>
<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<form action="{{ route('v1.hrm.hrm-letter-parameter-store') }}" method="post" id="parameter_save_form">
    @csrf
    {{-- <div class="modal fade bd-example-modal-lg" id="exampleModal" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true"> --}}
    {{-- <div class="modal-dialog modal-lg" role="document"> --}}
    <div class="modal-content">
        <div class="modal-header">
            {{-- <h5 class="modal-title" id="exampleModalLabel">Add Parameters</h5> --}}
            {{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button> --}}
            <b>Template Name : {{ $lettertemp_name }}</b>
            <b>Template Code : {{ $lettertemp_uid }}</b>
        </div>
        <div class="modal-body p-0">
            <div class="row">
                <div class="col-md-12">
                    <div class="card mt-0">
                        <div class="card-body p-2">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead class="global-uhl-table-bg">
                                        <tr>
                                            <th class="text-center">SL No</th>
                                            <th class="text-center">Parameter Name</th>
                                            <th class="text-center">DB Function/SQL</th>
                                            <th class="text-center">Value Description</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-left">
                                                <input type="hidden" name="lettertemp_no_fk"
                                                    value="{{ $lettertemp_no_fk }}">

                                                <input type="hidden" name="lettertempdtl_no_pk"
                                                    id="lettertempdtl_no_pk" value="">
                                                {{-- <input type="text" class="form-control form-control-sm"
                                                    id="sl_no" name="sl_no" value="{{ $sl }}" readonly> --}}

                                                <input type="text" class="form-control form-control-sm"
                                                    id="sl_no" name="sl_no" value="" required>
                                            </td>
                                            <td class="text-left">
                                                <input type="text" class="form-control form-control-sm"
                                                    id="dynamic_value_name" name="dynamic_value_name" value=""
                                                    required>
                                            </td>
                                            <td class="text-left">
                                                <input type="text" class="form-control form-control-sm"
                                                    id="dynamic_value_sql_func" name="dynamic_value_sql_func"
                                                    value="" required>
                                                </select>
                                            </td>

                                            <td class="text-left">
                                                <input type="text" class="form-control form-control-sm"
                                                    id="dynamic_value_desc" name="dynamic_value_desc" value=""
                                                    required>
                                            </td>

                                        </tr>

                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            @php
                $response_action = route('v1.hrm.hr-letter-templates');
            @endphp
            <button type="button" class="btn btn-primary uhl_save_btn"
                onclick="btnSaveUpdateUpload(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')"
                id="">Save</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
</form>

<table class="table table-striped table-bordered table-hover data-table" id="parameter_table">
    <thead class="global-uhl-table-bg">
        <tr>
            <th class="text-center">SL No</th>
            <th class="text-center">Parameter Name</th>
            <th class="text-center">DB Function/SQL</th>
            <th class="text-center">Value Description</th>
            <th class="text-center">Action</th>
        </tr>
    </thead>
    <tbody>
        @if (isset($parameter_data))
            @foreach ($parameter_data as $key => $value)
                <tr>
                    {{-- <td class="text-center one">{{ $value->lettertempdtl_no_pk }}</td> --}}
                    <td class="text-center one">{{ $value->dyn_value_sl }}</td>
                    <td class="text-center">{{ $value->dynamic_value_name }}</td>
                    <td class="text-center">{{ $value->dynamic_value_sql_func }}</td>
                    <td class="text-center">{{ $value->dynamic_value_desc }}</td>
                    <td class="text-center">

                        <button type="button" class="btn btn-primary btn-sm" title="Edit"
                            onclick="EditRow({{ $value->dyn_value_sl }}, '{{ $value->dynamic_value_name }}', '{{ $value->dynamic_value_sql_func }}', '{{ $value->dynamic_value_desc }}', {{ $value->lettertempdtl_no_pk }})"><i
                                class="oi oi-pencil"></i></button>

                        <button type="button" class="btn btn-danger btn-sm deleteRow" title="Remove"
                            onclick="deleteParameter({{ $value->lettertempdtl_no_pk }})"><i
                                class="oi oi-circle-x"></i></button>
                    </td>
                </tr>
            @endforeach

        @endif

    </tbody>

</table>


</div>
{{-- </div> --}}
{{-- </div> --}}
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script>
    $(document).ready(function() {

        $('.data-table').DataTable({
            // "ordering": false,
            "searching": true,
        });

        $(".date_picker").datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true,
            clearBtn: true
        });

    });

    function EditRow(dyn_value_sl, value_name, value_sql_func, value_desc, lettertempdtl_no_pk) {
        // console.log('sl',sl);
        $("#sl_no").val(dyn_value_sl);
        $("#dynamic_value_name").val(value_name);
        $("#dynamic_value_sql_func").val(value_sql_func);
        $("#dynamic_value_desc").val(value_desc);
        $("#lettertempdtl_no_pk").val(lettertempdtl_no_pk)
    }


    function deleteParameter(lettertempdtl_no_pk) {
        var confirmation = confirm("Are you sure?");
        if (confirmation) {
            $.ajax({
                type: 'post',
                url: '{{ route('v1.hrm.hrm_letter_delete_parameter') }}',
                data: {
                    lettertempdtl_no_pk: lettertempdtl_no_pk
                },
                success: function(data) {
                    alert(data.msg);
                },
                error: function() {

                }
            });
        } else {

        }
    }

</script>
