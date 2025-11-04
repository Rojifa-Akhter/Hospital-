<!-- Sidebar -->
<div class="col-lg-4 col-md-12">
    <div class="sidebar_filter">
        <!-- by country -->
        <div class="country">
            <h3>By Country</h3>
            @if (!empty($country))
                @foreach ($country as $key => $value)
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <input type="checkbox" aria-label="Checkbox for following text input" id="country_id"
                                    value="{{ $value->nationality }}" />
                            </div>
                        </div>
                        <input type="text" class="form-control" aria-label="Text input with checkbox"
                            value="{{ $value->nationality }} ({{ $value->doctor }})" readonly="" id="country" />
                    </div>
                @endforeach
            @endif
        </div>
        <!-- by country -->

        <!-- by city -->
        <div class="city">
            <h3>By City</h3>
            <div class="input-group mb-2">
                <input type="text" class="form-control" placeholder="Search By City.." id="city" />
            </div>

            <div class="inner_city">
                @include('mCare.city_doctor_list')

            </div>
        </div>
        <!-- by city -->

        <!-- By Department -->
        <div class="Department">
            <h3>By Department</h3>
            <div class="input-group mb-2">
                <input type="text" class="form-control" placeholder="Search By Department.." id="dept" />
            </div>

            <div class="inner_dept">

                @include('mCare.dept_doctor_list')

            </div>
        </div>
        <!-- By Department -->

        <!-- by hospital -->
        <div class="hospital">
            <h3>By Hospital</h3>
            <div class="input-group mb-2">
                <input type="text" class="form-control" placeholder="Search By Hospital.." id="hospital" />
            </div>

            <div class="inner_hospital">

                @include('mCare.hospital_doctor_list')
            </div>
        </div>
        <!-- by hospital -->

        <!-- BEST DOCTORS -->
        <div class="best_doctors">
            <h3>BEST DOCTORS</h3>
            <div class="input-group mb-2">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <input type="checkbox" aria-label="Checkbox for following text input" />
                    </div>
                </div>
                <input type="text" class="form-control" aria-label="Text input with checkbox"
                    value="Best Doctors in India" readonly="" />
            </div>
        </div>
        <!-- BEST DOCTORS -->
    </div>
</div>
<!-- Sidebar end-->
