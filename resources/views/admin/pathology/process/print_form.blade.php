
<div class="row">
    <div class="col-md-6">
{{--        <a class="btn btn-md btn-warning btn-block text-black"--}}
{{--           href="{{  route("path/bc-report-pdf",$print_id)}}" target="_blank">View</a>--}}
        <a href="{{ url('path/bc-report-pdf', $print_id) }}" class="btn btn-md btn-warning btn-block text-black" target="_blank">View</a>
{{--        <a href="{{ url('path/bc-report-pdf', $row->report_no_fk) }}" class="btn btn-sm btn-warning" target="_blank">Print</a>--}}

    </div>
    <div class="col-md-6">
        <form action="{{route('pathology.skip-verify-and-finalize')}}" id="skip_verify" method="post">
            @csrf
            <input type="hidden" value="{{$print_id}}" name="hid_value">
            @php
                $response_action = route('path.result-finalize');
            @endphp
            <button class="btn btn-md btn-primary btn-block text-black" onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')"> View And Finalize</button>
        </form>
    </div>
</div>
