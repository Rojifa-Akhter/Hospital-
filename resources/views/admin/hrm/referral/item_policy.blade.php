<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<section id="create_Policy">
	<div id="item-policy">		
		@include('admin.hrm.referral.create_item_policy')
	</div>
	
	<div id="policy-details">
		@include('admin.hrm.referral.item_policy_data')
	</div>
</section>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
