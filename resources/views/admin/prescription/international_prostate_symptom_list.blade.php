<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.min.css') }}" rel="stylesheet">
<section id="full_lookup_list">
	<div class="container-fluid">
		<div class="row bg-white border-bottom sticky-top shadow-sm">
			<div class="col-md-12 mb-1">
				<h5 class="mt-2 mb-0">International-prostate-symptom-score-questionnaire-list</h5>
				<small>Prescription / International-prostate-symptom-score-questionnaire-list</small>
			</div>
		</div>
		<div class="card">
			{{-- <div class="card-header"><h5>Room List <button class="btn btn-sm btn-primary float-right open-modal" data-modal="common-modal-sm" data-action="{{ route('room.create_form') }}" data-title="Create New Room">Create Room</button></h5></div> --}}

			<div class="card-body">
				<div class="row mt-2">
				    <div class="col-md-12 table-responsive">
				        <table  class="table table-bordered table-hover table-striped prostate-data-table">
	                        <thead class="bg-primary">
	                            <tr>
                                    <th class="text-center" scope="col">SL#</th>
                                    <th class="text-left" scope="col">Patient ID</th>
                                    <th class="text-left" scope="col">Patient Name</th>
                                    <th class="text-left" scope="col">Date of birth</th>
                                    <th class="text-left" scope="col">Date Completed</th>
                                    <th class="text-left" scope="col">Quality of Life</th>
                                    <th class="text-left" scope="col">Total Score</th>
									<th class="text-center">Action</th>

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
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script>
		$(document).ready(function() {
		// var id = $('#type').val();
	   // console.log(id);
		// var datatable = $('.prostate-data-table').DataTable({
		// 	"searching": false,
		// 		"processing": true,
		// 		"serverSide": true,
		// 		"order": [[ 0, "desc" ]],
		// 	"ajax": {
		// 		"url": "{{ route('international-prostate-symptom-score-questionnaire-list') }}",
		// 		"dataType": "json",
		// 		"type": "post",
		// 			// id: id,
		// 			// _token: "{{ csrf_token() }}"
        //             "data":{ _token: "{{csrf_token()}}"}

		// 	},
            var datatable = $('.prostate-data-table').DataTable({
				//"searching": false,
				"processing": true,
				"serverSide": true,
				"order": [[ 0, "desc" ]],
				"ajax":{
					"url": "{{ route('international-prostate-symptom-score-questionnaire-list') }}",
					"dataType": "json",
					"type": "post",
                "data":{ _token: "{{csrf_token()}}"}
            },
			"columnDefs": [
                {
			"targets": 0,
			"data": "Edit",
			"render": function ( data, type, row, meta ) {


				return `${meta.row + 1}`;
			}
		},
				{
					"targets": -1,
                    "visible": false,
					"data": "Edit",
					"render": function(data, type, row, meta) {

						var edit_action = '{{ route('international-prostate-symptom-score-questionnaire-edit', ':id') }}';
						edit_action = edit_action.replace(':id', row[7]);

						return '<span Class="btn btn-sm btn-primary open-modal" data-id="' +
							row[7] + '" data-action="' + edit_action +
							'" data-modal="common-modal-md" data-title="Edit International Prostate Symptom Score Questionnaire" title="Edit"><i class="fa fa-pencil-alt"></i></span>';
					}
				},
                {
					"targets": 1,
					// "data": "Edit",
					"render": function(data, type, row, meta) {
                      if(row[1])
                      {
						return ` ${row[1]}`;
                      }
                      else
                         return '';
					}
				},

				{
					"targets": 2,
					// "data": "Edit",
					"render": function(data, type, row, meta) {
                        if(row[2])
                      {
						return ` ${row[2]}`;
                      }
                      else
                         return '';

					}
				},
				{
					"targets": 3,
					// "data": "Edit",
					"render": function(data, type, row, meta) {
                        if(row[3])
                        {
                            var date=new Date(row[3]);
                       var dob =('0' + date.getDate()).slice(-2)+'/'+('0' + (date.getMonth() +1)).slice(-2)+'/'+date.getFullYear();
                       return ` ${dob}`;
                        }
                        else return '';

					}
				},
				{
					"targets": 4,
					// "data": "Edit",
					"render": function(data, type, row, meta) {
                        if(row[4])
                     {
                        var date=new Date(row[4]);
                       var doc =('0' + date.getDate()).slice(-2)+'/'+('0' + (date.getMonth() +1)).slice(-2)+'/'+date.getFullYear();
                       return ` ${doc}`;
                     }
                     else return '';


					}
				},
				{
					"targets": 5,
					// "data": "Edit",
					"render": function(data, type, row, meta) {
                      // if(row[5])
                       if (row[5] != null) {
                            if(row[5]==0)
                            {
                                row[5]='Delighted';
                            }
                            else if(row[5]==1)
                            {
                                row[5]='Pleased';
                            }
                            else if(row[5]==2)
                            {
                                row[5]='Mostly Satisfied';
                            }
                            else if(row[5]==3)
                            {
                                row[5]='Mixed';
                            }
                            else if(row[5]==4)
                            {
                                row[5]='Mostly dissatisfied';
                            }
                            else if(row[5]==5)
                            {
                                row[5]='Unhappy';
                            }
                            else
                            {
                                row[5]='Terrible';

                            }
						    return ` ${row[5]}`;
                        } else {
                            return '';
                        }
					}
				},

                {
					"targets": 6,
					// "data": "Edit",
					"render": function(data, type, row, meta) {
                       if(row[6])
                       {
						return ` ${row[6]}`;
                       }
                       else return '';
                    }

				},


			]
		});
    });
</script>
