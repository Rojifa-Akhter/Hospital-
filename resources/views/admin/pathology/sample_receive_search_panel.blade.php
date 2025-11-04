<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<div class="form-row mt-2">
    <div class="col-md-4">
        <div class="form-group">
            <input type="text" class="form-control" id="patient_id" name="patient_id" placeholder="Enter UHID" />
            <input type="hidden" class="form-control" id="hdn_patient_id" name="hdn_patient_id" />
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <!-- <label for="lab_no" class="col-form-label col-form-label-sm">Lab No</label> -->
            <input class="form-control" type="text" name="lab_no" id="lab_no" placeholder="Sample Id">

        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <input type="text" class="form-control " id="invoice_no" name="invoice_no" value="" placeholder="Invoice No">
            <input type="hidden" name="hdn_lab_no" id="hdn_lab_no" />
        </div>
    </div>
    <!--    <div class="col">
        <div class="form-group">
            <label for="department_id"
                   class="col-form-label col-form-label-sm">Department</label>
            <select class="form-control form-control-sm" id="department_id"
                    name="department_id">
                <option value="0">Select Department</option>
                @if(!empty($department_data))
                    @foreach($department_data as $dept_id => $dept)
                        <option value="{{ $dept_id }}">{{ $dept }}</option>
                    @endforeach
                @endif
            </select>
        </div>
    </div> -->
    <div class="col-md-2">
        <!-- <label for="dept" class="col-form-label col-form-label-sm">&nbsp;</label> -->
        <button class="btn btn-md btn-success btn-block btn-md-global" onclick="pathologyFunc.searchSampleReceiveListByPresc(this)" data-action="{{ route('path.search-sample-receive') }}" data-type="{{ $indicator }}"><i class="fa fa-search mr-1"></i> Search
        </button>
    </div>
</div>

<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>

<script type="text/javascript">
    openInvoiceAutocomplete("#invoice_no");
    openPatientAutocomplete('#patient_id', 'patient_name');
</script>