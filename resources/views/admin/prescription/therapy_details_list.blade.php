<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.min.css') }}" rel="stylesheet">
<section id="full_lookup_list">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-12 mb-1">
                <h5 class="mt-2 mb-0">Therapy-details-list</h5>
                <small>Prescription / Therapy-details-list</small>
            </div>
        </div>
        <div class="card">
            {{-- <div class="card-header"><h5>Room List <button class="btn btn-sm btn-primary float-right open-modal" data-modal="common-modal-sm" data-action="{{ route('room.create_form') }}" data-title="Create New Room">Create Room</button></h5></div> --}}

            <div class="card-body">
                <div class="row mt-2">
                    <div class="col-md-12 table-responsive">
                        <table  class="table table-bordered table-hover table-striped therapy-data-table">
                            <thead class="bg-primary">
                                <tr>
                                    <th class="text-left" scope="col">SL#</th>
                                    <th class="text-left" scope="col">Patient ID</th>
                                    <th class="text-left" scope="col">Patient Name</th>
                                    <th class="text-left" scope="col">Day No.</th>
                                    <th class="text-left" scope="col">Date</th>
                                    <th class="text-left" scope="col">Time</th>
                                    <th class="text-left" scope="col">Dosage</th>

                                    {{-- <th class="text-left" scope="col">Action</th> --}}

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
</section>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}">
</script>
<script>
   	$(document).ready(function() {
		var id = $('#type').val();
	   // console.log(id);
		var datatable = $('.therapy-data-table').DataTable({
			"processing": true,
			"serverSide": true,
			//"pageLength": 25,
			"order": [
				[0, "desc"]
			],
			"ajax": {
				"url": "{{ route('therapy-details-list') }}",
				"dataType": "json",
				"type": "get",
				"data": {
					id: id,
					// _token: "{{ csrf_token() }}"
				}
			},
            "columnDefs": [{
                    "targets": 0,
                    //"data": "Edit",
                    "render": function(data, type, row, meta) {

                      return `${meta.row + 1}`;

                    }
                },

                {
                    "targets": 1,
                    //"data": "Edit",
                    "render": function(data, type, row, meta) {

                            return `<div class="text-left">${row[1]}</div>`;

                    }
                },
                {
                    "targets": 2,
                   // "data": "Edit",
                    "render": function(data, type, row, meta) {

                            return ` ${row[2]}`;

                    }
                },
                {
                    "targets": 3,
                   // "data": "Edit",
                    "render": function(data, type, row, meta) {

                        if(row[5])
                      {
                        var sl = "Day "+row[5];
                        return `${sl}`;

                      }
                      else return '';

                    }
                },
                {
                    "targets": 4,
                   // "data": "Edit",
                    "render": function(data, type, row, meta) {

                        //return ` ${row[2]}`;
                        if (row[3]) {
                            var date = new Date(row[3]);
                            var doc = ('0' + date.getDate()).slice(-2) + '/' + ('0' + (date
                                .getMonth() + 1)).slice(-2) + '/' + date.getFullYear();
                            return ` ${doc}`;
                        } else return '';
                    }
                },
                {
                    "targets": 5,
                    //"data": "Edit",
                    "render": function(data, type, row, meta) {
                        if (row[4]) {
                            var date = new Date(row[4]);
                            let hours = date.getHours();
                            let minutes = date.getMinutes();
                            const ampm = hours >= 12 ? 'pm' : 'am';
                            hours = hours % 12;
                            //var doc = ('0' + date.getHours() + ':' + date.getMinutes());
                            return `${hours}:${minutes} ${ampm}`;
                        } else return '';
                    }
                },

                {
                    "targets": 6,
                   // "data": "Edit",
                    "render": function(data, type, row, meta) {
                           if(row[6])
                           {
                            return `<div class ="text-left">${row[6]}</div>`;

                           }
                           else
                              return '';

                    }
                },

			]
		});
    });
</script>
