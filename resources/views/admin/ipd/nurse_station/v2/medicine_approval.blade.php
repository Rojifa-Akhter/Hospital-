
<style>
	.approved_medicine_table>thead>tr>th{
		font-size: 15px !important;
	}
	.approved_medicine_table>tbody>tr>td{
		font-size: 15px !important;
	}

	.pending_medicine_table>thead>tr>th{
		font-size: 15px !important;
	}
	.pending_medicine_table>tbody>tr>td{
		font-size: 15px !important;
	}

    .position-center{
       /* margin-bottom: -30px  */
    }
    .admission_pres_same_selected{
        background-color: rgb(203, 210, 210) !important;
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
                            <h5 class="mt-2 mb-0">Medicine Approval</h5>
                            <small>IPD / Nurse Station / Medicine Approval </small>
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
                                            <a class="nav-link active" id="received-patient" data-toggle="tab" href="#pending_medicine" role="tab" aria-controls="pending_medicine" aria-selected="true" onclick="getPendingMedicine(true)">Pending Medicine <span class="badge badge-secondary"></span></a>
                                        </li>
        
                                        <li class="nav-item">
                                            <a class="nav-link " id="receive-request" data-toggle="tab" href="#approved_medicine" role="tab" aria-controls="pending_medicine" aria-selected="true" onclick="getApprovedMedcine(true)">Approved Medicine<span class="badge badge-secondary"></span></a>
                                        </li>
                                    </ul>

                                    <div class="tab-content p-0" id="myTabContent">   
                                        <!-- Pending Medicine -->                       
                                        <div class="tab-pane fade show active" id="pending_medicine" role="tabpanel" aria-labelledby="received-patient">                                        
											
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="table-responsive pt-2">
                                                        <table class="table table-striped table-bordered table-hover pending_medicine_table">
                                                            <thead class="global-uhl-table-bg">
                                                                <tr>
                                                                    <th class="text-center" style="width:3%">#SL</th>
                                                                    <th class="text-left" style="width:8%">Prescription Id</th>
                                                                    <th class="text-left" style="width:10%">Prescription Date</th>
                                                                    <th class="text-left" style="width:13%">Patient Name</th>
                                                                    <th class="text-center" style="width:5%">UHID</th>
                                                                    <th class="text-center" style="width:7%">IP Date</th>
                                                                    <th class="text-center" style="width:6%">IP No</th>
                                                                    <th class="text-left" style="width:9%">Bed Category</th>
                                                                    <th class="text-center" style="width:7%">Bed No</th>
                                                                    <th class="text-left" style="width:14%">Consultant</th>
                                                                    <th class="text-left" style="width:12%">Department</th>
                                                                    <th class="text-center" style="width:4%">Action</th>                 
                                                                </tr>
                                                            </thead>
                        
                                                            <tbody>
                                                                <tr>
                                                                    <td colspan="12" class="text-center">Data Fetching ...</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <!-- Approved Medicine -->
                                        <div class="tab-pane fade " id="approved_medicine" role="tabpanel" aria-labelledby="receive-request">

                                            <div class="row">
                                                <div class="col-12">
                                                    <div style="padding-top:10px">
                                                        <div class="table-responsive">
                                                            <table class="table table-striped table-bordered table-hover approved_medicine_table">
                                                                <thead class="global-uhl-table-bg">
                                                                    <tr>
                                                                        <th class="text-center" style="width:3%">#SL</th>
                                                                        <th class="text-left" style="width:8%">Prescription Id</th>
                                                                        <th class="text-left" style="width:10%">Prescription Date</th>
                                                                        <th class="text-left" style="width:13%">Patient Name</th>
                                                                        <th class="text-center" style="width:5%">UHID</th>
                                                                        <th class="text-center" style="width:7%">IP Date</th>
                                                                        <th class="text-center" style="width:6%">IP No</th>
                                                                        <th class="text-left" style="width:9%">Bed Category</th>
                                                                        <th class="text-center" style="width:7%">Bed No</th>
                                                                        <th class="text-left" style="width:14%">Consultant</th>
                                                                        <th class="text-left" style="width:12%">Department</th>
                                                                        <th class="text-center" style="width:4%">Action</th>                 
                                                                    </tr>
                                                                </thead>
                            
                                                                <tbody>
                                                                    <tr>
                                                                        <td colspan="12" class="text-center">Data Fetching ...</td>
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
<script>
	 $("body").addClass("sidebar-collapse");
    $(document).ready(function(){
        getPendingMedicine();
    })
</script>

<script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
        });
       
        function getPendingMedicine(search = null){

                $.ajax({
                    url: "{{route('v2.ipd.get-medicine-approval')}}",
                    method: "post",
                    data:{medicine_approval:0},
                    beforeSend: function() {
                        if(search != null){
                            blockUI();
                        }
                    },
                    success: function(response){
                        $.unblockUI();
                        if(response.data.length != 0){
                            setPendingMedicine(response.data);
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

        function getApprovedMedcine(search = null){
            $.ajax({
                url: "{{route('v2.ipd.get-medicine-approval')}}",
                method: "post",
                data:{medicine_approval:1},
                beforeSend: function() {
                    if(search != null){
                        blockUI();
                    }
                },
                success: function(response){
                    $.unblockUI();
                    if(response.data.length != 0){
                        setApproved(response.data);
                    }
                    else{
                        emptyReceiveTable();
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

        function setPendingMedicine(data){
            $('.pending_medicine_table tbody').empty();

			var rows = [];
            if($.fn.DataTable.isDataTable('.pending_medicine_table')) {
                $('.pending_medicine_table').DataTable().destroy();
            }

            var table = $('.pending_medicine_table').DataTable({
                        searching: true,
                        columnDefs: [
                                { targets: [0,1, 2,4,5, 6, 11], className: 'text-center' },
                                { targets: [ 3, 7, 8, 9, 10], className: 'text-left' }
                            ],
						"lengthMenu": [[15, 25, 50, 75, 100, -1], [15, 25, 50, 75, 100, "All"]], 
                		"pageLength": 15
                    });

			var button_group = ``;
            data.forEach(function(item, index) {
				var admission_date = '';
				var pres_date = '';

				if(item.admission_date != ''){
					var date = new Date(item.admission_date);
					var day = date.getDate();
					var month = date.getMonth() + 1; 
					var year = date.getFullYear();
						admission_date = padZero(day) + "/" + padZero(month) + "/" + year;
				}

				if(item.prescription_date != ''){
					var date = new Date(item.prescription_date);
					var day = date.getDate();
					var month = date.getMonth() + 1; 
					var year = date.getFullYear();
						pres_date = padZero(day) + "/" + padZero(month) + "/" + year;
				}
                
                button_group = `<a style="cursor:pointer" class="open-modal"
                                        data-action="{{ route('v2.ipd.get-prescription-wise-pending-medicine', '') }}/${item.prescription_no_pk}"
                                        data-id="${item.prescription_no_pk}" data-modal="common-modal-sm"
                                        data-title="Pending Medicine" title="Pending Medicine">
                                        <i class="fa fa-eye"></i>
                                    </a>`;   
                
                button_group+= `<a href="{{ route('op_summary_pdf_uhl', '') }}/${item.prescription_no_pk}"
                                    class="btn btn-outline-primary btn-sm bg-none cursor-pointer"
                                    target="_blank" data-id="${item.prescription_no_pk}"
                                    title="Print Prescription"><i class="fa fa-file-pdf"></i>
                                </a>`;  
                                          
                button_group+= `<a style="cursor:pointer" class="btn btn-outline-success btn-sm bg-none cursor-pointer ml-1" href="{{route('ipd.patient-assesment', '','')}}/${item.patient_no_fk}/${item.admission_no_pk}" target="_blank" title="Doctor Note"><i class="fa fa-sticky-note"></i></a>`;   

                 var admission_pres_same = ''  ;
                 var today = moment().format('DD/MM/YYYY');
                 if(admission_date == pres_date == today)  {
                    admission_pres_same = 'admission_pres_same';
                 }               
                var rowData = [
                    `<span class="${admission_pres_same}">${++index}</span>`,
                    item.prescription_no_pk,
                    pres_date,
                    item.patient_name,
                    item.uhid,
                    admission_date,
                    item.admission_no_pk,
					item.ward_name,
					item.bed_name,
                    item.doctor_name,
					item.su_name,
                    `<span style="white-space:nowrap">${button_group}</span>`,
                ];
                rows.push(rowData);
            });
            table.clear();
            table.rows.add(rows);
            table.draw(); 

            $(".admission_pres_same").parent().parent().addClass('admission_pres_same_selected');
        }

        function setApproved(data){

            $('.approved_medicine_table tbody').empty();

            var rows = [];
            if($.fn.DataTable.isDataTable('.approved_medicine_table')) {
                $('.approved_medicine_table').DataTable().destroy();
            }

            var table = $('.approved_medicine_table').DataTable({
                        searching: true,
                        columnDefs: [
                                { targets: [0,1, 2,4,5, 6, 11], className: 'text-center' },
                                { targets: [ 3, 7, 8, 9, 10], className: 'text-left' }
                            ],
						"lengthMenu": [[15, 25, 50, 75, 100, -1], [15, 25, 50, 75, 100, "All"]], 
                		"pageLength": 15
                    });

            data.forEach(function(item, index) {
				var admission_date = '';
				var pres_date = '';
				var button_group = '';

				if(item.admission_date != ''){
					var date = new Date(item.admission_date);
					var day = date.getDate();
					var month = date.getMonth() + 1; 
					var year = date.getFullYear();
						admission_date = padZero(day) + "/" + padZero(month) + "/" + year;
				}

                if(item.prescription_date != ''){
					var date = new Date(item.prescription_date);
					var day = date.getDate();
					var month = date.getMonth() + 1; 
					var year = date.getFullYear();
						pres_date = padZero(day) + "/" + padZero(month) + "/" + year;
				}
				
                button_group+= ``;
                
                button_group = `<a style="cursor:pointer" class="open-modal"
                                        data-action="{{ route('v2.ipd.get-prescription-wise-approved-medicine', '') }}/${item.prescription_no_pk}"
                                        data-id="${item.prescription_no_pk}" data-modal="common-modal-sm"
                                        data-title="Approved Medicine" title="Approved Medicine">
                                        <i class="fa fa-eye"></i>
                                    </a>`; 

                button_group+= `<a href="{{ route('op_summary_pdf_uhl', '') }}/${item.prescription_no_pk}"
                                    class="btn btn-outline-primary btn-sm bg-none cursor-pointer"
                                    target="_blank" data-id="${item.prescription_no_pk}"
                                    title="Print Prescription"><i class="fa fa-file-pdf"></i>
                                </a>`;
                button_group+= `<a style="cursor:pointer" class="btn btn-outline-success btn-sm bg-none cursor-pointer ml-1" href="{{route('ipd.patient-assesment', '','')}}/${item.patient_no_fk}/${item.admission_no_pk}" target="_blank" title="Doctor Note"><i class="fa fa-sticky-note"></i></a>`;
                var rowData = [
                    ++index,
                    item.prescription_no_pk,
                    pres_date,
					item.patient_name,
                    item.uhid,
                    admission_date,
                    item.admission_no_pk,
					item.ward_name,
					item.bed_name,
                    item.doctor_name,
					item.su_name,
                    `<span style="white-space:nowrap">${button_group}</span>`
                ];

                rows.push(rowData);
            });

            table.clear();
            table.rows.add(rows);
            table.draw(); 

            $(".admission_pres_same").parent('tr').addClass('admission_pres_same_selected')
        }

        function emptyTable(){
            $('.pending_medicine_table tbody').empty();
            $('.pending_medicine_table tbody').append(`
                <tr>
                    <td colspan="12" class="text-danger text-center">Data Not Found</td>
                </tr>
            `);
        }

        function emptyReceiveTable(){
            $('.approved_medicine_table tbody').empty();
            $('.approved_medicine_table tbody').append(`
                <tr>
                    <td colspan="12" class="text-danger text-center">Data Not Found</td>
                </tr>
            `);
        }

		function padZero(number){ return number < 10 ? "0" + number : number; }

        $(document).ready(function(){
            $(document).on('click', 'a', function(){
                $(".admission_pres_same").parent().parent().addClass('admission_pres_same_selected');
            })
        })
</script>
