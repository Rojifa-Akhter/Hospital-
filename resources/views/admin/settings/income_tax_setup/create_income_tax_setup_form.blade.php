@php
//$income_setup_info_edit = (isset($income_setup_info_edit) && (!empty($income_setup_info_edit))) ? $income_setup_info_edit : '';
//dd($income_setup_info_edit);
// dd($income_setup_info_edit);
$income_tax_setup_no_pk = isset($income_setup_info_edit->income_tax_setup_no_pk) ? $income_setup_info_edit->income_tax_setup_no_pk : '';
$tax_description = isset($income_setup_info_edit->tax_description) ? $income_setup_info_edit->tax_description : '';
$tax_fee_amount = isset($income_setup_info_edit->tax_fee_amount) ? $income_setup_info_edit->tax_fee_amount : '';
$min_tax_percent = isset($income_setup_info_edit->min_tax_percent) ? $income_setup_info_edit->min_tax_percent : '';
$rem_next_one_lac = isset($income_setup_info_edit->rem_next_one_lac) ? $income_setup_info_edit->rem_next_one_lac : '';
$rem_next_one_lac_percent = isset($income_setup_info_edit->rem_next_one_lac_percent) ? $income_setup_info_edit->rem_next_one_lac_percent : '';
$rem_next_three_lac = isset($income_setup_info_edit->rem_next_three_lac) ? $income_setup_info_edit->rem_next_three_lac : '';
$rem_next_three_lac_percent = isset($income_setup_info_edit->rem_next_three_lac_percent) ? $income_setup_info_edit->rem_next_three_lac_percent : '';
$rem_next_four_lac = isset($income_setup_info_edit->rem_next_four_lac) ? $income_setup_info_edit->rem_next_four_lac : '';
$rem_next_four_lac_percent = isset($income_setup_info_edit->rem_next_four_lac_percent) ? $income_setup_info_edit->rem_next_four_lac_percent : '';
$rem_next_five_lac = isset($income_setup_info_edit->rem_next_five_lac) ? $income_setup_info_edit->rem_next_five_lac : '';
$rem_next_five_lac_percent = isset($income_setup_info_edit->rem_next_five_lac_percent) ? $income_setup_info_edit->rem_next_five_lac_percent : '';
$rem_next_everything_percent = isset($income_setup_info_edit->rem_next_everything_percent ) ? $income_setup_info_edit->rem_next_everything_percent : '';
$default_ind = isset($income_setup_info_edit->default_ind ) ? $income_setup_info_edit->default_ind : '';
$rem_next_everything_percent = isset($income_setup_info_edit->rem_next_everything_percent) ? $income_setup_info_edit->rem_next_everything_percent : '';


@endphp

