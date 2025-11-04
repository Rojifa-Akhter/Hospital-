{{-- <link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}"> --}}
<style>
	.datepicker {
		z-index: 9999 !important;
	}

</style>
<section id="full_registration">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				@include('admin.patient.registration_form_v2')
			</div>
		</div>
	</div>
</section>

<!-- datepicker -->
{{-- <script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script> --}}
<script>
	function readURL(input) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function(e) {
				$('#imagePreview').css('background-image', 'url('+e.target.result +')');
				$('#imagePreview').hide();
				$('#imagePreview').fadeIn(650);
			}
			reader.readAsDataURL(input.files[0]);
		}
	}
	$("#imageUpload").change(function() {
		readURL(this);
	});

	$('.date_picker').datepicker({
		onSelect: function(){
			var yr = $("#patient_dob").val();
			$('#patient_age').val(yr);
		}
	});



</script>
