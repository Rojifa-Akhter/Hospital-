 <!-- Modal -->

 <form action="{{route('tv-screen.update-tv-wise-counter-info')}}" method="post" id="tvEditInfo" class="tvEditInfo">
    @csrf
    <div class="form-row">
 
        <div class="col-lg-12 col-md-12 col-12">
            <div class="form-group form-row">
                <label for="floor_no_fk" class="col-sm-4 col-form-label">TV Name<span style="color:red">*</span></label>
                <div class="col-sm-8">
                    

                    <select class="form-control form-control-sm select2" name="tv_no_fk" id="tv_no_fk">
                        <option value="" disabled selected>Select one</option>
                        @foreach($tv as $item)
                                <option value="{{$item->tvscreen_no_pk}}" {{ $item->tvscreen_no_pk == $data->tvscreen_no_fk ? 'selected' : ''}}>{{$item->tvscreen_name}} - {{ $item->physicalstruct_name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="form-group form-row">
                <label for="code" class="col-sm-4 col-form-label">Counter<span style="color:red">*</span></label>
                <div class="col-sm-8">
               

                    <select class="form-control form-control-sm" name="counter_no_fk" id="counter_no_fk">
                        <option value="" disabled selected>Select one</option>
                        @foreach ($cash_counter as $key => $item)
                            <option value="{{$key}}"  {{ $item == $data->tvscreendisplay_no_pk ? 'selected' : ''}}>{{ $item}}</option>
                        @endforeach
                    </select>
                    <input class="form-control" type="hidden" id="tvscreendisplay_no_pk" name="tvscreendisplay_no_pk" placeholder="Code" value="{{$tvscreendisplay_no_pk}}">
                </div>
            </div>
        </div>

        

        <div class="col-lg-12 col-md-12 col-12">
            <div class="form-group form-row">
                <label for="status" class="col-sm-4 col-form-label">Status</label>
                <div class="col-sm-2 mt-1">
                    <input type="checkbox" id="status" name="status" value="1" @if($data->status == 1) {{'checked'}} @endif/>
                </div>
            </div>
        </div>

    </div>

    @php
        $redirect_url = route('tv-screen.tv-wise-doctor-setup');
    @endphp

    <div class="text-center">
        <button type="button" class="btn btn-primary uhl_save_btn mt-3"
            onclick="btnSaveUpdate(this,'','','','',getCounterTVInfo,'{{ $redirect_url }}')">Save</button>
        <button type="button" class="btn btn-danger mt-3" data-dismiss="modal">Close</button>
    </div>
</form>
<script>
    $(document).ready(function() {
        $('.floor_info').select2();
        $("#tvEditInfo").validate({
            rules:{
                floor_no_fk:{
                    required:true, 
                },
                code:{
                    required:true,
                    maxlength:200,
                    notOnlySpaces: true
                },
                name:{
                    maxlength:250,
                    notOnlySpaces: true
                },
            },
            messages:{
                floor_no_fk:{
                    required: "Floor Name Required", 
                },
                code:{
                    required: "Code Required",
                },
                name:{
                    required: "Name Required",
                }
            }
        });
    });
</script>