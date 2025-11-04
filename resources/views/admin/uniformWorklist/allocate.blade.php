@php
    $uniform_ind_status = '';
    $shoe_ind_status = '';
    $winteruniform_ind_status = '';
    $activeStatus = 'checked';
    $inactiveStatus = '';

    if(isset($item)) {
        $submitRoute = route('uniformWorklist.update', [$item->uniformpolicy_no_pk]);

        if($item->uniform_ind == 1) {
            $uniform_ind_status = 'checked';
        }

        if($item->shoe_ind == 1) {
            $shoe_ind_status = 'checked';
        }

        if($item->winteruniform_ind == 1) {
            $winteruniform_ind_status = 'checked';
        }

        if($item->status == '1') {
            $activeStatus = 'checked';
            $inactiveStatus = '0';
        } else {
            $activeStatus = '0';
            $inactiveStatus = 'checked';
        }
    } else {
        $submitRoute = route('uniformWorklist.store');
    }

    $serviceunit_no_fk  = $item->serviceunit_no_fk ?? '';
    $designation_no_fk  = $item->designation_no_fk ?? $designation_id;

    $uniform_qty        = $item->uniform_qty ?? '';
    $shoe_qty           = $item->shoe_qty ?? '';
    $winteruniform_qty  = $item->winteruniform_qty ?? '';
@endphp

<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">

<div class="table-responsive">
    <table class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <td class="text-center"><b>Name: {{ $items[0]->full_name }}</b></td>
                <td class="text-center"><b>Department: {{ $items[0]->department }}</b></td>
                <td class="text-center"><b>Designation: {{ $items[0]->designation_name }}</b></td>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

<form method="POST" id="form-uniform-store-{{ rand() }}" action="{{ $submitRoute }}" enctype="multipart/form-data">
    @csrf

    <input type="hidden" name="designation_no_fk" value="{{ $designation_no_fk }}" />

    {{-- Form Repeater --}}
    <div class="row">
        <div class="col-12 pr-0">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover uniform_worklist_allocation table_identity">
                    <thead class="global-uhl-table-bg">
                        <tr id="tblhead1">
                            <th class="text-center" style="width: 45%">Uniform Type<span class="text-danger">*</span></th>
                            <th class="text-center" style="width: 45%">Quantity<span class="text-danger">*</span></th>
                            <th class="text-center" style="width: 10%">Action</th>                                
                        </tr>
                    </thead>
                    <tbody>
                        <tr id="tbl0">
                            <td>
                                <select class="form-control form-control-sm font_size_12 m-auto select2" id="general_ledger0" name="item_no_fk[]">
                                    <option value="" disabled selected>Select Uniform Type - (Item Code)</option>
                                    @foreach ($itemTypes as $itemType)
                                        <option value="{{ $itemType->item_no_pk }}">{{ $itemType->item_name }} - ({{ $itemType->item_code }})</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <input type="number" class="form-control form-control-sm" id="percentage0" name="qty[]" placeholder="Enter Quantity" required />
                            </td>
                            <td>
                                <span class="btn btn-primary" onclick="addRow('debit')"><i class="fas fa-plus-circle"></i></span>
                            </td>
                        </tr>
                    </tbody>
                </table>                                        
            </div>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="remarks" class="col-form-label col-form-label-sm">Remarks</label>
                <textarea name="remarks" id="remarks" class="form-control" cols="30" rows="5" onkeyup="checkBlankSpace(this)" placeholder="Remarks"></textarea>
            </div>
        </div>
    </div>

    <input type="hidden" name="person_no_fk" value="{{ $items[0]->person_no_pk }}" />
    
    <div class="form-row">
        <div class="col-md-12 mt-3">
            @php
                $redirect_url = route('uniform.index');
            @endphp
            <button type="submit" class="btn btn-md btn-primary uhl_save_btn mt-3"
            onclick="btnSaveUpdate(this,'','','','',getData,'{{ $redirect_url }}')">Save</button>
            <button type="button" class="btn btn-md btn-danger mt-3" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-md btn-info mt-3" data-dismiss="modal">Exit</button>
        </div>
    </div>
