
{{-- <link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('asset/timepicker/css/timepicker.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}"> --}}
<main id="page-content">    
        <section class="paitent__registration_details">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row bg-white border-bottom sticky-top shadow-sm">
                            <div class="col-md-12">
                                <h5 class="mt-2 mb-0">Ambulance List </h5>
                                <small>Ambulance / Ambulance List </small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                   <div class="card-header">
                        <h5>Ambulance List & Status</h5>
                    </div>
                    <div class="card-body">

                        <div class="form-row">
                            @if(!empty($ambulance_info))
                                @foreach($ambulance_info as $value)
                                    <div class="col-md-3">  
                                        <div class="card  p-2">
                                            <div class="card-body" >
                                                <table width="100%">
                                                    <tr>
                                                        <td style="width: 40%"> 
                                                           
                                                        @if($value['status']==1)                                                           
                                                            <i class="fa fa-ambulance" style="font-size:100px;color:green"></i>                                                          
                                                        @elseif($value['status']==2)
                                                            <i class="fa fa-ambulance" style="font-size:100px;color:blue"></i>                                                                                                                
                                                        @else
                                                            <i class="fa fa-ambulance" style="font-size:100px;color:red"></i>                                                                
                                                        @endif
                                                        </td>
                                                        <td style="vertical-align: text-top"> 
                                                            <strong>Name : </strong> {{$value['ambs_ambulance_name']}} <br>
                                                            <strong>Model :</strong> {{$value['model_no']}}<br>
                                                            <strong>No plate :</strong> {{$value['no_plate']}}<br>
                                                            <strong>License :</strong> {{$value['lic_no']}}<br>                                                          
                                                            <strong>Lic. Exp. Date :</strong> {{$value['lic_expire_date'] !="" ? date('d-m-Y',strtotime($value['lic_expire_date'])) :''}}<br>
                                                            <strong>Status :</strong>
                                                            @if($value['status']==1)
                                                                <span class="badge badge-success">Available</span>                                                                
                                                            @elseif($value['status']==2)
                                                                <span class="badge badge-info"> En Route</span>                                                               
                                                            @else
                                                                <span class="badge badge-danger">  Out of Service</span>                                                               
                                                            @endif
                                                            <span class="btn btn-sm btn-warning  open-modal" data-id="{{$value['ambs_ambulance_no_pk']}}" data-action="{{route('ambulance.ambulance-setup-edit',$value['ambs_ambulance_no_pk'])}}" data-modal="common-modal-xl" data-title="Edit" title="Edit"><i class="fa fa-pencil-alt"></i></span>
                                                             <br>
                                                        </td>
                                                    </tr>
                                                </table>
                                               
                                               
                                            </div>
                                        </div>                              
                                                                                               
                                    </div>
                                @endforeach
                            @endif      
                        </div>
                    </div>                   
                </div>

            </div>
        </section>
</main>
{{-- <script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('asset/timepicker/js/timepicker.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script> --}}
<script>
    $("body").addClass("sidebar-collapse");
 
  
</script>
