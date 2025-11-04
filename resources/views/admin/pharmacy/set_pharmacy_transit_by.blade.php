
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<div class="container-fluid">
    <label for="patient_id" class=""> Transit By</label>
<input type="text" class="form-control" name="" id="patient_id">
<input type="hidden" name="" id="hdn_doctor_id" value="">
<input type="hidden" name="" id="indent_id" value="{{$indent_no}}">
<input type="hidden" name="" id="item_no" value="{{$item_no}}">
<input type="button" data-dismiss="modal" onclick="setTransitId(this)" class="btn btn-info" value="Set Transit By">
</div>

<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script>
//   openPatientAutocomplete('#patient_id', 'patient_name');
openDoctorAutocomplete('#patient_id', 'hdn_doctor_id', 'employee_ind', '1');
  function setTransitId(params) {
var id= $('#hdn_doctor_id').val();
var name= $('#patient_id').val();
var indent_no= $('#indent_id').val();
var item_no= $('#item_no').val();
$('#transit_info_'+indent_no+item_no).html(name +' '+'<span class="btn btn-sm btn-danger" data-id="" onclick="deleteTransBy(this)" data-url="" title="Cancel"><i class="fas fa-times"></i><div></div></span>');
$('#transit_by_id_'+indent_no+item_no).val(id);
// $('#transit_info_'+indent_no+item_no).parents('td').parents('tr').find('button').attr('disabled', true);
$('#button_'+indent_no+item_no).attr('disabled', false);
$('#button_'+indent_no+item_no).attr('data-transit_by_id', id);
console.log(indent_no+'_bellal_'+item_no);
  }
</script>
