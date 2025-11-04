<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}" rel="stylesheet">


<div class="container-fluid">
    <form action="{{ route('store-jakat-non-muslim-edit') }}" id="jakatNonMuslim" method="post">@csrf
        <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm align-items-center py-2">
            <div class="col-md-4 mb-1">
                <h5 class="mt-2 mb-0"> Jakat , Non-Muslim  Edit </h5>
                <small>Billing / Jakat , Non-Muslim  Edit</small>
            </div>
        </div>

        <div class="form-row justify-content-center">
            <div class="col-md-4">
                <div class="card shadow-sm mb-3">
                    <div class="card-body ">
                        <div class="mt-2">
                            <strong >Invoice No <span class="text-danger">*</span></strong>
                            <div class="">
                                <input type="text" class="form-control " id="voucher_no" name="voucher_no" value="" placeholder="Invoice No" style="width: 100%;" required>
                            </div>
                        </div>
                        <div class="mt-2">
                            <strong >Select Type <span class="text-danger">*</span></strong>
                            <div class="">
                               
                                <select id="edit_cancel" name="edit_cancel" class="form-control " required>
                                    <option value="">select</option>
                                    @if(!empty($jakat_non_muslim))
                                        @foreach($jakat_non_muslim as $value)
                                        <option value="{{$value->person_no_pk}}">{{$value->full_name}}</option>
                                        @endforeach
                                    @endif                                    
                                    <option value="0">Cancel</option>
                                </select>
                            </div>
                        </div>
                        <div class="mt-2 text-right">   
                            @php
                                $redirect_url=route('billing.jakat-non-muslim');
                            @endphp
                        <button type="button" class="btn btn-success btn-md" onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{$redirect_url}}')">Save</button>

                        </div>
                    </div>
                    <input type="hidden" name="hdn_invoice_id" id="hdn_invoice_id">
                </div>

            </div>
        </div>     

    </form>

</div>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>

<script type="text/javascript">
    $('.select2').select2();
    $("body").addClass("sidebar-collapse");
    // openInvoiceAutocomplete("#voucher_no");

    // function reload() {
    //     location.reload();
    // }
    // $(document).on('click', '#details', function() {
    //     var voucher_no = $("#hdn_invoice_id").val();
    //     $.ajax({
    //         async: true,
    //         data: {
    //             voucher_no: voucher_no
    //         },
    //         url: "{{ route('billing.get-billing-cancel-invoice-list-edit') }}",
    //         type: "get",
    //         beforeSend: function() {
    //             blockUI();
    //         },
    //         success: function(data) {
    //             $("#patient_data").html(data);
    //             $('#invoice_delete').removeAttr('disabled');
    //             openDoctorAutocomplete('#doctor_code', 'hdn_doctor_id', 'doctor_ind', '1');

    //         },
    //         complete: function() {

    //         },
    //         error: function(data) {
    //             var errors = jQuery.parseJSON(data.responseText).errors;
    //             error_messages = "";
    //             for (messages in errors) {
    //                 var field_name = $("#" + messages).siblings("label").html();
    //                 error_messages += "<div class='alert alert-danger' role='alert'>" + errors[messages] + "</div>";
    //             }

    //             $('.common-modal-notify-error').modal('show');
    //             $('.common-modal-notify-error .modal-title').html("Validation Error");
    //             $('.common-modal-notify-error .modal-body').html(error_messages);

    //             $.unblockUI();
    //         }
    //     }).done(function() {
    //         $.unblockUI();
    //     });


    // });


    // function invoiceDelete(element) {
    //     var voucher_no = $("#hdn_invoice_id").val();
    //     if (confirm('Are you sure ?')) {
    //         $.ajax({
    //             async: true,
    //             data: {
    //                 voucher_no: voucher_no
    //             },
    //             url: "{{ route('billing.delete-invoice') }}",
    //             type: "post",
    //             beforeSend: function() {
    //                 blockUI();
    //             },
    //             success: function(data) {
    //                 var response_url = "{{ route('billing.billing-cancelation') }}";
    //                 $('.common-modal-notify').modal('show');
    //                 $('.common-modal-notify .modal-body').html("<i class='fas fa-stroopwafel fa-spin'></i>");
    //                 $('.common-modal-notify .modal-title').html(data.title);
    //                 $('.common-modal-notify .modal-body').html(data.msg);
    //                 dynamicFunc.afterSaveLoadPage(response_url);

    //             },
    //             complete: function() {

    //             },
    //             error: function(data) {
    //                 var errors = jQuery.parseJSON(data.responseText).errors;
    //                 error_messages = "";
    //                 for (messages in errors) {
    //                     var field_name = $("#" + messages).siblings("label").html();
    //                     error_messages += "<div class='alert alert-danger' role='alert'>" + errors[messages] + "</div>";
    //                 }

    //                 $('.common-modal-notify-error').modal('show');
    //                 $('.common-modal-notify-error .modal-title').html(data.title);
    //                 $('.common-modal-notify-error .modal-body').html(data.msg);

    //                 $.unblockUI();
    //             }
    //         }).done(function() {
    //             $.unblockUI();
    //         });
    //     }

    // }
</script>