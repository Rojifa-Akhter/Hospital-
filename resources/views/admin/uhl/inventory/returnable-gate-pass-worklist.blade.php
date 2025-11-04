<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<style>
    .text-left{
        text-align:left;
    }

    .center{
        display: flex;
        justify-content: center;
        align-items: center
    }
    .profile{
        height: 80px;
        width: 80px;
        border-radius: 50%; 
        overflow: hidden;
        outline:3px dotted #B4B5B6;
    }
    .expired-bg{
        background-color: red !important;
        color:white;
    }
    .return-table td{
        white-space: nowrap
    }
    .end{
        display: flex;
        justify-content: end;
    }
    .list-group-item{
        border:none !important;
        padding: 5px 5px !important;
        padding-bottom: 0px !important;
        background-color: unset;
    }
    .pdf-icon{
        font-size: 22px;
        color: red
    }
</style>
<main id="page-content">
    <section class="fixed_asset">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="row justify-content-between align-items-center bg-white border-bottom sticky-top shadow-sm">
                        <div class="col-md-11">
                            <h5 class="mt-2 mb-0">Returnable Gate Pass Worklist</h5>
                            <small>Gate Pass / Returnable Gate Pass Worklist</small>
                        </div>
                    </div>
                </div>
            </div>
            
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <form action="#" method="post" id="getPassReturnable" class="getPassReturnable">
                                    @csrf
                                    <div class="row gx-1">

                                        <div class="col-md-2 col-12">
                                            <div class="form-group">
                                                <label for="department" class="col-form-label" class="form-control form-control-sm">Department</label>    
                                                <select name="department" id="department" class="form-control form-control-sm select2">
                                                    <option value="">All</option>
                                                    @foreach ($dept as $item)
                                                        <option value="{{$item->store_no_fk}}">{{$item->department}}</option>   
                                                    @endforeach
                                                </select>                                        
                    
                                            </div>
                                        </div>

                                        <div class="col-md-2 col-12">
                                            <div class="form-group">
                                                <label for="status" class="col-form-label">Status</label>                                            
                                                <select class="form-control form-control-sm" id="status" name="status"  value="" >
                                                    <option value="" >All</option>
                                                    <option value="0" selected>Pending</option>
                                                    <option value="1">Received</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-2 col-12">
                                            <div class="form-group">
                                                <label for="gid" class="col-form-label">GID</label>                                            
                                                <input type="text" class="form-control form-control-sm" id="gid" name="gid" placeholder="Enter Gate Pass Id" value="" />
                                            </div>
                                        </div>

                                        <div class="col-md-2 col-12">
                                            <div class="form-group">
                                                <label for="from_date" class="col-form-label">From Date <span class="text-danger">*</span></label>                                            
                                                <input type="text" class="form-control form-control-sm date_picker" id="from_date" name="from_date" value="" placeholder="Enter From Date"/>
                                            </div>
                                        </div>

                                        <div class="col-md-2 col-12">
                                            <div class="form-group">
                                                <label for="to_date" class="col-form-label">To Date<span class="text-danger">*</span></label>                                            
                                                <input type="text" class="form-control form-control-sm date_picker" id="to_date" name="to_date" placeholder="Enter To Date" value="" />
                                            </div>
                                        </div>

                                        <div class="col-md-2 col-12">
                                            <div class="form-group">
                                                <label for="submit" class="col-form-label"></label> <br>                                        
                                                <button type="button" class="btn btn-secondary uhl_common_btn btn-md-global" onclick="getPassReturnableForm()">Search</button>
                                            </div>
                                        </div>

                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
           

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="end export-option my-2">
                                <ul class="list-group list-group-horizontal-sm">
                                    <li class="list-group-item"><span onclick="downloadReturnReceive('pdf')" style="cursor:pointer"><i class="fas fa-file-pdf pdf-icon"></i></span></li>
                                </ul>
                            </div> 
                            <div class="table-responsive">
                                <table class="return-table table table-striped table-bordered table-hover return_gate_pass" id="gatePassDataTable">
                                    <thead class="global-uhl-table-bg">
                                        <tr>
                                            <th class="text-center">SL No</th>
                                            <th class="text-center" style="white-space: nowrap">Department</th>
                                            <th class="text-center">GID</th>
                                            <th class="text-center">Date</th>
                                            <th class="text-center">Issued By</th>
                                            <th class="text-center">Issue To</th>
                                            <th class="text-center">Issue Date</th>
                                            <th class="text-center">Return Date</th>
                                            <th class="text-center">Purpose/Problem</th>
                                            <th class="text-center">Supplier Name</th>
                                            <th class="text-center">OneTime</th>
                                            <th class="text-center">No of Item</th>
                                            <th class="text-center">status</th>
                                            <th class="text-center">Approval Status</th>
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

        </div>
    </section>
