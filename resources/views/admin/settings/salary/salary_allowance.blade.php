@php
$bonus = (isset($bonus) && (!empty($bonus))) ? $bonus : [];
$id= ($bonus) ? $bonus->bonus_no_pk : '';
$bonus_name= ($bonus) ? $bonus->bonus_name : '';
$bonus_amount_ind= ($bonus) ? $bonus->bonus_amount_ind : '';
$bonus_percent_ind= ($bonus) ? $bonus->bonus_percent_ind : '';
$callculate_on= ($bonus) ? $bonus->callculate_on : '';
$value_amount= ($bonus) ? $bonus->value_amount : '';
$value_percent= ($bonus) ? $bonus->value_percent : '';
$festival_bonus_ind= ($bonus) ? $bonus->festival_bonus_ind : '';
$effective_date= ($bonus) ? date('d/m/Y',strtotime( $bonus->effective_date)) : '';
@endphp
<link href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<section id="create_lookup">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-lg-12 col-xl-12">
                <form action="{{ route('salary.store') }}" method="post" id="salary-create">
                    @csrf
                    <input type="hidden" name="id" value="{{$id}}">

                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="bonus_name" class="col-md-12 col-form-label col-form-label-sm" required>Bonus Name <span class="text-danger">*</span></label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control form-control-sm" id="bonus_name" name="bonus_name" value="{{$bonus_name}}" placeholder="Enter Room Code">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="bonus_amount_ind" class="col-md-12 col-form-label col-form-label-sm">Bonus Amount IND <span class="text-danger">*</span></label>
                            <div class="col-md-12">
                                <input type="text" class="form-control form-control-sm" id="bonus_amount_ind" name="bonus_amount_ind" value="{{$bonus_amount_ind}}" placeholder="Enter Room Name">
                            </div>
                        </div>


                    </div>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="bonus_percent_ind" class="col-md-12 col-form-label col-form-label-sm">Bonus Percent IND <span class="text-danger">*</span></label>
                            <div class="col-md-12">
                                <input type="text" class="form-control form-control-sm" id="bonus_percent_ind" name="bonus_percent_ind" value="{{$bonus_percent_ind}}" placeholder="Enter Room Capacity">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="callculate_on" class="col-md-12 col-form-label col-form-label-sm">Callculate on </label>
                            <div class="col-md-12">
                                <input type="text" class="form-control form-control-sm" id="callculate_on" name="callculate_on" value="{{$callculate_on}}" placeholder="Enter Room Size">
                            </div>
                        </div>

                    </div>

                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="value_amount" class="col-md-12 col-form-label col-form-label-sm">Value Amount </label>
                            <div class="col-md-12">
                                <input type="text" class="form-control form-control-sm" id="value_amount" name="value_amount" value="{{$value_percent}}" placeholder="Enter Room Size">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="value_percent" class="col-md-12 col-form-label col-form-label-sm">Value Percent </label>
                            <div class="col-md-12">
                                <input type="text" class="form-control form-control-sm" id="value_percent" name="value_percent" value="{{$value_percent}}" placeholder="Enter Room Size">
                            </div>
                        </div>


                    </div>
                    <div class="form-group row">
                        <div class="col-md-6">

                            <label for="festival_bonus_ind" class="col-md-12 col-form-label col-form-label-sm">Effective Date </label>

                            <div class="col-md-12">
                                <input type="text" class="form-control form-control-sm date_picker" id="effective_date" name="effective_date" value="{{$effective_date}}" placeholder="dd/mm/yyyy">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <input type="checkbox" class="  ml-2 " id="festival_bonus_ind" name="festival_bonus_ind" value="1" {{$festival_bonus_ind ==1 ? 'checked' : ''}} placeholder="Enter Room Size">
                            <label for="festival_bonus_ind" class="  col-form-label col-form-label-sm">Festival Bonus IND </label>&nbsp;
                        </div>

                    </div>


                    @php
                    $doctor_id = "";
                    $response_url = route('salary.index');
                    @endphp

                    <div class="modal-footer mt-1">
                        <button type="submit" class="btn btn-md btn-success" onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_url }}')">Save changes</button>
                        <button type="button" class="btn btn-md btn-danger " data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-md btn-info " data-dismiss="modal">Exit</button>

                    </div>
                </form>
            </div>
        </div>
    </div>


</section>
<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script>
    // openDoctorAutocomplete('#user_name', 'hidn_id');
    $('.date_picker').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true,
        clearBtn: true,
        // startDate: new Date()
    });
</script>

