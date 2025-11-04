<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />

<main id="page-content">
        <section class="hr_payroll">
            <div class="container-fluid">
                <div class="row bg-white border-bottom sticky-top shadow-sm">
                    <div class="col-md-12">
                        <h5 class="mt-2 mb-0">Increment & Promotion Policy</h5>
                        <small>HRM / Increment & Promotion Policy</small>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h5>Increment & Promotion Duration</h5>
                            </div>
                            <form action="{{ route('v1.hrm.store-increament-policy') }}" method="post" id="store-increament-policy">
                                @csrf
                                <div class="card-body p-2">
                                    <div class="form-row">

                                        <div class="col-lg-2 col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="intern" class="col-form-label">Intern (duration/%)</label>
                                                <div class="input-group">
                                                    <input type="number" id="intern_duration" name="intern_duration" class="form-control" placeholder="Duration"  value="{{ isset($incrementPromotionPolicy->intern_duration) ? $incrementPromotionPolicy->intern_duration  : '' }}"/>
                                                    <input type="number" id="intern_percent" name="intern_percent" class="form-control" placeholder="(%)"  value="{{ isset($incrementPromotionPolicy->intern_percent) ? $incrementPromotionPolicy->intern_percent  : '' }}"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-2 col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="trainee" class="col-form-label">Trainee (duration/%)</label>
                                                <div class="input-group">
                                                    <input type="number" id="trainee_duration" name="trainee_duration" class="form-control" placeholder="Duration" value="{{ isset($incrementPromotionPolicy->trainee_duration) ? $incrementPromotionPolicy->trainee_duration  : '' }}" />
                                                    <input type="number" id="trainee_percent" name="trainee_percent" class="form-control" placeholder="(%)" value="{{ isset($incrementPromotionPolicy->trainee_percent) ? $incrementPromotionPolicy->trainee_percent  : '' }}" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-2 col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="regular" class="col-form-label">Regular (duration/%)</label>
                                                <div class="input-group">
                                                    <input type="number" id="regular_duration" name="regular_duration" class="form-control" placeholder="Duration"  value="{{ isset($incrementPromotionPolicy->regular_inc_duration) ? $incrementPromotionPolicy->regular_inc_duration  : '' }}"/>
                                                    <input type="number" id="regular_percent" name="regular_percent" class="form-control" placeholder="(%)" value="{{ isset($incrementPromotionPolicy->regular_inc_percent) ? $incrementPromotionPolicy->regular_inc_percent  : '' }}"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-2 col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="regular" class="col-form-label">Promotion (duration/%)</label>
                                                <div class="input-group">
                                                    <input type="number" id="promo_duration" name="promo_duration" class="form-control" placeholder="Duration" value="{{ isset($incrementPromotionPolicy->regular_promo_duration) ? $incrementPromotionPolicy->regular_promo_duration  : '' }}" />
                                                    <input type="number" id="promo_percent" name="promo_percent" class="form-control" placeholder="(%)" value="{{ isset($incrementPromotionPolicy->regular_promo_percent) ? $incrementPromotionPolicy->regular_promo_percent  : '' }}"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="regular" class="col-form-label">File Link</label>
                                                <input type="text" id="file_link" name="file_link" class="form-control" value="{{ isset($incrementPromotionPolicy->incpromo_file_link) ? $incrementPromotionPolicy->incpromo_file_link  : '' }}" />
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="regular" class="col-form-label">Description</label>
                                                <textarea class="form-control" rows="3" id="description" name="description">{{ isset($incrementPromotionPolicy->incpromo_description) ? $incrementPromotionPolicy->incpromo_description  : '' }}</textarea>
                                            </div>
                                        </div>
                                        <input type="hidden" value="{{ isset($incrementPromotionPolicy->incpromo_pol_no_pk) ? $incrementPromotionPolicy->incpromo_pol_no_pk  : '' }}" name="incpromo_pol_no">
                                        @php
                                            $response_action = route('v1.hrm.increment-promotion-policy');
                                        @endphp
                                        <div class="col-md-1 text-right">
                                            <button type="button"  class="btn btn-secondary uhl_common_btn mt-4" onclick="btnSaveUpdateUpload(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')"
                                            >Save</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            {{-- <div class="card-body p-2">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead class="global-uhl-table-bg">
                                            <tr>
                                                <th colspan="2" class="text-center">Intern</th>
                                                <th colspan="2" class="text-center">Trainee</th>
                                                <th colspan="2" class="text-center">Regular</th>
                                                <th rowspan="2" class="text-center">Action</th>
                                            </tr>
                                            <tr>
                                                <th>Duration</th>
                                                <th>%</th>
                                                <th>Duration</th>
                                                <th>%</th>
                                                <th>Duration</th>
                                                <th>%</th>
                                            </tr>

                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="text-center">6</td>
                                                <td class="text-center">6</td>
                                                <td class="text-center">6</td>
                                                <td class="text-center">6</td>
                                                <td class="text-center">6</td>
                                                <td class="text-center">12</td>
                                                <td class="text-center">
                                                    <a href="#" class="btn btn-md btn-primary"> <i class="far fa-edit"></i></a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </section>
</main>
<script>
$("body").addClass("sidebar-collapse");

</script>
