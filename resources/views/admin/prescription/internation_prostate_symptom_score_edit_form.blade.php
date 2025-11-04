<style>
    .table-responsive .table thead tr .first_heading {
        width: 14%;
        font-size: 16px !important;
        font-weight: 800;
        padding: 10px !important;
        line-height: 1.3;
    }

    .table-responsive .table tbody tr .second_heading {
        padding: 7px !important;
        text-align: left;
        font-size: 12px !important;
        color: #333;
        font-weight: 500;
    }

    .table-responsive .table tbody tr .second_heading strong {
        color: #000;
        letter-spacing: 0.5px;
        font-weight: 800;
    }

</style>

<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
@php
$edit_ipss = isset($edit_ipss) && !empty($edit_ipss) ? $edit_ipss : [];

@endphp
<div class="container-fluid">

        <input type="hidden" class="total_ipss_score" name="total_ipss_score" />
        <input type="hidden" name="id" value="{{ $prescription_id }}" />



        <div class="form-row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body mt-2">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover mb-0">
                                <thead class="bg-light-blue">
                                    <tr>
                                        <th class="text-center align-middle first_heading">In the past month:</th>
                                        <th class="text-center align-middle">Not at All</th>
                                        <th class="text-center align-middle">Less than 1 in 5 Times</th>
                                        <th class="text-center align-middle">Less than Half the Time</th>
                                        <th class="text-center align-middle">About Half the Time</th>
                                        <th class="text-center align-middle">More than Half the Time</th>
                                        <th class="text-center align-middle">Almost Always</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="row_rec_tr">
                                        <th class="second_heading align-middle">
                                            <strong>1.Incomplete Emptying<br />
                                            </strong>{{ $ipss[0]->pres_lookupdata_name }}
                                        </th>

                                        <td class="text-center align-middle">
                                            <div class="form-group form-check">
                                                <input type="radio" class="form-check-input row_rec row1"
                                                    value="{{ '0' .'~' .$ipss[0]->pres_lookupdata_name .'~' .$ipss[0]->pres_lookupdata_no_pk .'~' .$ipss[0]->pres_lookupdata_code }}"
                                                    data-row="1" name="row1" data-value="0"
                                                    {{ isset($edit_ipss[0]) ? ($edit_ipss[0]->not_at_all_score== '0' ? 'checked' : '') : ''  }} />
                                                <label class="form-check-label" for="exampleCheck1">0</label>
                                            </div>
                                        </td>
                                        <td class="text-center align-middle">
                                            <div class="form-group form-check">
                                                <input type="radio" class="form-check-input row_rec row1"
                                                    value="{{ '1' .'~' .$ipss[0]->pres_lookupdata_name .'~' .$ipss[0]->pres_lookupdata_no_pk .'~' .$ipss[0]->pres_lookupdata_code }}"
                                                    data-row="1" name="row1" data-value="1"
                                                    {{ isset($edit_ipss[0]) ? ($edit_ipss[0]->less_than_1_to_5_tiems_scr == '1' ? 'checked' : ''): '' }} />
                                                <label class="form-check-label" for="exampleCheck2">1</label>
                                            </div>
                                        </td>
                                        <td class="text-center align-middle">
                                            <div class="form-group form-check">
                                                <input type="radio" class="form-check-input row_rec row1"
                                                    value="{{ '2' .'~' .$ipss[0]->pres_lookupdata_name .'~' .$ipss[0]->pres_lookupdata_no_pk .'~' .$ipss[0]->pres_lookupdata_code }}"
                                                    data-row="1" name="row1" data-value="2"
                                                    {{ isset($edit_ipss[0]) ? ($edit_ipss[0]->less_than_half_time_score == '2' ? 'checked' : ''): '' }} />
                                                <label class="form-check-label" for="exampleCheck3">2</label>
                                            </div>
                                        </td>
                                        <td class="text-center align-middle">
                                            <div class="form-group form-check">
                                                <input type="radio" class="form-check-input row_rec row1"
                                                    value="{{ '3' .'~' .$ipss[0]->pres_lookupdata_name .'~' .$ipss[0]->pres_lookupdata_no_pk .'~' .$ipss[0]->pres_lookupdata_code }}"
                                                    data-row="1" name="row1" data-value="3"
                                                    {{ isset($edit_ipss[0]) ? ($edit_ipss[0]->about_half_time_score == '3' ? 'checked' : ''): '' }} />
                                                <label class="form-check-label" for="exampleCheck4">3</label>
                                            </div>
                                        </td>
                                        <td class="text-center align-middle">
                                            <div class="form-group form-check">
                                                <input type="radio" class="form-check-input row_rec row1"
                                                    value="{{ '4' .'~' .$ipss[0]->pres_lookupdata_name .'~' .$ipss[0]->pres_lookupdata_no_pk .'~' .$ipss[0]->pres_lookupdata_code }}"
                                                    data-row="1" name="row1" data-value="4"
                                                    {{ isset($edit_ipss[0]) ? ($edit_ipss[0]->more_than_half_time_scr == '4' ? 'checked' : ''): '' }} />
                                                <label class="form-check-label" for="exampleCheck5">4</label>
                                            </div>
                                        </td>
                                        <td class="text-center align-middle">
                                            <div class="form-group form-check">
                                                <input type="radio" class="form-check-input row_rec row1"
                                                    value="{{ '5' .'~' .$ipss[0]->pres_lookupdata_name .'~' .$ipss[0]->pres_lookupdata_no_pk .'~' .$ipss[0]->pres_lookupdata_code }}"
                                                    data-row="1" name="row1" data-value="5"
                                                    {{ isset($edit_ipss[0]) ? ($edit_ipss[0]->almost_always_score == '5' ? 'checked' : ''): '' }} />
                                                <label class="form-check-label" for="exampleCheck6">5</label>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr class="row_rec_tr">
                                        <th class="second_heading align-middle">
                                            <strong>2.Frequency <br /> </strong>{{ $ipss[1]->pres_lookupdata_name }}
                                        </th>

                                        <td class="text-center align-middle">
                                            <div class="form-group form-check">
                                                <input type="radio" class="form-check-input row_rec row2"
                                                    value="{{ '0' .'~' .$ipss[1]->pres_lookupdata_name .'~' .$ipss[1]->pres_lookupdata_no_pk .'~' .$ipss[1]->pres_lookupdata_code }}"
                                                    data-row="2" name="row2" data-value="0"
                                                    {{ isset($edit_ipss[1]) ? ($edit_ipss[1]->not_at_all_score == '0' ? 'checked' : ''): '' }} />
                                                <label class="form-check-label" for="exampleCheck1">0</label>
                                            </div>
                                        </td>
                                        <td class="text-center align-middle">
                                            <div class="form-group form-check">
                                                <input type="radio" class="form-check-input row_rec row2"
                                                    value="{{ '1' .'~' .$ipss[1]->pres_lookupdata_name .'~' .$ipss[1]->pres_lookupdata_no_pk .'~' .$ipss[1]->pres_lookupdata_code }}"
                                                    data-row="2" name="row2" data-value="1"
                                                    {{ isset($edit_ipss[1]) ? ($edit_ipss[1]->less_than_1_to_5_tiems_scr == '1' ? 'checked' : ''): '' }} />
                                                <label class="form-check-label" for="exampleCheck2">1</label>
                                            </div>
                                        </td>
                                        <td class="text-center align-middle">
                                            <div class="form-group form-check">
                                                <input type="radio" class="form-check-input row_rec row2"
                                                    value="{{ '2' .'~' .$ipss[1]->pres_lookupdata_name .'~' .$ipss[1]->pres_lookupdata_no_pk .'~' .$ipss[1]->pres_lookupdata_code }}"
                                                    data-row="2" name="row2" data-value="2"
                                                    {{ isset($edit_ipss[1]) ? ($edit_ipss[1]->less_than_half_time_score == '2' ? 'checked' : ''): '' }} />
                                                <label class="form-check-label" for="exampleCheck3">2</label>
                                            </div>
                                        </td>
                                        <td class="text-center align-middle">
                                            <div class="form-group form-check">
                                                <input type="radio" class="form-check-input row_rec row2"
                                                    value="{{ '3' .'~' .$ipss[1]->pres_lookupdata_name .'~' .$ipss[1]->pres_lookupdata_no_pk .'~' .$ipss[1]->pres_lookupdata_code }}"
                                                    data-row="2" name="row2" data-value="3"
                                                    {{ isset($edit_ipss[1]) ? ($edit_ipss[1]->about_half_time_score == '3' ? 'checked' : ''): '' }} />
                                                <label class="form-check-label" for="exampleCheck4">3</label>
                                            </div>
                                        </td>
                                        <td class="text-center align-middle">
                                            <div class="form-group form-check">
                                                <input type="radio" class="form-check-input row_rec row2"
                                                    value="{{ '4' .'~' .$ipss[1]->pres_lookupdata_name .'~' .$ipss[1]->pres_lookupdata_no_pk .'~' .$ipss[1]->pres_lookupdata_code }}"
                                                    data-row="2" name="row2" data-value="4"
                                                    {{ isset($edit_ipss[1]) ? ($edit_ipss[1]->more_than_half_time_scr == '4' ? 'checked' : ''): '' }} />
                                                <label class="form-check-label" for="exampleCheck5">4</label>
                                            </div>
                                        </td>
                                        <td class="text-center align-middle">
                                            <div class="form-group form-check">
                                                <input type="radio" class="form-check-input row_rec row2"
                                                    value="{{ '5' .'~' .$ipss[1]->pres_lookupdata_name .'~' .$ipss[1]->pres_lookupdata_no_pk .'~' .$ipss[1]->pres_lookupdata_code }}"
                                                    data-row="2" name="row2" data-value="5"
                                                    {{ isset($edit_ipss[1]) ? ($edit_ipss[1]->almost_always_score == '5' ? 'checked' : ''): '' }} />
                                                <label class="form-check-label" for="exampleCheck6">5</label>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr class="row_rec_tr">
                                        <th class="second_heading align-middle">
                                            <strong>3.Intermittency <br />
                                            </strong>{{ $ipss[2]->pres_lookupdata_name }}
                                        </th>
                                        <td class="text-center align-middle">
                                            <div class="form-group form-check">
                                                <input type="radio" class="form-check-input row_rec row3"
                                                    value="{{ '0' .'~' .$ipss[2]->pres_lookupdata_name .'~' .$ipss[2]->pres_lookupdata_no_pk .'~' .$ipss[2]->pres_lookupdata_code }}"
                                                    data-row="3" name="row3" data-value="0"
                                                    {{ isset($edit_ipss[2]) ? ($edit_ipss[2]->not_at_all_score == '0' ? 'checked' : ''): '' }} />
                                                <label class="form-check-label" for="exampleCheck1">0</label>
                                            </div>
                                        </td>
                                        <td class="text-center align-middle">
                                            <div class="form-group form-check">
                                                <input type="radio" class="form-check-input row_rec row3"
                                                    value="{{ '1' .'~' .$ipss[2]->pres_lookupdata_name .'~' .$ipss[2]->pres_lookupdata_no_pk .'~' .$ipss[2]->pres_lookupdata_code }}"
                                                    data-row="3" name="row3" data-value="1"
                                                    {{ isset($edit_ipss[2]) ? ($edit_ipss[2]->less_than_1_to_5_tiems_scr == '1' ? 'checked' : ''): '' }} />
                                                <label class="form-check-label" for="exampleCheck2">1</label>
                                            </div>
                                        </td>
                                        <td class="text-center align-middle">
                                            <div class="form-group form-check">
                                                <input type="radio" class="form-check-input row_rec row3"
                                                    value="{{ '2' .'~' .$ipss[2]->pres_lookupdata_name .'~' .$ipss[2]->pres_lookupdata_no_pk .'~' .$ipss[2]->pres_lookupdata_code }}"
                                                    data-row="3" name="row3" data-value="2"
                                                    {{ isset($edit_ipss[2]) ? ($edit_ipss[2]->less_than_half_time_score == '2' ? 'checked' : ''): '' }} />
                                                <label class="form-check-label" for="exampleCheck3">2</label>
                                            </div>
                                        </td>
                                        <td class="text-center align-middle">
                                            <div class="form-group form-check">
                                                <input type="radio" class="form-check-input row_rec row3"
                                                    value="{{ '3' .'~' .$ipss[2]->pres_lookupdata_name .'~' .$ipss[2]->pres_lookupdata_no_pk .'~' .$ipss[2]->pres_lookupdata_code }}"
                                                    data-row="3" name="row3" data-value="3"
                                                    {{ isset($edit_ipss[2]) ? ($edit_ipss[2]->about_half_time_score == '3' ? 'checked' : ''): '' }} />
                                                <label class="form-check-label" for="exampleCheck4">3</label>
                                            </div>
                                        </td>
                                        <td class="text-center align-middle">
                                            <div class="form-group form-check">
                                                <input type="radio" class="form-check-input row_rec row3"
                                                    value="{{ '4' .'~' .$ipss[2]->pres_lookupdata_name .'~' .$ipss[2]->pres_lookupdata_no_pk .'~' .$ipss[2]->pres_lookupdata_code }}"
                                                    data-row="3" name="row3" data-value="4"
                                                    {{ isset($edit_ipss[2]) ? ($edit_ipss[2]->more_than_half_time_scr == '4' ? 'checked' : ''): '' }} />
                                                <label class="form-check-label" for="exampleCheck5">4</label>
                                            </div>
                                        </td>
                                        <td class="text-center align-middle">
                                            <div class="form-group form-check">
                                                <input type="radio" class="form-check-input row_rec row3"
                                                    value="{{ '5' .'~' .$ipss[2]->pres_lookupdata_name .'~' .$ipss[2]->pres_lookupdata_no_pk .'~' .$ipss[2]->pres_lookupdata_code }}"
                                                    data-row="3" name="row3" data-value="5"
                                                    {{ isset($edit_ipss[2]) ? ($edit_ipss[2]->almost_always_score == '5' ? 'checked' : ''): '' }} />
                                                <label class="form-check-label" for="exampleCheck6">5</label>
                                            </div>
                                        </td>

                                    </tr>
                                    <tr class="row_rec_tr">
                                        <th class="second_heading align-middle">
                                            <strong>4.Urgency <br /> </strong>{{ $ipss[3]->pres_lookupdata_name }}
                                        </th>
                                        <td class="text-center align-middle">
                                            <div class="form-group form-check">
                                                <input type="radio" class="form-check-input row_rec row4"
                                                    value="{{ '0' .'~' .$ipss[3]->pres_lookupdata_name .'~' .$ipss[3]->pres_lookupdata_no_pk .'~' .$ipss[3]->pres_lookupdata_code }}"
                                                    data-row="4" name="row4" data-value="0"
                                                    {{ isset($edit_ipss[3]) ? ($edit_ipss[3]->not_at_all_score == '0' ? 'checked' : ''):'' }} />
                                                <label class="form-check-label" for="exampleCheck1">0</label>
                                            </div>
                                        </td>
                                        <td class="text-center align-middle">
                                            <div class="form-group form-check">
                                                <input type="radio" class="form-check-input row_rec row4"
                                                    value="{{ '1' .'~' .$ipss[3]->pres_lookupdata_name .'~' .$ipss[3]->pres_lookupdata_no_pk .'~' .$ipss[3]->pres_lookupdata_code }}"
                                                    data-row="4" name="row4" data-value="1"
                                                    {{ isset($edit_ipss[3]) ? ($edit_ipss[3]->less_than_1_to_5_tiems_scr == '1' ? 'checked' : ''):'' }} />
                                                <label class="form-check-label" for="exampleCheck2">1</label>
                                            </div>
                                        </td>
                                        <td class="text-center align-middle">
                                            <div class="form-group form-check">
                                                <input type="radio" class="form-check-input row_rec row4"
                                                    value="{{ '2' .'~' .$ipss[3]->pres_lookupdata_name .'~' .$ipss[3]->pres_lookupdata_no_pk .'~' .$ipss[3]->pres_lookupdata_code }}"
                                                    data-row="4" name="row4" data-value="2"
                                                    {{ isset($edit_ipss[3]) ? ($edit_ipss[3]->less_than_half_time_score == '2' ? 'checked' : ''):'' }} />
                                                <label class="form-check-label" for="exampleCheck3">2</label>
                                            </div>
                                        </td>
                                        <td class="text-center align-middle">
                                            <div class="form-group form-check">
                                                <input type="radio" class="form-check-input row_rec row4"
                                                    value="{{ '3' .'~' .$ipss[3]->pres_lookupdata_name .'~' .$ipss[3]->pres_lookupdata_no_pk .'~' .$ipss[3]->pres_lookupdata_code }}"
                                                    data-row="4" name="row4" data-value="3"
                                                    {{ isset($edit_ipss[3]) ? ($edit_ipss[3]->about_half_time_score == '3' ? 'checked' : ''):'' }} />
                                                <label class="form-check-label" for="exampleCheck4">3</label>
                                            </div>
                                        </td>
                                        <td class="text-center align-middle">
                                            <div class="form-group form-check">
                                                <input type="radio" class="form-check-input row_rec row4"
                                                    value="{{ '4' .'~' .$ipss[3]->pres_lookupdata_name .'~' .$ipss[3]->pres_lookupdata_no_pk .'~' .$ipss[3]->pres_lookupdata_code }}"
                                                    data-row="4" name="row4" data-value="4"
                                                    {{ isset($edit_ipss[3]) ? ($edit_ipss[3]->more_than_half_time_scr == '4' ? 'checked' : ''):'' }} />
                                                <label class="form-check-label" for="exampleCheck5">4</label>
                                            </div>
                                        </td>
                                        <td class="text-center align-middle">
                                            <div class="form-group form-check">
                                                <input type="radio" class="form-check-input row_rec row4"
                                                    value="{{ '5' .'~' .$ipss[3]->pres_lookupdata_name .'~' .$ipss[3]->pres_lookupdata_no_pk .'~' .$ipss[3]->pres_lookupdata_code }}"
                                                    data-row="4" name="row4" data-value="5"
                                                    {{ isset($edit_ipss[3]) ? ($edit_ipss[3]->almost_always_score == '5' ? 'checked' : ''):'' }} />
                                                <label class="form-check-label" for="exampleCheck6">5</label>
                                            </div>
                                        </td>

                                    </tr>
                                    <tr class="row_rec_tr">
                                        <th class="second_heading align-middle">
                                            <strong>5.Weak Stream <br /> </strong>{{ $ipss[4]->pres_lookupdata_name }}
                                        </th>
                                        <td class="text-center align-middle">
                                            <div class="form-group form-check">
                                                <input type="radio" class="form-check-input row_rec row5"
                                                    value="{{ '0' .'~' .$ipss[4]->pres_lookupdata_name .'~' .$ipss[4]->pres_lookupdata_no_pk .'~' .$ipss[4]->pres_lookupdata_code }}"
                                                    data-row="5" name="row5" data-value="0"
                                                    {{ isset($edit_ipss[4]) ? ($edit_ipss[4]->not_at_all_score == '0' ? 'checked' : '' ):''}} />
                                                <label class="form-check-label" for="exampleCheck1">0</label>
                                            </div>
                                        </td>
                                        <td class="text-center align-middle">
                                            <div class="form-group form-check">
                                                <input type="radio" class="form-check-input row_rec row5"
                                                    value="{{ '1' .'~' .$ipss[4]->pres_lookupdata_name .'~' .$ipss[4]->pres_lookupdata_no_pk .'~' .$ipss[4]->pres_lookupdata_code }}"
                                                    data-row="5" name="row5" data-value="1"
                                                    {{ isset($edit_ipss[4]) ? ($edit_ipss[4]->less_than_1_to_5_tiems_scr == '1' ? 'checked' : '' ):''}} />
                                                <label class="form-check-label" for="exampleCheck2">1</label>
                                            </div>
                                        </td>
                                        <td class="text-center align-middle">
                                            <div class="form-group form-check">
                                                <input type="radio" class="form-check-input row_rec row5"
                                                    value="{{ '2' .'~' .$ipss[4]->pres_lookupdata_name .'~' .$ipss[4]->pres_lookupdata_no_pk .'~' .$ipss[4]->pres_lookupdata_code }}"
                                                    data-row="5" name="row5" data-value="2"
                                                    {{ isset($edit_ipss[4]) ? ($edit_ipss[4]->less_than_half_time_score == '2' ? 'checked' : '' ):''}} />
                                                <label class="form-check-label" for="exampleCheck3">2</label>
                                            </div>
                                        </td>
                                        <td class="text-center align-middle">
                                            <div class="form-group form-check">
                                                <input type="radio" class="form-check-input row_rec row5"
                                                    value="{{ '3' .'~' .$ipss[4]->pres_lookupdata_name .'~' .$ipss[4]->pres_lookupdata_no_pk .'~' .$ipss[4]->pres_lookupdata_code }}"
                                                    data-row="5" name="row5" data-value="3"
                                                    {{ isset($edit_ipss[4]) ? ($edit_ipss[4]->about_half_time_score == '3' ? 'checked' : '' ):''}} />
                                                <label class="form-check-label" for="exampleCheck4">3</label>
                                            </div>
                                        </td>
                                        <td class="text-center align-middle">
                                            <div class="form-group form-check">
                                                <input type="radio" class="form-check-input row_rec row5"
                                                    value="{{ '4' .'~' .$ipss[4]->pres_lookupdata_name .'~' .$ipss[4]->pres_lookupdata_no_pk .'~' .$ipss[4]->pres_lookupdata_code }}"
                                                    data-row="5" name="row5" data-value="4"
                                                    {{ isset($edit_ipss[4]) ? ($edit_ipss[4]->more_than_half_time_scr == '4' ? 'checked' : '' ):''}} />
                                                <label class="form-check-label" for="exampleCheck5">4</label>
                                            </div>
                                        </td>
                                        <td class="text-center align-middle">
                                            <div class="form-group form-check">
                                                <input type="radio" class="form-check-input row_rec row5"
                                                    value="{{ '5' .'~' .$ipss[4]->pres_lookupdata_name .'~' .$ipss[4]->pres_lookupdata_no_pk .'~' .$ipss[4]->pres_lookupdata_code }}"
                                                    data-row="5" name="row5" data-value="5"
                                                    {{ isset($edit_ipss[4]) ? ($edit_ipss[4]->almost_always_score == '5' ? 'checked' : '' ):''}} />
                                                <label class="form-check-label" for="exampleCheck6">5</label>
                                            </div>
                                        </td>

                                    </tr>
                                    <tr class="row_rec_tr">
                                        <th class="second_heading align-middle">
                                            <strong>6.Straining <br /> </strong>{{ $ipss[5]->pres_lookupdata_name }}
                                        </th>

                                        <td class="text-center align-middle">
                                            <div class="form-group form-check">
                                                <input type="radio" class="form-check-input row_rec row6"
                                                    value="{{ '0' .'~' .$ipss[5]->pres_lookupdata_name .'~' .$ipss[5]->pres_lookupdata_no_pk .'~' .$ipss[5]->pres_lookupdata_code }}"
                                                    data-row="6" name="row6" data-value="0"
                                                    {{ isset($edit_ipss[5]) ? ($edit_ipss[5]->not_at_all_score == '0' ? 'checked' : ''):'' }} />
                                                <label class="form-check-label" for="exampleCheck1">0</label>
                                            </div>
                                        </td>
                                        <td class="text-center align-middle">
                                            <div class="form-group form-check">
                                                <input type="radio" class="form-check-input row_rec row6"
                                                    value="{{ '1' .'~' .$ipss[5]->pres_lookupdata_name .'~' .$ipss[5]->pres_lookupdata_no_pk .'~' .$ipss[5]->pres_lookupdata_code }}"
                                                    data-row="6" name="row6" data-value="1"
                                                    {{ isset($edit_ipss[5]) ? ($edit_ipss[5]->less_than_1_to_5_tiems_scr == '1' ? 'checked' : ''):'' }} />
                                                <label class="form-check-label" for="exampleCheck2">1</label>
                                            </div>
                                        </td>
                                        <td class="text-center align-middle">
                                            <div class="form-group form-check">
                                                <input type="radio" class="form-check-input row_rec row6"
                                                    value="{{ '2' .'~' .$ipss[5]->pres_lookupdata_name .'~' .$ipss[5]->pres_lookupdata_no_pk .'~' .$ipss[5]->pres_lookupdata_code }}"
                                                    data-row="6" name="row6" data-value="2"
                                                    {{ isset($edit_ipss[5]) ? ($edit_ipss[5]->less_than_half_time_score == '2' ? 'checked' : ''):'' }} />
                                                <label class="form-check-label" for="exampleCheck3">2</label>
                                            </div>
                                        </td>
                                        <td class="text-center align-middle">
                                            <div class="form-group form-check">
                                                <input type="radio" class="form-check-input row_rec row6"
                                                    value="{{ '3' .'~' .$ipss[5]->pres_lookupdata_name .'~' .$ipss[5]->pres_lookupdata_no_pk .'~' .$ipss[5]->pres_lookupdata_code }}"
                                                    data-row="6" name="row6" data-value="3"
                                                    {{ isset($edit_ipss[5]) ? ($edit_ipss[5]->about_half_time_score == '3' ? 'checked' : ''):'' }} />
                                                <label class="form-check-label" for="exampleCheck4">3</label>
                                            </div>
                                        </td>
                                        <td class="text-center align-middle">
                                            <div class="form-group form-check">
                                                <input type="radio" class="form-check-input row_rec row6"
                                                    value="{{ '4' .'~' .$ipss[5]->pres_lookupdata_name .'~' .$ipss[5]->pres_lookupdata_no_pk .'~' .$ipss[5]->pres_lookupdata_code }}"
                                                    data-row="6" name="row6" data-value="4"
                                                    {{ isset($edit_ipss[5]) ? ($edit_ipss[5]->more_than_half_time_scr == '4' ? 'checked' : ''):'' }} />
                                                <label class="form-check-label" for="exampleCheck5">4</label>
                                            </div>
                                        </td>
                                        <td class="text-center align-middle">
                                            <div class="form-group form-check">
                                                <input type="radio" class="form-check-input row_rec row6"
                                                    value="{{ '5' .'~' .$ipss[5]->pres_lookupdata_name .'~' .$ipss[5]->pres_lookupdata_no_pk .'~' .$ipss[5]->pres_lookupdata_code }}"
                                                    data-row="6" name="row6" data-value="5"
                                                    {{ isset($edit_ipss[5]) ? ($edit_ipss[5]->almost_always_score == '5' ? 'checked' : ''):'' }} />
                                                <label class="form-check-label" for="exampleCheck6">5</label>
                                            </div>
                                        </td>

                                    </tr>

                                    <tr style="background: #726e6e0a;">
                                        <th class="align-middle" style="padding: 20px 0px !important;"></th>
                                        <td class="text-center align-middle">None</td>
                                        <td class="text-center align-middle">1 Time</td>
                                        <td class="text-center align-middle">2 Time</td>
                                        <td class="text-center align-middle">3 Time</td>
                                        <td class="text-center align-middle">4 Time</td>
                                        <td class="text-center align-middle">5 Time</td>

                                    </tr>

                                    <tr class="row_rec_tr">
                                        <th class="second_heading align-middle">
                                            <strong>7.Nocturia <br /> </strong>{{ $ipss[6]->pres_lookupdata_name }}
                                        </th>
                                        <td class="text-center align-middle">
                                            <div class="form-group form-check">
                                                <input type="radio" class="form-check-input row_rec row7"
                                                    value="{{ '0' .'~' .$ipss[6]->pres_lookupdata_name .'~' .$ipss[6]->pres_lookupdata_no_pk .'~' .$ipss[6]->pres_lookupdata_code }}"
                                                    data-row="7" name="row7" data-value="0"
                                                    {{ isset($edit_ipss[6]) ? ($edit_ipss[6]->not_at_all_score == '0' ? 'checked' : '' ):''}} />
                                                <label class="form-check-label" for="exampleCheck1">0</label>
                                            </div>
                                        </td>
                                        <td class="text-center align-middle">
                                            <div class="form-group form-check">
                                                <input type="radio" class="form-check-input row_rec row7"
                                                    value="{{ '1' .'~' .$ipss[6]->pres_lookupdata_name .'~' .$ipss[6]->pres_lookupdata_no_pk .'~' .$ipss[6]->pres_lookupdata_code }}"
                                                    data-row="7" name="row7" data-value="1"
                                                    {{ isset($edit_ipss[6]) ? ($edit_ipss[6]->less_than_1_to_5_tiems_scr == '1' ? 'checked' : '' ):''}} />
                                                <label class="form-check-label" for="exampleCheck2">1</label>
                                            </div>
                                        </td>
                                        <td class="text-center align-middle">
                                            <div class="form-group form-check">
                                                <input type="radio" class="form-check-input row_rec row7"
                                                    value="{{ '2' .'~' .$ipss[6]->pres_lookupdata_name .'~' .$ipss[6]->pres_lookupdata_no_pk .'~' .$ipss[6]->pres_lookupdata_code }}"
                                                    data-row="7" name="row7" data-value="2"
                                                    {{ isset($edit_ipss[6]) ? ($edit_ipss[6]->less_than_half_time_score == '2' ? 'checked' : '' ):''}} />
                                                <label class="form-check-label" for="exampleCheck3">2</label>
                                            </div>
                                        </td>
                                        <td class="text-center align-middle">
                                            <div class="form-group form-check">
                                                <input type="radio" class="form-check-input row_rec row7"
                                                    value="{{ '3' .'~' .$ipss[6]->pres_lookupdata_name .'~' .$ipss[6]->pres_lookupdata_no_pk .'~' .$ipss[6]->pres_lookupdata_code }}"
                                                    data-row="7" name="row7" data-value="3"
                                                    {{ isset($edit_ipss[6]) ? ($edit_ipss[6]->about_half_time_score == '3' ? 'checked' : '' ):''}} />
                                                <label class="form-check-label" for="exampleCheck4">3</label>
                                            </div>
                                        </td>
                                        <td class="text-center align-middle">
                                            <div class="form-group form-check">
                                                <input type="radio" class="form-check-input row_rec row7"
                                                    value="{{ '4' .'~' .$ipss[6]->pres_lookupdata_name .'~' .$ipss[6]->pres_lookupdata_no_pk .'~' .$ipss[6]->pres_lookupdata_code }}"
                                                    data-row="7" name="row7" data-value="4"
                                                    {{ isset($edit_ipss[6]) ? ($edit_ipss[6]->more_than_half_time_scr == '4' ? 'checked' : '' ):''}} />
                                                <label class="form-check-label" for="exampleCheck5">4</label>
                                            </div>
                                        </td>
                                        <td class="text-center align-middle">
                                            <div class="form-group form-check">
                                                <input type="radio" class="form-check-input row_rec row7"
                                                    value="{{ '5' .'~' .$ipss[6]->pres_lookupdata_name .'~' .$ipss[6]->pres_lookupdata_no_pk .'~' .$ipss[6]->pres_lookupdata_code }}"
                                                    data-row="7" name="row7" data-value="5"
                                                    {{ isset($edit_ipss[6]) ? ($edit_ipss[6]->almost_always_score == '5' ? 'checked' : '' ):''}} />
                                                <label class="form-check-label" for="exampleCheck6">5</label>
                                            </div>
                                        </td>

                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr style="background: #726e6e0a;">
                                        <th class="text-left second_heading">Total I-PSS Score</th>
                                        <th class="text-center align-middle"></th>
                                        <th class="text-center align-middle"></th>
                                        <th class="text-center align-middle"></th>
                                        <th class="text-center align-middle"></th>
                                        <th class="text-center align-middle"></th>
                                        <th class="text-center align-middle"></th>
                                        <th class="text-center align-middle"></th>
                                    </tr>
                                    <tr>
                                        <th class="second_heading" colspan="8">
                                            <table class="table table-bordered m-0" style="width: 100%;">
                                                <tr>
                                                    <td class="text-center" style="padding: 10px 0px !important;">
                                                        Score:</td>
                                                    <td class="text-center mild">1-7: Mild</td>
                                                    <td class="text-center moderate">8-19: Moderate</td>
                                                    <td class="text-center severe">20-35: Servere</td>
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

        <div class="form-row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body mt-2">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="bg-light-blue">
                                    <tr>
                                        <th class="text-left align-middle first_heading">Quality of Life Due to Urinary
                                            Symptoms</th>
                                        <th class="text-center align-middle">Delighted</th>
                                        <th class="text-center align-middle">Pleased</th>
                                        <th class="text-center align-middle">Mostly Satisfied</th>
                                        <th class="text-center align-middle">Mixed</th>
                                        <th class="text-center align-middle">Mostly Dissatisfied</th>
                                        <th class="text-center align-middle">Unhappy</th>
                                        <th class="text-center align-middle">Terrible</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th class="second_heading align-middle">If you were to spend the rest of your
                                            life with your urinary condition just the way it is now, how would you feel
                                            about that?</th>

                                        <td class="text-center align-middle">
                                            <div class="form-group form-check">
                                                <input type="radio" class="form-check-input row8"
                                                    value="{{ 0 }}" name="urinary_symptom_ind"
                                                    {{ isset($edit_ipss[1]) ? ($edit_ipss[1]->urinary_symptoms_ind == 0 ? 'checked' : '' ):'' }} />
                                                <label class="form-check-label" for="exampleCheck1">0</label>
                                            </div>
                                        </td>
                                        <td class="text-center align-middle">
                                            <div class="form-group form-check">
                                                <input type="radio" class="form-check-input row8"
                                                    value="{{ 1 }}" name="urinary_symptom_ind"
                                                    {{ isset($edit_ipss[1]) ? ($edit_ipss[1]->urinary_symptoms_ind == 1 ? 'checked' : '' ):'' }} />
                                                <label class="form-check-label" for="exampleCheck2">1</label>
                                            </div>
                                        </td>
                                        <td class="text-center align-middle">
                                            <div class="form-group form-check">
                                                <input type="radio" class="form-check-input row8"
                                                    value="{{ 2 }}" name="urinary_symptom_ind"
                                                    {{ isset($edit_ipss[1]) ? ($edit_ipss[1]->urinary_symptoms_ind == 2 ? 'checked' : '' ):'' }} />
                                                <label class="form-check-label" for="exampleCheck3">2</label>
                                            </div>
                                        </td>
                                        <td class="text-center align-middle">
                                            <div class="form-group form-check">
                                                <input type="radio" class="form-check-input row8"
                                                    value="{{ 3 }}" name="urinary_symptom_ind"
                                                    {{ isset($edit_ipss[1]) ? ($edit_ipss[1]->urinary_symptoms_ind == 3 ? 'checked' : '' ):'' }} />
                                                <label class="form-check-label" for="exampleCheck4">3</label>
                                            </div>
                                        </td>
                                        <td class="text-center align-middle">
                                            <div class="form-group form-check">
                                                <input type="radio" class="form-check-input row8"
                                                    value="{{ 4 }}" name="urinary_symptom_ind"
                                                    {{ isset($edit_ipss[1]) ? ($edit_ipss[1]->urinary_symptoms_ind == 4 ? 'checked' : '' ):'' }} />
                                                <label class="form-check-label" for="exampleCheck5">4</label>
                                            </div>
                                        </td>
                                        <td class="text-center align-middle">
                                            <div class="form-group form-check">
                                                <input type="radio" class="form-check-input row8"
                                                    value="{{ 5 }}" name="urinary_symptom_ind"
                                                    {{ isset($edit_ipss[1]) ? ($edit_ipss[1]->urinary_symptoms_ind == 5 ? 'checked' : '' ):'' }} />
                                                <label class="form-check-label" for="exampleCheck6">5</label>
                                            </div>
                                        </td>

                                        <td class="text-center align-middle">
                                            <div class="form-group form-check">
                                                <input type="radio" class="form-check-input row8"
                                                    value="{{ 6 }}" name="urinary_symptom_ind"
                                                    {{ isset($edit_ipss[1]) ? ($edit_ipss[1]->urinary_symptoms_ind == 6 ? 'checked' : '' ):'' }} />
                                                <label class="form-check-label" for="exampleCheck7">6</label>
                                            </div>
                                        </td>

                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>


