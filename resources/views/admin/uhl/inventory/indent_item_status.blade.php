<main id="page-content">
    <link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
    <link rel="stylesheet" href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}">
    <link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
    <link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
    <form action="#" method="post" target="_blank" id="indent_to_grn">
        @csrf
        <input type="hidden" name="print_type" id="print_type" value="">
        <input type="hidden" value="{{ $requisition_no }}" name="requisition_no">

        <section class="indent_worklist">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row bg-white border-bottom sticky-top shadow-sm">
                            <div class="col-md-7">
                                <h5 class="mt-2 mb-0">Item Tracking</h5>
                                <small>Inventory/ Store / Item Tracking</small>
                            </div>

                            <!-- <div class="col-lg-5 col-md-5 col-12 mt-2">
                                <div class="text-right">
                                    <a rel="tab" href="{{ route('v1.indent-receive-worklist') }}"
                                        class="btn btn-success uhl_common_outline_btn"><i
                                            class="fa fa-plus"></i>&nbsp;Pending List</a>
                                </div>
                            </div> -->
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="form-row">
                                    <div class="col-12 col-sm-6 col-md-2 col-lg-2">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="inlineRadioOptions"
                                                id="inlineRadio1" value="INDENT" checked>
                                            <label class="form-check-label" for="inlineRadio1">Indent</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="inlineRadioOptions"
                                                id="inlineRadio2" value="PR">
                                            <label class="form-check-label" for="inlineRadio2">PR</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="inlineRadioOptions"
                                                id="inlineRadio3" value="PO">
                                            <label class="form-check-label" for="inlineRadio3">PO</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="inlineRadioOptions"
                                                id="inlineRadio4" value="GRN">
                                            <label class="form-check-label" for="inlineRadio4">GRN</label>
                                        </div>                                        
                                        {{-- <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="inlineRadioOptions"
                                                id="inlineRadio5" value="ALL">
                                            <label class="form-check-label" for="inlineRadio5">ALL</label>
                                        </div> --}}
                                    </div>

                                    <div class="col-md-1">
                                        <input type="text" class="form-control" placeholder="Id No" id="trns_id"
                                            name="trns_id" value="" />
                                    </div>

                                    <div class="col-md-3">
                                        <input type="text" class="form-control " placeholder="Item Name"
                                            id="item_name" name="item_name" value="" />
                                        <input type="hidden" class="form-control" placeholder="Search"
                                            id="item_id_hidden" name="item_id_hidden" value="" />

                                    </div>
                                    <div class="col-md-4">
                                    {{-- <div class="input-group">
                                         <div class="input-group-prepend">
                                             <div class="input-group-text">From</div>
                                         </div>
                                         <input type="text"
                                             class="form-control form-control-sm m-0 date_picker"
                                             id="indent_date_from" name="indent_date_from"
                                             value="" placeholder="dd-mm-yyyy" autocomplete="off"/>
                                         <div class="input-group-prepend">
                                             <div class="input-group-text">To</div>
                                         </div>
                                         <input type="text"
                                             class="form-control form-control-sm m-0 date_picker"
                                             id="indent_date_to" name="indent_date_to"
                                             value="" placeholder="dd-mm-yyyy" autocomplete="off" />
                                     </div> --}}

                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-md btn-success btn-md-global"
                                            id="btnSearch"><i class="fa fa-search"></i> &nbsp;Search</button>

                                            <button type="button" class="btn btn-md btn-secondary btn-md-global" 
                                             onclick="indentToGrn('excel')"
                                            id=""><i class='fa fa-file-excel fa-4x'></i> &nbsp;Excel</button>
                                    </div>
                                    <!-- <div class="col-md-1">
                                        <button type="button" class="btn btn-md btn-secondary"
                                            id="btnSearch"><i class='fa fa-file-excel fa-4x'></i>Excel</button>
                                    </div> -->
                                    {{-- <div class="col-md-1">
                                        <button type="reset" class="btn btn-md btn-success btn-md-global" id="reset"><i class="fa fa-reset"></i>Reset</button>
                                    </div> --}}
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover table-striped data-table">
                                        <thead class="global-uhl-table-bg">
                                            <tr>
                                                <th colspan="10" class="bg-primary">INDENT</th>
                                                <th colspan="4" class="bg-success">PR</th>
                                                <th colspan="5" class="bg-secondary">PO</th>
                                                <th colspan="4" class="bg-warning">GRN</th>
                                            </tr>
                                            <tr>
                                                <th>SL</th>
                                                <th class="text-left">Indent No</th>
                                                <th class="text-left">Date No</th>
                                                <th class="text-left">Item Name</th>
                                                {{-- <th class="text-right">Last Price</th> --}}
                                                <!-- <th>Remarks</th>
                                                <th>ROL</th>
                                                <th>Delivery Info</th>
                                                <th>Generic Stock</th>
                                                <th>Cons. From Store</th>
                                                <th>Cons. Current Store</th>
                                                <th>Stock From Store</th>
                                                <th>Current Stock</th> -->
                                                <th>Indent Qty</th>
                                                <th>Issued Qty</th>
                                                <th>Received Qty</th>
                                                <th>Pending Rcv.Qty</th>
                                                <th>Status</th>
                                                <th>Indent Approval</th>
                                                <th>PR No</th>
                                                <th>PR Item Name</th>
                                                <th>PR Qty</th>
                                                <th>PR Approval</th>
                                                <th>PO No</th>
                                                <th>PO Item Name</th>
                                                <th>PO Date</th>
                                                <th>PO Qty</th>
                                                <th>PO Approval</th>
                                                <th>GRN No</th>
                                                <th>GRN Item Name</th>
                                                <th>GRN Date</th>
                                                <th>GRN Qty </th>
                                                <!-- <th>Receive Qty</th> -->

                                            </tr>

                                        </thead>
                                        <tbody id="track_list">
                                            @include('admin.uhl.inventory.indent_item_status_list')
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </form>
</main>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>

