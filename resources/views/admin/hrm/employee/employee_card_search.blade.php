<div class="card">
    <div class="card-header"><h5><i class="fa fa-search"></i> Search</h5></div>
    <div class="card-body">
        <form action="" id="searchCardForm" method="post">
            @csrf
            <div class="form-row justify-content-center">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="lookup_no" class="col-sm-12 col-form-label col-form-label-sm">Employee Id</label>
                        <div class="col-sm-12">
                            <input type="hidden" id="doctor_id" name="doctor_id" value="" />
                            <input type="text" class="form-control form-control-sm m-0" id="primary_doctor" name="primary_doctor" value="" placeholder="Employee Id" required />
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="btn-group btn-block" role="group">
                        <button type="button" id="card_search_btn"  class="btn btn-md btn-success btn-block mt-4">Search</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>



