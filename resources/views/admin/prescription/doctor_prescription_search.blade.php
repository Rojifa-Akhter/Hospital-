
{{-- <form method="post" id="formSearch" action="" >
    @csrf --}}

    <div class="card mt-2">
        <div class="card-body">
            <div class="form-row justify-content-center">
                <div class="col-4"></div>
                <div class="col-6">
                    <div class="form-group">
                        {{-- <label class="col-form-label col-form-label-sm" for="search_date_from">Date</label> --}}
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">From</div>
                            </div>
                            <input type="text" class="form-control form-control-sm m-0 date_picker" id="search_date_from" name="search_date_from" value="{{date('d/m/Y')}}" placeholder="dd/mm/yyyy" autocomplete="off">
                            <div class="input-group-prepend">
                                <div class="input-group-text">To</div>
                            </div>
                            <input type="text" class="form-control form-control-sm m-0 date_picker" id="search_date_to" name="search_date_to" value="{{date('d/m/Y')}}" placeholder="dd/mm/yyyy" autocomplete="off">
                        </div>
                    </div>
                </div>

                <div class="col-2">
                    <span class="btn btn-md btn-success" id="formSearch" tab_type='Prescribed' onclick="PresFunc.prescribedPatientList(this)" data-action="{{ route('prescription.doctor-prescribed-patient-list') }}">
                         <i class="fa fa-search mr-1"></i> Search</span>
                    {{-- <button type="reset" class="btn btn-md btn-info mt-4">Reset</button> prescription.all-patient-appointed-prescribed-list --}}
                </div>
            </div>
        </div>
    </div>
{{-- </form> --}}



<script>

$(function() {
        $('.date_picker').datepicker({
            todayHighlight: true,
            clearBtn: true,
            autoclose: true,
            // endDate: '+0d',
            'format': 'dd/mm/yyyy'
        });
    });

</script>

