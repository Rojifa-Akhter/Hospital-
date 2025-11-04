<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<section id="create_Policy">
	<div id="item-policy">
		@include('admin.corporate.item.create_item_policy')
	</div>

	<div id="policy-details">
		@include('admin.corporate.item.item_policy_data')
	</div>
</section>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
