<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<main id="page-content">
    <form action="{{route('carparking.store-car-parking-in')}}" method="post" id="car-parking-in">
        <section class="paitent__registration_details">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row bg-white border-bottom sticky-top shadow-sm">
                            <div class="col-md-12">
                                <h5 class="mt-2 mb-0">Car Parking</h5>
                                <small>Car Parking / Car Parking In</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 col-lg-12">
                            <div class="card">
                            	<div class="card-header">
                            		<h5>CARPARKING IN</h5>
                            	</div>
                                <div class="card-body border-bottom-3 p-2">
                                    <div class="form-row">
                                        <div class="col-lg-3 col-md-6 col-12">
                                            <div class="form-group form-row">
                                                <label for="car_number" class="col-sm-4 col-form-label">Vehicle Number</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control form-control-sm" id="car_number" name="car_number" placeholder="" value="" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-md-6 col-12">
                                            <div class="form-group form-row">
                                                <label for="vehicle_type" class="col-sm-4 col-form-label">Vehicle Type</label>
                                                <div class="col-sm-8">
                                                    <select class="form-control form-control-sm" id="vehicle_type"
                                                        name="vehicle_type" required>
                                                        <option value="0">Select Type</option>
                                                        @if (!empty($vehicle_data))
                                                            @foreach ($vehicle_data as $record)
                                                                <option value="{{ $record->lookupdata_name }}">
                                                                    {{ $record->lookupdata_name }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-md-6 col-12">
                                            <div class="form-group form-row">
                                                <label for="name" class="col-sm-4 col-form-label">Name</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control form-control-sm" id="name" name="name" placeholder="" value="" required />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-md-6 col-12">
                                            <div class="form-group form-row">
                                                <label for="mobile_no" class="col-sm-4 col-form-label">Mobile</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control form-control-sm" id="mobile_no" name="mobile_no" placeholder="" value="" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 text-right mt-3">
                                            @php                                             
                                                $response_action = route('carparking.car-parking-worklist');
                                            @endphp
                                             <button class="btn btn-secondary uhl_save_btn"
                                             onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">
                                             Save</button>
                                        </div>

                                    </div>
                                </div>
                            </div>

                    </div>
                </div>

            </div>
        </section>
    </form>
</main>
<script>
	  $("body").addClass("sidebar-collapse");
</script>

