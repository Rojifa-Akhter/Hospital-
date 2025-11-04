<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<style>

    .error{
        color:red !important;
        font-size: 12px;
    }
    .roleTable tbody td{
        vertical-align:top
    }
    .pl-second{
        padding-left:50px !important;
    }
    .pl-third{
        padding-left: 70px !important;
    }
    .second-icon{
        font-size: 14px;
        color:#5253569e;
    }
    .third-icon{
        font-size: 12px;
        color:#B4B5B6;
    }
</style>
<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top shadow-sm">
        <div class="col-md-12 mb-1">
            <h5 class="mt-2 mb-0">Role Permission</h5>
            <small>Settings / Role Permission / Role Permission</small>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header text-center bg-primary text-white"><h5>Role Permission</h5></div>
                <div class="card-body p-2">                    
                    <div class="row justify-content-center">
                        <div class="col-md-6 col-12">
                            <div class="row">
                                <div class="col-10">
                                    <div class="input-group mb-3">
                                        <select id="role" name="role" class="form-control select2" form="rolePermissionForm" onchange="getRolesPermission()">
                                            <option value="" selected disabled>Select Roles</option>
                                            @foreach ($roles as $item)
                                                @if($item->status == 1)
                                                <option value="{{$item->role_no_pk}}">{{$item->role_name}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        <div class="input-group-append">
                                          {{-- <a class="form-control" href="{{route('role-list')}}" target="_blank"><i class="fa fa-plus" aria-hidden="true"></i></a> --}}
                                        </div>
                                      </div> 
                                </div>
                                <div class="col-2">
                                    <button class="btn-primary" style="width:32px;height:32px" onclick="collapseAll()"><i class="fa fa-compress" aria-hidden="true"></i></button>
                                </div>
                            </div>
                             
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@php 
$count = 1; 
$take = ceil(count($allMenus) / 2) ;
@endphp
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10 col-12">
            <form action="#" class="rolePermissionForm" id="rolePermissionForm" method="post" name="rolePermissionForm">
                @csrf()
                <div class="row">
                    <div class="col-md-6 col-12">
                        @forelse (collect($allMenus)->take($take) as $key1 => $item1)                       
                        <div id="accordion{{$count}}">
                            <div class="card">
                                <div class="card-header" id="heading{{$count}}">
                                    <a class="btn btn-link btn-block text-left global-uhl-table-bg accordion_title" data-toggle="collapse" data-target="#moduleInfo{{$count}}" aria-expanded="true" aria-controls="collapseThree">
                                        @php
                                            $total_features = 0;
                                            foreach ($item1->submenu as $key => $value) {
                                                $total_features+= count($value->pages);
                                            }
                                        @endphp
                                        <strong> {{ $count }} . {{ $item1->menu_name }} (<span style="color:green" id="permissionCount{{$item1->menu_no_pk}}">0</span> / {{$total_features}}) </strong>
                                        <i class="fa fa-angle-down float-right pt-2"></i>
                                    </a>
                                </div>
    
                                <div id="moduleInfo{{$count}}" class="collapse p-1" aria-labelledby="heading{{$count}}" data-parent="#accordion{{$count}}">
                                    @forelse  ($item1->submenu as $item2)
                              
                                    
                                        @php
                                            $datas = collect($item2->pages)->pluck('features_no_pk')->toArray();
                                    
                                        @endphp
                                        <table class="table roleTable table-striped" style="width:100%">
                                            <thead style="background-color: rgb(156, 155, 155);color:white">
                                                <tr>
                                                    <th style="width:80%" class="text-left pl-second"><span><i class="fa fa-square second-icon" aria-hidden="true"></i></span> {{ $item2->menu_name }}</th>
                                                    <th style="width:10%" class="text-center">@if(count($item2->pages) > 0) <input class="form-check-input" type="checkbox" value="1" id="permissionAll{{$item2->menu_no_pk}}" oninput="checkedAll({{json_encode($datas)}} , {{$item2->menu_no_pk}})"> <label for="permissionAll{{$item2->menu_no_pk}}">All</label> @endif</th>
                                                    <th style="width:10%" class="text-center">@if(count($item2->pages) > 0) Access @endif</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($item2->pages as $item3)
                                                    <tr>
                                                        <td colspan="2" class="pl-third py-0"><small> <span><i class="fa fa-square pr-1 third-icon" aria-hidden="true"></i><i class="fa fa-square third-icon" aria-hidden="true"></i></span> <label for="permission{{$item3->features_no_pk}}">{{ $item3->features_name }} </label> </small> </td>
                                                        <td class="text-center py-0">
                                                            <input class="form-check-input" type="checkbox" value="{{$item3->menu_no_pk}}-{{$item3->features_no_pk}}" id="permission{{$item3->features_no_pk}}" name="permission[]" oninput="uncheckedParent({{$item2->menu_no_pk}},{{$item3->features_no_pk}})">                                                  
                                                        </td>
                                                    </tr>                                   
                                                @empty
                                                    <tr>
                                                        <td class="text-center text-danger py-0" colspan="2"><small> Features Not Found! </small></td>
                                                    </tr>
                                                @endforelse 
                                            </tbody>
                                        </table>
                                    
                                    @empty
                                        <div class="text-center">
                                            <span class="text-danger"> <small>Features Not Found! </small></span>
                                        </div>
                                    @endforelse 

                                </div>
    
                            </div>
                        </div>  
                        @php $count++ @endphp                                                          
                    @empty
                        <h4 class="text-center">Module Not Found!</h4>
                    @endforelse
                    </div>

                    <!-- second phase -->

                    <div class="col-md-6 col-12">
                        @forelse (collect($allMenus)->skip($take) as $key2 => $item1)                                               
                            <div id="accordion{{$count}}">
                                <div class="card">
                                    <div class="card-header" id="heading{{$count}}">
                                        <a class="btn btn-link btn-block text-left global-uhl-table-bg accordion_title" data-toggle="collapse" data-target="#moduleInfo{{$count}}" aria-expanded="true" aria-controls="collapseThree">
                                            @php
                                                $total_features = 0;
                                                foreach ($item1->submenu as $key => $value) {
                                                    $total_features+= count($value->pages);
                                                }
                                            @endphp
                                        <strong> {{ $count }} . {{ $item1->menu_name }} (<span style="color:green" id="permissionCount{{$item1->menu_no_pk}}">0</span> / {{$total_features}}) </strong>
                                            <i class="fa fa-angle-down float-right pt-2"></i>
                                        </a>
                                    </div>
        
                                    <div id="moduleInfo{{$count}}" class="collapse p-1" aria-labelledby="heading{{$count}}" data-parent="#accordion{{$count}}">
                                        @forelse ($item1->submenu as $item2)
                                         
                                                @php
                                                    $datas = collect($item2->pages)->pluck('features_no_pk')->toArray();
                                                
                                                @endphp
                                            
                                                <table class="table roleTable table-striped" style="width:100%">
                                                    <thead style="background-color: rgb(156, 155, 155);color:white">
                                                        <tr>
                                                            <th style="width:75%" class="text-left pl-second"><span><i class="fa fa-square second-icon" aria-hidden="true"></i></span> {{ $item2->menu_name }}</th>
                                                            <th style="width:15%" class="text-center">@if(count($item2->pages) > 0) <input class="form-check-input" type="checkbox" value="1" id="permissionAll{{$item2->menu_no_pk}}" oninput="checkedAll({{json_encode($datas)}},{{$item2->menu_no_pk}})"> <label for="permissionAll{{$item2->menu_no_pk}}">All</label>  @endif</th>
                                                            <th style="width:10%" class="text-center">@if(count($item2->pages) > 0) Access @endif</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse ($item2->pages as $item3)
                                                            <tr>
                                                                <td colspan="2" class="pl-third py-0"><small> <span><i class="fa fa-square pr-1 third-icon" aria-hidden="true"></i><i class="fa fa-square third-icon" aria-hidden="true"></i></span> <label for="permission{{$item3->features_no_pk}}">{{ $item3->features_name }} </label> </small></small> </td>
                                                                <td class="text-center py-0">
                                                                    <input class="form-check-input" type="checkbox" value="{{$item3->menu_no_pk}}-{{$item3->features_no_pk}}" id="permission{{$item3->features_no_pk}}" name="permission[]" oninput="uncheckedParent({{$item2->menu_no_pk}},{{$item3->features_no_pk}})">                                                  
                                                                </td>
                                                            </tr>                                   
                                                        @empty
                                                            <tr>
                                                                <td class="text-center text-danger py-0" colspan="2"><small> Features Not Found! </small></td>
                                                            </tr>
                                                        @endforelse 
                                                    </tbody>
                                                </table>                                                              
                                        @empty
                                            <div class="text-center">
                                                <span class="text-danger"> <small>Features Not Found! </small></span>
                                            </div>
                                        @endforelse                                                    
                                    </div>
        
                                </div>
                            </div>   
                        @php $count++ @endphp                                                          
                    @empty
                        <h4 class="text-center">Module Not Found!</h4> 
                    @endforelse
                    </div>

                    <input type="hidden" name="role_hidden" id="role_hidden">

                </div>
                <div class="my-3 text-center">
                    <button type="button" class="btn btn-primary w-50" onclick="rolePermissionFormForm()">Save</button>  
                </div>             
            </form>
        </div>
        
    </div>
</div>

<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script>
    $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
        });
        $(document).ready(function() {
            $('.select2').select2();
        });
        function collapseAll(){
            $('.collapse').collapse('toggle')
        }

        function checkedAll(data,id){
            if($('#permissionAll'+id).is(':checked')){
                data.forEach(function(element) {
                    $("#permission" + element).prop("checked", true);
                });
            }
            else{
                data.forEach(function(element) {
                    $("#permission" + element).prop("checked", false);
                });
            }
        }

        function uncheckedParent(parent_id, self_id){
            if(!$('#permission'+self_id).is(':checked')){
                $("#permissionAll" + parent_id).prop("checked", false);
            }
           
        }

        function getRolesPermission(){
                var id = $('#role').val();
                $('#role_hidden').val(id);
                $.ajax({
                url: "{{route('v1.settings.get-role-permission','')}}/"+id,
                method: "get",
                beforeSend: function() {
                        blockUI();
                    },
                success: function(response){
                    if(response.data.length != 0)
                        {
                            let data = response.data;
                            let count_data = response.count_data;
                            $("input[type='checkbox']").prop("checked", false);
                            data.forEach(function(element) {
                                $("#permission"+element.features_no_fk).prop("checked", true);   
                            });

                            $('[id^="permissionCount"]').text('0');
                            count_data.forEach(function(element) {
                                $("#permissionCount"+element.parent_id).text(element.count);   
                            });
                        }
                    else
                        {
                            $('[id^="permissionCount"]').text('0');
                            $("input[type='checkbox']").prop("checked", false);
                        }
                },
                error:function(err){
                        var error = err.responseJSON;
                        $('.common-modal-notify-error').modal('show');
                        $('.common-modal-notify-error .modal-title').html('Failed');
                        $('.common-modal-notify-error .modal-body').html(error.message); 
                },
                complete: function() {
                    $.unblockUI();
                }
            })
        }

        <!-- Submit Form Data -->
        function rolePermissionFormForm(){
                let roles = $('#role_hidden').val();
                if(roles == ''){
                    alert('Please select Role')
                    return false;
                }
                let formElement = document.querySelector('#rolePermissionForm');
                let formData = new FormData(formElement);
                $.ajax({
                    url:"{{route('v1.settings.save-role-permission')}}",
                    type:"post",
                    dataType:"json",
                    data:formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        blockUI();
                    },
                    success:function(data){
                        $('.common-modal-notify').modal('show');
                        $('.common-modal-notify .modal-title').html(data.title);
                        $('.common-modal-notify .modal-body').html(data.message);
                    },
                    error:function(err){
                        var error = err.responseJSON;
                        $.unblockUI();
                        $('.common-modal-notify-error').modal('show');
                        $('.common-modal-notify-error .modal-title').html('Failed');
                        $('.common-modal-notify-error .modal-body').html(error.message);
                    },
                    complete: function() {
                        $.unblockUI();
                    }
                });
            
        }

</script>