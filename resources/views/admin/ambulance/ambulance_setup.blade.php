@php
    $ambulance_info_arr = isset($ambulance_info) && !empty($ambulance_info) ? $ambulance_info : '';
    $ambs_ambulance_no_pk = $ambulance_info_arr != '' ? $ambulance_info_arr['ambs_ambulance_no_pk'] : '';
    $ambs_ambulance_name = $ambulance_info_arr != '' ? $ambulance_info_arr['ambs_ambulance_name'] : ''; 
    $model_no = $ambulance_info_arr != '' ? $ambulance_info_arr['model_no'] : '';
    $lic_no = $ambulance_info_arr != '' ? $ambulance_info_arr['lic_no'] : '';
    $lic_expire_date = $ambulance_info_arr != '' ?date('d-m-Y',strtotime($ambulance_info_arr['lic_expire_date']))  : '';
    $no_plate = $ambulance_info_arr != '' ? $ambulance_info_arr['no_plate'] : '';
    $status = $ambulance_info_arr != '' ? $ambulance_info_arr['status'] : '';
@endphp
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('asset/timepicker/css/timepicker.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<main id="page-content">
    <form action="{{ route('ambulance.ambulance-setup-save') }}" method="post" id="ambulanceSetupSave">
        @csrf
        <input type="hidden" name="ambulance_id" value="{{ $ambs_ambulance_no_pk }}">
        <section class="paitent__registration_details">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row bg-white border-bottom sticky-top shadow-sm">
                            <div class="col-md-12">
                                <h5 class="mt-2 mb-0">Ambulance Setup </h5>
                                <small>Ambulance / Ambulance Setup </small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <span>Setup</span>

                            </div>
                            <div class="card-body border-bottom-3 p-2">
                                <div class="form-row">
                                    <div class="col-lg-3 col-md-3 col-12">
                                        <div class="form-group form-row">
                                            <label for="ambulance_name" class="col-sm-4 col-form-label">Ambulance Name</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control form-control-sm"
                                                    id="ambulance_name" name="ambulance_name" placeholder="Enter Name"
                                                    value="{{ $ambs_ambulance_name }}" autocomplete="off" required />
                                                
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-3 col-12">
                                        <div class="form-group form-row">
                                            <label for="model_no" class="col-sm-4 col-form-label">Model No</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control form-control-sm"
                                                    id="model_no" name="model_no" placeholder=""
                                                    value="{{ $model_no }}" autocomplete="off" required />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-12">
                                        <div class="form-group form-row">
                                            <label for="license_no" class="col-sm-4 col-form-label">License No</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control form-control-sm"
                                                    id="license_no" name="license_no" placeholder=""
                                                    value="{{ $lic_no }}" autocomplete="off" required />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-12">
                                        <div class="form-group form-row">
                                            <label for="license_expiry_date" class="col-sm-4 col-form-label">License Expiry Date</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control form-control-sm date_picker"
                                                    id="license_expiry_date" name="license_expiry_date" placeholder="dd-mm-YYYY"
                                                    value="{{ $lic_expire_date }}" autocomplete="off" required />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-3 col-12">
                                        <div class="form-group form-row">
                                            <label for="no_plate" class="col-sm-4 col-form-label">No Plate</label>
                                            <div class="col-sm-8">
                                                <input type="number" class="form-control form-control-sm "
                                                    id="no_plate" name="no_plate" placeholder=""
                                                    value="{{ $no_plate }}" autocomplete="off" required />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-12">
                                        <div class="form-group form-row">
                                            <label for="no_plate" class="col-sm-4 col-form-label">Status</label>
                                            <div class="col-sm-8">
                                                <select name="status" id="status" class="form-control form-control-sm">
                                                    <option value="1" @if($status == 1)  selected @endif>Available</option>
                                                    <option value="2" @if($status == 2)  selected @endif>En Route</option>
                                                    <option value="3" @if($status == 3)  selected @endif>Out of Service</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 text-right mt-3">
                                        @php
                                            $response_action = route('ambulance.ambulance-list');
                                        @endphp
                                        <button class="btn btn-secondary uhl_save_btn"
                                            onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">
                                            Save</button>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </section>
    </form>
</main>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('asset/timepicker/js/timepicker.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script>
    $("body").addClass("sidebar-collapse");
    $('.timepicker').timepicker({
        defaultTime: ''
    });
    $('.date_picker').datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        todayHighlight: true,
        clearBtn: true
    });
  
</script>
