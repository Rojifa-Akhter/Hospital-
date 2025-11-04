<link href="{{asset('node_modules/datatables/media/css/jquery.dataTables.css')}}" rel="stylesheet">
<link rel="stylesheet" href="{{asset('datepicker/dist/css/bootstrap-datepicker.min.css')}}">
<link rel="stylesheet" href="{{asset('css/typeaheadjs.css')}}">
<link rel="stylesheet" href="{{asset('node_modules/select2/dist/css/select2.min.css')}}">
<link rel="stylesheet" href="{{asset('uhl_assets/css/uhl_style.css')}}" />
<main id="page-content">
	<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
	<form id="packagePatientForm" action="{{ route('v1.ipd-patient-package-store') }}" method="post">
		<section class="ipd__package_details">
			<div class="container-fluid">
				<div class="row">
					<div class="col-md-12">
						<div class="row bg-white border-bottom sticky-top shadow-sm">
							<div class="col-md-10">
								<h5 class="mt-2 mb-0">Package</h5>
								<small>Ipd / Package</small>
							</div>
						</div>
					</div>
				</div>

				@csrf

				<div class="row">
					<div class="col-md-12">
						<div class="card">
							<div class="card-header">
								<h5>Package For Patient</h5>
							</div>
							<div class="card-body p-2">
                                <div class="col-lg-12 col-md-12 col-12 mb-2">
                                    <div class="form-group form-row align-items-center">
                                        <input type="hidden" name="hdn_admission_id" id="hdn_admission_id">

                                        <label for="admission_id" class="col-sm-2 form-label">Admission Number</label>
                                        <div class="col-sm-2">
                                            <input type="text" class="form-control form-control-sm m-0" id="admission_id"
                                                name="admission_id" value="" placeholder="Enter Admission Number">
                                        </div>

                                        <label for="package_ipd_r" class="col-sm-1 form-label text-right">Package</label>
                                        <div class="col-sm-2">
                                            <select class="form-control form-control-sm" name="package_ipd_r" id="package_ipd_r">
                                                <option value="0">Select Package</option>
                                                @foreach ($package_item as $item)
                                                    <option value="{{ $item->pkg_no_pk }}">{{ $item->pkg_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-12 col-md-12 col-12 mb-2">
                                    <div class="form-group form-row align-items-center">
                                        <label for="package_start_date" class="col-sm-2 form-label">Package Start Date</label>
                                        <div class="col-sm-2">
                                            <input type="date" class="form-control form-control-sm" name="package_start_date" id="package_start_date">
                                        </div>

                                        <div class="col-sm-2">
                                            <button type="button" onclick="savePackage()" class="btn btn-secondary uhl_common_btn">Save</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
						</div>
					</div>
				</div>

                
			</div>
		</section>
	</form>
</main>
<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script src="{{asset('node_modules/datatables/media/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
<script src="{{asset('js/typeahead.bundle.js')}}"></script>

<script>
    openAdmissionAutocomplete('#admission_id', 'patient_name', '');

    $('#admission_id').on('typeahead:selected', function (event, suggestion) {
        $('#hdn_admission_id').val(suggestion.admission_no_pk); // numeric primary key
    });

    const today = new Date().toISOString().split('T')[0];
    document.getElementById('package_start_date').setAttribute('min', today);

    function savePackage() {
        let admissionId = $('#hdn_admission_id').val();
        let typedAdmission = $('#admission_id').val();

        if (!admissionId || admissionId === '') {
            alert('Please select a valid patient from the list.');
            $('#admission_id').focus();
            return false;
        }

        const packageId = $('#package_ipd_r').val();
        const packageStartDate = $('#package_start_date').val();

        if (packageId === '0' || packageId === '') {
            alert('Please select a package.');
            $('#package_ipd_r').focus();
            return false;
        }
        if (packageStartDate === '') {
            alert('Please select package start date.');
            $('#package_start_date').focus();
            return false;
        }

        let formElement = document.querySelector('#packagePatientForm');
        let formData = new FormData(formElement);

        if (!confirm('Are you sure you want to save this package?')) return false;

        $.ajax({
            url: "{{ route('v1.ipd-patient-package-store') }}",
            type: "POST",
            data: formData,
            dataType: "json",
            processData: false,
            contentType: false,
            cache: false,
            beforeSend: function() { blockUI(); },
            success: function(response) {
                $.unblockUI();
                $('.common-modal-notify').modal('show');
                $('.common-modal-notify .modal-title').html(response.title || 'Success');
                $('.common-modal-notify .modal-body').html(response.msg || 'Package saved successfully.');
                $('#packagePatientForm')[0].reset();
                $('#hdn_admission_id').val('');
            },
            error: function(xhr) {
                $.unblockUI();
                let error = xhr.responseJSON;
                $('.common-modal-notify-error').modal('show');
                $('.common-modal-notify-error .modal-title').html('Failed');
                $('.common-modal-notify-error .modal-body').html(error.msg || 'Something went wrong.');
            }
        });
    }


</script>
