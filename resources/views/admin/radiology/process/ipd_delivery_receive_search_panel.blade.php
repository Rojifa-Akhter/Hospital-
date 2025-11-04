<form method="post" id="frm_receive_search" action="{{ route('path.search-result-entry') }}" action="">
    @csrf
    <input type="hidden" name="type" value="Receive">
    <div class="card mt-0">
        <div class="card-header">
            <h5> <i class="fa fa-search"></i> Search</h5>
        </div>
        <div class="card-body">
            <div class="form-row">
                <div class="col-2">
                    <div class="form-group">
                        <label for="patient_code" class="col-form-label col-form-label-sm"> UHID</label>
                        <input type="hidden" id="hdn_patient_id" name="hdn_patient_id" />
                        <input type="text" class="form-control form-control-sm m-0 mb-0" id="service_number"
                            name="service_number" value="" placeholder="Patient ID" />
                    </div>
                </div>

                {{-- <div class="col-2">
                    <div class="form-group">
                        <label for="admission_no" class="col-form-label col-form-label-sm">Admission No</label>
                        <input class="form-control form-control-sm" type="text" id="admission_no" name="admission_no" value="" placeholder="Admission No">
                        <input type="hidden" name="hdn_admission_id" id="hdn_admission_id" value="">
                    </div>
                </div> --}}

                {{-- <div class="col-2">
                    <div class="form-group">
                        <label for="prescription_id" class="col-form-label col-form-label-sm">Department</label>
                        <select name="dept" id="dept" class="form-control form-control-sm select2">
                            <option value="">Select Department</option>
                            @if (!empty($service_unit))
                                @foreach ($service_unit as $dept)
                                    <option value="{{$dept->serviceunit_no_pk}}">{{$dept->serviceunit_name}}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div> --}}

                <div class="col-6">
                    <div class="form-group">
                        <label class="col-form-label col-form-label-sm" for="search_date_from">Date</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">From</div>
                            </div>
                            <input type="text" class="form-control form-control-sm m-0 date_picker"
                                id="search_date_from" name="search_date_from"
                                value="" placeholder="dd-mm-yyyy"
                                autocomplete="off">
                            <div class="input-group-prepend">
                                <div class="input-group-text">To</div>
                            </div>
                            <input type="text" class="form-control form-control-sm m-0 date_picker"
                                id="search_date_to" name="search_date_to"
                                value="" placeholder="dd-mm-yyyy"
                                autocomplete="off">
                        </div>

                    </div>

                </div>
                <div class="col-2">
                    <div class="form-group">
                        <label for="prescription_id" class="col-form-label col-form-label-sm">Invoice No</label>
                        <input class="form-control form-control-sm " type="text" id="patientBilling"
                            name="invoice_id" value="" placeholder="Invoice No" keep_me>
                    </div>
                </div>
                <div class="col-2">
                    <button type="button" class="btn btn-md btn-success mt-4 " id="rcb_process_search"> <i
                            class="fa fa-search mr-1"></i> Search</button>
                    <button type="reset" class="btn btn-md btn-info mt-4">Reset</button>
                </div>
            </div>
        </div>
    </div>
</form>
