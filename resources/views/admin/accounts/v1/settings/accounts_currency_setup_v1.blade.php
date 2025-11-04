
<style>
    .error{
        color:red !important;
        font-size: 12px;
    }
</style>
<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top shadow-sm">
        <div class="col-md-12 mb-1">
            <h5 class="mt-2 mb-0">Currency Setup</h5>
            <small>Accounts / Setup / Currency Setup</small>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center bg-primary text-white"><h5>Currency List</h5></div>
                <div class="card-body p-2">
                  <form action="#" class="saveCurrencyV1" id="saveCurrencyV1" method="post">
                    @csrf()
                    <table class="table mb-0">
                        <tbody>
                            <tr>
                                <td style="min-width: 120px;">
                                    <input id="currency_name" name="currency_name" type="text" class="form-control datepicker" placeholder="Name" style="margin-bottom:0px!important;" autocomplete="off">
                                </td>
                                <td style="min-width: 120px;">
                                    <input id="currency_rate" name="currency_rate" type="number" step="0.01" class="form-control datepicker" placeholder="Rate" style="margin-bottom:0px!important;" autocomplete="off">
                                </td>             
                                <td style="min-width: 120px;">
                                    <label class="checkbox inline" style="font-size: 16px; margin: 0px;" for="status">
                                        <input id="status" type="checkbox" name="status" value="1">&nbsp;Status
                                    </label>
                                </td>
                                <td style="width: 90px;padding: 2px;vertical-align: middle;">
                                    <button id="" type="button" class="btn btn-block btn-md btn-success" onclick="saveCurrencyV1Data()">
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
                                <th style="min-width: 15%;">Currency Name</th>
                                <th style="min-width: 45%;">Currency Rate</th>
                                <th style="width: 15%;">Status</th>
                                <th style="width: 15%;text-align:center">Action</th>
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
    $("#saveCurrencyV1").validate({
    rules:{
        currency_name:{
            required:true,
            minlength:2,
            maxlength:50,
        },
        currency_rate:{
            required:true,
            maxlength:5,
        }
    },
    messages:{
        currency_name:{
            required: "Name Required",
        },
        currency_rate:{
            required: "Rate Required",
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

        getAccountsCurrency();
        function getAccountsCurrency(){
                $.ajax({
                url: "{{route('v1.accounts.get-accounts-currency-setup')}}",
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
        function saveCurrencyV1Data(){
            if($('#saveCurrencyV1').valid()){ 
                let formElement = document.querySelector('#saveCurrencyV1');
                let formData = new FormData(formElement);
                $.ajax({
                    url:"{{route('v1.accounts.save-accounts-currency-setup')}}",
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
                        $('#saveCurrencyV1').trigger('reset');
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
            var status = "";
            $('.journalTypeV1Table tbody').empty();
            data.forEach(function(item,index){

                if((item.status) == '1')
                    status = '<span class="badge badge-success">Active</span>';
                else
                    status = '<span class="badge badge-danger">Inactive</span>';

                tbl+='<tr>';
                    tbl+='<td style="font-weight: bold;">'+ ++index+'</td>';
                    tbl+='<td>'+item.curr_name+'</td>';
                    tbl+='<td>'+item.curr_rate+'</td>';
                    tbl+='<td>'+status+'</td>';
                    tbl+='<td style="text-align:center">';
                    tbl+='<span class="btn btn-sm btn-success btn-md-global open-modal btnView" data-action="{{route('v1.accounts.edit-accounts-currency-setup','')}}/'+item.curr_pk+'" data-modal="common-modal-sm" data-title="Edit Currency" title="Edit Currency" data-id="'+item.curr_pk+'"><i class="fas fa-edit"></i></span>';
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