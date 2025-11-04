<form action="{{ route('dietNutrition.report') }}" id="dietNutritionFilterForm" target="_blank" method="POST">
    @csrf
    <div class="form-row">
        <div class="col-lg-2 col-md-6 col-12">
            <div class="form-group">
                <label for="admission_no" class="col-form-label">Admission No.</label>
                <input type="text" class="form-control form-control-sm" id="admission_no" name="admission_no"
                    placeholder="Enter Admission ID" autocomplete="off" />
            </div>
        </div>
        <div class="col-lg-2 col-md-6 col-12">
            <div class="form-group">
                <label for="mobile" class="col-form-label">Mobile No</label>
                <input type="text" class="form-control form-control-sm" id="mobile" name="mobile"
                    placeholder="Enter Primary Mobile Number"  />
            </div>
        </div>
        <div class="col-lg-2 col-md-6 col-12">
            <div class="form-group">
                <label for="ward_id" class="col-form-label">Ward</label>
                <select class="form-control form-control-sm select2" id="ward_id" name="ward_id" required>
                    <option value="">Select Ward</option>
                    @if (!empty($wards))
                        @foreach ($wards as $rd)
                            <option value="{{ $rd->ward_no_pk }}">{{ $rd->ward_name }}</option>
                        @endforeach
                    @endif
                </select>
            </div>
        </div>
        <div class="col-lg-2 col-md-6 col-12">
            <div class="form-group">
                <label for="bed_" class="col-form-label">Bed</label>
                <select class="form-control form-control-sm select2" id="bed_id" name="bed_id" required>
                    <option value="">Select Bed</option>
                    @if (!empty($beds))
                        @foreach ($beds as $rd)
                            <option value="{{ $rd->bed_name }}">{{ $rd->bed_name }}</option>
                        @endforeach
                    @endif
                </select>
            </div>
        </div>
        <div class="col-lg-2 col-md-6 col-12">
            <div class="form-group">
                <label for="department_id" class="col-form-label">Nurse Station</label>
                <select class="form-control form-control-sm select2" id="department_id" name="department_id" required>
                    <option value="">Select Nurse Station</option>
                    @if (!empty($nurseStations))
                        @foreach ($nurseStations as $rd)
                            <option value="{{ $rd->serviceunit_name }}">{{ $rd->serviceunit_name }}</option>
                        @endforeach
                    @endif
                </select>
            </div>
        </div>
        <div class="col-md-2 col-sm-12">
            <div class="btn-block" style="margin-top: 25px;">
                <button type="button" class="btn btn-secondary uhl_common_btn btn-md-global" id="search"><i class="fa fa-search"></i>Search</button>
                <button type="button" class="btn btn-info btn-md-global" id="downloadPdf"><i class="fa fa-file"></i>Report</button>
                <a rel="tab" href="{{ route('dietNutrition.index') }}" class="btn btn-md-global btn-danger">Reset</a>
            </div>
        </div>
    </div>
</form>
