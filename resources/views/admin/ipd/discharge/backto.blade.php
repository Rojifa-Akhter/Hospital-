<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<style>
    .participent_img {
        width: 50px;
        border: 1px solid #d2d2d2;
        margin-right: 5px;
    }
</style>
<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm align-items-center">
        <div class="col-md-6">
            <h5 class="mt-2 mb-0">Discharge Return List</h5>
            <small>IPD / Discharge Return List</small>
        </div>
    </div>

    <div class="form-row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>Discharge Return List</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('ipd.discharge-req-list-search') }}" id="backtoAdmission_form"
                        method="post">
                        <div class="form-row justify-content-center border-bottom mb-2">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="col-form-label col-form-label-sm" for="card_no">Admission ID</label>

                                    <input type="text" class="form-control " id="admission_id" name="admission_id"
                                        value="" placeholder="Admission ID"
                                        data-admission-route="{{ route('ipd.admission-discharge-return-data') }}">


                                    <input type="hidden" class="form-control" id="hdn_admission_id"
                                        name="hdn_admission_id" value="" />
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="form-row">
                        <div class="col-12 table-responsive" id="backToList">
                            @include('admin.ipd.discharge.search_backto_list')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script>
    openAdmissionAutocomplete('#admission_id', 'patient_name', function getADischargePatientData(patientData,
        patientObj) {
        console.log(patientData)
        var admission_uid = patientData.admission_uid;
        var admission_route = $("#admission_id").attr("data-admission-route");
        window.location = admission_route + "/" + admission_uid;
    });
</script>
