<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<style>
    table tr td,
    table tr td {
        vertical-align: top !important;
    }

    table#investigation_cancle_form.table-bordered,
    table#investigation_cancle_form.table-bordered td,
    table#investigation_cancle_form.table-bordered th {
        border: 1px solid #dee2e6;
        border-bottom: 2px solid #d2d2d2;
    }

</style>
<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm">
        <div class="col-md-12">
            <h5 class="mt-2 mb-0">Radiology Step Cancellation</h5>
            <small>Admin / Radiology Step Cancellation</small>
        </div>
    </div>
    <div class="card">
        <div class="card-body p-2">
            <div class="form-row justify-content-center border-bottom">
                <div class="col-md-8">
                    @include('admin.investigation_cancel.investigation_cancel_search_rad')
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-12">
            <div class="tab-content" style="background-color: transparent; padding:0px;">
                <div class="tab-pane fade show active" id="result-entry" role="tabpanel"
                    aria-labelledby="received-by-challan-tab">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active page-tab cursor-pointer" data-toggle="tab" role="tab"
                                aria-controls="Result Entry" aria-selected="true" href="#" rel="tab">Radiology</a>
                        </li>
                        {{-- <li class="nav-item" role="presentation">
                            <a class="nav-link page-tab cursor-pointer" data-toggle="tab" role="tab"
                                aria-controls="Verified Results" aria-selected="false" href="#" rel="tab">Radiology</a>
                        </li> --}}
                    </ul>

                    <div id="inv-list">
                        @include('admin.investigation_cancel.investigation_cancel_create_form_rad')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script>
    $("body").addClass("sidebar-collapse");
    openInvoiceAutocomplete("#voucher_no");

    function searchInvestigationCancel(element) {
        var cancel_invoice_id = $('#voucher_no').val();
        var lab_no = $('#lab_no').val();
        // alert(invoice_id);

        $.ajax({
            url: "{{ route('inv.get-investigation-data-search-rad') }}",
            type: "post",
            data: {
                cancel_invoice_id: cancel_invoice_id,
                lab_no: lab_no
            },
            beforeSend: function() {
                blockUI();
            },
            success: function(data) {

                // var json_data = JSON.parse(data);
                // console.log(json_data);
                console.log(data);
                if (data == '"Error"') {
                    $("#inv-list").html('<h2>No Record</h2>');
                } else {
                    $("#inv-list").html(data);

                    var lab_no = $('.checked_ind').attr('id');
                    var tab_attribs = [];
                    $('.checked_ind').each(function() {
                        tab_attribs.push($(this).attr("data-lab_no"));
                    });
                    tab_attribs.forEach(element => {
                        var class_arr = [];
                        var len = 1;
                        $('.check_box_' + element).each(function() {
                            if ($(this).is(':checked')) {
                                class_arr.push($(this).val());
                            }
                        });
                        var enable_check = class_arr.length;
                        console.log(enable_check);

                        $('.check_box_' + element).each(function() {
                            if ($(this).is(':checked')) {

                                if (enable_check != len++) {
                                    $(this).attr('disabled', true);
                                }
                            }
                        });

                    })
                }

            },
            complete: function(data) {
                // var j_data = JSON.parse(data);

                // if (j_data.meg == 'Error') {

                // } else {
                //     var lab_no = $('.checked_ind').attr('id');
                //     var tab_attribs = [];
                //     $('.checked_ind').each(function() {
                //         tab_attribs.push($(this).attr("data-lab_no"));

                //     });

                //     tab_attribs.forEach(element => {
                //         var class_arr = [];
                //         var len = 1;
                //         $('.check_box_' + element).each(function() {
                //             if ($(this).is(':checked')) {
                //                 class_arr.push($(this).val());
                //             }
                //         });
                //         var enable_check = class_arr.length;
                //         console.log(enable_check);

                //         $('.check_box_' + element).each(function() {
                //             if ($(this).is(':checked')) {

                //                 if (enable_check != len++) {
                //                     $(this).attr('disabled', true);
                //                 }
                //             }
                //         });

                //     })

                // }
                $.unblockUI();
            }
        })
    }

    function cancel(element) {
        var code_lab_repot = $(element).attr('data-cancel_value');
        var id_name = $(element).attr('id');

        console.log(id_name);
        if ($(element).prop('checked') == false) {
            var comf = confirm("Are You Sure?");
            if (comf == true) {
                $.ajax({
                    url: "{{ route('inv.cancel-investigation-data-rad') }}",
                    type: "post",
                    data: {
                        code_lab_repot: code_lab_repot,
                    },
                    beforeSend: function() {
                        blockUI();
                    },
                    success: function(data) {
                        console.log(data);
                        if (data.title == 'Success') {
                            searchInvestigationCancel(this);
                            $('.common-modal-notify').modal('show');
                            $('.common-modal-notify .modal-body').html(
                                "<i class='fas fa-stroopwafel fa-spin'></i>");
                            $('.common-modal-notify .modal-title').html(data.title);
                            $('.common-modal-notify .modal-body').html(data.msg);

                            // $(element).parent().parent().parent().prev('div').children().find('.check_box_'+id_name).attr('disabled', false);
                            // $(element).attr('disabled', true);
                        } else {
                            searchInvestigationCancel(this);
                            // $(element).parent().parent().parent().prev('div').children().find('.check_box_'+id_name).attr('disabled', true);
                            // $(element).attr('disabled', false);
                            // $(element).attr('checked', false);
                        }


                    },
                    complete: function() {

                        $.unblockUI();
                    }
                })
            } else {
                $(element).prop('checked', true);
            }
        }
    }
    $('body').on('click', '.show_in_rep', function() {
        if ($(this).is(':checked')) {
            $(this).prop('checked', true)
            $(this).attr('checked', true)
        } else {
            $(this).prop('checked', false)
            $(this).attr('checked', false)
        }
    });
</script>
