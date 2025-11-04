<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
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
</style>
<main id="page-content">
    <section class="fixed_asset">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="row justify-content-between align-items-center bg-white border-bottom sticky-top shadow-sm">
                        <div class="col-md-11">
                            <h5 class="mt-2 mb-0"> Ticket Issue</h5>
                            <small>Support Ticket / Ticket Issue</small>
                        </div>
                    </div>
                </div>
            </div>
            <form action="#" method="post" id="userTicketSave" class="userTicketSave" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-row">
                                    <div class="col-md-3 col-12">
                                       
                                            
                                            <div class="row">
                                                <div class="col-12">
                                                    <label for="issue_name" class="col-form-label">Issue Name<span style="color:red">*</span></label>
                                                    <input type="text" class="form-control form-control-sm" id="issue_name" name="issue_name" placeholder="Issue Name" value="" />
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12">
                                                    <label for="issue_date" class="col-form-label mt-1">Issue Date<span style="color:red">*</span></label>
                                                    <input type="text" class="form-control form-control-sm" id="issue_date" name="issue_date" placeholder="Issue Date" value="" />
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12">
                                                    <label for="attach_file" class="col-form-label mt-1">Screenshot</label>
                                                    <input type="file" class="form-control form-control-sm file" id="attach_file" name="attach_file" onchange="readURL(this);"/>
                                                    <div>
                                                        <small><b>N.B:</b> Only .jpg, .jpeg, .png, .pdf acceptable</small>
                                                    </div>
                                                </div>
                                            </div>                                                                                                                       
                                            <div class="row">
                                                <div class="col-8">
                                                    <input type="hidden" value="0" id="status" name="status" class="">
                                                    <input type="hidden" value="" id="old_image" name="old_image" class="">
                                                    <input type="hidden" id="issu_pk" name="issu_pk">
                                                </div>
                                                <div class="col-4">
                                                    <img class="form-control img-thumbnail mt-3" src="" id="previewImage" style="width: 100px;height: 80px; background: #3f4a49;">
                                                </div>
                                            </div>
                                            
                                            
                                                                                                
                                    </div>

                                    <div class="col-md-9 col-12">
                                            <label for="notes" class="col-form-label">Issue Description</label>                                         
                                            <textarea class="form-control custom_area issue_description ckeditor" id="issue_description" rows="5" name="issue_description" placeholder="Write here ..."></textarea>                                                                
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card mb-2">
                            <div class="card-body">
                                <div class="form-group">
                                    <ul class="list-inline btn__box">
                                        <li class="list-inline-item">
                                            <button type="button" class="btn btn-secondary uhl_save_btn" type="button" onclick="openModal()">Submit</button>
                                        </li>
                                    </ul>
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
                                            <th class="text-center" style="width:10%">Issue Date</th>
                                            <th class="text-center" style="width:5%">Issue Code</th>
                                            <th class="text-center" style="width:35%">Issue Name</th>
                                            <th class="text-center" style="width:10%">Issued By</th>
                                            <th class="text-center" style="width:5%">Published</th>
                                            <th class="text-center" style="width:10%">Progress</th>
                                            <th class="text-center" style="width:5%">Document</th>
                                            <th class="text-center" style="width:5%">Feedback</th>
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

<input type="hidden" id="confirmationModal" class="btn btn-primary" data-toggle="modal" data-target="#ticketModal">

<!-- Modal -->
<div class="modal fade" id="ticketModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">

        <div class="modal-body">
            <h4 class="text-center my-3">Are You Sure ?</h4>
            <div class="d-flex justify-content-around">
                <button type="button" class="btn btn-info" onclick="userTicketSaveForm('save')">Save</button>
                <button type="button" class="btn btn-primary" onclick="userTicketSaveForm('published')">Save & Published</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>    
        </div>

      </div>
    </div>
</div>



<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>


