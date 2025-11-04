<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<form action="{{ route('delivery.pathology-save-data') }}" method="post" id="pathology_data_save">
    @csrf

    <div class="card">
        <div class="card-header align-content-center" style="text-align: center;">
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <div class="form-check ">
                        <button class="btn btn-success btn-md" type="button" name="is_paid_amount" id="receive_btn"
                            value="receive" onclick="receiveSaveData(this)" title="Receive Data">Receive</button>
                        <button class="btn btn-success btn-md" type="button" name="is_paid_amount" id="delivery_btn"
                            value="pending" onclick="receiveSaveData(this)" title="Delivered Data">Delivery</button>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <input type="hidden" name="type" id="receive" value="">
    <input type="hidden" name="Pendingtype" id="pending" value="">


    <div class="row">
        <div class="col-md-6 pr-0">
            <div class="card">
                <div class="card-header mb-2">
                    <div class="card-title">
                        Pathology Delivery Reports
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table data-table table-bordered" id="pathology-data">
                        <thead class="bg-primary">
                            <tr>
                                <th style="width: 5%;">SL#</th>
                                <th style="width: 5%;"><input type="checkbox" id="PathselectAll" />All</th>
                                <th style="width: 22%;">Invoice </th>
                                <th style="width: 10%;">Admission</th>
                                <th style="width: 12%;">Sample Coll. Date</th>
                                <th style="width: 20%;">Exam Name</th>
                                <th style="width: 13%;">Received By</th>
                                <th style="width: 13%;">Delivery By</th>
                            </tr>
                        </thead>
                        <tbody>
                            <div id="pathology_dt">
                                @include('admin.radiology.process.pathology_dt')
                            </div>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header mb-2">
                    <div class="card-title">
                        Radiology Delivery Reports
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table data-table table-bordered" id="radiology-data">
                        <thead class="bg-primary">
                            <tr>
                                <th style="width: 5%;">SL#</th>
                                <th><input type="checkbox" id="RadselectAll" /></th>
                                <th style="width: 10%;">Invoice</th>
                                <th style="width:7%;">Admission</th>
                                <th style="width: 15%;">Exam Name</th>
                                <th style="width: 10%;">Receive By </th>
                                <th style="width: 10%;">Delivery By </th>
                            </tr>
                        </thead>
                        <tbody>
                            <div id="radiology_dt">
                                @include('admin.radiology.process.radiology_dt')
                            </div>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</form>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}">
