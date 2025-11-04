@php
    $company = (isset($data) && (!empty($data))) ? $data : [];
    $drug_drug_interact_no_pk = ($company) ? $company->drug_drug_interact_no_pk : '';
    $drug_name = ($company) ? $company->drug_name : '';
    $interact_drug_name = ($company) ? $company->interact_drug_name : '';
    $interaction_alert_msg = ($company) ? $company->interaction_alert_msg : '';
    $severiaty_text = ($company) ? $company->severiaty_text : '';
@endphp
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<form method="post" action="{{route('prescription-interaction.drug-drug-interaction-store')}}"  enctype="multipart/form-data" id="hospital_form">
    @csrf
    <input type="hidden" name="id" value="{{$drug_drug_interact_no_pk}}">
    <div class="form-row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="form-row">
                <div class="col-12">
                    <div class="form-group">
                        <label for="drug_name" class="col-form-label col-form-label-sm">Drug Name</label>
                        <input type="text" class="form-control form-control-sm" id="drug_name" name="drug_name" value="{{$drug_name}}" placeholder="Drug Name" autofocus="">
                        <input type="hidden" name="drug_id" id="drug_id" value="">
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <label for="interaction_drug_name" class="col-form-label col-form-label-sm">Interaction Drug Name</label>
                        <input type="text" class="form-control form-control-sm" id="interaction_drug_name" name="interaction_drug_name" value="{{$interact_drug_name}}" placeholder="Interaction Drug Name">
                        <input type="hidden" name="interaction_drug_id" id="interaction_drug_id">
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <label for="interaction_alert_message" class="col-form-label col-form-label-sm">Interaction Alert Message</label>
                        <textarea class="form-control form-control-sm" value="" id="interaction_alert_message" name="interaction_alert_message" rows="3"  placeholder="Interaction Alert Message">{{$interaction_alert_msg}}</textarea>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <label for="severity_department" class="col-form-label col-form-label-sm">Severity</label>
                        <select class="form-control form-control-sm" id="severity_department"
                                name="severity_department">
                            <option value="">Select Severity</option>
                            @if($severity)
                                @foreach($severity as $value)
                                    <option value="{{$value}}" {{$severiaty_text==$value ? 'selected' : ''  }}>{{$value}}</option>
                                @endforeach
                            @endif
                        </select>


                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        @php $response_action = route('prescription-interaction.drug-drug-interaction-all-data'); @endphp
        <div class="col-md-12 mt-2">
            <button type="button" class="btn btn-md btn-success "  onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')" title="Click here to save for save drug drug interaction" ><i class="fa fa-save"></i> Save</button>
            <button type="reset" class="btn btn-info btn-md " title="Click here to Clear form data">Clear</button>
            <a href="#" class="btn btn-danger btn-md " rel="tab" title="Click here to go back to Dashboard">Exit</a>
        </div>
    </div>
</form>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script>
    openItemAutocomplete ($("#drug_name"),'MED','#drug_id','#drug_name');
    openItemAutocomplete ($("#interaction_drug_name"),'MED','#interaction_drug_id','#interaction_drug_name');
</script>
