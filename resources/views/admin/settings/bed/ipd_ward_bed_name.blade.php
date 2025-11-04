
<div class="">
    <label class="col-form-label col-form-label-sm" for="destination_ward">Ward </label>
    <select class="form-control form-control-sm select2" id="destination_ward" name="destination_ward" onchange="bedViewer.getBedByWard(this)" >
        <option value="">Select Ward</option>
        @if(!empty($destinationWards)) @foreach($destinationWards as $dw)
        <option value="{{ $dw->ward_no_pk }}" >{{ $dw->ward_name }}</option>
        @endforeach @endif
    </select>
</div>
