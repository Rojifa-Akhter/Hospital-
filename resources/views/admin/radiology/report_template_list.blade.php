
<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />

<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm align-items-center justify-content-between">
        <div class="col-md-6">
            <h5 class="mt-2 mb-0">Report Template List</h5>
            <small>Radiology / Report Template List</small>
        </div>
        <div class="col-md-6 text-right">
            <div id="top-action" class="m-0">
                <a class="btn btn-outline-primary btn-md uhl_common_outline_btn" target="_blank"  href="{{ route('report_template_build') }}" data-title="Add New Report Template" title="Add New Report Template"><i class="fa fa-plus"></i> Add New Report Template</a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>Report Template
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row mt-2">
                        <div class="col-md-12 table-responsive">
                            <table id="data-table" class="table table-bordered table-hover table-striped data-table">
                                <thead class="global-uhl-table-bg">
                                    <tr>
                                        <th class="text-center" scope="col">Sl#</th>
                                        <th class="text-center" scope="col">Department name</th>
                                        <th class="text-center" scope="col">Result Template Uid</th>
                                        <th class="text-center" scope="col">Template Name</th>
                                        <th class="text-center" scope="col">Serial Number</th>
                                        <th class="text-center" scope="col">Description</th>
                                        <th class="text-center" scope="col">Template Date</th>
                                        <th class="text-center" scope="col">Default IND</th>
                                        <th class="text-center" scope="col">Share IND</th>
                                        <th class="text-center" scope="col">General IND</th>
                                        <th class="text-center" scope="col">Status</th>
                                        <th class="text-center w-5" scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script>
    $(document).ready(function() {
        var datatable = $('.data-table').DataTable({
            "ordering": false,
            "language": {
                "infoFiltered": ""
            },
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "{{ url('report_template_list') }}",
                "dataType": "json",
                "type": "POST",
                "data": {
                    _token: "{{csrf_token()}}"
                }
            },
            "columnDefs": [{
                "targets": -1,
                "data": "Edit",
                "render": function(data, type, row, meta) {
                    var edit_action = '{{ route("report_template_edit", ":id") }}';
                    edit_action = edit_action.replace(':id', row[11]);
                    var del_action = '{{ route("report_template_del", ":id") }}';
                    del_action = del_action.replace(':id', row[11]);
                    var action_url = '{{ route("report_template") }}';
                    return `<a Class="btn btn-md btn-primary" data-id="' + row[11] + '" href="${edit_action}"  target="_blank" data-title="Edit Report Template" title="Edit"><i class="fa fa-pencil-alt"></i></a><form action="${del_action}" method="get" id="id"> <span Class="btn btn-md btn-warning ml-2" data-title="Delete Report Template" title="Delete"  onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'${action_url}')"><i class="fa fa-trash"></i></span></form>
                   `;
                }
            }]
        });
    });
</script>
