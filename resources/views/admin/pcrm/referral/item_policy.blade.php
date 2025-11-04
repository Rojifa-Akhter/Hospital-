<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.min.css') }}" rel="stylesheet">
<section id="create_Policy">
	<div id="item-policy">
		@include('admin.pcrm.referral.create_item_policy')
	</div>

	<div id="policy-details">
		@include('admin.pcrm.referral.item_policy_data')
	</div>
</section>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script>
  $('.data-table').DataTable( {
        "paging":   true,
        "ordering": true,
        "info":     false
    } );
</script>