{{-- <link href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}" rel="stylesheet"> --}}


<div class="row">
	<div class="col-sm-12 col-lg-12 col-xl-12">
		<form action="{{ route('income-tax-setup.store') }}" method="post" id="income_tax_setup">
			@csrf

            <input type="hidden" name="income_tax_id" value="{{$income_tax_setup_no_pk}}">
			<div class="form-group row">
				<div class="col-md-4">
					<label for="lookup_code" class="col-sm-12 col-form-label col-form-label-sm">Tax Description<span class="text-danger">*</span></label>
					<div class="col-sm-12">
						<input type="text" class="form-control form-control-sm" id="tax_description" name="tax_description" value = "{{ $tax_description ? $tax_description: 'Income tax year 2022'}}">
					</div>
				</div>
				<div id="doctor_id" class="col-md-4">
					<label for="lookup_code" class="col-sm-12 col-form-label col-form-label-sm">Tax Fee amount(max)<span class="text-danger">*</span></label>
                    <input type="text" class="form-control form-control-sm" id="tax_fee_amount" name="tax_fee_amount" value = "{{$tax_fee_amount ? $tax_fee_amount:300000}}">

				</div>
                <div id="doctor_id" class="col-md-4">
					<label for="lookup_code" class="col-sm-12 col-form-label col-form-label-sm">Min tax (%)<span class="text-danger">*</span></label>
                    <input type="text" class="form-control form-control-sm" id="min_tax_percent" name="min_tax_percent" value = "{{$min_tax_percent ? $min_tax_percent: 5}}">

				</div>
			</div>

			<div class="form-group row">
				<div class="col-md-6">
					<label for="item_type_Code" class="col-sm-12 col-form-label col-form-label-sm">Remaining next 1 Lac<span class="text-danger">*</span></label>
                    <input type="text" class="form-control form-control-sm" id="rem_next_one_lac" name="rem_next_one_lac" value = "{{$rem_next_one_lac ? $rem_next_one_lac: 100000}}">

				</div>
				<div class="col-md-6">
					<label for="item_type_Code" class="col-sm-12 col-form-label col-form-label-sm">Remaining next 1 Lac percent<span class="text-danger">*</span></label>
                    <input type="text" class="form-control form-control-sm" id="rem_next_one_lac_percent" name="rem_next_one_lac_percent" value = "{{$rem_next_one_lac_percent ? $rem_next_one_lac_percent: 5}}">

				</div>
			</div>

            <div class="form-group row">
				<div class="col-md-6">
					<label for="item_type_Code" class="col-sm-12 col-form-label col-form-label-sm">Remaining next 3 Lac<span class="text-danger">*</span></label>
                    <input type="text" class="form-control form-control-sm" id="rem_next_three_lac" name="rem_next_three_lac" value = "{{$rem_next_three_lac? $rem_next_three_lac:300000}}">

				</div>
				<div class="col-md-6">
					<label for="item_type_Code" class="col-sm-12 col-form-label col-form-label-sm">Remaining next 3 Lac percent<span class="text-danger">*</span></label>
                    <input type="text" class="form-control form-control-sm" id="rem_next_three_lac_percent" name="rem_next_three_lac_percent" value = "{{$rem_next_three_lac_percent ? $rem_next_three_lac_percent: 10}}">

				</div>
			</div>

            <div class="form-group row">
				<div class="col-md-6">
					<label for="item_type_Code" class="col-sm-12 col-form-label col-form-label-sm">Remaining next 4 Lac<span class="text-danger">*</span></label>
                    <input type="text" class="form-control form-control-sm" id="rem_next_four_lac" name="rem_next_four_lac" value = "{{$rem_next_four_lac ?$rem_next_four_lac: 400000}}">

				</div>
				<div class="col-md-6">
					<label for="item_type_Code" class="col-sm-12 col-form-label col-form-label-sm">Remaining next 4 Lac percent<span class="text-danger">*</span></label>
                    <input type="text" class="form-control form-control-sm" id="rem_next_four_lac_percent" name="rem_next_four_lac_percent" value = "{{$rem_next_four_lac_percent ?$rem_next_four_lac_percent: 15}}">

				</div>
			</div>
            <div class="form-group row">
				<div class="col-md-6">
					<label for="item_type_Code" class="col-sm-12 col-form-label col-form-label-sm">Remaining next 5 Lac<span class="text-danger">*</span></label>
                    <input type="text" class="form-control form-control-sm" id="rem_next_five_lac" name="rem_next_five_lac" value = "{{$rem_next_five_lac ? $rem_next_five_lac :500000}}">

				</div>
				<div class="col-md-6">
					<label for="item_type_Code" class="col-sm-12 col-form-label col-form-label-sm">Remaining next 5 Lac percent<span class="text-danger">*</span></label>
                    <input type="text" class="form-control form-control-sm" id="rem_next_five_lac_percent" name="rem_next_five_lac_percent" value = "{{$rem_next_five_lac_percent ? $rem_next_five_lac_percent: 20}}">

				</div>
			</div>
            <div class="form-group row">
				<div class="col-md-6">
					<label for="item_type_Code" class="col-sm-12 col-form-label col-form-label-sm">Remaining next everything<span class="text-danger">*</span></label>
                    <input type="text" class="form-control form-control-sm" id="rem_next_everything_percent" name="rem_next_everything_percent" value = "{{$rem_next_everything_percent? $rem_next_everything_percent: 25}}">

				</div>

                <div class="col-md-6">
					<label for="status" class="col-sm-12 col-form-label col-form-label-sm">Default</label>
					<div class="col-md-4">
						<div class="form-check form-check-inline">
							<input class="form-check-input" type="checkbox" name="default_ind" value="1" {{$default_ind == '1' ? 'checked' : ''}}>
							<label class="form-check-label" for="status">Active</label>
						</div>
					</div>
				</div>

			</div>
            {{-- <div class="form-group row">

				<div class="col-md-6">
					<label for="status" class="col-sm-12 col-form-label col-form-label-sm">Status</label>
					<div class="col-md-4">
						<div class="form-check form-check-inline">
							<input class="form-check-input" type="checkbox" name="status" id="status" value="1" {{ $status == '1' ? 'checked' : '' }}>
							<label class="form-check-label" for="status">Active</label>
						</div>
					</div>
				</div>
			</div> --}}
			{{-- <div class="form-group row">

				<div class="col-md-6">
					<label for="status" class="col-sm-12 col-form-label col-form-label-sm">Status</label>
					<div class="col-md-4">
						<div class="form-check form-check-inline">
							<input class="form-check-input" type="checkbox" name="status" id="status" value="1" {{ $status == '1' ? 'checked' : '' }}>
							<label class="form-check-label" for="status">Active</label>
						</div>
					</div>
				</div>
			</div> --}}

			<div class="modal-footer mt-1 text-left">
				@php
				$response_action = route('income-tax-setup.create');
				@endphp
				<button type="button" class="btn btn-md btn-danger" data-dismiss="modal">Exit</button>
				<button type="submit" class="btn btn-md btn-success" onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">Add</button>

			</div>
		</form>
	</div>
</div>
{{-- <script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script type="text/javascript">
	$(function() {

		$('.select2').select2();
	});
    var dept = {
    getlookupList:function (thisElement) {
        var departmentId = $('#department_id').val();
        $.ajax({
            url:"{{route('departmentId')}}",
            type:'POST',
            data: {
             departmentId:departmentId
         },
         beforeSend: function () {
            blockUI();
        },
        success: function (data) {
		$('#doctor_id').html(data);
     },
     complete: function () {

        $.unblockUI();
    }
});
    },
};

</script> --}}
