

<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('datatables/media/css/jquery.dataTables.css') }}">
<link rel="stylesheet" href="{{ asset('datatables/media/css/buttons.dataTables.min.css') }}">
<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm">
        <div class="col-md-12">
            <h5 class="mt-2 mb-0">Prescription List</h5>
            <small>Doctor/ Prescription List</small>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header"><h5><i class="fa fa-search"></i> Search Panel</h5></div>
                <div class="card-body border-bottom-3 p-2">
                    <form action="{{route('prescription-list-search')}}" id="prescription-search" method="post">
                        <div class="form-row">
                            <div class="form-group col-md-1">
                                <label class="col-form-label col-form-label-sm" for="service_no">Service No</label>
                                <input type="text" class="form-control form-control-sm m-0" id="service_no" name="service_no" value="" placeholder="Service No" >
                            </div>

                            <div class="form-group col-md-2">
                                <label class="col-form-label col-form-label-sm" for="prescription_id">Prescription No</label>
                                <input type="text" class="form-control form-control-sm m-0" id="prescription_id" name="prescription_id" value="" placeholder="Prescription No" >
                            </div>

                            <div class="form-group col-md-3">
                                <label class="col-form-label col-form-label-sm" for="prescription_date_from">Date</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">From</div>
                                    </div>
                                    <input type="text" class="form-control form-control-sm m-0 date_picker" id="prescription_date_from" name="prescription_date_from" value="" placeholder="dd-mm-yyyy" >
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">To</div>
                                    </div>
                                    <input type="text" class="form-control form-control-sm m-0 date_picker" id="prescription_date_to" name="prescription_date_to" value="" placeholder="dd-mm-yyyy" >
                                </div>
                            </div>

                            <div class="form-group col-md-2">
                                <label class="col-form-label col-form-label-sm" for="mobile_no">Mobile No</label>
                                <input type="text" class="form-control form-control-sm m-0" id="mobile_no" name="mobile_no" value="" placeholder="Mobile No">
                            </div>

                            <div class="form-group col-md-2">
                                <label class="col-form-label col-form-label-sm" for="patient_name">Patient Name</label>
                                <input type="text" class="form-control form-control-sm m-0" id="patient_name" name="patient_name" value="" placeholder="Patient Name">
                            </div>

                            <div class="col-md-2">
                                <div class="btn-group btn-block" role="group">
                                    <button type="button" onclick="generateSearch( this, 'prescription-search', '{{ route('prescription-list-search') }}', 'prescription-list' )" class="btn btn-success btn-md mt-4"><i class="fa fa-search"></i> Search</button>
                                    <button type="reset" class="btn btn-info btn-md mt-4"><i class="fa fa-redo"></i> Reset</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card" id="">
                <div class="card-body mt-3">
                    <div class="row">
                        <div class="col-12 table-responsive" id = "prescription-list">
                            <table class="table data-table table-striped table-bordered table-hover">
                                <thead class="bg-primary">
                                    <tr>
                                        <th class="text-center">SL</th>
                                        <th class="text-center">Date</th>
                                        <th class="text-center">Prescription No</th>
                                        <th class="text-center">Patient</th>
                                        <th class="text-center">Doctor</th>
                                        <th class="text-center">C/O</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(!empty($prescription_list))
                                    @foreach($prescription_list as $prescription_list)
                                    <tr>
                                        <td class="text-center w-3">{{ $loop->iteration }}</td>
                                        <td class="text-left w-10">{{ date("d/m/Y", strtotime($prescription_list->prescription_date)) }}</td>
                                        <td class="text-left w-10"><strong>
                                            {{ !empty($prescription_list->prescription_uid)? $prescription_list->prescription_uid: '' }} </strong>
                                        </td>
                                        <td class="w-20">
                                            <div class="patient_info">
                                                <span data-title="View Patient Information" title="View Patient Information">
                                                    @if($prescription_list->patient_photo != '')
                                                    <img src="{{asset ('img/uploads/patient_images/thumb/')}}/{{$prescription_list->patient_photo}}" alt="patient image" class="rounded float-right" width="25">
                                                    @elseif($prescription_list->gender_txt == 'Male')
                                                    <img src="{{asset ('img/Male.png')}}" alt="patient image" class="rounded float-right" width="25">
                                                    @else
                                                    <img src="{{asset ('img/Female.png')}}" alt="patient image" class="rounded float-right" width="25">
                                                    @endif

                                                    <div class="patient_info_data">
                                                        <div>
                                                            <strong>{{ !empty($prescription_list->service_number)? $prescription_list->service_number: '' }}
                                                            </strong>
                                                        </div>
                                                        <div>{{ !empty($prescription_list->patient_name_rank)? $prescription_list->patient_name_rank: '' }}
                                                        </div>                                                    

                                                        <div>{{ !empty($prescription_list->gender_txt)? $prescription_list->gender_txt: '' }} , {{ !empty($prescription_list->age)? $prescription_list->age: '' }}
                                                        </div>
                                                        <div> {{ !empty($prescription_list->contact_official) ? $prescription_list->contact_official: '' }}
                                                        </div>
                                                    </div>
                                                </span>
                                            </div>
                                        </td>

                                        <td class="w-20 align-top" >
                                                <span data-title="View Patient Information" title="View Patient Information">

                                                    <img src="{{asset ('img/uploads/doctor_images/thumb/doc-1.png')}}" alt="doctor image" class="rounded float-right" width="25">
                                                    <div class="patient_info_data">                                                        
                                                        <div>
                                                            <strong>
                                                                {{ !empty($prescription_list->doctor_person_no_fk)? $prescription_list->doctor_person_no_fk: '' }}
                                                            </strong>
                                                        </div>
                                                        <div>
                                                            {{ !empty($prescription_list->doctor_name)? $prescription_list->doctor_name: '' }}
                                                        </div>
                                                    </div>
                                                </span>
                                        </td>
                                        <td class="w-20">
                                            <div class="patient_info">
                                                <span data-title="View C/O Information" title="View C/O Information">
                                                    <div class="patient_info_data">
                                                        <div>
                                                            <strong>
                                                                {{ !empty($prescription_list->ref_service_number)? $prescription_list->ref_service_number: '' }}                                                            
                                                            </strong>                                                     
                                                        </div>
                                                        <div>
                                                            {{ !empty($prescription_list->ref_patient_name_rank)? $prescription_list->ref_patient_name_rank: '' }}
                                                        </div>
                                                        <div>
                                                            {{ !empty($prescription_list->nok_relation)? $prescription_list->nok_relation: '' }}
                                                        </div>
                                                        <div>
                                                            {{ !empty($prescription_list->ref_age)? $prescription_list->ref_age: '' }}
                                                        </div>

                                                    </div>
                                                </span>
                                            </div>
                                        </td>
                                        <td class="text-center" >
                                            <a id="btn_emr" target="_blank" href="{{url('emr/patient-emr',$prescription_list->patient_no_pk)}}" class="btn btn-primary btn-sm cursor-pointer mx-1"><i class="fa fa-laptop-medical"></i> EMR</a>

                                            <button class="btn btn-sm btn-success open-modal" data-modal="common-modal-md" data-title="Prescription view" data-action="{{ route('prescription-print', $prescription_list->prescription_no_pk) }}" ><i class="fa fa-eye"></i></button>

                                            <a href="{{ route('prescription-print-pdf', $prescription_list->prescription_no_pk) }}" class="btn btn-sm btn-warning" target="_blank"  title="print"> <i class="fa fa-print"></i> </a>
                                        </td>
                                    </tr>

                                    @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="application/javascript" src="{{ asset('datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('datatables/media/js/dataTables.buttons.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('datatables/media/js/buttons.colVis.min.js') }}"></script>
<script>
    $(document).ready( function () {
        $('.data-table').DataTable({
            "bLengthChange": false,
            "bAutoWidth": false,
            "bPaginate": false,
            "ordering": false
        });
    });

    $('.date_picker').datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        todayHighlight: true,
        clearBtn: true
    });

    $(".date_picker").datepicker("setDate", new Date());

    openPatientAutocomplete('#service_no', 'service_number', function(item, obj){
        $('#patient_name').val(item.patient_name_rank);
        $('#mobile_no').val(item.phone_mobile);

        obj.stopImmediatePropagation();
    });

</script>

