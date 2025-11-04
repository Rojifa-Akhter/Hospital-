<link rel="stylesheet" href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<style>
    .sorting {
        background-image: none !important;
    }
</style>

<section id="report_section">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-12 mb-1">
                <h5 class="mt-2 mb-0"> Medicine Dispense  List</h5>
                <small>Medicine Dispense List</small>
            </div>
        </div>
        {{-- <div class="card">
            <div class="card-header ">
                <h5><i class="fa fa-search"></i> Search Panel</h5>
            </div>
            <div class="card-body pt-2 bg-light">
                <div class=" justify-content-center">
                    <form id="medSearch" method="POST" target="_blank" 
                        action="{{ route('laboratoryLifeCycle.filter') }}">
                        @csrf
                        <div class="form-group row">
                           
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="prescription_id" class=" col-form-label col-form-label-sm">Prescription ID</label>
                                    <input type="text" class="form-control form-control-sm m-0" id="prescription_id"
                                        name="prescription_id"  value="" placeholder="Enter Prescription ID" />                             
                                </div>
                            </div>

                           
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="patient_id" class=" col-form-label col-form-label-sm">UHID</label>
                                    <input type="text" class="form-control form-control-sm m-0" id="patient_id"
                                        name="patient_id"  value="" placeholder="Enter UHID" />

                                        <input type="hidden" name="hdn_patient_id" id="hdn_patient_id">
                                <div>
                                    <strong>
                                        <p id="autocomplete_data"></p>
                                    </strong></div>
                                </div>
                            </div>                         

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="col-form-label col-form-label-sm" for="search_date_from">Date</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">From</div>
                                        </div>
                                        <input type="text" class="form-control form-control-sm m-0 date_picker"
                                            id="search_date_from" name="search_date_from" 
                                          
                                            placeholder="dd/mm/yyyy" autocomplete="off" >
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">To</div>
                                        </div>
                                        <input type="text" class="form-control form-control-sm m-0 date_picker"
                                            id="search_date_to" name="search_date_to" 
                                            
                                            placeholder="dd/mm/yyyy" autocomplete="off" >
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="type" id="type" value="{{$type}}">

                            <div class="col-md-2">
                                <button type="button" id="btnSearchReport"
                                    class="btn btn-md btn-success mt-4">Search</button>
                                <button type="button" id="btnReset"
                                    class="btn btn-md btn-info mt-4">Reset</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div> --}}
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" onclick="getReadyData()" href="#home">Billed & Ready Medicine</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" onclick="getDeliveredData()" href="#menu1">Delivered Medicine</a>
            </li>
        </ul>

     <!-- Tab panes -->
     <div class="tab-content">
        <div id="home" class=" tab-pane active">
            <div class="form-row">
                <div class="col-md-6" id="med_billing_list">                    
                    @include('admin.pathology.med_billing_list') 
                </div>
                <div class="col-md-6 " id="med_ready_list">                   
                    @include('admin.pathology.med_ready_list')                     
                </div>
            </div>
        </div>
        <div id="menu1" class=" tab-pane fade">
            <div id="med_delivered_list">
                @include('admin.pathology.med_delivered_list')  
            </div>
        </div>
    </div>      
       
    </div>
</section>

<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="text/javascript">
    // openDoctorAutocomplete('#primary_doctor', 'doctor_id');
    openPatientAutocomplete('#patient_id', 'patient_name');

    $("body").addClass("sidebar-collapse");
    $(document).on('click', '.patClass', function() {
        $("input[type=text]").attr('disabled', false);
    });

    $(function() {
        $('.date_picker').datepicker({
            todayHighlight: true,
            clearBtn: true,
            autoclose: true,
            endDate: '+0d',
            'format': 'dd/mm/yyyy'
        });
    });

  

    $("#btnReset").on('click', function() {
        const form = $("#medSearch");
        form.trigger("reset");

        getData();
    });

    function getReadyData(){
        getDataV2();
        getData();
    }
    function getDeliveredData() {
        const type = $('#type').val();
        $.ajax({
            url: "{{ route('med-item-delivered') }}",
            method: "POST",
            data :{type:type},
            beforeSend: function() {
                blockUI();
            },
            success: function(response) {
                console.log(response.type);
                if(response.data.length != 0) {
                    setTableDeliveredData(response.data, response.type);
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
   
    function setTableDeliveredData(data,type) {
        if($.fn.DataTable.isDataTable('.data_table_3')) {
            $('.data_table_3').DataTable().destroy();
        }
        $('.data_table_3 #tbody_3').empty();
        var rows = [];
        var table = $('.data_table_3').DataTable({
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
            var billing_url="{{route('pos-due-invoice-print-v2',[':invoice',':trn'])}}";
                billing_url=billing_url.replace(':invoice',item.invoice_no_fk);
                billing_url=billing_url.replace(':trn',item.ledgertrn_no_fk);              
            console.log(type+'____type')
            // var pres_url="{{route('opd_prescription_print_pdf',':id')}}";
            var pres_url="{{route('prescription_pdf_uhl',':id')}}";
                pres_url=pres_url.replace(':id',item.prescription_no_pk);

            var pres_medicine_list="{{route('prescriped-medicine-list-pdf',[':pres'])}}";
                pres_medicine_list=pres_medicine_list.replace(':pres',item.prescription_no_pk);


            const action_button=`<a href="${pres_medicine_list}" class="btn btn-sm btn-warning" target="_blank" data-id="${pres_medicine_list}" data-type="${item.prescription_uid}" id="precribed_med" title="Print medicine list"><i class="fa fa-capsules"></i></a> <a href="${billing_url}" target="_blank" class="btn btn-sm btn-warning " title="invoice"><i class="fa fa-file-invoice"></i></a>`;
            
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

    function emptyDeliveredTableV2() {
        $('.data_table_3 #tbody_3').empty();
        $('.data_table_3 #tbody_3').append(`
            <tr>
                <td colspan="13" class="text-danger text-center">Data Not Found</td>
            </tr>
        `);
    }
</script>
