<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<link href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}" rel="stylesheet">
<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">

<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm align-items-center">
        <div class="col-md-6">
            <h5 class="mt-2 mb-0">Accounts Approval</h5>
            <small>Supplier Payment / Accounts Approval</small>
        </div>
        <!-- <div class="col-md-6 text-right">
            <div id="top-action" class="mt-0">
                <a class="btn btn-outline-primary btn-md uhl_common_outline_btn" rel="tab" href="{{ route('ipd.quick-admission') }}"><i
                        class="fa fa-plus"></i> Quick Admission</a>
            </div>
        </div> -->
    </div>

    <div class="form-row">
        <div class="col-md-12 mt-2">
            <div class="tab-content p-" id="myTabContent">
                <div class="tab-pane fade active show" id="admitted-patient" role="tabpanel"
                    aria-labelledby="admitted-patient-tab">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{route('supplier-payment-sent-to-accounts-all-pdf')}}" method="post" id="print_data" target="_blank">
                                @csrf
                                <div class="form-row justify-content-center">
                                    <!-- <div class="form-group col-md-2">
                                            <label class="col-form-label col-form-label-sm" for="service_id">Patient
                                                ID</label>
                                            <input type="hidden" id="hdn_patient_id" name="hdn_patient_id" />
                                            <input type="text" class="form-control form-control-sm m-0 mb-0"
                                                id="service_number" name="service_number" value=""
                                                placeholder="Patient ID" />
                                        </div> -->
                                    <div class="form-group col-md-4">
                                        <label class="col-form-label col-form-label-sm" for="date_from"> Date <span
                                                class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">From</div>
                                            </div>
                                            <input type="text" class="form-control form-control-sm m-0 date-picker"
                                                id="date_from" name="date_from" value="" placeholder="dd-mm-yyyy"
                                                autocomplete="off">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">To</div>
                                            </div>
                                            <input type="text" class="form-control form-control-sm m-0 date-picker"
                                                id="date_to" name="date_to" value="" placeholder="dd-mm-yyyy"
                                                autocomplete="off">
                                        </div>
                                    </div>


                                    <div class="form-group col-md-2">
                                        <label class="col-form-label col-form-label-sm" for="grn_no">GRN No</label>
                                        <input type="text" class="form-control form-control-sm m-0" id="grn_no"
                                            name="grn_no" value="" placeholder="grn no" autocomplete="off">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label class="col-form-label col-form-label-sm"
                                            for="department">Department</label>
                                        <select class="form-control form-control-sm m-0" id="department"
                                            name="department">
                                            <option value="">select</option>
                                            @if (!empty($main_store_list))
                                                @foreach ($main_store_list as $value)
                                                    <option value="{{ $value->serviceunit_no_pk }}">
                                                        {{ $value->serviceunit_name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label class="col-form-label col-form-label-sm" for="supplier">Supplier</label>
                                        <select class="form-control form-control-sm m-0 select2" id="supplier"
                                            name="supplier">
                                            <option value="">select</option>
                                            @if (!empty($supplier_list))
                                                @foreach ($supplier_list as $value)
                                                    <option value="{{ $value->supplier_no_pk }}">
                                                        {{ $value->supplier_name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <!-- <div class="form-group col-md-2">
                                        <label class="col-form-label col-form-label-sm" for="status">Status</label>
                                        <select class="form-control form-control-sm m-0" id="status" name="status">
                                            <option value="">select</option>
                                            <option value="1">Received</option>
                                            <option value="2">Pending</option>
                                        </select>
                                    </div> -->
                                    <!-- <div class="form-group col-md-2">
                                        <label class="col-form-label col-form-label-sm" for="prescription_id">Prescription
                                            ID</label>
                                        <input type="text" class="form-control form-control-sm m-0" id="prescription_id" name="prescription_id" value="" placeholder="Prescription ID" autocomplete="off">
                                    </div> -->
                                    <div class="col-md-2">
                                        <div class="btn-group btn-block mt-4" role="group">
                                            <button type="button" class="btn btn-md btn-success btn-md-global"
                                                id="search_approval_from_account1" data-action="">
                                                Search
                                            </button>
                                            <button type="submit" class="btn btn-md btn-warning btn-md-global"
                                                id="search_approval_from_account1" data-action="">
                                                <i class="fa fa-file"></i> Print
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <form action="{{ route('supplier-payment-accounts-save') }}" method="post" id="paymentRequest">
            @csrf
            <div class="card-body table-responsive">
                <table width="100%" class="data-table" border="1">
                    <thead>
                        <tr class="global-uhl-table-bg">
                            <th class="text-center" style="width: 30px;">Sl.</th>
                            <th class="text-center" style="width: 100px;">Bill Process No / Date</th>
                            <th class="text-center" style="width: 100px;">GRN No</th>
                            <th class="text-center" style="width: 100px;">PO No</th>
                            <th class="text-center" style="width: 100px;">Challan No</th>
                            <th>Store</th>
                            <th>Supplier</th>
                            <th class="text-right" style="width: 100px;">Receive Amt</th>
                            <th class="text-right" style="width: 100px;">Return Amt</th>
                            <th class="text-right" style="width: 100px;">Current Amt</th>
                            <th class="text-center" style="width: 140px;">Status </th>
                        </tr>
                    </thead>
                    <tbody id="btnSearchAccounts1">
                        @include('admin.supplier_payment.supplier_payment_send_to_accounts1_list')
                    </tbody>
                </table>

            </div>
        </form>
    </div>

</div>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="application/javascript" src="{{asset('node_modules/datatables/media/js/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>

<script>
   $(function() {
  const today = new Date();
  const priorDate = new Date();
  priorDate.setDate(today.getDate() - 30);

  function formatDate(date) {
      let d = date.getDate();
      let m = date.getMonth() + 1;
      let y = date.getFullYear();

      d = d < 10 ? '0' + d : d;
      m = m < 10 ? '0' + m : m;

      return d + '-' + m + '-' + y;
  }

  $('#date_from').datepicker({
    dateFormat: 'dd-mm-yy'
  }).datepicker("setDate", priorDate);

  $('#date_to').datepicker({
    dateFormat: 'dd-mm-yy'
  }).datepicker("setDate", today);
});
</script>

<script>
    $("body").addClass("sidebar-collapse");
    $('.select2').select2();
    $('.data-table').DataTable({
        "ordering": false,
        "bAutoWidth": false,
        "paging": false,
        "searching": false,
    });
    $(".date-picker").datepicker({
        format: 'dd-mm-yyyy',
        todayHighlight: true,
        clearBtn: true,
        autoclose: true
    });

    $(document).on("click", "#search_approval_from_account1", function(e) {
        var grn_no = $('#grn_no').val();
        var status = $('#status').val();
        var department = $('#department').val();
        var supplier = $('#supplier').val();
        var requisition_no = $('#requisition_no').val();
        var date_from = $('#date_from').val();
        var date_to = $('#date_to').val();
        if (date_from == '') {
            alert("Select Date");
            return false;
        }
        $.ajax({
            data: {
                grn_no: grn_no,
                status: status,
                requisition_no: requisition_no,
                date_from: date_from,
                date_to: date_to,
                department: department,
                supplier: supplier,
            },
            url: "{{ route('supplier-payment-sent-to-accounts-list-search') }}",
            type: 'post',
            beforeSend: function() {
                blockUI();
            },
            success: function(data) {
                $("#btnSearchAccounts1").html(data);
            },
            complete: function() {
                $.unblockUI();
            }
        });
    });
</script>
