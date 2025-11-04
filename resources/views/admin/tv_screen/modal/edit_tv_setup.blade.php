 <!-- Modal -->

 <form action="{{route('tv-screen.update-tv-info')}}" method="post" id="tvEditInfo" class="tvEditInfo">
    @csrf
    <div class="form-row">
 
        <div class="col-lg-12 col-md-12 col-12">
            <div class="form-group form-row">
                <label for="floor_no_fk" class="col-sm-4 col-form-label">Floor Name<span style="color:red">*</span></label>
                <div class="col-sm-8">
                    <select class="form-control form-control-sm floor_info" name="floor_no_fk" id="floor_no_fk">
                        <option value="" disabled selected>Select one</option>
                        @foreach ($floor as $item)
                                <option value="{{$item->physicalstruct_no_pk}}"  {{ $item->physicalstruct_no_pk == $data->floor_no_fk ? 'selected' : ''}}>{{ $item->physicalstruct_name}} ({{$item->physicalstruct_desc}})</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="form-group form-row">
                <label for="code" class="col-sm-4 col-form-label">Code<span style="color:red">*</span></label>
                <div class="col-sm-8">
                    <input class="form-control" type="text" id="code" name="code" placeholder="Code" value="{{$data->tvscreen_code}}" readonly>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="form-group form-row">
                <label for="name" class="col-sm-4 col-form-label">Name<span style="color:red">*</span></label>
                <div class="col-sm-8">
                    <input type="text" class="form-control form-control-sm" id="name" name="name" placeholder="Name" value="{{$data->tvscreen_name}}" />
                    <input type="hidden" class="form-control form-control-sm" id="tvscreen_no_pk" name="tvscreen_no_pk" placeholder="Name" value="{{@$tvscreen_no_pk}}" />
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
        $redirect_url = route('tv-screen.tv-setup');
    @endphp

    <div class="text-center">
        <button type="submit" class="btn btn-primary uhl_save_btn mt-3"
            onclick="btnSaveUpdate(this,'','','','',getTVInfo,'{{ $redirect_url }}')">Save</button>
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