<link href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}" rel="stylesheet">
<section id="create_lookup">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-12 mb-1">
                <h5 class="mt-2 mb-0">Marketing Agent List</h5>
                <small>Settings / item  Setup / Marketing Agent Add</small>
            </div>
        </div>
        <div class="card">
            <div class="card-header"><h5>Create Marketing Agent</h5></div>
            <div class="card-body mt-2">
                <div class="row">
                    @include('admin.settings.marketing_agent.add_new_marketing_agent_form')
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
