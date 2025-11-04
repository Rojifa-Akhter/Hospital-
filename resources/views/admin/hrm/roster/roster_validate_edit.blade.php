
<?php

$roster = (isset($roster_validate) && !empty($roster_validate) ? $roster_validate : []);
$roster_no_pk=  ($roster) ? $roster->roster_no_pk : '';
$shift_no_fk=  ($roster) ? $roster->shift_no_fk : '';
$duty_area_su_no_fk=  ($roster) ? $roster->duty_area_su_no_fk : '';
$duty_start_time=  ($roster) ? date('H:i:s',strtotime( $roster->duty_start_time)) : '';
$duty_end_time=  ($roster) ? date('H:i:s',strtotime($roster->duty_end_time))  : '';

?>

<div class="container-fluid" id="model">

    <div class="form-row">
        <div class="col-12">

            <form action=" {{route('roster.store-edit-roster')}}" method="post" id="validate_roster_form">
                @csrf
                <input type="hidden" name="roster_id" value="{{$roster_no_pk}}"/>

                <label>Duty Area</label>
                <select class="form-control " id="duty_area_list" name="duty_area_no" style="margin:0px!important;">
                   <option value="">Select Duty Area</option>
                   @if(!empty($dutyArea))
                   @foreach($dutyArea as $key => $value)
                   <option value="{{$key}}" {{($key == $duty_area_su_no_fk) ? 'selected' : ''}}>{{$value}}</option>
                   @endforeach
                   @endif
               </select>

               <label>Shift</label>
               <select class="form-control " id="shift_no" name="shift_type_no" style="margin:0px!important;">
                   <option value="">Select Shift</option>
                   @if(!empty($shift))
                   @foreach($shift as $value)
                   <?php	$time=explode(' ',$value->start_time); ?>
                   <option value="{{$value->start_time}}_{{$value->end_time}}_{{$value->shift_no_pk}}_{{$value->shift_code}}"{{($value->shift_no_pk == $shift_no_fk ) ? 'selected' : ''}}>{{$value->shift_code}}</option>
                   @endforeach
                   @endif
               </select>
               <label>Duty Start Time</label>
               <input type="text" class="  form-control " name="duty_start_time" value="{{$duty_start_time}}" id="shift_start_time"  style="margin: 0px !important;">
               <label>Duty End Time</label>
               <input type="text" class="  form-control " name="duty_end_time"  value="{{$duty_end_time}}" id="shift_end_time" style="margin: 0px !important;">

               <div class="col-md-12 p-0">
                <div class="card border-0">
                    <div class="card-body text-right">
                        @php
                        $response_action = route('roster.validate-roster');
                        @endphp
                        <button type="button" class="btn btn-md btn-success" id="validate_roster" onclick="btnSaveUpdate(this,'','','','', resetRoster)"> Save </button>
                        <button type="reset" class="btn btn-info btn-md" title="Click Here to Clear Form Data">Clear</button>
                        <button  class="btn btn-danger btn-md" data-dismiss="modal"  title="">Close</button>
                    </div>
                </div>
            </div>

        </form>

    </div>
</div>
</div>


<script type="text/javascript">
  $(document).on('change', '#shift_no', function() {

            // var shift= $(this).val();
            var time= $(this).val().split('_');
            var start_time  = time[0].split(' ');
            var end_time  = time[1].split(' ');
            $('#shift_start_time').val(start_time[1]);
            $('#shift_end_time').val(end_time[1]);
        });




</script>
