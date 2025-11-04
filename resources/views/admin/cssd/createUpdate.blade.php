@php
    $uniform_ind_status = '';
    $shoe_ind_status = '';
    $winteruniform_ind_status = '';
    $activeStatus = 'checked';
    $inactiveStatus = '';

    if(isset($item)) {
        $submitRoute = route('uniform.update', [$item->uniformpolicy_no_pk]);

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
        $submitRoute = route('uniform.store');
    }

    $serviceunit_no_fk  = $item->serviceunit_no_fk ?? '';
    $designation_no_fk  = $item->designation_no_fk ?? '';

    $uniform_qty        = $item->uniform_qty ?? '';
    $shoe_qty           = $item->shoe_qty ?? '';
    $winteruniform_qty  = $item->winteruniform_qty ?? '';
@endphp

<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">

<form method="POST" id="form-uniform-store-{{ rand() }}" action="{{ $submitRoute }}" enctype="multipart/form-data">
    @csrf
    <div class="form-group row">
        {{-- Department --}}
        <label for="serviceunit_no_fk" class="col-sm-2 col-form-label col-form-label-sm">Department <span class="text-danger">*</span></label>
        <div class="col-sm-4">
            <select class="form-control font_size_12 m-auto select2" id="serviceunit_no_fk" name="serviceunit_no_fk" required>
                <option value="" selected disabled>Select Department</option>
                @foreach ($departments as $department)
                    <option value="{{ $department->serviceunit_no_pk }}" {{ $serviceunit_no_fk == $department->serviceunit_no_pk ? 'selected' : '' }}> {{ ucwords(strtolower($department->serviceunit_name)) }}</option>
                @endforeach
            </select>
        </div>

        {{-- Items --}}
        <label for="designation_no_fk" class="col-sm-1 col-form-label col-form-label-sm">Item <span class="text-danger">*</span></label>
        <div class="col-sm-5">
            <select class="form-control font_size_12 m-auto select2" id="designation_no_fk" name="designation_no_fk" required>
                <option value="" selected disabled>Select Item</option>
                @foreach ($items as $item)
                    <option value="{{ $item->item_no_pk }}" {{ 1 != 1 ? 'selected' : '' }}> {{ ucwords(strtolower($item->item_name)) }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="form-group row">
        {{-- Item Quantity --}}
        <label for="qty" class="col-sm-2 col-form-label col-form-label-sm">Item Qty<span class="text-danger"> </span></label>
        <div class="col-sm-4">
            <input type="number" class="form-control form-control-sm " id="qty" name="qty" placeholder="Enter Item Qty" min="0" value="{{ $uniform_qty }}" />
        </div>
    </div>

    <div class="form-group row">
        {{-- Remarks --}}
        <label for="remarks" class="col-sm-12 col-form-label col-form-label-sm">Remarks</label>
        <div class="col-sm-12">
           <textarea id="remarks" name="remarks" rows="2" class="form-control"></textarea>
        </div>
    </div>

    <div class="form-row">
        <div class="col-md-12 mt-3">
            @php
                $redirect_url = route('uniform.index');
            @endphp
            <button type="submit" class="btn btn-md btn-primary uhl_save_btn mt-3"
            onclick="btnSaveUpdate(this,'','','','',getUniformSetupData,'{{ $redirect_url }}')">Save</button>
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
