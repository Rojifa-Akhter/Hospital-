<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<main id="page-content">
<section class="matrix">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div
                    class="row bg-white border-bottom sticky-top shadow-sm">
                    <div class="col-md-12">
                        <h5 class="mt-2 mb-0">My Approval</h5>
                        <small>Settings /My Approval</small>
                    </div>

                </div>
            </div>
        </div>
        <div class="card mt-2" style="width: 100%; margin: auto">
            <div class="card-header ">
                <h5> Search</h5>
            </div>
            <div class="card-body ">
                <div class="form-row mt-2 mb-4">
                    <div class="col-md-12">
                        <form  method="post"  data-response-action="" action=""  target="_blank" id="frmSearch">
                            @csrf
                            <div class="form-row">
                                <input type="hidden" name="id" value="">
                                <div class="col-md-3">
                                    <label for="user_expire_date" class=" col-form-label col-form-label-sm ">From
                                        Date</label>
                                        <?php $currentDate = date('d-m-Y'); ?>
                                    <input type="text" class="form-control form-control-sm date_picker" id="from_date"
                                        name="from_date" 
                                        @if(Session::get('user.ses_hospital_code') != 'DMHL')
                                            value="{{ date('d-m-Y', strtotime('-6 days', strtotime($currentDate))) }}" 
                                        @endif
                                        placeholder="DD/MM/YYYY">
                                    <span class="focus_input"></span>
                                </div>

                                <div class="col-md-3">
                                    <label for="user_expire_date" class=" col-form-label col-form-label-sm ">To
                                        Date</label>
                                    <input type="text" class="form-control form-control-sm date_picker" id="to_date"
                                        name="to_date" 
                                        @if(Session::get('user.ses_hospital_code') != 'DMHL')
                                            value="{{ date('d-m-Y') }}" placeholder="DD/MM/YYYY"
                                        @endif
                                        >
                                    <span class="focus_input"></span>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="approveType" class="col-form-label">Approve Type</label>
                                        <select class="form-control form-control-sm  select2"
                                            id="approveType" name="approveType">
                                            <option value="all">All</option>
                                                @if(!empty($approval_for))
                                                    @foreach($approval_for as $key => $val)
                                                        <option value="{{$key}}">{{ $val }}</option>
                                                    @endforeach
                                                @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-2 mt-3">
                                    <div>
                                        <input type="radio" id="pending" name="status" value="pending" checked>
                                        <label for="pending">Pending & Hold</label>
                                    </div>
                                    <div>
                                        <input type="radio" id="approved" name="status" value="approved">
                                        <label for="approved">Approved</label>
                                    </div>
                                     <div>
                                        <input type="radio" id="rejected" name="status" value="rejected">
                                        <label for="rejected">Rejected</label>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-6 text-center mt-4">
                                    <div class="btn-group btn-block" role="group">
                                        <button type="button" class="btn btn-md btn-success btn-md-global btn-block mt-0"
                                        id="myApprovalSearchReport"> <i class="fas fa-search"></i>
                                            Search</button>
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <div class="form-row">
              <div class="col-md-12">
                  <div class="card">
                       <div class="card-body">
                           <div class="table-responsive"  id="my_approval_list_container">
                                @if(Session::get('user.ses_hospital_code') == 'EWMCH')
                                    @include('admin.uhl.approval_matrix.my-approval-table-list_ewmch')
                                @else
                                    @include('admin.uhl.approval_matrix.my-approval-table-list')
                                @endif
                           </div>
                    </div>
              </div>
              </div>
        </div>

    </div>
</section>
</main>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script>
  $('.select2').select2();
  $(function() {
    $('.date_picker').datepicker({
        todayHighlight: true,
        clearBtn: true,
        autoclose: true,
        endDate: '+0d',
        'format': 'dd-mm-yyyy'
    });
});
$('.exampleModal').on('shown.bs.modal', function () {
            $('#remarks').focus();
            $('#hold_reason').focus();
            $('#reject_reason').focus();
        });
$(document).on("click", "#myApprovalSearchReport", function(e) {
    var formID = $("#frmSearch").attr("id");
    var formMethod = $("#frmSearch").attr("method");

    $.ajax({
        data: $('#' + formID).serialize(),
        url: "{{ url('v1/my-approval-search') }}",
        type: formMethod,
        beforeSend: function() {
            blockUI();

        },
        success: function(data) {
            $("#my_approval_list_container").html(data);
        },
        complete: function() {
            $.unblockUI();
        }
    });
    e.stopImmediatePropagation();
});
</script>
