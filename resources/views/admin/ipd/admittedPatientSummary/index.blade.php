<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}" rel="stylesheet">

<section id="full_appointment">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-12 mb-1">
                <h5 class="mt-2 mb-0"> Admitted Patient Summary</h5>
                <small>Report / IPD / Admitted Patient Summary</small>
            </div>
        </div>
        <div class="card mt-2" style="width: 100%; margin: auto">
            <div class="card-header ">
                <h5> Search</h5>
            </div>
            <div class="card-body ">
                <div class="form-row mt-2">
                    <div class="col-md-12 ">
                        <form method="post" id="frmSearch" data-response-action="" action="">
                            @csrf
                            <div class=" justify-content-center  form-row">
                                <input type="hidden" name="id" value="">

                                <div class=" col-md-2">
                                    <label for="user_expire_date" class=" col-form-label col-form-label-sm ">From
                                        Date</label>
                                    <input type="text" class="form-control form-control-sm date_picker" id="date_pic"
                                        name="date_pic" value="{{ date('d-m-Y') }}" placeholder="YYYY/DD/MM">
                                    <span class="focus_input"></span>
                                </div>

                                <div class=" col-md-2">
                                    <label for="user_expire_date" class=" col-form-label col-form-label-sm ">To
                                        Date</label>
                                    <input type="text" class="form-control form-control-sm date_picker" id="date_pic2"
                                        name="date_pic2" value="{{ date('d-m-Y') }}" placeholder="YYYY/DD/MM">
                                    <span class="focus_input"></span>
                                </div>

                                <div class=" col-md-2 ">
                                    <label for="department_name"
                                        class=" col-form-label col-form-label-sm ">Department</label>
                                    <select class="form-control select2" id="department_name" name="department_name"
                                        style="margin:0px!important;">
                                        <option value="" selected>Select Department</option>
                                        @if (!empty($requestDepts))
                                            @foreach ($requestDepts as $rd)
                                                <option value="{{ $rd->serviceunit_no_pk }}">
                                                    {{ $rd->serviceunit_name }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>

                                </div>
                                <div class=" col-md-2 ">
                                    <label for="doctor" class=" col-form-label col-form-label-sm ">Doctor</label>
                                    <select class="form-control " id="doctor" name="doctor"
                                        style="margin:0px!important;">
                                        <option value="">Select Doctor</option>

                                        <option value="0">Abnormal/Single</option>
                                        <option value="1">Attend</option>
                                        <option value="2">Late</option>
                                        <option value="3">Leave</option>
                                        <option value="4">Leave without pay</option>
                                        <option value="5">Absent</option>
                                        <option value="6">Weekly day off</option>
                                        <option value="7">Natinal Holiday</option>

                                    </select>

                                </div>
                                <div class="col-md-4 text-center mt-4">
                                    <div class="btn-group btn-block" role="group">
                                        <button type="submit" class="btn btn-sm btn-success btn-block mt-0"
                                            id="dailyAttSearchReport" onclick=""> <i class="fas fa-search"></i>
                                            Search</button>
                                        <button type='submit' class="btn btn-primary btn-block btn-md mt-0 print"
                                            value="1"> Export PDF</button>

                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">

        <div class="card">
            <div class="card-header"> Patient Summary</div>
            <div class="card-body">

                <div class="form-row mt-2">
                    <div class="col-md-12 table-responsive" id="patientSummary-container">
                        @include('admin.ipd.admittedPatientSummary.patientSummery')
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script>
    $('.date_picker').datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        todayHighlight: true,
        clearBtn: true,
    });
</script>
