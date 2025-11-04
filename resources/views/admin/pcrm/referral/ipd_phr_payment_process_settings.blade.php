<link href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}" rel="stylesheet">
{{-- <section id="create_lookup"> --}}
<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm">
        <div class="col-md-12">
            <div class="float-left">
                <h5 class="mt-2 mb-0">Ipd Medicine Indent Payment Type</h5>
                <small>Ipd Medicine Indent Payment Type</small>
            </div>
            <div id="top-action1">
                {{-- <button class="btn btn-outline-primary btn-md float-right open-modal" data-modal="common-modal-md" data-action="{{ route('bed.index') }}" data-title="Room List"><i class="fa fa-list"></i>&nbsp;Bed List</button> --}}
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h5>Create Ipd Medicine Indent Payment Type</h5>
        </div>
        <div class="card-body mt-2">
            <div class="row">
                @include('admin.pcrm.referral.ipd_phr_payment_process_settings_info')
            </div>
        </div>
    </div>
</div>
{{-- </section> --}}
