<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<form method="post" id="frm-result-search" action="{{ route('path.search-result-entry') }}" action="javascript:void(0)">
@csrf
<input type="hidden" id="mailType" name="mailType" value="{{isset($mailType) ? $mailType :''}}">
<div class="card mt-0">
	<div class="card-body">
		<div class="form-row">
			<!-- <div class="col-3">
				<div class="form-group">
					<label for="patient_code" class="col-form-label col-form-label-sm"> Patient Code</label>
					<input class="form-control form-control-sm" type="text" id="patient_code" name="patient_code" value="" placeholder=" Patient Code.">
				</div>
			</div>
			-->
			<div class="col-2">
				<div class="form-group">
					<label for="admission_no" class="col-form-label col-form-label-sm">IP No</label>
					<input class="form-control form-control-sm" type="text" id="admission_no" name="admission_no" value="" placeholder="">
				</div>
			</div>
            <div class="col-3">
                <div class="form-group">
                    <label class="col-form-label col-form-label-sm" for="search_date_from"> Date</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">From</div>
                        </div>
                        <input type="text" class="form-control form-control-sm m-0 date_picker" id="search_date_from" name="search_date_from" value="{{date('d-m-Y', strtotime("-30 Days"))}}" placeholder="dd-mm-yyyy" autocomplete="off" >
                        <div class="input-group-prepend">
                            <div class="input-group-text">To</div>
                        </div>
                        <input type="text" class="form-control form-control-sm m-0 date_picker" id="search_date_to" name="search_date_to" value="{{date('d-m-Y')}}" placeholder="dd-mm-yyyy" autocomplete="off">
                    </div>
                </div>
            </div>


			<div class="col-2">
				<div class="form-group">
					<label for="prescription_id" class="col-form-label col-form-label-sm">Service Unit</label>


                    <select name="service_unit" id="service_unit" class="form-control form-control-sm select2">
                        <option value="">select</option>
                        @if (!empty($service_unit))
                        @foreach ($service_unit as $value )
                        <option value="{{$value->serviceunit_no_pk}}">{{$value->serviceunit_name}}</option>
                        @endforeach
                        @endif
                    </select>
				</div>
			</div>
            <div class="col-2">
				<div class="form-group">
					<label for="prescription_id" class="col-form-label col-form-label-sm">Invoice No</label>
					<input class="form-control form-control-sm" type="text" id="prescription_id" name="prescription_id" value="" placeholder="">
				</div>
			</div>
            <div class="col-2">
				<div class="form-group">
					<label for="lab_id" class="col-form-label col-form-label-sm">Sample Id</label>
					<input class="form-control form-control-sm" type="text" id="lab_id" name="lab_id" value="" placeholder="">
				</div>
			</div>
			<div class="col-1">
				<input type="hidden" name="hdn_operation" value="{{ $operation }}">
				<input type="hidden" name="hdn_type" value="{{ $type }}">
				<button type="button" id="searchResult" class="btn btn-md btn-success btn-block mt-4 btn-md-global" onclick="pathologyFunc.searchResultEntry(this)">  Search</button>
                {{-- <i class="fa fa-search mr-1"></i> --}}
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
