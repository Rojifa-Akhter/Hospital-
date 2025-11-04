<div class="card-body border-top pt-1">
    <div class="form-row">
        <div class="col-md-4">
            <div class="form-group mb-0">
                <label for="clinical_disease" class="col-form-label col-form-label-sm d-block">Investigation / Procedure 
                    <a class="btn btn-sm btn-outline-primary open-modal"
                        data-modal="common-modal-md" data-action="{{ route('prescription-most-used-items', 'INVFIND') }}"
                        data-title="Most Used Investigation" data-append-id="#investigation"
                        onclick="prescriptionFunc.mosUsedIdPass(this)">MUI</a>
                </label>
                <input type="text" class="form-control mb-0" id="investigation_item"
                    name="investigation_item" placeholder="Enter Investigation or Procedure Name" lookup-code="INVFIND"
                    data-append-id="investigation"
                    onclick="prescriptionFunc.loadToPresFavouritList(this,'INVFIND','Investigation','#investigation', '{{ $action_url }}')">
            </div>
            <div class="form-group">
                @if (!empty($in_arr))
                    @php
                        $class = !empty($in_arr) ? ' border p-1' : '';
                    @endphp
                    <ul class="list-unstyled mb-0 pt-1 {{ $class }}" id="investigation">
                        @foreach ($in_arr as $code => $rows)
                            @foreach ($rows as $row)
                                @php
                                    $row_data = explode('_', $row);
                                @endphp
                                <li id="item-{{ $row_data[0] }}">
                                    <input type="hidden" name="item_id[]" value="{{ $row_data[0] }}"
                                        readonly="readonly">
                                    <input class="left-element" type="hidden" name="item_name[]"
                                        value="{{ $row_data[1] }}" readonly="readonly">
                                    <input type="hidden" name="lookup_id[]" value="{{ $row_data[2] }}"
                                        readonly="readonly">
                                    <input type="hidden" name="lookup_code[]" value="{{ $code }}"
                                        readonly="readonly">
                                    <input type="hidden" name="lookupdata_code[]" value="{{ $row_data[3] }}"
                                        readonly="readonly">
                                    <input type='hidden' class='' id='' name='unit_intensity[]'><input
                                        type='hidden' class='' id='' name='session_duration[]'> <input
                                        type='hidden' class='' id='' name='no_of_session[]'> <input
                                        type='hidden' class='' id='' name='session_mu[]'>
                                    <input type='hidden' class='' id='' name='frequency[]'>
                                    <input type='hidden' class='' id='' name='mode[]'>
                                    <i class="fa fa-angle-double-right"></i> {{ $row_data[1] }}&nbsp;&nbsp;
                                    <span class="float-right text-danger cursor-pointer" title="Remove This Item"
                                        onclick="removeParentElement(this)"><i
                                            class="fa fa-times"></i></span>&nbsp;<span
                                        class="float-right text-secondary mr-1 cursor-pointer" style="font-size:11px;"
                                        title="Add To Favourite List"
                                        onclick="prescriptionFunc.addToPresFavouritList(this)"
                                        data-url="{{ $add_to_pres_url }}" data-id="{{ $row_data[0] }}"
                                        data-name="{{ $row_data[1] }}" data-type="{{ $code }}"><i
                                            class="fa fa-star text-primary"></i></span>
                                </li>
                            @endforeach
                        @endforeach
                    </ul>
                @else
                    <ul class="list-unstyled mb-0 pt-1" id="investigation"></ul>
                @endif
            </div>
        </div>
        <div class="col-md-8">
            <div class="form-group mb-0">
                <label for="clinical_disease" class="col-form-label col-form-label-sm">Investigation Findings</label>
                <input type="text" class="form-control mb-0" id="investigation_findings"
                    name="investigation_findings" placeholder="Write Investigation Findings"
                    onclick="prescriptionFunc.loadToPresFavouritList(this,'FINDINGS','Inv. Findings','#investigation_find_con', '{{ $action_url }}')"
                    data-lookup-id="" data-lookup-code="FINDINGS">
                    {{-- {{ $lookup_id_arr->FINDINGS }} --}}
                <div class="card mt-0">
                    <div class="card-body p-0">
                        @if (!empty($find_arr))
                            @php
                                $class = !empty($find_arr) ? ' border p-1' : '';
                            @endphp
                            <ul class="list-unstyled mb-0 pt-1 {{ $class }}" id="investigation_find_con">
                                @foreach ($find_arr as $rows)
                                    @foreach ($rows as $row)
                                        @php
                                            $row_data = explode('_', $row);
                                        @endphp
                                        <li id="item-{{ $row_data[0] }}">
                                            <input type="hidden" name="item_id[]" value="{{ $row_data[0] }}"
                                                readonly="readonly">
                                            <input class="left-element" type="hidden" name="item_name[]"
                                                value="{{ $row_data[1] }}" readonly="readonly">
                                            <input type="hidden" name="lookup_id[]" value="{{ $row_data[2] }}"
                                                readonly="readonly">
                                            <input type="hidden" name="lookup_code[]" value="FINDINGS"
                                                readonly="readonly">
                                            <input type="hidden" name="lookupdata_code[]"
                                                value="{{ $row_data[3] }}" readonly="readonly">
                                            <input type='hidden' class='' id=''
                                                name='unit_intensity[]'><input type='hidden' class=''
                                                id='' name='session_duration[]'> <input type='hidden'
                                                class='' id='' name='no_of_session[]'> <input
                                                type='hidden' class='' id='' name='session_mu[]'>
                                            <input type='hidden' class='' id='' name='frequency[]'>
                                            <input type='hidden' class='' id='' name='mode[]'>
                                            <i class="fa fa-angle-double-right"></i> {{ $row_data[1] }}&nbsp;&nbsp;
                                            <span class="float-right text-danger cursor-pointer"
                                                title="Remove This Item" onclick="removeParentElement(this)"><i
                                                    class="fa fa-times"></i></span>&nbsp;<span
                                                class="float-right text-secondary mr-1 cursor-pointer"
                                                style="font-size:11px;" title="Add To Favourite List"
                                                onclick="prescriptionFunc.addToPresFavouritList(this)"
                                                data-url="{{ $add_to_pres_url }}" data-id="{{ $row_data[0] }}"
                                                data-name="{{ $row_data[1] }}" data-type="FINDINGS"><i
                                                    class="fa fa-star text-primary"></i></span>
                                        </li>
                                    @endforeach
                                @endforeach
                            </ul>
                        @else
                            <ul class="list-unstyled mb-0 pt-1" id="investigation_find_con"></ul>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        @if (Session::get('user.ses_hospital_code') != 'IMPALA')
            {{-- <div class="col-md-4">
                <div class="form-group">
                    <label for="clinical_disease" class="col-form-label col-form-label-sm">Note</label>
                    <input type="text" class="form-control mb-0 text-capitalize" id="investigation_note"
                        name="investigation_note" placeholder="Write Investigation Note">
                </div>
            </div> --}}
        @endif
    </div>


</div>



<!-- Radiology & Pathology Report Print Modal -->
<div class="modal fade" id="radiologyPathologyReport" tabindex="-1" role="dialog"
    aria-labelledby="radiologyPathologyReportTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title" id="exampleModalLongTitle">Radiology & Pathology Report Print</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-row">
                    <div class="col-md-6">
                        <label for="department" class="col-form-label col-form-label-sm d-block">Department</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="reportType"
                                id="reportTypeRadiology" value="">
                            <label class="form-check-label" for="reportTypeRadiology">Radiology</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="reportType"
                                id="reportTypePathology" value="">
                            <label class="form-check-label" for="reportTypePathology">Pathology</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="department" class="col-form-label col-form-label-sm">Department</label>
                        <select class="form-control" id="department" name="department">
                            <option value="0">Select Department</option>
                            <option value="">Department-1</option>
                            <option value="">Department-2</option>
                        </select>
                    </div>

                </div>
            </div>
            <div class="modal-footer py-1">
                <div class="col-md-12 text-right">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-sm btn-primary"><i class="fas fa-print"></i> Print</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function handleAcupName(val) {
        alert('Hello ' + val);
    }
</script>
