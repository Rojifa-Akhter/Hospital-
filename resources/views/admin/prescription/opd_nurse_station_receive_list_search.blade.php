
<form method="post" id="receive_list_form" action="" >
    @csrf

    <div class="card mt-2">
        <div class="card-header">
            <h5> <i class="fa fa-search"></i> Search</h5>
        </div>
        <div class="card-body">
            <div class="form-row">

                <div class="col-3">
                    <div class="form-group">
                        <label for="patient_code" class="col-form-label col-form-label-sm"> Patient Code</label>
                        <input class="form-control form-control-sm " type="text" id="patient_code" name="patient_code" value="" placeholder=" Patient Code.">
                        <input type="hidden" class="form-control" id="hdn_patient_id" name="hdn_patient_id"  />
                    </div>
                </div>

                <div class="col-6">
                    <div class="form-group">
                        <label class="col-form-label col-form-label-sm" for="search_date_from">Date</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">From</div>
                            </div>
                            <input type="text" class="form-control form-control-sm m-0 date_picker" id="search_date_from" name="search_date_from" value="{{date('d-m-Y')}}" placeholder="dd-mm-YYYY" autocomplete="off">
                            <div class="input-group-prepend">
                                <div class="input-group-text">To</div>
                            </div>
                            <input type="text" class="form-control form-control-sm m-0 date_picker" id="search_date_to" name="search_date_to" value="{{date('d-m-Y')}}" placeholder="dd-mm-YYYY" autocomplete="off">
                        </div>
                    </div>
                </div>

                <div class="col-3">
                    <span class="btn btn-md btn-success mt-4 btn-md-global" id="receive_list_search" data-action="{{ route('appointments.opd-nurse-station-appointed-list') }}" tab_type='Appointed' onclick="PresFunc.allAppointedPrescribedList(this)"> <i class="fa fa-search mr-1"></i> Search</span>
                    <button type="reset" class="btn btn-md btn-info mt-4 btn-md-global">Reset</button>
                </div>
            </div>
        </div>
    </div>
</form>



<script>


</script>

