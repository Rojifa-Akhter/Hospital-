<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link href="{{ asset('css/redactor.css') }}" rel="stylesheet">
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
                            <h5 class="mt-2 mb-0"> Notice </h5>
                            <small> Notice / Notice </small>
                        </div>
                    </div>
                </div>
            </div>
            <form action="#" method="post" id="noticePOStSave" class="noticePOStSave" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-row">
                                    <div class="col-md-3 col-12">
                                       
                                            
                                            <div class="row">
                                                <div class="col-12">
                                                    <label for="title" class="col-form-label">Title<span style="color:red">*</span></label>
                                                    <input type="text" class="form-control form-control-sm" id="title" name="title" placeholder="Title" value="" />
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12">
                                                    <label for="date" class="col-form-label mt-1">Date<span style="color:red">*</span></label>
                                                    <input type="text" class="form-control form-control-sm" id="date" name="date" placeholder="Date" value="" />
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12">
                                                    <label for="category" class="col-form-label mt-1">Category<span style="color: red">*</span></label>
                                                    <select name="category" id="category" class="form-control form-control-sm" >
                                                        @foreach($category as $item)
                                                            <option value="{{$item->notice_type_no_pk}}">{{$item->notice_type_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12">
                                                    <label for="attach_file" class="col-form-label mt-1">File</label>
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
                                                    <input type="hidden" id="notice_pk" name="notice_pk">
                                                </div>
                                                <div class="col-4">
                                                    <img class="form-control img-thumbnail mt-3" src="" id="previewImage" style="width: 100px;height: 80px; background: #3f4a49;">
                                                </div>
                                            </div>
                                            
                                            
                                                                                                
                                    </div>

                                    <div class="col-md-9 col-12">
                                            <label for="notes" class="col-form-label">Notice Description</label>                                         
                                            <textarea class="form-control custom_area notice_description ckeditor" id="notice_description" rows="5" name="notice_description" placeholder="Write here ..."></textarea>                                                                
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
                                <table class="table table-striped table-bordered table-hover notice_v1" id="noticeDataTable">
                                    <thead class="global-uhl-table-bg">
                                        <tr>
                                            <th class="text-center" style="width:5%">SL No</th>
                                            <th class="text-center" style="width:10%">Date</th>
                                            <th class="text-center" style="width:50%">Title</th>
                                            <th class="text-center" style="width:20%">Category</th>
                                            <th class="text-center" style="width:5%">Published</th>
                                            <th class="text-center" style="width:5%">Document</th>
                                            <th class="text-center" style="width:5%">Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <tr>
                                            <td colspan="7" class="text-danger text-center">Data Fetching ...</td>
                                        </tr>
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

<input type="hidden" id="confirmationModal" class="btn btn-primary" data-toggle="modal" data-target="#noticeModal">

<!-- Modal -->
<div class="modal fade" id="noticeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">

        <div class="modal-body">
            <h4 class="text-center my-3">Are You Sure ?</h4>
            <div class="d-flex justify-content-around">
                <button type="button" class="btn btn-info" onclick="noticePOStSaveForm('save')">Save</button>
                <button type="button" class="btn btn-primary" onclick="noticePOStSaveForm('published')">Save & Published</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>    
        </div>

      </div>
    </div>
</div>



<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('js/redactor.js') }}"></script>

