<?php
$requestDepts = DB::table('sysc_serviceunit_vw')
    ->where('ipd_ind', 1)
    ->get(['serviceunit_name', 'serviceunit_no_pk'])
    ->toarray();
$ward = db::table('ipds_ward')
    ->select('ward_no_pk', 'ward_name')
    // ->where('au_entry_hospital_no_fk', session::get('user.ses_hospital_no_pk'))
    ->get();
$bed_data = db::table('ipds_bed')
    ->select('bed_no_pk', 'bed_name')
    ->get();

?>
<form action="#">
    <div class="form-row">
        <div class="col-lg-2 col-md-6 col-12">
            <div class="form-group">
                <label for="admission_no" class="col-form-label">Admission
                    No</label>

                <input type="text" class="form-control form-control-sm"
                    id="admission_no_dis" name="admission_no" value=""
                    placeholder="Enter Admission ID" autocomplete="off">
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-12">
            <div class="form-group">
                <label for="mobile_name" class="col-form-label">Mobile No</label>
                <input type="text" class="form-control form-control-sm"
                    id="mobile_name_dis" name="mobile_name"
                    placeholder="Enter Primary Mobile Number"
                     />
            </div>
        </div>
        <div class="col-lg-2 col-md-6 col-12">
            <div class="form-group">
                <label for="bed_" class="col-form-label">Bed</label>
                <select class="form-control form-control-sm select2" id="bed_id"
                    name="bed_id_dis" required>
                    <option value="">Select Bed</option>
                   

                    @if (!empty($bed_data))
                    @foreach ($bed_data as $rd)
                        <option value="{{ $rd->bed_no_pk }}">
                            {{ $rd->bed_name }}
                        </option>
                    @endforeach
                @endif
                </select>
            </div>
        </div>
        <div class="col-lg-2 col-md-6 col-12">
            <div class="form-group">
                <label for="Ward_" class="col-form-label">Ward</label>
                <select class="form-control form-control-sm select2" id="Ward_id_dis"
                    name="Ward_id" required>
                    <option value="">Select Ward</option>
                    @if (!empty($ward))
                        @foreach ($ward as $rd)
                            <option value="{{ $rd->ward_no_pk }}">
                                {{ $rd->ward_name }}
                            </option>
                        @endforeach
                    @endif
                </select>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-12">
            <div class="form-group">
                <label for="Ward_" class="col-form-label">Department</label>
                <select class="form-control form-control-sm select2"
                    id="dept_id_dis" name="dept_id" required>
                    <option value="">Select Department</option>
                    @if (!empty($requestDepts))
                        @foreach ($requestDepts as $rd)
                            <option value="{{ $rd->serviceunit_no_pk }}">
                                {{ $rd->serviceunit_name }}
                            </option>
                        @endforeach
                    @endif
                </select>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-12">
            <div class="form-group">
                <label for="primary_doctor" class="col-form-label">Primary
                    Doctor</label>
                <input type="text" class="form-control form-control-sm"
                    id="primary_doctor_dis" name="primary_doctor"
                    placeholder="Enter Primary Doctor" />
                <input type="hidden" id="doctor_id_dis" name="doctor_id"
                    value="" />
            </div>
        </div>

        <div class="col-lg-3 col-md-6 col-12">
            <div class="form-group">
                <label for="from_date" class="col-form-label">From Date</label>
                <input type="text"
                    class="form-control form-control-sm date-picker"
                    id="from_date_dis" name="from_date"
                    placeholder="Enter From Date" />
            </div>
        </div>

        <div class="col-lg-3 col-md-6 col-12">
            <div class="form-group">
                <label for="to_date" class="col-form-label">To Date</label>
                <input type="text"
                    class="form-control form-control-sm date-picker"
                    id="to_date_dis" name="to_date" placeholder="Enter To Date" />
            </div>
        </div>

        <div class="col-md-3 col-sm-12">
            <div class="btn-block" style="margin-top: 25px;">
                <button type="button"
                    class="btn btn-secondary uhl_common_btn btn-md-global"
                    id="btnSearchDischargePatientList"><i class="fa fa-search"></i>
                    Search</button>
            </div>
        </div>
    </div>
</form>


<script>
    
    openDoctorAutocomplete('#primary_doctor_dis', 'doctor_id_dis');
</script>