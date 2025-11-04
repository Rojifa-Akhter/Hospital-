  <div class="form-row">

            <div class="col-sm-2">
                <label for="attendence_bonus" class=" col-form-label col-form-label-sm">Gross Salary</label>

                <!-- <div class="form-row"> -->

                    <div class="input-group flex-nowrap">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="addon-wrapping">Amt</span>
                        </div>

                        <input type="text" class="form-control form-control-sm " id="gross_salary" name="gross_salary" value="{{isset($grade_amt) ? intval($grade_amt->gross_salary) : ''}}{{!empty($gross_salary) ? intval($gross_salary) : ''}}" placeholder="0.00" maxlength="10">

                    </div>


                <!-- </div>   -->
            </div>

            <div class="col-sm-4">
                <label for="medical_allowance" class=" col-form-label col-form-label-sm"> Basic Salary  </label>

                <div class="form-row">
                    <div class="col-sm-6">
                        <div class="input-group flex-nowrap">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="addon-wrapping">%</span>
                            </div>
                            <input type="text" class="form-control form-control-sm percent" id="basic_salary_per" name="basic_salary_per" value="{{isset($grade_amt) ? $grade_amt->basic_salary_perc : ''}}{{!empty($basic_salary_perc) ? $basic_salary_perc : ''}}" placeholder="0.00" maxlength="10" onkeyup="calculateAmt(this)">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="input-group flex-nowrap">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="addon-wrapping">Amt</span>
                            </div>
                            <input type="text" class="form-control form-control-sm sum number_only amount" id="basic_salary" name="basic_salary" value="{{isset($grade_amt) ? intval($grade_amt->basic_salary) : ''}}{{!empty($basic_salary) ? intval($basic_salary) : ''}}" placeholder="0.00" maxlength="10" onkeyup="calculateAmtOnValue(this)">
                        </div>
                    </div>

                </div>
            </div>


        </div>

        <div class="form-group row">
            <div class="col-sm-4">
                <label for="medical_allowance" class=" col-form-label col-form-label-sm">Medical Allowance </label>

                <div class="form-row">
                    <div class="col-sm-6">
                        <div class="input-group flex-nowrap">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="addon-wrapping">%</span>
                            </div>
                            <input type="text" class="form-control form-control-sm percent" id="medical_allowance_per" name="medical_allowance_per" value="{{isset($grade_amt) ? $grade_amt->medical_allow_perc : ''}}{{!empty($medical_allow_perc) ? $medical_allow_perc : ''}}" placeholder="0.00" maxlength="10" onkeyup="calculateAmt(this)">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="input-group flex-nowrap">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="addon-wrapping">Amt</span>
                            </div>
                            <input type="text" class="form-control form-control-sm sum number_only amount" id="medical_allowance" name="medical_allowance" value="{{isset($grade_amt) ? intval($grade_amt->medical_allow) : ''}}{{!empty($medical_allow) ? intval($medical_allow) : ''}}" placeholder="0.00" maxlength="10" onkeyup="calculateAmtOnValue(this)">
                        </div>
                    </div>

                </div>
            </div>


            <div class="col-sm-4">
                <label for="house_rent" class=" col-form-label col-form-label-sm">House Rent </label>


                <div class="form-row">
                    <div class="col-sm-6">
                        <div class="input-group flex-nowrap">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="addon-wrapping">%</span>
                            </div>
                            <input type="text" class="form-control form-control-sm percent" id="house_rent_per" name="house_rent_per" value="{{isset($grade_amt) ? $grade_amt->house_rent_perc : ''}}{{!empty($house_rent_perc) ? $house_rent_perc : ''}}" placeholder="0.00" maxlength="10" onkeyup="calculateAmt(this)">
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="input-group flex-nowrap">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="addon-wrapping">Amt</span>
                            </div>
                            <input type="text" class="form-control form-control-sm sum number_only amount" id="house_rent" name="house_rent" value="{{isset($grade_amt) ? intval($grade_amt->house_rent) : ''}}{{!empty($house_rent) ? intval($house_rent) : ''}}" placeholder="0.00" maxlength="10" onkeyup="calculateAmtOnValue(this)">
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-sm-4">
                <label for="" class=" col-form-label col-form-label-sm">Utility</label>
                <div class="form-row">
                    <div class="col-sm-6">
                        <div class="input-group flex-nowrap">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="addon-wrapping">%</span>
                            </div>
                            <input type="text" class="form-control form-control-sm percent" id="utility_per" name="utility_per" value="{{isset($grade_amt) ? $grade_amt->utility_perc : ''}}{{!empty($utility_allow_perc) ? $utility_allow_perc : ''}}" placeholder="0.00" maxlength="10" onkeyup="calculateAmt(this)">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="input-group flex-nowrap">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="addon-wrapping">Amt</span>
                            </div>
                            <input type="text" class="form-control form-control-sm sum number_only amount" id="utility" name="utility" value="{{isset($grade_amt) ? intval($grade_amt->utility) : ''}}{{!empty($utility_allow) ? intval($utility_allow) : ''}}" placeholder="0.00" maxlength="10" onkeyup="calculateAmtOnValue(this)">
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm-4">
                <label for="Conveyance_allowance" class=" col-form-label col-form-label-sm">Conveyance Allowance </label>
                <div class="form-row">
                    <div class="col-sm-6">
                        <div class="input-group flex-nowrap">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="addon-wrapping">%</span>
                            </div>
                            <input type="text" class="form-control form-control-sm percent" id="conveyance_allowance_per" name="conveyance_allowance_per" value="{{isset($grade_amt) ? $grade_amt->conveyance_allow_perc : ''}}{{!empty($conveyance_allow_perc) ? $conveyance_allow_perc : ''}}" placeholder="0.00" maxlength="10" onkeyup="calculateAmt(this)">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="input-group flex-nowrap">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="addon-wrapping">Amt</span>
                            </div>
                            <input type="text" class="form-control form-control-sm sum number_only amount" id="conveyance_allowance" name="conveyance_allowance" value="{{isset($grade_amt) ? intval($grade_amt->conveyance_allow) : ''}}{{!empty($conveyance_allow) ? intval($conveyance_allow) : ''}}" placeholder="0.00" maxlength="10" onkeyup="calculateAmtOnValue(this)">
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-sm-4">
                <label for="house_rent" class=" col-form-label col-form-label-sm">Entertainment </label>


                <div class="form-row">
                    <div class="col-sm-6">
                        <div class="input-group flex-nowrap">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="addon-wrapping">%</span>
                            </div>
                            <input type="text" class="form-control form-control-sm percent" id="entertainment_per" name="entertainment_per" value="{{isset($grade_amt) ? $grade_amt->entertainment_perc : ''}}{{!empty($entertainment_perc) ? $entertainment_perc : ''}}" placeholder="0.00" maxlength="10" onkeyup="calculateAmt(this)">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="input-group flex-nowrap">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="addon-wrapping">Amt</span>
                            </div>
                            <input type="text" class="form-control form-control-sm sum number_only amount" id="entertainment" name="entertainment" value="{{isset($grade_amt) ? intval($grade_amt->entertainment) : ''}}{{!empty($entertainment) ? intval($entertainment) : ''}}" placeholder="0.00" maxlength="10" onkeyup="calculateAmtOnValue(this)">
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-sm-4">

                <label for="attendence_bonus" class=" col-form-label col-form-label-sm">Festival Bonus</label>
                <div class="form-row">
                    <div class="col-sm-6">
                        <div class="input-group flex-nowrap">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="addon-wrapping">%</span>
                            </div>
                            <input type="text" class="form-control form-control-sm percent" id="festival_bonus_per" name="festival_bonus_per" value="{{isset($grade_amt) ? $grade_amt->festival_bonus_perc : ''}}{{!empty($festival_bonus_perc) ? $festival_bonus_perc : ''}}" placeholder="0.00" maxlength="10" onkeyup="calculateAmt(this)">
                        </div>
                    </div>
                    <div class="col-sm-6">

                        <div class="input-group flex-nowrap">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="addon-wrapping">Amt</span>
                            </div>
                            <input type="text" class="form-control form-control-sm sum number_only amount" id="festival_bonus" name="festival_bonus" value="{{isset($grade_amt) ? intval($grade_amt->festival_bonus) : ''}}{{!empty($festival_bonus) ? intval($festival_bonus) : ''}}" placeholder="0.00" maxlength="10" onkeyup="calculateAmtOnValue(this)">
                        </div>
                    </div>

                </div>
            </div>


        </div>
        <div class="form-row">

            <div class="col-sm-4">
                <label for="Conveyance_allowance" class=" col-form-label col-form-label-sm">TA/DA</label>
                <div class="form-row">
                    <div class="col-sm-6">
                        <div class="input-group flex-nowrap">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="addon-wrapping">%</span>
                                
                            </div>
                            <input type="text" class="form-control form-control-sm percent" id="ta_da_per" name="ta_da_per" value="{{isset($grade_amt) ? $grade_amt->ta_da_perc : ''}}{{!empty($ta_da_perc) ? $ta_da_perc : ''}}" placeholder="0.00" maxlength="10" onkeyup="calculateAmt(this)">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="input-group flex-nowrap">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="addon-wrapping">Amt</span>
                            </div>
                            <input type="text" class="form-control form-control-sm sum number_only amount" id="ta_da" name="ta_da" value="{{isset($grade_amt) ? intval($grade_amt->ta_da) : ''}}{{!empty($ta_da) ? intval($ta_da) : ''}}" placeholder="0.00" maxlength="10" onkeyup="calculateAmtOnValue(this)">
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-sm-2">
                <label for="attendence_bonus" class=" col-form-label col-form-label-sm">Attendence Bonus</label>

                <div class="form-row">
                    <div class="col-sm-12">
                        <div class="input-group flex-nowrap">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="addon-wrapping">Amt</span>
                            </div>
                            <input type="text" class="form-control form-control-sm sum number_only " id="attendance_bonus" name="attendance_bonus" value="{{isset($grade_amt) ? intval($grade_amt->attendance_bonus) : ''}}{{!empty($attendance_bonus) ? intval($attendance_bonus) : ''}}" placeholder="0.00" maxlength="10">
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-sm-4">
                <label for="other_allowance" class=" col-form-label col-form-label-sm">Others</label>

                <div class="form-row">
                    <div class="col-sm-6">
                        <div class="input-group flex-nowrap">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="addon-wrapping">%</span>
                            </div>
                            <input type="text" class="form-control form-control-sm percent" id="other_allow_perc" name="other_allow_perc" value="{{isset($grade_amt) ? $grade_amt->other_allow_perc : ''}}{{!empty($other_allow_perc) ? $other_allow_perc : ''}}" placeholder="0.00" maxlength="10" onkeyup="calculateAmt(this)">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="input-group flex-nowrap">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="addon-wrapping">Amt</span>
                            </div>
                            <input type="text" class="form-control form-control-sm sum number_only " id="other_allowance" name="other_allowance" value="{{!empty($other_allow) ? intval($other_allow) : ''}}" placeholder="0.00" maxlength="10" onkeyup="calculateAmtOnValue(this)">
                        </div>
                    </div>

                </div>
            </div>
        </div>
