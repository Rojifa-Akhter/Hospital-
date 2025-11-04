<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link href="{{ asset('css/redactor.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<main id="page-content">
    <section class="hr_payroll">
        <div class="container-fluid">
            <div class="row bg-white border-bottom sticky-top shadow-sm">
                <div class="col-md-12 d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mt-2 mb-0">Prepare Letter</h5>
                        <small>HRM / Prepare Letter</small>
                    </div>
                </div>
            </div>


            <form action="{{ route('v1.hrm.save-generate-letter') }}" id="generateLetterForm" method="post"
                enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-row">
                                    <div class="col-lg-2 col-md-2 col-12">
                                        <div class="form-group">
                                            <label for="lettertemp_no_pk" class="col-form-label">Letter Name</label>
                                            <select name="lettertemp_no_pk" id="lettertemp_no_pk"
                                                class="form-control select2">
                                                <option value="">Select</option>
                                                @if (!empty($letters))
                                                    @foreach ($letters as $letters_name)
                                                        <option data-type="{{ $letters_name->lettertemp_type }}"
                                                            value="{{ $letters_name->lettertemp_no_pk }}">
                                                            {{ $letters_name->lettertemp_name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            <input type="hidden" name="letter_name" id="letter_name">
                                            <input type="hidden" name="apply_for_letter_ind" id="apply_for_letter_ind">
                                            <input type="hidden" name="apply_for_sms_ind" id="apply_for_sms_ind">
                                            <input type="hidden" name="apply_for_email_ind" id="apply_for_email_ind">
                                        </div>
                                    </div>

                                    <div class="col-lg-2 col-md-2 col-12">
                                        <div class="form-group">
                                            <label for="name" class="col-form-label">Name</label>
                                            <input type="text" class="form-control form-control-sm" name="emp_name"
                                                id="emp_name" placeholder="" autocomplete="off" value="" />
                                            <input type="hidden" name="emp_id" id="emp_id">

                                            {{-- <input type="text" id="name" name="name" autocomplete="off"> --}}
                                            <div id="autocomplete-results"> </div>

                                            {{-- <select name="lettertemp_no_pk" id="selectBox" class="form-control select2">
                                                <option value="">Select</option>
                                            </select> --}}
                                        </div>
                                        <input type="hidden" name="lettertemp_type" id="lettertemp_type"
                                            value="">
                                    </div>


                                    <div class="col-lg-2 col-md-2 col-12">
                                        <div class="form-group">
                                            {{-- <label for="emp-id" class="col-form-label">Employee ID</label> --}}
                                            <label for="emp-id" class="col-form-label">ID</label>
                                            <input type="text" class="form-control form-control-sm" id="employee_id"
                                                name="employee_id" placeholder="" value="" />
                                            <input type="hidden" name="hdnIDforCandidate" id="hdnIDforCandidate">
                                            <input type="hidden" name="hdnIDforEmployee" id="hdnIDforEmployee">
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="designation" class="col-form-label">Designation</label>
                                            <input type="text" class="form-control form-control-sm" id="designation"
                                                name="designation" placeholder="" value="" />
                                        </div>
                                    </div>

                                    <div class="col-lg-2 col-md-2 col-12">
                                        <div class="form-group">
                                            <label for="department" class="col-form-label">Department</label>
                                            <input type="text" class="form-control form-control-sm" id="department"
                                                name="department" placeholder="" value="" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group">
                                    <ul class="list-inline btn__box">

                                        <li class="list-inline-item mb-0 mt-0">
                                            <button type="button" class="btn btn-secondary uhl_common_btn "
                                                id="" onclick="generateLetter()">Generate</button>
                                        </li>
                                        <li class="list-inline-item"><button type="button"
                                                class="btn btn-danger uhl_common_btn">Edit</button></li>

                                        <li class="list-inline-item">
                                            <button type="button" class="btn btn-danger uhl_save_btn">Post</button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-row">
                                    <div class="col-lg-12 col-md-12 col-12">
                                        <div class="form-group">
                                            <label for="department" class="col-form-label">Edit Window</label>
                                            <textarea class="form-control" rows="12" id="signature" name="signature" placeholder=""></textarea>
                                        </div>
                                    </div>

                                    @php
                                        $response_action = route('v1.hrm.template_generate');
                                    @endphp

                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <ul class="list-inline btn__box">

                                                <li class="list-inline-item mb-0 mt-0">
                                                    <button type="button" class="btn btn-primary uhl_save_btn"
                                                        onclick="btnSaveUpdateUpload(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')"
                                                        id="saveButton">Save</button>
                                                </li>

                                                <li class="list-inline-item">
                                                    <button type="button" class="btn btn-success"
                                                        onclick="LetterPreview()">Letter Preview</button>

                                                    {{-- <a data-modal="common-modal"
                                                        data-action="{{ route('v1.hrm.letter-templates-pdf') }}"
                                                        class="btn btn-primary open-modal modal-lg"
                                                        data-title="">Letter
                                                        Preview</a> --}}
                                                    {{-- <a href="{{ route('v1.hrm.letter-templates-pdf') }}"
                                                        target="_blank" class="btn btn-success">Letter Preview</a> --}}
                                                </li>
                                                <li class="list-inline-item">
                                                    <button type="button" class="btn btn-danger">Cancel</button>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
</main>
<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('js/redactor.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script>
    loadEditor("signature");
    $('.select2').select2();
    $("body").addClass("sidebar-collapse");

    $('#lettertemp_no_pk').on('change', function() {
        var selectedValue = $(this).val();
        $.ajax({
            type: 'POST',
            url: '{{ route('v1.hrm.get-letter-type') }}',
            data: {
                selected_value: selectedValue,
            },
            success: function(response) {
                console.log(response);
                $("#lettertemp_type").val(response.lettertemp_type);
                $("#letter_name").val(response.lettertemp_name);

                if (response.apply_for_letter_ind == '1') {
                    $("#apply_for_letter_ind").val(response.apply_for_letter_ind);
                    console.log('letter');
                } else {
                    $("#apply_for_letter_ind").val('');
                }
                if (response.apply_for_email_ind == '1') {
                    $("#apply_for_email_ind").val(response.apply_for_email_ind);
                    console.log('email');
                } else {
                    $("#apply_for_email_ind").val('');
                }
                if (response.apply_for_sms_ind == '1') {
                    $("#apply_for_sms_ind").val(response.apply_for_sms_ind);
                    console.log('sms');
                } else {
                    $("#apply_for_sms_ind").val('');
                }
                // $("#apply_for_letter_ind").val(response.apply_for_letter_ind);
                // $("#apply_for_email_ind").val(response.apply_for_email_ind);
                // $("#apply_for_sms_ind").val(response.apply_for_sms_ind);
            },
            error: function() {

            }
        });

    });

    $(document).ready(function() {

        $('#emp_name').typeahead({
            hint: true,
            highlight: true,
            minLength: 3
        }, {
            limit: 'Infinity',
            async: true,
            source: function(query, processSync, processAsync) {
                return $.ajax({
                    url: "{{ route('v1.hrm.get-applicant') }}",
                    type: 'POST',
                    data: {
                        query: query,
                        letter_type: $("#lettertemp_no_pk").find(":selected").attr(
                            "data-type"),
                    },
                    dataType: 'json',
                    success: function(result) {
                        console.log(result);
                        return processAsync(result);
                    }
                });
            },
            display: 'name',
            templates: {

                suggestion: function(item) {
                    $("#hdn_degree_id").val('');
                    return '<div id="user-selection" class="clearfix border-bottom">' +
                        '<div style="display:block"><strong>Name: ' + item.name +
                        '</strong></div></div>';
                }
            }

        }).bind("typeahead:selected", function(obj, item, name) {
            var ids = item.id;

            var hdn_applicantID = '';
            var hdn_employeeID = '';
            if (ids.includes("c")) {
                $("#hdnIDforEmployee").val('');
                var hdn_applicantID = ids.replace('c', '');
                $("#hdnIDforCandidate").val(hdn_applicantID);
                $('#employee_id').val(hdn_applicantID);
            } else if (ids.includes("e")) {
                $("#hdnIDforCandidate").val('');
                var hdn_employeeID = ids.replace('e', '')
                $("#hdnIDforEmployee").val(hdn_employeeID);
                $('#employee_id').val(hdn_employeeID);
            }

            $('#designation').val(item.designation);
            $('#department').val(item.serviceunit_name);
            // $("#hdn_degree_id").val(item.doctor_degree);
            // var degree_info = "<strong>Degree: " + item.doctor_degree + " </strong>";
            // $("#degree_info").html(degree_info);
            obj.stopImmediatePropagation();
        });
    })



    // $(document).ready(function() {

    //     function clearInfo() {
    //         $("#emp_name").val(" ");
    //         $("#employee_id").val(" ");
    //         $("#designation").val(" ");
    //         $("#department").val(" ");
    //     }

    //     $('#lettertemp_no_pk').on('change', function() {
    //         var selectedValue = $(this).val();
    //         $.ajax({
    //             type: 'POST',
    //             url: '{{ route('v1.hrm.get-letter-type') }}',
    //             data: {
    //                 selected_value: selectedValue
    //             },
    //             success: function(response) {
    //                 // console.log(response);

    //                 $("#lettertemp_type").val(response.lettertemp_type)
    //                 $("#letter_name").val(response.lettertemp_name)
    //                 $("#apply_for_letter_ind").val(response.apply_for_letter_ind)
    //                 $("#apply_for_email_ind").val(response.apply_for_email_ind)
    //                 $("#apply_for_sms_ind").val(response.apply_for_sms_ind)

    //                 var letterType = $("#lettertemp_type").val();

    //                 // $.ajax({
    //                 //     type: 'POST',
    //                 //     url: '{{ route('v1.hrm.get-applicant') }}',
    //                 //     data: {
    //                 //         letterType: letterType
    //                 //     },
    //                 //     success: function(res) {
    //                 //         var responseData = res;
    //                 //     },
    //                 //     error: function() {}
    //                 // });



    //                 $('#emp_name').keyup(function() {
    //                     var query = $(this).val();
    //                     // console.log(query);
    //                     if (query !== '') {
    //                         $.ajax({
    //                             url: '{{ route('v1.hrm.get-applicant') }}',
    //                             method: 'POST',
    //                             data: {
    //                                 query: query,
    //                                 letterType: letterType
    //                             },
    //                             dataType: 'json',

    //                             display: 'emp_name',
    //                             success: function(data) {
    //                                 // console.log(data);
    //                                 var results = '';
    //                                 $.each(data, function(index, item) {
    //                                     // console.log(item);
    //                                     results += '<div>' +
    //                                         item.full_name +
    //                                         '</div>';
    //                                 });
    //                                 $('#autocomplete-results').html(
    //                                     results);
    //                             },
    //                             error: function(xhr, status, error) {
    //                                 console.error(error);
    //                             }
    //                         });
    //                     } else {
    //                         $('#autocomplete-results').html('');
    //                     }
    //                 });
    //             },
    //             error: function() {

    //             }
    //         });
    //     });








    //     // $('#lettertemp_no_pk').on('change', function() {
    //     //     var selectedValue = $(this).val();
    //     //     $.ajax({
    //     //         type: 'POST',
    //     //         url: '{{ route('v1.hrm.get-letter-type') }}',
    //     //         data: {
    //     //             selected_value: selectedValue
    //     //         },
    //     //         success: function(response) {
    //     //             // console.log(response);

    //     //             $("#lettertemp_type").val(response.lettertemp_type)
    //     //             $("#letter_name").val(response.lettertemp_name)
    //     //             $("#apply_for_letter_ind").val(response.apply_for_letter_ind)
    //     //             $("#apply_for_email_ind").val(response.apply_for_email_ind)
    //     //             $("#apply_for_sms_ind").val(response.apply_for_sms_ind)

    //     //             var letterType = $("#lettertemp_type").val();

    //     //             if (letterType == "Employee") {
    //     //                 openDoctorAutocomplete('#emp_name', 'emp_id', "employee_ind", 1,
    //     //                     personInfo);

    //     //                 function personInfo(item, obj) {
    //     //                     var emp_id = item.doctor_id != null ? item.doctor_id : '';
    //     //                     var deg = item.designation != null ? item.designation : '';
    //     //                     var dept = item.su_name != null ? item.su_name : '';

    //     //                     $("#employee_id").val(emp_id);
    //     //                     $("#designation").val(deg);
    //     //                     $("#department").val(dept);
    //     //                 }
    //     //             } else {

    //     //                 $('#emp_name').on('change', function() {
    //     //                     var value = $(this).val();
    //     //                     console.log(value);
    //     //                     $.ajax({
    //     //                         type: 'POST',
    //     //                         url: '{{ route('v1.hrm.get-applicant') }}',
    //     //                         data: {
    //     //                             value: value
    //     //                         },
    //     //                         success: function(res) {

    //     //                             // var results = $('#btagforapplicant');
    //     //                             // results.empty();

    //     //                             // if (res.length > 0) {
    //     //                             //     res.each(function(index, item) {results.append( '<li>' + item.full_name + '<li>'); });
    //     //                             //     // console.log(results);
    //     //                             // } else {
    //     //                             //     results.append('<li>No results found</li>');
    //     //                             // }

    //     //                             $("#emp_name").val(res.full_name);
    //     //                             $("#employee_id").val(res
    //     //                                 .cvapplicant_no_pk);
    //     //                             $("#designation").val(res
    //     //                                 .designation);
    //     //                             $("#department").val(res
    //     //                                 .serviceunit_name);

    //     //                         },
    //     //                         error: function() {}
    //     //                     });
    //     //                 });

    //     //             }
    //     //         },
    //     //         error: function() {}
    //     //     });
    //     // });


    // });



    function LetterPreview() {
        $.ajax({
            type: 'post',
            url: '{{ route('v1.hrm.letter-templates-pdf') }}',
            data: {
                signature: $("#signature").val(),
                letter_name: $("#letter_name").val()
            },
            beforeSend: function() {
                blockUI();

            },
            success: function(data) {
                // console.log(data);
                // for html preview
                var ne_window = window.open('', '_blank');
                ne_window.document.write(data);
                ne_window.document.close();

                // for pdf preview
                // window.open("{{ route('v1.hrm.letter_preview') }}?letterpreview=" + data.pdf, "_blank");
            },
            error: function(err) {
                $.unblockUI();
                var error = err.responseJSON;
                $('.common-modal-notify-error').modal('show');
                $('.common-modal-notify-error .modal-title').html('Failed');
                $('.common-modal-notify-error .modal-body').html(error.message);
            },
            complete: function() {
                $.unblockUI();
            }
        });
    }



    function generateLetter(id) {
        var lettertemp_no_pk = $("#lettertemp_no_pk").val();
        var emp_name = $("#emp_name").val();
        var employee_id = $("#employee_id").val();
        $.ajax({
            type: 'get',
            url: '{{ route('v1.hrm.template_generate') }}',
            data: {
                lettertemp_no_pk: lettertemp_no_pk,
                emp_name: emp_name,
                employee_id: employee_id
            },
            success: function(data) {
                // console.log(data);
                $('#signature').redactor('set', data);
            },
            error: function() {

            }
        });
    }
</script>