</div>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>

<script type="application/javascript">
    // openPatientAutocomplete('#patient_name', 'patient_name');
    $('.date_picker').datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        todayHighlight: true,
        clearBtn: true,
    });

    // $(document).on('keyup', '#patient_name', function() {

    //     if ($(this).val() == '') {



    //         $('#hdn_patient_id').val('');

    //     }

    // });

    $(document).ready(function() {

        var count = 0;
        $(".row_rec").each(function() {
            if ($(this).is(':checked')) {
                var value = parseFloat($(this).attr('data-value'));
                count += value
            }
            if ((1 <= count) && (count <= 7)) {
                $('.mild').addClass('alert alert-warning');
            } else {
                $('.mild').removeClass('alert alert-warning');

            }
            if ((8 <= count) && (count <= 19)) {
                $('.moderate').addClass('alert alert-warning');
            } else {
                $('.moderate').removeClass('alert alert-warning');

            }
            if ((20 <= count) && (count <= 35)) {
                $('.severe').addClass('alert alert-warning');
            } else {
                $('.severe').removeClass('alert alert-warning');

            }
      $('input.total_ipss_score').val(count);
       console.log(count)

        });

        $(document).on('change', '.row_rec', function() {

            $(this).parent('div').parent('td').parent('tr').find('.row_rec').prop('checked', false);
            $(this).prop('checked', true);

            var count3 = 0;
            $(".row_rec").each(function() {
                if ($(this).is(':checked')) {
                    var value = parseFloat($(this).attr('data-value'));
                    count3 += value
                }
            });
            $('input.total_ipss_score').val(count3);

            if ((1 <= count3) && (count3 <= 7)) {
                $('.mild').addClass('alert alert-warning');
            } else {
                $('.mild').removeClass('alert alert-warning');

            }
            if ((8 <= count3) && (count3 <= 19)) {
                $('.moderate').addClass('alert alert-warning');
            } else {
                $('.moderate').removeClass('alert alert-warning');

            }
            if ((20 <= count3) && (count3 <= 35)) {
                $('.severe').addClass('alert alert-warning');
            } else {
                $('.severe').removeClass('alert alert-warning');

            }
           // $sum = $count ? $count
            $('input.total_ipss_score').val(count3);
            console.log(count3)

        });
    });

    //var sum = 0;
    // var i = 0;
    // var prev_value = 0;
    // var row_val0 = 0;
    // var row_val1 = 0;
    // var row_val2 = 0;
    // var row_val3 = 0;
    // var row_val4 = 0;
    // var row_val5 = 0;
    // var row_val6 = 0;

    // let prev_sum = 0;

    // $('body').on('mouseover','.row_rec_tr', function() {
    //     prev_sum = $(this).data('value');
    // })


    // $('body').on('click', '.row_rec', function() {

    //     //let data_row = $(this).data('row');
    //     let data_value = $(this).data('value');
    //     let data_row = $(this).data('row')
    //     let sum = 0;


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

    //     if (data_row == 6) {
    //         row_val5 = data_value;
    //     }

    //     if (data_row == 7) {
    //         row_val6 = data_value;
    //     }


    //     //console.log('record no ',data_row)
    //     if ($(this).prop('checked') === true) {
    //         i++;

    //         let data_row = $('.row_rec');

    //         let this_row_val = parseInt($(this).data('value'));

    //         $(this).parent().parent().parent().attr('data-value',$(this).data('value'))

    //         Array.from(data_row,(row) => {
    //             if ($(row).prop('checked') === true) {
    //                 //alert($(row).data('value'))
    //                 let row_val = parseInt($(row).attr('data-value'))

    //                 if ($(row).attr('data-value') !== NaN || $(row).attr('data-value') !== undefined) {
    //                     sum += row_val;
    //                 }

    //             }
    //         })

    //         sum = (sum-prev_sum)
    //         console.log(sum)


    //sum = (row_val0 + row_val1 + row_val2 + row_val3 + row_val4 + row_val5 + row_val6);


    //         if ((1 <= sum) && (sum <= 7)) {
    //             $('.mild').addClass('alert alert-warning');
    //         } else {
    //             $('.mild').removeClass('alert alert-warning');

    //         }
    //         if ((8 <= sum) && (sum <= 19)) {
    //             $('.moderate').addClass('alert alert-warning');
    //         } else {
    //             $('.moderate').removeClass('alert alert-warning');

    //         }
    //         if ((20 <= sum) && (sum <= 35)) {
    //             $('.severe').addClass('alert alert-warning');
    //         } else {
    //             $('.severe').removeClass('alert alert-warning');

    //         }

    //         // console.log('summery ',sum)
    //         // if(i==7)
    //         // {
    //         //     console.log(sum);

    //         // }
    //     }
    //     $('input.total_ipss_score').val(sum);
    // })



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
