<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<style>
    .text-left{
        text-align:left;
    }
</style>

<main id="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="row justify-content-between align-items-center bg-white border-bottom sticky-top shadow-sm">
                    <div class="col-md-11">
                        <h5 class="mt-2 mb-0"> Notice Type</h5>
                        <small> Notice / Notice Type</small>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="form-row">
                            <div class="col-md-4 col-12">
                                <form action="#" method="post" id="typePOStSave" class="typePOStSave" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-12">
                                            <label for="title" class="col-form-label">Title<span style="color:red">*</span></label>
                                            <input type="text" class="form-control form-control-sm" id="title" name="title" placeholder="Title" value=""/>
                                            <input type="hidden" id="type_pk" name="type_pk">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12">
                                            <label for="notes" class="col-form-label">Description</label>                                         
                                            <textarea class="form-control custom_area" id="description" rows="3" name="description" placeholder="Write here ..."></textarea>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <div class="form-check">
                                                  <input class="form-check-input pt-1" type="checkbox" id="status" name="status" value="1" checked>
                                                  <label class="form-check-label" for="status">
                                                    Is Active
                                                  </label>
                                                </div>
                                              </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <ul class="list-inline btn__box">
                                                    <li class="list-inline-item">
                                                        <button type="button" class="btn btn-secondary uhl_save_btn" type="button" onclick="typePOStSaveForm()">Submit</button>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                <form>                                      
                            </div>

                            <div class="col-8">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover notice_type_v1" id="noticeTypeDataTable">
                                        <thead class="global-uhl-table-bg">
                                            <tr>
                                                <th class="text-center" style="width:5%">SL No</th>
                                                <th class="text-left" style="width:50%">Title</th>
                                                <th class="text-center" style="width:20%">Description</th>
                                                <th class="text-center" style="width:5%">Status</th>
                                                <th class="text-center" style="width:5%">Action</th>
                                            </tr>
                                        </thead>
    
                                        <tbody>
                                            <tr>
                                                <td colspan="5" class="text-danger text-center">Data Fetching ...</td>
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
</main>




<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>

<script>
    $("#typePOStSave").validate({
        rules:{
            title:{
                required:true,
                minlength:3,
                maxlength:200,
                notOnlySpaces: true
            },
            notes:{
                maxlength:1000
            }
        },
        messages:{
            title:{
                required: "Title Required",
            },
        }
    });
</script>

<script>

        $.ajaxSetup({ headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
       
        getNotice();

        function getNotice(){
                $.ajax({
                    url: "{{route('v1.notice.get-notice-type')}}",
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

        <!-- Submit Form Data -->
        function typePOStSaveForm(){
            if($('#typePOStSave').valid()){ 
                let formElement = document.querySelector('#typePOStSave');
                let formData = new FormData(formElement);

                $.ajax({
                    url:"{{route('notice.save-type')}}",
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
                        $('.common-modal-notify').modal('show');
                        $('.common-modal-notify .modal-title').html(data.title);
                        $('.common-modal-notify .modal-body').html(data.message);
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
            $('.notice_type_v1 tbody').empty();     
            if($.fn.DataTable.isDataTable('#noticeTypeDataTable')) {$('#noticeTypeDataTable').DataTable().destroy();}       
            var rows = [];
            var table = $('#noticeTypeDataTable').DataTable({
                searching: true,
                columnDefs: [
                        { targets: [0,2,3], className: 'text-center' },
                        { targets: [1], className: 'text-left' }
                    ],
                    "lengthMenu": [[10, 25, 50, 75, 100, -1], [10, 25, 50, 75, 100, "All"]], 
                    "pageLength": 10 
                });
            var status = "";
            var edit_link = "";
            data.forEach(function(item, index) {

                if((item.status) == '1'){
                    status = '<span class="badge badge-success">Yes</span>';
                }
                else{
                    status = '<span class="badge badge-danger">No</span>';
                }
                
                edit_link = `<button class="btn btn-sm btn-primary" type="button" onclick="editNotice(${item.notice_type_no_pk})"><i class="fa fa-edit" aria-hidden="true"></i></button>`;

                var rowData = [
                    ++index,
                    item.notice_type_name,
                    item.notice_type_description,
                    status,
                    edit_link,
                ];
                rows.push(rowData);
            });
            table.clear();
            table.rows.add(rows);
            table.draw();
        }

        function editNotice(id){
            $.ajax({
                    url: "{{route('v1.notice.get-notice-type-by-id','')}}/"+id,
                    method: "get",                
                    beforeSend: function() {
                        blockUI();
                    },
                    success: function(response){
                        $.unblockUI();
                        response = response.data;

                        if((response.status) == '1'){
                            $('#status').prop('checked',true);
                        }else{
                            $('#status').prop('checked',false);
                        }
                        
                        $('#title').val(response.notice_type_name);
                        $('#type_pk').val(response.notice_type_no_pk);
                        $('#description').val(response.notice_type_description);    
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
            $('#typePOStSave').trigger('reset'); 
        }

        function emptyTable(){
            $('.notice_type_v1 tbody').empty();
            $('.notice_type_v1 tbody').append(`
                <tr>
                    <td colspan="5" class="text-danger text-center">Data Not Found</td>
                </tr>
            `);
        }
</script>
