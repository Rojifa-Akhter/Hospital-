<div class="row">
    <div class="col-md-3 col-lg-3 col-sm-3">
        <div class="row">
            <div class="col-md-12 col-lg-12 col-sm-12">
                <div class="card mt-0 bg-none">
                    <div class="card-header">
                        <span id="favourit_list_title" data-append-to="">Favourite List</span>
                        <span class="loading-img"></span>
                    </div>
                    <div class="card-body" style="max-height: 300px; overflow:scroll;">
                        <div class="form-group mt-2">
                            <input type="search" class="form-control form-control-sm " id="favListSearch"
                                name="" onkeyup="favoriteListSearch(this)" searcAttrvalue=''
                                placeholder="Search Favourite Item">
                        </div>
                        <table class="table m-0">
                            <tbody id="pres-favourit-list-plan" style="word-break: break-all;">
                                @include('admin.prescription.uhl.pres_favourit_list')
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-9 col-lg-9 col-sm-9 p-0 border-left shadow-sm mt-3">
        <div class="card-body border-top">
            <div class="form-row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="note" class="col-form-label col-form-label-sm">Plan</label>

                        <textarea name="note" id="note" class="form-control form-control-sm m-0 p-0 item_element mb-0" cols="20"
                            rows="5"> {{ $management_plan_note ?? '' }}</textarea>
                    </div>
                </div>
                {{-- <div class="col-md-12 col-lg-12 col-sm-12">
                    <div class="form-group">
                        <label for="procedure_item" class="col-form-label col-form-label-sm">Plan</label> --}}
                {{-- <textarea name="procedure_item" id="procedure_item" class="form-control form-control-sm m-0 p-0 item_element mb-0"
                            cols="20" rows="5"> {{ $management_plan_note ?? '' }}</textarea> --}}
                {{-- 
                        <textarea name="procedure_item" id="procedure_item" class="form-control form-control-sm m-0 p-0 item_element mb-0"
                            cols="20" rows="5"
                            onclick="prescriptionV2.loadToPresFavouritListV2(this,'PROCEDURE','Procedure','#proc', '{{ $action_url }}', '#pres-favourit-list-plan')"
                            data-lookup-id="{{ @$lookup_id_arr->PROCEDURE }}" data-lookup-code="PROCEDURE"></textarea>

                        <div class="card mt-0">
                            <div class="card-body p-0">
                                @php
                                    $class = !empty($pr_arr) ? ' border p-1' : '';
                                @endphp
                                <ul class="list-unstyled mb-0 pt-1 {{ $class }}" id="proc">
                                    @if (!empty($pr_arr))
                                        @foreach ($pr_arr as $rows)
                                            @foreach ($rows as $row)
                                                @php
                                                    $row_data = explode('_', $row);
                                                @endphp
                                                <li id="item-{{ $row_data[0] }}">
                                                    <input type="hidden" name="item_id[]" value="{{ $row_data[0] }}"
                                                        readonly="readonly">

                                                    <input class="left-element" type="text" style="width:90%"
                                                        name="item_name[]" value="{{ $row_data[1] }}">

                                                    <input type="hidden" name="lookup_id[]" value="{{ $row_data[2] }}"
                                                        readonly="readonly">

                                                    <input type="hidden" name="lookup_code[]" value="PROCEDURE"
                                                        readonly="readonly">

                                                    <input type="hidden" name="lookupdata_code[]"
                                                        value="{{ $row_data[3] }}" readonly="readonly">

                                                    <input type='hidden' name='unit_intensity[]'>

                                                    <input type='hidden' name='session_duration[]'>

                                                    <input type='hidden' name='no_of_session[]'>

                                                    <input type='hidden' name='session_mu[]'>

                                                    <input type='hidden' name='frequency[]'>

                                                    <input type='hidden' name='mode[]'>

                                                    <input type='hidden' name='in_m_duration[]'>

                                                    <input type='hidden' name='in_m_repetition[]'>

                                                    <input type='hidden' name='in_e_location[]'>

                                                    <span class="float-right text-danger cursor-pointer"
                                                        title="Remove This Item" onclick="removeParentElement(this)"><i
                                                            class="fa fa-times"></i>
                                                    </span>&nbsp;
                                                    <span class="float-right text-secondary mr-1 cursor-pointer"
                                                        style="font-size:11px;" title="Add To Favourite List"
                                                        onclick="prescriptionFunc.addToPresFavouritList(this)"
                                                        data-url="{{ $add_to_pres_url }}" data-id="{{ $row_data[0] }}"
                                                        data-name="{{ $row_data[1] }}" data-type="PROCEDURE"><i
                                                            class="fa fa-star text-primary"></i>
                                                    </span>
                                                </li>
                                            @endforeach
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                        </div> --}}
                {{-- </div>
                </div> --}}
                <div class="col-md-12">
                    <div class="form-row">
                        <div class="col-sm-12 col-md-6 col-lg-6">
                            <label for="txt_referred_doctor" class="col-form-label col-form-label-sm">Refferred
                                Doctor <span class="badge badge-primary cursor-pointer open-modal"
                                    data-modal="common-modal-sm" data-id="1"
                                    data-action="{{ route('doctor.createquickregistration-pres', 1) }}"
                                    data-title="Add new Doctor (External)">
                                    + Add New </span></label>
                            <input type="text" class="form-control " name="txt_referred_doctor"
                                onclick="doctorselect(this)" id="txt_referred_doctor"
                                placeholder="Write Referred Doctor Name"
                                value="{{ isset($pat_med_rs[0]->ref_doc_name) ? $pat_med_rs[0]->ref_doc_name : '' }}">
                            <input type="hidden" name="ref_doc_card_hidn" id="ref_doc_card_hidn"
                                value="{{ isset($pat_med_rs[0]->ref_doctor) ? $pat_med_rs[0]->ref_doctor : '' }}">
                        </div>

                        <div class="col-sm-12 col-md-3 col-lg-3">

                            <input type="text" class="form-control mt-4 department_name" name="department"
                                id="department" placeholder="Department" value="" disabled>
                        </div>

                        <div class="col-sm-12 col-md-3 col-lg-3">
                            <label for="next_followup" class="col-form-label col-form-label-sm">Next Followup</label>
                            <input type="text" class="form-control date_picker_app" name="next_followup"
                                id="next_followup"
                                value="{{ !empty($next_followup_dt) ? date('d-m-Y', strtotime($next_followup_dt)) : '' }}">
                        </div>
                    </div>
                </div>

                @if (!empty($su_info) && $su_info->physio_ind == 1)
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="expected_session" class="col-form-label col-form-label-sm">Expected
                                session</label>
                            <div class="input-group">
                                <input type="text" class="form-control form-control-sm m-0 p-0 number_only"
                                    id="expected_session" name="expected_session" onkeyup="" value="">
                                <select class="form-control" id="expected_session_mu" name="expected_session_mu"
                                    onchange="">
                                    <option value="">Select</option>
                                    @if (!empty($followup_mu))
                                        @foreach ($followup_mu as $key => $fmu)
                                            @if ($followup_mu_name == '')
                                                @if (strtoupper($key) == 'DAY')
                                                    <option value="{{ strtoupper($key) }}" selected="selected">
                                                        {{ $fmu['data'] }}</option>
                                                @else
                                                    <option value="{{ strtoupper($key) }}">{{ $fmu['data'] }}
                                                    </option>
                                                @endif
                                            @else
                                            @endif
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="col-md-12">
                    <div class="form-row">
                        <div class="col-sm-12 col-md-6 col-lg-6">
                            <label for="reffered_reason" class="col-form-label col-form-label-sm">Reffered
                                Reason</label>
                            <input type="text" name="reffered_reason" id="reffered_reason"
                                class="form-control form-control-sm m-0 p-0 item_element mb-0"
                                value="{{ $ref_reason ?? '' }}">
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-6">
                            <label for="referred_clinic" class="col-form-label col-form-label-sm">Referred
                                Clinic</label>
                            <select id="referred_clinic" name="referred_clinic" class="form-control form-control-sm">
                                <option value="">Select Clinic</option>
                                @if (!empty($referred_clinic_list))
                                    @foreach ($referred_clinic_list as $pk => $cl)
                                        <option value="{{ $cl['entry'] }}"
                                            {{ $cl['entry'] == $ref_clinic_no_fk ? 'selected' : '' }}>
                                            {{ $cl['data'] }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                </div>


                <div class="col-md-12 soft-border">
                    <div class="form-row">


                        <!-- Admission Referred Checkbox -->
                        <div class="col-sm-12 col-md-6 col-lg-6 mt-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="admission_referred"
                                    id="admission_referred" value="HOSPITALIZED"
                                    @if ($disposal == 'HOSPITALIZED') checked @endif>
                                <label class="form-check-label" for="admission_referred">
                                    Admission Referred
                                </label>
                            </div>
                        </div>
                        <!-- Referred Date -->
                        <div class="col-sm-12 col-md-6 col-lg-6">
                            <label for="ipd_referred_date" class="col-form-label col-form-label-sm">Admission Referred
                                Date</label>
                            <input type="text" class="form-control date_picker_app" name="ipd_referred_date"
                                id="ipd_referred_date"
                                value="{{ !empty($ipd_referred_date) ? date('d-m-Y', strtotime($ipd_referred_date)) : '' }}"
                                placeholder="Select Referred Date">
                        </div>


                        <!-- IPD Referred Advice -->
                        <div class="col-sm-12 col-md-12 col-lg-12">
                            <label for="ipd_referred_advice" class="col-form-label col-form-label-sm">Admission
                                Advice</label>
                            <textarea name="ipd_referred_advice" id="ipd_referred_advice"
                                class="form-control form-control-sm m-0 p-0 item_element mb-0" cols="20" rows="3"
                                placeholder="Enter Admission Advice">{{ $ipd_referred_advice ?? '' }}</textarea>
                        </div>

                    </div>

                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label for="global_hidden_note" class="col-form-label col-form-label-sm">Hidden Note</label>
                        <textarea name="global_hidden_note" id="global_hidden_note"
                            class="form-control form-control-sm m-0 p-0 item_element mb-0" cols="20" rows="5"
                            placeholder="Enter Global Hidden Note">{{ $global_hidden_note ?? '' }}</textarea>


                        {{-- <textarea name="global_hidden_note" id="global_hidden_note" class="form-control form-control-sm m-0 p-0 item_element mb-0"
                            cols="20" rows="5" placeholder="Enter Hidden Note"> </textarea> --}}
                    </div>
                </div>



                <div class="col-md-12">
                    <div class="form-group">
                        <label for="template_name" class="col-form-label col-form-label-sm">
                            Template Name <span class="text-danger" id="template_msg"></span>
                        </label>
                        <input type="text"
                            class="form-control form-control-sm m-0 p-0 item_element mb-0 text-capitalize"
                            id="template_name" name="template_name" value="">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function doctorselect(thisElement) {
        // alert($(thisElement).attr('item-id'))
        var id = $(thisElement).attr('item-id')
        var dept = $(thisElement).attr('item-su')
        var name = $(thisElement).attr('item-name')
        $('#myModal').modal("hide");

        $('#txt_referred_doctor').val(name)
        $('#ref_doc_card_hidn').val(id)
        $(".department_name").val(dept)
        $('#doc_dept').find(":selected").val(item.serviceunit_no_fk);
        $('#doc_dept').find(":selected").text(dept);
        $('#myModal').removeData('bs.modal');

    }


    $(document).ready(function() {
        const $checkbox = $('#admission_referred');
        const $referredDateInput = $('#ipd_referred_date');

        // Function to handle checkbox change
        function handleCheckboxChange() {
            if ($checkbox.is(':checked') && $.trim($referredDateInput.val()) === '') {
                alert('Please add referred date and advice.');
                $referredDateInput.focus();
            }
        }

        // Trigger on page load if checkbox is checked and input is empty
        handleCheckboxChange();

        // Bind change event to checkbox
        $checkbox.change(handleCheckboxChange);
    });
</script>
