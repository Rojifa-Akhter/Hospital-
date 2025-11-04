<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<style>
    #gridlist .user-card {
        margin-bottom: 10px !important;
    }

    #gridlist .user-card .details h4 {
        /* font-size: 22px; */
        color: #607d8b !important;
        margin: 0px !important;
        font-size: 16px;
    }

    #gridlist .user-card .details h6 {
        color: #91bcd1 !important;
        font-size: 12px !important;
    }

    #gridlist .user-card .image {
        width: 100px !important;
        height: 100px !important;
        border-radius: 50% !important;
        overflow: hidden !important;
        margin: 0px auto 20px auto !important;
    }

    #gridlist .user-card .details {
        margin: 20px 0px 20px 0px !important;
        text-align: center !important;
    }

    #gridlist .badge-primary {
        border: 1px solid #b66dff !important;
        color: #ffffff !important;
    }


    #gridlist .badge-info {
        border: 1px solid #198ae3 !important;
        color: #ffffff !important;
    }

    #gridlist .nav-tabs .nav-item {
        margin-bottom: -1px !important;
        width: 33.3% !important;
        background-color: #607d8b !important;
        text-align: center !important;
        color: #fff !important;
        border: 1px solid #607d8b !important;
    }

    #gridlist .nav-tabs .nav-item.show .nav-link,
    #gridlist .nav-tabs .nav-link.active {
        color: #495057 !important;
        background-color: #fff !important;
        border-color: #fff #fff #fff !important;
        transition: all 0.3s !important;
        border-radius: 0 !important;
    }

    #gridlist .nav-tabs .nav-link:hover,
    #gridlist .nav-tabs .nav-link:focus {
        border-color: #ebedf2 #ebedf2 #ebedf2 !important;
        border-radius: 0 !important;
    }

    #gridlist .nav-tabs .nav-link {
        text-transform: uppercase !important;
    }

    #gridlist .nav-link {
        display: block !important;
        padding: 0.5rem 1rem !important;
        font-size: 18px !important;
        font-weight: 500 !important;
        color: #fff !important;

    }

    #gridlist .nav-tabs {
        border-bottom: 2px solid transparent;
    }

</style>


<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm">
        <div class="col-md-12">
            <div class="float-left">
                <h5 class="mt-2 mb-0"> Emergency Prescribed Patient List</h5>
                <small>Prescription / Emergency Prescribed Patient List</small>
            </div>
            <div id="top-action1">
                {{-- <button class="btn btn-outline-primary btn-md float-right open-modal" data-modal="common-modal-md" data-action="{{ route('bed.index') }}" data-title="Room List"><i class="fa fa-list"></i>&nbsp;Bed List</button> --}}
            </div>
        </div>
    </div>

    @include('admin.prescription.emergency_prescribed_patient_search')

    <section id="gridlist">
        <div class="form-row">
            <div class="col-md-12 mt-2">
                {{-- <ul class="nav nav-tabs" id="myTab" role="tablist">

                    <li class="nav-item">
                        <a class="nav-link active" id="prescribed-patient-tab" data-toggle="tab" href="#prescribed-patient"
                            role="tab" onclick="PresFunc.allAppointedPrescribedList(this)"
                            aria-controls="prescribed-patient" aria-selected="false" tab_type="Prescribed"
                            data-action="{{ route('prescription.all-patient-appointed-prescribed-list') }}">PRESCRIBED
                            PATIENT </a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" id="appointed-patient-tab" data-toggle="tab" href="#appointed-patient"
                            role="tab" onclick="PresFunc.allAppointedPrescribedList(this)"
                            aria-controls="appointed-patient" aria-selected="false" tab_type="Appointed"
                            data-action="{{ route('prescription.all-patient-appointed-prescribed-list') }}">APPOINTED
                            PATIENT</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" id="all-patient-tab" data-toggle="tab" href="#all-patient" role="tab"
                           onclick="PresFunc.allAppointedPrescribedList(this)" aria-controls="all-patient"
                           aria-selected="true" tab_type="Appointed & Prescribed"
                           data-action="{{ route('prescription.all-patient-appointed-prescribed-list') }}">ALL
                            PATIENT</a>
                    </li>
                </ul> --}}

                <div class="tab-content p-0 bg-transparent" id="myTabContent">

                    @include('admin.prescription.emergency_prescribed_list')
                </div>
            </div>
        </div>
    </section>


</div>

<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script>
    $(document).on("click", "#btn_emr", function(e) {
        var hdn_patient_id = $(this).attr('emr-attr');
        if (hdn_patient_id == "") {
            $('.common-modal-notify-error').modal('show');
            $('.common-modal-notify-error .modal-title').html("Validation Error");
            $('.common-modal-notify-error .modal-body').html("You did not select any Patient");
            return;
        }
        window.open("{{ route('emr.patient-emr') }}/" + hdn_patient_id, "_blank");
    });

    var PresFunc = {
        allAppointedPrescribedList: function(thisElement) {
            var patient_id = $('#hdn_patient_id').val();
            var search_date_from = $('#search_date_from').val();
            var search_date_to = $('#search_date_to').val();
            var action = $(thisElement).attr("data-action");
            var tab_type = $(thisElement).attr("tab_type");
            $.ajax({
                data: {
                    tab_type: tab_type,
                    patient_id: patient_id,
                    search_date_from: search_date_from,
                    search_date_to: search_date_to
                },
                url: action,
                type: "post",
                beforeSend: function() {
                    blockUI();
                },
                success: function(data) {
                    $(thisElement).parents("#myTab").siblings("#myTabContent").html(data);
                    $("#myTabContent").html(data);
                },
                complete: function() {
                    $.unblockUI();
                }
            });
        }
    }


    $(function() {
        $('.date_picker').datepicker({
            todayHighlight: true,
            clearBtn: true,
            autoclose: true,
            // endDate: '+0d',
            'format': 'dd/mm/yyyy'
        });
    });
    openPatientAutocomplete('#patient_code');
</script>
