<link href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}" rel="stylesheet">
<section id="create_lookup">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-12 mb-1">
                <h5 class="mt-2 mb-0">Marketing Area List</h5>
                <small>Settings / Marketing  Setup / Marketing Area List</small>
            </div>
        </div>
        <div class="card">
            <div class="card-header"><h5>Create Marketing Area</h5></div>
            <div class="card-body mt-2">
                <div class="row">
                    @include('admin.settings.marketing_area.add_new_marketing_area_form')
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
