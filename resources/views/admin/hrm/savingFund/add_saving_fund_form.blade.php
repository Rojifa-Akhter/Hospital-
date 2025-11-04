@php
    $name = (isset($name) && (!empty($name))) ? $name : [];
     $full_name = ($name) ? $name->full_name : '';
    $savingFund = (isset($savingFund) && (!empty($savingFund))) ? $savingFund : [];
    $person_no_fk = ($savingFund) ? $savingFund->person_no_fk : '';
    $personal_savings_amount = ($savingFund) ? $savingFund->personal_savings_amount : '';
    $salary_yyyymm = ($savingFund) ? $savingFund->salary_yyyymm : '';
    $monthly_save_fund_no_pk = ($savingFund) ? $savingFund-> monthly_save_fund_no_pk : '';



    $arr2 =(!empty($salary_yyyymm)) ? str_split($salary_yyyymm, 4) : '';


@endphp
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('asset/timepicker/css/timepicker.css') }}">

<form action="{{ route('hrm.saving-fund-store') }}" method="post" id="saving-fund">
@csrf
    <input type="hidden" name="savings_id" id="savingFund" value="{{$monthly_save_fund_no_pk}}">

    <div class="col-md-12">
        <div class="row">
            <div class="col-lg-3 col-md-6">
                <div class="form-group">
                    <div class="col-md-12">
                        <div class="row">
                            <label for="card_no" class="col-form-label col-form-label-sm">Employee Id <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm m-0 keep_me hidden_class" id="employee_id" name="employee_code" value="{{$full_name}}" placeholder="Employee Code/Name/Phone Number" required/>
                            <input type="hidden" class="keep_me" id="hdn_employee_id_0" name="card_num" value="{{$person_no_fk}}" >
                            @error('employee_id')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="form-group">

                    <label for="value_amount" class="col-form-label col-form-label-sm ">Amount<span class="text-danger">*</span></label>
                    <div class="col-md-12">
                        <div class="row justify-content-center">
                            <input type="text"
                                   class="form-control form-control-sm m-0 number_only"
                                   id="value_amount" name="amount" placeholder="Value Amount" value="{{$personal_savings_amount}}" maxlength="10" required>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="form-group">

                    <label for="year" class=" col-form-label">Year <span class="text-danger">*</span></label>
                    <select class="form-control font_size_12 m-auto hidden_class" id="year" name="year" required>
                        <option value="">Select Year</option>
                        @php
                            $date=date('Y');

                        @endphp

                        @for($i=($date-2); $i<($date+3); $i++) <option value="{{$i}}"  @<?php if (!empty($arr2)): ?>
                          {{($arr2[0] == $i ) ? 'selected' : ''}}
                                    <?php endif ?>  >{{$i}}</option>
                        @endfor
                    </select>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="form-group">

                    <label for="year" class="col-form-label">Month <span class="text-danger">*</span></label>
                    <select class="form-control font_size_12 m-auto hidden_class" id="month" name="month" width="200px" required>
                        <option value="">Select Month</option>
                        <option value="01" @<?php if (!empty($arr2)): ?>
                            {{($arr2[1] == '1' ) ? 'selected' : ''}}
                                    <?php endif ?> >January
                        </option>
                        <option value="02" @<?php if (!empty($arr2)): ?>
                            {{($arr2[1] == '2' ) ? 'selected' : ''}}
                                    <?php endif ?> >February
                        </option>
                        <option value="03" @<?php if (!empty($arr2)): ?>
                          {{($arr2[1] == '3' ) ? 'selected' : ''}}
                                    <?php endif ?>  >March
                        </option>
                        <option value="04" @<?php if (!empty($arr2)): ?>
                         {{($arr2[1] == '4' ) ? 'selected' : ''}}
                                    <?php endif ?>  >April
                        </option>
                        <option value="05"  @<?php if (!empty($arr2)): ?>
                       {{($arr2[1] == '5' ) ? 'selected' : ''}}
                                    <?php endif ?> >May
                        </option>
                        <option value="06"  @<?php if (!empty($arr2)): ?>
                     {{($arr2[1] == '6' ) ? 'selected' : ''}}
                                    <?php endif ?> >June
                        </option>
                        <option value="07"  @<?php if (!empty($arr2)): ?>
                    {{($arr2[1] == '7' ) ? 'selected' : ''}}
                                    <?php endif ?> >July
                        </option>
                        <option value="08"  @<?php if (!empty($arr2)): ?>
                  {{($arr2[1] == '8' ) ? 'selected' : ''}}
                                    <?php endif ?> >August
                        </option>
                        <option value="09"  @<?php if (!empty($arr2)): ?>
                     {{($arr2[1] == '9' ) ? 'selected' : ''}}
                                    <?php endif ?>>September
                        </option>
                        <option value="10"  @<?php if (!empty($arr2)): ?>
                  {{($arr2[1] == '10' ) ? 'selected' : ''}}
                                    <?php endif ?> >October
                        </option>
                        <option value="11"  @<?php if (!empty($arr2)): ?>
                   {{($arr2[1] == '11' ) ? 'selected' : ''}}
                                    <?php endif ?> >November
                        </option>
                        <option value="12"  @<?php if (!empty($arr2)): ?>
                   {{($arr2[1] == '12' ) ? 'selected' : ''}}
                                    <?php endif ?> >December
                        </option>

                    </select>
                </div>
            </div>
        </div>
    </div>




    @php
        $response_action = route('hrm.saving-fund-list');
    @endphp


    <div class="col-md-12 mt-4 text-right">
        <button type="submit" class="btn btn-md btn-success uhl_save_btn" onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">Save</button>
        <button type="reset" class="btn btn-info btn-md" title="Click here to Clear form data">Clear</button>
        <button type="button" class="btn btn-md btn-danger mr-auto" data-dismiss="modal">Exit</button>

    </div>
</form>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('asset/timepicker/js/timepicker.js') }}"></script>

<script>
    openDoctorAutocomplete("#employee_id", "hdn_employee_id_0");

    $('.select2').select2();
    $(document).ready(function (){
      var par_key =  $('#savingFund').val();
      if(par_key != ''){
        $('.hidden_class').attr('readonly',true);
                    // $('.hidden_class option:not(:selected)').attr('disabled', true);
                }
            });
        </script>
