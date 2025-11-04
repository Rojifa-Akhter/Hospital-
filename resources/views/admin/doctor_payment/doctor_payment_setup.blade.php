<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('datatables/media/css/jquery.dataTables.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<main id="page-content">
    <section class="hr_payroll">
        <div class="container-fluid">
            {{-- @if (!isset($id)) --}}
            <div class="row bg-white border-bottom sticky-top shadow-sm">
                <div class="col-md-8">
                    <h5 class="mt-2 mb-0">Doctor Share Setup</h5>
                    <small>Doctor payment/Doctor Share Setup</small>
                </div>
                <div class="col-md-4 text-right">
                    <a type="button" class="btn btn-success uhl_common_btn mt-2"
                        href="{{ route('doctor-payment-worklist') }}">Doctor Share list</a>
                </div>
            </div>
            {{-- @endif --}}
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <form action="{{ route('store-doctor-payment') }}" method="post" id="doctor_payment_setup_id">
                            @csrf
                            <input type="hidden" name="docershare_no_pk"
                                value="{{ $docerShareData->docershare_no_pk ?? '' }}">
                            <div class="card-body p-2">
                                <div class="row">
                                    <div class="col-md-3 col-12">
                                        <div class="form-group">
                                            <label for="doc_name" class="col-form-label">Doctor <span style="color:red">
                                                    *</span></label>
                                            <div class="input-group">
                                                <input type="text" id="doc_name" name="doc_name"
                                                    class="form-control" value="{{ @$docerShareData->full_name }}"
                                                    autocomplete="off" required />
                                                <input type="hidden" class="form-control" id="hdn_doctor_id"
                                                    name="hdn_doctor_id" value="{{ @$docerShareData->person_no_fk }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-12">
                                        <div class="form-group">
                                            <label for="intern" class="col-form-label">Item<span style="color:red">
                                                    *</span></label>
                                            <div class="input-group">
                                                <input type="text" id="item_name" name="item_name"
                                                    value="{{ @$docerShareData->item_name }}"
                                                    class="form-control item_typehead" autocomplete="off" required />
                                                <input type="hidden" id="hdn_item_id" name="hdn_item_id"
                                                    value="{{ @$docerShareData->item_no_fk }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-12">
                                        <div class="form-group">
                                            <label for="intern" class="col-form-label">Date<span style="color:red">
                                                    *</span></label>
                                            <div class="input-group">
                                                <input type="text" id="effdate" name="effdate"
                                                    class="form-control date_picker"
                                                    value="{{ @$docerShareData->effdate ? date('d-m-Y', strtotime($docerShareData->effdate)) : '' }}"
                                                    autocomplete="off" required />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-12">
                                        <div class="form-group">
                                            <label for="intern" class="col-form-label">Patient Type<span
                                                    style="color:red"> *</span></label>
                                            <div class="input-group">
                                                <select class="form-control" name="pat_type" id="pat_type" required>
                                                    <option value="">Select</option>
                                                    <option value="IP"
                                                        {{ @$docerShareData->pat_type == 'IP' ? 'selected' : '' }}>IP
                                                    </option>
                                                    <option value="OP"
                                                        {{ @$docerShareData->pat_type == 'OP' ? 'selected' : '' }}>OP
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-12">
                                        <div class="form-group">
                                            <label for="drprcnt" class="col-form-label">Doctor Percent(%)<span
                                                    style="color:red"> *</span></label>
                                            <div class="input-group">
                                                <input type="number" id="drprcnt" name="drprcnt" class="form-control"
                                                    value="{{ @$docerShareData->drprcnt }}" autocomplete="off"
                                                    required />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-12">
                                        <div class="form-group">
                                            <label for="stfpercent" class="col-form-label">Staff Percent(%)<span
                                                    style="color:red"> *</span></label>
                                            <div class="input-group">
                                                <input type="number" id="stfpercent" name="stfpercent"
                                                    class="form-control" value="{{ @$docerShareData->stfpercent }}"
                                                    autocomplete="off" required />
                                            </div>
                                        </div>
                                    </div>
                                    @php
                                        if (isset($docerShareData)) {
                                            $response_action = route('doctor-payment-worklist');
                                        } else {
                                            $response_action = route('doctor-payment-setup');
                                        }
                                    @endphp
                                    <div class="col-md-3">
                                        <button type="button" class="btn btn-secondary uhl_common_btn mt-4"
                                            onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">
                                            {{ isset($docerShareData) ? 'Update' : 'Save' }} </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}">
</script>
<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script>
    $("body").addClass("sidebar-collapse");

    function itemInfo(item, obj) {
        if (item) {
            $("#hdn_item_id").val(item.item_id);
        } else {
            $("#hdn_item_id").val('');
        }
    }
    openDoctorAutocomplete('#doc_name', 'hdn_doctor_id', 'doctor_ind', '1');
    openBillingItemAutocompleteV1(".item_typehead", "CONS, DOCBILL,LAB, RAD", "", itemInfo);
    $(".date_picker").datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        todayHighlight: true,
        clearBtn: true,
        startDate: new Date()
    });
</script>
