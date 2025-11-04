
<div class="row">
    <div class="col-md-6">
        <a class="btn btn-md btn-warning btn-block text-black"
           href="{{  route("radiology.rad-report-pdf",$print_id)}}" target="_blank">View</a>

    </div>
    <div class="col-md-6">
        <form action="{{route('radiology.skip-verify-and-finalize')}}" id="skip_verify" method="post">
            @csrf
            <input type="hidden" value="{{$print_id}}" name="hid_value">
            @php
                $response_action = route('radiology.result-finalize-wl');
            @endphp
            <button class="btn btn-md btn-primary btn-block text-black" onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')"> View And Finalize</button>
        </form>
    </div>
</div>

{{--<div class="col-sm-12 col-lg-5 col-xl-12">--}}
{{--    <form action="{{ route('bed.store-bed') }}" method="post" id="bed-create">--}}

{{--    </form>--}}
{{--</div>--}}
