<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">

<a href="{{ route('icu.central-line-insertion-form', [$patient_data->patient_no_fk, $patient_data->admission_uid]) }}"
    class="btn btn-md btn-primary w-100 text-white mt-1">
    Central Line Insertion
</a>

<a href="{{ route('icu.ventilator-associated-events-form', [$patient_data->patient_no_fk, $patient_data->admission_uid]) }}"
    class="btn btn-md btn-primary w-100 text-white mt-1">
    Ventilator Bundle
</a>

<a style="cursor:pointer" class="btn btn-md btn-primary w-100 text-white mt-1 open-modal" data-modal="common-modal-xl"
    data-title="Indwelling Urinary Catheter Checklist"
    data-action="{{ route('indwelling-urinary-catheter-checklist', [@$patient_data->patient_no_fk, @$patient_data->admission_uid]) }}">
    Indwelling Urinary Catheter </a>

