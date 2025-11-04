@extends('iCure-Home.admin.partials.cover_master')
@section('admin_content')

                <!--Page header-->
                <div class="page-header shadow-sm">
                    <div class="page-leftheader">
                        <h4 class="page-title">Appointments</h4>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="#"><i class="fe fe-grid mr-2 fs-14"></i>Doctor</a>
                            </li>
                            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><a href="#">Appointments</a></li>
                        </ol>
                    </div>
                    <div class="page-rightheader">
                        <div class="btn btn-list">
                            <a href="#" class="btn btn-info"><i class="fe fe-plus mr-1"></i> Add New</a>
                        </div>
                    </div>
                </div>
                <!--End Page header-->

                <!-- Row -->
                <div class="row">
                    <div class="col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-body p-0">

                                <div class="panel panel-primary tabs-style-3">
                                    <div class="panel panel-primary">
                                        <div class=" tab-menu-heading p-0 bg-light">
                                            <div class="tabs-menu1 ">
                                                <!-- Tabs -->
                                                <ul class="nav panel-tabs" id="myTabs">
                                                    <li><a href="#today_patient" class="active" data-toggle="tab" onclick="app.toDayApp(this)" data-tab-type="1" data-action="{{route('admin.appointment-list')}}">Today (30)</a></li>
                                                    <li><a href="#next_day_patient" data-toggle="tab" onclick="app.toDayApp(this)" data-tab-type="2" data-action="{{route('admin.appointment-list')}}">Next Day (30)</a></li>
                                                    <li><a href="#future_patient" data-toggle="tab" onclick="app.toDayApp(this)" data-tab-type="3" data-action="{{route('admin.appointment-list')}}">Future Patient (30) </a></li>
                                                    <li><a href="#precribed_patients" data-toggle="tab" onclick="app.toDayApp(this)" data-tab-type="4" data-action="{{route('admin.appointment-list')}}">Prescribed Patients </a></li>
                                                    <input type="hidden" id="hdn_doctor_id" value="{{\Illuminate\Support\Facades\Auth::user()->person_no_fk}}">
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="panel-body tabs-menu-body">
                                            <div class="tab-content" id="my_tab_content">
                                                <div class="tab-pane active " id="today_patient">
                                                    <h4 class="page-title mb-3">Today's Appointments [{{date('d/m/Y')}}] ({{$appointment_data_count}})</h4>
                                                    @include('iCure-Home.admin.doctor.cover_doctor_appointment_list')
                                                </div>

                                                <div class="tab-pane " id="next_day_patient">
                                                    <h4 class="page-title mb-3">Nextday's Appointments [01/10/2021] (30)</h4>
                                                    @include('iCure-Home.admin.doctor.cover_doctor_appointment_list')
                                                </div>

                                                <div class="tab-pane " id="future_patient">
                                                    <h4 class="page-title mb-3">Future Appointments</h4>
                                                    @include('iCure-Home.admin.doctor.cover_doctor_appointment_list')
                                                </div>

                                                <div class="tab-pane " id="precribed_patients">
                                                    <h4 class="page-title mb-3">Prescribed Patients</h4>
                                                    @include('iCure-Home.admin.doctor.prescribed_patient_list')

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

