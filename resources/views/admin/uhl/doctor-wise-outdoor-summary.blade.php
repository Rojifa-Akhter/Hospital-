<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<main id="page-content">
    <form action="#">
        <section class="hospital_fiancial_reports">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row bg-white border-bottom sticky-top shadow-sm">
                            <div class="col-md-10">
                                <h5 class="mt-2 mb-0">Doctor Wise Outdoor Summary</h5>
                                <small>Reports / Doctor Wise Outdoor Summary</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3">
                      

                     @include('admin.uhl.finacial_report_sidebar')
                        
                    </div>
                    <div class="col-md-9">
                        <div class="card">
                            <div class="card-header">
                                <div class="form-row">
                                    <div class="col-lg-8 col-md-8 col-12">
                                        <div class="form-group form-row">
                                            <label class="col-sm-3 col-form-label col-form-label-sm" for="allowed-dates">Date</label>
                                            <div class="col-sm-9">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">From</div>
                                                    </div>
                                                    <input type="text" class="form-control form-control-sm m-0" id="allowed-dates" name="allowed-dates" value="" placeholder="dd-mm-yyyy" />
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">To</div>
                                                    </div>
                                                    <input type="text" class="form-control form-control-sm m-0 " id="allowed_dates_to" name="allowed_dates_to" value="" placeholder="dd-mm-yyyy" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <button type="button" class="btn btn-md btn-success btn-md-global"><i class="fa fa-search"></i> Search</button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body p-2">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover table-striped">
                                        <thead class="global-uhl-table-bg">
                                            <tr>
                                                <th>Doctor / Consultant Name</th>
                                                <th>Qualification</th>
                                                <th>New Pt.</th>
                                                <th>Old Pt.</th>
                                                <th>Ext. Pt.</th>
                                                <th>Reg. Amt.</th>
                                                <th>Doc. Amt.</th>
                                                <th>Dis. Amt.</th>
                                                <th>Rec. AMt.</th> 
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                            	<td class="text-left">Duty Doctor (M)</td>
                                            	<td class="text-left">MBBS, MEDICAL OFFICER JK. MEMORIAL HOSPITAL</td>
                                            	<td class="text-center">256</td>
                                            	<td class="text-center">13</td>
                                            	<td class="text-center">0</td>
                                            	<td class="text-right">12,800</td>
                                            	<td class="text-right">53,800</td>
                                            	<td class="text-right">4,250</td>
                                            	<td class="text-right">62,350</td>
                                            </tr>
                                            <tr>
                                            	<td class="text-left">MOHAMMAD SOHIDULLAH</td>
                                            	<td class="text-left">MBBS, (CMC), D.CARD,FCPS(FINAL PART)MEDICINE</td>
                                            	<td class="text-center">7</td>
                                            	<td class="text-center">1</td>
                                            	<td class="text-center">0</td>
                                            	<td class="text-right">700</td>
                                            	<td class="text-right">3,800</td>
                                            	<td class="text-right"></td>
                                            	<td class="text-right">4,500</td>
                                            </tr>
                                        </tbody>
                                        <tfoot class="global-uhl-table-bg">
                                        	<th colspan="2" class="text-right">Grand Toatal =</th>
                                        	<th class="text-center">263</th>
                                        	<th class="text-center">14</th>
                                        	<th class="text-center">0</th>
                                        	<th class="text-right">13,500</th>
                                        	<th class="text-right">57,600</th>
                                        	<th class="text-right">4,250</th>
                                        	<th class="text-right">66,850</th>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </form>
</main>
@include('admin.uhl.finacial_report_sidebar_js')
