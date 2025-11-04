  <select class="form-control font_size_12 m-auto select2"
  id="doctor_present_thana" name="doctor_pr_thana">
  <option value="">Select Thana</option>

  @if(isset($thana_pre))
  @foreach($thana_pre as $value)
  <option value="{{$value->id}}" {{($doctor_present_thana==$value->id) ? 'selected' : '' }}>
  	{{$value->name}}
  </option>
  @endforeach
  @endif
</select>