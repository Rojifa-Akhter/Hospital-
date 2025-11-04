 <!-- Modal -->
 <form action="{{route('v1.settings.update-role')}}" method="post" id="updateRoleSetup" class="updateRoleSetup">
     @csrf
     <div class="form-row">
         
         <div class="col-lg-12 col-md-12 col-12">
             <div class="form-group form-row">
                 <label for="role_name" class="col-sm-4 col-form-label">Role Name<span style="color:red">*</span></label>
                 <div class="col-sm-8">
                     <input type="text" class="form-control form-control-sm" id="role_name" name="role_name" value="{{$role_info->role_name}}" placeholder="Role Name"/>
                         <input type="hidden" value="{{$role_info->role_no_pk}}" name="role_no_pk">
                 </div>
             </div>
         </div>
 
         <div class="col-lg-12 col-md-12 col-12">
             <div class="form-group form-row">
                 <label for="role_code" class="col-sm-4 col-form-label">Role Code<span style="color:red">*</span></label>
                 <div class="col-sm-8">
                     <input type="text" class="form-control form-control-sm" id="role_code"
                         name="role_code" value="{{$role_info->role_code}}" placeholder="Role Code"/>
                 </div>
             </div>
         </div>
 
         <div class="col-lg-12 col-md-12 col-12">
            <div class="form-group form-row">
                <label for="copy_role" class="col-sm-4 col-form-label">Copy Role Permission<span style="color:red">*</span></label>
                <div class="col-sm-8">
                    <select class="form-control role_copy"  id="copy_role" name="copy_role">
                        <option value="">--Copy Role Permission--</option>
                        @foreach ($roles as $item)
                            @if($item->status == 1)
                                <option value="{{$item->role_no_pk}}">{{ $item->role_name}}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

         <div class="col-lg-12 col-md-12 col-12">
             <div class="form-group form-row">
                 <label for="notes" class="col-sm-4 col-form-label">Notes</label>
                 <div class="col-sm-8">
                     <textarea class="form-control form-control-sm" id="notes"
                         name="notes" value="{{$role_info->role_desc}}" placeholder="Notes" cols="4" rows="4">{{$role_info->role_desc}}</textarea>
                 </div>
             </div>
         </div>
 
         <div class="col-lg-12 col-md-12 col-12">
             <div class="form-group form-row">
                 <label for="status" class="col-sm-4 col-form-label">Status</label>
                 <div class="col-sm-2 mt-1">
                     <input type="checkbox" id="status"
                         name="status" value="1" @if($role_info->status == 1) {{'checked'}} @endif/>
                 </div>
             </div>
         </div>
 
     </div>
 
     @php
         $redirect_url = route('v1.settings.role');
     @endphp
 
     <div class="text-center">
         <button type="submit" class="btn btn-primary uhl_save_btn mt-3"
             onclick="btnSaveUpdate(this,'','','','',getRole,'{{ $redirect_url }}')">Save</button>
         <button type="button" class="btn btn-danger mt-3" role_info-dismiss="modal">Close</button>
     </div>
 </form>
 <script>
     $(document).ready(function() {
         $("#updateRoleSetup").validate({
         rules:{
             role_no_pk:{
                 required:true, 
             },
             role_name:{
                 required:true,
                 minlength:5,
                 maxlength:200,
                 notOnlySpaces: true
             },
             role_code:{
                 required:true,
                 minlength:1,
                 maxlength:50,
                 notOnlySpaces: true
             },
             notes:{
                 maxlength:500
             }
         },
         messages:{
             role_no_pk:{
                 required: "Role No Required", 
             },
             role_name:{
                 required: "Role Name Required",
             },
             role_code:{
                 required: "Role Code Required",
             }
         }
         });
     });
 </script>