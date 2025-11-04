<div class="card">
    <div class="card-header">
        <div class=" justify-content-center">
            <form id="medSearch" method="POST" target="_blank" action="{{ route('laboratoryLifeCycle.filter') }}">
                @csrf
                <div class="form-group row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="col-form-label col-form-label-sm" for="search_date_from">Date</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">From</div>
                                </div>
                                <input type="text" class="form-control form-control-sm m-0 date_picker" id="search_date_from" name="search_date_from" placeholder="dd/mm/yyyy" autocomplete="off">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">To</div>
                                </div>
                                <input type="text" class="form-control form-control-sm m-0 date_picker" id="search_date_to" name="search_date_to" placeholder="dd/mm/yyyy" autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="type" id="type" value="{{$type}}">

                    <div class="col-md-2">
                        <button type="button" id="btnSearchReport" class="btn btn-md btn-success mt-4">Search</button>
                        <button type="button" id="btnReset" class="btn btn-md btn-info mt-4">Reset</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="card-body">
        <div class="mt-2">
            <div class="table-responsive border-top border-right">
                <table class="table table-bordered table-hover mb-0 data_table_3">
                    <thead class="bg-light-blue">
                        <tr>
                            <th class="text-center" scope="col">SL</th>
                            <th class="text-center" scope="col">Queue</th>
                            <th class="text-left" scope="col">Prescription ID</th>
                            <th class="text-left" scope="col">Invoice No</th>
                            <th class="text-left" scope="col">Invoice Date</th>
                            <th class="text-left" scope="col">UHID</th>
                            <th class="text-left" scope="col">Patient Name</th>
                            <th class="text-center" style="width: 79px;">Action</th>
                        </tr>
                    </thead>
                    <tbody id="tbody_3"></tbody>
                    <tfoot></tfoot>
                </table>
            </div>
        </div>
    </div>
</div>


<script>
    // $(document).on('change', '#pat_type', function() {
    //     var selectedValue = $('#pat_type').find(":selected").text();
    //     $('.updatedHeader').text(selectedValue)
    //     $('#type').val(selectedValue)
    // });
    $(document).on("click", "#btnSearchReport", function(e) {
        var formID = $("#medSearch").attr("id");
        var formMethod = $("#medSearch").attr("method");

        $("#medSearch").attr('action', "{{ route('med-item-search') }}");
        $.ajax({
            data: $('#' + formID).serialize(),
            url: "{{ route('med-item-search') }}",
            type: formMethod,
            beforeSend: function() {
                blockUI();
            },
            success: function(response) {
                if ($.fn.DataTable.isDataTable('.data_table_3')) {
                    $('.data_table_3').DataTable().destroy();
                }
                $('.data_table_3 #tbody_3').empty();
                var rows = [];
                var table = $('.data_table_3').DataTable({
                    searching: true,
                    bLengthChange: false,
                    columnDefs: [{
                            targets: [0, 1, 6],
                            className: 'text-center'
                        },
                        {
                            targets: [2, 3, 4, 5],
                            className: 'text-left'
                        }
                    ],
                    "lengthMenu": [
                        [5, 10, 25, 50, 75, 100, -1],
                        [5, 10, 25, 50, 75, 100, "All"]
                    ],
                    "pageLength": 10
                });
                var data = response.data;
                console.log(data)
                data.forEach(function(item, index) {
                    var billing_url = "{{route('pos-due-invoice-print-v2',[':invoice',':trn'])}}";
                    billing_url = billing_url.replace(':invoice', item.invoice_no_fk);
                    billing_url = billing_url.replace(':trn', item.ledgertrn_no_fk);
                    console.log(type + '____type')
                    // var pres_url="{{route('opd_prescription_print_pdf',':id')}}";
                    var pres_url = "{{route('prescription_pdf_uhl',':id')}}";
                    pres_url = pres_url.replace(':id', item.prescription_no_pk);

                     var pres_medicine_list="{{route('prescriped-medicine-list-pdf',[':pres'])}}";
                        pres_medicine_list=pres_medicine_list.replace(':pres',item.prescription_no_pk);



                    //     const action_button = `<a href="${pres_url}" class="btn btn-sm btn-warning" target="_blank" data-id="${pres_url}" data-type="${item.prescription_uid}" id="prescription_id" title="Print Prescription"><i class="fa fa-prescription"></i></a> <a href="${pres_medicine_list}" class="btn btn-sm btn-warning" target="_blank" data-id="${pres_medicine_list}" data-type="${item.prescription_uid}" id="precribed_med" title="Print medicine list"><i class="fa fa-capsules"></i></a>
                    // <a href="${billing_url}" target="_blank" class="btn btn-sm btn-warning " title="invoice"><i class="fa fa-file-invoice"></i></a>`;


                    const action_button = ` <a href="${pres_medicine_list}" class="btn btn-sm btn-warning" target="_blank" data-id="${pres_medicine_list}" data-type="${item.prescription_uid}" id="precribed_med" title="Print medicine list"><i class="fa fa-capsules"></i></a>
                    <a href="${billing_url}" target="_blank" class="btn btn-sm btn-warning " title="invoice"><i class="fa fa-file-invoice"></i></a>`;

                    const billing = `<a href="${billing_url}" class="btn btn-md btn-info ml-2" data-id="${pres_url}" data-type="${item.prescription_uid}" id="billing" title="billing" target="_blank">Billing</a>`;
                    const pres_date = new Date(item.tran_date);
                    const date = pres_date.getDate();
                    const month = pres_date.getMonth() + 1;
                    const year = pres_date.getFullYear();
                    const set_date = item.tran_date != null ? date + '/' + month + '/' + year : '';
                    const action = action_button;
                    const rowData = [
                        ++index,
                        item.sl_no,
                        item.prescription_uid,
                        item.invoice_no_fk,
                        set_date,
                        item.patient_code,
                        item.patient_name,
                        action
                    ];
                    rows.push(rowData);
                });
                table.clear();
                table.rows.add(rows);
                table.draw();
            },
            complete: function() {
                $.unblockUI();
            }
        });
    });
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });  
    });


    function formatDate(date) {
        let formattedDate = new Date(date);
        return formattedDate.toLocaleString('en-GB', {
            hour12: true
        });

    }
</script>