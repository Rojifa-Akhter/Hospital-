
<style>
	.receive_patient_table>thead>tr>th{
		font-size: 15px !important;
	}
	.receive_patient_table>tbody>tr>td{
		font-size: 15px !important;
	}

	.received_patient_table>thead>tr>th{
		font-size: 15px !important;
	}
	.received_patient_table>tbody>tr>td{
		font-size: 15px !important;
	}

    .position-center{
       /* margin-bottom: -30px  */
    }
</style>
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">

<main id="page-content">
    <section class="fixed_asset">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="row justify-content-between align-items-center bg-white border-bottom sticky-top shadow-sm">
                        <div class="col-md-11">
                            <h5 class="mt-2 mb-0">Pending Referal Worklist</h5>
                            <small>IPD / Nurse Station / Pending Referal Worklist</small>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row justify-content-center position-center pt-1">          
                                <div class="col-6">
                                    <div class="row">
                                        <div class="col-4">
                                            <label class="col-form-label col-form-label-sm" for="nurse_station_received">Nurse Station</label>
                                        </div>
                                        
                                        <div class="col-8">
                                            <select class="form-control form-control-sm" id="nurse_station_received" name="nurse_station_received" onchange="getPendingPatient(true)">
                                                @if(!empty($service_point))
                                                    @foreach($service_point as $item)
                                                        <option value="{{ $item->serviceunit_no_pk}}">{{ $item->serviceunit_name}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            
                            <div class="row">
                                <div class="col-12">
                                    <div class="table-responsive pt-2">
                                        <table class="table table-striped table-bordered table-hover received_patient_table">
                                            <thead class="global-uhl-table-bg">
                                                <tr>
                                                    <th class="text-center" style="width:3%">#SL</th>
                                                    <th class="text-center" style="width:8%">Bed No</th>
                                                    <th class="text-left" style="width:13%">Patient Name</th>
                                                    <th class="text-center" style="width:5%">UHID</th>
                                                    <th class="text-center" style="width:8%">IP Date</th>
                                                    <th class="text-center" style="width:8%">IP No</th>
                                                    <th class="text-left" style="width:12%">Department</th>
                                                    <th class="text-left" style="width:8%">Bed Category</th>              
                                                    <th class="text-left" style="width:12%">From Consultant</th>
                                                    <th class="text-left" style="width:11%">To Consultant</th>
                                                </tr>
                                            </thead>
        
                                            <tbody>
                                                <tr>
                                                    <td colspan="10" class="text-center">Data Fetching ...</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
</main>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script>
	 $("body").addClass("sidebar-collapse");
    $(document).ready(function(){
        getPendingPatient();
    })
</script>

<script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
        });
       
        function getPendingPatient(search = null){
                var received_patient = $("#nurse_station_received").val();

                $.ajax({
                url: "{{route('get-pending-referal-patient')}}",
                method: "post",
                data:{nurse_station:received_patient},
                beforeSend: function() {
                    if(search != null){
                        blockUI();
                    }
                },
                success: function(response){
                    if(response.data.length != 0){
                        setPendingPatient(response.data);
                    }
                    else{
                        emptyTable();
                    } 
                },
                error:function(err){
                    var error = err.responseJSON;
                    $('.common-modal-notify-error').modal('show');
                    $('.common-modal-notify-error .modal-title').html('Failed');
                    $('.common-modal-notify-error .modal-body').html(error.message); 
                },
                complete: function() {
                    $.unblockUI();
                }
            })
        }

        function setPendingPatient(data){
            $('.received_patient_table tbody').empty();

			var rows = [];
            if($.fn.DataTable.isDataTable('.received_patient_table')) {
                $('.received_patient_table').DataTable().destroy();
            }

            var table = $('.received_patient_table').DataTable({
                        searching: true,
                        columnDefs: [
                                { targets: [0, 1, 3, 4, 5], className: 'text-center' },
                                { targets: [2, 6, 7, 8,9], className: 'text-left' }
                            ],
						"lengthMenu": [[15, 25, 50, 75, 100, -1], [15, 25, 50, 75, 100, "All"]], 
                		"pageLength": 15
                    });

            data.forEach(function(item, index) {
				var admission_date = '';

				if(item.admission_date != ''){
					var date = new Date(item.admission_date);
					var day = date.getDate();
					var month = date.getMonth() + 1; 
					var year = date.getFullYear();
						admission_date = padZero(day) + "/" + padZero(month) + "/" + year;
				}


                var rowData = [
                    ++index,
					item.bed_name,
                    `<b>${item.patient_name}</b>`,
                    item.patient_no_fk,
                    admission_date,
                    item.admission_uid,
					item.doc_department,
					item.ward_name,
                    item.from_doctor_name,
                    item.to_doctor_name,
                ];
                rows.push(rowData);
            });
            table.clear();
            table.rows.add(rows);
            table.draw(); 

        }

        function emptyTable(){
            $('.received_patient_table tbody').empty();
            $('.received_patient_table tbody').append(`
                <tr>
                    <td colspan="10" class="text-danger text-center">Data Not Found</td>
                </tr>
            `);
        }

		function padZero(number) {
        	return number < 10 ? "0" + number : number;
    	}

</script>
