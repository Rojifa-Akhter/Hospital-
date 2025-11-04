<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.min.css') }}" rel="stylesheet">
<main id="page-content">
    <form action="#">
        <section class="hospital_fiancial_reports">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row bg-white border-bottom sticky-top shadow-sm">
                            <div class="col-md-10">
                                <h5 class="mt-2 mb-0">Medical Examination Report</h5>
                                <small>Reports / Medical Examination Report</small>
                            </div>
                        </div>
                        <div id="top-action">
                            <a class="btn btn-outline-primary btn-md float-right open-modal mt-2" href="{{ url('medical-examination-report') }}"
                                data-title="Create New Medical Examination"><i class="fa fa-plus"></i> Create New Medical Examination</a>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="form-row">
                                    <div class="col-lg-8 col-md-8 col-12">
                                        <div class="form-group form-row">
                                            <label class="col-sm-3 col-form-label col-form-label-sm text-right"
                                                for="allowed-dates">Date</label>
                                            <div class="col-sm-9">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">From</div>
                                                    </div>
                                                    <input type="text" class="form-control form-control-sm m-0"
                                                        id="allowed-dates" name="allowed-dates" value=""
                                                        placeholder="dd-mm-yyyy" />
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">To</div>
                                                    </div>
                                                    <input type="text" class="form-control form-control-sm m-0 "
                                                        id="allowed_dates_to" name="allowed_dates_to" value=""
                                                        placeholder="dd-mm-yyyy" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <button type="button" class="btn btn-md btn-success btn-md-global"><i
                                                class="fa fa-search"></i> Search</button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body p-2">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover table-striped">
                                        <thead class="global-uhl-table-bg">
                                            <tr>
                                                <th>SL</th>
                                                <th>Patient Name</th>
                                                <th>Father Name</th>
                                                <th>DOB</th>
                                                <th>Gender</th>
                                                <th>Passport No.</th>
                                                <th>Doctor Name</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (!empty($data))
                                                @foreach ($data as $value)
                                                    <tr>
                                                        <td class="text-center">{{ $loop->iteration }}</td>
                                                        <td class="text-left">
                                                            {{ !empty($value->patient_name) ? ucfirst($value->patient_name) : 'N/A' }}
                                                        </td>
                                                        <td class="text-left">
                                                            {{ !empty($value->fathers_name) ? ucfirst($value->fathers_name) : 'N/A' }}
                                                        </td>
                                                        <td class="text-center">
                                                            {{!empty($value->dob)?date('d-m-y', strtotime($value->dob)):'N/A' }}</td>
                                                        <td class="text-left">
                                                            {{ !empty($value->gender_text) ? ucfirst($value->gender_text) : 'N/A' }}
                                                        </td>
                                                        <td class="text-left">
                                                            {{ !empty($value->passport_no) ? $value->passport_no : 'N/A' }}
                                                        </td>
                                                        <td class="text-left">
                                                            {{ !empty($value->doctor_name) ? ucfirst($value->doctor_name) : 'N/A' }}
                                                        </td>
                                                        <td class="text-left">
                                                            <a href="{{ route('medical-examination-report-print', $value->exam_foreign_worker_no_pk) }}"
                                                                target="_blank" class="btn btn-sm btn-warning btn-block mb-1 mt-2">Print</a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </form>
</main>
<script type="application/javascript"
    src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>