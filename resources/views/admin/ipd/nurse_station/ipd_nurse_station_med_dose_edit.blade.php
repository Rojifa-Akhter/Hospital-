<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<section id="full_registration">
<div>
    <div class="row">
        <div class="col-md-12">
            <div class="hospital_info text-center">
                {{-- <h5 class="mb-0">
                    {{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }}</h5>
                <small>{{ isset($po_hospital_details->addrress1) ? $po_hospital_details->addrress1 : '' }}</small> --}}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card bg-light border">

                <form action="{{route('ipd.medicine-dose-edit-save')}}" method="post" id="medEdit">
                    @csrf
                    <input type="hidden" name="med_id" value="{{$med_id}}">
                    {{-- <label for="pat_info"></label>
                    <input type="text" class="form-control" name="customer_name" id="pat_info"> --}}

                    <table width="100%">
                        <tr>
                            <td>
                                <label for="dose" class="form-control"> <strong> Dose : </strong> </label>
                                <select class="form-control select2 m-0 p-0 medicine_dose"
                                id="medicine_dose_0" name="medicine_dose"
                                onchange="prescriptionFunc.addMoreDropdownOption(this,'.medicine_dose');prescriptionFunc.calculateMedicineQnty(this)">
                                <option value="0">Select</option>
                                @if (!empty($dose))
                                    @foreach ($dose as $key => $dmu)
                                        <option data-qnty=""
                                            value="{{ $key }}">
                                            {{ $dmu['data'] }}</option>
                                    @endforeach
                                @endif
                                {{-- <option data-qnty="0" data-dropdown_option="add_more"
                                    data-popup_header="Medicine Dose"
                                    data-input_label="Dose"
                                    data-input_placeholder="Enter medicine doses (i.e., 0+0+0, 0tsf+0tsf+0tsf)"
                                    value="0">Add More</option> --}}
                            </select>
                            </td>
                        </tr>
                    </table>
                    <div class="row">
                        <div class="col-md-12">
                            @php
                                $redirect_url=route('ipd.nurse-station-patient-details',[$medicine->patient_no_fk,$medicine->admission_pk_no])
                            @endphp
                            <button class="btn btn-success btn-md " type="submit" onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{$redirect_url}}')">Save</button>
                            {{-- <a href="{{ route('due-invoice-print', [$invoice_mst_info->invoice_no_pk, $finc_inv_collection_amount->ledgertrn_no_pk]) }}"
                                target="_blank" class="btn btn-warning btn-md" title="Click here to Clear form data">Print</a> --}}
                            <button type="reset" class="btn btn-danger btn-md" title="Click here to Clear form data"
                                data-dismiss="modal">Close</button>
                            <a href="{{ route('home') }}" class="btn btn-info btn-md" rel="tab"
                                title="Click here to go back to Dashboard" data-dismiss="modal">Exit</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addMoreDropdownOption" tabindex="-1" role="dialog"
    aria-labelledby="addMoreDropdownOptionTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" id="newDropdownOptionDiv">
            <div class="modal-header bg-primary">
                <h5 class="modal-title" id="addMoreDropdownOptionHeader">Header</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-row">
                    <div class="col-md-12">
                        <label for="new_dose_opt" id="addMoreDropdownOptionLabel"
                            class="col-form-label col-form-label-sm">Label</label>
                        <input type="hidden" name="thisElement_id" id="thisElement_id" value="">
                        <input type="text" class="form-control" id="new_dropdown_opt" name="new_dropdown_opt"
                            value="" placeholder="Enter new option" required>
                    </div>

                </div>
            </div>
            <div class="modal-footer py-1">
                <div class="col-md-12 text-right">
                    <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-sm btn-primary add_new_option_btn"
                        onclick="prescriptionFunc.addToDropdown(this)">Add</button>
                </div>
            </div>
        </div>
    </div>
</div>

    <hr />

</div>
</section>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script>

     openPatientAutocomplete('#patient_id', 'patient_name');
    openDoctorAutocomplete('#doctor_code', 'hdn_doctor_id', 'doctor_ind', '1,2');

</script>
