<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}" />
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}" />
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}" />
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<main id="page-content">
    <form action="#" id="" method="post">
        <section class="paitent__registration_details">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row bg-white border-bottom sticky-top shadow-sm">
                            <div class="col-md-12">
                                <h5 class="mt-2 mb-0">Bed Maintentce</h5>
                                <small>House Keeping / Bed Maintentce</small>
                            </div>
                        </div>
                    </div>
                </div>

              

                <div class="card" id="">
                    <div class="card-header">
                          <div class="col-lg-4 col-md-6 col-12">
                                            <div class="form-group form-row">
                                                <label for="hospital_" class="col-sm-4 col-form-label">Hospital</label>
                                                <div class="col-sm-8">
                                                    <select class="form-control form-control-sm" id="hospital_" name="hospital_">
                                                        <option value="">Select</option>
                                                        <option value="">EWMCH</option>
                                                        <option value=""></option>
                                                        <option value=""></option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                    </div>
                    <div class="card-body mt-3">
                        <div class="row">
                            <div class="col-12 table-responsive">
                                <table id="datatable" class="table data-table table-striped table-bordered table-hover">
                                    <thead class="global-uhl-table-bg">
                                        <tr>
                                            <th class="text-center">Sr No</th>
                                            <th class="text-center">Floor No</th>
                                            <th class="text-center">Ward No</th>
                                            <th class="text-left">Bed No</th>
                                            <th class="text-left">Rate(Per Day)</th>
                                            <th class="text-left">Transfer Date</th>
                                            <th class="text-left">Release Date</th>
                                            <th class="text-left">Release Time</th>
                                            <th class="text-center">Staff Name</th>
                                            <th class="text-center">Patient Info</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Action</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>4th Floor</td>
                                            <td>Ward-04</td>
                                            <td>Bed-43</td>
                                            <td>1500</td>
                                            <td>18/12/2022</td>
                                            <td>18/12/2022</td>
                                            <td>11:00 AM</td>
                                            <td>MD ROFIQ</td>
                                            <td>
                                                
                                            </td>
                                            <td class="text-center">
                                                <button class=" btn btn-success btn-sm">Ready</button>
                                            </td>
                                            <td class="text-center">
                                                <button class=" btn btn-success btn-sm">Ready</button>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>2</td>
                                            <td>4th Floor</td>
                                            <td>Ward-06</td>
                                            <td>Bed-46</td>
                                            <td>1500</td>
                                            <td>18/12/2022</td>
                                            <td>18/12/2022</td>
                                            <td>11:30 AM</td>
                                            <td>MD ROFIQ</td>
                                            <td>
                                                 
                                            </td>
                                            <td class="text-center">
                                                <button class=" btn btn-warning btn-sm">Not Ready</button>
                                            </td class="text-center">
                                            <td><button class=" btn btn-warning btn-sm">Not Ready</button></td>
                                        </tr>

                                        <tr>
                                            <td>3</td>
                                            <td>4th Floor</td>
                                            <td>Ward-05</td>
                                            <td>Bed-48</td>
                                            <td>1500</td>
                                            <td>18/12/2022</td>
                                            <td>18/12/2022</td>
                                            <td>11:30 AM</td>
                                            <td>MD ROFIQ</td>
                                            <td>
                                                 Name : Rokeya Begum<br>
                                                 Status : Dis. Req
                                            </td>
                                            <td class="text-center">
                                                <button class=" btn btn-info btn-sm">Occupied</button>
                                            </td>
                                            <td class="text-center">
                                           <button class=" btn btn-info btn-sm"> Clearance</button>
                                        </td>
                                        </tr>
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

              


            </div>
        </section>
    </form>
</main>

<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
