@php

$tran_type = (isset($tran_type) && (!empty($tran_type))) ? $tran_type : [];

$tran_type_no_pk = ($tran_type) ? $tran_type->trn_type_no_pk : '';
$tran_type_code = ($tran_type) ? $tran_type->trn_type_code : '';
$tran_type_name = ($tran_type) ? $tran_type->trn_type_name : '';
@endphp

<div class="col-sm-12 col-lg-5 col-xl-12">
    <form action="{{ route('tran-type.store') }}" method="post" id="room-create">
        @csrf
        <input type="hidden" name="id" value="{{ $tran_type_no_pk }}">
        <div class="form-group row">
            <label for="tran_type_code" class="col-sm-12 col-form-label col-form-label-sm">Transection Type Code <span class="text-danger">*</span></label>
            <div class="col-sm-12">
            <input type="text" class="form-control form-control-sm" id="tran_type_code" name="tran_type_code" value="{{ $tran_type_code }}" placeholder="Enter Transection Type Code" required>
            </div>

            <label for="tran_type_name" class="col-sm-12 col-form-label col-form-label-sm">Transection Type Name <span class="text-danger">*</span></label>
            <div class="col-sm-12">
            <input type="text" class="form-control form-control-sm" id="tran_type_name" name="tran_type_name" value="{{ $tran_type_name }}" placeholder="Enter Transection Type Name" required>
            </div>
        </div>
        <div class="modal-footer mt-1">
			<button type="button" class="btn btn-sm btn-danger mr-auto" data-dismiss="modal">Exit</button>
			<button type="submit" class="btn btn-sm btn-success" onclick="btnSaveUpdate(this)">Save changes</button>
		</div>
    </form>
</div>
	

