
<div class="">
    <label class="col-form-label col-form-label-sm" for="destination_bed">Bed </label>
    <select class="form-control form-control-sm select2" id="destination_bed" name="destination_bed" >
        <option value="">Select Bed</option>
        @if(!empty($data)) @foreach($data as $ipds_bed)
        <option value="{{$ipds_bed->bed_no_pk }}" }}>{{ $ipds_bed->bed_name }}</option>
        @endforeach @endif
    </select>
</div>
