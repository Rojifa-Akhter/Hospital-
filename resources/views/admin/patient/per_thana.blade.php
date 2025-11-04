    <select class="form-control font_size_12 m-auto select2"
    id="doctor_pe_thana" name="doctor_pe_thana">
    <option value="0">Select Thana</option>
    @if(isset($thana_per))
    @foreach($thana_per as $value)
    <option value="{{$value->id}}" {{( $doctor_permanent_thana == $value->id) ? 'selected' : ''}}
    	>{{$value->name}}</option>
    	@endforeach
    	@endif
    </select>