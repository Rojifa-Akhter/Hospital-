@php
$doc_card = (isset($data) && (!empty($data))) ? $data : [];

$person_no_pk = ($doc_card) ? $doc_card->person_no_pk : '';
$doctor_salutation = ($doc_card) ? $doc_card->salutation : '';
$doctor_name = ($doc_card) ? $doc_card->full_name : '';
$doctor_code = ($doc_card) ? $doc_card->person_code : '';
$doctor_blood_group = ($doc_card) ? $doc_card->ld_blood_group : '';
$doctor_dob = ($doc_card) ? $doc_card->dob : '';
$doctor_gender = ($doc_card) ? $doc_card->ld_gender_name : '';
$photo_name = ($doc_card) ? $doc_card->photo_name : '';
@endphp
<style>
	@media print
	{
		.noprint {display:none;}
	}
</style>
<section id="patient_card">
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
			<div class="row">
				<div class="col-md-12">
					<div class="row">
						<div class="col-md-12">
							<div class="hosital_logo m-auto">
								<img class="w-100" src="{{ asset('images/uploads/hospital_images/'.$po_hospital_details->logo) }}" alt="">
							</div>

							<div class="hospital_info" >
								<h5> {{isset($po_hospital_details->hospital_name )? $po_hospital_details->hospital_name : ""}}</h5>
								 <span>   {{ isset($po_hospital_details->addrress1) ? $po_hospital_details->addrress1 : ""}} </span>
								<h6>Employee ID Card</h6>
							</div>
						</div>
					</div>
					<div class="card_info text-left">
						<div class="patient_info">
							<div class="row">
								<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 col-xl-8">
									<table class="">
										<tr>
											<th class="text-left ">Name</th>
											<th class="text-left px-3">:</th>
											<th class="text-left "> {{ $doctor_salutation }} {{ $doctor_name }}</th>
										</tr>

										<tr>
											<th class="text-left ">UID</th>
											<th class="text-left px-3">:</th>
											<th class="text-left ">{{ $doctor_code }}</th>
										</tr>



										<tr>
											<th class="text-left ">Gender</th>
											<th class="text-left px-3">:</th>
											<th class="text-left ">{{ $doctor_gender }}</th>
										</tr>
									</table>
								</div>
								<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
									<div class="patient_img m-auto">
										@if ($photo_name != "")
										<img class="rounded" src="{{ asset('images/uploads/doctor_images/thumb/'.$photo_name) }}">
										@else

										@if($doctor_gender == 'Male')
										<img class="rounded w-100" src="{{ asset('images/pt-patient.png') }}">
										@else
										<img class="rounded w-100" src="{{ asset('images/nurse-2.png') }}">
										@endif
										@endif
									</div>
								</div>
							</div>

						</div>

						<div class="card_footer">
							<div class="row align-items-center py-2">
								<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6 text-left">
									<div class="foot_time">
										<strong class="">ISSUE Date : <?php echo date ('d F Y,')?></strong>
									</div>
								</div>
								<!-- <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6 text-right">
									<div class="foot_bar_code">
										<img class="w-100" src="{{ asset('images/barcode.gif') }}" alt="">
									</div>
								</div> -->
							</div>
						</div>
						<div id="noprint">
						<hr />
						{{-- <button class="btn btn-md btn-success noprint"  onclick="printDiv('patient_card')"><i class="fas fa-print"></i> Print</button> --}}
                        <a href="{{ route('referral-card-print', $person_no_pk) }}"
                        class="btn btn-primary btn-md cursor-pointer" target="_blank"
                        data-id="{{ $person_no_pk }}" id="patient_card" title="Referral Card"><i
                            class="fa fa-file-print"></i>Print</a>

						<a href="#" class="btn btn-info btn-md" rel="tab" title="Click here to go to Patient List">Exit</a>
						<button class="btn btn-md btn-danger" data-dismiss="modal" title="Click here to Clear form data">Close</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<script>
		function printDiv(divName){
			document.getElementById("noprint").style.visibility = "hidden";
			var printContents = document.getElementById(divName).innerHTML;
			var originalContents = document.body.innerHTML;

			document.body.innerHTML = printContents;

			window.print();

			document.body.innerHTML = originalContents;

		}
	</script>

