<div class="card-header">
    <div class="row">
        <div class="col-md-6">
            <h5>Alternative Item </h5>
        </div>
        <div class="col-md-6">
            <input type="text" class="float-right form-control" name="" id=""
                placeholder="Enter Supplier Name" onkeyup="searchAltItem(this)" data-input-id="{{ $genetic_name }}" data-row-id="{{ $data_row_id }}">
        </div>
    </div>

</div>
<div class="row" id="altData">
    @include('admin.prescription.alternative_medicine_data')

</div>
