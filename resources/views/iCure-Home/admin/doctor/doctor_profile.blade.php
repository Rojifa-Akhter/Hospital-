@extends('iCure-Home.patient.partials.patient_master')

@section('patient_content')
    <!--Page header-->
    <div class="page-header shadow-sm">
        <div class="page-leftheader">
            <h4 class="page-title mb-0">Dr. Afiya Ashrafi </h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#"><i class="fe fe-layers mr-2 fs-14"></i>Profile</a></li>
                <li class="breadcrumb-item active" aria-current="page"><a href="#">Dr. Afiya Ashrafi </a></li>
            </ol>
        </div>
        <div class="page-rightheader">
            <!-- <div class="btn btn-list">
                <a href="#" class="btn btn-info"><i class="fe fe-settings mr-1"></i> General Settings </a>
                <a href="#" class="btn btn-danger"><i class="fe fe-printer mr-1"></i> Print </a>
                <a href="#" class="btn btn-warning"><i class="fe fe-shopping-cart mr-1"></i> Buy Now </a>
            </div> -->
        </div>
    </div>
    <!--End Page header-->

    <!--/app header-->
    <div class="main-proifle shadow-sm">
        <div class="row">
            <div class="col-lg-8">
                <div class="box-widget widget-user">
                    <div class="widget-user-image1 d-sm-flex">
                        <img alt="User Avatar" class="rounded-circle border p-0" src="../../assets/images/users/2.jpg" />
                        <div class="mt-1 ml-lg-5">
                            <h4 class="pro-user-username mb-3 font-weight-bold">Dr. Afiya Ashrafi  <i class="fa fa-check-circle text-success"></i></h4>
                            <ul class="mb-0 pro-details">
                                <li>
                                    <span class="profile-icon"><i class="fas fa-user-md"></i></span><span class="h6 mt-3">BMDC/ Licence No: 01232012546</span>
                                </li>
                                <li>
                                    <span class="profile-icon"><i class="fe fe-mail"></i></span><span class="h6 mt-3">Afiya@gmail.com</span>
                                </li>
                                <li>
                                    <span class="profile-icon"><i class="fe fe-flag"></i></span><span class="h6 mt-3">English, Bangla, Hindi</span>
                                </li>
                                <li>
                                    <span class="profile-icon"><i class="fe fe-phone-call"></i></span><span class="h6 mt-3">+345 657 567</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-auto">
                <div class="text-lg-right btn-list mt-4 mt-lg-0">
                    <!-- <a href="#" class="btn btn-light">Message</a> -->
                    <a href="editprofile.php" class="btn btn-primary">Edit Profile</a>
                </div>
                <div class="mt-5">
                    <div class="main-profile-contact-list row">
                        <div class="media col-sm-4">
                            <div class="media-icon bg-primary text-white mr-3 mt-1">
                                <i class="fas fa-prescription"></i>
                            </div>
                            <div class="media-body">
                                <small class="text-muted">Prescription</small>
                                <div class="font-weight-bold number-font">
                                    2,450
                                </div>
                            </div>
                        </div>
                        <div class="media col-sm-4">
                            <div class="media-icon bg-secondary text-white mr-3 mt-1">
                                <i class="fa fa-users fs-18"></i>
                            </div>
                            <div class="media-body">
                                <small class="text-muted">Patients</small>
                                <div class="font-weight-normal1">
                                    6,890
                                </div>
                            </div>
                        </div>
                        <div class="media col-sm-4">
                            <div class="media-icon bg-info text-white mr-3 mt-1">
                                <i class="fa fa-feed fs-18"></i>
                            </div>
                            <div class="media-body">
                                <small class="text-muted">Regular Followup</small>
                                <div class="font-weight-bold number-font">
                                    3,765
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="profile-cover">
            <div class="wideget-user-tab">
                <div class="tab-menu-heading p-0">
                    <div class="tabs-menu1 px-3">
                        <ul class="nav">
                            <li><a href="#tab-7" class="active fs-14" data-toggle="tab">About</a></li>
                            <li><a href="#tab-8" data-toggle="tab" class="fs-14">Patients</a></li>
                            <!-- <li><a href="#tab-9" data-toggle="tab" class="fs-14">Timeline</a></li> -->
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.profile-cover -->
    </div>
    <!-- Row -->
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12">
            <div class="border-0">
                <div class="tab-content">
                    <div class="tab-pane active" id="tab-7">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="font-weight-bold clearfix">Biography <button class="btn btn-sm ml-auto float-right" data-toggle="modal" data-target="#biography_modal" data-effect="effect-super-scaled"><i class="fa fa-plus"></i></button></h5>
                                <div class="main-profile-bio mb-0">
                                    <p>
                                        simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy when an unknown printer took a galley of type and scrambled it to
                                        make a type specimen book. It has survived not only five centuries nchanged.
                                    </p>
                                    <p>
                                        Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum
                                        dolore eu fugiat nulla pariatur.
                                    </p>
                                    <p class="mb-0">
                                        pleasure rationally encounter but because pursue consequences that are extremely painful.occur in which toil and pain can procure him some great pleasure.. <a href="">More</a>
                                    </p>
                                </div>
                            </div>

                            <div class="card-body border-top">
                                <h5 class="font-weight-bold clearfix">Education & Degrees<button class="btn btn-sm ml-auto float-right" data-toggle="modal" data-target="#education_modal" data-effect="effect-super-scaled"><i class="fa fa-plus"></i></button></h5>
                                <div class="main-profile-contact-list d-lg-flex">
                                    <div class="media mr-5">
                                        <div class="media-icon bg-danger text-white mr-4">
                                            <i class="fas fa-user-graduate"></i>
                                        </div>
                                        <div class="media-body">
                                            <h6 class="font-weight-bold mb-1">Studied at <a href="" class="btn-link">Dhaka Medical College Hospital</a></h6>
                                            <span>2004-2008</span>
                                            <p>Graduation: Bachelor of Medical Sciences.</p>
                                        </div>
                                    </div>

                                    <div class="media mr-5">
                                        <div class="media-icon bg-danger text-white mr-4">
                                            <i class="fas fa-user-graduate"></i>
                                        </div>
                                        <div class="media-body">
                                            <h6 class="font-weight-bold mb-1">Studied at <a href="" class="btn-link">Dhaka Medical College Hospital</a></h6>
                                            <span>2004-2008</span>
                                            <p>Graduation: Bachelor of Medical Sciences.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body border-top">
                                <h5 class="font-weight-bold clearfix">Work Experience <button class="btn btn-sm ml-auto float-right" data-toggle="modal" data-target="#work_experience_modal" data-effect="effect-super-scaled"><i class="fa fa-plus"></i></button></h5>
                                <div class="main-profile-contact-list d-lg-flex">
                                    <div class="media mr-5">
                                        <div class="media-icon bg-success text-white mr-4">
                                            <i class="fa fa-briefcase"></i>
                                        </div>
                                        <div class="media-body">
                                            <h6 class="font-weight-bold mb-1">MBBS Doctor at <a href="" class="btn-link">Dhaka Medical College Hospital</a></h6>
                                            <span>2016 - 2018</span>
                                            <p>Past Work: National Institute of Cardiovascular Diseases.</p>
                                        </div>
                                    </div>

                                    <div class="media mr-5">
                                        <div class="media-icon bg-success text-white mr-4">
                                            <i class="fa fa-briefcase"></i>
                                        </div>
                                        <div class="media-body">
                                            <h6 class="font-weight-bold mb-1">MBBS Doctor at <a href="" class="btn-link">BSMMU</a></h6>
                                            <span>2018 - present</span>
                                            <p>Past Work: National Institute of Cardiovascular Diseases.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body border-top">
                                <h5 class="font-weight-bold clearfix">Expertise <button class="btn btn-sm ml-auto float-right" data-toggle="modal" data-target="#expertise_modal" data-effect="effect-super-scaled"><i class="fa fa-plus"></i></button></h5>
                                <a class="btn btn-sm btn-light mt-1" href="#">Surgery</a>
                                <a class="btn btn-sm btn-light mt-1" href="#">Psychiatry</a>
                                <a class="btn btn-sm btn-light mt-1" href="#">Paediatrics</a>
                                <a class="btn btn-sm btn-light mt-1" href="#">Pathology</a>
                                <a class="btn btn-sm btn-light mt-1" href="#">Anaesthetics</a>
                                <a class="btn btn-sm btn-light mt-1" href="#">Emergency Medicine</a>
                                <a class="btn btn-sm btn-light mt-1" href="#">General Medicine</a>
                                <a class="btn btn-sm btn-light mt-1" href="#">Trauma and Orthopaedics</a>
                            </div>


                            <div class="card-body border-top">
                                <h5 class="font-weight-bold clearfix">Available Hours <button class="btn btn-sm ml-auto float-right" data-toggle="modal" data-target="#available_hours" data-effect="effect-super-scaled"><i class="fa fa-plus"></i></button></h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="table-responsive">
                                            <table class="table card-table table-vcenter text-nowrap border">
                                                <tbody>
                                                <tr>
                                                    <th class="bg-success text-white">Saturday</th>
                                                    <th class="text-center">5:00 PM</th>
                                                    <th class="text-center">9:00 PM</th>
                                                </tr>
                                                <tr>
                                                    <th class="bg-success text-white">Sunday</th>
                                                    <th class="text-center">5:00 PM</th>
                                                    <th class="text-center">9:00 PM</th>
                                                </tr>
                                                <tr>
                                                    <th class="bg-success text-white">Monday</th>
                                                    <th class="text-center">5:00 PM</th>
                                                    <th class="text-center">9:00 PM</th>
                                                </tr>
                                                <tr>
                                                    <th class="bg-success text-white">Tuesday</th>
                                                    <th class="text-center">5:00 PM</th>
                                                    <th class="text-center">9:00 PM</th>
                                                </tr>
                                                <tr>
                                                    <th class="bg-success text-white">Wednesday</th>
                                                    <th class="text-center">5:00 PM</th>
                                                    <th class="text-center">9:00 PM</th>
                                                </tr>
                                                <tr>
                                                    <th class="bg-success text-white">Thursday</th>
                                                    <th class="text-center">5:00 PM</th>
                                                    <th class="text-center">9:00 PM</th>
                                                </tr>
                                                <tr>
                                                    <th class="bg-success text-white">Friday</th>
                                                    <th class="text-center">5:00 PM</th>
                                                    <th class="text-center">9:00 PM</th>
                                                </tr>


                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body border-top">
                                <h5 class="font-weight-bold">Contact</h5>
                                <div class="main-profile-contact-list d-lg-flex">
                                    <div class="media mr-4">
                                        <div class="media-icon bg-primary text-white mr-3 mt-1">
                                            <i class="fa fa-phone"></i>
                                        </div>
                                        <div class="media-body">
                                            <small class="text-muted">Mobile</small>
                                            <div class="font-weight-normal1">
                                                +245 354 654
                                            </div>
                                        </div>
                                    </div>
                                    <div class="media mr-4">
                                        <div class="media-icon bg-warning text-white mr-3 mt-1">
                                            <i class="fe fe-mail"></i>
                                        </div>
                                        <div class="media-body">
                                            <small class="text-muted">Email</small>
                                            <div class="font-weight-normal1">
                                                example@mail.com
                                            </div>
                                        </div>
                                    </div>
                                    <div class="media">
                                        <div class="media-icon bg-info text-white mr-3 mt-1">
                                            <i class="fa fa-map"></i>
                                        </div>
                                        <div class="media-body">
                                            <small class="text-muted">Current Address</small>
                                            <div class="font-weight-normal1">
                                                House-17, Road-17/A, Block-E, Banani, Dhaka 1206, Dhaka Bangladesh.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- main-profile-contact-list -->
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane" id="tab-8">
                        <div class="card p-5">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="d-flex align-items-center border p-3 mb-3 br-7">
                                        <div class="avatar avatar-lg brround d-block cover-image" data-image-src="../../assets/images/users/7.jpg"></div>
                                        <div class="wrapper ml-3">
                                            <p class="mb-0 mt-1 text-dark font-weight-semibold">Denis Rosenblum</p>
                                            <small><strong>Age :</strong> 28, Male</small>
                                        </div>
                                        <div class="float-right ml-auto">
                                            <a href="#" class="btn btn-primary btn-sm"><i class="si si-eye mr-1"></i>View</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="d-flex align-items-center border p-3 mb-3 br-7">
                                        <div class="avatar avatar-lg brround d-block cover-image" data-image-src="../../assets/images/users/6.jpg"></div>
                                        <div class="wrapper ml-3">
                                            <p class="mb-0 mt-1 text-dark font-weight-semibold">Harvey Mattos</p>
                                            <small><strong>Age :</strong> 28, Male</small>
                                        </div>
                                        <div class="float-right ml-auto">
                                            <a href="#" class="btn btn-primary btn-sm"><i class="si si-eye mr-1"></i>View</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="d-flex align-items-center border p-3 mb-3 br-7">
                                        <div class="avatar avatar-lg brround d-block cover-image" data-image-src="../../assets/images/users/5.jpg"></div>
                                        <div class="wrapper ml-3">
                                            <p class="mb-0 mt-1 text-dark font-weight-semibold">Catrice Doshier</p>
                                            <small><strong>Age :</strong> 28, Male</small>
                                        </div>
                                        <div class="float-right ml-auto">
                                            <a href="#" class="btn btn-primary btn-sm"><i class="si si-eye mr-1"></i>View</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="d-flex align-items-center border p-3 mb-3 br-7">
                                        <div class="avatar avatar-lg brround d-block cover-image" data-image-src="../../assets/images/users/1.jpg"></div>
                                        <div class="wrapper ml-3">
                                            <p class="mb-0 mt-1 text-dark font-weight-semibold">Catherina Bamber</p>
                                            <small><strong>Age :</strong> 28, Male</small>
                                        </div>
                                        <div class="float-right ml-auto">
                                            <a href="#" class="btn btn-primary btn-sm"><i class="si si-eye mr-1"></i>View</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="d-flex align-items-center border p-3 mb-3 br-7">
                                        <div class="avatar avatar-lg brround d-block cover-image" data-image-src="../../assets/images/users/8.jpg"></div>
                                        <div class="wrapper ml-3">
                                            <p class="mb-0 mt-1 text-dark font-weight-semibold">Margie Fitts</p>
                                            <small><strong>Age :</strong> 28, Male</small>
                                        </div>
                                        <div class="float-right ml-auto">
                                            <a href="#" class="btn btn-primary btn-sm"><i class="si si-eye mr-1"></i>View</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="d-flex align-items-center border p-3 mb-3 br-7">
                                        <div class="avatar avatar-lg brround d-block cover-image" data-image-src="../../assets/images/users/5.jpg"></div>
                                        <div class="wrapper ml-3">
                                            <p class="mb-0 mt-1 text-dark font-weight-semibold">Dana Lott</p>
                                            <small><strong>Age :</strong> 28, Male</small>
                                        </div>
                                        <div class="float-right ml-auto">
                                            <a href="#" class="btn btn-primary btn-sm"><i class="si si-eye mr-1"></i>View</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="d-flex align-items-center border p-3 mb-3 br-7">
                                        <div class="avatar avatar-lg brround d-block cover-image" data-image-src="../../assets/images/users/6.jpg"></div>
                                        <div class="wrapper ml-3">
                                            <p class="mb-0 mt-1 text-dark font-weight-semibold">Benedict Vallone</p>
                                            <small><strong>Age :</strong> 28, Male</small>
                                        </div>
                                        <div class="float-right ml-auto">
                                            <a href="#" class="btn btn-primary btn-sm"><i class="si si-eye mr-1"></i>View</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="d-flex align-items-center border p-3 mb-3 br-7">
                                        <div class="avatar avatar-lg brround d-block cover-image" data-image-src="../../assets/images/users/8.jpg"></div>
                                        <div class="wrapper ml-3">
                                            <p class="mb-0 mt-1 text-dark font-weight-semibold">Robbie Ruder</p>
                                            <small><strong>Age :</strong> 28, Male</small>
                                        </div>
                                        <div class="float-right ml-auto">
                                            <a href="#" class="btn btn-primary btn-sm"><i class="si si-eye mr-1"></i>View</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="d-flex align-items-center border p-3 mb-3 br-7">
                                        <div class="avatar avatar-lg brround d-block cover-image" data-image-src="../../assets/images/users/3.jpg"></div>
                                        <div class="wrapper ml-3">
                                            <p class="mb-0 mt-1 text-dark font-weight-semibold">Micaela Aultman</p>
                                            <small><strong>Age :</strong> 28, Male</small>
                                        </div>
                                        <div class="float-right ml-auto">
                                            <a href="#" class="btn btn-primary btn-sm"><i class="si si-eye mr-1"></i>View</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="d-flex align-items-center border p-3 mb-3 br-7">
                                        <div class="avatar avatar-lg brround d-block cover-image" data-image-src="../../assets/images/users/4.jpg"></div>
                                        <div class="wrapper ml-3">
                                            <p class="mb-0 mt-1 text-dark font-weight-semibold">Jacquelynn Sapienza</p>
                                            <small><strong>Age :</strong> 28, Male</small>
                                        </div>
                                        <div class="float-right ml-auto">
                                            <a href="#" class="btn btn-primary btn-sm"><i class="si si-eye mr-1"></i>View</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="d-flex align-items-center border p-3 mb-3 br-7">
                                        <div class="avatar avatar-lg brround d-block cover-image" data-image-src="../../assets/images/users/9.jpg"></div>
                                        <div class="wrapper ml-3">
                                            <p class="mb-0 mt-1 text-dark font-weight-semibold">Elida Distefano</p>
                                            <small><strong>Age :</strong> 28, Male</small>
                                        </div>
                                        <div class="float-right ml-auto">
                                            <a href="#" class="btn btn-primary btn-sm"><i class="si si-eye mr-1"></i>View</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="d-flex align-items-center border p-3 mb-3 br-7">
                                        <div class="avatar avatar-lg brround d-block cover-image" data-image-src="../../assets/images/users/7.jpg"></div>
                                        <div class="wrapper ml-3">
                                            <p class="mb-0 mt-1 text-dark font-weight-semibold">Collin Bridgman</p>
                                            <small><strong>Age :</strong> 28, Male</small>
                                        </div>
                                        <div class="float-right ml-auto">
                                            <a href="#" class="btn btn-primary btn-sm"><i class="si si-eye mr-1"></i>View</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <a class="btn btn-block btn-light" href="#"><i class="fe fe-chevron-down"></i> See All</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane" id="tab-9">
                        <ul class="timelineleft pb-5">
                            <li class="timeleft-label"><span class="bg-danger">10 May. 2020</span></li>
                            <li>
                                <i class="fa fa-envelope bg-primary"></i>
                                <div class="timelineleft-item">
                                    <span class="time"><i class="fa fa-clock-o text-danger"></i> 12:05</span>
                                    <h3 class="timelineleft-header"><a href="#">Support Team</a> <span>sent you an email</span></h3>
                                    <div class="timelineleft-body">
                                        Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles, weebly ning heekya handango imeem plugg dopplr jibjab, movity jajah plickers sifteo edmodo ifttt zimbra. Babblely
                                        odeo kaboodle quora plaxo ideeli hulu weebly balihoo...
                                    </div>
                                    <div class="timelineleft-footer">
                                        <a class="btn btn-primary text-white btn-sm">Read more</a>
                                        <a class="btn btn-secondary text-white btn-sm">Delete</a>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <i class="fa fa-user bg-secondary"></i>
                                <div class="timelineleft-item">
                                    <span class="time"><i class="fa fa-clock-o text-danger"></i> 5 mins ago</span>
                                    <h3 class="timelineleft-header no-border"><a href="#">Sarah Young</a> accepted your friend request</h3>
                                </div>
                            </li>
                            <li>
                                <i class="fa fa-comments bg-warning"></i>
                                <div class="timelineleft-item">
                                    <span class="time"><i class="fa fa-clock-o text-danger"></i> 27 mins ago</span>
                                    <h3 class="timelineleft-header"><a href="#">Jay White</a> commented on your post</h3>
                                    <div class="timelineleft-body">
                                        Take me to your leader! Switzerland is small and neutral! We are more like Germany, ambitious and misunderstood!
                                    </div>
                                    <div class="timelineleft-footer">
                                        <a class="btn btn-info text-white btn-flat btn-sm">View comment</a>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <i class="fa fa-video-camera bg-pink"></i>
                                <div class="timelineleft-item">
                                    <span class="time"><i class="fa fa-clock-o text-danger"></i> 1 hour ago</span>
                                    <h3 class="timelineleft-header"><a href="#">Mr. John</a> shared a video</h3>
                                    <div class="timelineleft-body">
                                        <div class="embed-responsive embed-responsive-16by9 w-75">
                                            <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/tMWkeBIohBs" allowfullscreen></iframe>
                                        </div>
                                        <div class="timelineleft-body mt-3">
                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer dignissim neque condimentum lacus dapibus.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer
                                            dignissim neque condimentum lacus dapibus.Lorem ipsum dolor sit amet
                                        </div>
                                    </div>
                                    <div class="timelineleft-footer">
                                        <a href="#" class="btn btn-sm bg-warning text-white">See comments</a>
                                    </div>
                                </div>
                            </li>
                            <li class="timeleft-label">
                                <span class="bg-success"> 3 Jan. 2014</span>
                            </li>
                            <li>
                                <i class="fa fa-camera bg-orange"></i>
                                <div class="timelineleft-item">
                                    <span class="time"><i class="fa fa-clock-o text-danger"></i> 2 days ago</span>
                                    <h3 class="timelineleft-header"><a href="#">Mina Lee</a> uploaded new photos</h3>
                                    <div class="timelineleft-body">
                                        <img src="../../assets/images/photos/1.jpg" alt="..." class="margin mt-2 mb-2" />
                                        <img src="../../assets/images/photos/2.jpg" alt="..." class="margin mt-2 mb-2" />
                                        <img src="../../assets/images/photos/3.jpg" alt="..." class="margin mt-2 mb-2" />
                                        <img src="../../assets/images/photos/4.jpg" alt="..." class="margin mt-2 mb-2" />
                                    </div>
                                </div>
                            </li>
                            <li>
                                <i class="fa fa-video-camera bg-pink"></i>
                                <div class="timelineleft-item">
                                    <span class="time"><i class="fa fa-clock-o text-danger"></i> 5 days ago</span>
                                    <h3 class="timelineleft-header"><a href="#">Mr. Doe</a> shared a video</h3>
                                    <div class="timelineleft-body">
                                        <div class="embed-responsive embed-responsive-16by9 w-75">
                                            <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/tMWkeBIohBs" allowfullscreen></iframe>
                                        </div>
                                    </div>
                                    <div class="timelineleft-footer">
                                        <a href="#" class="btn btn-sm bg-warning text-white">See comments</a>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <i class="fa fa-clock-o bg-success pb-3"></i>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Biography Modal -->
    <div class="modal fade" id="biography_modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title">Biography</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group mb-0">
                                <textarea rows="5" class="form-control" placeholder="Enter About your description"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-sm btn-indigo" type="button">Save changes</button>
                    <button class="btn btn-sm btn-secondary" type="button">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Work Experience Modal -->
    <div class="modal fade" id="work_experience_modal" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title">Work Experience</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-6 col-md-6">
                            <div class="form-group">
                                <label class="form-label">Specialist</label>
                                <input type="text" class="form-control" placeholder="Specialist" />
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <div class="form-group">
                                <label class="form-label">Employment type</label>
                                <select class="form-control select2">
                                    <option value="Please select">Please select</option>
                                    <option value="Full-time">Full-time</option>
                                    <option value="Part-time">Part-time</option>
                                    <option value="Self-employed">Self-employed</option>
                                    <option value="Internship">Internship</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <div class="form-group">
                                <label class="form-label">Company name*</label>
                                <input type="text" class="form-control" placeholder="Company name " />
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <div class="form-group">
                                <label class="form-label">Location</label>
                                <input type="text" class="form-control" placeholder="Location" />
                            </div>
                        </div>

                        <div class="col-sm-6 col-md-6">
                            <div class="form-group">
                                <label class="form-label">Start date</label>
                                <div class="input-group">
                                    <input type="date" class="form-control" placeholder="Date" />
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 col-md-6">
                            <div class="form-group">
                                <label class="form-label">End Date</label>
                                <input type="date" class="form-control" placeholder="Location" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-sm btn-primary" type="button">Add</button>
                    <button class="btn btn-sm btn-secondary" type="button">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Education Modal -->
    <div class="modal fade" id="education_modal" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title">Education</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-6 col-md-6">
                            <div class="form-group">
                                <label class="form-label">School</label>
                                <input type="text" class="form-control" placeholder="Ex: Boston University" />
                            </div>
                        </div>

                        <div class="col-sm-6 col-md-6">
                            <div class="form-group">
                                <label class="form-label">Degree</label>
                                <input type="text" class="form-control" placeholder="Ex: Bachelor’s" />
                            </div>
                        </div>

                        <div class="col-sm-6 col-md-6">
                            <div class="form-group">
                                <label class="form-label">Grade</label>
                                <input type="text" class="form-control" placeholder="Ex: 4.00" />
                            </div>
                        </div>

                        <div class="col-sm-6 col-md-6">
                            <div class="form-group">
                                <label class="form-label">Location</label>
                                <input type="text" class="form-control" placeholder="Location" />
                            </div>
                        </div>

                        <div class="col-sm-6 col-md-6">
                            <div class="form-group">
                                <label class="form-label">Start date</label>
                                <div class="input-group">
                                    <input type="date" class="form-control" placeholder="Date" />
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 col-md-6">
                            <div class="form-group">
                                <label class="form-label">End Date</label>
                                <input type="date" class="form-control" placeholder="Location" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-sm btn-primary" type="button">Add</button>
                    <button class="btn btn-sm btn-secondary" type="button">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Expertise Modal -->
    <div class="modal fade" id="expertise_modal" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title">Expertise</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12 col-md-12">
                            <div class="form-group">
                                <label class="form-label">Expertise</label>
                                <input type="text" class="form-control" placeholder="Ex: Surgery" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-sm btn-primary" type="button">Add</button>
                    <button class="btn btn-sm btn-secondary" type="button">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Available Hours Modal -->
    <div class="modal fade" id="available_hours" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title">Available Hours</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xl-12">

                            <div class="form-group">
                                <label class="custom-switch">
                                    <input type="checkbox" name="custom-switch-checkbox1" class="custom-switch-input">
                                    <span class="custom-switch-indicator custom-switch-indicator-lg"></span>
                                    <span class="custom-switch-description mr-2">In Vacation <small class="text-muted d-block">Input your own hours</small></span>
                                </label>
                            </div>

                            <div class="form-group">
                                <label class="custom-switch">
                                    <input type="checkbox" name="custom-switch-checkbox1" class="custom-switch-input" checked="">
                                    <span class="custom-switch-indicator custom-switch-indicator-lg"></span>
                                    <span class="custom-switch-description mr-2">Open on selected Hours <small class="text-muted d-block">whwn you going for vacation</small></span>
                                </label>
                            </div>


                        </div>
                    </div>



                    <div class="table-responsive">
                        <table class="table card-table table-vcenter text-nowrap border">
                            <tbody>
                            <tr>
                                <th class="bg-success text-white" rowspan="2">Saturday</th>
                                <th class="text-center">
                                    <div class="form-group mb-0">
                                        <input type="time" class="form-control" placeholder="" />
                                    </div>
                                </th>
                                <th class="text-center">
                                    <div class="form-group mb-0">
                                        <input type="time" class="form-control" placeholder="Ex: Surgery" />
                                    </div>
                                </th>
                                <th class="text-center"><button class="btn btn-sm btn-block btn-outline-primary d-none"> <i class="fa fa-plus"></i></button></th>
                                <th class="text-center"><button class="btn btn-sm btn-block btn-outline-danger"> <i class="fa fa-times"></i></button></th>
                            </tr>

                            <tr>
                                <th class="text-center">
                                    <div class="form-group mb-0">
                                        <input type="time" class="form-control" placeholder="" />
                                    </div>
                                </th>
                                <th class="text-center">
                                    <div class="form-group mb-0">
                                        <input type="time" class="form-control" placeholder="Ex: Surgery" />
                                    </div>
                                </th>
                                <th class="text-center"><button class="btn btn-sm btn-block btn-outline-primary"> <i class="fa fa-plus"></i></button></th>
                                <th class="text-center"><button class="btn btn-sm btn-block btn-outline-danger"> <i class="fa fa-times"></i></button></th>
                            </tr>


                            <tr>
                                <th class="bg-success text-white">Sunday</th>
                                <th class="text-center">
                                    <div class="form-group mb-0">
                                        <input type="time" class="form-control" placeholder="Ex: Surgery" />
                                    </div>
                                </th>
                                <th class="text-center">
                                    <div class="form-group mb-0">
                                        <input type="time" class="form-control" placeholder="Ex: Surgery" />
                                    </div>
                                </th>
                                <th class="text-center"><button class="btn btn-sm btn-block btn-outline-primary"> <i class="fa fa-plus"></i></button></th>
                                <th class="text-center"><button class="btn btn-sm btn-block btn-outline-danger"> <i class="fa fa-times"></i></button></th>
                            </tr>
                            <tr>
                                <th class="bg-success text-white">Monday</th>
                                <th class="text-center">
                                    <div class="form-group mb-0">
                                        <input type="time" class="form-control" placeholder="Ex: Surgery" />
                                    </div>
                                </th>
                                <th class="text-center">
                                    <div class="form-group mb-0">
                                        <input type="time" class="form-control" placeholder="Ex: Surgery" />
                                    </div>
                                </th>
                                <th class="text-center"><button class="btn btn-sm btn-block btn-outline-primary"> <i class="fa fa-plus"></i></button></th>
                                <th class="text-center"><button class="btn btn-sm btn-block btn-outline-danger"> <i class="fa fa-times"></i></button></th>
                            </tr>
                            <tr>
                                <th class="bg-success text-white">Tuesday</th>
                                <th class="text-center">
                                    <div class="form-group mb-0">
                                        <input type="time" class="form-control" placeholder="Ex: Surgery" />
                                    </div>
                                </th>
                                <th class="text-center">
                                    <div class="form-group mb-0">
                                        <input type="time" class="form-control" placeholder="Ex: Surgery" />
                                    </div>
                                </th>
                                <th class="text-center"><button class="btn btn-sm btn-block btn-outline-primary"> <i class="fa fa-plus"></i></button></th>
                                <th class="text-center"><button class="btn btn-sm btn-block btn-outline-danger"> <i class="fa fa-times"></i></button></th>
                            </tr>
                            <tr>
                                <th class="bg-success text-white">Wednesday</th>
                                <th class="text-center">
                                    <div class="form-group mb-0">
                                        <input type="time" class="form-control" placeholder="Ex: Surgery" />
                                    </div>
                                </th>
                                <th class="text-center">
                                    <div class="form-group mb-0">
                                        <input type="time" class="form-control" placeholder="Ex: Surgery" />
                                    </div>
                                </th>
                                <th class="text-center"><button class="btn btn-sm btn-block btn-outline-primary"> <i class="fa fa-plus"></i></button></th>
                                <th class="text-center"><button class="btn btn-sm btn-block btn-outline-danger"> <i class="fa fa-times"></i></button></th>
                            </tr>
                            <tr>
                                <th class="bg-success text-white">Thursday</th>
                                <th class="text-center">
                                    <div class="form-group mb-0">
                                        <input type="time" class="form-control" placeholder="Ex: Surgery" />
                                    </div>
                                </th>
                                <th class="text-center">
                                    <div class="form-group mb-0">
                                        <input type="time" class="form-control" placeholder="Ex: Surgery" />
                                    </div>
                                </th>
                                <th class="text-center"><button class="btn btn-sm btn-block btn-outline-primary"> <i class="fa fa-plus"></i></button></th>
                                <th class="text-center"><button class="btn btn-sm btn-block btn-outline-danger"> <i class="fa fa-times"></i></button></th>
                            </tr>
                            <tr>
                                <th class="bg-success text-white">Friday</th>
                                <th class="text-center">
                                    <div class="form-group mb-0">
                                        <input type="time" class="form-control" placeholder="Ex: Surgery" />
                                    </div>
                                </th>
                                <th class="text-center">
                                    <div class="form-group mb-0">
                                        <input type="time" class="form-control" placeholder="Ex: Surgery" />
                                    </div>
                                </th>
                                <th class="text-center"><button class="btn btn-sm btn-block btn-outline-primary"> <i class="fa fa-plus"></i></button></th>
                                <th class="text-center"><button class="btn btn-sm btn-block btn-outline-danger"> <i class="fa fa-times"></i></button></th>
                            </tr>



                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-sm btn-primary" type="button">Save Changes</button>
                    <button class="btn btn-sm btn-secondary" type="button">Close</button>
                </div>
            </div>
        </div>
    </div>

@endsection


@push('patient_customjs')



@endpush
