<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<section id="create-saving-fund">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-md align-items-center">
            <div class="col-md-6">
                <h5 class="mt-2 mb-0">Create Saving Fund</h5>
                <small>HRM / Saving Fund Setup / Create Saving Fund Form </small>
            </div>
        </div>
        <div class="card">
            <div class="card-header"><h5>Create Saving Fund</h5></div>
            <div class="card-body mt-2">
                <div class="row">
                    <div class="col-md-12">
                        @include('admin.hrm.savingFund.add_saving_fund_form')
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


