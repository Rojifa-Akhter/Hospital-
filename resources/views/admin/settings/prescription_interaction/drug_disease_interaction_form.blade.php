@php
$drugDiseaseInteract = (isset($drugDiseaseInteract) && (!empty($drugDiseaseInteract))) ? $drugDiseaseInteract : [];
$DRUG_DISSEASE_INTERACT_NO_PK = ($drugDiseaseInteract) ? $drugDiseaseInteract->drug_dissease_interact_no_pk : '';
$DRUG_NAME = ($drugDiseaseInteract) ? $drugDiseaseInteract->drug_name : '';
$DRUG_ITEM_NO_FK = ($drugDiseaseInteract) ? $drugDiseaseInteract->drug_item_no_fk : '';
$DISSEASE_NAME = ($drugDiseaseInteract) ? $drugDiseaseInteract->dissease_name : '';
$INTERACTION_ALERT_MSG = ($drugDiseaseInteract) ? $drugDiseaseInteract->interaction_alert_msg : '';
$SEVERIATY_TEXT = ($drugDiseaseInteract) ? $drugDiseaseInteract->severiaty_text : '';
$status = ($drugDiseaseInteract) ? $drugDiseaseInteract->status : '';
@endphp
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css')}}">

<form action="{{ route('Prescription-Interaction.drug-disease-interaction-store') }}" method="post" id="drug_disease_interact">
    @csrf
    <input type="hidden" name="id" value="{{$DRUG_DISSEASE_INTERACT_NO_PK}}">
    <div class="form-row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="form-row">
                <div class="col-12">
                    <div class="form-group">
                        <label for="drug_name" class="col-form-label col-form-label-sm">Drug Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-sm" id="drug_name" name="drug_name" value="{{$DRUG_NAME}}"
                        placeholder="Drug Name" autofocus="">
                        <input type="hidden" name="hdn_drug_name" id="hdn_drug_name" value="{{$DRUG_ITEM_NO_FK}}">
                    </div>
                </div>

                <div class="col-12">
                    <div class="form-group">
                        <label for="interaction_disease_name" class="col-form-label col-form-label-sm">Interaction
                            Disease
                            Name <span class="text-danger">*</span></label>
                            <select class="form-control font_size_12 m-auto select2" id="interaction_disease_name"
                            name="interaction_disease_name">
                            <option selected="selected" value="">Select Disease Name</option>
                            @foreach ($drugDiseaseInteractionForm as $value)
                            <option value="{{ $value->pres_lookupdata_no_pk }}_{{ $value->pres_lookup_code }}" @if($DISSEASE_NAME == $value->pres_lookup_code ) selected @endif>
                                {{ $value->pres_lookup_code }}</option>
                                @endforeach
                            </select>

                        </div>
                    </div>


                    <div class="col-12">
                        <div class="form-group">
                            <label for="interaction_alert_message" class="col-form-label col-form-label-sm">Interaction
                                Alert
                            Message</label>
                            <textarea class="form-control form-control-sm" id="interaction_alert_message"
                            name="interaction_alert_message" rows="3"
                            placeholder="Interaction Alert Message" value="">{{$INTERACTION_ALERT_MSG}}</textarea>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-group">
                            <label for="severity_department" class="col-form-label col-form-label-sm">Severity <span class="text-danger">*</span></label>

                            <select class="form-control form-control-sm select2" id="severity_department"
                            name="severity_department">
                            <option value="">Select Severity</option>
                            @if($severity)
                            @foreach($severity as $value)
                            <option value="{{$value}}" {{$SEVERIATY_TEXT==$value ? 'selected' : ''  }}>{{$value}}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="text-right col-md-12 text-right mt-2">
            <div class="modal-footer">
                @php
                $response_action = route('Prescription-Interaction.drug-disease-interaction');
                @endphp
                <button class="btn btn-success btn-md"
                onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">
            Save</button>
            <button type="reset" class="btn btn-info btn-md" title="Click here to Clear form data">Clear</button>
            <a href="#" class="btn btn-danger btn-md" rel="tab" data-dismiss="modal"
            title="Click here to go back to Dashboard">Exit</a>
        </div>
    </div>

</form>

<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js')}}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>

<script>
    openItemAutocomplete($("#drug_name"), 'MED', '#hdn_drug_name', '#drug_name');
    $('.select2').select2();
</script>
