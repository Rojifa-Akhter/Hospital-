<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<section id="item_type_wise">
	<div id="itemWisePolicyPopup">		
		@include('admin.pcrm.referral.item_wise_policy_popup')		
	</div>
	<div id="policy-details">
		@include('admin.pcrm.referral.item_type_policy_data')
	</div>
</section>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
