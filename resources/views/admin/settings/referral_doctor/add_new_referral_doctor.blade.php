<link href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}" rel="stylesheet">
<section id="create_lookup">
    <div class="container-fluid">

        <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm">
            <div class="col-md-12">
                <div class="float-left">
                    <h5 class="mt-2 mb-0">Referral Doctor List</h5>
                    <small>Settings / Referral Doctor /Create Referral Doctor  </small>
                </div>
                <div id="top-action">
                    <button class="btn btn-outline-primary btn-md bg-none float-right mt-2 ml-2 open-modal"
                            data-modal="common-modal-md"
                            data-action="{{ route('doctor-referral.create_form') }}" data-title="Create Referral Doctor"><i
                            class="fa fa-plus"></i> Create New
                        Referral Doctor
                    </button>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header"><h5>Create Referral Doctor</h5></div>
            <div class="card-body mt-2">
                <div class="row">
                    @include('admin.settings.referral_doctor.add_new_referral_doctor_form')
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
