<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">

<div class="container-fluid">
	<div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm align-items-center justify-content-between">
		<div class="col-md-6">
			<h5 class="mt-2 mb-0">Grant Service Unit To User</h5>
			<small>Service Unit / Grant Service Unit To User</small>
		</div>
		<div class="col-md-6 text-right">
			<div id="top-action" class="m-0">
				<button class="btn btn-outline-primary btn-md open-modal" data-modal="common-modal-sm" data-action="{{ route('serviceunit.grant-service-unit-to-user-popup-Form') }}" data-title="Grant SU to User" title="Grant SU to User"><i class="fa fa-plus"></i> Add New Grant SU</button>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header"><h5>Grant Service Unit to User
                    </h5></div>
				<div class="card-body">
					<div class="row mt-2">
						<div class="col-md-12 table-responsive">
							<table id="data-table" class="table table-bordered table-hover table-striped data-table">
								<thead class="bg-primary">
									<tr>
										<th class="text-center " scope="col">Sl#</th>
										<th class="text-left" scope="col">User</th>
										<th class="text-center" scope="col">Department</th>
										<th class="text-center" scope="col">Default</th>
                                        <th class="text-center" scope="col">Verify</th>
                                       <th class="text-center" scope="col">Sample Receive</th>
                                      <th class="text-center" scope="col">Preview</th>
                                        <th class="text-center" scope="col">Save</th>
                                        <th class="text-center" scope="col">Finalize</th>
                                         <th class="text-center" scope="col">Result</th>
                                        <th class="text-center" scope="col">Print</th>
                                        <th class="text-center" scope="col">User Code</th>
                                        <th class="text-center" scope="col">Action</th>
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
{{-- <script>
    $(document).ready(function () {
        var datatable = $('.data-table').DataTable({
            "ordering": false,
            "language": {
                "infoFiltered": ""
            },
            "processing": true,
            "serverSide": true,
            "ajax":{
                "url": "{{ url('grantServiceUnit-list') }}",
                "dataType": "json",
                "type": "POST",
                "data":{ _token: "{{csrf_token()}}"}
            },
            "columnDefs": [{
                "targets": -1,
                "data": "Edit",
                "render": function ( data, type, row, meta ) {
                    var edit_action = '{{ route("grantServiceUnit-editData", ":id") }}';
                    edit_action = edit_action.replace(':id', row[11]);

                    return '<span Class="btn btn-sm btn-primary open-modal" data-id="'+ row[11] +'" data-action="'+edit_action+'" data-modal="common-modal-sm" data-title="Edit Grant Service Unit to User" title="Edit"><i class="fa fa-pencil-alt"></i></span>';
                }
            }]
        });
    });
</script> --}}

