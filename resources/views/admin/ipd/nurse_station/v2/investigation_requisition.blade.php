
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
                            <h5 class="mt-2 mb-0">Investigation Requisition</h5>
                            <small>IPD / Nurse Station / Investigation Requisition</small>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">

                                <div class="col-12 pb-4 text-center">
                                    <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">Patient Name: {{ @$patient_info->patient_name }}</span>
                                    <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">UHID: {{ @$patient_info->patient_code }}</span>
                                    <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">IP No: {{ @$patient_info->admission_uid }}</span>
                                    <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">IP Date: {{ date('d/m/Y', strtotime($patient_info->admission_date)) }}</span>
                                    <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">IP Department: {{ $patient_info->admitted_department }}</span>
                                    <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">Bed Category: {{ $patient_info->ward_name }}</span>
                                    <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">Bed No: {{ $patient_info->bed_name }}</span>
                                </div>
                                <div class="col-md-12">
                                    <form action="{{route('v2.ipd.medicine-indent-request')}}" method="post" id="indentReqForm">
                                        @csrf
                                            <ul class="nav nav-tabs justify-content-center" id="myTab" role="tablist">
                                                <li class="nav-item">
                                                    <a class="nav-link active" id="received-patient" data-toggle="tab" href="#pending_medicine" role="tab" aria-controls="pending_medicine" aria-selected="true" onclick="getPendingInvestigation(true)">Pending Indent <span class="badge badge-secondary"></span></a>
                                                </li>

                                                <li class="nav-item">
                                                    <a class="nav-link " id="receive-request" data-toggle="tab" href="#approved_medicine" role="tab" aria-controls="pending_medicine" aria-selected="true" onclick="getApprovedMedcine(true)">Completed Indent<span class="badge badge-secondary"></span></a>
                                                </li>

                                                {{-- <li class="nav-item">
                                                    <a class="nav-link " id="medicine-receive" data-toggle="tab" href="#medicine_receive" role="tab" aria-controls="pending_medicine" aria-selected="true" onclick="getMedcineReceive(true)">Investigation Return<span class="badge badge-secondary"></span></a>
                                                </li> --}}
                                            </ul>

                                            <div class="tab-content p-0" id="myTabContent">
                                                <!-- Pending Medicine -->
                                                <div class="tab-pane fade show active" id="pending_medicine" role="tabpanel" aria-labelledby="received-patient">
                                                    <div class="row justify-content-center">
                                                        <div class="col-4 text-center mt-2">
                                                            @php
                                                                $lockBill=$patient_info->lock_ind !='' ? 'disabled':''; 
                                                            @endphp
                                                            <button type="button" class="btn btn-md btn-primary w-50" {{$lockBill}} onclick="IndentRequest()">Indent & Bill</button>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12">


                                                            <input type="hidden" name="admission_no_pk" value="{{ @$patient_info->admission_no_pk}}">
                                                            <input type="hidden" name="patient_no_pk" value="{{ @$patient_info->patient_no_pk}}">



                                                            <div class="table-responsive pt-2">
                                                                <table class="table table-striped table-bordered table-hover pending_medicine_table">
                                                                    <thead class="global-uhl-table-bg">
                                                                        <tr>
                                                                            <th class="text-center" style="width:5%">#SL</th>
                                                                            <th class="text-left" style="width:10%">Prescription Id</th>
                                                                            <th class="text-left" style="width:10%">Date</th>
                                                                            <th class="text-left" style="width:25%">Entry By</th>
                                                                            <th class="text-center" style="width:45%">Name</th>
                                                                            <th class="text-center" style="width:45%">Department</th>
                                                                            <th class="text-center" style="width:45%">Container</th>
                                                                            <th class="text-center" style="width:45%">Action</th>
                                                                            <th class="text-center" style="width:5%">
                                                                                <div style="display: flex;justify-content:center">
                                                                                    <div class="mt-1"> <input type="checkbox" name="checked_all" id="checked_all" value="1" class="form-control form-control-sm" onclick="checkedAll()"/></div>
                                                                                    <div><label class="form-check-label" for="checked_all">&nbsp;All</label></div>
                                                                                </div>
                                                                            </th>
                                                                        </tr>
                                                                    </thead>

                                                                    <tbody>
                                                                        <tr>
                                                                            <td colspan="8" class="text-center">Data Fetching ...</td>
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
                                                                                <th class="text-center" style="width:5%">#SL</th>
                                                                                <th class="text-left" style="width:10%">Prescription Id</th>
                                                                                <th class="text-left" style="width:10%">Date</th>
                                                                                <th class="text-left" style="width:25%">Entry By</th>
                                                                                <th class="text-center" style="width:45%">Name</th>
                                                                                <th class="text-center" style="width:5%">Action</th>
                                                                            </tr>
                                                                        </thead>

                                                                        <tbody>
                                                                            <tr>
                                                                                <td colspan="6" class="text-center">Data Fetching ...</td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Approved Medicine -->
                                                <div class="tab-pane fade " id="medicine_receive" role="tabpanel" aria-labelledby="medicine-receive">
                                                    <div class="table-responsive pt-2">
                                                        <table class="table table-striped table-bordered table-hover receive_medicine_table">
                                                            <thead class="global-uhl-table-bg">
                                                                <tr>
                                                                    <th class="text-center" style="width:3%">#SL</th>
                                                                    <th class="text-left" style="width:6%">Indent No</th>
                                                                    <th class="text-left" style="width:8%">Prescription Id</th>
                                                                    <th class="text-left" style="width:10%">Prescription Date</th>
                                                                    <th class="text-left" style="width:14%">Patient Name</th>
                                                                    <th class="text-center" style="width:5%">UHID</th>
                                                                    <th class="text-center" style="width:7%">Adm. Date</th>
                                                                    <th class="text-center" style="width:6%">Adm. Id</th>
                                                                    <th class="text-left" style="width:12%">Bed Category</th>
                                                                    <th class="text-center" style="width:8%">Bed No</th>
                                                                    <th class="text-left" style="width:11%">Consultant Name</th>
                                                                    <th class="text-center" style="width:8%">Action</th>
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
                                    </form>
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
    $(document).ready(function(){
        getPendingInvestigation();
    })