<script>
    
    function indentToGrn() {

            var type = 'excel';
            var id =    $('input[name="inlineRadioOptions"]:checked').val();
            var item_id = $('#item_id_hidden').val();
            var item_name = document.getElementById("trns_id").value;
            var trns_id = document.getElementById("item_name").value;
            var from_date = document.getElementById("indent_date_from").value;
            var to_date = $("#indent_date_to").val();

            if(type == 'excel'){
                var url = "{{ route('v1.indent-to-grn-report-download') }}";
            }
            else if(type == 'pdf'){
                var url = '';
            }

            $.ajax({
                url: url,
                method: 'post',
                data:{id:id,item_id:item_id,item_name:item_name,trns_id:trns_id,from_date:from_date,to_date:to_date, print_type:type},
                xhrFields: {
                    responseType: 'blob' 
                },
                success: function(data) {
                    var downloadLink = document.createElement('a');
                    var url = window.URL.createObjectURL(new Blob([data]));
                    downloadLink.href = url;
                    if(type == 'excel')
                        downloadLink.setAttribute('download', 'indent_to_grn_report.xls');

                    else if(type == 'pdf')                     
                        downloadLink.setAttribute('download', 'trial_balance_report.pdf');
                    document.body.appendChild(downloadLink);
                    downloadLink.click();
                    document.body.removeChild(downloadLink);
                    window.URL.revokeObjectURL(url);
                },
                error: function(xhr, status, error) {
                    $('.common-modal-notify-error').modal('show');
                    $('.common-modal-notify-error .modal-title').html('Failed');
                    $('.common-modal-notify-error .modal-body').html(error);
                }
            });
     
    }
</script>
<script>
    var table = $('.data-table').DataTable({
        "ordering": false,
        "bPaginate": true,
        "bLengthChange": true,
        "bAutoWidth": false
    });
    $(".date_picker").datepicker({
        format: 'dd-mm-yyyy',
        todayHighlight: true,
        clearBtn: true,
        autoclose: true,
    })
    $("body").addClass("sidebar-collapse");
    openReceiveItemAutocomplete('#item_name', 'INV,MED,SUR,SERVICE,CAFE,COFFEE,INJ,OPTICAL,FOOD,KIT,CONSUM', 'item_name', function(item, obj) {
        $('#item_id_hidden').val(item.item_id);
        obj.stopImmediatePropagation();

    });

    $('body').on('click', '#btnSearch', function() {

        if ($('#trns_id').val() == '' && $('#item_name').val()=='') {
            alert ('Enter Value');
            return false;
        }
        $.ajax({
            async: true,
            data: {
                _token: "{{ csrf_token() }}",
                module_code: $('#module_code').val(),
                id: $('input[name="inlineRadioOptions"]:checked').val(),
                item_id: $('#item_id_hidden').val(),
                item_name: $('#item_name').val(),
                trns_id: $('#trns_id').val(),
                from_date: $('#indent_date_from').val(),
                to_date: $('#indent_date_to').val()
            },
            dataType: "html",
            url: "{{ route('v1.indent-item-status-search') }}",
            type: 'post',
            beforeSend: function() {
                $('.data-table').DataTable().destroy();
                blockUI();
            },
            success: function(data) {
                console.log(data);


                $('.data-table').DataTable({
                    "ordering": false,
                    "bPaginate": false,
                    "bLengthChange": false,
                    "bAutoWidth": false
                });
                $('#track_list').html(data);

            },
            complete: function() {
                $.unblockUI();

            }
        });
    });
</script>
