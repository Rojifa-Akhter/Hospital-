<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<section id="create_Policy">
	<div id="dept_policy">
		@include('admin.corporate.department.dept_wise_policy_popup')
	</div>

	<div id="policy-details">
		@include('admin.corporate.department.department_type_policy_data')
	</div>
</section>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
