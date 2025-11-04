@php


@endphp

<style>
    .heading{
        font-weight: bold;
        padding: 8px;
        background: #f7f7f7;
        margin-top: 10px;
    }

</style>


<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">


<div class="card">
    <div class="card-body p-2">
        <div class="form-row">
            <div class="col-md-2">
                <div class="form-group">
                    <label for="weight_" class="col-form-label">{{$physical_examination[0]->pres_lookupdata_name}}</label>
                    <input type="text" class="form-control form-control-sm" id="weight_" name="weight" value="{{$pe_weight}}" readonly="true"/>
                </div>
            </div>

            <div class="col-md-2">
                <div class="form-group">
                    <label for="height_" class="col-form-label">{{$physical_examination[1]->pres_lookupdata_name}}</label>
                    <input type="text" class="form-control form-control-sm" id="height_" name="height" value="{{$per_height}}" readonly="true" />
                </div>
            </div>

            <div class="col-md-2">
                <div class="form-group">
                    <label for="race_" class="col-form-label">{{$physical_examination[2]->pres_lookupdata_name}}</label>
                    <input type="text" class="form-control form-control-sm" id="race_" name="race" value="{{$race}}"/>
                </div>
            </div>

            <div class="col-md-2">
                <div class="form-group">
                    <label for="temp_" class="col-form-label">{{$physical_examination[3]->pres_lookupdata_name}}</label>
                    <input type="text" class="form-control form-control-sm" id="temp_" name="temp" value="{{$temp}}" readonly="true"/>
                </div>
            </div>

            <div class="col-md-2">
                <div class="form-group">
                    <label for="pulse_" class="col-form-label">{{$physical_examination[4]->pres_lookupdata_name}}</label>
                    <input type="text" class="form-control form-control-sm" id="pulse_" name="pulse" value="{{$pulse}}" readonly="true"/>
                </div>
            </div>

            <div class="col-md-2">
                <div class="form-group">
                    <label for="resp_" class="col-form-label">{{$physical_examination[5]->pres_lookupdata_name}}</label>
                    <input type="text" class="form-control form-control-sm" id="resp_" name="resp" value="{{$resp}}"/>
                </div>
            </div>

            <div class="col-md-2">
                <div class="form-group">
                    <label for="phallus_" class="col-form-label">{{$physical_examination[6]->pres_lookupdata_name}}</label>
                    <input type="text" class="form-control form-control-sm" id="phallus_" name="phallus" value="{{$phallus}}"/>
                </div>
            </div>

            <div class="col-md-2">
                <div class="form-group">
                    <label for="meatus_" class="col-form-label">{{$physical_examination[7]->pres_lookupdata_name}}</label>
                    <input type="text" class="form-control form-control-sm" id="meatus_" name="meatus" value="{{$meatus}}"/>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label for="sec_sex" class="col-form-label">{{$physical_examination[10]->pres_lookupdata_name}}</label>
                    <input type="text" class="form-control form-control-sm" id="sec_sex" name="sec_sex" value="{{$sex_characteristics}}"/>
                </div>
            </div>


            <div class="col-md-4">
                <div class="form-check ml-1">
                    <input class="form-check-input" type="checkbox" value="1" id="defaultdupu_contra" name="dupu_contra" {{$dupuytren_contrature== '1' ? 'checked' : ''}}/>
                    <label class="col-form-label p-0" for="defaultdupu_contra">{{$physical_examination[11]->pres_lookupdata_name}}</label>
                </div>
                <div class="form-check ml-1">
                    <input class="form-check-input" type="checkbox" value="1" id="defaultCircumcised" name="circumcised" {{$circumcised== '1' ? 'checked' : ''}}/>
                    <label class="col-form-label p-0" for="defaultCircumcised">{{$physical_examination[8]->pres_lookupdata_name}}</label>
                </div>

                <div class="form-check ml-1">
                    <input class="form-check-input" type="checkbox" value="1" id="defaultPlaque" name="plaque" {{$plaque== '1' ? 'checked' : ''}}/>
                    <label class="col-form-label p-0" for="defaultPlaque">{{$physical_examination[9]->pres_lookupdata_name}}</label>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">TESTES EXAM :</h5>
    </div>

    <div class="card-body p-2">
        <div class="form-row">
            <div class="col-md-6">
                <h5 class="heading mb-0 text-center">RIGHT</h5>
                <div class="form-row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="location_siao_right" class="col-form-label">{{$physical_examination[12]->pres_lookupdata_name}}</label>
                            <input type="text" class="form-control form-control-sm" id="location_siao_right" name="siao_right" value="{{$right_location}}"/>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="size_right" class="col-form-label">{{$physical_examination[13]->pres_lookupdata_name}}</label>
                            <input type="text" class="form-control form-control-sm" id="size_right" name="size_right" value="{{$right_size}}"/>
                        </div>
                    </div>



                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="varico_right" class="col-form-label">{{$physical_examination[15]->pres_lookupdata_name}}</label>
                            <input type="text" class="form-control form-control-sm" id="varico_right" name="varico_right" value="{{$right_varicocele}}"/>
                        </div>
                    </div>


                    <div class="col-md-3">
                        <div class="form-check ml-1 mt-4">
                            <input class="form-check-input" type="checkbox" value="1" id="defaulthydro_right" name="hydro_right" {{$right_hydrocele== '1' ? 'checked' : ''}}/>
                            <label class="col-form-label p-0" for="defaulthydro_right">{{$physical_examination[14]->pres_lookupdata_name}}</label>
                        </div>
                    </div>


                    <div class="col-md-3">
                        <div class="form-check ml-1 mt-4">
                            <input class="form-check-input" type="checkbox" value="1" id="defaultherni_right" name="herni_right" {{$right_hernia== '1' ? 'checked' : ''}}/>
                            <label class="col-form-label p-0" for="defaultherni_right">{{$physical_examination[16]->pres_lookupdata_name}}</label>
                        </div>
                    </div>


                </div>
            </div>

            <div class="col-md-6">
                <h5 class="heading mb-0 text-center">LEFT</h5>
                <div class="form-row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="location_siao_left" class="col-form-label">{{$physical_examination[12]->pres_lookupdata_name}}</label>
                            <input type="text" class="form-control form-control-sm" id="location_siao_left" name="siao_left" value="{{$left_location}}"/>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="size_left" class="col-form-label">{{$physical_examination[13]->pres_lookupdata_name}}</label>
                            <input type="text" class="form-control form-control-sm" id="size_left" name="size_left" value="{{$left_size}}"/>
                        </div>
                    </div>


                   <div class="col-md-6">
                        <div class="form-group">
                            <label for="varico_left" class="col-form-label">{{$physical_examination[15]->pres_lookupdata_name}}</label>
                            <input type="text" class="form-control form-control-sm" id="varico_left" name="varico_left" value="{{$left_varicocele}}"/>
                        </div>
                    </div>


                    <div class="col-md-3">
                        <div class="form-check ml-1 mt-4">
                            <input class="form-check-input" type="checkbox" value="1" id="defaulthydro_left" name="hydro_left" {{$left_hydrocele== '1' ? 'checked' : ''}}/>
                            <label class="col-form-label p-0" for="defaulthydro_left">{{$physical_examination[14]->pres_lookupdata_name}}</label>
                        </div>
                    </div>


                    <div class="col-md-3">
                        <div class="form-check ml-1 mt-4">
                            <input class="form-check-input" type="checkbox" value="1" id="defaultherni_left" name="herni_left" {{$left_hernia== '1' ? 'checked' : ''}}/>
                            <label class="col-form-label p-0" for="defaultherni_left">{{$physical_examination[16]->pres_lookupdata_name}}</label>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="card-body p-2">
        <div class="form-row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="prostate_" class="col-form-label">{{$physical_examination[22]->pres_lookupdata_name}}</label>
                    <input type="text" class="form-control form-control-sm" id="prostate_" name="prostate" value="{{$prostate}}"/>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label for="pulse_s" class="col-form-label">{{$physical_examination[23]->pres_lookupdata_name}}</label>
                    <input type="text" class="form-control form-control-sm" id="pulse_s" name="pulse_bottom" value="{{$pulses_id}}"/>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-check ml-1 mt-4">
                    <input class="form-check-input" type="checkbox" value="1" id="carotid_bruit_" name="carotid_bruit" {{$carotid_bruit=='1' ? 'checked': ''}}/>
                    <label class="col-form-label p-0" for="carotid_bruit_">{{$physical_examination[24]->pres_lookupdata_name}}</label>
                </div>
            </div>
        </div>
    </div>
</div>





