@php
$team = (isset($team) && (!empty($team))) ? $team : [];
$team_no_pk = ($team) ? $team->team_no_pk : '';
$team_name = ($team) ? $team->team_name : '';

@endphp

<div class="row">
	<div class="col-sm-12 col-lg-12 col-xl-12">
		<form action="{{ route('team.store') }}" method="post" id="team-create">
			@csrf

			<input type="hidden" name="id" value="{{$team_no_pk}}">
			<div class="form-group row">
				<div class="col-md-6">
					<div class="col-sm-12">
						<label for="team_name" class="col-sm-12 col-form-label col-form-label-sm">Team Name<span class="text-danger">*</span></label>
						<div class="col-sm-12">
							<input type="text" class="form-control form-control-sm" id="team_name" name="team_name" value="{{$team_name ? ucfirst($team_name):''}}" placeholder = "Enter Team Name">
						</div>
					</div>
				</div>
			</div>            
			<div class="modal-footer mt-1 text-left">
				@php
				$response_action = route('corporate.worklist');
				@endphp
				<button type="button" class="btn btn-md btn-danger" data-dismiss="modal">Exit</button>
				<button type="button" class="btn btn-md btn-success" onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">Save changes</button>
			</div>


		</form>
	</div>
</div>
<script type="text/javascript">
	$(function() {

	});

</script>
