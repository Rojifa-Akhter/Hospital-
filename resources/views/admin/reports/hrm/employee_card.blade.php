<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">

<section id="full_appointment">
  <div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top shadow-sm">
      <div class="col-md-12 mb-1">
        <h5 class="mt-2 mb-0"> Employee Id Card</h5>
        <small>Report / HRM / Employee Id Card</small>
      </div>
    </div>

    <div class="card m-2" style="width: 40%; margin: auto">
      <div class="card-header ">
        <h5> Search</h5>
      </div>

      <div class="card-body ">
        <div class="form-row mt-2">
          <div class="col-md-12 ">
            <form method="post" id="frmSearch" action="{{ route('hrm.employee_id_card_print') }}" data-response-action="">
              @csrf
              <div class="form-group  form-row">
                <input type="hidden" name="id" value="">

                <label for="card_no" class=" col-form-label col-form-label-sm ">Card No</label>
                <div class=" col-md-4 ">
                  <input type="text" class="form-control form-control-sm " id="card_no" name="card_no" value="" placeholder="Cord no" required="required">
                  <input type="hidden" name="hidn_card" id="hidn_card">

                </div>

                <div class="col-md-6">
                  <div class="btn-group btn-block" role="group">
                    <button type="button" class="btn btn-sm btn-success btn-block mt-0" id="btnSearchReport" onclick=""> <i class="fas fa-search"></i> Search</button>
                    <button type='submit' class="btn btn-primary btn-block btn-md mt-0"> Export PDF</button>
                  </div>
                </div>

              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

<div id="search-container">
   @include('admin.reports.hrm.employee_id_card_info')
</div>


</div>

</section>

<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script>
  openDoctorAutocomplete('#card_no','hidn_card');
	$('.date_picker').datepicker({
		format: 'yyyy-mm-dd',
		autoclose: true,
		todayHighlight: true,
		clearBtn: true,
	});
  $('.data-table').DataTable();
	$(document).on("click", "#btnSearchReport", function(e) {
    var formID = $("#frmSearch").attr("id");
    // var formAction = $("#frmSearch").attr("action");
    var formMethod = $("#frmSearch").attr("method");

    $.ajax({
        data: $('#' + formID).serialize(),
        url:"{{ url('hrm/employee_card_search') }}",
        type: formMethod,
        beforeSend: function() {
            blockUI();

        },
        success: function(data) {
            $("#search-container").html(data);
        },
        complete: function() {
            $.unblockUI();
        }
    });
});
</script>
