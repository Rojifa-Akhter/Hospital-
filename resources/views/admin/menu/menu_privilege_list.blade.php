<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css')}}">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">

<style>
    .dataTables_wrapper .dataTables_filter input {
        width: 190px;
        margin-top: 10px;
    }
</style>
<div class="container-fluid">
 <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm align-items-center">
     <div class="col-md-6">
         <h5 class="mt-2 mb-0">Menu Privilege</h5>
         <small>Settings / Menu Management / Leave Privilege</small>
     </div>
 </div>

 <div class="form-row" >

    <div class="col-md-3">
        <div class="card">
            <div class="card-header"><h5>Search Employee</h5></div>

            <div class="card-body">
             <form action="{{route('menu-privilege-emp-search')}}" method="post" id="search-employee">
                @csrf
                <div class="form-row">
                    <div class="col-md-12 mt-1">
                        <div class="form-group">
                         <label for="hospital" class="col-form-label col-form-label-sm">Hospital </label>
                         <select class="form-control  keep_me" id="hospital_name"
                         name="hospital_name" >
                         <option value="">Select Hospital</option>
                         @if(!empty($hospital))
                         @foreach($hospital as $value)
                         <option value="{{ $value->hospital_no_pk  }}"> {{ $value->hospital_name }}</option>
                         @endforeach
                         @endif
                     </select>
                 </div>
             </div>
         </div>
    <!--      <div class="form-row">
            <div class="col-md-12 mt-1">
                <div class="form-group">
                 <label for="hospital" class="col-form-label col-form-label-sm">Service Unit </label>
                 <select class="form-control select2 keep_me" id="su_name"
                 name="su_name" >
                 <option value="">Select Service Unit</option>
                 @if(!empty($service_unit))
                 @foreach($service_unit as $value)
                 <option value="{{ $value->su_no_pk  }}"> {{ $value->su_name  }}</option>
                 @endforeach
                 @endif
             </select>
         </div>
     </div>
 </div> -->
 <div class="row">
    <div class="col-md-12 text-left">
        <div class="">
            <button type="button" class="btn btn-md btn-success" id="emp_search" data-action=""><i class="fa fa-search"></i>Search</button>
            <button type="reset" class="btn btn-md btn-info"> Clear </button>
        </div>
    </div>
</div>
</form>
</div>

</div>

<div class="card">
    <div class="card-body">
        <div class="form-row ">
            <div  class="col-12 table-responsive" id="emp_name">
                @include('admin.menu.menu_privilege_emp_list')
            </div>
        </div>
    </div>
</div>
</div>
<div class="col-md-9">
    <div class="form-row"  id="employee_info">
          @include('admin.menu.menu_privilege_emp_info')
    </div>

</div>



</div>


</div>
</div>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js')}}"></script>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>

<script>
 $('.select2').select2();

 $(document).on("click", "#emp_search", function(e) {

var formMethod = $("#search-employee").attr("method");
var formID = $("#search-employee").attr("id");
var formAction = $("#search-employee").attr("action");
$.ajax({
    data: $('#' + formID).serialize(),
    url:formAction,
    type: formMethod,
    beforeSend: function() {
        blockUI();

    },
    success: function(data) {
        $("#emp_name").html(data);
    },
    complete: function() {
        $.unblockUI();
    }
});
});

 $(document).on("click", ".emp_id", function(e) {

var emp_hidden =$(this).siblings('#emp_hidden').val();

$('.emp_id').removeClass('bg-navy');
$(this).addClass('bg-navy');


var url= "{{route('menu-privilege-emp-info')}}";
$.ajax({
    data: {emp_hidden : emp_hidden},
    url:url,
    type: "post",
    beforeSend: function() {
        blockUI();

    },
    success: function(data) {
        $("#employee_info").html(data);
    },
    complete: function() {
        $.unblockUI();
    }
});

});


</script>


