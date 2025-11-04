
<link href="http://localhost/h360/public/node_modules/datatables/media/css/jquery.dataTables.css" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<section id="full_doctor_list">
<div class="container-fluid">
    <form action="{{ route('v1.hrm.employee_increament_approve_store') }}" method="POST" id="employee_increament_approve_id">
        @csrf
        <div class="form-row">
            <div class="col-lg-7 col-md-12 col-12">
                <div class="form-group">
                    <label for="effective-date" class="col-form-label">Effective Date</label>
                    <input type="text" class="form-control date_picker" name="effective_date"
                    autocomplete="off" placeholder="Effective Date"  value="{{date('d-m-Y')}}" />
                </div>
            </div>
            <div class="col-lg-5 col-md-12 col-12">
                <div class="form-group">
                    <label for="amount" class="col-form-label">Increament Percentage(%)</label>
                    <input type="number" class="form-control form-control-sm" id="inc_percentage" name="inc_percentage" placeholder="" value="{{isset($increamentInfo->proposed_increment_percent) ? $increamentInfo->proposed_increment_percent : ''}}"  onkeyup="handleIncPercrntage(this)"/>
                </div>
            </div>
            <div class="col-lg-6 col-md-12 col-12">
                <div class="form-group">
                    <label for="amount" class="col-form-label">Increament Amount</label>
                    <input type="text" class="form-control form-control-sm" id="inc_amt" name="inc_amt" placeholder="" value="{{isset($increamentInfo->proposed_increment_amt) ? $increamentInfo->proposed_increment_amt : ''}}" onkeyup="handleIncAmt(this)" />
                </div>
            </div>
            <div class="col-lg-6 col-md-12 col-12">
                <div class="form-group">
                    <label for="amount" class="col-form-label">Increament Salary</label>
                    <input type="text" class="form-control form-control-sm" id="inc_salary" name="inc_salary" placeholder="" value="{{$increamentInfo->proposed_increment_amt + $increamentInfo->current_salary }}" readonly/>
                    <input type="hidden" name="current_salary" id="current_salary" value="{{$increamentInfo->current_salary}}">
                </div>
            </div>

            <div class="col-lg-12 col-md-12 col-12">
                <div class="form-group">
                    <label for="remarks" class="col-form-label">Remarks</label>
                    <textarea class="form-control form-control-sm" name="remarks" id="remarks" rows="3"></textarea>
                </div>
            </div>

            <div class="col-lg-6 col-md-12 col-12">
                <label for="remarks" class="col-form-label">Notify By:</label>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="sms" id="sms" name="sms">
                    <label class="form-check-label" for="sms">
                    SMS
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="email" id="email" name="email">
                    <label class="form-check-label" for="email">
                    Email
                    </label>
                </div>
            </div>
        </div>
        <input type="hidden" name="inctrans_no_pk" value="{{$increamentInfo->inctrans_no_pk}}">
        <div class="text-right mt-2">
            @php
                $response_action = route('v1.hrm.increment-processing-work-list');
            @endphp
            <button type="button" class="btn btn-primary uhl_save_btn"  onclick="btnSaveUpdateUpload(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">Save</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
    </form>
</div>
</section>
<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="application/javascript" src="http://localhost/h360/public/node_modules/datatables/media/js/jquery.dataTables.min.js"></script>
  <script>
  $('.datatable').DataTable({
        "ordering": false,
        "pageLength": 20

  });
  $(function(){
            $('.date_picker').datepicker({
                todayHighlight: true,
                clearBtn: true,
                autoclose: true,
                // endDate: '+0d',
                format: 'dd-mm-yyyy',
            });
    });
    function handleIncPercrntage(element){
        let inc_perc = Number($('#inc_percentage').val());
        let current_salary = Number($('#current_salary').val());
        let inc_amt = Math.round(current_salary * (inc_perc/100));
        let inc_salary = inc_amt + current_salary;
        $('#inc_amt').val(inc_amt.toFixed(0));
        $('#inc_salary').val(inc_salary.toFixed(0));
     }
     function handleIncAmt(element){
       let inc_amt = Number($('#inc_amt').val());
        let current_salary = Number($('#current_salary').val());
        let inc_perc = Math.round((100 /current_salary) * inc_amt );
        let inc_salary = inc_amt + current_salary;
        $('#inc_percentage').val(inc_perc.toFixed(0));
         $('#inc_salary').val(inc_salary.toFixed(0));
      }

  </script>
