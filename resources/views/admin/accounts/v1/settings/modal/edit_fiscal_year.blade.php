 <!-- Modal -->
<form action="{{route('v1.accounts.update-fiscal-year')}}" method="post" id="updateFiscalYear" class="updateFiscalYear">
    @csrf
    <div class="form-row">

        <div class="col-lg-12 col-md-12 col-12">
            <div class="form-group form-row">
                <label for="" class="col-sm-4 col-form-label">Start Date<span style="color:red">*</span></label>
                <div class="col-sm-8">
                    <input type="text" class="form-control form-control-sm datepickerModal" id="start_date_modal"
                        name="start_date_modal" value="{{$data->start_date}}" placeholder="Start Date" autocomplete="off"/>
                        <input type="hidden" value="{{$data->fiscalyear_no_pk}}" name="fiscalyear_no_pk">
                </div>
            </div>
        </div>

        <div class="col-lg-12 col-md-12 col-12">
            <div class="form-group form-row">
                <label for="" class="col-sm-4 col-form-label">End Date<span style="color:red">*</span></label>
                <div class="col-sm-8">
                    <input type="text" class="form-control form-control-sm datepickerModal" id="end_date_modal" name="end_date_modal" value="{{$data->end_date}}" placeholder="End Date" autocomplete="off"/>
                </div>
            </div>
        </div>

        @if($data->current_fiscal_year_ind == 1)
            <div class="col-lg-12 col-md-12 col-12">
                <div class="form-group form-row">
                    <label for="current_fiscal_year_ind" class="col-sm-4 col-form-label">Is closed</label>
                    <div class="col-sm-2 mt-1">
                        <input type="checkbox" id="current_fiscal_year_ind"
                            name="current_fiscal_year_ind" value="1" @if($data->current_fiscal_year_ind != 1) {{'checked'}} @endif/>
                    </div>
                </div>
            </div>
        @endif

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
        $redirect_url = route('v1.accounts.fiscal-year');
    @endphp

    <div class="text-center">
        <button type="submit" class="btn btn-primary uhl_save_btn mt-3"
            onclick="btnSaveUpdate(this,'','','','',getFiscalYear,'{{ $redirect_url }}')">Save</button>
        <button type="button" class="btn btn-danger mt-3" data-dismiss="modal">Close</button>
    </div>
</form>
<script>
    $(document).ready(function() {

        $(".datepickerModal").datepicker({
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
                    dateComparisonSE:true
                },
                end_date:{
                    required:true,
                    dateComparisonSE:true
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