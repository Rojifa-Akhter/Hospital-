<style>
    .sorting {
        background-image: none !important;
    }

</style>

<div class="card">
    <div class="card-header ">
        <h5><i class="fa fa-search"></i> Search Panel</h5>
    </div>
    <div class="card-body pt-2 bg-light form-row justify-content-center">
        <form id="frmAreaReport" method="post" action="{{ route('marketing-area.search-list-summaryreport-print') }}">
            @csrf
            <input type="hidden" value="AREA" name="type">
            <div class="form-group row">

                <div class="col-md-3">
                    <label for="marketing_area">Marketing Area</label>
                    <input type="text" class="form-control form-control-sm pat_info" id="search_data" name="patient_area"
                        value="" placeholder="Enter Patient Area" maxlength="100 ">
                    <input type="hidden" id="hdn_area_code" name="hdn_area_code" >
                    <input type="hidden" id="hdn_area_name" name="hdn_area_name" >
                </div>


                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-6" style="margin-right: -30px;">
                            <label for="type">From</label>
                            <input type="text" class="form-control date_picker" name="date_from" value="" id="date_from"
                                autocomlete="off" placeholder="From Date" />
                        </div>
                        <div class="col-md-6">
                            <label for="type">To </label>
                            <input type="text" class="form-control date_picker" name="date_to" value="" id="date_to"
                                autocomlete="off" placeholder="To Date" />
                        </div>
                    </div>
                </div>
                <div class="col-md-3 btn-group">
                    <button type="button" id="area_report_search" class="btn btn-md btn-success mt-4">Search</button>
                    <button type="submit" id="area_report_report" class="btn btn-md btn-primary mt-4 print"> Export
                        PDF</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="card">
    <div class="card-header ">
        <h5>Marketing Area Report List</h5>
    </div>
    <div class="card-body">
        <div class="mt-2" id="marketing_area_list">
            @include(
                'admin.reports.marketing_reports.marketing_area_summary_list'
            )
        </div>
    </div>
</div>
