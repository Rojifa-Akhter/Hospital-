<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<section id="full_registration">
<div>
    <div class="row">
        <div class="col-md-12">
            <div class="hospital_info text-center">
                <h5 class="mb-0">
                    {{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }}</h5>
                <small>{{ isset($po_hospital_details->addrress1) ? $po_hospital_details->addrress1 : '' }}</small>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card bg-light border">
                <div class="table-responsive">
                    <table class="table table-borderless">
                        <tbody>
                            <tr style="border-bottom:2px solid #38C172">
                                <th colspan="6" class="text-center no-line"><span
                                        class="btn btn-sm bg-primary btn-rounded">Customer Copy</span></th>
                            </tr>
                            <tr>
                                <th class="w-10">PID</th>
                                <td class="text-left">{{ $invoice_mst_info->patient_code }}</td>
                                <th class="text-right">Bill ID = {{ $invoice_mst_info->invoice_code }}</th>
                                <td class="text-left">TRX ID = {{ $finc_inv_collection_amount->ledgertrn_no_pk }}</td>
                                <th class="w-10 text-right">Date of invoice:</th>
                                <td class="text-left">
                                    {{ date('d-m-Y ', strtotime($invoice_mst_info->au_entry_at)) }}</td>
                            </tr>
                            @if ($invoice_mst_info->admission_no_pk != '')
                                <tr>
                                    <th class="w-25">Admission ID :</th>
                                    <td>{{ $invoice_mst_info->admission_no_pk }}</td>
                                </tr>
                            @endif
                            <tr>
                                <th>{{ $invoice_mst_info->patient_name ? 'Name' : '' }}</th>
                                <td colspan="4" class="text-left">
                                    {{ ucwords($invoice_mst_info->patient_name) . ' ( ' . $invoice_mst_info->patient_type_code . ' ) ' }}
                                </td>
                            </tr>
                            <tr>
                                @php
                                    $pat_dob = new \DateTime($invoice_mst_info->dob);
                                    $invoice_date = new \DateTime($invoice_mst_info->invoice_date);
                                    $interval = $invoice_date->diff($pat_dob);
                                @endphp
                                <th>{{ $invoice_mst_info->age != 0 || $invoice_mst_info->age != '' ? 'Age' : '' }}
                                </th>
                                <td colspan="4" class="text-left">
                                    {{ isset($interval) ? $interval->format('%yY %mM %dD') : '' }}
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>{{ $invoice_mst_info->gender_txt ? 'Gender:' : '' }}
                                    </strong> {{ $invoice_mst_info->gender_txt }}
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>{{ $invoice_mst_info->mobile1 ? 'Contact:' : '' }}
                                    </strong> {{ $invoice_mst_info->mobile1 }} &nbsp;&nbsp;&nbsp;&nbsp;<strong>
                                        {{ $invoice_mst_info->present_addr != '  ' ? 'Address:' : '' }} </strong>
                                    {{ $invoice_mst_info->present_addr }} </td>
                            </tr>

                        </tbody>
                    </table>
                </div>

                <form action="{{route('invoice-update')}}" method="post" id="invoiceEdit">
                    @csrf
                    <input type="hidden" name="invoice_no" value="{{$invoice_mst_info->invoice_no_pk}}">
                    {{-- <label for="pat_info"></label>
                    <input type="text" class="form-control" name="customer_name" id="pat_info"> --}}


                    <label for="doctor_code" class="form-control"> <strong> Doctor referral : <span class="badge badge-primary cursor-pointer open-modal" data-modal="common-modal-sm" data-id="1" data-action="{{ route('doctor.createquickregistration', 1) }}" data-title="Add new Doctor (Referral)">
                        + Add New </span></strong> </label>
                    <input type="text" class="form-control" onkeyup="autoCompleteRemove(this)" name="" id="doctor_code_popup" value="{{ isset( $invoice_mst_info->doctor_name) ?  $invoice_mst_info->doctor_name : ''}}" placeholder="Enter Doctor referral">


                    <label for="first_refer" class="form-control"> <strong> 1st referral :      <span class="badge badge-primary cursor-pointer open-modal" data-modal="common-modal-sm" data-id="2" data-action="{{ route('doctor.createquickregistration', 2) }}" data-title="Add new Doctor (Referral)"> + Add New </span></strong> </label>
                    <input type="text" class="form-control"  onkeyup="autoCompleteRemove(this)" name="" id="first_refer" value="{{ isset( $invoice_mst_info->first_doc_name) ?  $invoice_mst_info->first_doc_name : ''}}" placeholder="Enter 1st referral">


                    <label for="second_refer" class="form-control"> <strong> 2nd referral :  <span class="badge badge-primary cursor-pointer open-modal" data-modal="common-modal-sm" data-id="3" data-action="{{ route('doctor.createquickregistration', 3) }}" data-title="Add new Doctor (Referral)"> + Add New </span></strong> </label>
                    <input type="text" class="form-control" name="" onkeyup="autoCompleteRemove(this)" id="second_refer" value="{{ isset( $invoice_mst_info->second_doc_name) ?  $invoice_mst_info->second_doc_name : ''}}" placeholder="Enter 2nd referral">

                    <label for="first_refer" class=""> <strong>Remarks : </strong> </label>
                    {{-- <input type="text" class="form-control" name="remarks" id="remarks" value="{{ isset( $invoice_mst_info->invoice_remarks) ?  $invoice_mst_info->invoice_remarks : ''}}" placeholder="Enter remarks"> --}}

                    <textarea name="remarks" id="remarks" class="form-control" rows="3">{{ isset( $invoice_mst_info->invoice_remarks) ?  $invoice_mst_info->invoice_remarks : ''}}</textarea>

                    <input type="hidden" name="doc_ref" id="hdn_doctor_id_popup" value="{{ isset( $invoice_mst_info->person_no_fk) ?  $invoice_mst_info->person_no_fk : ''}}">
                    <input type="hidden" name="first_ref" id="hdn_first_refer" value="{{ isset( $invoice_mst_info->first_ref_doc_person_no_fk) ?  $invoice_mst_info->first_ref_doc_person_no_fk : ''}}">
                    <input type="hidden" name="second_ref" id="hdn_second_refer" value="{{ isset( $invoice_mst_info->second_ref_doc_person_no_fk) ?  $invoice_mst_info->second_ref_doc_person_no_fk : ''}}">




                    <div class="row">
                        <div class="col-md-12">
                            <button class="btn btn-success btn-md " type="submit" onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage)">Save</button>
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

    <hr />

</div>
</section>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script>
    function autoCompleteRemove(element) {
        console.log($(element).val());
        if ($(element).val() == "") {
            if ($(element).attr('id') == "doctor_code_popup") {
                $('#hdn_doctor_id_popup').val('');
            }else if($(element).attr('id') == "first_refer"){
                $('#hdn_first_refer').val('');
            }else if($(element).attr('id') == "second_refer"){
                $('#hdn_second_refer').val('');
            }
        }
    }
     openPatientAutocomplete('#patient_id', 'patient_name');
    openDoctorAutocomplete('#doctor_code_popup', 'hdn_doctor_id_popup', 'doctor_ind', '1,2');
    openDoctorAutocomplete('#first_refer', 'hdn_first_refer', 'doctor_ind', '1,2');
    openDoctorAutocomplete('#second_refer', 'hdn_second_refer', 'referral_agent_ind', '1,2');
</script>
