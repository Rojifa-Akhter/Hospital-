<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">

<form action="{{ route('ipd.save-referral-doctor') }}" method="post" id="refer_doctor">
    @csrf
    <input type="hidden" name="patient_no_fk" id="patient_no_fk" value="{{ $patient_no_fk }}">
    <input type="hidden" name="admission_no_fk" id="admission_no_fk" value="{{ $admission_id }}">
    <input type="hidden" name="consultrecord_no_pk" id="consultrecord_no_pk" value="">


    <div class="form-group row">
        <div class="col-md-4 ">
            <strong> Patient Name </strong>
        </div>
        <div class="col-md-5">: {{ @$patient_info->patient_name }}</div>
    </div>


    <div class="form-group row">
        <div class="col-md-12 ">
            <strong for="ref_type">Referral Type</strong>
        </div>
        <div class="col-md-12">
            <select id="ref_type" name="ref_type" class="form-control">
                <option value="1">Routine</option>
                <option value="2">Urgent</option>
            </select>
        </div>

    </div>

    <div class="form-group row">
        <div class="col-md-12 ">
            <strong for="ref_reason" class="">Referral Reason</strong>
        </div>
        <div class="col-md-12">
            <textarea id="ref_reason" name="ref_reason" class="form-control" rows="3" placeholder="write here ..."></textarea>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-12 ">
            <strong for="ref_referral" class="">Reply to Referral</strong>
        </div>
        <div class="col-md-12">
            <textarea id="ref_referral" name="ref_referral" class="form-control" rows="4" placeholder="write here ..."></textarea>
        </div>
    </div>





    <div class="form-group mb-0">
        <label for="doctor_name" class="col-form-label col-form-label-sm">Doctor Name <span
                class="text-danger">*</span></label>
        <input type="text" class="form-control form-control-sm m-0 p-0 item_element  mb-0 resetClass"
            id="doctor_name" name="doctor_name" placeholder="Doctor Name"
            value="{{ @$admission_info->primary_doctor_name }}" readonly />
        <input type="hidden" id="doctor_id" name="doctor_id" value="{{ @$admission_info->primary_doctor_no_fk }}" />
    </div>

    <div class="form-group mb-0">
        <label for="ref_doctor_name" class="col-form-label col-form-label-sm">Referral Doctor Name</label>
        <input type="text" class="form-control form-control-sm m-0 p-0 item_element  mb-0 resetClass"
            id="ref_doctor_name" name="ref_doctor_name" placeholder="Referral Doctor Name" value="" />
        <input type="hidden" id="ref_doctor_id" name="ref_doctor_id" value="" />
    </div>


    <div class="modal-footer">
        @php
            $response_action = route('v2.ipd.nurse-note', $admission_id);
        @endphp
        <button class="btn btn-success btn-md"
            onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">Save</button>
        <button type="reset" class="btn btn-info btn-md" title="Click here to Clear form data">Clear</button>
    </div>


    <div class="row">
        <div class="col-md-12 col-12">
            <h6 class="text-center mt-2"><b>Referral History</b></h6>
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover">
                    <thead class="global-uhl-table-bg">
                        <tr>
                            <th class="text-center nowrap" style="width: 16%">Date</th>
                            <th class="text-center nowrap" style="width: 10%">Ref. Type</th>
                            <th class="text-left nowrap" style="width: 18%">Referral Reason</th>
                            <th class="text-left nowrap" style="width: 22%">Reply to Referral</th>
                            <th class="text-left nowrap" style="width: 12%">Doctor Name </th>
                            <th class="text-left nowrap" style="width: 14%">Ref. Doctor Name</th>
                            <th class="text-center nowrap" style="width: 15%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($ref_info as $item)
                            <tr>
                                <td class="text-center">
                                    @if (!empty($item->au_entry_at))
                                        {{ date('d/m/Y h:i:s A', strtotime($item->au_entry_at)) }}
                                    @endif
                                </td>
                                <td class="text-center nowrap">
                                    @if ($item->ref_type == 1)
                                        Routine
                                    @elseif($item->ref_type == 2)
                                        Urgent
                                    @endif
                                </td>
                                <td class="text-left nowrap">{{ $item->reason }}</td>
                                <td class="text-left nowrap">{{ $item->replay_to_reff }}</td>
                                <td class="text-left nowrap">{{ $item->from_doctor_name }}</td>
                                <td class="text-left nowrap">{{ $item->ref_doctor_name }}</td>
                                <td class="text-center nowrap">

                                    {{-- <span class="btn btn-sm btn-primary open-modal" data-id="{{$item->consultrecord_no_pk}}"
                                        data-action="{{ route('v2.ipd.reply-to-referral', $item->consultrecord_no_pk) }}"
                                        data-modal="common-modal-xl" data-title="Reply To Referral"
                                        title="Reply To Referral">Reply To Referral</span> --}}

                                    <a style="cursor:pointer"
                                        class="btn btn-md btn-primary w-100 text-white mt-1 open-modal mb-2"
                                        data-modal="common-modal-xl" data-title="Update Referral Reply"
                                        data-action="{{ route('v2.reply-to-referral', $item->consultrecord_no_pk) }}">
                                        Reply To Referral
                                    </a>




                                    <a href="{{ route('v2.ipd.download-referral-doctor', $item->consultrecord_no_pk) }}"
                                        class="btn btn-sm btn-danger" target="_blank">
                                        <i class="fa fa-file-pdf text-white"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-secondary"
                                        onclick="getReferalInfo({{ $item->consultrecord_no_pk }})">
                                        Edit
                                    </button>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center text-danger">Data Not Found</td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>
        </div>
    </div>

</form>


<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script>
    openDoctorAutocomplete("#doctor_name", "doctor_id");
    // openDoctorAutocomplete("#ref_doctor_name", "ref_doctor_id");

    openDoctorAutocomplete('#ref_doctor_name', 'ref_doctor_id', 'doctor_ind', '1');


    function getReferalInfo(consultrecord_no_pk) {
        $.ajax({
            data: {
                consultrecord_no_pk: consultrecord_no_pk,
            },
            url: "{{ route('v2.ipd.get-referal-info') }}",
            type: 'post',
            beforeSend: function() {
                blockUI();
            },
            success: function(data) {
                $.unblockUI();
                var result = data.data;
                $("#ref_type").val(result.ref_type);
                $("#ref_reason").val(result.reason);
                $("#ref_referral").val(result.replay_to_reff);
                $("#doctor_name").val(result.doctor_name);
                $("#ref_doctor_name").val(result.ref_doctor_name);
                $("#consultrecord_no_pk").val(result.consultrecord_no_pk);
                $("#doctor_id").val(result.from_doctor_no_fk);
                $("#ref_doctor_id").val(result.to_doctor_no_fk);
            },
            error: function(err) {
                $.unblockUI();
                var error = err.responseJSON;
                $('.common-modal-notify-error').modal('show');
                $('.common-modal-notify-error .modal-title').html('Failed');
                $('.common-modal-notify-error .modal-body').html(error.message);
            }
        })
    }
</script>
