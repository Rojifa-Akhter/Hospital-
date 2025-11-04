@php

$role = (isset($role) && (!empty($role))) ? $role : [];
$id = ($role) ? $role->role_no_pk : '';
$role_name = ($role) ? $role->role_name : '';
$role_desc = ($role) ? $role->role_desc : '';
$status = ($role) ? $role->status : '';

@endphp

<form method="post" id="frm-menu-store" action="{{ route('role-store') }}">
    @csrf
    <input type="hidden" name="id" value="{{$id}}">
    <div class="form-group row">
        <label for="menu_id" class="col-sm-4 col-form-label col-form-label-sm">Role Name<span class="text-danger">*</span></label>
        <div class="col-sm-8">
            <input type="text" class="form-control form-control-sm" id="role_name" name="role_name" value="{{$role_name}}" placeholder="Role Name" >
        </div>

       
    </div>

    <div class="form-group row">
        <label for="menu_name" class="col-sm-4 col-form-label col-form-label-sm">Descpription <span class="text-danger">*</span></label>
        <div class="col-sm-8">
            <textarea  class="form-control form-control-sm" id="desc_name" name="desc_name" placeholder=" Write Description" >{{$role_desc}}</textarea>
        </div>

       

        <label for="menu_status" class="col-sm-4 col-form-label col-form-label-sm">Role Status</label>
        <div class="col-sm-8">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="status" id="status" value="1" {{$status == '1' ? 'checked' : ''}}>
                <label class="form-check-label" for="status">Active</label>
            </div>
        </div>
    </div>
    @php
    $response_action = route('role-list');
    @endphp

    <div class="modal-footer mt-1">
        
    <button type="button" class="btn btn-sm btn-success" onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">Save changes</button>
        <button type="button" data-dismiss="modal" class="btn btn-sm btn-danger">close</button>
        
        <a href="{{route('role-list')}}" class="btn btn-sm btn-info ">Exit</a>
    </div>
</form>