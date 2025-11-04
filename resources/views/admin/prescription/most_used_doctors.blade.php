<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header" style="padding-bottom: 0px !important;">
                <ul class="nav nav-pills" id="pills-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="pills-mum-tab" data-toggle="pill" href="#pills-mum" role="tab"
                            aria-controls="pills-mum" aria-selected="true" data-tab_type="0"
                            onclick="changeTab(this)">Most Used</a>
                    </li>
                    {{-- <li class="nav-item">
                        <a class="nav-link" id="pills-group-tab" data-toggle="pill" href="#pills-group" role="tab"
                            aria-controls="pills-group" aria-selected="false" data-tab_type="1"
                            onclick="changeTab(this)">Group</a>
                    </li> --}}
                </ul>
            </div>

            <div class="card">
                <div class="card-body">

                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-mum" role="tabpanel"
                            aria-labelledby="pills-mum-tab">
                            <div class="" id="most_used_medicine">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h5>Most Used Doctors </h5>
                                            </div>
                                        </div>

                                    </div>

                                    {{-- {{ dd($item_list) }} --}}
                                    <div class="card-body" style="max-height: 350px;overflow:scroll;">
                                        <div class="row" id="itemDataAll">
                                            @include('admin.prescription.most_used_doctor_list')
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="tab-pane fade" id="pills-group" role="tabpanel" aria-labelledby="pills-group-tab">
                            <div class="" id="Group">
                                GROUP MUM
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
