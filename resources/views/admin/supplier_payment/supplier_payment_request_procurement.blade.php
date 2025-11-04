<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<link href="{{asset('node_modules/datatables/media/css/jquery.dataTables.css')}}" rel="stylesheet">
<link href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}" rel="stylesheet">

<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm align-items-center">
        <div class="col-md-6">
            <h5 class="mt-2 mb-0">Supplier Bill Process Request </h5>
            <small>Supplier Payment / Supplier Bill Process Request</small>
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
                <div class="tab-pane fade active show" id="admitted-patient" role="tabpanel" aria-labelledby="admitted-patient-tab">
                    <div class="card">
                        <div class="card-body">

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
                                    <label class="col-form-label col-form-label-sm" for="date_from">GRN Date <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">From</div>
                                        </div>
                                        <input type="text" class="form-control form-control-sm m-0 date-picker" id="date_from" name="date_from" placeholder="dd-mm-yyyy" autocomplete="off">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">To</div>
                                        </div>
                                        <input type="text" class="form-control form-control-sm m-0 date-picker" id="date_to" name="date_to" placeholder="dd-mm-yyyy" autocomplete="off">
                                    </div>
                                </div>


                                <!-- <div class="form-group col-md-2">
                                    <label class="col-form-label col-form-label-sm" for="requisition_no">Requisition No</label>
                                    <input type="text" class="form-control form-control-sm m-0" id="requisition_no" name="requisition_no" value="" placeholder="Requisition No" autocomplete="off">
                                </div> -->
                                
                                <div class="form-group col-md-2">
                                    <label class="col-form-label col-form-label-sm" for="supplier">Supplier</label>
                                    <select class="form-control form-control-sm m-0 select2" id="supplier" name="supplier">
                                        <option value="">select</option>
                                        @if(!empty($supplier_list))
                                            @foreach($supplier_list as $value)
                                                <option value="{{$value->supplier_no_pk}}">{{$value->supplier_name}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>

                                <div class="form-group col-md-2">
                                    <label class="col-form-label col-form-label-sm" for="grn_no">GRN No</label>
                                    <input type="text" class="form-control form-control-sm m-0" id="grn_no" name="grn_no" value="" placeholder="grn no" autocomplete="off">
                                </div>

                                <!-- <div class="form-group col-md-2">
                                    <label class="col-form-label col-form-label-sm" for="prescription_id">Prescription
                                        ID</label>
                                    <input type="text" class="form-control form-control-sm m-0" id="prescription_id" name="prescription_id" value="" placeholder="Prescription ID" autocomplete="off">
                                </div> -->
                                <div class="col-md-2">
                                    <div class="btn-group btn-block mt-4" role="group">
                                        <button type="button" class="btn btn-md btn-success btn-md-global" id="btnSearch" data-action="">
                                            Search
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <form action="{{route('supplier-payment-request-save')}}" method="post" id="paymentRequest">
            @csrf
            <div class="card-body table-responsive">
                <table width="100%" class="data-table" border="1">
                    <thead>
                        <tr class="global-uhl-table-bg">
                            <th class="text-center" style="width: 30px;">Sl.</th>
                            <th class="text-center" style="width: 100px;">GRN No</th>
                            <th class="text-center" style="width: 100px;">PO No</th>
                            <th class="text-center" style="width: 100px;">Challan No</th>
                            <th>Store</th>
                            <th>Supplier</th>
                            <th class="text-right" style="width: 100px;">Receive Amt</th>
                            <th class="text-right" style="width: 100px;">Return Amt</th>
                            <th class="text-right" style="width: 100px;">Discount amt.</th>
                            <th class="text-right" style="width: 100px;">Vat amt.</th>
                            <th class="text-right" style="width: 100px;">Others LC cost</th>
                            <th class="text-right" style="width: 100px;">Alt amt.</th>
                            <th class="text-right" style="width: 100px;">Current Amt</th>
                            <th class="text-center" style="width: 100px;"><input type="checkbox" id="select_all"> <label for="select_all"> Select All</label> </th>
                        </tr>
                    </thead>
                    <tbody id="supplier_payment">
                        @include('admin.supplier_payment.supplier_payment_request_procurement_list')
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="13" class="text-right" style="background-color: rgb(245, 245, 233);">
                               <strong>Note : </strong>Please check minimum one grn and click on Save button for Payment Request
                            </td>
                            <td colspan="" class="text-right">
                                <!-- @php
                                $url="route('supplier-payment-request-procurement')"
                                @endphp -->
                                <button type="button" id="save_btn" class="btn btn-success btn-md btn-md-global uhl_common_btn">Save</button>

                            </td>
                        </tr>
                    </tfoot>
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

    $('.data-table').DataTable({
        "ordering": false,
        "bAutoWidth": false
    });

    $(".date-picker").datepicker({
        format: 'dd-mm-yyyy',
        todayHighlight: true,
        clearBtn: true,
        autoclose: true
    });

    $(document).ready(function(){
        $('.select2').select2();
    })

    $(document).on("click", "#btnSearch", function(e) {
        var grn_no = $('#grn_no').val();
        var prescription_id = $('#prescription_id').val();
        var requisition_no = $('#requisition_no').val();
        var date_from = $('#date_from').val();
        var date_to = $('#date_to').val();
        var supplier = $('#supplier').val();
        
        if (date_from == '') {
            alert("Select Date");
            return false;
        }

        $.ajax({
            data: {
                grn_no: grn_no,
                prescription_id: prescription_id,
                requisition_no: requisition_no,
                date_from: date_from,
                supplier:supplier,
                date_to: date_to
            },
            url: "{{ route('supplier-payment-request-procurement-search') }}",
            type: 'post',
            beforeSend: function() {
                blockUI();
            },
            success: function(data) {
                $('.data-table').DataTable().destroy();
                $("#supplier_payment").html(data);
                $('.data-table').DataTable({
                    "ordering": false,
                    "bAutoWidth": false
                });
            },
            complete: function() {
                $.unblockUI();
            }
        });
    });

    $('#select_all').change(function() {
        if ($(this).prop('checked')) {
            $('.payment_select').prop('checked', true)
        } else {
            $('.payment_select').prop('checked', false)
        }
    })

    $('#save_btn').click(function() {
        var check_ind = 0;
        $('.payment_select').each(function() {
            if ($(this).prop('checked')) {
                check_ind = 1;
            }
        })
        if (check_ind == 1) {
            btnSaveUpdate($('#save_btn'), '', '', '', '', search_list);
            // btnSaveUpdate($('#save_btn'), '', '', '', '', dynamicFunc.afterSaveLoadPage, "{{route('supplier-payment-request-procurement')}}");
        } else {
            alert("Check At lest 1 Item")
        }
    })
    function search_list(params) {
        $('#btnSearch').click();
    }
</script>