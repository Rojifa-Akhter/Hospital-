 <!-- Modal -->
 <form action="{{route('v1.accounts.update-cost-center')}}" method="post" id="updateCostCenter" class="updateCostCenter">
    @csrf
    <div class="form-row">
        {{-- @dd($service_unit->getData()->data); --}}
        <div class="col-lg-12 col-md-12 col-12">
            <div class="form-group form-row">
                <label for="" class="col-sm-4 col-form-label">Department<span style="color:red">*</span></label>
                <div class="col-sm-8">
                    <select name="department_modal" id="department_modal" class="form-control form-control-sm selectCostCenter">
                        <option value="" disabled selected>Select One</option>
                        @foreach ($service_unit->getData()->data as $item)
                            @if($item->status == 1)
                            <option value="{{$item->serviceunit_no_pk}}" {{ $item->serviceunit_no_pk == $data->su_no_fk ? 'selected' : '' }}>{{$item->serviceunit_name}} - {{$item->serviceunit_code}}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="col-lg-12 col-md-12 col-12">
            <div class="form-group form-row">
                <label for="" class="col-sm-4 col-form-label">Cost Center Name<span style="color:red">*</span></label>
                <div class="col-sm-8">
                    <input type="text" class="form-control form-control-sm" id="costcenter_name"
                        name="costcenter_name" value="{{$data->costcenter_name}}" placeholder="Cost Center Name"/>
                        <input type="hidden" value="{{$data->costcenter_no_pk}}" name="costcenter_no_pk">
                </div>
            </div>
        </div>

        <div class="col-lg-12 col-md-12 col-12">
            <div class="form-group form-row">
                <label for="" class="col-sm-4 col-form-label">Cost Center Code<span style="color:red">*</span></label>
                <div class="col-sm-8">
                    <input type="text" class="form-control form-control-sm" id="costcenter_code" name="costcenter_code" value="{{$data->costcenter_code}}" placeholder="Cost Center Code"/>
                </div>
            </div>
        </div>

        <div class="col-lg-12 col-md-12 col-12">
            <div class="form-group form-row">
                <label for="notes" class="col-sm-4 col-form-label">Notes</label>
                <div class="col-sm-8">
                    <textarea class="form-control form-control-sm" id="notes"
                        name="notes" value="{{$data->notes}}" placeholder="Notes" cols="5" rows="5">{{$data->notes}}</textarea>
                </div>
            </div>
        </div>

        <div class="col-lg-12 col-md-12 col-12">
            <div class="form-group form-row">
                <label for="status" class="col-sm-4 col-form-label">Status</label>
                <div class="col-sm-2 mt-1">
                    <input type="checkbox" id="status"
                        name="status" value="1" @if($data->status == 1) {{'checked'}} @endif/>
                </div>
            </div>
        </div>

    </div>

    @php
        $redirect_url = route('v1.accounts.cost-center-setup');
    @endphp

    <div class="text-center">
        <button type="submit" class="btn btn-primary uhl_save_btn mt-3"
            onclick="btnSaveUpdate(this,'','','','',CostCenterFunc,'{{ $redirect_url }}')">Save</button>
        <button type="button" class="btn btn-danger mt-3" data-dismiss="modal">Close</button>
    </div>
</form>
<script>
    $(document).ready(function() {
        $('.selectCostCenter').select2();
        $("#updateCostCenter").validate({
            rules:{
                department_modal:{
                    required:true,
                },
                costcenter_name:{
                    required:true,
                    minlength:5,
                    maxlength:50,
                    notOnlySpaces: true
                },
                costcenter_code:{
                    required:true,
                    minlength:1,
                    maxlength:50,
                    notOnlySpaces: true
                },
                notes:{
                    maxlength:500,
                }
            },
            messages:{
                department_modal:{
                    required: "Department Required"
                },
                costcenter_name:{
                    required: "Cost Center Name Required",
                },
                costcenter_code:{
                    required: "Cost Center Code Required"
                }
            }
        });

    });
</script>