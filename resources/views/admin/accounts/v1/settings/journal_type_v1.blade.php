
<style>
    .error{
        color:red !important;
        font-size: 12px;
    }
</style>
<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top shadow-sm">
        <div class="col-md-12 mb-1">
            <h5 class="mt-2 mb-0">Voucher Type</h5>
            <small>Accounts / Setup / Voucher Type</small>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center bg-primary text-white"><h5>Voucher Type</h5></div>
                <div class="card-body p-2">
                  <form action="#" class="saveJournalTypeV1" id="saveJournalTypeV1" method="post">
                    @csrf()
                    <table class="table mb-0">
                        <tbody>
                            <tr>
                                <td style="min-width: 120px;">
                                    <input id="voucher_type_code" name="voucher_type_code" type="text" class="form-control datepicker" placeholder="Code" style="margin-bottom:0px!important;" autocomplete="off">
                                </td>
                                <td style="min-width: 120px;">
                                    <input id="voucher_type_name" name="voucher_type_name" type="text" class="form-control datepicker" placeholder="Voucher Name" style="margin-bottom:0px!important;" autocomplete="off">
                                </td>             

                                <td style="width: 90px;padding: 2px;vertical-align: middle;">
                                    <button id="" type="button" class="btn btn-block btn-md btn-success" onclick="saveJournalTypeV1Data()">
                                        <span class="fa fa-save"></span> Save
                                    </button>
                                </td>
                                <td style="width: 90px;padding: 2px;vertical-align: middle;">
                                    <button type="reset" class="btn btn-block btn-md btn-danger cancel-fy">
                                        <span class="fa fa-ban"></span> Reset
                                    </button>
                                </td>
                            </tr>
                        </tbody>                        
                    </table>
                </form>
                    <table id="" class="table table-hover table-condensed mb-0 journalTypeV1Table">
                        <thead>
                            <tr>
                                <th style="width:10%;">SL#</th>
                                <th style="min-width: 15%;">Code</th>
                                <th style="min-width: 60%;">Voucher Name</th>
                                <th style="width: 15%;">Status</th>
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

<script>
    $("#saveJournalTypeV1").validate({
    rules:{
        voucher_type_code:{
            required:true,
            minlength:2,
            maxlength:50,
        },
        voucher_type_name:{
            required:true,
            maxlength:50,
        }
    },
    messages:{
        voucher_type_code:{
            required: "Code Required",
        },
        voucher_type_name:{
            required: "Journal Name Required",
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

        getJournalTypeList();
        function getJournalTypeList(){
                $.ajax({
                url: "{{route('get-vouchertype-v1')}}",
                method: "get",
                success: function(response){
                    if(response.data.length != 0)
                    setTableData(response.data);
                    else
                    emptyTable();
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
        function saveJournalTypeV1Data(){
            if($('#saveJournalTypeV1').valid()){ 
                let formElement = document.querySelector('#saveJournalTypeV1');
                let formData = new FormData(formElement);
                $.ajax({
                    url:"{{route('add-vouchertype-v1')}}",
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
                        $('#saveJournalTypeV1').trigger('reset');
                        $('.common-modal-notify').modal('show');
                        $('.common-modal-notify .modal-title').html(data.title);
                        $('.common-modal-notify .modal-body').html(data.message);
                    },
                    error:function(err){
                        var error = err.responseJSON;
                        $.unblockUI();
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

            var tbl = "";
            $('.journalTypeV1Table tbody').empty();
            data.forEach(function(item,index){
                tbl+='<tr>';
                    tbl+='<td style="font-weight: bold;">'+ ++index+'</td>';
                    tbl+='<td>'+item.voucher_type_code+'</td>';
                    tbl+='<td>'+item.voucher_type_name+'</td>';
                    tbl+='<td style="padding: 1px 0px;">';
                    tbl+=`<button  onclick="updateStatus(${item.voucher_type_no_pk},${item.status})" class="btn btn-block ${item.status == 1 ? 'btn-outline-success bg-transperant' : 'btn-danger'}" type="button"> ${item.status == 1 ? 'Active' : 'Inactive'} </button>`;
                    tbl+='</td>';
                tbl+='</tr>';

            })

            $('.journalTypeV1Table tbody').append(tbl);
        }
        
        function updateStatus(id,status){

            console.log('data',id,status)
            $.ajax({
                url:"{{route('set-vouchertype-status-v1')}}",
                type:"post",
                data:{id: id,status: status},
                beforeSend: function() {
                    blockUI();
                },
                success:function(data){
                    if(data.data.length != 0)
                    setTableData(data.data);   
                    $('.common-modal-notify').modal('show');
                    $('.common-modal-notify .modal-title').html(data.title);
                    $('.common-modal-notify .modal-body').html(data.message);
                },
                error:function(err){
                    var error = err.responseJSON;
                    $.unblockUI();
                    $('.common-modal-notify-error').modal('show');
                    $('.common-modal-notify-error .modal-title').html('Failed');
                    $('.common-modal-notify-error .modal-body').html(error.message);
                },
                complete: function() {
                $.unblockUI();
            }
            });
        }
        function emptyTable(){
            $('.journalTypeV1Table tbody').empty();
            $('.journalTypeV1Table tbody').append(`
                <tr>
                    <td colspan="4" class="text-danger text-center">Data Not Found</td>
                </tr>
            `);

        }
</script>