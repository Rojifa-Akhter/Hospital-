<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<main id="page-content">
    <section class="hr_payroll">
        <div class="container-fluid">
            <div class="row bg-white border-bottom sticky-top shadow-sm">
                <div class="col-md-12">
                    <h5 class="mt-2 mb-0">Salary Structure Setup</h5>
                    <small>Payroll Management / Payroll Setup / Salary Structure Setup</small>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <form action="{{ route('store-hospital-salary-setup') }}" method="post"
                            id="hospital_salary_id">
                            @csrf
                            <input type="hidden" name="hws_setup_no_pk" value="{{ $salaryData->hws_setup_no_pk ?? '' }}">
                            <div class="card-body p-2">
                                <div class="row mb-3">
                                    <div class="col-md-3 col-12">
                                        <div class="form-group">
                                            <label for="startday" class="col-form-label">Cut Off Start Day</label>
                                            <div class="input-group">
                                                <input type="text" id="startday" name="startday"
                                                    class="form-control number_only" placeholder="Enter start day"
                                                    value="{{ $salaryData->cut_off_strday ?? '' }}" @if (isset($salaryData->cut_off_ind) && $salaryData->cut_off_ind != 1) disabled @endif
                                                    autocomplete="off" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-12">
                                        <div class="form-group">
                                            <label for="intern" class="col-form-label">Cut Off End Day</label>
                                            <div class="input-group">
                                                <input type="text" id="endday" name="endday"
                                                    class="form-control number_only" placeholder="Enter end day"
                                                    value="{{ $salaryData->cut_off_endday ?? '' }}" @if (isset($salaryData->cut_off_ind) && $salaryData->cut_off_ind != 1) disabled @endif autocomplete="off" />

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-12">
                                        <div class="form-check mt-4">
                                            <input class="form-check-input col-form-label mt-2" type="checkbox"
                                                id="cut_off" name="cut_off"
                                                @if (isset($salaryData->cut_off_ind) && $salaryData->cut_off_ind == 1) checked @endif autocomplete="off">
                                            <label class="form-check-label col-form-label" for="cut_off">
                                                Cut Off
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3 col-12">
                                        <div class="form-group">
                                            <label for="intern" class="col-form-label">Basic Salary(%)</label>
                                            <div class="input-group">
                                                <input type="text" id="basic_salary" name="basic_salary"
                                                    class="form-control number_only cal_percentage"
                                                    placeholder="Enter basic salary"
                                                    value="{{ $salaryData->basic_salary_perc ?? '' }}" autocomplete="off"
                                                    onkeyup="handlePercentageCal()" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-12">
                                        <div class="form-group">
                                            <label for="house_rent" class="col-form-label">House Allowance(%)</label>
                                            <div class="input-group">
                                                <input type="text" id="house_rent" name="house_rent"
                                                    class="form-control number_only cal_percentage"
                                                    placeholder="Enter house rent"
                                                    value="{{ $salaryData->house_rent_perc ?? '' }}" autocomplete="off"
                                                    onkeyup="handlePercentageCal()" />

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-12">
                                        <div class="form-group">
                                            <label for="medical_allow" class="col-form-label">Medical
                                                Allowance(%)</label>
                                            <div class="input-group">
                                                <input type="text" id="medical_allowance" name="medical_allowance"
                                                    class="form-control number_only cal_percentage"
                                                    placeholder="Enter medical allowance"
                                                    value="{{ $salaryData->medical_allow_perc ?? '' }}" autocomplete="off"
                                                    onkeyup="handlePercentageCal()" />

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-12">
                                        <div class="form-group">
                                            <label for="intern" class="col-form-label">Transport Allowance(%)</label>
                                            <div class="input-group">
                                                <input type="text" id="transport_allowance"
                                                    name="transport_allowance"
                                                    class="form-control number_only cal_percentage"
                                                    placeholder="Enter transport allowance"
                                                    value="{{ $salaryData->ta_da_perc ?? '' }}" autocomplete="off"
                                                    onkeyup="handlePercentageCal()" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-12">
                                        <div class="form-group">
                                            <label for="utility" class="col-form-label">Utility(%)</label>
                                            <div class="input-group">
                                                <input type="text" id="utility" name="utility"
                                                    class="form-control number_only cal_percentage"
                                                    placeholder="Enter utility"
                                                    value="{{ $salaryData->utility_allow_perc ?? '' }}" autocomplete="off"
                                                    onkeyup="handlePercentageCal()" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-12">
                                        <div class="form-group">
                                            <label for="intern" class="col-form-label">Conveyance
                                                Allowance(%)</label>
                                            <div class="input-group">
                                                <input type="text" id="conveyance_allowance"
                                                    name="conveyance_allowance"
                                                    class="form-control number_only cal_percentage"
                                                    placeholder="Enter conveyance allowance"
                                                    value="{{ $salaryData->conveyance_allow_perc ?? '' }}"
                                                    autocomplete="off" onkeyup="handlePercentageCal()" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-12">
                                        <div class="form-group">
                                            <label for="intern" class="col-form-label">Entertainment(%)</label>
                                            <div class="input-group">
                                                <input type="text" id="entertainment" name="entertainment"
                                                    class="form-control number_only cal_percentage"
                                                    placeholder="Enter transport allowance"
                                                    value="{{ $salaryData->entertainment_perc ?? '' }}" autocomplete="off"
                                                    onkeyup="handlePercentageCal()" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-12">
                                        <div class="form-group">
                                            <label for="festival_bonus" class="col-form-label">Festival
                                                Bonus(%)</label>
                                            <div class="input-group">
                                                <input type="text" id="festival_bonus" name="festival_bonus"
                                                    class="form-control number_only cal_percentage"
                                                    placeholder="Enter festival bonus"
                                                    value="{{ $salaryData->festival_bonus_perc ?? '' }}" autocomplete="off"
                                                    onkeyup="handlePercentageCal()" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-12">
                                        <div class="form-group">
                                            <label for="festival_bonus" class="col-form-label">Critical 
                                                Allowance(%)</label>
                                            <div class="input-group">
                                                <input type="text" id="critical_allowance" name="critical_allowance"
                                                    class="form-control number_only cal_percentage"
                                                    placeholder="Enter critical allowance"
                                                    value="{{ $salaryData->ca_perc ?? '' }}" autocomplete="off"
                                                    onkeyup="handlePercentageCal()" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-12">
                                        <div class="form-group">
                                            <label for="special_allowance" class="col-form-label">Special 
                                                Allowance(%)</label>
                                            <div class="input-group">
                                                <input type="text" id="special_allowance" name="special_allowance"
                                                    class="form-control number_only cal_percentage"
                                                    placeholder="Enter special allowance"
                                                    value="{{ $salaryData->sa_perc ?? '' }}" autocomplete="off"
                                                    onkeyup="handlePercentageCal()" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-12">
                                        <div class="form-group">
                                            <label for="incharge_allowance" class="col-form-label">Incharge 
                                                Allowance(%)</label>
                                            <div class="input-group">
                                                <input type="text" id="incharge_allowance" name="incharge_allowance"
                                                    class="form-control number_only cal_percentage"
                                                    placeholder="Enter special allowance"
                                                    value="{{ $salaryData->ica_prea ?? '' }}" autocomplete="off"
                                                    onkeyup="handlePercentageCal()" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-12">
                                        <div class="form-group">
                                            <label for="risk_allowance" class="col-form-label">Risk 
                                                Allowance(%)</label>
                                            <div class="input-group">
                                                <input type="text" id="risk_allowance" name="risk_allowance"
                                                    class="form-control number_only cal_percentage"
                                                    placeholder="Enter risk allowance"
                                                    value="{{ $salaryData->ra_prec ?? '' }}" autocomplete="off"
                                                    onkeyup="handlePercentageCal()" />
                                            </div>
                                        </div>
                                    </div>
                                    {{-- <div class="col-md-3 col-12">
                                        <div class="form-group">
                                            <label for="intern" class="col-form-label">Others(%)</label>
                                            <div class="input-group">
                                                <input type="text" id="others"
                                                    name="others"
                                                    class="form-control number_only cal_percentage"
                                                    placeholder="Enter transport allowance"
                                                    value="{{ $salaryData->ta_da_perc }}" autocomplete="off" onkeyup="handlePercentageCal()"/>
                                            </div>
                                        </div>
                                    </div> --}}
                                    @php
                                        $total_percentage = 0;
                                        if(isset($salaryData)) {
                                            $total_percentage = $salaryData->basic_salary_perc + $salaryData->house_rent_perc + $salaryData->medical_allow_perc  + $salaryData->ta_da_perc  + $salaryData->utility_allow_perc + $salaryData->entertainment_perc + $salaryData->conveyance_allow_perc + $salaryData->festival_bonus_perc + $salaryData->ca_perc + $salaryData->sa_perc + $salaryData->ica_prea + $salaryData->ra_prec;
                                        }
                                    @endphp
                                    <input type="hidden" name="total_percentage" id="total_percentage" value="{{$total_percentage}}">
                                    @php
                                        $response_action = route('hospital-salary-setup');
                                    @endphp
                                    <div class="col-md-12 text-right">
                                        <button type="button" class="btn btn-secondary uhl_common_btn mt-4"
                                            {{-- onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')" id --}}>Save</button>
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
<script>
    $("body").addClass("sidebar-collapse");
    // alert(isNullOrUndefinedOrNaN(5));
    var cut_off_val = document.querySelector('#cut_off');
    cut_off_val.addEventListener('change', function(element) {
        if (cut_off_val.checked == true) {
            document.querySelector('#startday').disabled = false;
            document.querySelector('#endday').disabled = false;
        } else {
            document.querySelector('#startday').disabled = true;
            document.querySelector('#endday').disabled = true;
        }
    })
    function handlePercentageCal() {
        let basic_salary = isNullOrUndefinedOrNaN(document.querySelector('#basic_salary').value) ? 0 : parseFloat(
            document.querySelector('#basic_salary').value);
        let house_rent = isNullOrUndefinedOrNaN(document.querySelector('#house_rent').value) ? 0 : parseFloat(document
            .querySelector('#house_rent').value);
        let medical_allowance = isNullOrUndefinedOrNaN(document.querySelector('#medical_allowance').value) ? 0 :
            parseFloat(document.querySelector('#medical_allowance').value);
        let transport_allowance = isNullOrUndefinedOrNaN(document.querySelector('#transport_allowance').value) ? 0 :
            parseFloat(document.querySelector('#transport_allowance').value);
        let utility = isNullOrUndefinedOrNaN(document.querySelector('#utility').value) ? 0 : parseFloat(document
            .querySelector('#utility').value);
        let conveyance_allowance = isNullOrUndefinedOrNaN(document.querySelector('#conveyance_allowance').value) ? 0 :
            parseFloat(document.querySelector('#conveyance_allowance').value);
        let entertainment = isNullOrUndefinedOrNaN(document.querySelector('#entertainment').value) ? 0 : parseFloat(
            document.querySelector('#entertainment').value);
        let festival_bonus = isNullOrUndefinedOrNaN(document.querySelector('#festival_bonus').value) ? 0 : parseFloat(
            document.querySelector('#festival_bonus').value);
        let critical_allowance = isNullOrUndefinedOrNaN(document.querySelector('#critical_allowance').value) ? 0 : parseFloat(
            document.querySelector('#critical_allowance').value);
        let special_allowance = isNullOrUndefinedOrNaN(document.querySelector('#special_allowance').value) ? 0 : parseFloat(document.querySelector('#special_allowance').value);
        let incharge_allowance = isNullOrUndefinedOrNaN(document.querySelector('#incharge_allowance').value) ? 0 : parseFloat(document.querySelector('#incharge_allowance').value);
        let risk_allowance = isNullOrUndefinedOrNaN(document.querySelector('#risk_allowance').value) ? 0 : parseFloat(
            document.querySelector('#risk_allowance').value);
        // let others = isNullOrUndefinedOrNaN(document.querySelector('#others').value) ? 0 : parseFloat(document.querySelector('#others').value);
        let totalPercentage = Math.round(basic_salary + house_rent + medical_allowance + transport_allowance + utility +
            conveyance_allowance + entertainment + festival_bonus + critical_allowance + special_allowance + incharge_allowance + risk_allowance);
        document.querySelector('#total_percentage').value = totalPercentage;
        if (totalPercentage > 100) {
            alert('Total percentage can not be greater than 100')
            return false;
        }
    }

    document.querySelector('.uhl_common_btn').addEventListener('click', function(e) {
        
        let startday = isNullOrUndefinedOrNaN(document.querySelector('#startday').value) ? 0 : parseInt(document
            .querySelector('#startday').value);
        let endday = isNullOrUndefinedOrNaN(document.querySelector('#endday').value) ? 0 : parseInt(document
            .querySelector('#endday').value);
        let cut_off = document.querySelector('#cut_off').checked;
        let totalPercentage = document.querySelector('#total_percentage').value;
        // alert(totalPercentage);

        if (cut_off && (startday <= endday || !(startday - endday == 1))) {
            alert('Invalid Cut Off Days');
            return false;
        } else if (totalPercentage > 100 || totalPercentage < 100) {
            alert('Total percentage must be equal to 100');
            return false;
        } else {
            btnSaveUpdateUpload(e.target, '', '', '', '', dynamicFunc.afterSaveLoadPage,
                '{{ $response_action }}')
        }
    })
</script>
