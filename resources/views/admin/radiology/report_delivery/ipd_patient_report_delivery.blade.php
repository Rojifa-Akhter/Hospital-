<style>
    .nav-pills .nav-link.active, .nav-pills .show > .nav-link {
        background-color: #004b7b;
        clip-path: polygon(93% 0, 100% 50%, 93% 100%, 0 100%, 0 0);
    }


    .detail-info-tab .nav-tabs{
        border-bottom: 0px;
    }

    .detail-info-tab .nav-tabs .nav-link.active {
        clip-path: inherit;
        background-color: transparent!important;
        color: #003b61;
        border-bottom: 2px solid #003b61;
        text-align: center;
        padding: 0px 10px;
        transition: all 0.3s;
    }

    .detail-info-tab .nav-tabs .nav-link {
        clip-path: inherit;
        color: #3490dc;
        background-color: transparent!important;
        border-bottom: 2px solid #5eb8e245;
        text-align: center;
        padding: 0px 10px;
        transition: all 0.3s;
        position: relative;
    }

    .detail-info-tab .nav-tabs .nav-link.active::before{
        content: '';
        position: absolute;
        top: 100%;
        left: 50%;
        transform: translateX(-50%);
        height: 5px;
        width:15px;
        background-color: #003b61;
        clip-path: polygon(50% 100%, 0 0, 100% 0);
    }

    #demographic-details-child tr th{
        min-width: 150px;
    }

    .list-group-item {
        padding: 0.2rem 0.8rem!important;
    }

    .cursor-pointer{
        cursor: pointer;
    }
</style>
<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css')}}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">

<div class="container-fluid">
    <div class="row align-items-center bg-white border-bottom sticky-top-breadcrumb shadow-sm">
        <div class="col-md-6">
            <h5 class="mt-2 mb-0">IPD Patient Report Delivery</h5>
            <small>IPD Patient Report Delivery</small>
        </div>
    </div>
   
    <div class="form-row">
        <div class="col-md-12">        
            @include('admin.radiology.process.ipd_patient_delivery_receive')
        </div>
    </div>
</div>

<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js')}}"></script>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script>


    $("body").addClass("sidebar-collapse");
    $('.select2').select2();
    $(function() {
        $('.date_picker').datepicker({
            todayHighlight: true,
            clearBtn: true,
            autoclose: true,
            endDate: '+0d',
            'format':'dd-mm-yyyy'
        });
    });

    var DeliveryFunc = {
        getReceptionData: function(thisElement)
        {
            var action 		= $(thisElement).attr("data-action");
            var tab_type 	= $(thisElement).attr("data-tab-type");
            $.ajax({
                data: { tab_type:tab_type },
                url: action,
                type: "post",
                beforeSend:function(){
                    blockUI();
                },
                success: function (data) {
                    $(thisElement).parents("#my_tab").siblings("#my_tab_content").html(data);
                },
                complete:function(){
                    $.unblockUI();
                }
            });
            event.stopImmediatePropagation();
        },
        // DeliveryFunc.selectInvoiceId
        selectInvoiceId:function (invoice_no=""){
            $("#pat_bill_info").removeClass('d-none');
            var invoice_code = invoice_no;
            $.ajax({
                url: "{{ route('patient-bill-info-json') }}",
                type: 'post',
                data: {
                    invoice_code: invoice_code,
                    type: 1
                },
                beforeSend: function() {
                    blockUI();
                },
                success: function(data) {     
                    console.log(data)              
                    $("#patient_code").html(data.patient_code);
                    $("#patient_name").html(data.patient_name);
                    $("#patient_age").html(data.age);
                    $("#patient_gender").html(data.gender);
                    $("#patient_bg").html(data.blood_group);
                    $("#patient_ms").html(data.mobile1);
                    $("#amount").html(data.amount);
                    $("#paid").html(data.paid);
                    $("#due").html(data.due);
                    $("#payable").html(data.payable);
                    $("#discount").html(data.discount);

                },
                complete: function() {
                    $.unblockUI();
                }
            });
            event.stopImmediatePropagation();

        }


    };

    // All Search Here

    // Search Receive list
    $(document).on("click", "#rcb_process_search", function(e) {
        var formID = $("#frm_receive_search").attr("id");
        var formMethod = $("#frm_receive_search").attr("method");
        $.ajax({
            data: $('#' + formID).serialize(),
            url:"{{ url('delivery/ipd-patient-receive-data-search') }}",
            type: formMethod,
            beforeSend: function() {
                blockUI();

            },
            success: function(data) {
                // console.log(data);
                $("#receive_search_data").html(data);
                DeliveryFunc.selectInvoiceId($('#patientBilling').val());
            },
            complete: function() {
                $.unblockUI();
            }
        });
    });
    // Search Delivery Pending list
    $(document).on("click", "#delivery_process_search", function(e) {
        var formID = $("#frm_delivery_search").attr("id");
        var formMethod = $("#frm_delivery_search").attr("method");
        $.ajax({
            data: $('#' + formID).serialize(),
            url:"{{ url('delivery/ipd-patient-receive-data-search') }}",
            type: formMethod,
            beforeSend: function() {
                blockUI();

            },
            success: function(data) {
                $("#delivery_pending_list").html(data);
            },
            complete: function() {
                $.unblockUI();
            }
        });
    });
    // Search Delivered  list
    $(document).on("click", "#delivered_search", function(e) {
        var formID = $("#frm_delivered_search").attr("id");
        var formMethod = $("#frm_delivered_search").attr("method");
        $.ajax({
            data: $('#' + formID).serialize(),
            url:"{{ url('delivery/ipd-patient-receive-data-search') }}",
            type: formMethod,
            beforeSend: function() {
                blockUI();

            },
            success: function(data) {
                $("#delivered_list").html(data);
            },
            complete: function() {
                $.unblockUI();
            }
        });
    });
    // Search Delivery  list
    $(document).on("click", "#status_search", function(e) {
        var formID = $("#frm_status_search").attr("id");
        var formMethod = $("#frm_status_search").attr("method");
        $.ajax({
            data: $('#' + formID).serialize(),
            url:"{{ url('delivery/ipd-patient-receive-data-search') }}",
            type: formMethod,
            beforeSend: function() {
                blockUI();

            },
            success: function(data) {
                $("#status_list").html(data);
            },
            complete: function() {
                $.unblockUI();
            }
        });
    });
    openInvoiceAutocomplete("#prescription_id");
    openPatientAutocomplete('#patient_id');
    openAdmissionAutocomplete('#admission_no');
    openPatientAndBillingAutocomplete('#patientBilling',"voucher_id");

</script>
