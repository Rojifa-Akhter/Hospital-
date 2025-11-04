 <!-- Modal -->
 {{-- <link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}"> --}}
<form action="{{route('v1.accounts.update-fiscal-month')}}" method="post" id="updateFiscalYear" class="updateFiscalYear">
    @csrf
    <div class="form-row">

        <div class="col-lg-12 col-md-12 col-12">
            <div class="form-group form-row">
                <label for="" class="col-sm-4 col-form-label">Start Date<span style="color:red">*</span></label>
                <div class="col-sm-8">
                    <input type="text" class="form-control form-control-sm datepickerModalFiscalMonth" id="start_date_modal"
                        name="start_date_modal" value="{{$data->start_date}}" placeholder="Start Date" autocomplete="off"/>
                        <input type="hidden" value="{{$data->fiscalmonth_no_pk}}" name="fiscalmonth_no_pk">
                </div>
            </div>
        </div>

        <div class="col-lg-12 col-md-12 col-12">
            <div class="form-group form-row">
                <label for="" class="col-sm-4 col-form-label">End Date<span style="color:red">*</span></label>
                <div class="col-sm-8">
                    <input type="text" class="form-control form-control-sm datepickerModalFiscalMonth" id="end_date_modal" name="end_date_modal" value="{{$data->end_date}}" placeholder="End Date" autocomplete="off"/>
                </div>
            </div>
        </div>

        <div class="col-lg-12 col-md-12 col-12">
            <div class="form-group form-row">
                <label for="closing_type" class="col-sm-4 col-form-label">Closing Type</label>
                <div class="col-sm-8 mt-1">
                    <select name="closing_type" id="closing_type" class="form-control form-control-sm">
                        <option value="0" {{$data->closing_type == 0 ? 'selected' : ''}}>Select Closing Type </option>
                        <option value="1" {{$data->closing_type == 1 ? 'selected' : ''}}>Soft Closing</option>
                        <option value="2" {{$data->closing_type == 2 ? 'selected' : ''}}>Hard Closing</option>
                   </select>
                </div>
            </div>
        </div>

        <div class="col-lg-12 col-md-12 col-12">
            <div class="form-group form-row">
                <label for="status_modal" class="col-sm-4 col-form-label">Status</label>
                <div class="col-sm-2 mt-1">
                    <input type="checkbox" id="status_modal"
                        name="status_modal" value="1" @if($data->status == 1) {{'checked'}} @endif/>
                </div>
            </div>
        </div>

    </div>

    @php
        $redirect_url = route('v1.accounts.fiscal-month');
    @endphp

    <div class="text-center">
        <button type="submit" class="btn btn-primary uhl_save_btn mt-3"
            onclick="btnSaveUpdate(this,'','','','',getFiscalMonth,'{{ $redirect_url }}')">Save</button>
        <button type="button" class="btn btn-danger mt-3" data-dismiss="modal">Close</button>
    </div>
</form>

{{-- <script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script> --}}
<script>
    $(document).ready(function() {
        // $(".datepickerModalFiscalMonth").datepicker('destroy');
        
        $(".datepickerModalFiscalMonth").datepicker({
            todayHighlight: true,
			clearBtn: true,
			autoclose: true,
            changeMonth: true,
            changeYear: true,
            format: 'dd/mm/yyyy',
        });

        $("#updateFiscalYear").validate({
            rules:{
                start_date:{
                    required:true,
                    dateComparisonSE:true,
                },
                end_date:{
                    required:true,
                    dateComparisonSE:true,
                }
            },
            messages:{
                start_date:{
                    required: "Start Date Required"
                },
                end_date:{
                    required: "End Date Required",
                }
            }
        });

    });
</script>