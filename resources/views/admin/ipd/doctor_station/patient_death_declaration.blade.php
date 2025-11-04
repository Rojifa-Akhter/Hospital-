<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('asset/timepicker/css/timepicker.css') }}">
<link href="{{ asset('css/redactor.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<style>
	.redactor_box {
		margin-bottom: 0px;
	}
</style>

<div class="form-row">
{{-- @include('admin.components.patient_info') --}}
    <form id="death-declare-form" action="{{ route('ipd.store-patitent-death-info') }}" method="post">
        <div class="form-row">
            <input type="hidden" id="hidden_admission_no_pk" name ="hidden_admission_no_pk" value="{{$admission_id}}">
            <div class="col-md-12 pt-2">
                <div class="card p-0 m-0 border-0">
                    <div class="card-header p-0 m-0 bg-navy">Cause of Death</div>
                    <div class="card-body p-0 m-0"><textarea id="pre-ot" name ="cause_of_death"></textarea></div>
                </div>

                <div class="form-row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-form-label col-form-label-sm" for="death_date">Date Of Death</label>
                            <input type="text" class="form-control form-control-sm date_picker" id="death_date" name="death_date" value="" placeholder="dd/mm/yyyy" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-form-label col-form-label-sm" for="death_time">Death Time</label>
                            <input type="text" class="form-control form-control-sm timepicker" id="death_time" name="death_time" value="" placeholder="--:--:--" required>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="m-0 pt-2 text-right border-top">
            @php
                $response_action = route('ipd.doctor-station-received-patient');
            @endphp
            <button type="submit" onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')" class="btn btn-success btn-sm"><i class="fa fa-save"></i> Save</button>
            <button type="reset" class="btn btn-info btn-sm" title="Click here to Clear form data">Clear</button>
            <a href="{{ $response_action }}" class="btn btn-danger btn-sm" rel="tab" title="Click here to go back to Dashboard" data-dismiss="modal">Exit</a>
        </div>

    </form>
</div>
<script type="application/javascript" src="{{ asset('js/redactor.js') }}"></script>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('asset/timepicker/js/timepicker.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script>
	loadEditor("pre-ot");
	loadEditor("post-ot");

	$('.timepicker').timepicker({
		defaultTime: new Date(),
		interval: '5'
	});


	$('.date_picker').datepicker({
		format: 'dd-mm-yyyy',
		autoclose: true,
		todayHighlight: true,
		clearBtn: true
	});
	$('.select2').select2({});

</script>