</script>
<script>
    $('#PathselectAll').click(function(e) {
        // var table = $(e.target).closest('table');
        // $('td input:checkbox', table).prop('checked', this.checked);
        if ($('#PathselectAll').is(':checked')) {
            $('.is_check_path').prop('checked', true);
        } else {
            $('.is_check_path').prop('checked', false);
        }
    });
    $('#RadselectAll').click(function(e) {
        // var table = $(e.target).closest('table');
        // $('td input:checkbox', table).prop('checked', this.checked);
        if ($('#RadselectAll').is(':checked')) {
            $('.is_check_rad').prop('checked', true);
        } else {
            $('.is_check_rad').prop('checked', false);
        }
    });

    $('#selectAllPath').click(function(e) {
        if ($('#selectAllPath').is(':checked')) {
            $('.mulltiple_print_path').prop('checked', true);
        } else {
            $('.mulltiple_print_path').prop('checked', false);
        }
    });
    $('#selectAllPathLabel').click(function(e) {
        if ($('#selectAllPathLabel').is(':checked')) {
            $('.mulltiple_print_path_label').prop('checked', true);
        } else {
            $('.mulltiple_print_path_label').prop('checked', false);
        }
    });
    $('#selectAllRad').click(function(e) {

        if ($('#selectAllRad').is(':checked')) {
            $('.mulltiple_print').prop('checked', true);
        } else {
            $('.mulltiple_print').prop('checked', false);
        }
    });
    $('#selectAllRadLabel').click(function(e) {

        if ($('#selectAllRadLabel').is(':checked')) {
            $('.mulltiple_print_label').prop('checked', true);
        } else {
            $('.mulltiple_print_label').prop('checked', false);
        }
    });
    $('.data-table').DataTable({
        "lengthMenu": [[50, 100, 200, 300, 500, -1], [50, 100, 200, 300, 500, "All"]]
    });

    function receiveSaveData(thisElement) {
       
      

        var current_url = '{{ Route::currentRouteName() }}';
        var brack_ind=0;
        if(current_url == 'delivery.ipd-patient-receive-data-search'){
            var response_url = '{{ route('ipd-patient-report-delivery') }}';
            if ($(thisElement).val() == 'receive') {           
                $("#receive").val("Receive");
            } else {                
                $("#receive").val("Pending");
            }
        }else{
            if ($(thisElement).val() == 'receive') {           
                $("#receive").val("Receive");
            } else {
                
                $("#receive").val("Pending");
                $('input.is_check:checked:not(:disabled), input.is_check_path:checked:not(:disabled)').each(function() {
                let value = $(this).val();
                let pending_ind= $(this).parents('tr').find('.report_deli_pending_ind').val();
                let due= $(this).parents('tr').find('.due').val();
                if (pending_ind =='' || due >0) {
                        brack_ind=1;   
                    }           
                });
            }
           
            var response_url = '{{ route('report-delivery') }}';
        }
        if (brack_ind == 1) {
            alert('Please Receive Report First or Pay Due Amount');
            return false;
        }
        btnSaveUpdate(thisElement, '', '', '', '', dynamicFunc.afterSaveLoadPage, response_url);
    }

    function pendingSaveData(thisElement) {
        let hidden_value = "Pending";
        $("#pending").val(hidden_value);

    }

    function patholog_report_receive(thisElement) {
        var formID = $(thisElement).attr("id");
        var formMethod = $(thisElement).attr("method");
        var formAction = $(thisElement).attr("action");

        if (formValidation(formID) == false) {
            return;
        }

        if (confirm("Are You Sure ?")) {
            $.ajax({
                async: true,
                data: $('#' + formID).serialize(),
                url: formAction,
                type: formMethod,
                beforeSend: function() {
                    blockUI();
                },
                success: function(data) {
                    $('.common-modal-notify').modal('show');
                    $('.common-modal-notify .modal-body').html(
                        "<i class='fas fa-stroopwafel fa-spin'></i>");
                    $('.common-modal-notify .modal-title').html(data.title);
                    $('.common-modal-notify .modal-body').html(data.msg);
                    window.location.href = "{{ route('report-delivery') }}";
                },
                complete: function() {
                    $.unblockUI();
                }
            });
        }
    }

    function reportPrint(thisElement) {
        var invoice_id = $(thisElement).attr("data-invoice");
        var report_route = $(thisElement).attr("data-report_route");
        // var pdf_url ="{{ route('radiology.rad-report-pdf', ':id') }}";
        // var pdf_url_id=pdf_url.replace(':id', report_id);
        if (report_route == "#") {
            return;
        }
        var url = "{{ route('radiology.rad-report-validate') }}";

        $.ajax({
            async: true,
            data: {
                invoice_id: invoice_id
            },
            url: url,
            type: "post",
            beforeSend: function() {
                blockUI();
            },
            success: function(data) {
                console.log(data);
                if (data == "PASS") {
                    window.location.replace(report_route, '_blank');
                } else {
                    alert(data);
                    return;
                }
                // $('.common-modal-notify').modal('show');
                // $('.common-modal-notify .modal-body').html("<i class='fas fa-stroopwafel fa-spin'></i>");
                // $('.common-modal-notify .modal-title').html(data.title);
                // $('.common-modal-notify .modal-body').html(data.msg);
                // window.location.href = "{{ route('report-delivery') }}";
            },
            complete: function() {
                $.unblockUI();
            }
        });
    }

    function allLabelPrintRad(element) {
        var report_id = $('.mulltiple_print_label').map((_, el) => el.value).get();
        var id = '';
        report_id.forEach(element => {
            if ($('#mulltiple_print_label_' + element).is(':checked')) {
                id += element + '_';
            }
        });
        if (!id) {
            return;
        }
        console.log(id);
        var url = "{{ route('delivery.radiology-label-print-all', ':report_data') }}";
        var pdf_url_id = url.replace(':report_data', id);
        window.location.replace(pdf_url_id);
    }

    function allReportPrintPath(element) {
        var report_id = $('.mulltiple_print_path').map((_, el) => el.value).get();
        var report_url = $('.mulltiple_print_path').attr('data-report_route');
        console.log(jQuery.makeArray(report_url));
        var id = '';
        var url = '';
        report_id.forEach(element => {
            if ($('#mulltiple_print_path_' + element).is(':checked') && $('#mulltiple_print_path_' + element)
                .prop(
                    'disabled') == false) {
                id += element + '_';
                url += $('#mulltiple_print_path_' + element).attr('data-report_route') + '_';
            }
        });
        if (!id) {
            return;
        }
        console.log(id);
        console.log(url);
        return;
        var url = "{{ route('delivery.pathology-label-print-all', ':report_data') }}";
        var pdf_url_id = url.replace(':report_data', id);
        window.location.replace(pdf_url_id);
    }

    function allLabelPrintPath(element) {
        var report_id = $('.mulltiple_print_path_label').map((_, el) => el.value).get();
        var id = '';
        report_id.forEach(element => {
            if ($('#mulltiple_print_path_label_' + element).is(':checked')) {
                id += element + '_';
            }
        });
        if (!id) {
            return;
        }
        console.log(id);
        var url = "{{ route('delivery.pathology-label-print-all', ':report_data') }}";
        var pdf_url_id = url.replace(':report_data', id);
        window.location.replace(pdf_url_id);
    }


    function allReportPrintRad(element) {
        var report_id = $('.mulltiple_print').map((_, el) => el.value).get();
        var id = '';
        //         var array = $('.mulltiple_print').map(function(){
        //   return $(this).attr('data-paymentStatus')
        // }).get();
        console.log(report_id);
        report_id.forEach(element => {
            if ($('#mulltiple_print_' + element).is(':checked') && $('#mulltiple_print_' + element).prop(
                    'disabled') == false) {
                id += element + '_';

            }
        });
        if (!id) {
            return;
        }
        console.log(id);

        var url = "{{ route('radiology.rad-report-pdf-all', ':report_data') }}";
        var pdf_url_id = url.replace(':report_data', id);
        window.location.replace(pdf_url_id);
    }
</script>
