@extends('iCure-Home.patient.partials.patient_master')

@push('patient_customcss')
	 <!-- Slick slider -->
	 <link rel="stylesheet" href="{{ asset('coverpage/css/slick.css') }}" />
	 <link rel="stylesheet" href="{{ asset('coverpage/css/slick-theme.css') }}" />
@endpush

@section('patient_content')
	 @php
	 $hospital_code = strtoupper(Session::get('user.ses_hospital_code'));
	 @endphp


	 <!--Page header-->
	 <div class="page-header shadow-sm">
		  <div class="page-leftheader">
				{{-- <h4 class="page-title mb-0">Hi! Welcome Back</h4> --}}
				<ol class="breadcrumb">
					 <li class="breadcrumb-item">
						  <a href="#"><i class="fe fe-home mr-2 fs-14"></i>Home</a>
					 </li>

						  <li class="breadcrumb-item active" aria-current="page"><a href="#">Patient Dashboard</a></li>
					 

				</ol>
		  </div>
		  <div class="page-rightheader">
		  </div>
	 </div>
	 <!--End Page header-->

	 <div class="row">
		  <div class="col-md-12">
				@if ($hospital_code != 'CHPC')
					 <div class="card">
						  <div class="card-header">

								<h3 class="card-title">Active Medicine </h3>
						  </div>
						  <div class="card-body">
								<div class=" row myClass">
									 @if (!empty($active_med_list))
										  @foreach ($active_med_list as $med_list_row)
												<div class="col-md-12">
													 <div class="card item-card">
														  <div class="card-body pb-0">
																<div class="text-center">
																	 <img src="{{ asset('images/product-01.jpg') }}" alt="img"
																		  class="img-fluid w-60">
																</div>
																<div class="card-body px-0 ">
																	 <div class="cardtitle">
																		  <div>
																				<a href="#"><i class="fa fa-star text-yellow fs-16"></i></a>
																				<a href="#"><i class="fa fa-star text-yellow fs-16"></i></a>
																				<a href="#"><i class="fa fa-star text-yellow fs-16"></i></a>
																				<a href="#"><i
																						  class="fa fa-star-half text-yellow fs-16"></i></a>
																				<a href="#"><i class="fa fa-star-o text-yellow fs-16"></i></a>
																				<a href="#"> (32)</a>
																		  </div>
																		  <a class="shop-title"
																				style="font-size: 12px !important;">{{ !empty($med_list_row->item_name) ? $med_list_row->item_name : '' }}</a>
																	 </div>
																	 <div class="cardprice">
																		  <span class="number-font"
																				style="font-size: 12px !important;">{{ !empty($med_list_row->sales_price) ? number_format($med_list_row->sales_price, 2) : 0 }}</span>
																		  <span class="number-font"
																				style="font-size: 12px !important;">Dose:
																				{{ !empty($med_list_row->dosage) ? $med_list_row->dosage : '' }}</span>
																	 </div>
																</div>
														  </div>
														  <div class="text-center pb-4 pl-4 pr-4">
																<a href="#" class="btn btn-primary mb-2"><i class="fe fe-eye mr-1"></i>View
																	 More</a>
																<a href="#" class="btn btn-secondary  mb-2"><i
																		  class="fe fe-shopping-cart mr-1"></i>Add to Cart</a>
														  </div>
													 </div>

												</div>
										  @endforeach
									 @endif
								</div>
						  </div>
					 </div>
				@endif

				<div class="card">
					 <div class="card-header">
						  @if ($hospital_code == 'CHPC')
								<h3 class="card-title">Service Schedule</h3>
						  @else
								<h3 class="card-title">Active Appointments</h3>
						  @endif
					 </div>
					 <div class="card-body">
						  @if ($hospital_code == 'CHPC')
								<div class="row">
									 <div class="col-md-12 table-responsive">
										  <table id="datatable"
												class="table table-bordered table-hover table-striped data-table-service-list">
												<thead style="background-color:#e8fbf3">
													 <tr>
														  <th class="text-center" scope="col">Sl#</th>
														  <th class="text-left" scope="col">Service No</th>
														  <th class="text-left" scope="col">Service Name</th>
														  <th class="text-left" scope="col">Date</th>
														  <th class="text-left" scope="col">Start Time</th>
														  <th class="text-left" scope="col">End Time</th>

														  {{-- <th class="text-center" scope="col">Rate</th> --}}
														  <th class="text-center" scope="col">Quantity</th>
														  {{-- <th class="text-center" scope="col">Amount</th> --}}
													 </tr>
												</thead>
												<tbody>
													 @if (isset($service_schedule))
														  @foreach ($service_schedule as $data)


																<tr>
																	 <td>{{ $loop->iteration }}</td>
																	 <td>{{ $data->schedule_no_pk }}</td>

																	 <td>{{ $data->selected_service_name }}</td>
																	 <td>{{ date('d/m/Y', strtotime($data->schedule_dt)) }}</td>
																	 <td>{{ date('h:i A', strtotime($data->start_time)) }}</td>
																	 <td>{{ date('h:i A', strtotime($data->end_time)) }}</td>
																	 {{-- <td>{{$data->service_rate}}</td> --}}
																	 <td class="text-center">{{ $data->schedule_session }}</td>
																	 {{-- <td>{{$data->service_rate}}</td> --}}



																</tr>
														  @endforeach
													 @endif
												</tbody>
										  </table>
									 </div>
								</div>
						  @else

								<div class="row activeAppointmentClass">


									 @if (!empty($active_appointment))
										  @foreach ($active_appointment as $appointment)
												<div class="col-md-12">
													 <div class="card item-card">
														  <div class="card-body pb-0">
																<div class="text-center">
																	 @if ($appointment->doctor_photo != '')
																		  <img class="avatat avatar-md brround mr-2 img-fluid w-60"
																				src="{{ asset('images/uploads/patient_images/thumb/' . $appointment->doctor_photo) }}"
																				alt="img">

																	 @else
																		  @if (ucfirst($appointment->gender_txt) == 'Female')
																				<img class="avatat avatar-md brround mr-2 img-fluid w-60"
																					 src="{{ asset('images/female-doc.jpg') }}" alt="img">
																		  @else
																				<img class="avatat avatar-md brround mr-2 img-fluid w-60"
																					 src="{{ asset('images/doc-1.png') }}" alt="img">
																		  @endif
																	 @endif
																</div>
																<div class="card-body px-0 ">
																	 <div class="cardtitle">
																		  <div>
																				<a href="#"><i class="fa fa-star text-yellow fs-16"></i></a>
																				<a href="#"><i class="fa fa-star text-yellow fs-16"></i></a>
																				<a href="#"><i class="fa fa-star text-yellow fs-16"></i></a>
																				<a href="#"><i
																						  class="fa fa-star-half text-yellow fs-16"></i></a>
																				<a href="#"><i class="fa fa-star-o text-yellow fs-16"></i></a>
																				<a href="#"> (32)</a>
																		  </div>
																		  <span class="shop-title mt-3"><b>Doctor Name &
																					 Dept.:</b>{{ !empty($appointment->full_name) ? ucfirst($appointment->full_name) : 'N/A' }}
																				&
																				{{ !empty($appointment->specialization) ? ucfirst($appointment->specialization) : 'N/A' }}</span>
																		  <span class="shop-title mt-3"><b>App. Sl &
																					 Date:</b>
																				{{ !empty($appointment->slot_sl) ? $appointment->slot_sl : 'N/A' }}
																				&
																				{{ date('d/m/Y', strtotime($appointment->appoint_date)) }}</span>
																	 </div>
																</div>
														  </div>
													 </div>

												</div>
										  @endforeach
									 @endif
								</div>
						  @endif
					 </div>
				</div>

				<div class="card">
					 <div class="card-header">
						  @if ($hospital_code == 'CHPC')
								<h3 class="card-title">Services Taken</h3>
						  @else
								<h3 class="card-title">Visited Doctor List</h3>
						  @endif
					 </div>
					 <div class="card-body">
						  @if ($hospital_code == 'CHPC')
								<div class="row">
									 <div class="col-md-12 table-responsive">
										  <table id="datatable"
												class="table table-bordered table-hover table-striped data-table-service-list">
												<thead style="background-color:#e8fbf3">
													 <tr>
														  <th class="text-center" scope="col">Sl#</th>
														  <th class="text-left" scope="col">Service No</th>

														  <th class="text-left" scope="col">Service Name</th>
														  <th class="text-left" scope="col">Date</th>
														  <th class="text-left" scope="col">Start Time</th>
														  <th class="text-left" scope="col">End Time</th>

														  {{-- <th class="text-center" scope="col">Rate</th> --}}
														  <th class="text-center" scope="col">Quantity</th>
														  {{-- <th class="text-center" scope="col">Amount</th> --}}
													 </tr>
												</thead>
												<tbody>
													 @if (isset($service_taken))
														  @foreach ($service_taken as $data)


																<tr>
																	 <td>{{ $loop->iteration }}</td>
																	 <td>{{ $data->schedule_no_pk }}</td>

																	 <td>{{ $data->selected_service_name }}</td>
																	 <td>{{ date('d/m/Y', strtotime($data->schedule_dt)) }}</td>
																	 <td>{{ date('h:i A', strtotime($data->start_time)) }}</td>
																	 <td>{{ date('h:i A', strtotime($data->end_time)) }}</td>
																	 {{-- <td>{{$data->service_rate}}</td> --}}
																	 <td class="text-center">{{ $data->schedule_session }}</td>
																	 {{-- <td>{{$data->service_rate}}</td> --}}



																</tr>
														  @endforeach
													 @endif
												</tbody>
										  </table>
									 </div>
								</div>
						  @else
								<div class="row">
									 @if (!empty($visited_list))
										  @foreach ($visited_list as $row)
												<div class="col-xl-12">
													 <div class="card">
														  <div class="card-body p-0">
																<div class="chat-widget-header d-flex p-5 align-items-center">
																	 <div
																		  class="font-weight-bold pr-4 mr-4 border-right d-none d-sm-none d-md-none d-lg-block">
																		  <div class="mt-1">
																				<h6 class="font-weight-semibold mb-0">{{ $loop->iteration }}
																				</h6>
																		  </div>
																	 </div>

																	 <div
																		  class="font-weight-bold pr-4 mr-4 border-right d-none d-sm-none d-md-none d-lg-block">
																		  <div class="mt-1">
																				<h6 class="font-weight-semibold mb-0">App. ID</h6>
																				<small>{{ !empty($row->appoint_code) ? $row->appoint_code : 'N/A' }}</small>
																		  </div>
																	 </div>


																	 <div
																		  class="font-weight-bold d-flex pr-4 mr-4 border-right align-items-center">
																		  {{-- <img class="avatat avatar-md brround mr-2" src="../../assets/images/users/1.jpg" alt="img"> --}}


																		  @if ($row->doctor_photo != '')
																				<img class="avatat avatar-md brround mr-2"
																					 src="{{ asset('images/uploads/patient_images/thumb/' . $row->doctor_photo) }}">
																		  @else
																				@if ($row->gender_txt == 'Male')
																					 <img class="avatat avatar-md brround mr-2"
																						  src="{{ asset('images/boy.jpg') }}" alt="">
																				@else
																					 <img class="avatat avatar-md brround mr-2"
																						  src="{{ asset('images/boy.jpg') }}" alt="">
																				@endif
																		  @endif


																		  <div class="mt-1 d-none d-sm-block">
																				<h6 class="font-weight-semibold mb-0">
																					 {{ !empty($row->full_name) ? $row->full_name : 'N/A' }}
																				</h6>
																				<small>{{ !empty($row->specialization) ? $row->specialization : 'N/A' }}</small>
																		  </div>
																	 </div>

																	 <div
																		  class="font-weight-bold pr-4 mr-4 border-right d-none d-sm-none d-md-none d-lg-block">
																		  <div class="mt-1">
																				<h6 class="font-weight-semibold mb-0">Date & Time</h6>
																				<small>{{ date('d/m/Y', strtotime($row->appoint_date)) }}</small>
																		  </div>
																	 </div>

																	 <div
																		  class="font-weight-bold pr-4 mr-4 border-right d-none d-sm-none d-md-none d-lg-block">
																		  <div class="mt-1">
																				<h6 class="font-weight-semibold mb-0">App Status</h6>
																				<small>Follow Up, Video Call</small>
																		  </div>
																	 </div>


																	 <div class="ml-auto">
																		  <div class="d-flex">
																				<a class="btn btn-sm btn-primary new-list2" href="#"
																					 data-placement="top" data-toggle="modal"
																					 data-target="#AppBook" title=""
																					 data-original-title="Make Appointment"
																					 onclick="patientApp({{ $row->doctor_no_fk }})"
																					 doctor_id="{{ $row->doctor_no_fk }}">Make Appointment</a>
																		  </div>
																	 </div>

																</div>
														  </div>
													 </div>
												</div>
										  @endforeach
									 @endif

								</div>
						  @endif
					 </div>
				</div>
				@if ($hospital_code != 'CHPC')
					 <div class="card">
						  <div class="card-header">
								<h3 class="card-title">My Prescription </h3>
						  </div>
						  <div class="card-body">
								<div class="row">
									 @if (!empty($prescribed_patient_list))
										  @foreach ($prescribed_patient_list as $list)
												<div class="col-xl-12">
													 <div class="card">
														  <div class="card-body p-0">
																<div class="chat-widget-header d-flex p-5 align-items-center">
																	 <div
																		  class="font-weight-bold d-flex pr-4 mr-4 border-right align-items-center">
																		  {{-- <img class="avatat avatar-md brround mr-2" src="../../assets/images/users/1.jpg" alt="img"> --}}
																		  @if ($list->doctor_photo != '')
																				<img class="avatat avatar-md brround mr-2"
																					 src="{{ asset('images/uploads/patient_images/thumb/' . $list->doctor_photo) }}">
																		  @else
																				@if ($list->gender_txt == 'Male')
																					 <img class="avatat avatar-md brround mr-2"
																						  src="{{ asset('images/boy.jpg') }}" alt="">
																				@else
																					 <img class="avatat avatar-md brround mr-2"
																						  src="{{ asset('images/boy.jpg') }}" alt="">
																				@endif
																		  @endif
																		  <div class="mt-1 d-none d-sm-block">
																				<h6 class="font-weight-semibold mb-0">
																					 {{ !empty($list->full_name) ? $list->full_name : 'N/A' }}
																				</h6>
																				<small>{{ !empty($list->specialization) ? $list->specialization : 'N/A' }}</small>
																		  </div>
																	 </div>

																	 <div
																		  class="font-weight-bold pr-4 mr-4 border-right d-none d-sm-none d-md-none d-lg-block">
																		  <div class="mt-1">
																				<h6 class="font-weight-semibold mb-0">Date</h6>
																				<small>{{ date('d/m/Y', strtotime($list->appoint_date)) }}</small>
																		  </div>
																	 </div>
																	 <div
																		  class="font-weight-bold pr-4 mr-4 border-right d-none d-sm-none d-md-none d-lg-block">
																		  <div class="mt-1">
																				<h6 class="font-weight-semibold mb-0">Chief Complaint</h6>
																				<small>Dental pain, Fever, Blood flow.</small>
																		  </div>
																	 </div>


																	 <div class="ml-auto">
																		  <div class="d-flex">
																				<a class="btn btn-sm btn-primary new-list2"
																					 href="{{ route('opd_prescription_print_pdf', $list->prescription_no_pk) }}"
																					 target="_blank" data-placement="top" data-toggle="tooltip"
																					 title="" data-original-title="View Appointment">View
																					 Prescription</a>
																		  </div>
																	 </div>

																</div>
														  </div>
													 </div>
												</div>
										  @endforeach
									 @endif


								</div>
						  </div>
					 </div>
				@endif


				<!-- Appointment Modal -->
				<div class="modal fade" id="AppBook" data-backdrop="static" data-keyboard="false" tabindex="-1"
					 aria-labelledby="staticBackdropLabel" aria-hidden="true">
					 <div class=" modal-dialog-centered modal-dialog modal-lg">
						  <div class="modal-content">
								{{-- <div class="modal-header"> --}}
								{{-- <h5 class="modal-title">Book Appointment</h5> --}}
								{{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"> --}}
								{{-- <span aria-hidden="true">&times;</span> --}}
								{{-- </button> --}}
								{{-- </div> --}}


								<div class="modal-header">
									 <h6 class="modal-title">Book Appointment</h6>
									 <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span
												aria-hidden="true">×</span></button>
								</div>


								<div class="modal-body" id="appId">

									 <!-- Sign-in start -->
									 @php
										  $patient_id = !empty(Auth::user()->patient_no_fk) ? Auth::user()->patient_no_fk : '';
										  $pat_details = \Illuminate\Support\Facades\DB::table('patient_info_vw')
												->where('patient_no_pk', $patient_id)
												->first();
										  $full_name = isset($pat_details->patient_name) ? $pat_details->patient_name : 'N/A';
										  $dob = isset($pat_details->dob) ? date('d-m-Y', strtotime($pat_details->dob)) : 'N/A';
										  $gender_txt = isset($pat_details->gender_txt) ? $pat_details->gender_txt : 'N/A';
										  $gender_id = isset($pat_details->gender) ? $pat_details->gender : 'N/A';
										  $mobile1 = isset($pat_details->mobile1) ? $pat_details->mobile1 : 'n/a';
										  $email = isset($pat_details->email) ? $pat_details->email : 'n/a';

									 @endphp

									 <form id="msform" method="post" action="{{ route('cover.appointment-store') }}">

										  @csrf

										  <div class="row align-items-center">
												<div class="col-md-12 text-center">
													 <div class="section_title_area about_us_section">
														  <h3 class="section_title2">Make Your Appointment</h3>
													 </div>
												</div>
										  </div>

										  <fieldset>
												<input type="hidden" class="keep_me" id="hdn_appointment_date"
													 name="hdn_appointment_date"
													 value="{{ !empty($doc_data[0]->schedule_dt) ? $doc_data[0]->schedule_dt : '' }}">
												<input type="hidden" class="keep_me" id="hdn_doctor_id" name="hdn_doctor_id"
													 value="{{ !empty($doc_data[0]->person_no_pk) ? $doc_data[0]->person_no_pk : '' }}">
												<input type="hidden" class="keep_me" id="hdn_hospital_id" name="hdn_hospital_id"
													 value="{{ !empty($doc_data[0]->au_entry_hospital_pk_no) ? $doc_data[0]->au_entry_hospital_pk_no : '' }}">
												<input type="hidden" class="keep_me" id="hdn_service_unit"
													 name="hdn_service_unit"
													 value="{{ !empty($doc_data[0]->serviceunit_no_fk) ? $doc_data[0]->serviceunit_no_fk : '' }}">
												<input type="hidden" class="keep_me" id="hdn_schedule_id" name="hdn_schedule_id"
													 value="{{ !empty($doc_data[0]->schedule_no_pk) ? $doc_data[0]->schedule_no_pk : '' }}">
												<input type="hidden" class="keep_me" id="hdn_patient_id" name="hdn_patient_id"
													 value="{{ !empty(Auth::user()->patient_no_fk) ? Auth::user()->patient_no_fk : '' }}">

												<input type="hidden"
													 value="{{ !empty($doc_data[0]->full_name) ? $doc_data[0]->full_name : '' }}"
													 id="doc_id">
												<input type="hidden"
													 value="{{ !empty($doc_data[0]->specialization) ? $doc_data[0]->specialization : '' }}"
													 id="doc_specialist">
												<input type="hidden"
													 value="{{ !empty($doc_data[0]->status) ? 'available' : 'unavailable' }}"
													 id="doc_status">
												<input type="hidden" value="" id="doc_app_mode">
												<input type="hidden" value="" id="doc_app_date">
												<input type="hidden"
													 value="{{ !empty($doc_data[0]->schedule_dt) ? date('H:i', strtotime($doc_data[0]->schedule_dt)) : '' }}"
													 id="doc_app_time">
												<input type="hidden"
													 value="{{ !empty($doc_data[0]->doctor_fee) ? $doc_data[0]->doctor_fee : 0 }}"
													 id="doc_fee">
												<div class="form-card mt-5">
													 <div class="row">
														  <div class="col-md-6">
																<div class="form-group">
																	 <label class="text-sucess form_label"> Patient Name<strong
																				class="text-danger">*</strong> </label>
																	 <input type="text" placeholder="Enter Your Name"
																		  name="patient_first_name" id="patient_name"
																		  class="form-control shadow-sm"
																		  value="{{ !empty(Auth::user()->user_fullname) ? Auth::user()->user_fullname : '' }} " />
																</div>
														  </div>

														  <div class="col-md-6">
																<div class="form-group">
																	 <label class="text-sucess form_label"> Select Gender<strong
																				class="text-danger">*</strong> </label>
																	 <select class="form-control shadow-sm pat_gender"
																		  name="patient_gender_id">
																		  <option value="">Select Gender</option>
																		  @if (!empty($gender))
																				@foreach ($gender as $pk => $gen)
																					 <option value="{{ $pk }}"
																						  {{ $pk == $gender_id ? 'selected' : '' }}>
																						  {{ $gen }}</option>
																				@endforeach
																		  @endif
																	 </select>
																</div>
														  </div>

														  <div class="col-md-6">
																<div class="form-group">
																	 <label class="text-sucess form_label"> Appointment For <strong
																				class="text-danger">*</strong> </label>
																	 <select
																		  class="form-control shadow-sm available_type pat_appointmentfor"
																		  name="appointment_person">
																		  <option value="Self">Self</option>
																		  <option value="Others">Others</option>
																	 </select>
																</div>
														  </div>

														  <div class="col-md-6">
																<div class="form-group">
																	 <label class="text-sucess form_label"> Phone Number <strong
																				class="text-danger">*</strong> </label>
																	 <input type="text" placeholder="Enter Your Phone Number"
																		  class="form-control shadow-sm pat_phone"
																		  value="{{ $mobile1 }}" name="phone" />
																</div>
														  </div>

														  <div class="col-md-6 optional_data d-none">
																<div class="form-group">
																	 <label class="text-sucess form_label"> Relation (Optional) </label>
																	 <input type="text" placeholder="Enter Relationship"
																		  class="form-control shadow-sm pat_relation" value=""
																		  name="relationship" />

																	 {{-- <select class="form-control shadow-sm"> --}}
																	 {{-- <option>Select Appointment</option> --}}
																	 {{-- <option>Father</option> --}}
																	 {{-- <option>Mother</option> --}}
																	 {{-- </select> --}}
																</div>
														  </div>


														  <div class="col-md-6">
																<div class="form-group">
																	 <label class="text-sucess form_label"> Email <strong
																				class="text-danger">*</strong> </label>
																	 <input type="email" placeholder="Enter Your Email"
																		  class="form-control shadow-sm pat_email" name="email"
																		  value="{{ $email }}" />
																</div>
														  </div>

														  <div class="col-md-6">
																<div class="form-group">
																	 <label class="text-sucess form_label"> Date of Birth <strong
																				class="text-danger">*</strong> </label>
																	 <input type="text" id="datepicker" value="{{ $dob }}"
																		  placeholder="dd/mm/yyyy"
																		  class="form-control shadow-sm pat_dateofbirth" name="dob" />
																</div>
														  </div>

														  <div class="col-md-6">
																<div class="form-group">
																	 <label class="text-sucess form_label"> Disease Details </label>
																	 <textarea class="form-control shadow-sm pat_details"></textarea>
																</div>
														  </div>

														  <div class="col-md-6 ">
																<div class="form-group">
																	 <label class="text-sucess form_label">PayMod </label>

																	 <select class="form-control shadow-sm p_mod">
																		  @if (!empty($bank_name))
																				@foreach ($bank_name as $pk => $bank)
																					 <option value="{{ $bank }}">{{ $bank }}
																					 </option>
																				@endforeach
																		  @endif
																	 </select>
																</div>
														  </div>
														  <div class="col-md-6">
																<div class="form-group">
																	 <label class="text-sucess form_label transaction_id"> Transaction
																		  Id</label>
																	 <input type="text" placeholder="Enter Transaction Id "
																		  class="form-control shadow-sm t_id" name="transaction_id"
																		  id="transaction_id" value="" />
																</div>
														  </div>
													 </div>
												</div>
												<button type="button" name="next" class="next action-button" id="loadBtnData"
													 onclick="appFunc.loadFunc(this)">Next
												</button>
												<button type="button" name="previous" class="previous action-button-previous">
													 Previous
												</button>
										  </fieldset>


										  <fieldset>
												<div class="form-card">
													 <div class="row p-3">


														  <div class="col-md-12">
																<div class="card">
																	 <div class="card-header">
																		  <h2 class="card-title">Patient & Doctor
																				Details</h2>
																	 </div>
																	 <div class="card-body">
																		  <table style="width: 100%;">
																				<tr>
																					 <td><label class="text-sucess confirm_label">Department
																						  </label>
																					 </td>
																					 <td>:</td>
																					 <td><span class="confirm_span specialist_data"></span>
																					 </td>

																					 <td><label class="text-sucess confirm_label">Patient
																								Name </label></td>
																					 <td>:</td>
																					 <td><span class="confirm_span pat_name"
																								id="pat_name_data"></span></td>
																				</tr>

																				<tr>
																					 <td><label class="text-sucess confirm_label"> Doctor
																								Name </label></td>
																					 <td>:</td>
																					 <td><span class="confirm_span doctor_name_app"
																								id=""></span></td>

																					 <td><label class="text-sucess confirm_label">
																								Gender </label></td>
																					 <td>:</td>
																					 <td><span class="confirm_span pat_gender_app" id=""></span>
																					 </td>
																				</tr>

																				<tr>
																					 <td><label class="text-sucess confirm_label">
																								Date </label></td>
																					 <td>:</td>
																					 <td><span class="confirm_span" id="app_date"> </span>
																					 </td>

																					 <td><label class="text-sucess confirm_label"> Mobile
																								Number </label></td>
																					 <td>:</td>
																					 <td><span class="confirm_span pat_mobile_num" id="">
																						  </span></td>
																				</tr>

																				<tr>
																					 <td><label class="text-sucess confirm_label">
																								Time </label></td>
																					 <td>:</td>
																					 <td><span class="confirm_span " id="">
																								{{ date('H:i') }} </span></td>

																					 <td><label class="text-sucess confirm_label">
																								Email </label></td>
																					 <td>:</td>
																					 <td><span class="confirm_span pat_email_app" id=""> </span>
																					 </td>
																				</tr>
																				<tr>
																					 <td><label class="text-sucess confirm_label">
																								Fee </label></td>
																					 <td>:</td>
																					 <td><span class="confirm_span doctor_fee_app" id="">
																						  </span></td>

																					 <td><label class="text-sucess confirm_label"> Disease
																								Details </label></td>
																					 <td>:</td>
																					 <td><span class="confirm_span disease_details" id="">
																						  </span></td>
																				</tr>

																				<tr>
																					 <td><label class="text-sucess confirm_label"> Paymod </label></td>
																					 <td>:</td>
																					 <td><span class="confirm_span paymod" id=""> </span></td>
																					 <td><label class="text-sucess confirm_label"> Transaction Id </label></td>
																					 <td>:</td>
																					 <td><span class="confirm_span transaction" id=""> </span></td>
																				</tr>


																		  </table>
																	 </div>
																</div>
														  </div>

													 </div>
												</div>

												<button type="button" class="previous action-button reset">Reset</button>
												@php
													 $appoint_id = '';
													 $response_url = route('appointment-card-pat', $appoint_id);
													 $redirect_url = route('cover.patient-admin-panel');
												@endphp
												<button type="button" class="action-button-previous pay"
													 data-response_action="{{ $response_url }}"
													 data-riderect_action="{{ $redirect_url }}"
													 onclick="appointmentEngine.saveAppointmentForPatient(this)">Go for Pay
												</button>


												{{-- @php --}}
												{{-- $response_action = route('cover.doctor-admin-panel'); --}}
												{{-- @endphp --}}
												{{-- <button type="submit"   class="action-button-previous pay" onclick="payAppointment(this)">Go for Pay</button> --}}
												{{-- <button type="button" class="action-button-previous pay" >Go for Pay</button> --}}
										  </fieldset>
									 </form>


									 <!-- sign-in end -->
								</div>
								<div class="modal-footer">
									 <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
									 <!-- <button type="button" class="btn btn-success">Sign In</button> -->
								</div>
						  </div>
					 </div>
				</div>


		  </div>
	 </div>









@endsection

@push('patient_customjs')
	 <!-- Slick slider -->
	 <script src="{{ asset('coverpage/js/slick.min.js') }}"></script>
	 <script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}">
	 </script>

	 <script>
		  $(document).ready(function() {
				var datatable = $('.data-table-service-list').DataTable({
					 'paging': false,
					 'searching': false,
					 'info': false
				});

		  });

		  function patientApp(doctor_id) {
				$.ajax({
					 data: {
						  doctor_id: doctor_id,
					 },
					 url: '{{ route('patient.appointment-modal') }}',
					 type: "get",
					 beforeSend: function() {
						  blockUI();
					 },
					 success: function(data) {
						  // alert(data[0])
						  //                      Patient Part
						  //                     Doctor Part
						  $('#doc_id').val(data[0].full_name);
						  $('#hdn_doctor_id').val(data[0].person_no_pk);
						  $('#doc_specialist').val(data[0].specialization);
						  // $('#doc_status').val(data[0].person_no_pk);
						  // $('#doc_app_mode').val(data[0].person_no_pk);
						  $('#doc_app_time').val(data[0].schedule_dt);
						  $('#hdn_appointment_date').val(data[0].schedule_dt);
						  $('#doc_fee').val(data[0].doctor_fee);

						  // ENd


						  let name = $('#patient_name').val();
						  let pat_appointment_for_app = $('.pat_appointmentfor').val();
						  let pat_gender_app = $('.pat_gender option:selected').text();
						  // let pat_gender_app = $('.pat_gender').val();
						  let pat_years_app = $('.pat_years_app').val();
						  let pat_mobile_num = $('.pat_phone').val();
						  let pat_email_app = $('.pat_email').val();
						  let hdn_appointment_date = $('#hdn_appointment_date').val();
						  let pat_relation = $('.pat_relation').val();
						  let pat_dateofbirth = $('.pat_dateofbirth').val();
						  let pat_details = $('.pat_details').val();
						  // doctor
						  let doctor_full_name = $('#doc_id').val();
						  let doc_specialist = $('#doc_specialist').val();
						  let doc_status = $('#doc_status').val();
						  let doc_app_mode = $('#doc_app_mode').val();
						  let doc_app_time = $('#doc_app_time').val();
						  let doc_fee = $('#doc_fee').val();

						  // Patient
						  $('#pat_name_data').html(name)
						  $('.appointment_status_app').html('Web')
						  $('.pat_appointment_app').html(pat_appointment_for_app)
						  $('.pat_gender_app').html(pat_gender_app)
						  $('.pat_years_app').html(pat_years_app)
						  $('.pat_mobile_num').html(pat_mobile_num)
						  $('.pat_email_app').html(pat_email_app)
						  $('.disease_details').html(pat_details)
						  $('#app_date').html(hdn_appointment_date)

						  // doctor part /
						  $('.doctor_time_app').html(doc_app_time)
						  $('.doctor_email_app').html(name)
						  $('.doctor_fee_app').html(doc_fee)
						  $('.doctor_name_app').html(doctor_full_name)
						  $('.specialist_data').html(doc_specialist)
					 },
					 complete: function() {
						  $.unblockUI();
					 }
				});
		  }

		  var appFunc = {
				loadFunc: function(thisElement) {
					 let name = $('#patient_name').val();
					 let pat_appointment_for_app = $('.pat_appointmentfor').val();
					 let pat_gender_app = $('.pat_gender option:selected').text();
					 // let pat_gender_app = $('.pat_gender').val();
					 let pat_years_app = $('.pat_years_app').val();
					 let pat_mobile_num = $('.pat_phone').val();
					 let pat_email_app = $('.pat_email').val();
					 let hdn_appointment_date = $('#hdn_appointment_date').val();
					 let pat_relation = $('.pat_relation').val();
					 let pat_dateofbirth = $('.pat_dateofbirth').val();
					 let pat_details = $('.pat_details').val();
					 // doctor
					 let doctor_full_name = $('#doc_id').val();
					 let doc_specialist = $('#doc_specialist').val();
					 let doc_status = $('#doc_status').val();
					 let doc_app_mode = $('#doc_app_mode').val();
					 let doc_app_time = $('#doc_app_time').val();
					 let doc_fee = $('#doc_fee').val();
					 let paymod = $('.p_mod option:selected').text();
					 let transaction_id = $('.t_id').val();

					 // Patient
					 $('#pat_name_data').html(name)
					 $('.appointment_status_app').html('Web')
					 $('.pat_appointment_app').html(pat_appointment_for_app)
					 $('.pat_gender_app').html(pat_gender_app)
					 $('.pat_years_app').html(pat_years_app)
					 $('.pat_mobile_num').html(pat_mobile_num)
					 $('.pat_email_app').html(pat_email_app)
					 $('.disease_details').html(pat_details)
					 $('#app_date').html(hdn_appointment_date)


					 // doctor part /


					 $('.doctor_time_app').html(doc_app_time)
					 $('.doctor_email_app').html(name)
					 $('.doctor_fee_app').html(doc_fee)
					 $('.doctor_name_app').html(doctor_full_name)
					 $('.specialist_data').html(doc_specialist)
					 $('.paymod').html(paymod)
					 $('.transaction').html(transaction_id)
				}
		  }

		  $('.myClass').slick({
				infinite: true,
				speed: 300,
				slidesToShow: 4,
				slidesToScroll: 1,
				autoplay: true,
				autoplaySpeed: 2000,
		  });
		  $('.activeAppointmentClass').slick({
				infinite: true,
				speed: 300,
				slidesToShow: 4,
				slidesToScroll: 1,
				autoplay: true,
				autoplaySpeed: 2000,
		  });
	 </script>
@endpush
