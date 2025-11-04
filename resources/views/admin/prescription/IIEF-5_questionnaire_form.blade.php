<style>

    .table-responsive .table tbody tr .second_heading {
        padding: 7px !important;
        text-align: left;
        font-size: 12px !important;
        color: #333;
        font-weight: 500;
        width: 25%;
    }
    .segmnt_row{
        border-bottom:2px solid #333 !important;
    }



</style>
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">

<div class="container-fluid">
    {{-- <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm">
        <div class="col-md-12">
            <h5 class="mt-2 mb-0">The IIEF-5 Questionnaire (SHIM)</h5>
            <small>Prescription / The IIEF-5 Questionnaire (SHIM)</small>
        </div>
    </div> --}}
    {{-- <form action="{{route('store-IIEF-5-questionnaire')}}" id="iief_form" method="POST"> --}}
        {{-- @csrf --}}
        <input type="hidden" class="total_shim_score" name="total_shim_score"/>
        {{-- <div class="form-row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5><i class="fa fa-search"></i> Search Panel</h5>
                    </div>
                    <div class="card-body pt-2 bg-light">
                        <div class="form-row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="patient_name">Patient Name</label>
                                    <input type="text" class="form-control form-control-sm" placeholder="Patient Name" id="patient_name" name="patient_name" />
                                    <input type="hidden" class="form-control" id="hdn_patient_id"
                                    name="hdn_patient_id" />
                                </div>
                            </div>

                             <div class="col-md-3">
                                <div class="form-group">
                                    <label for="Date_of_birth">Date Of Birth</label>
                                    <input type="text" autocomplete="off" class="form-control form-control-sm date_picker" id="dob" name="dob" value="" placeholder="DD-MM-YYYY">
                                    <span class="focus_input"></span>

                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="Date_of_birth">Date Completed</label>
                                    <input type="text" autocomplete="off" class="form-control form-control-sm date_picker" id="doc" name="doc" value="" placeholder="DD-MM-YYYY">
                                    <span class="focus_input"></span>

                                </div>
                            </div>

                            <div class="col-md-3">
                                <button type="button" class="btn btn-md btn-success mt-4">Search</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
        <div class="form-row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body mt-2">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover mb-0">
                                <thead class="bg-light-blue">
                                    <tr>
                                        <th class="text-left align-middle segmnt_row" colspan="6">Over the past 6 months:</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- 1st row --}}
                                    <tr>
                                        <td class="second_heading align-middle segmnt_row" rowspan="2">

                                            1. {{$iief[0]->pres_lookupdata_name}}
                                        </td>

                                        <th class="text-center align-middle">Very low</th>
                                        <th class="text-center align-middle">Low</th>
                                        <th class="text-center align-middle">Moderate</th>
                                        <th class="text-center align-middle">High</th>
                                        <th class="text-center align-middle">Very high</th>
                                    </tr>
                                    <tr >
                                        <td class="text-center align-middle segmnt_row">
                                            <div class="form-group form-check">
                                                <input type="radio" class="form-check-input iief_row_rec" value="{{'1'.'~'.$iief[0]->pres_lookupdata_name.'~'.$iief[0]->pres_lookupdata_no_pk.'~'.$iief[0]->pres_lookupdata_code}}"  iief_data-row="1" name="iief_row1" iief_data-value="1" />
                                                <label class="form-check-label" for="iief_exampleCheck1">1</label>
                                            </div>
                                        </td>
                                        <td class="text-center align-middle segmnt_row">
                                            <div class="form-group form-check">
                                                <input type="radio" class="form-check-input iief_row_rec" value="{{'2'.'~'.$iief[0]->pres_lookupdata_name.'~'.$iief[0]->pres_lookupdata_no_pk.'~'.$iief[0]->pres_lookupdata_code}}"  iief_data-row="1" name="iief_row1" iief_data-value="2" />
                                                <label class="form-check-label" for="iief_exampleCheck2">2</label>
                                            </div>
                                        </td>
                                        <td class="text-center align-middle segmnt_row">
                                            <div class="form-group form-check">
                                                <input type="radio" class="form-check-input iief_row_rec" value="{{'3'.'~'.$iief[0]->pres_lookupdata_name.'~'.$iief[0]->pres_lookupdata_no_pk.'~'.$iief[0]->pres_lookupdata_code}}"  iief_data-row="1" name="iief_row1" iief_data-value="3" />
                                                <label class="form-check-label" for="iief_exampleCheck3">3</label>
                                            </div>
                                        </td>
                                        <td class="text-center align-middle segmnt_row">
                                            <div class="form-group form-check">
                                                <input type="radio" class="form-check-input iief_row_rec" value="{{'4'.'~'.$iief[0]->pres_lookupdata_name.'~'.$iief[0]->pres_lookupdata_no_pk.'~'.$iief[0]->pres_lookupdata_code}}"  iief_data-row="1" name="iief_row1" iief_data-value="4" />
                                                <label class="form-check-label" for="iief_exampleCheck4">4</label>
                                            </div>
                                        </td>
                                        <td class="text-center align-middle segmnt_row">
                                            <div class="form-group form-check">
                                                <input type="radio" class="form-check-input iief_row_rec" value="{{'5'.'~'.$iief[0]->pres_lookupdata_name.'~'.$iief[0]->pres_lookupdata_no_pk.'~'.$iief[0]->pres_lookupdata_code}}"  iief_data-row="1" name="iief_row1" iief_data-value="5" />
                                                <label class="form-check-label" for="iief_exampleCheck5">5</label>
                                            </div>
                                        </td>

                                    </tr>
                                     {{-- 1st row --}}

                                      {{-- 2nd row --}}

                                    <tr>
                                        <td class="second_heading align-middle segmnt_row" rowspan="3">

                                            2. {{$iief[1]->pres_lookupdata_name}}
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
                                        <td class="text-center align-middle segmnt_row">
                                            <div class="form-group form-check">
                                                <input type="radio" class="form-check-input iief_row_rec" value="{{'1'.'~'.$iief[1]->pres_lookupdata_name.'~'.$iief[1]->pres_lookupdata_no_pk.'~'.$iief[1]->pres_lookupdata_code}}"  iief_data-row="2" name="iief_row2" iief_data-value="1" />
                                                <label class="form-check-label" for="iief_exampleCheck1">1</label>
                                            </div>
                                        </td>
                                        <td class="text-center align-middle segmnt_row">
                                            <div class="form-group form-check">
                                                <input type="radio" class="form-check-input iief_row_rec" value="{{'2'.'~'.$iief[1]->pres_lookupdata_name.'~'.$iief[1]->pres_lookupdata_no_pk.'~'.$iief[1]->pres_lookupdata_code}}"  iief_data-row="2" name="iief_row2" iief_data-value="2" />
                                                <label class="form-check-label" for="iief_exampleCheck2">2</label>
                                            </div>
                                        </td>
                                        <td class="text-center align-middle segmnt_row">
                                            <div class="form-group form-check">
                                                <input type="radio" class="form-check-input iief_row_rec" value="{{'3'.'~'.$iief[1]->pres_lookupdata_name.'~'.$iief[1]->pres_lookupdata_no_pk.'~'.$iief[1]->pres_lookupdata_code}}"  iief_data-row="2" name="iief_row2" iief_data-value="3" />
                                                <label class="form-check-label" for="iief_exampleCheck3">3</label>
                                            </div>
                                        </td>
                                        <td class="text-center align-middle segmnt_row">
                                            <div class="form-group form-check">
                                                <input type="radio" class="form-check-input iief_row_rec" value="{{'4'.'~'.$iief[1]->pres_lookupdata_name.'~'.$iief[1]->pres_lookupdata_no_pk.'~'.$iief[1]->pres_lookupdata_code}}"  iief_data-row="2" name="iief_row2" iief_data-value="4" />
                                                <label class="form-check-label" for="iief_exampleCheck4">4</label>
                                            </div>
                                        </td>
                                        <td class="text-center align-middle segmnt_row">
                                            <div class="form-group form-check">
                                                <input type="radio" class="form-check-input iief_row_rec" value="{{'5'.'~'.$iief[1]->pres_lookupdata_name.'~'.$iief[1]->pres_lookupdata_no_pk.'~'.$iief[1]->pres_lookupdata_code}}"  iief_data-row="2" name="iief_row2" iief_data-value="5" />
                                                <label class="form-check-label" for="iief_exampleCheck5">5</label>
                                            </div>
                                        </td>

                                    </tr>
                                     {{-- 2nd row --}}

                                      {{-- 3rd row --}}
                                      <tr>
                                          <td class="second_heading align-middle segmnt_row" rowspan="3">

                                              3. {{$iief[2]->pres_lookupdata_name}}
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
                                        <td class="text-center align-middle segmnt_row">
                                            <div class="form-group form-check">
                                                <input type="radio" class="form-check-input iief_row_rec" value="{{'1'.'~'.$iief[2]->pres_lookupdata_name.'~'.$iief[2]->pres_lookupdata_no_pk.'~'.$iief[2]->pres_lookupdata_code}}"  iief_data-row="3" name="iief_row3" iief_data-value="1" />
                                                <label class="form-check-label" for="iief_exampleCheck1">1</label>
                                            </div>
                                        </td>
                                        <td class="text-center align-middle segmnt_row">
                                            <div class="form-group form-check">
                                                <input type="radio" class="form-check-input iief_row_rec" value="{{'2'.'~'.$iief[2]->pres_lookupdata_name.'~'.$iief[2]->pres_lookupdata_no_pk.'~'.$iief[2]->pres_lookupdata_code}}"  iief_data-row="3" name="iief_row3" iief_data-value="2" />
                                                <label class="form-check-label" for="iief_exampleCheck2">2</label>
                                            </div>
                                        </td>
                                        <td class="text-center align-middle segmnt_row">
                                            <div class="form-group form-check">
                                                <input type="radio" class="form-check-input iief_row_rec" value="{{'3'.'~'.$iief[2]->pres_lookupdata_name.'~'.$iief[2]->pres_lookupdata_no_pk.'~'.$iief[2]->pres_lookupdata_code}}"  iief_data-row="3" name="iief_row3" iief_data-value="3" />
                                                <label class="form-check-label" for="iief_exampleCheck3">3</label>
                                            </div>
                                        </td>
                                        <td class="text-center align-middle segmnt_row">
                                            <div class="form-group form-check">
                                                <input type="radio" class="form-check-input iief_row_rec" value="{{'4'.'~'.$iief[2]->pres_lookupdata_name.'~'.$iief[2]->pres_lookupdata_no_pk.'~'.$iief[2]->pres_lookupdata_code}}"  iief_data-row="3" name="iief_row3" iief_data-value="4" />
                                                <label class="form-check-label" for="iief_exampleCheck4">4</label>
                                            </div>
                                        </td>
                                        <td class="text-center align-middle segmnt_row">
                                            <div class="form-group form-check">
                                                <input type="radio" class="form-check-input iief_row_rec" value="{{'5'.'~'.$iief[2]->pres_lookupdata_name.'~'.$iief[2]->pres_lookupdata_no_pk.'~'.$iief[2]->pres_lookupdata_code}}"  iief_data-row="3" name="iief_row3" iief_data-value="5" />
                                                <label class="form-check-label" for="iief_exampleCheck5">5</label>
                                            </div>
                                        </td>

                                      </tr>
                                      {{-- 3rd row --}}

                                       {{-- 4th row --}}
                                       <tr>
                                           <td class="second_heading align-middle segmnt_row" rowspan="2">

                                               4. {{$iief[3]->pres_lookupdata_name}}
                                           </td>

                                           <th class="text-center align-middle">Extremely difficult</th>
                                           <th class="text-center align-middle">Very difficult</th>
                                           <th class="text-center align-middle">Difficult</th>
                                           <th class="text-center align-middle">Slightly difficult</th>
                                           <th class="text-center align-middle">Not difficult</th>
                                       </tr>
                                       <tr>
                                        <td class="text-center align-middle segmnt_row">
                                            <div class="form-group form-check">
                                                <input type="radio" class="form-check-input iief_row_rec" value="{{'1'.'~'.$iief[3]->pres_lookupdata_name.'~'.$iief[3]->pres_lookupdata_no_pk.'~'.$iief[3]->pres_lookupdata_code}}"  iief_data-row="4" name="iief_row4" iief_data-value="1" />
                                                <label class="form-check-label" for="iief_exampleCheck1">1</label>
                                            </div>
                                        </td>
                                        <td class="text-center align-middle segmnt_row">
                                            <div class="form-group form-check">
                                                <input type="radio" class="form-check-input iief_row_rec" value="{{'2'.'~'.$iief[3]->pres_lookupdata_name.'~'.$iief[3]->pres_lookupdata_no_pk.'~'.$iief[3]->pres_lookupdata_code}}"  iief_data-row="4" name="iief_row4" iief_data-value="2" />
                                                <label class="form-check-label" for="iief_exampleCheck2">2</label>
                                            </div>
                                        </td>
                                        <td class="text-center align-middle segmnt_row">
                                            <div class="form-group form-check">
                                                <input type="radio" class="form-check-input iief_row_rec" value="{{'3'.'~'.$iief[3]->pres_lookupdata_name.'~'.$iief[3]->pres_lookupdata_no_pk.'~'.$iief[3]->pres_lookupdata_code}}"  iief_data-row="4" name="iief_row4" iief_data-value="3" />
                                                <label class="form-check-label" for="iief_exampleCheck3">3</label>
                                            </div>
                                        </td>
                                        <td class="text-center align-middle segmnt_row">
                                            <div class="form-group form-check">
                                                <input type="radio" class="form-check-input iief_row_rec" value="{{'4'.'~'.$iief[3]->pres_lookupdata_name.'~'.$iief[3]->pres_lookupdata_no_pk.'~'.$iief[3]->pres_lookupdata_code}}"  iief_data-row="4" name="iief_row4" iief_data-value="4" />
                                                <label class="form-check-label" for="iief_exampleCheck4">4</label>
                                            </div>
                                        </td>
                                        <td class="text-center align-middle segmnt_row">
                                            <div class="form-group form-check">
                                                <input type="radio" class="form-check-input iief_row_rec" value="{{'5'.'~'.$iief[3]->pres_lookupdata_name.'~'.$iief[3]->pres_lookupdata_no_pk.'~'.$iief[3]->pres_lookupdata_code}}"  iief_data-row="4" name="iief_row4" iief_data-value="5" />
                                                <label class="form-check-label" for="iief_exampleCheck5">5</label>
                                            </div>
                                        </td>
                                       </tr>
                                       {{-- 4th row --}}

                                       {{-- 5th row --}}
                                       <tr>
                                           <td class="second_heading align-middle segmnt_row" rowspan="3">

                                               5. {{$iief[4]->pres_lookupdata_name}}
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
                                        <td class="text-center align-middle segmnt_row">
                                            <div class="form-group form-check">
                                                <input type="radio" class="form-check-input5 iief_row_rec" value="{{'1'.'~'.$iief[4]->pres_lookupdata_name.'~'.$iief[4]->pres_lookupdata_no_pk.'~'.$iief[4]->pres_lookupdata_code}}"  iief_data-row="5" name="iief_row5" iief_data-value="1" />
                                                <label class="form-check-label" for="iief_exampleCheck1">1</label>
                                            </div>
                                        </td>
                                        <td class="text-center align-middle segmnt_row">
                                            <div class="form-group form-check">
                                                <input type="radio" class="form-check-input5 iief_row_rec" value="{{'2'.'~'.$iief[4]->pres_lookupdata_name.'~'.$iief[4]->pres_lookupdata_no_pk.'~'.$iief[4]->pres_lookupdata_code}}"  iief_data-row="5" name="iief_row5" iief_data-value="2" />
                                                <label class="form-check-label" for="iief_exampleCheck2">2</label>
                                            </div>
                                        </td>
                                        <td class="text-center align-middle segmnt_row">
                                            <div class="form-group form-check">
                                                <input type="radio" class="form-check-input5 iief_row_rec" value="{{'3'.'~'.$iief[4]->pres_lookupdata_name.'~'.$iief[4]->pres_lookupdata_no_pk.'~'.$iief[4]->pres_lookupdata_code}}"  iief_data-row="5" name="iief_row5" iief_data-value="3" />
                                                <label class="form-check-label" for="iief_exampleCheck3">3</label>
                                            </div>
                                        </td>
                                        <td class="text-center align-middle segmnt_row">
                                            <div class="form-group form-check">
                                                <input type="radio" class="form-check-input5 iief_row_rec" value="{{'4'.'~'.$iief[4]->pres_lookupdata_name.'~'.$iief[4]->pres_lookupdata_no_pk.'~'.$iief[4]->pres_lookupdata_code}}"  iief_data-row="5" name="iief_row5" iief_data-value="4" />
                                                <label class="form-check-label" for="iief_exampleCheck4">4</label>
                                            </div>
                                        </td>
                                        <td class="text-center align-middle segmnt_row">
                                            <div class="form-group form-check">
                                                <input type="radio" class="form-check-input5 iief_row_rec" value="{{'5'.'~'.$iief[4]->pres_lookupdata_name.'~'.$iief[4]->pres_lookupdata_no_pk.'~'.$iief[4]->pres_lookupdata_code}}"  iief_data-row="5" name="iief_row5" iief_data-value="5" />
                                                <label class="form-check-label" for="iief_exampleCheck5">5</label>
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
                                                    <td class="text-center" style="padding: 10px 0px !important;">Total Score:</td>
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
        {{-- <div class="modal-footer mt-1 text-left">
            @php
            $response_action = route('IIEF-5-questionnaire-page');

            @endphp
            <button type="button" class="btn btn-md btn-danger" iief_data-dismiss="modal">Exit</button>
            <button type="submit" class="btn btn-md btn-success" onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">Save changes</button>

        </div> --}}
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
    // $(document).on('keyup','#patient_name',function(){

    //     if($(this).val() ==''){



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



    var iief_sum = 0;
    var i = 0;
    var iief_prev_value = 0;
    var iief_row_val0 = 0;
    var iief_row_val1 = 0;
    var iief_row_val2 = 0;
    var iief_row_val3 = 0;
    var iief_row_val4 = 0;
    $('body').on('click','.iief_row_rec', function(){
        //let data_row = $(this).data('row');
       let iief_data_value = $(this).attr('iief_data-value');
      // console.log(iief_data_value);
        let iief_data_row = $(this).attr('iief_data-row');
        //console.log(iief_data_row);

        if (iief_data_row == 1) {
            iief_row_val0 = iief_data_value;
        }

        if (iief_data_row == 2) {
            iief_row_val1 = iief_data_value;
        }

        if (iief_data_row == 3) {
            iief_row_val2 = iief_data_value;
        }

        if (iief_data_row == 4) {
            iief_row_val3 = iief_data_value;
        }

        if (iief_data_row == 5) {
            iief_row_val4 = iief_data_value;
        }

        //console.log('record no ',data_row)
        if ($(this).prop('checked') === true) {
            i++;

            iief_sum=(parseInt(iief_row_val0)+parseInt(iief_row_val1)+parseInt(iief_row_val2)+parseInt(iief_row_val3)+parseInt(iief_row_val4));
            console.log(iief_sum);
            if((iief_sum >= 1 ) && (iief_sum <= 7))
            {
                $('.iief_severe').addClass('alert alert-warning');
            }
            else
            {
                $('.iief_severe').removeClass('alert alert-warning');

            }
            if((iief_sum >= 8) && (iief_sum <= 11))
            {
                $('.iief_moderate').addClass('alert alert-warning');
            }
            else
            {
                $('.iief_moderate').removeClass('alert alert-warning');

            }
            if((iief_sum >= 12 ) && (iief_sum <= 16))
            {
                $('.iief_mild-moderate').addClass('alert alert-warning');
            }
            else
            {
                $('.iief_mild-moderate').removeClass('alert alert-warning');

            }
            if((iief_sum >= 17 ) && (iief_sum <= 21))
            {
                $('.iief_mild-ed').addClass('alert alert-warning');
            }
            else
            {
                $('.iief_mild-ed').removeClass('alert alert-warning');

            }
            if((iief_sum >= 22 ) && (iief_sum <= 25))
            {
                $('.iief_no-ed').addClass('alert alert-warning');
            }
            else
            {
                $('.iief_no-ed').removeClass('alert alert-warning');

            }

            // console.log('iief_summery ',iief_sum)
            // if(i==7)
            // {
                //     console.log(iief_sum);

                // }
            }
        $('input.total_shim_score').val(iief_sum);
        })



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
