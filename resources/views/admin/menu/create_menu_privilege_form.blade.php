@php
$grant_dt = (isset($grant_date) && (!empty($grant_date))) ? $grant_date : [];
$grant_dt = ($grant_dt) ? date('Y/m/d', strtotime($grant_dt)) : '';
$menuPrivilege = (isset($menuPrivilege) && (!empty($menuPrivilege))) ? $menuPrivilege : [];
$feature_status = ($menuPrivilege) ? $menuPrivilege->status : '';
@endphp

<link href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css')}}">
<form method="post" id="frm-menu-store" action="{{ route('menu-privilege-store') }}">
    @csrf
    <div class="row">
        <div class="col-sm-4">
            <div class="form-group row">
                <label for="role_name" class="col-sm-12 col-form-label col-form-label-sm">Role Name<span class="text-danger">*</span></label>
                <div class="col-sm-12">

                    @if(isset($role))

                    @foreach($role as $key => $value)
                    <input type="radio" class="role_name" id="role_name_{{$value->role_no_pk}}" name="role_name" value="{{$value->role_no_pk}}" }}>
                    <label for="role_name_{{$value->role_no_pk}}"> {{$value->role_name}} </label><br />
                    @endforeach
                    @endif
                    <!-- </select> -->
                </div>
            </div>
        </div>
        <div class="col-sm-8">
            <div class="form-group row">
                <div class="col-sm-12">
                    <select class="form-control font_size_12 m-auto select2" id="user_name" name="user_name">

                        <option value="">Select User</option>
                        @if(isset($users) && $users->count() > 0 )
                        @foreach($users as $value)
                        <option value="{{$value->user_no_pk}}" {{$value->user_no_pk == $value->user_no_pk ? 'selected' : ''}}>
                            {{$value->user_fullname}}</option>
                        @endforeach
                        @endif
                    </select>
                </div>
            </div>

            <div class="form-group row  menu_show">
                <div class="col-md-11 mt-2" id="menu_name" style="max-height: 400px; overflow-y:auto;">
                    @include('admin.menu.menu_features')
                </div>

            </div>
        </div>

    </div>
    <input type="hidden" name="route" id="route" data-action="{{route('user-role-feature-dropdown')}}">
    <div class="form-group row mt-2">
        <label for="menu_id" class="col-sm-4 col-form-label col-form-label-sm">Grant Date </label>
        <div class="col-sm-8">
            <input type="text" class="form-control form-control-sm m-0 date_picker" id="grant_date" name="grant_date" placeholder="dd/mm/yyyy" value="{{$grant_dt}}">
        </div>
    </div>

    @php
    $response_action = route('menu-privilege-table');
    @endphp

    <div class="mt-1">
    <button type="button" class="btn btn-sm btn-success" onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">Save
            changes</button>
        <input type="button" class="btn btn-sm btn-danger " value="Close" data-dismiss="modal">
            <a href="{{route('menu-feature-table')}}" class="btn btn-sm btn-info">Exit</a>
    </div>
</form>
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script>
    $('.date_picker').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true,
        clearBtn: true,
    });
    $(document).ready(function() {
        $(".select2").select2();
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
