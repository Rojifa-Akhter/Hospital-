<div class="form-group row pb-3">
    <div class="col-sm-4">
        <label for="gross_salary" class=" col-form-label col-form-label-sm">Gross Salary<span
                style="color:red; font-weight:bold"> *</span></label>
        <div class="input-group flex-nowrap">
            <div class="input-group-prepend">
                <span class="input-group-text" id="addon-wrapping">Amt</span>
            </div>
            <input type="text" class="form-control form-control-sm" id="gross_salary" name="gross_salary"
                value="{{isset($salaryInfo->gross_salary) ? $salaryInfo->gross_salary : ''}}"
                maxlength="10" autocomplete="off" required onkeyup="handleGrossSalary(this)" @if(isset($gradeStatus) && $gradeStatus == '1') readonly @endif>
        </div>
    </div>
    <div class="col-sm-4">
        <label for="medical_allowance" class=" col-form-label col-form-label-sm">Basic Salary </label>
        <div class="form-row">
            <div class="col-sm-5">
                <div class="input-group flex-nowrap">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="addon-wrapping">%</span>
                    </div>
                    <input type="text" class="form-control form-control-sm percent getDisable" id="basic_salary_per"
                        name="basic_salary_per"
                        value="{{isset($salaryInfo->basic_salary_perc) ? $salaryInfo->basic_salary_perc : ''}}"
                        maxlength="10" autocomplete="off" onkeyup="handleSalaryPerc(this)">
                </div>
            </div>
            <div class="col-sm-7">
                <div class="input-group flex-nowrap">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="addon-wrapping">Amt</span>
                    </div>
                    <input type="text" class="form-control form-control-sm sum number_only amount getDisable"
                        id="basic_salary" name="basic_salary"
                        value="{{isset($salaryInfo->basic_salary) ? $salaryInfo->basic_salary : ''}}"
                        maxlength="10" autocomplete="off" readonly>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <label for="house_rent" class=" col-form-label col-form-label-sm">House Rent </label>
        <div class="form-row">
            <div class="col-sm-5">
                <div class="input-group flex-nowrap">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="addon-wrapping">%</span>
                    </div>
                    <input type="text" class="form-control form-control-sm percent getDisable" id="house_rent_per"
                        name="house_rent_per" maxlength="10" autocomplete="off" value="{{isset($salaryInfo->house_rent_perc) ? $salaryInfo->house_rent_perc : ''}}" onkeyup="handleSalaryPerc(this)">
                </div>
            </div>
            <div class="col-sm-7">
                <div class="input-group flex-nowrap">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="addon-wrapping">Amt</span>
                    </div>
                    <input type="text" class="form-control form-control-sm sum number_only amount getDisable"
                        id="house_rent" name="house_rent" maxlength="10" autocomplete="off" value="{{isset($salaryInfo->house_rent) ? $salaryInfo->house_rent : ''}}" readonly>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <label for="medical_allowance" class="col-form-label col-form-label-sm">Medical Allowance </label>
        <div class="form-row">
            <div class="col-sm-5">
                <div class="input-group flex-nowrap">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="addon-wrapping">%</span>
                    </div>
                    <input type="text" class="form-control form-control-sm percent getDisable" id="medical_allowance_per"
                        name="medical_allowance_per"  maxlength="10" autocomplete="off" value="{{isset($salaryInfo->medical_allow_perc) ? $salaryInfo->medical_allow_perc : ''}}" onkeyup="handleSalaryPerc(this)">
                </div>
            </div>
            <div class="col-sm-7">
                <div class="input-group flex-nowrap">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="addon-wrapping">Amt</span>
                    </div>
                    <input type="text" class="form-control form-control-sm sum number_only amount getDisable"
                        id="medical_allowance" name="medical_allowance" maxlength="10" autocomplete="off" value="{{isset($salaryInfo->medical_allow) ? $salaryInfo->medical_allow : ''}}" readonly>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <label for="Conveyance_allowance" class=" col-form-label col-form-label-sm">TA/DA</label>
        <div class="form-row">
            <div class="col-sm-5">
                <div class="input-group flex-nowrap">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="addon-wrapping">%</span>
                    </div>
                    <input type="text" class="form-control form-control-sm percent getDisable" id="ta_da_per"
                        name="ta_da_per" maxlength="10" autocomplete="off" value="{{isset($salaryInfo->ta_da_perc) ? $salaryInfo->ta_da_perc : ''}}" onkeyup="handleSalaryPerc(this)">
                </div>
            </div>
            <div class="col-sm-7">
                <div class="input-group flex-nowrap">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="addon-wrapping">Amt</span>
                    </div>
                    <input type="text" class="form-control form-control-sm sum number_only amount getDisable"
                        id="ta_da" name="ta_da" maxlength="10" autocomplete="off" value="{{isset($salaryInfo->ta_da) ? $salaryInfo->ta_da : ''}}" readonly>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <label for="Conveyance_allowance" class=" col-form-label col-form-label-sm">Conveyance Allowance </label>
        <div class="form-row">
            <div class="col-sm-5">
                <div class="input-group flex-nowrap">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="addon-wrapping">%</span>
                    </div>
                    <input type="text" class="form-control form-control-sm percent getDisable"
                        id="conveyance_allowance_per" name="conveyance_allowance_per" maxlength="10"
                        autocomplete="off" value="{{isset($salaryInfo->conveyance_allow_perc) ? $salaryInfo->conveyance_allow_perc : ''}}" onkeyup="handleSalaryPerc(this)">
                </div>
            </div>
            <div class="col-sm-7">
                <div class="input-group flex-nowrap">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="addon-wrapping">Amt</span>
                    </div>
                    <input type="text" class="form-control form-control-sm sum number_only amount getDisable"
                        id="conveyance_allowance" name="conveyance_allowance" maxlength="10" autocomplete="off" value="{{isset($salaryInfo->conveyance_allow) ? $salaryInfo->conveyance_allow : ''}}" readonly>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <label for="" class=" col-form-label col-form-label-sm">Utility</label>
        <div class="form-row">
            <div class="col-sm-5">
                <div class="input-group flex-nowrap">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="addon-wrapping">%</span>
                    </div>
                    <input type="text" class="form-control form-control-sm percent getDisable" id="utility_per"
                        name="utility_per" maxlength="10" autocomplete="off" value="{{isset($salaryInfo->utility_allow_perc) ? $salaryInfo->utility_allow_perc : ''}}" onkeyup="handleSalaryPerc(this)">
                </div>
            </div>
            <div class="col-sm-7">
                <div class="input-group flex-nowrap">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="addon-wrapping">Amt</span>
                    </div>
                    <input type="text" class="form-control form-control-sm sum number_only amount getDisable"
                        id="utility" name="utility" maxlength="10" autocomplete="off" value="{{isset($salaryInfo->utility_allow) ? $salaryInfo->utility_allow : ''}}" readonly>
                </div>
            </div>

        </div>
    </div>
    <div class="col-sm-4">
        <label for="attendence_bonus" class=" col-form-label col-form-label-sm">Festival Bonus</label>
        <div class="form-row">
            <div class="col-sm-5">
                <div class="input-group flex-nowrap">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="addon-wrapping">%</span>
                    </div>
                    <input type="text" class="form-control form-control-sm percent getDisable" id="festival_bonus_per"
                        name="festival_bonus_per" maxlength="10" autocomplete="off" value="{{isset($salaryInfo->festival_bonus_perc) ? $salaryInfo->festival_bonus_perc : ''}}" onkeyup="handleSalaryPerc(this)">
                </div>
            </div>
            <div class="col-sm-7">
                <div class="input-group flex-nowrap">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="addon-wrapping">Amt</span>
                    </div>
                    <input type="text" class="form-control form-control-sm sum number_only amount getDisable"
                        id="festival_bonus" name="festival_bonus" maxlength="10" autocomplete="off" value="{{isset($salaryInfo->festival_bonus) ? $salaryInfo->festival_bonus : ''}}" readonly>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <label for="house_rent" class=" col-form-label col-form-label-sm">Entertainment </label>
        <div class="form-row">
            <div class="col-sm-5">
                <div class="input-group flex-nowrap">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="addon-wrapping">%</span>
                    </div>
                    <input type="text" class="form-control form-control-sm percent getDisable" id="entertainment_per"
                        name="entertainment_per" maxlength="10" autocomplete="off" value="{{isset($salaryInfo->entertainment_perc) ? $salaryInfo->entertainment_perc : ''}}" onkeyup="handleSalaryPerc(this)">
                </div>
            </div>
            <div class="col-sm-7">
                <div class="input-group flex-nowrap">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="addon-wrapping">Amt</span>
                    </div>
                    <input type="text" class="form-control form-control-sm sum number_only amount getDisable"
                        id="entertainment" name="entertainment" maxlength="10" autocomplete="off" value="{{isset($salaryInfo->entertainment) ? $salaryInfo->entertainment : ''}}" readonly>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <label for="critical" class=" col-form-label col-form-label-sm">Critical Allowance </label>
        <div class="form-row">
            <div class="col-sm-5">
                <div class="input-group flex-nowrap">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="addon-wrapping">%</span>
                    </div>
                    <input type="text" class="form-control form-control-sm percent getDisable" id="critical_per"
                        name="critical_per" maxlength="10" autocomplete="off" value="{{isset($salaryInfo->ca_perc) ? $salaryInfo->ca_perc : ''}}" onkeyup="handleSalaryPerc(this)">
                </div>
            </div>
            <div class="col-sm-7">
                <div class="input-group flex-nowrap">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="addon-wrapping">Amt</span>
                    </div>
                    <input type="text" class="form-control form-control-sm sum number_only amount getDisable"
                        id="critical" name="critical" maxlength="10" autocomplete="off" value="{{isset($salaryInfo->ca_sal) ? $salaryInfo->ca_sal : ''}}" readonly>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <label for="special" class=" col-form-label col-form-label-sm">Special Allowance </label>
        <div class="form-row">
            <div class="col-sm-5">
                <div class="input-group flex-nowrap">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="addon-wrapping">%</span>
                    </div>
                    <input type="text" class="form-control form-control-sm percent getDisable" id="special_per"
                        name="special_per" maxlength="10" autocomplete="off" value="{{isset($salaryInfo->sa_perc) ? $salaryInfo->sa_perc : ''}}" onkeyup="handleSalaryPerc(this)">
                </div>
            </div>
            <div class="col-sm-7">
                <div class="input-group flex-nowrap">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="addon-wrapping">Amt</span>
                    </div>
                    <input type="text" class="form-control form-control-sm sum number_only amount getDisable"
                        id="special" name="special" maxlength="10" autocomplete="off" value="{{isset($salaryInfo->sa_sal) ? $salaryInfo->sa_sal : ''}}" readonly>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <label for="incharge" class=" col-form-label col-form-label-sm">Incharge Allowance </label>
        <div class="form-row">
            <div class="col-sm-5">
                <div class="input-group flex-nowrap">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="addon-wrapping">%</span>
                    </div>
                    <input type="text" class="form-control form-control-sm percent getDisable" id="incharge_per"
                        name="incharge_per" maxlength="10" autocomplete="off" value="{{isset($salaryInfo->ica_prea) ? $salaryInfo->ica_prea : ''}}" onkeyup="handleSalaryPerc(this)">
                </div>
            </div>
            <div class="col-sm-7">
                <div class="input-group flex-nowrap">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="addon-wrapping">Amt</span>
                    </div>
                    <input type="text" class="form-control form-control-sm sum number_only amount getDisable"
                        id="incharge" name="incharge" maxlength="10" autocomplete="off" value="{{isset($salaryInfo->ica_sal) ? $salaryInfo->ica_sal : ''}}" readonly>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <label for="risk" class=" col-form-label col-form-label-sm">Risk Allowance </label>
        <div class="form-row">
            <div class="col-sm-5">
                <div class="input-group flex-nowrap">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="addon-wrapping">%</span>
                    </div>
                    <input type="text" class="form-control form-control-sm percent getDisable" id="risk_per"
                        name="risk_per" maxlength="10" autocomplete="off" value="{{isset($salaryInfo->ra_prec) ? $salaryInfo->ra_prec : ''}}" onkeyup="handleSalaryPerc(this)">
                </div>
            </div>
            <div class="col-sm-7">
                <div class="input-group flex-nowrap">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="addon-wrapping">Amt</span>
                    </div>
                    <input type="text" class="form-control form-control-sm sum number_only amount getDisable"
                        id="risk" name="risk" maxlength="10" autocomplete="off" value="{{isset($salaryInfo->ra_sal) ? $salaryInfo->ra_sal : ''}}" readonly>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function handleSalaryPerc(element) {
        let id = element.id;
        let underscoreCount = (id.match(/_/g) || []).length;
        let cutBy = Math.min(underscoreCount, 2); 
        let parts = id.split("_");
        let amount_id = parts.slice(0, cutBy).join("_");
        let gross_salary = parseFloat($('#gross_salary').val());
        let basic_salary_per = parseFloat($('#'+id).val());
        let basic_salary_val = parseFloat(basic_salary_per / 100);
        let basic_salary_amt = Math.round(gross_salary * basic_salary_val);
        $('#' + amount_id).val(!isNaN(basic_salary_amt) ? basic_salary_amt : 0);
    }
</script>
