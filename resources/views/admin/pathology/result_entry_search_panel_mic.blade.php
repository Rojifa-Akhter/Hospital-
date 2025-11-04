<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<form method="post" id="frm-result-search" action="{{ route('path.search-result-entry') }}" action="javascript:void(0)">
@csrf
<div class="card mt-0">
	<div class="card-body">
		<div class="form-row">
		 <div class="col-2">
            <label for="prescription_id" class="col-form-label col-form-label-sm">Department</label>

            <h6>{{isset($service_unit_name) ? $service_unit_name :''}}</h6>
			</div>

            <div class="col-6">
                <div class="form-group">
                    <label class="col-form-label col-form-label-sm" for="search_date_from">Invoice Date</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">From</div>
                        </div>
                        <input type="text" class="form-control form-control-sm m-0 date_picker" id="search_date_from" name="search_date_from" value="" placeholder="dd-mm-yyyy" autocomplete="off">
                        <div class="input-group-prepend">
                            <div class="input-group-text">To</div>
                        </div>
                        <input type="text" class="form-control form-control-sm m-0 date_picker" id="search_date_to" name="search_date_to" value="" placeholder="dd-mm-yyyy" autocomplete="off">
                    </div>
                </div>
            </div>


			{{-- <div class="col-2">
				<div class="form-group">
					<label for="prescription_id" class="col-form-label col-form-label-sm">Department</label>


                    <select name="service_unit" id="service_unit" class="form-control form-control-sm select2">
                        <option value="">select</option>
                        @if (!empty($service_unit))
                        @foreach ($service_unit as $value )
                        <option value="{{$value->serviceunit_no_pk}}">{{$value->serviceunit_name}}</option>
                        @endforeach
                        @endif
                    </select>
				</div>
			</div> --}}
            <div class="col-2">
				<div class="form-group">
					<label for="prescription_id" class="col-form-label col-form-label-sm">Invoice No</label>
					<input class="form-control form-control-sm" type="text" id="prescription_id" name="prescription_id" value="" placeholder="Invoice No">
				</div>
			</div>
			<div class="col-2">
				<input type="hidden" name="hdn_operation" value="{{ $operation }}">
				<input type="hidden" name="hdn_type" value="{{ $type }}">
				<button type="button" class="btn btn-md btn-success btn-block mt-4 btn-md-global" onclick="pathologyFunc.searchResultEntry(this)"> <i class="fa fa-search mr-1"></i> Search</button>
			</div>
		</div>
	</div>
</div>
</form>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script>
    $(function() {
        $('.date_picker').datepicker({
		format: 'dd-mm-yyyy',
		autoclose: true,
		todayHighlight: true,
		clearBtn: true,
	});
    });
</script>
