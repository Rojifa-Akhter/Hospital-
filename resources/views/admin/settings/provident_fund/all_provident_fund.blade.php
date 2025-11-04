
<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<section id="full_lookup_list">
	<div class="container-fluid">
		<div class="row bg-white border-bottom sticky-top shadow-sm">
			<div class="col-md-12 mb-1">
				<h5 class="mt-2 mb-0">provident Fund  List</h5>
				<small>Settings / provident Fund  Setup / provident Fund  List</small>
			</div>
		</div>
		<div class="card">
			<div class="card-header"><h5>provident Fund <button class="btn btn-sm btn-primary float-right open-modal" data-modal="common-modal-md" data-action="{{route('provident-fund-create')}}" data-title="Create New provident Fund">Create New provident Fund</button></h5></div>

			<div class="card-body">
				<div class="row mt-2">
				    <div class="col-md-12 table-responsive">
				        @include("admin.settings.provident_fund.provident_fund_list")
				    </div>
				</div>
			</div>
		</div>
	</div>
</section>
