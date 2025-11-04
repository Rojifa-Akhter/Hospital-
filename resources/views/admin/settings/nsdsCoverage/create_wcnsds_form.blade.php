@php

$nsdsCoverage = (isset($nsdsCoverage) && (!empty($nsdsCoverage))) ? $nsdsCoverage : [];

$nsdscoverage_no_pk = ($nsdsCoverage) ? $nsdsCoverage->nsdscoverage_no_pk : '';
$nsds_no_fk = ($nsdsCoverage) ? $nsdsCoverage->nsds_no_fk : '';
$ward_no_fk = ($nsdsCoverage) ? $nsdsCoverage->ward_no_fk : '';
$status = ($nsdsCoverage) ? $nsdsCoverage->status : '';
@endphp
<link rel="stylesheet" href="{{ asset('select2/dist/css/select2.min.css')}}">

<div class="col-sm-12 col-lg-5 col-xl-12">
    <form action="{{ route('ipd.store-wcnsds') }}" method="post" id="nsdscoverage-create">
        @csrf
        <input type="hidden" name="id" value="{{ $nsdscoverage_no_pk }}">
        <div class="form-group row">
            <div class="col-md-6">
                <label for="nsds_no_fk" class="col-sm-12 col-form-label col-form-label-sm">NSDS <span class="text-danger">*</span></label>
                <div class="col-sm-12">
                    <select class="form-control font_size_12 m-auto select2" id="nsds_no_fk" name="nsds_no_fk" required>
                        <option selected="selected" value="">Select NSDS</option>
                        @if(!empty($nsds))
                            @foreach ($nsds as $record)
                                <option value="{{ $record->nsds_no_pk }}" {{$record->nsds_no_pk == $nsds_no_fk ? 'selected' : ''}}>{{ $record->nsds_name }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <label for="ward_no_fk" class="col-sm-12 col-form-label col-form-label-sm">Ward<span class="text-danger">*</span></label>
                <div class="col-sm-12">
                    <select class="form-control font_size_12 m-auto select2" id="ward_no_fk" name="ward_no_fk" required>
                        <option selected="selected" value="">Select Ward</option>
                        @if(!empty($ward))
                            @foreach ($ward as $record)
                                <option value="{{ $record->ward_no_pk }}" {{$record->ward_no_pk == $ward_no_fk ? 'selected' : ''}}>{{ $record->ward_name }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-12">
                <label for="status" class="col-sm-12 col-form-label col-form-label-sm">Status</label>
                <div class="col-md-4">
                    <div class="form-check form-check-inline">
                       <input class="form-check-input" type="checkbox" name="status" id="status" value="1" {{ $status == '1' ? 'checked' : '' }}>
                       <label class="form-check-label" for="status">Active</label>
                   </div>
               </div>
           </div>
       </div>

       <div class="modal-footer">
        @php
        $response_action = route('wcnsds.index');
        @endphp
        <button class="btn btn-success btn-md" onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')"> Save</button>
        <button type="reset" class="btn btn-info btn-md" title="Click here to Clear form data">Clear</button>
        <a href="{{ route('wcnsds.index') }}" class="btn btn-danger btn-md" rel="tab" title="Click here to go back to Dashboard">Exit</a>
    </div>
</form>
</div>


<script type="application/javascript" src="{{ asset('select2/dist/js/select2.min.js')}}"></script>
<script>
    $('.select2').select2({});
</script>
