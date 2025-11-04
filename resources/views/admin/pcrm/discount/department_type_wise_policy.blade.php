

<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<section id="create_Policy">
	<div id="dept_policy">
		@include('admin.pcrm.discount.dept_wise_policy_popup')
	</div>

	<div id="policy-details">
		@include('admin.pcrm.discount.department_type_policy_data')
	</div>
</section>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
