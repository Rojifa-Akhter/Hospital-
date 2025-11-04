<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">

<div id="referral_policy_form" style="width:100% !important;">
    @include('admin.pcrm.referral.ipd_phr_payment_process_settings_save')

</div>

<div id="policy-details" style="width:100% !important;">
    @include('admin.pcrm.referral.ipd_phr_payment_process_settings_list')
</div>

<script src="{{ asset('js/typeahead.bundle.js') }}"></script>