</main>

<!-- Profile Show -->
<input type="hidden" id="profileShowModalButton" class="btn btn-primary" data-toggle="modal" data-target="#profileShowModal">

<div class="modal fade" id="profileShowModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Profile</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        <div class="modal-body">

            <div class="center">
                <img src="" alt="" class="profile" id="image">
            </div>
            <table class="table table-striped table-bordered mt-3">
                <tbody>
                  <tr>
                    <th class="text-left w-25" style="text-align: left !important">Name <span class="float-right">:</span></th>
                    <td id="name" class="w-75" style="text-align: left !important"></td>
                  </tr>
                  <tr>
                    <th class="w-25" style="text-align: left !important">Mobile <span class="float-right">:</span></th>
                    <td id="mobile" class="w-75" style="text-align: left !important"></td>
                  </tr>
                  <tr>
                    <th class="w-25" style="text-align: left !important">Designation <span class="float-right">:</span></th>
                    <td id="designation" class="w-75" style="text-align: left !important"></td>
                  </tr>
                  <tr>
                    <th class="w-25" style="text-align: left !important">Department <span class="float-right">:</span></th>
                    <td id="departments" class="w-75" style="text-align: left !important"></td>
                  </tr>
                </tbody>
            </table>
        </div>
      </div>
    </div>
</div>

<!-- Close Profile Show -->
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script>
    $(document).ready(function(){

        $('.select2').select2();

        //set date
        var currentDate = new Date();
        $('.date_picker').datepicker({
			todayHighlight: true,
			clearBtn: true,
			autoclose: true,
            changeMonth: true,
            changeYear: true,
			format: 'mm/dd/yyyy',
		}).datepicker('setDate', currentDate);
    })

</script>


<script>
    $("#getPassReturnable").validate({
        rules:{
            from_date:{
                required:true,
            },
            to_date:{
                required:true,
            } 
        },
        messages:{
            from_date:{
                    required: 'From Date Required'
            },
            to_date:{
                    required:'To Date Required'
            }
        }
    });
</script>

