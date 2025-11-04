<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<main id="page-content">
    <form action="{{route('v1.save-parking-data')}}" method="post" id="parking_serivce_bill">
        <section class="paitent__registration_details">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row bg-white border-bottom sticky-top shadow-sm">
                            <div class="col-md-12">
                                <h5 class="mt-2 mb-0">Car Parking</h5>
                                <small>Car Parking / Car Parking Out</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 col-lg-12">
                            <div class="card">
                            	<div class="card-header">
                                    <div class="form-row">
                                        <div class="col-md-8"><h5>CARPARKING OUT</h5></div>
                                        <div class="col-md-4">
                                            <select class="form-control keep_me" id="service_point" name="service_point" onchange="servicePoint(this)" required>
                                                <option value="">Select Counter</option>
                                                @if (!empty($service_point))
                                                    @foreach ($service_point as $value)
                                                        @if ($value->default_ind == 1)
                                                            <option selected value="{{ $value->serviceunit_no_pk }}"
                                                                data-posind="{{ $value->hs_pos_ind }}">
                                                                {{ $value->serviceunit_name }}</option>
                                                        @else
                                                            <option data-posind="{{ $value->hs_pos_ind }}"
                                                                value="{{ $value->serviceunit_no_pk }}">
                                                                {{ $value->serviceunit_name }}</option>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                            		
                                  
                            	</div>
                                <div class="card-body border-bottom-3 p-2">
                                    <div class="form-row">
                                        <div class="col-lg-4 col-md-6 col-12">
                                            <div class="form-group form-row">
                                                <label for="parking_id" class="col-sm-4 col-form-label">Parking ID</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control form-control-sm" id="parking_id" name="parking_id" placeholder="" value="" onkeyup="getParkingData(event, this)"  />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-md-6 col-12">
                                            <div class="form-group form-row">
                                                <label for="car_number" class="col-sm-4 col-form-label">Car Number</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control form-control-sm" id="car_number" name="car_number" placeholder="" value="" readonly />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-md-6 col-12">
                                            <div class="form-group form-row">
                                                <label for="vehicle_type" class="col-sm-4 col-form-label">Vehicle Type</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control form-control-sm" id="vehicle_type" name="vehicle_type" placeholder="" value="" readonly />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-md-6 col-12">
                                            <div class="form-group form-row">
                                                <label for="total_hour" class="col-sm-4 col-form-label">Total Hour</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control form-control-sm" id="total_hour" name="total_hour" placeholder="" value="" readonly />
                                                </div>
                                            </div>
                                        </div> 

                                        <div class="col-lg-4 col-md-6 col-12">
                                            <div class="form-group form-row">
                                                <label for="bill_amt" class="col-sm-4 col-form-label">Bill Amount</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control form-control-sm" id="bill_amt" name="bill_amt" placeholder="" value="" readonly />
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                </div>
                            </div>
                      
                    </div>
                </div>
                 <div class="row">
                    <div class="col-md-12">
                        <div class="card mb-2">
                            <div class="card-body">
                                <div class="form-group">
                                    <ul class="list-inline btn__box">
                                        <li class="list-inline-item">                                           
                                            <input type="hidden" name="end_time" id="end_time" value="{{date('Y-m-d H:i')}}">
                                            @php
                                                $response_action = route('v1.car-parking-worklist');
                                            @endphp 
                                            <button type="button" class="btn btn-secondary uhl_save_btn" onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')"> Save</button>
                                        </li>
                                    </ul>
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
      function getParkingData() {     
        if (event.key === 'Enter') {       
            $.ajax({
                async: true,
                data: {
                    _token: "{{ csrf_token() }}",
                    parking_id: $('#parking_id').val(),
                
                },

                dataType: "html",
                url: "{{ route('v1.get-parking-data') }}",
                type: 'post',
                beforeSend: function() {

                    blockUI();
                },
                success: function(data) {
                    var vehicle_data= jQuery.parseJSON(data).vehicle_data;
                    var policy_data= jQuery.parseJSON(data).policy;
                   

                    $('#car_number').val(vehicle_data.car_number);            
                    $('#vehicle_type').val(vehicle_data.vehicle_type);        
                    $('#parking_id').val(vehicle_data.carp_trans_no_pk);        
                    
                    var startTime = new Date(vehicle_data.start_date);
                    var currentTime = new Date();
                    var difference = currentTime - startTime;
                    var totalHours = difference / (1000 * 60 * 60);
                   

                    if (totalHours < 1) {
                        $('#total_hour').val(1);
                        $('#bill_amt').val(policy_data.minimum_rate);

                    }else{
                        $('#total_hour').val(Math.round(totalHours));
                        var amount =   parseInt(policy_data.minimum_rate) + parseInt((Math.round(totalHours) - policy_data.minimum_hour) * policy_data.hourly_rate);
                        console.log(data, policy_data.minimum_rate , Math.round(totalHours) , policy_data.minimum_hour , policy_data.hourly_rate)
                        $('#bill_amt').val(amount);
                    }

                },
                complete: function() {
                    $.unblockUI();

                }
            });
        }
    }
</script>

