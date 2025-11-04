<style>
	.bed-icon{
		width: 50px;
		margin: auto;
	}
	.bed{
		width: 15.33%;
		margin:5px;
		border: 1px solid #004b7b;
		padding: 5px;
		position: relative;
		overflow: hidden;
		background-color: #9e9d9d33;
	}

	.bed-availability{
		content: '';
		height: 50px;
		width: 50px;
		position: absolute;
		top: -32px;
		left: -32px;
		transform:rotate(45deg);
		/*background-color: #222;*/
		overflow: hidden;
	}

</style>
<div class="custom-card-header">
	<ul class="list-inline">
		<li class="list-inline-item text-secondary">Total Bed <span class="badge badge-primary">{{ $bedStats['total_beds'] }}</span></li>
		<li class="list-inline-item text-secondary">Available <span class="badge badge-success">{{ $bedStats['available'] }}</span></li>
		<li class="list-inline-item text-secondary">Occupied <span class="badge badge-danger">{{ $bedStats['occupied'] }}</span></li>
		<li class="list-inline-item text-secondary">Not Ready<span class="badge badge-warning">{{ $bedStats['not_ready'] }}</span></li>
	</ul>
</div>

<div class="form-row">
	<div class="col-md-6">
		<div class="form-group">
			<label class="col-form-label col-form-label-sm" for="ward">Ward Name</label>
			<input type = "text" class="form-control form-control-sm" id="ward" name="ward" value="{{$ward_name}}" disabled>
			<input type = "hidden" id= "ward_no" name="ward_no" value="{{$ward_no}}">
			<input type = "hidden" id= "admission_no" name="admission_no" value="{{$admission_no}}">
			<input type = "hidden" id= "bed_no" name="bed_no" value="{{$bed_no}}">
		</div>
	</div>

	<div class="col-md-6">
		<div class="form-group">
			<label class="col-form-label col-form-label-sm" for="bed_status">Bed Status</label>
			<select class="form-control form-control-sm" id="bed_status" name="bed_status">
				<option value="0" selected>All Beds</option>
				<option value="1">Available</option>
				<option value="2">Occupied</option>
				<option value="3">Not Ready</option>
			</select>
		</div>
	</div>
</div>

<div class="beds align-items-center clearfix">
	@if(!empty($ipds_beds))
		@foreach($ipds_beds as $ipds_bed)
			<div class=" bed text-center float-left bed-status-{{$ipds_bed->bed_status}}">
				@if($ipds_bed->bed_status == 1)
					<div class="bed-availability bg-success"></div>
				@elseif($ipds_bed->bed_status == 2)
					<div class="bed-availability bg-danger"></div>
				@elseif($ipds_bed->bed_status == 3)	
					<div class="bed-availability bg-warning"></div>	
				@endif
				<div class="bed-icon">
					<img class="w-100" src="{{ asset('img/patient-bed.png') }}" alt="">
				</div>
				<div class="bed-name">
					<h6 class="mb-0">{{$ipds_bed->bed_name}}<!--  <strong>01</strong> --></h6>
				</div>
				@if($ipds_bed->bed_status == 1)
					@if($ipds_bed->bed_no_pk == $bed_no)
						<input type = "checkbox" class="d-flex" name="select_bed" value="{{$ipds_bed->bed_no_pk}}" checked>
					@else
						<input type = "checkbox" class="d-flex" name="select_bed" value="{{$ipds_bed->bed_no_pk}}">
					@endif
				@else
					@if($ipds_bed->bed_no_pk == $bed_no)
						<input type = "checkbox" class="d-flex" name="select_bed" checked disabled>
					@else
						<input type = "checkbox" class="d-flex" name="select_bed" disabled>
					@endif
				@endif
				
			</div>
		@endforeach
	@endif
</div>


