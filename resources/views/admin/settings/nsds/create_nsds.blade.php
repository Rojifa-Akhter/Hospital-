<link href="{{ asset('select2/dist/css/select2.min.css') }}" rel="stylesheet">
<section id="create_lookup">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm">
            <div class="col-md-12">
                <div class="float-left">
                    <h5 class="mt-2 mb-0">Add New Nurse or Doctor Station</h5>
                    <small>Settings /  /NSDS setup / Add New  Nurse or Doctor Station</small>
                </div>
                <div id="top-action">
                    <button class="btn btn-outline-primary btn-md float-right open-modal" data-modal="common-modal-md" data-action="{{ route('nsds.index') }}" data-title="NSDS List"><i class="fa fa-list"></i>&nbsp;NSDS List</button>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header"><h5>Nurse Station or Doctor Station</h5></div>
            <div class="card-body mt-2">
                <div class="row">
                    @include('admin.settings.nsds.create_nsds_form')
                </div>
            </div>
        </div>
    </div>
</section>
<script src="{{ asset('select2/dist/js/select2.min.js') }}"></script>
<script>
	$(function() {

		$("#category_lookup").focus();
		$('.select2').select2();
    });
</script>
