@foreach ($doctors as $row)
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-4">
        <div class="custom-card">
            <div class="row no-gutters">
                <div class="col-md-4 text-center">
                    <div class="doctor_img">
                        <img class="w-100" src="{{ asset('images/doctor-img.jpg') }}" alt="">
                    </div>
                </div>

            </div>
            <div class="col-md-8">
                <div class="custom-card-body p-0 pb-3 pt-2">
                    <div class="informations text-left">
                        <span class="doctor_address"><strong>Employee ID :</strong> {{ $row->person_code }}</span><br>
                        <span><strong class="doctor_address">Name :</strong> {{ $row->salutation }} {{ $row->full_name }}</span><br>
                        @if($row->gender_txt > 0)
                            <span class="doctor_address"><strong>Gender: </strong>{{ $row->gender_txt }},
												@endif
                                @if($row->age > 0)
                                    <strong>Age: </strong>{{ $row->age }},
                                @endif
												<span class="badge badge-sm badge-warning border cursor-pointer">{{ $row->degree1 }}</span>
												<span class="badge badge-sm badge-warning border cursor-pointer">{{ $row->degree2 }}</span>
												<span class="badge badge-sm badge-warning border cursor-pointer">{{ $row->degree3 }}</span>
												<span class="badge badge-sm badge-warning border cursor-pointer">{{ $row->degree4 }}</span>
											</span>
                    </div>
                    <div class="doc_actions text-left">
                        @php
                            $doctor_schedule = route('doctor-schedule',$row->person_no_pk);
                            $show_action = route('doctor.show', $row->person_no_pk);
                            $edit_action = route('doctor.edit', $row->person_no_pk);
                            $doctor_fee_setup = route('doctor-fee-setup', $row->person_no_pk);

                        @endphp
                        <span Class="badge badge-sm badge-primary cursor-pointer open-modal" data-id="{{ $row->person_no_pk }}" data-action="{{ $show_action }}" data-modal="common-modal" data-title="View Employee Information" title="View Employee Information"><i class="fa fa-eye"></i> Profile</span>

                        <span Class="badge badge-sm badge-info cursor-pointer open-modal text-white" data-id="{{ $row->person_no_pk }}" data-action="{{ $edit_action }}" data-modal="common-modal" data-title="Edit Employee Information" title="Edit Employee Information"><i class="fa fa-pencil-alt"></i> Edit</span>

                        <span Class="badge badge-sm badge-secondary cursor-pointer open-modal" data-id="{{ $row->person_no_pk }}" data-action="{{ $doctor_schedule }}" data-modal="common-modal" data-title="Create Schedule For This Employee" title="reate Schedule For This Employee"><i class="fa fa-calendar-plus text-white"></i> Schedule</span>

                        <span  Class="badge badge-sm badge-success cursor-pointer open-modal" title="Billing Setup" data-modal="common-modal-sm" data-title="Employee Fee" data-action={{ $doctor_fee_setup }}><i class="fa fa-money-bill"></i> Fee</span>

                    </div>

                </div>
            </div>
        </div>
    </div>

@endforeach
