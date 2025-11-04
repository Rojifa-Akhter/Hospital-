<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css')}}">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<style>
    .participent_img {
        width: 50px;
        border: 1px solid #d2d2d2;
        margin-right: 5px;
    }
</style>
<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm align-items-center">
        <div class="col-md-6">
            <h5 class="mt-2 mb-0">Discharge Template List</h5>
            <small>IPD / Discharge Template List</small>
        </div>
    </div>

    <div class="form-row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>Discharge Template List</h5>
                </div>
                <div class="card-body">

                    <form action="{{route('ipd.discharge-req-list-search')}}" id="discharge_form" method="post">
                        <div class="form-row justify-content-center border-bottom mb-2 mt-2">
                            <div class="col-md-2 text-right">
                                <label class="col-form-label col-form-label-sm " for="discharge_ward">Template Name</label>
                            </div>

                            <div class="col-md-4">

                                <div class="form-group">
                                    <select class="form-control form-control-sm select2" id="discharge_temp" name="discharge_temp">
                                        <option value="">All Template</option>
                                        @if(!empty($discharge_temp))
                                        @foreach($discharge_temp as $value)
                                        <option value="{{ $value->dis_template_no_pk}}">{{ $value->dis_template_name}}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>


                            <div class="  col-md-2 text-center ">
                                <div class="btn-group btn-block form-group" role="group">

                                    <button type="button" id="discharge_temp_search" class="btn btn-success btn-md btn-md-global"><i class="fa fa-search"></i> Search</button>

                                    <button type="button" id="reset" class="btn btn-info btn-md btn-md-global" onclick="resetAll(this)"><i class="fa fa-redo"></i> Reset</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="form-row">
                        <div class="col-12 table-responsive" id="discaharge_list">

                            <table class="table data-table border table-striped table-bordered table-hover mb-0 discharge_temp">
                                <thead class="global-uhl-table-bg">
                                    <tr>
                                        <th class="text-center">SL</th>
                                        <th class="text-center">Template Code</th>
                                        <th class="text-center">Template Name</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>


                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js')}}"></script>
<script>
    function resetAll(Element) {
        $("#discharge_form").find("input, textarea").val("");
        $("#discharge_form").find("select").val("");
        $('#discharge_temp').select2({
            id: '',
            a_key: 'All Template'
        });
    }

    openDoctorAutocomplete("#card_no", 'card_hidn');
    openPatientAutocomplete('#service_number', 'patient_name');
    openAdmissionAutocomplete('#admission_id', 'patient_name');

    $(document).ready(function() {
        // $('.data-table').DataTable();

        var datatable = $('.discharge_temp').DataTable({
            "searching": false,
            "processing": true,
            "serverSide": true,
            "order": [
                [0, "desc"]
            ],
            "ajax": {
                "url": "{{ route('ipd.discharge-template-list') }}",
                "dataType": "json",
                "type": "post",
            },
            "columnDefs": [{
                    "targets": -1,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {
                        var edit_action = '{{ route("ipd.discharge-template-edit", ":id") }}';
                        edit_action = edit_action.replace(':id', row[0]);
                        return '<span Class="btn btn-sm btn-primary open-modal" data-id="' +
                            row[0] + '" data-action="' + edit_action +
                            '" data-modal="common-modal-md" data-title="Edit Discharge summary" title="Edit"><i class="fa fa-pencil-alt"></i></span>';
                    }
                },
                {
                    "targets": 0,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {


                        return `${meta.row + 1}`;
                    }
                },
                {
                    "targets": 1,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {


                        return `${row[1]}`;
                    }
                },
                {
                    "targets": 0,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {


                        return `${row[2]}`;
                    }
                },
            ]
        });
    });


    $(document).on("click", "#discharge_temp_search", function(e) {

        $('.discharge_temp').empty();
        $('.discharge_temp').DataTable().destroy();
        $('.discharge_temp').DataTable({
            "searching": false,
            "processing": true,
            "serverSide": true,
            "order": [
                [0, "desc"]
            ],
            "ajax": {
                "url": "{{ route('ipd.discharge-template-list-search') }}",
                "dataType": "json",
                "type": "post",
                data: {
                    // invoice_id:$('input[name="invoice_id"]').val(),
                    temp_id: $('#discharge_temp').val(),

                }
            },
            "columnDefs": [{
                    "targets": -1,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {
                        var edit_action = '{{ route("ipd.discharge-template-edit", ":id") }}';
                        edit_action = edit_action.replace(':id', row[0]);
                        return '<span Class="btn btn-sm btn-primary open-modal" data-id="' +
                            row[0] + '" data-action="' + edit_action +
                            '" data-modal="common-modal-md" data-title="Edit Discharge summary" title="Edit"><i class="fa fa-pencil-alt"></i></span>';
                    }
                },
                {
                    "targets": 0,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {


                        return `${meta.row + 1}`;
                    }
                },
                {
                    "targets": 1,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {


                        return `${row[1]}`;
                    }
                },
                {
                    "targets": 0,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {
                        return `${row[2]}`;
                    }
                }
            ]
        })
    });
</script>
