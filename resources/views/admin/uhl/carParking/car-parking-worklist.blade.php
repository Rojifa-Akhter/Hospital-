<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<link rel="stylesheet" href="{{asset('datepicker/dist/css/bootstrap-datepicker.min.css')}}">
<main id="page-content">
    <form action="#" id="">
        <section class="paitent__registration_details">
            <div class="container-fluid">
                        <div class="row bg-white align-items-center justify-content-between border-bottom sticky-top shadow-sm">
                            <div class="col-md-8">
                                <h5 class="mt-2 mb-0">Car Parking</h5>
                                <small>Car Parking / Car Parking Worklist</small>
                            </div>
                            <div class="col-md-4">
                                <div class="btn-group btn-block" role="group">
                                        <a type="button" class="btn btn-md btn-success btn-block mt-0" href="{{route('carparking.car-parking-in')}}" target="_blank">
                                            Go to Car Parking In</a>
                                            <a type="button" class="btn btn-info btn-block btn-md mt-0" href="{{route('v1.car-parking-out')}}" target="_blank">Go to Car Parking out</a>

                                    </div>
                            </div>
                        </div>


                <div class="row">
                    <div class="col-sm-12 col-lg-12">
                        <div class="card">
                            <div class="card-body border-bottom-3 p-2">
                                <div class="form-row">
                                    <div class="col-lg-2 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="from_date" class="col-form-label">From Date</label>

                                            <input type="text" class="form-control form-control-sm date_picker" id="from_date" name="from_date" placeholder="" value="" autocomplete="off" />
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="to_date" class="col-form-label">To Date</label>

                                            <input type="text" class="form-control form-control-sm date_picker" id="to_date" name="to_date" placeholder="" value="" autocomplete="off" />
                                        </div>
                                    </div>

                                    <div class="col-lg-2 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="vehicale_type" class="col-form-label">Vehicle Type</label>
                                            <select class="form-control form-control-sm" id="vehicale_type"
                                            name="vehicale_type">
                                            <option value="">Select Type</option>
                                            @if (!empty($vehicle_data))
                                                @foreach ($vehicle_data as $record)
                                                    <option value="{{ $record->lookupdata_name }}">
                                                        {{ $record->lookupdata_name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                            {{-- <input type="text" class="form-control form-control-sm" id="vehicale_type" name="vehicale_type" placeholder="" value="" /> --}}
                                        </div>
                                    </div>

                                    <div class="col-lg-2 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="car_number" class="col-form-label">Car Number</label>

                                            <input type="text" class="form-control form-control-sm" id="car_number" name="car_number" placeholder="" value="" />
                                        </div>
                                    </div>

                                     <div class="col-lg-2 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="token" class="col-form-label">Token</label>

                                            <input type="text" class="form-control form-control-sm" id="token" name="token" placeholder="" value="" />
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="btn-group" role="group" style="margin-top: 25px;">
                                            <button type="button" id="" class="btn btn-success btn-block btn-md btn-md-global" onclick="searchData()"><i class="fas fa-search"></i> Search</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body border-bottom-3 p-2">
                                <div class="row">
                                    <div class="col-12 table-responsive" id="carparking_list_id">
                                        @include('admin.uhl.carParking.car-parking-table-list')
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
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script>
    $("body").addClass("sidebar-collapse");
    $('.date_picker').datepicker({
        todayHighlight: true,
        clearBtn: true,
        autoclose: true,
        format: 'dd-mm-yyyy'
    });

    function searchData() {            
        $.ajax({
            async: true,
            data: {
                _token: "{{ csrf_token() }}",
                from_date: $('#from_date').val(),
                to_date: $('#to_date').val(),
                vehicale_type: $('#vehicale_type').val(),
                car_number: $('#car_number').val(),
                token: $('#token').val(),
            
            },

            dataType: "html",
            url: "{{ route('v1.car-parking-search') }}",
            type: 'post',
            beforeSend: function() {

                blockUI();
            },
            success: function(data) {
                $('#carparking_list_id').html(data);            

            },
            complete: function() {
                $.unblockUI();

            }
        });
    }

</script>
