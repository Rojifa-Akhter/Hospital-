<div id="accordion" class="prescribed_patient_list">
    @if(!empty($appointment_data))
        @foreach($appointment_data as $data)
        <div class="card">
        <div class="card-header p-0" id="headingOne">
            <button class="btn btn-block p-0" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                <div class="chat-widget-header d-flex p-5 align-items-center">
                    <div class="font-weight-bold pr-4 mr-4 border-right d-none d-sm-none d-md-none d-lg-block">
                        <div class="mt-1">
                            <h6 class="font-weight-semibold mb-0">{{$loop->iteration}}</h6>
                        </div>
                    </div>

                    <div class="font-weight-bold pr-4 mr-4 border-right d-none d-sm-none d-md-none d-lg-block">
                        <div class="mt-1">
                            <h6 class="font-weight-semibold mb-0">Patient ID</h6>
                            <small>{{!empty($data->patient_code)?$data->patient_code:'N/A'}}</small>
                        </div>
                    </div>

                    <div class="font-weight-bold d-flex pr-4 mr-4 border-right align-items-center">
                        <img class="avatat avatar-md brround mr-2" src="{{ asset('images/boy.jpg') }}" alt="img">
                        <div class="mt-1 d-none d-sm-block">
                            <h6 class="font-weight-semibold mb-0">{{!empty($data->patient_name)?$data->patient_name:'N/A'}}</h6>
                            <small><strong>Age :</strong> {{!empty($data->age)?$data->age:'N/A'}}, {{!empty($data->doc_gender_txt)?$data->doc_gender_txt:'N/A'}}</small>
                        </div>
                    </div>

                    <div class="ml-auto">
                        <span class="accordion_arrow">
                            <i class="angle fa fa-angle-right"></i>
                        </span>
                    </div>
                </div>
            </button>
        </div>

        <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
            <div class="card-body">
                Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon
                tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice
                lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
            </div>
        </div>
    </div>
        @endforeach
    @endif
</div>
