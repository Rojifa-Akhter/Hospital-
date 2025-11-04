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

        if(isset($item->shoe_ind) && $item->shoe_ind == 1) {
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
        {{-- <label for="serviceunit_no_fk" class="col-sm-2 col-form-label col-form-label-sm">Department <span class="text-danger">*</span></label>
        <div class="col-sm-4">
            <select class="form-control font_size_12 m-auto select2" id="serviceunit_no_fk" name="serviceunit_no_fk" required>
                <option value="" selected disabled>Select Department</option>
                @foreach ($departments as $department)
                    <option value="{{ $department->serviceunit_no_pk }}" {{ $serviceunit_no_fk == $department->serviceunit_no_pk ? 'selected' : '' }}> {{ ucwords(strtolower($department->serviceunit_name)) }}</option>
                @endforeach
            </select>
        </div> --}}

        {{-- Designation --}}
        <label for="designation_no_fk" class="col-sm-3 col-form-label col-form-label-sm">Designation <span class="text-danger">*</span></label>
        <div class="col-sm-3">
            <select class="form-control font_size_12 m-auto select2" id="designation_no_fk" name="designation_no_fk" required>
                <option value="" selected disabled>Select Designation</option>
                @foreach ($designations as $designation)
                    <option value="{{ $designation->designation_no_pk }}" {{ $designation_no_fk == $designation->designation_no_pk ? 'selected' : '' }}> {{ ucwords(strtolower($designation->designation_name)) }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="form-group row">
        {{-- Uniform --}}
        <label for="uniform_ind" class="col-sm-3 col-form-label col-form-label-sm">Uniform</label>
        <div class="col-sm-3">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="uniform_ind" id="uniform_ind" value="1" {{ $uniform_ind_status }} />
            </div>
        </div>

        {{-- Uniform Quantity --}}
        <label for="uniform_qty" class="col-sm-3 col-form-label col-form-label-sm">Uniform Qty<span class="text-danger"> </span></label>
        <div class="col-sm-3">
            <input type="number" class="form-control form-control-sm " id="uniform_qty" name="uniform_qty" placeholder="Enter Uniform Qty" min="0" value="{{ $uniform_qty }}" />
        </div>
    </div>

    <div class="form-group row">
        {{-- Shoes --}}
        <label for="shoe_ind" class="col-sm-3 col-form-label col-form-label-sm">Shoes</label>
        <div class="col-sm-3">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="shoe_ind" id="shoe_ind" value="1" {{ $shoe_ind_status }} />
            </div>
        </div>

        {{-- Shoe Quantity --}}
        <label for="shoe_qty" class="col-sm-3 col-form-label col-form-label-sm">Shoe Qty<span class="text-danger"> </span></label>
        <div class="col-sm-3">
            <input type="number" class="form-control form-control-sm " id="shoe_qty" name="shoe_qty" placeholder="Enter Shoe Qty" min="0" value="{{ $shoe_qty }}" />
        </div>
    </div>

    <div class="form-group row">
        {{-- Winter Uniform --}}
        <label for="winteruniform_ind" class="col-sm-3 col-form-label col-form-label-sm">Winter Uniform</label>
        <div class="col-sm-3">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="winteruniform_ind" id="winteruniform_ind" value="1" {{ $winteruniform_ind_status }} />
            </div>
        </div>

        {{-- Winter Uniform Quantity --}}
        <label for="winteruniform_qty" class="col-sm-3 col-form-label col-form-label-sm">Winter Uniform Qty<span class="text-danger"> </span></label>
        <div class="col-sm-3">
            <input type="number" class="form-control form-control-sm " id="winteruniform_qty" name="winteruniform_qty" placeholder="Enter Winter Uniform Qty" min="0" value="{{ $winteruniform_qty }}" />
        </div>
    </div>

    <div class="form-group row">
        {{-- Status --}}
        <label for="status" class="col-sm-3 col-form-label col-form-label-sm">Status</label>
        &nbsp;&nbsp;&nbsp;&nbsp;
        <div class="listRadio">
            <input type="radio" class="moduleRadio" name="status" id="active" {{ $activeStatus }} value="1">
            <label for="active">Active </label>
        </div>
        &nbsp;&nbsp;
        <div class="listRadio">
            <input type="radio" class="moduleRadio" name="status" id="inactive" {{ $inactiveStatus }} value="0">
            <label for="inactive">Inactive </label>
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
