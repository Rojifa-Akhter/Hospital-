<form id="frm_result_search" action="" method="post">
    @csrf
    <div class="card mt-0">
        <div class="card-body">
            <div class="form-row">

                <div class="col-2">
                    <div class="form-group">
                        <label for="patient_code" class="col-form-label col-form-label-sm"> Patient Code</label>
                        <input class="form-control form-control-sm" type="text" id="patient_id" name="patient_code"
                            value="" placeholder=" Patient Code.">
                    </div>
                </div>
                <div class="col-2">
                    <div class="form-group">
                        <label for="admission_no" class="col-form-label col-form-label-sm">Admission No</label>
                        <input class="form-control form-control-sm" type="text" id="admission_no" name="admission_no"
                            value="" placeholder="Admission No">
                    </div>
                </div>

                <div class="col-2">
                    <div class="form-group">
                        <label for="prescription_id" class="col-form-label col-form-label-sm">Department</label>
                        <select name="dept" id="dept" class="form-control form-control-sm select2">
                            <option value="">Select Department</option>
                            @if (!empty($department))
                                @foreach ($department as $dept)
                                    <option value="{{ $dept->serviceunit_no_pk }}">{{ $dept->serviceunit_name }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>

                <div class="col-6">
                    <div class="form-group">
                        <label class="col-form-label col-form-label-sm" for="search_date_from">Date</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">From</div>
                            </div>
                            <input type="text" class="form-control form-control-sm m-0 date_picker"
                                id="search_date_from" name="search_date_from" value="" placeholder="dd/mm/yyyy"
                                autocomplete="off">
                            <div class="input-group-prepend">
                                <div class="input-group-text">To</div>
                            </div>
                            <input type="text" class="form-control form-control-sm m-0 date_picker" id="search_date_to"
                                name="search_date_to" value="" placeholder="dd/mm/yyyy" autocomplete="off">
                        </div>
                    </div>
                </div>

            </div>

            <div class="form-row">
                <div class="col-3">
                    <div class="form-group">
                        <label for="prescription_id" class="col-form-label col-form-label-sm">Invoice No</label>
                        <input class="form-control form-control-sm" type="text" id="prescription_id" name="invoice_id"
                            value="" placeholder="Invoice No">
                    </div>
                </div>

                <div class="col-3">
                    <input type="hidden" name="hdn_operation" value="">
                    <input type="hidden" name="hdn_type" value="">
                    <span class="btn btn-md btn-success mt-4 btn-md-global" id="rad_process_search"> <i
                            class="fa fa-search mr-1"></i> Search</span>
                </div>
            </div>
        </div>
    </div>
</form>
