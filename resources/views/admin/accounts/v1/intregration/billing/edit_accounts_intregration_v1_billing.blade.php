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
                    <h5 class="mt-2 mb-0">Edit Account Integration - Billing</h5>
                    <small>Accounts / Setup / Edit Account Integration - Billing</small>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <form id="item_type_wise_form_data_update" method="POST" class="item_type_wise_form_data_update">
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
                                                        <option value="{{$item->voucher_type_no_pk}}" data-type="{{$item->voucher_type_name}}" {{$master->voucher_type_no_fk == $item->voucher_type_no_pk ? 'selected' : ''}}>{{$item->voucher_type_code}} - {{$item->voucher_type_name}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            <input type="hidden" value="{{$master->itemgroupwisemst_no_pk}}" name="itemgroupwisemst_no_pk">
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
                                                        <option value="{{ $data->module_no_pk }}" {{$master->module_no_fk == $data->module_no_pk ? 'selected' : ''}}>{{ $data->module_code }} - {{ $data->module_name }}</option>
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
                                                        <option value="{{ $data->trn_type_no_pk }}" {{$master->trn_type_no_fk == $data->trn_type_no_pk ? 'selected' : ''}} >{{ $data->trn_type_code }} - {{ $data->trn_type_name }}</option>
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
                                                    <option value="{{$item->serviceunit_no_pk}}" {{$master->store_su_no_fk == $item->serviceunit_no_pk ? 'selected' : ''}}>{{$item->serviceunit_name}} - {{$item->serviceunit_code}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-2">
                                    <div class="row">
                                        <div class="col-12">
                                            <label for="">Accounts Mapping SU </label>
                                        </div>
                                        <div class="col-12">
                                            <select name="service_unit" id="service_unit" class="form-control form-control-sm font_size_12 m-auto select2">
                                                <option value="" selected>-Select service unit-</option>
                                                @foreach ($all_service_unit->getData()->data as $item)
                                                    @if($item->status == 1)
                                                        <option value="{{$item->serviceunit_no_pk}}" {{$master->accounts_mapping_su_no_fk == $item->serviceunit_no_pk ? 'selected' : ''}}>{{$item->serviceunit_name}} - {{$item->serviceunit_code}}</option>
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
                                                    <th class="text-center" style="width: 35%">Item Group<span class="text-danger">*</span></th>
                                                    <th class="text-center" style="width: 10%">Percentage<span class="text-danger">*</span></th>
                                                    <th class="text-center" style="width: 10%">Action</th>                                
                                                </tr>
        
                                            </thead>
        
                                            <tbody>
                                               @php $counter = 0 ; @endphp
                                            @foreach (collect($details->getData()->data)->where('trn_crdr_type','DR') as $key => $childitem)
                                                <tr class="accounts-integration-row" id="tbl{{$counter}}">
                                                    <td>
                                                    
                                                            <select class="form-control form-control-sm font_size_12 m-auto select2" id="general_ledger{{$counter}}" name="general_ledger[]">
                                                                <option value=""  selected>Select One</option>
                                                                @foreach ($general_ledger->getData()->data as $item)
                                                                    @if($item->status == 1)
                                                                        <option value="{{$item->account_no_pk}}" {{$childitem->trn_dr_cr_account_no_fk == $item->account_no_pk ? 'selected' : ''}} >{{$item->account_code}} - {{$item->account_name}}</option>
                                                                    @endif
                                                                @endforeach
                                                            </select>
                                                            <input type="hidden" class="form-control form-control-sm" id="dr_cr_type{{$counter}}" name="dr_cr_type[]" value="DR">
            
                                                    </td>
            
                                                    
                                        
                                                    <td>
                                                        <select name="item_type[]" id="item_type{{$counter}}" class="form-control form-control-sm select2">
                                                            <option value="0" selected>Select One</option>
                                                            @foreach($major_group_item_type as $data)
                                                                    <option value="{{ $data->itemtype_no_pk }}" {{$childitem->group_itemtype_no_fk == $data->itemtype_no_pk ? 'selected' : ''}}>{{ $data->itemtype_code }} - {{ $data->item_type_name }}</option>                      
                                                            @endforeach
                                                        </select>
                                                    </td>

                                                    <td>
                                                        <input type="number" step="0.01" class="form-control form-control-sm" id="percentage{{$counter}}" name="percentage[]" placeholder="Percent %" value="{{$childitem->trn_dr_cr_account_percent}}" oninput="PercentageUpdate()"  max="100"/>
                                                    </td>
                  
                                                    <td>
                                                        @if($key == 0)
                                                            <span class="btn btn-primary" onclick="addRow('debit')"><i class="fas fa-plus-circle"></i></span>
                                                        @else
                                                            <span class="btn btn-warning remove_row_accounts_integration"><i class="fas fa-trash" style="color:red"></i></span>
                                                        @endif
                                                    </td>
                                                </tr>  
                                                @php $counter++ ; @endphp   
                                            @endforeach                                            
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
                                                    <th class="text-center" style="width: 35%">Item Group<span class="text-danger">*</span></th>
                                                    <th class="text-center" style="width: 10%">Percentage<span class="text-danger">*</span></th>
                                                    <th class="text-center" style="width: 10%">Action</th>                                                                 
                                                </tr>
                                            </thead>
                                            <tbody>

                                                @foreach (collect($details->getData()->data)->where('trn_crdr_type','CR') as $key => $childitem)
                                                <tr class="accounts-integration-row" id="tbl{{$counter}}">
                                                    <td>
                                                    
                                                            <select class="form-control form-control-sm font_size_12 m-auto select2" id="general_ledger{{$counter}}" name="general_ledger[]">
                                                                <option value=""  selected>Select One</option>
                                                                @foreach ($general_ledger->getData()->data as $item)
                                                                    @if($item->status == 1)
                                                                        <option value="{{$item->account_no_pk}}" {{$childitem->trn_dr_cr_account_no_fk == $item->account_no_pk ? 'selected' : ''}} >{{$item->account_code}} - {{$item->account_name}}</option>
                                                                    @endif
                                                                @endforeach
                                                            </select>
                                                            <input type="hidden" class="form-control form-control-sm" id="dr_cr_type{{$counter}}" name="dr_cr_type[]" value="CR">
            
                                                    </td>
            
                                                    
                                        
                                                    <td>
                                                        <select name="item_type[]" id="item_type{{$counter}}" class="form-control form-control-sm select2">
                                                            <option value="0" selected>Select One</option>
                                                            @foreach($major_group_item_type as $data)
                                                                    <option value="{{ $data->itemtype_no_pk }}" {{$childitem->group_itemtype_no_fk == $data->itemtype_no_pk ? 'selected' : ''}}>{{ $data->itemtype_code }} - {{ $data->item_type_name }}</option>                      
                                                            @endforeach
                                                        </select>
                                                    </td>

                                                    <td>
                                                        <input type="number" step="0.01" class="form-control form-control-sm" id="percentage{{$counter}}" name="percentage[]" placeholder="Percent %" value="{{$childitem->trn_dr_cr_account_percent}}" oninput="PercentageUpdate()"  max="100"/>
                                                    </td>

                                                    <td>
                                                        @if($loop->iteration == 1)
                                                            <span class="btn btn-primary" onclick="addRow('credit')"><i class="fas fa-plus-circle"></i></span>
                                                        @else
                                                            <span class="btn btn-warning remove_row_accounts_integration"><i class="fas fa-trash" style="color:red"></i></span>
                                                        @endif
                                                    </td>
                                                </tr>  
                                                @php $counter++ ; @endphp   
                                            @endforeach  
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
                                            <button type="button"  class="btn btn-secondary uhl_save_btn" id="item_type_wise_form" onclick="updateItemwiseIntegration()">Save</button>
                                        </li>
                                        <li class="list-inline-item"><button type="reset" class="btn btn-secondary">Reset</button></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                   
                    
                </form>  
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
        $("#item_type_wise_form_data_update").validate({
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
 
    var count= '<?php echo $counter ;?>';      
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

    PercentageUpdate()
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

    function updateItemwiseIntegration(){
        let formElement = document.querySelector('#item_type_wise_form_data_update');
        let formData = new FormData(formElement);
        if($('#item_type_wise_form_data_update').valid()){

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
                url:"{{route('v1.accounts.update-item-wise-account-integration-billing')}}",
                type:"post",
                dataType:"json",
                data:formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    blockUI();
                    $('#item_type_wise_form_data_update button[type="submit"]').prop('disabled', true);
                },
                success:function(data){                 
                    if(data.success == true){                        
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
                $('#item_type_wise_form_data_update button[type="submit"]').prop('disabled', false);
                }
            });
        }
    }
</script>

