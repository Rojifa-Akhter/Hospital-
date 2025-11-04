<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">

<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<section id="create_lookup">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm align-items-center">
            <div class="col-md-6">
                <h5 class="mt-2 mb-0">Create Medicine Item</h5>
                <small>Settings / Item Setup / Create Medicine Item Form </small>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h5>Create Medicine Item</h5>
            </div>
            <div class="card-body mt-2">
                <div class="row">
                    <div class="col-md-12">

                        @include('admin.settings.medicine.create_item_form_elements')
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script>
    $(".select2").select2();
    openItemAutocomplete($("#item_generic_name"), 'GENERIC', '#item_generic_id', '#item_generic_name');



</script>
