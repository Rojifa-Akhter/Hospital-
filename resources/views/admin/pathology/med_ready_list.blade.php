<div class="card">
    <div class="card-header">
         Ready For Delivery
    </div>
    <div class="card-body">
    <div class="mt-2">
        <div class="table-responsive border-top border-right">
            <table class="table table-bordered table-hover mb-0 data_table_2">
                <thead class="bg-light-blue">
                    <tr>
                        <th class="text-center" scope="col">SL</th>
                        <th class="text-center" scope="col">Queue</th>
                        <th class="text-left" scope="col">Prescription ID</th>
                        <th class="text-left" scope="col">Invoice No</th>
                        <th class="text-left" scope="col">Invoice Date</th>
                        <th class="text-left" scope="col">UHID</th>
                        <th class="text-left" scope="col">Patient Name</th>
                        <th class="text-center"  style="width: 155.094px !important;">Action</th>
                    </tr>
                </thead>                
                <tbody id="tbody_2"></tbody>
                <tfoot></tfoot>
            </table>
        </div>
    </div>
</div>
</div>


<script>
    $(document).on('change', '#pat_type', function() {
        var selectedValue = $('#pat_type').find(":selected").text();
        $('.updatedHeader').text(selectedValue)
        $('#type').val(selectedValue)
    });

    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
  
    <!-- Fetch Table Data -->
    getData();
});
    function getData() {
        const type = $('#type').val();
        $.ajax({
            url: "{{ route('med-item-from-prescription-ready.getData') }}",
            method: "POST",
            data :{type:type},
            beforeSend: function() {
                blockUI();
            },
            success: function(response) {
                console.log(response.type);
                if(response.data.length != 0) {
                    setTableData(response.data, response.type);
                }
                else {
                    emptyTableV2();
                }
            },
            error:function(err) {
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
  
    function saveDelivery(element) {
        const invoice_no = $(element).data('invoice');
        // const counter_no = $(element).parents('tr').find('#counter_no').val();
        // const counter_name = $(element).parents('tr').find('#counter_no').text();
        // if (counter_no =="") {
        //     alert("Select Counter Name.");
        //     return false;
        // }
        
        if (confirm('Will it be delivered?')) {
            $.ajax({
                url: "{{ route('med-item-delivery-done') }}",
                method: "POST",
                data :{
                    invoice_no:invoice_no,
                  

                },
                beforeSend: function() {
                    blockUI();
                },
                success: function(response) {               
                    $(".common-modal-notify").modal("show");
                    $(".common-modal-notify .modal-body").html("<i class='fas fa-stroopwafel fa-spin'></i>");
                    $(".common-modal-notify .modal-title").html(response.title);
                    $(".common-modal-notify .modal-body").html(response.msg);            
                
                },
                error:function(err) {
                    var error = err.responseJSON;
                    $('.common-modal-notify-error').modal('show');
                    $('.common-modal-notify-error .modal-title').html('Failed');
                    $('.common-modal-notify-error .modal-body').html(error.message);
                },
                complete: function() {
                  
                    getData();
                    $.unblockUI();
                }
            });
        }
       
    }
    function setTableData(data,type) {
        if($.fn.DataTable.isDataTable('.data_table_2')) {
            $('.data_table_2').DataTable().destroy();
        }
        $('.data_table_2 #tbody_2').empty();
        var rows = [];
        var table = $('.data_table_2').DataTable({
            searching: true,
            bLengthChange: false,
            columnDefs: [
                    { targets: [0,1,6], className: 'text-center' },
                    { targets: [2,3,4,5], className: 'text-left' }
                ],
                "lengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
                "pageLength": 10
            });
           
        data.forEach(function(item, index) {

            // let counter_no_data=`<select id="counter_no" name="counter_no"><option value=""></option>`;
            //     $.each(counter_no, function(index, value) {
            //         counter_no_data +=`<option value="${index}">${value}</option>`;
            //     });
            //     counter_no_data +=`</select>`;
            console.log(item)
            var billing_url="{{route('pos-due-invoice-print-v2',[':invoice',':trn'])}}";
                billing_url=billing_url.replace(':invoice',item.invoice_no_fk);
                billing_url=billing_url.replace(':trn',item.ledgertrn_no_fk);

                var dose_url="{{route('dose-print',[':invoice',':prescription_id'])}}";
                    dose_url=dose_url.replace(':invoice',item.invoice_no_fk);
                    dose_url=dose_url.replace(':prescription_id',item.prescription_no_pk);
            console.log(type+'____type')
            // var pres_url="{{route('opd_prescription_print_pdf',':id')}}";
            var pres_url="{{route('prescription_pdf_uhl',':id')}}";
            pres_url=pres_url.replace(':id',item.prescription_no_pk);

             let med_list_url="{{route('prescriped-medicine-list-pdf',[':id'])}}";
                med_list_url=med_list_url.replace(':id',item.prescription_no_pk);
                med_list= `<a href="${med_list_url}" class="btn btn-sm btn-warning" target="_blank" data-id="${med_list_url}" data-type="${item.prescription_no_pk}" id="precribed_med" title="Print medicine list"><i class="fa fa-capsules"></i></a>`;

            const action_button=`
            <a href="${med_list_url}" class="btn btn-sm btn-warning" target="_blank" data-id="${med_list_url}" data-type="${item.prescription_uid}" id="precribed_med" title="Print medicine list"><i class="fa fa-capsules"></i></a>
             <a href="${billing_url}" target="_blank" class="btn btn-sm btn-warning " title="invoice"><i class="fa fa-file-invoice"></i></a>
            <a href="${dose_url}" target="_blank" class="btn btn-sm btn-warning " title="dose"><i class="fas fa-pills"></i></a>
             <span  class="btn btn-sm btn-info" onclick="saveDelivery(this)" data-invoice="${item.invoice_no_fk}" title="Delivery"><i class="fa fa-shipping-fast"></i></span>`;
            
            const billing=`<a href="${billing_url}" class="btn btn-md btn-info ml-2" data-id="${pres_url}" data-type="${item.prescription_uid}" id="billing" title="billing" target="_blank">Billing</a>`;
            const pres_date=new Date(item.tran_date);
            const date=pres_date.getDate();
            const month= pres_date.getMonth() + 1;
            const year = pres_date.getFullYear();
            const set_date=item.tran_date !=null ? date+'/'+month+'/'+year:'';
            const action=action_button ;
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
    }

    function emptyTableV2() {
        $('.data_table_2 #tbody_2').empty();
        $('.data_table_2 #tbody_2').append(`
            <tr>
                <td colspan="13" class="text-danger text-center">Data Not Found</td>
            </tr>
        `);
    }

    function formatDate(date)
    {
        let formattedDate = new Date(date);
        return formattedDate.toLocaleString('en-GB', { hour12: true });

    }
</script>
