<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<style>
    .text-left{
        text-align:left;
    }
    .file {
        cursor: pointer;
        color: #595757;
        border: 1px dashed #97dad4;
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
    .description{
      border: 1px dotted #B4B5B6;  
      border-radius: 5px;
      padding:3px;
      height: 260px;
      overflow-y: scroll;
    }
</style>
<main id="page-content">
    <section class="fixed_asset">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="row justify-content-between align-items-center bg-white border-bottom sticky-top shadow-sm">
                        <div class="col-md-11">
                            <h5 class="mt-2 mb-0"> Ticket Mangement</h5>
                            <small>Support Ticket / Ticket Mangement</small>
                        </div>
                    </div>
                </div>
            </div>
            <form action="#" method="post" id="supportTicketSearch" class="supportTicketSearch">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-row">

                                    <div class="col-md-2">                                                                               
                                        <label for="from_date" class="col-form-label">From Date<span style="color:red">*</span></label>
                                        <input type="text" class="form-control form-control-sm date_picker" id="from_date" name="from_date" placeholder="From Name" value="" />                                                   
                                    </div>
                                    <div class="col-md-2">                                                                               
                                        <label for="to_date" class="col-form-label">To Date<span style="color:red">*</span></label>
                                        <input type="text" class="form-control form-control-sm date_picker" id="to_date" name="to_date" placeholder="Issue Name" value="" />                                                   
                                    </div>

                                    <div class="col-md-3">                                                                               
                                        <label for="employeer" class="col-form-label">Employeer<span style="color:red">*</span></label>
                                        <select type="text" class="form-control form-control-sm select2" id="employeer" name="employeer"> 
                                            <option value="">Select One</option>
                                                @foreach ($users as $item)
                                                    @if($item->status == 1 && !empty($item->user_fullname))
                                                        <option value="{{$item->person_no_fk}}" > @if(!empty($item->user_code)){{$item->user_code}} - @endif {{$item->user_fullname}}   </option>
                                                    @endif
                                            @endforeach 
                                        </select>                                                  
                                    </div>

                                    <div class="col-md-3">                                                                               
                                        <label for="progress" class="col-form-label">Progress<span style="color:red">*</span></label>
                                        <select type="text" class="form-control form-control-sm" id="progress" name="progress"> 
                                            <option value="">Select One</option>
                                            <option value="1">Pending</option>
                                            <option value="2">working</option>
                                            <option value="3">Done</option>
                                            <option value="4">Now Not Possible</option>
                                            <option value="5">Not Possible</option>
                                        </select>                                                  
                                    </div>
                                    
                                    <div class="col-md-2">    
                                        <label for="progress" class="col-form-label"></label>                                                                                                        
                                        <button type="button" class="btn btn-md btn-success w-100" onclick="supportTicketSearch()"><i class="fa fa-search"></i>&nbsp;Search</button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </form>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover ticket_v1" id="ticketDataTable">
                                    <thead class="global-uhl-table-bg">
                                        <tr>
                                            <th class="text-center" style="width:5%">SL No</th>
                                            <th class="text-center" style="width:12%">Issue Date</th>
                                            <th class="text-center" style="width:8%">Issue code</th>
                                            <th class="text-center" style="width:30%">Issue Name</th>
                                            <th class="text-center" style="width:15%">Issued By</th>
                                            <th class="text-center" style="width:10%">Assigned</th>
                                            <th class="text-center" style="width:10%">Progress</th>
                                            <th class="text-center" style="width:5%">Document</th>
                                            <th class="text-center" style="width:5%">Action</th>
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


<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
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
                    <td id="department" class="w-75" style="text-align: left !important"></td>
                  </tr>
                </tbody>
            </table>
        </div>
      </div>
    </div>
</div>
<!-- Close Profile Show -->

<script>
    $("#supportTicketSearch").validate({
        rules:{
            from_date:{
                dateFormat:true,
                // notOnlySpaces: true,
            },
            to_date:{
                dateFormat:true, 
                // notOnlySpaces: true
            },

        },
        messages:{
            from_date:{
                required: "From Date Required",
            },
            to_date:{
                required: "To Date Required",
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

        $(document).ready(function() {
            $('.select2').select2();
        });

        $(function(){
            var currentDate = new Date();           
            $('.date_picker').datepicker({
                todayHighlight: true,
                clearBtn: true,
                autoclose: true,
                format: 'dd-mm-yyyy',
                maxDate: currentDate,
                changeMonth: true,
                changeYear: true,
            }).datepicker('setDate', currentDate);

        })

        $(document).ready(function(){
            $('#ticketDataTable').DataTable({
                searching: true,
                columnDefs: [
                        { targets: [0, 1,2, 4, 5, 6,7], className: 'text-center' },
                        { targets: [3], className: 'text-left' }
                    ],
                    "lengthMenu": [[10, 25, 50, 75, 100, -1], [10, 25, 50, 75, 100, "All"]], 
                    "pageLength": 10 
                });
            $('th').addClass('text-center');
        })

        $(document).ready(function() {
            fetchData();
            function fetchData(){
                let formElement = document.querySelector('.supportTicketSearch');
                let formData = new FormData(formElement);
                $.ajax({
                    url: "{{route('v1.ticket.get-support-ticket')}}",
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
            } 
        });

        function getData(){
                let formElement = document.querySelector('.supportTicketSearch');
                let formData = new FormData(formElement);
                $.ajax({
                    url: "{{route('v1.ticket.get-support-ticket')}}",
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
            } 



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
            $('#department').text(department); 

        }

        function supportTicketSearch(){

            var from_date = $('#from_date').val();
            var to_date = $('#to_date').val();

            if(from_date != '' && to_date == ''){
                alert('Only From Date not Acceptable.')
                return false;
            }
            if(to_date != '' && from_date == ''){
                alert('Only To Date not Acceptable.')
                return false;
            }

            if($('#supportTicketSearch').valid()){ 
                let formElement = document.querySelector('#supportTicketSearch');
                let formData = new FormData(formElement);
                
                $.ajax({
                    url:"{{route('v1.ticket.get-support-ticket')}}",
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
        
        <!-- Set Table Data -->
        function setTableData(data){
            $('.ticket_v1 tbody').empty();          
            var rows = [];
            var table = $('#ticketDataTable').DataTable();
            var status = "";
            var document = "";
            var formattedDate = "";
            var date = "";
            var options = "";
            var edit_link = "";
            var progress = "";
            data.forEach(function(item, index) {
                if(item.issue_date != null){
                    date = new Date(item.issue_date);
                    options = { year: 'numeric', month: 'long', day: 'numeric' };
                    formattedDate = date.toLocaleDateString('en-US', options);
                }
                

                if((item.status) == '1')
                    status = '<span class="badge badge-success">Yes</span>';
                else
                    status = '<span class="badge badge-danger">No</span>';
                
                if(item.issue_document != null){
                    document = '<a href="{{asset('')}}images/uploads/issue/file/'+ item.issue_document+'" target="_blank" class="btn btn-sm btn-primary"><i class="fa fa-eye" aria-hidden="true"></i></a>';
                }
                else{
                    document = ""; 
                }

                if(item.progress_status == 1){
                    progress = '<span class="badge badge-warning">Pending</span>';
                    edit_link = '<span class="btn btn-sm btn-success btn-md-global open-modal btnView" data-action="{{route('v1.get-ticket-by-id','')}}/'+item.issue_no_pk+'" data-modal="common-modal-md" data-title="Update Progress & Feedback" title="Update Progress & Feedback" data-id="'+item.issue_no_pk+'"><i class="fas fa-edit"></i></span>';
                 }
                 else if(item.progress_status == 2){
                    progress = '<span class="badge badge-info">Working</span>';
                    edit_link = '<span class="btn btn-sm btn-success btn-md-global open-modal btnView" data-action="{{route('v1.get-ticket-by-id','')}}/'+item.issue_no_pk+'" data-modal="common-modal-md" data-title="Update Progress & Feedback" title="Update Progress & Feedback" data-id="'+item.issue_no_pk+'"><i class="fas fa-edit"></i></span>';
                 }
                 else if(item.progress_status == 3){
                    progress = '<span class="badge badge-primary">done</span>';
                    edit_link = '';
                 }
                 else if(item.progress_status == 4){
                    progress = '<span class="badge badge-primary">Now Not Possible</span>';
                    edit_link = '<span class="btn btn-sm btn-success btn-md-global open-modal btnView" data-action="{{route('v1.get-ticket-by-id','')}}/'+item.issue_no_pk+'" data-modal="common-modal-md" data-title="Update Progress & Feedback" title="Update Progress & Feedback" data-id="'+item.issue_no_pk+'"><i class="fas fa-edit"></i></span>';
                 }
                 else if(item.progress_status == 5){
                    progress = '<span class="badge badge-primary">Not Possible</span>';
                    edit_link = '<span class="btn btn-sm btn-success btn-md-global open-modal btnView" data-action="{{route('v1.get-ticket-by-id','')}}/'+item.issue_no_pk+'" data-modal="common-modal-md" data-title="Update Progress & Feedback" title="Update Progress & Feedback" data-id="'+item.issue_no_pk+'"><i class="fas fa-edit"></i></span>';
                 }
                 else{
                    progress = "";
                    edit_link = '';
                 }
                var rowData = [
                    ++index,
                    formattedDate,
                    item.issue_code,
                    item.issue_name,
                    `<span class="primary" style="text-decoration:underline;cursor:pointer" onclick="showProfile('${item.issue_person_name}','${item.phone_mobile}','${item.su_name}','${item.designation}','${item.photo_name}')" title="click to show profile">${item.issue_person_name}</span>`,
                    item.task_full_name,
                    progress,
                    document,
                    edit_link
                ];
                rows.push(rowData);
            });
            table.clear();
            table.rows.add(rows);
            table.draw();           
        }

        function emptyTable(){
            $('.ticket_v1 tbody').empty();
            $('.ticket_v1 tbody').append(`
                <tr>
                    <td colspan="9" class="text-danger text-center">Data Not Found</td>
                </tr>
            `);

        }
</script>