<script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
        });

        function showProfile(name,mobile,department,designation,photo){
            $('#profileShowModalButton').click(); 
           
            var imageSrc = "{{asset('')}}images/uploads/doctor_images/"+photo;

            $('#image').attr('src',imageSrc); 

            if(photo == "null"){
                imageSrc = "{{asset('')}}images/user.jpg";
            }

            $('#image').attr('src',imageSrc); 
            $('#name').text(name); 
            $('#mobile').text(mobile); 
            $('#designation').text(designation); 
            $('#departments').text(department); 

        }

        <!-- Fetch Table Data -->
           $(document).ready(function(){
                let formElement = document.querySelector('#getPassReturnable');
                let formData = new FormData(formElement);
                    $.ajax({
                    url: "{{route('v1.returnable-gate-pass-list')}}",
                    method: "post",
                    dataType:"json",
                    data:formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(response){
                        if(response.data.length != 0)
                        {
                            setTableData(response.data);
                        }                       
                        else
                        {
                            emptyTable();
                        }
                        
                    },
                    error:function(err){
                        var error = err.responseJSON;
                        $('.common-modal-notify-error').modal('show');
                        $('.common-modal-notify-error .modal-title').html('Failed');
                        $('.common-modal-notify-error .modal-body').html(error.message); 
                    }
                })
           })


        $(document).ready(function(){
            $('#gatePassDataTable').DataTable({
                searching: true,
                columnDefs: [
                        { targets: [0, 2, 3, 4,6, 7, 10, 11, 12,13], className: 'text-center' },
                        { targets: [1,5,8,9], className: 'text-left' }
                    ],
                    "lengthMenu": [[10, 25, 50, 75, 100, -1], [10, 25, 50, 75, 100, "All"]], 
                    "pageLength": 10 
                });
            $('th').addClass('text-center');
        })

        <!-- Submit Form Data -->
        function getPassReturnableForm(){
            if($('#getPassReturnable').valid()){ 
                let formElement = document.querySelector('#getPassReturnable');
                let formData = new FormData(formElement);
                
                $.ajax({
                    url:"{{route('v1.returnable-gate-pass-list')}}",
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
                        if(data.data.length != 0)
                        setTableData(data.data);
                        else
                        emptyTable();
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
        }

        function downloadReturnReceive(type){
            let formElement = document.querySelector('#getPassReturnable');
            let formData = new FormData(formElement);
            console.log('data',formData)

            $.ajax({
            url: "{{route('v1.accounts.download-return-receive-gate-pass')}}",
            method: 'post',
    
            data:formData,
            cache: false,
            contentType: false,
            processData: false,
            xhrFields: {
                responseType: 'blob' 
            },
            success: function(data) {
                var downloadLink = document.createElement('a');
                var url = window.URL.createObjectURL(new Blob([data]));
                downloadLink.href = url;                  
                downloadLink.setAttribute('download', 'return_receive_gate_pass.pdf');
                document.body.appendChild(downloadLink);
                downloadLink.click();
                document.body.removeChild(downloadLink);
                window.URL.revokeObjectURL(url);
            },
            error: function(xhr, status, error) {
                $('.common-modal-notify-error').modal('show');
                $('.common-modal-notify-error .modal-title').html('Failed');
                $('.common-modal-notify-error .modal-body').html(error);
            }
            });
        }
        
        <!-- Set Table Data -->
        function setTableData(data){
            $('.return_gate_pass tbody').empty();          
            var rows = [];
            var table = $('#gatePassDataTable').DataTable();
            var status = "";
            var gate_pass_date = "";
            var issue_date = "";
            var return_date = "";
            var date = "";
            var expired = false;
            var rcv_ind = "";
            var edit_button = "";
            data.forEach(function(item, index) {

                var status = 'Approval Not Found';
                var approval_exp = (item.approval_level_status_text != null && item.approval_level_status_text != '') ? item.approval_level_status_text.split('/') : [];
                var status_pending = (item.approval_status_text != null) ? item.approval_status_text.includes('PENDING') : false;

                if (item.approval_status_text != null) {
                    if (item.approval_status_text.includes('APPROVED')) {
                        status = 'APPROVED';
                    }
                    if (item.approval_status_text.includes('PENDING')) {
                        status = 'PENDING';
                    }
                    if (item.approval_status_text.includes('REJECTED')) {
                        status = 'REJECTED';
                    }
                    if (item.approval_status_text.includes('HOLD')) {
                        status = 'HOLD';
                    }
                }


                if(item.gatepass_date != ""){
                    date = new Date(item.gatepass_date);
                    gate_pass_date = (date.getMonth() + 1) + '/' + date.getDate() + '/' + date.getFullYear();
                }

                if(item.issue_date != ""){
                    date = new Date(item.issue_date);
                    issue_date = (date.getMonth() + 1) + '/' + date.getDate() + '/' + date.getFullYear();
                }

                if(item.return_date != ""){
                    date = new Date(item.return_date);
                    return_date = (date.getMonth() + 1) + '/' + date.getDate() + '/' + date.getFullYear();
                }

                var specificDate = new Date(return_date);
                var today = new Date();
                if (item.return_date != "" && specificDate < today && item.rcv_ind == 0) {
                    expired = true
                }
                else{
                    expired = false
                }
                
                if((item.rcv_ind) == 1){

                    rcv_ind = `<span class="primary badge badge-primary" style="text-decoration:underline;cursor:pointer" onclick="showProfile('${item.rcv_name}','${item.rcv_contact}','${item.rcv_department}','${item.rcv_designation}','${item.rcv_photo_name}')" title="click to show profile">Received</span>`;
                }
                    else{
                      edit_button = '<span class="btn btn-sm btn-success btn-md-global open-modal btnView" data-action="{{route('v1.returnable-gate-pass-edit','')}}/'+item.gatepass_no_pk+'" data-modal="common-modal-sm" data-title="Receive Gate Pass" title="Receive Gate Pass" data-id="'+item.gatepass_no_pk+'"><i class="fas fa-edit"></i></span>'
                      rcv_ind = '<span class="badge badge-danger">Pending</span>';
                    }

                var rowData = [                        
                    `<span class="${expired == true ? 'expired' : ''}">${++index}</span>`,
                    `<span style="white-space: nowrap">${item.department}</span>`,
                    item.gatepass_uid,
                    gate_pass_date,
                    `<span class="primary" style="text-decoration:underline;cursor:pointer" onclick="showProfile('${item.emp_name}','${item.emp_contact}','${item.emp_department}','${item.emp_designation}','${item.emp_photo_name}')" title="click to show profile">${item.emp_name}</span>`,
                    `<span style="white-space: nowrap">${item.issued_to_name}</span>`,
                    issue_date,
                    return_date,
                    item.gatepass_purpose_short,
                    `<span style="white-space: nowrap">${item.vendor_supplier_name}</span>`,
                    item.onetime_use_ind,
                    item.item_count,
                    rcv_ind,
                    `<span style="white-space: nowrap">${status}</span>`,                   
                    edit_button,
                ];
                rows.push(rowData);
            });
            table.clear();
            table.rows.add(rows);
            table.draw();

            $('.expired').parent().parent().addClass('bg-warning');
        }
        function emptyTable(){
            $('.return_gate_pass tbody').empty();
            $('.return_gate_pass tbody').append(`
                <tr>
                    <td colspan="15" class="text-danger text-center">Data Not Found</td>
                </tr>
            `);

        }   
</script>
