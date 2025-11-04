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
            <h5 class="mt-2 mb-0">Pathology Step Cancelation </h5>
            <small>Admin / Pathology Step Cancelation</small>
        </div>
    </div>
    <div class="card">
        <div class="card-body p-2">
            <div class="form-row justify-content-center border-bottom">
                <div class="col-md-8">
                    @include('admin.investigation_cancel.investigation_cancel_search')
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
                                aria-controls="Result Entry" aria-selected="true" href="#"
                                rel="tab">Pathology</a>
                        </li>
                        {{-- <li class="nav-item" role="presentation">
                            <a class="nav-link page-tab cursor-pointer" data-toggle="tab" role="tab"
                                aria-controls="Verified Results" aria-selected="false" href="#" rel="tab">Radiology</a>
                        </li> --}}
                    </ul>

                    <div id="inv-list">
                        @include('admin.investigation_cancel.investigation_cancel_create_form')
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
            url: "{{ route('inv.get-investigation-data-search') }}",
            type: "post",
            data: {
                cancel_invoice_id: cancel_invoice_id,
                lab_no: lab_no
            },
            beforeSend: function() {
                blockUI();
            },
            success: function(data) {
                if (data == '"Error"') {
                    $("#inv-list").html('<h2>No Record</h2>');
                }else{
                    $("#inv-list").html(data);
                    var lab_no = $('.checked_ind').attr('id');
                    var tab_attribs = [];
                    $('.checked_ind').each(function() {
                        tab_attribs.push($(this).attr("data-lab_no"));
                    });

                    console.log(tab_attribs,'tab_attribs')

                    tab_attribs.forEach((element, index) => {
                        var class_arr = [];
                        var len = 1;
                        $('.check_box_' + index + '_' + element).each(function() {
                            if ($(this).is(':checked')) {
                                class_arr.push($(this).val());
                            }
                        });
                        var enable_check = class_arr.length;
                        console.log(index, tab_attribs, class_arr, enable_check);

                        $('.check_box_' + index + '_' + element).each(function() {
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
                    url: "{{ route('inv.cancel-investigation-data') }}",
                    type: "post",
                    data: {
                        code_lab_repot : code_lab_repot,
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
                        } else {
                            searchInvestigationCancel(this);
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





    function restructureBtn(element) {
        console.log($(element).attr('invoice_id'))
        const invoice = $(element).attr('invoice_id')
        const item = $(element).attr('item_id')
        $.ajax({
            url: "{{ route('inv.restructure') }}",
            type: "get",
            data: {
                invoice: invoice,
                item: item
            },
            beforeSend: function() {
                blockUI();
            },
            success: function(data) {
                if (data.title == 'Success') {
                    $('.common-modal-notify').modal('show');
                    $('.common-modal-notify .modal-body').html(
                    "<i class='fas fa-stroopwafel fa-spin'></i>");
                    $('.common-modal-notify .modal-title').html(data.title);
                    $('.common-modal-notify .modal-body').html(data.msg);
                } else {
                    $('.common-modal-notify-error').modal('show');
                    $('.common-modal-notify-error .modal-title').html(data.title);
                    $('.common-modal-notify-error .modal-body').html(data.msg);
                }
            },
            complete: function() {
                $.unblockUI();
            }
        });
    }

    function splitItem(e) {
        let invoice_id = $(e).attr("invoice_id");
        let report_id = $(e).attr("report_id");
        let item_id = $(e).attr("item_id");
        let lab_id = $(e).attr("lab_id");
        $.ajax({
            url: "{{ route('inv.split-investigation-data') }}",
            type: "POST",
            data: {
                invoice_id: invoice_id,
                report_id: report_id,
                item_id: item_id,
                lab_id: lab_id,
                _token: "{{ csrf_token() }}"
            },
            beforeSend: function() {
                $(e).prop("disabled", true).text("Processing...");
            },
            success: function(data) {
                if (data.title == 'Success') {
                    searchInvestigationCancel(this);
                    $('.common-modal-notify').modal('show');
                    $('.common-modal-notify .modal-body').html(
                    "<i class='fas fa-stroopwafel fa-spin'></i>");
                    $('.common-modal-notify .modal-title').html(data.title);
                    $('.common-modal-notify .modal-body').html(data.msg);
                } else {
                    $('.common-modal-notify-error').modal('show');
                    $('.common-modal-notify-error .modal-title').html(data.title);
                    $('.common-modal-notify-error .modal-body').html(data.msg);
                }
            },
            error: function(xhr, status, error) {
                console.error("Error:", error);
                alert("Something went wrong!");
            },
            complete: function() {
                $(e).prop("disabled", false).text("Report Split");
            }
        });
    }
</script>
