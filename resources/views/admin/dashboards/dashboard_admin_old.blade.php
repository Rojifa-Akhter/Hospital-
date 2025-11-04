<style>
    .card-counter{
    box-shadow: 2px 2px 10px #DADADA;
    margin: 5px;
    padding: 20px 10px;
    background-color: #fff;
    height: 100px;
    border-radius: 10px;
    transition: .3s linear all;
  }

  .card-counter:hover{
    box-shadow: 4px 4px 20px #DADADA;
    transition: .3s linear all;
  }

  .card-counter.primary{
    background-color: #007bff;
    color: #FFF;
  }

  .card-counter.danger{
    background-color: #ef5350;
    color: #FFF;
  }  

  .card-counter.success{
    background-color: #66bb6a;
    color: #FFF;
  }  

  .card-counter.info{
    background-color: #26c6da;
    color: #FFF;
  }

  .card-counter.primary1{
    background-color: #7426da;
    color: #FFF;
  }

  .card-counter.danger1{
    background-color: #da268f;
    color: #FFF;
  }

  .card-counter.success1{
    background-color: #13ebb5;
    color: #FFF;
  }   

  .card-counter.info1{
    background-color: #a82096;
    color: #FFF;
  }

  .card-counter.primary2{
    background-color: #3279449a;
    color: #FFF;
  }

  .card-counter.danger2{
    background: linear-gradient(to bottom, #ccff99 0%, #003399 100%);
    color: #FFF;
  }

  .card-counter.success2{
    background: linear-gradient(to bottom, #ff33cc 0%, #99ff33 100%);
    color: #FFF;
  }   

  .card-counter.info2{
    background: linear-gradient(to bottom, #9933ff 0%, #ff66cc 100%);
    color: #FFF;
  }  
  .card-counter.primary3{
    background: linear-gradient(to bottom, #33ccff 0%, #ff99cc 100%);
    color: #FFF;
  }  
  .card_name{
        display: block;
        margin-left: auto;
        margin-right: auto;
        font-size: 20px;
        position: absolute;
        top: 30%;
        left: 50%;
        margin-right: -50%;
        transform: translate(-50%, -50%);
  }
  .counter-num {
    display: block;
    margin-left: auto;
    margin-right: auto;
    font-size: 32px;
    font-weight: bold;
    position: absolute;
    top: 70%;
    left: 50%;
    margin-right: -50%;
    transform: translate(-50%, -50%);
    }
</style>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <h2 class="float-left mt-2">Central Dashboard</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <div class="card-counter primary">
              {{-- <i class="fa fa-code-fork"></i> --}}
              <span class="card_name">Total Physiotherapist</span>
              <span class="counter-num">12</span>
            </div>
          </div>
      
          <div class="col-md-3">
            <div class="card-counter danger">
              {{-- <i class="fa fa-ticket"></i> --}}
              <span class="card_name">Total Patient</span>
              <span class="counter-num">599</span>
            </div>
          </div>
      
          <div class="col-md-3">
            <div class="card-counter success text-center">
              {{-- <i class="fa fa-database"></i> --}}
              <span class="card_name">Total Appointment</span>
              <span class="counter-num">6875</span>
            </div>
          </div>
      
          <div class="col-md-3">
            <div class="card-counter info">
              {{-- <i class="fa fa-users"></i> --}}
              <span class="card_name">Total Consulation</span>
              <span class="counter-num">35</span>
            </div>
          </div>

          <div class="col-md-3">
            <div class="card-counter primary1">
              {{-- <i class="fa fa-ticket"></i> --}}
              <span class="card_name">Total Finance</span>
              <span class="counter-num">599</span>
            </div>
          </div>

          <div class="col-md-3">
            <div class="card-counter danger1">
              {{-- <i class="fa fa-database"></i> --}}
              <span class="card_name">Today Patient</span>
              <span class="counter-num">6875</span>
            </div>
          </div>

          <div class="col-md-3">
            <div class="card-counter success1">
              {{-- <i class="fa fa-users"></i> --}}
              <span class="card_name">Today Appointment</span>
              <span class="counter-num">35</span>
            </div>
          </div>

          <div class="col-md-3">
            <div class="card-counter info1">
              {{-- <i class="fa fa-users"></i> --}}
              <span class="card_name">Today Consulation</span>
              <span class="counter-num">35</span>
            </div>
          </div>

          <div class="col-md-3">
            <div class="card-counter primary2">
              {{-- <i class="fa fa-users"></i> --}}
              <span class="card_name">Today Collection</span>
              <span class="counter-num">35000</span>
            </div>
          </div>

          <div class="col-md-3">
            <div class="card-counter danger2">
              {{-- <i class="fa fa-users"></i> --}}
              <span class="card_name">Today Due</span>
              <span class="counter-num">2500</span>
            </div>
          </div>

          <div class="col-md-3">
            <div class="card-counter success2">
              {{-- <i class="fa fa-users"></i> --}}
              <span class="card_name">Today Referal Doctor</span>
              <span class="counter-num">25</span>
            </div>
          </div>

          <div class="col-md-3">
            <div class="card-counter info2">
              {{-- <i class="fa fa-users"></i> --}}
              <span class="card_name">Today Sales Agent</span>
              <span class="counter-num">35</span>
            </div>
          </div>

          <div class="col-md-3">
            <div class="card-counter primary3">
              {{-- <i class="fa fa-users"></i> --}}
              <span class="card_name">Total Center</span>
              <span class="counter-num">20</span>
            </div>
          </div>
        </div>
        {{-- <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3">
            <div class="card text-center card_body_dashboard">
                <div class="card-body">
                    <h3 class="card-title">Card title-1</h3>
                    <p class="card-text">This card has supporting text below as a natural lead-in to additional content.</p>
                    <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                </div>
            </div>
        </div>


        <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3">
            <div class="card text-center card_body_dashboard">
                <div class="card-body">
                    <h3 class="card-title">Card title-2</h3>
                    <p class="card-text">This card has supporting text below as a natural lead-in to additional content.</p>
                    <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                </div>
            </div>
        </div>


        <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3">
            <div class="card text-center card_body_dashboard">
                <div class="card-body">
                    <h3 class="card-title">Card title-3</h3>
                    <p class="card-text">This card has supporting text below as a natural lead-in to additional content.</p>
                    <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                </div>
            </div>
        </div>


        <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3">
            <div class="card text-center card_body_dashboard">
                <div class="card-body">
                    <h3 class="card-title">Card title-4</h3>
                    <p class="card-text">This card has supporting text below as a natural lead-in to additional content.</p>
                    <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                </div>
            </div>
        </div> --}}
        <div class="row">
        <div class="col-md-3">
            <a href="#" class="btn btn-block btn-success mt-5 open-modal" data-modal="common-modal-alert" data-action="{{ route('success-alert') }}" data-title="Success Alert"> Success Alert</a>
        </div>

        <div class="col-md-3">
            <a href="#" class="btn btn-block btn-danger mt-5 open-modal" data-modal="common-modal-alert" data-action="{{ route('error-alert') }}" data-title="Error Alert"> Error Alert</a>
        </div>

        <div class="col-md-3">
            <a href="#" class="btn btn-block btn-warning text-white mt-5 open-modal" data-modal="common-modal-alert" data-action="{{ route('warning-alert') }}" data-title="Warning Alert"> Warning Alert</a>
        </div>

        <div class="col-md-3">
            <a href="#" class="btn btn-block btn-info text-white mt-5 open-modal" data-modal="common-modal-alert" data-action="{{ route('confirmation-alert') }}" data-title="Confirmation Alert"> Are You Sure?</a>
        </div>



        <div class="col-md-3">
            <button type="button" class="btn btn-secondary btn-block mt-3 open-modal mt-5" data-modal="common-modal" data-action="{{ route('appointment-card') }}" data-title="Create Appointment Card">Create Appointment Card </button>
        </div>

        <div class="col-md-3">
            <button type="button" class="btn btn-secondary btn-block mt-3 open-modal mt-5" data-modal="common-modal-md" data-action="{{ route('appointment-card-print') }}" data-title="Print Appointment Card">Print Appointment Card </button>
        </div>

        <div class="col-md-2">
            <button type="button" class="btn btn-sm btn-block btn-print mt-5"> <i class="fa fa-print mr-1"></i> Print Button</button>
        </div>

        <div class="col-md-2">
            <button type="button" class="btn btn-sm  btn-save mt-5"> <i class="fa fa-save mr-1"></i> Save Button</button>
        </div>

        <div class="col-md-2">
            <button type="button" class="btn btn-sm  btn-view mt-5"> <i class="fa fa-eye mr-1"></i> View Button</button>
            <button type="button" class="btn btn-sm  btn-edit mt-5"> <i class="fa fa-edit mr-1"></i> Edit Button</button>
            <button type="button" class="btn btn-sm  btn-delete mt-5"> <i class="fa fa-trash mr-1"></i> Delete Button</button>
        </div>

    </div>


    <div class="row">
        <div class="col-sm-12 col-lg-5 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="row m-0 doctor_list">
                        <div class="col-12 border-bottom p-0 mt-2">
                            <table class="table table-borderless">
                                <thead>
                                    <tr style="display: none;">
                                        <th scope="col"></th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody id="doctor_list" style="overflow-y: auto; max-height: 450px;">
                                    <tr class="border-bottom doctor_select cursor-pointer">
                                        <td>
                                            <img src="{{asset ('images/doctor.png')}}" alt="doctor image" class="rounded float-left mrv-2" width="35" >
                                        </td>
                                        <td><strong>DOC-118 :</strong> Ismail Hasan<br/> <i>Cardiology,</i> 01212026358</td>
                                        <td class="text-center bg-light-gray"><i class="fa fa-chevron-right"></i></td>
                                    </tr>

                                    <tr class="border-bottom doctor_select cursor-pointer">
                                        <td>
                                            <img src="{{asset ('images/doctor.png')}}" alt="doctor image" class="rounded float-left mrv-2" width="35" >
                                        </td>
                                        <td><strong>DOC-118 :</strong> Ismail Hasan<br/> <i>Cardiology,</i> 01212026358<strong>DOC-118 :</strong> Ismail Hasan<br/> <i>Cardiology,</i> 01212026358</td>
                                        <td class="text-center bg-light-gray"><i class="fa fa-chevron-right"></i></td>
                                    </tr>

                                    <tr class="border-bottom doctor_select cursor-pointer">
                                        <td>
                                            <img src="{{asset ('images/doctor.png')}}" alt="doctor image" class="rounded float-left mrv-2" width="35" >
                                        </td>
                                        <td><strong>DOC-118 :</strong> Ismail Hasan<br/> <i>Cardiology,</i> 01212026358<strong>DOC-118 :</strong> Ismail Hasan<br/> <i>Cardiology,</i> 01212026358</td>
                                        <td class="text-center bg-light-gray"><i class="fa fa-chevron-right"></i></td>
                                    </tr>

                                    <tr class="border-bottom doctor_select cursor-pointer">
                                        <td>
                                            <img src="{{asset ('images/doctor.png')}}" alt="doctor image" class="rounded float-left mrv-2" width="35" >
                                        </td>
                                        <td><strong>DOC-118 :</strong> Ismail Hasan<br/> <i>Cardiology,</i> 01212026358</td>
                                        <td class="text-center bg-light-gray"><i class="fa fa-chevron-right"></i></td>
                                    </tr>



                                    <tr>
                                        <td class="text-center" colspan="3">No Doctor found</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
