
<style>

    .custom-form{
        width:100%;
        border:none;
        outline: none;
    }
    .border-left-0{
        border-left:none !important;
    }
    .border-right-0{
        border-right:none !important;
    }
    .medicine_thead{
        background-color: #e1e1e5;
    }
    .w-15{
        width:15%;
    }
    .w-25{
        width:25%;
    }
    .w-8{
        width:8%;
    }
    .w-6{
        width:6%;
    }
    .w-16{
        width:16%;
    }
    .remove_row{
        cursor: pointer;
        background-color: white;
    }
    .fa-star{
        display:none;
    }
    thead {
        position: sticky;
        top: 0px;
        left:0px;
        right:0px;
        background-color: white;
    }
    .fs-12{
        font-size: 14px;
    }
    .pdf-icon{
        font-size: 22px;
        color: red
    }
</style>

<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">

<main id="page-content">
    <section class="fixed_asset">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="row justify-content-between align-items-center bg-white border-bottom sticky-top shadow-sm">
                        <div class="col-md-10">
                            <h5 class="mt-2 mb-0">Invasive Lines/Tubes/Drains</h5>
                            <small>IPD / Nurse Station / Invasive Lines/Tubes/Drains</small>
                        </div>
                        <div class="col-md-2">
                            <a class="btn btn-md btn-warning" target="_blank" href="{{route('v2.ipd.download-invasive-lines',[$patient_info->patient_no_pk, $patient_info->admission_no_pk])}}">PDF Export</a>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body pt-2">
                            <div class="row">
                                <div class="col-12 pb-4 text-center">
                                    <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">Patient Name: {{ @$patient_info->patient_name }}</span>
                                    <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">UHID: {{ @$patient_info->patient_code }}</span>
                                    <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">IP No: {{ @$patient_info->admission_uid }}</span>
                                    <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">Admission Date: {{ date('d/m/Y', strtotime($patient_info->admission_date)) }}</span>
                                    <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">Admission Department: {{ $patient_info->admitted_department }}</span>
                                    <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">Bed Category: {{ $patient_info->ward_name }}</span>
                                    <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">Bed No.: {{ $patient_info->bed_name }}</span>
                                </div>
                                <div class="col-md-12">
                                    <form action="" method="post" id="invasive_lines_form">
                                        @csrf
                                        <input type="hidden" name="patient_no_fk" id="patient_no_fk" value="{{ @$patient_info->patient_no_pk }}">
                                        <input type="hidden" name="admission_no_fk" id="admission_no_fk" value="{{ @$patient_info->admission_no_pk }}">
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                   <tbody>
                                                    <thead>
                                                        <tr>
                                                            <th colspan="10">INVASIVE LINES/TUBES/DRAINS</th>
                                                        </tr>
                                                        <tr>
                                                            <th style="width: 150px;">Lines/Tubes</th>
                                                            <td>ET</td>
                                                            <td>Tracheostomy Tube</td>
                                                            <td>CVP Line</td>
                                                            <td>Arterial Line</td>
                                                            <td>Peripheral Line</td>
                                                            <td>Ryles tube /JJ/PEG</td>
                                                            <td>Urinary Catheter</td>
                                                            <td>Drains</td>
                                                            <td>Others</td>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>Size</td>
                                                            <td><input type="text" class="custom-form" name="et_size" id="" value="{{ @$data->et_size}}" autocomplete="off"></td>
                                                            <td><input type="text" class="custom-form" name="trache_tube_size" id="" value="{{ @$data->trache_tube_size}}" autocomplete="off"></td>
                                                            <td><input type="text" class="custom-form" name="cvp_line_size" id="" value="{{ @$data->cvp_line_size}}" autocomplete="off"></td>
                                                            <td><input type="text" class="custom-form" name="art_line_size" id="" value="{{ @$data->art_line_size}}" autocomplete="off"></td>
                                                            <td><input type="text" class="custom-form" name="periph_line_size" id="" value="{{ @$data->periph_line_size }}" autocomplete="off"></td>
                                                            <td><input type="text" class="custom-form" name="ryle_tube_size" id="" value="{{ @$data->ryle_tube_size }}" autocomplete="off"></td>
                                                            <td><input type="text" class="custom-form" name="urinary_cath_size" id="" value="{{ @$data->urinary_cath_size}}" autocomplete="off"></td>
                                                            <td><input type="text" class="custom-form" name="drains_size" id="" value="{{ @$data->drains_size}}" autocomplete="off"></td>
                                                            <td><input type="text" class="custom-form" name="others_size" id="" value="{{ @$data->others_size }}" autocomplete="off"></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Fixation (lip level)</td>
                                                            <td><input type="text" class="custom-form" name="et_fixation" id="" value="{{ @$data->et_fixation}}" autocomplete="off"></td>
                                                            <td><input type="text" class="custom-form" name="trache_tube_fixation" id="" value="{{ @$data->trache_tube_fixation }}" autocomplete="off"></td>
                                                            <td><input type="text" class="custom-form" name="cvp_line_fixation" id="" value="{{ @$data->cvp_line_fixation }}" autocomplete="off"></td>
                                                            <td><input type="text" class="custom-form" name="art_line_fixation" id="" value="{{ @$data->art_line_fixation }}" autocomplete="off"></td>
                                                            <td><input type="text" class="custom-form" name="periph_line_fixation" id="" value="{{ @$data->periph_line_fixation }}" autocomplete="off"></td>
                                                            <td><input type="text" class="custom-form" name="ryle_tube_fixation" id="" value="{{ @$data->ryle_tube_fixation }}" autocomplete="off"></td>
                                                            <td><input type="text" class="custom-form" name="urinary_cath_fixation" id="" value="{{ @$data->urinary_cath_fixation }}" autocomplete="off"></td>
                                                            <td><input type="text" class="custom-form" name="drains_fixation" id="" value="{{ @$data->drains_fixation }}" autocomplete="off"></td>
                                                            <td><input type="text" class="custom-form" name="others_fixation" id="" value="{{ @$data->others_fixation }}" autocomplete="off"></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Date of insertion</td>
                                                            <td><input type="text" class="custom-form date_picker" name="et_date_insertion" id="" value="{{@$data->et_date_insertion ? date('d-m-Y', strtotime($data->et_date_insertion)) : "" }}" autocomplete="off"></td>
                                                            <td><input type="text" class="custom-form date_picker" name="trache_tube_date_insertion" id="" value="{{ @$data->trache_tube_date_insertion ? date('d-m-Y', strtotime($data->trache_tube_date_insertion)) : "" }}" autocomplete="off"></td>
                                                            <td><input type="text" class="custom-form date_picker" name="cvp_line_date_insertion" id="" value="{{ @$data->cvp_line_date_insertion ? date('d-m-Y', strtotime($data->cvp_line_date_insertion)) : " " }}" autocomplete="off"></td>
                                                            <td><input type="text" class="custom-form date_picker" name="art_line_insert_date" id="" value="{{ @$data->art_line_insert_date ? date('d-m-Y', strtotime($data->art_line_insert_date)) : ""}}" autocomplete="off"></td>
                                                            <td><input type="text" class="custom-form date_picker" name="periph_line_date_insertion" id="" value="{{ @$data->periph_line_date_insertion ? date('d-m-Y', strtotime($data->periph_line_date_insertion)) : ""}}" autocomplete="off"></td>
                                                            <td><input type="text" class="custom-form date_picker" name="ryle_tube_date_insertion" id="" value=" {{ @$data->ryle_tube_date_insertion ? date('d-m-Y', strtotime($data->ryle_tube_date_insertion)) : "" }}" autocomplete="off"></td>
                                                            <td><input type="text" class="custom-form date_picker" name="urinary_cath_date_insertion" id="" value="{{ @$data->urinary_cath_date_insertion ? date('d-m-Y', strtotime($data->urinary_cath_date_insertion)) : "" }}" autocomplete="off"></td>
                                                            <td><input type="text" class="custom-form date_picker" name="drains_date_insertion" id="" value="{{ @$data->drains_date_insertion ? date('d-m-Y', strtotime($data->drains_date_insertion)) : "" }}" autocomplete="off"></td>
                                                            <td><input type="text" class="custom-form date_picker" name="others_date_insertion" id="" value="{{@$data->others_date_insertion ? date('d-m-Y', strtotime($data->others_date_insertion))  : ""}}" autocomplete="off"></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Site</td>
                                                            <td><input type="text" class="custom-form" name="et_site" id="" value="{{ @$data->et_site }}" autocomplete="off"></td>
                                                            <td><input type="text" class="custom-form" name="trache_tube_site" id="" value="{{ @$data->trache_tube_site }}" autocomplete="off"></td>
                                                            <td><input type="text" class="custom-form" name="cvp_line_site" id="" value="{{ @$data->cvp_line_site }}" autocomplete="off"></td>
                                                            <td><input type="text" class="custom-form" name="art_line_site" id="" value="{{ @$data->art_line_site }}" autocomplete="off"></td>
                                                            <td><input type="text" class="custom-form" name="periph_line_site" id="" value="{{ @$data->periph_line_site }}" autocomplete="off"></td>
                                                            <td><input type="text" class="custom-form" name="ryle_tube_site" id="" value="{{ @$data->ryle_tube_site }}" autocomplete="off"></td>
                                                            <td><input type="text" class="custom-form" name="urinary_cath_site" id="" value="{{ @$data->urinary_cath_site }}" autocomplete="off"></td>
                                                            <td><input type="text" class="custom-form" name="drains_site" id="" value="{{ @$data->drains_site }}" autocomplete="off"></td>
                                                            <td><input type="text" class="custom-form" name="others_site" id="" value="{{ @$data->others_site }}" autocomplete="off"></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Days</td>
                                                            <td><input type="text" class="custom-form" name="et_days" id="" value="{{ @$data->et_days }}" autocomplete="off"></td>
                                                            <td><input type="text" class="custom-form" name="trache_tube_days" id="" value="{{ @$data->trache_tube_days }}" autocomplete="off"></td>
                                                            <td><input type="text" class="custom-form" name="cvp_line_days" id="" value="{{ @$data->cvp_line_days }}" autocomplete="off"></td>
                                                            <td><input type="text" class="custom-form" name="art_line_days" id="" value="{{ @$data->art_line_days }}" autocomplete="off"></td>
                                                            <td><input type="text" class="custom-form" name="periph_line_days" id="" value="{{ @$data->periph_line_days }}" autocomplete="off"></td>
                                                            <td><input type="text" class="custom-form" name="ryle_tube_days" id="" value="{{ @$data->ryle_tube_days }}" autocomplete="off"></td>
                                                            <td><input type="text" class="custom-form" name="urinary_cath_days" id="" value="{{ @$data->urinary_cath_days }}" autocomplete="off"></td>
                                                            <td><input type="text" class="custom-form" name="drains_days" id="" value="{{ @$data->drains_days }}" autocomplete="off"></td>
                                                            <td><input type="text" class="custom-form" name="others_days" id="" value="{{ @$data->others_days }}" autocomplete="off"></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Patency check</td>
                                                            <td><input type="text" class="custom-form" name="et_patency_check" id="" value="{{ @$data->et_patency_check }}" autocomplete="off"></td>
                                                            <td><input type="text" class="custom-form" name="trache_tube_patency_check" id="" value="{{ @$data->trache_tube_patency_check }}" autocomplete="off"></td>
                                                            <td><input type="text" class="custom-form" name="cvp_line_patency_check" id="" value="{{ @$data->cvp_line_patency_check }}" autocomplete="off"></td>
                                                            <td><input type="text" class="custom-form" name="art_line_patency" id="" value="{{ @$data->art_line_patency }}" autocomplete="off"></td>
                                                            <td><input type="text" class="custom-form" name="periph_line_patency_check" id="" value="{{ @$data->periph_line_patency_check }}" autocomplete="off"></td>
                                                            <td><input type="text" class="custom-form" name="ryle_tube_patency_check" id="" value="{{ @$data->ryle_tube_patency_check }}" autocomplete="off"></td>
                                                            <td><input type="text" class="custom-form" name="urinary_cath_patency_check" id="" value="{{ @$data->urinary_cath_patency_check }}" autocomplete="off"></td>
                                                            <td><input type="text" class="custom-form" name="drains_patency_check" id="" value="{{ @$data->drains_patency_check }}" autocomplete="off"></td>
                                                            <td><input type="text" class="custom-form" name="others_patency_check" id="" value="{{ @$data->others_patency_check }}" autocomplete="off"></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Removed on</td>
                                                            <td><input type="text" class="custom-form date_picker" name="et_removed_on" id="" value="{{@$data->et_removed_on ? date('d-m-Y', strtotime($data->et_removed_on)) : "" }}" autocomplete="off"></td>
                                                            <td><input type="text" class="custom-form date_picker" name="trache_tube_removed_on" id="" value=" {{@$data->trache_tube_removed_on ? date('d-m-Y', strtotime($data->trache_tube_removed_on)) : "" }}" autocomplete="off"></td>
                                                            <td><input type="text" class="custom-form date_picker" name="cvp_line_removed_on" id="" value="{{@$data->cvp_line_removed_on ? date('d-m-Y', strtotime($data->cvp_line_removed_on)) : "" }}" autocomplete="off"></td>
                                                            <td><input type="text" class="custom-form date_picker" name="art_line_removed_on" id="" value="{{@$data->art_line_removed_on ? date('d-m-Y', strtotime($data->art_line_removed_on)) : "" }} " autocomplete="off"></td>
                                                            <td><input type="text" class="custom-form date_picker" name="periph_line_removed_on" id="" value="{{@$data->periph_line_removed_on ? date('d-m-Y', strtotime($data->periph_line_removed_on)) : "" }}" autocomplete="off"></td>
                                                            <td><input type="text" class="custom-form date_picker" name="ryle_tube_removed_on" id="" value="{{@$data->ryle_tube_removed_on ? date('d-m-Y', strtotime($data->ryle_tube_removed_on)) : "" }}" autocomplete="off"></td>
                                                            <td><input type="text" class="custom-form date_picker" name="urinary_cath_removed_on" id="" value="{{@$data->urinary_cath_removed_on ? date('d-m-Y', strtotime($data->urinary_cath_removed_on)) : "" }}" autocomplete="off"></td>
                                                            <td><input type="text" class="custom-form date_picker" name="drains_removed_on" id="" value=" {{@$data->drains_removed_on ? date('d-m-Y', strtotime($data->drains_removed_on)) : "" }}" autocomplete="off"></td>
                                                            <td><input type="text" class="custom-form date_picker" name="others_removed_on" id="" value="{{@$data->others_removed_on ? date('d-m-Y', strtotime($data->others_removed_on)) : "" }}" autocomplete="off"></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Reason for removal</td>
                                                            <td><input type="text" class="custom-form" name="et_reason_removal" id="" value="{{ @$data->et_reason_removal }}" autocomplete="off"></td>
                                                            <td><input type="text" class="custom-form" name="trache_reason_removal" id="" value="{{ @$data->trache_reason_removal }}" autocomplete="off"></td>
                                                            <td><input type="text" class="custom-form" name="cvp_line_reason_removal" id="" value="{{ @$data->cvp_line_reason_removal }}" autocomplete="off"></td>
                                                            <td><input type="text" class="custom-form" name="art_line_removal_reason" id="" value="{{ @$data->art_line_removal_reason }}" autocomplete="off"></td>
                                                            <td><input type="text" class="custom-form" name="periph_line_reason_removal" id="" value="{{ @$data->periph_line_reason_removal }}" autocomplete="off"></td>
                                                            <td><input type="text" class="custom-form" name="ryle_tube_reason_removal" id="" value="{{ @$data->ryle_tube_reason_removal }}" autocomplete="off"></td>
                                                            <td><input type="text" class="custom-form" name="urinary_cath_reason_removal" id="" value="{{ @$data->urinary_cath_reason_removal }}" autocomplete="off"></td>
                                                            <td><input type="text" class="custom-form" name="drains_reason_removal" id="" value="{{ @$data->drains_reason_removal }}" autocomplete="off"></td>
                                                            <td><input type="text" class="custom-form" name="others_reason_removal" id="" value="{{ @$data->others_reason_removal }}" autocomplete="off"></td>
                                                        </tr>
                                                    </tbody>
                                                   </tbody>
                                                </table>
                                            </div>
                                            <div class="text-center">
                                                <button class="btn btn-md btn-success px-5" type="button" onclick="saveInvasive()">Save</button>
                                            </div>
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
</main>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script>
      $(".date_picker").datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        todayHighlight: true,
        clearBtn: true,
        // startDate: new Date()
    });  
    function saveInvasive(){
        let formElement = document.querySelector('#invasive_lines_form');
        let formData = new FormData(formElement);
        if($('#admission_no_fk').val() == ''){
            alert('Amission no required');
            return false;
        }
        if($('#patient_no_fk').val() == ''){
            alert('Patient no required');
            return false;
        }
        $.ajax({
                url:"{{route('v2.ipd.save-invasive-lines')}}",
                type:"post",
                dataType:"json",
                data:formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    blockUI();
                },
                success:function(data){  
                    $.unblockUI();
                    $('.common-modal-notify').modal('show');
                    $('.common-modal-notify .modal-title').html('Success');
                    $('.common-modal-notify .modal-body').html(data.message);
                },
                error:function(err){
                    $.unblockUI();
                    var error = err.responseJSON;
                    $('.common-modal-notify-error').modal('show');
                    $('.common-modal-notify-error .modal-title').html('Failed');
                    $('.common-modal-notify-error .modal-body').html(error.message);
                },
                complete: function() {
                    $.unblockUI();
                }
        });
    }                                                     
</script>
