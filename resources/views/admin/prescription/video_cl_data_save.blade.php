<?php
$machineData = (isset($machineData) && (!empty($machineData))) ? $machineData : [];
$person_code = ($machineData) ? $machineData->person_code : '';
$full_name = ($machineData) ? $machineData->full_name : '';
$emp_designation = ($machineData) ? $machineData->specialization : '';
$emp_department = ($machineData) ? $machineData->su_name : '';
$emp_photo = ($machineData) ? $machineData->photo_name : '';
?>
<div class="form-row">
    <div class="col-md-6"  style="text-align: right;">

        <img src="" id="emp_photo"  width= "150"  >


    </div>
    <div class="col-md-6" >

{{--        <label for="doctor_name" class="col-form-label col-form-label-sm"> <strong> Employee Id </strong></label>--}}
{{--        <div class="">--}}
{{--            <input type="text" class="form-control form-control-sm "--}}
{{--                   id="user_id" name="user_id"--}}
{{--                   value=""  maxlength="40" >--}}
{{--        </div>--}}

{{--        <label for="doctor_name" clss=" col-form-label col-form-label-sm"> <strong> Employee Name </strong></label>--}}
{{--        <div class="">--}}
{{--            <input type="text" class="form-control form-control-sm "--}}
{{--                   id="emp_name" name="emp_name"--}}
{{--                   value="" placeholder=" "  readonly="readonly">--}}
{{--        </div>--}}
{{--        <label for="doctor_name" class=" col-form-label col-form-label-sm"> <strong> Department </strong></label>--}}
{{--        <div class="">--}}
{{--            <input type="text" class="form-control form-control-sm "--}}
{{--                   id="emp_department" name="emp_department"--}}
{{--                   value="" placeholder="" readonly="readonly" >--}}
{{--        </div>--}}

{{--        <label for="doctor_name" class=" col-form-label col-form-label-sm"> <strong> Designation </strong></label>--}}
{{--        <div class="">--}}
{{--            <input type="text" class="form-control form-control-sm "--}}
{{--                   id="emp_designation" name="emp_designation"--}}
{{--                   value="" placeholder="" readonly="readonly" >--}}
{{--        </div>--}}

        <div class="">
            <span class="badge badge-lg badge-primary text-white p-1 mb-1 cursor-pointer" data-action="" data-title="Save Video" title="Save Video" data-modal="common-modal-md"><i class="fa fa-video"></i> Record</span>
            <span class="badge badge-lg badge-danger text-white p-1 mb-1 cursor-pointer" data-action="" data-title="Save Video" title="Save Video" data-modal="common-modal-md"><i class="fa fa-clear"></i> clear</span>
        </div>

    </div>
</div>