<script>
    $(document).ready(function() {
        loadEditor("notice_description");
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


    $("#noticePOStSave").validate({
        rules:{
            title:{
                required:true,
                minlength:3,
                maxlength:200,
                notOnlySpaces: true
            },
            date:{
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
            title:{
                required: "Issue Name Required",
            },
            date:{
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
            
            $('#date').datepicker({
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
        getNotice();

        function getNotice(){
                $.ajax({
                url: "{{route('v1.notice.get-notice')}}",
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
            if($('#noticePOStSave').valid()){ 
     
                $('#confirmationModal').click();           
        
            }
        }



        <!-- Submit Form Data -->
        function noticePOStSaveForm(target){
            if(target == 'published'){
                $('#status').val(1);
            }
            else{
                $('#status').val(0);  
            }

            if($('#noticePOStSave').valid()){ 
                let formElement = document.querySelector('#noticePOStSave');
                let formData = new FormData(formElement);
                
                $.ajax({
                    url:"{{route('notice.save-notice')}}",
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
                        getNotice();                
                        resetForm();
                        $("#noticeModal").modal('hide');
                        $('.common-modal-notify').modal('show');
                        $('.common-modal-notify .modal-title').html(data.title);
                        $('.common-modal-notify .modal-body').html(data.message);
                    },
                    error:function(err){
                        $.unblockUI();
                        $("#noticeModal").modal('hide');
                        var error = err.responseJSON;
                        $('.common-modal-notify-error').modal('show');
                        $('.common-modal-notify-error .modal-title').html('Failed');
                        $('.common-modal-notify-error .modal-body').html(error.message);
                    },
                    complete: function() {
                    $("#noticeModal").modal('hide');
                    $.unblockUI();
                }
                });
            }
        }
        
        <!-- Set Table Data -->
        function setTableData(data){
            $('.notice_v1 tbody').empty();     
            if($.fn.DataTable.isDataTable('#noticeDataTable')) {$('#noticeDataTable').DataTable().destroy();}       
            var rows = [];
            var table = $('#noticeDataTable').DataTable({
                searching: true,
                columnDefs: [
                        { targets: [0, 1, 4, 5, 6], className: 'text-center' },
                        { targets: [2,3], className: 'text-left' }
                    ],
                    "lengthMenu": [[10, 25, 50, 75, 100, -1], [10, 25, 50, 75, 100, "All"]], 
                    "pageLength": 10 
                });
            var status = "";
            var document = "";
            var formattedDate = "";
            var date = "";
            var options = "";
            var edit_link = "";
            data.forEach(function(item, index) {

                if(item.notice_date != null){
                    date = new Date(item.notice_date);
                    options = { year: 'numeric', month: 'long', day: 'numeric' };
                    formattedDate = date.toLocaleDateString('en-US', options);
                }
                
                if((item.status) == '1'){
                    status = '<span class="badge badge-success">Yes</span>';
                }
                else{
                    status = '<span class="badge badge-danger">No</span>';
                }
                
                if(item.attach_file != null){
                    document = '<a href="{{asset('')}}images/uploads/notice/file/'+ item.attach_file+'" target="_blank" class="btn btn-sm btn-primary"><i class="fa fa-eye" aria-hidden="true"></i></a>'
                }
                else{
                    document = ""; 
                }

                edit_link = `<button class="btn btn-sm btn-primary" type="button" onclick="editNotice(${item.notice_board_no_pk})"><i class="fa fa-edit" aria-hidden="true"></i></button>`;

                var rowData = [
                    ++index,
                    formattedDate,
                    item.title,
                    item.notice_type_name,
                    status,
                    document,
                    edit_link,
                ];
                rows.push(rowData);
            });
            table.clear();
            table.rows.add(rows);
            table.draw();
            $('[data-toggle="popover"]').popover()
        }

        function editNotice(id){
            
            
            $.ajax({
                    url: "{{route('v1.notice.get-notice-by-id','')}}/"+id,
                    method: "get",                
                    beforeSend: function() {
                        blockUI();
                    },
                    success: function(response){
                        $.unblockUI();
                        response = response.data;
                        $('#title').val(response.title);
                        $('#category').val(response.notice_type_no_fk);
                        $('#old_image').val(response.attach_file);
                        $('#notice_pk').val(response.notice_board_no_pk);
                        var date = response.notice_date;
                        $('#notice_description').redactor('set',response.notice_description);

                        if(date != ''){
                            var dateComponents = date.split(" ")[0].split("-");
                            var formattedDate = dateComponents[2] + "/" + dateComponents[1] + "/" + dateComponents[0];
                            $('#date').val(formattedDate);
                        }
                                               
                        if(image != 'null'){
                            document.getElementById("previewImage").src = '{{asset('')}}images/uploads/notice/file/'+image
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
            $('#noticePOStSave').trigger('reset');
            var currDate = new Date();
            $('#date').datepicker().datepicker('setDate', currDate);

            $('#notice_description').redactor('set','');

            document.getElementById("previewImage").src = "{{asset('images/not_found.jpg')}}";
            
        }

        function emptyTable(){
            $('.notice_v1 tbody').empty();
            $('.notice_v1 tbody').append(`
                <tr>
                    <td colspan="7" class="text-danger text-center">Data Not Found</td>
                </tr>
            `);

        }
</script>
