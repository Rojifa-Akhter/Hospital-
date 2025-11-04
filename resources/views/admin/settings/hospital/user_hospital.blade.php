<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.min.css') }}" rel="stylesheet">
<section id="full_lookup_list">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm">
            <div class="col-md-12">
                <div class="float-left">
                    <h5 class="mt-2 mb-0">Add New User Hospital</h5>
                    <small>Settings / Hospital Setup / User Hospital</small>
                </div>
                <div id="top-action">
                    <button class="btn btn-outline-primary btn-md float-right open-modal" data-modal="common-modal-sm" data-action="{{route('create_user_hospital')}}" data-title=" Add User Hospital<i
                            class=" fa fa-plus"></i> Add New User Hospital</button>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="row mt-2">
                    <div class="col-md-12 table-responsive">
                        <table id="datatable" class="table table-bordered table-hover table-striped data-table">
                            <thead class="bg-primary">


                                <tr>
                                    <th class="text-center" scope="col">Sl#</th>
                                    <th class="text-center" scope="col">Hospital Name</th>
                                    <th class="text-center" scope="col">User name</th>
                                    <th class="text-center" scope="col">Status</th>
                                    <th class="text-center width-150" scope="col">Actions</th>
                                </tr>
                            </thead>

                            <tbody>
                                @php $slNo = 0; @endphp
                                @foreach($user_hospital as $hospital_id => $hospital_data)
                                @php $hospital = 0 @endphp
                                @foreach($hospital_data as $user_id => $user_data)
                                @php $user = 0 @endphp
                                @foreach($user_data as $data)
                                @php $slNo++; @endphp
                                @php $hospital++; @endphp
                                @php $user++; @endphp
                                <tr>
                                    <td class="text-center w-5" scope="col">{{ $slNo }}</td>
                                    @if($hospital == 1)
                                    <td class="text-left w-25" scope="col" rowspan="{{count(\Illuminate\Support\Arr::collapse($hospital_data)) }}">{{$hospital_id}}</td>
                                    @endif
                                    @if($user == 1)
                                    <td class="text-left w-25" scope="col" rowspan="{{ count($user_data) }}">{{$user_id}}</td>
                                    @endif
                                    <td class="text-center w-10" scope="col">{{$data->status}}</td>
                                    <td class="text-center w-8" scope="col">
                                        <button class="btn btn-outline-primary btn-md open-modal" data-modal="common-modal-sm" data-action="{{ route('user-hospital-edit',$data->userhosp_no_pk) }}" data-title="ADD Menu Privilege" title="ADD Menu Privilege"><i class="fa fa-edit"></i> </button>
                                    </td>
                                </tr>

                                @endforeach
                                @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}">
</script>