<div class="m-0 pt-2 mt-2 text-right border-top">
	<button type="button" class="btn btn-success btn-sm update-assign-bed-btn"><i class="fa fa-save"></i> Save</button>
	<button type="reset" class="btn btn-info btn-sm" title="Click here to Clear form data">Clear</button>
	<span class="btn btn-danger btn-sm" rel="tab" title="Click here to dismiss the modal" data-dismiss="modal">Exit</span>
</div>



<script>
$(document).ready(function () {
	
	/* var admissionNoPk = parseInt($("#admission_no").val())
	var ward_no =  parseInt($("#ward_no").val())
	var prev_bed_no = parseInt($("#bed_no").val()) */
	var curr_bed_no = parseInt($("#bed_no").val())

	$(document).on('change', '#bed_status', function (e) {
		e.preventDefault()
		var bed_status = parseInt($('#bed_status').val())
		var bed_name = $('#bed_status option:selected').text()

		if(bed_status ===1){
			$(".bed-status-1").css("display", "inline-block");
			$(".bed-status-2").css("display", "none");
			$(".bed-status-3").css("display", "none");
		}else if(bed_status ===2){
			$(".bed-status-1").css("display", "none");
			$(".bed-status-2").css("display", "inline-block");
			$(".bed-status-3").css("display", "none");
		}else if(bed_status ===3){
			$(".bed-status-1").css("display", "none");
			$(".bed-status-2").css("display", "none");
			$(".bed-status-3").css("display", "inline-block");

		}else{
			$(".bed-status-1").css("display", "inline-block");
			$(".bed-status-2").css("display", "inline-block");
			$(".bed-status-3").css("display", "inline-block");
		}
	})

	$(document).on('click', 'input[type="checkbox"]', function() {      
		$('input[type="checkbox"]').not(this).prop('checked', false);
		$("input:checkbox[name=select_bed]:checked").each(function() { 
			curr_bed_no = parseInt($(this).val()); 
        });
	});
	//alert(admissionNoPk)
	//alert(ward_no)
	//alert(curr_bed_no)
	$(document).on('click', '.update-assign-bed-btn', function (e) {
		e.preventDefault()
		if (isNaN(curr_bed_no)) {
			alert('Please, Select a bed.')
			e.stopImmediatePropagation();
			return false
		}
		if (!confirm("Are you sure?")) {
			e.stopImmediatePropagation();
			return false
		}
		var response_action = "{{ route('ipd.nurse-station-received-patient') }}"
		$.ajax({
			async: true,
			data: {
				prev_bed_no_fk: parseInt($("#bed_no").val()),
				curr_bed_no_fk: curr_bed_no,
				admission_no_pk: parseInt($("#admission_no").val()),
				ward_no_fk: parseInt($("#ward_no").val()),
			},
			url: "{{ route('ipd.update-assign-bed') }}",
			type: 'post',
			beforeSend: function() {
				if (isAModalOpen)
					$('.modal').modal('hide');
				blockUI();
			},
			success: function(data) {
				if (data.title == 'Success') {
					$('.common-modal-notify').modal('show');
					$('.common-modal-notify .modal-body').html("<i class='fas fa-stroopwafel fa-spin'></i>");
					$('.common-modal-notify .modal-title').html(data.title);
					$('.common-modal-notify .modal-body').html(data.msg);
				}
			},
			error: function(data) {
				var errors = jQuery.parseJSON(data.responseText).errors;
				error_messages = "";
				for (messages in errors) {
					var field_name = $("#" + messages).siblings("label").html();
					error_messages += "<div class='alert alert-danger' role='alert'>" +
							errors[messages] + "</div>";
				}

				$('.common-modal-notify-error').modal('show');
				$('.common-modal-notify-error .modal-title').html("Validation Error");
				$('.common-modal-notify-error .modal-body').html(error_messages);

				$.unblockUI();
			}
		}).done(function() {
			$.unblockUI();
			dynamicFunc.afterSaveLoadPage(response_action);
		});
		e.stopImmediatePropagation();

	})

});
</script>