<link href="{{ asset('css/redactor.css') }}" rel="stylesheet">
<section id="create_lookup">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header"><h5>Create Email Template</h5></div>
            <div class="card-body mt-2">
                <div class="row">
                    @include('admin.settings.email_format.create_email_format_form')
                </div>
            </div>
        </div>
    </div>
</section>
<script type="application/javascript" src="{{ asset('js/redactor.js') }}"></script>
<script>
	loadEditor("email_body");
</script>