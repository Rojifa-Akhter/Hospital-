<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<section id="doctor_fee_setup">
	<div class="container-fluid">
		<div class="card">
			<div class="card-header"><h5>Doctor Fee Setup</h5></div>
			<div class="card-body">
				<form method="post" id="fee_setup_store" action="{{ route('doctor-fee-setup-store') }}">
					@csrf
					<input type="hidden" name="doctor_pk_no" value="{{$data->person_no_pk}}">
					<div class="form-group mt-1">
						@if(isset($visit_type))
						@php $i = 0; @endphp
						@foreach($visit_type as $key => $val)


						<div class="row">
							<div class="col-md-6">
								<label for="email">{{$val}}</label>
								<input type="hidden" name="visit_type_pk_no[]" value="{{$key}}">
							</div>
							<div class="col-md-6">
								@if(isset($fee_arr[$key]['item_id']))


								<input type="text" name="item_name[]" class="form-control item_name" {{ $i == 0 ? 'required' : ' ' }} value="{{ $fee_arr[$key]['item_name'] }}">
								<input type="hidden" name="item_id[]" value="{{ $fee_arr[$key]['item_id'] }}" />
								<input type="hidden" name="hdn_doctorfee_id[]" value="{{ $fee_arr[$key]['doc_fee_id'] }}" />
								@else
								<input type="text" name="item_name[]" class="form-control item_name" {{ $i == 0 ? 'required' : ' ' }} value="" autocomplete="off">
								<input type="hidden" name="item_id[]" />
								@endif

							</div>
						</div>
						@php $i++; @endphp
						@endforeach
						@endif
					</div>
					<div class="card-body p-2">
						<button class="btn btn-danger btn-sm" onclick="" data-func="" data-dismiss="modal"> Close </button>

						<button type="submit" class="btn btn-success btn-sm float-right" onclick="btnSaveUpdate(this)" >Save</button>
					</div>

				</div>
			</div>
		</div>
	</section>
	<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
	<!-- datepicker -->
	<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
	<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
	<script>
		$('.datepicker').datepicker();

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}

		});

		$('.item_name').each(function() {
			openItemAutocomplete($(this));
		});


	</script>


