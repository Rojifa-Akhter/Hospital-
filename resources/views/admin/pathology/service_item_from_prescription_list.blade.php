<div class="card-body">
    <div class="mt-2">
        <div class="table-responsive border-top border-right">
            <table class="table table-bordered table-hover mb-0 data_table">
                <thead class="bg-light-blue">
                    <tr>
                        <th class="text-center" scope="col">SL</th>
                        <th class="text-left" scope="col">Visit Id</th>
                        <th class="text-left" scope="col">Visit Date</th>
                        <th class="text-left" scope="col">UHID</th>
                        <th class="text-left" scope="col">Patient Name</th>
                        <th class="text-left" scope="col">Consultant Name</th>
                        <th class="text-center" scope="col">Action</th>
                    </tr>
                </thead>                
                <tbody></tbody>
                <tfoot></tfoot>
            </table>
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
    });
    <!-- Fetch Table Data -->
    getData();

    function getData() {
        const type = $('#type').val();
        $.ajax({
            url: "{{ route('service-item-from-prescription.getData') }}",
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
                    emptyTable();
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

    function setTableData(data,type) {
        if($.fn.DataTable.isDataTable('.data_table')) {
            $('.data_table').DataTable().destroy();
        }
        $('.data_table tbody').empty();
        var rows = [];
        var table = $('.data_table').DataTable({
            searching: true,
            columnDefs: [
                    { targets: [0,6], className: 'text-center' },
                    { targets: [1,2,3,4,5], className: 'text-left' }
                ],
                "lengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
                "pageLength": 10
            });
           
        data.forEach(function(item, index) {
            if (type =="MED") {
                var billing_url="{{route('billing.pharmacy-billing-v2',[':code',':id'])}}";
                billing_url=billing_url.replace(':code',item.prescription_uid);
                billing_url=billing_url.replace(':id',item.prescription_no_pk);
                let med_list_url="{{route('prescriped-medicine-list-pdf',[':id'])}}";
                med_list_url=med_list_url.replace(':id',item.prescription_no_pk);
                med_list= `<a href="${med_list_url}" class="btn btn-sm btn-warning" target="_blank" data-id="${med_list_url}" data-type="${item.prescription_no_pk}" id="precribed_med" title="Print medicine list"><i class="fa fa-capsules"></i></a>`;

                
                
            }else{
                var billing_url="{{route('uhl.billing-invoice-form',[':pres_id'])}}";
                var id=item.prescription_no_pk+'-'+item.prescription_uid+'-'+'pres';
                billing_url=billing_url.replace(':pres_id',id);
                // billing_url=billing_url.replace(':pres_code',item.prescription_uid);
                // billing_url=billing_url.replace(':press_code','pres');
            }
            
            console.log(type+'____type')
            // var pres_url="{{route('opd_prescription_print_pdf',':id')}}";
            var pres_url="{{route('prescription_pdf_uhl',':id')}}";
            pres_url=pres_url.replace(':id',item.prescription_no_pk);
            const action_button=`<a href="${pres_url}" class="btn btn-md btn-warning" target="_blank" data-id="${pres_url}" data-type="${item.prescription_uid}" id="prescription_id" title="Print Prescription"><i class="fa fa-prescription"></i></a>`;
            
            const billing=`<a href="${billing_url}" class="btn btn-md btn-info ml-2" data-id="${pres_url}" data-type="${item.prescription_uid}" id="billing" title="billing" target="_blank"><i class="fa fa-money-bill"></i></a>`;
            const pres_date=new Date(item.prescription_date);
            const date=pres_date.getDate();
            const month= pres_date.getMonth() + 1;
            const year = pres_date.getFullYear();
            const set_date=item.prescription_date !=null ? date+'/'+month+'/'+year:'';
            const action=action_button + billing + med_list;
            const rowData = [
                ++index,
                item.prescription_uid,
                set_date,
                item.patient_code,
                item.patient_name,
                item.doctor_name,
                action             
            ];
            rows.push(rowData);
        });
        table.clear();
        table.rows.add(rows);
        table.draw();
    }

    function emptyTable() {
        $('.data_table tbody').empty();
        $('.data_table tbody').append(`
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