</script>

<script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
        });

        function getPendingInvestigation(search = null){

                let admission_id = '{{@$patient_info->admission_no_pk}}';
                let patient_id = '{{@$patient_info->patient_no_pk}}';

                $.ajax({
                    url: "{{route('v2.ipd.get-investigation-indent')}}",
                    method: "post",
                    data:{investigation_indent: 0, admission_id:admission_id, patient_id: patient_id},
                    beforeSend: function() {
                        if(search != null){
                            blockUI();
                        }
                    },
                    success: function(response){
                        $.unblockUI();
                        if(response.data.length != 0){
                            setPendingInvestigation(response.data);
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

            let admission_id = '{{@$patient_info->admission_no_pk}}';
            let patient_id = '{{@$patient_info->patient_no_pk}}';
            $.ajax({
                url: "{{route('v2.ipd.get-investigation-indent')}}",
                method: "post",
                data:{investigation_indent:1, admission_id:admission_id, patient_id: patient_id},
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

        function setPendingInvestigation(data){
            $('.pending_medicine_table tbody').empty();

			var rows = [];
            if($.fn.DataTable.isDataTable('.pending_medicine_table')) {
                $('.pending_medicine_table').DataTable().destroy();
            }

            var table = $('.pending_medicine_table').DataTable({
                        searching: true,
                        paginate:false,
                        columnDefs: [
                                { targets: [0,1, 2, 3], className: 'text-center' },
                                { targets: [4], className: 'text-left' }
                            ],
                    });

            data.forEach(function(item, index) {
				var au_entry_at = '';

				if(item.au_entry_at != ''){
					var date = new Date(item.au_entry_at);
					var day = date.getDate();
					var month = date.getMonth() + 1;
					var year = date.getFullYear();
                    au_entry_at = padZero(day) + "/" + padZero(month) + "/" + year;
				}

                var rowData = [
                    `${++index}`,
                    item.prescription_no_fk,
                    au_entry_at,
                    item.user_fullname,
                    item.prescrition_data,
                    item.serviceunit_name,
                    item.container_name,
                   `<button type="button" class="btn btn-danger btn-sm" onclick="deleteIndent(${item.prescription_dtl_no_pk})">Cancel</button>`,
                    `<input type="checkbox" value="${item.prescription_dtl_no_pk}" id="pending_indent${index}" name="pending_indent[]" class="all-investigation form-control form-control-sm">`,
                ];

                console.log(rowData);
                rows.push(rowData);
            });
            table.clear();
            table.rows.add(rows);
            table.draw();
        }


        function setApproved(data){

            $('.approved_medicine_table tbody').empty();

            var rows = [];
            if($.fn.DataTable.isDataTable('.approved_medicine_table')) {
                $('.approved_medicine_table').DataTable().destroy();
            }

            var table = $('.approved_medicine_table').DataTable({
                searching: true,
                        paginate:false,
                        columnDefs: [
                                { targets: [0,1, 2, 3, 5], className: 'text-center' },
                                { targets: [4], className: 'text-left' }
                            ],
                    });
            var button_group = '';
            data.forEach(function(item, index) {

                    button_group = '';
                    if(item.invoice_no_fk != null && item.ledgertrn_no_fk != null) {
                            button_group = `<a class="btn btn-sm btn-primary text-white" style="cursor:pointer" href="{{ url('pos-due-invoice-print-v2/${item.invoice_no_fk}/${item.ledgertrn_no_fk}') }}" target="_blank" title="Invoice">
                                                <i class="fa fa-file text-white"></i>
                                            </a>`;
                    }


                    var au_entry_at = '';
                    if(item.au_entry_at != ''){
                        var date = new Date(item.au_entry_at);
                        var day = date.getDate();
                        var month = date.getMonth() + 1;
                        var year = date.getFullYear();
                        au_entry_at = padZero(day) + "/" + padZero(month) + "/" + year;
                    }

                    var rowData = [
                            `${++index}`,
                            item.prescription_no_fk,
                            au_entry_at,
                            item.user_fullname,
                            item.prescrition_data,
                            item.serviceunit_name,
                            button_group,
                    ];
                    rows.push(rowData);
            });
            table.clear();
            table.rows.add(rows);
            table.draw();


        }

        function emptyTable(){
            $('.pending_medicine_table tbody').empty();
            $('.pending_medicine_table tbody').append(`
                <tr>
                    <td colspan="6" class="text-danger text-center">Data Not Found</td>
                </tr>
            `);
        }

        function emptyReceiveTable(){
            $('.approved_medicine_table tbody').empty();
            $('.approved_medicine_table tbody').append(`
                <tr>
                    <td colspan="6" class="text-danger text-center">Data Not Found</td>
                </tr>
            `);
        }

		function padZero(number){ return number < 10 ? "0" + number : number; }

        function IndentRequest(){
            let formElement = document.querySelector('#indentReqForm');
            let formData = new FormData(formElement);
            let hasError = false;

            if($('input[name="pending_indent[]"]:checked').length == 0){
                alert('Please select at least one item!');
                return false;
            }

            if(hasError == true){
                alert('Qty Required!');
                return false;
            }


            $.ajax({
                    url:"{{route('v2.ipd.investigation-indent-request')}}",
                    type:"post",
                    dataType:"json",
                    data:formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        blockUI();
                    },
                    success:function(data){
                        $.unblockUI();

                        getPendingInvestigation(null);
                       var action ="{{ route('due-colletion-ipd-invoice', [':id', ':trx']) }}";
                            action = action.replace(':id', data.invoice_no);
                            action = action.replace(':trx', data.bill_no);

                        dynamicFunc['afterSaveModal'](
                            action,
                            'common-modal-md',
                            'Invoice Details'
                        );
                    },
                    error:function(err){
                        $.unblockUI();
                        var error = err.responseJSON;
                        $('.common-modal-notify-error').modal('show');
                        $('.common-modal-notify-error .modal-title').html('Failed');
                        $('.common-modal-notify-error .modal-body').html(error.message);
                    },
                    complete: function() {
                        $.unblockUI();
                    }
            });
        }

        function checkedAll(){
            if($("#checked_all").is(":checked")){
                $(".all-investigation").prop('checked', true);
                $(".input_checked").attr('readonly', false);
            }
            else{
                $(".all-investigation").prop('checked', false);
                $(".input_checked").attr('readonly', true);
            }
        }

        // Medicine Delivery
        function getMedcineReceive(search = null){
                $.ajax({
                    url: "{{route('v2.ipd.get-medicine-indent-delivery')}}",
                    method: "post",
                    data:{delivered:1},
                    beforeSend: function() {
                        if(search != null){
                            blockUI();
                        }
                    },
                    success: function(response){
                        $.unblockUI();
                        if(response.data.length != 0){
                            setMedicineReceive(response.data);
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

        function setMedicineReceive(data){
            $('.receive_medicine_table tbody').empty();

            var rows = [];
            if($.fn.DataTable.isDataTable('.receive_medicine_table')) {
            $('.receive_medicine_table').DataTable().destroy();
            }

            var table = $('.receive_medicine_table').DataTable({
                    searching: true,
                    columnDefs: [
                            { targets: [0, 1, 2, 3, 5, 6, 7, 11], className: 'text-center' },
                            { targets: [ 4, 8, 9, 10], className: 'text-left' }
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
                var date = new Date(item.admission_date);
                var day = date.getDate();
                var month = date.getMonth() + 1;
                var year = date.getFullYear();
                    pres_date = padZero(day) + "/" + padZero(month) + "/" + year;
            }

            button_group = `<a style="cursor:pointer" class="open-modal btn btn-sm btn-info text-white mr-1"
                                    data-action="{{ route('v2.ipd.get-prescription-wise-pending-medicine-delivered-receive', '') }}/${item.patmedtran_no_pk}"
                                    data-id="${item.patmedtran_no_pk}" data-modal="common-modal-sm"
                                    data-title="Pending Medicine" title="Pending Medicine">
                                    <i class="fa fa-eye"></i>
                                </a>`;


            button_group+= `<a style="cursor:pointer" class="open-modal btn btn-sm btn-info text-white mr-1"
                                    data-action="{{ route('v2.ipd.medicine-receive-request', '') }}/${item.patmedtran_no_pk}"
                                    data-id="${item.patmedtran_no_pk}" data-modal="common-modal-sm"
                                    data-title="Medicine Receive" title="Medicine Receive">
                                    Receive
                                </a>`;

            // button_group+= `<a class="btn btn-sm btn-primary text-white" style="cursor:pointer" onclick="receiveMedicine('${item.patmedtran_no_pk}')" title="Click to Delivery">
            //                         Receive
            //                 </a>`;

            var admission_pres_same = ''  ;
            var today = moment().format('DD/MM/YYYY');
            if(admission_date == pres_date == today)  {
                admission_pres_same = 'admission_pres_same';
            }
            var rowData = [
                `<span class="${admission_pres_same}">${++index}</span>`,
                item.ref_tran_id,
                item.prescription_no_pk,
                pres_date,
                item.patient_name,
                item.uhid,
                admission_date,
                item.admission_no_pk,
                item.ward_name,
                item.bed_name,
                item.doctor_name,
                button_group,
            ];
            rows.push(rowData);
            });
            table.clear();
            table.rows.add(rows);
            table.draw();

            $(".admission_pres_same").parent().parent().addClass('admission_pres_same_selected');
        }

        function receiveMedicine(id){
                $.ajax({
                    url: "{{route('v2.ipd.medicine-receive')}}",
                    method: "post",
                    data:{id:id},
                    beforeSend: function() {
                            blockUI();
                    },
                    success: function(response){
                        getMedcineDelivery();
                        $('.common-modal-notify').modal('show');
                        $('.common-modal-notify .modal-title').html('Success');
                        $('.common-modal-notify .modal-body').html(response.message);
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
    function deleteIndent(id) {
        if(!confirm("Are you sure you want to cancel this Indent?")) return;

        fetch("{{ url('v2/ipd/medicine-indent-delete') }}/" + id, {
            method: "DELETE",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Accept": "application/json"
            }
        })
        .then(res => res.json())
        .then(data => {
            if(data.success){
                alert(data.message);
                getPendingInvestigation();
            } else {
                alert("Error: " + data.message);
            }
        })
        .catch(err => alert("Error: " + err));
    }
    
</script>
