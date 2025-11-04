<style>
    .table-responsive .table tbody tr .second_heading {
        padding: 7px !important;
        text-align: left;
        font-size: 12px !important;
        color: #333;
        font-weight: 500;
        width: 25%;
    }
    .segment_row{
        border-bottom:2px solid #333 !important;
    }

</style>
@php
$edit_iief = isset($edit_iief) && !empty($edit_iief) ? $edit_iief : [];
@endphp
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">

<div class="container-fluid">
    {{-- <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm">
        <div class="col-md-12">
            <h5 class="mt-2 mb-0">The IIEF-5 Questionnaire (SHIM)</h5>
            <small>Prescription / The IIEF-5 Questionnaire (SHIM)</small>
        </div>
    </div>
    <form action="{{ route('store-IIEF-5-questionnaire') }}" id="iief_form" method="POST">
        @csrf --}}
        <input type="hidden" class="total_shim_score" name="total_shim_score" />
        {{-- <input type="hidden" class="total_ipss_score" name="total_ipss_score" /> --}}
        <input type="hidden" name="id" value="{{ $prescription_id }}" />
        {{-- <input type="hidden" name="hdn_patient_id_edit" value="{{ $hdn_patient_id }}" /> --}}

        <div class="form-row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body mt-2">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover mb-0">
                                <thead class="bg-light-blue">
                                    <tr>
                                        <th class="text-left align-middle segment_row" colspan="6">Over the past 6 months:</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- 1st row --}}
                                    <tr>
                                        <td class="second_heading align-middle segment_row" rowspan="2">

                                            1. {{ $iief[0]->pres_lookupdata_name }}
                                        </td>

                                        <th class="text-center align-middle">Very low</th>
                                        <th class="text-center align-middle">Low</th>
                                        <th class="text-center align-middle">Moderate</th>
                                        <th class="text-center align-middle">High</th>
                                        <th class="text-center align-middle">Very high</th>
                                    </tr>
                                    <tr>
                                        <td class="text-center align-middle segment_row">
                                            <div class="form-group form-check">
                                                <input type="radio" class="form-check-input iief_row_rec row1"
                                                    value="{{ '1' .'~' .$iief[0]->pres_lookupdata_name .'~' .$iief[0]->pres_lookupdata_no_pk .'~' .$iief[0]->pres_lookupdata_code }}"
                                                    iief_data-row="1" name="iief_row1" iief_data-value="1"
                                                    {{ isset($edit_iief[0]) ? ($edit_iief[0]->very_low_ind == '1' ? 'checked' : ''):'' }} />
                                                <label class="form-check-label" for="exampleCheck1">1</label>
                                            </div>
                                        </td>
                                        <td class="text-center align-middle segment_row">
                                            <div class="form-group form-check">
                                                <input type="radio" class="form-check-input iief_row_rec row1"
                                                    value="{{ '2' .'~' .$iief[0]->pres_lookupdata_name .'~' .$iief[0]->pres_lookupdata_no_pk .'~' .$iief[0]->pres_lookupdata_code }}"
                                                    iief_data-row="1" name="iief_row1" iief_data-value="2"
                                                    {{ isset($edit_iief[0]) ? ($edit_iief[0]->low_ind == '2' ? 'checked' : ''):'' }} />
                                                <label class="form-check-label" for="exampleCheck2">2</label>
                                            </div>
                                        </td>
                                        <td class="text-center align-middle segment_row">
                                            <div class="form-group form-check">
                                                <input type="radio" class="form-check-input iief_row_rec row1"
                                                    value="{{ '3' .'~' .$iief[0]->pres_lookupdata_name .'~' .$iief[0]->pres_lookupdata_no_pk .'~' .$iief[0]->pres_lookupdata_code }}"
                                                    iief_data-row="1" name="iief_row1" iief_data-value="3"
                                                    {{ isset($edit_iief[0]) ? ($edit_iief[0]->moderate_ind == '3' ? 'checked' : ''):'' }} />
                                                <label class="form-check-label" for="exampleCheck3">3</label>
                                            </div>
                                        </td>
                                        <td class="text-center align-middle segment_row">
                                            <div class="form-group form-check">
                                                <input type="radio" class="form-check-input iief_row_rec row1"
                                                    value="{{ '4' .'~' .$iief[0]->pres_lookupdata_name .'~' .$iief[0]->pres_lookupdata_no_pk .'~' .$iief[0]->pres_lookupdata_code }}"
                                                    iief_data-row="1" name="iief_row1" iief_data-value="4"
                                                    {{ isset($edit_iief[0]) ? ($edit_iief[0]->high_ind == '4' ? 'checked' : ''):'' }} />
                                                <label class="form-check-label" for="exampleCheck4">4</label>
                                            </div>
                                        </td>
                                        <td class="text-center align-middle segment_row">
                                            <div class="form-group form-check">
                                                <input type="radio" class="form-check-input iief_row_rec row1"
                                                    value="{{ '5' .'~' .$iief[0]->pres_lookupdata_name .'~' .$iief[0]->pres_lookupdata_no_pk .'~' .$iief[0]->pres_lookupdata_code }}"
                                                    iief_data-row="1" name="iief_row1" iief_data-value="5"
                                                    {{ isset($edit_iief[0]) ? ($edit_iief[0]->very_high_ind == '5' ? 'checked' : ''):'' }} />
                                                <label class="form-check-label" for="exampleCheck5">5</label>
                                            </div>
                                        </td>

                                    </tr>
                                    {{-- 1st row --}}

                                    {{-- 2nd row --}}

                                    <tr>
                                        <td class="second_heading align-middle segment_row" rowspan="3">

                                            2. {{ $iief[1]->pres_lookupdata_name }}
                                        </td>

                                        <th class="text-center align-middle">Almost never or never</th>
                                        <th class="text-center align-middle">A few times</th>
                                        <th class="text-center align-middle">Sometimes</th>
                                        <th class="text-center align-middle">Most times</th>
                                        <th class="text-center align-middle">Almost always or always</th>
                                    </tr>

                                    <tr>
                                        <td class="text-center align-middle"></td>
                                        <td class="text-center align-middle">(much less than half the time)</td>
                                        <td class="text-center align-middle">(about half the time)</td>
                                        <td class="text-center align-middle">(much more than half the time)</td>
                                        <td class="text-center align-middle"></td>

                                    </tr>


                                    <tr>
                                        <td class="text-center align-middle segment_row">
                                            <div class="form-group form-check">
                                                <input type="radio" class="form-check-input iief_row_rec row2"
                                                    value="{{ '1' .'~' .$iief[1]->pres_lookupdata_name .'~' .$iief[1]->pres_lookupdata_no_pk .'~' .$iief[1]->pres_lookupdata_code }}"
                                                    iief_data-row="2" name="iief_row2" iief_data-value="1"
                                                    {{ isset($edit_iief[1]) ? ($edit_iief[1]->very_low_ind == '1' ? 'checked' : ''):'' }} />
                                                <label class="form-check-label" for="exampleCheck1">1</label>
                                            </div>
                                        </td>
                                        <td class="text-center align-middle segment_row">
                                            <div class="form-group form-check">
                                                <input type="radio" class="form-check-input iief_row_rec row2"
                                                    value="{{ '2' .'~' .$iief[1]->pres_lookupdata_name .'~' .$iief[1]->pres_lookupdata_no_pk .'~' .$iief[1]->pres_lookupdata_code }}"
                                                    iief_data-row="2" name="iief_row2" iief_data-value="2"
                                                    {{ isset($edit_iief[1]) ? ($edit_iief[1]->low_ind == '2' ? 'checked' : ''):'' }} />
                                                <label class="form-check-label" for="exampleCheck2">2</label>
                                            </div>
                                        </td>
                                        <td class="text-center align-middle segment_row">
                                            <div class="form-group form-check">
                                                <input type="radio" class="form-check-input iief_row_rec row2"
                                                    value="{{ '3' .'~' .$iief[1]->pres_lookupdata_name .'~' .$iief[1]->pres_lookupdata_no_pk .'~' .$iief[1]->pres_lookupdata_code }}"
                                                    iief_data-row="2" name="iief_row2" iief_data-value="3"
                                                    {{ isset($edit_iief[1]) ? ($edit_iief[1]->moderate_ind == '3' ? 'checked' : ''):'' }} />
                                                <label class="form-check-label" for="exampleCheck3">3</label>
                                            </div>
                                        </td>
                                        <td class="text-center align-middle segment_row">
                                            <div class="form-group form-check">
                                                <input type="radio" class="form-check-input iief_row_rec row2"
                                                    value="{{ '4' .'~' .$iief[1]->pres_lookupdata_name .'~' .$iief[1]->pres_lookupdata_no_pk .'~' .$iief[1]->pres_lookupdata_code }}"
                                                    iief_data-row="2" name="iief_row2" iief_data-value="4"
                                                    {{ isset($edit_iief[1]) ? ($edit_iief[1]->high_ind == '4' ? 'checked' : ''):'' }} />
                                                <label class="form-check-label" for="exampleCheck4">4</label>
                                            </div>
                                        </td>
                                        <td class="text-center align-middle segment_row">
                                            <div class="form-group form-check">
                                                <input type="radio" class="form-check-input iief_row_rec row2"
                                                    value="{{ '5' .'~' .$iief[1]->pres_lookupdata_name .'~' .$iief[1]->pres_lookupdata_no_pk .'~' .$iief[1]->pres_lookupdata_code }}"
                                                    iief_data-row="2" name="iief_row2" iief_data-value="5"
                                                    {{ isset($edit_iief[1]) ? ($edit_iief[1]->very_high_ind == '5' ? 'checked' : ''):'' }} />
                                                <label class="form-check-label" for="exampleCheck5">5</label>
                                            </div>
                                        </td>

                                    </tr>
                                    {{-- 2nd row --}}

                                    {{-- 3rd row --}}
                                    <tr>
                                        <td class="second_heading align-middle segment_row" rowspan="3">

                                            3. {{ $iief[2]->pres_lookupdata_name }}
                                        </td>

                                        <th class="text-center align-middle">Almost never or never</th>
                                        <th class="text-center align-middle">A few times</th>
                                        <th class="text-center align-middle">Sometimes</th>
                                        <th class="text-center align-middle">Most times</th>
                                        <th class="text-center align-middle">Almost always or always</th>
                                    </tr>

                                    <tr>
                                        <td class="text-center align-middle"></td>
                                        <td class="text-center align-middle">(much less than half the time)</td>
                                        <td class="text-center align-middle">(about half the time)</td>
                                        <td class="text-center align-middle">(much more than half the time)</td>
                                        <td class="text-center align-middle"></td>

                                    </tr>


                                    <tr>
                                        <td class="text-center align-middle segment_row">
                                            <div class="form-group form-check">
                                                <input type="radio" class="form-check-input iief_row_rec row3"
                                                    value="{{ '1' .'~' .$iief[2]->pres_lookupdata_name .'~' .$iief[2]->pres_lookupdata_no_pk .'~' .$iief[2]->pres_lookupdata_code }}"
                                                    iief_data-row="3"

                                                    name="iief_row3" iief_data-value="1"
                                                    {{ isset($edit_iief[2]) ? ($edit_iief[2]->very_low_ind == '1' ? 'checked' : ''):'' }} />
                                                <label class="form-check-label" for="exampleCheck1">1</label>
                                            </div>
                                        </td>
                                        <td class="text-center align-middle segment_row">
                                            <div class="form-group form-check">
                                                <input type="radio" class="form-check-input iief_row_rec row3"
                                                    value="{{ '2' .'~' .$iief[2]->pres_lookupdata_name .'~' .$iief[2]->pres_lookupdata_no_pk .'~' .$iief[2]->pres_lookupdata_code }}"
                                                    iief_data-row="3"

                                                    name="iief_row3" iief_data-value="2"
                                                    {{ isset($edit_iief[2]) ? ($edit_iief[2]->low_ind == '2' ? 'checked' : ''):'' }} />
                                                <label class="form-check-label" for="exampleCheck2">2</label>
                                            </div>
                                        </td>
                                        <td class="text-center align-middle segment_row">
                                            <div class="form-group form-check">
                                                <input type="radio" class="form-check-input iief_row_rec row3"
                                                    value="{{ '3' .'~' .$iief[2]->pres_lookupdata_name .'~' .$iief[2]->pres_lookupdata_no_pk .'~' .$iief[2]->pres_lookupdata_code }}"
                                                    iief_data-row="3"

                                                    name="iief_row3" iief_data-value="3"
                                                    {{ isset($edit_iief[2]) ? ($edit_iief[2]->moderate_ind == '3' ? 'checked' : ''):'' }} />
                                                <label class="form-check-label" for="exampleCheck3">3</label>
                                            </div>
                                        </td>
                                        <td class="text-center align-middle segment_row">
                                            <div class="form-group form-check">
                                                <input type="radio" class="form-check-input iief_row_rec row3"
                                                    value="{{ '4' .'~' .$iief[2]->pres_lookupdata_name .'~' .$iief[2]->pres_lookupdata_no_pk .'~' .$iief[2]->pres_lookupdata_code }}"
                                                    iief_data-row="3"

                                                    name="iief_row3" iief_data-value="4"
                                                    {{ isset($edit_iief[2]) ? ($edit_iief[2]->high_ind == '4' ? 'checked' : ''):'' }} />
                                                <label class="form-check-label" for="exampleCheck4">4</label>
                                            </div>
                                        </td>
                                        <td class="text-center align-middle segment_row">
                                            <div class="form-group form-check">
                                                <input type="radio" class="form-check-input iief_row_rec row3"
                                                    value="{{ '5' .'~' .$iief[2]->pres_lookupdata_name .'~' .$iief[2]->pres_lookupdata_no_pk .'~' .$iief[2]->pres_lookupdata_code }}"
                                                    iief_data-row="3"

                                                    name="iief_row3" iief_data-value="5"
                                                    {{ isset($edit_iief[2]) ? ($edit_iief[2]->very_high_ind == '5' ? 'checked' : ''):'' }} />
                                                <label class="form-check-label" for="exampleCheck5">5</label>
                                            </div>
                                        </td>

                                    </tr>
                                    {{-- 3rd row --}}

                                    {{-- 4th row --}}
                                    <tr>
                                        <td class="second_heading align-middle segment_row" rowspan="2">

                                            4. {{ $iief[3]->pres_lookupdata_name }}
                                        </td>

                                        <th class="text-center align-middle">Extremely difficult</th>
                                        <th class="text-center align-middle">Very difficult</th>
                                        <th class="text-center align-middle">Difficult</th>
                                        <th class="text-center align-middle">Slightly difficult</th>
                                        <th class="text-center align-middle">Not difficult</th>
                                    </tr>
                                    <tr>
                                        <td class="text-center align-middle segment_row">
                                            <div class="form-group form-check">
                                                <input type="radio" class="form-check-input iief_row_rec row4"
                                                    value="{{ '1' .'~' .$iief[3]->pres_lookupdata_name .'~' .$iief[3]->pres_lookupdata_no_pk .'~' .$iief[3]->pres_lookupdata_code }}"
                                                    iief_data-row="4" name="iief_row4" iief_data-value="1"
                                                    {{ isset($edit_iief[3]) ? ($edit_iief[3]->very_low_ind == '1' ? 'checked' : ''):'' }} />
                                                <label class="form-check-label" for="exampleCheck1">1</label>
                                            </div>
                                        </td>
                                        <td class="text-center align-middle segment_row">
                                            <div class="form-group form-check">
                                                <input type="radio" class="form-check-input iief_row_rec row4"
                                                    value="{{ '2' .'~' .$iief[3]->pres_lookupdata_name .'~' .$iief[3]->pres_lookupdata_no_pk .'~' .$iief[3]->pres_lookupdata_code }}"
                                                    iief_data-row="4" name="iief_row4" iief_data-value="2"
                                                    {{ isset($edit_iief[3]) ? ($edit_iief[3]->low_ind == '2' ? 'checked' : ''):'' }} />
                                                <label class="form-check-label" for="exampleCheck2">2</label>
                                            </div>
                                        </td>
                                        <td class="text-center align-middle segment_row">
                                            <div class="form-group form-check">
                                                <input type="radio" class="form-check-input iief_row_rec row4"
                                                    value="{{ '3' .'~' .$iief[3]->pres_lookupdata_name .'~' .$iief[3]->pres_lookupdata_no_pk .'~' .$iief[3]->pres_lookupdata_code }}"
                                                    iief_data-row="4" name="iief_row4" iief_data-value="3"
                                                    {{ isset($edit_iief[3]) ? ($edit_iief[3]->moderate_ind == '3' ? 'checked' : ''):'' }} />
                                                <label class="form-check-label" for="exampleCheck3">3</label>
                                            </div>
                                        </td>
                                        <td class="text-center align-middle segment_row">
                                            <div class="form-group form-check">
                                                <input type="radio" class="form-check-input iief_row_rec row4"
                                                    value="{{ '4' .'~' .$iief[3]->pres_lookupdata_name .'~' .$iief[3]->pres_lookupdata_no_pk .'~' .$iief[3]->pres_lookupdata_code }}"
                                                    iief_data-row="4" name="iief_row4" iief_data-value="4"
                                                    {{ isset($edit_iief[3]) ? ($edit_iief[3]->high_ind == '4' ? 'checked' : ''):'' }} />
                                                <label class="form-check-label" for="exampleCheck4">4</label>
                                            </div>
                                        </td>
                                        <td class="text-center align-middle segment_row">
                                            <div class="form-group form-check">
                                                <input type="radio" class="form-check-input iief_row_rec row4"
                                                    value="{{ '5' .'~' .$iief[3]->pres_lookupdata_name .'~' .$iief[3]->pres_lookupdata_no_pk .'~' .$iief[3]->pres_lookupdata_code }}"
                                                    iief_data-row="4" name="iief_row4" iief_data-value="5"
                                                    {{ isset($edit_iief[3]) ? ($edit_iief[3]->very_high_ind == '5' ? 'checked' : ''):'' }} />
                                                <label class="form-check-label" for="exampleCheck5">5</label>
                                            </div>
                                        </td>
                                    </tr>
                                    {{-- 4th row --}}

                                    {{-- 5th row --}}
                                    <tr>
                                        <td class="second_heading align-middle segment_row" rowspan="3>

                                            5. {{ $iief[4]->pres_lookupdata_name }}
                                        </td>

                                        <th class="text-center align-middle">Almost never or never</th>
                                        <th class="text-center align-middle">A few times</th>
                                        <th class="text-center align-middle">Sometimes</th>
                                        <th class="text-center align-middle">Most times</th>
                                        <th class="text-center align-middle">Almost always or always</th>
                                    </tr>

                                    <tr>
                                        <td class="text-center align-middle"></td>
                                        <td class="text-center align-middle">(much less than half the time)</td>
                                        <td class="text-center align-middle">(about half the time)</td>
                                        <td class="text-center align-middle">(much more than half the time)</td>
                                        <td class="text-center align-middle"></td>

                                    </tr>


                                    <tr>
                                        <td class="text-center align-middle segment_row">
                                            <div class="form-group form-check">
                                                <input type="radio" class="form-check-input5 iief_row_rec row5"
                                                    value="{{ '1' .'~' .$iief[4]->pres_lookupdata_name .'~' .$iief[4]->pres_lookupdata_no_pk .'~' .$iief[4]->pres_lookupdata_code }}"
                                                    iief_data-row="5" name="iief_row5"
                                                    iief_data-value="1" {{ isset($edit_iief[4]) ? ($edit_iief[4]->very_low_ind == '1' ? 'checked' : ''):'' }} />
                                                <label class="form-check-label" for="exampleCheck1">1</label>
                                            </div>
                                        </td>
                                        <td class="text-center align-middle segment_row">
                                            <div class="form-group form-check">
                                                <input type="radio" class="form-check-input5 iief_row_rec row5"
                                                    value="{{ '2' .'~' .$iief[4]->pres_lookupdata_name .'~' .$iief[4]->pres_lookupdata_no_pk .'~' .$iief[4]->pres_lookupdata_code }}"
                                                    iief_data-row="5" name="iief_row5" iief_data-value="2"
                                                    {{ isset($edit_iief[4]) ? ($edit_iief[4]->low_ind == '2' ? 'checked' : ''):'' }} />
                                                <label class="form-check-label" for="exampleCheck2">2</label>
                                            </div>
                                        </td>
                                        <td class="text-center align-middle segment_row">
                                            <div class="form-group form-check">
                                                <input type="radio" class="form-check-input5 iief_row_rec row5"
                                                    value="{{ '3' .'~' .$iief[4]->pres_lookupdata_name .'~' .$iief[4]->pres_lookupdata_no_pk .'~' .$iief[4]->pres_lookupdata_code }}"
                                                    iief_data-row="5" name="iief_row5" iief_data-value="3"
                                                    {{ isset($edit_iief[4]) ? ($edit_iief[4]->moderate_ind == '3' ? 'checked' : ''):'' }} />
                                                <label class="form-check-label" for="exampleCheck3">3</label>
                                            </div>
                                        </td>
                                        <td class="text-center align-middle segment_row">
                                            <div class="form-group form-check">
                                                <input type="radio" class="form-check-input5 iief_row_rec row5"
                                                    value="{{ '4' .'~' .$iief[4]->pres_lookupdata_name .'~' .$iief[4]->pres_lookupdata_no_pk .'~' .$iief[4]->pres_lookupdata_code }}"
                                                    iief_data-row="5" name="iief_row5" iief_data-value="4"
                                                    {{ isset($edit_iief[4]) ? ($edit_iief[4]->high_ind == '4' ? 'checked' : ''):'' }} />
                                                <label class="form-check-label" for="exampleCheck4">4</label>
                                            </div>
                                        </td>
                                        <td class="text-center align-middle segment_row">
                                            <div class="form-group form-check">
                                                <input type="radio" class="form-check-input5 iief_row_rec row5"
                                                    value="{{ '5' .'~' .$iief[4]->pres_lookupdata_name .'~' .$iief[4]->pres_lookupdata_no_pk .'~' .$iief[4]->pres_lookupdata_code }}"
                                                    iief_data-row="5" name="iief_row5" iief_data-value="5"
                                                    {{ isset($edit_iief[4]) ? ($edit_iief[4]->very_high_ind == '5' ? 'checked' : ''):'' }} />
                                                <label class="form-check-label" for="exampleCheck5">5</label>
                                            </div>
                                        </td>

                                    </tr>
                                    {{-- 5th row --}}

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th class="second_heading" colspan="6">
                                            <table class="table table-bordered m-0" style="width: 100%;">
                                                <tr>
                                                    <td class="text-center" style="padding: 10px 0px !important;">
                                                        Total Score:</td>
                                                    <td class="text-center iief_severe">1-7: Severe ED</td>
                                                    <td class="text-center iief_moderate">8-11: Moderate ED</td>
                                                    <td class="text-center iief_mild-moderate">12-16: Mild-moderate ED</td>
                                                    <td class="text-center iief_mild-ed">17-21: Mild ED</td>
                                                    <td class="text-center iief_no-ed">22-25: No ED</td>
                                                </tr>
                                            </table>
                                        </th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    {{-- </form> --}}
