{{-- @if (!empty($pat_info))
@dd($pat_info)
@endif --}}

<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<table width="100%" >
    <tr>
        <td>Name : </td>
        <td colspan="3"><input type="text" class="form-control" name="name" id="name" value="{{isset($pat_info->patient_name) ? $pat_info->patient_name :""}}" placeholder="name"> </td>
    </tr>
    <tr>
        <td>Father's Name : </td>
        <td ><input type="text" class="form-control" name="fathers_name" id="fathers_name" value="{{isset($pat_info->father_name) ? $pat_info->father_name :""}}" placeholder="name"> </td>
        <td>Date of Birth : </td>
        <td><input type="text" class="form-control date_picker" name="dob" id="dob" value="{{isset($pat_info->dob) ? date('d-m-Y',strtotime($pat_info->dob)) : ""}}" placeholder="dd-mm-YYYY"></td>

        <input type="hidden" name="patient_no_pk" value="{{isset($pat_info->patient_no_pk) ? $pat_info->patient_no_pk : ""}}">
        {{-- <input type="hidden" name="patient_name" value="{{isset($pat_info->patient_name) ? $pat_info->patient_name : ""}}"> --}}
        {{-- <input type="hidden" name="gender_txt" value="{{isset($pat_info->gender_txt) ? $pat_info->gender_txt : ""}}">
        <input type="hidden" name="dob" value="{{isset($pat_info->dob) ? date('d/m/Y',strtotime($pat_info->dob)) : ""}}"> --}}

    </tr>
    <tr>
        <td>  Sex : </td>
        <td><input type="text" class="form-control" name="sex" id="sex" value="{{isset($pat_info->gender_txt) ? $pat_info->gender_txt :""}}" placeholder="sex"> </td>
        <td> <label for="passport">Passport No :</label>  </td>
        <td><input type="text" class="form-control" name="passport" id="passport" value="{{isset($pat_info->passport_no) ?  $pat_info->passport_no : ''}}" placeholder="passport"></td>
    </tr>
    <tr>

          <td> <label for="height">Height (cm) :</label>  </td>
        <td><input type="text" class="form-control" name="height" id="height" value="{{isset($pat_info->height) ?  $pat_info->height : ''}}" placeholder="cm"> </td>
        <td> <label for="occupation">Occupation :</label>  </td>
        <td><input type="text" class="form-control" name="occupation" id="occupation" value="{{isset($pat_info->occupation_name) ?  $pat_info->occupation_name : ''}}" placeholder="occupation"></td>

    </tr>
    <tr>
           <td> <label for="weight"> Weight (kg) : </label></td>
        <td><input type="text" class="form-control" name="weight" id="weight" value="{{isset($pat_info->weight) ?  $pat_info->weight : ''}}"  placeholder="kg"></td>
        <td> <label for="citizenship"> Citizenship :</label> </td>
        <td><input type="text" class="form-control" name="citizenship" id="citizenship" value="{{isset($pat_info->nationality) ?  $pat_info->nationality : ''}}" placeholder="citizenship"></td>


    </tr>

</table>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script>
      $('.date_picker').datepicker({
                    todayHighlight: true,
                    format: 'dd-mm-yyyy',
                    // clearBtn: true,
                    // autoclose: true,
                    // endDate: '+0d',
                });
</script>
