
<style>
	.operation_status_table>thead>tr>th{
		font-size: 15px !important;
	}
	.operation_status_table>tbody>tr>td{
		font-size: 15px !important;
	}

	.ot_requsition_table>thead>tr>th{
		font-size: 15px !important;
	}
	.ot_requsition_table>tbody>tr>td{
		font-size: 15px !important;
	}

    .position-center{
       /* margin-bottom: -30px  */
    }

</style>
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">

<main id="page-content">
    <section class="fixed_asset">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="row justify-content-between align-items-center bg-white border-bottom sticky-top shadow-sm">
                        <div class="col-md-11">
                            <h5 class="mt-2 mb-0">OT Requsition Worklist</h5>
                            <small>IPD / Nurse Station / OT Requsition Worklist </small>
                        </div>
                    </div>
                </div>
            </div>



            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <form method="post" id="ot_requsition">
                                        @csrf
                                        <div class="row align-items-center">
                                            
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="voucher_date_from">UHID/Name</label>
                                                    <input type="text" class="form-control form-control-sm" id="uhid" name="uhid" placeholder="UHID/Name" />
                                                    <input type="hidden" class="form-control" id="hdn_patient_id" name="hdn_patient_id" value="">                       
                                                </div>
                                            </div>
                            
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="voucher_date_from">IP No</label>
                                                    <input type="text" class="form-control form-control-sm" name="ip_no" id="ip_no" placeholder="IP No">
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="voucher_date_from">Procedure</label>
                                                    <select class="form-control form-control-sm select2" name="ot_id" id="ot_id">
                                                        <option value="" selected>All</option>
                                                        @foreach ($ot_item as $item)
                                                            <option value="{{$item->item_no_pk}}">{{$item->item_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            
                            
                                

                                            

                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <label for="surgon_name">Surgon Name</label>
                                                        </div>
                                                        <div class="col-12">
                                                            <input type="text" class="form-control form-control-sm w-100" name="doctor_name" id="doctor_name"  placeholder="Surgon Name">
                                                            <input type="hidden" class="form-control" name="doctor_id" id="doctor_id" placeholder="">
                                                        </div>
                                                    </div>
                                                  
                                                </div>  
                                            </div>


                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="voucher_date_from">From Date/To Date</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <input type="text" class="form-control form-control-sm from_date_picker" placeholder="From Date" id="ot_req_date_from" name="ot_req_date_from">
                                                        </div>
                                                        <input type="text" class="form-control form-control-sm date_picker" placeholder="To Date" id="ot_req_date_to" name="ot_req_date_to">
                                                      </div>         
                                                </div>
                                            </div>

                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>




            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <ul class="nav nav-tabs justify-content-center" id="myTab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="received-patient" data-toggle="tab" href="#pending_medicine" role="tab" aria-controls="pending_medicine" aria-selected="true" onclick="getOTRequsition(true)">Requsition List <span class="badge badge-secondary"></span></a>
                                        </li>
        
                                        <li class="nav-item">
                                            <a class="nav-link " id="receive-request" data-toggle="tab" href="#approved_medicine" role="tab" aria-controls="pending_medicine" aria-selected="true" onclick="getOperationStatus(true)">Operation Status<span class="badge badge-secondary"></span></a>
                                        </li>
                                    </ul>

                                    <div class="tab-content p-0" id="myTabContent">   
                                        <!-- Requsition List -->                       
                                        <div class="tab-pane fade show active" id="pending_medicine" role="tabpanel" aria-labelledby="received-patient">                                        
											
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="table-responsive pt-2">
                                                        <table class="table table-striped table-bordered table-hover ot_requsition_table">
                                                            <thead class="global-uhl-table-bg">
                                                                <tr>
                                                                    <th class="text-center" style="width:3%">#SL</th>
                                                                    <th class="text-left" style="width:20%">Patient Name</th>
                                                                    <th class="text-left" style="width:5%">Req. ID</th>
                                                                    <th class="text-left" style="width:5%">IP No</th>
                                                                    <th class="text-center" style="width:15%">Department Name</th>
                                                                    <th class="text-center" style="width:10%">Ward Name</th>
                                                                    <th class="text-center" style="width:7%">Age</th>
                                                                    <th class="text-left" style="width:5%">Sex</th>
                                                                    <th class="text-center" style="width:10%">Requisition Date</th>
                                                                    <th class="text-left" style="width:15%">Proposed operation</th>
                                                                    <th class="text-center" style="width:5%">Action</th>                 
                                                                </tr>
                                                            </thead>
                        
                                                            <tbody>
                                                                <tr>
                                                                    <td colspan="11" class="text-center">Data Fetching ...</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <!-- Operation Status -->
                                        <div class="tab-pane fade " id="approved_medicine" role="tabpanel" aria-labelledby="receive-request">

                                            <div class="row">
                                                <div class="col-12">
                                                    <div style="padding-top:10px">
                                                        <div class="table-responsive">
                                                            <table class="table table-striped table-bordered table-hover operation_status_table">
                                                                <thead class="global-uhl-table-bg">
                                                                    <tr>
                                                                        <th class="text-center" style="width:3%">#SL</th>
                                                                        <th class="text-left" style="width:8%">Patient Name</th>
                                                                        <th class="text-left" style="width:4%">Req. ID</th>
                                                                        <th class="text-left" style="width:4%">IP ID</th>
                                                                        <th class="text-center" style="width:13%">Dept. Name</th>
                                                                        <th class="text-center" style="width:8%">Ward Name</th>
                                                                        <th class="text-center" style="width:7%">Age</th>
                                                                        <th class="text-left" style="width:8%">OT Name</th>
                                                                        <th class="text-center" style="width:6%">Req. Date</th>
                                                                        <th class="text-left" style="width:6%">Confe. Note</th>
                                                                        <th class="text-left" style="width:6%">Anes. Conf.</th>
                                                                        <th class="text-left" style="width:6%">Doc. Conf.</th>
                                                                        <th class="text-left" style="width:7%">OT Execution</th>
                                                                        <th class="text-left" style="width:7%">OT Completed</th>
                                                                        <th class="text-center" style="width:7%">Return Status</th>                 
                                                                    </tr>
                                                                </thead>
                            
                                                                <tbody>
                                                                    <tr>
                                                                        <td colspan="15" class="text-center">Data Fetching ...</td>
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


                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
</main>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script>
	 $("body").addClass("sidebar-collapse");
    $(document).ready(function(){
        // $(".select2").select2();



        openPatientAutocomplete('#uhid');
        openDoctorAutocomplete("#doctor_name", "doctor_id");


        var currentDate = new Date();
        $('.date_picker').datepicker({
            todayHighlight: true,
            clearBtn: true,
            autoclose: true,
            changeMonth: true,
            changeYear: true,
            format: 'dd/mm/yyyy',
        }).datepicker('setDate', currentDate);

        var sevenDaysAgo = new Date();
            sevenDaysAgo.setDate(sevenDaysAgo.getDate() - 30);
        
            $('.from_date_picker').datepicker({
            todayHighlight: true,
            clearBtn: true,
            autoclose: true,
            changeMonth: true,
            changeYear: true,
            format: 'dd/mm/yyyy',
        }).datepicker('setDate', sevenDaysAgo);


        getOTRequsition();
    })
</script>

<script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
        });
       
        function getOTRequsition(search = null){
            let formElement = document.querySelector('#ot_requsition');
            let formData = new FormData(formElement);
                $.ajax({
                    url: "{{route('v2.ipd.get-requisition-list')}}",
                    type:"post",
                    dataType:"json",
                    data:formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        if(search != null){
                            blockUI();
                        }
                    },
                    success: function(response){
                        $.unblockUI();
                        if(response.data.length != 0){
                            setOTRequsition(response.data);
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

        function getOperationStatus(search = null){
            let formElement = document.querySelector('#ot_requsition');
            let formData = new FormData(formElement);
            $.ajax({
                url: "{{route('v2.ipd.get-ot-status')}}",
                type:"post",
                dataType:"json",
                data:formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    if(search != null){
                        blockUI();
                    }
                },
                success: function(response){
                    $.unblockUI();
                    if(response.data.length != 0){
                        setOperationStatus(response.data);
                    }
                    else{
                        emptyOSTable();
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

        function setOTRequsition(data){
            $('.ot_requsition_table tbody').empty();

			var rows = [];
            if($.fn.DataTable.isDataTable('.ot_requsition_table')) {
                $('.ot_requsition_table').DataTable().destroy();
            }

            var table = $('.ot_requsition_table').DataTable({
                        searching: true,
                        columnDefs: [
                                { targets: [0,2,3,6,7,8,10], className: 'text-center' },
                                { targets: [1,3,4,5,9], className: 'text-left' }
                            ],
						"lengthMenu": [[15, 25, 50, 75, 100, -1], [15, 25, 50, 75, 100, "All"]], 
                		"pageLength": 15
                    });

			var button_group = ``;
            data.forEach(function(item, index) {
				var admission_date = '';
				var ot_req_date = '';

				if(item.admission_date != ''){
					var date = new Date(item.admission_date);
					var day = date.getDate();
					var month = date.getMonth() + 1; 
					var year = date.getFullYear();
						admission_date = padZero(day) + "/" + padZero(month) + "/" + year;
				}

				if(item.ot_req_date != ''){
					var date = new Date(item.ot_req_date);
					var day = date.getDate();
					var month = date.getMonth() + 1; 
					var year = date.getFullYear();
						ot_req_date = padZero(day) + "/" + padZero(month) + "/" + year;
				}
                
                button_group = `<button type="button" class="btn btn-success btn-sm open-modal mr-2" data-modal="common-modal-sm" data-title="OT Confirmation" data-action="{{ route('ot-confirmation-popUp', '') }}/${item.ot_req_no_pk}/${item.ot_req_no_pk}"  title="OT Confirmation"><i class="fa fa-check"></i></button>`;   
                button_group+= `<button type="button" class="btn btn-danger btn-sm open-modal" data-modal="common-modal-sm" data-title="OT Rejection" data-action="{{ route('ot.ot-rejection-popUp', '') }}/${item.ot_req_no_pk}"><i class="fa fa-times-circle" title="OT Rejection"></i></button>`;  
                                          
                var rowData = [
                    ++index,
                    item.patient_name,
                    item.ot_req_no_pk,
                    item.admission_uid,
                    item.new_serivce_unit_name,
                    item.ward_name,
					item.age,
					item.gender_txt,
                    ot_req_date,
					item.item_name,
                    `<span style="white-space:nowrap">${button_group}</span>`,
                ];
                rows.push(rowData);
            });
            table.clear();
            table.rows.add(rows);
            table.draw(); 

        }

        function setOperationStatus(data){

            $('.operation_status_table tbody').empty();

            var rows = [];
            if($.fn.DataTable.isDataTable('.operation_status_table')) {
                $('.operation_status_table').DataTable().destroy();
            }

            var table = $('.operation_status_table').DataTable({
                        searching: true,
                        columnDefs: [
                                { targets: [0, 2,3,5,6,8,9,10,11,12,13,14], className: 'text-center' },
                                { targets: [1, 4, 7], className: 'text-left' }
                            ],
						"lengthMenu": [[15, 25, 50, 75, 100, -1], [15, 25, 50, 75, 100, "All"]], 
                		"pageLength": 15
                    });

            var confession_note_ind = '';
            var anest_clearance_ind = '';
            var obs_ind = '';
            var ot_in_ind = '';
            var ot_out_ind = '';
            var return_ipd_ind = '';
            var ot_req_date = '';
            data.forEach(function(item, index) {
				    ot_req_date = '';
                    confession_note_ind = ``;
                    anest_clearance_ind = '';
                    obs_ind = '';
                    ot_in_ind = '';
                    ot_out_ind = '';
                    return_ipd_ind = '';
				

                if(item.ot_req_date != ''){
					var date = new Date(item.ot_req_date);
					var day = date.getDate();
					var month = date.getMonth() + 1; 
					var year = date.getFullYear();
						ot_req_date = padZero(day) + "/" + padZero(month) + "/" + year;
				}
				

                if(item.confession_note_ind == 1){
                    confession_note_ind = `<span class="badge badge-success btn-success"><i class="fa fa-check"></i></span>`;
                }else{
                    confession_note_ind = `<span class="badge bg-danger btn-danger"><i class="fa fa-times"></i></span>`;
                }

                if(item.anest_clearance_ind == 1){
                    anest_clearance_ind = `<span class="badge badge-success btn-success btn-md"><i class="fa fa-check" style="font-size:10px"></i></span>`;
                }else{
                    anest_clearance_ind = `<span class="badge bg-danger btn-danger"><i class="fa fa-times"></i></span>`;
                }

                if(item.obs_ind == 1){
                    obs_ind = `<span class="badge badge-success btn-success"><i class="fa fa-check"></i></span>`;
                }else{
                    obs_ind = `<span class="badge bg-danger btn-danger"><i class="fa fa-times"></i></span>`;
                }

                if(item.ot_in_ind == 1){
                    ot_in_ind = `<span class="badge badge-success btn-success"><i class="fa fa-check"></i></span>`;
                }else{
                    ot_in_ind = `<span class="badge bg-danger btn-danger"><i class="fa fa-times"></i></span>`;
                }

                if(item.ot_out_ind == 1){
                    ot_out_ind = `<span class="badge badge-success btn-success"><i class="fa fa-check"></i></span>`;
                }else{
                    ot_out_ind = `<span class="badge bg-danger btn-danger"><i class="fa fa-times"></i></span>`;
                }
                 
                
                        
                if(item.obs_ind == 1){
                    return_ipd_ind = `<span class="badge badge-info">to Observation</span>`;
                }
                else if(item.return_ipd_ind == 1){
                    return_ipd_ind = `<span class="badge badge-success">to IPD</span>`;
                }
                else{
                    return_ipd_ind = `<span class="badge badge-warning">Pending</span>`;
                }
                   

                var rowData = [
                    ++index,
                    item.patient_name,
                    item.ot_req_uid,
					item.admission_uid,
                    item.new_serivce_unit_name,
                    item.ward_name,
                    item.age,
					item.item_name,
                    ot_req_date,
					confession_note_ind,
                    anest_clearance_ind,
					obs_ind,
					ot_in_ind,
					ot_out_ind,
                    return_ipd_ind
                ];

                rows.push(rowData);
            });

            table.clear();
            table.rows.add(rows);
            table.draw(); 
        }

        function emptyTable(){
            $('.ot_requsition_table tbody').empty();
            $('.ot_requsition_table tbody').append(`
                <tr>
                    <td colspan="12" class="text-danger text-center">Data Not Found</td>
                </tr>
            `);
        }

        function emptyOSTable(){
            $('.operation_status_table tbody').empty();
            $('.operation_status_table tbody').append(`
                <tr>
                    <td colspan="15" class="text-danger text-center">Data Not Found</td>
                </tr>
            `);
        }

		function padZero(number){ return number < 10 ? "0" + number : number; }

</script>
