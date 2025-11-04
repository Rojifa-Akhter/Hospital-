@php
$menuPrivilege = (isset($menuPrivilege) && (!empty($menuPrivilege))) ? $menuPrivilege : [];
$id = ($menuPrivilege) ? $menuPrivilege->userfeatures_no_pk : '';
$user_no_fk = ($menuPrivilege) ? $menuPrivilege->user_no_fk : '';
$role_no_fk = ($menuPrivilege) ? $menuPrivilege->role_no_fk : '';
$features_no_fk = ($menuPrivilege) ? $menuPrivilege->features_no_fk : '';
$grant_date = ($menuPrivilege) ? date('d/m/Y', strtotime($menuPrivilege->grant_dt)) : '';
$feature_status = ($menuPrivilege) ? $menuPrivilege->status : '';
@endphp

<link href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}" rel="stylesheet">
<link href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
<!-- <link rel="stylesheet" href="{{ asset('asset/timepicker/css/timepicker.css') }}"> -->
<form method="post" id="frm-menu-store" action="{{ route('role-privilege-store') }}">
    @csrf
    <input type="hidden" name="id" value="{{$id}}">

    <input type="hidden" name="roleid" value="{{$roleid}}">

    <div class="form-group row  menu_show">
            <div class="col-md-11 mt-2" id="menu_name" style="max-height: 400px; overflow-y:auto;">
               @include('admin.menu.role_feature')
            </div>

            </div>
    @php
    $response_action = route('role-list');
    @endphp

    <div class="mt-4">
    <button type="button" class="btn btn-sm btn-success"
            onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">Save
            changes</button>
        <button type="button" data-dismiss="modal" class="btn btn-sm btn-danger ">close</button>
            <a href="{{route('role-list')}}" class="btn btn-sm btn-info ">Exit</a>
    </div>
</form>

<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script>
$(document).ready(function(){
$(".select2").select2();
$('.date_picker').datepicker();
});

$(document).on("click", "#all_check", function(e) {
        if ($(this).is(':checked')) {
            $(this).parents('#menu_name').find('input[type="checkbox"]').prop('checked',true);
        } else {
            $(this).parents('#menu_name').find('input[type="checkbox"]').prop('checked', false);
        }
    });
    $(document).on("click", ".modul_checkbox", function(e) {
        if ($(this).is(':checked')) {
            $(this).parents('.menu-item').find('input[type="checkbox"]').prop('checked',true);
        } else {
            $(this).parents('.menu-item').find('input[type="checkbox"]').prop('checked',false);
        }
    });
    $(document).on("click", ".menu_name", function(e) {
        if ($(this).not(':checked')) {
            $(this).parent('.menu-item').find('.modul_checkbox').prop('checked',false);
        }
    });
</script>
