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
        <form id="frmMpoSearh" method="post" action="{{ route('marketing-area/search-list-report-print') }}">
            @csrf
            <input type="hidden" value="MPO" name="MPO">
            <div class="form-group row">

                <div class="col-md-3">
                    <label for="marketing_area">Referral ID</label>
                    <input type="hidden" id="ref_doc" name="ref_doc"

                    value="" />
                <input type="text" class="form-control form-control-sm m-0" id="referral_doctor"
                    name="referral_doctor" value=""
                    placeholder="Name/ Phone Number"  />
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
                    <button type="button" id="mpo_report_search" class="btn btn-md btn-success mt-4">Search</button>
                    <button type="submit" id="mpo_report_report" class="btn btn-md btn-primary mt-4 print"> Export
                        PDF</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="card">
    <div class="card-header ">
        <h5>Marketing MPO Report List</h5>
    </div>
    <div class="card-body">
        <div class="mt-2" id="marketing_mpo_list">
            @include(
                'admin.reports.marketing_reports.marketing_mpo_report_list'
            )
        </div>
    </div>
</div>