</form>

<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script>
    $('.select2').select2();

    // $("#accountsGroupSave").validate({
    //     rules:{
    //         account_group_name:{
    //             required:true,
    //             minlength:5,
    //             maxlength:200,
    //             notOnlySpaces: true
    //         },
    //         start_range:{
    //             maxlength:10,
    //         },
    //         end_range:{
    //             maxlength:10,
    //         },
    //         account_group_code:{
    //             required:true,
    //             minlength:1,
    //             maxlength:50,
    //             notOnlySpaces: true
    //         },
    //         notes:{
    //             maxlength:500
    //         }
    //     },
    //     messages:{
    //         account_group_name:{
    //             required: "Account Group Name Required",
    //         },
    //         account_group_code:{
    //             required: "Account Group Code Required",
    //         }
    //     }
    // });

    // <!-- Submit Form Data -->
    // function accountsGroupSaveForm(){
    //     if($('#accountsGroupSave').valid()){
    //         let formElement = document.querySelector('#accountsGroupSave');
    //         let formData = new FormData(formElement);

    //         var start_range = $('#start_range').val();
    //         var end_range = $('#end_range').val();

    //         if(start_range != '' || end_range != ''){
    //             if(start_range == ''){
    //                 alert('Start Range Required!');
    //                 return false;
    //             }
    //             if(end_range == ''){
    //                 alert('End Range Required!');
    //                 return false;
    //             }
    //         }

    //         $.ajax({
    //             url:"{{ route('v1.accounts.save-accounts-group') }}",
    //             type:"post",
    //             dataType:"json",
    //             data:formData,
    //             cache: false,
    //             contentType: false,
    //             processData: false,
    //             beforeSend: function() {
    //                 blockUI();
    //             },
    //             success:function(data) {
    //                 if(data.data.length != 0)
    //                     setTableData(data.data);

    //                 $('#accountsGroupSave').trigger('reset');
    //                 $('.common-modal-notify').modal('show');
    //                 $('.common-modal-notify .modal-title').html(data.title);
    //                 $('.common-modal-notify .modal-body').html(data.message);
    //             },
    //             error:function(err){
    //                 $.unblockUI();
    //                 var error = err.responseJSON;
    //                 $('.common-modal-notify-error').modal('show');
    //                 $('.common-modal-notify-error .modal-title').html('Failed');
    //                 $('.common-modal-notify-error .modal-body').html(error.message);
    //             },
    //             complete: function() {
    //                 $.unblockUI();
    //             }
    //         });
    //     }
    // }

    // // Form
    // const formId = $('form').attr('id');
    // console.log(formId);
</script>

<script type="text/javascript">
    var count = 1;      
    function addRow(type) {
        count += 1;
        var tbl = `<tr class="accounts-integration-row" id="tbl${count}">
                    <td>
                        <select class="form-control font_size_12 m-auto select2 select2" id="general_ledger${count}" name="item_no_fk[]">
                            <option value="" disabled selected>Select Uniform Type - (Item Code)</option>
                            @foreach ($itemTypes as $itemType)
                                <option value="{{ $itemType->item_no_pk }}">{{ $itemType->item_name }} - ({{ $itemType->item_code }})</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input type="number" class="form-control form-control-sm" id="percentage${count}" name="qty[]" placeholder="Enter Quantity" required />
                    </td>
                    <td>
                        <span class="btn btn-warning remove_row"><i class="fas fa-trash" style="color:red"></i></span>
                    </td>

                </tr>`;
        $('.uniform_worklist_allocation tbody').append(tbl);

        // initialize select2       
        $('#general_ledger'+count).select2({});
        $('#item_type'+count).select2({});

    }

    $(document).ready(function(){
        /*remove row*/
        $(document).on("click", ".remove_row", function() {
            let id = $(this).closest('.accounts-integration-row').attr('id');
            $("#"+id).remove();
        });
    })
</script>