<script>
    $(document).ready(function() {
        $("body").addClass("sidebar-collapse");
        var datatable = $('.data-table').DataTable({
            "ordering": true,
            "language": {
                "infoFiltered": ""
            },
            "processing": true,
            "searching": true,
            "order": [
                [3, "asc"]
            ],
            "serverSide": true,

            "ajax": {
                "url": "{{ url('grantServiceUnit-list') }}",
                "dataType": "json",
                "type": "POST",
                "data": {
                    _token: "{{ csrf_token() }}"
                }
            },
            "columnDefs": [{
                    "targets": -1,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {

                        // var create_action = '{{ route('serviceunit.create') }}';
                        // create_action = create_action.replace(':id', row[0]);

                        var edit_action = '{{ route('grantServiceUnit-editData', ':id') }}';
                        edit_action = edit_action.replace(':id', row[12]);

                        // var delete_action = '{{ route('serviceunit.destroy', ':id') }}';
                        // delete_action = delete_action.replace(':id', row[0]);

                        return '<span Class="btn btn-sm btn-primary open-modal" data-id="' +
                            row[12] + '" data-action="' + edit_action +
                            '" data-modal="common-modal-sm" data-title="Edit Grant Service Unit" title="Edit"><i class="fa fa-pencil-alt"></i></span>';
                    }
                },
                // {
                //    "targets": 1,
                //     "searchable": true,
                //     "data": "User",
                //     // "data": "Edit",
                //     "render": function(data, type, row, meta) {
                //         var buttonText = row[1] != null ? row[1] : "No Data";
                //         var rowClass = meta.row % 2 === 0 ? 'bg-light' : 'bg-secondary';
                //         return `<span class='${rowClass}'>${buttonText}</span>`;
                //     }
                // },
                // {
                //     "targets": 2,
                //     "searchable": true,
                //     "data": "Edit",
                //     "render": function(data, type, row, meta) {
                //         if (row[2] != null) {
                //             return `<span class='btn btn-lg btn-info btn-lg medium'>${row[2]}</span>`;
                //         } else {
                //             return `<span class='btn btn-lg btn-info btn-lg medium'>${row[2]}</span>`;
                //         }
                //     }
                // },
                // {
                //     "targets": 11,
                //     "searchable": true,
                //     "data": "Edit",
                //     "render": function(data, type, row, meta) {
                //         if (row[11] != null) {
                //             return `<span class='btn btn-lg btn-warning btn-lg medium'>${row[11]}</span>`;
                //         } else {
                //             return `<span class='btn btn-lg btn-warning btn-lg medium'>${row[11]}</span>`;
                //         }
                //     }
                // },
                {
                    "targets": 3,
                    // "data": "Edit",
                    "render": function(data, type, row, meta) {
                        if (row[3] == 1) {
                            return "<span class='btn btn-sm btn-success'>Yes </span>";
                        } else {
                            return "<span class='btn btn-sm btn-danger'>No </span>";
                        }
                    }
                },
                {
                    "targets": 4,
                    // "data": "Edit",
                    "render": function(data, type, row, meta) {
                        if (row[4] == 1) {
                            return "<span class='btn btn-sm btn-success'>Yes </span>";
                        } else {
                            return "<span class='btn btn-sm btn-danger'>No </span>";
                        }
                    }
                },
                {
                    "targets": 5,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {
                        if (row[5] == 1) {
                            return "<span class='btn btn-sm btn-success'>Yes </span>";
                        } else {
                            return "<span class='btn btn-sm btn-danger'>No </span>";
                        }
                    }
                },
                {
                    "targets": 6,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {
                        if (row[6] == 1) {
                            return "<span class='btn btn-sm btn-success'>Yes </span>";
                        } else {
                            return "<span class='btn btn-sm btn-danger'>No </span>";
                        }
                    }
                },
                {
                    "targets": 7,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {
                        if (row[7] == 1) {
                            return "<span class='btn btn-sm btn-success'>Yes </span>";
                        } else {
                            return "<span class='btn btn-sm btn-danger'>No </span>";
                        }
                    }
                },
                {
                    "targets": 8,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {
                        if (row[8] == 1) {
                            return "<span class='btn btn-sm btn-success'>Yes </span>";
                        } else {
                            return "<span class='btn btn-sm btn-danger'>No </span>";
                        }
                    }
                },
                {
                    "targets": 9,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {
                        if (row[9] == 1) {
                            return "<span class='btn btn-sm btn-success'>Yes </span>";
                        } else {
                            return "<span class='btn btn-sm btn-danger'>No </span>";
                        }
                    }
                },
                {
                    "targets": 10,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {
                        if (row[10] == 1) {
                            return "<span class='btn btn-sm btn-success'>Yes </span>";
                        } else {
                            return "<span class='btn btn-sm btn-danger'>No </span>";
                        }
                    }
                },
                {
                    "targets": 12,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {
                        if (row[12] == 1) {
                            return "<span class='btn btn-sm btn-success'>Yes </span>";
                        } else {
                            return "<span class='btn btn-sm btn-danger'>No </span>";
                        }
                    }
                }
            ]
        });
    });
</script>
