<link href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}" rel="stylesheet">
<section id="create_lookup">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm">
            <div class="col-md-12">
                <div class="float-left">
                    <h5 class="mt-2 mb-0">Add Attribute Value</h5>
                    <small>Settings / Attribute Value / Add New Attribute Value</small>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h5>Create Attribute Value</h5>
            </div>
            <div class="card-body mt-2">
                <div class="row">
                    @include('admin.settings.path_attribute.create_attribute_value_form')
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
