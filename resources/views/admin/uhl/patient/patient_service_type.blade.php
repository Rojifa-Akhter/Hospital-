<main id="page-content">
    <link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
    <link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
    <link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
  
    <form action="{{ route('uhl.patient-service-type-store') }}" id="patient-service-type-form" method="POST"
        enctype="multipart/form-data">
        @csrf
        <section class="paitent__registration">
            <div class="container-fluid">
                <div class="row">
                    {{-- <div class="col-md-12">
                        <div class="row bg-white border-bottom sticky-top shadow-sm">
                            <div class="col-md-12 mb-1">
                                <h5 class="mt-2 mb-0">Patient Service Type</h5>
                                <small>Patient / Patient Service Type</small>
                            </div>
                        </div>
                    </div> --}}
                </div>

                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-body border-bottom-3 p-2">
                                <div class="form-row">
                                    <div class="col-lg-3 col-md-12 col-sm-12">
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <div class="form-group form-row">
                                            <label for="billing_type" class="col-sm-4 col-form-label">Which service do you seek?<span class="text-danger">*</span></label>
                                            <div class="col-sm-8">
                                                <select class="form-control form-control-sm" id="billing_type" name="billing_type" required>
                                                    <option value="">Select</option>
                                                    <option value="Billing">Billing</option>
                                                    <option value="Consultant">Consultant</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group form-row d-none" id = "dept">
                                            <input type="hidden" id="patient_id" name="patient_id" value="{{ $patient_id }}">
                                            <label for="department" class="col-sm-4 col-form-label">Department</label>
                                            <div class="col-sm-8">
                                                <select class="form-control form-control-sm select2" id="department" name="department">
                                                    <option value="">Select</option>
                                                    @if (isset($specialization))
                                                    @foreach ($specialization as $key => $value)
                                                        <option value="{{ $key }}">{{ $value }}</option>
                                                    @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group form-row d-none" id="doc">
                                            <label for="doctotr" class="col-sm-4 col-form-label">Doctor</label>
                                            <div class="col-sm-8">
                                                <select class="form-control form-control-sm select2" id="doctotr" name="doctotr">
                                                    <option value="">Select</option>
                                                    @if (isset($doctors))
                                                    @foreach ($doctors as $key => $value)
                                                    <option value="{{ $value->person_no_pk }}">{{ $value->full_name }}</option>
                                                    @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group form-row">
                                            <label for="doctotr" class="col-sm-4 col-form-label">Remarks</label>
                                            <div class="col-sm-8">
                                                <textarea class="form-control" name="remarks" id="remarks" cols="30" rows="3"></textarea>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-lg-3 col-md-12 col-sm-12">

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card mb-2">
                            <div class="card-body">
                                <div class="form-group">
                                    @php
                                        $response_url = '';
                                    @endphp

                                    <ul class="list-inline btn__box">
                                        <li class="list-inline-item">
                                          <button type="button" class="btn btn-secondary uhl_save_btn"
                                                onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_url }}')"
                                                id="">Save</button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section>
    </form>
</main>
<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.26/webcam.min.js"
    integrity="sha512-dQIiHSl2hr3NWKKLycPndtpbh5iaHLo6MwrXm7F0FM5e+kL2U16oE9uIwPHUl6fQBeCthiEuV/rzP3MiAB8Vfw=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script type="text/javascript">
// $("body").addClass("sidebar-collapse");
$('.select2').select2();

   $(document).ready(function() {
        $('#billing_type').on('change', function() {
            if ($(this).val() === 'Consultant') {
                $('#dept').removeClass('d-none');
                $('#doc').removeClass('d-none');
            } else {
                $('#dept').addClass('d-none');
                $('#doc').addClass('d-none');
            }
        });
    });


</script>
