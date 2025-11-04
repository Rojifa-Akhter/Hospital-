<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<section id="item_type_wise">
	<div id="itemWisePolicyPopup">
		@include('admin.corporate.item_type.item_wise_policy_popup')
	</div>
	<div id="policy-details">
		@include('admin.corporate.item_type.item_type_policy_data')
	</div>
</section>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js')}}"></script>
<script>
	$('.select2').select2();
	
</script>
