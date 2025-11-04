
<div class="container-fluid">
	<div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm align-items-center">
		<div class="col-md-6">
			<h5 class="mt-2 mb-0">Other Item Setup</h5>
			<small>Item Setup / Other Item Setup</small>
		</div>
		<div class="col-md-6">
			<div class="m-0 text-right" id="top-action">
				<a rel="tab"  href="{{ route('item.other-item-worklist') }}" class="btn btn-outline-primary btn-md float-right" ><i class="fa fa-desktop"></i>&nbsp;Other Item Worklist</a>
			</div>
		</div>
	</div>
	
	
<div class="form-row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header"><h5>Other item Entry</h5></div>
			<div class="card-body">
				@include('admin.settings.item.other_item_popup')
			</div>
		</div>
	</div>
</div>


</div>

<script>
	$("#myDiv").css({
		display: "none",
		visibility: "hidden"
	});

	$(document).ready(function(){
		$("#ot_item_setup").click(function(){
			$("#myDIV").show();
		});
		$("#other_item_setup").click(function(){
			$("#myDIV").hide();
		});
		$("#diet_item_setup").click(function(){
			$("#myDIV").hide();
		});

	});
</script>