<script>
    $(document).ready(function() {
        var editor = CKEDITOR.replace('issue_description', {
            tabSpaces: 4,
        });

        editor.on('change', function(evt) {
            $('#issue_description').val(evt.editor.getData())
        });
    });
</script>

<script>
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload=function(e) {
                $('#previewImage')
                    .attr('src', e.target.result)
                    .width(100)
                    .height(80);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
    document.getElementById("previewImage").src = "{{asset('images/not_found.jpg')}}";
</script>

<script>
    //initialize extention to jquery validate
    $.validator.addMethod( "extension", function( value, element, param ) {
            param = typeof param === "string" ? param.replace( /,/g, "|" ) : "png|jpe?g|gif";
            return this.optional( element ) || value.match( new RegExp( "\\.(" + param + ")$", "i" ) );
    }, $.validator.format( "Please enter a value with a valid extension." ) );


    $("#userTicketSave").validate({
        rules:{
            issue_name:{
                required:true,
                minlength:3,
                maxlength:200,
                notOnlySpaces: true
            },
            issue_date:{
                // dateFormat:true, 
                required:true,
            },
            attach_file:{
                extension: "jpg|jpeg|png|pdf",
            },
            notes:{
                maxlength:1000
            }
        },
        messages:{
            issue_name:{
                required: "Issue Name Required",
            },
            issue_date:{
                required: "Issue Date Required",
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

        $(function(){

            var currentDate = new Date();
            
            $('#issue_date').datepicker({
                todayHighlight: true,
                clearBtn: true,
                autoclose: true,
                format: 'dd/mm/yyyy',
                maxDate: currentDate,
                changeMonth: true,
                changeYear: true,
            }).datepicker('setDate', currentDate);

        })

        <!-- Fetch Table Data -->
        getUserTicket();

        function getUserTicket(){
                $.ajax({
                url: "{{route('v1.ticket.get-user-ticket')}}",
                method: "get",
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

        function openModal(){
            if($('#userTicketSave').valid()){ 
     
                $('#confirmationModal').click();           
        
            }
        }

        $(document).ready(function(){
            $('#ticketDataTable').DataTable({
                searching: true,
                columnDefs: [
                        { targets: [0, 1, 2, 4, 5, 6, 7], className: 'text-center' },
                        { targets: [3], className: 'text-left' }
                    ],
                    "lengthMenu": [[10, 25, 50, 75, 100, -1], [10, 25, 50, 75, 100, "All"]], 
                    "pageLength": 10 
                });
            $('th').addClass('text-center');
        })

        <!-- Submit Form Data -->
        function userTicketSaveForm(target){
            if(target == 'published'){
                $('#status').val(1);
            }
            else{
                $('#status').val(0);  
            }

            if($('#userTicketSave').valid()){ 
                let formElement = document.querySelector('#userTicketSave');
                let formData = new FormData(formElement);
                
                $.ajax({
                    url:"{{route('v1.ticket.save-user-ticket')}}",
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
                            
                        resetForm();
                        $("#ticketModal").modal('hide');
                        $('.common-modal-notify').modal('show');
                        $('.common-modal-notify .modal-title').html(data.title);
                        $('.common-modal-notify .modal-body').html(data.message);
                    },
                    error:function(err){
                        $.unblockUI();
                        $("#ticketModal").modal('hide');
                        var error = err.responseJSON;
                        $('.common-modal-notify-error').modal('show');
                        $('.common-modal-notify-error .modal-title').html('Failed');
                        $('.common-modal-notify-error .modal-body').html(error.message);
                    },
                    complete: function() {
                    $("#ticketModal").modal('hide');
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
            var feedback = "";
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
                    document = '<a href="{{asset('')}}images/uploads/issue/file/'+ item.issue_document+'" target="_blank" class="btn btn-sm btn-primary"><i class="fa fa-eye" aria-hidden="true"></i></a>'
                }
                else{
                    document = ""; 
                }

                 if(item.progress_status == 1){
                    progress = '<span class="badge badge-warning">Pending</span>';
                    edit_link = `<span class="btn btn-sm btn-success btn-md-global" onclick="editIssue('${item.issue_no_pk}')"><i class="fas fa-edit"></i></span>`;
                 }
                 else if(item.progress_status == 2){
                    progress = '<span class="badge badge-info">Working</span>';
                    edit_link = '';
                 }
                 else if(item.progress_status == 3){
                    progress = '<span class="badge badge-primary">done</span>';
                    edit_link = '';
                 }
                 else if(item.progress_status == 4){
                    progress = '<span class="badge badge-primary">Now Not Possible</span>';
                    edit_link = `<span class="btn btn-sm btn-success btn-md-global" onclick="editIssue('${item.issue_no_pk}')"><i class="fas fa-edit"></i></span>`;
                 }
                 else if(item.progress_status == 5){
                    progress = '<span class="badge badge-primary">Not Possible</span>';
                    edit_link = `<span class="btn btn-sm btn-success btn-md-global" onclick="editIssue('${item.issue_no_pk}')"><i class="fas fa-edit"></i></span>`;
                 }
                 else{
                    progress = "";
                    edit_link = '';
                 }

                 if(item.feedback != null){
                    feedback = '<button type="button" class="btn btn-sm btn-info btn-md-global" data-toggle="popover" title="Feedback" data-content="'+item.feedback+'"><i class="fa fa-eye" aria-hidden="true"></i></button>';
                 }
                 else{
                    feedback = "";
                 }

                var rowData = [
                    ++index,
                    formattedDate,
                    item.issue_code,
                    item.issue_name,
                    item.issue_person_name,
                    status,
                    progress,
                    document,
                    feedback,
                    edit_link,
                ];
                rows.push(rowData);
            });
            table.clear();
            table.rows.add(rows);
            table.draw();
            $('[data-toggle="popover"]').popover()
        }

        function editIssue(id){
            
            
            $.ajax({
                    url: "{{route('v1.ticket.get-support-ticket-by-id','')}}/"+id,
                    method: "get",                
                    beforeSend: function() {
                        blockUI();
                    },
                    success: function(response){
                        $.unblockUI();
                        response = response.data;
                        $('#issue_name').val(response.issue_name);
                        $('#old_image').val(response.issue_document);
                        $('#issu_pk').val(response.issue_no_pk);
                        var date = response.issue_date;
                        var editor = CKEDITOR.instances['issue_description'];
                        editor.setData(response.issue_descriptions);

                        if(date != ''){
                            var dateComponents = date.split(" ")[0].split("-");
                            var formattedDate = dateComponents[1] + "/" + dateComponents[2] + "/" + dateComponents[0];
                            $('#issue_date').val(formattedDate);
                        }
                                               
                        if(image != 'null'){
                            document.getElementById("previewImage").src = '{{asset('')}}images/uploads/issue/file/'+image
                        }
                        else{
                            document.getElementById("previewImage").src = "{{asset('images/not_found.jpg')}}";
                        }
                          
                    },
                    error:function(err){
                        $.unblockUI();
                        var error = err.responseJSON;
                        $('.common-modal-notify-error').modal('show');
                        $('.common-modal-notify-error .modal-title').html('Failed');
                        $('.common-modal-notify-error .modal-body').html(error.message); 
                    }
                })    
        }

        function resetForm(){
            $('#userTicketSave').trigger('reset');
            var currDate = new Date();
            $('#issue_date').datepicker().datepicker('setDate', currDate);
            var editor = CKEDITOR.instances['issue_description'];
            editor.setData('');
            document.getElementById("previewImage").src = "{{asset('images/not_found.jpg')}}";
            
        }

        function emptyTable(){
            $('.ticket_v1 tbody').empty();
            $('.ticket_v1 tbody').append(`
                <tr>
                    <td colspan="7" class="text-danger text-center">Data Not Found</td>
                </tr>
            `);

        }
</script>
