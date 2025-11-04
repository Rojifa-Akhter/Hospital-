<link href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}" rel="stylesheet">
<div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm align-items-center">
    <div class="col-md-6">
        <h5 class="mt-2 mb-0">Patient Type</h5>
        <small>Settings / Patient Type </small>
    </div>


</div>
<section id="create_lookup">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h5>Create New Patient Type</h5>
            </div>
            <div class="card-body mt-2">
                <div class="row">
                    <div class="col-md-12">
                        @include('admin.settings.patient_type.create_patient_type_form')
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script>
    $(function() {

        $("#category_lookup").focus();
        $('.select2').select2();
    });
</script>