<!-- Message Modal -->
<div class="modal fade" id="chatmodel" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-right chatbox" role="document">
        <div class="modal-content chat border-0">
            <div class="card overflow-hidden mb-0 border-0">
                <!-- action-header -->
                <div class="action-header">
                    <div class="float-left hidden-xs d-flex ml-2">
                        <div class="img_cont mr-3">
                            <img src="../../assets/images/users/2.jpg" class="rounded-circle user_img avatar avatar-md" alt="img" />
                        </div>
                        <div class="align-items-center mt-2 text-white">
                            <h5 class="mb-0">Jessica</h5>
                            <span class="dot-label bg-success"></span><span class="mr-3 fs-12">online</span>
                        </div>
                    </div>
                    <ul class="ah-actions actions align-items-center">
                        <li class="call-icon">
                            <a href="" class="d-done d-md-block phone-button">
                                <i class="fa fa-prescription fs-20"></i>
                            </a>
                        </li>

                        <li class="dropdown">
                            <a href="" data-toggle="dropdown" aria-expanded="true">
                                <i class="fe fe-more-vertical fs-20"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li><i class="fa fa-user-circle"></i> View profile</li>
                                <li><i class="fa fa-users"></i> Add to close friends</li>
                                <li><i class="fa fa-plus"></i> Add to group</li>
                                <li><i class="fa fa-ban"></i> Block</li>
                            </ul>
                        </li>
                        <li>
                            <a href="" class="" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true"><i class="fe fe-x fs-20"></i></span>
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- action-header end -->
                <!-- msg_card_body -->
                <div class="card-body msg_card_body">
                    <div class="chat-box-single-line">
                        <abbr class="timestamp">February 1st, 2019</abbr>
                    </div>
                    <div class="d-flex justify-content-start">
                        <div class="img_cont_msg">
                            <img src="../../assets/images/users/9.jpg" class="rounded-circle user_img_msg" alt="img" />
                        </div>
                        <div class="msg_cotainer">
                            Hi, how are you Jenna Side?
                            <span class="msg_time">8:40 AM, Today</span>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <div class="msg_cotainer_send">
                            Hi Connor Paige i am good tnx how about you?
                            <span class="msg_time_send">8:55 AM, Today</span>
                        </div>
                        <div class="img_cont_msg">
                            <img src="../../assets/images/users/2.jpg" class="rounded-circle user_img_msg" alt="img" />
                        </div>
                    </div>
                    <div class="d-flex justify-content-start">
                        <div class="img_cont_msg">
                            <img src="../../assets/images/users/9.jpg" class="rounded-circle user_img_msg" alt="img" />
                        </div>
                        <div class="msg_cotainer">
                            I am good too, thank you for your chat template
                            <span class="msg_time">9:00 AM, Today</span>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <div class="msg_cotainer_send">
                            You welcome Connor Paige
                            <span class="msg_time_send">9:05 AM, Today</span>
                        </div>
                        <div class="img_cont_msg">
                            <img src="../../assets/images/users/2.jpg" class="rounded-circle user_img_msg" alt="img" />
                        </div>
                    </div>
                    <div class="d-flex justify-content-start">
                        <div class="img_cont_msg">
                            <img src="../../assets/images/users/9.jpg" class="rounded-circle user_img_msg" alt="img" />
                        </div>
                        <div class="msg_cotainer">
                            Yo, Can you update Views?
                            <span class="msg_time">9:07 AM, Today</span>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mb-4">
                        <div class="msg_cotainer_send">
                            But I must explain to you how all this mistaken born and I will give
                            <span class="msg_time_send">9:10 AM, Today</span>
                        </div>
                        <div class="img_cont_msg">
                            <img src="../../assets/images/users/2.jpg" class="rounded-circle user_img_msg" alt="img" />
                        </div>
                    </div>
                    <div class="d-flex justify-content-start">
                        <div class="img_cont_msg">
                            <img src="../../assets/images/users/9.jpg" class="rounded-circle user_img_msg" alt="img" />
                        </div>
                        <div class="msg_cotainer">
                            Yo, Can you update Views?
                            <span class="msg_time">9:07 AM, Today</span>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mb-4">
                        <div class="msg_cotainer_send">
                            But I must explain to you how all this mistaken born and I will give
                            <span class="msg_time_send">9:10 AM, Today</span>
                        </div>
                        <div class="img_cont_msg">
                            <img src="../../assets/images/users/2.jpg" class="rounded-circle user_img_msg" alt="img" />
                        </div>
                    </div>
                    <div class="d-flex justify-content-start">
                        <div class="img_cont_msg">
                            <img src="../../assets/images/users/9.jpg" class="rounded-circle user_img_msg" alt="img" />
                        </div>
                        <div class="msg_cotainer">
                            Yo, Can you update Views?
                            <span class="msg_time">9:07 AM, Today</span>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mb-4">
                        <div class="msg_cotainer_send">
                            But I must explain to you how all this mistaken born and I will give
                            <span class="msg_time_send">9:10 AM, Today</span>
                        </div>
                        <div class="img_cont_msg">
                            <img src="../../assets/images/users/2.jpg" class="rounded-circle user_img_msg" alt="img" />
                        </div>
                    </div>
                    <div class="d-flex justify-content-start">
                        <div class="img_cont_msg">
                            <img src="../../assets/images/users/9.jpg" class="rounded-circle user_img_msg" alt="img" />
                        </div>
                        <div class="msg_cotainer">
                            Okay Bye, text you later..
                            <span class="msg_time">9:12 AM, Today</span>
                        </div>
                    </div>
                </div>
                <!-- msg_card_body end -->
                <!-- card-footer -->
                <div class="card-footer">
                    <div class="msb-reply-button d-flex">
                        <div class="input-group">
                            <input type="text" class="form-control bg-white" placeholder="Typing...." />
                            <div class="input-group-append">
                                <button type="button" class="btn btn-primary">
                                    <i class="fa fa-paper-plane"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- card-footer end -->
            </div>
        </div>
    </div>
</div>

@endsection


@push('admin_js')
    <script>


        var app ={
          toDayApp:function (thisElement) {
              const data_id = $(thisElement).attr('data-tab-type');
              const data_action = $(thisElement).attr('data-action');
              const hdn_doctor_id = $('#hdn_doctor_id').val();

              $.ajax({
                  data: { data_id:data_id, hdn_doctor_id:hdn_doctor_id },
                  url: data_action,
                  type: "post",
                  beforeSend:function(){
                      blockUI();
                  },
                  success: function (data) {
                      $(thisElement).parents("#myTabs").siblings("#my_tab_content").html(data);
                  },
                  complete:function(){
                      $.unblockUI();
                  }
              });
          }
        }
    </script>

@endpush
