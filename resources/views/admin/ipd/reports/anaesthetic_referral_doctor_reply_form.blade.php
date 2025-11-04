<link rel="stylesheet" href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link href="{{ asset('css/redactor.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('asset/timepicker/css/timepicker.css') }}">

<section id="report_section">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-12 mb-1">
                <h5 class="mt-2 mb-0">Anaesthetic Referral Doctor Reply Form</h5>
                <small>Anaesthetic Referral Doctor Reply Form</small>
            </div>
        </div>
        <div class="anaesthetic__form">
            <form action="{{ route('anaesthetia-referral-store') }}" method="post" id="OPERATIONNOTE">
                @csrf
                <input type="hidden" name="ref_no" value="{{ isset($ref_no) ? $ref_no : '' }}">
                <input type="hidden" name="admission_id"
                    value="{{ isset($pat_info->admission_no_pk) ? $pat_info->admission_no_pk : '' }}">
                <input type="hidden" name="pat_id"
                    value="{{ isset($pat_info->patient_no_pk) ? $pat_info->patient_no_pk : '' }}">
                <input type="hidden" name="ot_operation_no_pk"
                    value="{{ isset($reffered_info->anaesthetic_reff_form_no_pk) ? $reffered_info->anaesthetic_reff_form_no_pk : '' }}">
                <input type="hidden" name="doctorReply" id="doctorReplyHidden">

                <div class="card">
                    <div class="card-header text-center">
                        <h2 class="card-title mb-0 text-left"><strong>Patient Info</strong></h2>
                    </div>
                    <div class="card-body p-3">
                        <div class="form-row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="nameOfpt">Name of Patient</label>
                                    <input type="text" class="form-control" id="nameOfpt" name="nameOfpt"
                                        value="{{ isset($pat_info->patient_name) ? $pat_info->patient_name : '' }}"
                                        readonly />
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="regNo">UHID</label>
                                    <input type="text" class="form-control" id="regNo" name="regNo"
                                        value="{{ isset($pat_info->patient_code) ? $pat_info->patient_code : '' }}"
                                        readonly />
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="ptAge">Age</label>
                                    <input type="text" class="form-control" id="ptAge" name="ptAge"
                                        value="{{ isset($pat_info->age) ? $pat_info->age : '' }}" readonly />
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="ptSex">Sex</label>
                                    <input type="text" class="form-control" id="ptSex" name="ptSex"
                                        value="{{ isset($pat_info->gender_txt) ? $pat_info->gender_txt : '' }}"
                                        readonly />
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="weight">Weight</label>
                                    <input type="text" class="form-control number_only" id="weight" name="weight"
                                        placeholder=""
                                        value="{{ isset($reffered_info->weight) ? $reffered_info->weight : '' }}"
                                        required />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="ptBed" class="col-form-label col-form-label-sm">Name of the Doctor
                                        (Referred)</label>
                                    <input type="text" class="form-control form-control-sm" id="doctor_name"
                                        name="doctor_name" placeholder="Dr. Name"
                                        value="{{ isset($reffered_info->full_name) ? $reffered_info->full_name : '' }}" />
                                    <input type="hidden" name="hdn_doctor_id" id="hdn_doctor_id"
                                        value="{{ isset($reffered_info->person_no_pk) ? $reffered_info->person_no_pk : '' }}">
                                </div>
                            </div>


                            {{-- <div class="col-md-4">
                                <div class="form-group">
                                    <label for="department">Department</label>
                                    <input type="text" class="form-control" id="department" name="department" value="{{ isset($pat_info->new_su_name) ? $pat_info->new_su_name : '' }}" readonly />
                                </div>
                            </div> --}}


                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="date">Date</label>
                                    <input type="text" class="form-control date_picker" id="date"
                                        name="date" value="{{ date('d-m-Y') }}" required />
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="purpose">Purpose of Referral</label>
                                    <select class="form-control" id="purpose" name="purpose" required>
                                        <option value="preoperative" @if (isset($reffered_info) && $reffered_info->purpose_of_referral == 'preoperative') selected @endif>
                                            Preoperative assessment
                                        </option>
                                        <option value="postoperative"
                                            @if (isset($reffered_info) && $reffered_info->purpose_of_referral == 'postoperative') selected @endif>
                                            Postoperative complication
                                        </option>
                                        <option value="painclinic" @if (isset($reffered_info) && $reffered_info->purpose_of_referral == 'painclinic') selected @endif>
                                            Pain clinic
                                        </option>
                                    </select>
                                </div>

                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="history">History</label>
                                    <input type="hidden" name="history" id="history"
                                        value="{{ isset($reffered_info->history) ? $reffered_info->history : '' }}">
                                    <textarea id="editor1" class="form-control" rows="4" readonly required>{{ isset($reffered_info->history) ? $reffered_info->history : '' }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="positive_findings">Result of Investigation and Treatment (Positive
                                        Findings)</label>
                                    <input type="hidden" name="positive_findings" id="positive_findings"
                                        value="{{ isset($reffered_info->positive_findings) ? $reffered_info->positive_findings : '' }}">
                                    <textarea id="editor2" class="form-control" rows="4" readonly required>{{ isset($reffered_info->positive_findings) ? $reffered_info->positive_findings : '' }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="diagnosis">Diagnosis</label>
                                    <input type="hidden" name="diagnosis" id="diagnosis"
                                        value="{{ isset($reffered_info->diagnosis) ? $reffered_info->diagnosis : '' }}">
                                    <textarea id="editor3" class="form-control" rows="4" readonly required>{{ isset($reffered_info->diagnosis) ? $reffered_info->diagnosis : '' }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="operationPlanned">Operation Planned</label>
                                    <input type="text" class="form-control" id="operationPlanned"
                                        name="operationPlanned"
                                        value="{{ isset($reffered_info->ot_planned) ? $reffered_info->ot_planned : '' }}"
                                        readonly required />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="dateOperationPlanned">Date of Operation Planned</label>
                                    <input type="text" class="form-control date_picker" id="dateOperationPlanned"
                                        name="dateOperationPlanned"
                                        value="{{ isset($reffered_info->ot_planned_date) ? date('d-m-Y', strtotime($reffered_info->ot_planned_date)) : '' }}"
                                        readonly required />
                                </div>
                            </div>

                            <hr>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <h1 style="text-align: center">
                                        <strong>
                                            Reply to Referring Doctor
                                        </strong>
                                    </h1>
                                    {{-- <textarea id="doctor_reply" class="form-control" rows="6" name="doctor_reply" required></textarea> --}}

                                    <input type="hidden" name="doc_reply_text" id="doc_reply_text"
                                        value="{{ isset($reffered_info->doc_reply_text) ? $reffered_info->doc_reply_text : '' }}">
                                    <textarea id="editor5" class="form-control" rows="4">{{ isset($reffered_info->doc_reply_text) ? $reffered_info->doc_reply_text : '' }}</textarea>
                                </div>
                            </div>


                        </div>
                        @php
                            $redirect_url = route('ipd.anaesthetic-refferral-reply-form', [
                                $pat_info->patient_no_pk,
                                $ref_no,
                            ]);
                        @endphp
                        <button type="submit" class="btn btn-success btn-lg m-3 float-right"
                            onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $redirect_url }}')">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>


<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="application/javascript" src="{{ asset('asset/timepicker/js/timepicker.js') }}"></script>
<script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
<script type="text/javascript">
    $(function() {
        // Initialize datepicker
        $('.date_picker').datepicker({
            todayHighlight: true,
            clearBtn: true,
            autoclose: true,
            endDate: '+0d',
            format: 'dd-mm-yyyy'
        });

        // Autocomplete for doctor names
        openDoctorAutocomplete('#doctor_name', 'hdn_doctor_id', 'doctor_ind', '1,2');

        // Initialize CKEditor
        var editor1 = CKEDITOR.replace('editor1', {
            tabSpaces: 4
        });
        var editor2 = CKEDITOR.replace('editor2', {
            tabSpaces: 4
        });
        var editor3 = CKEDITOR.replace('editor3', {
            tabSpaces: 4
        });
        // var editor5 = CKEDITOR.replace('editor5', { tabSpaces: 4 });
        var editor5 = CKEDITOR.replace('editor5', {
            tabSpaces: 4
        });

        // Set editors to read-only
        // editor1.setReadOnly(true);
        // editor2.setReadOnly(true);
        // editor3.setReadOnly(true);
        // editor5.on('change', function(evt) {
        //     $('#doc_reply_text').val(evt.editor.getData());
        // });


        editor5.on('change', function(evt) {
            $('#doc_reply_text').val(evt.editor.getData());
        });

    });
</script>