</div>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>

<script type="application/javascript">
    // openPatientAutocomplete('#patient_name', 'patient_name');
    // $('.date_picker').datepicker({
    //     format: 'dd-mm-yyyy',
    //     autoclose: true,
    //     todayHighlight: true,
    //     clearBtn: true,
    // });
    // $(document).on('keyup', '#patient_name', function() {

    //     if ($(this).val() == '') {



    //         $('#hdn_patient_id').val('');

    //     }

    // });

    // $('input.row1').on('change', function() {
    //     //alert('hi');
    //     $('input.row1').not(this).prop('checked', false);
    // });
    // $('input.row2').on('change', function() {
    //     //alert('hi');
    //     $('input.row2').not(this).prop('checked', false);
    // });
    // $('input.row3').on('change', function() {
    //     //alert('hi');
    //     $('input.row3').not(this).prop('checked', false);
    // });
    // $('input.row4').on('change', function() {
    //     //alert('hi');
    //     $('input.row4').not(this).prop('checked', false);
    // });
    // $('input.row5').on('change', function() {
    //     //alert('hi');
    //     $('input.row5').not(this).prop('checked', false);
    // });
    var iief_count = 0;
    $(".iief_row_rec").each(function() {
        if ($(this).is(':checked')) {
            var iief_value = parseFloat($(this).attr('iief_data-value'));
            iief_count += iief_value
        }
        if ((1 <= iief_count) && (iief_count <= 7)) {
            $('.iief_severe').addClass('alert alert-warning');
        } else {
            $('.iief_severe').removeClass('alert alert-warning');

        }
        if ((8 <= iief_count) && (iief_count <= 11)) {
            $('.iief_moderate').addClass('alert alert-warning');
        } else {
            $('.iief_moderate').removeClass('alert alert-warning');

        }
        if ((12 <= iief_count) && (iief_count <= 16)) {
            $('.iief_mild-moderate').addClass('alert alert-warning');
        } else {
            $('.iief_mild-moderate').removeClass('alert alert-warning');

        }
        if ((17 <= iief_count) && (iief_count <= 21)) {
            $('.iief_mild-ed').addClass('alert alert-warning');
        } else {
            $('.iief_mild-ed').removeClass('alert alert-warning');

        }
        if ((22 <= iief_count) && (iief_count <= 25)) {
            $('.iief_no-ed').addClass('alert alert-warning');
        } else {
            $('.iief_no-ed').removeClass('alert alert-warning');

        }
        $('input.total_shim_score').val(iief_count);
        console.log(iief_count)

    });
    $(document).on('change', '.iief_row_rec', function() {

    $(this).parent('div').parent('td').parent('tr').find('.iief_row_rec').prop('checked', false);
    $(this).prop('checked', true);

    var iief_count3 = 0;
    $(".iief_row_rec").each(function() {
        if ($(this).is(':checked')) {
            var iief_value = parseFloat($(this).attr('iief_data-value'));
            iief_count3 += iief_value
        }
    });
    //$('input.total_ipss_score').val(iief_count3);

    if ((1 <= iief_count3) && (iief_count3 <= 7)) {
            $('.iief_severe').addClass('alert alert-warning');
        } else {
            $('.iief_severe').removeClass('alert alert-warning');

        }
        if ((8 <= iief_count3) && (iief_count3 <= 11)) {
            $('.iief_moderate').addClass('alert alert-warning');
        } else {
            $('.iief_moderate').removeClass('alert alert-warning');

        }
        if ((12 <= iief_count3) && (iief_count3 <= 16)) {
            $('.iief_mild-moderate').addClass('alert alert-warning');
        } else {
            $('.iief_mild-moderate').removeClass('alert alert-warning');

        }
        if ((17 <= iief_count3) && (iief_count3 <= 21)) {
            $('.iief_mild-ed').addClass('alert alert-warning');
        } else {
            $('.iief_mild-ed').removeClass('alert alert-warning');

        }
        if ((22 <= iief_count3) && (iief_count3 <= 25)) {
            $('.iief_no-ed').addClass('alert alert-warning');
        } else {
            $('.iief_no-ed').removeClass('alert alert-warning');

        }
        $('input.total_shim_score').val(iief_count3);
        console.log(iief_count3)

    });




    // var iief_count = 0;
    // var i = 0;
    // var prev_iief_value = 0;
    // var row_val0 = 0;
    // var row_val1 = 0;
    // var row_val2 = 0;
    // var row_val3 = 0;
    // var row_val4 = 0;
    // $('body').on('click','.iief_row_rec', function(){
    //     //let data_row = $(this).data('row');
    //    let data_iief_value = $(this).data('value');
    //     let data_row = $(this).data('row')

    //     if (data_row == 1) {
    //         row_val0 = data_value;
    //     }

    //     if (data_row == 2) {
    //         row_val1 = data_value;
    //     }

    //     if (data_row == 3) {
    //         row_val2 = data_value;
    //     }

    //     if (data_row == 4) {
    //         row_val3 = data_value;
    //     }

    //     if (data_row == 5) {
    //         row_val4 = data_value;
    //     }

    //     //console.log('record no ',data_row)
    //     if ($(this).prop('checked') === true) {
    //         i++;

    //         sum=(row_val0+row_val1+row_val2+row_val3+row_val4);
    //         if((1 <= sum) && (sum <= 7))
    //         {
    //             $('.severe').addClass('alert alert-warning');
    //         }
    //         else
    //         {
    //             $('.severe').removeClass('alert alert-warning');

    //         }
    //         if((8 <= sum) && (sum <= 11))
    //         {
    //             $('.moderate').addClass('alert alert-warning');
    //         }
    //         else
    //         {
    //             $('.moderate').removeClass('alert alert-warning');

    //         }
    //         if((12 <= sum) && (sum <= 16))
    //         {
    //             $('.mild-moderate').addClass('alert alert-warning');
    //         }
    //         else
    //         {
    //             $('.mild-moderate').removeClass('alert alert-warning');

    //         }
    //         if((17 <= sum) && (sum <= 21))
    //         {
    //             $('.mild-ed').addClass('alert alert-warning');
    //         }
    //         else
    //         {
    //             $('.mild-ed').removeClass('alert alert-warning');

    //         }
    //         if((22 <= sum) && (sum <= 25))
    //         {
    //             $('.no-ed').addClass('alert alert-warning');
    //         }
    //         else
    //         {
    //             $('.no-ed').removeClass('alert alert-warning');

    //         }

    //         // console.log('summery ',sum)
    //         // if(i==7)
    //         // {
    //             //     console.log(sum);

    //             // }
    //         }
    //     $('input.total_shim_score').val(sum);
    //     })



    //    function getValue(value)
    //    {

    //    let sum1 = 0;
    //    let j = 0;
    //        j++;
    //        sum1+=value;
    //        if(j==7)
    //        {
    //          console.log(sum1);

    //        }
    //    }
</script>
