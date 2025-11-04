<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<style>
    .select2-selection__rendered{
        text-align: left !important;     
    }
    .select2-results__option{
        font-size: 12px !important;
    }
    .select2-container .select2-selection--single .select2-selection__rendered {
        overflow-x: hidden !important;
        /* width: 300px; */
    }
    .accounts_integration_table>thead>tr>th{
        font-size: 12px !important;
        white-space: nowrap;
    }   
    /* .disabled{
        border:1px dotted black !important;
    } */
</style>

<section>
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm">
            <div class="col-md-12">
                <div class="float-left">
                    <h5 class="mt-2 mb-0">Account Integration - Billing</h5>
                    <small>Account / Account Integration - Billing</small>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <form id="item_type_wise_billing" method="POST" class="item_type_wise_billing">
                    @csrf
                    <div class="card">
                        <div class="card-body p-2">
                                           
                            <div class="row my-3">

                                <div class="col-3">
                                    <div class="row">
                                        <div class="col-12">
                                            <label for="">Voucher <span style="color:red">*</span></label>
                                        </div>
                                        <div class="col-12">
                                            <select class="form-control form-control-sm" id="journal_type" name="journal_type">
                                                <option value="" selected>Select One</option>
                                                @foreach ($voucher_type->getData()->data as $item)
                                                    @if($item->status == 1)
                                                        <option value="{{$item->voucher_type_no_pk}}" data-type="{{$item->voucher_type_name}}">{{$item->voucher_type_code}} - {{$item->voucher_type_name}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-3">
                                    <div class="row">
                                        <div class="col-12">
                                            <label for="">Module <span style="color:red">*</span></label>
                                        </div>
                                        <div class="col-12">
                                            <select name="module" id="module" class="form-control form-control-sm">
                                                <option value="" selected>Select One</option>
                                                @foreach($module as $data)
                                                    @if($data->status == 1)
                                                        <option value="{{ $data->module_no_pk }}">{{ $data->module_code }} - {{ $data->module_name }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-2">
                                    <div class="row">
                                        <div class="col-12">
                                            <label for="">Trn Type <span style="color:red">*</span></label>
                                        </div>
                                        <div class="col-12">
                                            <select name="trn_type" id="trn_type" class="form-control form-control-sm">
                                                <option value="" selected>Select One</option>
                                                @foreach($finc_trntype as $data)
                                                    @if($data->status == 1)
                                                        <option value="{{ $data->trn_type_no_pk }}">{{ $data->trn_type_code }} - {{ $data->trn_type_name }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-2">
                                    <div class="row">
                                        <div class="col-12">
                                            <label for="">Store <span style="color:red">*</span></label>
                                        </div>
                                        <div class="col-12">
                                            <select name="store" id="store" class="form-control form-control-sm">
                                                <option value="" selected>Select One</option>
                                                @foreach ($system_service_unit->getData()->data as $item)
                                                    @if($item->status == 1)
                                                    <option value="{{$item->serviceunit_no_pk}}">{{$item->serviceunit_name}} - {{$item->serviceunit_code}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-2">
                                    <div class="row">
                                        <div class="col-12">
                                            <label for="">Accounts Mapping SU</label>
                                        </div>
                                        <div class="col-12">
                                            <select name="service_unit" id="service_unit" class="form-control form-control-sm font_size_12 m-auto select2">
                                                <option value="" selected>-Select service unit-</option>
                                                @foreach ($all_service_unit->getData()->data as $item)
                                                    @if($item->status == 1)
                                                        <option value="{{$item->serviceunit_no_pk}}">{{$item->serviceunit_name}} - {{$item->serviceunit_code}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6 pr-0">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover accounts_integration_table_debit table_identity">
                                            <thead class="global-uhl-table-bg">                                     
                                                <tr id="tblhead0">
                                                    <th  colspan="7" class="bg-primary text-center ">Debit Part</th>
                                                </tr>
                                                <tr id="tblhead1">
                                                    <th class="text-left" style="width: 45%">General Ledger (GL)<span class="text-danger">*</span></th>
                                                    <th class="text-center" style="width: 35%">Item Group <span class="text-danger">*</span></th>
                                                    <th class="text-center" style="width: 10%">Percentage<span class="text-danger">*</span></th>
                                                    <th class="text-center" style="width: 10%">Action</th>                                
                                                </tr>
        
                                            </thead>
        
                                            <tbody>
                                            <tr id="tbl0">
                                                <td>
                                                
                                                        <select class="form-control form-control-sm font_size_12 m-auto select2" id="general_ledger0" name="general_ledger[]">
                                                            <option value=""  selected>Select One</option>
                                                            @foreach ($general_ledger->getData()->data as $item)
                                                                @if($item->status == 1)
                                                                    <option value="{{$item->account_no_pk}}" data-cost="{{$item->cost_center_ind}}" class="{{$item->cost_center_ind}}">{{$item->account_code}} - {{$item->account_name}}</option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                        <input type="hidden" class="form-control form-control-sm" id="dr_cr_type0" name="dr_cr_type[]" value="DR">
        
                                                </td>
        
                                                   
                                     
                                                <td>
                                                    <select name="item_type[]" id="item_type0" class="form-control form-control-sm select2">
                                                        <option value="0" selected>Select One</option>
                                                        @foreach($major_group_item_type as $data)
                                                                <option value="{{ $data->itemtype_no_pk }}">{{ $data->itemtype_code }} - {{ $data->item_type_name }}</option>                      
                                                        @endforeach
                                                    </select>
                                                </td>

                                                <td>
                                                    <input type="number" step="0.01" class="form-control form-control-sm" id="percentage0" name="percentage[]" placeholder="Percent %" value="0" oninput="PercentageUpdate()"  max="100"/>
                                                </td>
        
                                                <td>
                                                    <span class="btn btn-primary" onclick="addRow('debit')"><i class="fas fa-plus-circle"></i></span>
                                                </td>
                                            </tr>
        
                                            </tbody>
                                        </table>                                        
                                    </div>

                                    <div>
                                        <h6 class="text-center">Total Dr. :&nbsp;<span id="total_dr">0</span> %</h6>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover accounts_integration_table_credit table_identity">
                                            <thead class="global-uhl-table-bg">                                               
                                                <tr id="tblhead2">
                                                    <th  colspan="7" class="bg-primary text-center ">Credit Part</th>
                                                </tr>
                                                <tr id="tblhead3">
                                                    <th class="text-left" style="width: 45%">General Ledger (GL)<span class="text-danger">*</span></th>
                                                    <th class="text-center" style="width: 35%">Item Group <span class="text-danger">*</span></th>
                                                    <th class="text-center" style="width: 10%">Percentage<span class="text-danger">*</span></th>
                                                    <th class="text-center" style="width: 10%">Action</th>                                                                 
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr id="tbl1">
                                                    <td>
                                                        <select class="form-control font_size_12 m-auto select2 select2" id="general_ledger1" name="general_ledger[]">
                                                            <option value="" disabled selected>Select One</option>
                                                            @foreach ($general_ledger->getData()->data as $item)
                                                                @if($item->status == 1)
                                                                    <option value="{{$item->account_no_pk}}" data-cost="{{$item->cost_center_ind}}" class="{{$item->cost_center_ind}}">{{$item->account_code}} - {{$item->account_name}}</option>
                                                                @endif
                                                            @endforeach
                                                        </select>
            
                                                    </td>                           
                               
            
                                                    <td>
                                                        <select name="item_type[]" id="item_type1" class="form-control form-control-sm select2">
                                                            <option value="0" selected>Select One</option>
                                                            @foreach($major_group_item_type as $data)
                                                                    <option value="{{ $data->itemtype_no_pk }}">{{ $data->itemtype_code }} - {{ $data->item_type_name }}</option>                      
                                                            @endforeach
                                                        </select>
                                                        <input type="hidden" class="form-control form-control-sm" id="dr_cr_type1" name="dr_cr_type[]" value="CR">
                                                    </td>

                                                    <td>
                                                        <input type="number" step="0.01" class="form-control form-control-sm" id="percentage1" name="percentage[]" placeholder="Percent %" value="0" oninput="PercentageUpdate()"  max="100"/>
                                                    </td>
            
                                                    <td>
                                                        <span class="btn btn-primary" onclick="addRow('credit')"><i class="fas fa-plus-circle"></i></span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div>
                                        <h6 class="text-center">Total Cr. :&nbsp;<span id="total_cr">0</span> %</h6>
                                    </div>
                                </div>

                            </div>
                                                                                  
                        </div>
                    </div>
                                      
              
                        <div class="card mb-2">
                            <div class="card-body p-2">
                                <div class="form-group">
                                    <ul class="list-inline btn__box">
                                        <li class="list-inline-item">
                                            <button type="button"  class="btn btn-secondary uhl_save_btn" id="item_type_wise_form" onclick="saveItemwiseIntegration()">Save</button>
                                        </li>
                                        <li class="list-inline-item"><button type="reset" class="btn btn-secondary">Reset</button></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                   
                    
                </form>  
            </div>
        </div>
           

        <div class="card">
            <div class="card-body p-2">                 
                    <table class="table table-striped table-bordered table-hover" id="itemwiseDataTable">
                            <thead class="global-uhl-table-bg">
                                <tr class="table-primary">
                                    <th class="text-left" style="width: 5%">#SL</th>
                                    <th class="text-left" style="width: 15%">Voucher Type</th>
                                    <th class="text-left"style="width: 20%">Trn Type</th>
                                    <th class="text-left" style="width: 23%">Store</th>
                                    <th class="text-left" style="width: 23%">Service Name</th>
                                    <th class="text-left" style="width: 7%">Status</th>
                                    <th class="text-left" style="width: 7%">Action</th>
                                </tr>
                            </thead>
                            <tbody class="item_type_wise_table_body">

                            </tbody>
                    </table>
            </div>
        </div>

    </div>

</section>

<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2();

        //validate form
        $("#item_type_wise_billing").validate({
            rules:{
                    trn_type:{
                        required:true
                    },
                    store:{
                        required:true
                    },
                    journal_type:{
                        required:true
                    },
                    module:{
                        required:true
                    },
                },
                messages:{
                    trn_type:{
                        required:'Trn Type Required'
                    },
                    store:{
                        required: 'Store is Required'
                    },
                    journal_type:{
                        required:'Voucher Type Required'
                    },
                    module:{
                        required:'Module Required'
                    },
                }
            })
    });
</script>

<script>
 
    var count=1;      
    function addRow(type){
        count+=1;
        var tbl = `<tr class="accounts-integration-row" id="tbl${count}">
    
                    <td>
                        <select class="form-control font_size_12 m-auto select2 select2" id="general_ledger${count}" name="general_ledger[]">
                            <option value="" disabled selected>Select One</option>
                            @foreach ($general_ledger->getData()->data as $item)
                                @if($item->status == 1)
                                    <option value="{{$item->account_no_pk}}" data-cost="{{$item->cost_center_ind}}" class="{{$item->cost_center_ind}}">{{$item->account_code}} - {{$item->account_name}}</option>
                                @endif
                            @endforeach
                        </select>

                    </td>
                   
                    <td>
                        <select name="item_type[]" id="item_type${count}" class="form-control form-control-sm select2">
                            <option value="0" selected>Select One</option>
                            @foreach($major_group_item_type as $data)
                                <option value="{{ $data->itemtype_no_pk }}">{{ $data->itemtype_code }} - {{ $data->item_type_name }}</option>                      
                            @endforeach
                        </select>
                        <input type="hidden" class="form-control form-control-sm" id="dr_cr_type${count}" name="dr_cr_type[]" value="${type == 'debit' ? 'DR' : 'CR'}">
                    </td>

                    <td>
                        <input type="number" step="0.01" class="form-control form-control-sm" id="percentage${count}" name="percentage[]" placeholder="Percent %" value="0" oninput="PercentageUpdate()"  max="100"/>
                    </td>
               
                    <td>
                        <span class="btn btn-warning remove_row_accounts_integration"><i class="fas fa-trash" style="color:red"></i></span>
                    </td>

                </tr>`;
               
        if(type == 'debit'){           
            $('.accounts_integration_table_debit tbody').append(tbl);
        }
        else{         
            $('.accounts_integration_table_credit tbody').append(tbl);
        }

        //initialize select2       
        $('#general_ledger'+count).select2({});
        $('#item_type'+count).select2({});

    }

    $(document).ready(function(){
        /*remove row*/
        $(document).on("click", ".remove_row_accounts_integration", function(){
                var id = $(this).closest('.accounts-integration-row').attr('id');
                $("#"+id).remove();
                PercentageUpdate()
            })
    })

</script>

<script>
    getItemwiseAccountIntegration();
    
    function getItemwiseAccountIntegration(){
        $.ajax({
                    url: "{{route('v1.accounts.get-itemwise-account-integration-billing')}}",
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

    function PercentageUpdate(){
        var dr_values = 0; // Array to store the input values
        var cr_values = 0; // Array to store the input values
        var prev_dr = 0;
        var prev_cr = 0;
        $('input[name="percentage[]"]').each(function(index) {
            var value = $(this).val();
            var drCrValue = $('input[name="dr_cr_type[]"]').eq(index).val();
            prev_dr = dr_values;
            prev_cr = cr_values;
            if((value != '') && (drCrValue != '')){
                if(drCrValue == 'DR')
                dr_values+=parseFloat(value);
                if(drCrValue == 'CR')
                cr_values+=parseFloat(value);
            }
            
            if(dr_values > 100){
                alert('Dr % Not Eligible')
                $('input[name="percentage[]"]').eq(index).val((100 - prev_dr));
                dr_values = 100;
                return false;
            }

            if(cr_values > 100){
                alert('Dr % Not Eligible')
                $('input[name="percentage[]"]').eq(index).val(100 - prev_cr);
                cr_values = 100;
                return false;
            }
            
        });


        cr_values = isNaN(cr_values) ? 0: cr_values;
        dr_values = isNaN(dr_values) ? 0: dr_values;

        $('#total_dr').text(dr_values)
        $('#total_cr').text(cr_values)     
    }

    function saveItemwiseIntegration(){
        let formElement = document.querySelector('#item_type_wise_billing');
        let formData = new FormData(formElement);
        if($('#item_type_wise_billing').valid()){
            var hasError = false;
            if(parseFloat($('#total_dr').text()) != 100){
                alert('Total Dr % not Eligible.');
                hasError = true;
                return false;
            }
            if(parseFloat($('#total_cr').text()) != 100){
                alert('Total Cr % not Eligible.');
                hasError = true;
                return false;
            }
            if(hasError == true){
                return false;
            }
            hasError = false;
            var general_ledger = '';
            var dr_cr = '';

            $('select[name="general_ledger[]"]').each(function(index) {                    
                general_ledger = $('select[name="general_ledger[]"]').eq(index).attr('id');
                dr_cr = $('select[name="dr_cr_type[]"]').eq(index).attr('id');
                percentage = $('input[name="percentage[]"]').eq(index).attr('id');
                item_type = $('select[name="item_type[]"]').eq(index).attr('id');

                if($('#'+general_ledger).val() == null) {
                    alert('General Ledger is Required!');
                    hasError = true;
                    return false;
                }
                if($('#'+percentage).val() == null || $('#'+percentage).val() == 0) {
                    if($('#'+percentage).val() == 0)
                    alert('0% Percentage is Invalid!');
                    else
                    alert('Percentage is Required!');
                    hasError = true;
                    return false;
                }

                if($('#'+item_type).val() == 0) {
                    alert('Item Group is Required!');
                    hasError = true;
                    return false;
                }

            });

            if(hasError == true){
                return false;
            }

            $.ajax({
                url:"{{route('v1.accounts.save-item-wise-account-integration-billing')}}",
                type:"post",
                dataType:"json",
                data:formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    blockUI();
                    $('#item_type_wise_billing button[type="submit"]').prop('disabled', true);
                },
                success:function(data){                 
                    if(data.success == true){
                        getItemwiseAccountIntegration();
                        resetForm();                         
                        $.unblockUI();
                        $('.common-modal-notify').modal('show');
                        $('.common-modal-notify .modal-title').html(data.title);
                        $('.common-modal-notify .modal-body').html(data.message);   
                    }                                                     
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
                $('#item_type_wise_billing button[type="submit"]').prop('disabled', false);
                }
            });
        }
    }

    function resetForm(){
        $(".table_identity tr:not(#tblhead0,#tblhead1,#tblhead2,#tblhead3,#tbl0,#tbl1)").empty();                
        $("#trn_type").val('');
        $("#journal_type").val('');
        $("#module").val('');
        $("#store").val('');
        $("#percentage0").val(0);
        $("#percentage1").val(0);
        $('#general_ledger0').val(null).trigger('change');
        $('#general_ledger1').val(null).trigger('change');
        $('#item_type0').val(0).trigger('change');
        $('#item_type1').val(0).trigger('change');
        $('#service_unit').val(null).trigger('change');
    }


    function setTableData(data){
            $('.item_type_wise_table_body tbody').empty();          
            var rows = [];
            var table = $('#itemwiseDataTable').DataTable();
            var status = "";
            data.forEach(function(item, index) {
                  if((item.active_status) == '1')
                        status = '<span class="badge badge-success">Active</span>';
                    else
                        status = '<span class="badge badge-danger">Inactive</span>';

                var rowData = [
                    ++index,
                    '<span>'+item.voucher_type_name+'</span>',
                    '<span>'+item.trn_type_name+'</span>',
                    item.serviceunit_name,
                    item.mserviceunit_name,
                    status,
                    '<span class="btn btn-sm btn-success open-modal" data-action="{{route('v1.accounts.accounts-billing-details','')}}/'+item.itemgroupwisemst_no_pk+'" data-modal="common-modal-md" data-title="Account Integration Billing Details" title="Account Integration Billing Details" data-id="'+item.itemgroupwisemst_no_pk+'"><i class="fas fa-eye"></i></span>&nbsp;<span><a href="{{route('v1.accounts.edit-accounts-integration-billing','')}}/'+item.itemgroupwisemst_no_pk+'" target="_blank" class="btn btn-sm btn-info"><i class="fas fa-edit"></i></a><span>'
                ];
                rows.push(rowData);
            });
            table.clear();
            table.rows.add(rows);
            table.draw();
            
    }

    function emptyTable(){

            $('#itemwiseDataTable tbody').empty();
            $('#itemwiseDataTable tbody').append(`
                <tr>
                    <td colspan="4" class="text-danger text-center">Data Not Found</td>
                </tr>
            `);

    }
</script>

